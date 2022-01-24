<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal col-md-12" id="frm_form<?php echo $NumWindow; ?>"  >
<input name="hdn_prefijo<?php echo $NumWindow; ?>" id="hdn_prefijo<?php echo $NumWindow; ?>" type="hidden" value="<?php echo $_SESSION['Kl_Prefijo']; ?>"/>
	<label class="label label-info"> <span class="glyphicon glyphicon-plane" aria-hidden="true"></span> </label>
	  		<div class="row well well-sm">
	  		<div class="col-md-12">
	  		<div class="row">

		<div class="col-md-2">
		<?php
			$noctz="000000";
			if (isset($_GET["CTZ"])) {	
				$noctz=str_pad($_GET["CTZ"], 6, "0", STR_PAD_LEFT);
			}
		?>

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_cotizacion<?php echo $NumWindow; ?>">Cotizacion</label>
		<div class="input-group">
			<input name="txt_cotizacion<?php echo $NumWindow; ?>" id="txt_cotizacion<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarCTZ<?php echo $NumWindow; ?>(event);" value="<?php echo $noctz; ?>"/>
			 <span class="input-group-btn"> 		
	 		  <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-bs-toggle="modal" data-bs-target="#GnmX_Search" data-whatever="Cotizacion" onclick="javascript:CargarSearch('KlCotizacion', 'txt_cotizacion<?php echo $NumWindow; ?>', 'Estado_CTZ=*1*');"><i class="fas fa-search"></i></button>
			 </span>
		</div>
	</div>

		</div>
		
		<?php
			if (isset($_GET["CTZ"])) {	
				$SQL="Select ID_TER as 'Pasaporte', Nombre_TER as 'Nombres', Fecha_CTZ as 'Fecha Cotizacion', Nombre_AGE as 'Agencia', Nombre_USR as 'Promotor', nombre_pla as 'Plan', Modalidad_CTZ as 'Modalidad', f.nombre_dst as 'Procedencia', g.nombre_dst as 'Destino', FechaIni_CTZ as 'Fecha Inicio', FechaFin_CTZ as 'Fecha Fin', Dias_CTZ as 'Días', format(TRM_CTZ, 2) as 'T.R.M.', Dolares_CTZ as 'Valor en Dolares', format(Pesos_CTZ, 2) as 'Valor en Pesos', Descuento_CTZ as '% Descuento', format(Total_CTZ,2) as 'Total en Pesos', Voucher_CTZ as 'Voucher'
				From czterceros a, klcotizaciones b, itusuarios c, klagencias d, klplanes e, kldestinos f, kldestinos g
				Where a.codigo_ter=b.codigo_ter and c.codigo_usr=b.codigo_usr and d.codigo_age=b.codigo_age and e.codigo_pla=b.codigo_pla and  f.codigo_dst=procedencia_ctz and g.codigo_dst=b.codigo_dst and
				LPAD(codigo_ctz,6,'0')='".str_pad($_GET["CTZ"], 6, "0", STR_PAD_LEFT)."' and estado_ctz='1'";
				$result = mysqli_query($conexion, $SQL);
				if($row = mysqli_fetch_array($result)) {			
			
		?>
		<div class="col-md-12 alert alert-warning">
		<div class="row">
<?php 
	$j=0;
while ($j <= 17) {
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
<input name="hdn_modalidad<?php echo $NumWindow; ?>" type="hidden" id="hdn_modalidad<?php echo $NumWindow; ?>" value="<?php echo $row[6]; ?>" />
<input  name="hdn_voucher<?php echo $NumWindow; ?>" id="hdn_voucher<?php echo $NumWindow; ?>" type="hidden" value="<?php echo $row[17]; ?>" />

		</div>

		</div>
		<?php
				}
				mysqli_free_result($result); 
			}
		?>

  		</div>
</div>

</form>

<script >

function BuscarCTZ<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if ((document.getElementById('txt_cotizacion<?php echo $NumWindow; ?>').value=="")||(document.getElementById('txt_cotizacion<?php echo $NumWindow; ?>').value=="000000")) {
		document.frm_form<?php echo $NumWindow; ?>.txt_cotizacion<?php echo $NumWindow; ?>.value='000000';
		
	} else {
		AbrirForm('application/forms/klcotizacionesno.php', '<?php echo $NumWindow; ?>', '&CTZ='+document.getElementById('txt_cotizacion<?php echo $NumWindow; ?>').value);
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
