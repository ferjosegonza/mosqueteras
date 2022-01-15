<?php
session_start();
include "includes/myAutoloader.inc.php";
include "conexion.php";
conectar();

global $esmodista;global $esauxadmin;global $esdisenadora; 

if (conectar())
{
	$user = $_POST['user'];
	$pass = $_POST['pass'];
	$sql = "select * from usuario where user='$user' and pass='$pass';";
	$res = mysql_query($sql);
	if (mysql_num_rows($res)>0)
	{
		$dato = mysql_fetch_array($res);
		if(isset($dato["user"])){ 
			$_SESSION['usuario_autentificado'] = true;
			$_SESSION['user'] = $dato['user'];//declaramos una variable de tipo sesion
			$_SESSION['pass'] = $dato['pass'];	
			$_SESSION['id'] = $dato['id'];
			$r=session_id();
		}
	}
	else
	{
		$_SESSION['usuario_autentificado'] = false;
		unset ($_SESSION['user']);
		unset ($_SESSION['pass']);
		echo "<script languaje=javascript> alert (\"Usuario o Contraseña incorrecta\")</script>";
		echo "<script>window.location.href = \"index.php\"</script>";
	}
	if ($_SESSION['usuario_autentificado']) {
		$esauxadmin = false;
		$esdisenadora = false;
		$esmodista = false;
		$id = $_SESSION['id'];
		
		$auxadmin = new Aux_admin();
		if ($auxadmin->loginAuxAdmin ($id)) {	
			$esauxadmin = true;
			echo "<script>window.location.href = \"menu_aux.php\"</script>";
		}

		$disenadora = new disenadora();
		if ($disenadora->loginDise ($id)) {
			$esdisenadora = true;
			echo "<script>window.location.href = \"menu_dise.php\"</script>";
		}

		$modista = new modista();
		if ($modista->loginModista ($id)) {
			$esmodista = true;
			echo "<script>window.location.href = \"menu_mod.php\"</script>";			
		}
	}
} 
else 
{ 
	echo " <script languaje=javascript>alert ('No pudo conectarse a la base de datos.');</script> "; 
	echo "<script>window.location.href = \"index.php\"</script>";
}
?>
</body>
</html>
