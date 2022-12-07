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
        <div id="divListado">
            <h1>LISTADO DE PREGUNTAS</h1>
            <table>
                <thead>
                    <tr>
                        <th scope="col">Categoría</th>
                        <th scope="col">Pregunta</th>
                        <th scope="col">Respuesta 1</th>
                        <th scope="col">Respuesta 2</th>
                        <th scope="col">Resp. correcta</th>
                        <th scope="col">Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require_once('../config/conexion.php');
                        $conexionPreguntas = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
                        $consultaPreguntas = "SELECT pregunta,respuesta AS 'respuesta1',correcta, numRespuesta,Categorias.nombre AS 'Cat'
                        FROM Preguntas 
                        INNER JOIN Subcategorias ON(Preguntas.idSubcategoria=Subcategorias.id)
                        INNER JOIN Categorias ON(Subcategorias.idCategoria=Categorias.id)
                        INNER JOIN Respuestas ON(Respuestas.numPregunta=Preguntas.numPregunta AND Respuestas.idSubcategoria=Preguntas.idSubcategoria)
                        WHERE Respuestas.numRespuesta=1";

                        $preguntas=$conexionPreguntas->query($consultaPreguntas);
                        while($fila = $preguntas->fetch_assoc()){
                            echo '<tr>';
                                echo '<td data-titulo="Categoria">'.$fila['Cat'].'</td>';
                                echo '<td data-titulo="Pregunta">'.$fila['pregunta'].'</td>';
                                echo '<td data-titulo="Resp1">'.$fila['respuesta1'].'</td>';

                                $consultaRespuesta= "SELECT pregunta,respuesta, S.id, Respuestas.numPregunta, numRespuesta FROM Preguntas 
                                INNER JOIN Subcategorias S ON(Preguntas.idSubcategoria=S.id)
                                INNER JOIN Categorias ON(S.idCategoria=Categorias.id)
                                INNER JOIN Respuestas ON(Respuestas.numPregunta=Preguntas.numPregunta AND Respuestas.idSubcategoria=Preguntas.idSubcategoria)
                                WHERE Respuestas.numRespuesta=2 AND Preguntas.pregunta='".$fila['pregunta']."';";
                                $respuesta=$conexionPreguntas->query($consultaRespuesta);
                                while($resp = $respuesta->fetch_assoc()){
                                    $respuesta2=$resp['numRespuesta'];
                                    $idSubcategoria=$resp['id'];
                                    $numpregunta=$resp['numPregunta'];
                                    echo '<td data-titulo="Resp2">'.$resp['respuesta'].'</td>';
                                }

                                if($fila['correcta']==1){
                                    echo '<td data-titulo="Resp. correcta">respuesta1</td>';
                                }
                                else{
                                    echo '<td data-titulo="Resp. correcta">respuesta2</td>';
                                }
                                echo '<td data-titulo="Opciones"><a href="../cruds_preguntas/modificacionpreguntas.php?idSubcategoria='.$idSubcategoria.'&numPregunta='.$numpregunta.'&numRespuesta1='.$fila['numRespuesta'].'&numRespuesta2='.$respuesta2.'">✎</a>/<a href="../cruds_preguntas/borrarpregunta.php?id='.$fila['pregunta'].'">🗑</a></td>';
                            echo'</tr>';
                        }
                        // Cerrar conexión
                        mysqli_close($conexionPreguntas);
                    ?>
                </tbody>
            </table>
        </div>

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
                                echo '<td><a href="modificar.php?id='.$fila['id'].'">✎</a>/<a href="borrar.php?id='.$fila['id'].'">🗑</a></td>';
                            echo'</tr>';
                        }
                        // Cerrar conexión
                        mysqli_close($conexionListado);
                    ?>
                </tbody>
            </table>
        </div>
        <!-- CRUD PREGUNTAS -->
        <div id="divCrudPreguntasRespuestas">
        <h1>CREAR PREGUNTA & RESPUESTAS</h1>
            <form id="formPreguntasRespuestas" method="post">
                <!-- PREGUNTAS -->
                <div>
                    <label for="nuevaPregunta">
                        Pregunta<br/>
                        <textarea id="nuevaPregunta" rows="3" cols="60" required></textarea>
                    </label>
                </div>
                <div>
                    <label for="categoriaPregunta">
                        Categoría de la pregunta
                        <select id="categoriaPregunta">
                            <option>Agua</option>
                            <option>Tierra</option>
                            <option>Aire</option>
                        </select>
                    </label>
                </div>
                <div>            
                    <label for="imagenPregunta">Imagen</label>
                    <input type="file" id="imagenPregunta" value="Adjuntar imagen" accept="image/png, image/jpeg" required/><br/>
                </div>
                <hr/>
                <!-- RESPUESTAS -->
                <fieldset>
                    <legend></legend>
                    <div>
                        <label for="primeraRespuesta">
                            Respuesta uno <input id="primeraRespuesta" type="text" maxlength="300" required/>
                        </label>
                        <label class="textoCorrectas" for="btnCorrecta1">
                            ¿Es la correcta? <input type="radio" id="btnCorrecta1" name="btnCorrecta" required/>
                        </label>
                    </div>
                </fieldset>

                <fieldset>
                    <legend></legend>
                    <div>
                        <label for="segundaRespuesta">
                            Respuesta dos <input id="segundaRespuesta" type="text" maxlength="300" required/>
                        </label>
                        <label class="textoCorrectas" for="btnCorrecta2">
                            ¿Es la correcta? <input type="radio" id="btnCorrecta2" name="btnCorrecta" required/>
                        </label>
                    </div>
                </fieldset>

                <!-- BOTONES FORMULARIO -->
                <div>
                    <button type="reset">Cancelar</button>
                    <button type="submit">Enviar</button>
                </div>
            </form>
        </div>

        <div id="divReflexiones">
        <h1>CREAR REFLEXION</h1>
            <form>
                <label for="reflexion">Reflexión</label>
                <textarea name="reflexion" id="reflexion"></textarea><br>
                <label for="numPreguntas">Número de preguntas</label>
                <select id="numPreguntas">
                    <option>1</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                    <option>6</option>
                    <option>7</option>
                    <option>8</option>
                    <option>9</option>
                    <option>10</option>
                </select><br>
                <button type="reset">Cancelar</button>
                <button type="submit">Enviar</button>
            </form>
        </div>
        <script type="module" src="../../js/servicios/controladoradmin.js"></script>
    </body>
</html>