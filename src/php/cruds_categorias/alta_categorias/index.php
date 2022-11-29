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
            <!-- LISTADO -->
            <div id="divListado"></div>

            <!-- CRUD CATEGORIAS -->
            <div id="divCrudCategorias">
                <h1>NUEVA CATEGORIA</h1>
                <form method="post">
                    <label>Nueva categoria</label>
                    <input type="text" name="nombreCat" required><br>
                    <label>Icono</label>
                    <input type="text"  name="iconoCat" required><br><br>
                    <label>Nuevas subcategoría</label><br>
                    <input type="text"  name="nombreSubCat[]" required><br>
                    <input type="text"  name="nombreSubCat[]" required><br>
                    <input type="text"  name="nombreSubCat[]" required><br>
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
                            include('../conexion.php');
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

                        ?>
                    </select><br>
                    <button type="reset">Cancelar</button>
                    <button type="submit"  name="enviarSubCat">Enviar</button>
                </form>
                <h1>SUBCATEGORIAS</h1>
                <table>
                    <thead>
                        <tr>
                            <th>
                                Nombre
                            </th>
                            <th>
                                Opciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Categoria1</td>
                            <td>B/D</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- MODIFICACIÓN -->
            <div id="divCrudSubcategorias">
                <h1>MODIFICAR SUBCATEGORIA</h1>
                <form>
                    <label>Nuevo nombre</label>
                    <input type="text"><br>
                    <label>Categoría</label>
                    <select>
                        <option></option>
                    </select><br>
                    <button type="reset">Cancelar</button>
                    <button type="submit">Enviar</button>
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
            //Conexión con la base de datos
            $conexion2 = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
            //Valores introducidos en el formulario, los recogemos en variables
            $nombre = $_POST['nombreCat'];
            $icono = $_POST['iconoCat'];
            /*var_dump($_POST);*/
            $array_nombres = [];
            $length = count($_POST["nombreSubCat"]);
            $x = 0;
            for($x=0;$x<$length;$x++){
                $array_nombres[$x]=$_POST["nombreSubCat"][$x];
            }
            

            //Consulta preparada para insertar Categorias en la bbdd
            $consulta2 = $conexion2->prepare('INSERT INTO Categorias(nombre,icono) VALUES(?,?)');
            $consulta2->bind_param('ss', $nombre,$icono);
            $consulta2->execute();

            //Conexión con la base de datos
            $idcategoria = "SELECT id
            FROM Categorias
            WHERE nombre='".$nombre."';";
            $idSacado=mysqli_query($conexion2,$idcategoria);
            while($fila = $idSacado->fetch_array()){
               $id=$fila['id'];
            }
            
            //Consulta preparada para insertar subcategorias en la bbdd
            $consulta3 = $conexion2->prepare('INSERT INTO Subcategorias(nombre,idCategoria) VALUES(?,?)');
            for($x=0;$x<$length;$x++){
                $consulta3->bind_param('si', $array_nombres[$x],$id);
                $consulta3->execute();
            }
            
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