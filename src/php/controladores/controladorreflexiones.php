<?php
    require_once('modelos/modeloreflexiones.php');
    require_once('vistas/vistareflexiones.php');
    /**
     * Clase para la gestión de objetos de tipo ControladorReflexiones
     */
    class ControladorReflexiones{
        /**
         * Constructor para el instanciamiento de objetos de tipo ControladorReflexiones
         */
        function __construct(){
            $this->modelo=new ModeloReflexiones();
            $this->vista=new VistaReflexiones();
        }
        /**
         * Método para el envío de una nueva reflexion recibida al modelo
         */
        public function post($nuevaReflexion){
            
                $this->modelo->insertarReflexion($nuevaReflexion);
            
        }
        public function actualizar($reflexion){
            $this->modelo->modificarReflexion($reflexion);
           
        
        }
        public function modificar($parametrosQuery){
            $this->vista->vistaModificacion($parametrosQuery);
        }
        public function eliminar($parametrosQuery){
            $this->modelo->eliminarReflexion($parametrosQuery);
        }
        public function obtenerReflexiones($body){
            $this->modelo->obtenerReflexiones($body);
        }
    }
?>