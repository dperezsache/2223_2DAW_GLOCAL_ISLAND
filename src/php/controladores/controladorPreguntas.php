<?php
    require_once('modelos/modelopreguntas.php');
    /**
     * Clase para la gestión de objetos de tipo ControladorPreguntas
     */
    class ControladorPreguntas{
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
        public function post($nuevaPregunta)
        {
            $this->modelo->insertarPreguntayRespuesta($nuevaPregunta);
        }
    }
?>