<?php
/* Pagina editar modelo de proyecto vertical
Se despliega la forma con los datos del modelo de proyecto a editar.
Esta pagina solo es accesada por el administrador, revision.
 */
$pageTitle = "SIGII | Editar Modelo Vertical";
include "includes/header_aplicacion.php";
	//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
	$usuariologueado = new Usuarios();
	$usuariologueado = $_SESSION["usuario"];
	if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision")) {
	header("Location: bienvenido.php");
	}
	include "clases/Conexion.php";
	$conexion = new Conexion();
	$link = $conexion->dbconn();	
	$idModelo=$_GET["id"];
	$dataModelo = "SELECT * FROM modelo WHERE idmodelo ='".$idModelo."'";
	$result1 = mysql_query( $dataModelo);
	$dataModeloFracc = "SELECT * FROM modelodepartamento WHERE modelo_idmodelo ='".$idModelo."'";
	$result2 = mysql_query( $dataModeloFracc);
	$dataAtributo="SELECT * FROM incluyeatributo WHERE idmodelo = '".$idModelo."'";
	$result3=mysql_query( $dataAtributo);
	$dataCaract="SELECT * FROM incluyecaracteristica WHERE modelo_idmodelo='".$idModelo."'";
	$result4=mysql_query($dataCaract);	
	if (!$result1 || !$result2 || !$result3 || !$result4 ) {
		die('No se pudo realizar la consulta:' . mysql_error());
		//header("Location: ../bienvenido.php");
	} else {
		$data1 = mysql_fetch_array($result1);
		$data2 = mysql_fetch_array($result2);
		
		$caractArray[][2]="";
		$i=0;
		while ( $data4 = mysql_fetch_array($result4, MYSQL_ASSOC)){
			$caractArray[$i][0]= $data4["caracteristicas_idcaracteristicas"];
			$caractArray[$i][1]= $data4["cantidad"];
			$i++;
		}
		function checarIncluyeCaract($idC ){
		
			global $caractArray;
			$cantidad="";
			foreach($caractArray as $value){
				if($value[0]==$idC){
					$cantidad=$value[1];
				}
			}
			return $cantidad;
		}
		$atributoArray[][2]="";
		$i=0;
		while ( $data3 = mysql_fetch_array($result3, MYSQL_ASSOC)){
			$atributoArray[$i][0]= $data3["idatributo"];
			$atributoArray[$i][1]= $data3["calificacion"];
			$i++;
		}
		function checarIncluyeAtributo($idA ){
		
			global $atributoArray;
			$calif="";
			foreach($atributoArray as $value){
				if(isset($value[0]) && $value[0]==$idA){
					$calif=$value[1];
				}
			}
			return $calif;
		}
	}
?>
        <div class="container">          
        <div class="row">      
            <div class="span7 offset2">
              <div class="alert alert-info">
  <button class="close" data-dismiss="alert">×</button>
  <strong>Atenci&oacute;n!</strong> Aseg&uacute;rate de llenar la informaci&oacute;n de todas las etiquetas.
</div>
  <form class="forma form-horizontal well" action="control/EditarModelo.php" method="post" enctype="multipart/form-data">                                                    
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
						  <h1>Datos del modelo vertical</h1>
						  <input type="hidden" name="idmodelo" value="<?php echo $idModelo?>">
                            <fieldset>
                                <legend>Informaci&oacute;n necesaria</legend>                               
                                          <?php 
					$q = "SELECT idproyecto, nombre, promotor FROM proyecto WHERE tipo= 'vertical' ";
						$proyectos = mysql_query( $q);
						if (!$proyectos) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
					?>           
					<div class="control-group">
									<label class="control-label" for="proyecto">Proyecto</label>
									<div class="controls">
									  <input type="hidden" name="tipo" value="vertical">
										<select class="span2" name='proyecto'>
											<?php 
											while ($data = mysql_fetch_array($proyectos, MYSQL_ASSOC)) {
												if($data1["proyecto_idproyecto"]==$data["idproyecto"]){?>	
													<option value="<?php echo $data["idproyecto"]?>" selected=selected><?php echo $data["nombre"]?>-<?php echo $data["promotor"]?></option>
											<?php }else{ ?>																															
											<option value="<?php echo $data["idproyecto"]?>"><?php echo $data["nombre"]?>-<?php echo $data["promotor"]?></option>
											<?php 
												}
						}
						}
											?>
										</select> <span class="help-inline"></span>
									</div>
								</div>
                                 <div class="control-group">
                                    <label class="control-label" for="nombres">Nombre del modelo</label>
                                    <div class="controls">
                                        <input name="nombre" id="nombre" class="input-large" type="text" value="<?php echo $data1["nombre"]?>">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>                               
                                <div class="control-group">
                                    <label class="control-label" for="diferenciadores">Diferenciadores</label>
                                    <div class="controls">
                                        <textarea name="diferenciadores" id="diferenciadores" class="input-large"><?php echo $data1["diferenciadores"]?></textarea>
                                        <span class="help-inline"></span>
                                    </div>
                                </div>                                                                                                                         
                                </fieldset>
                                 <fieldset>
                                <legend>Informaci&oacute;n num&eacute;rica</legend> 
                                 <div class="control-group">
                                    <label class="control-label" for="precioPromedio">Precio promedio*</label>
                                    <div class="controls">
                                        $ <input name="precioPromedio" id="precioPromedio" class="input-small" type="text" value="<?php echo $data2["precioPromedio"]?>">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>  
                                  <div class="control-group">
                                    <label class="control-label" for="precioMin">Precio m&iacute;nimo*</label>
                                    <div class="controls">
                                       $ <input name="precioMin" id="precioMin" class="input-small" type="text" value="<?php echo $data2["precioMin"]?>">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="precioMax">Precio m&aacute;ximo*</label>
                                    <div class="controls">
                                        $ <input name="precioMax" id="precioMax" class="input-small" type="text" value="<?php echo $data2["precioMax"]?>">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>                                                                              
                                <div class="control-group">
                                    <label class="control-label" for="metrosCuadrados">Metros cuadrados</label>
                                    <div class="controls">
                                        <input name="metrosCuadrados" id="metrosCuadrados" class="input-small" type="text" value="<?php echo $data1["metrosCuadrados"]?>">
                                        <span class="help-inline"></span>
                                    </div>
                                </div> 
                                                                              
                                 <div class="control-group">
                                    <label class="control-label" for="unidadesTotales">Unidades totales</label>
                                    <div class="controls">
                                        <input name="unidadesTotales" id="unidadesTotales" class="input-small" type="text" value="<?php echo $data1["unidades"]?>">
                                        <span class="help-inline"></span>
                                    </div>
                                </div> 
                                  <div class="control-group">
                                    <label class="control-label" for="unidadesVendidas">Unidades vendidas</label>
                                    <div class="controls">
                                        <input name="unidadesVendidas" id="unidadesVendidas" class="input-small" type="text" value="<?php echo $data1["unidadesVendidas"]?>">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                  <div class="control-group">
                                    <label class="control-label" for="montoSeparacion">Monto de separaci&oacute;n</label>
                                    <div class="controls">
                                        $ <input name="montoSeparacion" id="montoSeparacion" class="input-small" type="text" value="<?php echo $data1["montoSeparacion"]?>">
                                                                                <span class="help-inline"></span>
                                    </div>
                                </div> 
                                 <div class="control-group">
                                    <label class="control-label" for="porcentajeEngancheMin">Porcentaje de enganche m&iacute;nimo</label>
                                    <div class="controls">
										<select class="span2" name='porcentajeEngancheMin'>
										<?php 
										$percent = 0;
										while($percent<=100){
											if($data1["porcentajeEngancheMin"]==$percent){
										?>
										<option value="<?php echo $percent?>" selected=selected><?php echo $percent?>%</option>
										<?php } else {?>
										<option value="<?php echo $percent?>"><?php echo $percent?>%</option>
											<?php 
										}$percent+=5;
										 }
											?>
										</select>
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
											if(checarIncluyeCaract($data["idcaracteristicas"])==$int){
										?>
										<option value="<?php echo $int?>" selected=selected><?php echo $int?></option>
										<?php } else {?>
										<option value="<?php echo $int?>"><?php echo $int?></option>
											<?php
										}
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
                                 <?php 
                                 $imagenes="SELECT * FROM imagenes WHERE modelo_idmodelo='".$idModelo."' AND tipo = 'distribucion'";
                                 $result=mysql_query($imagenes);
                                 $i=1;
                                 while($data=mysql_fetch_array($result)){?>
                                 <div class="control-group">
                                    <label class="control-label" for="distribucion1">Im&aacute;gen de distribuci&oacute;n <?php echo $i?></label>                                    
                                    <div class="controls">                                    
                                        <img
											src="<?php echo $data["path"]?>" id="<?php echo $data["idimagenes"]?>">
                                       <input type="hidden" name="eliminaImagen<?php echo $data["idimagenes"]?>" id="eliminaImagen<?php echo $data["idimagenes"]?>">                                       
                                        <a href="#" class="btn" onclick="EliminaImagen2(<?php echo $data["idimagenes"]?>,<?php echo $i?>)"><i class="icon-remove-circle"></i>Eliminar</a>                                       
                                        <span class="help-inline"></span>
                                       
                                    </div>
                                </div> 
                                <?php $i++;}?> 
                                </div>
                                <input type="hidden" id="contDist" name="contDist" value="<?php echo $i?>">
                                 <a class="btn" onclick="createDivDistribuciones()"><i class="icon-plus-sign"></i>Agregar otra</a>                                 
                                                                                           
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
                                    	$calificacion=checarIncluyeAtributo($data["idatributos"]);                                 	
											if($calificacion==""){
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
											}else if($calificacion!=""){ ?>
											 <label class="checkbox">                                    
                                      <input id="<?php echo $data["idatributos"]?>" type="checkbox" checked=checked value="<?php echo  $data["nombre"]?>" name="atributo_<?php echo  $data["idatributos"]?>">
                                      <?php echo $data["nombre"]?>
                                    </label>
                                      <div class="controls">
                                      <?php if($calificacion=="Verde"){?>
                                        <input id="<?php echo  $data["idatributos"]?>" type="radio" checked=checked value="Verde" name="calificacion_<?php echo  $data["idatributos"]?>"><img src="assets/img/bullet_green.png"/>
                                     <?php } else {?>
                                       <input id="<?php echo  $data["idatributos"]?>" type="radio" value="Verde" name="calificacion_<?php echo  $data["idatributos"]?>"><img src="assets/img/bullet_green.png"/>
                                     <?php } 
                                      if($calificacion=="Amarillo"){?>
                                        <input id="<?php echo  $data["idatributos"]?>" type="radio" checked=checked value="Amarillo" name="calificacion_<?php echo $data["idatributos"]?>"><img src="assets/img/bullet_yellow.png"/>                                  
                                     <?php } else {?>
                                          <input id="<?php echo  $data["idatributos"]?>" type="radio" value="Amarillo" name="calificacion_<?php echo $data["idatributos"]?>"><img src="assets/img/bullet_yellow.png"/>                                  
                                     <?php }
                                     if($calificacion=="Rojo"){ ?>
                                      <input id="<?php echo  $data["idatributos"]?>" type="radio" checked=checked value="Rojo" name="calificacion_<?php echo $data["idatributos"]?>"><img src="assets/img/bullet_red.png"/>                                
                                     <?php } else {?>
                                      <input id="<?php echo  $data["idatributos"]?>" type="radio" value="Rojo" name="calificacion_<?php echo $data["idatributos"]?>"><img src="assets/img/bullet_red.png"/>                                
                                   <?php }?>
                                   </div>
                                   <hr/>
									<?php }
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
                                   <button class="btn btn-primary" type="submit">Editar</button>
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
		
		function EliminaImagen2(id,file){
			document.getElementById(id).style.visibility="hidden";
			document.getElementById("eliminaImagen"+id).value=id;
			}
        </script>                      
<?php 
include "includes/footer_principal.php";
 ?>