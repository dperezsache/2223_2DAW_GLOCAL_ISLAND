<html id="htmlClasificaciones" xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="es">
    <head>
		<meta charset="utf-8"/>
		<meta author="Team Glocal Guadalupe: David Pérez, Juan Manuel Rincón, Laura Merino y Daniel García"/>
		<title>Glocal Island</title>
		<meta name="viewport" content="width=device-width,initial-scale=1"/>
		<link rel="stylesheet" type="text/css" href="css.css"/>
		<link rel="shortcut icon" href="../../../diseno/Logo/logo2.png"/>
	</head>
    <body id="bodyClasificaciones">
        <header id="cabecera">
            <div id="logo">
                <a href="../../index/html/index.html"><img src="../../../diseno/Logo/logo2.png" alt="Logo Glocal Island"/></a>
            </div>
            <h1>CLASIFICACIONES JUGADORES</h1>
        </header>
        <div id="divClasificaciones">
            <table id="tablaClasificaciones">
                <thead>
                    <tr>
                        <th>Posición</th>
                        <th>Alias del jugador</th>
                        <th class="soloDesktop">Fecha partida</th>
                        <th>Puntuación</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        require('../config/conexion.php');
                        $conexion = new mysqli(SERVIDOR, USUARIO, CONTRASENIA, BD);

                        $consulta = 'SELECT *
                        FROM Clasificacion
                        ORDER BY puntuacion desc
                        LIMIT 5' ;
                        $i=1;
                        $tablaRanking=$conexion->query($consulta);
                        while($fila = $tablaRanking->fetch_array()){
                            echo '<tr>';
                                echo '<td>'.$i.'º</td>';
                                echo '<td class="aliasTexto">'.$fila['alias'].'</td>';
                                echo '<td class="soloDesktop">'.$fila['fechaHora'].'</td>';
                                echo '<td>'.$fila['puntuacion'].'</td><br><br>';
                                $i++;
                            echo '</tr>';
                        }
                    ?>
                </tbody>
            </table>
            <div id="logo2">
                <a href="../../index/html/index.html"><img src="../../../diseno/Logo/logo2.png" alt="Logo Glocal Island"/></a>
            </div>
        </div>
        <footer id="footerClasificaciones">
            <p>GLOCAL ISLAND © 2022<p>
        </footer>
    </body>
</html>