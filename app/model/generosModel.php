<?php
class GenerosModel{
    private $db;
    
    //constructor lo unico que tiene es la base de datos, la llama con new PDO
    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=libreria;charset=utf8', 'root', '');
    }

    /*llama a todos los generos de mi db, y agarra solo los id de la tabla
        se prepara sentencia en la que llamo a los id y se ejecuta
        se guarda en una variable el resultado de la busqueda(se pide solo la columna) y se devuelve*/
    public function getAllIds(){
        $query = $this->db->prepare("SELECT Id_generos FROM generos");
        $query -> execute();
        $generos = $query->fetchAll(PDO::FETCH_COLUMN);
        return $generos;
    }

}