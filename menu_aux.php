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
	botonagregarproducto();
	botonbuscarprenda();
	botonvolvermenuaux();
	botonmodistas();
	botondisenadoras();
	botonusuarios();
	?>
	</tr>
</table>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

<link type="text/css" rel="stylesheet" href="css/estilo.css" media="screen">

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
	if (isset($_POST['agregarproducto'])) { ?>
		<table align="center">
		<tr><td>
			<table align="center" border="1">
				<tr align="center" ><td colspan="2"><strong>AUXILIAR ADMINISTRATIVA</strong></td></tr>
				<tr align="center" ><td colspan="2"><strong>AGREGAR NUEVO PRODUCTO (* Obligatorios)</strong></td></tr>
				<tr><td colspan="5"><br/></td></tr> 
				<form action="menu_aux.php" method="post" name="altaprod">
					<tr><td>* Nombre del Producto:</td>
						<td><input required="" type="text" name="nombre" maxlength="50" /></td></tr>
					<tr><td>Stock: </td><td><input type="number" min="1" name="cantstock" /></td></tr>
					<tr><td>* Unidad:</td>
						<td><input required="" type="text" name="unidad" maxlength="30" /></td></tr>
					<tr><td colspan="2"><input name="altaprod" value="Agregar" type="submit" /></td></tr>
				</form>
			</table>
		</td></tr>
		</table> <?php
	} else if (isset($_POST['altaprod'])) {
		$producto = new producto();
		$nombre = $_POST['nombre'];
		$cantStock = $_POST['cantstock'];
		$unidad = $_POST['unidad'];
		$producto->altaprod($nombre, $cantStock, $unidad);
	} else { ?>
		<table align="center">
		<tr><td>
			<table align="center" border="1">
				<tr align="center" ><td colspan="5"><strong>AUXILIAR ADMINISTRATIVA</strong></td></tr>
				<tr><td colspan="5"><br/></td></tr>	<?php 
				$id = $_SESSION['id'];
				$mod_sol_prod = new modista_solicita_prod();
				$mod_sol_prod->mostrar_solicitudes_pendientes($id); ?>
				<tr><td colspan="5"><br/></td></tr> <?php 
				$pedido = new producto();
				$pedido->faltantesdestock(); ?>
				<tr><td colspan="5"><br/></td></tr>	<?php 
				$pedido = new pedidoProdProveed();
				$pedido->pedidos_pendientes(); ?>
				<tr><td colspan="5"><br/></td></tr> <?php
				$modista_confecciona = new modista();
				$modista_confecciona->prendasenconfeccion($id); ?>
			</table>
		</td></tr>
		</table> <?php
	}
} else { 
	echo "no entro a ".$_SESSION['usuario_autentificado'];
	echo " <script languaje=javascript>alert ('Ingrese con Usuario y Contraseña.');</script> "; 
	echo "<script>window.location.href = \"index.php\"</script>";
}
?>
</body>
</html>