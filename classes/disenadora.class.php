<?php

class Disenadora extends Usuario 
{
	private $id_dise;

	function __construct()
	{
		
	}

	function loginDise ($id){
		$sqldise = "select * from disenadora where id_dise='$id';";
		$resdise = mysql_query($sqldise);
		if (mysql_num_rows($resdise)>0)	{
			$datodise = mysql_fetch_array($resdise);
			if($datodise['id_dise'] == $_SESSION['id']){
				return true;
			} else {
				return false;
			}
		}
	}

	function cargarVenta (){
		
	}

	function mostrar ($id){
		
	}
	
	function __destruct()
	{
		
	}
}