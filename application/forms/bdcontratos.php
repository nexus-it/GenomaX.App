<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">
<div class="row well well-sm">

		<div class="col-md-1">

<div class="form-group">
	<label for="txt_codigo<?php echo $NumWindow; ?>">Codigo</label>
	<div class="input-group">
		<input name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" onkeypress="BuscarCodigo<?php echo $NumWindow; ?>(event);" value=""/>
		<span class="input-group-btn">
	      <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Contrato" onclick="javascript:CargarSearch('Contrato', 'txt_codigo<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
	    </span>
	</div>
</div>
		</div>
		<div class="col-md-3">
<div class="form-group">
	<label for="txt_nombreeps<?php echo $NumWindow; ?>">Descripcion Contrato</label>
	<input name="txt_nombreeps<?php echo $NumWindow; ?>" type="text" id="txt_nombreeps<?php echo $NumWindow; ?>" style="font-size:14px; font-weight: bold;" disabled="disabled" />
</div>
		</div>
		<div class="col-md-2">

<div class="form-group">
	<label for="txt_contrato<?php echo $NumWindow; ?>">No. Contrato</label>
	<input name="txt_contrato<?php echo $NumWindow; ?>" type="text" id="txt_contrato<?php echo $NumWindow; ?>"  style="color: #8b1329;font-size:15px; text-align:center;font-weight: bold;" disabled="disabled" />
</div>
	
		</div>
		<div class="col-md-2">


<div class="form-group">
<label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicio</label>
<input name="txt_fechaini<?php echo $NumWindow; ?>"  id="txt_fechaini<?php echo $NumWindow; ?>" type="date" required class="form-control"/>
</div>
		</div>
		<div class="col-md-2">

<div class="form-group">
<label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Fin</label>
<input name="txt_fechafin<?php echo $NumWindow; ?>" id="txt_fechafin<?php echo $NumWindow; ?>"  type="date" required class="form-control"/>
</div>
		
		</div>
		<div class="col-md-2">

<div class="form-group">
<label for="btn_file<?php echo $NumWindow; ?>">Cargar Archivo</label>
<input type="file"  id="btn_file<?php echo $NumWindow; ?>" onchange="upload_plano<?php echo $NumWindow; ?>();" class="form-control"> 
</div>
		
		</div>

</div>

<div class="row well well-sm" style="height: 32px">
		
		<div class="col-md-12" id="Preview<?php echo $NumWindow; ?>">

		</div>

</div>
</form>

<script >

<?php
	if (isset($_GET["Codigo"])) {
		echo "document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["Codigo"]."';";
	$SQL="Select *, date(now()) as ahora from gxeps a, czterceros b where a.Codigo_TER=b.Codigo_TER and Codigo_EPS='".$_GET["Codigo"]."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		if ($row["Estado_EPS"]!='1'){
			echo "
			MsgBox1('Contratos','El Contrato ".$_GET["Codigo"]." se encuentra inactivo');
			";}
	echo "
		document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$row["Codigo_EPS"]."';
		document.frm_form".$NumWindow.".txt_nombreeps".$NumWindow.".value='".$row["Nombre_EPS"]."';
		document.frm_form".$NumWindow.".txt_contrato".$NumWindow.".value='".$row["Contrato_EPS"]."';
		document.frm_form".$NumWindow.".txt_fechaini".$NumWindow.".value='".$row["ahora"]."';
		document.frm_form".$NumWindow.".txt_fechafin".$NumWindow.".value='".$row["FechaFin_EPS"]."';
		
	";
	}
	mysqli_free_result($result); 
	}else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>
function upload_plano<?php echo $NumWindow; ?>(e) {
	document.getElementById("Preview<?php echo $NumWindow; ?>").innerHTML= '<div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="99" aria-valuemin="0" aria-valuemax="100" style="width: 100%">';
	var inputFileImage = document.getElementById("btn_file<?php echo $NumWindow; ?>");
	var file = inputFileImage.files[0];
	var data = new FormData();
	data.append('fileToUpload',file);
	
	/*jQuery.each($('#fileToUpload')[0].files, function(i, file) {
		data.append('file'+i, file);
	});*/

	LoadPoblacion('<?php echo $NumWindow; ?>',data)

				
	$.ajax({
		url: "functions/php/nexus/upld.php",        // Url to which the request is send
		type: "POST",             // Type of request to be send, called as method
		data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
		contentType: false,       // The content type used when sending data to the server.
		cache: false,             // To unable request pages to be cached
		processData:false,        // To send DOMDocument or non processed data file it is set to false
		success: function(data)   // A function to be called if request succeeds
		{
			window.setTimeout(function() {
			$(".alert-dismissible").fadeTo(500, 0).slideUp(500, function(){
			$(this).remove();
			});	}, 5000);
			document.getElementById("Preview<?php echo $NumWindow; ?>").style="height:150px";
		}
	});
	
}

function BuscarCodigo<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/bdcontratos.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/bdcontratos.php', '<?php echo $NumWindow; ?>', '&Codigo='+document.getElementById('txt_codigo<?php echo $NumWindow; ?>').value);
	}  
  }
}
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");

</script>