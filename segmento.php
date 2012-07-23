<?php
/*
 * Pagina de reporte: Segmento
* Se muestra la gráfica de las ventas anuales por segmento.
*/
$pageTitle = "SIGII | Ventas por segmento";
include "clases/Usuarios.php";
session_start();
if(!(isset($_SESSION["usuario"]))){
	header("Location: index.php");
}
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision" ||
		$usuariologueado->getTipo()=="captura" || $usuariologueado->getTipo()=="analisis" ||
		$usuariologueado->getTipo()=="cliente")) {
	$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta página.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: error.php");
}
//Consulta de datos del proyecto
$dataProyectos = "SELECT * FROM proyecto ";
$result = mysql_query( $dataProyectos );
$precioYcredito1 = "SELECT avg(mf.precio) as precio, avg(mf.creditoSobreEnganche) as credito
FROM sigii.modelofraccionamiento mf
INNER JOIN modelo m ON mf.modelo_idmodelo= m.idmodelo AND m.proyecto_idproyecto='".$idproyecto."'";
$precioYcredito2 = "SELECT avg(md.precioPromedio) as precio, avg(metrosCuadrados) as metros
FROM sigii.modelodepartamento md
INNER JOIN modelo m ON md.modelo_idmodelo= m.idmodelo AND m.proyecto_idproyecto='".$idproyecto."'";

$result1=mysql_query($precioYcredito1);
$dataprecioYcredito1=mysql_fetch_array($result1);

$result2=mysql_query($precioYcredito1);
$dataprecioYcredito2=mysql_fetch_array($result2);
//Datos absorcion y precio m2 [nombre, absorcion, preciom2]
$datosH[][3]="";
$datosV[][3]="";
$i=0;
while($data=mysql_fetch_array($result)){
	if($data["tipo"]=="horizontal"){
	$datosH[$i][0]=$data["nombre"];	
	$datosH[$i][1]=$data["unidadesVendidas"]/$data["tiempoMercado"];
	settype($datosH[$i][1], "integer");
	$precioYmetrosH= "SELECT avg(mf.precio) as precio, avg(metrosCuadrados) as metros
	FROM sigii.modelofraccionamiento mf
	INNER JOIN modelo m ON mf.modelo_idmodelo= m.idmodelo AND m.proyecto_idproyecto='".$data["idproyecto"]."'";
	$result1=mysql_query($precioYmetrosH);
	$dataprecioYmetrosH=mysql_fetch_array($result1);
	$datosH[$i][2]=$dataprecioYmetrosH["precio"]/$dataprecioYmetrosH["metros"];
	settype($datosH[$i][2], "integer");
	$i++;
	} else if($data["tipo"]=="vertical"){
	$datosV[$i][0]=$data["nombre"];
	$datosV[$i][1]=$data["unidadesVendidas"]/$data["tiempoMercado"];
	settype($datosV[$i][1], "integer");
	$precioYmetrosV = "SELECT avg(md.precioPromedio) as precio, avg(metrosCuadrados) as metros
	FROM sigii.modelodepartamento md
	INNER JOIN modelo m ON md.modelo_idmodelo= m.idmodelo AND m.proyecto_idproyecto='".$data["idproyecto"]."'";
	$result2=mysql_query($precioYmetrosV);
	$dataprecioYmetrosV=mysql_fetch_array($result2);
	$datosV[$i][2]=$dataprecioYmetrosV["precio"]/$dataprecioYmetrosV["metros"];
	settype($datosV[$i][2], "integer");
	$i++;
	}
}

include "includes/header_aplicacion.php";

?>

<div class="row">
	<div id="print" class="span10 offset2">
		<h1>Gr&aacute;ficas de absorci&oacute;n y precio por m<sup>2</sup></h1>
		 <div id="preciom2AbsH" style="width: 900px; height: 500px"></div>
		 <br/>
		 <div id="preciom2AbsV" style="width: 900px; height: 500px"></div>
		 </div>	
		<a href="javascript:window.print()">Imprimir esta página<img
			src="assets/img/Printer-icon.png" />
		</a>
	
</div>
<script type="text/javascript" src="assets/js/flotr2.min.js"></script>
<script type="text/javascript">
(function download_image(container) {

	  var
	    d1 = [], //Datos de precio m2
	    d2 = [], //Datos de absorcion
	    proyectos = [],		    
	    graph,
	    i;
	  <?php $i=0; foreach($datosH as $value){?>
	   proyectos.push([<?php echo json_encode($value[0])?>]); 
	   d1.push([<?php echo $i?>,<?php echo  json_encode($value[2])?>]);
	   d2.push([<?php echo $i?>,<?php echo  json_encode($value[1])?>]);
	    <?php $i++;}?> 
	

	  // Draw the graph
	  graph = Flotr.draw(
	    container,[ 
	      {data:d1, label:'Precio m2',  lines : { show : true,  color:'#CC0000' }, points : { color:'#CC0000',  show : true }}, 
	      {data:d2, label:'Absorción',  lines : { show : true,   color:'#3333FF' }, yaxis:2}	     
	    ],{
	      title: 'Absorción y precio m2',
	      subtitle: 'Proyectos horizontales',
	      xaxis:{
	      tickFormatter: function (x) {
        var
          x = parseInt(x);
      return proyectos[x];
      },
	      labelsAngle: 45,
	        title: 'Proyectos'
	      },
	      yaxis:{
	    	  autoscale : true,
	    	  title: 'Precio por m2'
	      },
	      y2axis:{ 
	    	  autoscale : true,
		      title: 'Absorción'		     
	      },
	      grid:{
	        verticalLines: false,
	        backgroundColor: 'white'
	      },
	      HtmlText: false,
	      legend : {show:false},
		     
	  });
	

	  return graph;
	})(document.getElementById("preciom2AbsH"));
(function download_image(container) {

	  var
	    d1 = [], //Datos de precio m2
	    d2 = [], //Datos de absorcion
	    proyectos = [],		    
	    graph,
	    i;
	  <?php $i=0; foreach($datosV as $value){?>
	   proyectos.push([<?php echo json_encode($value[0])?>]); 
	   d1.push([<?php echo $i?>,<?php echo  json_encode($value[2])?>]);
	   d2.push([<?php echo $i?>,<?php echo  json_encode($value[1])?>]);
	    <?php $i++;}?> 
	

	  // Draw the graph
	  graph = Flotr.draw(
	    container,[ 
	      {data:d1, label:'Precio m2',  lines : { show : true,  color:'#CC0000' }, points : { color:'#CC0000',  show : true }}, 
	      {data:d2, label:'Absorción',  lines : { show : true,   color:'#3333FF' }, yaxis:2}	     
	    ],{
	      title: 'Absorción y precio m2',
	      subtitle: 'Proyectos verticales',
	      xaxis:{
	       tickFormatter: function (x) {
      var
        x = parseInt(x);
    return proyectos[x];
    },
	         labelsAngle: 45,
	        title: 'Proyectos'
	      },
	      yaxis:{
	    	  autoscale : true,
	    	  title: 'Precio por m2'
	      },
	      y2axis:{ 
	    	  autoscale : true,
		      title: 'Absorción'		     
	      },
	      grid:{
	        verticalLines: false,
	        backgroundColor: 'white'
	      },
	      HtmlText: false,
	      legend : {show:false},
	  });
	

	  return graph;
	})(document.getElementById("preciom2AbsV"));
  </script>

<?php 
include "includes/footer_principal.php";
?>