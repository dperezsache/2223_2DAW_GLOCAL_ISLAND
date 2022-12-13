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

        <div id="eliminarPregunta">
            <h1>¿SEGURO QUE QUIERE ELIMINARLA?</h1>
            <form action="../fachada/fachada.php/controladormodificacion" method="get">
                <!-- BOTONES FORMULARIO -->
                <div>
                    <input class="none" id="idSubcategoria" name="idSubcategoria" value="<?php echo $_GET['idSubcategoria']?>"></input>
                    <input class="none" id="numPregunta" name="numPregunta" value="<?php echo $_GET['numPregunta']?>"></input>
                <a href="../cruds_categorias/index.php"><button type="button">Volver</button></a>
                <button type="submit">Eliminar</button>
                </div>
            </form>
        </div>
        <div id="footer">
            <p>Glocal Island</p>
        </div>
    </body>
</html>
