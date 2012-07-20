<?php
/*
 * Control getPunto
 * Se recibe la peticion por AJAX para obtener los tipos de puntos de afluencia, la informacion
 * y los puntos de acuerdo a un tipo.
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
if(isset($_POST["accion"]) && $_POST["accion"]=="registro"){						//Obtener info de puntos en registro de proyectos
	$tipo = $_POST["tipo"]; 							//El tipo de punto (hospital, centro...)
	$numero = $_POST["numero"];							//El numero de punto en la forma a desplegar
	$sql="SELECT * FROM puntosafluencia WHERE tipo = '".$tipo."'";
} else if(isset($_POST["accion"]) && $_POST["accion"]=="tipos"){					//Obtener info de puntos en registro de proyectos
	$numero = $_POST["numero"];							//El numero de punto en la forma a desplegar
	$sql="SELECT * FROM puntosafluencia GROUP BY tipo ASC";
}else {													//Obtener info de puntos en registro de proyectos
$id=$_POST["id"];
$sql="SELECT * FROM puntosafluencia WHERE idpuntosAfluencia = '".$id."'";
}
$result = mysql_query($sql);
	if (!$result) {
						die('No se pudo realizar la consulta:' . mysql_error());
						header("Location: ../bienvenido.php");
					} else {
						header("Content-Type: text/html; charset=iso-8859-1");
						if(isset($_POST["accion"]) && $_POST["accion"]=="registro"){//Obtener el select de los puntos de acuerdo al tipo
							echo "<select class='span2' id='selectPunto' name='puntoAfluencia".$numero."' >
							<option value=''>Seleccione un punto</option>";
							while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
								echo "<option value='".$data["idpuntosAfluencia"]."'>".$data["nombre"]."</option>";							
							}
							echo "</select>";
						} else if(isset($_POST["accion"]) && $_POST["accion"]=="tipos"){ //Obtener el select de los tipos
							echo "<select class='span2' id='".$numero."' onchange='desplegarPuntos(this.value, this.id)'>
							<option value=''>Seleccione un tipo</option>";
							while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
								echo "<option value='".$data["tipo"]."'>".$data["tipo"]."</option>";							
							}
							echo "</select>";
						} else  { //Obtener datos de puntos
						$data = mysql_fetch_array($result);
						$array = $data["nombre"].",".$data["tipo"].",".$data["logo"] ;
						echo $array;				
					}
					}
}
?>