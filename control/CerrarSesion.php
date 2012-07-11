<?php
/*
 * Control cerrar sesion
 * Se dstruye la sesion y se redirige a la pagina de inicio de sesion.
 */ 
session_start();
session_destroy();
header("Location: ../index.php");
?>
