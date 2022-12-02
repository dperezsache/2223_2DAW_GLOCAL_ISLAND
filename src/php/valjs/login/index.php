<?php
/*     try
    {
        require_once('../conexion.php');
        $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
        $sql = $conexion->prepare('SELECT * FROM Administrador');
        $sql->execute();
    
        $resultado = $sql->get_result();
    
        $sql->close();
        $conexion->close();
        
        if($resultado->num_rows == 0) 
        {
            header('Location: ../alta/index.php');
        }
    }
    catch(mysqli_sql_exception $e) 
    {
        echo '<p>' . $e->getMessage() . '</p>';
    } */
?> 
<!DOCTYPE html>
<html>
    <head>
		<meta charset="utf-8"/>
		<meta author="Team Glocal Guadalupe: David Pérez, Juan Manuel Rincón, Laura Merino y Daniel García"/>
		<title>Glocal Island</title>
		<meta name="viewport" content="width=device-width,initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="../estilos.css"/>
	</head>
	<body>
        <div id="divInicioSesion">
			<img id="logoCorporativo" src="../../../img/logo1.png"/>
            <form id="formulario_inicio" method="post" action="login.php">
                <label for="nombre">Usuario</label><br/>
                <input type="text" name="nombre" maxlength="150"  required/><br/><br/>

                <label for="password">Clave</label><br/>
                <input type="password" name="password" required/><br/><br/>

                <button id="btnEnviar" type="submit"></button>
                <p id="error"></p>
            </form>
        </div>
        <script type=module src="app.js"></script>  
	</body>
</html>