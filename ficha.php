<?php 
/* Pagina de reporte - Lámina
Se despliegan los datos basicos del proyecto seleccionado y de sus respectivos modelos.
Se despliegan imagenes, tablas, graficas, links. Los datos calculados se muestran en 
esta pagina y son calculados por el sistema.
Esta pagina es accesada por todos los usuarios registrados.
*/
	$pageTitle = "SIGII | Reporte Ficha";

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
   
   include "includes/header_aplicacion.php";
  $proyectos="SELECT idproyecto, nombre, promotor FROM proyecto";
   $result=mysql_query($proyectos);
   ?>
<div class="container-fluid">
        <div class="row"> 
	<div class="span10 offset2">
			<form class="form-horizontal" action="fichaProyecto.php" method="post">
			<fieldset>
				<legend>
					<i class="icon-th "></i> Generar ficha de proyecto
				</legend>
				  <div class="control-group">
                                    <label class="control-label" for="proyecto">Selecciona el proyecto</label>
                                    <div class="controls">
                                       <select name="idproy" class="span2">
                                          <option value="" selected=selected disabled=disabled>Selecciona el proyecto</option>
                                          <?php while($data=mysql_fetch_array($result)){?>
                                          <option value="<?php echo $data["idproyecto"]?>"><?php echo $data["nombre"]."-".$data["promotor"]?></option>
                                          <?php }?>
                                       </select>
                                     <span class="help-inline"></span>
                                    </div>
                                </div>  
                                 <div class="form-actions">
		          <button type="submit" class="btn btn-inverse"><i class="icon-th icon-white"></i> Generar ficha...</button>		          		          		         	         
		        </div> 
                             </fieldset>                             
                             </form>       
</div>
</div>
</div>
<?php  include "includes/footer_aplicacion_1.php" ?>