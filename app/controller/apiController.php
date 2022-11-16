<?php
require_once "app/model/librosModel.php";
require_once "app/model/generosModel.php";
require_once "app/view/apiView.php";

class ApiController{
    private $model;
    private $generosModel;
    private $view;
    private $authHelper;

    private $data;

    public function __construct(){
        $this->model = new LibrosModel();
        $this->generosModel = new GenerosModel();
        $this->view = new ApiView();
        $this->data = file_get_contents("php://input");
    }

    private function getData(){
        return json_decode($this->data);
    }

    public function verifyGet($orderBy, $orderMode, $filterBy, $filterValue, $page, $limit){
        $columns=[
            "id_libros",
            "titulo",
            "autores",
            "anio",
            "precio",
            "generos_fk"
        ];
        if($orderMode!=null && !in_array($orderBy, $columns)){
            $this->view->response("El parametro pasado es incorrecto", 400);
            die;
        }
        if($orderMode!="asc" && $orderMode!="desc"){
            $this->view->response("La forma de ordenamiento no existe", 400);
            die;
        }
        if($filterBy!=null && !in_array($filterBy, $columns)){
            $this->view->response("La forma de filtrado no existe", 400);
            die;
        }
        if($filterBy!=null && $filterValue==null){
            $this->view->response("Falta valor por el cual filtrar", 400);
            die;
        }
        if($page<1 || $limit<1 || !is_numeric($page) || !is_numeric($limit)){
            $this->view->response("El valor ingresado para page o el limite es incorrecto", 400);
            die;
        }
    }

    public function getAll($params=null){
        $orderBy=$_GET["orderBy"] ?? "id_libros";
        $orderMode=$_GET["orderMode"] ?? "asc";
        $filterBy=$_GET["filterBy"] ?? null;
        $filterValue=$_GET["filterValue"] ?? null;
        $page=$_GET["page"] ?? 1;
        $limit=$_GET["limit"] ?? 10;

        $this->verifyGet($orderBy, $orderMode, $filterBy, $filterValue, $page, $limit);
        
        $row = $page*$limit - $limit;
        if($filterBy==null){
            $libros=$this->model->getAll($orderBy, $orderMode, $limit, $row);
        }
        else{
            $libros=$this->model->getAllFilteredBy($orderBy, $orderMode, $filterBy, $filterValue, $limit, $row);
        }
        return $this->view->response($libros, 200);
    }

    public function getLibroById($params=null){
        $id=$params[':ID'];
        $libro=$this->model->getLibroInd($id);
        if($libro){
            $this->view->response($libro, 200);
        }
        else{
            $this->view->response("El libro con id: $id no existe", 404);
        }
    }

    public function verificarIdGen($idGen){
        $generos=$this->generosModel->getAll();
        return in_array($idGen, $generos);
    }

    public function addLibro($params=null){
        $libro=$this->getData();
        if(empty($libro->Titulo)||empty($libro->Autores)||empty($libro->Anio)||empty($libro->Precio)||empty($libro->Generos_fk)){
            $this->view->response("Faltan completar datos", 400);
        }
        else{
            $idGen = $libro->Generos_fk;
            if($this->verificarIdGen($idGen)==false){
                $this->view->response("El valor $idGen, ingresado para genero no existe", 400);
            }
            else{
                $id=$this->model->addLibro($libro->Titulo, $libro->Autores, $libro->Anio, $libro->Precio, $libro->Generos_fk);
                $this->view->response("el libro se inserto con id $id", 201);
            }
        }
    }

    public function editLibro($params=null){
        $id = $params[':ID'];
        $data=$this->getData();
        $libro=$this->model->getLibroInd($id);
        if($libro){
            if (empty($data->Titulo) || empty($data->Autores) || empty($data->Anio)||empty($data->Precio)||empty($data->Generos_fk)){
                $this->view->response("Falta completar datos", 400);
            } else {
                $idGen = $data->Generos_fk;
                if($this->verificarIdGen($idGen)==false){
                    $this->view->response("El valor $idGen, ingresado para genero no existe", 400);
                }
                else{
                    $this->model->editLibro($id, $data->Titulo, $data->Autores, $data->Anio, $data->Precio, $data->Generos_fk);
                    $this->view->response($data, 200);
                }
            }
        }
        else{
            $this->view->response("No existe el libro con este id", 404);
        }
        
    }
    
    public function deleteLibro($params=null){
        $id=$params[':ID'];
        $libro=$this->model->getLibroInd($id);
        if($libro){
           $this->model->delete($id);
           $this->view->response($libro);
        }
        else{
            $this->view->response("El libro con id: $id no existe", 404);
        }
    }
}