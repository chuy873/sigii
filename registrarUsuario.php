<?php 
/* Pagina Registrar Usuarios
Se despliega la forma para ingresar los datos personales del usuario a registrar.
Esta pagina solo es accesada por el administrador.
*/
$pageTitle = "SIGII | Registrar Usuario";
include "includes/header_aplicacion.php";
	//Verificar si el usuario tiene permiso para visualizar esta p�gina
	$usuariologueado = new Usuarios();
	$usuariologueado = $_SESSION["usuario"];
	if (!$usuariologueado->getTipo()=="administrador") {
		header("Location: bienvenido.php");
}    	
?>
        <div class="container">      
        <div class="row">      
            <div class="span7 offset2">          
                        <form class="form-horizontal well" action="control/admonUsuario.php" method="post">
                            <h1>Registro</h1>
                            <fieldset>
                                <legend>Favor de llenar la informaci&oacute;n necesaria</legend>                               
                                 <div class="control-group">
                                    <label class="control-label" for="nombres">Nombre(s)</label>
                                    <div class="controls">
                                        <input name="nombre" id="nombre" class="input-small" type="text">
                                            <input type="hidden" name="accion" value="registrar">                                     
                                        <span class="help-inline"></span>
                                    </div>
                                </div>                                
                                <div class="control-group">
                                    <label class="control-label" for="apellidos">Apellido(s)</label>
                                    <div class="controls">
                                        <input id="apellidos" name="apellidos" class="input-small" type="text">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                 <div class="control-group">
                                    <label class="control-label" for="email">E-mail</label>
                                    <div class="controls">
                                        <input id="email" name="email" class="input-large" type="text">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                  <div class="control-group">
                                  <label class="control-label" for="telefono">Tel&eacute;fono</label>
                                  <div class="controls">
                                     <input id="telefono" name="telefono" class="input-small" type="text">
                                      <span class="help-inline"></span>                                    
                                  </div>
                                </div>
                                 <div class="control-group">
                                  <label class="control-label">Tipo</label>                                
                                     <div id="tipo" class="controls">
                                    <label class="radio inline">
                                      <input id="admin" type="radio" value="administrador" name="tipo">
                                      Administrador
                                    </label>
                                    <label class="radio inline">
                                      <input id="revision" type="radio" value="revision" name="tipo">
                                      Revisi&oacute;n
                                    </label>
                                     <label class="radio inline">
                                      <input id="captura" type="radio" value="captura" name="tipo">
                                      Captura
                                    </label>
                                     <label class="radio inline">
                                      <input id="analisis" type="radio" value="analisis" name="tipo">
                                      An&aacute;lisis
                                    </label>
                                     <label class="radio inline">
                                      <input id="cliente" type="radio" value="cliente" name="tipo">
                                      Cliente	
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
                                        <input name="username" id="username" class="input-small" type="text">                                        
                                        <span class="help-inline"></span>
                                    </div>                                  
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="password">Contrase&ntilde;a</label>
                                    <div class="controls">
                                        <input name="password" id="password" class="input-medium" type="password">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="passwordC">Confirmaci&oacute;n contrase&ntilde;a</label>
                                    <div class="controls">
                                        <input name="passwordC" id="passwordC" class="input-medium" type="password">
                                        <span class="help-inline"></span>
                                    </div>
                                </div>                                                            
                                <div class="form-actions">                                   
                                   <button class="btn btn-primary" type="submit">Registrar</button>
                                   <button class="btn" type="reset">Cancelar</button>
                                </div>
                            </fieldset>
                        </form>
            </div> <!-- /span -->
        </div><!-- /row -->
        </div> <!-- /container -->
<?php include "includes/footer_principal.php" ?>