<?php
/* Pagina Administrar caracteristicas
Se despliega la lista de todos las caracteristicas registradas en la base de datos.
Además se pueden modificar y eliminar y tambien el usuario puede agregar una amenidad nueva.
Esta pagina solo es accesada por el administrador, revision y captura.
*/
$pageTitle = "SIGII | Administrar características";
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
		        <legend><i class="icon-star"></i>Administrar caracter&iacute;sticas</legend>
		        <table class="table">
		        	<tr>
						<th style='text-align:left; width:240px; padding:5px;'>Nombre</th>						
						<th style='text-align:left; width:100px; padding:5px;'></th>
						<th style='text-align:left; width:100px; padding:5px;'></th>								
					  	<th></th>
					</tr>
					<?php  
                        $q = "SELECT * FROM `caracteristicas` ORDER BY nombre ASC";
						$cont = 0;
					   	$dataCaract = mysql_query( $q );	
					   	if (!$dataCaract) {
						die('No se pudo realizar la consulta:' . mysql_error());
						header("Location: ../index.php");
					} else {
						while ($data = mysql_fetch_array($dataCaract, MYSQL_ASSOC)) {					    
						    ?>	
					    	<tr>
							  		<td><?php echo $data["nombre"]?></td>							  	
							  		<td> 
							  		<a href="#modalEdit" data-toggle="modal" class="openEditCaract btn btn-primary" data-id="<?php echo $data["idcaracteristicas"]?>"
							  		data-nombre="<?php echo $data["nombre"]?>"><i class="icon-edit icon-white"></i> Editar</a>
							  		</td>
							  		<td> 
							  		<a href="#modalDelete" data-toggle="modal" class="openDeleteCaract btn btn-danger" data-id="<?php echo $data["idcaracteristicas"]?>"><i class="icon-trash icon-white"></i> Eliminar</a>
							  		</td>							  		
							  		<td><input type="hidden" value='<?php echo  $data["idcaracteristicas"]?>' name="idAmenidad_<?php echo $data["idcaracteristicas"]?>" /></td>
							  	</tr>
							  	<tr style='height:10px;'></tr>	
						   <?php  $cont++; 
						   }
					}					     
				    ?>
		        </table>
		        <input type="hidden" value='<?php $cont?>' name="caracteristicas" />
		        <div class="form-actions">
		          <a href="#" class="confirm-add btn btn-inverse"><i class="icon-plus-sign icon-white"></i> Agregar caracter&iacute;stica...</a>		          		          
		          <a href="bienvenido.php" class="btn">Regresar</a>		          
		        </div>
		      </fieldset>
			</form>
		</div>
	</div>
<div id="modalEditar" class="modal hide fade in">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Editar caracter&iacute;stica</h3>
    </div>
    <div class="modal-body">   
     <label class="control-label" for="caracteristica">Nombre</label>
      <input type="text" class="input-medium" id="editarcaracteristicas">
        <input type="hidden"  id="idcaracteristicas">
           
    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-primary" onclick="editar('caracteristicas')">Editar</a>
      <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>
    </div>
</div>
<div id="modalBorrar" class="modal hide fade in">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Eliminar caracter&iacute;stica</h3>
    </div>
    <div class="modal-body">
      <p>Atenci&oacute;n! Est&aacute;s a punto de eliminar la caracter&iacute;stica.</p>
      <p>Deseas continuar?</p>
           <input type="hidden"  id="idcaracteristicasD">
    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-danger" onclick="eliminar('caracteristicas')">Eliminar</a>
      <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>
    </div>
    </div>
<div id="modal4" class="modal hide fade in">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Agregar caracter&iacute;stica</h3>
    </div>
    <div class="modal-body">   
     <label class="control-label" for="caracteristicas">Nombre</label>
      <input type="text" class="input-small" id="nombrecaracteristicas">
          
    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-primary" onclick="insertar('caracteristicas')">Agregar</a>
      <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>
    </div>
</div>

<?php include "includes/footer_principal.php" ?>