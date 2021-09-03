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
		////include "functions/desconectar.php";
		}
	}	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Turnos N&oacute;mina</title>
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
.Estilo2 {	font-size: 12px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #333333;
}
.Estilo3 {	font-size: 13px;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #333333;
	text-align: center;
}
-->
</style>
<script language="javascript">
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
		window.open("turnosmes-conf.php?opcion="+param, "_blank", "toolbar=no,menubar=no,directories=no,status=no,resizable=no,location=no,scrollbars=no,height=400,width=610");
		opcion[0].selected=true;
	}
}
function MostrarLiq() {
	window.open("turnosmes-excel.php?cmb_mesexcel="+document.frm_turnos.cmb_mesexcel.value+"&txt_anyoexcel="+document.frm_turnos.txt_anyoexcel.value+"&cmb_empre="+document.frm_turnos.cmb_empre.value, "_self", "");
}
function cambiararea(combo) {
	if (combo!=0) {
		if (document.frm_turnos.Chk_Personal.checked==true) {
			window.open("turnosmes-tarj.php?cmb_mes="+document.frm_turnos.cmb_mes.value+"&txt_anyo="+document.frm_turnos.txt_anyo.value+"&cmb_area="+document.frm_turnos.cmb_areas.value, "_self", "");
		}
		else {
			document.frm_turnos.submit();
		}
	}
}
</script>
</head>
<body>
<div align="center" class="Estilo5">
  <p>:: TURNOS NOMINA ::</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
</div>
<form action="turnosmes-view.php" method="get" name="frm_turnos" id="frm_turnos">
  <fieldset>
  <table width="50%" border="0" align="center" cellpadding="2" cellspacing="2">
    <tr>
      <td align="left" valign="middle" class="Estilo2"><img src="images/bullet_arrow_right.png" width="15" height="15" align="absmiddle" />CONFIGURAR: 
        <select name="cmb_configurar" class="Estilo2" id="cmb_configurar" onchange="abrirconf(this)">
          <option value="00" selected="selected">-- SELECCIONE --</option>
<!--          <option value="01">EMPRESAS</option>
-->          <option value="02">EMPLEADOS</option>
          <option value="03">TIPOS DE TURNOS</option>
          <option value="04">AREAS</option>
          <option value="05">DIAS FESTIVOS</option>
<!--          <option value="06">RECARGOS</option>
-->        </select>      </td>
    </tr>
    <tr>
      <td align="left" valign="middle" class="Estilo2"><img src="images/bullet_arrow_right.png" width="15" height="15" align="absmiddle" />PROGRAMACION DE HORARIOS
        <table width="80%" border="0" align="right" cellpadding="2" cellspacing="2">
          <tr>
            <td><img src="images/bullet_arrow_right.png" width="15" height="15" align="absmiddle" />EDITAR TURNOS: <a href="turnosmes-asig.php"> <img src="images/button_edit.png" width="16" height="16" border="0" align="absmiddle" /></a></td>
          </tr>
          <tr>
            <td><img src="images/bullet_arrow_right.png" width="15" height="15" align="absmiddle" />VISUALIZAR POR AREA:</td>
                <tr>
                  <td colspan="2" align="center">A&Ntilde;O:
                    <input name="txt_anyo" type="text" class="Estilo3" id="txt_anyo" value="<?php echo date("Y"); ?>" size="4" maxlength="4" />
                    MES:
                    <select name="cmb_mes" class="Estilo2" id="cmb_mes">
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
                    </select></td>
                </tr>
                <tr>
                  <td colspan="2" align="center" valign="middle"><label>
                    <input name="Chk_Personal" type="checkbox" class="Estilo2" id="Chk_Personal" value="1" />
                  TARJETA PERSONAL (LIQUIDAR) </label></td>
                </tr>
                <tr>
                  <td colspan="2" align="center">AREA:
                    <select name="cmb_areas" class="Estilo2" id="cmb_areas" onchange="cambiararea(this.value)">
                      <option value="00" selected="selected">-- Seleccione --</option>
                      <?php
		$SQL="Select distinct a.Codigo_ARE, Nombre_ARE from czareas a, czareasterceros b Where a.Codigo_ARE=b.Codigo_ARE and Estado_ARE='1' order by Nombre_ARE";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		while($row=mysqli_fetch_array($result)) {
			echo '<option value="'.$row[0].'">'.$row[1].'</option>
		';
			
		}
		////include "functions/desconectar.php";
		?>
                    </select></td>
                </tr>
      </table>  </td>
    </tr>
    <tr>
      <td align="left" valign="middle"><span class="Estilo2"><img src="images/bullet_arrow_right.png" width="15" height="15" align="absmiddle" />REPORTE EXCEL: 
          <input name="txt_anyoexcel" type="text" class="Estilo3" id="txt_anyoexcel" value="<?php echo date("Y");  ?>" size="4" maxlength="4" />
        &middot;
        <select name="cmb_mesexcel" class="Estilo2" id="cmb_mesexcel">
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
      &middot;
      <select name="cmb_empre" class="Estilo2" id="cmb_empre">
        <?php
		$SQL="Select Codigo_TCL, Nombre_TCL From cztipocontratos Where Estado_TCL='1';";
		include "functions/conectar.php";
		$result = mysqli_query( $conexion, $SQL);
		while($row=mysqli_fetch_array($result)) {
			echo '<option value="'.$row[0].'">'.$row[1].'</option>
		';
			
		}
		////include "functions/desconectar.php";
		?>
            </select>
      <a href="javascript: MostrarLiq()"><img src="images/accept_green.gif" width="16" height="16" border="0" align="absmiddle" /></a></span></td>
    </tr>
    <tr>
      <td align="left" valign="middle"><hr align="center" width="95%" size="1" noshade="noshade" class="Estilo3" />
<a href="javascript: document.frm_adingres.submit();"><img src="images/cog.png" width="32" height="32" border="0" align="right" title="Ejecutar!"/></a></td>
    </tr>
  </table>
  </fieldset>
</form>
</body>
</html>
