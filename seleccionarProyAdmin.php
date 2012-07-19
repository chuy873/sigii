<?php
/* Pagina Seleccionar Proyecto para administracion de Modelos
 Se despliega la lista de todos los proyectos registrados en la base de datos para administrar los modelos.
Esta pagina solo es accesada por el administrador y revision.
*/
$pageTitle = "SIGII | Seleccionar proyecto";
include "clases/Usuarios.php";
session_start();
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision")) {
	$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta página.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: error.php");	
}
include "includes/header_aplicacion.php";
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$proyectos="SELECT idproyecto, nombre FROM proyecto";
$result=mysql_query($proyectos);
$proyectosHori="SELECT idproyecto, nombre FROM proyecto WHERE tipo='horizontal'";
$result1=mysql_query($proyectosHori);
$proyectosVert="SELECT idproyecto, nombre FROM proyecto WHERE tipo='vertical'";
$result2=mysql_query($proyectosVert);
$_SESSION['pageFrom']="seleccionarProyAdmin";
?>
<div class="row">
		<div class="span6 offset4">
		  <form class="form-horizontal" action="administrarModelosProy.php" method="post">
		      <fieldset>
		        <legend><i class="icon-fullscreen"></i> Administrar modelos</legend>
		          <div class="control-group">
                                    <label class="control-label" for="selectProy">Proyecto: </label>
                                    <div class="controls">
		        <select name="idproyecto" id="idproyecto1" class="required">
		        <option  value="" disabled="disabled" selected=selected>Selecciona el proyecto</option>
		        <?php while($data=mysql_fetch_array($result)){?>
		        <option value="<?php echo $data["idproyecto"]?>"><?php echo $data["nombre"]?></option>
		        <?php }?>
		        </select>
		         <span class="help-inline"></span>
                                    </div>     
                                    </div>                         		        		       
		        <button type="submit" class="btn">Administrar modelos</button>
		         </fieldset>
		          </form>
		        	  <form class="form-horizontal" action="administrarModelosProy.php" method="post">		 
		           <fieldset>
		        <legend><i class="icon-resize-horizontal"></i> Administrar modelos horizontales</legend>
		          <div class="control-group">
                                    <label class="control-label" for="selectProy">Proyecto horizontal: </label>
                                    <div class="controls">
		        <select name="idproyecto" id="idproyecto2" class="required">
		        <option value="" disabled="disabled" selected=selected>Selecciona el proyecto</option>
		        <?php while($data=mysql_fetch_array($result1)){?>
		        <option value="<?php echo $data["idproyecto"]?>"><?php echo $data["nombre"]?></option>
		        <?php }?>
		        </select>
		        <span class="help-inline"></span>
                                    </div>     
                                    </div>                         		        		       
		        <button type="submit" class="btn">Administrar modelos</button>		        	        
		         </fieldset>
		           </form>	
		          	  <form class="form-horizontal" action="administrarModelosProy.php" method="post">		 		      
		           <fieldset>
		        <legend><i class="icon-resize-vertical"></i> Administrar modelos verticales</legend>
		          <div class="control-group">
                                    <label class="control-label" for="selectProy">Proyecto vertical: </label>
                                    <div class="controls">
		        <select name="idproyecto" id="idproyecto3" class="required">
		        <option value="" disabled="disabled" selected=selected>Selecciona el proyecto</option>
		        <?php while($data=mysql_fetch_array($result2)){?>
		        <option value="<?php echo $data["idproyecto"]?>"><?php echo $data["nombre"]?></option>
		        <?php }?>
		        </select>		       
		         <span class="help-inline"></span>
                                    </div>     
                                    </div>                         		        		       
		        <button type="submit" class="btn">Administrar modelos</button>
		         </fieldset>
		        </form>
		        </div>
		        </div>
		        <?php include "includes/footer_principal.php" ?>
		        
		        
		        