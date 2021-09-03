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
   }   switch($mes) {
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
}
.EstiloR {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #990000;
}
.EstiloT1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #222222;
	font-weight: bold;
}
.EstiloR1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 11px;
	color: #990000;
	font-weight: bold;
}
.Estilo12 {color: #FFFFFF}
-->
</style>
<script language="javascript">
function mostrardiv() {
div = document.getElementById('DivBHE');
div.style.display = '';
div = document.getElementById('DivShow');
div.style.display='none';
}
function ocultardiv() {
div = document.getElementById('DivBHE');
div.style.display='none';
div = document.getElementById('DivShow');
div.style.display = '';
}
function inicio() {
div = document.getElementById('DivShow');
div.style.display='none';
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
  <p>&nbsp;</p>
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
  ?>
      </td>
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
    <tr>
      <td align="left">DESCRIPCI&Oacute;N DE TURNOS: </td>
      <td colspan="3" align="left"><table border="0" align="left" cellpadding="1" cellspacing="3">
        <tr>
		<?php
		$SQL="Select distinct H.CodTurno, H.NomTurno From TurnosHoras H, Turnos T, TurnosEmple E Where H.CodTurno=T.CodTurno and E.CodArea='".$_GET["cmb_areas"]."' and month(Fecha)='".$_GET["cmb_mes"]."' and year(Fecha)='".$_GET["txt_anyo"]."' and E.CodEmple=T.CodEmple;";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		while ($row=mysqli_fetch_array($result)) {
		?>
          <td><span class="EstiloC"><?php echo $row[0]; ?></span> &middot; <?php echo $row[1]; ?> </td>
          <td>&nbsp;</td>
		<?php
		}
		//include "functions/desconectar.php";
		?>  
        </tr>
      </table></td>
    </tr>
  </table>
  <br><table width="100%" border="1" align="center" cellpadding="0" cellspacing="0" class="EstiloT">
  <tr>
    <td rowspan="2" align="center" valign="middle" class="EstiloT1">ASOCIADO</td>
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
$SQL="SELECT distinct NomEmple + ' ' + ApeEmple, E.CodEmple FROM TurnosEmple E, Turnos T WHERE T.CodEmple=E.CodEmple and E.CodArea='".$_GET["cmb_areas"]."' and month(Fecha)='".$_GET["cmb_mes"]."' and year(Fecha)='".$_GET["txt_anyo"]."' AND CodEmpre='".$_GET["codempre"]."' and EstadoEmple='1' and ocultaremple='0'";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	while ($row=mysqli_fetch_array($result)) {
?>
  <tr>
    <td align="left" class="EstiloT1"><?php echo $row[0]; ?></td>
<?php
	$SQL="Select CodTurno, Fecha, month(fecha), day(Fecha), year(Fecha) From Turnos Where CodEmple='".$row[1]."' and month(Fecha)='".$_GET["cmb_mes"]."' and year(Fecha)='".$_GET["txt_anyo"]."' Order by year(Fecha), month(Fecha), day(Fecha)";
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
    <td align="center" valign="middle"><?php echo '<span class="Estilo'.$Colorday.'">'.$row1[0].'</span>'; ?></td>
<?php
	}
	mysqli_free_result($result1);
?>	
<?php
	}
?>
</table>
<br><table width="90%" border="1" align="right" cellpadding="0" cellspacing="0" bordercolor="#222222" class="EstiloT1">
  <tr>
    <th align="left" bgcolor="#222222" scope="col"><span class="Estilo12">Observaciones:</span></th>
  </tr>
  <tr>
    <td><?PHP 
	$SQL="Select Observaciones from turnosobs where codarea='".$_GET["cmb_areas"]."' and mesanyo='".$_GET["cmb_mes"]."-".$_GET["txt_anyo"]."' and codempre='".$_GET["codempre"]."'";
	$result = mysqli_query( $conexion, $SQL);
	if ($row=mysqli_fetch_array($result)) {
		echo $row[0];
	}
	else {
		echo '&nbsp;';
	}
	//include "functions/desconectar.php";
	?></td>
  </tr>
</table>
<br><br><br><br><br>
  <table width="100%" border="0" align="center" cellpadding="3" cellspacing="5">
    <tr>
      <td width="25%" valign="bottom"><hr /></td>
      <td width="25%" valign="bottom"><hr /></td>
      <td width="25%" valign="bottom"><hr /></td>
      <td width="25%" valign="bottom"><hr /></td>
    </tr>
    <tr>
      <td align="center" valign="top" class="EstiloT">SUB-DIRECCION MEDICO ASISTENCIAL</td>
      <td align="center" valign="top" class="EstiloT">SUB-DIRECCION FINANCIERA ADMINISTRATIVA</td>
      <td align="center" valign="top" class="EstiloT">COORDINACION GESTION HUMANA</td>
      <td align="center" valign="top" class="EstiloT">RECIBIDO DE NOMINA</td>
    </tr>
  </table>
  <?php
  }
  ?>
</form>
<a href="turnosmes.php"><img src="images/arrow_2_left_round.gif" width="16" height="16" border="0" align="left" title="&lt;&lt; ATRAS" /></a>
</body>
</html>
