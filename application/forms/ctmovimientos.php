<?php
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;

	$CNT="";
	if (isset($_GET["CNT"])) {
		$CNT=$_GET["CNT"];
	}
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>"  enctype="multipart/form-data" >
<div class="col-sm-12">
		<label class="label label-default">Datos Comprobante</label>
	<div class="row well well-sm">

	<div class="col-sm-2">

<div class="form-group">
	<label for="Codigo_CNT<?php echo $NumWindow; ?>">Comprobante No.</label>
	<div class="input-group">
		<span class="input-group-btn">
			<button class="btn btn-success btn-sm" type="button" data-toggle="modal" id="btnCopy<?php echo $NumWindow; ?>" name="btnCopy<?php echo $NumWindow; ?>" data-target="#GnmX_Search" data-whatever="Codigo_CNT" onclick="javascript:CargarSearch('ctMovimiento', 'Codigo_CNT<?php echo $NumWindow; ?>', 'NULL'); CopyMov<?php echo $NumWindow; ?>();" title="Cargar Movimientos desde...">
				<i class="fas fa-copy"></i> 
			</button>
		</span>
		<input style="font-size:15px; font-weight: bold; text-align: right; color: #cc682e;" name="Codigo_CNT<?php echo $NumWindow; ?>" id="Codigo_CNT<?php echo $NumWindow; ?>" type="text" disabled="disabled" onblur="Duplicar<?php echo $NumWindow; ?>();"/>
	</div>
	<input name="HDN_CNT<?php echo $NumWindow; ?>" id="HDN_CNT<?php echo $NumWindow; ?>" type="hidden" value="X" />
</div>

	</div>
	<div class="col-sm-2">

	<div class="form-group">
		<label for="Codigo_FNC<?php echo $NumWindow; ?>">Tipo Documento</label>
		<select name="Codigo_FNC<?php echo $NumWindow; ?>" id="Codigo_FNC<?php echo $NumWindow; ?>" >
	  <?php 
	$SQL="Select Codigo_FNC, Nombre_FNC from czfuentescont";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
		{
	 ?>
	  <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
	<?php
		}
	mysqli_free_result($result); 
	 ?>
		</select>
	</div>

		</div>
		<div class="col-sm-5">

	<div class="form-group">
		<label for="Referencia_CNT<?php echo $NumWindow; ?>">Referencia</label>
		<input name="Referencia_CNT<?php echo $NumWindow; ?>" id="Referencia_CNT<?php echo $NumWindow; ?>" type="text" maxlength="50" />
	</div>
	
		</div>
		<div class="col-sm-1">

	<div class="form-group">
		<label for="Consec_FNC<?php echo $NumWindow; ?>"># Referencia</label>
		<input name="Consec_FNC<?php echo $NumWindow; ?>" id="Consec_FNC<?php echo $NumWindow; ?>" type="text" />
	</div>
	
		</div>
		<div class="col-sm-2">

	<div class="form-group">
		<label for="Fecha_CNT<?php echo $NumWindow; ?>">Fecha</label>
		<input name="Fecha_CNT<?php echo $NumWindow; ?>" id="Fecha_CNT<?php echo $NumWindow; ?>" type="date" />
	</div>
	
		</div>
		<div class="col-sm-12">
	
	<div class="form-group">
		<label for="Observaciones_CNT<?php echo $NumWindow; ?>">Observaciones</label>
		<textarea name="Observaciones_CNT<?php echo $NumWindow; ?>" rows="2" id="Observaciones_CNT<?php echo $NumWindow; ?>" > </textarea>
	</div>

		</div>
		
	</div>
</div>
<div class="col-sm-12">

	<label class="label label-default">Movimmientos Contables</label>
	  <div class="row well well-sm">	

<div class="col-sm-12">
	<div id="zero_detalle<?php echo $NumWindow; ?>" class=" table-responsive ">
		<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
		<thead id="thDetalle<?php echo $NumWindow; ?>">
		<tr id="trh<?php echo $NumWindow; ?>"> 
			<th colspan="2">TERCERO</th>
			<th colspan="2">CUENTA</th>
			<th>C. COSTO</th>
			<th>DEBITO</th>
			<th>CREDITO</th>
		</tr> 
		</thead>
		<tbody id="tbDetalle<?php echo $NumWindow; ?>">
		</tbody>
		</table>
		<div class="col-sm-2">
			<button class="btn btn-warning btn-xs" type="button" style="font-style: italic;" onclick="AddRow<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-plus" aria-hidden="true" ></span> Agregar Fila</button>
		</div>
	</div>
	<input type="hidden" name="TotRows<?php echo $NumWindow; ?>" id="TotRows<?php echo $NumWindow; ?>" value="0">
</div>
	
	</div>
</div>

</div>

<div class="col-sm-12">
	<label class="label label-default">Total Asiento</label>
	<div class="row well well-sm">

		<div class="col-sm-2 col-sm-offset-8">
	<div class="form-group">
		<label for="Total_CNT<?php echo $NumWindow; ?>">Total Débito</label>
		<input style="font-size:15px; font-weight: bold; text-align: right;" name="Total_CNT<?php echo $NumWindow; ?>" id="Total_CNT<?php echo $NumWindow; ?>" type="number" step="0.01" disabled="disabled" onchange="calcDiff<?php echo $NumWindow; ?>();"/>
	</div>
		</div>
		<div class="col-sm-2">
	<div class="form-group">
		<label for="Total2_CNT<?php echo $NumWindow; ?>">Total Crédito</label>
		<input style="font-size:15px; font-weight: bold; text-align: right;" name="Total2_CNT<?php echo $NumWindow; ?>" id="Total2_CNT<?php echo $NumWindow; ?>" type="number" step="0.01" disabled="disabled" onchange="calcDiff<?php echo $NumWindow; ?>();"/>
	</div>
		</div>
		<div class="col-sm-2 col-sm-offset-10">
	<div class="form-group">
		<label for="Diff<?php echo $NumWindow; ?>">Diferencia</label>
        <input style="font-size:15px; font-weight: bold; text-align: right;" name="Diff<?php echo $NumWindow; ?>" id="Diff<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
    </div>
		</div>

	</div>
</div>

</form>

<script >
var CopyCat="X";
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";

<?php 
if ($CNT=="") {
	echo "
		AddRow".$NumWindow."();
		document.frm_form".$NumWindow.".Codigo_CNT".$NumWindow.".disabled='disabled';
		FechaActual('Fecha_CNT".$NumWindow."');
		AddRow".$NumWindow."();
		";
	$SQL="Select Codigo_FNC from itconfig_ct";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "document.frm_form".$NumWindow.".Codigo_CNT".$NumWindow.".value='".$row["Codigo_CNT"]."';
document.frm_form".$NumWindow.".Codigo_FNC".$NumWindow.".value='".$row["Codigo_FNC"]."';
		";
	}
	mysqli_free_result($result);
} else  {
	$SQL="Select * from czmovcontcab Where Codigo_CNT='".$CNT."'";
	if ($CNT=='0') {
		$SQL="Select '0' as 'Codigo_CNT', SaldosIni_XCT as 'Codigo_FNC', ifnull(Fecha_CNT, curdate()) as 'Fecha_CNT', '0' as 'Consec_FNC', ifnull(Referencia_CNT,'SALDOS INICIALES CONTABILIDAD') as 'Referencia_CNT', ifnull(Total_CNT, 0) as 'Total_CNT', ifnull(Observaciones_CNT, 'CARGUE DE SALDOS INICIALES CONTABLES') as 'Observaciones_CNT' from itconfig_ct a left join czmovcontcab b on Codigo_CNT='0'";	
	}
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "document.frm_form".$NumWindow.".Codigo_CNT".$NumWindow.".value='".$row["Codigo_CNT"]."';
document.frm_form".$NumWindow.".Codigo_FNC".$NumWindow.".disabled='disabled';
document.frm_form".$NumWindow.".Codigo_FNC".$NumWindow.".value='".$row["Codigo_FNC"]."';
document.frm_form".$NumWindow.".Fecha_CNT".$NumWindow.".value='".$row["Fecha_CNT"]."';
document.frm_form".$NumWindow.".Consec_FNC".$NumWindow.".value='".$row["Consec_FNC"]."';
document.frm_form".$NumWindow.".Referencia_CNT".$NumWindow.".value='".$row["Referencia_CNT"]."';
document.frm_form".$NumWindow.".Total_CNT".$NumWindow.".value='".$row["Total_CNT"]."';
document.frm_form".$NumWindow.".Total2_CNT".$NumWindow.".value='".$row["Total_CNT"]."';
document.frm_form".$NumWindow.".Diff".$NumWindow.".value='0';
document.frm_form".$NumWindow.".Observaciones_CNT".$NumWindow.".value='".preg_replace("/\r\n|\n|\r/", "<br/>",$row["Observaciones_CNT"])."';
		";
		if (isset($_GET["Copy"])) {
			echo "document.frm_form".$NumWindow.".Codigo_CNT".$NumWindow.".value='';
			document.frm_form".$NumWindow.".Codigo_FNC".$NumWindow.".disabled=false;
			";
		}
	}
	mysqli_free_result($result);
	$SQL="Select  Codigo_TER, Codigo_CTA, Descripcion_CNT, Codigo_CCT, Debito_CNT, Credito_CNT from czmovcontdet Where Codigo_CNT='".$CNT."' order by Codigo_CTA";
	if ($CNT=='0') {
		$SQL="SELECT '', a.Codigo_CTA, a.Nombre_CTA as 'Descripcion_CNT', '' as 'Codigo_CCT', ifnull(b.Debito_CNT, 0) as 'Debito_CNT', ifnull(b.Credito_CNT,0) as 'Credito_CNT', Naturaleza_CLA FROM czclasescont c, czcuentascont a left JOIN czmovcontdet b ON a.Codigo_CTA=b.Codigo_CTA AND b.Codigo_CNT='0' WHERE c.Codigo_CLA=SUBSTRING(a.Codigo_CTA,1,1) and a.Codigo_NVL='5'";	
	}
	$result = mysqli_query($conexion, $SQL);
	$NumItem=0;
	while($row = mysqli_fetch_array($result)) {
		$NumItem++;
		echo "
AddRow".$NumWindow."();
document.frm_form".$NumWindow.".Codigo_CTA".$NumItem.$NumWindow.".value='".$row["Codigo_CTA"]."';
document.frm_form".$NumWindow.".Descripcion_CNT".$NumItem.$NumWindow.".value='".$row["Descripcion_CNT"]."';
document.frm_form".$NumWindow.".Codigo_CCT".$NumItem.$NumWindow.".value='".$row["Codigo_CCT"]."';
document.frm_form".$NumWindow.".Debito_CNT".$NumItem.$NumWindow.".value='".$row["Debito_CNT"]."';
document.frm_form".$NumWindow.".Credito_CNT".$NumItem.$NumWindow.".value='".$row["Credito_CNT"]."';
		";
		if ($CNT=='0') {
			echo "
				document.frm_form".$NumWindow.".Codigo_CTA".$NumItem.$NumWindow.".disabled='disabled';
				document.frm_form".$NumWindow.".Descripcion_CNT".$NumItem.$NumWindow.".disabled='disabled';
				document.frm_form".$NumWindow.".ID_TER".$NumItem.$NumWindow.".disabled='disabled';
				document.frm_form".$NumWindow.".Nombre_TER".$NumItem.$NumWindow.".disabled='disabled';
				document.frm_form".$NumWindow.".btnx".$NumItem.$NumWindow.".disabled='disabled';
				document.frm_form".$NumWindow.".btny".$NumItem.$NumWindow.".disabled='disabled';
				document.frm_form".$NumWindow.".Codigo_CCT".$NumItem.$NumWindow.".disabled='disabled';";
			if($row["Naturaleza_CLA"]=="Credito") {
				echo "
				document.frm_form".$NumWindow.".Debito_CNT".$NumItem.$NumWindow.".disabled='disabled';";
			} else {
				echo "
				document.frm_form".$NumWindow.".Credito_CNT".$NumItem.$NumWindow.".disabled='disabled';";
			}
		}
		$SQL="Select ID_TER, Nombre_TER from czterceros Where Codigo_TER='".$row[0]."'";
		$resultter = mysqli_query($conexion, $SQL);
		if($rowter = mysqli_fetch_array($resultter)) {
			echo "
document.frm_form".$NumWindow.".ID_TER".$NumItem.$NumWindow.".value='".$rowter["ID_TER"]."';
document.frm_form".$NumWindow.".Nombre_TER".$NumItem.$NumWindow.".value='".$rowter["Nombre_TER"]."';
		";
		}
		mysqli_free_result($resultter);	
	}
	mysqli_free_result($result);
}
?>

function CopyMov<?php echo $NumWindow; ?>() {
	CopyCat="Y";
	document.frm_form<?php echo $NumWindow; ?>.Codigo_CNT<?php echo $NumWindow; ?>.disabled=false;
	// document.frm_form<?php echo $NumWindow; ?>.Codigo_CNT<?php echo $NumWindow; ?>.focus();
}

function Duplicar<?php echo $NumWindow; ?>() {
	Valor=document.frm_form<?php echo $NumWindow; ?>.Codigo_CNT<?php echo $NumWindow; ?>.value;
	document.frm_form<?php echo $NumWindow; ?>.Codigo_FNC<?php echo $NumWindow; ?>.focus();
	if (Valor=="") {
		CopyCat="X";
		document.frm_form<?php echo $NumWindow; ?>.Codigo_CNT<?php echo $NumWindow; ?>.disabled=true;
	} else {
		AbrirForm('application/forms/ctmovimientos.php', '<?php echo $NumWindow; ?>', '&Copy=Copy&CNT='+Valor);
	}
}

function calcDiff<?php echo $NumWindow; ?>() {
	var totDiff=0;
	var totDeb=document.getElementById("Total_CNT<?php echo $NumWindow; ?>").value;
	var totCred=document.getElementById("Total2_CNT<?php echo $NumWindow; ?>").value;
	totDiff=totDeb - totCred;
	document.getElementById("Diff<?php echo $NumWindow; ?>").value=totDiff;
	if (totDiff==0) {
		document.getElementById("Diff<?php echo $NumWindow; ?>").style="font-size:15px; font-weight: bold; text-align: right; color: #729d3b;";
	} else {
		document.getElementById("Diff<?php echo $NumWindow; ?>").style="font-size:15px; font-weight: bold; text-align: right; color: #bf4141;";
	}
}

function calcDeb<?php echo $NumWindow; ?>() {
	var totDeb=0;
	var valDeb=0;
	var totCred=0;
	var valCred=0;
	totRows=document.getElementById("TotRows<?php echo $NumWindow; ?>").value;
	for (var i = totRows; i >= 1; i--) {
		if (document.getElementById("Debito_CNT"+i+"<?php echo $NumWindow; ?>").value=="") {
			document.getElementById("Debito_CNT"+i+"<?php echo $NumWindow; ?>").value="0";
		}
		valDeb=parseFloat(document.getElementById("Debito_CNT"+i+"<?php echo $NumWindow; ?>").value);
		if (valDeb!=0) {
			document.getElementById("Credito_CNT"+i+"<?php echo $NumWindow; ?>").value="0";
		}
		totDeb=totDeb + valDeb;
		valCred=parseFloat(document.getElementById("Credito_CNT"+i+"<?php echo $NumWindow; ?>").value);
		if (valCred!=0) {
			document.getElementById("Debito_CNT"+i+"<?php echo $NumWindow; ?>").value="0";
		}
		totCred=totCred + valCred;
	}
	document.getElementById("Total_CNT<?php echo $NumWindow; ?>").value=totDeb;
	document.getElementById("Total2_CNT<?php echo $NumWindow; ?>").value=totCred;
	calcDiff<?php echo $NumWindow; ?>();
}

function calcCred<?php echo $NumWindow; ?>() {
	var totDeb=0;
	var valDeb=0;
	var totCred=0;
	var valCred=0;
	totRows=document.getElementById("TotRows<?php echo $NumWindow; ?>").value;
	for (var i = totRows; i >= 1; i--) {
		if (document.getElementById("Credito_CNT"+i+"<?php echo $NumWindow; ?>").value=="") {
			document.getElementById("Credito_CNT"+i+"<?php echo $NumWindow; ?>").value="0";
		}
		valCred=parseFloat(document.getElementById("Credito_CNT"+i+"<?php echo $NumWindow; ?>").value);
		if (valCred!=0) {
			document.getElementById("Debito_CNT"+i+"<?php echo $NumWindow; ?>").value="0";
		}
		totCred=totCred + valCred;
		valDeb=parseFloat(document.getElementById("Debito_CNT"+i+"<?php echo $NumWindow; ?>").value);
		if (valDeb!=0) {
			document.getElementById("Credito_CNT"+i+"<?php echo $NumWindow; ?>").value="0";
		}
		totDeb=totDeb + valDeb;
	}
	document.getElementById("Total_CNT<?php echo $NumWindow; ?>").value=totDeb;
	document.getElementById("Total2_CNT<?php echo $NumWindow; ?>").value=totCred;
	calcDiff<?php echo $NumWindow; ?>();
}

function cttercero<?php echo $NumWindow; ?>(Fila)
{
	var IDTer=document.getElementById("ID_TER"+Fila+"<?php echo $NumWindow; ?>").value;
	$.get(Funciones,{'Func':'NombreTercero','value':IDTer,'tabla':'czterceros'},function(data){ 
		document.getElementById('Nombre_TER'+Fila+'<?php echo $NumWindow; ?>').value=data;
	});
}

function ctcuenta<?php echo $NumWindow; ?>(Fila)
{
	var CodCTA=document.getElementById("Codigo_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	var DescCTA=document.getElementById("Descripcion_CNT"+Fila+"<?php echo $NumWindow; ?>").value;
	if (DescCTA=="") {
		$.get(Funciones,{'Func':'NombreCuenta','value':CodCTA},function(data){ 
			document.getElementById('Descripcion_CNT'+Fila+'<?php echo $NumWindow; ?>').value=data;
		});
	}
}

function saveMovCont<?php echo $NumWindow; ?>() {
	Guardar_ctmovimientos('<?php echo $NumWindow; ?>') 
}

function AddRow<?php echo $NumWindow; ?>() {
	var TotalFilas=document.getElementById("TotRows<?php echo $NumWindow; ?>").value;
	var miTabla = document.getElementById("tbDetalle<?php echo $NumWindow; ?>"); 
    var fila = document.createElement("tr"); 
    TotalFilas++;
    Komillas="\'";
    fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
	var celda1 = document.createElement("td");
	celda1.style = 'width:10%;';
	celda1.innerHTML = '<div class="input-group"><input type="text" name="ID_TER'+TotalFilas+'<?php echo $NumWindow; ?>" id="ID_TER'+TotalFilas+'<?php echo $NumWindow; ?>" value="" style="border-width: 0px; background-color: white; font-size: 11px; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px; text-transform: none;" class="form-control" onblur="javascript:cttercero<?php echo $NumWindow; ?>(\''+TotalFilas+'\')"><span class="input-group-btn"><button class="btn btn-success btn-sm" type="button" data-toggle="modal" id="btnx'+TotalFilas+'<?php echo $NumWindow; ?>" name="btnx'+TotalFilas+'<?php echo $NumWindow; ?>" data-target="#GnmX_Search" data-whatever="ID_TER" onclick="javascript:CargarSearch(\'Tercero\', \'ID_TER'+TotalFilas+'<?php echo $NumWindow; ?>\', \'NULL\');"><i class="fas fa-search"></i></button></span></div>';
	fila.appendChild(celda1);	
	var celda2 = document.createElement("td");
	celda2.style = 'width:16%;';
	celda2.innerHTML = '<input type="text" name="Nombre_TER'+TotalFilas+'<?php echo $NumWindow; ?>" id="Nombre_TER'+TotalFilas+'<?php echo $NumWindow; ?>" value="" style="border-width: 0px; background-color: white; font-size: 11px; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px; text-transform: none;" class="form-control" disabled="disabled">';
	fila.appendChild(celda2);
	var celda3 = document.createElement("td");
	celda3.style = 'width:10%;';
	celda3.innerHTML = '<div class="input-group"><input type="text" name="Codigo_CTA'+TotalFilas+'<?php echo $NumWindow; ?>" id="Codigo_CTA'+TotalFilas+'<?php echo $NumWindow; ?>" value="" style="border-width: 0px; background-color: white; font-size: 11px; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px; text-transform: none;" class="form-control"  onblur="javascript:ctcuenta<?php echo $NumWindow; ?>(\''+TotalFilas+'\')"><span class="input-group-btn"><button class="btn btn-success btn-sm" type="button" name="btny'+TotalFilas+'<?php echo $NumWindow; ?>" id="btny'+TotalFilas+'<?php echo $NumWindow; ?>" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ID_TER" onclick="javascript:CargarSearch(\'PUC\', \'Codigo_CTA'+TotalFilas+'<?php echo $NumWindow; ?>\', \'Codigo_NVL=*5*\');"><i class="fas fa-search"></i></button></span></div>';
	fila.appendChild(celda3);
	var celda4 = document.createElement("td");
	celda4.style = 'width:19%;';
	celda4.innerHTML = '<input type="text" name="Descripcion_CNT'+TotalFilas+'<?php echo $NumWindow; ?>" id="Descripcion_CNT'+TotalFilas+'<?php echo $NumWindow; ?>" value="" style="border-width: 0px; background-color: white; font-size: 11px; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px; text-transform: none;" class="form-control">';
	fila.appendChild(celda4);
	<?php
	$SQL="Select Codigo_CCT, Nombre_CCT from czcentrocosto Order By 2";
	$result = mysqli_query($conexion, $SQL);
	$Optinex='<option value=""></option>';
	while($row = mysqli_fetch_array($result)) {
		$Optinex=$Optinex.'<option value="'.$row[0].'">'.$row[1].'</option>';
	}
	mysqli_free_result($result);
	?>
	var optionex = '<?php echo $Optinex; ?>';
	var celda5 = document.createElement("td");
	celda5.style = 'width:15%;';
	celda5.innerHTML = '<select name="Codigo_CCT'+TotalFilas+'<?php echo $NumWindow; ?>" id="Codigo_CCT'+TotalFilas+'<?php echo $NumWindow; ?>"  style="border-width: 0px; background-color: white; font-size: smaller; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px;" class="form-control">'+optionex+'</select>';
	fila.appendChild(celda5);
	var celda6 = document.createElement("td");
	celda6.style = 'width:15%;';
	celda6.innerHTML = '<input type="number" min="0" step="0.01" name="Debito_CNT'+TotalFilas+'<?php echo $NumWindow; ?>" id="Debito_CNT'+TotalFilas+'<?php echo $NumWindow; ?>" value="0" style="border-width: 0px; background-color: white; font-size: 11px; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px; text-transform: none; text-align:right;" class="form-control" onkeyup="calcDeb<?php echo $NumWindow; ?>();" onchange="calcDeb<?php echo $NumWindow; ?>();">';
	fila.appendChild(celda6);
	var celda7 = document.createElement("td");
	celda7.style = 'width:15%;';
	celda7.innerHTML = '<input type="number" min="0" step="0.01" name="Credito_CNT'+TotalFilas+'<?php echo $NumWindow; ?>" id="Credito_CNT'+TotalFilas+'<?php echo $NumWindow; ?>" value="0" style="border-width: 0px; background-color: white; font-size: 11px; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px; text-transform: none; text-align:right;" class="form-control" onkeyup="calcCred<?php echo $NumWindow; ?>();" onchange="calcCred<?php echo $NumWindow; ?>();">';
	fila.appendChild(celda7);
	miTabla.appendChild(fila);
    document.getElementById("TotRows<?php echo $NumWindow; ?>").value=TotalFilas; 
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
</script>
<script src="functions/nexus/ctmovimientos.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
