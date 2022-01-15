<?php
class Aux_admin extends Usuario 
{
	protected $id_auxAdmin;

	function __construct()
	{
		
	}

	function loginAuxAdmin ($id){
		$sqlaux = "select * from aux_admin where id_aux='$id';";
		$resaux = mysql_query($sqlaux);
		if (mysql_num_rows($resaux)>0) {	
			$datoaux = mysql_fetch_array($resaux);
			if($datoaux['id_aux'] == $_SESSION['id']) { 
				return true;
			} else {
				return false;
			}
		}
	}
	
	public function mostrar ($id){
		
	}

	public function admin_retira_prenda($id_prenda,$fechahoy) {
		$sql_update = "update prenda set fecharetiro = '$fechahoy'
		where id = $id_prenda";
		$res_update = mysql_query($sql_update) or die(mysql_error());

		$sql_select = "select fecharetiro from prenda where id = $id_prenda;";
		$res_select = mysql_query($sql_select) or die(mysql_error());
		$row_select = mysql_fetch_array($res_select);

		if ($row_select['fecharetiro'] = $fechahoy) {
			echo "<script languaje=javascript>alert ('Prenda lista para la venta.');</script> "; 
		} else {
			echo "<script languaje=javascript>alert ('No se pudo cargar la Prenda como lista para la venta.');</script> "; 
		}
		echo "<script>window.location.href = \"menu_aux.php\"</script>";
	}
	
	function __destruct()
	{
		
	}
}