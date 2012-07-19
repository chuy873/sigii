<?php
/* Pagina Actualizar proyecto horizontal
 Se despliega la forma para ingresar los datos necesarios para  actualizar el proyecto.
Esta pagina solo es accesada por el administrador, revision y captura.
*/
$pageTitle = "SIGII | Actualizar proyecto";
include "clases/Usuarios.php";
session_start();
$earth = "earth";
$_SESSION["earth"] = $earth;
$_SESSION["datepicker"] = "date";
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
?>
        <div class="container">           
        <div class="row">      
           <div class="span10 offset1">
     
  <form class="forma form-horizontal well" action="control/ActualizarProyecto.php" method="post">                                                    

    <?php 
                      $q = "SELECT idproyecto, nombre, promotor, fechaRevision FROM proyecto WHERE idproyecto=' ".$idproyecto."'";
						$proyectos = mysql_query( $q);
						if (!$proyectos) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
							$data=mysql_fetch_array($proyectos);
						}
					?>           
					<input type="hidden" name="proyecto" value="<?php echo $idproyecto?>">
						  <h1>Actualizar proyecto <?php echo $data["nombre"] ?></h1>
                            <fieldset>
                                <legend>Informaci&oacute;n necesaria</legend>                              
                                  <div class="control-group"> <label class="control-label"><i>&Uacute;ltima actualizaci&oacute;n: <?php echo $data["fechaRevision"]?></i>	</label></div>
                                 
								      <div class="control-group">
                                    <label class="control-label" for="precio">Precio</label>
                                    <div class="controls">
                                        $ <input name="precio" id="precio" class="input-small" type="text">                                        <span class="help-inline"></span>
                                    </div>
                                </div> 
                                      <div class="control-group">
                                    <label class="control-label" for="meses">Meses</label>
                                    <div class="controls">
                                         <input name="meses" id="meses" class="input-small" type="text">                                        <span class="help-inline"></span>
                                    </div>
                                </div>    
                                      <div class="control-group">
                                    <label class="control-label" for="vendidaXmes">Vendida por mes</label>
                                    <div class="controls">
                                        <input name="vendidaXmes" id="vendidaXmes" class="input-small" type="text">                                        <span class="help-inline"></span>
                                    </div>
                                </div>    
                                      <div class="control-group">
                                    <label class="control-label" for="vendidasTotales">Vendidas totales</label>
                                    <div class="controls">
                                         <input name="vendidasTotales" id="vendidasTotales" class="input-small" type="text">                                        <span class="help-inline"></span>
                                    </div>
                                </div>       
								</fieldset>
								<div class="form-actions">                                   
                                   <button class="btn btn-primary" type="submit">Actualizar</button>                                					
						 <button class="btn" type="reset">Cancelar</button>											                                 
                                </div>
                                   
								</form>
								</div>
								</div>
								</div>
                               
<?php include "includes/footer_principal.php"?>