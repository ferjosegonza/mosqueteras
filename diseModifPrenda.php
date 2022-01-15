<?php
session_start();
include "includes/myAutoloader.inc.php";
include "encabezado.php";
include "conexion.php";
conectar();
include "funciones.php";

$prendamodif = new prenda();
$modif = true;
$prendamodif->modifPrenda($_POST["id_prenda"], $_POST["nombre"], $_POST["descripcion"], $_POST["precio"], $_POST["fechainicreacion"], $_POST["fechafincreacion"], $_POST["fechaventa"], $_POST["mod"], $modif);
if($prendamodif) {
	$nombre = $_POST['nombre'];
	$descripcion = $_POST['descripcion'];
	$precio = $_POST['precio'];

	// FALTA CARGAR LOS MATERIALES, SI HUBIERE

	$sql_borrar = "delete from prenda_incluye_prod where id = ".$_POST["id_prenda"].";";
	$res_borrar = mysql_query($sql_borrar) or die (mysql_error());

	$combinarmateriales = "";
	$sql_maxid = "select max(id_prod) as maxid from producto;";
	$res_maxid = mysql_query($sql_maxid) or die (mysql_error());
	$row_maxid = mysql_fetch_array($res_maxid);

	for ($i=1; $i < $row_maxid['maxid']+1; $i++) { 
		$canti = "cant".$i;
		if($_POST[$canti]) {
			//se cargó la cant de x lo menos uno de los materiales
			$almenosuno = true;
			$sql = "insert into prenda_incluye_prod values (".$_POST["id_prenda"].", $i, $_POST[$canti]);";
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
	$string = "PRENDA MODIFICADA CORRECTAMENTE.\\nNombre de la Prenda: ".$nombre."\\nDescripcion: ".$descripcion."\\nPrecio: $".$precio."\\n".$combinarmateriales;
	echo "<script languaje=javascript> alert('".$string."');</script> " ;
	echo "<script>window.location.href = \"menu_dise.php\"</script>";

} else {
	// no cargo la prenda, volver
	echo " <script languaje=javascript>alert ('No se pudo modificar la Prenda, intente nuevamente o comuniquese con el Administrador.');</script> "; 
	echo "<script>window.location.href = \"menu_dise.php\"</script>";
}
?>