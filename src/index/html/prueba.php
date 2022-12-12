<?php
    header('mime-type: application/json');
    $body = json_decode(file_get_contents('php://input'));
    require_once('../../php/config/conexion.php');
    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
    $respuesta=[];
    $array=[];
    $id=$body->agua;
    $id=2;
    $consulta='SELECT texto FROM Reflexiones WHERE numPreguntas='.$id;
    $respuesta=$conexion->query($consulta);
    while($fila = $respuesta->fetch_assoc()){
         array_push($array,$fila);
    }
    $id=$body->aire;
    $id=1;
    $consulta='SELECT texto FROM Reflexiones WHERE numPreguntas='.$id;
    $respuesta=$conexion->query($consulta);
    while($fila = $respuesta->fetch_assoc()){
        array_push($array,$fila);
    }

    $id=$body->tierra;
    $id=3;
    $consulta='SELECT texto FROM Reflexiones WHERE numPreguntas='.$id;
    $respuesta=$conexion->query($consulta);
    while($fila = $respuesta->fetch_assoc()){
        array_push($array,$fila);
    }
    mysqli_close($conexion);
    echo json_encode($array,JSON_FORCE_OBJECT);
?>