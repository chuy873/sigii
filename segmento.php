<?php
/*
 * Pagina de reporte: Segmento
* Se muestra la gráfica de las ventas anuales por segmento.
*/
$pageTitle = "SIGII | Ventas por segmento";
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
include "clases/Usuarios.php";
session_start();
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision" ||
		$usuariologueado->getTipo()=="captura" || $usuariologueado->getTipo()=="analisis" ||
		$usuariologueado->getTipo()=="cliente")) {
	header("Location: index.php");
}
$ventasH="SELECT SUM(unidadesVendidas) AS ventas, segmento FROM sigii.proyecto 
	WHERE tipo='horizontal' GROUP BY segmento ASC;";
$result = mysql_query( $ventasH );
$ventasV="SELECT SUM(unidadesVendidas) AS ventas, segmento FROM sigii.proyecto
WHERE tipo='vertical' GROUP BY segmento ASC;";
$result2 = mysql_query( $ventasV );
include "includes/header_aplicacion.php";
while ($data=mysql_fetch_array($result)){
		if($data["segmento"]=="Económico"){
			$ventasEconomicoH=$data["ventas"];
		}
		else if($data["segmento"]=="Medio"){
		$ventasMedioH=$data["ventas"];
	} else 
		if($data["segmento"]=="Residencial"){
			$ventasResidencialH=$data["ventas"];
		} else if($data["segmento"]=="Residencial Plus"){
		$ventasResidencialPlusH=$data["ventas"];
	}
}
while ($data=mysql_fetch_array($result2)){	
		if($data["segmento"]=="Residencial"){
		$ventasResidencialV=$data["ventas"];
	} else if($data["segmento"]=="Residencial Plus"){
		$ventasResidencialPlusV=$data["ventas"];
	}else if($data["segmento"]=="Premium"){
		$ventasPremiumV=$data["ventas"];
	}
}
settype($ventasEconomicoH, "integer");
settype($ventasMedioH, "integer");
settype($ventasResidencialH, "integer");
settype($ventasResidencialPlusH, "integer");

settype($ventasResidencialV, "integer");
settype($ventasResidencialPlusV, "integer");
settype($ventasPremiumV, "integer");

?>

<div class="row">
<div class="span10 offset2">
		<h1>Ventas anuales por segmento</h1>
		 <div id="chart_div" style="width: 900px; height: 500px;"></div>
		 <div id="chart_div2" style="width: 900px; height: 500px;"></div>
		 <a href="javascript:window.print()">Imprimir esta página<img src="assets/img/Printer-icon.png"  /></a> 		 
</div>
</div>
  <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
    	   data = new google.visualization.DataTable();
           data.addColumn('string', 'Segmento');
           data.addColumn('number', '2012');
           data.addColumn('number', '2013');
           data.addRows([
            ['Económico',  <?php echo  json_encode($ventasEconomicoH)?>,56],
             ['Medio', <?php echo  json_encode($ventasMedioH)?>,43],
             ['Residencial', <?php echo  json_encode($ventasResidencialH)?>, 56	],
             ['Residencial Plus',  <?php echo  json_encode($ventasResidencialPlusH)?>, 32],            
           ]);
       

        var options = {
          title: 'Ventas anuales de proyectos horizontales',
          hAxis: {title: 'Segmento', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
      google.load("visualization", "2", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart2);
      function drawChart2() {
    	   data = new google.visualization.DataTable();
           data.addColumn('string', 'Segmento');
           data.addColumn('number', '2012');
           data.addColumn('number', '2013');
           data.addRows([           
             ['Residencial', <?php echo  json_encode($ventasResidencialV)?>, 56	],
             ['Residencial Plus',  <?php echo  json_encode($ventasResidencialPlusV)?>, 32],
             ['Premium',  <?php echo  json_encode($ventasPremiumV)?>, 20]
           ]);
       

        var options = {
          title: 'Ventas anuales de proyectos verticales',
          hAxis: {title: 'Segmento', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
        chart.draw(data, options);
      }
    </script>
<?php 
include "includes/footer_principal.php";
?>