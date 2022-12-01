<!-- MODIFICACIÓN -->
<?php
    $idCategoria = $_POST["IconoCategoria"];
    include('../conexion.php');
    //Conexión con la base de datos
    $conexionIconos = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);

    $consultaNombre = 'SELECT nombre,icono
    FROM Categorias
    WHERE id="'.$idCategoria.'"';

    $nombres=mysqli_query($conexionIconos,$consultaNombre);
    while($fila = $nombres->fetch_array()){
        $nombreCategoria = $fila['nombre'];
        $iconoCategoria = $fila['icono'];
    }
    // Cerrar conexión
    mysqli_close($conexionIconos);
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
            <h1>MODIFICAR ICONOS</h1>
            <?php echo '<form action="modificarIcono.php" method="post" enctype="multipart/form-data">';?>
                <label>Nombre Categoría</label>
                <?php echo'<input id="modNombre" type="text" value='.$nombreCategoria.' name="nombreCat" readonly>';?>
                <?php echo'<input id="desaparecido" type="text" value='.$idCategoria.'  name="IconoCategoria" readonly>';?><br>
                <?php echo'<img src="'.$iconoCategoria.'">'?><br>
                <label>Icono</label>
                <input type="file"   accept="image/png, image/jpeg" name="iconoCat" required><br><br>
                <br>
                <button type="submit" name="enviarModIcon">Enviar</button>
            </form>
        </div>
        <?php
            //If para hacer la inserción si se pulsa el botón de crear las subcategorías
            if(isset ($_POST["enviarModIcon"])){
                $idCategoria = $_POST["IconoCategoria"];
                //Conexión con la base de datos
                $conexion2 = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
                
                $consultaAntique = 'SELECT icono
                FROM Categorias
                WHERE id="'.$idCategoria.'"';

                $nombres=mysqli_query($conexion2,$consultaAntique);
                while($fila = $nombres->fetch_array()){
                    $iconoCatAntique = $fila['icono'];
                }

                $nom_archivo = $_FILES['iconoCat']['name'];
                $ruta = "../../../img/subidas_bbdd/".$nom_archivo;
                $archivo=$_FILES['iconoCat']['tmp_name'];
                $subir=move_uploaded_file($archivo,$ruta);
                unlink(realpath($iconoCatAntique));

                //Consulta preparada para insertar Categorias en la bbdd
                $consulta2 = 'UPDATE Categorias SET icono="'.$ruta.'" WHERE id='.$idCategoria.';';
                $resultado=$conexion2->query($consulta2);
                echo'Modificado con éxito';
                echo'<br><br><a href="index.php">Volver</a>';
                // Cerrar conexión
                mysqli_close($conexion2);
            }
        ?>
        <div id="footer">
            <p>Glocal Island</p>
        </div>
    </body>
</html>