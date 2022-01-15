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
	botonsolicitarstock();
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
	$id = $_SESSION['id'];
	$sql_modista = "select u.nombre as nom, u.apellido as ape 
					from modista m, usuario u
					where m.id_mod = u.id and m.id_mod = $id;";
	$res_modista = mysql_query($sql_modista) or die(mysql_error());
	$row_modista = mysql_fetch_array($res_modista);
	if (!$res_modista) {
		echo " <script languaje=javascript>alert ('El usuario no es modista.');</script> "; 
		echo "<script>window.location.href = \"index.php\"</script>";
	}

	if (isset($_POST['solicitarstock'])) { ?>
		<table align="center">
		<tr><td>
			<table align="center" border="1">
				<tr align="center" ><td colspan="2"><strong>SOLICITAR PRODUCTO (* Obligatorios)</strong></td></tr>
				<tr><td colspan="2"><br/></td></tr> 
				<form action="menu_mod.php" method="post" name="altasolicitud">
					<tr><td>Producto:</td>
						<td><?php $obj = new producto();
						$obj->selectproductos();
						?></td>
					</tr>
					<tr><td>Cantidad a solicitar: </td><td><input type="number" min="1" name="modsolicita" /></td></tr>
					<tr><td colspan="2"><input name="altasolicitud" value="Agregar" type="submit" /></td></tr>
				</form>
			</table>
		</td></tr>
		</table> <?php
	} elseif (isset($_POST['altasolicitud'])) {
		$fecha_solicitud = getaniomesfecha();
		$cantsolicita = $_POST['modsolicita'];
		$mod_sol_stock = new modista_solicita_prod();
		$altaok = $mod_sol_stock->altaSolicitud($_POST['id_prod'], $cantsolicita, $fecha_solicitud);
		if ($altaok) {
			echo "<script languaje=javascript>alert ('Solicitud cargada correctamente.');</script> "; 
		} else {
			echo " <script languaje=javascript>alert ('La solicitud no se ha podido cargar.');</script> "; 
		}
		echo "<script>window.location.href = \"menu_mod.php\"</script>";
	} else { ?>
		<table align="center">
		<tr><td>
			<table align="center" border="1"> 
			<tr align="center" ><td colspan="5"><strong>Bienvenida Modista 
			<?php	echo $row_modista['nom']." ".$row_modista['ape']; 	?>
			</strong></td></tr>
			<tr><td colspan="5"><br/></td></tr>
				<?php
				$id = $_SESSION['id']; 
				$mod_sol_prod = new modista_solicita_prod();
				$mod_sol_prod->mostrar_solicitudes_pendientes($id); ?>
			<tr><td colspan="5"><br/></td></tr>
				<?php
				$id = $_SESSION['id']; 
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