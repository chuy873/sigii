<?php
/*
 * Control admonInsertar
* Permite insertar los acabados, amenidades, caracteristicas y atributos con los parametros
* que tienen en comun ( nombre, tipo)
*/
//Verificar si el usuario tiene acceso
include "../clases/Usuarios.php";
session_start();
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || ($usuariologueado->getTipo()=="revision")
		|| ($usuariologueado->getTipo()=="captura"))) {
	header("Location: ../bienvenido.php");
}
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$idproyecto="";
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
$llamadasSeguimiento=$_POST["llamadasSeguimiento"];
$tiempoMercado=$_POST["tiempoMercado"];
$pisos=$_POST["pisos"];
$torres=$_POST["torres"];
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
//google earth
$earth=$_POST["earth"];
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
print_r($_POST);

//Insertar a DB
//Seguridad SQLi
$insertProyecto =  sprintf("INSERT INTO  proyecto (nombre, descripcion, 
		caracteristicas,  amenidadesDescripcion, segmento, unidadesTotales,
		unidadesVendidas, tiempoMercado, promotor, colonia, municipio, zona_idzona,
		entrega, fechaRevision, linkWebpage, promociones, paquetesAcabados,
		comentarios, inicioVentas, numeroModelos, etapa, nombreEtapa, llamadasSeguimiento, tipo, telefono)
			VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s',
		'%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s','%s');",mysql_real_escape_string($nombre),
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
		mysql_real_escape_string($tipo), mysql_real_escape_string($telefono)  );
$result = mysql_query( $insertProyecto );
if (!$result) {
	die('No se pudo realizar la consulta:' . mysql_error());
	//header("Location: ../index.php");
} else {
	$getIdProyecto = sprintf("SELECT idproyecto FROM proyecto WHERE nombre = '%s';",mysql_real_escape_string($nombre));
	$result = mysql_query( $getIdProyecto );
	$idproyecto=mysql_fetch_row($result);
	if($tipo=="horizontal"){
	$insertProyectoTipo =  sprintf("INSERT INTO proyectofraccionamiento ( proyecto_idproyecto,
			 unidadesEtapa ) VALUES ('%s','%s');",$idproyecto[0], mysql_real_escape_string($unidadesEtapa));
	} else if($tipo=="vertical"){ 
		$insertProyectoTipo=  sprintf("INSERT INTO proyectodepartamento ( proyecto_idproyecto,
				pisos, torres ) VALUES ('%s','%s', '%s');",$idproyecto[0], mysql_real_escape_string($pisos),
				mysql_real_escape_string($torres));
	}
	$result = mysql_query( $insertProyectoTipo);	
	if (!$result) {
		die('No se pudo realizar la consulta:' . mysql_error());
		//header("Location: ../bienvenido.php");
	} else {
		
		
		$file = '../img/earth/'.$idproyecto[0].'_earth.kml.';
		//Agregar al archivo la informacion de kml de google earth.
		$current = $earth;
		// Escribir los datos en servidor
		file_put_contents($file, $current);
		//Registrar en DB
		$insertEarth=sprintf("INSERT INTO posicionearth (pathArchivoKML, proyecto_idproyecto)
		VALUES ('%s','%s');", 'img/earth/'.$idproyecto[0].'_earth.kml',$idproyecto[0]);
		$result = mysql_query( $insertEarth);
		
		if(isset($logoProyecto)){
			guardarImagen("logoProyecto", "logo", $logoProyecto, $idproyecto[0]);
		}
		if(isset($lotificacion)){
			guardarImagen("lotificacion", "plano", $lotificacion, $idproyecto[0]);
		}
		if(isset($previaTorre)){
			guardarImagen("previaTorre", "plano", $previaTorre, $idproyecto[0]);
		}	
		if(isset($imagenAmenidad1)){
			guardarImagen("imagenAmenidad1", "amenidad", $imagenAmenidad1, $idproyecto[0]);
		}	
		if(isset($imagenAmenidad2)){
			guardarImagen("imagenAmenidad2", "amenidad", $imagenAmenidad2, $idproyecto[0]);
		}
		if(isset($imagenAmenidad3)){
			guardarImagen("imagenAmenidad3", "amenidad", $imagenAmenidad3, $idproyecto[0]);
		}
		if(isset($imagenAmenidad4)){
			guardarImagen("imagenAmenidad4", "amenidad", $imagenAmenidad4, $idproyecto[0]);
		}	
		//Guardar acabados
		$i=0;
		while($i<$cont){
		$insertAcabados = sprintf("INSERT INTO incluyeacabado (acabado_idacabado, proyecto_idproyecto, cumplimiento) 
				VALUES ('%s','%s','%s')", $idacabadosArray[$i][0],$idproyecto[0],$idacabadosArray[$i][1]);
		$result = mysql_query( $insertAcabados);
		$i++;
		}
		//Guardar amenidades
		if(isset($amenidades)){
		foreach($amenidades as $value){
			$insertAmenidades = sprintf("INSERT INTO incluyeamenidad (amenidad_idamenidad, proyecto_idproyecto)
					VALUES ('%s','%s')", $value,$idproyecto[0]);
			$result = mysql_query( $insertAmenidades);			
		}
		}
		//Guardar puntos de afluencia
		$i=0;
		while($i<$contPuntos){
			$insertPuntos = sprintf("INSERT INTO incluyepuntoafluencia (idproyecto, idpuntoafluencia, distancia)
					VALUES ('%s','%s','%f')", $idproyecto[0],$puntosAfluencia[$i][0],$puntosAfluencia[$i][1]);
			if($puntosAfluencia[$i][0]!=""){
			$result = mysql_query( $insertPuntos);
			}
			$i++;
		}
			//header("Location: ../bienvenido.php");		
		
	}
}

//Se guardan las imagenes en la DB y en la carpeta de img
//En el path se agrega el id del proyecto al inicio del nombre del archivo.
function guardarImagen($name, $tipo, $path, $id){
	$path="img\proyectos\\".$id."_".$path;
	$insertImagen= sprintf("INSERT INTO imagenes (tipo, path, proyecto_idproyecto)
			VALUES ('%s','%s','%s');",$tipo, mysql_real_escape_string($path), $id);
	//Guardar la imagen nueva
	move_uploaded_file($_FILES[$name]["tmp_name"],
			"..\img\proyectos\\" .$id."_". $_FILES[$name]["name"]);
	$result = mysql_query( $insertImagen);	
}

	function verificarTamañoYTipo($nombre){
	if ((($_FILES[$nombre]["type"] == "image/gif")
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