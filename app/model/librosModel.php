<?php
class LibrosModel{
    private $db;
    
    //constructor lo unico que tiene es la base de datos
    public function __construct(){
        $this->db = new PDO('mysql:host=localhost;' . 'dbname=libreria;charset=utf8', 'root', '');
    }

    /*llamar a todos los libros que estan en mi db, agarro todos los registros de mi tabla libros
        se prepara sentencia: llamo a los libros con orden en el q tiene q devolverse, se ejecuta
        se guarda en una variable el resultado de la busqueda(arr de obj) y se devuelve*/
    public function getAll($orderBy, $orderMode, $limit, $row){
        $query = $this->db->prepare("SELECT * FROM libros ORDER BY $orderBy $orderMode LIMIT $limit OFFSET $row");
        $query->execute();
        $libros = $query->fetchAll(PDO::FETCH_OBJ);
        return $libros;
    }

    /*llama a los libros filtrandolos por una columna y un valor de esta
        se devuelve un arr con los obj que cumplan con esta condicion*/
    public function getAllFilteredBy($orderBy, $orderMode, $filterBy, $filterValue, $limit, $row){
        $query = $this->db->prepare("SELECT * FROM libros WHERE $filterBy = '$filterValue' 
                                    ORDER BY $orderBy $orderMode LIMIT $limit OFFSET $row");
        $query->execute();
        $libros = $query->fetchAll(PDO::FETCH_OBJ);
        return $libros;
    }

    /*funcion que llama a un libro en particular teniendo en cuenta su id
        se prepara sentencia para registro con id determinado, se ejecuta con el id
        se guarda en variable resultado de la busqueda(un obj) y se devuelve*/
    public function getLibroInd($id){
        $query = $this->db->prepare("SELECT * FROM libros WHERE id_libros=?");
        $query->execute([$id]);
        $libro = $query->fetch(PDO::FETCH_OBJ);
        return $libro;
    } 

    /*funcion para agregar nuevo libro, parametros: variables con los valores que va a tener el libro
        se prepara sentencia para insertar valores en db, se ejecuta la sentencia pasando parametros*/
    public function addLibro($libro, $autores, $anio, $precio, $genero){
        $query = $this -> db -> prepare("INSERT INTO libros
            (titulo, autores, anio, precio, generos_fk) VALUES(?, ?, ?, ?, ?)");
        $query -> execute([$libro, $autores, $anio, $precio, $genero]);
        return $this -> db -> lastInsertId();
    }

    /*funcion para eliminar un libro, recibe como parametro id
        se prepara sentencia que elimina el libro y se ejecuta*/
    public function delete($id){
        $query = $this -> db -> prepare("DELETE FROM libros WHERE id_libros=?");
        $query -> execute([$id]);
    }

    /*funcion para editar un libro, parametros: variables con los valores modificados o como estaban
        se prepara sentencia que actualiza la tabla
        se ejecuta con los valores pasados por variables*/
    public function editLibro($id, $titulo, $autores, $anio, $precio, $genero){
        $query = $this -> db -> prepare("UPDATE libros SET titulo = ?, autores = ?,
                                anio=?, precio=?, generos_fk=? WHERE id_libros=?");
        $query -> execute([$titulo, $autores, $anio, $precio, $genero, $id]);
    }
}