<?php
include "../clases/Conexion.php";
$conexion = new Conexion();
$link = $conexion->dbconn();
$ciudad=$_POST["zona"];
$sql="SELECT * FROM zona WHERE ciudad = '".$ciudad."' ORDER BY subzona ASC";
$result = mysql_query($sql);
	if (!$result) {
						die('No se pudo realizar la consulta:' . mysql_error());
						header("Location: ../index.php");
					} else {
						header("Content-Type: text/html; charset=iso-8859-1");
						echo "<select class='span2' name='subzona' id='subzonaSelect'>";									
						while ($data = mysql_fetch_array($result, MYSQL_ASSOC)) {	
						echo "<option value='".$data["idzona"]."'>".$data["subzona"]."</option>";										
						}	
						echo "</select>";
						
					}