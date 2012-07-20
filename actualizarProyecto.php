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
                      $q = sprintf("SELECT idproyecto, nombre, promotor, tipo, fechaRevision, tiempoMercado, unidadesVendidas FROM proyecto WHERE idproyecto='%s'",
                      		mysql_real_escape_string($idproyecto));
						$proyectos = mysql_query( $q);
						if (!$proyectos) {
							die('No se pudo realizar la consulta:' . mysql_error());
							$_SESSION['error'] = "consulta";
	$_SESSION['errormsg'] = "Hubo un error al realizar la acción.";
	$_SESSION['pageFrom']="actualizarProyecto";
							header("Location: error.php");
						} else {
							$data=mysql_fetch_array($proyectos);
						}
					?>           
					<input type="hidden" name="proyecto" value="<?php echo $data["idproyecto"]?>">
					<input type="hidden" name="tipo" value="<?php echo $data["tipo"]?>">
						  <h1>Actualizar proyecto <?php echo $data["nombre"] ?></h1>
                            <fieldset>
                                <legend>Informaci&oacute;n necesaria</legend>                              
                                  <div class="control-group"> <label class="control-label"><i>&Uacute;ltima actualizaci&oacute;n: <?php echo $data["fechaRevision"]?></i>	</label></div>                                 								     
								     <?php 								    
								     if($data["tipo"]=="horizontal"){								     	
								    $modelosH=" SELECT m.idmodelo AS idmodelo, m.nombre AS nombre, md.precio AS precio FROM modelo m
INNER JOIN modelofraccionamiento md ON m.idmodelo = md.modelo_idmodelo AND m.proyecto_idproyecto='".$data["idproyecto"]."';";
									$result = mysql_query( $modelosH);
									$cont=0;
									while($dataH=mysql_fetch_array($result)){
								     ?>
								     Modelo <?php echo $dataH["nombre"]?>
								      <div class="control-group">
                                    <label class="control-label" for="precio">Precio</label>
                                    <div class="controls">
                                        $ <input name="precio<?php echo $cont?>" id="precio" class="input-small" type="text"
                                        value="<?php echo $dataH["precio"]?>">
                                                                                <span class="help-inline"></span>
                                    </div>
                                </div> 
                                <input type="hidden" name="modelo<?php echo $cont?>" value="<?php echo $dataH["idmodelo"]?>"/>
                                <?php $cont++;}} else  if($data["tipo"]=="vertical"){
								    $modelosV=" SELECT m.idmodelo AS idmodelo, m.nombre AS nombre, md.precioPromedio AS precio FROM modelo m
INNER JOIN modelodepartamento md ON m.idmodelo = md.modelo_idmodelo AND m.proyecto_idproyecto='".$data["idproyecto"]."';";
									$result = mysql_query( $modelosV);
									$cont=0;
									while($dataV=mysql_fetch_array($result)){
								     ?>
								     Modelo <?php echo $dataV["nombre"]?>
								      <div class="control-group">
                                    <label class="control-label" for="precio">Precio</label>
                                    <div class="controls">
                                        $ <input name="precio<?php echo $cont?>" class="input-small" type="text"
                                        value="<?php echo $dataV["precio"]?>">
                                                                                <span class="help-inline"></span>
                                    </div>
                                </div> 
                                 <input type="hidden" name="modelo<?php echo $cont?>" value="<?php echo $dataV["idmodelo"]?>"/>                               
                                <?php $cont++; }
									}?>
									<input type="hidden" name="numMod" value="<?php echo $cont?>"/>
                                      <div class="control-group">
                                    <label class="control-label" for="tiempoMercado">Tiempo en el mercado</label>
                                    <div class="controls">
                                         <input name="tiempoMercado" id="tiempoMercado" class="input-small" type="text"
                                         value="<?php echo $data['tiempoMercado']?>"> meses                
                                          <span class="help-inline"></span>
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
                                         <input name="vendidasTotales" id="vendidasTotales" class="input-small" type="text"
                                          value="<?php echo $data['unidadesVendidas']?>">   
                                                  <span class="help-inline"></span>
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