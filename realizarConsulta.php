<?php
/* Pagina Consultar
 * Se pueden realizar consultas especificas a la base de datos
* Es accesada por admin, revision y analisis.
*/
$pageTitle = "SIGII | Resultado de consulta";
include "clases/Usuarios.php";
session_start();
if(!(isset($_SESSION["usuario"]))){
	header("Location: index.php");
}
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
include "includes/header_aplicacion.php";
//Verificar si el usuario tiene permiso para visualizar esta página
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision" ||
		$usuariologueado->getTipo()=="captura" || $usuariologueado->getTipo()=="analisis" ||
		$usuariologueado->getTipo()=="cliente")) {
	header("Location: index.php");
}

//Datos recibidos
$tabla=$_POST["tabla"];
if(isset($_POST["columnasAtributos"])){
$tablaAtributos=$_POST["columnasAtributos"];
$valorAtributos=$_POST["columnasAtributosF"];
//Obtener ids de modelos/proyectos que cumplen con el atributo
if(isset($_POST["cantidadF"])){
	$selectId="SELECT * FROM v".$tablaAtributos." WHERE ".$tablaAtributos." = '".$valorAtributos."' AND cantidad = ".$_POST["cantidadF"];
} else if(isset($_POST["califF"])){
	$selectId="SELECT * FROM v".$tablaAtributos." WHERE ".$tablaAtributos." = '".$valorAtributos."' AND calificacion = '".$_POST["califF"]."'";
} else {
$selectId="SELECT * FROM v".$tablaAtributos." WHERE ".$tablaAtributos." = '".$valorAtributos."'";
}
$result1=mysql_query($selectId);
$ids[]="";
$i=0;
while($data=mysql_fetch_array($result1)){
	$ids[$i]=$data[$tabla];
	$i++;
}
$select="SELECT *";
$from=" FROM v".$tabla;
$where=" WHERE nombre IN (";
$n=0;
$leng=count($ids);
foreach($ids as $value){
	if($n<($leng-1)){
	$where.="'".$value."',";
	} else {
		$where.="'".$value."'";
	}
	$n++;
}
$where.=")";
$query=$select." ".$from." ".$where;
} else 
if(isset($_POST["columnasProyectos"])){
$columnaProyectos=$_POST["columnasProyectos"];
$valorProyectos=$_POST["columnasProyectosF"];
$select="SELECT *";
$from=" FROM v".$tabla;
$where=" WHERE ".$columnaProyectos." = '".$valorProyectos."'";
$query=$select." ".$from." ".$where;
} else 
if(isset($_POST["columnasModelos"])){
$columnaModelos=$_POST["columnasModelos"];
$valorModelos=$_POST["columnasModelosF"];
$select="SELECT *";
$from=" FROM v".$tabla;
$where=" WHERE ".$columnaModelos." = '".$valorModelos."'";
$query=$select." ".$from." ".$where;
} else {
	$select="SELECT *";
	$from=" FROM v".$tabla;	
	$query=$select." ".$from;
}

$result=mysql_query($query);
if (!$result) {
	$_SESSION['error'] = "consulta";
	$_SESSION['errormsg'] = "Hubo un error al consultar la base de datos.";
	$_SESSION['pageFrom']="consultar";
	header("Location: error.php");
}

?>
<div class="row span12 offset1">

	<table id="Exportar_a_Excel">
		<tr>
			<td>

				<div class="row-fluid">
					<div class="span10 offset2">
						<h1>Resultado de la consulta</h1>
						<table class="table table-bordered">
						<tr>
						<?php $j=0; while($j<mysql_num_fields($result)){?>
						
								<th><?php echo strtoupper(mysql_field_name($result, $j));?></th>																					
							<?php							
							$j++;}?>
							</tr>
							<?php while ($data = mysql_fetch_row($result)) {
								?>								
							<tr>							
								<?php 				
								$numColumns=count($data);
								$cont=0;
								while($cont<$numColumns){?>														
								<td><?php echo $data[$cont]?>
								</td>
								<?php $cont++;}?>
							</tr>
							<?php }?>
						</table>					
					</div>
				</div>
			</td>
		</tr>
	</table>
		<form action="control/exportarExcel.php" method="post"
					target="_blank" id="FormularioExportacion">
					<p>
						Exportar a Excel <img src="assets/img/Excel-icon.png"
							class="botonExcel" />
					</p>
					<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" /> <input
						type="hidden" name="tipo" value="lista" />
				</form>
</div>

<?php include "includes/footer_principal.php"?>