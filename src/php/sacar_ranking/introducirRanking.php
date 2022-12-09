<?php
    require('../config/conexion.php');
    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);

    $alias=$_POST['aliasJugador'];
    $puntos=$_POST['puntosJugador'];

    $consultaRanking = $conexion->prepare('INSERT INTO Clasificacion(alias,puntuacion) VALUES(?,?)');
    $consultaRanking->bind_param('si', $alias,$puntos);
    $consultaRanking->execute();
?>