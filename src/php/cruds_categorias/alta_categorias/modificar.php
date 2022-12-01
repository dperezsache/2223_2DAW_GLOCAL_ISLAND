<!-- MODIFICACIÓN -->
<?php
    $idSubcategoria = $_GET["id"];
    include('../conexion.php');
    //Conexión con la base de datos
    $conexionNombre = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);

    $consultaNombre = 'SELECT nombre,idCategoria
    FROM Subcategorias
    WHERE id='.$idSubcategoria.'';

    $nombres=mysqli_query($conexionNombre,$consultaNombre);
    while($fila = $nombres->fetch_array()){
        $nombreSubCategoria = $fila['nombre'];
    }
    // Cerrar conexión
    mysqli_close($conexionNombre);
?>

<html>
    <head>
		<meta charset="utf-8">
		<meta author="Team Glocal Guadalupe: David Pérez, Juan Manuel Rincón, Laura Merino y Daniel García">
		<title>Glocal Island</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" type="text/css" href="css.css">
		<link rel="shotcut icon" href="../../../img/logo.png">
	</head>
    <body>
        <!-- MENU -->
        <header>
            <div class="logo">
                <img src="../../../../diseño/Logo/logo1.png" alt="Logo Glocal Island" id="logo" />
            </div>
            <nav>
                <input type="checkbox" id="check" />
                <label for="check" id="btnMenu">
                    <img src="../../../../diseño/Logo/menu.png" alt="Icono de menú" />
                </label>
                <ul>
                    <li id="flex0">
                        <img src="../../../../diseño/Logo/logo1.png" alt="Logo Glocal Island" id="logo" />
                    </li>
                    <li >
                        <a class="opciones" id="liListado">Listado</a>
                    </li>
                    <li >
                        <a class="opciones" id="liCategorias">Categorías</a>
                    </li>
                    <li >
                        <a class="opciones" id="liReflexiones">Reflexiones</a>
                    </li>
                    <li >
                        <a class="opciones" id="liPreguntas">Preguntas</a>
                    </li>
                    <li id="flex1">
                        <a class="opciones" id="liCerrarSesion">Cerrar sesión</a>
                    </li>
                </ul>
            </nav>
        </header>
        <div id="divModSubcategorias">
            <h1>MODIFICAR SUBCATEGORIA</h1>
            <?php echo '<form action="modificar.php?id='.$idSubcategoria.'" method="post">';?>
                <label for="modNombre">Subactegoría</label>
                <?php echo'<input id="modNombre" type="text" value='.$nombreSubCategoria.' name="nombreSubCat" required>';?><br>
                <label for="modCat">Categoría</label>
                <select id="modCat" name="categoria">
                    <?php
                        include('../conexion.php');
                        //Conexión con la base de datos
                        $conexionCategoria = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);

                        $consultaMod = 'SELECT nombre
                        FROM Categorias
                        ORDER BY id';

                        $nombres=mysqli_query($conexionCategoria,$consultaMod);
                        $i=1;
                        while($fila = $nombres->fetch_array()){
                            echo '<option value='.$i.'>'.$fila['nombre'].'</option>';
                            $i++;
                        }
                        // Cerrar conexión
                        mysqli_close($conexionCategoria);
                    ?>
                </select><br>
                <button type="reset">Cancelar</button>
                <button type="submit" name="enviarModSubCat">Enviar</button>
            </form>
        </div>
        <?php
            //If para hacer la inserción si se pulsa el botón de crear las subcategorías
            if(isset ($_POST["enviarModSubCat"])){
                $idSubcategoria = $_GET["id"];
                //Conexión con la base de datos
                $conexion2 = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
                //Valores introducidos en el formulario, los recogemos en variables
                $nombre = $_POST['nombreSubCat'];
                $categoria = $_POST['categoria'];
                
                //Consulta preparada para insertar Subcategotias en la bbdd
                $sql = 'UPDATE Subcategorias SET nombre="'.$nombre.'",idCategoria="'.$categoria.'" WHERE id='.$idSubcategoria.';';
                $resultado=$conexion2->query($sql);
                echo'Modificado con éxito';
                echo'<a href="index.php">Volver</a>';
                // Cerrar conexión
                mysqli_close($conexion2);
            }
        ?>
        <div id="footer">
            <p>Glocal Island</p>
        </div>
    </body>
</html>
