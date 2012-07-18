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
            <div class="row pad" >
                <div class="span4 offset1" align="left" >
                     <div >
                        <h1>Bienvenido a SIGII</h1>
                        <i>0.8 alpha</i>
                        <p>SISTEMA DE INFORMACI&Oacute;N DE GEOMERCADOS DE LA INDUSTRIA INMOBILIARIA</p>
                    </div>
                </div> <!-- /span -->
                    <div class="span3 offset3">
                     <form action="control/IniciarSesion.php"  method="post">
                        <fieldset>
                          <div class="control-group">
                              <label class="control-label" for="usuario">USUARIO</label>
                              <div class="controls">
                                <input id="usuario" name="username" type="text" class="input-medium"  placeholder="Nombre de usuario">
                                <span class="help-inline" id="usuarioInfo"></span>
                              </div>
                            </div>
                              <div class="control-group">
                                <label class="control-label" for="pwd">CONTRASE&Ntilde;A</label>
                                <div class="controls">
                                  <input id="pwd" name="password" type="password" class="input-medium"  placeholder="Contraseña">
                                  <span class="help-inline" id="passInfo"></span>
                                </div>
                              </div>
                            <div>
                              <button type="submit" class="btn">ENTRAR</button>
                            </div>
                          </fieldset>
                        </form>
                    </div> <!-- /span -->
            </div> <!-- /row -->
           </div> <!-- /container -->
<?php include "includes/footer_principal.php" ?>