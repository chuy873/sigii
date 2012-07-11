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
                	<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class=" icon-wrench icon-white"></i> Administraci&oacute;n<b class="caret"></b></a>
                	<ul class="dropdown-menu">
                		<li><a href="administrarAmenidades.php"><i class="icon-star-empty icon-white"></i> Amenidades</a></li>
                        <li><a href="administrarAcabados.php"><i class="icon-star icon-white"></i> Acabados</a></li>
                		<li><a href="administrarAtributos.php"><i class="icon-star-empty icon-white"></i> Atributos</a></li>
                		<li><a href="administrarCaracteristicas.php"><i class="icon-star icon-white"></i> Caracter&iacute;sticas</a></li>
             		    <li><a href="administrarPuntos.php"><i class="icon-screenshot icon-white"></i> Puntos de afluencia</a></li>             		   
             		    <li><a href="administrarUsuarios.php"><i class="icon-user icon-white"></i> Usuarios</a></li>             
                	</ul>
                </li>
                <li class="dropdown">
                	<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-search icon-white"></i> Proyectos <b class="caret"></b></a>
                	<ul class="dropdown-menu">
                		<li><a href="administrarVertical.php"><i class="icon-resize-vertical icon-white"></i> Vertical </a></li>
                		<li><a href="administrarHorizontal.php"><i class="icon-resize-horizontal icon-white"></i> Horizontal </a></li>
                		<li><a href="administrarProyectos.php"><i class="icon-briefcase icon-white"></i> Todos </a></li>
                		<li><a href="registrarProyectoVertical.php"><i class="icon-resize-vertical icon-white"></i> Registar Vertical </a></li>
                		<li><a href="registrarProyectoHorizontal.php"><i class="icon-resize-horizontal icon-white"></i> Registar Horizontal </a></li>
                	</ul>                	
                </li>
                <li class="dropdown">
                	<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-search icon-white"></i> Modelos <b class="caret"></b></a>
                	<ul class="dropdown-menu">
                		<li><a href="administrarModeloVertical.php"><i class="icon-resize-vertical icon-white"></i> Administrar Vertical </a></li>
                		<li><a href="administrarModeloHorizontal.php"><i class="icon-resize-horizontal icon-white"></i> Administrar Horizontal </a></li>
                		<li><a href="administrarModelos.php"><i class="icon-fullscreen icon-white"></i> Administrar Todos </a></li>
                		<li><a href="seleccionarProyAdmin.php"><i class="icon-briefcase icon-white"></i> Administrar por proyecto </a></li>                	
                		<li><a href="registrarModeloVertical.php"><i class="icon-resize-vertical icon-white"></i> Registar Vertical </a></li>
                		<li><a href="registrarModeloHorizontal.php"><i class="icon-resize-horizontal icon-white"></i> Registar Horizontal </a></li>
                	</ul>                	
                </li>
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
				<li><a href="#"><i class="icon-user icon-white"></i> <?php echo $usuario->getNombre()." ". $usuario->getApellidos() ?></a></li>
                <li><a href="control/CerrarSesion.php"><i class="icon-off icon-white"></i> Cerrar Sesi&oacute;n</a></li>               
              </ul>
            </div><!--/.nav-collapse -->
          </div> <!-- /.container -->
        </div> <!-- /navbar-inner -->
      </div> <!-- /navbar -->