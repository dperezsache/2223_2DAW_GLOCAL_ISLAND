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
            if (isset($error)){
                echo '<div> Esto es un asco</div>';
            }
        ?>
        <div id="divModPreguntasRespuestas">
            <h1>MODIFICAR PREGUNTAS Y RESPUESTAS</h1>
            <form id="formModPreguntasRespuestas" action="../fachada/fachada.php/controladormodificacion" method="post" enctype="multipart/form-data">
                <!-- PREGUNTAS -->
                <div>
                    <label for="nuevaPregunta">Pregunta<br/>
                        <textarea id="nuevaPregunta" name="nuevaPregunta" rows="3" cols="60" required><?php echo $_GET['pregunta'];?></textarea>
                    </label>
                    <input name="numPregunta" id="numPregunta" value="<?php echo $_GET['numPregunta']?>">
                </div>
                <div>
                    <label for="categoriaPregunta">
                        Categoría de la pregunta
                        <select id="categoriaPregunta" name="categoriaPregunta">
                            <?php 
                                require_once('../modelos/modelopreguntas.php');
                                $modeloPreguntas=new ModeloPreguntas();
                                $subcategoria=$modeloPreguntas->sacarSubcategoria($_GET['idSubcategoria']);
                                while($fila = $subcategoria->fetch_assoc()){
                                    echo "<option value=".$_GET['idSubcategoria'].">".$fila['nombre']."</option>";
                                }
                            ?>
                        </select>
                    </label>
                </div>
                <div>            
                    <label for="imagenPregunta">Imagen</label>
                    <input type="file" id="imagenPregunta" name="imagenPregunta" value="Adjuntar imagen" accept="image/png, image/jpeg"/><br/>
                </div>
                <hr/>
                <!-- RESPUESTAS -->
                <fieldset>
                    <div>
                        <label for="primeraRespuesta">
                            Respuesta uno <input id="primeraRespuesta" name="primeraRespuesta" type="text" maxlength="300" required value="<?php echo $_GET['respuesta1'];?>"/>
                        </label>
                        <label class="textoCorrectas" for="btnCorrecta1">
                            <?php 
                                if($_GET['correcta']=='respuesta1'){
                                    echo ' ¿Es la correcta? <input type="radio" id="btnCorrecta" name="btnCorrecta" required checked="checked"/>';
                                }
                                else{
                                    echo '¿Es la correcta? <input type="radio" id="btnCorrecta" name="btnCorrecta" required/>';
                                }
                            ?>
                        </label>
                    </div>
                </fieldset>

                <fieldset>
                    <legend></legend>
                    <div>
                        <label for="segundaRespuesta">
                            Respuesta dos <input id="segundaRespuesta" name="segundaRespuesta" type="text" maxlength="300" required value="<?php echo $_GET['respuesta2'];?>"/>
                        </label>
                        <label class="textoCorrectas" for="btnCorrecta2">
                            <?php
                            if($_GET['correcta']=='respuesta2'){
                                echo '¿Es la correcta? <input type="radio" id="btnCorrecta" name="btnCorrecta" required checked="checked"/>';
                            }
                            else{
                                echo '¿Es la correcta? <input type="radio" id="btnCorrecta" name="btnCorrecta" required/>';
                            }
                            ?>
                        </label>
                    </div>
                </fieldset>
                <div><p>*Recuerda que las respuestas no pueden ser iguales. Sino, la modificación no se hará.</p></div>
                <!-- BOTONES FORMULARIO -->
                <div>
                <a href="../cruds_categorias/index.php"><button type="button">Cancelar</button></a>
                    <button type="submit">Enviar</button>
                </div>
            </form>
        </div>
        <div id="footer">
            <p>Glocal Island</p>
        </div>
    </body>
</html>
