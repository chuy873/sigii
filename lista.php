<?php
/*
 * Pagina de reporte: Lista
 * Se muestra la informacion de los proyectos en tablas.
 */
$pageTitle = "SIGII | Listado de proyectos";

include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$dataProyectos = "SELECT * FROM proyecto p 
INNER JOIN proyectofraccionamiento f ON p.idproyecto=f.proyecto_idproyecto 
INNER JOIN zona z ON z.idzona=p.zona_idzona;";
$result = mysql_query( $dataProyectos );
$dataProyectosDept = "SELECT * FROM proyecto p
INNER JOIN proyectodepartamento d ON p.idproyecto=d.proyecto_idproyecto
INNER JOIN zona z ON z.idzona=p.zona_idzona;";
$result1 = mysql_query( $dataProyectosDept );
if (!$result || !$result) {
	$_SESSION['error'] = "lectura";
	$_SESSION['errormsg'] = "Hubo un error al leer la base de datos";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: error.php");
}
include "includes/header_aplicacion.php";
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision" ||
		$usuariologueado->getTipo()=="captura" || $usuariologueado->getTipo()=="analisis" ||
		$usuariologueado->getTipo()=="cliente")) {
	header("Location: index.php");
}

?>
<div class="row span12 offset1">
<div class="tabbable tabs-left">
			<!-- Only required for left/right tabs -->
			<ul class="nav nav-tabs">
				<li class="active"><a href="#tab1" data-toggle="tab"><img src="assets/img/black-spot.png" /> Horizontales</a></li>
				<li><a href="#tab2" data-toggle="tab"><img src="assets/img/black-spot.png" /> Verticales</a></li>
				<br/><br/><br/>
				<li><a href="javascript:window.print()" >Imprimir esta página <img src="assets/img/Printer-icon.png"  /></a> </li>
	
				<li>	<form action="control/exportarExcel.php" method="post" target="_blank" id="FormularioExportacion">
<p>Exportar a Excel  <img src="assets/img/Excel-icon.png" class="botonExcel" /></p>
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
<input type="hidden"  name="tipo" value="lista" />
</form></li>										
		</ul>		
				<table  id="Exportar_a_Excel">
	<tr><td>
			<div class="tab-content">
				<div class="tab-pane active" id="tab1">
					<div class="row-fluid">
	<div class="span8 offset3">
		<h1>Listado de proyectos horizontales</h1>
		<?php $cont=1;
					while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
						//Promedio de metros cuadrados
						$promedioM2="SELECT avg(m.metrosCuadrados) as promM2 FROM modelo m 
									WHERE m.proyecto_idproyecto = '".$data["idproyecto"]."';";
						$result2=mysql_query($promedioM2);
						$dataM2=mysql_fetch_array($result2);
						//Promedio de metros cuadrados de terreno
						$promedioM2Terr="SELECT avg(m2Terreno) as promM2Terr, avg(precioTerreno) as precioM2Terr FROM modelofraccionamiento mf 
INNER JOIN modelo m ON mf.modelo_idmodelo=m.idmodelo AND m.proyecto_idproyecto = '".$data["idproyecto"]."';";
						$result3=mysql_query($promedioM2Terr);
						$dataM2Terr=mysql_fetch_array($result3);
						//Promedio separacion y enganche
						$promSepyEng="SELECT avg(montoSeparacion) as separacion, avg(porcentajeEngancheMin) as engancheMin
									FROM modelo  WHERE 	proyecto_idproyecto = '".$data["idproyecto"]."'";
						$result4=mysql_query($promSepyEng);
						$dataSepyEng=mysql_fetch_array($result4);
						//Precio y credito sobre enganche
						$precioYcredito = "SELECT avg(mf.precio) as precio, avg(mf.creditoSobreEnganche) as credito
						FROM sigii.modelofraccionamiento mf
						INNER JOIN modelo m ON mf.modelo_idmodelo= m.idmodelo AND m.proyecto_idproyecto='".$data["idproyecto"]."'";
						$result5=mysql_query($precioYcredito);
						$dataprecioYcredito=mysql_fetch_array($result5);
						//Promedio de caracteristicas
						$promedioCaract="SELECT avg(cantidad) as cantidad, c.nombre as nombre FROM incluyecaracteristica ic
						INNER JOIN modelo m ON ic.modelo_idmodelo=m.idmodelo
						AND m.proyecto_idproyecto='".$data["idproyecto"]."'".
						" INNER JOIN caracteristicas c ON c.idcaracteristicas=ic.caracteristicas_idcaracteristicas
						GROUP BY c.nombre;";
						$result6=mysql_query($promedioCaract);						
		?>
		<table class="table table-bordered">
			<tr>
				<!-- colspan="2" -->
				<td>No. <?php echo $cont;?>
				</td>
				<td></td>
				<th>Unidades proy. totales</th>
				<th>Unidades proy. etapa</th>
				<th>Unidades vendidas</th>
				<th>Inventario</th>
				<th>Absorci&oacute;n hist&oacute;rica</th>
				<th>M<sup>2</sup></th>
				<th>M<sup>2</sup> Terreno</th>
				<th>Precio x M<sup>2</sup></th>
			</tr>
			<tr>
				<td></td>
				<th>Nombre</th>
				<td><?php echo $data["unidadesTotales"];?></td>
				<td><?php echo $data["unidadesEtapa"];?></td>
				<td><?php echo $data["unidadesVendidas"];?></td>
				<td><?php echo ($data["unidadesTotales"]-$data["unidadesVendidas"])?></td>
				<td><?php if($data["tiempoMercado"]!=0){echo round($data["unidadesVendidas"]/$data["tiempoMercado"],2);}?></td>
				<td><?php echo round($dataM2["promM2"], 0, PHP_ROUND_HALF_UP);?></td>
				<td><?php echo round($dataM2Terr["promM2Terr"], 0, PHP_ROUND_HALF_UP);?></td>
				<td>$<?php if(round($dataM2["promM2"], PHP_ROUND_HALF_UP)!=0){echo number_format(round(($dataprecioYcredito["precio"]/round($dataM2["promM2"], 0, PHP_ROUND_HALF_UP)),2), 2, '.', ',');}?></td>
			</tr>
			<tr>
			<td>
			<table class="table">
					<tr><th>Clasificaci&oacute;n</th></tr>
					<tr><td><?php  echo $data["segmento"];?></td></tr>
					<tr><th>Tipo</th></tr>
					<tr><td><?php  echo $data["tipo"];?></td></tr>
					</table>
			</td>
			<td><table class="table">
			<tr><td><?php  echo $data["nombre"];?></td></tr>
				<tr><th>Colonia</th><td><?php  echo $data["colonia"];?></td></tr>
				<tr><th>Municipio</th><td><?php  echo $data["municipio"];?></td></tr>
				<tr><th>Zona</th><td><?php  echo $data["ciudad"];?></td></tr>
				<tr><th>Subzona</th><td><?php  echo $data["subzona"];?></td></tr>
				<tr><th>Promotor</th><td><?php  echo $data["promotor"];?></td></tr>
				</table></td>
				<td colspan="2">
					<table class="table">					
					<tr><th>Monto para separar</th><td>$<?php  echo round($dataSepyEng["separacion"],2);?></td></tr>
					<tr><th>Monto de enchanche min(%)</th><td><?php  echo round($dataSepyEng["engancheMin"],0);?>%</td></tr>
					<tr><th>Monto en cantidad</th><td>$<?php  echo number_format(round(($dataprecioYcredito["precio"]*($dataSepyEng["engancheMin"]/100)),2), 2, '.', ',');?></td></tr>
					<tr><th>Credito sobre enganche</th><td><?php echo round($dataprecioYcredito["credito"],0)?> meses</td></tr>
					</table>
					</td>
				<td colspan="2">
				<table class="table">
					<?php while($dataPromCaract=mysql_fetch_array($result6)){
					 if($dataPromCaract["nombre"]=="Recámaras"){?>
					<tr><th>Rec&aacute;maras</th><td><?php echo round($dataPromCaract["cantidad"],0)?></td></tr>
					<?php } 
					 if($dataPromCaract["nombre"]=="Baños"){?>
					<tr><th>Baños</th><td><?php echo round($dataPromCaract["cantidad"],0)?></td></tr>
					<?php }  if($dataPromCaract["nombre"]=="Niveles"){?>
					<tr><th>Niveles</th><td><?php echo round($dataPromCaract["cantidad"],0)?></td></tr>
					<?php } if($dataPromCaract["nombre"]=="Estancias"){?>
					<tr><th>Estancias</th><td><?php echo round($dataPromCaract["cantidad"],0)?></td></tr>
					<?php } if($dataPromCaract["nombre"]=="Estacionamientos"){?>
					<tr><th>Estacionamientos</th><td><?php echo round($dataPromCaract["cantidad"],0)?></td></tr>
					<?php }}?>
					<tr><th>Llamadas de seguimiento</th><td><?php  echo $data["llamadasSeguimiento"];?></td></tr>				
					</table>
				</td>
				<td colspan="4">
					<table class="table">
						<tr>
							<th>Precio</th>
							<td>$<?php echo number_format(round($dataprecioYcredito["precio"],2), 2, '.', ',');?></td>
						</tr>
						<tr>
							<th>Precio estimado terreno</th>
							<td>$<?php echo number_format(($dataM2Terr["promM2Terr"]*$dataM2Terr["precioM2Terr"]), 2, '.', ',');?> </td>
						</tr>
						<tr>
							<th>Fecha de inicio</th>
							<td><?php echo $data["inicioVentas"]?></td>
						</tr>
						<tr>
							<th>Fecha de revisi&oacute;n</th>
							<td><?php echo $data["fechaRevision"]?></td>
						</tr>
						<tr>
							<th>Tiempo en el mercado</th>
							<td><?php echo $data["tiempoMercado"]?> meses</td>
						</tr>
						<tr>
							<th>&Eacute;xito comercial</th>
							<td><?php echo  number_format(($data["unidadesVendidas"]/$data["unidadesTotales"]), 3, '.', '');?></td>
						</tr>					
					</table>
				</td>
			</tr>
		</table>

		<?php 	$cont++;	
					}

					?>
	</div>
</div>
</div>
	<div class="tab-pane" id="tab2">
	<div class="row-fluid">
	<div class="span8 offset3">
		<h1>Listado de proyectos verticales</h1>
		<?php $cont=1;
					while ($data = mysql_fetch_array($result1, MYSQL_ASSOC)) {
						//Promedio de metros cuadrados
						$promedioM2="SELECT avg(m.metrosCuadrados) as promM2 FROM modelo m 
									WHERE m.proyecto_idproyecto = '".$data["idproyecto"]."';";
						$result2=mysql_query($promedioM2);
						$dataM2=mysql_fetch_array($result2);												
						//Precios promedio	
						$preciosPromedio= "SELECT avg(precioPromedio) as precioPromedio,  avg(precioMin) as precioMin,
    avg(precioMax) as precioMax FROM modelodepartamento md
INNER JOIN modelo m ON m.idmodelo=md.modelo_idmodelo AND m.proyecto_idproyecto='".$data["idproyecto"]."'";
						$result5=mysql_query($preciosPromedio);
						$dataPrecios=mysql_fetch_array($result5);
						//Promedio de caracteristicas
						$promedioCaract="SELECT avg(cantidad) as cantidad, c.nombre as nombre FROM incluyecaracteristica ic
						INNER JOIN modelo m ON ic.modelo_idmodelo=m.idmodelo
						AND m.proyecto_idproyecto='".$data["idproyecto"]."'".
						" INNER JOIN caracteristicas c ON c.idcaracteristicas=ic.caracteristicas_idcaracteristicas
						GROUP BY c.nombre;";
						$result6=mysql_query($promedioCaract);
		?>
		<table class="table table-bordered"  >
			<tr>
				<!-- colspan="2" -->
				<td>No. <?php echo $cont;?>
				</td>
				<td></td>
				<th>Unidades totales</th>
				<th>Unidades vendidas</th>
				<th>Inventario</th>
				<th>Absorci&oacute;n hist&oacute;rica</th>
				<th>M<sup>2</sup></th>				
				<th>Precio x M<sup>2</sup></th>
			</tr>
			<tr>
				<td></td>
				<th>Nombre</th>
				<td><?php echo $data["unidadesTotales"];?></td>
				<td><?php echo $data["unidadesVendidas"];?></td>
				<td><?php echo ($data["unidadesTotales"]-$data["unidadesVendidas"])?></td>
				<td><?php echo round($data["unidadesVendidas"]/$data["tiempoMercado"],2)?></td>
				<td><?php echo round($dataM2["promM2"], 0, PHP_ROUND_HALF_UP);?></td>
				<td>$<?php if($dataM2["promM2"]!=0){echo number_format(round(($dataprecioYcredito["precio"]/round($dataM2["promM2"], 0, PHP_ROUND_HALF_UP)),2), 2, '.', ',');}?></td>
			</tr>
			<tr>
			<td>
			<table class="table">
					<tr><th>Clasificaci&oacute;n</th></tr>
					<tr><td><?php  echo $data["segmento"];?></td></tr>
					<tr><th>Tipo</th></tr>
					<tr><td><?php  echo $data["tipo"];?></td></tr>
					</table>
			</td>
			<td><table class="table">
			<tr><td><?php  echo $data["nombre"];?></td></tr>
				<tr><th>Colonia</th><td><?php  echo $data["colonia"];?></td></tr>
				<tr><th>Municipio</th><td><?php  echo $data["municipio"];?></td></tr>
				<tr><th>Zona</th><td><?php  echo $data["ciudad"];?></td></tr>
				<tr><th>Subzona</th><td><?php  echo $data["subzona"];?></td></tr>
				<tr><th>Promotor</th><td><?php  echo $data["promotor"];?></td></tr>
				</table></td>
				<td colspan="2">
					<table class="table">					
					<tr><th>Monto para separar</th><td>$<?php  echo round($dataSepyEng["separacion"],2);?></td></tr>
					<tr><th>Monto de enchanche min(%)</th><td><?php  echo round($dataSepyEng["engancheMin"],0);?>%</td></tr>
					<tr><th>Monto en cantidad</th><td>$<?php  echo number_format(round(($dataprecioYcredito["precio"]*($dataSepyEng["engancheMin"]/100)),2), 2, '.', ',');?></td></tr>
					<tr><th>Credito sobre enganche</th><td><?php echo round($dataprecioYcredito["credito"],0)?> meses</td></tr>
					</table>
					</td>
				<td colspan="2">
				<table class="table">
					<?php while($dataPromCaract=mysql_fetch_array($result6)){
					 if($dataPromCaract["nombre"]=="Recámaras"){?>
					<tr><th>Rec&aacute;maras</th><td><?php echo round($dataPromCaract["cantidad"],0)?></td></tr>
					<?php } 
					 if($dataPromCaract["nombre"]=="Baños"){?>
					<tr><th>Baños</th><td><?php echo round($dataPromCaract["cantidad"],0)?></td></tr>
					<?php }  if($dataPromCaract["nombre"]=="Niveles"){?>
					<tr><th>Niveles</th><td><?php echo round($dataPromCaract["cantidad"],0)?></td></tr>
					<?php } if($dataPromCaract["nombre"]=="Estancias"){?>
					<tr><th>Estancias</th><td><?php echo round($dataPromCaract["cantidad"],0)?></td></tr>
					<?php } if($dataPromCaract["nombre"]=="Estacionamientos"){?>
					<tr><th>Estacionamientos</th><td><?php echo round($dataPromCaract["cantidad"],0)?></td></tr>
					<?php }}?>
					<tr><th>Llamadas de seguimiento</th><td><?php  echo $data["llamadasSeguimiento"];?></td></tr>				
					</table>
				</td>
				<td colspan="4">
					<table class="table">
						<tr>
							<th>Precio promedio</th>
							<td>$<?php echo number_format($dataPrecios["precioPromedio"], 2, '.', ',');?></td>
						</tr>
						<tr>
							<th>Precio m&iacute;nimo</th>
							<td>$<?php echo number_format(($dataPrecios["precioMin"]), 2, '.', ',');?> </td>
						</tr>
						<tr>
							<th>Precio m&aacute;ximo</th>
							<td>$<?php echo number_format(($dataPrecios["precioMax"]), 2, '.', ',');?> </td>
						</tr>
						<tr>
							<th>Fecha de inicio</th>
							<td><?php echo $data["inicioVentas"]?></td>
						</tr>
						<tr>
							<th>Fecha de revisi&oacute;n</th>
							<td><?php echo $data["fechaRevision"]?></td>
						</tr>
						<tr>
							<th>Tiempo en el mercado</th>
							<td><?php echo $data["tiempoMercado"]?> meses</td>
						</tr>
						<tr>
							<th>&Eacute;xito comercial</th>
							<td><?php echo  number_format(($data["unidadesVendidas"]/$data["unidadesTotales"]), 3, '.', '');?></td>
						</tr>					
					</table>
				</td>
			</tr>
		</table>

		<?php 	$cont++;	
					}

					?>
				
	</div>
		
</div>
</div>
</div>
</td></tr></table>
</div>
</div>
<?php include "includes/footer_principal.php"?>