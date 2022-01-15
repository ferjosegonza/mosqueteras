<?php
session_start();
include "includes/myAutoloader.inc.php";
include "encabezado.php";
include "conexion.php";
conectar();
include "funciones.php";


if (isset($_POST['enviado_a_modista'])) {
	$id_solicitud = $_POST['id_solicitud'];
	$cant = $_POST['cant'];
	$id_prod = $_POST['id_prod'];

	$obj = new modista_solicita_prod();
	$obj->cargar_fecha_entrega($id_solicitud, $cant, $id_prod);
} elseif (isset($_POST['anularsolicitud'])) {
	$modista_solicita_prod = new modista_solicita_prod();
	$baja = $modista_solicita_prod->anularSolicitud($_POST['id_solicitud']); 
	if ($baja) {
		echo "<script languaje=javascript>alert ('Solicitud anulada correctamente.');</script> ";
	} else {
		echo "<script languaje=javascript>alert ('La solicitud no se pudo anular.');</script> ";
	}
	echo "<script>window.location.href = \"menu_mod.php\"</script>";
}

?>