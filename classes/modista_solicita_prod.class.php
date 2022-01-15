<?php

class modista_solicita_prod {
	protected $id_solicitud;
	protected $id_mod;
	protected $id_prod;
	protected $cantsolicita;
	protected $fecha_solicitud;
	protected $fecha_entrega;
	protected $tiene;

	function __construct() {
	}

	public function altaSolicitud($id_prod, $cantsolicita, $fecha_solicitud) { 
		$sql_maxid = "select MAX(id_solicitud) as maxid from modista_solicita_producto;";
		$res_maxid = mysql_query($sql_maxid) or die(mysql_error());
		$row_maxid = mysql_fetch_array($res_maxid);
		$nvoid = $row_maxid['maxid']+1;
		$id_mod = $_SESSION['id'];
		echo $sql = "insert into modista_solicita_producto values ($nvoid, $id_prod, $id_mod, $cantsolicita, '$fecha_solicitud', '', 0);";
		$res = mysql_query($sql) or die(mysql_error());
		if ($res) {
			return true;
		} else {
			return false;
		}
	}

	public function anularSolicitud($id_solicitud){
		$sql = "delete from modista_solicita_producto where id_solicitud = $id_solicitud;";
		$res = mysql_query($sql) or die(mysql_error());
		echo "<br>res: ".$res."<br>";
		if ($res) {
			return true;
		} else { return false; 
		}
	}

	public function mostrar_solicitudes_pendientes($id)  {
		$user = new modista();
		$modista = $user->loginmodista($id);
		
		$user = new aux_admin();
		$aux_admin = $user->loginauxadmin($id);

		if ($aux_admin) {
			$sql = "select u.nombre as modnombre, u.apellido as modapellido, msp.fecha_solicitud as fecha_solicitud, msp.fecha_entrega as fecha_entrega, p.nombre as prodnombre, msp.cantidad as cant, msp.id_solicitud as id_solicitud, p.unidad as unidad, msp.tiene as tiene, p.id_prod as id_prod
					from modista m, modista_solicita_producto msp, producto p, usuario u
					where u.id = m.id_mod and msp.id_prod = p.id_prod and msp.id_mod = m.id_mod and (fecha_entrega = '' or fecha_entrega = '0000-00-00') and p.cantstock >= msp.cantidad
					order by fecha_solicitud;";
		} elseif ($modista) {
			$sql = "select u.nombre as modnombre, u.apellido as modapellido, msp.fecha_solicitud as fecha_solicitud, msp.fecha_entrega as fecha_entrega, p.nombre as prodnombre, msp.cantidad as cant, msp.id_solicitud as id_solicitud, p.unidad as unidad, msp.tiene as tiene, p.id_prod as id_prod
					from modista m, modista_solicita_producto msp, producto p, usuario u
					where u.id = m.id_mod and msp.id_prod = p.id_prod and msp.id_mod = m.id_mod and (fecha_entrega = '' or fecha_entrega = '0000-00-00') and p.cantstock >= msp.cantidad and m.id_mod = $id
					order by fecha_solicitud;";
		}
		$res = mysql_query($sql) or die (mysql_error());
		$num_rows = mysql_num_rows($res); 
		if ($num_rows > 0) { 
			if ($aux_admin) { ?> 
				<tr><td colspan="5"><strong>SOLICITUDES DE STOCK DE MODISTAS:</strong></td></tr><?php
			} elseif ($modista) { ?>
				<tr><td colspan="5"><strong>SUS SOLICITUDES DE STOCK (Pendientes de entrega):</strong></td></tr><?php
			} ?>
			<tr align="center"><td>FECHA SOLICITUD</td>
				<td>PRODUCTO</td> <?php
			if ($aux_admin) { ?>
				<td>MODISTA</td>
				<td colspan="2">CANT. QUE SOLICITA</td> <?php
			} elseif ($modista) { ?>
				<td colspan="3">CANT. QUE SOLICITA</td> <?php 
			}	?>
			</tr> <?php 
		} else { 
			if ($aux_admin) { ?> 
				<tr><td colspan="5"><strong> NO HAY SOLICITUDES PENDIENTES DE MODISTAS.</strong></td></tr> <?php
			} elseif ($modista) { ?>
				<tr><td colspan="5"><strong> NO TIENE SOLICITUDES PENDIENTES.</strong></td></tr> <?php
			}
		} 
		while ($row = mysql_fetch_array($res)) { ?>
			<form name="cargarstock" method="post" action="solicitudes_modistas.php">
				<input type="hidden" name="id_solicitud" value="<?php echo $row['id_solicitud']; ?>">
				<input type="hidden" name="cant" value="<?php echo $row['cant']; ?>">
				<input type="hidden" name="id_prod" value="<?php echo $row['id_prod']; ?>">
				<tr align="center">
					<td><?php echo $row['fecha_solicitud']; ?></td>
					<td><?php echo $row['prodnombre']; ?></td> <?php
					if ($aux_admin) { ?>
					<td><?php echo $row['modapellido']." ".$row['modnombre']; ?></td> <?php 
					} ?>
					<td><?php echo $row['cant']." ".$row['unidad']." "; ?></td>
					<?php 
					if ($aux_admin) { ?>
						<td><input value="ENVIADO A MODISTA" type="submit" name="enviado_a_modista" /> </td>	<?php
					} elseif ($modista) { ?>
						<td><input value="ANULAR" type="submit" name="anularsolicitud" /></td>
						<td><input value="MODIFICAR" type="submit" name="modifsolicitud" /></td> <?php
					}  ?>
				</tr>
			</form> 
			<?php 
		} 
	}

	public function cargar_fecha_entrega($id_solic, $cantidad, $id_producto){
			$fecha_entrega = getaniomesfecha();
			echo "funcion cargar_fecha_entrega ".$id_solicitud = $id_solic;
			echo $cant = $cantidad;
			echo $id_prod = $id_producto;

			$sql_update = "update modista_solicita_producto set 
			fecha_entrega='$fecha_entrega'
			where id_solicitud=$id_solicitud";
			$res_update = mysql_query($sql_update) or die (mysql_error());

			$sql_descontar_prod = "update producto set
			cantstock = cantstock - $cant
			where id_prod = $id_prod";
			$res_descontar_prod = mysql_query($sql_descontar_prod) or die (mysql_error());
			echo "<script>window.location.href = \"menu_aux.php\"</script>";
	}

	function __destruct() {
	}

}


