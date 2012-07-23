<?php
/*
 * Control editarModelo
* Editar los modelos verticales y horizontales y registrarlos en la base de datos.
*/
//Verificar si el usuario tiene acceso
include "../clases/Usuarios.php";
session_start();
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || ($usuariologueado->getTipo()=="revision"))) {
	$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta página.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: ../error.php");	
} else {
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$idproyecto=$_POST["proyecto"];
$idModelo=$_POST["idmodelo"];
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
	$m2Terreno=$_POST["m2Terreno"];
	$precioTerreno=$_POST["precioTerreno"];
	$contFachadas=$_POST["contFachadas"];
	
	if(isset($contFachadas)){		
	$fachadas[]="";
	$i=0;
	while($i < $contFachadas){
		if(verificarTamañoYTipo("fachada".($i+1))){
		$fachada[$i]= $_FILES["fachada".($i+1)]["name"];
		}
		$i++;		
	}
	}

} else if($tipo=="vertical"){
	//vertical
	$aumentoXPiso=$_POST["aumentoXPiso"];
	$precioPromedio=$_POST["precioPromedio"];
	$precioMin=$_POST["precioMin"];
	$precioMax=$_POST["precioMax"];
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
$updateModelo =  sprintf("UPDATE modelo SET proyecto_idproyecto='%s', nombre='%s', diferenciadores='%s',
		metrosCuadrados='%s',  montoSeparacion='%s', porcentajeEngancheMin='%s', unidades='%s',
		unidadesVendidas='%s' WHERE idmodelo='%s'",mysql_real_escape_string($idproyecto),
		mysql_real_escape_string($nombre),
		mysql_real_escape_string($diferenciadores), mysql_real_escape_string($metrosCuadrados),
		mysql_real_escape_string($montoSeparacion), mysql_real_escape_string($porcentajeEngancheMin),
		mysql_real_escape_string($unidades), mysql_real_escape_string($unidadesVendidas), $idModelo );
$result = mysql_query( $updateModelo );
if (!$result) {
	die('No se pudo realizar la consulta:' . mysql_error());
	header("Location: ../error.php");
} else {
	if($tipo=="horizontal"){
		$insertModeloTipo =  sprintf("UPDATE modelofraccionamiento SET
			 absorcion='%s', precio='%s', creditoSobreEnganche='%s', m2Terreno='%s', precioTerreno='%s'
				WHERE modelo_idmodelo='%s'",
				mysql_real_escape_string($absorcion), mysql_real_escape_string($precio),
				mysql_real_escape_string($creditoSobreEnganche), mysql_real_escape_string($m2Terreno),
				mysql_real_escape_string($precioTerreno), $idModelo );
	} else if($tipo=="vertical"){
		$insertModeloTipo=  sprintf("UPDATE modelodepartamento SET 	precioPromedio='%s',
				precioMin='%s', precioMax='%s', aumentoXPiso='%s' WHERE modelo_idmodelo='%s'",
				$precioPromedio, $precioMin,$precioMax, $idModelo, mysql_real_escape_string($aumentoXPiso));
	}
	$result = mysql_query( $insertModeloTipo);
	if (!$result) {
		die('No se pudo realizar la consulta:' . mysql_error());
		header("Location: ../error.php");
	} else {
		//Eliminar imagenes (si aplica)
		$imagenesActuales = "SELECT * FROM imagenes WHERE modelo_idmodelo='".$idModelo."'";
		$result=mysql_query($imagenesActuales);
		while($data=mysql_fetch_array($result)){
			if(isset($_POST["eliminaImagen".$data["idimagenes"]]) && $data["idimagenes"]==$_POST["eliminaImagen".$data["idimagenes"]]){//eliminarla
				unlink('..\\'.$data['path']);
				mysql_query("DELETE FROM imagenes WHERE idimagenes='".$data["idimagenes"]."'");
			}
		}
		
		//Guardar imagenes de distribucion
		$k=0;
		while($k<$contDist){
			if(isset($distribuciones[$k]) && $distribuciones[$k]!=""){	
				guardarImagen("distribucion".($k+1), "distribucion", $distribuciones[$k], $idModelo);
			}
			$k++;
		}

		//Guardar imagenes de fachadas
		if($tipo=="horizontal"){
			$i=0;			
			while($i < $contFachadas){
				if(isset($fachada[$i]) && $fachada[$i]!=""){
					guardarImagen("fachada".($i+1), "fachada", $fachada[$i], $idModelo);
				}
				$i++;
			}
		}
		//Actualizar atributos
		$deleteAtributos= sprintf("DELETE FROM incluyeatributo  WHERE idmodelo = '%s'", $idModelo);
		$result = mysql_query( $deleteAtributos);
		$j=0;
		while($j<$contatributos){
			$insertAtributos = sprintf("INSERT INTO incluyeatributo ( idmodelo, idatributo, calificacion)
					VALUES ('%s','%s', '%s');",
					$idModelo, $idatributosArray[$j][0],$idatributosArray[$j][1]	);
			if($idatributosArray[$j][1]!=""){
				$result = mysql_query( $insertAtributos);
			}
			$j++;
		}

		//Actualiza caracteristicas
		$deleteCaract= sprintf("DELETE FROM incluyecaracteristica WHERE modelo_idmodelo = '%s'", $idModelo);
		$result = mysql_query( $deleteCaract);
		$k=0;
		while($k<$contcaract){
			$insertAtributos = sprintf("INSERT INTO incluyecaracteristica ( modelo_idmodelo, caracteristicas_idcaracteristicas,
					cantidad)VALUES ('%s','%s', '%s');",
					$idModelo, $idcaractArray[$k][0],$idcaractArray[$k][1]	);
			$result = mysql_query( $insertAtributos);
			$k++;
		}
		header("Location: ../".$_SESSION["pageFrom"].".php");		
	}
}
}
//Se guardan las imagenes en la DB y en la carpeta de img
//En el path se agrega el id del proyecto al inicio del nombre del archivo.
function guardarImagen($name, $tipo, $path, $id){
	
	$path="img\modelos\\".$id."_".$path;
	//Si reemplaza la imagen
	$existeImagen= sprintf("SELECT * FROM imagenes WHERE modelo_idmodelo = '%s' AND
			tipo = '%s' ", $id,$tipo);
	$result = mysql_query( $existeImagen);
	//Borrar la imagen antigua
	if($data=mysql_fetch_array($result)){
		
		//unlink('..\\'.$data['path']);
		//mysql_query("DELETE FROM imagenes WHERE idimagenes='".$data["idimagenes"]."'");
	}	
	$insertImagen= sprintf("INSERT INTO imagenes (tipo, path, modelo_idmodelo)
			VALUES ('%s','%s','%s');",$tipo, mysql_real_escape_string($path), $id);
	//Guardar la imagen nueva
	move_uploaded_file($_FILES[$name]["tmp_name"],
			"..\img\modelos\\" .$id."_". $_FILES[$name]["name"]);
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