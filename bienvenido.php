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

				<h1>Bienvenido a SIGII</h1>
				<i>0.6 alpha</i>
				<p>Sistema de informaci&oacute;n de geomercados de la industria inmobiliaria</p>					
		
		</div>
	</div>
	<!-- /row -->	
	<?php 
	if($usuario->getTipo()=="administrador"){ ?>
	<div class="row-fluid pad2">
	<!-- Modulo para empezar -->
		<div class="span3" align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_173_play.png"/></div><div class="span9"><h3>Para empezar...</h3></br>
			<a href="#" class="span12"><i class="icon-book"></i> Manual de usuario</a></div>
		</div>	
	<!-- Modulo administrar -->	
		<div class="span3 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_280_settings.png"/></div><div class="span9"><h2>Administrar</h2></br>		
			<a href="administrarAmenidades.php" class=" span12"><i class="icon-star"></i> Amenidades</a></br>
			<a href="administrarAcabados.php" class=" span12"><i class="icon-star"></i> Acabados</a> </br>					
			<a href="administrarAtributos.php" class=" span12"><i class="icon-star"></i> Atributos</a></br>
            <a href="administrarCaracteristicas.php" class=" span12"><i class="icon-star"></i> Caracter&iacute;sticas</a></br>                	
			<a href="administrarUsuarios.php" class=" span12"><i class="icon-user "></i> Usuarios</a></br>		
			<a href="administrarProyectos.php" class=" span12"><i class="icon-briefcase"></i> Proyectos</a></br>
			<a href="administrarModelos.php" class=" span12"><i class="icon-fullscreen"></i> Modelos</a>
			</div>			
		</div>	
	<!-- Modulo consultar -->	
		<div class="span3 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_027_search.png"/></div><div class="span9"><h2>Consultar</h2></br>
			<a href="consultar.php" class=" span12"><i class="icon-search "></i> Realizar una
				consulta espec&iacute;fica</a>
				</div>
		</div>
	<!-- Modulo reportes -->
		<div class="span3 " align="left">
			<div class="span3 " align="center"><img src="assets/img/glyphicons_040_stats.png"/></div><div class="span9"><h2>Reportes</h2></br>			
			<a href="ficha.php" class="span12"><i class="icon-th"></i> Ficha</a></br> 
			<a href="lista.php" class=" span12"><i class="icon-list"></i> Lista</a></br> 
			<a href="resumen.php" class=" span12"><i class="icon-list-alt"></i> Resumen</a>
			<a href="segmento.php" class=" span12"><i class="icon-globe"></i> Segmento</a></br> 			
			</div>
		</div>
	</div>
	<?php } else if($usuario->getTipo()=="revision"){ ?>
	<div class="row-fluid">
		<!-- Modulo para empezar -->
		<div class="span3 hero-unit" align="center">
			<div align="center"><h2>Para empezar...</h2><img src="assets/img/glyphicons_173_play.png"/></div></br>
			<a href="#" class="btn span12"><i class="icon-book"></i> Manual de usuario</a>
		</div>				
		<!-- Modulo administrar -->	
		<div class="span3 hero-unit" align="center">
			<div align="center"><h2>Administrar</h2><img src="assets/img/glyphicons_280_settings.png"/></div></br>		
			<a href="administrarAmenidades.php" class="btn span12"><i class="icon-star"></i> Amenidades</a></br>
			<a href="administrarAcabados.php" class="btn span12"><i class="icon-star"></i> Acabados</a> </br>		
			<a href="administrarAtributos.php" class="btn span12"><i class="icon-star"></i> Atributos</a></br>
            <a href="administrarCaracteristicas.php" class="btn span12"><i class="icon-star"></i> Caracter&iacute;sticas</a></br>                	
			<a href="administrarProyectos.php" class="btn span12"><i class="icon-briefcase"></i> Proyectos</a></br>
			<a href="administrarModelos.php" class="btn span12"><i class="icon-fullscreen"></i> Modelos</a>			
		</div>							
		<!-- Modulo consultar -->	
		<div class="span3 hero-unit" align="center">
			<div align="center"><h2>Consultar</h2><img src="assets/img/glyphicons_027_search.png"/></div></br>
			<a href="consultar.php" class="btn span12"><i class="icon-search "></i> Realizar una
				consulta espec&iacute;fica</a>
		</div>
	<!-- Modulo reportes -->
		<div class="span3 hero-unit" align="center">
			<div align="center"><h2>Reportes</h2><img src="assets/img/glyphicons_040_stats.png"/></div></br>			
			<a href="ficha.php" class="btn span12"><i class="icon-th"></i> Ficha</a></br> 
			<a href="lista.php" class="btn span12"><i class="icon-list"></i> Lista</a></br> 
			<a href="resumen.php" class="btn span12"><i class="icon-list-alt"></i> Resumen</a>
			<a href="segmento.php" class="btn span12"><i class="icon-globe"></i> Segmento</a></br>
		</div>
	</div>
	<?php } else if($usuario->getTipo()=="captura"){  ?>
		<div class="row-fluid">
			<!-- Modulo para empezar -->
		<div class="span3 hero-unit" align="center">
			<div align="center"><h2>Para empezar...</h2><img src="assets/img/glyphicons_173_play.png"/></div></br>
			<a href="#" class="btn span12"><i class="icon-book"></i> Manual de usuario</a>
		</div>				
			<!-- Modulo administrar -->	
		<div class="span3 hero-unit" align="center">
			<div align="center"><h2>Administrar</h2><img src="assets/img/glyphicons_280_settings.png"/></div></br>		
			<a href="administrarAmenidades.php" class="btn span12"><i class="icon-star"></i> Amenidades</a></br>
			<a href="administrarAcabados.php" class="btn span12"><i class="icon-star"></i> Acabados</a> </br>	
			<a href="administrarAtributos.php" class="btn span12"><i class="icon-star"></i> Atributos</a></br>
            <a href="administrarCaracteristicas.php" class="btn span12"><i class="icon-star"></i> Caracter&iacute;sticas</a></br>                	
			<a href="registrarProyecto.php" class="btn span12"><i class="icon-briefcase"></i> Proyectos</a></br>
			<a href="registrarModelo.php" class="btn span12"><i class="icon-fullscreen"></i> Modelos</a>			
		</div>				
		<!-- Modulo consultar -->	
		<div class="span3 hero-unit" align="center">
			<div align="center"><h2>Consultar</h2><img src="assets/img/glyphicons_027_search.png"/></div></br>
			<a href="consultar.php" class="btn span12"><i class="icon-search "></i> Realizar una
				consulta espec&iacute;fica</a>
		</div>
		<!-- Modulo reportes -->
		<div class="span3 hero-unit" align="center">
			<div align="center"><h2>Reportes</h2><img src="assets/img/glyphicons_040_stats.png"/></div></br>			
			<a href="ficha.php" class="btn span12"><i class="icon-th"></i> Ficha</a></br> 
			<a href="lista.php" class="btn span12"><i class="icon-list"></i> Lista</a></br> 
			<a href="resumen.php" class="btn span12"><i class="icon-list-alt"></i> Resumen</a>
			<a href="segmento.php" class="btn span12"><i class="icon-globe"></i> Segmento</a></br>
		</div>
	</div>
	<?php } else  if($usuario->getTipo()=="analisis"){ ?>
		<div class="row-fluid">
			<!-- Modulo para empezar -->
		<div class="span4 hero-unit" align="center">
			<div align="center"><h2>Para empezar...</h2><img src="assets/img/glyphicons_173_play.png"/></div></br>
			<a href="#" class="btn span12"><i class="icon-book"></i> Manual de usuario</a>
		</div>				
		<!-- Modulo consultar -->	
		<div class="span4 hero-unit" align="center">
			<div align="center"><h2>Consultar</h2><img src="assets/img/glyphicons_027_search.png"/></div></br>
			<a href="consultar.php" class="btn span12"><i class="icon-search "></i> Realizar una
				consulta espec&iacute;fica</a>
		</div>
	<!-- Modulo reportes -->
		<div class="span4 hero-unit" align="center">
			<div align="center"><h2>Reportes</h2><img src="assets/img/glyphicons_040_stats.png"/></div></br>			
			<a href="ficha.php" class="btn span12"><i class="icon-th"></i> Ficha</a></br> 
			<a href="lista.php" class="btn span12"><i class="icon-list"></i> Lista</a></br> 
			<a href="resumen.php" class="btn span12"><i class="icon-list-alt"></i> Resumen</a>
			<a href="segmento.php" class="btn span12"><i class="icon-globe"></i> Segmento</a></br>
		</div>
	</div>
	<?php } else { ?>
		<div class="row-fluid">
			<!-- Modulo para empezar -->
		<div class="span6 hero-unit" align="center">
			<div align="center"><h2>Para empezar...</h2><img src="assets/img/glyphicons_173_play.png"/></div></br>
			<a href="#" class="btn span12"><i class="icon-book"></i> Manual de usuario</a>
		</div>		
		<!-- Modulo reportes -->
		<div class="span6 hero-unit" align="center">
			<div align="center"><h2>Reportes</h2><img src="assets/img/glyphicons_040_stats.png"/></div></br>			
			<a href="ficha.php" class="btn span12"><i class="icon-th"></i> Ficha</a></br> 
			<a href="lista.php" class="btn span12"><i class="icon-list"></i> Lista</a></br> 
			<a href="resumen.php" class="btn span12"><i class="icon-list-alt"></i> Resumen</a>
			<a href="segmento.php" class="btn span12"><i class="icon-globe"></i> Segmento</a></br>
		</div>
	</div>
	<?php } ?>
	<!-- /row -->
</div>
<!-- /container -->
<?php  include "includes/footer_aplicacion_1.php" ?>