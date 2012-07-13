<?php 
/*
 * Clase Conexion
 * Establece la conexion a la base de datos MySQL
 * Se define el nombre de la base de datos, el nombre de usuario, el password
 * y el url para realizar la conexion.
 */

/**
 *
 * @author Oziel
 */
error_reporting(0);
class Conexion {
	
	
	/**
	 * M�todo dbconn
	 * Establece la conexion a la base de datos mysql
	 * @param database, nombre de la base de datos.
	 * @param hostname, nombre de url de la base de datos.
	 * @param username, nombre de usuario
	 * @param password, la contrase�a de la base de datos.
	 * @return Objeto Connection, la conexion a la base de datos.
	 */
	function dbconn() {
		//Colocar otro if(include-... con ../fueraderoot en servidor
		if(!include_once($_SERVER['DOCUMENT_ROOT'].'/sigii/fueraderoot/dbcfg.php')) {
			
			echo "Problema de conexion a DB";
		
		}
	
		if (!$link = mysql_connect($db['hostname'],$db['username'],$db['password'])) {
			die('Error connecting...');
		}
	
		if (!mysql_select_db($db['database'])) {
			die('Error selecting...');
		}
	
		return $link;
	}
}
?>