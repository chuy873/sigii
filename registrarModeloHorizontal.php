<?php
/* Pagina Registrar modelo de proyecto horizontal
Se despliega la forma para ingresar los datos necesarios para el modelo de proyecto a registrar.
Esta pagina solo es accesada por el administrador, revision y captura.
 */
$pageTitle = "SIGII | Registrar Modelo Horizontal";
include "clases/Usuarios.php";
session_start();
	//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
	$usuariologueado = new Usuarios();
	$usuariologueado = $_SESSION["usuario"];
	if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision"
			|| $usuariologueado->getTipo()=="captura" )) {
	header("Location: bienvenido.php");
	}
	
	include "includes/header_aplicacion.php";
	include "clases/Conexion.php";
	$conexion = new Conexion();
	$link = $conexion->dbconn();
?>
        <div class="container">          
        <div class="row">      
            <div class="span7 offset2">
              <div class="alert alert-info">
  <button class="close" data-dismiss="alert">×</button>
  <strong>Atenci&oacute;n!</strong> Aseg&uacute;rate de llenar la informaci&oacute;n de todas las etiquetas.
</div>
  <form id="registroModelo" class="forma form-horizontal well" action="control/RegistrarModelo.php" method="post" enctype="multipart/form-data">                                                    
		<div class="tabbable">
				<!-- Only required for left/right tabs -->
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1" data-toggle="tab">Datos b&aacute;sicos</a></li>					
					<li><a href="#tab2" data-toggle="tab">Caracter&iacute;sticas</a></li>
					<li><a href="#tab3" data-toggle="tab">Im&aacute;genes</a></li>
					<li><a href="#tab4" data-toggle="tab">Atributos</a></li>					
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
						  <h1>Datos del modelo horizontal</h1>
                            <fieldset>
                                <legend>Informaci&oacute;n necesaria</legend> 
                                 <input
										type="hidden" id="modelo" value="1">                              
                     <?php 
                      $q = "SELECT idproyecto, nombre, promotor FROM proyecto WHERE tipo= 'horizontal' ";
						$proyectos = mysql_query( $q);
						if (!$proyectos) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
					?>           
					<div class="control-group">
									<label class="control-label" for="proyecto">Proyecto</label>
									<div class="controls">
									  <input type="hidden" name="tipo" value="horizontal">
										<select class="span2" name='proyecto'>
											<?php 
											while ($data = mysql_fetch_array($proyectos, MYSQL_ASSOC)) {						
											?>
											<option value="<?php echo $data["idproyecto"]?>"><?php echo $data["nombre"]?>-<?php echo $data["promotor"]?></option>
											<?php 
												}
						}
											?>
										</select> <span class="help-inline"></span>
									</div>
								</div>
                                 <div class="control-group">
                                    <label class="control-label" for="nombres">Nombre del modelo</label>
                                    <div class="controls">
                                        <input name="nombre" id="nombre" class="input-large" type="text">
                                      <div class="alert alert-error" id="alertNombre"	style="display: none">
												<strong>Atenci&oacute;n!</strong> El nombre ya existe.
												Selecciona otro.
											</div>
                                    </div>
                                </div>                               
                                <div class="control-group">
                                    <label class="control-label" for="diferenciadores">Diferenciadores</label>
                                    <div class="controls">
                                        <textarea name="diferenciadores" id="diferenciadores" class="input-large"></textarea>
                                        <span class="help-inline"></span>
                                    </div>
                                </div>                                                                                                                         
                                </fieldset>
                                 <fieldset>
                                <legend>Informaci&oacute;n num&eacute;rica</legend> 
                                           <div class="control-group">
                                    <label class="control-label" for="absorcion">Absorci&oacute;n</label>
                                    <div class="controls">
                                      <input name="absorcion" id="absorcion" class="input-small" type="text">                                        <span class="help-inline"></span>
                                    </div>
                                </div>  
                                      <div class="control-group">
                                    <label class="control-label" for="precio">Precio</label>
                                    <div class="controls">
                                        $ <input name="precio" id="precio" class="input-small" type="text">                                        <span class="help-inline"></span>
                                    </div>
                                </div>                                                                
                                <div class="control-group">
                                    <label class="control-label" for="metrosCuadrados">Metros cuadrados</label>
                                    <div class="controls">
                                        <input name="metrosCuadrados" id="metrosCuadrados" class="input-small" type="text">
                                        <span class="help-inline"></span>
                                    </div>
                                </div> 
                                     <div class="control-group">
                                    <label class="control-label" for="precioTerreno">Precio m2 del terreno</label>
                                    <div class="controls">
                                        $ <input name="precioTerreno" id="precioTerreno" class="input-small" type="text">                                        <span class="help-inline"></span>
                                    </div>
                                </div>  
                                    <div class="control-group">
                                    <label class="control-label" for="anchoTerreno">Ancho del terreno</label>
                                    <div class="controls">
                                        <input name="anchoTerreno" id="anchoTerreno" class="input-small" type="text">
                                        <span class="help-inline"></span>
                                    </div>                              
                                 </div>  
                                     <div class="control-group">
                                    <label class="control-label" for="largoTerreno">Largo del terreno</label>
                                    <div class="controls">
                                        <input name="largoTerreno" id="largoTerreno" class="input-small" type="text">
                                        <span class="help-inline"></span>
                                    </div>                              
                                 </div>                                                              
                                 <div class="control-group">
                                    <label class="control-label" for="unidadesTotales">Unidades totales*</label>
                                    <div class="controls">
                                        <input name="unidadesTotales" id="unidadesTotales" class="input-small" type="text">
                                        <span class="help-inline"></span>
                                    </div>
                                </div> 
                                  <div class="control-group">
                                    <label class="control-label" for="unidadesVendidas">Unidades vendidas*</label>
                                    <div class="controls">
                                        <input name="unidadesVendidas" id="unidadesVendidas" class="input-small" type="text">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                  <div class="control-group">
                                    <label class="control-label" for="montoSeparacion">Monto de separaci&oacute;n</label>
                                    <div class="controls">
                                        $ <input name="montoSeparacion" id="montoSeparacion" class="input-small" type="text">                                        <span class="help-inline"></span>
                                    </div>
                                </div> 
                                 <div class="control-group">
                                    <label class="control-label" for="porcentajeEngancheMin">Porcentaje de enganche m&iacute;nimo</label>
                                    <div class="controls">
										<select class="span2" name='porcentajeEngancheMin'>
										<?php 
										$percent = 0;
										while($percent<=100){
										?>
										<option value="<?php echo $percent?>"><?php echo $percent?>%</option>
											<?php 
											$percent+=5;
										 }
											?>
										</select>
										</div>
                                </div> 
                                                           
                                 <div class="control-group">
                                    <label class="control-label" for="creditoSobreEnganche">Cr&eacute;dito sobre enganche</label>
                                    <div class="controls">
                                        <input name="creditoSobreEnganche" id="creditoSobreEnganche" class="input-small" type="text"> meses                                       <span class="help-inline"></span>
                                    </div>
                                </div>
                                </fieldset> 
                                </div>                                                                                              
                                     <?php 
						$c = "SELECT * FROM `caracteristicas`";
						$dataCaract = mysql_query( $c );
						if (!$dataCaract) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
					?>
                            <!-- Caracteristicas -->
					<div class="tab-pane" id="tab2">
					 <h1>Caracter&iacute;sticas del modelo</h1>					 
                                 <fieldset>
                                <legend>Otras caracter&iacute;sticas</legend>
                                 <?php 
                                    while ($data = mysql_fetch_array($dataCaract, MYSQL_ASSOC)) {
                                    	?>                                                                      
                                  <div class="control-group">
                                      <label class="control-label" for="<?php echo $data["nombre"]?>"><?php echo $data["nombre"]?></label>                  					
                                   <div class="controls">
                                   	 <select class="span2" name='caracteristicas_<?php echo $data["idcaracteristicas"]?>'>
										<?php 
										$int = 0;
										while($int <=10){
										?>
										<option value="<?php echo $int?>"><?php echo $int?></option>
											<?php
											if($data["nombre"]=="Baños"){
												$int+=0.5;
											}else { 
											$int++;
										 }
										}
											?>
										</select>
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <?php 
                                }
						} 
                                ?>                                                                                                                                                                                                                   
                            </fieldset>                    
					</div>
					<!-- Imagenes -->
					<div class="tab-pane" id="tab3">
					 <h1>Im&aacute;genes del modelo</h1>
					 <fieldset>                             
                                 <legend>Distribuci&oacute;n</legend> 
                             <div id="distribuciones">
                               
                                </div>                                
                                <input type="hidden" id="contDist" name="contDist" value="1">
                                <!-- onclick="createDivDistribuciones()" -->
                                 <a class="btn addDist"  onclick="createDivDistribuciones()"><i class="icon-plus-sign"></i>Agregar otra</a>                                   
                                </fieldset>
                                 <fieldset>                             
                                 <legend>Im&aacute;genes de fachadas </legend>
                                    <div class="control-group" id="fachadas">
                                    <input type='hidden' id="contFachadas" name="contFachadas">
                                    <label class="control-label" for="fachada1">Im&aacute;gen de fachada 1</label>                                    
                                    <div class="controls">
                                        <input name="fachada1" id="fachada1" class="input-medium inputFachada" type="file" >                                       
                                        <span class="help-inline"></span>   
                                         <div id="errorfachada1"></div>                                    
                                    </div>
                                </div>
                                <a class="btn" onclick="createDivFachadas()"><i class="icon-plus-sign"></i>Agregar otra</a>                                 
                                 </fieldset>                                    
												
					</div>					
					<?php 
						$a = "SELECT * FROM `atributos` ORDER BY nombre ASC";
						$dataAtributos = mysql_query( $a );
						if (!$dataAtributos) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
					?>
					<!-- Atributos -->
					<div class="tab-pane" id="tab4">
					 <fieldset>
                         <legend>Atributos del modelo</legend>  
						 <div class="control-group">
                                  <label class="control-label">Seleccionar y calificar atributos:</label>                                
                                     <div class="controls">
                                     <?php 
                                    while ($data = mysql_fetch_array($dataAtributos, MYSQL_ASSOC)) {
                                    	?>
                                    <label class="checkbox">
                                      <input id="<?php echo $data["idatributos"]?>" type="checkbox" value="<?php echo  $data["nombre"]?>" name="atributo_<?php echo  $data["idatributos"]?>">
                                      <?php echo $data["nombre"]?>
                                    </label>
                                      <div class="controls">
                                      <input id="<?php echo  $data["idatributos"]?>" type="radio" value="Verde" name="calificacion_<?php echo  $data["idatributos"]?>"><img src="assets/img/bullet_green.png"/>
                                          <input id="<?php echo  $data["idatributos"]?>" type="radio" value="Amarillo" name="calificacion_<?php echo $data["idatributos"]?>"><img src="assets/img/bullet_yellow.png"/>                                  
                                      <input id="<?php echo  $data["idatributos"]?>" type="radio" value="Rojo" name="calificacion_<?php echo $data["idatributos"]?>"><img src="assets/img/bullet_red.png"/>                                
                                   </div>
                                   <hr/>
                                   <?php 
                                   	}
						}
                                   ?>
                                     <span class="help-inline"></span>     
                                  </div>
                                </div>
                                </fieldset>
					</div>										
					</div><!-- div tab-content -->
					<div class="tabbable tabs-below">
					<!-- Only required for left/right tabs -->
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1" data-toggle="tab">Datos b&aacute;sicos</a></li>
					<li><a href="#tab2" data-toggle="tab">Caracter&iacute;sticas</a></li>
					<li><a href="#tab3" data-toggle="tab">Im&aacute;genes</a></li>
					<li><a href="#tab4" data-toggle="tab">Atributos</a></li>				
				</ul>
					<div class="form-actions">                                   
                                   <button class="btn btn-primary" type="submit">Registrar</button>
                                    <button class="btn btn-primary" onclick="agregarOtro()">Registrar y agregar otro modelo...</button>
                             	<input type="hidden" id="agregar" name="agregar"/>
                             	<a href="#modalCancel" data-toggle="modal" class="openCancel2 btn" 
						> Cancelar</a>	   </div>
                                   
				</div>
				</div>
						<div id="modalCancel1" class="modal hide fade in">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Cancelar registro</h3>
    </div>
    <div class="modal-body">     
     <p>Atenci&oacute;n! Se borrarán los campos capturados.</p>
      <p>Deseas continuar?</p>            
     </div>
    <div class="modal-footer">
      <button class="quit btn btn-danger" type="reset" >Cancelar</button>
      <a href="#" class="btn secondary" data-dismiss="modal">Regresar</a>
    </div>
</div>       		
				 </form>		                 
            </div> <!-- /span -->
        </div><!-- /row -->
        </div><!-- /container -->   
        <script type="text/javascript">
		function agregarOtro(){
			document.getElementById("agregar").value=1;
document.getElementById("registroModelo").submit();

			}
        </script>        
<?php 
include "includes/footer_principal.php";
 ?>