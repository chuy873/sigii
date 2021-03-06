<?php
/* Pagina editar modelo de proyecto horizontal
 Se despliega la forma con los datos del modelo de proyecto a editar.
Esta pagina solo es accesada por el administrador, revision.
*/
$pageTitle = "SIGII | Editar Modelo Horizontal";
include "clases/Usuarios.php";
session_start();
if(!(isset($_SESSION["usuario"]))){
	header("Location: index.php");
}
//Verificar si el usuario tiene permiso para visualizar esta página
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision")) {
	$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta p�gina.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: error.php");
}
include "includes/header_aplicacion.php";
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$idModelo=$_GET["id"];
$dataModelo = "SELECT * FROM modelo WHERE idmodelo ='".$idModelo."'";
$result1 = mysql_query( $dataModelo);
$dataModeloFracc = "SELECT * FROM modelofraccionamiento WHERE modelo_idmodelo ='".$idModelo."'";
$result2 = mysql_query( $dataModeloFracc);
$dataAtributo="SELECT * FROM incluyeatributo WHERE idmodelo = '".$idModelo."'";
$result3=mysql_query( $dataAtributo);
$dataCaract="SELECT * FROM incluyecaracteristica WHERE modelo_idmodelo='".$idModelo."'";
$result4=mysql_query($dataCaract);
if (!$result1 || !$result2 || !$result3 || !$result4 ) {
	die('No se pudo realizar la consulta:' . mysql_error());
	//header("Location: ../bienvenido.php");
} else {
	$data1 = mysql_fetch_array($result1);
	$data2 = mysql_fetch_array($result2);

	$caractArray[][2]="";
	$i=0;
	while ( $data4 = mysql_fetch_array($result4, MYSQL_ASSOC)){
		$caractArray[$i][0]= $data4["caracteristicas_idcaracteristicas"];
		$caractArray[$i][1]= $data4["cantidad"];
		$i++;
	}
	function checarIncluyeCaract($idC ){

		global $caractArray;
		$cantidad="";
		foreach($caractArray as $value){
			if($value[0]==$idC){
				$cantidad=$value[1];
			}
		}
		return $cantidad;
	}
	$atributoArray[][2]="";
	$i=0;
	while ( $data3 = mysql_fetch_array($result3, MYSQL_ASSOC)){
		$atributoArray[$i][0]= $data3["idatributo"];
		$atributoArray[$i][1]= $data3["calificacion"];
		$i++;
	}
	function checarIncluyeAtributo($idA ){

		global $atributoArray;
		$calif="";
		foreach($atributoArray as $value){
			if(isset($value[0]) && $value[0]==$idA){
				$calif=$value[1];
			}
		}
		return $calif;
	}
}
?>
<div class="container">
	<div class="row">
		<div class="span7 offset2">
			<div class="alert alert-info">
				<button class="close" data-dismiss="alert">�</button>
				<strong>Atenci&oacute;n!</strong> Aseg&uacute;rate de llenar la
				informaci&oacute;n de todas las etiquetas.
			</div>
			<form id="registroModelo" class="forma form-horizontal well"
				action="control/EditarModelo.php" method="post"
				enctype="multipart/form-data">
				<div class="tabbable">
					<!-- Only required for left/right tabs -->
					<ul class="nav nav-tabs">
						<li class="active"><a href="#tab1" data-toggle="tab">Datos
								b&aacute;sicos</a></li>
						<li><a href="#tab2" data-toggle="tab">Caracter&iacute;sticas</a></li>
						<li><a href="#tab3" data-toggle="tab">Im&aacute;genes</a></li>
						<li><a href="#tab4" data-toggle="tab">Atributos</a></li>
					</ul>
					<div class="tab-content">
						<div class="tab-pane active" id="tab1">
							<h1>Datos del modelo horizontal</h1>
							<input type="hidden" name="idmodelo"
								value="<?php echo $idModelo?>">
							<fieldset>
								<legend>Informaci&oacute;n necesaria</legend>
								<input type="hidden" id="modelo" value="<?php echo $idModelo?>">
								<?php 
								$q = "SELECT idproyecto, nombre, promotor FROM proyecto WHERE tipo= 'horizontal' ";
								$proyectos = mysql_query( $q);
								if (!$proyectos) {
									die('No se pudo realizar la consulta:' . mysql_error());
									header("Location: ../index.php");
								} else {
									?>
								<div class="control-group">
									<label class="control-label" for="proyecto">Proyecto</label>
									<div class="controls">
										<input type="hidden" name="tipo" value="horizontal"> <select
											class="span2" name='proyecto'>
											<?php 
											while ($data = mysql_fetch_array($proyectos, MYSQL_ASSOC)) {
												if($data1["proyecto_idproyecto"]==$data["idproyecto"]){?>
											<option value="<?php echo $data["idproyecto"]?>"
												selected=selected>
												<?php echo $data["nombre"]?>
												-
												<?php echo $data["promotor"]?>
											</option>
											<?php }else{ ?>
											<option value="<?php echo $data["idproyecto"]?>">
												<?php echo $data["nombre"]?>
												-
												<?php echo $data["promotor"]?>
											</option>
											<?php 
												}
											}
								}
								?>
										</select> <span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="nombres">Nombre del modelo</label>
									<div class="controls">
										<input name="nombre" id="nombre" class="input-large"
											type="text" value="<?php echo $data1["nombre"]?>">
										<div class="alert alert-error" id="alertNombre"
											style="display: none">
											<strong>Atenci&oacute;n!</strong> El nombre ya existe.
											Selecciona otro.
										</div>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="diferenciadores">Diferenciadores</label>
									<div class="controls">
										<textarea name="diferenciadores" id="diferenciadores"
											class="input-large">
											<?php echo $data1["diferenciadores"]?>
										</textarea>
										<span class="help-inline"></span>
									</div>
								</div>
							</fieldset>
							<fieldset>
								<legend>Informaci&oacute;n num&eacute;rica</legend>
								<div class="control-group">
									<label class="control-label" for="absorcion">Absorci&oacute;n</label>
									<div class="controls">
										<input name="absorcion" id="absorcion" class="input-small"
											type="text" value="<?php echo $data2["absorcion"]?>"> <span
											class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="precio">Precio</label>
									<div class="controls">
										$ <input name="precio" id="precio" class="input-small"
											type="text" value="<?php echo $data2["precio"]?>"> <span
											class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="metrosCuadrados">Metros
										cuadrados</label>
									<div class="controls">
										<input name="metrosCuadrados" id="metrosCuadrados"
											class="input-small" type="text"
											value="<?php echo $data1["metrosCuadrados"]?>"> <span
											class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="precioTerreno">Precio m2 de
										terreno</label>
									<div class="controls">
										$ <input name="precioTerreno" id="precioTerreno"
											class="input-small" type="text"
											value="<?php echo $data2["precioTerreno"]?>"> <span
											class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<div class="control-group">
										<label class="control-label" for="m2Terreno">Metros cuadrados
											del terreno</label>
										<div class="controls">
											<input name="m2Terreno" id="m2Terreno" class="input-small"
												type="text"> <span class="help-inline"></span>
										</div>
									</div>
									<label class="control-label" for="unidadesTotales">Unidades
										totales*</label>
									<div class="controls">
										<input name="unidadesTotales" id="unidadesTotales"
											class="input-small" type="text"
											value="<?php echo $data1["unidades"]?>"> <span
											class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="unidadesVendidas">Unidades
										vendidas*</label>
									<div class="controls">
										<input name="unidadesVendidas" id="unidadesVendidas"
											class="input-small" type="text"
											value="<?php echo $data1["unidadesVendidas"]?>"> <span
											class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="montoSeparacion">Monto de
										separaci&oacute;n</label>
									<div class="controls">
										$ <input name="montoSeparacion" id="montoSeparacion"
											class="input-small" type="text"
											value="<?php echo $data1["montoSeparacion"]?>"> <span
											class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="porcentajeEngancheMin">Porcentaje
										de enganche m&iacute;nimo</label>
									<div class="controls">
										<select class="span2" name='porcentajeEngancheMin'>
											<?php 
											$percent = 0;
											while($percent<=100){
												if($data1["porcentajeEngancheMin"]==$percent){
													?>
											<option value="<?php echo $percent?>" selected=selected>
												<?php echo $percent?>
												%
											</option>
											<?php } else {?>
											<option value="<?php echo $percent?>">
												<?php echo $percent?>
												%
											</option>
											<?php 
													}$percent+=5;
										 }
											?>
										</select>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="creditoSobreEnganche">Cr&eacute;dito
										sobre enganche</label>
									<div class="controls">
										<input name="creditoSobreEnganche" id="creditoSobreEnganche"
											class="input-small" type="text"
											value="<?php echo $data2["creditoSobreEnganche"]?>"> meses <span
											class="help-inline"></span>
									</div>
								</div>
							</fieldset>
						</div>
						<?php 
						$c = "SELECT * FROM `caracteristicas`";
						$dataCaract = mysql_query( $c );
						if (!$dataCaract) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
							?>
						<!-- Caracteristicas -->
						<div class="tab-pane" id="tab2">
							<h1>Caracter&iacute;sticas del modelo</h1>
							<fieldset>
								<legend>Otras caracter&iacute;sticas</legend>
								<?php 
								while ($data = mysql_fetch_array($dataCaract, MYSQL_ASSOC)) {
									?>
								<div class="control-group">
									<label class="control-label" for="<?php echo $data["nombre"]?>"><?php echo $data["nombre"]?>
									</label>
									<div class="controls">
										<select class="span2"
											name='caracteristicas_<?php echo $data["idcaracteristicas"]?>'>
											<?php 
											$int = 0;
											while($int <=10){
												if(checarIncluyeCaract($data["idcaracteristicas"])==$int){
													?>
											<option value="<?php echo $int?>" selected=selected>
												<?php echo $int?>
											</option>
											<?php } else {?>
											<option value="<?php echo $int?>">
												<?php echo $int?>
											</option>
											<?php
													}
													if($data["nombre"]=="Ba�os"){
														$int+=0.5;
													}else {
														$int++;
													}
											}
											?>
										</select> <span class="help-inline"></span>
									</div>
								</div>
								<?php 
								}
						}
						?>
							</fieldset>
						</div>
						<!-- Imagenes -->
						<div class="tab-pane" id="tab3">
							<h1>Im&aacute;genes del modelo</h1>
							<fieldset>
								<legend>Distribuci&oacute;n</legend>
								<div id="distribuciones">
									<?php 
									$imagenes="SELECT * FROM imagenes WHERE modelo_idmodelo='".$idModelo."' AND tipo = 'distribucion'";
									$result=mysql_query($imagenes);
									$i=1;
                                 while($data=mysql_fetch_array($result)){?>
									<div class="control-group">
										<label class="control-label" for="distribucion1">Im&aacute;gen
											de distribuci&oacute;n <?php echo $i?>
										</label>
										<div class="controls">
											<img src="<?php echo $data["path"]?>"
												id="<?php echo $data["idimagenes"]?>"> <input type="hidden"
												name="eliminaImagen<?php echo $data["idimagenes"]?>"
												id="eliminaImagen<?php echo $data["idimagenes"]?>"> <a
												href="#" class="btn"
												onclick="EliminaImagen2(<?php echo $data["idimagenes"]?>,<?php echo $i?>)"><i
												class="icon-remove-circle"></i>Eliminar</a> <span
												class="help-inline"></span>

										</div>
									</div>
									<?php $i++;
}?>
								</div>
								<input type="hidden" id="contDist" name="contDist"
									value="<?php echo $i?>"> <a class="btn"
									onclick="createDivDistribuciones()"><i class="icon-plus-sign"></i>Agregar
									otra</a>

							</fieldset>
							<fieldset>
								<legend>Im&aacute;genes de fachadas </legend>
								<div id="fachadas">
									<?php $imagenes = "SELECT * FROM imagenes WHERE modelo_idmodelo ='".$idModelo."' AND tipo = 'fachada'";
									$result7 = mysql_query( $imagenes);
									$j=1;
									while($data7 = mysql_fetch_array($result7)){
										?>
									<div class="control-group" id="fachadas">
										<label class="control-label" for="fachada<?php echo $j?>">Im&aacute;gen
											de fachada <?php echo $j?>
										</label>
										<div class="controls">
											<img src="<?php echo $data7["path"]?>"
												id="<?php echo $data7["idimagenes"]?>"> <input type="hidden"
												name="eliminaImagen<?php echo $data7["idimagenes"]?>"
												id="eliminaImagen<?php echo $data7["idimagenes"]?>"> <a
												href="#" class="btn"
												onclick="EliminaImagen1(<?php echo $data7["idimagenes"]?>)"><i
												class="icon-remove-circle"></i>Eliminar</a> <span
												class="help-inline"></span>
										</div>
									</div>
									<?php $j++;
}?>
								</div>
								<input type='hidden' id="contFachadas" name="contFachadas"
									value="<?php echo $j?>"> <a class="btn"
									onclick="createDivFachadas()"><i class="icon-plus-sign"></i>Agregar
									otra</a>
							</fieldset>
						</div>
						<?php 
						$a = "SELECT * FROM `atributos` ORDER BY nombre ASC";
						$dataAtributos = mysql_query( $a );
						if (!$dataAtributos) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
							?>
						<!-- Atributos -->
						<div class="tab-pane" id="tab4">
							<fieldset>
								<legend>Atributos del modelo</legend>
								<div class="control-group">
									<label class="control-label">Seleccionar y calificar atributos:</label>
									<div class="controls">
										<?php 
										while ($data = mysql_fetch_array($dataAtributos, MYSQL_ASSOC)) {
											$calificacion=checarIncluyeAtributo($data["idatributos"]);
											if($calificacion==""){
												?>
										<label class="checkbox"> <input
											id="<?php echo $data["idatributos"]?>" type="checkbox"
											value="<?php echo  $data["nombre"]?>"
											name="atributo_<?php echo  $data["idatributos"]?>"> <?php echo $data["nombre"]?>
										</label>
										<div class="controls">
											<input id="<?php echo  $data["idatributos"]?>" type="radio"
												value="Verde"
												name="calificacion_<?php echo  $data["idatributos"]?>"><img
												src="assets/img/bullet_green.png" /> <input
												id="<?php echo  $data["idatributos"]?>" type="radio"
												value="Amarillo"
												name="calificacion_<?php echo $data["idatributos"]?>"><img
												src="assets/img/bullet_yellow.png" /> <input
												id="<?php echo  $data["idatributos"]?>" type="radio"
												value="Rojo"
												name="calificacion_<?php echo $data["idatributos"]?>"><img
												src="assets/img/bullet_red.png" />
										</div>
										<hr />
										<?php
											}else if($calificacion!=""){ ?>
										<label class="checkbox"> <input
											id="<?php echo $data["idatributos"]?>" type="checkbox"
											checked=checked value="<?php echo  $data["nombre"]?>"
											name="atributo_<?php echo  $data["idatributos"]?>"> <?php echo $data["nombre"]?>
										</label>
										<div class="controls">
											<?php if($calificacion=="Verde"){?>
											<input id="<?php echo  $data["idatributos"]?>" type="radio"
												checked=checked value="Verde"
												name="calificacion_<?php echo  $data["idatributos"]?>"><img
												src="assets/img/bullet_green.png" />
											<?php } else {?>
											<input id="<?php echo  $data["idatributos"]?>" type="radio"
												value="Verde"
												name="calificacion_<?php echo  $data["idatributos"]?>"><img
												src="assets/img/bullet_green.png" />
											<?php } 
                                      if($calificacion=="Amarillo"){?>
											<input id="<?php echo  $data["idatributos"]?>" type="radio"
												checked=checked value="Amarillo"
												name="calificacion_<?php echo $data["idatributos"]?>"><img
												src="assets/img/bullet_yellow.png" />
											<?php } else {?>
											<input id="<?php echo  $data["idatributos"]?>" type="radio"
												value="Amarillo"
												name="calificacion_<?php echo $data["idatributos"]?>"><img
												src="assets/img/bullet_yellow.png" />
											<?php }
                                     if($calificacion=="Rojo"){ ?>
											<input id="<?php echo  $data["idatributos"]?>" type="radio"
												checked=checked value="Rojo"
												name="calificacion_<?php echo $data["idatributos"]?>"><img
												src="assets/img/bullet_red.png" />
											<?php } else {?>
											<input id="<?php echo  $data["idatributos"]?>" type="radio"
												value="Rojo"
												name="calificacion_<?php echo $data["idatributos"]?>"><img
												src="assets/img/bullet_red.png" />
											<?php }?>
										</div>
										<hr />
										<?php }
										}
						}
						?>
										<span class="help-inline"></span>
									</div>
								</div>
							</fieldset>
						</div>
					</div>
					<!-- div tab-content -->
					<div class="tabbable tabs-below">
						<!-- Only required for left/right tabs -->
						<ul class="nav nav-tabs">
							<li class="active"><a href="#tab1" data-toggle="tab">Datos
									b&aacute;sicos</a></li>
							<li><a href="#tab2" data-toggle="tab">Caracter&iacute;sticas</a>
							</li>
							<li><a href="#tab3" data-toggle="tab">Im&aacute;genes</a></li>
							<li><a href="#tab4" data-toggle="tab">Atributos</a></li>
						</ul>
						<div class="form-actions">
							<button class="btn btn-primary" type="submit">Editar</button>
							<a href="#modalCancel" data-toggle="modal"
								class="openCancel2 btn"> Cancelar</a> <span id="errorBoton"
								style="color: red"></span>
						</div>

					</div>
				</div>
				<div id="modalCancel1" class="modal hide fade in">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">x</button>
						<h3>Cancelar edici&oacute;n</h3>
					</div>
					<div class="modal-body">
						<p>Atenci&oacute;n! Los campos modificados no se guardar&aacute;n</p>
						<p>Deseas continuar?</p>
					</div>
					<div class="modal-footer">
						<a
							href="<?php if(isset($_SESSION['pageFrom'])){echo $_SESSION['pageFrom'];} else {?>bienvenido<?php }?>.php"
							class="quit btn btn-danger">Cancelar</a> <a href="#"
							class="btn secondary" data-dismiss="modal">Regresar</a>
					</div>
				</div>
			</form>
		</div>
		<!-- /span -->
	</div>
	<!-- /row -->
</div>
<!-- /container -->
<script type="text/javascript">
   	function EliminaImagen1(id){
		document.getElementById(id).style.visibility="hidden";
		document.getElementById("eliminaImagen"+id).value=id;
		}
   	function EliminaImagen2(id,file){
		document.getElementById(id).style.visibility="hidden";
		document.getElementById("eliminaImagen"+id).value=id;
		}
        </script>
<?php 
include "includes/footer_principal.php";
?>