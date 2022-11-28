<html>
    <head>
		<meta charset="utf-8">
		<meta author="Team Glocal Guadalupe: David Pérez, Juan Manuel Rincón, Laura Merino y Daniel García">
		<title>Glocal Island</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css.css">
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
                    <input type="text" name="nombreCat" required><br>
                    <label>Icono</label>
                    <input type="text"  name="iconoCat" required><br>
                    <button type="submit" name="enviarCat">Enviar</button>
                </form>
            </div>

            <!-- CRUD SUBCATEGORIAS -->
            <div id="divCrudSubcategorias">
                <h1>NUEVA SUBCATEGORIA</h1>
                <form method="post">
                    <label>Nueva subcategoría</label>
                    <input type="text"  name="nombreSubCat" required><br>
                    <label>Categoría</label>
                    <select name="categoria">
                        <?php
                            //Conexión con la base de datos
                            require('../conexion.php');
                            $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);

                            $consulta = 'SELECT nombre
                            FROM Categorias
                            ORDER BY id';

                            $nombres=mysqli_query($conexion,$consulta);
                            $i=2;
                            while($fila = $nombres->fetch_array()){
                                echo '<option value='.$i.'>'.$fila['nombre'].'</option>';
                                $i++;
                            }

                            /*// Cerrar consulta y conexión
                            $consulta->close();
                            $conexion->close();*/
                        ?>
                    </select><br>
                    <button type="reset">Cancelar</button>
                    <button type="submit"  name="enviarSubCat">Enviar</button>
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
        //If para hacer la inserción si se pulsa el botón de crear las categorías
        if(isset ($_POST["enviarCat"])){

            //Valores introducidos en el formulario, los recogemos en variables
            $nombre = $_POST['nombreCat'];
            $icono = $_POST['iconoCat'];
            
            //Consulta preparada para insertar Categorias en la bbdd
            $consulta = $conexion->prepare('INSERT INTO Categorias(nombre,icono) VALUES(?,?)');
            $consulta->bind_param('ss', $nombre,$icono);
            $consulta->execute();

            // Cerrar consulta y conexión
            $consulta->close();
            $conexion->close();
        }
        //If para hacer la inserción si se pulsa el botón de crear las subcategorías
        if(isset ($_POST["enviarSubCat"])){
    
            //Valores introducidos en el formulario, los recogemos en variables
            $nombre = $_POST['nombreSubCat'];
            $categoria = $_POST['categoria'];
            
            //Consulta preparada para insertar Subcategotias en la bbdd
            $consulta = $conexion->prepare('INSERT INTO Subcategorias(nombre,idCategoria) VALUES(?,?)');
            $consulta->bind_param('si', $nombre,$categoria);
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