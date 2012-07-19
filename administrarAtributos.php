<?php
/* Pagina Administrar atributos
Se despliega la lista de todos las atributos registrados en la base de datos.
Además se pueden modificar y eliminar y tambien el usuario puede agregar una amenidad nueva.
Esta pagina solo es accesada por el administrador, revision y captura.
*/
$pageTitle = "SIGII | Administrar atributos";
include "clases/Usuarios.php";
session_start();
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision" 
		|| $usuariologueado->getTipo()=="captura")) {
		$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta página.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: error.php");	
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
		        <legend><i class="icon-star-empty"></i>Administrar atributos</legend>
		        <table class="table">
		        	<tr>
						<th style='text-align:left; width:240px; padding:5px;'>Nombre</th>						
						<th style='text-align:left; width:100px; padding:5px;'></th>
						<th style='text-align:left; width:100px; padding:5px;'></th>								
					  	<th></th>
					</tr>
					<?php  
                        $q = "SELECT * FROM `atributos` ORDER BY nombre ASC";
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
							  		<a href="#modalEdit" data-toggle="modal" class="openEditAtrib btn btn-primary" data-id="<?php echo $data["idatributos"]?>"
							  		data-nombre="<?php echo $data["nombre"]?>"><i class="icon-edit icon-white"></i> Editar</a>
							  		</td>
							  		<td> 
							  	    <a href="#modalDelete" data-toggle="modal" class="openDeleteAtrib btn btn-danger" data-id="<?php echo $data["idatributos"]?>"><i class="icon-trash icon-white"></i> Eliminar</a>
							  		</td>							  		
							  		<td><input type="hidden" value='<?php echo  $data["idatributos"]?>' name="idatributos_<?php echo $data["idatributos"]?>" /></td>
							  	</tr>
							  	<tr style='height:10px;'></tr>	
						   <?php  $cont++; 
						   }
					}					     
				    ?>
		        </table>
		        <input type="hidden" value='<?php $cont?>' name="atributos" />
		        <div class="form-actions">
		          <a href="#" class="confirm-add btn btn-inverse"><i class="icon-plus-sign icon-white"></i> Agregar atributos...</a>		          		          
		          <a href="bienvenido.php" class="btn">Regresar</a>		          
		        </div>
		      </fieldset>
			</form>
		</div>
	</div>
<div id="modalEditar" class="modal hide fade in">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Editar atributo</h3>
    </div>
    <div class="modal-body">   
     <label class="control-label" for="atributo">Nombre</label>
    <input type="text" class="input-medium" id="editaratributos">
        <input type="hidden"  id="idatributos">
       
    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-primary" onclick="editar('atributos')">Editar</a>
      <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>
    </div>
</div>
<div id="modalBorrar" class="modal hide fade in">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Eliminar atributo</h3>
    </div>
    <div class="modal-body">
      <p>Atenci&oacute;n! Est&aacute;s a punto de eliminar el atributo.</p>
      <p>Deseas continuar?</p>
             <input type="hidden"  id="idatributosD">       
    </div>
    <div class="modal-footer">
       <a href="#" class="btn btn-danger" onclick="eliminar('atributos')">Eliminar</a>
      <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>
    </div>
    </div>
<div id="modal4" class="modal hide fade in">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Agregar atributo</h3>
    </div>
    <div class="modal-body">   
     <label class="control-label" for="atributos">Nombre</label>
      <input type="text" class="input-small" id="nombreatributos">
          
    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-primary" onclick="insertar('atributos')">Agregar</a>
      <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>
    </div>
</div>

<?php include "includes/footer_principal.php" ?>