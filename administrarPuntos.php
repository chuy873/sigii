<?php 
	/* Pagina Administrar Puntos de afluencia
	 Se despliega la lista de todos los puntos registrados en la base de datos.
	 Además se pueden modificar y eliminar y tambien el usuario puede agregar un punto nuevo.
	 Esta pagina solo es accesada por el administrador, revision y captura.
	 */
$pageTitle = "SIGII | Administrar puntos de afluencia";
include "clases/Usuarios.php";
session_start();
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision" 
		|| $usuariologueado->getTipo()=="captura")) {
	header("Location: bienvenido.php");
}
include "includes/header_aplicacion.php";
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
?>
	<div class="row">
		<div class="span6 offset4">
		  <form class="form-horizontal" action="#" method="post">
		      <fieldset>
		        <legend><i class="icon-screenshot"></i>Administrar puntos de afluencia</legend>
		        <table class="table">
		        	<tr>
						<th style='text-align:left; width:240px; padding:5px;'>Nombre</th>
						<th style='text-align:left; width:240px; padding:5px;'>Tipo</th>	
						<th style='text-align:left; width:240px; padding:5px;'>Logo</th>							
						<th style='text-align:left; width:200px; padding:5px;'></th>
						<th style='text-align:left; width:200px; padding:5px;'></th>								
					  	<th></th>
					</tr>
					<?php  
                        $q = "SELECT * FROM `puntosafluencia`";
						$cont = 0;
					   	$dataPuntos = mysql_query( $q );	
					   	if (!$dataPuntos) {
						die('No se pudo realizar la consulta:' . mysql_error());
						header("Location: ../index.php");
					} else {
						while ($data = mysql_fetch_array($dataPuntos, MYSQL_ASSOC)) {					    
						    ?>
					    	<tr>
							  		<td><?php echo $data["nombre"]?></td>
							  		<td><?php echo $data["tipo"]?></td>	
							  		<td><img src="<?php echo $data["logo"]?>"></td>								  	
							  		<td> 
							  		<a href="#modalEdit" data-toggle="modal" class="openEditPuntos btn btn-primary" data-id="<?php echo $data["idpuntosAfluencia"]?>"><i class="icon-edit icon-white"></i> Editar</a>
							  		</td>
							  		<td> 
							  		<a href="#modalDelete" data-toggle="modal" class="openDeletePuntos btn btn-danger" data-id="<?php echo $data["idpuntosAfluencia"]?>"><i class="icon-trash icon-white"></i> Eliminar</a>
							  		</td>							  									  		
							  	</tr>
							  	<tr style='height:10px;'></tr>	
						   <?php 
							   	$cont++;
							   	}
					}
							   ?>
		        </table>		       
		        <div class="form-actions">
		          <a href="#" class="confirm-add btn btn-inverse"><i class="icon-plus-sign icon-white"></i> Agregar punto de afluencia...</a>		          		          
		          <a href="bienvenido.php" class="btn">Regresar</a>		          
		        </div>
		      </fieldset>
			</form>
		</div>
	</div>
<div id="modalEditar" class="modal hide fade in">
    <form action="control/admonPuntos.php" method="post" enctype="multipart/form-data">    
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Editar acabado</h3>
    </div>
    <div class="modal-body">       
    <input type="hidden"  name="accion" value="editar">
       <input type="hidden"  name="idpuntosAfluencia" id="idpuntosAfluencia">  
     <label class="control-label" >Nombre</label>
      <input type="text" class="input-small" name="nombrePunto" id="nombrePunto">
        <label class="control-label" >Clasificaci&oacute;n</label>
      <select class="span2" name='tipoPunto' id="tipoPunto">
      <option value="Hospitales">Hospitales</option>
      <option value="Centros comerciales">Centros comerciales</option>
      <option value="Otro">Otro</option> 
      </select>
       <label class="control-label" >Logo</label>
       <img id="logoPunto">
         <label class="control-label" >Cambiar:</label>
       <input type="file" id="file" name="file">              
       </div>
    <div class="modal-footer">
     <button class="btn btn-primary" type="submit">Editar</button>                              
       <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>      
    </div>
     </form> 
</div>
<div id="modalBorrar" class="modal hide fade in">
    <form action="control/admonPuntos.php" method="post">                
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Eliminar punto de afluencia</h3>
    </div>
    <div class="modal-body">   
        <input type="hidden"  name="accion" value="eliminar">  
     <input type="hidden"  name="idpuntosAfluencia" id="idpuntosAfluenciaD"> 
     <p>Atenci&oacute;n! Est&aacute;s a punto de eliminar el punto de afluencia.</p>
      <p>Deseas continuar?</p>
   </div>
    <div class="modal-footer">
     <button class="btn btn-primary" type="submit">Eliminar</button>                              
      <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>
    </div>
    </form>
</div>
<div id="modal4" class="modal hide fade in">
    <form action="control/admonPuntos.php" method="post" enctype="multipart/form-data">  
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Agregar punto de afluencia</h3>
    </div>
    <div class="modal-body"> 
     <input type="hidden"  name="accion" value="insertar">
     <label class="control-label" >Nombre</label>
      <input type="text" class="input-small" name="nombrePunto">
        <label class="control-label" >Clasificaci&oacute;n</label>
      <select class="span2" name='tipoPunto' id="tipoPunto">
      <option value="Hospitales">Hospitales</option>
      <option value="Centros comerciales">Centros comerciales</option>
      <option value="Otro">Otro</option> 
      </select>
       <label class="control-label" >Logo</label>
       <input type="file" id="file" name="file">                  
    </div>
    <div class="modal-footer">
         <button class="btn btn-primary" type="submit">Agregar</button>                                             
     <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>
    </div>
       </form>  
</div>
<?php include "includes/footer_principal.php" ?>