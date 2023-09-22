<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
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
	 		  <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-bs-toggle="modal" data-bs-target="#GnmX_Search" data-whatever="Planes" onclick="javascript:CargarSearch('KlPlanes', 'txt_plan<?php echo $NumWindow; ?>', '*1*=*1*');"><i class="fas fa-search"></i></button>
			 </span>
		</div>
	</div>
	<input name="hdn_codpla<?php echo $NumWindow; ?>" type="hidden" id="hdn_codpla<?php echo $NumWindow; ?>" value="0" />

		</div>
		<div class="col-md-8">
	
	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_descripcion<?php echo $NumWindow; ?>">Descripcion</label>
		<input  name="txt_descripcion<?php echo $NumWindow; ?>" id="txt_descripcion<?php echo $NumWindow; ?>" type="text"  disabled="disabled"/>
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="cmb_estado<?php echo $NumWindow; ?>">Estado</label>
		<select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>"   disabled="disabled">
		  <option value="0">Inactivo</option>
		  <option value="1">Activo</option>
		</select>

	</div>

		</div>

<label class="label label-default">PAISES</label>
	<div class="row well well-sm">
	  	<?php
	  		$SQL="Select Codigo_DST, Nombre_DST from kldestinos";
	  		$result = mysqli_query($conexion, $SQL);
			while ($row = mysqli_fetch_array($result)) {
				$valpais=0;
				$SQL="Select Codigo_DST from klplanesdestinos where Codigo_DST='".$row[0]."' and Codigo_PLA in (Select Codigo_PLA from klplanes Where Nombre_PLA='".str_replace('_', ' ', $_GET["PLA"])."')";
		  		$resultp = mysqli_query($conexion, $SQL);
				if ($rowp = mysqli_fetch_array($resultp)) {
					$valpais=1;
				}
				mysqli_free_result($resultp); 
	  	?>
	  	<div class="col-md-3">	
	  		<div class="checkbox checkbox-success">
				<input name="chk_pais<?php echo $row[0].$NumWindow; ?>" id="chk_pais<?php echo $row[0].$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:selpais<?php echo $NumWindow; ?>('<?php echo $row[0]; ?>');" class="styled" <?php if ($valpais==1) { echo 'checked="checked"'; } ?> >
				<label for="chk_pais<?php echo $row[0].$NumWindow; ?>"><?php echo $row[1]; ?></label>
			</div>
			<input name="hdn_paiz<?php echo $row[0].$NumWindow; ?>" type="hidden" id="hdn_paiz<?php echo $row[0].$NumWindow; ?>" value="<?php echo $valpais; ?>" />
		</div>
		<?php
			}
			mysqli_free_result($result); 
		?>
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
			echo " MsgBox1('Planes','No existe el plan: ".str_replace('_', ' ', $_GET["PLA"])."');";
		}
		mysqli_free_result($result); 
	} 
?>

function BuscarPLA<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
  	str=document.getElementById('txt_plan<?php echo $NumWindow; ?>').value;
  	str=str.replace(/ /g, "_");
	AbrirForm('application/forms/kldestinos.php', '<?php echo $NumWindow; ?>', '&PLA='+str);
	}
}

function selpais<?php echo $NumWindow; ?>(codpais) {
	if (document.getElementById('hdn_paiz'+codpais+'<?php echo $NumWindow; ?>').value=='1') {
		document.getElementById('hdn_paiz'+codpais+'<?php echo $NumWindow; ?>').value='0';
	} else {
		document.getElementById('hdn_paiz'+codpais+'<?php echo $NumWindow; ?>').value='1';
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
