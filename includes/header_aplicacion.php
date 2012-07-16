<?php /*
Header que se anexa a todas las p�ginas del sistema SIPROI
Obtener datos de la sesi�n
*/
include_once("clases/Usuarios.php");
if(!(isset($_SESSION))){
session_start();
}
//Cerrar automaticamente la sesion
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