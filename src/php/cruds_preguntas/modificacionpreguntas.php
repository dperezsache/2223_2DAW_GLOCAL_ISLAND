<?php
    //Comprobar sesión
    session_start();
        
    if(!isset($_SESSION['nombre'])) {
        header('Location: ../../index/html/index.html');
    } 
    $resp=$_GET;
    require_once '../config/conexion.php';
    
    $idSubcategoria=$resp['idSubcategoria'];
    $numPregunta=$resp['numPregunta'];
    $numRespuesta1=$resp['numRespuesta1'];
    $numRespuesta2=$resp['numRespuesta2'];

    /* echo $idSubcategoria;
    echo $numPregunta;
    echo $numRespuesta1;
    echo $numRespuesta2; */
?>
<!-- MODIFICACIÓN -->
<html>
    <head>
		<meta charset="utf-8">
		<meta author="Team Glocal Guadalupe: David Pérez, Juan Manuel Rincón, Laura Merino y Daniel García">
		<title>Glocal Island</title>
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<link rel="stylesheet" type="text/css" href="../cruds_categorias/css.css">
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
        <?php
            //If para hacer la inserción si se pulsa el botón de crear las subcategorías
            if(isset ($_POST["enviarModSubCat"])){
                require_once('../config/conexion.php');
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

        <div id="divModPreguntasRespuestas">
            <h1>MODIFICAR PREGUNTAS Y RESPUESTAS</h1>
            <?php
                require_once('../config/conexion.php');
                $conexionPreguntas = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);
                $consulta="SELECT pregunta,respuesta AS 'respuesta1',correcta, numRespuesta,Categorias.nombre AS 'Cat'
                FROM Preguntas 
                INNER JOIN Subcategorias ON(Preguntas.idSubcategoria=Subcategorias.id)
                INNER JOIN Categorias ON(Subcategorias.idCategoria=Categorias.id)
                INNER JOIN Respuestas ON(Respuestas.numPregunta=Preguntas.numPregunta AND Respuestas.idSubcategoria=Preguntas.idSubcategoria)
                WHERE Respuestas.numRespuesta=1 AND Subcategorias.id=1 AND Respuestas.numPregunta=1";
                $preguntas=$conexionPreguntas->query($consulta);
                $fila=$preguntas->fetch_assoc();
            ?>
            <form id="formModPreguntasRespuestas" method="post">
                <!-- PREGUNTAS -->
                <div>
                    <label for="nuevaPregunta">
                        Pregunta<br/>
                        <textarea id="nuevaPregunta" rows="3" cols="60" required><?php echo $fila['pregunta'];?>
                        </textarea>
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
        <div id="footer">
            <p>Glocal Island</p>
        </div>
        <script type="module" src="../../js/servicios/controladormodificarsub.js"></script>
    </body>
</html>