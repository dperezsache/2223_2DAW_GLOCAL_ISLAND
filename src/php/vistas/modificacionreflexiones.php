<!DOCTYPE html>
<html>
    <head>
        <title>MVC en servidor</title>
        <link rel="stylesheet" type="text/css" href="../cruds_categorias/css.css">
    </head>
    <body>
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
        <h1>MODIFICAR REFLEXION</h1>
        
        <form action="../index.php/controladorreflexiones" method="POST" id="fomularioReflexiones">
            <input name="id" type="hidden" value=<?php echo '"'.$parametrosquery["id"].'"'?>>
            <label for="reflexion">Reflexión</label>
            <textarea name="texto" id="reflexion"><?php echo $parametrosquery["texto"] ?></textarea><br>
            <label for="cantPreguntas">Número de preguntas</label>
            <input name="numPreguntas" type="number" min="1" max="5" value=<?php echo '"'.$parametrosquery["numPreguntas"].'"'?>><br>
            <label for="respuesta1">Categoria de reflexion</label>
            <select name="categoria" id="" value=<?php echo '"'.$parametrosquery["categoria"].'"'?>>
            <?php
                if($parametrosquery["nombre"]=="Aire" || $_POST["categoria"]=="1"){
                    echo '<option value="1">Aire</option>';
                    echo'<option value="2">Tierra</option>';
                    echo '<option value="3">Agua</option>';
                }
                if($parametrosquery["nombre"]=="Tierra" || $_POST["categoria"]=="2"){
                    echo'<option value="2">Tierra</option>';
                    echo '<option value="1">Aire</option>';
                    echo '<option value="3">Agua</option>';
                }
                if($parametrosquery["nombre"]=="Agua" || $_POST["categoria"]=="3"){
                    echo '<option value="3">Agua</option>';
                    echo '<option value="1">Aire</option>';
                    echo'<option value="2">Tierra</option>';
                }
            ?>  
            </select>
            <button type="reset">Cancelar</button>
            <button type="submit">Enviar</button>
        </form>
        <div id="footer">
            <p>Glocal Island</p>
        </div>
    </body>
</html>