<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8' />
        <title>MVC en servidor</title>
    </head>
    <body>
        <h1>MODIFICAR REFLEXION</h1>
        <form action="../index.php/controladorreflexiones" method="POST" id="fomularioReflexiones">
            <input name="id" type="hidden" value=<?php echo '"'.$parametrosquery["id"].'"'?>>
            <label for="reflexion">Reflexión</label>
            <textarea name="reflexion" id="reflexion"><?php echo $parametrosquery["texto"] ?></textarea><br>
            <label for="cantPreguntas">Número de preguntas</label>
            <input name="cantPreguntas" type="number" min="1" max="5" value=<?php echo '"'.$parametrosquery["numPreguntas"].'"'?>><br>
            <label for="respuesta1">Categoria de reflexion</label>
            <select name="categoria" id="" value=<?php echo '"'.$parametrosquery["categoria"].'"'?>>
                <option value="1">Aire</option>
                <option value="2">Tierra</option>
                <option value="3">Agua</option>
            </select>
            <button type="reset">Cancelar</button>
            <button type="submit">Enviar</button>
        </form>
    </body>
</html>