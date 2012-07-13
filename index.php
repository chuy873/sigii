<?php /* Pagina de inicio
Se despliega una forma para ingresar el nombre de usuario y contraseña.
Esta pagina es accesada por cualquier usuario.
 */ 
?>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<?php 
	$pageTitle = "SIGII | Iniciar Sesi&oacute;n";
    include "includes/header_principal.php" ?> 
         <div class="container">
            <div class="row">
                <div class="span8 offset2">
                     <div class="hero-unit">
                        <h1>Bienvenido a SIGII</h1>
                        <i>0.6 alpha</i>
                        <p>Sistema de informaci&oacute;n de geomercados de la industria inmobiliaria</p>
                    </div>
                </div> <!-- /span -->
                    <div class="span4 offset4">
                     <form action="control/IniciarSesion.php" class="well" method="post">
                        <fieldset>
                          <h1>Iniciar Sesi&oacute;n</h1>
                          <div class="control-group">
                              <label class="control-label" for="usuario">Usuario</label>
                              <div class="controls">
                                <input id="usuario" name="username" type="text" class="input-medium"  placeholder="Nombre de usuario">
                                <span class="help-inline" id="usuarioInfo"></span>
                              </div>
                            </div>
                              <div class="control-group">
                                <label class="control-label" for="pwd">Contrase&ntilde;a</label>
                                <div class="controls">
                                  <input id="pwd" name="password" type="password" class="input-medium"  placeholder="Contraseña">
                                  <span class="help-inline" id="passInfo"></span>
                                </div>
                              </div>
                            <div>
                              <button type="submit" class="btn btn-primary">Entrar</button>
                            </div>
                          </fieldset>
                        </form>
                    </div> <!-- /span -->
            </div> <!-- /row -->
           </div> <!-- /container -->
<?php include "includes/footer_principal.php" ?>