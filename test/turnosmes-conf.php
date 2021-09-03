<?php
error_reporting(E_ALL ^ E_NOTICE);
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
<title>Configuraci&oacute;n N&oacute;mina</title>
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
	font-size: 18px;
	color: #333333;
}
.Estilo2 {	font-size: 11px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #333333;
}
.Estilo3 {	font-size: 13px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #333333;
	text-align: center;
}
.Estilo6 {
font-family: Verdana, Arial, Helvetica, sans-serif;
	font-weight: bold;
	font-size: 16px;
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
-->
</style>
<script language="javascript">
function buscarcedula() {
	location.href="turnosmes-conf.php?opcion=02&txt_cedula="+document.frm_turnos.txt_cedula.value;
}
function cambioturno(codigo) {
	if (codigo!='0') {
		location.href="turnosmes-conf.php?opcion=<?php
		echo $_GET["opcion"];
		?>&txt_codigo="+codigo;
	}
}
</script>
</head>
<body>
<div align="center" class="Estilo5">
  <p>:: <span class="Estilo6">CONFIGURACION DE <?php
  if ($_GET["opcion"]=="01") echo 'EMPRESAS';
  if ($_GET["opcion"]=="02") echo 'EMPLEADOS';  
  if ($_GET["opcion"]=="03") echo 'TIPOS DE TURNOS';  
  if ($_GET["opcion"]=="04") echo 'AREAS';  
  if ($_GET["opcion"]=="05") echo 'DIAS FESTIVOS';  
  if ($_GET["opcion"]=="06") echo 'RECARGOS';  
  ?></span> ::</p>
  <p>&nbsp;</p>
</div>
<form action="" method="post" name="frm_turnos" id="frm_turnos">
    <?php
  if ($_GET["opcion"]=="01") {
  ?>
    <?php
  }
  if ($_GET["opcion"]=="02") {
	$Existe=0;
  	if (isset($_POST["txt_cedula"]))
	{
		$SQL="Delete From TurnosEmple Where CodEmple='".$_POST["txt_cedula"]."'";
		include "functions/conectar.php";
		mysql_query($SQL);
		mysql_close($conectID); 
		$ocultar='0';
		if ($_POST["chk_ocultar"]=='1') {
			$ocultar='1';
		}
		$SQL="Insert Into TurnosEmple(CodEmple, NomEmple, ApeEmple, CodEmpre, CodArea, HorasEmple, SalarioEmple, EstadoEmple, OcultarEmple) Values('".$_POST["txt_cedula"]."', '".$_POST["txt_nombre"]."', '".$_POST["txt_apellido"]."', '".$_POST["cmb_empresa"]."', '".$_POST["cmb_area"]."', ".$_POST["txt_horas"].", ".$_POST["txt_salario"].", '".$_POST["cmb_estado"]."', '".$ocultar."')";
		include "functions/conectar.php";
		mysql_query($SQL);
		mysql_close($conectID);
		echo '<div class="Estilo3" align="center"><img src="images/accept_green.gif" width="16" height="16" border="0" align="left" /><img src="images/accept_green.gif" width="16" height="16" border="0" align="right" />EMPLEADO GUARDADO CON EXITO!</div>';
	}
  ?>
  <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <td width="20%" align="right" class="Estilo2">DOCUMENTO:</td>
    <td width="30%" align="left" class="Estilo2"><input name="txt_cedula" type="text" class="Estilo2" id="txt_cedula" value="<?php
	if (isset($_GET["txt_cedula"])) 
	{
		echo $_GET["txt_cedula"];
		$SQL="Select EstadoEmple, NomEmple, ApeEmple, CodEmpre, CodArea, HorasEmple, SalarioEmple, OcultarEmple From TurnosEmple Where CodEmple='".$_GET["txt_cedula"]."'";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		if($row=mysqli_fetch_array($result)) {
			$Existe=1;
		}
	}
	?>" size="15" />
      <a href="javascript: buscarcedula()"><img src="images/magnify.png" width="16" height="16" border="0" title="BUSCAR POR CEDULA" /></a></td>
    <td width="20%" align="right" class="Estilo2">ESTADO:</td>
    <td width="30%" align="left" class="Estilo2"><select name="cmb_estado" class="Estilo2" id="cmb_estado">
      <option value="1" <?php
	  if ($Existe==1) {
	  	if ($row[0]=="1") echo 'selected="selected" ';
	  }
	  ?>>ACTIVO</option>
      <option value="0" <?php
	  if ($Existe==1) {
	  	if ($row[0]=="0") echo 'selected="selected" ';
	  }
	  ?>>INACTIVO</option>
    </select>    </td>
  </tr>
  <tr>
    <td align="right" class="Estilo2">NOMBRES:</td>
    <td align="left" class="Estilo2"><input name="txt_nombre" type="text" class="Estilo2" id="txt_nombre" value="<?php
	  if ($Existe==1) {
	  	echo $row[1];
	  }
	  ?>" size="25" /></td>
    <td align="right" class="Estilo2">APELLIDOS:</td>
    <td align="left" class="Estilo2"><input name="txt_apellido" type="text" class="Estilo2" id="txt_apellido" value="<?php
	  if ($Existe==1) {
	  	echo $row[2];
	  }
	  ?>" size="25" /></td>
  </tr>
  <tr>
    <td align="right" class="Estilo2">EMPRESA:</td>
    <td align="left" class="Estilo2"><select name="cmb_empresa" class="Estilo2" id="cmb_empresa">
	<?php
		$SQL="Select CodEmpre, NomEmpre From TurnosEmpre Where EstadoEmpre='1'";
		include "functions/conectar.php";
		$result1=mysql_query($SQL);
		while ($row1=mysqli_fetch_array($result1)) {
			echo '<option value="'.$row1[0].'"';
			if ($Existe==1) {
				if ($row[3]==$row1[0]) echo 'selected="selected"';
			}
			echo '>'.$row1[1].'</option>
			';
		}
		mysqli_free_result($result1);
	?>
    </select></td>
    <td align="right" class="Estilo2">AREA:</td>
    <td align="left" class="Estilo2"><select name="cmb_area" class="Estilo2" id="cmb_area">
	<?php
		$SQL="Select CodArea, NomArea From TurnosAreas Where EstadoArea='1'";
		include "functions/conectar.php";
		$result1=mysql_query($SQL);
		while ($row1=mysqli_fetch_array($result1)) {
			echo '<option value="'.$row1[0].'"';
			if ($Existe==1) {
				if ($row[4]==$row1[0]) echo 'selected="selected"';
			}
			echo '>'.$row1[1].'</option>
			';
		}
		mysqli_free_result($result1);
	?>
    </select></td>
  </tr>
  <tr>
    <td align="right" class="Estilo2">HORAS/MES:</td>
    <td align="left" class="Estilo2"><input name="txt_horas" type="text" class="Estilo2" id="txt_horas" value="<?php
	  if ($Existe==1) {
	  	echo $row[5];
	  }
	  ?>" size="3" maxlength="3" /></td>
    <td align="right" class="Estilo2">SALARIO:</td>
    <td align="left" class="Estilo2"><input name="txt_salario" type="text" class="Estilo2" id="txt_salario" value="<?php
	  if ($Existe==1) {
	  	echo $row[6];
	  }
	  ?>" size="7" maxlength="7" /></td>
	<?php
	if (isset($_GET["txt_cedula"])) 
	{
		//include "functions/desconectar.php";
	}
	?>
  </tr>
  <tr>
    <td align="right" class="Estilo2">&nbsp;</td>
    <td colspan="2" align="right" class="Estilo2">OCULTAR NOMBRE EN TABLA DE HORARIOS: </td>
    <td align="left" class="Estilo2"><label>
      <input name="chk_ocultar" type="checkbox" id="chk_ocultar" value="1" <?php
	  if ($Existe==1) {
	  	if ($row[7]=='1') {
			echo 'checked="checked"';
		}
	  }
	  ?> />
    </label></td>
  </tr>
</table>
  <hr align="center" width="85%" size="1" noshade="noshade" />
  <a href="javascript: document.frm_turnos.submit()">
  <img src="images/run.gif" border="0" align="right" title="GUARDAR DATOS"/>
  </a>
    <?php
  }
  if ($_GET["opcion"]=="03") {
	$Existe=0;
  	if (isset($_POST["txt_codigo"]))
	{
		$SQL="Delete From TurnosHoras Where CodTurno='".$_POST["txt_codigo"]."'";
		include "functions/conectar.php";
		mysql_query($SQL);
		mysql_close($conectID); 
		$SQL="Insert Into TurnosHoras(CodTurno, EstadoTurno, NomTurno, IniTurno, FinTurno, HorasTurno, DescansoTurno) Values('".$_POST["txt_codigo"]."', '".$_POST["cmb_estado"]."', '".$_POST["txt_nombre"]."', '".$_POST["txt_horaini"]."', '".$_POST["txt_horafin"]."', ".$_POST["txt_horas"].", ".$_POST["txt_descanso"].")";
		include "functions/conectar.php";
		mysql_query($SQL);
		mysql_close($conectID);
		echo '<div class="Estilo3" align="center"><img src="images/accept_green.gif" width="16" height="16" border="0" align="left" /><img src="images/accept_green.gif" width="16" height="16" border="0" align="right" />TURNO GUARDADO CON EXITO!</div>';
	}
  ?>
  <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <td width="20%" align="right" class="Estilo2">BUSCAR:</td>
    <td width="30%" align="left" class="Estilo2"><select name="cmb_codigo" class="Estilo2" id="cmb_codigo" onchange="cambioturno(this.value)">
      <option value="0">Seleccione</option>
	<?php
		$SQL="Select CodTurno, NomTurno From TurnosHoras";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		while ($row=mysqli_fetch_array($result)) {
			echo '<option value="'.$row[0].'">'.$row[1].'</option>
			';
		}
		//include "functions/desconectar.php";
	?>
    </select></td>
    <td width="20%" align="right" class="Estilo2">ESTADO:</td>
    <td width="30%" align="left" class="Estilo2"><select name="cmb_estado" class="Estilo2" id="cmb_estado">
	<?php
	if (isset($_GET["txt_codigo"])) 
	{
		$SQL="Select EstadoTurno, NomTurno, IniTurno, FinTurno, HorasTurno, DescansoTurno From TurnosHoras Where CodTurno='".$_GET["txt_codigo"]."'";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		if($row=mysqli_fetch_array($result)) {
			$Existe=1;
		}
	}
	?><option value="1" <?php
	  if ($Existe==1) {
	  	if ($row[0]=="1") echo 'selected="selected" ';
	  }
	  ?>>ACTIVO</option>
      <option value="0" <?php
	  if ($Existe==1) {
	  	if ($row[0]=="0") echo 'selected="selected" ';
	  }
	  ?>>INACTIVO</option>
    </select>    </td>
  </tr>
  <tr>
    <td align="right" class="Estilo2">CODIGO:</td>
    <td align="left" class="Estilo2"><input name="txt_codigo" type="text" class="Estilo2" id="txt_codigo" value="<?php
	  if (isset($_GET["txt_codigo"])) {
	  	echo $_GET["txt_codigo"];
	  }
	  ?>" size="3" />
      <a href="javascript: cambioturno(document.frm_turnos.txt_codigo.value)"><img src="images/magnify.png" width="16" height="16" border="0" align="absmiddle" title="BUSCAR POR CEDULA" /></a></td>
    <td align="right" class="Estilo2">NOMBRE:</td>
    <td align="left" class="Estilo2"><input name="txt_nombre" type="text" class="Estilo2" id="txt_nombre" value="<?php
	  if ($Existe==1) {
	  	echo $row[1];
	  }
	  ?>" size="15" /></td>
  </tr>
  <tr>
    <td align="right" class="Estilo2">HORA INICIAL:</td>
    <td align="left" class="Estilo2"><input name="txt_horaini" type="text" class="Estilo2" id="txt_horaini" value="<?php
	  if ($Existe==1) {
	  	echo $row[2];
	  }
	  ?>" size="5" maxlength="5" /></td>
    <td align="right" class="Estilo2">HORA FINAL:</td>
    <td align="left" class="Estilo2"><input name="txt_horafin" type="text" class="Estilo2" id="txt_horafin" value="<?php
	  if ($Existe==1) {
	  	echo $row[3];
	  }
	  ?>" size="5" maxlength="5" /></td>
  </tr>
  <tr>
    <td align="right" class="Estilo2">HORAS:</td>
    <td align="left" class="Estilo2"><input name="txt_horas" type="text" class="Estilo2" id="txt_horas" value="<?php
	  if ($Existe==1) {
	  	echo $row[4];
	  }
	  ?>" size="5" maxlength="5" /></td>
    <td align="right" class="Estilo2">DESCANSO:</td>
    <td align="left" class="Estilo2"><input name="txt_descanso" type="text" class="Estilo2" id="txt_descanso" value="<?php
	  if ($Existe==1) {
	  	echo $row[5];
	  }
	  ?>" size="5" maxlength="5" /></td>
	<?php
	if (isset($_GET["txt_codigo"])) 
	{
		//include "functions/desconectar.php";
	}
	?>
  </tr>
</table><hr align="center" width="85%" size="1" noshade="noshade" />
  <a href="javascript: document.frm_turnos.submit()">
  <img src="images/run.gif" border="0" align="right" title="GUARDAR DATOS"/>
  </a>
    <?php
  }  
  if ($_GET["opcion"]=="04") {
	$Existe=0;
  	if (isset($_POST["txt_codigo"]))
	{
		$SQL="Delete From TurnosAreas Where CodArea='".$_POST["txt_codigo"]."'";
		include "functions/conectar.php";
		mysql_query($SQL);
		mysql_close($conectID); 
		$SQL="Insert Into TurnosAreas(CodArea, EstadoArea, NomArea, CoordArea) Values('".$_POST["txt_codigo"]."', '".$_POST["cmb_estado"]."', '".$_POST["txt_nombre"]."', '".$_POST["cmb_coord"]."')";
		include "functions/conectar.php";
		mysql_query($SQL);
		mysql_close($conectID);
		echo '<div class="Estilo3" align="center"><img src="images/accept_green.gif" width="16" height="16" border="0" align="left" /><img src="images/accept_green.gif" width="16" height="16" border="0" align="right" />AREA GUARDADA CON EXITO!</div>';
	}
  ?>
  <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2">
  <tr>
    <td width="20%" align="right" class="Estilo2">BUSCAR:</td>
    <td width="30%" align="left" class="Estilo2"><select name="cmb_codigo" class="Estilo2" id="cmb_codigo" onchange="cambioturno(this.value)">
      <option value="0">Seleccione</option>
	<?php
		$SQL="Select CodArea, NomArea From TurnosAreas";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		while ($row=mysqli_fetch_array($result)) {
			echo '<option value="'.$row[0].'">'.$row[1].'</option>
			';
		}
		//include "functions/desconectar.php";
	?>
    </select></td>
    <td width="20%" align="right" class="Estilo2">ESTADO:</td>
    <td width="30%" align="left" class="Estilo2"><select name="cmb_estado" class="Estilo2" id="cmb_estado">
	<?php
	if (isset($_GET["txt_codigo"])) 
	{
		$SQL="Select EstadoArea, NomArea, CoordArea From TurnosAreas Where CodArea='".$_GET["txt_codigo"]."'";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		if($row=mysqli_fetch_array($result)) {
			$Existe=1;
		}
	}
	?><option value="1" <?php
	  if ($Existe==1) {
	  	if ($row[0]=="1") echo 'selected="selected" ';
	  }
	  ?>>ACTIVO</option>
      <option value="0" <?php
	  if ($Existe==1) {
	  	if ($row[0]=="0") echo 'selected="selected" ';
	  }
	  ?>>INACTIVO</option>
    </select>    </td>
  </tr>
  <tr>
    <td align="right" class="Estilo2">CODIGO:</td>
    <td align="left" class="Estilo2"><input name="txt_codigo" type="text" class="Estilo2" id="txt_codigo" value="<?php
	  if (isset($_GET["txt_codigo"])) {
	  	echo $_GET["txt_codigo"];
	  }
	  ?>" size="3" />
      <a href="javascript: cambioturno(document.frm_turnos.txt_codigo.value)"><img src="images/magnify.png" width="16" height="16" border="0" align="absmiddle" title="BUSCAR POR CEDULA" /></a></td>
    <td align="right" class="Estilo2">NOMBRE:</td>
    <td align="left" class="Estilo2"><input name="txt_nombre" type="text" class="Estilo2" id="txt_nombre" value="<?php
	  if ($Existe==1) {
	  	echo $row[1];
	  }
	  ?>" size="15" /></td>
  </tr>
  <tr>
    <td align="right" class="Estilo2">COORDINADOR(A):</td>
    <td align="left" class="Estilo2"><select name="cmb_coord" class="Estilo2" id="cmb_coord">
      <option value="0" >- Seleccione Uno -</option>
      <?php
		$SQL="Select CodEmpLe, NomEmpLe + ' ' + ApeEmple From TurnosEmple Where EstadoEmple='1' Order By NomEmple, ApeEmple;";
		include "functions/conectar.php";
		$result1=mysql_query($SQL);
		while ($row1=mysqli_fetch_array($result1)) {
			echo '<option value="'.$row1[0].'"';
			if ($Existe==1) {
				if ($row[2]==$row1[0]) echo 'selected="selected"';
			}
			echo '>'.$row1[1].'</option>
			';
		}
		mysqli_free_result($result1);
	?>
                </select></td>
    <td colspan="2" align="right" class="Estilo2">&nbsp;</td>
    </tr>
</table><hr align="center" width="85%" size="1" noshade="noshade" />
  <a href="javascript: document.frm_turnos.submit()">
  <img src="images/run.gif" border="0" align="right" title="GUARDAR DATOS"/>
  </a>
    <?php
  }
  if ($_GET["opcion"]=="05") {
  	if (isset($_POST["hdn_mes"]))
	{
		$NumDia=0;
		$SQL="Delete From TurnosFest Where month(DiaFest)='".$_POST["hdn_mes"]."' and year(DiaFest)='".$_POST["hdn_anyo"]."'";
		include "functions/conectar.php";
		mysql_query($SQL);
		mysql_close($conectID); 
		while (UltimoDia($_POST["hdn_anyo"], $_POST["hdn_mes"]) > $NumDia) {
			$NumDia++;
			$checa=$_POST["chk_dia".$NumDia];
			if (($checa=="1")&&(date("w", mktime(0, 0, 0, $_POST["hdn_mes"], $NumDia, $_POST["hdn_anyo"]))!=0)) {
				$SQL="Insert Into TurnosFest(DiaFest) Values('".$NumDia."/".$_POST["hdn_mes"]."/".$_POST["hdn_anyo"]."')";
				include "functions/conectar.php";
				mysql_query($SQL);
				mysql_close($conectID);
			}
		}
	}
  ?>
<div align="center" class="Estilo2">
    <a href="turnosmes-conf.php?opcion=05&elmes=<?php
		$var="";
		if ($_GET["elmes"]=="1") $var='12';
		else $var=$_GET["elmes"]-1;
		echo $var;
	?>&elanyo=<?php
		$var="";
		if ($_GET["elmes"]=="1") $var=$_GET["elanyo"]-1;
		else $var=$_GET["elanyo"];
		echo $var;
	?>"><img src="images/arrow_left_blue_round.png" width="16" height="16" border="0" align="left" /></a><a href="turnosmes-conf.php?opcion=05&elmes=<?php
		$var="";
		if ($_GET["elmes"]=="12") $var='1';
		else $var=$_GET["elmes"]+1;
		echo $var;
	?>&elanyo=<?php
		$var="";
		if ($_GET["elmes"]=="12") $var=$_GET["elanyo"]+1;
		else $var=$_GET["elanyo"];
		echo $var;
	?>"><img src="images/arrow_right_blue_round.png" width="16" height="16" border="0" align="right" /></a> MES: <strong>
    <input name="hdn_mes" type="hidden" id="hdn_mes" value="<?php echo $_GET["elmes"]; ?>" />
    <?php
  if ($_GET["elmes"]=="01") echo "ENERO";
  if ($_GET["elmes"]=="02") echo "FEBRERO";
  if ($_GET["elmes"]=="03") echo "MARZO";
  if ($_GET["elmes"]=="04") echo "ABRIL";
  if ($_GET["elmes"]=="05") echo "MAYO";
  if ($_GET["elmes"]=="06") echo "JUNIO";
  if ($_GET["elmes"]=="07") echo "JULIO";
  if ($_GET["elmes"]=="08") echo "AGOSTO";
  if ($_GET["elmes"]=="09") echo "SEPTIEMBRE";
  if ($_GET["elmes"]=="10") echo "OCTUBRE";
  if ($_GET["elmes"]=="11") echo "NOVIEMBRE";
  if ($_GET["elmes"]=="12") echo "DICIEMBRE";
  ?></strong> A&Ntilde;O: <strong>
    <strong>
    <input name="hdn_anyo" type="hidden" id="hdn_anyo" value="<?php echo $_GET["elanyo"]; ?>" />
    </strong>
    <?php echo $_GET["elanyo"]; ?></strong></div>
	<br>
	<div  align="center" class="EstiloA">
  <table border="1" align="center" cellpadding="1" cellspacing="1" class="Estilo2">
  <tr>
  <?php
  	$Weekday="";
	$Colorday="";
	$NumDia=0;
	while (UltimoDia($_GET["elanyo"], $_GET["elmes"])> $NumDia) {
	$NumDia++;
	?>
    <td align="center" valign="bottom"><?php
	$Colorday="2";
	$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["elmes"]."/".$_GET["elanyo"]."'";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	if($row=mysqli_fetch_array($result)) {
		$Colorday="R";
	}
	else
	{
		$Colorday="2";
	}
	//include "functions/desconectar.php";
	if (date("w", mktime(0, 0, 0, $_GET["elmes"], $NumDia, $_GET["elanyo"]))==1) $Weekday= "Lu";
	if (date("w", mktime(0, 0, 0, $_GET["elmes"], $NumDia, $_GET["elanyo"]))==2) $Weekday= "Ma";
	if (date("w", mktime(0, 0, 0, $_GET["elmes"], $NumDia, $_GET["elanyo"]))==3) $Weekday= "Mi";
	if (date("w", mktime(0, 0, 0, $_GET["elmes"], $NumDia, $_GET["elanyo"]))==4) $Weekday= "Ju";
	if (date("w", mktime(0, 0, 0, $_GET["elmes"], $NumDia, $_GET["elanyo"]))==5) $Weekday= "Vi";
	if (date("w", mktime(0, 0, 0, $_GET["elmes"], $NumDia, $_GET["elanyo"]))==6) $Weekday= "Sa";
	if (date("w", mktime(0, 0, 0, $_GET["elmes"], $NumDia, $_GET["elanyo"]))==0) 
	{
		$Weekday= "Do";
		$Colorday="R";
	}
	echo '<span class="Estilo'.$Colorday.'">'.$Weekday.'</span>';
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
	while (UltimoDia($_GET["elanyo"], $_GET["elmes"])> $NumDia) {
	$NumDia++;
	?>
    <td align="center" valign="middle"><?php echo $NumDia; ?></td>
	<?php
	
	}
	?>
  </tr>
  <tr>
  <?php
  	$Weekday="";
	$Colorday="";
	$NumDia=0;
	while (UltimoDia($_GET["elanyo"], $_GET["elmes"])> $NumDia) {
	$NumDia++;
	?>
    <td align="center" valign="top"><input name="chk_dia<?php echo $NumDia; ?>" type="checkbox" id="chk_dia<?php echo $NumDia; ?>" value="1" <?php
	$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["elmes"]."/".$_GET["elanyo"]."'";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	if($row=mysqli_fetch_array($result)) {
		echo 'checked="checked"';
	}
	else
	{
		if (date("w", mktime(0, 0, 0, $_GET["elmes"], $NumDia, $_GET["elanyo"]))==0) echo 'checked="checked"';
	}
	//include "functions/desconectar.php";
	?>/></td>
	<?php
	
	}
	?>
  </tr>
</table>
</div>
  <a href="javascript: document.frm_turnos.submit()">
  <img src="images/run.gif" border="0" align="right" title="GUARDAR DATOS"/>
  </a>
  <?php
  }
  if ($_GET["opcion"]=="06") {
  ?>
  <?php
  }
  ?>
</form>
</body>
</html>
