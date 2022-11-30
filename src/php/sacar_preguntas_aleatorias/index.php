<?php
    include('conexion.php');
    //Conexión con la base de datos
    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);

    $consulta = 'SELECT  pregunta,respuesta,correcta,imagen,Subcategorias.nombre AS "subCat",Categorias.nombre AS "Cat"
    FROM Preguntas INNER JOIN Subcategorias ON(Preguntas.idSubcategoria=Subcategorias.id)
    INNER JOIN Categorias ON(Subcategorias.idCategoria=Categorias.id)
    INNER JOIN Respuestas ON(Respuestas.numPregunta=Preguntas.numPregunta AND Respuestas.idSubcategoria=Preguntas.idSubcategoria)';

    $preguntasSacadas=mysqli_query($conexion,$consulta);
    $preguntas = [];
    while($fila = $preguntasSacadas->fetch_array()){
        var_dump($fila);
    }
?>
    
    
    