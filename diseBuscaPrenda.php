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
	botonvolvermenudise();
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
if (isset($_POST['buscaPrenda'])) {
?>	<table align="center" border="1">
	<tr><td>
	<table align="center">
	<tr align="center" ><td colspan="3"><strong> <?php
		$id = $_SESSION['id'];
		$user = new aux_admin();
		$aux_admin = $user->loginauxadmin($id);
		
		$user = new disenadora();
		$disenadora = $user->logindise($id);
		if ($aux_admin) {
			echo "GESTI&Oacute;N ADMINISTRATIVA";
		} elseif ($disenadora) {
			echo "GESTI&Oacute;N DISE&Ntilde;ADORA";
		} ?>
		</strong></td></tr>
	<tr align="center"><td colspan="3"><strong>BUSCAR PRENDA</strong></td></tr>
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST" name="busca2">
		<tr align="center"><td colspan="3"><strong>Elija un criterio de b&uacutesqueda:</strong></td></tr>
		<tr><td>Buscar por Nombre de la Prenda</td>
			<td><select name="nombre"> <?php
			$sql_nom_agrup = "select * from prenda group by nombre;";
			$res_nom_agrup = mysql_query($sql_nom_agrup) or die (mysql_error());
				while ($row_nom_agrup = mysql_fetch_array($res_nom_agrup)) { ?>
						<option value="<?php echo $row_nom_agrup['nombre']; ?>">
							<?php echo $row_nom_agrup['nombre']; ?>
						</option>
						<?php
					}	?>	
			</select></td>
			<td><input name="buscanombre" value="Buscar" type="submit" /></td>
		</tr>
		<tr><td>Buscar por Descripci&oacuten</td>
			<td><select name="descripcion"> <?php
			$sql_des_agrup = "select * from prenda group by descripcion;";
			$res_des_agrup = mysql_query($sql_des_agrup) or die (mysql_error());
				while ($row_des_agrup = mysql_fetch_array($res_des_agrup)) { ?>
						<option value="<?php echo $row_des_agrup['descripcion']; ?>">
							<?php echo $row_des_agrup['descripcion']; ?>
						</option>
						<?php
					}	?>	
			</select></td>
			<td><input name="buscadesc" value="Buscar" type="submit" /></td>
		</tr>
		<tr><td>Rango de precios</td>
			<td>Entre $<input type="number" min="1" name="precio1" /> y $<input type="number" min="1" name="precio2" /></td>
			<td><input name="buscaprecio" value="Buscar" type="submit" /></td>
		</tr>
		<tr><td>Prendas creadas entre: </td>
			<td><input type="date" id="fecha1" name="fechacrea1" max="<?php echo(getaniomesfecha()); ?>" /> y 
				<input type="date" id="fecha2" name="fechacrea2" max="<?php echo(getaniomesfecha()); ?>"/> </td>
			<td><input id="submit" name="buscacreadaentre" value="Buscar" type="submit" />
			</td>
		</tr>
		<tr><td>Prendas vendidas entre: </td>
			<td><input type="date" name="fechavend1" max="<?php echo(getaniomesfecha()); ?>"/> y 
				<input type="date" name="fechavend2" max="<?php echo(getaniomesfecha()); ?>"/> </td>
			<td><input name="buscavendidaentre" value="Buscar" type="submit" /></td>
		</tr>
	</form>
<?php
} else if (isset($_POST['buscanombre'])) { 
	$prendaxnombre = new prenda();
	$criteriobusqueda = 'nombre';
	$prendaxnombre->buscarxcriterio($_POST['nombre'], $criteriobusqueda);
} else if (isset($_POST['buscadesc'])) { 
	$prendaxdesc = new prenda();
	$criteriobusqueda = 'descripcion';
	$prendaxdesc->buscarxcriterio($_POST['descripcion'], $criteriobusqueda);
} else if (isset($_POST['buscaprecio'])) {
	$prendaxprecio = new prenda();
	$prendaxprecio->buscarxprecios($_POST['precio1'],$_POST['precio2']);
} else if (isset($_POST['buscacreadaentre'])) { 
	if ((isset($_POST['fechacrea1'])) or (isset($_POST['fechacrea2']))) {
		if (isset($_POST['fechacrea1'])) {$fechacrea1 = $_POST['fechacrea1'];}else {$fechacrea1 = "";}
		if (isset($_POST['fechacrea2'])) {$fechacrea2 = $_POST['fechacrea2'];}else {$fechacrea2 = "";}
		$prendaxfechas = new prenda();
		$crea_o_venta = 'fechainicreacion';
		$prendaxfechas->buscarentrefechas($fechacrea1, $fechacrea2, $crea_o_venta);
	} 
} else if (isset($_POST['buscavendidaentre'])) { 
	if (isset($_POST['fechavend1'])) {$fechavend1 = $_POST['fechavend1'];}else {$fechavend1 = "";}
		if (isset($_POST['fechavend2'])) {$fechavend2 = $_POST['fechavend2'];}else {$fechavend2 = "";}
		$prendaxfechas = new prenda();
		$crea_o_venta = 'fechaventa';
		$prendaxfechas->buscarentrefechas($fechavend1, $fechavend2, $crea_o_venta);
} else if (isset($_POST['buscamat'])) { 
} else if ((isset($_POST['borrar'])) or (isset($_POST['modif']))) { 
	$prendamodif = new prenda();
	if (isset($_POST['borrar'])) {
		$prendamodif->bajaPrenda($_POST["id"]);
	}
	if (isset($_POST['modif'])) {
		$modif = false;
		$prendamodif->modifPrenda($_POST["id"], $_POST["nombre"], $_POST["descripcion"], $_POST["precio"], $_POST["fechainicreacion"], $_POST["fechafincreacion"], $_POST["fechaventa"], $_POST["id_mod"], $modif);
	}
} else { 
	echo " <script languaje=javascript>alert ('Ocurri&oacute; un error inesperado, por favor vuelva a ingresar.');</script> "; 
	echo "<script>window.location.href = \"index.php\"</script>";
} ?>
	</table>
</td></tr>
</table>
</body>
</html>
