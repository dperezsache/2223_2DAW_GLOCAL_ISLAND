<?php
    include('../config/conexion.php');
    //Conexión con la base de datos
    $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);

    $consulta = 'SELECT alias,puntuacion
    FROM Clasificacion
    ORDER BY puntuacion desc' ;

    $puntuaciones=$conexion->query($consulta);
    while($fila = $puntuaciones->fetch_array()){
        echo '<td>'.$fila['alias'].'</td>';
        echo '<td>'.$fila['puntuacion'].'</td><br><br>';
    }
    // Cerrar conexión
    mysqli_close($conexion);
?>