<?php
    require_once('../modelos/modelopreguntas.php');
    /**
     * Clase para la gestión de objetos de tipo ControladorPreguntas
     */
    class ControladorModificacion{
        /**
         * Constructor para el instanciamiento de nuevos objetos de tipo ControladorPreguntas
         */
        function __construct()
        {       
            $this->modelo=new ModeloPreguntas();
        }
        /**
         *Método para el envío de preguntas recibidas al modelo para su posterior insercción
         */
        public function post($pregunta)
        {
            /* $_GET['pregunta']=$_POST['nuevaPregunta'];
            $_GET['numPregunta']=$_POST['numPregunta'];
            $_GET['idSubcategoria']=$_POST['categoriaPregunta'];
            $_GET['idSubcategoria']=$_POST['categoriaPregunta'];
            $arrayIndices=array_keys($pregunta);
            for($i=0;$i<sizeof($arrayIndices);$i++){
                if($arrayIndices[$i]=="primeraRespuesta"){
                    if($arrayIndices[$i+1]=="btnCorrecta"){
                        $_GET['correcta']='respuesta1';
                    }else{
                        $_GET['correcta']='respuesta2';
                    }
                }
            }
            $_GET['respuesta1']=$_POST['primeraRespuesta'];
            $_GET['respuesta2']=$_POST['segundaRespuesta']; */
            if($pregunta['primeraRespuesta']==$pregunta['segundaRespuesta']){
                /* $error='Dos respuestas iguales';
                require_once('../vistas/modificarCat.php'); */
                header('location:../../cruds_categorias/index.php');
            }
            else{
                $this->modelo->modificarPreguntayRespuesta($pregunta);
            }
        }

        public function dom($datos){
            $this->modelo->eliminarPreguntayRespuesta($datos);
        }
    }
?>