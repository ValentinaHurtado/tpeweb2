# API REST

## Importar DB
Se debe importar base de datos libreria.sql encontrada en la carpeta db

## Prueba con postman
Usando endpoint: http://localhost/tpeweb2/api/libros

## Metodos GET
- Listar todos los libros: http://localhost/tpeweb2/api/libros
- Obtener un libro determinado mediante su id: http://localhost/tpeweb2/api/libros/:ID
- Obtener lista ordenando de forma ascendente o descente por distintas columnas de la tabla:
  - http://localhost/tpeweb2/api/libros?orderBy=anio&orderMode=asc
  - http://localhost/tpeweb2/api/libros?orderBy=precio&orderMode=desc
- Obtener lista filtrando por una columna de la tabla y un valor de esta: http://localhost/tpeweb2/api/libros?filterBy=anio&filterValue=1939
- Obtener lista por pagina con un limite de libros en cada una: http://localhost/tpeweb2/api/libros?page=1&limit=10
- Obtener lista combinando funciones anteriores:
  - http://localhost/tpeweb2/api/libros?orderBy=anio&orderMode=asc&filterBy=autores&filterValue=Stephen-King
  - http://localhost/tpeweb2/api/libros?orderBy=anio&orderMode=asc&page=1&limit=10
  - http://localhost/tpeweb2/api/libros?filterBy=anio&filterValue=1985&page=1&limit=10
  - http://localhost/tpeweb2/api/libros?orderBy=anio&orderMode=asc&filterBy=anio&filterValue=1985&page=1&limit=2

## Metodos POST
Agregar un nuevo libro: http://localhost/tpeweb2/api/libros
Ejemplo:

![image](https://user-images.githubusercontent.com/115017557/202066222-45a4913e-ad54-494e-bc51-3012958e26f7.png)

## Metodo PUT
Modifico un libro: http://localhost/tpeweb2/api/libros/:ID

## Metodo DELETE
Elimino un libro: http://localhost/tpeweb2/api/libros/:ID
