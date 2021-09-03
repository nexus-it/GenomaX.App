<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	

	function ConectarSIPx() {
		$SQL="Select NombreBD_MYE, Servidor_MYE, UsuarioBD_MYE, ClaveBD_MYE from myescala";
		$conexionX = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"]);
		$result = mysqli_query($conexionX, $SQL);
		if ($row = mysqli_fetch_row($result)) {
			//echo $row[1].'-'.$row[2].'-'.$row[3];
			$conexionFPx = mssql_connect($row[1], $row[2], $row[3]);
			return $conexionFPx;
		}
	}
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>">
<fieldset id="fields<?php echo $NumWindow; ?>">
  <legend>PRODU <?php echo date("Y"); ?>:</legend>

<label for="txt_buscarop<?php echo $NumWindow; ?>">Buscar OP </label>
<input name="txt_buscarop<?php echo $NumWindow; ?>" id="txt_buscarop<?php echo $NumWindow; ?>" type="text" size="5" maxlength="5" />
<label for="txt_buscarped<?php echo $NumWindow; ?>">Buscar Pedido </label>
<input name="txt_buscarped<?php echo $NumWindow; ?>" id="txt_buscarped<?php echo $NumWindow; ?>" type="text" size="5" maxlength="5" />

<label for="cmb_estado<?php echo $NumWindow; ?>">Estado </label>
<select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>">
  <option value="[PRO_Programacion1].Fuera='0'" selected="selected">Ordenes Abiertas</option>
  <option value="[PRO_Programacion1].Fuera='1'">Ordenes Cerradas</option>
  <option value="1=1">Todas las Ordenes</option>
  <option value="[PRO_Programacion1].Fuera='1'">Ordenes Cerradas (Incompleto)</option>
</select>
<hr align="center" width="95%" size="1" class="anulado">
<label for="txt_factual1<?php echo $NumWindow; ?>">Fecha Actual</label>
<input name="txt_factual1<?php echo $NumWindow; ?>" id="txt_factual1<?php echo $NumWindow; ?>" type="text" size="10" maxlength="10" class="datepicker"/>
<label for="txt_factual2<?php echo $NumWindow; ?>">-</label>
<input name="txt_factual2<?php echo $NumWindow; ?>" id="txt_factual2<?php echo $NumWindow; ?>" type="text" size="10" maxlength="10" class="datepicker"/>
<label for="txt_fdesp1<?php echo $NumWindow; ?>">Fecha Desp.</label>
<input name="txt_fdesp1<?php echo $NumWindow; ?>" id="txt_fdesp1<?php echo $NumWindow; ?>" type="text" size="10" maxlength="10" class="datepicker"/>
<label for="txt_fdesp2<?php echo $NumWindow; ?>">-</label>
<input name="txt_fdesp2<?php echo $NumWindow; ?>" id="txt_fdesp2<?php echo $NumWindow; ?>" type="text" size="10" maxlength="10" class="datepicker"/>
<hr align="center" width="95%" size="1" class="anulado">
<label for="cmb_vendedor<?php echo $NumWindow; ?>">Vendedor </label>
<select name="cmb_vendedor<?php echo $NumWindow; ?>" id="cmb_vendedor<?php echo $NumWindow; ?>">
	<option value="01"> -- Todos -- </option>
<?
	$SQL="SELECT [ID Vendedor], [Nombre Vendedor] FROM Z_Vendedores";
	$conexionFPx=ConectarSIPx();
	$resultFPx = mssql_query($SQL, $conexionFPx);
	
	while($rowFPx = mssql_fetch_row($resultFP)) {
		echo '<option value="'.$rowFPx[0].'">'.$rowFPx[1].'</option>';	
	}
	mssql_free_result($resultFPx);
	mssql_close($conexionFPx);
?>
</select>
<label for="cmb_cliente<?php echo $NumWindow; ?>">Cliente </label>
<select name="cmb_cliente<?php echo $NumWindow; ?>" id="cmb_cliente<?php echo $NumWindow; ?>">
  <option value="01"> -- Todos -- </option>
  <option value="02">Ordenes Cerradas</option>
  <option value="03">Todas las Ordenes</option>
  <option value="04">Ordenes Cerradas (Incompleto)</option>
</select>
<label for="cmb_orderby<?php echo $NumWindow; ?>">Ordenar Por </label>
<select name="cmb_orderby<?php echo $NumWindow; ?>" id="cmb_orderby<?php echo $NumWindow; ?>">
  <option value="01"> -- Todos -- </option>
  <option value="02">Ordenes Cerradas</option>
  <option value="03">Todas las Ordenes</option>
  <option value="04">Ordenes Cerradas (Incompleto)</option>
</select>
<a href="javascript:CargarProdu<?php echo $NumWindow; ?>();"> <img id="img_tabla<?php echo $NumWindow; ?>" src="http://cdn.genomax.co/media/image/table_import.png"  alt="Cargar Produ" align="absmiddle" title="Cargar Produ" /></a>

</fieldset>
<fieldset class="can-grow" id="results<?php echo $NumWindow; ?>" style="overflow:auto">
<legend>Progreso</legend>
    <div id="destino<?php echo $NumWindow; ?>">
    <input type="hidden" name="hdn_conta<?php echo $NumWindow; ?>" id="hdn_conta<?php echo $NumWindow; ?>" value="0"/>
    <input type="hidden" name="hdn_printear<?php echo $NumWindow; ?>" id="hdn_printear<?php echo $NumWindow; ?>" value="0"/>
    </div>
</fieldset>
</form>
<script>
var MyEscala="functions/php/nexus/myescala.php";
function CargarProdu<?php echo $NumWindow; ?>() {
		<?php
		$NoVent= substr($NumWindow, (strlen($NumWindow)-strpos($NumWindow, "_"))*(-1));
		?>
		document.getElementById('destino<?php echo $NumWindow; ?>').innerHTML='<div align="center">Por favor espere un momento mientras se realiza su consulta...<br><img src="http://cdn.genomax.co/media/image/loading.gif" border="0" align="absmiddle"></div>';
		WindAct = document.getElementById("Window<?php echo $NoVent; ?>").style;
		if (100*WindAct.width/screen.width<=60) {
			document.getElementById("Window<?php echo $NoVent; ?>").style.width="98.7%";
			document.getElementById("Window<?php echo $NoVent; ?>").style.height="97.5%";
			document.getElementById("Window<?php echo $NoVent; ?>").style.left="0.5%";
			document.getElementById("Window<?php echo $NoVent; ?>").style.top="0.5%";
		}
		document.getElementById("results<?php echo $NumWindow; ?>").style.height="79%";
		$.get(MyEscala,{'Func':'CargarProdu','ventana':'<?php echo $NumWindow; ?>', 'op':document.getElementById("txt_buscarop<?php echo $NumWindow; ?>").value, 'pedido':document.getElementById("txt_buscarped<?php echo $NumWindow; ?>").value, 'estado':document.getElementById("cmb_estado<?php echo $NumWindow; ?>").value, 'orderby':document.getElementById("cmb_orderby<?php echo $NumWindow; ?>").value},function(data){ 
			document.getElementById('destino<?php echo $NumWindow; ?>').innerHTML=data;
		})
}

</script>