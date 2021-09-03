<?php
session_start();
if(!isset($_SESSION["usu_codigo"]))
	{
	header('Location: turnosmes-login.php');
	}
else
	{
	if (($_SESSION["usu_nivel"]!='0') && (!(isset($_GET["codempre"]))))
		{
		$SQL="Select CodArea, CodEmpre From TurnosEmple Where CodEmple='".$_SESSION["usu_codigo"]."'";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		if ($row=mysqli_fetch_array($result)) {
			header('Location: turnosmes-view.php?txt_anyo='.date("Y").'&cmb_mes='.date("m").'&cmb_areas='.$row[0].'&codempre='.$row[1]);
		}
		//include "functions/desconectar.php";
		}
	}	
function UltimoDia($anho,$mes){
   if (((fmod($anho,4)==0) and (fmod($anho,100)!=0)) or (fmod($anho,400)==0)) {
       $dias_febrero = 29;
   } else {
       $dias_febrero = 28;
   }
   switch($mes) {
       case '01': return '31'; break;
       case '02': return $dias_febrero; break;
       case '03': return '31'; break;
       case '04': return '30'; break;
       case '05': return '31'; break;
       case '06': return '30'; break;
       case '07': return '31'; break;
       case '08': return '31'; break;
       case '09': return '30'; break;
       case '10': return '31'; break;
       case '11': return '30'; break;
       case '12': return '31'; break;
   }
} 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PROGRAMACION DE HORARIOS</title>
<style type="text/css">
<!--
body {
	background-image: url(images/background.jpg);
}
.logo {	left: 10px;
	top: 5px;
	position: absolute;
}
.Estilo5 {	font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 14px;
	color: #333333;
}
.Estilo9 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333333;
}
.EstiloC {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #333333;
	border: 1px solid #000000;
}
.EstiloT {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 10px;
	color: #222222;
	text-align: center;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	text-transform: uppercase;
}
.EstiloR {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #990000;
	text-align: center;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	text-transform: uppercase;
}
.EstiloT1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #222222;
	font-weight: bold;
	text-align: center;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	text-transform: uppercase;
}
.EstiloR1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #990000;
	font-weight: bold;
	text-align: center;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	text-transform: uppercase;
}
.Estilo12 {color: #FFFFFF}
.Estilo13 {font-family: Arial, Helvetica, sans-serif; font-size: 11px; color: #FFFFFF; font-weight: bold; }
.EstiloT3 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	color: #222222;
	font-weight: normal;
	text-align: left;
	border-top-width: 0px;
	border-right-width: 0px;
	border-bottom-width: 0px;
	border-left-width: 0px;
	border-top-style: none;
	border-right-style: none;
	border-bottom-style: none;
	border-left-style: none;
	background-image: url(images/background.jpg);
}
-->
</style>
<script language="javascript">
function mostrardiv() {
div = document.getElementById('DivBHE');
if (div.style.display == 'none') {
	div.style.display = '';
	}
	else {
	div.style.display = 'none';
	}
}
<?PHP 
	if (isset($_GET["codempre"])) {
?>
function guardartodo() {
<?PHP 
	//$turnotxt="";
//	$SQL="SELECT E.CodEmple FROM TurnosEmple E WHERE E.CodArea='".$_GET["cmb_areas"]."' AND CodEmpre='".$_GET["codempre"]."' and EstadoEmple='1'";
//	include "functions/conectar.php";
//	$result = mysqli_query( $conexion, $SQL);
//	while ($row=mysqli_fetch_array($result)) {
//		$i=1;
//		while ($i<=UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])) {
//			$turnotxt=$turnotxt."&txt_dia".$i."_".$row[0].="+txt_dia".$i."_".$row[0];
//			$i++;
//		}	
//	}
//	//include "functions/desconectar.php";
	//echo 'window.open("turnosmes-asig2.php?txt_anyo='.$_GET["txt_anyo"].'&cmb_mes='.$_GET["cmb_mes"].'&cmb_areas='.$_GET["cmb_areas"].'&codempre='.$_GET["codempre"].'&txt_observaciones="+txt_observaciones.value+"'.$turnotxt.');';
?>
}
<?PHP 
	}
?>
function inicio() {
div = document.getElementById('DivBHE');
div.style.display = 'none';
}
function abrirconf(opcion) {
	if (opcion.value!='00') {
		param=opcion.value;
		if (opcion.value=="05") {
			var fecha=new Date();
			var mes=fecha.getMonth()+2;
			var anyo=fecha.getYear();
			if (anyo < 1000) anyo+=1900;
			param=param+"&elmes="+mes+"&elanyo="+anyo;
		}
		window.open("turnosmes-conf.php?opcion="+param, "_blank", "toolbar=no,menubar=no,directories=no,status=no,resizable=no,location=no,scrollbars=no,height=480,width=610");
	}
}
function traerempresa(combo){
	
}
</script>
</head>
<body>
<?php
$rutalogo="";
$razonsocial="";
$nit="";
if (isset($_GET["codempre"]))
{
	$SQL="Select LogoEmpre, RazonEmpre, NitEmpre From TurnosEmpre Where CodEmpre='".$_GET["codempre"]."'";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	if($row=mysqli_fetch_array($result)) {
		$rutalogo=$row[0];
		$razonsocial=$row[1];
		$nit=$row[2];
	}
	//include "functions/desconectar.php";
	echo '<img src="'.$rutalogo.'" class="logo" />';
}
?>
<div align="center" class="Estilo5">
  <p><?php
  if ($rutalogo=="") echo ':: PROGRAMACION DE HORARIOS ::';
  else echo $razonsocial.'<br><span class="Estilo6">NIT '.$nit.'</span>';
?></p>
  <p><?php
  if ($rutalogo=="") echo '&nbsp;';
  else echo 'FORMATO ÚNICO PARA ELABORACIÓN Y ENTREGA<br>DE PROGRAMACIÓN DE HORARIOS';
?></p>
</div>
<form action="" method="get" name="frm_horario" id="frm_horario">
  <input name="txt_anyo" type="hidden" id="txt_anyo" value="<?php echo $_GET["txt_anyo"]; ?>" />
  <input name="cmb_mes" type="hidden" id="cmb_mes" value="<?php echo $_GET["cmb_mes"]; ?>" />
  <input name="cmb_areas" type="hidden" id="cmb_areas" value="<?php echo $_GET["cmb_areas"]; ?>" />
  <?php
  if ($rutalogo=="")
  {
  	$totalempre=0;
  	$SQL="Select count (distinct CodEmpre) From TurnosEmple Where CodArea='".$_GET["cmb_areas"]."'";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	if($row=mysqli_fetch_array($result)) {
	  	$totalempre=$row[0];
	}
	//include "functions/desconectar.php";
	if ($totalempre>1)
		{
  ?>
  <table width="60%" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td width="50%" align="right" class="Estilo9">EMPRESA: </td>
      <td align="left"><select name="codempre" class="Estilo9" id="codempre" onchange="document.frm_horario.submit()">
	  <option value="00">-- Seleccione Una --</option>
<?php
  	$SQL="Select distinct E.CodEmpre, M.NomEmpre From TurnosEmple E, TurnosEmpre M Where E.CodArea='".$_GET["cmb_areas"]."' and E.CodEmpre=M.CodEmpre;";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	while ($row=mysqli_fetch_array($result)) {
?>
        <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
<?php
	}
	//include "functions/desconectar.php";
?>
      </select>
      </td>
    </tr>
  </table>
  <?php
	}
	else
	{
  	$SQL="Select distinct CodEmpre From TurnosEmple Where CodArea='".$_GET["cmb_areas"]."';";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	while ($row=mysqli_fetch_array($result)) {
  ?>
  <input name="codempre" type="hidden" id="codempre" value="<?php echo $row[0]; ?>" />
<?php
	}
	//include "functions/desconectar.php";
?>
  <script language="javascript">
  	document.frm_horario.submit();
  </script>
  <?php
	}
  }
  else
  {
$SQL="SELECT E.CodEmple FROM TurnosEmple E WHERE E.CodArea='".$_GET["cmb_areas"]."' AND CodEmpre='".$_GET["codempre"]."' and EstadoEmple='1'";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	while ($row=mysqli_fetch_array($result)) {
		$SQL="Select * from Turnos Where CodEmple='".$row[0]."' and year(fecha)='".$_GET["txt_anyo"]."' and month(fecha)='".$_GET["cmb_mes"]."'";
		$result1=mysql_query($SQL);
		if (!($row1=mysqli_fetch_array($result1))) {
			$i=1;
			while ($i<=UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])) {
				$SQL="Insert into Turnos(CodEmple, CodTurno, Fecha) Values('".$row[0]."', '25','".$i."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."')";
				mysql_query($SQL);
				$i++;
			}
		}
	}
	//include "functions/desconectar.php";
	$SQL="Select * from TurnosObs where  CodArea='".$_GET["cmb_areas"]."' and CodEmpre='".$_GET["codempre"]."' and MesAnyo='".$_GET["cmb_mes"]."-".$_GET["txt_anyo"]."'";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	if (!($row=mysqli_fetch_array($result))) {
		$SQL="Insert into TurnosObs(CodArea, CodEmpre, MesAnyo) Values('".$_GET["cmb_areas"]."' ,'".$_GET["codempre"]."','".$_GET["cmb_mes"]."-".$_GET["txt_anyo"]."')";
		mysql_query($SQL);
	}
	//include "functions/desconectar.php";
	
	if (isset($_GET["txt_observaciones"])) {
		$SQL="SELECT E.CodEmple FROM TurnosEmple E WHERE E.CodArea='".$_GET["cmb_areas"]."' AND CodEmpre='".$_GET["codempre"]."' and EstadoEmple='1'";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		while ($row=mysqli_fetch_array($result)) {
			$i=1;
			while ($i<=UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])) {
				$SQL="Update Turnos
				Set CodTurno='".$_GET["txt_dia_".$i.'_'.rtrim($row[0])]."'
				Where CodEmple='".$row[0]."' and Fecha='".$i."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
				mysql_query($SQL);
				$i++;
			}
		}
		$SQL="Update TurnosObs Set Observaciones='".$_GET["txt_observaciones"]."' Where CodArea='".$_GET["cmb_areas"]."' and CodEmpre='".$_GET["codempre"]."' and MesAnyo='".$_GET["cmb_mes"]."-".$_GET["txt_anyo"]."'";
		mysql_query($SQL);
		//include "functions/desconectar.php";
	}
	
  $SQL="Select NomArea, E1.NomEmple + ' ' + E1.ApeEmple From TurnosAreas A, TurnosEmple E1 Where A.CoordArea=E1.CodEmple and A.CodArea='".$_GET["cmb_areas"]."';";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	if($row=mysqli_fetch_array($result)) {
  ?>
  <table width="99%" border="0" align="center" cellpadding="3" cellspacing="3" class="Estilo9">
    <tr>
      <td width="200" align="left">AREA O DEPARTAMENTO:</td>
      <td align="left"><?php echo $row[0]; ?></td>
      <td align="right">MES: 
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
  ?>      </td>
      <td width="15%" align="left">A&Ntilde;O: <?php echo $_GET["txt_anyo"]; ?></td>
    </tr>
    <tr>
      <td align="left">COORDINADOR(A) DE AREA:</td>
      <td align="left"><?php echo $row[1]; ?></td>
<?php
	}
	//include "functions/desconectar.php";
?>	  
      <td align="right">HORAS ORDINARIAS:</td>
      <td align="left"><?php
	  $NumDia=0;
	  $totalh=0;
	  while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
	    $NumDia++;
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		if(!($row=mysqli_fetch_array($result))) {
			if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))!=0) 
			{
				$totalh++;
			}
		}
		//include "functions/desconectar.php";
	  }
	  echo ($totalh*8);
	  ?></td>
    </tr>
  </table>
  <table width="100%" border="1" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td rowspan="2" align="center" valign="middle"><span class="EstiloT1"> ASOCIADO </span></td>
  <?php
  	$Weekday="";
	$Colorday="";
	$NumDia=0;
	while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
	$NumDia++;
	?>
    <td align="center" valign="bottom"><?php
	$Colorday="2";
	$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	if($row=mysqli_fetch_array($result)) {
		$Colorday="R";
	}
	else
	{
		$Colorday="T";
	}
	//include "functions/desconectar.php";
	if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))==1) $Weekday= "Lu";
	if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))==2) $Weekday= "Ma";
	if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))==3) $Weekday= "Mi";
	if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))==4) $Weekday= "Ju";
	if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))==5) $Weekday= "Vi";
	if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))==6) $Weekday= "Sa";
	if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))==0) 
	{
		$Weekday= "Do";
		$Colorday="R";
	}
	echo '<span class="Estilo'.$Colorday.'1">'.$Weekday.'</span>';
	?></td>
	<?php
	
	}
	?>
  </tr>
  <tr>
  <?php
  	$Weekday="";
	$Colorday="";
	$NumDia=0;
	while (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
	$NumDia++;
	$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	if($row=mysqli_fetch_array($result)) {
		$Colorday="R1";
	}
	else
	{
		$Colorday="T";
		if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))==0) 
		{
			$Colorday="R1";
		}
	}
	//include "functions/desconectar.php";
	?>
    <td align="center" valign="middle"><?php echo '<span class="Estilo'.$Colorday.'">'.$NumDia.'</span>'; ?></td>
	<?php
	
	}
	?>
  </tr>
<?php
$SQL="SELECT distinct NomEmple + ' ' + ApeEmple, E.CodEmple FROM TurnosEmple E WHERE E.CodArea='".$_GET["cmb_areas"]."' AND CodEmpre='".$_GET["codempre"]."' and EstadoEmple='1' and ocultaremple='0'";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	while ($row=mysqli_fetch_array($result)) {
?>
  <tr>
    <td align="left"><span class="EstiloT1"> <?php echo $row[0]; ?> </span></td>
<?php
	$SQL="Select rtrim(CodTurno), Fecha, month(fecha), day(Fecha), year(Fecha) From Turnos Where CodEmple='".$row[1]."' and month(Fecha)='".$_GET["cmb_mes"]."' and year(Fecha)='".$_GET["txt_anyo"]."' Order by year(Fecha), month(Fecha), day(Fecha)";
	$result1=mysql_query($SQL);
	while ($row1=mysqli_fetch_array($result1)) {
		$SQL="Select DiaFest From TurnosFest Where DiaFest='".$row1[1]."'";
		$result2=mysql_query($SQL);
		if($row2=mysqli_fetch_array($result2)) {
			$Colorday="R";
		}
		else
		{
			$Colorday="T";
			if (date("w", mktime(0, 0, 0, $row1[2], $row1[3], $row1[4]))==0) 
			{
				$Colorday="R";
			}
		}
		mysqli_free_result($result2);
	?>
    <td align="center" valign="middle">
      <input name="txt_dia_<?php echo $row1[3].'_'.rtrim($row[1]).'"'; ?> type="" id="txt_dia_<?php echo $row1[3].'_'.rtrim($row[1]).'" class="Estilo'.$Colorday.'" value="'.$row1[0]; ?>" size="1" maxlength="2" />
      </td>
<?php
	}
	mysqli_free_result($result1);
?>	
  </tr>
<?php
	}
	//include "functions/desconectar.php";
?>
</table>
  <table width="100%"  border="0" align="center" cellpadding="2" cellspacing="2"text100%>
    <tr>
      <td valign="top">
	  <table border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td align="center" bgcolor="#222222"><span class="EstiloT1"><a href="javascript: mostrardiv();"><span class="Estilo12">Tabla de Horarios</span></a></span></td>
  </tr>
  <tr>
    <td><div id="DivBHE" ><table border="1" cellpadding="0" cellspacing="0">
      <tr>
        <th background="images/backfoot.jpg" scope="col"><span class="EstiloT1">C&oacute;digo</span></th>
        <th background="images/backfoot.jpg" scope="col"><span class="EstiloT1">Descripci&oacute;n</span></th>
        <th background="images/backfoot.jpg" scope="col"><span class="EstiloT1">Horas</span></th>
        <th background="images/backfoot.jpg" scope="col"><span class="EstiloT1">Descanso</span></th>
      </tr>
      <?php
  	$SQL="Select Codturno, NomTurno, HorasTurno, DescansoTurno From TurnosHoras Where EstadoTurno='1' order by Initurno, codturno";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	while ($row=mysqli_fetch_array($result)) {
  ?>
      <tr>
        <td><span class="EstiloT1"><?php echo $row[0]; ?></span></td>
        <td><span class="EstiloT"><?php echo $row[1]; ?></span></td>
        <td align="center"><span class="EstiloT"><?php echo $row[2]; ?></span></td>
        <td align="center"><span class="EstiloT">
          <?php if ($row[3]==0) echo '--'; else echo $row[3]; ?>
        </span></td>
      </tr>
      <?php
	}
	//include "functions/desconectar.php";
  ?>
    </table></div></td>
  </tr>
</table>
<script language="javascript"> inicio(); </script>
	  </td>
      <td align="right" valign="top"><table border="0" cellspacing="1" cellpadding="1">
        <tr>
          <th scope="col"><table border="1" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <th align="left" bgcolor="#222222" scope="col"><span class="Estilo13">Observaciones</span></th>
            </tr>
            <tr>
              <td align="left" valign="top"><label>
                <textarea name="txt_observaciones" cols="60" rows="5" wrap="physical" class="EstiloT3" id="txt_observaciones"><?PHP
					if (isset($_GET["txt_observaciones"])) {
						echo $_GET["txt_observaciones"];
					}
				?></textarea>
              </label></td>
            </tr>
          </table></th>
        </tr>
        <tr>
          <td><table border="1" align="right" cellpadding="0" cellspacing="0">
            <tr>
              <td colspan="4" align="center" valign="middle" bgcolor="#222222"><span class="EstiloT1 Estilo12"> Consolidado </span></td>
            </tr>
            <tr>
              <td align="center" valign="middle"><span class="EstiloT1">Asociado</span></td>
              <td align="center" valign="middle"><span class="EstiloT1">Horas/Mes</span></td>
              <td align="center" valign="middle"><span class="EstiloT1">Base H. E.</span></td>
              <td align="center" valign="middle"><span class="EstiloT1">Total H.E.</span></td>
            </tr>
            <?php
$SQL="SELECT distinct NomEmple + ' ' + ApeEmple, E.CodEmple FROM TurnosEmple E, Turnos T WHERE T.CodEmple=E.CodEmple and E.CodArea='".$_GET["cmb_areas"]."' and month(Fecha)='".$_GET["cmb_mes"]."' and year(Fecha)='".$_GET["txt_anyo"]."' AND CodEmpre='".$_GET["codempre"]."' and EstadoEmple='1' and ocultaremple='0'";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	while ($row=mysqli_fetch_array($result)) {
?>
            <tr>
              <td align="left"><span class="EstiloT"><?php echo $row[0]; ?></span></td>
              <td align="right"><span class="EstiloT"><?php 
	  $HorasDesc=0;
	  $SQL="SELECT sum(DescansoTurno) From TurnosHoras H, Turnos T, TurnosEmple E Where H.CodTurno=T.CodTurno and E.CodEmple=T.CodEmple and E.CodEmple='".$row[1]."' and month(Fecha)='".$_GET["cmb_mes"]."' and year(Fecha)='".$_GET["txt_anyo"]."'";
	$result2=mysql_query($SQL);
	if($row2=mysqli_fetch_array($result2)) {
		$HorasDesc = $row2[0];
	}
	mysqli_free_result($result2);
	  $SQL="SELECT sum(HorasTurno) From TurnosHoras H, Turnos T, TurnosEmple E Where H.CodTurno=T.CodTurno and E.CodEmple=T.CodEmple and E.CodEmple='".$row[1]."' and month(Fecha)='".$_GET["cmb_mes"]."' and year(Fecha)='".$_GET["txt_anyo"]."'";
	$result2=mysql_query($SQL);
	if($row2=mysqli_fetch_array($result2)) {
		echo $row2[0] - $HorasDesc;
	}
	mysqli_free_result($result2);
   ?></span></td>
              <td align="right"><span class="EstiloT"><?php 
	  $HorasTotales=0;
	  $HorasFest=0;
	  $HorasDesc=0;
	  $SQL="SELECT sum(HorasTurno) From TurnosHoras H, Turnos T, TurnosEmple E Where H.CodTurno=T.CodTurno and E.CodEmple=T.CodEmple and E.CodEmple='".$row[1]."' and month(Fecha)='".$_GET["cmb_mes"]."' and year(Fecha)='".$_GET["txt_anyo"]."'";
	$result2=mysql_query($SQL);
	if($row2=mysqli_fetch_array($result2)) {
		$HorasTotales = $row2[0];
	}
	mysqli_free_result($result2);
	//CALCULO DE HORAS DE LOS FESTIVOS
	$SQL="Select T1.CodEmple, T1.fecha, H1.IniTurno, H1.FinTurno, CASE DAY(T1.fecha) WHEN '01' THEN '00:00' ELSE H2.IniTurno END, CASE DAY(T1.fecha) WHEN '01' THEN '00:00' ELSE H2.FinTurno END --H2.IniTurno, H2.FinTurno
	From Turnos T1, TurnosHoras H1, Turnos T2, TurnosHoras H2
	Where  T1.fecha in (Select DIAFEST from TurnosFest where month(diafest)='".$_GET["cmb_mes"]."' and year(diafest)='".$_GET["txt_anyo"]."') and T1.CodEmple='".$row[1]."' and T1.CodTurno=H1.CodTurno 
	AND T2.CodEmple=T1.CodEmple AND T2.FECHA=(DateAdd(d, -1 ,T1.fecha)) and T2.CodTurno=H2.CodTurno";
	$result2=mysql_query($SQL);
	while($row2=mysqli_fetch_array($result2)) {
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
	mysqli_free_result($result2);
	//CALCULO DE LOS DESCANSOS
	  $SQL="SELECT sum(DescansoTurno) From TurnosHoras H, Turnos T, TurnosEmple E Where H.CodTurno=T.CodTurno and E.CodEmple=T.CodEmple and E.CodEmple='".$row[1]."' and month(Fecha)='".$_GET["cmb_mes"]."' and year(Fecha)='".$_GET["txt_anyo"]."'
	  and fecha not in (Select DIAFEST from TurnosFest where month(diafest)='".$_GET["cmb_mes"]."' and year(diafest)='".$_GET["txt_anyo"]."')";
	$result2=mysql_query($SQL);
	if($row2=mysqli_fetch_array($result2)) {
		$HorasDesc = $row2[0];
	}
	mysqli_free_result($result2);
	//TOTALIZAR
	$HorasTotales = $HorasTotales - ($HorasFest + $HorasDesc);
	echo $HorasTotales;
   ?></span></td>
              <td align="right"><span class="EstiloT"><?php
	if (($HorasTotales)-($totalh*8)>0) {
		echo ($HorasTotales)-($totalh*8);
	}
	else {
		echo "--";
	}
	?></span></td>
            </tr>
            <?php
	}
	//include "functions/desconectar.php";
?>
          </table></td>
        </tr>
      </table>
      <hr align="right" size="1" noshade="noshade" class="Estilo5" />
      <a href="javascript: document.frm_horario.submit();">
      <input name="codempre" type="hidden" id="codempre" value="<?php echo $_GET["codempre"]; ?>" />
      <img src="images/run.gif" border="0" align="middle" /></a></td>
    </tr>
  </table>
  <?php
  }
  ?>
  <div align="center" >
<?php
  if (isset($_GET["txt_observaciones"])) {
  	echo '  <a href="turnosmes-view.php?txt_anyo='.$_GET["txt_anyo"].'&cmb_mes='.$_GET["cmb_mes"].'&cmb_areas='.$_GET["cmb_areas"].'&codempre='.$_GET["codempre"].'" target="_blank"> <spam class="EstiloT1">Imprimir Horario</spam> </a>
';
  }
?>
</div>
</form>
<a href="turnosmes.php"><img src="images/arrow_2_left_round.gif" width="16" height="16" border="0" align="left" title="&lt;&lt; ATRAS" /></a>
</body>
</html>
