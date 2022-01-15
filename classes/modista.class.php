<?php

class Modista extends Usuario 
{
	private $id_mod;
	
	function __construct()
	{
		
	}

	function loginModista ($id){
		$sqlmod = "select * from modista where id_mod='$id';";
		$resmod = mysql_query($sqlmod);
		if (mysql_num_rows($resmod)>0) {
			$datomod = mysql_fetch_array($resmod);
			if($datomod['id_mod'] == $_SESSION['id']){ 
				return true;
			} else {
				return false;
			}
		}
	}
	
	function agregarDirMaq (){
		
	}
	
	function modifDatos(){

	}

	function borrarDatos (){

	}

	function mostrar ($id){
		
	}

	public function prendasenconfeccion($id) {
		$user = new modista();
		$modista = $user->loginmodista($id);

		$user = new aux_admin();
		$aux_admin = $user->loginauxadmin($id);

		if ($aux_admin) {
			$sql = "select p.id as id_prenda, p.id_mod as id_mod, p.nombre as nom_prenda, p.descripcion as desc_prenda, p.fechainicreacion as fechainicreacion, u.nombre as nom_modista, u.apellido as ape_modista, p.fechafincreacion as fechafincreacion
			from modista m, prenda p, usuario u
			where p.id_mod = m.id_mod and u.id = m.id_mod and (fecharetiro = '' or fecharetiro = '0000-00-00')
			order by fechainicreacion;";
		} else if ($modista) {
			$sql = "select p.id as id_prenda, p.id_mod as id_mod, p.nombre as nom_prenda, p.descripcion as desc_prenda, p.fechainicreacion as fechainicreacion
			from modista m, prenda p 
			where p.id_mod = m.id_mod and m.id_mod = $id and (fechafincreacion = '' or fechafincreacion = '0000-00-00') and (fecharetiro = '' or fecharetiro = '0000-00-00')
			order by fechainicreacion;";
		}
		$res = mysql_query($sql) or die(mysql_error());
		$num_rows = mysql_num_rows($res);
		if ($num_rows > 0) { 
			if ($aux_admin) { ?>
				<tr><td colspan="5"><strong>PRENDAS EN CONFECCI&Oacute;N:</strong></td></tr>
				<tr align="center">
					<td colspan="3">PRENDA</td><td rowspan="2">MODISTA</td><td rowspan="2">ESTADO</td>
				</tr>
				<tr align="center">
					<td>NOMBRE</td>
					<td>DESCRIPCI&Oacute;N</td>
					<td>INICIO DE CONFECCI&Oacute;N</td>
				</tr> <?php
			} elseif ($modista) {?>
				<tr><td colspan="5"><strong>SUS PRENDAS EN CONFECCI&Oacute;N:</strong></td></tr>
				<tr align="center">
					<td colspan="3">PRENDA</td><td rowspan="2" colspan="2">AVISAR A ADMINISTRACI&Oacute;N</td>
				</tr>
				<tr align="center">
					<td>NOMBRE</td>
					<td>DESCRIPCI&Oacute;N</td>
					<td>INICIO DE CONFECCI&Oacute;N</td>
				</tr> <?php
			}	
			while ($row = mysql_fetch_array($res)) { ?>
				<form action="prendalista.php" method="post" name="prendalista">
					<input type="hidden" name="id_mod" value="<?php echo $row['id_mod']; ?>">
					<input type="hidden" name="id_prenda" value="<?php echo $row['id_prenda']; ?>">
					<tr>
						<td><?php echo $row['nom_prenda']; ?></td>
						<td><?php echo $row['desc_prenda']; ?></td>
						<td align="center"><?php echo $row['fechainicreacion']; ?></td> <?php 
						if ($aux_admin) { ?>
							<td> <?php 
							echo $row['nom_modista']." ".$row['ape_modista']; ?> </td> <?php
							$id_prenda = $row['id_prenda'];
							$sql_fecha = "select fechafincreacion from prenda where id = $id_prenda;";
							$res_fecha = mysql_query($sql_fecha) or die(mysql_error());
							$row_fecha = mysql_fetch_array($res_fecha);
							if (($row['fechafincreacion'] != '') and ($row['fechafincreacion'] != '0000-00-00')) { ?>
								<td><input type="submit" name="adminretiraprenda" value="LISTA PARA RETIRAR"></td> <?php
							} else { ?>
								<td>En confecci&oacute;n</td> <?php
							}
						} elseif ($modista) {?>
							<td colspan="2"><input type="submit" name="modterminaprenda" value="LISTO PARA RETIRAR"></td>
							<?php
						} ?>
						</td>
					</tr>
				</form>
				<?php
			}
			
		} else { ?> 
			<tr><td colspan="5"><strong> NO HAY PRENDAS EN CONFECCI&Oacute;N.</strong></td></tr> <?php
		}
	}

	public function modista_termina_prenda ($id_prenda,$fechahoy) {
		$sql_update = "update prenda set fechafincreacion = '$fechahoy'
		where id = $id_prenda";
		$res_update = mysql_query($sql_update) or die (mysql_error());

		$sql_select = "select fechafincreacion from prenda where id = $id_prenda;";
		$res_select = mysql_query($sql_select) or die(mysql_error());
		$row_select = mysql_fetch_array($res_select);

		if ($row_select['fechafincreacion'] = $fechahoy) {
			echo "<script languaje=javascript>alert ('La Administacion vera esta prenda como lista para retirar.');</script> "; 
		} else {
			echo "<script languaje=javascript>alert ('No se pudo cargar la fecha de fin de confecci&oacute;n de la prenda.');</script> "; 
		}
		echo "<script>window.location.href = \"menu_mod.php\"</script>";
	}

	function __destruct()
	{
		
	}
}