<?php

class proveedor 
{
	private $id_proveedor;
	private $nombre_prov;

	function __construct() {
	}

	public function altaProveedor(){}
	public function bajaProveedor(){}
	public function modifProveedor(){}
	
	public function listarproveedores ($id_prod) {
		$sql = "select pdor.id_proveedor as id_prod, pdor.nombre_prov as nombre_prov
		from proveedor pdor, provee pve
		where pdor.id_proveedor = pve.id_proveedor and pve.id_prod = $id_prod
		order by pdor.nombre_prov;";
		$res = mysql_query($sql) or die (mysql_error()); ?>
		<select name="proveedor"> <?php
		while ($row = mysql_fetch_array($res)) { ?>
			<option value="<?php echo $row['id_prod']; ?>">
			<?php echo $row['nombre_prov']; ?>
			</option>	<?php
		}	?>	
		</select> <?php
	}
}
?>