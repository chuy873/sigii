<?php
/*
Barra de navegación del usuario tipo captura
Se despliega el nombre y apellidos del usuario obtenidos de la session.
*/
?>
    <div id="wrap" class="wrapper">
      <!-- Barra de navegacion -->
       <div class="row pad3">
      <div class="span2 offset0" align="right"><img src="assets/img/sigii.png"/></div>
      <div id="nav" class="span10 navbar ">
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
                <li><a href="bienvenido.php"><i class="icon-home icon-white"></i> INICIO</a></li>
                <li class="dropdown">
                	<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class=" icon-wrench icon-white"></i> ADMINISTRACI&Oacute;N<b class="caret"></b></a>
                	<ul class="dropdown-menu">
                		<li><a href="administrarAmenidades.php"><i class="icon-star-empty icon-white"></i> AMENIDADES</a></li>
                        <li><a href="administrarAcabados.php"><i class="icon-star icon-white"></i> ACABADOS</a></li>
                		<li><a href="administrarAtributos.php"><i class="icon-star-empty icon-white"></i> ATRIBUTOS</a></li>
                		<li><a href="administrarCaracteristicas.php"><i class="icon-star icon-white"></i> CARACTER&Iacute;STICAS</a></li>
             		    <li><a href="administrarPuntos.php"><i class="icon-screenshot icon-white"></i> PUNTOS DE AFLUENCIA</a></li>             		                		           
                	</ul>
                </li>
                <li class="dropdown">
                	<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-search icon-white"></i> PROYECTOS <b class="caret"></b></a>
                	<ul class="dropdown-menu">
                		<li><a href="registrarProyectoVertical.php"><i class="icon-resize-vertical icon-white"></i> REGISTRAR VERTICAL </a></li>
                		<li><a href="registrarProyectoHorizontal.php"><i class="icon-resize-horizontal icon-white"></i> REGISTRAR HORIZONTAL </a></li>
                	</ul>                	
                </li>
                <li class="dropdown">
                	<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-search icon-white"></i> MODELOS <b class="caret"></b></a>
                	<ul class="dropdown-menu">
                		<li><a href="registrarModeloVertical.php"><i class="icon-resize-vertical icon-white"></i> REGISTRAR VERTICAL </a></li>
                		<li><a href="registrarModeloHorizontal.php"><i class="icon-resize-horizontal icon-white"></i> REGISTRAR HORIZONTAL </a></li>
                	</ul>                	
                </li>
                <li class="dropdown">
                	<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-th-list icon-white"></i> REPORTES <b class="caret"></b></a>
                	<ul class="dropdown-menu">
                		<li><a href="ficha.php"><i class="icon-th icon-white"></i> FICHA </a></li>
                		<li><a href="lista.php"><i class="icon-list icon-white"></i> LISTA </a></li>
                		<li><a href="resumen.php"><i class="icon-list-alt icon-white"></i> RESUMEN </a></li>
                		<li><a href="segmento.php"><i class="icon-globe icon-white"></i> SEGMENTO </a></li>                		
                	</ul>                	
                </li>               
                 <li><a href="consultar.php"><i class="icon-search icon-white"></i> CONSULTAR </a></li>
              </ul>
                 
              <ul class="nav pull-right">
				<li><a href="#"><i class="icon-user icon-white"></i> </a></li>
                <li><a href="control/CerrarSesion.php"><i class="icon-off icon-white"></i></a></li>               
              </ul>
            </div><!--/.nav-collapse -->
          </div> <!-- /.container -->
        </div> <!-- /navbar-inner -->
      </div> <!-- /navbar -->
      </div>