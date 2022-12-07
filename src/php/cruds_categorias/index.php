<?php
    // Comprobar sesión
    session_start();
    
    if(!isset($_SESSION['nombre'])) {
        header('Location: ../../index/html/index.html');
    }
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
                <img src="../../../diseno/Logo/logo1.png" alt="Logo Glocal Island" id="logo" />
            </div>
            <nav>
                <input type="checkbox" id="check" />
                <label for="check" id="btnMenu">
                    <img src="../../../diseno/Logo/menu.png" alt="Icono de menú" />
                </label>
                <ul>
                    <li id="flex0">
                        <img src="../../../diseno/Logo/logo1.png" alt="Logo Glocal Island" id="logo" />
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
        <!-- LISTADO -->
        <div id="divListado"></div>

        <!-- CRUD CATEGORIAS -->
        <div id="divCrudCategorias">
            <h1>NUEVA CATEGORIA</h1>
            <form id="formNuevaCategoria" method="post" enctype="multipart/form-data">
                <label for="nuevaCategoria">Nueva categoria</label>
                <input id="nuevaCategoria" type="text" name="nombreCat" required><br>
                <label for="icono">Icono</label>
                <input id="icono" type="file"  accept="image/png, image/jpeg" name="iconoCat" required><br><br>
                <label for="nuevasSubcategorias">Nuevas subcategorías</label><br>
                <input id="subcategoria1" title="nuevasSubcategorias" placeholder="Subcategoria 1" type="text"  name="nombreSubCat[]" required><br>
                <input id="subcategoria2" title="nuevasSubcategorias" placeholder="Subcategoria 2" type="text"  name="nombreSubCat[]" required><br>
                <input id="subcategoria3" title="nuevasSubcategorias" placeholder="Subcategoria 3" type="text"  name="nombreSubCat[]" required><br>
                <button type="reset">Cancelar</button>
                <button type="submit" id="botonEnviarCategoria" name="enviarCat">Enviar</button>
            </form>
        </div>
        <?php
                //If para hacer la inserción si se pulsa el botón de crear las categorías
                if(isset ($_POST["enviarCat"])){
                    require('../config/conexion.php');
                    //Conexión con la base de datos
                    $conexion2 = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
                    //Valores introducidos en el formulario, los recogemos en variables
                    $nombre = $_POST['nombreCat'];
                    $array_nombres = [];
                    $length = count($_POST["nombreSubCat"]);
                    $x = 0;
                    for($x=0;$x<$length;$x++){
                        $array_nombres[$x]=$_POST["nombreSubCat"][$x];
                    }
                    
                    $nom_archivo = $_FILES['iconoCat']['name'];
                    $ruta = "../../img/subidas_bbdd/".$nom_archivo;
                    $archivo=$_FILES['iconoCat']['tmp_name'];
                    $subir=move_uploaded_file($archivo,$ruta);

                    //Consulta preparada para insertar Categorias en la bbdd
                    $consulta2 = $conexion2->prepare('INSERT INTO Categorias(nombre,icono) VALUES(?,?)');
                    $consulta2->bind_param('ss', $nombre,$ruta);
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
            <form method="post" action="modificarIcono.php">
                <label>Las Categorías ya están credas</label><br>
                <label>Pulsa si quieres modificar iconos de categorías</label><br>
                <select name="IconoCategoria">
                    <?php
                        include('../config/conexion.php');
                        //Conexión con la base de datos
                        $conexionSUB = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);

                        $consultaSUB = 'SELECT nombre
                        FROM Categorias
                        ORDER BY id';

                        $nombres=mysqli_query($conexionSUB,$consultaSUB);
                        $i=1;
                        while($fila = $nombres->fetch_array()){
                            echo '<option value="'.$i.'">'.$fila['nombre'].'</option>';
                            $i++;
                        }
                        // Cerrar conexión
                        mysqli_close($conexionSUB);
                    ?>
                </select>
                <button type="submit"  name="enviarSubCat">Enviar</button>
            </form>
            <h1>CREAR SUBCATEGORIA</h1>
            <form method="post">
                <label for="nuevaSubcategoria">Nueva subcategoría</label>
                <input id="nuevaSubcategoria" type="text"  name="nombreSubCat" required><br>
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria">
                    <?php
                        include('../config/conexion.php');
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
            <?php
                //If para hacer la inserción si se pulsa el botón de crear las subcategorías
                if(isset ($_POST["enviarSubCat"])){
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
        <!-- CRUD PREGUNTAS -->
        <div id="divPreguntas"></div>
        <!-- REFLEXIONES -->
        <div id="divReflexiones">
            <form action="../../php/index.php/controladorreflexiones" method="POST">
                <label for="reflexion">REFLEXION</label>
                <textarea name="reflexion"></textarea><br>
                <label for="cantPreguntas">Cantidad de preguntas fallidas</label>
                <input name="cantPreguntas" type="number" min="1" max="5"><br>
                <label for="respuesta1">Categoria de reflexion</label>
                <select name="categoria" id="">
                    <option value="1">Aire</option>
                    <option value="2">Tierra</option>
                    <option value="3">Agua</option>
                </select><br><br>
                <button type=submit>Enviar</button>
            </form>
        </div>
        <script type="module" src="../../js/servicios/controladoradmin.js"></script>
    </body>
</html>