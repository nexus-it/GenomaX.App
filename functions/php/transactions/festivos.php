<?php

include '00trnsctns.php';

	$NumDia=0;
	$SQL="Delete From czfestivos Where month(DiaFest_FST)='".$_POST["mes"]."' and year(DiaFest_FST)='".$_POST["anyo"]."'";
	EjecutarSQL($SQL, $conexion);
	while (UltimoDia($_POST["anyo"], $_POST["mes"]) > $NumDia) {
		$NumDia++;
		$checa=$_POST["dia".$NumDia];
		if (($checa=="1")&&(date("w", mktime(0, 0, 0, $_POST["mes"], $NumDia, $_POST["anyo"]))!=0)) {
			$SQL="Insert Into czfestivos(DiaFest_FST) Values('".$_POST["anyo"]."-".$_POST["mes"]."-".$NumDia."')";
			$MSG=$SQL;
			EjecutarSQL($SQL, $conexion);
		}
	}

	it_aud('2', 'Festivos', 'Mes '.$_POST["mes"].' - Año '.$_POST["anyo"]);

include '99trnsctns.php';

?>