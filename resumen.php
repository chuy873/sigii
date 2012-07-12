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
			<li><a href="#tab2" data-toggle="tab">Ec&oacute;nomico</a></li>
			<li><a href="#tab3" data-toggle="tab">Medio</a></li>
			<li><a href="#tab4" data-toggle="tab">Residencial</a></li>
			<li><a href="#tab5" data-toggle="tab">Residencial Plus</a></li>
			<li><a href="#tab6" data-toggle="tab">Premium</a></li>
		</ul>
		<div class="tab-content">
		<?php $tab=1;
		$segmentos= array(1=>"Social",2=>"Economico",3=>"Medio",4=>"Residencial",5=>"Residencial Plus",6=>"Premium");
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
		<table class="table table-bordered">
		<tr><th>Num</th><th>Tipo</th><th>Nombre</th><th>Precio</th><th>M<sup>2</sup></th><th>M<sup>2</sup> Terr</th>
		<th>Precio M<sup>2</sup></th><th>Unids</th><th>Vend</th><th>Inv</th><th>Abs</th>
		<th>Rec</th><th>Bañ</th><th>Niv</th><th>Est</th><th>Ubicaci&oacute;n</th><th>Colonia</th>
		</tr>
		<?php 
		$cont=1;
					while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {
						$promedioCaract="SELECT avg(cantidad) as cantidad, c.nombre as nombre FROM incluyecaracteristica ic
						INNER JOIN modelo m ON ic.modelo_idmodelo=m.idmodelo
						AND m.proyecto_idproyecto='".$data["idproyecto"]."'".
						" INNER JOIN caracteristicas c ON c.idcaracteristicas=ic.caracteristicas_idcaracteristicas
						GROUP BY c.nombre;";
						$result1=mysql_query($promedioCaract);
						?>
		<tr>
		<td><?php echo $cont?></td>
		<td><?php echo $data["tipo"]?></td>
		<td><?php echo $data["nombreP"]?></td>
		<td>$<?php echo number_format(round($data["precio"],2), 2, '.', ',')?></td>
		<td><?php echo round($data["metrosCuadrados"],0)?></td>
		<td><?php echo round($data["metrosCuadradosTerr"],0)?></td>
		<td>$ <?php if($data["metrosCuadrados"]!=0){echo number_format(round(($data["precio"]/$data["metrosCuadrados"]),2), 2, '.', ',');}?></td>
		<td><?php echo $data["unidades"]?></td>
		<td><?php echo $data["unidadesVendidas"]?></td>
		<td><?php echo ($data["unidades"]-$data["unidadesVendidas"])?></td>
		<td><?php if($data["tiempoMercado"]){echo round($data["unidadesVendidas"]/$data["tiempoMercado"],2);}?></td>
		<?php 		
			if(mysql_num_rows($result1)>0){			
		while($dataPromCaract=mysql_fetch_array($result1)){					
					 if($dataPromCaract["nombre"]=="Recámaras"){?>
					<td><?php echo round($dataPromCaract["cantidad"],0)?></td>
					<?php } else if($dataPromCaract["nombre"]=="Baños"){?>
					<td><?php echo round($dataPromCaract["cantidad"],0)?></td>
					<?php } else if($dataPromCaract["nombre"]=="Niveles"){?>
					<td><?php echo round($dataPromCaract["cantidad"],0)?></td>				
					<?php } else if($dataPromCaract["nombre"]=="Estacionamientos"){?>
					<td><?php echo round($dataPromCaract["cantidad"],0)?></td>
					<?php 
					 } }}else{?>
					 <td>ND</td><td>ND</td><td>ND</td><td>ND</td>
					 <?php }?>
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
		</div>
		</div>		
<?php include "includes/footer_principal.php"?>