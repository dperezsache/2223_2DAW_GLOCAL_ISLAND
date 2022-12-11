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
        /**
         * Método para la insercción en la base de datos de una nueva reflexión
         * @param {Array} $nuevaReflexion
         */
        public function insertarReflexion($nuevaReflexion){
            $this->conectar();
            $consulta=$this->conexion->prepare('INSERT INTO Reflexiones(texto,numPreguntas,idCategoria) VALUES(?,?,?)');
            $consulta->bind_param('sii',$texto,$cantPreguntas,$categoria);
            $texto=$_POST['reflexion'];
            $cantPreguntas=$_POST['cantPreguntas'];
            $categoria=$_POST['categoria'];

            $consulta->execute();
            $this->conexion->close();
            header('Location:../cruds_categorias/index.php');
        }
        public function modificarReflexion($reflexion){
            $this->conectar();
            $consulta=$this->conexion->prepare('UPDATE Reflexiones SET texto=?,numPreguntas=?,idCategoria=? WHERE id=?');
            $consulta->bind_param('siii',$texto,$numPreguntas,$idCategoria,$id);
            $texto=$reflexion['reflexion'];
            $numPreguntas=$reflexion['cantPreguntas'];
            $idCategoria=$reflexion['categoria'];
            $id=$reflexion['id'];
            $consulta->execute();
            $this->conexion->close();
            header('Location:../cruds_categorias/index.php');
        }
        /**
         * Método para la conexión con la BBDD del juego
         */
        private function conectar()
        {     
            $this->conexion = new mysqli($this->servidor,  $this->usuario,  $this->contrasenia, $this->bd);
        }
        public function eliminarReflexion($paramQuery){
            $this->conectar();
            $consulta=$this->conexion->prepare('DELETE FROM Reflexiones WHERE Reflexiones.id=?');
            $consulta->bind_param('i',$id);
            $id=$paramQuery['id'];

            $consulta->execute();
            $this->conexion->close();
            header('Location:../cruds_categorias/index.php');
        }
    }
?>