<?php /*
Header que se anexa a todas las páginas del sistema SIPROI
Obtener datos de la sesión
*/
include_once("clases/Usuarios.php");
//Cerrar automaticamente la sesion
if(!isset($_SESSION["earth"])){
session_start();
}
$t = time();
$t0 = $_SESSION['time'];
$diff = $t - $t0;
if ($diff > 1800 || !ISSET ($t0)) {          //Cerrar sesion despues de 30 mins o inicio ilegal
	session_unset();
	session_destroy();
	Header ('Location: index.php');
	exit;
}
else {
	$_SESSION['time'] = time();
}
 // Obtener el objeto usuario, si es null redirige a inicio 
 include 'header1.php';
 if(isset($_SESSION["earth"]) && $_SESSION["earth"]=="earth"){
 	include "header_earth.html";
 }
 include "style_bienvenido.html";
 include "hero_unit.html";
 include "header2.php";
 $usuario = new Usuarios();
 $usuario = $_SESSION["usuario"];
 //Verificar el tipo de usuario 
  if($usuario->getTipo() == "administrador") {
  include "navbar_admin.php";
  } else if ($usuario->getTipo()=="revision") {
  include "navbar_revision.php";
  } else if ($usuario->getTipo()=="captura") {
  include "navbar_captura.php";
  } else if ($usuario->getTipo()=="analisis") {
  include "navbar_analisis.php";
  } else { 
  include "navbar_cliente.php";
 } 
?>