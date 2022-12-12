<?php
    require_once('config/conexion.php');
    /**
     * Clase para la gestión de ModeloPreguntas desde servidor
     */
    class ModeloPreguntas{
        /**
         * Constructor para el instanciamiento de objetos de tipo ModeloPreguntas
         */
        function __construct(){
            $this->servidor = constant('SERVIDOR');
            $this->usuario = constant('USUARIO');
            $this->contrasenia = constant('CONTRASENIA');
            $this->bd = constant('BD');
        }
        /**
         * Método para la insercción en la BBDD de una nueva pregunta y sus categorias
         */
        public function insertarPreguntayRespuesta($preguntaYrespuesta){
            $this->conectar();
            $sw=0;
            $consulta=$this->conexion->prepare('INSERT INTO Preguntas(idSubcategoria,pregunta,imagen) VALUES(?,?,?)');
            
            $idSubCat=$preguntaYrespuesta['subcategoria'];
            $pregunta=$preguntaYrespuesta['pregunta'];
            $imagen=$preguntaYrespuesta['imagenPregunta'];
            $respuesta1=$preguntaYrespuesta['respuesta1'];
            $respuesta2=$preguntaYrespuesta['respuesta2'];
            $correcta=0;
            
            $consulta->bind_Param('sss',$idSubCat,$pregunta,$imagen);
            $arrayIndices=array_keys($preguntaYrespuesta);
           for($i=0;$i<sizeof($arrayIndices);$i++){
                if($arrayIndices[$i]=="respuesta1"){
                    if($arrayIndices[$i+1]=="btnCorrecta"){
                        $correcta=1;
                        $sw=1;
                    }else{
                        $correcta=0;
                        $sw=0;
                    }
                }
           }
           $consulta->execute();
            //Con esto obtenemos el ultimo id insertado tras la consulta para poder hacer la siguiente insercción de las respuestas asociadas a pregunta
            $ultimoID=$this->conexion->insert_id;
            $this->conexion->close();
            //INSERCCIÓN DE LAS RESPUESTAS
            $this->conectar();
            $consulta=$this->conexion->prepare('INSERT INTO Respuestas(idSubcategoria,numPregunta,respuesta,correcta) VALUES(?,?,?,?)');
            $consulta->bind_Param('sssi',$idSubCat,$ultimoID,$respuesta1,$correcta);
            $consulta->execute();
            if($sw==1){
                $correcta=0;
            }else{
                $correcta=1;
            }
            $consulta->bind_Param('sssi',$idSubCat,$ultimoID,$respuesta2,$correcta);
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
        public function obtenerSubcategorias(){
            $this->conectar();
            $consulta="SELEC id,nombre FROM Subcategorias";
            $respuesta=$this->conexion->query($consulta);
            return $respuesta;

        }
    }
?>