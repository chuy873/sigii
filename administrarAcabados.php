<?php 
	/* Pagina Administrar Acabados
	 Se despliega la lista de todos los acabados registrados en la base de datos.
	 Además se pueden modificar y eliminar y tambien el usuario puede agregar un acabado nuevo.
	 Esta pagina solo es accesada por el administrador, revision y captura.
	 */
$pageTitle = "SIGII | Administrar acabados";
include "includes/header_aplicacion.php";
//Verificar si el usuario tiene permiso para visualizar esta pÃ¡gina
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision" 
		|| $usuariologueado->getTipo()!="captura")) {
	header("Location: bienvenido.php");
}
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
?>
	<div class="row">
		<div class="span6 offset4">
		  <form class="form-horizontal" action="#" method="post">
		      <fieldset>
		        <legend><i class="icon-star"></i>Administrar acabados</legend>
		        <table class="table">
		        	<tr>
						<th style='text-align:left; width:240px; padding:5px;'>Nombre</th>						
						<th style='text-align:left; width:100px; padding:5px;'></th>
						<th style='text-align:left; width:100px; padding:5px;'></th>								
					  	<th></th>
					</tr>
					<?php  
                        $q = "SELECT * FROM `acabado`";
						$cont = 0;
					   	$dataAcabados = mysql_query( $q );	
					   	if (!$dataAcabados) {
						die('No se pudo realizar la consulta:' . mysql_error());
						header("Location: ../index.php");
					} else {
						while ($data = mysql_fetch_array($dataAcabados, MYSQL_ASSOC)) {					    
						    ?>
					    	<tr>
							  		<td><?php echo $data["nombre"]?></td>							  	
							  		<td> 
							  		<a href="#modalEdit" data-toggle="modal" class="openEditAcab btn btn-primary" data-id="<?php echo $data["idacabado"]?>"><i class="icon-edit icon-white"></i> Editar</a>
							  		</td>
							  		<td> 
							  		<a href="#modalDelete" data-toggle="modal" class="openDeleteAcab btn btn-danger" data-id="<?php echo $data["idacabado"]?>"><i class="icon-trash icon-white"></i> Eliminar</a>
							  		</td>							  		
							  		<td><input type="hidden" value='<?php $data["idacabado"]?>' name="idAcabado_<?php $data["idacabado"]?>" /></td>
							  	</tr>
							  	<tr style='height:10px;'></tr>	
						   <?php 
							   	$cont++;
							   	}
					}
							   ?>
		        </table>		       
		        <div class="form-actions">
		          <a href="#" class="confirm-add btn btn-inverse"><i class="icon-plus-sign icon-white"></i> Agregar acabado...</a>		          		          
		          <a href="bienvenido.php" class="btn">Regresar</a>		          
		        </div>
		      </fieldset>
			</form>
		</div>
	</div>
<div id="modalEditar" class="modal hide fade in">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Editar acabado</h3>
    </div>
    <div class="modal-body">       
   <label class="control-label" for="amenidad">Nombre</label>
       <input type="text" class="input-small" id="editaracabado">
        <input type="hidden"  id="idacabado">
           </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-danger" onclick="editar('acabado')">Editar</a>
      <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>
    </div>
</div>
<div id="modalBorrar" class="modal hide fade in">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Eliminar acabado</h3>
    </div>
    <div class="modal-body">     
     <p>Atenci&oacute;n! Est&aacute;s a punto de eliminar el acabado.</p>
      <p>Deseas continuar?</p>
      <input type="hidden"  id="idacabadoD"/>         
     </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-danger" onclick="eliminar('acabado')">Eliminar</a>
      <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>
    </div>
</div>
<div id="modal4" class="modal hide fade in">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Agregar acabado</h3>
    </div>
    <div class="modal-body">   
     <label class="control-label" for="acabado">Nombre</label>
      <input type="text" class="input-small" id="nombreacabado">          
    </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-primary" onclick="insertar('acabado')">Agregar</a>
      <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>
    </div>
</div>
<?php include "includes/footer_principal.php" ?>