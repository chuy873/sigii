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
$ventas="SELECT SUM(unidadesVendidas) AS ventas, segmento FROM sigii.proyecto GROUP BY segmento ASC;";
$result = mysql_query( $ventas );
include "includes/header_aplicacion.php";
while ($data=mysql_fetch_array($result)){
	if($data["segmento"]=="Social"){
		$ventasSocial=$data["ventas"];
	} else 
		if($data["segmento"]=="Económico"){
			$ventasEconomico=$data["ventas"];
		}
		else if($data["segmento"]=="Medio"){
		$ventasMedio=$data["ventas"];
	} else 
		if($data["segmento"]=="Residencial"){
			$ventasResidencial=$data["ventas"];
		} else if($data["segmento"]=="Residencial Plus"){
		$ventasResidencialPlus=$data["ventas"];
	}else if($data["segmento"]=="Premium"){
		$ventasPremium=$data["ventas"];
	}
}
settype($ventasSocial, "integer");
settype($ventasEconomico, "integer");
settype($ventasMedio, "integer");
settype($ventasResidencial, "integer");
settype($ventasResidencialPlus, "integer");
settype($ventasPremium, "integer");

?>

<div class="row">
<div class="span10 offset2">
		<h1>Ventas anuales por segmento</h1>
		 <div id="chart_div" style="width: 900px; height: 500px;"></div>		 
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
             ['Social',  <?php echo json_encode($ventasSocial)?>, 23],
             ['Económico',  <?php echo  json_encode($ventasEconomico)?>,56],
             ['Medio', <?php echo  json_encode($ventasMedio)?>,43],
             ['Residencial', <?php echo  json_encode($ventasResidencial)?>, 56	],
             ['Residencial Plus',  <?php echo  json_encode($ventasResidencialPlus)?>, 32],
             ['Premium',  <?php echo  json_encode($ventasPremium)?>, 20]
           ]);
       

        var options = {
          title: 'Ventas anuales de proyectos horizontales y verticales',
          hAxis: {title: 'Segmento', titleTextStyle: {color: 'red'}}
        };

        var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
        chart.draw(data, options);
      }
    </script>
<?php 
include "includes/footer_principal.php";
?>