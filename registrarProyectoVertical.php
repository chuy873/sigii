<?php
/* Pagina Registrar proyecto vertical
			 Se despliega la forma para ingresar los datos necesarios para el proyecto a registrar.
			 Esta pagina solo es accesada por el administrador, revision y captura.
			 */
$pageTitle = "SIGII | Registrar proyecto vertical";
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
		header("Location: bienvenido.php");
   }
 include "includes/header_aplicacion.php";
 include "clases/Conexion.php";
   $conexion = new Conexion();
   $link = $conexion->dbconn();
  ?>
        <div class="container">         
        <div class="row">      
            <div class="span10 offset1">
              <div class="alert alert-info">
  <button class="close" data-dismiss="alert">×</button>
  <strong>Atenci&oacute;n!</strong> Aseg&uacute;rate de llenar la informaci&oacute;n de todas las etiquetas.
</div>
  <form id="registroVertical" class="forma form-horizontal well" action="control/RegistrarProyecto.php" method="post" enctype="multipart/form-data">                                      
 	<div class="tabbable">
				<!-- Only required for left/right tabs -->
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1" data-toggle="tab">Datos b&aacute;sicos</a></li>
					<li><a href="#tab2" data-toggle="tab">Im&aacute;genes</a></li>
					<li><a href="#tab3" data-toggle="tab">Ubicaci&oacute;n</a></li>
					<li><a href="#tab4" data-toggle="tab">Amenidades</a></li>
					<li><a href="#tab5" data-toggle="tab">Acabados</a></li>
					<li><a href="#tab6" data-toggle="tab">Promociones</a></li>
					<li><a href="#tab7" data-toggle="tab">Paquetes de acabados</a></li>	
					<li><a href="#tab8" data-toggle="tab">Comentarios</a></li>							
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="tab1">
						  <h1>Datos del proyecto vertical</h1>
                            <fieldset>
                                <legend>Informaci&oacute;n necesaria</legend> 
                                     <div class="control-group"> <label class="control-label"><i>* Campos obligatorios</i>	</label></div>
                                                            
                                 <div class="control-group">
                                    <label class="control-label" for="nombres">Nombre del proyecto*</label>                                   
                                    <div class="controls">
                                        <input name="nombre" id="nombre" class="input-large" type="text">
                                           <input type="hidden" name="tipo" value="vertical"> <span class="help-inline">
											<div class="alert alert-error" id="alertNombre"
												style="display: none">
												<strong>Atenci&oacute;n!</strong> El nombre ya existe.
												Selecciona otro.
											</div>
										</span>
									</div>
                                </div>                               
                                <div class="control-group">
                                    <label class="control-label" for="promotor">Promotor*</label>
                                    <div class="controls">
                                        <input name="promotor" id="promotor" class="input-medium" type="text">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                   <div class="control-group">
                                    <label class="control-label" for="telefono">Tel&eacute;fono</label>
                                    <div class="controls">
                                        <input name="telefono" id="telefono" class="input-medium" type="text">
                                        <span class="help-inline"></span>
                                    </div>
                                </div> 
                               <div class="control-group">
                                    <label class="control-label" for="inicioVentas">Fecha de inicio de ventas</label>
                                    <div class="controls">
                               <input name="inicioVentas"  type="text" class="span2" value="<?php date_default_timezone_set('America/Mexico_City'); echo date('Y-m-d'); ?>" id="dp1">                                    
                                       <span class="help-inline"></span>
                                    </div>
                                </div>    
                                   <div class="control-group">
                                    <label class="control-label" for="inicioVentas">Fecha de revisi&oacute;n</label>
                                    <div class="controls">
                               <input name="fechaRevision"  type="text" class="span2" value="<?php date_default_timezone_set('America/Mexico_City'); echo date('Y-m-d'); ?>" id="dp2" >
                                       <span class="help-inline"></span>
                                    </div>
                                </div> 
                                <div class="control-group">
                                    <label class="control-label" for="descripcion">Descripci&oacute;n</label>
                                    <div class="controls">
                                    <textarea name="descripcion" class="input-xlarge" id="descripcion" rows="5"
                                     placeholder="Breve descripción del proyecto..."></textarea>
                                    <span class="help-inline"></span>
                                    </div>
                                </div>
                                 <div class="control-group">
                                    <label class="control-label" for="caracteristicas">Caracter&iacute;sticas</label>
                                    <div class="controls">
                                       <textarea name="caracteristicas" class="input-xlarge" id="caracteristicas" rows="3"
                                        placeholder="Zona, vialidades, etc..."></textarea>
                                      <span class="help-inline"></span>
                                    </div>
                                </div>
                                 <div class="control-group">
                                    <label class="control-label" for="link">P&aacute;gina web del proyecto</label>
                                    <div class="controls">
                                        <input name="link" id="link" class="input-large" type="text" placeholder="www.ejemplo.com">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>                                                             
                                  <div class="control-group">
                                  <label class="control-label" for="segmento">Segmento*</label>
                                  <div class="controls">
                                  <select class="span2" name='segmento' id='segmento'>
                                  <option value="Social" selected=selected>Social</option>
                                  <option value="Economico" >Econ&oacute;mico</option>
                                  <option value="Medio">Medio</option>
                                  <option value="Residencial">Residencial</option>
                                  <option value="Residencial Plus">Residencial Plus</option>
                                  <option value="Premium">Premium</option>                                 
                                  </select>
                                  <span class="help-inline"></span>                                    
                                  </div>
                                </div>
                                </fieldset>
                                 <fieldset>
                                <legend>Informaci&oacute;n num&eacute;rica</legend>                                      
                                 <div class="control-group">
                                    <label class="control-label" for="unidadesTotales">Unidades totales</label>
                                    <div class="controls">
                                        <input name="unidadesTotales" id="unidadesTotales" class="input-small" type="text">
                                        <span class="help-inline"><i>Dejar vac&iacute;o si se tiene informaci&oacute;n de unidades totales de los modelos.</i></span>
                                    </div>
                                </div> 
                                  <div class="control-group">
                                    <label class="control-label" for="unidadesVendidas">Unidades vendidas</label>
                                    <div class="controls">
                                        <input name="unidadesVendidas" id="unidadesVendidas" class="input-small" type="text">
                                        <span class="help-inline"><i>Dejar vac&iacute;o si se tiene informaci&oacute;n de unidades vendidas de los modelos.</i></span>
                                    </div>
                                </div>                                
                                  <div class="control-group">
                                    <label class="control-label" for="pisos">Pisos</label>
                                    <div class="controls">
                                        <select class="span2" name='pisos'  id='pisos'  >
										<option value="0" selected=selected>0</option>
										<?php 
										$int = 1;
										while($int <=10){
										?>
										<option value="<?php echo $int?>"><?php echo $int?></option>
											<?php 
											$int++;
										 }
											?>
										</select>  <span class="help-inline"></span>
                                    </div>
                                </div> 
                                   <div class="control-group">
                                    <label class="control-label" for="vendidas1Q">Vendidas 1Q</label>
                                    <div class="controls">
                                        <input name="vendidas1Q" id="vendidas1Q" class="input-small" type="text">
                                        <span class="help-inline"></span>
                                    </div>
                                </div> 
                                  <div class="control-group">
                                    <label class="control-label" for="vendidas2Q">Vendidas 2Q</label>
                                    <div class="controls">
                                        <input name="vendidas2Q" id="vendidas2Q" class="input-small" type="text">
                                        <span class="help-inline"></span>
                                    </div>
                                </div> 
                                  <div class="control-group">
                                    <label class="control-label" for="vendidas3Q">Vendidas 3Q</label>
                                    <div class="controls">
                                        <input name="vendidas3Q" id="vendidas3Q" class="input-small" type="text">
                                        <span class="help-inline"></span>
                                    </div>
                                </div> 
                                  <div class="control-group">
                                    <label class="control-label" for="vendidas4Q">Vendidas 4Q</label>
                                    <div class="controls">
                                        <input name="vendidas4Q" id="vendidas4Q" class="input-small" type="text">
                                        <span class="help-inline"></span>
                                    </div>
                                </div> 
                                  <div class="control-group">
                                    <label class="control-label" for="torres">Torres</label>
                                    <div class="controls">
                                       <select class="span2" name='torres'>
                                       <option value="0" selected=selected>0</option>
										<?php 
										$int = 1;
										while($int <=10){
										?>
										<option value="<?php echo $int?>"><?php echo $int?></option>
											<?php 
											$int++;
										 }
											?>
										</select> <span class="help-inline"></span>
                                    </div>
                                </div> 
                                 <div class="control-group">
                                    <label class="control-label" for="numeroModelos">N&uacute;mero de modelos</label>
                                    <div class="controls">
                                    	 <select class="span2" name='numeroModelos'>
										<?php 
										$int = 0;
										while($int <=20){
										?>
										<option value="<?php echo $int?>"><?php echo $int?></option>
											<?php 
											$int++;
										 }
											?>
										</select>
                                        <span class="help-inline"></span>
                                    </div>
                                </div> 
                                   <div class="control-group">
                                    <label class="control-label" for="numeroMedidores">N&uacute;mero de medidores</label>
                                    <div class="controls">
                                    	 <select class="span2" name='numeroMedidores'>
										<?php 
										$int = 0;
										while($int <=20){
										?>
										<option value="<?php echo $int?>"><?php echo $int?></option>
											<?php 
											$int++;
										 }
											?>
										</select>
                                        <span class="help-inline"></span>
                                    </div>
                                </div>  
                                 <div class="control-group">
                                    <label class="control-label" for="llamadasSeguimiento">Llamadas de seguimiento</label>
                                    <div class="controls">
                                         <select class="span2" name='torres'>
										<?php 
										$int = 0;
										while($int <=10){
										?>
										<option value="<?php echo $int?>"><?php echo $int?></option>
											<?php 
											$int++;
										 }
											?></select> <span class="help-inline"></span>
                                    </div>
                                </div> 
                                  <div class="control-group">
                                    <label class="control-label" for="tiempoMercado">Tiempo en el mercado</label>
                                    <div class="controls">
                                        <input name="tiempoMercado" id="tiempoMercado" class="input-small" type="text"> meses
                                        <span class="help-inline"></span>
                                    </div>
                                </div>                                                                                                                                                                             
                            </fieldset>                    
					</div>
					<!-- Imagenes -->
					<div class="tab-pane" id="tab2">
					 <h1>Im&aacute;genes del proyecto</h1>
					 <fieldset>
                                <legend>Logo</legend>  
						 <div class="control-group">
                                    <label class="control-label" for="logoProyecto">Logo del proyecto</label>
                                    <div class="controls">
                                        <input name="logoProyecto" id="logoProyecto	" class="input-medium" type="file"
                                         onchange="comprueba_extension(this.value,'logo')">
                                        <span class="help-inline"></span>
                                         <div id="errorlogo"></div>
                                    </div>
                                </div>
                                </fieldset> 
                                <fieldset>
                                 <legend>Im&aacute;genes principales</legend> 
                                 <div class="control-group">
                                    <label class="control-label" for="previaTorre">Vista previa de torre</label>                                    
                                    <div class="controls">
                                        <input name="previaTorre" id="previaTorre" class="input-medium" type="file"
                                         onchange="comprueba_extension(this.value,'vistaprevia')">
                                        <span class="help-inline"></span>
                                         <div id="errorvistaprevia"></div>
                                        <p class="help-block">Para proyectos verticales.</p>
                                    </div>
                                </div>                                 
                                </fieldset>                                    
					<fieldset>
                                 <legend>Im&aacute;genes de amenidades</legend> 
                                 <?php $k=1;
                                 while($k<=4){
                                 ?>
                                 <div class="control-group">
                                    <label class="control-label" for="imagenAmenidad<?php echo $k?>">Im&aacute;gen de amenidad <?php echo $k?></label>                                    
                                    <div class="controls">
                                        <input name="imagenAmenidad<?php echo $k?>" id="imagenAmenidad<?php echo $k?>" class="input-medium" type="file"
                                         onchange="comprueba_extension(this.value,'amenidad<?php echo $k?>')">
                                        <span class="help-inline"></span>
                                       <div id="erroramenidad<?php echo $k?>"></div>
                                    </div>
                                </div>
                                <?php $k++;
                                 }
                                 ?>                               
						</fieldset>												
					</div>
					<?php 
						$q = "SELECT * FROM `zona` GROUP BY ciudad ASC";
						$zona = mysql_query( $q);
						if (!$zona) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
					?>
					<!--Ubicacion-->
					<div class="tab-pane" id="tab3">
					 <h1>Ubicaci&oacute;n del proyecto</h1>
							<fieldset>
								<legend>Direcci&oacute;n</legend>
								     <div class="control-group"> <label class="control-label"><i>* Campos obligatorios</i>	</label></div>                              
								<div class="control-group">
									<label class="control-label" for="colonia">Colonia</label>
									<div class="controls">
										<input name="colonia" id="colonia" class="input-medium"
											type="text"> <span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="municipio">Municipio*</label>
									<div class="controls">
										<input name="municipio" id="municipio" class="input-medium"
											type="text"> <span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="municipio">Zona*</label>
									<div class="controls">
										<select class="span2" name='ciudad' id='ciudad' onchange="desplegarSubzona(this.value)">
											<option value="" selected=selected disabled=disabled>Selecciona la zona</option>
											<?php 
											while ($data = mysql_fetch_array($zona, MYSQL_ASSOC)) {						
											?>
											<option value="<?php echo $data["ciudad"]?>"><?php echo $data["ciudad"]?></option>
											<?php 
												}
						}
											?>
										</select>  <span class="help-inline"></span>
									</div>
								</div>
								<div class="control-group">
									<label class="control-label" for="subzona">Subzona</label>
									<div class="controls" id="subzona">										
									</div>
								</div>								
								</fieldset>								
								<?php 
						$q = "SELECT * FROM `puntosafluencia` GROUP BY tipo ASC";
						$result = mysql_query( $q);
						if (!$zona) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
					?>
								<fieldset>
								<legend>Puntos de afluencia</legend>
								<div class="control-group" id="puntoStart">								
								<input type="hidden" id="contPuntos" name="contPuntos">
								<div class="control-group">																								
										<label class="control-label" >Tipo</label>
									<div class="controls">
											<select class="span2" name='puntoAfluencia1' id='1' onchange="desplegarPuntos(this.value, this.id)">
											<option value="">Seleccione un tipo</option>
											<?php 
											while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {						
											?>
											<option value="<?php echo $data["tipo"]?>"><?php echo $data["tipo"]?></option>
											<?php 
												}
						}
											?>
										</select>  <span class="help-inline"></span>
									</div>
									<div class="control-group">
									<label class="control-label">Punto 1</label>
									<div class="controls" id="punto1">																	
									</div>
								</div>	
									<label class="control-label" for="distanciaAfluencia1">Distancia</label>
									<div class="controls">									
										<input name="distanciaAfluencia1" id="distanciaAfluencia1"
											class="input-small" type="text"> kil&oacute;metros <span
											class="help-inline"></span>
										</div>										
									</div>
									<hr/>
									</div>
									<a class="btn" onclick="desplegarOtro()">Otro...</a>																																																				
							</fieldset>
							<fieldset>
								<legend>Ubicaci&oacute;n geogr&aacute;fica</legend>
								<div class="control-group">
									<label class="control-label" for="posicionamiento">Posicionamiento
										en mapa</label>
									<div class="controls">
									
										<p class="help-block">Google Earth.</p>
										   <p>Instrucciones:</p>
										   	<p>1. Haz clic en <button  class="btn btn-primary" id="posicionar" onclick="init()"><i
											class="icon-globe icon-white"></i> Posicionar</button></p>
										   <p>2. Dir&iacute;gete a la ubicaci&oacute;n del proyecto.</p>
										   <p>3. Haz clic en   <button class="btn btn-info" id="btnPoli" onclick="dibujar();"><i class="icon-pencil"></i>Dibujar pol&iacute;gono</button></p>
										   <p>4. Haz s&oacute;lo <b>1 clic</b> en el mapa donde deseas empezar el pol&iacute;gono y arrastra el rat&oacute;n para completar la forma.(No necesitas dejar
										   presionado el bot&oacute;n del rat&oacute;n)</p>
										   <p>5. Al terminar el pol&iacute;gono, haz otro clic con el rat&oacute;n. (Se rellenara el pol&iacute;gono de un color).</p>
										   <p>6. Para guardar  el pol&iacute;gono, haz clic en <button class="btn btn-primary" onclick="outKml();"><i class="icon-pencil"></i>Guardar pol&iacute;gono</button></p>
										   <p>*Si deseas eliminar el pol&iacute;gono, haz clic en 
     <button  class="btn btn-danger" onclick="borrar();"><i class="icon-trash"></i>Eliminar pol&iacute;gono</button></p>
       <div id='map3d' style='border: 1px solid silver; height: 600px; width: 600px;'></div>  
     <textarea name="earth" id="kml-out" style="display:none;"></textarea>	
									</div>

								</div>
							</fieldset>
						</div>
					<?php 
						$a = "SELECT * FROM `amenidad` ORDER BY nombre ASC";
						$amenidades = mysql_query( $a);
						if (!$amenidades) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
					?>
					<!-- Amenidades -->
					<div class="tab-pane" id="tab4">
					 <fieldset>
                         <legend>Amenidades del proyecto</legend>  
						 <div class="control-group">
                                  <label class="control-label">Seleccionar amenidades:</label>                                                                                                  
                                     <div id="amenidad" class="controls">
                                    <?php 
                                    while ($data = mysql_fetch_array($amenidades, MYSQL_ASSOC)) {						
                                    ?>
                                    <label class="checkbox">
                                      <input type="checkbox" name="amenidades[]" value=<?php echo $data["idamenidad"]?>>
                                      <?php echo $data["nombre"]?>
                                    </label>
                                   <?php 
                                   	}
						}
                                   ?>
                                     <span class="help-inline"></span>     
                                  </div>
                                </div>
                                </fieldset>
					</div>
					<?php 
						$a2 = "SELECT * FROM `acabado` ORDER BY nombre ASC";
						$acabado = mysql_query( $a2);
						if (!$acabado) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
					?>
					<!-- Acabados -->
					<div class="tab-pane" id="tab5">						
                                	 <fieldset>
                         <legend>Acabados del proyecto</legend>
                         <div class="control-group">
                                    <label class="control-label" for="entrega">Entrega</label>                                    
                                    <div class="controls">
                                    <select class="span2" name='entrega'>
                                  <option value="Gris" selected=selected>Gris</option>
                                  <option value="Blanca" >Blanca</option>
                                  <option value="Terminada">Terminada</option>                                  
                                  </select>
                                        <span class="help-inline"></span>
                                    </div>
                                </div>  
						 <div class="control-group">
                                    <label class="control-label">Seleccionar acabados: (Especificar los que s&iacute; incluye y los que se desea aclarar que no los incluye )</label>                                
                                     <div id="tipoAcab" class="controls">
                                    <?php 
                                    while ($data = mysql_fetch_array($acabado, MYSQL_ASSOC)) {						
                                    ?>
                                    <label class="inline">
                                      <p><?php echo $data["nombre"]?>	</p>
                                      <input type="radio" value="Si" name="acabado_<?php echo $data["idacabado"]?>">
                                     <i class="icon-ok-sign"></i>&nbsp;&nbsp;&nbsp; 
                                     <input type="radio" value="No" name="acabado_<?php echo $data["idacabado"]?>">
                                      <i class="icon-remove-sign"></i>
                                    </label>
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
					<div class="tab-pane" id="tab6">						
                                	 <fieldset>
                         <legend>Promociones</legend>
                         </fieldset>
                          <div class="control-group">
                                    <label class="control-label" for="promociones">Promociones</label>
                                    <div class="controls">
                                    <textarea name="promociones" class="input-xlarge" id="promociones" rows="8"
                                     placeholder="Promociones que incluye el proyecto..."></textarea>
                                    <span class="help-inline"></span>
                                    </div>
                                </div>
                         </div>  
                         <div class="tab-pane" id="tab7">						
                                	 <fieldset>
                         <legend>Paquetes de acabados</legend>
                         </fieldset>
                          <div class="control-group">
                                    <label class="control-label" for="paquetesAcabados">Paquetes de acabados</label>
                                    <div class="controls">
                                    <textarea name="paquetesAcabados" class="input-xlarge" id="paquetesAcabados" rows="8"
                                     placeholder="Paquetes de acabados del proyecto..."></textarea>
                                    <span class="help-inline"></span>
                                    </div>
                                </div>
                         </div> 
                           <div class="tab-pane" id="tab8">						
                                	 <fieldset>
                         <legend>Comentarios</legend>
                         </fieldset>
                          <div class="control-group">
                                    <label class="control-label" for="comentarios">Comentarios</label>
                                    <div class="controls">
                                    <textarea name="comentarios" class="input-xlarge" id="comentarios" rows="8"
                                     placeholder="Comentarios del proyecto..."></textarea>
                                    <span class="help-inline"></span>
                                    </div>
                                </div>
                         </div>  
					</div><!-- div tab-content -->
					<div class="tabbable tabs-below">
					<!-- Only required for left/right tabs -->
				<ul class="nav nav-tabs">
					<li class="active"><a href="#tab1" data-toggle="tab">Datos b&aacute;sicos</a></li>
					<li><a href="#tab2" data-toggle="tab">Im&aacute;genes</a></li>
					<li><a href="#tab3" data-toggle="tab">Ubicaci&oacute;n</a></li>
					<li><a href="#tab4" data-toggle="tab">Amenidades</a></li>
					<li><a href="#tab5" data-toggle="tab">Acabados</a></li>
					<li><a href="#tab6" data-toggle="tab">Promociones</a></li>
					<li><a href="#tab7" data-toggle="tab">Paquetes de acabados</a></li>	
					<li><a href="#tab8" data-toggle="tab">Comentarios</a></li>							
				</ul>
					<div class="form-actions">                                   
                                   <button class="btn btn-primary" type="submit">Registrar</button>
                                	<a href="#modalCancel" data-toggle="modal" class="openCancel2 btn" 
						> Cancelar</a>	
                                </div>
                                   
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
           <script type="text/javascript" src="http://www.google.com/jsapi?key=ABQIAAAAwbkbZLyhsmTCWXbTcjbgbRSzHs7K5SvaUdm8ua-Xxy_-2dYwMxQMhnagaawTo7L1FE1-amhuQxIlXw"></script>
  <script type="text/javascript">
google.load("earth", "1");
var ge = null;
var isMouseDown = false;
var lineStringPlacemark = null;
var coords = null;
var pointCount = 0;
var doc = null;
var dibuja=false;
function init() {
  google.earth.createInstance("map3d", initCB, failureCB);
}

function initCB(object) {
  ge = object;
  ge.getWindow().setVisibility(true);

  doc = ge.createDocument('');
  ge.getFeatures().appendChild(doc);

  ge.getNavigationControl().setVisibility(ge.VISIBILITY_AUTO);
  google.earth.addEventListener(ge.getGlobe(), 'mousemove', onmousemove); 
  google.earth.addEventListener(ge.getGlobe(), 'mousedown', onmousedown);

}
function dibujar(){
	document.getElementById("btnPoli").disabled=true;
	dibuja=true;
	
	//document.getElementById("btnPoli").disabled=true;
}
function borrar() {
	  var features = ge.getFeatures();	  
	  while (features.getFirstChild()) {
	    features.removeChild(features.getFirstChild());
	  }	 
	  doc = ge.createDocument('');
	  ge.getFeatures().appendChild(doc);
	
	  google.earth.addEventListener(ge.getGlobe(), 'mousemove', onmousemove); 
	  google.earth.addEventListener(ge.getGlobe(), 'mousedown', onmousedown);
		 
		  
	} 
function onmousemove(event) {
if(dibuja){
	  if (isMouseDown) {
    coords.pushLatLngAlt(event.getLatitude(), event.getLongitude(), 0);
  }
}
}

function convertLineStringToPolygon(placemark) {
  var polygon = ge.createPolygon('');
  var outer = ge.createLinearRing('');
  polygon.setOuterBoundary(outer);

  var lineString = placemark.getGeometry();
  for (var i = 0; i < lineString.getCoordinates().getLength(); i++) {
    var coord = lineString.getCoordinates().get(i);
    outer.getCoordinates().pushLatLngAlt(coord.getLatitude(), 
                                         coord.getLongitude(), 
                                         coord.getAltitude());
  }

  placemark.setGeometry(polygon);
}


function onmousedown(event) {
	if(dibuja){
  if (isMouseDown) {
    isMouseDown = false;
    coords.pushLatLngAlt(event.getLatitude(), event.getLongitude(), 0);

    convertLineStringToPolygon(lineStringPlacemark);
    dibuja=false;
    document.getElementById("btnPoli").disabled=false;
  } else {
    isMouseDown = true;

    lineStringPlacemark = ge.createPlacemark('');
    var lineString = ge.createLineString('');
    lineStringPlacemark.setGeometry(lineString);
    lineString.setTessellate(true);
    lineString.setAltitudeMode(ge.ALTITUDE_CLAMP_TO_GROUND);

    lineStringPlacemark.setStyleSelector(ge.createStyle(''));
    var lineStyle = lineStringPlacemark.getStyleSelector().getLineStyle();
    lineStyle.setWidth(4);
    lineStyle.getColor().set('ddffffff');  // aabbggrr formatx
    lineStyle.setColorMode(ge.COLOR_RANDOM);
    var polyStyle = lineStringPlacemark.getStyleSelector().getPolyStyle();
    polyStyle.getColor().set('ddffffff');  // aabbggrr format
    polyStyle.setColorMode(ge.COLOR_RANDOM);

    coords = lineString.getCoordinates();
    coords.pushLatLngAlt(event.getLatitude(), event.getLongitude(), 0);

    doc.getFeatures().appendChild(lineStringPlacemark);
  }
}
}
function failureCB(object) {
}

function outKml() {
  document.getElementById('kml-out').value = doc.getKml();
}

  </script>          
<?php include "includes/footer_principal.php" ?>
 <script type="text/javascript">
/*
 * LLamadas a seleccionador de fechas de bootstrap
 */
var currentTime = new Date();
var month = currentTime.getMonth() + 1;
var day = currentTime.getDate();
var year = currentTime.getFullYear();

function setToday(id){
	document.getElementById(id).value=year+"-"+month+"-"+day;
}
$(document).ready(function () {
$(function(){
	window.prettyPrint && prettyPrint();
	$('#dp1').datepicker({
		format: 'yyyy-mm-dd'
	});
});

$(function(){
	window.prettyPrint && prettyPrint();
	$('#dp2').datepicker({
		format: 'yyyy-mm-dd'
	});
});
});
  </script>