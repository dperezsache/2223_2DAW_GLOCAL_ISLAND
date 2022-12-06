<?php
    require_once('config/conexion.php');
    /**
     * Clase para la gestión de objetos de tipo ModeloReflexiones
     */
    class ModeloReflexiones{
        /**
         * Constructor para el instanciamiento de objetos de tipo ModeloReflexiones
         */
        function __construct(){
            $this->servidor = constant('SERVIDOR');
            $this->usuario = constant('USUARIO');
            $this->contrasenia = constant('CONTRASENIA');
            $this->bd = constant('BD');
        }
        public function insertarReflexion($nuevaReflexion){
            print_r($nuevaReflexion);
            $this->conectar();
            $consulta=$this->conexion->prepare('INSERT INTO Reflexiones(texto,numPreguntas,idCategoria) VALUES(?,?,?)');
            $consulta->bind_param('sii',$texto,$cantPreguntas,$categoria);
            $texto=$_POST['reflexion'];
            $cantPreguntas=$_POST['cantPreguntas'];
            $categoria=$_POST['categoria'];

            $consulta->execute();
            $this->conexion->close();
        }
        /**
         * Método para la conexión con la BBDD del juego
         */
        private function conectar()
        {     
            $this->conexion = new mysqli($this->servidor,  $this->usuario,  $this->contrasenia, $this->bd);
        }
    }
?>