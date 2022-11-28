<html>
    <head>
		<meta charset="utf-8">
		<meta author="Team Glocal Guadalupe: David Pérez, Juan Manuel Rincón, Laura Merino y Daniel García">
		<title>Glocal Island</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" type="text/css" href="./css.css">
		<link rel="shotcut icon" href="../logo/logo2.png">
	</head>
    <body>
        <div id="divCategoria">
            <!-- MENU -->
            <nav>
                <li>
                    <img src="../logo/logo1.png">
                </li>
                <li>
                    <a>Listado</a>
                </li>
                <li>
                    <a>Categorias</a>
                </li>
                <li>
                    <a>Preguntas</a>
                </li>
                <li>
                    <a>Cerrar sesión</a>
                </li>
            </nav>
            <!-- LISTADO -->
            <div id="divListado"></div>

            <!-- CRUD CATEGORIAS -->
            <div id="divCrudCategorias">
                <h1>NUEVA CATEGORIA</h1>
                <form method="post">
                    <label>Nueva categoria</label>
                    <input type="text" name="nombre" required><br>
                    <label>Icono</label>
                    <input type="text"  name="icono" required><br>
                    <button type="submit" name="enviar">Enviar</button>
                </form>
            </div>

            <!-- CRUD PREGUNTAS -->
            <div id="divPreguntas"></div>
        </div>
    </body>
</html>
<?php
    try 
    {
        if(isset ($_POST["enviar"])){
            //Conexión con la base de datos
            require('../conexion.php');
            $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);

            //Valores introducidos en el formulario, los recogemos en variables
            $nombre = $_POST['nombre'];
            $icono = $_POST['icono'];
            
            //Consulta preparada para insertar Categorias en la bbdd
            $consulta = $conexion->prepare('INSERT INTO Categorias(nombre,icono) VALUES(?,?)');
            $consulta->bind_param('ss', $nombre,$icono);
            $consulta->execute();

            // Cerrar consulta y conexión
            $consulta->close();
            $conexion->close();
        }
    }
    catch(mysqli_sql_exception $e)
    {
        echo '<p>' . $e->getMessage() . '</p>';
        echo '<p><a href="index.php">Volver</a></p>';
    }
?>