<?php 
/*
 * Control Iniciar Sesion
 * Se establece una sesion con los datos del usuario y contraseña
 * si existe en la BD
 */
//Incluir el objeto usuario
include_once("../clases/Usuarios.php");
//Incluir e instanciar la conexion a la DB
include('../clases/Conexion.php');
$conexion = new Conexion();
$link = $conexion->dbconn();
//Obtener datos de la forma
$username = $_POST["username"];
$password = $_POST["password"];
//Seguridad SQLi
mysql_real_escape_string($username);
mysql_real_escape_string($password);
//Consulta para obtener datos de usuario que se loguea
$datosusuario = sprintf("SELECT * FROM usuarios WHERE username = '%s'
				AND password = '%s' ",mysql_real_escape_string($username),mysql_real_escape_string($password));
$result = mysql_query( $datosusuario );
//Verificar si existe y redirigir en caso contrario

	$data = mysql_fetch_array($result, MYSQL_ASSOC);
	if($data['nombre']==""){
		header("Location: ../index.php");
	} else {
	//Iniciar la sesión
	/* set the cache limiter to 'private' */
	
	session_cache_limiter('private');
	$cache_limiter = session_cache_limiter();
	
	/* set the cache expire to 30 minutes */
	session_cache_expire(1);
	$cache_expire = session_cache_expire();
	
	/* start the session */
	
	session_start();
	$_SESSION['username'] = $result;
	$_SESSION['time'] = time();
	
	echo "The cache limiter is now set to $cache_limiter<br />";
	echo "The cached session pages expire after $cache_expire minutes";
	session_start();
//$data = mysql_fetch_array($result, MYSQL_ASSOC);
	//usuario y contraseña son validos
	//crear variable para la sesion
	$usuario = new Usuarios();
	$usuario->setUsername($data["username"]);
	$usuario->setPassword($data["password"]);
	$usuario->setIdU($data["idusuarios"]);
	$usuario->setNombre($data["nombre"]);
	$usuario->setApellidos($data["apellidos"]);
	$usuario->setEmail($data["email"]);
	$usuario->setTipo($data["tipo"]);
	$usuario->setTelefono($data["telefono"]);
	$_SESSION["autentificado"]="1";
	$_SESSION["usuario"] = $usuario;
	mysql_close($link);
	header("Location: ../bienvenido.php");
}

?>