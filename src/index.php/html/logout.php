<?php
    session_start();
    session_unset();    // Liberar la variable $_SESSION.
    session_destroy();  // Destruye los datos de sesión almacenados.
    header('Location: indexLogin.php');
?>