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
            try{
                $this->validarAlta($nuevaReflexion);
                $this->modelo->insertarReflexion($nuevaReflexion);
            }catch(Exception $e){
                header('Location:../cruds_categorias/index.php');
            }
                
            
        }
        public function actualizar($reflexion){
            try{
                $this->validarModificacion($reflexion);
                $this->modelo->modificarReflexion($reflexion);
            }catch(Exception $e){
                $this->modificar( $reflexion);
            }
        }
        public function modificar($parametrosQuery){
            $this->vista->vistaModificacion( $parametrosQuery);
        }
        public function eliminar($parametrosQuery){
            $this->modelo->eliminarReflexion($parametrosQuery);
        }
        public function obtenerReflexiones($body){
            $this->modelo->obtenerReflexiones($body);
        }
        public function validarAlta($nuevaReflexion){
           if(strlen($nuevaReflexion['reflexion'])>1000 || strlen($nuevaReflexion['reflexion'])<10){
                throw new Exception('Tamaño de reflexión no válido, vuelva a intentarlo.');
            }
            
        }
        public function validarModificacion($reflexion){
            if(strlen($reflexion['texto'])>1000 || strlen($reflexion['texto'])<10){
                throw new Exception('Tamaño de reflexión no válido, vuelva a intentarlo.');
            }
        }
    }
?>