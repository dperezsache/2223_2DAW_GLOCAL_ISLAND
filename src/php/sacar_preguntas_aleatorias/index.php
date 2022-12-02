<?php
    header('mime-type: application/json');
    include('../config/conexion.php');
    $objeto = new stdClass();
    $array=[];
    $atributo='';
    $prueba = new stdClass();
    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
    $consulta = 'SELECT  pregunta,respuesta,correcta,imagen,Subcategorias.nombre AS "subCat",Categorias.nombre AS "Cat"
    FROM Preguntas INNER JOIN Subcategorias ON(Preguntas.idSubcategoria=Subcategorias.id)
                    INNER JOIN Categorias ON(Subcategorias.idCategoria=Categorias.id)
                    INNER JOIN Respuestas ON(Respuestas.numPregunta=Preguntas.numPregunta AND Respuestas.idSubcategoria=Preguntas.idSubcategoria)';
    $preguntasSacadas=mysqli_query($conexion,$consulta);
    $preguntas = [];
    $i=0;
    while($fila = $preguntasSacadas->fetch_assoc()){
        array_push($array,$fila);
        $atributo='Pregunta'.$i;
        $i++;
    }
    echo json_encode($array,JSON_FORCE_OBJECT);
?>
    