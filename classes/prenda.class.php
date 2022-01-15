<?php

class Prenda {

	protected $id;
	protected $nombre;
	protected $descripcion;
	protected $precio;
	protected $fechaIniCreacion;
	protected $fechaFinCreacion;
	protected $fechaVenta;
	protected $id_modista;
	
	public function __construct() {	}
	
	public function altaPrenda ($nombre, $descripcion, $precio){
		$prodxprenda = false;
		//cargo los datos en la tabla prenda
		$sql = "select MAX(id) as maxid from prenda;";
		$res = mysql_query($sql) or die (mysql_error());
		$maxid = mysql_fetch_array($res); 
		$nvoidprenda = $maxid['maxid']+1;
		$fechainicreacion = date("Y")."-".date("m")."-".date("d");
		$sql_insert = "insert into prenda (id, nombre, descripcion, precio, fechainicreacion) values ($nvoidprenda, '$nombre', '$descripcion', $precio, '$fechainicreacion')";
		if($res_insert = mysql_query($sql_insert) or die (mysql_error())){
			$idprenda = $nvoidprenda;
		} else { $idprenda = null;}
		return $idprenda;
	}

	public function modifPrenda ($id, $nombre, $descripcion, $precio, $fechaIniCreacion, $fechaFinCreacion, $fechaVenta, $id_modista, $modif){
		if ($modif) {
			$sql = "update prenda set 
			id_mod = $id_modista,
			nombre = '$nombre',
			descripcion = '$descripcion',
			precio = $precio,
			fechainicreacion = '$fechaIniCreacion',
			fechafincreacion = '$fechaFinCreacion',
			fechaventa = '$fechaVenta'
			where id = $id;";
			echo "<script languaje=javascript>alert ('$sql');</script> ";
			$res = mysql_query($sql) or die (mysql_error());
		} else {	?>
		<table align="center" border="1">
		<tr><td>
		<table align="center">
		<tr align="center" ><td colspan="3"><strong>GESTI&OacuteN DISE&NtildeADORA</strong></td></tr>
		<tr align="center"><td colspan="3"><strong>MODIFICAR PRENDA (* Obligatorios)</strong></td></tr>
		<form name="modificarprenda" method="post" action="diseModifPrenda.php">
			<input type="hidden" name="id_prenda" value="<?php echo $id; ?>">
			<tr><td>* Nombre de la Prenda</td><td><input required="" type="text" name="nombre" maxlength="50" />Anterior: <?php echo $nombre; ?></td></tr>
			<tr><td>* Descripci&oacuten</td><td><input required="" type="text" name="descripcion" maxlength="50" />Anterior: <?php echo $descripcion; ?></td></tr>
			<tr><td>* Precio</td><td><input required="" type="number" min="1" name="precio" />Precio anterior: <?php echo $precio; ?></td></tr>
			<tr><td>Fecha inicio de confecci&oacuten</td><td><input type="date" name="fechainicreacion" value="<?php echo $fechaIniCreacion; ?>"></td></tr>
			<tr><td>Fecha fin de confecci&oacuten</td><td><input type="date" name="fechafincreacion" value="<?php echo $fechaFinCreacion; ?>"></td></tr>
			<tr><td>Fecha de venta</td><td><input type="date" name="fechaventa" value="<?php echo $fechaVenta; ?>"></td></tr>
			<tr><td>Modista</td><td>
				<select name="mod"> <?php
				$sql = "select m.id_mod as id_mod, u.nombre as nombre, u.apellido as apellido
						from modista m, usuario u
						where m.id_mod = u.id
						order by apellido, nombre;";
				$res = mysql_query($sql) or die (mysql_error());
					while ($result = mysql_fetch_array($res)) { ?>
						<option value="<?php echo $result['id_mod']; ?>"><?php echo $result['apellido']." ".$result['nombre']; ?></option>
						<?php
					} ?>
				</select></td>
			</tr>
			<tr><td align="center"><br><strong>Materiales para confecci&oacuten</strong></td>
				<td align="center"><br><strong>Stock</strong></td>
				<td align="left"><br><strong>Cantidad **</strong></td></tr>
			<?php 
			$obj = new producto();
			$obj->listaproductosmodif($id); ?>
			<tr><td colspan="3"><FONT SIZE=2>** Si la cantidad solicitada supera el stock, el Sistema SI.GE.A. notificar&aacute a la Auxiliar Administrativa.</FONT></td></tr>
			<tr align="center"><td colspan="3"><input type="submit" name="modifPrenda" value="Modificar Prenda" /></td></tr>
		</form>
		<?php
		}
	}

	public function bajaPrenda ($id){
		$sql_inc_prod = "delete from prenda_incluye_prod where id ='".$id."';";
		$res = mysql_query($sql_inc_prod) or die (mysql_error());
		$sql_prenda = "delete from prenda where id ='".$id."';";
		$res = mysql_query($sql_prenda) or die (mysql_error());
		echo "<script languaje=javascript>alert ('Prenda eliminada correctamente.');</script> "; 
		echo "<script>window.location.href = \"menu_dise.php\"</script>";
	}
	public function mostrar ($id){
		
	}
	public function buscarxcriterio($busqueda, $criterio){ ?>
		<table align="center" border="1">
		<tr align="center" ><td colspan="8"><strong>GESTI&OacuteN DISE&NtildeADORA</strong></td></tr>
		<tr align="center"><td colspan="8"><strong>BUSCAR PRENDA POR NOMBRE</strong></td></tr>
		<tr align="center"><td><strong>Nombre</strong></td>
			<td><strong>Descripci&oacute;n</strong></td>
			<td><strong>Precio</strong></td>
			<td><strong>Fecha Inicio Creaci&oacute;n</strong></td>
			<td><strong>Fecha Fin Creaci&oacute;n</strong></td>
			<td><strong>Fecha Venta</strong></td>
			<td colspan="2"><strong>Acciones</strong></td>
		</tr>
		<?php
		$sql = "select * from prenda where $criterio like '%$busqueda%';";
		$res = mysql_query($sql) or die (mysql_error());
		while ($result = mysql_fetch_array($res)) { ?>
			<form action="diseBuscaPrenda.php" method="POST" name="buscarxcriterio" >
				<tr><td><?php echo $result["nombre"]; ?></td>
				<td><?php echo $result["descripcion"]; ?></td>
				<td><?php echo $result["precio"]; ?></td>
				<td><?php echo $result["fechainicreacion"]; ?></td>
				<td><?php 
				if ($result["fechafincreacion"] = '0000-00-00') {
				 	$fechafincreacion = "";
				 } else { $fechafincreacion = $result["fechafincreacion"]; } ?></td>
				<td><?php echo $fechafincreacion; ?></td>
				<input type="hidden" name="id" value="<?php echo $result["id"]; ?>" />
				<input type="hidden" name="nombre" value="<?php echo $result["nombre"]; ?>" />
				<input type="hidden" name="descripcion" value="<?php echo $result["descripcion"]; ?>" />
				<input type="hidden" name="precio" value="<?php echo $result["precio"]; ?>" />
				<input type="hidden" name="fechainicreacion" value="<?php echo $result["fechainicreacion"]; ?>" />
				<input type="hidden" name="fechafincreacion" value="<?php echo $result["fechafincreacion"]; ?>" />
				<input type="hidden" name="fechaventa" value="<?php echo $result["fechaventa"]; ?>" />
				<input type="hidden" name="id_mod" value="<?php echo $result["id_mod"]; ?>" />
				<td><input name="borrar" value="Borrar" type="submit" /></td>
				<td><input name="modif" value="Modificar" type="submit" /></td>
				</tr>
			</form>
			<?php
		} ?>
		</table>
		<?php
	}
	public function buscarxprecios($precio1, $precio2) { ?>
		<table align="center" border="1">
		<tr align="center" ><td colspan="8"><strong>GESTI&OacuteN DISE&NtildeADORA</strong></td></tr>
		<tr align="center"><td colspan="8"><strong>BUSCAR PRENDA POR PRECIOS</strong></td></tr>
		<tr align="center"><td><strong>Nombre</strong></td>
			<td><strong>Descripci&oacute;n</strong></td>
			<td><strong>Precio</strong></td>
			<td><strong>Fecha Inicio Creaci&oacute;n</strong></td>
			<td><strong>Fecha Fin Creaci&oacute;n</strong></td>
			<td><strong>Fecha Venta</strong></td>
			<td colspan="2"><strong>Acciones</strong></td>
		</tr>
		<?php
		if ($precio1 > $precio2) {
			$aux = $precio1;
			$precio1 = $precio2;
			$precio2 = $aux;
		}
		$sql = "select * from prenda where precio >= $precio1 and precio <= $precio2;";
		$res = mysql_query($sql) or die (mysql_error());
		while ($result = mysql_fetch_array($res)) { ?>
			<form action="diseBuscaPrenda.php" method="POST" name="buscarxcriterio" >
				<tr><td><?php echo $result["nombre"]; ?></td>
				<td><?php echo $result["descripcion"]; ?></td>
				<td><?php echo $result["precio"]; ?></td>
				<td><?php echo $result["fechainicreacion"]; ?></td>
				<td><?php if ($result["fechafincreacion"] = '0000-00-00') {
				 	$fechafincreacion = "";
				 } else { $fechafincreacion = $result["fechafincreacion"]; } 
				 echo $fechafincreacion; ?></td>
				<td><?php if ($result["fechaventa"] = '0000-00-00') {
				 	$fechaventa = "";
				 } else { $fechaventa = $result["fechaventa"]; }
				 echo $fechaventa; ?></td>
				<input type="hidden" name="id" value="<?php echo $result["id"]; ?>" />
				<input type="hidden" name="nombre" value="<?php echo $result["nombre"]; ?>" />
				<input type="hidden" name="descripcion" value="<?php echo $result["descripcion"]; ?>" />
				<input type="hidden" name="precio" value="<?php echo $result["precio"]; ?>" />
				<input type="hidden" name="fechainicreacion" value="<?php echo $result["fechainicreacion"]; ?>" />
				<input type="hidden" name="fechafincreacion" value="<?php echo $result["fechafincreacion"]; ?>" />
				<input type="hidden" name="fechaventa" value="<?php echo $result["fechaventa"]; ?>" />
				<input type="hidden" name="id_mod" value="<?php echo $result["id_mod"]; ?>" />
				<td><input name="borrar" value="Borrar" type="submit" /></td>
				<td><input name="modif" value="Modificar" type="submit" /></td>
				</tr>
			</form>
			<?php
		} ?>
		</table>
		<?php
	}
	public function buscarentrefechas ($fecha1, $fecha2, $crea_o_venta){ ?>
		<table align="center" border="1">
		<tr align="center" ><td colspan="8"><strong>GESTI&OacuteN DISE&NtildeADORA</strong></td></tr>
		<tr align="center"><td colspan="8"><strong>BUSCAR PRENDA</strong></td></tr>
		<tr align="center"><td><strong>Nombre</strong></td>
			<td><strong>Descripci&oacute;n</strong></td>
			<td><strong>Precio</strong></td>
			<td><strong>Fecha Inicio Creaci&oacute;n</strong></td>
			<td><strong>Fecha Fin Creaci&oacute;n</strong></td>
			<td><strong>Fecha Venta</strong></td>
			<td colspan="2"><strong>Acciones</strong></td>
		</tr>
		<?php
		$sql = "select * from prenda where $crea_o_venta >= '".$fecha1."' and $crea_o_venta <= '".$fecha2."';";
		$res = mysql_query($sql) or die (mysql_error());
		while ($result = mysql_fetch_array($res)) { ?>
			<form action="diseBuscaPrenda.php" method="POST" name="borraomodif" >
				<tr><td><?php echo $result["nombre"]; ?></td>
				<td><?php echo $result["descripcion"]; ?></td>
				<td><?php echo $result["precio"]; ?></td>
				<td><?php echo $result["fechainicreacion"]; ?></td>
				<td><?php if ($result["fechafincreacion"] = '0000-00-00') {
				 	$fechafincreacion = "";
				 } else { $fechafincreacion = $result["fechafincreacion"]; } ?></td>
				<td><?php echo $fechafincreacion; ?></td>
				<td><?php echo $result["fechaventa"]; ?></td>
				<input type="hidden" name="id" value="<?php echo $result["id"]; ?>" />
				<input type="hidden" name="nombre" value="<?php echo $result["nombre"]; ?>" />
				<input type="hidden" name="descripcion" value="<?php echo $result["descripcion"]; ?>" />
				<input type="hidden" name="precio" value="<?php echo $result["precio"]; ?>" />
				<input type="hidden" name="fechainicreacion" value="<?php echo $result["fechainicreacion"]; ?>" />
				<input type="hidden" name="fechafincreacion" value="<?php echo $result["fechafincreacion"]; ?>" />
				<input type="hidden" name="fechaventa" value="<?php echo $result["fechaventa"]; ?>" />
				<input type="hidden" name="id_mod" value="<?php echo $result["id_mod"]; ?>" />
				<td><input name="borrar" value="Borrar" type="submit" /></td>
				<td><input name="modif" value="Modificar" type="submit" /></td>
				</tr>
			</form>
			<?php
		} ?>
		</table>
		<?php
	}
}
?>