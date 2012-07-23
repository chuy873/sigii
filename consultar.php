<?php
/* Pagina Consultar
 * Se pueden realizar consultas especificas a la base de datos
 * Es accesada por admin, revision y analisis.
*/
$pageTitle = "SIGII | Consultar";
include "clases/Usuarios.php";
session_start();
if(!(isset($_SESSION["usuario"]))){
	header("Location: index.php");
}
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision")) {
	$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta página.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: error.php");
}
include "includes/header_aplicacion.php";
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$_SESSION['pageFrom']="consultar";
$sql1 = "SELECT * FROM vproyecto LIMIT 0";
$result1 = mysql_query($sql1);

$sql2 = "SELECT * FROM vmodelo LIMIT 0";
$result2 = mysql_query($sql2);
if (!$result1 || !$result2) {
		$_SESSION['error'] = "consulta";
	$_SESSION['errormsg'] = "Hubo un error al consultar la base de datos.";
	$_SESSION['pageFrom']="consultar";
	header("Location: ../error.php");	
}
?>
<div class="row">
	<div class="span10 offset2">
		<form id="consulta" class="form-horizontal" action="realizarConsulta.php"
			method="post">
			<fieldset>
				<legend>
					<i class="icon-search"></i> Realizar consulta en la base de datos
				</legend>
				<hr>		
				<h4>Seleccionar:</h4>						
				<div class="control-group">
					<label class="control-label" for="tabla">Proyecto/Modelo*: </label>
					<div class="controls">
						<select name="tabla" id="tabla" onchange="filtrarColumna(this.value)">
							<option value="" disabled="disabled" selected=selected>Selecciona proyecto o modelo</option>										
							<option value="proyecto">Proyectos</option> 				
							<option value="modelo">Modelos</option>
						</select> <span class="help-inline"></span>
					</div>
				</div>
				<hr>
				<h4>Filtrar por:</h4>
				<div class="control-group">
					<label class="control-label" for="columnasAtributos">Atributos: </label>
					<div class="controls">
						<select name="columnasAtributos" id="columnasAtributos" onchange="desplegarColumnas(this.value, this.id,'attr')">
							<option value="" disabled="disabled" selected=selected >Atributos, amenidades, acabados...</option>										
							<option value="atributos">Atributos</option> 				
							<option value="amenidad">Amenidades</option>
							<option value="caracteristicas">Caracter&iacute;sticas</option>
							<option value="acabado">Acabados</option>   
						</select> <span class="help-inline"></span>
					</div>
				</div>	
				<div class="control-group">
						<label class="control-label" for="columnasAtributosF" >Valor: </label>
					<div class="controls">						
						<select name="columnasAtributosF" id="columnasAtributosF"  >
							<option value="" disabled="disabled" selected=selected>Selecciona el valor</option>
							</select> 						
							<span class="help-inline"></span>											
				</div>	
				</div>
				<div id="filtrarAttr" style="display : none">
				<div class="control-group">
						<label class="control-label" for="califF" >Calificaci&oacute;n: </label>
					<div class="controls">						
						<select name="califF" id="califF"  >
							<option value="" disabled="disabled" selected=selected>Selecciona el valor</option>
							<option value="Verde">Verde</option>
							<option value="Amarillo">Amarillo</option>
							<option value="Rojo">Rojo</option>
							</select> 						
							<span class="help-inline"></span>											
				</div>	
				</div>
				</div>
				<div id="filtrarCaract" style="display : none">
				<div class="control-group">
						<label class="control-label" for="cantidadF" >Cantidad </label>
					<div class="controls">						
						<select name="cantidadF" id="cantidadF"  >
							<option value="" disabled="disabled" selected=selected>Selecciona el valor</option>
							<?php $i=0; while($i<20){?>
							<option value="<?php echo $i?>"><?php echo $i?></option>
							<?php $i++;}?>
							</select> 						
							<span class="help-inline"></span>											
				</div>	
				</div>
				</div>
				<div id="filtrarProy" style="display : none">				
				<h4>&Oacute; por:</h4>
				<div class="control-group">
					<label class="control-label" for="columnasProyectos">Campos de proyecto: </label>	
					<div class="controls">												
						<select name="columnasProyectos" id="columnasProyectos" onchange="desplegarColumnas(this.value, this.id,'proyecto')" >
							<option value="" disabled="disabled" selected=selected>Selecciona el campo</option>										
							<?php 
							$i =0;
							$numColumns=mysql_num_fields($result1);							
							while($i<$numColumns){?>
							<option value="<?php echo mysql_field_name($result1, $i)?>"><?php echo mysql_field_name($result1, $i)?></option> 				
						<?php $i++;}?>
						</select>
						<span class="help-inline"></span>	
						</div>
						</div>
						<div class="control-group">
						<label class="control-label" for="columnasProyectosF">Valor: </label>
					<div class="controls">						
						<select name="columnasProyectosF" id="columnasProyectosF" >
							</select> 						
							<span class="help-inline"></span>											
				</div>	
				</div>				
				<hr>
				</div>
				<div id="filtrarMod" style="display : none">				
				<h4>&Oacute; por:</h4>
				<div class="control-group">
					<label class="control-label" for="columnasModelos">Campos de modelos: </label>
					<div class="controls">
						<select name="columnasModelos" id="columnasModelos" onchange="desplegarColumnas(this.value, this.id, 'modelo')" >
							<option value="" disabled="disabled" selected=selected>Selecciona el campo</option>										
								<?php 
							$i =0;
							$numColumns=mysql_num_fields($result2);							
							while($i<$numColumns){?>
							<option value="<?php echo mysql_field_name($result2, $i)?>"><?php echo mysql_field_name($result2, $i)?></option> 				
						<?php $i++;}?>  
						</select> <span class="help-inline"></span>
					</div>
				</div>
					<div class="control-group">
						<label class="control-label" for="columnasModelosF">Valor: </label>
					<div class="controls">						
						<select name="columnasModelosF" id="columnasModelosF" >
							<option value="" disabled="disabled" selected=selected>Selecciona el valor</option>
							</select> 						
							<span class="help-inline"></span>											
				</div>	
				</div>
				<hr>
				</div>	
				<button type="submit" class="btn">Realizar consulta</button>
			</fieldset>
		</form>
		
	</div>
</div>
<?php include "includes/footer_principal.php" ?>
<script type="text/javascript">

function filtrarColumna(value){
	if(value=="proyecto"){
		document.getElementById("filtrarMod").style.display="none";
	document.getElementById("filtrarProy").style.display="block";
	} else if(value=="modelo"){
		document.getElementById("filtrarProy").style.display="none";
	document.getElementById("filtrarMod").style.display="block";
	}
}
							
/*
 * Funcion AJAX para obtener valores de atributos, amenidades, etc. para filtrar
 */
function desplegarColumnas(valor, id, tipo)
{
	
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {	 	   
    document.getElementById(id+"F").innerHTML=xmlhttp.responseText;
    if(valor=="caracteristicas"  ){
    	document.getElementById("filtrarAttr").style.display="none";
    	document.getElementById("filtrarCaract").style.display="block";
    } else  if (valor=="atributos" ){
    	document.getElementById("filtrarCaract").style.display="none";
    	document.getElementById("filtrarAttr").style.display="block";
    } else {
    	document.getElementById("filtrarAttr").style.display="none";
    	document.getElementById("filtrarCaract").style.display="none";
  }
  }
  }
xmlhttp.open("POST","control/getColumnas.php",true);
xmlhttp.setRequestHeader("Content-Type",
"application/x-www-form-urlencoded; charset=UTF-8");
if(tipo=="attr"){
xmlhttp.send("tabla="+escape(valor));
}


else {
	xmlhttp.send("tabla="+escape(tipo)+"&columna="+valor);
}
}

</script>