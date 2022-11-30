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
                        <a id="liListado">Listado</a>
                    </li>
                    <li>
                        <a id="liCategorias">Categorias</a>
                    </li>
                    <li>
                        <a id="liPreguntas">Preguntas</a>
                    </li>
                    <li>
                        <a id="liCerrarSesion">Cerrar sesión</a>
                    </li>
                <ul>
            </nav>
            <!-- LISTADO -->
            <div id="divListado">

            </div>

            <!-- CRUD CATEGORIAS -->
            <div id="divCategorias">
                <div id="divCrudCategorias">
                    <h1>NUEVA CATEGORIA</h1>
                    <form id="formNuevaCategoria" method="post">
                        <label>Nueva categoria</label>
                        <input id="nuevaCategoria" type="text" name="nombreCat" required><br>
                        <label>Icono</label>
                        <input id="icono" type="text"  name="iconoCat" required><br><br>
                        <label>Nuevas subcategoría</label><br>
                        <input id="subcategoria1" type="text"  name="nombreSubCat[]" required><br>
                        <input id="subcategoria2" type="text"  name="nombreSubCat[]" required><br>
                        <input id="subcategoria3" type="text"  name="nombreSubCat[]" required><br>
                        <button type="reset" name="cancelar">Cancelar</button>
                        <button type="submit" name="enviarCat">Enviar</button>
                    </form>
                </div>
                <?php
                        //If para hacer la inserción si se pulsa el botón de crear las categorías
                        if(isset ($_POST["enviarCat"])){
                            require('../conexion.php');
                            //Conexión con la base de datos
                            $conexion2 = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
                            //Valores introducidos en el formulario, los recogemos en variables
                            $nombre = $_POST['nombreCat'];
                            $icono = $_POST['iconoCat'];
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
                            // Cerrar conexión
                            mysqli_close($conexion2);

                            //Conexión con la base de datos
                            $conexion3 = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
                            
                            $idcategoria = "SELECT id
                            FROM Categorias
                            WHERE nombre='".$nombre."';";
                            $idSacado=mysqli_query($conexion3,$idcategoria);
                            while($fila = $idSacado->fetch_array()){
                                $id=$fila['id'];
                            }
                            
                            //Consulta preparada para insertar subcategorias en la bbdd
                            $consulta3 = $conexion3->prepare('INSERT INTO Subcategorias(nombre,idCategoria) VALUES(?,?)');
                            for($x=0;$x<$length;$x++){
                                $consulta3->bind_param('si', $array_nombres[$x],$id);
                                $consulta3->execute();
                            }

                            // Cerrar conexión
                            mysqli_close($conexion3);
                        }  
                    ?>
                <!-- CRUD SUBCATEGORIAS -->
                <div id="divCrudSubcategorias">
                    <h1>NUEVA SUBCATEGORIA</h1>
                    <form method="post">
                        <label>Nueva subcategoría</label>
                        <input type="text"  name="nombreSubCat" required><br>
                        <label>Categoría</label>
                        <select name="categoria">
                            <?php
                                include('../conexion.php');
                                //Conexión con la base de datos
                                $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);

                                $consulta = 'SELECT nombre
                                FROM Categorias
                                ORDER BY id';

                                $nombres=mysqli_query($conexion,$consulta);
                                $i=1;
                                while($fila = $nombres->fetch_array()){
                                    echo '<option value='.$i.'>'.$fila['nombre'].'</option>';
                                    $i++;
                                }
                                // Cerrar conexión
                                mysqli_close($conexion);
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
                            <?php
                                
                                $conexionListado = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
                                $consultaListado = 'SELECT id,nombre
                                FROM Subcategorias
                                ORDER BY id';

                                $nombresSubcategorias=mysqli_query($conexionListado,$consultaListado);
                                while($fila = $nombresSubcategorias->fetch_array()){
                                    echo '<tr>';
                                        echo '<td>'.$fila['nombre'].'</td>';
                                        echo '<td><a href="modificar.php?id='.$fila['id'].'">M</a>/<a href="borrar.php?id='.$fila['id'].'">B</a></td>';
                                    echo'</tr>';
                                }
                                // Cerrar conexión
                                mysqli_close($conexionListado);
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- CRUD PREGUNTAS -->
            <div id="divPreguntas"></div>
        </div>
        <script type="module" src="../../../js/servicios/controladoradmin.js"></script>
    </body>
</html>
<?php
    //If para hacer la inserción si se pulsa el botón de crear las subcategorías
    if(isset ($_POST["enviarSubCat"])){
        include('../conexion.php');
        //Conexión con la base de datos
        $conexion4 = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
        //Valores introducidos en el formulario, los recogemos en variables
        $nombre = $_POST['nombreSubCat'];
        $categoria = $_POST['categoria'];
        
        //Consulta preparada para insertar Subcategotias en la bbdd
        $consultaSubCat = $conexion4->prepare('INSERT INTO Subcategorias(nombre,idCategoria) VALUES(?,?)');
        $consultaSubCat->bind_param('si', $nombre,$categoria);
        $consultaSubCat->execute();
        
        // Cerrar conexión
        mysqli_close($conexion4);
    }
?>