<?php
    // Comprobar sesión
    session_start();
    
    if(!isset($_SESSION['nombre'])) {
        header('Location: ../../../index.php/html/index.html');
    }
    require_once('../vistas/eliminarSub.php');
?>