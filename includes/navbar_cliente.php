<?php 
/*
Barra de navegación del usuario tipo cliente
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
            <div class="nav-collapse">
              <ul class="nav">
                <li><a href="bienvenido.php"><i class="icon-home icon-white"></i> Inicio</a></li>               
                <li class="dropdown">
                	<a href="#" data-toggle="dropdown" class="dropdown-toggle"><i class="icon-th-list icon-white"></i> REPORTES <b class="caret"></b></a>
                	<ul class="dropdown-menu">
                		<li><a href="ficha.php"><i class="icon-th icon-white"></i> FICHA </a></li>
                		<li><a href="lista.php"><i class="icon-list icon-white"></i> LISTA </a></li>
                		<li><a href="resumen.php"><i class="icon-list-alt icon-white"></i> RESUMEN </a></li>
                		<li><a href="segmento.php"><i class="icon-globe icon-white"></i> SEGMENTO </a></li>                		
                	</ul>                	
                </li>                                   
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