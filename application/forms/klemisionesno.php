<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
	  		<div class="row well well-sm">
	  		<div class="col-md-12">
	  		<div class="row">
	  	<?php
			$noctz="";
			if (isset($_GET["CTZ"])) {	
				$noctz=str_pad($_GET["CTZ"], 6, "0", STR_PAD_LEFT);
			}
		?>

		<div class="col-md-2">
		
	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_poliza<?php echo $NumWindow; ?>">POLIZA</label>
		<div class="input-group">
			<span class="input-group-addon" id="basic-addon1"><?php echo $_SESSION['Kl_Prefijo']; ?></span>
			<input name="txt_poliza<?php echo $NumWindow; ?>" id="txt_poliza<?php echo $NumWindow; ?>" type="text" onkeypress="javascript:BuscarEMI<?php echo $NumWindow; ?>(event);" value="<?php echo $noctz; ?>"/>
			 <span class="input-group-btn"> 		
	 		  <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Poliza" onclick="javascript:CargarSearch('KlPoliza', 'txt_poliza<?php echo $NumWindow; ?>', 'Estado_EMI<>*A*');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			 </span>
		</div>
	</div>

		</div>
		
		<?php
			if (isset($_GET["CTZ"])) {	
				$SQL="Select concat(prefijo_emi, '-',codigo_emi) as 'POLIZA',b.codigo_ctz as 'COTIZACION', ID_TER as 'Pasaporte', Nombre_TER as 'Nombres', Fecha_CTZ as 'Fecha Cotizacion', Nombre_AGE as 'Agencia', Nombre_USR as 'Promotor', nombre_pla as 'Plan', Modalidad_CTZ as 'Modalidad', f.nombre_dst as 'Procedencia', g.nombre_dst as 'Destino', FechaIni_CTZ as 'Fecha Inicio', FechaFin_CTZ as 'Fecha Fin', Dias_CTZ as 'Días', format(TRM_CTZ, 2) as 'T.R.M.', Dolares_CTZ as 'Valor en Dolares', format(Pesos_CTZ, 2) as 'Valor en Pesos', Descuento_CTZ as '% Descuento', format(Total_CTZ,2) as 'Total en Pesos', Voucher_CTZ as 'Voucher'
				From czterceros a, klcotizaciones b, itusuarios c, klagencias d, klplanes e, kldestinos f, kldestinos g, klemisiones h
				Where a.codigo_ter=b.codigo_ter and c.codigo_usr=b.codigo_usr and d.codigo_age=b.codigo_age and e.codigo_pla=b.codigo_pla and  f.codigo_dst=procedencia_ctz and g.codigo_dst=b.codigo_dst and h.codigo_ctz=b.codigo_ctz and 
				LPAD(codigo_emi,6,'0')='".str_pad($_GET["CTZ"], 6, "0", STR_PAD_LEFT)."' and estado_emi<>'A'";
				$result = mysqli_query($conexion, $SQL);
				if($row = mysqli_fetch_array($result)) {			
			
		?>
		<div class="col-md-12 alert alert-warning">
		<div class="row">
<?php 
	$j=0;
while ($j <= 19) {
?>
		<ul class="list-group col-md-4">
		  <li class="list-group-item">
		    <span class="badge"><?php echo $row[$j]; ?></span>
		    <?php echo mysql_field_name($result, $j); ?>
		  </li>
		</ul>
<?php 
	$j++;
} 
?>

		</div>
		</div>
		<?php
				}
				mysqli_free_result($result); 
			}
		?>

  		</div>
  		</div>
		</div>


<script >

function BuscarEMI<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13)  {
	if ((document.getElementById('txt_poliza<?php echo $NumWindow; ?>').value=="")||(document.getElementById('txt_poliza<?php echo $NumWindow; ?>').value=="000000")) 	{
		document.frm_form<?php echo $NumWindow; ?>.txt_poliza<?php echo $NumWindow; ?>.value='000000';
		
	} else {
		AbrirForm('application/forms/klemisionesno.php', '<?php echo $NumWindow; ?>', '&CTZ='+document.getElementById('txt_poliza<?php echo $NumWindow; ?>').value);
	}  
  }
}

$("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-select");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=checkbox]").addClass("form-check-input");
	$("input[type=radio]").addClass("form-check-input");

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
