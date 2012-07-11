<?php
/*
Barra de navegación del usuario tipo analisis
Se despliega el nombre y apellidos del usuario obtenidos de la session.
*/
?>
   <div id="wrap" class="wrapper">
      <!-- Barra de navegacion -->
      <div id="nav" class="navbar navbar-fixed-top">
        <div class="navbar-inner">
          <div class="container">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </a> <!-- / boton de colapsar -->
            <span class="brand">SIGII</span>
            <div class="nav-collapse">
            <ul class="nav">
                <li><a href="bienvenido.php"><i class="icon-home icon-white"></i> Inicio</a></li>                
                 <li class="dropdown">
                	<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-th-list icon-white"></i> Reportes <b class="caret"></b></a>
                <ul class="dropdown-menu">
                		<li><a href="ficha.php"><i class="icon-th icon-white"></i> Ficha </a></li>
                		<li><a href="lista.php"><i class="icon-list icon-white"></i> Lista </a></li>
                		<li><a href="resumen.php"><i class="icon-list-alt icon-white"></i> Resumen </a></li>
                		<li><a href="segmento.php"><i class="icon-globe icon-white"></i> Segmento </a></li>                		
                	</ul>                	
                </li>               
                 <li><a href="consultar.php"><i class="icon-search icon-white"></i> Consultar </a></li>
              </ul>              
              <ul class="nav pull-right">
				<li><a href="#"><i class="icon-user icon-white"></i> <?php echo $usuario->getNombre()." ".$usuario->getApellidos() ?></a></li>
                <li><a href="control/CerrarSesion.php"><i class="icon-off icon-white"></i> Cerrar Sesi&oacute;n</a></li>               
              </ul>
            </div><!--/.nav-collapse -->
          </div> <!-- /.container -->
        </div> <!-- /navbar-inner -->
      </div> <!-- /navbar -->