<?php
session_start();
include "includes/myAutoloader.inc.php";
include "encabezado.php";
include "conexion.php";
conectar();
include "funciones.php";
fecha();
?>

<table align="center">
	<tr align="left">
	<?php
	botoncerrarsesion();
?>
	</tr>
</table>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link type="text/css" rel="stylesheet" href="css/estilo.css">
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1; no-cache"/>
<title>SI.GE.A.</title>
<style type="text/css">
<!--
body {
	background-image: url(tallermoda.png);
}
-->
</style></head>
<body>
<br />

<?php

if ($_SESSION['usuario_autentificado']) {
?>
<table align="center" border="1">
<tr><td>
	<table align="center">
	<tr align="center"><td colspan="2"><strong>GESTIÓN DISEÑADORA</strong></td></tr>
	<form name="altaPrenda" method="post" class="boton" action="diseAltaPrenda.php">
	<tr align="center"><td colspan="2"><input type="submit" width="20em" name="altaPrenda" value="Cargar Prenda" /></td></tr>
	</form>
	<br/>
	<form name="buscaPrenda" method="post" action="diseBuscaPrenda.php">
		<tr align="center"><td colspan="2"><input type="submit" width="100%" name="buscaPrenda" value="Buscar Prenda" /></td></tr>
		<tr><td colspan="3"><FONT SIZE=2>Para modificar o borrar una prenda, realice una b&uacutesqueda.</FONT></td></tr>
	</form>
	</table>
</td>
</tr>
</table>

<?php
} 
else 
{ 
	echo "no entro a ".$_SESSION['usuario_autentificado'];
	echo " <script languaje=javascript>alert ('Ingrese con Usuario y Contraseña.');</script> "; 
	echo "<script>window.location.href = \"index.php\"</script>";
}
?>
</body>
</html>