<?php
    // Comprobar sesión
    /* session_start();
        
    if(!isset($_SESSION['nombre'])) {
        header('Location: ../../index/html/index.html');
    } */
    $resp=$_POST;
    require_once '../config/conexion.php';
    
/*     $pregunta=$resp['pregunta']
    $respuesta1=$resp['respuest1']
    $respuesta2=$resp['respuest2'] */

    $pregunta='Reutilizais objetos';
    $respuesta1='Si';
    $respuesta2='No';

    $consulta="SELECT idSubcategoria, numPregunta FROM Preguntas WHERE pregunta='".$pregunta."';";
    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
    
    try{
        $resultado=$conexion->query($consulta);
        $fila=$resultado->fetch_assoc();
        $idSubcategoria=$fila['idSubcategoria'];
        $numPregunta=$fila['numPregunta'];
        echo $idSubcategoria;
        echo $numPregunta;
    }
    catch (Exception $e){
            echo 'Ha habido algun error';
           
    }
   
    $conexion->close();
    $preguntaNueva='Reutilizas objetos';
    $consulta="UPDATE Preguntas SET pregunta='".$preguntaNueva."' WHERE idSubcategoria='".$idSubcategoria."' AND numPregunta='".$numPregunta."';";
    echo $consulta;
    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
    if ($conexion->query($consulta) === TRUE) {
        echo "<br>Record updated successfully";
    } else {
        echo "Error updating record: " . $conexion->error;
    }
    $conexion->close();
?>