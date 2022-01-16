<?php
session_start();
include "includes/myAutoloader.inc.php";
include "encabezado.php";
include "conexion.php";
conectar();
include "funciones.php";
fecha();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link type="text/css" rel="stylesheet" href="css/estilo.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1; no-cache"/>
<title>SI.GE.A. de la rama develop</title>
<style type="text/css">
<!--
body {
	background-image: url(tallermoda.png);
}
-->
</style></head>
<body>
	
      <p>&nbsp;</p>

<form action="validar.php" method="post" name="validar">
<table align="center" border="1">
<tr align="center">
	<td>USUARIO:</td><td><input name="user" type="text" /></td>
</tr>
<tr>
	<td>CONTRASE&NtildeA:</td><td><input name="pass" type="password" /></td>
</tr>
<tr>
	<td colspan="2" align="center"><input name="entrar" value="ENTRAR" type="submit" /></td>
</tr>
</table>
</form>

</body>
</html>
