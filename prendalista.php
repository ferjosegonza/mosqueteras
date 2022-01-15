<?php
session_start();
include "includes/myAutoloader.inc.php";
include "encabezado.php";
include "conexion.php";
conectar();
include "funciones.php";


/*
$id_prod = $_POST['id_prod'];
$cant = $_POST['solicitar_cant'];
$id_proveedor = $_POST['proveedor'];
$fechapedido = getaniomesfecha();

$obj = new pedidoProdProveed();
$obj->altaPedido($id_prod,$cant,$id_proveedor,$fechapedido);
*/

$id_prenda = $_POST['id_prenda'];
$fechahoy = getaniomesfecha();

if (isset($_POST['adminretiraprenda'])) {

	$obj = new aux_admin();
	$obj->admin_retira_prenda($id_prenda,$fechahoy);

} else if (isset($_POST['modterminaprenda'])) {
	
	$obj = new modista();
	$obj->modista_termina_prenda($id_prenda,$fechahoy);

}

?>