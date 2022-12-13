<?php
    //Comprobar sesión
    session_start();
        
    if(!isset($_SESSION['nombre'])) {
        header('Location: ../../index/html/index.html');
    } 
    require_once '../config/conexion.php';

    require_once('../vistas/modificarCat.php');
?>
