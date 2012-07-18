<?php
/* Pagina de reporte - Ficha
 Se despliegan los datos basicos del proyecto seleccionado y de sus respectivos modelos.
Se despliegan imagenes, tablas, graficas, links. Los datos calculados se muestran en
esta pagina y son calculados por el sistema.
Esta pagina es accesada por todos los usuarios registrados.
*/
$pageTitle = "SIGII | Reporte Ficha";
include "includes/header_aplicacion.php";
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$idproyecto=$_POST["idproy"];
//Consultas a base de datos
//Consulta de datos del proyecto
$dataProyectos = "SELECT * FROM proyecto p
INNER JOIN zona z ON z.idzona=p.zona_idzona AND p.idproyecto = '".$idproyecto."'";
$result = mysql_query( $dataProyectos );
$dataProyecto=mysql_fetch_array($result);
//Consultas de imagenes
//Consulta de imagen de logo
$dataImagenesLogo = "SELECT * FROM imagenes WHERE tipo = 'logo' AND proyecto_idproyecto ='".$idproyecto."'";
$result2 = mysql_query( $dataImagenesLogo );
//Consulta del numero de modelos
$contModelos = "SELECT count(idmodelo) as numeroModelos FROM modelo WHERE proyecto_idproyecto ='".$idproyecto."'";
$result3 = mysql_query( $contModelos );
//Consulta de imagen de plano (lotificacion o previatorre)
$dataImagenesPlano = "SELECT * FROM imagenes WHERE tipo = 'plano' AND proyecto_idproyecto ='".$idproyecto."'";
$result4 = mysql_query( $dataImagenesPlano );
//Consulta de imagenes de amenidad
$dataImagenesAmenidad = "SELECT * FROM imagenes WHERE tipo LIKE 'amenidad%' AND proyecto_idproyecto ='".$idproyecto."'";
$result5 = mysql_query( $dataImagenesAmenidad );
//Consulta del promedio de metros cuadrados obtenidos de los modelos
$promedioM2="SELECT avg(m.metrosCuadrados) as promM2 FROM modelo m
WHERE m.proyecto_idproyecto = '".$idproyecto."';";
$result6=mysql_query($promedioM2);
$dataM2=mysql_fetch_array($result6);
//Consulta del promedio de precio y credito obtenidos del promedio de los modelos horizontales
$precioYcredito = "SELECT avg(mf.precio) as precio, avg(mf.creditoSobreEnganche) as credito
FROM sigii.modelofraccionamiento mf
INNER JOIN modelo m ON mf.modelo_idmodelo= m.idmodelo AND m.proyecto_idproyecto='".$idproyecto."'";
$result7=mysql_query($precioYcredito);
$dataprecioYcredito=mysql_fetch_array($result7);
//Consulta de datos de proyectos verticales
$dataProyectosDept = "SELECT * FROM proyectodepartamento p WHERE  p.proyecto_idproyecto = '".$idproyecto."'";
$result8 = mysql_query( $dataProyectosDept );
//Consulta de datos de proyectos horizontales
$dataProyectosFracc = "SELECT * FROM proyectofraccionamiento f WHERE  f.proyecto_idproyecto = '".$idproyecto."'";
$result9 = mysql_query( $dataProyectosFracc );
//Consulta de amenidades
$dataAmenidades="SELECT * FROM incluyeamenidad ia
INNER JOIN amenidad a ON a.idamenidad=ia.amenidad_idamenidad AND ia.proyecto_idproyecto = '".$idproyecto."'";
$result10 = mysql_query( $dataAmenidades );
if($dataProyecto["tipo"]=="vertical"){
	//Consulta de modelos verticales
	$dataModelos="SELECT * FROM sigii.modelodepartamento md
	INNER JOIN modelo m ON m.idmodelo = md.modelo_idmodelo AND m.proyecto_idproyecto='".$idproyecto."'";
	$result11 = mysql_query( $dataModelos );
} else if($dataProyecto["tipo"]=="horizontal"){
	//Consulta de modelos horizontales
	$dataModelos="SELECT * FROM sigii.modelofraccionamiento mf
	INNER JOIN modelo m ON m.idmodelo = mf.modelo_idmodelo AND m.proyecto_idproyecto='".$idproyecto."'";
	$result11 = mysql_query( $dataModelos );
}
$puntos="SELECT * FROM incluyepuntoafluencia ip
INNER JOIN puntosafluencia p ON p.idpuntosAfluencia= ip.idpuntoafluencia
AND ip.idproyecto='".$idproyecto."'";
$result12 = mysql_query( $puntos );
//Pasar datos a arrays
$cont=mysql_fetch_array($result3);
$dataProyectoDept=mysql_fetch_array($result8);
$dataProyectoFracc=mysql_fetch_array($result9);
$dataImagen=mysql_fetch_array($result2);
$dataImagenPlano=mysql_fetch_array($result4);
if (!$result) {
	$_SESSION['error'] = "lectura";
	$_SESSION['errormsg'] = "Hubo un error al leer la base de datos";
	$_SESSION['pageFrom']="ficha";
	header("Location: error.php");
}
?>
<div class="container-fluid">
	<div class="row">
		<div class="tabbable tabs-left">
			<!-- Only required for left/right tabs -->
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab1" data-toggle="tab">Portada</a></li>
				<li><a href="#tab2" data-toggle="tab">Amenidades</a></li>
				<?php $i=1;
					 while($i<=$cont["numeroModelos"]){?>
				<li><a href="#tab<?php echo ($i+2)?>" data-toggle="tab">Modelo <?php echo $i?>
				</a></li>			
				<?php $i++;
}?>
	<li><a href="javascript:printDiv('tab1')" >Imprimir esta página <img src="assets/img/Printer-icon.png"  /></a> </li>
	
			</ul>
			<div class="tab-content">
				<!-- Portada -->
				<div class="tab-pane active" id="tab1">
					<div class="row-fluid">
						<!-- Div del logo, imagen de torre y descripcion  -->
						<div class="span8 hero-unit">
							<a href="<?php echo $dataProyecto["linkWebpage"]?>"
								target="_blank" class="thumbnail"><img
								src="<?php echo $dataImagen["path"]?>" /> </a> <a href=""
								target="_blank" class="thumbnail"><img
								src="<?php echo $dataImagenPlano["path"]?>" /> </a>
							<table class="table table-bordered table-striped">
								<tr>
									<th>Descipci&oacute;n</th>
								</tr>
							<tr>
								<td><?php echo $dataProyecto["descripcion"]?></td>
							</tr>
						</table>
						<table class="table table-bordered table-striped">
								<tr>
									<th colspan="2">Puntos de afluencia</th>									
								</tr>
								
								<?php while($dataPuntos=mysql_fetch_array($result12)){?>
							<tr>
								<td> <img src="<?php echo $dataPuntos["logo"]?>"/> <?php echo $dataPuntos["nombre"]?> </td>
								<td><?php echo $dataPuntos["distancia"]?> kms.</td>
							</tr>
							<?php }?>
						</table>
						</div>
						<!-- Div de la tabla con informacion basica -->
						<div class="span4 offset4 hero-unit">
							<!--Body content-->
							<table class="table table-condensed">
								<tr>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<th>Absorci&oacute;n</th>
									<td><?php if($dataProyecto["tiempoMercado"]!=0){ echo round($dataProyecto["unidadesVendidas"]/$dataProyecto["tiempoMercado"],2);}?>
									</td>
								</tr>
								<?php if($dataProyecto["vendidas1Q"]>0){?>
								<tr>
									<th>Absorci&oacute;n 1Q</th>
									<td><?php echo round($dataProyecto["vendidas1Q"]/3,2)?></td>
								</tr>
								<?php }
								if($dataProyecto["vendidas2Q"]>0){
								?>
								<tr>
									<th>Absorci&oacute;n 2Q</th>
									<td><?php echo round($dataProyecto["vendidas2Q"]/3,2)?></td>
								</tr>
								<?php }
								if($dataProyecto["vendidas3Q"]>0){?>
								<tr>
									<th>Absorci&oacute;n 3Q</th>
									<td><?php echo round($dataProyecto["vendidas3Q"]/3,2)?></td>
								</tr>
								<?php }
								if($dataProyecto["vendidas4Q"]>0){?>
								<tr>
									<th>Absorci&oacute;n 4Q</th>
									<td><?php echo round($dataProyecto["vendidas4Q"]/3,2)?></td>
								</tr>
								<?php }?>
								<tr>
									<th>Unidades totales</th>
									<td><?php echo $dataProyecto["unidadesTotales"]?></td>
								</tr>
								<tr>
									<th>Unidades vendidas</th>
									<td><?php echo $dataProyecto["unidadesVendidas"]?></td>
								</tr>
								<tr>
									<th>Unidades disponibles</th>
									<td><?php echo ($dataProyecto["unidadesTotales"]-$dataProyecto["unidadesVendidas"])?>
									</td>
								</tr>
								<tr>
									<th>M<sup>2</sup> promedio
									</th>
									<td><?php echo round($dataM2["promM2"], 0, PHP_ROUND_HALF_UP);?>
									</td>
								</tr>
								<tr>
									<th>Precio promedio</th>
									<td>$<?php echo number_format(round($dataprecioYcredito["precio"],2), 2, '.', ',');?>
									</td>
								</tr>
								<tr>
									<th>Precio promedio M<sup>2</sup>
									</th>
									<td>$<?php if(round($dataM2["promM2"], 0, PHP_ROUND_HALF_UP)!=0){
										echo number_format(round(($dataprecioYcredito["precio"]/round($dataM2["promM2"], 0, PHP_ROUND_HALF_UP)),2), 2, '.', ',');
									}?>
									</td>
								</tr>
								<tr>
									<?php if($dataProyecto["tipo"]=="vertical"){?>
									<th>N&uacute;mero de pisos</th>
									<td><?php echo $dataProyectoDept["pisos"]?></td>
								</tr>
								<tr>
									<th>N&uacute;mero de torres</th>
									<td><?php echo $dataProyectoDept["torres"]?></td>
								</tr>
								<?php } else {?>
								<tr>
									<th>Unidades de etapa</th>
									<td><?php echo $dataProyectoFracc["unidadesEtapa"]?></td>
								</tr>
								<?php }?>
								<tr>
									<th>N&uacute;mero de modelos</th>
									<td><?php echo $dataProyecto["numeroModelos"]?></td>
								</tr>
								<tr>
									<th>Tiempo en el mercado</th>
									<td><?php echo $dataProyecto["tiempoMercado"]?></td>
								</tr>
								<tr>
									<th>Tipo de entrega</th>
									<td><?php echo $dataProyecto["entrega"]?></td>
								</tr>
							</table>
						</div>
						<!-- Div de la tabla con caracteristicas -->
						<div class="span4 offset4 hero-unit">
							<!--Body content-->
							<table class="table table-condensed table-striped">
								<tr>
									<th>Caracter&iacute;sticas generales</th>
								</tr>
								<tr>
									<td><?php echo $dataProyecto["caracteristicas"]?></td>
								</tr>
							</table>
						</div>
						<!-- Div de la tabla con amenidades -->
						<div class="span4 offset4 hero-unit">
							<!--Body content-->
							<table class="table table-condensed">
								<tr>
									<th>Amenidades</th>
								</tr>
								<?php while($dataAmenidad=mysql_fetch_array($result10)){?>
								<tr>
									<td><?php echo $dataAmenidad["nombre"]?></td>
								</tr>
								<?php }?>
							</table>
						</div>
					</div>
				</div>
				<!-- Amenidades -->
				<div class="tab-pane" id="tab2">
					<div class="span2 hero-unit">
						<?php while($data1=mysql_fetch_array($result5)){?>
						<a href="#" class="thumbnail"><img
							src="<?php echo $data1["path"]?>" /> </a>
						<?php }?>
					</div>
					<div class="span6 hero-unit">
						<p>
							<?php echo $dataProyecto["amenidadesDescripcion"]?>
						</p>
					</div>
				</div>
				<!-- Modelos del proyecto -->
				<?php $i=3; while($dataModelo=mysql_fetch_array($result11)){
					//Consulta de imagen de desitribucion del modelo
					$imagenesModelo="SELECT * FROM imagenes WHERE tipo='distribucion' AND modelo_idmodelo='".$dataModelo["idmodelo"]."'";
					$res=mysql_query($imagenesModelo);
					$imagenModelo=mysql_fetch_array($res);
					//Consulta de caracteristicas del modelo
					$caractModelo="SELECT * FROM incluyecaracteristica ic
					INNER JOIN caracteristicas c ON c.idcaracteristicas = ic.caracteristicas_idcaracteristicas AND ic.modelo_idmodelo='".$dataModelo["idmodelo"]."'";
					$res1=mysql_query($caractModelo);
					//Consulta de atributos del modelo
					$atributosModelo="SELECT * FROM incluyeatributo ia
					INNER JOIN atributos a ON ia.idatributo=a.idatributos AND ia.idmodelo='".$dataModelo["idmodelo"]."'";
					$res2=mysql_query($atributosModelo);
					//Consulta de acabados del proyecto
					$acabadosModelo="SELECT * FROM incluyeacabado ia
					INNER JOIN acabado a ON ia.acabado_idacabado=a.idacabado AND ia.proyecto_idproyecto='".$dataProyecto["idproyecto"]."'";
					$res3=mysql_query($acabadosModelo);
					?>
				<div class="tab-pane" id="tab<?php echo $i?>">
					<div class="row-fluid">
						<div class="span5 hero-unit">
							<h3>
								Modelo
								<?php echo $dataModelo["nombre"]?>
							</h3>
							<a href="#" class="thumbnail"><img
								src="<?php echo $dataImagen["path"]?>" /> </a> </br> <a href=""
								target="_blank" class="thumbnail"><img
								src="<?php echo $imagenModelo["path"]?>" /> </a> </br>
							<table class="table table-bordered table-striped">
								<tr>
									<th>Diferenciadores</th>
								</tr>
								<tr>
									<td>
										<p>
											<?php echo $dataModelo["diferenciadores"]?>
										
										<p>
									
									</td>
								</tr>
							</table>
						</div>
						<!-- principal -->
						<div class="span4 hero-unit">
							<table class="table table-condensed">								
									<tr>
									<th>M<sup>2</sup>
									</th>
									<td><?php echo $dataModelo["metrosCuadrados"]?></td>
								</tr>
								<?php if($dataProyecto["tipo"]=="vertical"){?>
								<tr>
									<th>Precio M<sup>2</sup>
									</th>
									<td>$<?php if($dataModelo["metrosCuadrados"]!=0){
										echo round($dataModelo["precioPromedio"]/$dataModelo["metrosCuadrados"],2);
									}?>
									</td>
								</tr>
								<?php } else if($dataProyecto["tipo"]=="horizontal"){?>
								<tr>
									<th>Precio M<sup>2</sup>
									</th>
									<td>$<?php if($dataModelo["metrosCuadrados"]!=0){
										echo round($dataModelo["precio"]/$dataModelo["metrosCuadrados"],2);
									}?>
									</td>
								</tr>
								<?php }?>
								<?php if($dataProyecto["tipo"]=="vertical"){?>
								<tr>
									<th>Precio promedio</th>
									<td>$<?php echo $dataModelo["precioPromedio"]?>
									</td>
								</tr>
								<tr>
									<th>Precio m&iacute;nimo</th>
									<td>$<?php echo $dataModelo["precioMin"]?>
									</td>
								</tr>
								<tr>
									<th>Precio m&aacute;ximo</th>
									<td>$<?php echo $dataModelo["precioMax"]?>
									</td>
								</tr>
								<tr>
									<th>Diferencia</th>
									<td>$<?php echo ($dataModelo["precioMax"]-$dataModelo["precioMin"])?>
									</td>
								</tr>
								<tr>
									<th>Aumento por piso</th>
									<td>$<?php echo $dataModelo["aumentoXPiso"]?></td>
								</tr>
								<?php } else if($dataProyecto["tipo"]=="horizontal"){?>
								<tr>
									<th>Precio</th>
									<td>$<?php echo $dataModelo["precio"]?>
									</td>
								</tr>
								<tr>
									<th>M<sup>2</sup> Terreno
									</th>
									<td><?php echo $dataModelo["m2Terreno"]?></td>
								</tr>
								<tr>
									<th>Precio M<sup>2</sup> Terreno
									</th>
									<td>$<?php echo $dataModelo["precioTerreno"]?></td>
								</tr>
								<tr>
									<th>Precio estimado de terreno</th>
									<td>$<?php echo round($dataModelo["precioTerreno"]*$dataModelo["m2Terreno"],2)?>
									</td>
								</tr>
								<tr>
									<th>Precio estimado de construcci&oacute;n</th>
									<td>$<?php echo round(($dataModelo["precio"]-($dataModelo["precioTerreno"]*$dataModelo["m2Terreno"])),2)?>
									</td>
								</tr>
								<tr>
									<th>Precio M<sup>2</sup> de construcci&oacute;n
									</th>
									<td>$<?php echo round(($dataModelo["precio"]-($dataModelo["precioTerreno"]*$dataModelo["m2Terreno"]))/$dataModelo["metrosCuadrados"],2)?>
									</td>
								</tr>
								<tr>
									<th>M<sup>2</sup> construcci&oacute;n / M<sup>2</sup> terreno
									</th>
									<td><?php echo round($dataModelo["metrosCuadrados"]/$dataModelo["m2Terreno"],2)?>
									</td>
								</tr>

								<?php }?>							
								<?php 
       while( $caracteristicasModelo=mysql_fetch_array($res1)){?>
								<tr>
									<th><?php echo $caracteristicasModelo["nombre"]?></th>
									<td><?php if($caracteristicasModelo["nombre"]=="Baños"){
										echo $caracteristicasModelo["cantidad"];
									}else{echo round($caracteristicasModelo["cantidad"],0);
									}?>
									</td>
								</tr>
								<?php }?>
								<tr>
									<th>Monto para separar</th>
									<td>$<?php echo $dataModelo["montoSeparacion"]?>
									</td>
								</tr>
								<tr>
									<th>Porcentaje de enganche m&iacute;nimo</th>
									<td><?php echo $dataModelo["porcentajeEngancheMin"]?>%</td>
								</tr>
								<?php if($dataProyecto["tipo"]=="vertical"){?>
								<tr>
									<th>Monto en cantidad</th>
									<td>$<?php echo round($dataModelo["precioPromedio"]*($dataModelo["porcentajeEngancheMin"]/100),2)?>
									</td>
								</tr>
								<?php } else if($dataProyecto["tipo"]=="horizontal"){?>
								<tr>
									<th>Monto en cantidad</th>
									<td>$<?php echo round($dataModelo["precio"]*($dataModelo["porcentajeEngancheMin"]/100),2)?>
									</td>
								</tr>
								<?php }?>
							</table>
						</div>
						<!-- atributo -->
						<div class="span3 hero-unit">
							<table class="table table-condensed">
								<tr>
									<th>Atributo</th>
									<th>Evaluaci&oacute;n</th>
								</tr>
								<?php while( $atributoModelo=mysql_fetch_array($res2)){?>
								<tr>
									<td><?php echo $atributoModelo["nombre"]?></td>
									<?php if($atributoModelo["calificacion"]=="Verde"){?>
									<td><img src="assets/img/bullet_green.png" /></td>
									<?php } else if($atributoModelo["calificacion"]=="Amarillo"){ ?>
									<td><img src="assets/img/bullet_yellow.png" /></td>
									<?php } else if($atributoModelo["calificacion"]=="Rojo"){?>
									<td><img src="assets/img/bullet_red.png" /></td>
									<?php }?>
								</tr>
								<?php }?>
							</table>
						</div>
						<!-- acabado -->
						<div class="span3 hero-unit">
							<table class="table table-condensed">
								<tr>
									<th>Acabado</th>
									<th>Cumplimiento</th>
								</tr>
								<?php while( $acabadoModelo=mysql_fetch_array($res3)){?>
								<tr>
									<td><?php echo $acabadoModelo["nombre"]?></td>
									<td><?php echo $acabadoModelo["cumplimiento"]?></td>
								</tr>
								<?php }?>
							</table>
						</div>
					</div>
				</div>
				<?php $i++;}?>
			</div>
		</div>
	</div>
	<!-- row -->
</div>
<iframe name=print_frame width=0 height=0 frameborder=0 src=about:blank></iframe>

<!-- /container -->
<script type="text/javascript">
printDivCSS = new String ('<link href="myprintstyle.css" rel="stylesheet" type="text/css">')
function printDiv(divId) {
    window.frames["print_frame"].document.body.innerHTML=document.getElementById(divId).innerHTML
    window.frames["print_frame"].window.focus()
    window.frames["print_frame"].window.print()
}
</script>
<?php  include "includes/footer_aplicacion_1.php" ?>