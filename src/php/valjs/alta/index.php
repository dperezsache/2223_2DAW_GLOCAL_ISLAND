<?php
    try 
    {
        require_once('../conexion.php');
        $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
        $sql = $conexion->prepare('SELECT * FROM Administrador');
        $sql->execute();
    
        $resultado = $sql->get_result();
    
        $sql->close();
        $conexion->close();
    
        // Si ya existe un administrador, volver al login
        if($resultado->num_rows == 1) 
        {
            header('Location: ../login/index.php');
        }
    }
    catch(mysqli_sql_exception $e) 
    {
        echo '<p>' . $e->getMessage() . '</p>';
    }
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
        <div id="divAlta">
			<img id="logoCorporativo" src="../recursos/img/logo1.png"/>
            <form id="formulario_alta" method="post" action="altaAdmin.php">
                <label for="nombre">Usuario a Crear</label><br/>
                <input type="text" name="nombre" maxlength="150" required/><br/><br/>

                <label for="password">Clave</label><br>
                <input type="password" name="password" required/><br/><br/>

                <select id="selectorAdmin">
                    <option class="optionsAdmin" value="s">SuperAdmin</option>
                    <option class="optionsAdmin" value="a">Admin</option>
                    <option class="optionsAdmin" value="e">Editor</option>
                </select><br/><br/>

                <button id="btnEnviar" type="submit"></button>
            </form>
        </div>
	</body>
</html>