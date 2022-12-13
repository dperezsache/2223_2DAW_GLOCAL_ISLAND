<?php 
    //Conexión con la base de datos
    require_once('../config/conexion.php');
    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
    $id = $_GET["idSubcategoria"];
    $sql = 'DELETE FROM Subcategorias WHERE id='.$id.';';

    $resultado=$conexion->query($sql);
    header('location:../cruds_categorias/index.php');
    
?>