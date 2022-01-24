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
	 		  <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-bs-toggle="modal" data-bs-target="#GnmX_Search" data-whatever="Planes" onclick="javascript:CargarSearch('KlPlanes', 'txt_plan<?php echo $NumWindow; ?>', '*1*=*1*');"><i class="fas fa-search"></i></button>
			 </span>
		</div>
	</div>
	<input name="hdn_codpla<?php echo $NumWindow; ?>" type="hidden" id="hdn_codpla<?php echo $NumWindow; ?>" value="0" />

		</div>
		<div class="col-md-8">
	
	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_descripcion<?php echo $NumWindow; ?>">Descripcion</label>
		<input  name="txt_descripcion<?php echo $NumWindow; ?>" id="txt_descripcion<?php echo $NumWindow; ?>" type="text"  />
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="cmb_estado<?php echo $NumWindow; ?>">Estado</label>
		<select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>">
		  <option value="0">Inactivo</option>
		  <option value="1">Activo</option>
		</select>

	</div>

		</div>

<label class="label label-default">Cobertura</label>
	<div class="row well well-sm">
	  		<div class="col-md-3 col-6">
	  			<input  name="txt_cobertura<?php echo $NumWindow; ?>" id="txt_cobertura<?php echo $NumWindow; ?>" type="text" placeholder="Nombre Esp"  />
	  		</div>
	  		<div class="col-6 col-md-3">
				<input name="txt_descripcionx<?php echo $NumWindow; ?>" id="txt_descripcionx<?php echo $NumWindow; ?>" type="text" placeholder="Descripcion Esp" />
	  		</div>

	  		<div class="col-md-3 col-6">
	  			<input  name="txt_coberturaEng<?php echo $NumWindow; ?>" id="txt_coberturaEng<?php echo $NumWindow; ?>" type="text" placeholder="Name Eng"  />
	  		</div>
	  		<div class="col-6 col-md-3">
				<div class="input-group">
					<input name="txt_descripcionxEng<?php echo $NumWindow; ?>" id="txt_descripcionxEng<?php echo $NumWindow; ?>" type="text" placeholder="Description Eng" />
					 <span class="input-group-btn"> 		
			 		  <button class="btn btn-success" type="button"  onclick="javascript:Addcobertura<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i></button>
					 </span>
				</div>
	  		</div>
			  
			<div class="col-md-12">

			 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive ">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
			<tbody id="tbcob<?php echo $NumWindow; ?>">
			<tr><th colspan="2">Español</th><th colspan="2">Inglés</th><th id="th2<?php echo $NumWindow; ?>"><i class="fas fa-eraser"></i> </th></tr>
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th1<?php echo $NumWindow; ?>">Nombre</th> 
				<th id="th2<?php echo $NumWindow; ?>">Descripcion</th> 
			    <th id="th1<?php echo $NumWindow; ?>">Name</th> 
				<th id="th2<?php echo $NumWindow; ?>">Description</th> 
			    <th id="th2<?php echo $NumWindow; ?>"> </th> 
			</tr> 
				 <?php 
				 if (isset($_GET["PLA"])) {	
				$SQL="Select nOMBRE_COB, DESCRIPCION_COB, nOMBREeng_COB, DESCRIPCIONeng_COB FROM klplanescobertura a, klplanes b WHERE a.Codigo_PLA=b.Codigo_PLA and  Nombre_PLA='".str_replace('_', ' ', $_GET["PLA"])."' Order by Orden_COB";
				$resulthc = mysqli_query($conexion, $SQL);
				$contarow=0;
				echo '';
				while($rowhc = mysqli_fetch_array($resulthc)) 
					{
						$contarow=$contarow+1;
						echo '
				  <tr id="tr'.$contarow.$NumWindow.'"><td align="left"><input name="hdn_cobertura'.$contarow.$NumWindow.'" type="hidden" id="hdn_cobertura'.$contarow.$NumWindow.'" value="'.$rowhc[0].'" />'.$rowhc[0].'</td><td align="right"><input name="hdn_descripcion'.$contarow.$NumWindow.'" type="hidden" id="hdn_descripcion'.$contarow.$NumWindow.'" value="'.$rowhc[1].'" />'.$rowhc[1].'</td>
				  <td align="left"><input name="hdn_coberturaeng'.$contarow.$NumWindow.'" type="hidden" id="hdn_coberturaeng'.$contarow.$NumWindow.'" value="'.$rowhc[2].'" />'.$rowhc[2].'</td><td align="right"><input name="hdn_descripcioneng'.$contarow.$NumWindow.'" type="hidden" id="hdn_descripcioneng'.$contarow.$NumWindow.'" value="'.$rowhc[3].'" />'.$rowhc[3].'</td>
				  <td><button onclick="EliminarFilaCOB'.$NumWindow.'(\''.$contarow.'\');" type="button" class="btn btn-danger btn-xs btn-block"> <i class="fas fa-eraser"></i> </button>
				  </td></tr>
				  ';
					}
				mysqli_free_result($resulthc); 
				 }
				 ?>
			</tbody>
			</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
			 </div>

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
			echo " MsgBox1('Planes','Va a crear un nuevo plan: ".str_replace('_', ' ', $_GET["PLA"])."');";
		}
		mysqli_free_result($result); 
	} 
?>

function BuscarPLA<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
  	str=document.getElementById('txt_plan<?php echo $NumWindow; ?>').value;
  	str=str.replace(/ /g, "_");
	AbrirForm('application/forms/klplanes.php', '<?php echo $NumWindow; ?>', '&PLA='+str);
	}
}

function Addcobertura<?php echo $NumWindow; ?>() {
	Cobertura=document.getElementById('txt_cobertura<?php echo $NumWindow; ?>').value;
	Descripcion=document.getElementById('txt_descripcionx<?php echo $NumWindow; ?>').value;
	CoberturaEng=document.getElementById('txt_coberturaEng<?php echo $NumWindow; ?>').value;
	DescripcionEng=document.getElementById('txt_descripcionxEng<?php echo $NumWindow; ?>').value;
		
	if (Cobertura!="") {
		Cobertura=Cobertura.toUpperCase();
		Descripcion=Descripcion.toUpperCase();
		CoberturaEng=CoberturaEng.toUpperCase();
		DescripcionEng=DescripcionEng.toUpperCase();
		TotalFilas=document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbcob<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
	    var celda5 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
		TotalFilas++;
		fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
	    celda1.innerHTML = '<input name="hdn_cobertura'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_cobertura'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Cobertura+''+'" /> '+Cobertura; 
		celda2.innerHTML = '<input name="hdn_descripcion'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_descripcion'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Descripcion+''+'" /> '+Descripcion; 
		celda4.innerHTML = '<input name="hdn_coberturaeng'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_coberturaeng'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CoberturaEng+''+'" /> '+CoberturaEng; 
		celda5.innerHTML = '<input name="hdn_descripcioneng'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_descripcioneng'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+DescripcionEng+''+'" /> '+DescripcionEng; 
		celda3.innerHTML = '<button onclick="EliminarFilaCOB<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda4); 
	    fila.appendChild(celda5); 
	    fila.appendChild(celda3); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_cobertura<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_descripcionx<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_coberturaEng<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_descripcionxEng<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_cobertura<?php echo $NumWindow; ?>').focus();
	}
}

function EliminarFilaCOB<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalle<?php echo $NumWindow; ?>");     
    $('#tr'+Numero+"<?php echo $NumWindow; ?>").remove();
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
