<?php
    require_once('../../php/modelos/modeloiniciosesion.php');

    class ControladorInicioSesion
    {
        private $modelo;

        /**
         * Constructor de la clase controlador.
         */
        function __construct()
        {       
            $this->modelo = new ModeloInicioSesion();
        }

        /**
         * Llama al método para hacer login del modelo.
         * @param String $nombre Nombre del administrador.
         * @param String $password Contraseña del administrador.
         */
        public function login($nombre, $password)
        {
            if(!is_null($nombre) && !is_null($password) && !empty($nombre) && !empty($password))
            {
                $this->modelo->login($nombre, $password);
            }
        }

        /**
         * Llama al método para dar de alta al administrador del modelo.
         * @param String $nombre Nombre del administrador.
         * @param String $password Contraseña del administrador.
         */
        public function altaAdmin($nombre, $password)
        {
            if(!is_null($nombre) && !is_null($password) && !empty($nombre) && !empty($password))
            {
                $this->modelo->altaAdmin($nombre, $password);
            }
        }

        /**
         * Comprobar si existe un administrador en la aplicación.
         * @return Boolean True si existe, false si no.
         */
        public function checkAdmin()
        {
            return $this->modelo->checkAdmin();
        }
    }
?>