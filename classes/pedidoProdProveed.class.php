<?php

class pedidoProdProveed {
	protected $id;
	protected $cantidad;
	protected $fechaPedido;
	protected $fechaIngresaProd;
	protected $id_proveedor;

	function __construct() {
	}

	public function altaPedido($id_prod,$cant,$id_proveedor,$fechapedido) {
		$sql_id = "select MAX(id) as maxid from pedido_prod_proveed;";
		$res_id = mysql_query($sql_id) or die (mysql_error());
		$row_id = mysql_fetch_array($res_id);
		$nvo_id = $row_id['maxid']+1;
		$id_aux = $_SESSION['id'];
		echo $sql = "insert into pedido_prod_proveed values ($nvo_id,$id_aux,$id_prod,$id_proveedor,$cant,'$fechapedido','');";
		$res = mysql_query($sql) or die (mysql_error());
		if ($res) {
			echo "<script>window.location.href = \"menu_aux.php\"</script>";
		}
	}

	public function bajaPedido(){}

	public function modifPedido(){}

	public function pedidos_pendientes() {
		$sql = "select pedido.id as id_pedido,
		 	pedido.id_proveedor as id_prov,
		 	prov.nombre_prov as nombre_prov,
		 	prod.nombre as prod_nom, 
		 	prod.id_prod as prod_id, 
		 	pedido.id_prod as id_prod, 
		 	pedido.cantidad as cant, 
		 	pedido.fechaPedido as fechaPedido, 
		 	pedido.fechaIngresaProd as fechaIngresaProd,
		 	prov.id_proveedor as prov_id,
		 	prod.unidad as unidad
		from proveedor prov, pedido_prod_proveed pedido, producto prod 
		where 
			prod.id_prod = pedido.id_prod and 
			prov.id_proveedor = pedido.id_proveedor and 
			(pedido.fechaIngresaProd = '' or pedido.fechaIngresaProd = '0000-00-00')
		order by fechaPedido;";
		$res = mysql_query($sql) or die (mysql_error());
		$num_rows = mysql_num_rows($res);
		if ($num_rows > 0) { ?>
			<tr><td colspan="5"><strong>PEDIDOS REALIZADOS A PROVEEDORES (NO ENVIARON):</strong></td></tr>
			<tr align="center"><td>PEDIDO EL:</td>
				<td>PROVEEDOR</td>
				<td>PRODUCTO</td>
				<td colspan="2">CANT. SOLICITADA</td>
			</tr> <?php
		} else { ?>
			<tr><td colspan="5"><strong> NO HAY PEDIDOS PENDIENTES A PROVEEDORES.</strong></td></tr> <?php
		}

		while ($row = mysql_fetch_array($res)) { ?>
			<form name="recibirstock" method="post" class="boton" action="pedidos_proveedores.php">
				<input type="hidden" name="id_pedido" value="<?php echo $row['id_pedido']; ?>">
				<input type="hidden" name="cant" value="<?php echo $row['cant']; ?>">
				<input type="hidden" name="id_prod" value="<?php echo $row['id_prod']; ?>">
				<tr align="center">
					<td><?php echo $row['fechaPedido']; ?></td>
					<td><?php echo $row['nombre_prov']; ?></td>
					<td><?php echo $row['prod_nom']; ?></td>
					<td><?php echo $row['cant']." ".$row['unidad']; ?></td>
					<td><input type="submit" name="recibirproducto" value="RECIBIR PRODUCTO"></td>
				</tr>
			</form>
			<?php
		}
	}

	function recibirPedido ($id_pedido,$fecharecibido,$cant,$id_prod) {
		$sql_pedido = "update pedido_prod_proveed set
				fechaingresaprod = '$fecharecibido'
				where id = $id_pedido";
		$res_pedido = mysql_query($sql_pedido) or die (mysql_error());
		$sql_agregar_stock = "update producto set
				cantstock = cantstock + $cant
				where id_prod = $id_prod";
		$res_agregar_stock = mysql_query($sql_agregar_stock) or die (mysql_error());
		echo "<script>window.location.href = \"menu_aux.php\"</script>";
	}
}