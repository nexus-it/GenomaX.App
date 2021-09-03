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
<title>Asignaci&oacute;n de Turnos</title>
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
	font-size: 16px;
	color: #333333;
}
.Estilo2 {	font-size: 12px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #333333;
}
.EstiloR {	font-size: 12px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #990000;
}
.Estilo3 {	font-size: 13px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #333333;
	text-align: center;
}
.Estilo7 {font-size: 12px; font-family: Geneva, Arial, Helvetica, sans-serif; color: #FFFFFF; }
a:link {
	text-decoration: none;
}
a:visited {
	text-decoration: none;
}
a:hover {
	text-decoration: underline;
}
a:active {
	text-decoration: none;
}
.Estilo8 {font-size: 12px; font-family: Geneva, Arial, Helvetica, sans-serif; color: #FFFFFF; font-weight: bold; }
-->
</style>
<script language="javascript" type="text/javascript">
function cambioarea(combo) {
	<?php
	$Coord="";
	$ContaEmple=0;
	$SQL="Select CodArea, CoordArea From TurnosAreas Where EstadoArea='1';";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	while($row=mysqli_fetch_array($result)) {
		echo '
		if (combo.value=="'.$row[0].'") {
			';
		$SQL="Select NomEmple + ' ' + ApeEmple From TurnosEmple where EstadoEmple='1' and CodEmple='".$row[1]."';";
		$result1=mysql_query($SQL);
		if ($row1=mysqli_fetch_array($result1)) {
			$Coord=$row1[0];
		}
		mysqli_free_result($result1);
		echo 'document.frm_turnos.txt_coord.value="'.$Coord.'";
			';
		$SQL="Select CodEmple, NomEmple + ' ' + ApeEmple From TurnosEmple where EstadoEmple='1' and CodArea='".$row[0]."' Order by NomEmple, ApeEmple;";
		$result1=mysql_query($SQL);
		echo 'document.frm_turnos.cmb_emple.length = 0;
			';
		while ($row1=mysqli_fetch_array($result1)) {
			echo 'document.frm_turnos.cmb_emple.options['.$ContaEmple.']=new Option("'.$row1[1].'","'.$row1[0].'");
			';
			$ContaEmple++;
		}
		$ContaEmple=0;
		mysqli_free_result($result1);
		echo '
		}
';
	}
	//include "functions/desconectar.php";
	?>
}
function cambioturno(combo,turno, dia) {
	turno.value=combo.value;
	dia=dia-1;
	<?php
	$SQL="Select CodTurno, HorasTurno From TurnosHoras Where EstadoTurno='1';";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	while($row=mysqli_fetch_array($result)) {
		echo '
		if (combo.value=="'.$row[0].'") {
			document.frm_turnos.txt_horas[dia].value="'.$row[1].'";
		}';
	}
	//include "functions/desconectar.php";
	?>
	sumarhoras();
}
<?php
if (isset($_GET["txt_anyo"]))
{
?>
function sumarhoras() {
	totalhrs=0;
	totaldias=0;
	while (<?php echo UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"]); ?> > totaldias) {
		totalhrs=parseFloat(parseFloat(totalhrs) + parseFloat(document.frm_turnos.txt_horas[totaldias].value));
		totaldias++;
	}
	document.frm_turnos.txt_totalhoras.value=totalhrs;
}
<?php
}
?>
</script>
</head>

<body>
<img src="images/logo_la_prado.gif" width="208" height="113" class="logo" />
<div align="center" class="Estilo5">
  <p>:: PROGRAMACI&Oacute;N DE HORARIOS ::</p>
    <?php
  if (isset($_GET["txt_anyo"]))
  {
	?>
  <p class="Estilo3"><span class="Estilo2">MES:</span> <?php
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
  ?> - <span class="Estilo2">A&Ntilde;O:</span> <?php echo $_GET["txt_anyo"]; ?><br>
  <?php
	if ($_GET["cmb_areas"]=="00")
	{
	echo '
	<script language="javascript" type="text/javascript">
		alert ("SELECCIONE EL AREA O DEPARTAMENTO");
		location.href="turnosmes-asig.php";
	</script>';
	}
  $SQL="Select NomArea, E1.NomEmple + ' ' + E1.ApeEmple, E2.NomEmple + ' ' + E2.ApeEmple From TurnosAreas A, TurnosEmple E1, TurnosEmple E2 Where A.CoordArea=E1.CodEmple and A.CodArea='".$_GET["cmb_areas"]."' and E2.CodEmple='".$_GET["cmb_emple"]."';";
	include "functions/conectar.php";
	$result = mysqli_query( $conexion, $SQL);
	if($row=mysqli_fetch_array($result)) {
  ?>
    <span class="Estilo2">AREA O DEPARTAMENTO:</span> <?php echo $row[0]; ?><br>
  <span class="Estilo2">COORDINADOR(A) DE AREA:</span> <?php echo $row[1]; ?><br><br>
  <span class="Estilo2">PROGRAMACIÓN DE:</span> <?php echo $row[2]; ?></p>
  <?php
  	}
  	//include "functions/desconectar.php";
  
  }
  else
  {
  echo '<p>&nbsp;</p>';
  }
  ?>
  <p>&nbsp;</p>
</div>
<form action="turnosmes-asig.php" method="<?php
  if (!(isset($_GET["txt_anyo"])))
  	echo 'get';
  else
  	echo 'post';
  ?>" name="frm_turnos" id="frm_turnos">
  <fieldset>
  <?php
  if (!(isset($_GET["txt_anyo"])))
  {
  	if (isset($_POST["hdn_emple"]))
	{
	$SQL="Delete From Turnos Where CodEmple='".$_POST["hdn_emple"]."' and month(Fecha)='".$_POST["hdn_mes"]."' and year(Fecha)='".$_POST["hdn_anyo"]."'";
	include "functions/conectar.php";
	mysql_query($SQL);
	mysql_close($conectID);
	$DiaActual=0;
	include "functions/conectar.php";
	$MesAnt=0;
	$AnyoAnt=0;
	if ($_POST["hdn_mes"]==1) {
		$MesAnt=12;
		$AnyoAnt=$_POST["hdn_anyo"] - 1;
	}
	else {
		$MesAnt=$_POST["hdn_mes"] - 1;
		$AnyoAnt=$_POST["hdn_anyo"];
	}
	$SQL="Select * From Turnos Where CodEmple='".$_POST["hdn_emple"]."' and month(Fecha)='".$MesAnt."' and year(Fecha)='".$AnyoAnt."'";
	$result = mysqli_query( $conexion, $SQL);
	if (!($row=mysqli_fetch_array($result))) {
		$SQL="Insert Into Turnos(CodEmple, CodTurno, Fecha) Values('".$_POST["hdn_emple"]."', '25', '".UltimoDia($AnyoAnt, $MesAnt)."/".$MesAnt."/".$AnyoAnt."')";
		mysql_query($SQL);
		mysqli_free_result($result);
	}
	while (UltimoDia($_POST["hdn_anyo"], $_POST["hdn_mes"])>$DiaActual) {
		$DiaActual++;
		$Turno=$DiaActual-1;
		$SQL="Insert Into Turnos(CodEmple, CodTurno, Fecha) Values('".$_POST["hdn_emple"]."', '".$_POST["hdn_turno".$DiaActual]."', '".$DiaActual."/".$_POST["hdn_mes"]."/".$_POST["hdn_anyo"]."')";
		mysql_query($SQL);
	}
	mysql_close($conectID);
	echo '<div class="Estilo3" align="center"><img src="images/accept_green.gif" width="16" height="16" border="0" align="left" /><img src="images/accept_green.gif" width="16" height="16" border="0" align="right" />TURNO GUARDADO CON EXITO!</div>';
	}
  ?>
  <table border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td align="right" valign="middle" class="Estilo2">MES:</td>
      <td align="left" valign="middle" class="Estilo2"><select name="cmb_mes" class="Estilo2" id="cmb_mes">
        <option value="01"<?php if (date("m")=='12') echo ' selected="selected"'; ?>>ENERO</option>
        <option value="02"<?php if (date("m")=='01') echo ' selected="selected"'; ?>>FEBRERO</option>
        <option value="03"<?php if (date("m")=='02') echo ' selected="selected"'; ?>>MARZO</option>
        <option value="04"<?php if (date("m")=='03') echo ' selected="selected"'; ?>>ABRIL</option>
        <option value="05"<?php if (date("m")=='04') echo ' selected="selected"'; ?>>MAYO</option>
        <option value="06"<?php if (date("m")=='05') echo ' selected="selected"'; ?>>JUNIO</option>
        <option value="07"<?php if (date("m")=='06') echo ' selected="selected"'; ?>>JULIO</option>
        <option value="08"<?php if (date("m")=='07') echo ' selected="selected"'; ?>>AGOSTO</option>
        <option value="09"<?php if (date("m")=='08') echo ' selected="selected"'; ?>>SEPTIEMBRE</option>
        <option value="10"<?php if (date("m")=='09') echo ' selected="selected"'; ?>>OCTUBRE</option>
        <option value="11"<?php if (date("m")=='10') echo ' selected="selected"'; ?>>NOVIEMBRE</option>
        <option value="12"<?php if (date("m")=='11') echo ' selected="selected"'; ?>>DICIEMBRE</option>
      </select>
      </td>
      <td align="right" valign="middle" class="Estilo2">A&Ntilde;O:</td>
      <td align="left" valign="middle"><input name="txt_anyo" type="text" class="Estilo3" id="txt_anyo" value="<?php echo date("Y"); ?>" size="4" maxlength="4" /></td>
    </tr>
    <tr>
      <td align="right" valign="middle" class="Estilo2">AREA O DEPARTAMENTO:</td>
      <td align="left" valign="middle" class="Estilo2">
	  <select name="cmb_areas" class="Estilo2" id="cmb_areas" onchange="cambioarea(this)">
        <option value="00" selected="selected">-- Seleccione --</option>
		<?php
		$SQL="Select CodArea, NomArea From TurnosAreas Where EstadoArea='1';";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		while($row=mysqli_fetch_array($result)) {
			echo '<option value="'.$row[0].'">'.$row[1].'</option>
		';
			
		}
		//include "functions/desconectar.php";
		?>
      </select>
      </td>
      <td align="right" valign="middle" class="Estilo2">COORDINADOR(A):</td>
      <td align="left" valign="middle"><input name="txt_coord" type="text" class="Estilo2" id="txt_coord" disabled /></td>
    </tr>
    <tr>
      <td align="right" valign="middle" class="Estilo2">EMPLEADO:</td>
      <td align="left" valign="middle" class="Estilo2"><select name="cmb_emple" class="Estilo2" id="cmb_emple">
      </select>
      </td>
      <td align="right" valign="middle" class="Estilo2">&nbsp;</td>
      <td align="left" valign="middle">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="right" valign="middle" bgcolor="#666666"><a href="javascript: document.frm_turnos.submit();"><span class="Estilo7">ELABORAR PROGRAMACI&Oacute;N </span><img src="images/WebResource(1).gif" width="15" height="15" border="0" align="absmiddle" title="ELABORAR PROGRAMACIÓN" /></a></td>
    </tr>
  </table>
  <a href="turnosmes.php"><img src="images/arrow_2_left_round.gif" width="16" height="16" border="0" align="left" title="&lt;&lt; ATRAS" /></a>
  <?php 
  }
  else
  {
/*  	if (($_GET["cmb_mes"]==date("m")) and($_GET["txt_anyo"]==date("Y")))
  	{
	echo '<div align="center" class="Estilo2"><img src="images/jc_error.png" align="absmiddle" width="16" height="16" /> NO ES POSIBLE EDITAR EL MES EN CURSO <img src="images/jc_error.png" width="16" height="16" align="absmiddle" /><br><a href="turnosmes-asig.php"><img src="images/arrow_2_left_round.gif" width="16" height="16" border="0" align="left" title="&lt;&lt; ATRAS" /></a></div>';
	}
	else
*/	{
  ?>
  <table border="0" align="center" cellpadding="0" cellspacing="2">
    <tr>
      <td align="center" valign="top" bgcolor="#666666" class="Estilo8">- D&Iacute;A
        <input name="hdn_emple" type="hidden" id="hdn_emple" value="<?php echo $_GET["cmb_emple"]; ?>" /> 
      -</td>
      <td align="center" valign="top" bgcolor="#666666" class="Estilo8">- TURNO
        <input name="hdn_mes" type="hidden" id="hdn_mes" value="<?php echo $_GET["cmb_mes"]; ?>" /> 
      -</td>
      <td align="center" valign="top" bgcolor="#666666" class="Estilo8">- HORAS
        <input name="hdn_anyo" type="hidden" id="hdn_anyo" value="<?php echo $_GET["txt_anyo"]; ?>" /> 
      -</td>
    </tr>
	<?php
	$TotalHoras=0;
	$NumDia=0;
	While (UltimoDia($_GET["txt_anyo"], $_GET["cmb_mes"])> $NumDia) {
	$NumDia++;
	?>
    <tr>
      <td align="center" class="Estilo<?php 
	  if (date("w", mktime(0, 0, 0, $_GET["cmb_mes"], $NumDia, $_GET["txt_anyo"]))==0) 
	  {
	  	echo "R";
	  }
	  else
	  {
	  	$SQL="Select DiaFest From TurnosFest Where DiaFest='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		if($row=mysqli_fetch_array($result)) {
			echo "R";
		}
		else
		{
			echo "2";
		}
		//include "functions/desconectar.php";
	  }
	   ?>"><strong><?php 
	  echo $NumDia; 
	  ?></strong></td>
      <td align="left" class="Estilo2"><select name="select4" class="Estilo2" onchange="cambioturno(this, document.frm_turnos.hdn_turno<?php 
	  echo $NumDia; 
	  ?>, '<?php 
	  echo $NumDia; 
	  ?>')">
	  <?php
		$SQL="Select CodTurno, NomTurno From TurnosHoras Where EstadoTurno='1';";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		while($row=mysqli_fetch_array($result)) {
			echo '<option value="'.$row[0].'"';
			//Si esta programado, lo muestro seleccionado
			$SQL="Select CodTurno From Turnos Where CodEmple='".$_GET["cmb_emple"]."' and Fecha='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."'";
			$result1=mysql_query($SQL);			
			if ($row1=mysqli_fetch_array($result1)) {
				if ($row[0]==$row1[0]) {
					echo ' selected="selected" ';
				}
			}
			else
			{
				if ($row[0]=='25') echo ' selected="selected" ';
			}
			mysqli_free_result($result1);
			echo '>'.$row[1].'</option>
			';
		}
		
		//include "functions/desconectar.php";
	  ?>
      </select>
      </td>
      <td align="center" class="Estilo2"><input name="hdn_turno<?php 
	  echo $NumDia; 
	  ?>" type="hidden" id="hdn_turno<?php 
	  echo $NumDia; 
	  ?>" value="<?php
	$SQL="Select Turnos.CodTurno, HorasTurno From Turnos, TurnosHoras Where CodEmple='".$_GET["cmb_emple"]."' and Fecha='".$NumDia."/".$_GET["cmb_mes"]."/".$_GET["txt_anyo"]."' and Turnos.CodTurno=TurnosHoras.CodTurno";
	include "functions/conectar.php";
	$Horas=0;
	$result = mysqli_query( $conexion, $SQL);			
	if ($row=mysqli_fetch_array($result)) {
		echo $row[0];
		$Horas=$row[1];
	}
	else
	{
		echo '25';
		$Horas='0.00';
	}
	//include "functions/desconectar.php";
	$TotalHoras=$TotalHoras+$Horas;
?>" />
      <input name="txt_horas" type="text" disabled class="Estilo2" id="txt_horas" value="<?php echo $Horas; ?>" size="2" maxlength="2" /></td>
    </tr>
	<?php
	
	}
	?>
    <tr>
      <td colspan="2" align="center" valign="bottom" class="Estilo2"><strong>TOTAL HORAS: </strong></td>
      <td align="center"><input type="hidden" value="456" />
      <input name="txt_totalhoras" type="text" disabled class="Estilo3" id="txt_totalhoras" value="<?php echo $TotalHoras; ?>" size="3" maxlength="3" /></td>
    </tr>
  </table>
  <div align="center">
    <hr align="center" width="60%" noshade="noshade" class="EstiloR" />
    <a href="turnosmes-asig.php"><img src="images/arrow_2_left_round.gif" width="16" height="16" border="0" align="left" title="&lt;&lt; ATRAS" /></a><a href="javascript: document.frm_turnos.submit();"><img src="images/run.gif" width="32" height="32" border="0" align="absmiddle" title="PROCESAR TURNOS"/></a> </div>
  <?php
  	}
  }
  ?>
  </fieldset>
</form>
</body>
</html>
