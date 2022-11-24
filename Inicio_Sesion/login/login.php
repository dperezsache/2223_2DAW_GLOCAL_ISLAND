<?php
    try 
    {
        // Validación de datos del formulario
        if(isset($_POST['nombre']) && isset($_POST['password'])) 
        {
            $nombre = $_POST['nombre'];
            $password = $_POST['password'];

            // Incluir datos de conexión
            require_once('../conexion.php');   

            // Conectar con la BBDD
            $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);

            // Preparar consulta preparada para obtener los datos del administrador de la BBDD
            $consulta = $conexion->prepare('SELECT * FROM Administrador');   
            $consulta->execute();
            $resultado = $consulta->get_result();

            $consulta->close();
            $conexion->close();

            // Comprobar que el resultado devuelve al administrador (más de 0 filas)
            if($resultado->num_rows > 0) 
            {
                $fila = $resultado->fetch_assoc();
                $usuario = $fila['nick'];
                $hash = $fila['password'];
                
                // Comprobar que la contraseña del formulario y el hash de la contraseña de la BBDD coinciden, y comprobar que el usuario sea igual.
                if(password_verify($password, $hash) && $nombre === $usuario) 
                {
                    ini_set('session.use_strict_mode', true);   // Activar modo estricto.
                    ini_set('session.use_only_cookies', 1);     // Forzar las sesiones a usar solo cookies. 
                    ini_set('session.gc_maxlifetime', 3600);    // El servidor recordará los datos de sesión por 1 hora.
                    session_set_cookie_params(600);             // La sesión del cliente caducará en 600 segundos de inactividad.
                    session_start();                            // Iniciar la sesión.
                    
                    $_SESSION['nombre'] = $nombre;
                    header('Location: logueado.php');
                }
                else 
                {
                    header('Location: index.php');
                }
            }
            else 
            {
                header('Location: ../alta/index.php');
            }
        }
    }
    catch(mysqli_sql_exception $e) 
    {
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<p><a href="index.php">Volver</a></p>';
    }
?>