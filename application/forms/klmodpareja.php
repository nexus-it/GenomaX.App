<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal col-md-12" id="frm_form<?php echo $NumWindow; ?>"  enctype="multipart/form-data" onreset="KlResetea<?php echo $NumWindow; ?>();">
	  		<div class="row well well-sm">
	  		<div class="col-md-12">
	  		<div class="row">

		<div class="col-md-3">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_plan<?php echo $NumWindow; ?>">Plan</label>
		<div class="input-group">
			<input name="txt_plan<?php echo $NumWindow; ?>" id="txt_plan<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarPLA<?php echo $NumWindow; ?>(event);" />
			 <span class="input-group-btn"> 		
	 		  <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Planes" onclick="javascript:CargarSearch('KlPlanes', 'txt_plan<?php echo $NumWindow; ?>', 'Estado_PLA=*1*');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			 </span>
		</div>
	</div>
	<input name="hdn_codpla<?php echo $NumWindow; ?>" type="hidden" id="hdn_codpla<?php echo $NumWindow; ?>" value="0" />

		</div>
		<div class="col-md-8">
	
	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_descripcion<?php echo $NumWindow; ?>">Descripcion</label>
		<input  name="txt_descripcion<?php echo $NumWindow; ?>" id="txt_descripcion<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="cmb_estado<?php echo $NumWindow; ?>">Estado</label>
		<select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>" disabled="disabled">
		  <option value="0">Inactivo</option>
		  <option value="1">Activo</option>
		</select>

	</div>

		</div>



		<div class="col-md-12">
			<div class="row">

		<?php 
			$indiv=1;
			while ($indiv<=365) {
		?>

		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
  		<label for="cmb_estado<?php echo $NumWindow; ?>">Dia <?php echo $indiv; ?></label>
		<input  name="txt_dia<?php echo $indiv.$NumWindow; ?>" id="txt_dia<?php echo $indiv.$NumWindow; ?>" type="text" required value="0" />
	</div>

		</div>

		<?php
			$indiv++;
			}
		?>

			</div>
		</div>


	</div>
	</div>
</div>

</form>

<script >

<?php 
	if (isset($_GET["PLA"])) {	
		$SQL="Select Codigo_PLA, Descripcion_PLA, Estado_PLA from klplanes Where Nombre_PLA='".str_replace('_', ' ', $_GET["PLA"])."'";
		echo "	document.getElementById('txt_plan".$NumWindow."').value='".str_replace('_', ' ', $_GET["PLA"])."';";
		$result = mysqli_query($conexion, $SQL);
		if ($row = mysqli_fetch_array($result)) {
			echo "
				document.getElementById('hdn_codpla".$NumWindow."').value='".$row["Codigo_PLA"]."';
				document.getElementById('txt_descripcion".$NumWindow."').value='".$row["Descripcion_PLA"]."';
				document.getElementById('cmb_estado".$NumWindow."').value='".$row["Estado_PLA"]."';
			";
		} else {
			echo " MsgBoxErr('Planes Precios','No existe el plan: ".str_replace('_', ' ', $_GET["PLA"])."');
			document.getElementById('txt_plan".$NumWindow."').value='';";
		}
		mysqli_free_result($result); 
		$SQL="Select Dias_PLA, Pareja_pla from klplanesprecios a, klplanes b Where a.Codigo_PLA=b.Codigo_PLA and Nombre_PLA='".str_replace('_', ' ', $_GET["PLA"])."'";
		$result = mysqli_query($conexion, $SQL);
		while ($row = mysqli_fetch_array($result)) {
			echo "
				document.getElementById('txt_dia".$row[0].$NumWindow."').value='".$row[1]."';
			";
		}
		mysqli_free_result($result); 
	} 
?>

function BuscarPLA<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	str=document.getElementById('txt_plan<?php echo $NumWindow; ?>').value;
  	str=str.replace(/ /g, "_");
	AbrirForm('application/forms/klmodpareja.php', '<?php echo $NumWindow; ?>', '&PLA='+str);
   }
}


    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
