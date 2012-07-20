<?php 
/* Pagina de bienvenida
Se despliegan los accesos directos a los modulos del sistema.
Se despliegan los modulos de acuerdo al tipo de usuario logueado.
Esta pagina es accesada por todos los usuarios registrados.
*/
  $pageTitle = "SIGII | Bienvenido";  
 
 include "includes/header_aplicacion.php";
 ?>
<div class="container">
	<div class="row pad">
		<div class="span6 offset4" align="left">

				<h1>BIENVENIDO A SIGII</h1>
				<i>0.8 alpha</i>
				<p>SISTEMA DE INFORMACI&Oacute;N DE GEOMERCADOS DE LA INDUSTRIA INMOBILIARIA</p>					
		
		</div>
	</div>
	<!-- /row -->	
	<?php 
	if($usuario->getTipo()=="administrador"){ ?>
	<div class="row-fluid pad2">
	<!-- Modulo para empezar -->
		<div class="span3" align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_173_play.png"/></div><div class="span9"><h3>PARA EMPEZAR...</h3></br>
			<a href="#" class="span12"><i class="icon-book"></i> MANUAL DE USUARIO</a></div>
		</div>	
	<!-- Modulo administrar -->	
		<div class="span3 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_280_settings.png"/></div><div class="span9"><h2>ADMINISTRAR</h2></br>		
			<a href="administrarAmenidades.php" class=" span12"><i class="icon-star"></i> AMENIDADES</a></br>
			<a href="administrarAcabados.php" class=" span12"><i class="icon-star"></i> ACABADOS</a> </br>					
			<a href="administrarAtributos.php" class=" span12"><i class="icon-star"></i> ATRIBUTOS</a></br>
            <a href="administrarCaracteristicas.php" class=" span12"><i class="icon-star"></i> CARACTER&Iacute;STICAS</a></br>                	
			<a href="administrarUsuarios.php" class=" span12"><i class="icon-user "></i> USUARIOS</a></br>		
			<a href="administrarProyectos.php" class=" span12"><i class="icon-briefcase"></i> PROYECTOS</a></br>
			<a href="administrarModelos.php" class=" span12"><i class="icon-fullscreen"></i> MODELOS</a>
			</div>			
		</div>	
	<!-- Modulo consultar -->	
		<div class="span3 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_027_search.png"/></div><div class="span9"><h2>CONSULTAR</h2></br>
			<a href="consultar.php" class=" span12"><i class="icon-search "></i> REALIZAR UNA CONSULTA ESPEC&Iacute;FICA</a>
				</div>
		</div>
	<!-- Modulo reportes -->
		<div class="span3 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_040_stats.png"/></div><div class="span9"><h2>REPORTES</h2></br>			
			<a href="ficha.php" class="span12"><i class="icon-th"></i> FICHA</a></br> 
			<a href="lista.php" class=" span12"><i class="icon-list"></i> LISTA</a></br> 
			<a href="resumen.php" class=" span12"><i class="icon-list-alt"></i> RESUMEN</a>
			<a href="segmento.php" class=" span12"><i class="icon-globe"></i> SEGMENTO</a></br> 			
			</div>
		</div>
	</div>
	<?php } else if($usuario->getTipo()=="revision"){ ?>
	<div class="row-fluid pad2">
	<!-- Modulo para empezar -->
		<div class="span3" align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_173_play.png"/></div><div class="span9"><h3>PARA EMPEZAR...</h3></br>
			<a href="#" class="span12"><i class="icon-book"></i> MANUAL DE USUARIO</a></div>
		</div>	
	<!-- Modulo administrar -->	
		<div class="span3 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_280_settings.png"/></div><div class="span9"><h2>ADMINISTRAR</h2></br>		
			<a href="administrarAmenidades.php" class=" span12"><i class="icon-star"></i> AMENIDADES</a></br>
			<a href="administrarAcabados.php" class=" span12"><i class="icon-star"></i> ACABADOS</a> </br>					
			<a href="administrarAtributos.php" class=" span12"><i class="icon-star"></i> ATRIBUTOS</a></br>
            <a href="administrarCaracteristicas.php" class=" span12"><i class="icon-star"></i> CARACTER&Iacute;STICAS</a></br>                	
			<a href="administrarProyectos.php" class=" span12"><i class="icon-briefcase"></i> PROYECTOS</a></br>
			<a href="administrarModelos.php" class=" span12"><i class="icon-fullscreen"></i> MODELOS</a>
			</div>			
		</div>	
	<!-- Modulo consultar -->	
		<div class="span3 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_027_search.png"/></div><div class="span9"><h2>CONSULTAR</h2></br>
			<a href="consultar.php" class=" span12"><i class="icon-search "></i> REALIZAR UNA CONSULTA ESPEC&Iacute;FICA</a>
				</div>
		</div>
	<!-- Modulo reportes -->
		<div class="span3 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_040_stats.png"/></div><div class="span9"><h2>REPORTES</h2></br>			
			<a href="ficha.php" class="span12"><i class="icon-th"></i> FICHA</a></br> 
			<a href="lista.php" class=" span12"><i class="icon-list"></i> LISTA</a></br> 
			<a href="resumen.php" class=" span12"><i class="icon-list-alt"></i> RESUMEN</a>
			<a href="segmento.php" class=" span12"><i class="icon-globe"></i> SEGMENTO</a></br> 			
			</div>
		</div>
	</div>
	<?php } else if($usuario->getTipo()=="captura"){  ?>
	<div class="row-fluid pad2">
	<!-- Modulo para empezar -->
		<div class="span3" align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_173_play.png"/></div><div class="span9"><h3>PARA EMPEZAR...</h3></br>
			<a href="#" class="span12"><i class="icon-book"></i> MANUAL DE USUARIO</a></div>
		</div>	
	<!-- Modulo administrar -->	
		<div class="span3 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_280_settings.png"/></div><div class="span9"><h2>ADMINISTRAR</h2></br>		
			<a href="administrarAmenidades.php" class=" span12"><i class="icon-star"></i> AMENIDADES</a></br>
			<a href="administrarAcabados.php" class=" span12"><i class="icon-star"></i> ACABADOS</a> </br>					
			<a href="administrarAtributos.php" class=" span12"><i class="icon-star"></i> ATRIBUTOS</a></br>
            <a href="administrarCaracteristicas.php" class=" span12"><i class="icon-star"></i> CARACTER&Iacute;STICAS</a></br>                	
			<a href="registrarProyecto.php" class=" span12"><i class="icon-briefcase"></i> PROYECTOS</a></br>
			<a href="registrarModelo.php" class=" span12"><i class="icon-fullscreen"></i> MODELOS</a>
			</div>			
		</div>	
	<!-- Modulo consultar -->	
		<div class="span3 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_027_search.png"/></div><div class="span9"><h2>CONSULTAR</h2></br>
			<a href="consultar.php" class=" span12"><i class="icon-search "></i> REALIZAR UNA CONSULTA ESPEC&Iacute;FICA</a>
				</div>
		</div>
	<!-- Modulo reportes -->
		<div class="span3 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_040_stats.png"/></div><div class="span9"><h2>REPORTES</h2></br>			
			<a href="ficha.php" class="span12"><i class="icon-th"></i> FICHA</a></br> 
			<a href="lista.php" class=" span12"><i class="icon-list"></i> LISTA</a></br> 
			<a href="resumen.php" class=" span12"><i class="icon-list-alt"></i> RESUMEN</a>
			<a href="segmento.php" class=" span12"><i class="icon-globe"></i> SEGMENTO</a></br> 			
			</div>
		</div>
	</div>			
	<?php } else  if($usuario->getTipo()=="analisis"){ ?>
		<div class="row-fluid pad2">
	<!-- Modulo para empezar -->
		<div class="span4" align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_173_play.png"/></div><div class="span9"><h3>PARA EMPEZAR...</h3></br>
			<a href="#" class="span12"><i class="icon-book"></i> MANUAL DE USUARIO</a></div>
		</div>	
	
	<!-- Modulo consultar -->	
		<div class="span4 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_027_search.png"/></div><div class="span9"><h2>CONSULTAR</h2></br>
			<a href="consultar.php" class=" span12"><i class="icon-search "></i> REALIZAR UNA CONSULTA ESPEC&Iacute;FICA</a>
				</div>
		</div>
	<!-- Modulo reportes -->
		<div class="span4 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_040_stats.png"/></div><div class="span9"><h2>REPORTES</h2></br>			
			<a href="ficha.php" class="span12"><i class="icon-th"></i> FICHA</a></br> 
			<a href="lista.php" class=" span12"><i class="icon-list"></i> LISTA</a></br> 
			<a href="resumen.php" class=" span12"><i class="icon-list-alt"></i> RESUMEN</a>
			<a href="segmento.php" class=" span12"><i class="icon-globe"></i> SEGMENTO</a></br> 			
			</div>
		</div>
	</div>
	<?php } else { ?>
			<div class="row-fluid pad2">
	<!-- Modulo para empezar -->
		<div class="span6" align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_173_play.png"/></div><div class="span9"><h3>PARA EMPEZAR...</h3></br>
			<a href="#" class="span12"><i class="icon-book"></i> MANUAL DE USUARIO</a></div>
		</div>	

	<!-- Modulo reportes -->
		<div class="span6 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_040_stats.png"/></div><div class="span9"><h2>REPORTES</h2></br>			
			<a href="ficha.php" class="span12"><i class="icon-th"></i> FICHA</a></br> 
			<a href="lista.php" class=" span12"><i class="icon-list"></i> LISTA</a></br> 
			<a href="resumen.php" class=" span12"><i class="icon-list-alt"></i> RESUMEN</a>
			<a href="segmento.php" class=" span12"><i class="icon-globe"></i> SEGMENTO</a></br> 			
			</div>
		</div>
	</div>
			
	<?php } ?>
	<!-- /row -->
</div>
<!-- /container -->
<?php  include "includes/footer_aplicacion_1.php" ?>