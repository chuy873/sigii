<?php 
	/* Pagina Administrar Modelos horizontal
	 Se despliega la lista de todos los modelos registrados en la base de datos.
	 Además se pueden modificar y eliminar y tambien el usuario administrador puede agregar un modelo nuevo.
	 Esta pagina solo es accesada por el administrador y revision (no elimina).
	 */
$pageTitle = "SIGII | Administrar Modelos Horizontales";
include "clases/Usuarios.php";
session_start();
	//Verificar si el usuario tiene permiso para visualizar esta página
	$usuariologueado = new Usuarios();
	$usuariologueado = $_SESSION["usuario"];
	if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision")) {
		$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta p�gina.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: error.php");	
	}
	include "includes/header_aplicacion.php";
	include "clases/Conexion.php";
	$conexion = new Conexion();
	$link = $conexion->dbconn();
	$_SESSION['pageFrom']="administrarModeloHorizontal";
?>
	<div class="row">
		<div class="span10 offset2">
		  <form class="form-horizontal" action="#" method="post">
		      <fieldset>
		        <legend><i class="icon-fullscreen"></i> Administrar modelos horizontales</legend>
		        <table class="table">
		        	<tr>
						<th style='text-align:left; width:220px; padding:5px;'>Proyecto</th>
						<th style='text-align:left; width:220px; padding:5px;'>Modelo</th>
						<th style='text-align:left; width:220px; padding:5px;'>Promotor</th>
						<th style='text-align:left; width:270px; padding:5px;'>Zona</th>
						<th style='text-align:left; width:200px; padding:5px;'>Segmento</th>
						<th style='text-align:left; width:200px; padding:5px;'>Precio</th>
						<th style='text-align:left; width:200px; padding:5px;'>Metros cuadrados</th>										
						<th style='text-align:left; width:270px; padding:5px;'></th>
						<th style='text-align:left; width:270px; padding:5px;'></th>								
					  	<th></th>
					</tr>
					<?php 						
					    $data ="SELECT p.nombre AS proyecto, m.nombre AS modelo, p.promotor, p.segmento, ".
						"z.ciudad, z.subzona, md.precio, m.metrosCuadrados, m.idmodelo, p.tipo  ".
							  "FROM proyecto p " .
							  "INNER JOIN zona z " .
							  "ON p.zona_idzona=z.idzona ". 
							  "INNER JOIN modelo m " .
							  "ON m.proyecto_idproyecto = p.idproyecto ". 
							  "INNER JOIN modelofraccionamiento md " .
							  "ON md.modelo_idmodelo = m.idmodelo";
						$cont = 0;
						$dataModelo = mysql_query( $data );
						if (!$dataModelo) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
					while ($data = mysql_fetch_array($dataModelo, MYSQL_ASSOC)) {
							?>				
					    	<tr>							  		
							  		<td><?php echo $data["proyecto"]?></td>							  	
							  		<td><?php echo $data["modelo"]?></td>
							  		<td><?php echo $data["promotor"]?></td>							  		
							  		<td><?php echo $data["ciudad"]."-".$data["subzona"]?></td>							  		
							  		<td><?php echo $data["segmento"]?></td>	
							  		<td>$<?php echo $data["precio"]?></td>								  		
							  		<td><?php echo $data["metrosCuadrados"]?></td>						  							  									  								  		
							  		<td> 
							  		<a href="editarModeloHorizontal.php?id=<?php echo $data["idmodelo"]?>" class="btn btn-primary"><i class="icon-edit icon-white"></i> Editar</a>
							  		</td>
							  		<td> 
							  			<a href="#" class="openDeleteModelo btn btn-danger" data-id="<?php echo $data["idmodelo"]?>"><i class="icon-trash icon-white"></i> Eliminar</a>							  	
							  	</td>							  		 
							  		<td></td>
							  	</tr>
							  	<tr style='height:10px;'></tr>	
						   <?php 
							   	$cont++;
							   	}
						}
							   ?>
		        </table>
		        <input type="hidden" value='<?php $cont?>' name="usuarios" />
		        <div class="form-actions">
		          <a href="registrarModeloHorizontal.php" class="btn btn-inverse"><i class="icon-plus-sign icon-white"></i> Agregar modelo...</a>
		          <a href="bienvenido.php" class="btn"><i class="icon-remove-circle"></i> Regresar</a>		          
		        </div>
		      </fieldset>
			</form>
		</div>
	</div>
		<div id="modalBorrar" class="modal hide fade in">
	<form action="control/EliminarModelo.php" method="post">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Eliminar modelo</h3>
    </div>
    <div class="modal-body">
    <input type="hidden" name="idmodelo" id="idmodeloD">
      <p>Atenci&oacute;n! Est&aacute;s a punto de eliminar el modelo.</p>
      <p>Deseas continuar?</p>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-danger">S&iacute;</button>
      <a href="#" class="btn secondary" data-dismiss="modal">No</a>
    </div>
    </form>
</div>

<?php include "includes/footer_principal.php" ?>