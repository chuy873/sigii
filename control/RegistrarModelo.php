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
$idproyecto=$_POST["proyecto"];;
//datos basicos
$tipo=$_POST["tipo"];
$nombre=$_POST["nombre"];
$diferenciadores=$_POST["diferenciadores"];
$metrosCuadrados=$_POST["metrosCuadrados"];
$montoSeparacion=$_POST["montoSeparacion"];
$porcentajeEngancheMin=$_POST["porcentajeEngancheMin"];
$unidades=$_POST["unidadesTotales"];
$unidadesVendidas=$_POST["unidadesVendidas"];
//horizontal
if($tipo=="horizontal"){
$absorcion=$_POST["absorcion"];
$precio=$_POST["precio"];
$creditoSobreEnganche=$_POST["creditoSobreEnganche"];
$m2Terreno=$_POST["metros2Terreno"];
$precioTerreno=$_POST["precioTerreno"];
$contFachadas=$_POST["contFachadas"];
$fachadas[]="";
$i=1;
while($i <= $contFachadas){
	if(verificarTamañoYTipo("fachada".$i)){
		$fachada[$i]= $_FILES["fachada".$i]["name"];
	}
	$i++;
}

} else if($tipo=="vertical"){
//vertical
$aumentoXPiso=$_POST["aumentoXPiso"];
$contPrecios=$_POST["contPrecios"];
$preciosArray[]="";
$i=1;
while($i<=$contPrecios){
	$preciosArray[($i-1)]=$_POST["precios".$i];
	$i++;
}

$precioPromedio=array_sum($preciosArray)/$contPrecios;

$precioMin=min($preciosArray);
$precioMax=max($preciosArray);
}
//imagenes
$contDist=$_POST["contDist"];
$distribuciones[]="";
$i=0;
while($i < $contDist){
	if(verificarTamañoYTipo("distribucion".($i+1))){		
		$distribuciones[$i]= $_FILES["distribucion".($i+1)]["name"];
	}
	$i++;
}
//atributos
$atributos="SELECT * FROM atributos";
$result = mysql_query( $atributos );
$idatributosArray[][2]="";
$contatributos=0;
while($data = mysql_fetch_array($result, MYSQL_ASSOC)){
	if(isset($_POST["atributo_".$data["idatributos"]])){
		$idatributosArray[$contatributos][0]=$data["idatributos"];
		$idatributosArray[$contatributos][1]=$_POST["calificacion_".$data["idatributos"]];
		$contatributos++;
	}
}
//caracteristicas
$caract="SELECT * FROM caracteristicas";
$result = mysql_query( $caract );
$idcaractArray[][2]="";
$contcaract=0;
while($data = mysql_fetch_array($result, MYSQL_ASSOC)){
	if(isset($_POST["caracteristicas_".$data["idcaracteristicas"]])){
		$idcaractArray[$contcaract][0]=$data["idcaracteristicas"];
		$idcaractArray[$contcaract][1]=$_POST["caracteristicas_".$data["idcaracteristicas"]];
		$contcaract++;
	}
}


//Insertar a DB
//Seguridad SQLi

$insertModelo =  sprintf("INSERT INTO  modelo (proyecto_idproyecto, nombre, diferenciadores, 
		metrosCuadrados,  montoSeparacion, porcentajeEngancheMin, unidades,
		unidadesVendidas)
			VALUES ('%s','%s','%s','%s','%s','%s','%s','%s');",mysql_real_escape_string($idproyecto),
		mysql_real_escape_string($nombre),
		 mysql_real_escape_string($diferenciadores), mysql_real_escape_string($metrosCuadrados),
		mysql_real_escape_string($montoSeparacion), mysql_real_escape_string($porcentajeEngancheMin),
		mysql_real_escape_string($unidades), mysql_real_escape_string($unidadesVendidas)  );
$result = mysql_query( $insertModelo );
if (!$result) {
	die('No se pudo realizar la consulta:' . mysql_error());
	//header("Location: ../index.php");
} else {
	$getIdModelo = sprintf("SELECT idmodelo FROM modelo WHERE nombre = '%s';",mysql_real_escape_string($nombre));
	$result = mysql_query( $getIdModelo );
	$idmodelo=mysql_fetch_row($result);
	if($tipo=="horizontal"){
	$insertModeloTipo =  sprintf("INSERT INTO modelofraccionamiento ( modelo_idmodelo,
			 absorcion, precio, creditoSobreEnganche, m2Terreno, precioTerreno ) VALUES ('%s','%s','%s','%s','%s','%s');",
			$idmodelo[0], mysql_real_escape_string($absorcion), mysql_real_escape_string($precio),
			mysql_real_escape_string($creditoSobreEnganche), mysql_real_escape_string($m2Terreno),
			mysql_real_escape_string($precioTerreno));
	} else if($tipo=="vertical"){ 
		$insertModeloTipo=  sprintf("INSERT INTO modelodepartamento ( modelo_idmodelo,
				precioPromedio, precioMin, precioMax, aumentoXPiso ) VALUES ('%s','%f', '%f','%f', '%f');",
				$idmodelo[0], $precioPromedio, $precioMin,$precioMax,mysql_real_escape_string($aumentoXPiso));
	}
	$result = mysql_query( $insertModeloTipo);	
	if (!$result) {
		die('No se pudo realizar la consulta:' . mysql_error());
		//header("Location: ../bienvenido.php");
	} else {
		//Guardar imagenes de distribucion

		$k=0;
		while($k<$contDist){
			if(isset($distribuciones[$k]) && $distribuciones[$k]!=""){					
				guardarImagen("distribucion".($k+1), "distribucion", $distribuciones[$k], $idmodelo[0]);
			}
			$k++;
		}
		//Guardar imagenes de fachadas
		if($tipo=="horizontal"){
		$i=1;
		while($i <= $contFachadas){
			if(isset($fachada[$i])){
				guardarImagen("fachada".$i, "fachada", $fachada[$i], $idmodelo[0]);				
			}
			$i++;
		}
		}
		//Guardar atributos
		$j=0;
		while($j<$contatributos){
		$insertAtributos = sprintf("INSERT INTO incluyeatributo ( idmodelo, idatributo, calificacion) 
				VALUES ('%s','%s', '%s');",
				$idmodelo[0], $idatributosArray[$j][0],$idatributosArray[$j][1]	);
		if($idatributosArray[$j][1]!=""){
		$result = mysql_query( $insertAtributos);
		}
		$j++;
		}
		
		//Guardar caracteristicas
	$k=0;
		while($k<$contcaract){
		$insertAtributos = sprintf("INSERT INTO incluyecaracteristica ( modelo_idmodelo, caracteristicas_idcaracteristicas,
				cantidad)VALUES ('%s','%s', '%s');",
				$idmodelo[0], $idcaractArray[$k][0],$idcaractArray[$k][1]	);		
		$result = mysql_query( $insertAtributos);		
		$k++;
		}
		if($_POST["agregar"]==1){
			if($tipo=="horizontal"){		
			header("Location: ../registrarModeloHorizontal.php");
		}else if($tipo=="vertical"){
				header("Location: ../registrarModeloVertical.php");
		}} else {
		
		header("Location: ../bienvenido.php");		
		}
	}}

//Se guardan las imagenes en la DB y en la carpeta de img
//En el path se agrega el id del proyecto al inicio del nombre del archivo.
function guardarImagen($name, $tipo, $path, $id){
	$path="img\modelos\\".$id."_".$path;
	$insertImagen= sprintf("INSERT INTO imagenes (tipo, path, modelo_idmodelo)
			VALUES ('%s','%s','%s');",$tipo, mysql_real_escape_string($path), $id);
	//Guardar la imagen nueva
	move_uploaded_file($_FILES[$name]["tmp_name"],
			"..\img\modelos\\" .$id."_". $_FILES[$name]["name"]);
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