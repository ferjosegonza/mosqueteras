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

<table align="center" border="1">
<tr><td>
	<table align="center">
	<tr align="center" ><td colspan="3"><strong>GESTI&OacuteN DISE&NtildeADORA</strong></td></tr>
	<tr align="center"><td colspan="3"><strong>CARGA DE PRENDA (* Obligatorios)</strong></td></tr>

<?php
if (isset($_POST['altaPrenda'])) {
?>
	<form name="grabarPrenda" method="post" action="diseAltaPrenda.php">
	<tr><td>* Nombre de la Prenda</td><td><input required="" type="text" name="nombre" maxlength="50" /></td></tr>
	<tr><td>* Descripci&oacuten</td><td><input required="" type="text" name="descripcion" maxlength="50" /></td></tr>
	<tr><td>* Precio de venta</td><td><input required="" type="number" min="1" name="precio" /></td></tr>
	<tr><td>Fecha inicio de confecci&oacuten</td><td><?php echo solofecha(); ?></td></tr>
	<tr><td align="center"><br><strong>Materiales para confecci&oacuten</strong></td>
		<td align="center"><br><strong>Stock</strong></td>
		<td align="left"><br><strong>Cantidad **</strong></td></tr> <?php 
			$obj = new producto();
			$obj->listaproductos(); ?>
	<tr><td colspan="3"><FONT SIZE=2>** Si la cantidad solicitada supera el stock, el Sistema SI.GE.A. notificar&aacute a la Auxiliar Administrativa.</FONT></td></tr>
	<tr align="center"><td colspan="3"><input type="submit" name="grabarPrenda" value="Cargar Prenda" /></td></tr>
	</form>
<?php
} 
else if (isset($_POST['grabarPrenda'])){
		//Hay campos suficientes para cargar la prenda
		// mandar al metodo de dar de alta de la clase prenda
		$nvaprenda = new prenda();
		$idprenda = $nvaprenda->altaPrenda ($_POST['nombre'], $_POST['descripcion'], $_POST['precio']);
		
		if($idprenda) {
			$nombre = $_POST['nombre'];
			$descripcion = $_POST['descripcion'];
			$precio = $_POST['precio'];

			// FALTA CARGAR LOS MATERIALES, SI HUBIERE
			$combinarmateriales = "";
			$sql_maxid = "select max(id_prod) as maxid from producto;";
			$res_maxid = mysql_query($sql_maxid) or die (mysql_error());
			$row_maxid = mysql_fetch_array($res_maxid);
			
			for ($i=1; $i < $row_maxid['maxid']+1; $i++) { 
				$canti = "cant".$i;
				if($_POST[$canti]) {
					//se cargó la cant de x lo menos uno de los materiales
					$almenosuno = true;
					$sql = "insert into prenda_incluye_prod values ($idprenda, $i, $_POST[$canti]);";
					$res = mysql_query($sql);

					$sql_prod = "select nombre from producto where id_prod = $i;";
					$res_prod = mysql_query($sql_prod) or die (mysql_error());
					$row_prod = mysql_fetch_array($res_prod);

					if (!$res){
						echo "<script languaje=javascript> alert('La cantidad ".$_POST[$canti]." del material ".$row_prod['nombre']." no se pudo cargar correctamente.');</script> " ;
					}

				if ($almenosuno) {
					$combinarmateriales = $combinarmateriales.$row_prod['nombre']." - Cantidad: ".$_POST[$canti]."\\n";
				}

				} else {
					//no se cargó ninguna cant de materiales
				}
			}

			// mostrar el msj de prenda y materiales cargado correctamente
			if ($combinarmateriales != "") { $combinarmateriales = '\\nMateriales:\\n'.$combinarmateriales;}
			$string = "PRENDA CARGADA CORRECTAMENTE.\\nNombre de la Prenda: ".$nombre."\\nDescripcion: ".$descripcion."\\nPrecio: $".$precio."\\n".$combinarmateriales;
			echo "<script languaje=javascript> alert('".$string."');</script> " ;
			echo "<script>window.location.href = \"menu_dise.php\"</script>";

		} else {
		// no cargo la prenda, volver
			echo " <script languaje=javascript>alert ('No se pudo cargar la Prenda, intente nuevamente o comuniquese con el Administrador.');</script> "; 
			echo "<script>window.location.href = \"diseAltaPrenda.php\"</script>";
		}
	} else { 
		echo " <script languaje=javascript>alert ('Ocurrió un error inesperado, por favor vuelva a ingresar.');</script> "; 
		echo "<script>window.location.href = \"index.php\"</script>";
	} ?>
	</table>
</td>
</tr>
</table>
</body>
</html>
