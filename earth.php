<?php 
/* Pagina Añadir posicion geografica
 */
$pageTitle = "SIGII | Añadir posición geográfica";
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
$idproyecto=$_GET["idproyecto"];
$nombre=$_GET["nombre"];
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
    gex.util.lookAt([25.63, -100.28], { range: 80000 });
   // gex.util.lookAt([0, 0], { range: 80000 });
    <?php if(mysql_num_rows($result)>0){
    	$archivo=mysql_fetch_array($result);
    		?>
    	var kmlUrl = "http://localhost/sigii/<?php echo $archivo["pathArchivoKML"]?>"	
    	google.earth.fetchKml(ge, kmlUrl, finishFetchKml);
    	<?php }?>
    	
  }, function() {});
});
function borrar() {	
	gex.dom.clearFeatures();
	doc = ge.createDocument('');
    ge.getFeatures().appendChild(doc);

}
function outKml() {
	// Set the placemark's location. 
	 // get center point for given kml object and create new placemark at that location
	  var bounds = gex.dom.computeBounds(getFeatureById('poligono')); // Feature or Geometry
	  var pt = bounds.center();
	  //Colocar marca y dialogo con datos
	   var html="<p>Promotor: <?php  echo $dataProyecto['promotor']?></p>"+
		   "<p>Segmento: <?php  echo $dataProyecto['segmento']?></p>"+
		   "<p>Unidades totales: <?php  echo $dataProyecto['unidadesTotales']?></p>"+
		   "<p>Unidades vendidas: <?php  echo $dataProyecto['unidadesVendidas']?></p>"+
		   "<p>Tiempo en el mercado: <?php  echo $dataProyecto['tiempoMercado']?></p>"+
		   "<p>Entrega: <?php  echo $dataProyecto['entrega']?></p>"+
		   "<p>Telefono: <?php  echo $dataProyecto['telefono']?></p>";   
	  var center = new geo.Point((pt.lat()), pt.lng());
	  var placemark = gex.dom.addPlacemark({
		  name: '<?php echo $nombre?>',
		  id:'marca',
		  description:html,
		    point: center,
		    stockIcon: 'paddle/red-circle'
		  });
	
	// Create style for placemark
	  var icon = ge.createIcon('');
	  <?php if($dataProyecto["tipo"]=="horizontal"){?>
	  icon.setHref('http://mapicons.nicolasmollet.com/wp-content/uploads/mapicons/shape-default/color-3875d7/shapecolor-color/shadow-1/border-dark/symbolstyle-white/symbolshadowstyle-dark/gradient-no/condominium.png');
<?php }else if($dataProyecto["tipo"]=="vertical") {?>
icon.setHref('http://mapicons.nicolasmollet.com/wp-content/uploads/mapicons/shape-default/color-3875d7/shapecolor-color/shadow-1/border-dark/symbolstyle-white/symbolshadowstyle-dark/gradient-no/apartment-3.png');
<?php }?>
	  var style = ge.createStyle('');
	  style.getIconStyle().setIcon(icon);
	  placemark.setStyleSelector(style);
		
	 doc.getFeatures().appendChild(getFeatureById('poligono'));	
	 doc.getFeatures().appendChild(getFeatureById('marca'));
	  document.getElementById('kml-out').value = doc.getKml();
	  document.getElementById('geoposicion').submit();
	}
	function dibuja()	{	
		gex.dom.clearFeatures();
		placemark = gex.dom.addPlacemark({
		  polygon: [],
		  id:'poligono',
		  style: {
		    line: { width: 3, color: '#0f0' },
		    poly: { color: '8000ffff' }
		  }
		});
		gex.edit.drawLineString(placemark.getGeometry().getOuterBoundary());		
		}

	function getFeatureById(id) { 
        var foundFeature = null; 
        var i = false ; 
        gex.dom.walk(function() { 
            if (i) { 
            	 if ('getId' in this && this.getId 
            			 () == id)  { 
                    foundFeature = this; 
                    return false; // end the walk 
                } 
            } else 
            i = true; 

        }); 
        return foundFeature; 
    } 

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
				<?php echo $nombre?>
			</h2>
			<div class="control-group">
				<label class="control-label" for="posicionamiento">Posicionamiento
					en mapa</label>
				<div class="controls"></div>
			</div>


			<p class="help-block">Google Earth.</p>
			<div>
				<div id="map3d_container" style="width: 900px; height: 500px;">
					<div id="map3d" style="height: 100%"></div>
				</div>

				<button type="button" class="btn btn-primary" id="posicionar"
					onclick="dibuja();">
					<i class="icon-globe icon-white"></i> Posicionar
				</button>

				<button type="button" class="btn btn-primary" onclick="outKml();" id="guardar">
					<i class="icon-pencil"></i>Guardar pol&iacute;gono
				</button>
				<button type="button" class="btn btn-danger" onclick="borrar();" id="eliminar">
					<i class="icon-trash"></i>Eliminar pol&iacute;gono
				</button>
			</div>

			<div>
				<strong>Instrucciones:</strong>

				<p>1. Dir&iacute;gete a la ubicaci&oacute;n del proyecto.</p>
				<p>
					2. Haz clic en
					<button type="button" class="btn btn-primary" id="posicionar"
						onclick="dibuja()">
						<i class="icon-globe icon-white"></i> Posicionar
					</button>
					para empezar a dibujar el poligono
				</p>
				<p>
					3. Haz <b>un clic</b> en el mapa para colocar las marcas.(Se
					rellenara el pol&iacute;gono de un color).
				</p>
				<p>
					4. Al terminar el pol&iacute;gono, haz <b>doble clic</b> con el
					rat&oacute;n.
				</p>
				<p>
					5. Para guardar el pol&iacute;gono, haz clic en
					<button type="button" class="btn btn-primary" onclick="outKml();" id="guardar">
						<i class="icon-pencil"></i>Guardar pol&iacute;gono
					</button>
				</p>
				<p>
					*Si deseas eliminar el pol&iacute;gono, haz clic en
					<button type="button" class="btn btn-danger" onclick="borrar();" id="eliminar">
						<i class="icon-trash"></i>Eliminar pol&iacute;gono
					</button>
				</p>
			</div>
			<form id="geoposicion" action="control/guardarEarth.php"
				method="post">
				<textarea name="earth" id="kml-out" style="display: none;"></textarea>
				<input type="hidden" name="idproyecto"
					value="<?php echo $idproyecto?>" />
			</form>
			<textarea id="code" style="display: none;">
gex.dom.clearFeatures();

var placemark = gex.dom.addPlacemark({
  polygon: [],
  style: {
    line: { width: 15, color: '#ff0' },
    poly: { color: '8000ffff' }
  }
});

gex.edit.drawLineString(placemark.getGeometry().getOuterBoundary());
</textarea>
			<br />

		</div>
	</div>
</div>


<?php include "includes/footer_principal.php" ?>