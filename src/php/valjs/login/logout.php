<?php
    session_start();
    session_unset();    // Liberar la variable $_SESSION.
    session_destroy();  // Destruye los datos de conexión almacenados.
    header('Location: index.php');
?>