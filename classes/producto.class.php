<?php

class Producto {
	private $id_prod;
	private $nombre;
	private $cantStock;
	private $unidad;

	public function __construct(){
	}

	public function altaProd($nombre, $cantstock, $unidad) {
		$sql_duplicado = "select id_prod from producto where nombre = '$nombre';";
		$res_duplicado = mysql_query($sql_duplicado) or die(mysql_error());
		$num_rows = mysql_num_rows($res_duplicado);
		if ($num_rows > 0) {
			echo " <script languaje=javascript>alert ('Ya existe un producto con ese nombre.');</script> "; 
			echo "<script>window.location.href = \"menu_aux.php\"</script>";
		} else {
			$sql = "select MAX(id_prod) as idmax from producto;";
			$res = mysql_query($sql) or die(mysql_error());
			$row = mysql_fetch_array($res);
			$nvoid = $row['idmax']+1;
			if (!is_numeric($cantstock)) { $cantstock = "''"; }
			$sql_nvo_prod = "insert into producto values ($nvoid, '$nombre', $cantstock, '$unidad');";
			$res_nvo_prod = mysql_query($sql_nvo_prod) or die(mysql_error());
			echo "<script>window.location.href = \"menu_aux.php\"</script>";
		}
	}

	public function mostrar(){
		return "id de Producto: ".$this->id_prod."<br>".
		"nombre: ".$this->nombre."<br>".
		"cantidad de stock: ".$this->cantStock."<br>".
		"unidad: ".$this->unidad;
	}

	public function bajaProd ($id_prod){}
	public function modifProd ($id_prod, $nombre, $cantStock, $unidad){}

	public function faltantesdestock() {
		$sql_stock_prod = "select * from producto;";
		$res_stock_prod = mysql_query($sql_stock_prod) or die (mysql_error());
		
		$sql_cantxprenda = "select SUM(pip.cant) as pipcant, pip.id_prod as pip_id_prod
		from prenda_incluye_prod as pip, prenda as pre
		where pip.id = pre.id and (pre.fechafincreacion ='' or pre.fechafincreacion = '0000-00-00')
		group by id_prod;";
		
		$sql_cant_modistas = "select id_prod as mod_id_prod, SUM(cantidad) as mod_cant
		from modista_solicita_producto
		where (fecha_entrega ='' or fecha_entrega='0000-00-00')
		group by id_prod;";
			
		$sql_pedidos_prov = "select id_prod as ped_id_prod, sum(cantidad) as cant
		from pedido_prod_proveed
		where (fechaingresaprod = '' or fechaingresaprod='0000-00-00')
		group by id_prod;";
		
		$almenosuno = false;
		while ($row_stock_prod = mysql_fetch_array($res_stock_prod)) {	
			$faltante = $row_stock_prod['cantstock'];
			$res_cantxprenda = mysql_query($sql_cantxprenda) or die (mysql_error());
			$res_cant_modistas = mysql_query($sql_cant_modistas) or die(mysql_error());
			$res_pedidos_prod = mysql_query($sql_pedidos_prov) or die(mysql_error());

			while ($row_cantxprenda = mysql_fetch_array($res_cantxprenda)) {
				if ($row_stock_prod['id_prod'] == $row_cantxprenda['pip_id_prod']) {
					$faltante = $faltante - $row_cantxprenda['pipcant'];
					$pipcant = $row_cantxprenda['pipcant'];
				}
			}
			while ($row_cant_modistas = mysql_fetch_array($res_cant_modistas)) {
				if ($row_stock_prod['id_prod'] == $row_cant_modistas['mod_id_prod']) {
					$faltante =  $faltante - $row_cant_modistas['mod_cant'];
					$mod_cant = $row_cant_modistas['mod_cant'];
				}
			}
			while ($row_pedidos_prod = mysql_fetch_array($res_pedidos_prod)) {
				if ($row_stock_prod['id_prod'] == $row_pedidos_prod['ped_id_prod']) {
					$faltante = $faltante + $row_pedidos_prod['cant'];
					$pedidoscant = $row_pedidos_prod['cant'];
				}
			}

			if ($faltante<0) {
				if (!$almenosuno) {
					$almenosuno = true; ?>
					<tr><td colspan="5"><strong>FALTANTES DE STOCK (REALIZAR PEDIDOS A PROVEEDORES):</strong></td></tr>
					<tr align="center"><td>PRODUCTO</td>
						<td>ELEGIR PROVEEDOR</td>
						<td>CANT. FALTANTE</td>
						<td colspan="2">CANT. A SOLICITAR</td>
					</tr> <?php
				} ?>
				<form name="pedirstock" method="post" class="boton" action="pedir_stock.php">
				<input type="hidden" name="id_prod" value="<?php echo $row_stock_prod['id_prod']; ?>">
					<tr align="center">
						<td><?php echo $row_stock_prod['nombre']; ?></td>
						<td><?php $mostrar_prov = new proveedor();
						$mostrar_prov->listarproveedores($row_stock_prod['id_prod']); ?></td>
						<td><?php echo round($faltante,2)." ".$row_stock_prod['unidad']; ?></td>
						<td><input type="number" min="1" name="solicitar_cant"></td>
						<td><input type="submit" name="pedirstock" value="SOLICITAR"></td>
					</tr>
				</form> <?php
			}
		}
		
		if (!$almenosuno) { ?>
			<tr><td colspan="5"><strong> NO HAY FALTANTES DE STOCK.</strong></td></tr> <?php
		} 
	}

	public function selectproductos() {
		$sql = "select * from producto order by nombre;";
		$res = mysql_query($sql) or die (mysql_error()); ?>
		<select name="id_prod"> <?php
		while ($row = mysql_fetch_array($res)) { ?>
			<option value="<?php echo $row['id_prod']; ?>">
			<?php echo $row['nombre']." - Stock: ".$row['cantstock']." ".$row['unidad']; ?>
			</option>	<?php
		}	?>	
		</select> <?php
	}

	public function listaproductos() {
		$sql_productos = "select * from producto;";
		$res_productos = mysql_query($sql_productos) or die (mysql_error());

		while ($row_productos = mysql_fetch_row($res_productos)){
			$indice = "cant".$row_productos[0]; ?>
			<tr><td><?php echo $row_productos[1]; ?></td>
				<td><?php echo $row_productos[2]." ".$row_productos[3]; ?></td>
				<td><input type="number" min="1" name="<?php echo $indice; ?>" step=".01"/></td></tr> <?php 	
		}
	}

	public function listaproductosmodif($idprenda) {
		$sql_productos = "select pip.cant as cant, p.id_prod as id_prod, p.nombre as nombre, p.cantStock as cantstock, p.unidad as unidad, pip.id as id_prenda
					from producto p, prenda_incluye_prod pip, prenda pr
					where p.id_prod = pip.id_prod and pip.id = pr.id and pr.id = $idprenda
					group by nombre
					order by nombre;";
		$res_productos = mysql_query($sql_productos) or die (mysql_error());
		while ($row_productos = mysql_fetch_array($res_productos)) { 
			$indice = "cant".$row_productos['id_prod']; ?>
			<tr><td><?php echo $row_productos['nombre']; ?></td>
				<td><?php echo $row_productos['cantstock']." ".$row_productos['unidad']; ?></td>
				<td><input value="<?php if($idprenda == $row_productos['id_prenda']) echo $row_productos['cant']; ?>" type="number" min="1" name="<?php echo $indice; ?>" step=".01" /></td></tr><?php 	
		}
	}

	function __destruct(){
	}
}
