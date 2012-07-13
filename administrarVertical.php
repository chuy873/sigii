<?php 
	/* Pagina Administrar Proyectos verticales
	 Se despliega la lista de todos los proyectos registrados en la base de datos.
	 Además se pueden modificar y eliminar y tambien el usuario administrador revision puede agregar un proyecto nuevo.
	 Esta pagina solo es accesada por el administrador y revision (no elimina).
	 */
   $pageTitle = "SIGII | Administrar Proyectos Verticales";
include "clases/Usuarios.php";
session_start();
   //Verificar si el usuario tiene permiso para visualizar esta página
   $usuariologueado = new Usuarios();
   $usuariologueado = $_SESSION["usuario"];
   if (!($usuariologueado->getTipo()=="administrador" || $usuariologueado->getTipo()=="revision")) {
   	header("Location: bienvenido.php");
   }
   include "includes/header_aplicacion.php";
   include "clases/Conexion.php";
   $conexion = new Conexion();
   $link = $conexion->dbconn();
   $_SESSION['pageFrom']="administrarVertical";
  ?>
	<div class="row">
		<div class="span10 offset2">
		  <form class="form-horizontal" action="#" method="post">
		      <fieldset>
		        <legend><i class="icon-briefcase"></i> Administrar proyectos verticales</legend>
		        <table class="table">
		        	<tr>
						<th style='text-align:left; width:220px; padding:5px;'>Nombre</th>
						<th style='text-align:left; width:220px; padding:5px;'>Promotor</th>
						<th style='text-align:left; width:270px; padding:5px;'>Zona</th>
						<th style='text-align:left; width:200px; padding:5px;'>Segmento</th>
						<th style='text-align:left; width:70px; padding:5px;'>Pisos</th>
						<th style='text-align:left; width:70px; padding:5px;'>Torres</th>					
						<th style='text-align:left; width:270px; padding:5px;'></th>
						<th style='text-align:left; width:270px; padding:5px;'></th>								
					  	<th></th>
					</tr>
					<?php 
						
						$q = "SELECT * ".
								"FROM `proyecto` p " .								
								"INNER JOIN `zona` z " .
								"ON p.zona_idzona = z.idzona AND p.tipo = 'vertical'";					    			
						$cont = 0;
						$dataProyectos = mysql_query( $q);					
						if (!$dataProyectos) {
							die('No se pudo realizar la consulta:' . mysql_error());
							header("Location: ../index.php");
						} else {
							while ($data = mysql_fetch_array($dataProyectos, MYSQL_ASSOC)) {
								$q2 = "SELECT * FROM proyectodepartamento
								WHERE proyecto_idproyecto ='".$data["idproyecto"]."'";
								$dataDept = mysql_query( $q2);
								$dataDep= mysql_fetch_array($dataDept);
								?>					
					    	<tr>
							  		<td><?php echo $data["nombre"]?></td>
							  		<td><?php echo $data["promotor"]?></td>							  		
							  		<td><?php echo $data["ciudad"]."-".$data["subzona"]?></td>							  								  
							  		<td><?php echo $data["segmento"]?></td>
							  		<td><?php echo $dataDep["pisos"]?></td>
							  		<td><?php echo $dataDep["torres"]?></td>							  							  									  								  	
							  		<td> 
							  		<a href="editarProyectoVertical.php?idproyecto=<?php echo $data["idproyecto"]?>" class="btn btn-primary"><i class="icon-edit icon-white"></i> Editar</a>																					  	
							  		</td>							  		
							  		<td> 
							  		<a href="#" class="confirm-delete btn btn-danger" data-id="23"><i class="icon-trash icon-white"></i> Eliminar</a>
							  		<input type="hidden" value='<?php echo $data["idproyecto"]?>' name="idUsers_<?php echo $cont?>" />							  		
							  		</td>							  		 
							  		<td><input type="hidden" value='<?php echo $data["idproyecto"]?>' name="idUsers_<?php  echo $cont?>" /></td>
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
		         <a href="bienvenido.php" class="btn"><i class="icon-remove-circle"></i> Regresar</a>		          
		        </div>
		      </fieldset>
			</form>
		</div>
	</div>
	<div id="modal1" class="modal hide fade in">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Eliminar proyecto</h3>
    </div>
    <div class="modal-body">
      <p>Atenci&oacute;n! Est&aacute;s a punto de eliminar el proyecto.</p>
      <p>Deseas continuar?</p>
    </div>
    <div class="modal-footer">
      <a href="administrarProyectos.jsp" class="btn btn-danger">S&iacute;</a>
      <a href="#" class="btn secondary" data-dismiss="modal">No</a>
    </div>
</div>

<?php include "includes/footer_principal.php" ?> 