<?php 
/* Pagina Añadir posicion geografica
			 */
$pageTitle = "SIGII | Añadir posición geográfica";
 include "clases/Usuarios.php";
 session_start();
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
  ?>
        
  <script src="http://www.google.com/jsapi?key=ABQIAAAAsc0UQXoo2BnAJLhtpWCJFBTgHOxFyKCf35LCvsI_n4URElrkIhS9MkSlm_0NZWgrKFkOsnd5rEK0Lg" type="text/javascript"></script>
  <script src="assets/js/earth.js" type="text/javascript"></script>
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
    gex.util.lookAt([23, -102], { range: 4000000 });

  }, function() {});
});
function borrar() {
	
	location.reload(true);
			 		  
	} 
function outKml() {
	 doc.getFeatures().appendChild(getFeatureById('x'));	
	  document.getElementById('kml-out').value = doc.getKml();
	  document.getElementById('geoposicion').submit();
	}
	function dibuja(){
		document.getElementById("posicionar").disabled=true;
		gex.dom.clearFeatures();

		placemark = gex.dom.addPlacemark({
		  polygon: [],
		  id:'x',
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

		
/* ]]> */
</script>

<div class="container">           
        <div class="row">      
           <div class="span10 offset1">
								<h2>Ubicaci&oacute;n geogr&aacute;fica de <?php echo $nombre?></h2>
								<div class="control-group">
									<label class="control-label" for="posicionamiento">Posicionamiento
										en mapa</label>
									<div class="controls">											
								 </div>
      </div>									
							
			
								<p class="help-block">Google Earth.</p>
				<div >						
  <div id="map3d_container" style="width: 900px; height: 500px;">
    <div id="map3d" style="height: 100%"></div>
  </div>
  
  <button  type="button" class="btn btn-primary" id="posicionar" onclick="dibuja();" ><i
											class="icon-globe icon-white"></i> Posicionar</button>
											
											<button type="button" class="btn btn-primary" onclick="outKml();"><i class="icon-pencil"></i>Guardar pol&iacute;gono</button>
  <button  type="button" class="btn btn-danger" onclick="borrar();"><i class="icon-trash"></i>Eliminar pol&iacute;gono</button>
  </div>
  
  <div>
     <strong>Instrucciones:</strong>
										   	
										   <p>1. Dir&iacute;gete a la ubicaci&oacute;n del proyecto.</p>
										   <p>2. Haz clic en <button  type="button" class="btn btn-primary" id="posicionar" onclick="init()"><i
											class="icon-globe icon-white"></i> Posicionar</button> para empezar a dibujar el poligono</p>
										  	<p>3. Haz  <b>un clic</b> en el mapa para colocar las marcas.(Se rellenara el pol&iacute;gono de un color). </p>
										   <p>4. Al terminar el pol&iacute;gono, haz <b>doble clic</b> con el rat&oacute;n.</p>
										   <p>5. Para guardar  el pol&iacute;gono, haz clic en <button type="button" class="btn btn-primary" onclick="outKml();"><i class="icon-pencil"></i>Guardar pol&iacute;gono</button></p>
										   <p>*Si deseas eliminar el pol&iacute;gono, haz clic en 
     <button  type="button" class="btn btn-danger" onclick="borrar();"><i class="icon-trash"></i>Eliminar pol&iacute;gono</button></p>
   </div>
   <form id="geoposicion" action="control/guardarEarth.php" method="post">
    <textarea name="earth" id="kml-out" style="display:none;"></textarea>
    <input type="hidden" name="idproyecto" value="<?php echo $idproyecto?>"/>
    </form>	
<textarea id="code" style="display:none;" >
gex.dom.clearFeatures();

var placemark = gex.dom.addPlacemark({
  polygon: [],
  style: {
    line: { width: 15, color: '#ff0' },
    poly: { color: '8000ffff' }
  }
});

gex.edit.drawLineString(placemark.getGeometry().getOuterBoundary());
</textarea><br/>

</div>
</div>
</div>


<?php include "includes/footer_principal.php" ?>