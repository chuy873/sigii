<?php
/* Pagina Visualizar reporte de google earth
 */
$pageTitle = "SIGII | Reporte Earth";
include "clases/Usuarios.php";
session_start();
if(!(isset($_SESSION["usuario"]))){
	header("Location: index.php");
}
$earth = "earth";
//Verificar si el usuario tiene permiso para visualizar esta página
$usuariologueado =  new Usuarios();
$usuariologueado = $_SESSION['usuario'];
if (!($usuariologueado->getTipo()=="administrador"
		|| $usuariologueado->getTipo()=="revision" || $usuariologueado->
		getTipo()=="captura")) {
	$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta página.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: error.php");
}
include "includes/header_aplicacion.php";
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$idproyecto=$_POST["idproy"];
//Verficar si tiene archivo de posicionamiento KML
$dataProyecto=sprintf("SELECT * FROM proyecto WHERE idproyecto='%s'",
		mysql_real_escape_string($idproyecto));
$result1=mysql_query($dataProyecto);
$dataProyecto=mysql_fetch_array($result1);
$getKml=sprintf("SELECT * FROM posicionearth WHERE proyecto_idproyecto = '%s'",
		mysql_real_escape_string($idproyecto));
$result=mysql_query($getKml);
?>
<script
	src="http://www.google.com/jsapi?key=ABQIAAAAsc0UQXoo2BnAJLhtpWCJFBTgHOxFyKCf35LCvsI_n4URElrkIhS9MkSlm_0NZWgrKFkOsnd5rEK0Lg"
	type="text/javascript"></script>
<script
	src="assets/js/earth.js" type="text/javascript"></script>
<script type="text/javascript">
/* <![CDATA[ */
var doc = null;
var ge = null;
var gex = null;
google.load('earth', '1');

google.setOnLoadCallback(function() {
  google.earth.createInstance('map3d', function(pluginInstance) {
    ge = pluginInstance;
    ge.getWindow().setVisibility(true);
    ge.getNavigationControl().setVisibility(ge.VISIBILITY_AUTO);
    gex = new GEarthExtensions(pluginInstance);
    doc = ge.createDocument('');
    ge.getFeatures().appendChild(doc);
    //gex.util.lookAt([25.63, -100.28], { range: 80000 });
   // gex.util.lookAt([0, 0], { range: 80000 });
    <?php if(mysql_num_rows($result)>0){
    	$archivo=mysql_fetch_array($result);
    		?>
    	var kmlUrl = "http://localhost/sigii/<?php echo $archivo["pathArchivoKML"]?>"	
    	google.earth.fetchKml(ge, kmlUrl, finishFetchKml);
    	<?php }?>
    	
  }, function() {});
});
	 function finishFetchKml(kmlObject) {
		    // check if the KML was fetched properly
		    if (kmlObject) {
		      // add the fetched KML to Earth
		      currentKmlObject = kmlObject;
		      ge.getFeatures().appendChild(currentKmlObject);
		      
		    } else {
		      // wrap alerts in API callbacks and event handlers
		      // in a setTimeout to prevent deadlock in some browsers
		      setTimeout(function() {
		        alert('Bad or null KML.');
		      }, 0);
		    }
		  }
	
/* ]]> */
</script>
<div class="container">
	<div class="row">
		<div class="span10 offset1">
			<h2>
				Ubicaci&oacute;n geogr&aacute;fica de
				<?php echo $dataProyecto["nombre"]?>
			</h2>
			<div class="control-group">
				<label class="control-label" for="posicionamiento">Posicionamiento
					en mapa</label>
				<div class="controls"></div>
			</div>
			<p class="help-block">Google Earth.</p>
			<div id="map3d_container" style="width: 900px; height: 500px;">
				<div id="map3d" style="height: 100%"></div>
			</div>
			<br />
		</div>
	</div>
</div>
<?php include "includes/footer_principal.php" ?>