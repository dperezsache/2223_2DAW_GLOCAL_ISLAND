<?php
    session_start();    // El inicio de sesión tiene que ir lo primero, sino da problema con los headers al ir dentro de HTML.
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Pantalla logueado</title>
        <meta charset="UTF-8"/>
        <link rel="stylesheet" type="text/css" href="../estilos.css"/>
    </head>
    <body>
        <?php
            // Comprobar que la sesión exista.
            if(session_status() == PHP_SESSION_ACTIVE && $_SESSION['nombre']) 
            {
                echo '<p>Login correcto, bienvenido ' . $_SESSION['nombre'] . '</p>';
                echo '<p><a href="logout.php">Cerrar sesión</a></p>';
            }
            else 
            {
                echo '<p>Login fallido</p>';
                echo '<p><a href="index.php">Volver al login</a></p>';
            }    
        ?>
    </body>
</html>
