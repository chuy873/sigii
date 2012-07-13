<?php 
/* Pagina Editar Usuarios
Se despliega la forma con los datos personales del usuario a editar.
Esta pagina solo es accesada por el administrador.
*/
$pageTitle = "SIGII | Editar Usuario";
include "clases/Usuarios.php";
session_start();
	//Verificar si el usuario tiene permiso para visualizar esta página
	$usuariologueado = new Usuarios();
	$usuariologueado = $_SESSION["usuario"];	
	if (!($usuariologueado->getTipo()=="administrador")) {		
		header("Location: bienvenido.php");
}
include "includes/header_aplicacion.php";
include "clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$idusuario = $_POST["idusuario"];
$usuario = "SELECT * FROM usuarios WHERE idusuarios = '".$idusuario."'";
$result = mysql_query( $usuario );
if (!$result) {
	die('No se pudo realizar la consulta:' . mysql_error());
	header("Location: ../bienvenido.php");
}	
	$data = mysql_fetch_array($result);
?>
        <div class="container">      
        <div class="row">      
            <div class="span7 offset2">          
                        <form class="form-horizontal well" action="control/admonUsuario.php" method="post">
                            <h1>Editar usuario</h1>
                            <fieldset>
                                <legend>Favor de llenar la informaci&oacute;n necesaria</legend>                               
                                 <div class="control-group">
                                    <label class="control-label" for="nombres">Nombre(s)</label>
                                    <div class="controls">
                                        <input name="nombre" id="nombre" class="input-small" type="text" value="<?php echo $data["nombre"]?>"/>
                                            <input type="hidden" name="accion" value="editar">
                                            <input type="hidden" name="idusuario" value="<?php echo $data["idusuarios"]?>">                                       
                                        <span class="help-inline"></span>
                                    </div>
                                </div>                                
                                <div class="control-group">
                                    <label class="control-label" for="apellidos">Apellido(s)</label>
                                    <div class="controls">
                                        <input id="apellidos" name="apellidos" class="input-small" type="text"  value="<?php echo $data["apellidos"]?>">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                 <div class="control-group">
                                    <label class="control-label" for="email">E-mail</label>
                                    <div class="controls">
                                        <input id="email" name="email" class="input-large" type="text"  value="<?php echo $data["email"]?>">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                  <div class="control-group">
                                  <label class="control-label" for="telefono">Tel&eacute;fono</label>
                                  <div class="controls">
                                     <input id="telefono" name="telefono" class="input-small" type="text"  value="<?php echo $data["telefono"]?>">
                                      <span class="help-inline"></span>                                    
                                  </div>
                                </div>
                                 <div class="control-group">
                                  <label class="control-label">Tipo</label>                                
                                     <div id="tipo" class="controls">                                    
                                    <label class="radio inline">
                                     <?php if( $data["tipo"]=="administrador"){?>
                                      <input id="admin" type="radio" value="administrador" name="tipo" checked="checked">
                                      <?php } else {?>
                                       <input id="admin" type="radio" value="administrador" name="tipo">
                                       <?php }?>
                                      Administrador
                                    </label>
                                    <label class="radio inline">
                                     <?php if( $data["tipo"]=="revision"){?>
                                      <input id="revision" type="radio" value="revision" name="tipo" checked="checked">
                                       <?php } else {?>
                                       <input id="revision" type="radio" value="revision" name="tipo">
                                       <?php }?>
                                      Revisi&oacute;n
                                    </label>
                                     <label class="radio inline">
                                    <?php if( $data["tipo"]=="captura"){?>
                                      <input id="captura" type="radio" value="captura" name="tipo" checked="checked">
                                       <?php } else {?>
                                       <input id="captura" type="radio" value="captura" name="tipo">
                                       <?php }?>    Captura
                                    </label>
                                     <label class="radio inline">
                                    <?php if( $data["tipo"]=="analisis"){?>
                                      <input id="analisis" type="radio" value="analisis" name="tipo" checked="checked">
                                       <?php } else {?>
                                       <input id="analisis" type="radio" value="analisis" name="tipo">
                                       <?php }?>   An&aacute;lisis
                                    </label>
                                     <label class="radio inline">
                                     <?php if( $data["tipo"]=="revision"){?>
                                      <input id="cliente" type="radio" value="cliente" name="tipo" checked="checked">
                                       <?php } else {?>
                                       <input id="cliente" type="radio" value="cliente" name="tipo">
                                       <?php }?>  Cliente	
                                    </label>
                                     <span class="help-inline"></span>     
                                  </div>
                                </div>
                                </fieldset>
                                 <fieldset>
                                <legend>Datos de acceso al sistema</legend>
                                <div class="control-group">
                                    <label class="control-label" for="username">Nombre de usuario</label>
                                    <div class="controls">
                                        <input name="username" id="username" class="input-small" type="text" value="<?php echo $data["username"]?>">                                        
                                        <span class="help-inline"></span>
                                    </div>                                  
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="password">Contrase&ntilde;a</label>
                                    <div class="controls">
                                        <input name="password" id="password" class="input-medium" type="text" value="<?php echo $data["password"]?>">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                                                                        
                                <div class="form-actions">                                   
                                   <button class="btn btn-primary" type="submit">Editar</button>
                                   <a href="administrarUsuarios.php" class="btn" >Cancelar</a>
                                </div>
                            </fieldset>
                        </form>
            </div> <!-- /span -->
        </div><!-- /row -->
        </div> <!-- /container -->
<?php include "includes/footer_principal.php" ?>