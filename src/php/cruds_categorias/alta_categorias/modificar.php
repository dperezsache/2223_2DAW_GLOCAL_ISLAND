<!-- MODIFICACIÓN -->
<?php
    $idSubcategoria = $_GET["id"];
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
    <div id="divCategoria">
            <!-- MENU -->
            <nav>
                <ul>
                    <li>
                        <img src="../../../img/logo1.png">
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
                <ul>
            </nav>
            <div id="divCrudSubcategorias">
                <h1>MODIFICAR SUBCATEGORIA</h1>
                <?php echo '<form action="modificar.php?id='.$idSubcategoria.'" method="post">';?>
                    <label>Nuevo nombre</label>
                    <input type="text" name="nombreSubCat"><br>
                    <label>Categoría</label>
                    <select name="categoria">
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
        </div>
        
    </body>
</html>
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