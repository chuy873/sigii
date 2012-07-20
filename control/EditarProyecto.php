<?php
/*
 * Control Editar Proyecto
* Se permite editar campos del proyecto horizontal y vertical y registrar los cambios en la DB
*/
//Verificar si el usuario tiene acceso
include "../clases/Usuarios.php";
session_start();
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || ($usuariologueado->getTipo()=="revision")
		)) {
	$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta página.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: ../error.php");	
} else {
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$idproyecto=$_POST["id"];
//datos basicos
$tipo=$_POST["tipo"];
$nombre=$_POST["nombre"];
$promotor=$_POST["promotor"];
$telefono=$_POST["telefono"];
$inicioVentas=$_POST["inicioVentas"];
$fechaRevision=$_POST["fechaRevision"];
$etapa=$_POST["etapa"];
$nombreEtapa=$_POST["nombreEtapa"];
$descripcion=$_POST["descripcion"];
$amenidadesDescripcion=$_POST["amenidadesDescripcion"];
$caracteristicas=$_POST["caracteristicas"];
$link=$_POST["link"];
$numeroModelos=$_POST["numeroModelos"];
$segmento=$_POST["segmento"];
//datos numericos
$unidadesEtapa=$_POST["unidadesEtapa"];
$unidadesTotales=$_POST["unidadesTotales"];
$unidadesVendidas=$_POST["unidadesVendidas"];
$vendidas1Q=$_POST["vendidas1Q"];
$vendidas2Q=$_POST["vendidas2Q"];
$vendidas3Q=$_POST["vendidas3Q"];
$vendidas4Q=$_POST["vendidas4Q"];
$llamadasSeguimiento=$_POST["llamadasSeguimiento"];
$tiempoMercado=$_POST["tiempoMercado"];
if($tipo=="vertical"){	
$pisos=$_POST["pisos"];
$torres=$_POST["torres"];
}
//imagenes
if(verificarTamañoYTipo("logoProyecto")){
	$logoProyecto=$_FILES["logoProyecto"]["name"];	 
} 
if(verificarTamañoYTipo("lotificacion")){
	$lotificacion= $_FILES["lotificacion"]["name"];
}
if(verificarTamañoYTipo("previaTorre")){
	$previaTorre= $_FILES["previaTorre"]["name"];
}
if(verificarTamañoYTipo("imagenAmenidad1")){
	$imagenAmenidad1= $_FILES["imagenAmenidad1"]["name"];
}
if(verificarTamañoYTipo("imagenAmenidad2")){
	$imagenAmenidad2=$_FILES["imagenAmenidad2"]["name"];
}
if(verificarTamañoYTipo("imagenAmenidad3")){
	$imagenAmenidad3= $_FILES["imagenAmenidad3"]["name"];
}
if(verificarTamañoYTipo("imagenAmenidad4")){
	$imagenAmenidad4= $_FILES["imagenAmenidad4"]["name"];	 
}
//ubicacion
$colonia=$_POST["colonia"];
$municipio=$_POST["municipio"];
$ciudad=$_POST["ciudad"];
$subzona=$_POST["subzona"];
$contPuntos=$_POST["contPuntos"];
$i=1;
$puntosAfluencia[][2]="";
while ($i <= $contPuntos){
$puntosAfluencia[($i-1)][0]=$_POST["puntoAfluencia".$i];
$puntosAfluencia[($i-1)][1]=$_POST["distanciaAfluencia".$i];
$i++;
}
//pendiente google earth
//amenidades
$amenidades=$_POST["amenidades"];
$entrega=$_POST["entrega"];
//acabados
$acabados="SELECT * FROM acabado";
$result = mysql_query( $acabados );
$cont=0;;
$idacabadosArray[][2]="";
while($data = mysql_fetch_array($result, MYSQL_ASSOC)){
if(isset($_POST["acabado_".$data["idacabado"]])){
	$idacabadosArray[$cont][0]=$data["idacabado"];
	$idacabadosArray[$cont][1]=$_POST["acabado_".$data["idacabado"]];		
	$cont++;
}
}
//promociones
$promociones=$_POST["promociones"];
$paquetesAcabados=$_POST["paquetesAcabados"];
$comentarios=$_POST["comentarios"];

//Actualizar proyecto a DB
//Seguridad SQLi

$updateProyecto =  sprintf("UPDATE  proyecto SET nombre='%s', descripcion='%s', 
		caracteristicas='%s',  amenidadesDescripcion='%s', segmento='%s', unidadesTotales='%s',
		unidadesVendidas='%s', tiempoMercado='%s', promotor='%s', colonia='%s', municipio='%s', zona_idzona='%s',
		entrega='%s', fechaRevision='%s', linkWebpage='%s', promociones='%s', paquetesAcabados='%s',
		comentarios='%s', inicioVentas='%s', numeroModelos='%s', etapa='%s', nombreEtapa='%s', 
		llamadasSeguimiento='%s', tipo='%s', telefono='%s', vendidas1Q ='%s', vendidas2Q ='%s',
		vendidas3Q ='%s',vendidas4Q ='%s' WHERE idproyecto='%s'",mysql_real_escape_string($nombre),
		 mysql_real_escape_string($descripcion), mysql_real_escape_string($caracteristicas),
		mysql_real_escape_string($amenidadesDescripcion), mysql_real_escape_string($segmento),
		mysql_real_escape_string($unidadesTotales), mysql_real_escape_string($unidadesVendidas),
		mysql_real_escape_string($tiempoMercado), mysql_real_escape_string($promotor),
		mysql_real_escape_string($colonia), mysql_real_escape_string($municipio),
		mysql_real_escape_string($subzona), mysql_real_escape_string($entrega),
		mysql_real_escape_string($fechaRevision), mysql_real_escape_string($link),
		mysql_real_escape_string($promociones), mysql_real_escape_string($paquetesAcabados),
		mysql_real_escape_string($comentarios), mysql_real_escape_string($inicioVentas),
		mysql_real_escape_string($numeroModelos), mysql_real_escape_string($etapa),
		mysql_real_escape_string($nombreEtapa), mysql_real_escape_string($llamadasSeguimiento),
		mysql_real_escape_string($tipo), mysql_real_escape_string($telefono),
		mysql_real_escape_string($vendidas1Q), mysql_real_escape_string($vendidas2Q),
		mysql_real_escape_string($vendidas3Q), mysql_real_escape_string($vendidas4Q), $idproyecto  );
$result = mysql_query( $updateProyecto );
if (!$result) {
	die('No se pudo realizar la consulta:' . mysql_error());
	//header("Location: ../index.php");
} else {
	//Actualizar proyecto de fraccionamiento a DB
	if($tipo=="horizontal"){
	$updateProyectoTipo =  sprintf("UPDATE proyectofraccionamiento SET unidadesEtapa  = '%s'
			WHERE proyecto_idproyecto = '%s'", mysql_real_escape_string($unidadesEtapa), $idproyecto);
	} else if($tipo=="vertical"){ 	
		$updateProyectoTipo=  sprintf("UPDATE  proyectodepartamento SET 
				pisos= '%s', torres= '%s' WHERE proyecto_idproyecto = '%s';", mysql_real_escape_string($pisos),
				mysql_real_escape_string($torres), $idproyecto);
	}	
	$result = mysql_query( $updateProyectoTipo);	
	if (!$result) {
		$_SESSION['error'] = "actualización de la base de datos";
			$_SESSION['errormsg'] = "Verifique la información.";		
			header("Location: ../error.php");
	} else {
		//Actualizar imagenes				
		if(isset($logoProyecto)){
			guardarImagen("logoProyecto", "logo", $logoProyecto, $idproyecto);			
		}
		if(isset($lotificacion)){
			guardarImagen("lotificacion", "plano", $lotificacion, $idproyecto);
		}
		if(isset($previaTorre)){
			guardarImagen("previaTorre", "plano", $previaTorre, $idproyecto);
		}	
		if(isset($imagenAmenidad1)){
			guardarImagen("imagenAmenidad1", "amenidad1", $imagenAmenidad1, $idproyecto);
		}	
		if(isset($imagenAmenidad2)){
			guardarImagen("imagenAmenidad2", "amenidad2", $imagenAmenidad2, $idproyecto);
		}
		if(isset($imagenAmenidad3)){
			guardarImagen("imagenAmenidad3", "amenidad3", $imagenAmenidad3, $idproyecto);
		}
		if(isset($imagenAmenidad4)){
			guardarImagen("imagenAmenidad4", "amenidad4", $imagenAmenidad4, $idproyecto);			
		}	
		//Actualizar acabados
		$deleteAcabados= sprintf("DELETE FROM incluyeacabado WHERE proyecto_idproyecto = '%s'", $idproyecto);
		$result = mysql_query( $deleteAcabados);
		$i=0;
		while($i<$cont){
		$insertAcabados = sprintf("INSERT INTO incluyeacabado (acabado_idacabado, proyecto_idproyecto, cumplimiento) 
				VALUES ('%s','%s','%s')", $idacabadosArray[$i][0],$idproyecto,$idacabadosArray[$i][1]);
		$result = mysql_query( $insertAcabados);
		$i++;
		}
		//Actualizar amenidades
		if(isset($amenidades)){
			$deleteAmenidades= sprintf("DELETE FROM incluyeamenidad WHERE proyecto_idproyecto = '%s'", $idproyecto);
			$result = mysql_query( $deleteAmenidades);
		foreach($amenidades as $value){
			$insertAmenidades = sprintf("INSERT INTO incluyeamenidad (amenidad_idamenidad, proyecto_idproyecto)
					VALUES ('%s','%s')", $value,$idproyecto);
			$result = mysql_query( $insertAmenidades);			
		}
		}
		//Actualizar puntos de afluencia
		$deletePuntos= sprintf("DELETE FROM incluyepuntoafluencia  WHERE idproyecto = '%s'", $idproyecto);
		$result = mysql_query( $deletePuntos);
		$i=0;
		while($i<$contPuntos){
			$insertPuntos = sprintf("INSERT INTO incluyepuntoafluencia (idproyecto, idpuntoafluencia, distancia)
					VALUES ('%s','%s','%f')", $idproyecto,$puntosAfluencia[$i][0],$puntosAfluencia[$i][1]);
			if($puntosAfluencia[$i][0]!=""){
			$result = mysql_query( $insertPuntos);
			}
			$i++;
		}			
		header("Location: ../".$_SESSION["pageFrom"].".php");		
	}
}
}
//Se guardan las imagenes en la DB y en la carpeta de img
//En el path se agrega el id del proyecto al inicio del nombre del archivo.
function guardarImagen($name, $tipo, $path, $id){	
	$path="img\proyectos\\".$id."_".$path;	
	//Si reemplaza la imagen
	$existeImagen= sprintf("SELECT * FROM imagenes WHERE proyecto_idproyecto = '%s' AND
			tipo = '%s' ", $id,$tipo);
	$result = mysql_query( $existeImagen);
	//Borrar la imagen antigua
	if($data=mysql_fetch_array($result)){
		unlink('..\\'.$data['path']);
		mysql_query("DELETE FROM imagenes WHERE idimagenes='".$data["idimagenes"]."'");
	}
	$insertImagen= sprintf("INSERT INTO imagenes (tipo, path, proyecto_idproyecto)
			VALUES ('%s','%s','%s');",$tipo, mysql_real_escape_string($path), $id);
	//Guardar la imagen nueva
	move_uploaded_file($_FILES[$name]["tmp_name"],
			"..\img\proyectos\\" .$id."_". $_FILES[$name]["name"]);
	$result = mysql_query( $insertImagen);	
}

	function verificarTamañoYTipo($nombre){
	if (isset($_FILES[$nombre]) && (($_FILES[$nombre]["type"] == "image/gif")
			|| ($_FILES[$nombre]["type"] == "image/jpeg")
			|| ($_FILES[$nombre]["type"] == "image/pjpeg")
			|| ($_FILES[$nombre]["type"] == "image/png")
			|| ($_FILES[$nombre]["type"] == "image/gif"))
			&& ($_FILES[$nombre]["size"] < 2000000))
	{
		if ($_FILES[$nombre]["error"] > 0)
		{						
			return false;					
			//echo "Return Code: " . $_FILES[$nombre]["error"] . "<br />";
		}
		return true;
}
	}

?>