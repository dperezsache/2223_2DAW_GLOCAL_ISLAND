<?php
    /**
     * Archivo php que getionara los controladores del modelo MVC del servidor, será la entrada a las peticiones http
     */
    //Confirmamos que existe una sesión iniciada, sino, seria reenviado de vuelta a la página de juego
    session_start();
    if(isset($_SESSION['nombre'])){
        //Obtenemos el array de configuración descrito en config/config.php para así facilitar la gestión
        $config=require_once("config/config2.php");
        $usuario=$_SESSION['nombre'];
        //Leemos el metodo de la petición que recibimos
        $metodo=$_SERVER['REQUEST_METHOD'];

        //Recogemos los pathparams, en nuestro caso, seran los indicadores de a que controlador deben de dirigirse dicha solicitud
        $pathParams=null;
        if(isset($_SERVER['PATH_INFO'])){//Estos parámetros si existen, estaran recogidos en ese elemento del array $_SERVER
            $pathParams=explode('/',$_SERVER['PATH_INFO']);//Con el siguiente método, estamos conformando un array que parte de $_SERVER['PATH_INFO'] y que
                                                            //y que separamos con / que es como viene en la petición
        }
        //El controlador siempre sera el primero en recibirse, no se pone el 0 por que viene vacío
        $controlador=$pathParams[1];
        $parametrosQuery=null;
        //Función específica para la lectura de parametros query de las peticiones, lee dichos parámetros y los inserta en $paramQuery
        parse_str($_SERVER["QUERY_STRING"],$parametrosQuery);
        $body = json_decode(file_get_contents('php://input'));

       switch($controlador){
            case 'controladorpreguntas'://AQUI $FILE
                require_once($config['path_controladores'].'controladorpreguntas.php');
                if(isset($_FILES["imagenPregunta"])){
                    $nom_archivo = $_FILES['imagenPregunta']['name'];
                    $ruta = "../img/subidas_bbdd/".$nom_archivo;
                    $archivo=$_FILES['imagenPregunta']['tmp_name'];
                    $subir=move_uploaded_file($archivo,$ruta);
                    $_POST['imagenPregunta']=$nom_archivo;
                }
                $controlador=new ControladorPreguntas();
                break;
            case 'controladorreflexiones':
                require_once($config['path_controladores'].'controladorreflexiones.php');
                $controlador=new ControladorReflexiones();
                break;
            case 'obtenerreflexiones':
                require_once($config['path_controladores'].'controladorreflexiones.php');
                $controlador=new ControladorReflexiones();
                $metodo='obtenerreflexiones';
                break;
       }
       switch($metodo){
        case 'POST':
            if(!isset($_POST["id"])){
                $controlador->post($_POST);
            }else{
                $controlador->actualizar($_POST);
            }
            die();
            break;
        case "GET":
            if(sizeof($parametrosQuery)>2){
                $controlador->modificar($parametrosQuery);
                
            }else{
                $controlador->eliminar($parametrosQuery);
            }
            die();
            break;
        case "obtenerreflexiones":
            $controlador->obtenerReflexiones($body);
            die();
            break;
        }
    }else{
        header('location:../index/html/index.html');
    }
    
?>