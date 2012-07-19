<?php
	/* Pagina Administrar Proyectos
	 Se despliega la lista de todos los proyectos registrados en la base de datos.
	 Además se pueden modificar y eliminar y tambien el usuario administrador revision puede agregar un proyecto nuevo.
	 Esta pagina solo es accesada por el administrador y revision (no elimina).
	 */
 
   $pageTitle = "SIGII | Administrar Proyectos";
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
   $_SESSION['pageFrom']="administrarProyectos";
  ?>
	<div class="row">
		<div class="span10 offset2">
		  <form class="form-horizontal" action="#" method="post">
		      <fieldset>
		        <legend><i class="icon-briefcase"></i> Administrar proyectos</legend>
		        <table class="table">
		        	<tr>
						<th style='text-align:left; width:220px; padding:5px;'>Nombre</th>
						<th style='text-align:left; width:220px; padding:5px;'>Promotor</th>
						<th style='text-align:left; width:270px; padding:5px;'>Zona</th>
						<th style='text-align:left; width:200px; padding:5px;'>Segmento</th>
						<th style='text-align:left; width:70px; padding:5px;'>Unidades</th>
						<th style='text-align:left; width:70px; padding:5px;'>Unidades Vendidas</th>					
						<th style='text-align:left; width:200px; padding:5px;'></th>
						<th style='text-align:left; width:200px; padding:5px;'></th>	
						<th style='text-align:left; width:200px; padding:5px;'></th>								
					  	<th></th>
					</tr>
					<?php 
						
						$q = "SELECT * ".
								"FROM `proyecto` p " .								
								"INNER JOIN `zona` z " .
								"ON p.zona_idzona = z.idzona
								ORDER BY p.nombre ASC";					   				
						$cont = 0;
						$dataProyectos = mysql_query( $q);
						if (!$dataProyectos) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
							while ($data = mysql_fetch_array($dataProyectos, MYSQL_ASSOC)) {
								?>					
					    	<tr>
							  		<td><?php echo $data["nombre"]?></td>
							  		<td><?php echo $data["promotor"]?></td>							  		
							  		<td><?php echo $data["ciudad"]."-".$data["subzona"]?></td>							  								  
							  		<td><?php echo $data["segmento"]?></td>
							  		<td><?php echo $data["unidadesTotales"]?></td>
							  		<td><?php echo $data["unidadesVendidas"]?></td>							  							  									  								  		
							  		<td> 
							  		<?php if($data["tipo"]=="horizontal"){?>
							  		<a href="editarProyectoHorizontal.php?idproyecto=<?php echo $data["idproyecto"]?>" class="btn btn-primary"><i class="icon-edit icon-white"></i> Editar</a>
							  	<?php }else if($data["tipo"]=="vertical"){?>
							  	 		<a href="editarProyectoVertical.php?idproyecto=<?php echo $data["idproyecto"]?>" class="btn btn-primary"><i class="icon-edit icon-white"></i> Editar</a>
								<?php }?>						 
							  	</td>
							  	<td>
							  		 		<a href="actualizarProyecto.php?idproyecto=<?php echo $data["idproyecto"]?>" class="btn btn-info"><i class="icon-refresh icon-white"></i> Actualizar</a>
								</td>
							  	<?php if($usuariologueado->getTipo()=="administrador"){?>
							  	<td> 							  	
							  		<a href="#" class="openDeleteProyecto btn btn-danger" data-id="<?php echo $data["idproyecto"]?>"><i class="icon-trash icon-white"></i> Eliminar</a>							  	
							  		</td>
							  		<?php } else {?>
							  		<td></td>
							  		<?php }?>							  		 							  		
							  	</tr>
							  	<tr style='height:10px;'></tr>	
						   <?php
							   	$cont++;
							   	}
						}
						mysql_close($link);
							   ?>
		        </table>
		        <input type="hidden" value='<?php echo $cont?>' name="usuarios" />
		        <div class="form-actions">
		           <a href="registrarProyectoVertical.php" class="btn btn-inverse"><i class="icon-plus-sign icon-white"></i> Agregar proyecto vertical...</a>		        
		          <a href="registrarProyectoHorizontal.php" class="btn btn-inverse"><i class="icon-plus-sign icon-white"></i> Agregar proyecto horizontal...</a>
		         <a href="bienvenido.php" class="btn"><i class="icon-remove-circle"></i> Regresar</a>		          
		        </div>
		      </fieldset>
			</form>
		</div>
	</div>
	<div id="modalBorrar" class="modal hide fade in">
	<form action="control/EliminarProyecto.php" method="post">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Eliminar proyecto</h3>
    </div>
    <div class="modal-body">
    <input type="hidden" name="idproyecto" id="idproyectoD">
      <p>Atenci&oacute;n! Est&aacute;s a punto de eliminar el proyecto.</p>
      <p>Deseas continuar?</p>
    </div>
    <div class="modal-footer">
      <button type="submit" class="btn btn-danger">S&iacute;</button>
      <a href="#" class="btn secondary" data-dismiss="modal">No</a>
    </div>
    </form>
</div>

<?php include "includes/footer_principal.php" ?> 