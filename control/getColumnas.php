<?php
/*
 * Control getColumnas
 * Se recibe la peticion por AJAX para obtener los valores de los atributos par filtrar.
 */
include "../clases/Usuarios.php";
session_start();
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision" 
		|| $usuariologueado->getTipo()=="captura" || $usuariologueado->getTipo()=="analisis"  )) {
	$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta página.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: ../error.php");	
} else {
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$array="";
if(isset($_POST["columna"])){
	$sql=sprintf("SELECT %s FROM v%s GROUP BY %s", mysql_real_escape_string($_POST["columna"])
			,mysql_real_escape_string($_POST["tabla"]), mysql_real_escape_string($_POST["columna"]));
	
} else {
	$sql=sprintf("SELECT * FROM %s", mysql_real_escape_string($_POST["tabla"]));	
}
$result = mysql_query($sql);
	if (!$result) {
						die('No se pudo realizar la consulta:' . mysql_error());
						header("Location: ../bienvenido.php");
					} else {
						header("Content-Type: text/html; charset=iso-8859-1");
							echo "<option value='' disabled='disabled' selected=selected>Selecciona el valor</option>";
							while ($data = mysql_fetch_array($result)) {
								if(isset($_POST["columna"])){									
									echo "<option value='".$data[0]."'>".$data[0]."</option>";
								} else {
									echo "<option value='".$data[1]."'>".$data[1]."</option>";
								}							
							}						
					}
}
?>