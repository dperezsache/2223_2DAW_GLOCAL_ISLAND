<?php
    require_once('modelos/modeloreflexiones.php');
    /**
     * Clase para la gestión de objetos de tipo ControladorReflexiones
     */
    class ControladorReflexiones{
        /**
         * Constructor para el instanciamiento de objetos de tipo ControladorReflexiones
         */
        function __construct(){
            $this->modelo=new ModeloReflexiones();
        }
        /**
         * Método para el envío de una nueva reflexion recibida al modelo
         */
        public function post($nuevaReflexion){
            $this->modelo->insertarReflexion($nuevaReflexion);
        }
    }
?>