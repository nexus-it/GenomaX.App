<?php
session_start();
if(!isset($_SESSION["usu_codigo"]))
	{
	header('Location: turnosmes-login.php');
	}
else
	{
	if ($_SESSION["usu_nivel"]!='0')
		{
		$SQL="Select CodArea, CodEmpre From TurnosEmple Where CodEmple='".$_SESSION["usu_codigo"]."'";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		if ($row=mysqli_fetch_array($result)) {
			header('Location: turnosmes-view.php?txt_anyo='.date("Y").'&cmb_mes='.date("m").'&cmb_areas='.$row[0].'&codempre='.$row[1]);
		}
		mysqli_free_result($result);
		}
	}	
error_reporting(E_ALL ^ E_NOTICE);
function UltimoDia($anho,$mes){
   if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) {
       $dias_febrero = 29;
   } else {
       $dias_febrero = 28;
   }
   switch($mes) {
       case 1: return 31; break;
       case 2: return $dias_febrero; break;
       case 3: return 31; break;
       case 4: return 30; break;
       case 5: return 31; break;
       case 6: return 30; break;
       case 7: return 31; break;
       case 8: return 31; break;
       case 9: return 30; break;
       case 10: return 31; break;
       case 11: return 30; break;
       case 12: return 31; break;
   }
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Tarjeta Personal</title>
<style type="text/css">
<!--
body {
	background-image: url(images/background.jpg);
}
.logo {	left: 10px;
	top: 5px;
	position: absolute;
}
.Estilo2 {	font-size: 11px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #333333;
}
.EstiloR {
font-size: 11px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #990000;
}
.EstiloA {
	overflow: auto;
	width: 99%;
	height: 100px;
}
.Estilo19 {font-size: 9px; font-weight: bold; font-family: Arial, Helvetica, sans-serif; }
.Estilo20 {font-family: Arial, Helvetica, sans-serif}
.Estilo21 {font-size: 9px; font-family: Arial, Helvetica, sans-serif; }
-->
</style>
<script language="javascript">
</script>
</head>
<body>
<form action="" method="post" name="frm_turnos" id="frm_turnos">
    <?php
	$SQL="Select CodEmple From TurnosEmple Where CodArea='".$_GET["cmb_area"]."' and estadoemple='1';";
	include "functions/conectar.php";
	$rst_tarj=mysql_query($SQL);
	while($rtarj=mysqli_fetch_array($rst_tarj)) 
	{
?>
  <p>
  <table border="1" align="left" cellpadding="0" cellspacing="0" class="Estilo2">
    <tr>
      <td colspan="14" align="center" valign="middle"><span class="Estilo19"><?php 
	  $SQL="Select NomEmpre, NitEmpre, NomEmple + ' ' + ApeEmple, CargoEmple From TurnosEmpre R, TurnosEmple L where R.CodEmpre=L.CodEmpre and CodEmple='".$rtarj[0]."';";
	  $CurDay='';
   	  
	  $result = mysqli_query( $conexion, $SQL);
	  if($row=mysqli_fetch_array($result)) 
	    {
		echo $row[0];
	  ?></span></td>
    </tr>
    <tr>
      <td colspan="14" align="center" valign="middle"><span class="Estilo19">NIT <?php echo $row[1]; ?></span></td>
    </tr>
    <tr>
      <td colspan="14" align="center" valign="middle"><span class="Estilo19">TARJETA PERSONAL</span></td>
    </tr>
    <tr>
      <td colspan="14" valign="middle"><span class="Estilo19">NOMBRE:</span> <?php echo $row[2]; ?></td>
    </tr>
    <tr>
      <td height="39" colspan="8" valign="middle"><span class="Estilo19">CARGO:</span> <?php echo $row[3]; ?></td>
	  <?php
	    }
   	  mysqli_free_result($result);
	  ?>	  
      <td colspan="6" valign="middle"><span class="Estilo19">MES</span>
      <?php
  if ($_GET["cmb_mes"]=="01") echo "ENERO";
  if ($_GET["cmb_mes"]=="02") echo "FEBRERO";
  if ($_GET["cmb_mes"]=="03") echo "MARZO";
  if ($_GET["cmb_mes"]=="04") echo "ABRIL";
  if ($_GET["cmb_mes"]=="05") echo "MAYO";
  if ($_GET["cmb_mes"]=="06") echo "JUNIO";
  if ($_GET["cmb_mes"]=="07") echo "JULIO";
  if ($_GET["cmb_mes"]=="08") echo "AGOSTO";
  if ($_GET["cmb_mes"]=="09") echo "SEPTIEMBRE";
  if ($_GET["cmb_mes"]=="10") echo "OCTUBRE";
  if ($_GET["cmb_mes"]=="11") echo "NOVIEMBRE";
  if ($_GET["cmb_mes"]=="12") echo "DICIEMBRE";
  
  
  $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and month(FechaTurno)='".$_GET["cmb_mes"]."' and year(FechaTurno)='".$_GET["txt_anyo"]."'";
  mysql_query($SQL); 
  ?></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center"><span class="Estilo21">REGAR</span></td>
      <td colspan="2" align="center"><span class="Estilo21">H.E ORDINARIAS</span></td>
      <td align="center"><span class="Estilo21">TRABAJ</span></td>
      <td colspan="2" align="center"><span class="Estilo21">H.E DY F</span></td>
      <td align="center">&nbsp;</td>
      <td align="center"><span class="Estilo21">REGAR</span></td>
      <td colspan="2" align="center"><span class="Estilo21">H.E ORDINARIAS</span></td>
      <td align="center"><span class="Estilo21">TRABAJ</span></td>
      <td colspan="2" align="center"><span class="Estilo21">H.E DY F</span></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td align="center"><span class="Estilo21">NOCT</span></td>
      <td align="center"><span class="Estilo21">DIURNA</span></td>
      <td align="center"><span class="Estilo21">NOCT</span></td>
      <td align="center"><span class="Estilo21">D Y F</span></td>
      <td align="center"><span class="Estilo21">DIUR</span></td>
      <td align="center"><span class="Estilo21">NOC</span></td>
      <td align="center">&nbsp;</td>
      <td align="center"><span class="Estilo21">NOCT</span></td>
      <td align="center"><span class="Estilo21">DIURNA</span></td>
      <td align="center"><span class="Estilo21">NOCT</span></td>
      <td align="center"><span class="Estilo21">D Y F</span></td>
      <td align="center"><span class="Estilo21">DIUR</span></td>
      <td align="center"><span class="Estilo21">NOC</span></td>
    </tr>
    <tr>
    <?php $CurDay='1'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {
		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				/*if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}*/
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
			if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='17'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='2'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='18'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='3'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='19'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='4'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='20'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='5'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {
		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			if (($row[2] > $row[3])||($row[4] > $row[5])) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[3];
					}
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					mysqli_free_result($result1);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
				}
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='21'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='6'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='22'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='7'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='23'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='8'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='24'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='9'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='25'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='10'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='26'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='11'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='27'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='12'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='28'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='13'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='29'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='14'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='30'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
	  $HorasFest=0;
	  $HorasDesc=0;
	//CALCULO DE HORAS DE LOS FESTIVOS
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2
	Where  T1.fecha in (Select DIAFEST from TurnosFest where month(diafest)='".$_GET["cmb_mes"]."' and year(diafest)='".$_GET["txt_anyo"]."') and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA=(DateAdd(d, -1 ,T1.fecha)) and T2.CodTurno=H2.CodTurno ";
	$result1=mysql_query($SQL);
	while($row2=mysqli_fetch_array($result1)) {
		if ($row2[4] > $row2[5]) {
			$HorasFest = $HorasFest + $row2[5];
		}
		if ($row2[2] > $row2[3]) {
			$HorasFest = $HorasFest + (24 - $row2[2]);
		}
		else
		{
			$HorasFest = $HorasFest + ($row2[3] - $row2[2]);
		}
	}
	mysqli_free_result($result1);
	//CALCULO DE LOS DESCANSOS
	  $SQL="SELECT sum(DescansoTurno) From TurnosHoras H, Turnos T, TurnosEmple E Where H.CodTurno=T.CodTurno and E.CodEmple=T.CodEmple and E.CodEmple='".$rtarj[0]."' and month(Fecha)='".$_GET["cmb_mes"]."' and year(Fecha)='".$_GET["txt_anyo"]."'
	  and fecha not in (Select DIAFEST from TurnosFest where month(diafest)='".$_GET["cmb_mes"]."' and year(diafest)='".$_GET["txt_anyo"]."')";
	$result1=mysql_query($SQL);
	if($row2=mysqli_fetch_array($result1)) {
		$HorasDesc = $row2[0];
	}
	mysqli_free_result($result1);
	//TOTALIZAR
	$NumHoras = $NumHoras - ($HorasFest + $HorasDesc);
			
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				if (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])== 30) {
					mysql_query($SQL);
				}
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
				if (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])== 30) {
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
				}
				else {
					echo '
					<td align="center">&nbsp;</td>
					';
				}
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='15'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])== 30) {
					if ($row[2] > $row[3]) {
						if ($row[2] >=$row1[1]) {
							$NumHoras=24 - $row[2];
						}
						else {
							$NumHoras=24 - $row1[1];
						}
						if ($row[3] >=$row1[2]) {
							$NumHoras=$NumHoras + $row1[2];
						}
						else {
							$NumHoras=$NumHoras + $row[3];
						}
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    <?php $CurDay='31'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])== 31) {
					if ($row[2] > $row[3]) {
						if ($row[2] >=$row1[1]) {
							$NumHoras=24 - $row[2];
						}
						else {
							$NumHoras=24 - $row1[1];
						}
						if ($row[3] >=$row1[2]) {
							$NumHoras=$NumHoras + $row1[2];
						}
						else {
							$NumHoras=$NumHoras + $row[3];
						}
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
	  $HorasFest=0;
	  $HorasDesc=0;
	//CALCULO DE HORAS DE LOS FESTIVOS
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2
	Where  T1.fecha in (Select DIAFEST from TurnosFest where month(diafest)='".$_GET["cmb_mes"]."' and year(diafest)='".$_GET["txt_anyo"]."') and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA=(DateAdd(d, -1 ,T1.fecha)) and T2.CodTurno=H2.CodTurno ";
	$result1=mysql_query($SQL);
	while($row2=mysqli_fetch_array($result1)) {
		if ($row2[4] > $row2[5]) {
			$HorasFest = $HorasFest + $row2[5];
		}
		if ($row2[2] > $row2[3]) {
			$HorasFest = $HorasFest + (24 - $row2[2]);
		}
		else
		{
			$HorasFest = $HorasFest + ($row2[3] - $row2[2]);
		}
	}
	mysqli_free_result($result1);
	//CALCULO DE LOS DESCANSOS
	  $SQL="SELECT sum(DescansoTurno) From TurnosHoras H, Turnos T, TurnosEmple E Where H.CodTurno=T.CodTurno and E.CodEmple=T.CodEmple and E.CodEmple='".$rtarj[0]."' and month(Fecha)='".$_GET["cmb_mes"]."' and year(Fecha)='".$_GET["txt_anyo"]."'
	  and fecha not in (Select DIAFEST from TurnosFest where month(diafest)='".$_GET["cmb_mes"]."' and year(diafest)='".$_GET["txt_anyo"]."')";
	$result1=mysql_query($SQL);
	if($row2=mysqli_fetch_array($result1)) {
		$HorasDesc = $row2[0];
	}
	mysqli_free_result($result1);
	//TOTALIZAR
	$NumHoras = $NumHoras - ($HorasFest + $HorasDesc);
			
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				if (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])== 31) {
					mysql_query($SQL);
				}
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
				if (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])== 31) {
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
				}
				else {
					echo '
					<td align="center">&nbsp;</td>
					';
				}
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
    </tr>
    <tr>
    <?php $CurDay='16'; ?>
      <td align="center"><span class="Estilo21"><strong><?php echo $CurDay; ?></strong></span></td>
<?php
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, H2.IniTurno, H2.FinTurno,
	(SalarioEmple/HorasEmple) as ValorHora,
	R01.EstadoRecArea as '01', R02.EstadoRecArea as '02', R03.EstadoRecArea as '03', R04.EstadoRecArea as '04', R05.EstadoRecArea as '05', R06.EstadoRecArea as '06'
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2, TurnosEmple E, TurnosRecAreas R01, TurnosRecAreas R02, TurnosRecAreas R03, TurnosRecAreas R04, TurnosRecAreas R05, TurnosRecAreas R06
	Where  T1.fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and T1.CodEmple='".$rtarj[0]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA='".date("j/m/Y",strtotime($_GET["txt_anyo"]."-".$_GET["cmb_mes"]."-".$CurDay." - 1 day"))."' and T2.CodTurno=H2.CodTurno 
	and E.CodEmple=T1.CodEmple and E.CodArea=R01.CodArea and R01.CodRecargo='01'
	and E.CodArea=R02.CodArea and R02.CodRecargo='02' and E.CodArea=R03.CodArea and R03.CodRecargo='03'
	and E.CodArea=R04.CodArea and R04.CodRecargo='04' and E.CodArea=R05.CodArea and R05.CodRecargo='05'
	and E.CodArea=R06.CodArea and R06.CodRecargo='06'";

	$result = mysqli_query( $conexion, $SQL);
	$NumHoras=0;
	$ValorHora=0;
	if ($row=mysqli_fetch_array($result)) {		//CALCULO DE HORAS NOCTURNAS
		if ($row[8]=='1') {
			$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='02'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				if ($row[2] > $row[3]) {
					if ($row[2] >=$row1[1]) {
						$NumHoras=24 - $row[2];
					}
					else {
						$NumHoras=24 - $row1[1];
					}
				}
				if ($row[4] > $row[5]) {
					if ($row[5] >=$row1[2]) {
						$NumHoras=$NumHoras + $row1[2];
					}
					else {
						$NumHoras=$NumHoras + $row[5];
					}
				}
				if ($row[3] >= $row1[1]) { //Para cuando el turno no cambia de dia
					if ($row[2] > $row1[1]) {
						$NumHoras=$NumHoras + ($row[3]-$row[2]);
					}
					else {
						$NumHoras=$NumHoras + ($row[3]-$row1[1]);
					}
				}
				if ($row1[2] >= $row[4]) { //Para cuando el turno no cambia de dia
					if ($row[5] > $row1[2]) {
						$NumHoras=$NumHoras + ($row1[2]-$row[4]);
					}
					else {
						$NumHoras=$NumHoras + ($row[5]-$row[4]);
					}
				}
			}
if ($NumHoras > 0) {
$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					';
			}
			else {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. DIURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//CALCULO DE H.E. NOCTURNAS
		if ($row[9]=='1') {
			$SQL="Select PorcRecargo, sum(HorasTurno-DescansoTurno) From TurnosRecargos, Turnos T, TurnosHoras H Where CodRecargo='03' and T.CodTurno=H.CodTurno and month(T.Fecha)='".$_GET["cmb_mes"]."' and year(T.Fecha)='".$_GET["txt_anyo"]."' and CodEmple='".$rtarj[0]."' group by PorcRecargo";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$ValorHora=$row1[0]*$row[6];
				$NumHoras=$row1[1];
			}
			mysqli_free_result($result1);
			$NumDia=0;
			$totalh=0;
			while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
				$NumDia++;
				$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				$result1=mysql_query($SQL);
				if(!($row1=mysqli_fetch_array($result1))) {
					if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
					{
						$totalh++;
					}
				}
				mysqli_free_result($result1);
			}
			$NumHoras= $NumHoras - ($totalh*8);
			if ($NumHoras > 0) {
				$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='03' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
//					mysql_query($SQL);
				$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '03', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
//					mysql_query($SQL);
//					echo '
//					<td align="center">'.$NumHoras.'</td>
//					';
				echo '
				<td align="center">&nbsp;</td>
				';
			}
			else {
				echo '
				<td align="center">&nbsp;</td>
				';
			}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}		//CALCULO DE D Y F
		$NumHoras=0;
		$dyf=0;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		$result1=mysql_query($SQL);
		if(($row1=mysqli_fetch_array($result1))) {
			$dyf=1;
		}
		else {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $CurDay, $_GET["txt_anyo"]))==0) {
				$dyf=1;
			}
		}
		mysqli_free_result($result1);
		if (($row[7]=='1')&&($dyf==1)) {
			if ($row[4] > $row[5]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + $row[5];
					mysqli_free_result($result1);
					/* $SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='02' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '02', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					echo '
					<td align="center">'.$NumHoras.'</td>
					'; */
				}
			}
			if ($row[2] > $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + (24 - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($row[2] <= $row[3]) {
				$SQL="Select PorcRecargo, HoraIniRecargo, HoraFinRecargo From TurnosRecargos Where CodRecargo='01'";
				$result1=mysql_query($SQL);
				if ($row1=mysqli_fetch_array($result1)) {
					$ValorHora=$row1[0]*$row[6];
					$NumHoras=$NumHoras + ($row[3] - $row[2]);
					mysqli_free_result($result1);
					$SQL="Delete From TurnosLiq Where CodEmple='".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
					mysql_query($SQL);
					$SQL="Insert into TurnosLiq(CodEmple, CodRecargo, FechaTurno, HorasLiq, ValorLiq) Values('".$rtarj[0]."', '01', '".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."', ".$NumHoras.", ".$ValorHora.")";
					mysql_query($SQL);
					
				}
			}
			if ($NumHoras==0) {
				echo '
				  <td align="center">&nbsp;</td>
				  ';
			}
else {
			$SQL="Select descansoturno from turnos T, turnoshoras H where H.codturno=T.codturno and estadoturno='1' and codemple='".$rtarj[0]."' and fecha='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);
			if ($row1=mysqli_fetch_array($result1)) {
				$NumHoras=$NumHoras - $row1[0];
			}
			mysqli_free_result($result1);
			$SQL="Update TurnosLiq Set HorasLiq= ".$NumHoras." Where CodEmple= '".$rtarj[0]."' and CodRecargo='01' and FechaTurno='".$CurDay."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			mysql_query($SQL);
				echo '
				  <td align="center">'.$NumHoras.'</td>
				  ';
}
		}
		else {
			echo '
			  <td align="center">&nbsp;</td>
			  ';
		}
		//H.E. D Y F
		echo '
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  ';
	}
	else
	{
	echo '
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
	';
	}
	mysqli_free_result($result);
	
?>      
      <td align="center"><span class="Estilo21"><strong>T</strong></span></td>
      <?php 
	  $SQL="Select isnull(sum(HorasLiq), 0) From TurnosLiq Where CodEmple='".$rtarj[0]."' and month(FechaTurno)='".$_GET["cmb_mes"]."' and year(FechaTurno)='".$_GET["txt_anyo"]."' and CodRecargo='02'";
	  
	  $result = mysqli_query( $conexion, $SQL);
	  if ($row=mysqli_fetch_array($result)) {
	  	echo '<td align="center">'.$row[0].'</td>';
	  }
	  else {
	  	echo '<td align="center">&nbsp;</td>';
	  }
	  mysqli_free_result($result);
	  
	  $SQL="Select isnull(sum(HorasLiq), 0) From TurnosLiq Where CodEmple='".$rtarj[0]."' and month(FechaTurno)='".$_GET["cmb_mes"]."' and year(FechaTurno)='".$_GET["txt_anyo"]."' and CodRecargo='03'";
	  
	  $result = mysqli_query( $conexion, $SQL);
	  if ($row=mysqli_fetch_array($result)) {
	  	echo '<td align="center">'.$row[0].'</td>';
	  }
	  else {
	  	echo '<td align="center">&nbsp;</td>';
	  }
	  mysqli_free_result($result);
	  
	  $SQL="Select isnull(sum(HorasLiq), 0) From TurnosLiq Where CodEmple='".$rtarj[0]."' and month(FechaTurno)='".$_GET["cmb_mes"]."' and year(FechaTurno)='".$_GET["txt_anyo"]."' and CodRecargo='04'";
	  
	  $result = mysqli_query( $conexion, $SQL);
	  if ($row=mysqli_fetch_array($result)) {
	  	echo '<td align="center">'.$row[0].'</td>';
	  }
	  else {
	  	echo '<td align="center">&nbsp;</td>';
	  }
	  mysqli_free_result($result);
	  
	  $SQL="Select isnull(sum(HorasLiq), 0) From TurnosLiq Where CodEmple='".$rtarj[0]."' and month(FechaTurno)='".$_GET["cmb_mes"]."' and year(FechaTurno)='".$_GET["txt_anyo"]."' and CodRecargo='01'";
	  
	  $result = mysqli_query( $conexion, $SQL);
	  if ($row=mysqli_fetch_array($result)) {
	  	echo '<td align="center">'.$row[0].'</td>';
	  }
	  else {
	  	echo '<td align="center">&nbsp;</td>';
	  }
	  mysqli_free_result($result);
	  
	  $SQL="Select isnull(sum(HorasLiq), 0) From TurnosLiq Where CodEmple='".$rtarj[0]."' and month(FechaTurno)='".$_GET["cmb_mes"]."' and year(FechaTurno)='".$_GET["txt_anyo"]."' and CodRecargo='05'";
	  
	  $result = mysqli_query( $conexion, $SQL);
	  if ($row=mysqli_fetch_array($result)) {
	  	echo '<td align="center">'.$row[0].'</td>';
	  }
	  else {
	  	echo '<td align="center">&nbsp;</td>';
	  }
	  mysqli_free_result($result);
	  
	  $SQL="Select isnull(sum(HorasLiq), 0) From TurnosLiq Where CodEmple='".$rtarj[0]."' and month(FechaTurno)='".$_GET["cmb_mes"]."' and year(FechaTurno)='".$_GET["txt_anyo"]."' and CodRecargo='06'";
	  
	  $result = mysqli_query( $conexion, $SQL);
	  if ($row=mysqli_fetch_array($result)) {
	  	echo '<td align="center">'.$row[0].'</td>';
	  }
	  else {
	  	echo '<td align="center">&nbsp;</td>';
	  }
	  mysqli_free_result($result);
	  
	  ?>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center"><span class="Estilo21">35%</span></td>
      <td align="center"><span class="Estilo21">125%</span></td>
      <td align="center"><span class="Estilo21">175%</span></td>
      <td align="center"><span class="Estilo21">1.75%</span></td>
      <td align="center"><span class="Estilo21">2.00%</span></td>
      <td align="center"><span class="Estilo21">2.5%</span></td>
    </tr>
    <tr>
      <td height="40" colspan="14" valign="top"><span class="Estilo21"><strong>NOVEDADES:
      </strong> </span>        <hr align="right" width="85%" size="1" /></td>
    </tr>
    <tr>
      <td height="20" colspan="14" align="center">&nbsp;</td>
    </tr>
  </table> </p>
  <?php 
  }
  
  mysqli_free_result($rst_tarj);
  mysql_close($conectID); 
  ?>
</form>
</body>
</html>
