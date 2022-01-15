<?php
session_start();
include "includes/myAutoloader.inc.php";
include "encabezado.php";
include "conexion.php";
conectar();
include "funciones.php";

if(isset($_POST['id_pedido'])) {
	$id_pedido = $_POST['id_pedido']; 
	$fecharecibido = getaniomesfecha();
	$cant = $_POST['cant'];
	$id_prod = $_POST['id_prod'];

	$obj = new pedidoProdProveed();
	$obj->recibirPedido($id_pedido,$fecharecibido,$cant,$id_prod);
}
?>