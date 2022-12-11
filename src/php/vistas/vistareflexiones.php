<?php
/**
 * Clase para la gestión de objetos tipo VistaReflexiones
 */
class VistaReflexiones{
    /**
     * Método para el instanciamiento de objetos de tipo VistaReflexiones
     */
    function __construct(){

    }
    public function vistaModificacion($parametrosquery){
        require_once('modificacionreflexiones.php');
    }
}
?>