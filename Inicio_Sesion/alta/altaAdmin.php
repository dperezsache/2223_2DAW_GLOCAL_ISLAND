<?php
    try 
    {
        // Validar que los datos existan
        if(isset($_POST['nombre']) && isset($_POST['password'])) 
        {
            require_once('../conexion.php');

            $nombre = $_POST['nombre'];
            $password = $_POST['password'];
            
            $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
            $consulta = $conexion->prepare('INSERT INTO Administrador VALUES(?,?)');

            // 'Hashear' la contraseña sacada del formulario
            $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]);

            // Ejecutar consulta para insertar el usuario y el hash en la BBDD
            $consulta->bind_param('ss', $nombre, $hash);
            $consulta->execute();

            // Cerrar consulta y conexión
            $consulta->close();
            $conexion->close();

            // Una vez acabado el proceso, volver a la pantalla de login
            header('Location: ../login/index.php');
        }
    }
    catch(mysqli_sql_exception $e) 
    {
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<p><a href="../login/index.php">Volver</a></p>';
    }
?>