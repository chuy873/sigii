<?php
/*
 * Pagina de reporte: Resumen
* Se muestra la informacion de los proyectos resumida en una tabla.
*/
$pageTitle = "SIGII | Resumen de proyectos";
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
			<li class="active"><a href="#tab1" data-toggle="tab">Social</a></li>
			<li><a href="#tab2" data-toggle="tab">Econ&oacute;mico</a></li>
			<li><a href="#tab3" data-toggle="tab">Medio</a></li>
			<li><a href="#tab4" data-toggle="tab">Residencial</a></li>
			<li><a href="#tab5" data-toggle="tab">Residencial Plus</a></li>
			<li><a href="#tab6" data-toggle="tab">Premium</a></li>
			<br/><br/><br/>
<li><a href="javascript:window.print()" >Imprimir esta página <img src="assets/img/Printer-icon.png"  /></a> </li>
			<li>
			<form action="control/exportarExcel.php" method="post" target="_blank" id="FormularioExportacion">
<p>Exportar a Excel  <img src="assets/img/Excel-icon.png" class="botonExcel" /></p>
<input type="hidden" id="datos_a_enviar" name="datos_a_enviar" />
<input type="hidden"  name="tipo" value="resumen" />
</form></li>
		</ul>
		<table  id="Exportar_a_Excel">
	<tr><td>
		<div class="tab-content">
		<?php $tab=1;
		$segmentos= array(1=>"Social",2=>"Económico",3=>"Medio",4=>"Residencial",5=>"Residencial Plus",6=>"Premium");
		foreach($segmentos as $segmento){
		?>
				<div class="tab-pane <?php if($tab==1){?>active<?php }?>" id="tab<?php echo $tab?>">
					<div class="row-fluid">
	<div class="span8 offset3">		
		<h1>Resumen de proyectos</h1>
		<h2>Clasificaci&oacute;n <?php echo $segmento?></h2>
		<?php 
		$tablaResumen="SELECT avg(m.metrosCuadrados) AS metrosCuadrados, avg(md.precioPromedio) AS precio, avg(mf.precio) AS precio,
		 avg(mf.m2Terreno) AS metrosCuadradosTerr, p.nombre AS nombreP, m.unidades AS unidades, m.unidadesVendidas AS unidadesVendidas,
		 p.tiempoMercado AS tiempoMercado, p.idproyecto AS idproyecto, p.colonia AS colonia, p.municipio AS municipio,
    	p.segmento AS segmento, p.tipo AS tipo     
		FROM proyecto p
		LEFT JOIN modelo m ON m.proyecto_idproyecto=p.idproyecto
		LEFT JOIN modelodepartamento md ON md.modelo_idmodelo=m.idmodelo
		LEFT JOIN modelofraccionamiento mf ON mf.modelo_idmodelo=m.idmodelo
		GROUP BY p.idproyecto  HAVING segmento='".$segmento."'";
		$result = mysql_query( $tablaResumen );
		?>
		<table class="table table-condensed">
		<tr><th>Num</th><th>Tipo</th><th>Nombre</th><th>Absorci&oacute;n</th><th>Precio</th><th>M<sup>2</sup></th><th>M<sup>2</sup> Terr</th>
		<th>Precio M<sup>2</sup></th><th>Unidades</th><th>Vendidas</th><th>Inventario</th>
		<th>Ubicaci&oacute;n</th><th>Colonia</th>
		</tr>
		<?php $cont=1;
		while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {?>		
		<tr>
		<td><?php echo $cont?></td>
		<td><?php echo $data["tipo"]?></td>
		<td><?php echo $data["nombreP"]?></td>
		<td><?php if($data["tiempoMercado"]){echo round($data["unidadesVendidas"]/$data["tiempoMercado"],2);}?></td>
		<td>$<?php echo number_format(round($data["precio"],2), 2, '.', ',')?></td>
		<td><?php echo round($data["metrosCuadrados"],0)?></td>
		<td><?php echo round($data["metrosCuadradosTerr"],0)?></td>
		<td>$ <?php if($data["metrosCuadrados"]!=0){echo number_format(round(($data["precio"]/$data["metrosCuadrados"]),2), 2, '.', ',');}?></td>
		<td><?php echo $data["unidades"]?></td>
		<td><?php echo $data["unidadesVendidas"]?></td>
		<td><?php echo ($data["unidades"]-$data["unidadesVendidas"])?></td>		
		<td><?php echo $data["municipio"]?></td>		
			<td><?php echo $data["colonia"]?></td>		
						
		</tr>
		<?php $cont++;}?>
		</table>		
		</div>
		</div>
		</div>		
		<?php $tab++;}?>			
		</div>	
				</td></tr></table>
		</div>		
		</div>			
<?php include "includes/footer_principal.php"?>