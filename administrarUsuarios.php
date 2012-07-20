<?php
/* Pagina Administrar Usuarios
 Se despliega la lista de todos los usuarios registrados en la base de datos.
Además se pueden modificar y eliminar y tambien el usuario administrador puede agregar un usuario nuevo.
Esta pagina solo es accesada por el administrador.
*/
$pageTitle = "SIGII | Administrar Usuarios";
include "clases/Usuarios.php";
session_start();
//Verificar si el usuario tiene permiso para visualizar esta página
$usuariologueado = new Usuarios();
$usuariologueado = $_SESSION["usuario"];
if ($usuariologueado->getTipo()!="administrador") {
		$_SESSION['error'] = "acceso";
	$_SESSION['errormsg'] = "No tienes permiso para acceder a esta p�gina.";
	$_SESSION['pageFrom']="bienvenido";
	header("Location: error.php");	
}
include "includes/header_aplicacion.php";
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$_SESSION['pageFrom']="administrarUsuarios";
?>
<div class="row">
	<div class="span10 offset2">
			<form class="form-horizontal" action="#" method="post">
			<fieldset>
				<legend>
					<i class="icon-user "></i> Administrar cuentas de usuario
				</legend>
				<table class="table">
					<tr>
						<th style='text-align: left; width: 270px; padding: 5px;'>Nombre</th>
						<th style='text-align: left; width: 270px; padding: 5px;'>Apellidos</th>
						<th style='text-align: left; width: 270px; padding: 5px;'>Email</th>
						<th style='text-align: left; width: 270px; padding: 5px;'>Tel&eacute;fono</th>
						<th style='text-align: left; width: 270px; padding: 5px;'>Username</th>
						<th style='text-align: left; width: 270px; padding: 5px;'>Contrase&ntilde;a</th>
						<th style='text-align: left; width: 270px; padding: 5px;'>Rol</th>
						<th style='text-align: left; width: 270px; padding: 5px;'></th>
						<th style='text-align: left; width: 270px; padding: 5px;'></th>
						<th></th>
					</tr>
					<?php
					$query = "SELECT * FROM `usuarios`";
					$cont = 0;
					$datausuarios = mysql_query( $query );				
					if (!$datausuarios) {
						die('No se pudo realizar la consulta:' . mysql_error());
						header("Location: ../index.php");
					} else {
						while ($data = mysql_fetch_array($datausuarios, MYSQL_ASSOC)) {
							?>
					<tr>
						<td><?php echo $data["nombre"]?></td>
						<td><?php echo $data["apellidos"]?></td>
						<td><?php echo $data["email"]?></td>
						<td><?php echo $data["telefono"]?></td>
						<td><?php echo $data["username"]?></td>
						<td><?php echo $data["password"]?></td>
						<td><?php echo $data["tipo"]?></td>																							
						<td>							 			
						<a href="editarUsuario.php?idusuario=<?php echo $data["idusuarios"]?>"
						 class="btn btn-primary"><i	class="icon-edit icon-white"></i> Editar</a>								 						
						</td>
						<td>						
						<a href="#modalDelete" data-toggle="modal" class="openDeleteUser btn btn-danger" 
						data-id="<?php echo $data["idusuarios"]?>"><i class="icon-trash icon-white"></i> Eliminar</a>						
						</td>
						
					</tr>
					<tr style='height: 10px;'></tr>
					<?php
					$cont++;
						}
					}
					mysql_close($link);
						?>
				</table>
				<input type="hidden" value='<?php $cont?>' name="usuarios" />
				<div class="form-actions">
					<a href="registrarUsuario.php" class="btn btn-inverse"><i
						class="icon-plus-sign icon-white"></i> Agregar usuario...</a>										
					<a href="bienvenido.php" class="btn">
						<i class="icon-remove-circle"></i> Regresar
					</a>
				</div>
			</fieldset>
		</form>
	</div>
</div>
<div id="modalBorrar" class="modal hide fade in">
    <div class="modal-header">
     <button type="button" class="close" data-dismiss="modal">x</button>
      <h3>Eliminar usuario</h3>
    </div>
    <div class="modal-body">     
     <p>Atenci&oacute;n! Est&aacute;s a punto de eliminar al usuario.</p>
      <p>Deseas continuar?</p>
      <input type="hidden"  id="idusuarioD"/>         
     </div>
    <div class="modal-footer">
      <a href="#" class="btn btn-danger" onclick="eliminarUsuario()">Eliminar</a>
      <a href="#" class="btn secondary" data-dismiss="modal">Cancelar</a>
    </div>
</div>
<?php include "includes/footer_principal.php"?>