<?php

date_default_timezone_set('America/Buenos_Aires');

if (isset($_POST['cerrarsesion'])) {
	$_SESSION['usuario_autentificado'] = false;
	unset($_SESSION['user']);
	unset($_SESSION['pass']);
	unset($_SESSION['id']);
	echo "<script>window.location.href = \"index.php\"</script>";
}

function fecha()
{
$anio = date("Y"); 
$mes = date("m"); 
$solo_fecha = date("d"); 
echo "Hoy es ".$solo_fecha."-".$mes."-".$anio;
}

function getaniomesfecha()
{
$fecha = date("Y")."-".date("m")."-".date("d"); 
return $fecha;
}

function solofecha()
{
$anio = date("Y"); 
$mes = date("m"); 
$solo_fecha = date("d"); 
echo $solo_fecha."-".$mes."-".$anio;
}

function validar_fecha($dia, $mes, $anio)
{
	$resp = false;
	$anio_actual = date("Y");
	$anio_min = $anio_actual - 7;
	$anio_max = $anio_actual;
	
	if (is_numeric($dia))
	{
		if (is_numeric($mes))
		{
			if (is_numeric($anio))
			{
				if (($anio>=$anio_min) and ($anio<=$anio_max))
				{
					if (($mes>=1) and ($mes<=12))
					{
						if (($mes==1) or ($mes==3) or ($mes==5) or ($mes==7) or ($mes==8) or ($mes==10) or ($mes==12))
						{
							if (($dia>=1) and ($dia<=31))
							{
							$resp = true;
							}
						}
						else
						if (($mes==4) or ($mes==6) or ($mes==9) or ($mes==11))
						{
							if (($dia>=1) and ($dia<=30))
							{
							$resp = true;
							}
						}
						if ($mes==2)
						{
							if (($anio==2012) or ($anio==2008) or ($anio==2016))
							{
								if (($dia>=1) and ($dia<=29))
								{
								$resp = true;
								}
							}
							else 
							{
								if (($dia>=1) and ($dia<=28))
								{
								$resp = true;
								}
							}
						}
					}
				}
			}
		}
	}
return $resp;
}

function fecha_en_blanco($dia, $mes, $anio)
{ $resp=false;
		if (
			($dia=="") or 
			($mes=="") or 
			($anio==""))
		{$resp=true;
		}
return $resp;
}

function selecnumeros() { ?>
	<select name="num"> <?php
		for($i=1;$i<1001;$i++) { ?>
			<option value="<?php echo $i; ?>"><?php echo $i; ?></option> <?php
		} ?>
	</select> <?php
}

function variabletraealgo($variable){
	$permitidos = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789-_";
	$trae = false;
	for ($i=0; $i<strlen($variable); $i++){
		if (strpos($permitidos, substr($variable,$i,1))){
			$trae = true;
		}
	}
	return $trae;
}

function botoncerrarsesion() {
	?>
	<form action="index.php" method="post" name="cerrarsesion">
		<td>
		<input name="cerrarsesion" value="Cerrar Sesion" type="submit" />
		</td>
	</form>
	<?php
}

function botonvolvermenudise() { ?>
	<form action="menu_dise.php" method="post" name="volvermenu">
		<td>
		<input name="volvermenu" value="Volver al Menu" type="submit" />
		</td>
	</form>
	<?php
}

function botonvolvermenuaux() { ?>
	<form action="menu_aux.php" method="post" name="volvermenu">
		<td>
		<input name="volvermenu" value="Volver al Menu" type="submit" />
		</td>
	</form>
	<?php
}

function botonagregarproducto() { ?>
	<form action="menu_aux.php" method="post" name="agregarproducto">
		<td>
		<input name="agregarproducto" value="Producto" type="submit" />
		</td>
	</form>	<?php
} 

function botonbuscarprenda () { ?>
	<form action="diseBuscaPrenda.php" method="post" name="buscaPrenda">
		<td>
		<input name="buscaPrenda" value="Buscar Prenda" type="submit" />
		</td>
	</form>	<?php
}

function botonsolicitarstock () { ?>
	<form action="menu_mod.php" method="post" name="solicitarstock">
		<td>
		<input name="solicitarstock" value="Solicitar Stock" type="submit" />
		</td>
	</form>	<?php
}

function botonmodistas () { ?>
	<form action="menu_mod.php" method="post" name="solicitarstock">
		<td>
		<input name="solicitarstock" value="Modistas" type="submit" />
		</td>
	</form>	<?php
}

function botondisenadoras () { ?>
	<form action="menu_mod.php" method="post" name="solicitarstock">
		<td>
		<input name="solicitarstock" value="Dise&ntilde;adoras" type="submit" />
		</td>
	</form>	<?php
}

function botonusuarios () { ?>
	<form action="menu_mod.php" method="post" name="solicitarstock">
		<td>
		<input name="solicitarstock" value="Usuarios" type="submit" />
		</td>
	</form>	<?php
}
?>

</body>
</html>
