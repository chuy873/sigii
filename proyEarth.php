<?php
/* Pagina de reporte - Google Earth
 Se selecciona el proyecto para ver el reporte en google earth
Esta pagina es accesada por todos los usuarios registrados.
*/
$pageTitle = "SIGII | Reporte Earth";
include "clases/Usuarios.php";
session_start();
if(!(isset($_SESSION["usuario"]))){
	header("Location: index.php");
}
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();

//Verificar si el usuario tiene permiso para visualizar esta página
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision" ||
		$usuariologueado->getTipo()=="captura" || $usuariologueado->getTipo()=="analisis" ||
		$usuariologueado->getTipo()=="cliente")) {
	header("Location: index.php");
}

include "includes/header_aplicacion.php";
$proyectos="SELECT idproyecto, nombre, promotor FROM proyecto";
$result=mysql_query($proyectos);
?>
<div class="container-fluid">
	<div class="row">
		<div class="span10 offset2">
			<form class="form-horizontal" action="reporteEarth.php"
				method="post">
				<fieldset>
					<legend>
						<i class="icon-th "></i> Visualizar proyecto en Google Earth<sup>&copy;</sup> 
					</legend>
					<div class="control-group">
						<label class="control-label" for="proyecto">Selecciona el proyecto</label>
						<div class="controls">
							<select name="idproy" class="span2">
								<option value="" selected=selected disabled=disabled>Selecciona
									el proyecto</option>
								<?php while($data=mysql_fetch_array($result)){?>
								<option value="<?php echo $data["idproyecto"]?>">
									<?php echo $data["nombre"]."-".$data["promotor"]?>
								</option>
								<?php }?>
							</select> <span class="help-inline"></span>
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" class="btn btn-inverse">
							<i class="icon-th icon-white"></i> Ver en mapa...
						</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>
<?php  include "includes/footer_aplicacion_1.php" ?>