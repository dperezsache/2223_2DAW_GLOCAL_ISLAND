<?php
    require_once('../../php/controladores/controladoriniciosesion.php');
    $controlador = new ControladorInicioSesion();

    // Comprobar si existe administrador. Si no hay, ir a la pantalla de creación.
    if(!$controlador->checkAdmin())
    {
        header('Location: indexalta.php');
    }
    else if(isset($_POST['nombre']) && isset($_POST['password']))
    {
        $controlador->login($_POST['nombre'], $_POST['password']);
    }
?>
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8"/>
		<meta author="Team Glocal Guadalupe: David Pérez, Juan Manuel Rincón, Laura Merino y Daniel García"/>
		<title>Glocal Island</title>
		<meta name="viewport" content="width=device-width,initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="../../css/estilos.css"/>
	</head>
	<body>
        <div id="divInicioSesion">
			<img id="logoCorporativo" src="../../img/logo1.png"/>
            <form id="formulario_inicio" method="post" action="indexlogin.php">
                <label for="nombre">Usuario</label><br/>
                <input type="text" name="nombre" maxlength="150" pattern="[a-zA-Z0-9]+" required/><br/><br/>

                <label for="password">Clave</label><br/>
                <input type="password" name="password" required/><br/><br/>

                <button id="btnEnviar" type="submit"></button>
            </form>
        </div>
	</body>
</html>