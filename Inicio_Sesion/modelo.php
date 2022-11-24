<?php
    require_once('conexion.php');

    class Modelo
    {
        private $conexion;
        private $usuario;
        private $contrasenia;
        private $servidor;
        private $bd;

        /**
         * Constructor de la clase modelo.
         */
        function __construct()
        {
            $this->servidor = constant('SERVIDOR');
            $this->usuario = constant('USUARIO');
            $this->contrasenia = constant('CONTRASENIA');
            $this->bd = constant('BD');
        }

        /**
         * Realizar login del administrador.
         * @param String $nombre Nombre del administrador.
         * @param String $password Contraseña del administrador.
         */
        public function login($nombre, $password)
        {
            if(!empty($nombre) && !empty($password))
            {
                try 
                {
                    // Hacer conexión
                    $this->conectar();

                    // Preparar consulta preparada para obtener los datos del administrador de la BBDD
                    $consulta = $this->conexion->prepare("SELECT * FROM Administrador WHERE nombre=?");
                    $consulta->bind_param('s', $nombre);
                    $consulta->execute();
                    $resultado = $consulta->get_result();
    
                    $consulta->close();
                    $this->conexion->close();
    
                    // Comprobar que el resultado devuelve al administrador (más de 0 filas)
                    if($resultado->num_rows > 0) 
                    {
                        $fila = $resultado->fetch_assoc();
                        $usuario = $fila['nombre'];
                        $hash = $fila['clave'];
                        
                        // Comprobar que la contraseña del formulario y el hash de la contraseña de la BBDD coinciden, y comprobar que el usuario sea igual.
                        if(password_verify($password, $hash) && $nombre === $usuario) 
                        {
                            ini_set('session.use_strict_mode', true);   // Activar modo estricto.
                            ini_set('session.use_only_cookies', 1);     // Forzar las sesiones a usar solo cookies. 
                            session_set_cookie_params(600);             // La sesión del cliente caducará en 600 segundos de inactividad.
                            session_start();                            // Iniciar la sesión.
                            
                            $_SESSION['nombre'] = $nombre;
                            $_SESSION['perfil'] = 'GI';
                            header('Location: logueado.php');
                        }
                        else 
                        {
                            header('Location: indexLogin.php');
                        }
                    }
                    else 
                    {
                        header('Location: indexAlta.php');
                    }
                }
                catch(mysqli_sql_exception $e) 
                {
                    echo '<p>' . $e->getMessage() . '</p>';
                    echo '<p><a href="index.php">Volver</a></p>';
                }
            }
        }

        /**
         * Dar de alta al administrador de la aplicación
         * @param String $nombre Nombre del administrador.
         * @param String $password Contraseña del administrador.
         */
        public function altaAdmin($nombre, $password)
        {
            // Validar que los datos existan
            if(!empty($nombre) && !empty($password)) 
            {
                try 
                {
                    // Hacer conexión
                    $this->conectar();

                    // Preparar consulta preparada
                    $consulta = $this->conexion->prepare('INSERT INTO Administrador(nombre, clave, perfil) VALUES(?,?,?)');
                    
                    $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 15]); // 'Hashear' la contraseña sacada del formulario
                    $perfil = 'GI'; // 'GI' perfil del administrador de Glocal Island

                    // Ejecutar consulta para insertar el usuario y el hash en la BBDD
                    $consulta->bind_param('sss', $nombre, $hash, $perfil);
                    $consulta->execute();

                    // Cerrar consulta y conexión
                    $consulta->close();
                    $this->conexion->close();

                    // Una vez acabado el proceso, volver a la pantalla de login
                    header('Location: indexLogin.php');
                }
                catch(mysqli_sql_exception $e) 
                {
                    echo '<p>' . $e->getMessage() . '</p>';
                    echo '<p><a href="indexLogin.php">Volver</a></p>';
                }
            }
        }

        /**
         * Iniciar conexión con la base de datos.
         */
        private function conectar()
        {     
            $this->conexion = new mysqli($this->servidor,  $this->usuario,  $this->contrasenia, $this->bd);
        }

        /**
         * Comprobar si existe un administrador en la aplicación.
         * @return Boolean True si existe, false si no.
         */
        public function checkAdmin()
        {
            try
            {
                $this->conectar();
                $consulta = $this->conexion->prepare('SELECT * FROM Administrador');
                $consulta->execute();
                $resultado = $consulta->get_result();
                
                $consulta->close();
                $this->conexion->close();

                if($resultado->num_rows > 0)
                {
                    return true;
                }

                return false;
            }
            catch(mysqli_sql_exception $e)
            {
                return false;
            }
        }
    }
?>