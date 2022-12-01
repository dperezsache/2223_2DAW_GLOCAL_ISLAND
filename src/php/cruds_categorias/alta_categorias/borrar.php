<?php
    // Comprobar sesión
    session_start();
    
    if(!isset($_SESSION['nombre'])) {
        header('Location: ../../../index.php/html/index.html');
    }

    include('../conexion.php');
    //Conexión con la base de datos
    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
	$id = $_GET["id"];
	$sql = 'DELETE FROM Subcategorias WHERE id='.$id.';';
	
	$resultado=mysqli_query($conexion,$sql);
    echo'Borrado con éxito';
    echo'<a href="index.php">Volver</a>';

?>