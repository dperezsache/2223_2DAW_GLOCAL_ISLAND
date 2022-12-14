<?php
    header('mime-type: application/json');
    $body = json_decode(file_get_contents('php://input'));
    require_once('../../php/config/conexion.php');
    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
    $respuesta=[];
    $array=[];
    $idagua=$body->agua;
    $idaire=$body->aire;
    $idtierra=$body->tierra;

    $consulta='SELECT texto FROM Reflexiones WHERE idCategoria=3 AND numPreguntas='.$idagua;
    $respuesta=$conexion->query($consulta);
    while($fila = $respuesta->fetch_assoc()){
         array_push($array,$fila);
    }
    
    $consulta='SELECT texto FROM Reflexiones WHERE idCategoria=1 AND numPreguntas='.$idaire;
    $respuesta=$conexion->query($consulta);
    while($fila = $respuesta->fetch_assoc()){
        array_push($array,$fila);
    }
    
    $consulta='SELECT texto FROM Reflexiones WHERE idCategoria=2 AND numPreguntas='.$idtierra;
    $respuesta=$conexion->query($consulta);
    while($fila = $respuesta->fetch_assoc()){
        array_push($array,$fila);
    }
    mysqli_close($conexion);
    echo json_encode($array,JSON_FORCE_OBJECT);
?>