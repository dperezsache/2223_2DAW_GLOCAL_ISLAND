<?php
	header('mime-type: application/json');
	$objeto = new stdClass();
	require('../conexion.php');
    //Conexión con la base de datos
    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
    $categorias= "SELECT id
    FROM Categorias;";
    $idSacado=mysqli_query($conexion,$categorias);
    $i=0;
    while($fila = $idSacado->fetch_array()){
        $i++;
    }
    if($i>=3){
        $vista=1;
    }
    else{
        $vista=0;
    }
    $objeto->valor = $vista;
	echo json_encode($objeto);
?>