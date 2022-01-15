<?php

function conectar()
{
	global $con;
	$ret = false;
		$con = mysql_connect("localhost","root","");
		if ($con != false)
		{
				mysql_select_db("dbmosqueteras",$con) or die ("Error: Imposible Conectar con la Base de Datos".mysql_error());
				$ret = true;
		}
		else
		{
		die ("Error: Imposible Conectar con MySQL".mysql_error());
		}
	return $ret;
}
function desconectar()
{
	mysql_close($con);
}

?>
