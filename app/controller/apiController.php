<?php
require_once "app/model/librosModel.php";
require_once "app/model/generosModel.php";
require_once "app/view/apiView.php";

class ApiController{
    private $model;
    private $generosModel;
    private $view;

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

    /*verifica que los parametros pasados mediante la url sean correctos y permitan ordenar, filtrar, paginar
        guarda en un arreglo los nombres de las columnas 
            para no tener que chequear uno por uno y poder usar funcion in_array
            verifica que los valores del orderBy y filterBy este entre este
        verifica que exista la forma de ordenamiento qque se paso y que la pagina y el limita sean un nro>0*/
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

    /*obtiene una lista de los libros, pide parametros para ordenar, filtrar y paginar la lista
        si tiene filtrado se llama a la funcion que los lista por filtro, sino se llama a la sin filtrar
        se devuelve la lista de libros*/
    public function getAll($params=null){
        $orderBy=$_GET["orderBy"] ?? "id_libros";
        $orderMode=$_GET["orderMode"] ?? "asc";
        $filterBy=$_GET["filterBy"] ?? null;
        $filterValue=$_GET["filterValue"] ?? null;
        $page=$_GET["page"] ?? 1;
        $limit=$_GET["limit"] ?? 15;

        $this->verifyGet($orderBy, $orderMode, $filterBy, $filterValue, $page, $limit);
        
        $row = $page*$limit - $limit;
        $filterValue=str_replace('-', ' ', $filterValue);
        if($filterBy==null){
            $libros=$this->model->getAll($orderBy, $orderMode, $limit, $row);
        }
        else{
            $libros=$this->model->getAllFilteredBy($orderBy, $orderMode, $filterBy, $filterValue, $limit, $row);
        }
        return $this->view->response($libros, 200);
    }

    /*obtiene un libro determinado por su id
        obtiene el id por la url
        llama a la funcion del model que lo busca, si existe lo devuelve sino devuelve un error*/
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

    /*verifica si el id de genero que se puso al agregar un libro o modificarlo existe*/
    public function verificarIdGen($idGen){
        $generos=$this->generosModel->getAllIds();
        return in_array($idGen, $generos);
    }

    /*agrega libros a la db 
        verifica que tenga todas las columnas llenas y envia error si no lo estan
        verifica que el valor ingrsado en fk_generos corresponda a un id de generos sino muestra error
        en caso de que este todo bien muestra msj de que se inserto el libro*/
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

    /*edita un libro de la db usando su id que recibe como parametro en la url
        llama al libro con este id mediante la funcion del model
        si existe, estan todos los datos completos y la fk de generos esta bien, se modifica
        sino muestra un error*/ 
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
    
    /*elimina un libro de la db mediante su id que se pasa como parametro en la url
        cheuqeamos que el libro exista si existe se elimina sino muestra error */
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