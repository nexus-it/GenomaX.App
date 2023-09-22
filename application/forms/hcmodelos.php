<?php
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;

$CodigoHCT="";
if (isset($_GET["HCTNew"])) {
	$CodigoHCT=$_GET["HCTNew"];
}
if (isset($_GET["FromHC"])) {
	$CodigoHCT=$_GET["FromHC"];
}
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" action="functions/php/nexus/uploads.php?route=images&class=terceros&style=profile&wind=<?php echo $NumWindow; ?>" enctype="multipart/form-data" target="upload_target<?php echo $NumWindow; ?>" onreset="document.frm_form<?php echo $NumWindow; ?>.hdn_terceros<?php echo $NumWindow; ?>.value='<?php echo session_id(); ?>';FirmaMed<?php echo $NumWindow; ?>('white.png');">
	<div class="row">

		<div class="col-sm-2">

	<div class="form-group">
		<label for="Codigo_HCT<?php echo $NumWindow; ?>">Codigo HC</label>
		<div class="input-group">	
			<input name="Codigo_HCT<?php echo $NumWindow; ?>" id="Codigo_HCT<?php echo $NumWindow; ?>" type="text" maxlength="10" onkeypress="edithckey<?php echo $NumWindow; ?>(event);" onblur="edithc<?php echo $NumWindow; ?>()" style="text-transform: none;" />
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('ModelosHC', 'Codigo_HCT<?php echo $NumWindow; ?>', 'Activo_HCT<>*X*');"><i class="fas fa-search"></i></button>
			</span>
		</div>
	</div>

		</div>
		<div class="col-sm-4">

	<div class="form-group">
		<label for="Nombre_HCT<?php echo $NumWindow; ?>">Formato de Historia Clínica</label>
		<input name="Nombre_HCT<?php echo $NumWindow; ?>" id="Nombre_HCT<?php echo $NumWindow; ?>" type="text" maxlength="65" onblur="namehc<?php echo $NumWindow; ?>()" style="text-transform: none;" />
	</div>
	
		</div>
		<div class="col-sm-2">

	<div class="form-group">
		<label for="Activo_HCT<?php echo $NumWindow; ?>">Estado</label>
		<select name="Activo_HCT<?php echo $NumWindow; ?>" id="Activo_HCT<?php echo $NumWindow; ?>">
			<option value="0">Inactivo</option>
			<option value="1">Activo</option>
		</select>
	</div>
	
		</div>
		<div class="col-sm-4">
	
	<div class="form-group">
		<label for="cmb_from<?php echo $NumWindow; ?>">Crear formato a partir de</label>
	  <select name="cmb_from<?php echo $NumWindow; ?>" id="cmb_from<?php echo $NumWindow; ?>" onchange="selecthc<?php echo $NumWindow; ?>(this.value);">
	    <option value="0">NUEVO FORMATO</option>
	<?php 
	$SQL="Select Codigo_HCT, Nombre_HCT from hctipos order by 2";
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
		<div class="col-sm-12">

	  <div class="row well well-sm table-responsive">
	  	<table class="table table-striped table-condensed" width="100%">
	  	  <tr>
	  		<th width="17%" align="center"> Opción</th>
	  		<th width="26%" align="center"> Valor</th>
	  		<th width="17%" align="center"> Opción</th>
	  		<th width="11%" align="center"> Valor</th>
	  		<th width="17%" align="center"> Opción</th>
	  		<th width="11%" align="center"> Valor</th>
	  	  </tr>
	  	  <tbody>
	  	  	<tr>
	  	  	  <td>Encabezado</td>
	  	  	  <td>
	  	  	  	<select name="Codigo_HCH<?php echo $NumWindow; ?>" id="Codigo_HCH<?php echo $NumWindow; ?>">
			<?php 
			$SQL="Select Codigo_HCH, Nombre_HCH from hcencabezados where Estado_HCH='1' order by 2";
			$result = mysqli_query($conexion, $SQL);
			while($row = mysqli_fetch_array($result)) {
			 ?>
			      <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
			<?php
				}
			mysqli_free_result($result); 
			 ?>  
			    </select>
			  </td>
			  <td>Mostrar en Epicrisis</td>
			  <td>
			  	<?php nxs_yesno('Epicrisis_HCT', $NumWindow); ?>
	  		  </td>
	  	  	  <td>Actualizar Antecedentes</td>
			  <td>
			  	<?php nxs_yesno('Antecedentes_HCT', $NumWindow); ?>
			  </td>
			</tr>
	  	  	<tr>
			  <td>Aceptar Imágenes</td>
			  <td>
			  	<select name="Img_HCT<?php echo $NumWindow; ?>" id="Img_HCT<?php echo $NumWindow; ?>">
				  <option value="0">NO</option>
				  <option value="1">Como adjunto</option>
				  <option value="1">Página Completa</option>
				</select>
			  </td>
			  <td>Clasificar Diagnóstico</td>
			  <td>
			  	<?php nxs_yesno('Dx_HCT', $NumWindow); ?>
			  </td>
			  <td>Escala Glasgow</td>
			  <td>
			    <?php nxs_yesno('Glasgow_HCT', $NumWindow); ?>
			  </td>
			</tr>
	  	  	<tr>
			  <td>Formato Signos Vitales</td>
	  	  	  <td>
	  	  	  	<select name="SV_HCT<?php echo $NumWindow; ?>" id="SV_HCT<?php echo $NumWindow; ?>">
			  	  <option value="0">No incluir Signos Vitales</option>
			<?php 
			$SQL="Select Codigo_SV1, Nombre_SV1 from hcsv1 where Activo_SV1='1' order by 1";
			$result = mysqli_query($conexion, $SQL);
			while($row = mysqli_fetch_array($result)) {
			 ?>
			      <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
			<?php
				}
			mysqli_free_result($result); 
			 ?>  
			    </select>
			  </td>
			  <td>Cargar Insumos</td>
			  <td>
			  	<?php nxs_yesno('Insumos_HCT', $NumWindow); ?>
			  </td>
			  <td>Exámenes Diagnósticos</td>
			  <td>
			  	<?php nxs_yesno('AyudasDiag_HCT', $NumWindow); ?>
			  </td>
			</tr>
	  	  	<tr>
			  <td>Firma Profesional</td>
			  <td>
			  	<select name="Medico2_HCT<?php echo $NumWindow; ?>" id="Medico2_HCT<?php echo $NumWindow; ?>">
				  <option value="0">Quien Realiza La HC</option>
				  <option value="2">Dos Profesionales</option>
				  <option value="3">Tres Profesionales</option>
				</select>
			  </td>
			  <td>Formular Medicamentos</td>
			  <td>
			  	<?php nxs_yesno('Med_HCT', $NumWindow); ?>
			  </td>
			  <td>Indicaciones Médicas</td>
			  <td>
			  	<?php nxs_yesno('Indicaciones_HCT', $NumWindow); ?>
			  </td>
			</tr>
	  	  	<tr>
			  <td>Cargar Servicio a Factura</td>
			  <td>
			  	<div class="input-group col-sm-4" style="float: left;">	
				  <input name="Codigo_SER<?php echo $NumWindow; ?>" id="Codigo_SER<?php echo $NumWindow; ?>" type="text" maxlength="10" />
				  <span class="input-group-btn">	
				    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ServiciosX1" onclick="javascript:CargarSearch('ServiciosX1', 'Codigo_SER<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
				  </span>
				</div>
				<div class="col-sm-8" style="float: left; font-size: 8px;">
				  <input name="txt_servicio<?php echo $NumWindow; ?>" id="txt_servicio<?php echo $NumWindow; ?>" type="text" disabled/>
				</div>
			  </td>
			  <td>Capturar Firma Paciente</td>
			  <td>
			  	<?php nxs_yesno('FirmaPTE_HCT', $NumWindow); ?>
			  </td>
			  <td>HC Perteneciente a Triage</td>
			  <td>
			  	<?php nxs_yesno('Triage_HCT', $NumWindow); ?>
			  </td>
			</tr>
	  	  	<tr>
			  <td>HC Perteneciente a P&P</td>
			  <td>
			  	<?php nxs_yesno('PyP_HCT', $NumWindow); ?>
			  </td>
			  <td>Solicitar Procedimentos Qx</td>
			  <td>
			  	<?php nxs_yesno('Qx_HCT', $NumWindow); ?>
			  </td>
			  <td>Odontograma</td>
			  <td>
			  	<?php nxs_yesno('Odontograma_HCT', $NumWindow); ?>
			  </td>
			</tr>
			<tr>
			  <td>Consentimiento Informado</td>
			  <td colspan="5">
			  	<textarea rows="2" placeholder="Si va a incluirlo, escriba acá el texto. De lo contrario, deje en blanco. Puede usar etiquetas html" style="text-transform: none;" ></textarea>
			  </td>
			</tr>
	  	  </tbody>

	  	</table>
	  
	</div>
	  	</div>
	  	


	  	</div>
	  </div>
		
 <input type="hidden" name="Descripcion_HCT<?php echo $NumWindow; ?>" id="Descripcion_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="DescQx_HCT<?php echo $NumWindow; ?>" id="DescQx_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="RiesgoEspecif_HCT<?php echo $NumWindow; ?>" id="RiesgoEspecif_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="AntGineObs_HCT<?php echo $NumWindow; ?>" id="AntGineObs_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="EmbarazoAct_HCT<?php echo $NumWindow; ?>" id="EmbarazoAct_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="RiesgoObst_HCT<?php echo $NumWindow; ?>" id="RiesgoObst_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="RiesgoCardV_HCT<?php echo $NumWindow; ?>" id="RiesgoCardV_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="CtrlParacObs_HCT<?php echo $NumWindow; ?>" id="CtrlParacObs_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="CtrlHiperTen_HCT<?php echo $NumWindow; ?>" id="CtrlHiperTen_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="CtrlPreNat_HCT<?php echo $NumWindow; ?>" id="CtrlPreNat_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="Framingham_HCT<?php echo $NumWindow; ?>" id="Framingham_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="EscFramingham_HCT<?php echo $NumWindow; ?>" id="EscFramingham_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="Consentimiento_HCT<?php echo $NumWindow; ?>" id="Consentimiento_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="SexoM_HCT<?php echo $NumWindow; ?>" id="SexoM_HCT<?php echo $NumWindow; ?>" value="1">
<input type="hidden" name="SexoF_HCT<?php echo $NumWindow; ?>" id="SexoF_HCT<?php echo $NumWindow; ?>" value="1">
<input type="hidden" name="RipsAC_HCT<?php echo $NumWindow; ?>" id="RipsAC_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="Icono_HCT<?php echo $NumWindow; ?>" id="Icono_HCT<?php echo $NumWindow; ?>" value="GenomaX">
<input type="hidden" name="Ordenes_HCT<?php echo $NumWindow; ?>" id="Ordenes_HCT<?php echo $NumWindow; ?>">
<input type="hidden" name="Incapacidad_HCT<?php echo $NumWindow; ?>" id="Incapacidad_HCT<?php echo $NumWindow; ?>">


<div class="col-sm-12">

	<label class="label label-default">Campos</label>
	  <div class="row well well-sm">	

<div class="col-sm-12">
	<div id="zero_detalle<?php echo $NumWindow; ?>" class=" table-responsive ">
		<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
		<thead id="thDetalle<?php echo $NumWindow; ?>">
		<tr id="trh<?php echo $NumWindow; ?>"> 
			<?php
			$SQL="SELECT left(COLUMN_NAME, length(COLUMN_NAME)-4) FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hccampos' AND COLUMN_NAME not in ('Codigo_HCT')";
		$resultHCA = mysqli_query($conexion, $SQL);
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			echo '<th>'.$rowHCA[0].'</th>';
		}
		mysqli_free_result($resultHCA);
			?>
		</tr> 
		</thead>
		<tbody id="tbDetalle<?php echo $NumWindow; ?>">
<?php
$Item=0;
if ($CodigoHCT!="") {
	$SQL="Select * from hccampos Where Codigo_HCT='".$CodigoHCT."' order by Orden_HCC";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) {
		$Item++;
		echo '<tr id="tr'.$Item.$NumWindow.'"> ';
		$SQL="SELECT COLUMN_NAME, COLUMN_DEFAULT, case DATA_TYPE when 'int' then 'number' when 'enum' then 'select' else 'text' end , COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hccampos' AND COLUMN_NAME not in ('Codigo_HCT')";
		$resultHCA = mysqli_query($conexion, $SQL);
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			$campo=$rowHCA[0];
			$CampType=$rowHCA[2];
			if ($CampType=="select") {
?>
<td>
	<select name="<?php echo $rowHCA[0].$Item.$NumWindow; ?>" id="<?php echo $rowHCA[0].$Item.$NumWindow; ?>"  style="border-width: 0px; background-color: transparent; font-size: smaller; padding: 5px;">
		<option value="text" <?php if ($row[$campo]=="text") { echo 'selected'; } ?>>TEXTO</option>		
		<option value="textarea" <?php if ($row[$campo]=="textarea") { echo 'selected'; } ?>>PARRAFO</option>		
		<option value="check" <?php if ($row[$campo]=="check") { echo 'selected'; } ?>>CHECK</option>		
		<option value="image" <?php if ($row[$campo]=="image") { echo 'selected'; } ?>>IMAGEN</option>		
		<option value="date" <?php if ($row[$campo]=="date") { echo 'selected'; } ?>>FECHA</option>		
		<option value="time" <?php if ($row[$campo]=="time") { echo 'selected'; } ?>>HORA</option>		
		<option value="label" <?php if ($row[$campo]=="label") { echo 'selected'; } ?>>ETIQUETA</option>		
		<option value="select" <?php if ($row[$campo]=="select") { echo 'selected'; } ?>>SELECCION</option>
		<option value="well" <?php if ($row[$campo]=="well") { echo 'selected'; } ?>>GRUPO</option>		
		<option value="collapse" <?php if ($row[$campo]=="collapse") { echo 'selected'; } ?>>GRUPO COLAPSE</option>		
		
	</select>
</td>
<?php
			} else {
?>
<td>
	<input type="<?php echo $CampType; ?>" name="<?php echo $rowHCA[0].$Item.$NumWindow; ?>" id="<?php echo $rowHCA[0].$Item.$NumWindow; ?>" value="<?php echo $row[$campo]; ?>" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none;">
</td>
<?php
			}
		}
		mysqli_free_result($resultHCA);
		echo '</tr> ';
	}
	mysqli_free_result($result); 
}
?>
		</tbody>
		</table>
		<div class="col-sm-2">
			<button class="btn btn-default" type="button" style="background-color: #f4fafb;font-style: italic;" onclick="AddRow<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-plus" aria-hidden="true" ></span> Agregar Fila</button>
		</div>
	</div>
	<input type="hidden" name="TotRows<?php echo $NumWindow; ?>" id="TotRows<?php echo $NumWindow; ?>" value="<?php echo $Item; ?>">
</div>
	
	</div>
</div>

<div class="col-sm-12">

	<label class="label label-default">Opciones de Selección</label>
	  <div class="row well well-sm">
<div class="col-sm-8 col-md-offset-2">
	<div id="zero_detalle2<?php echo $NumWindow; ?>" class=" table-responsive ">
		<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle2<?php echo $NumWindow; ?>" >
		<thead id="thDetalle2<?php echo $NumWindow; ?>">
		<tr id="trh2<?php echo $NumWindow; ?>"> 
			<th>Campo</th><th>Orden</th><th>Valor</th><th>Opción</th><th>Script</th><th>Sel</th>
		</tr> 
		</thead>
		<tbody id="tbDetalle2<?php echo $NumWindow; ?>">
<?php
$Item=0;
if ($CodigoHCT!="") {
	$SQL="Select * from hccamposlistas Where Codigo_HCT='".$CodigoHCT."' order by Codigo_HCC, Orden_HCC";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) {
		$Item++;
		echo '<tr id="tr'.$Item.$NumWindow.'"> ';
		$SQL="SELECT COLUMN_NAME, COLUMN_DEFAULT, case DATA_TYPE when 'int' then 'number' when 'enum' then 'select' else 'text' end , COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hccamposlistas' AND COLUMN_NAME not in ('Codigo_HCT')";
		$resultHCA = mysqli_query($conexion, $SQL);
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			$campo=$rowHCA[0];
			$CampType=$rowHCA[2];
?>
<td>
	<input type="<?php echo $CampType; ?>" name="<?php echo 'l'.$rowHCA[0].$Item.$NumWindow; ?>" id="<?php echo 'l'.$rowHCA[0].$Item.$NumWindow; ?>" value="<?php echo $row[$campo]; ?>" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none;">
</td>
<?php
		}
		mysqli_free_result($resultHCA);
		echo '</tr> ';
	}
	mysqli_free_result($result); 
}
?>
		</tbody>
		</table>
		<div class="col-sm-2">
			<button class="btn btn-default" type="button" style="background-color: #f4fafb;font-style: italic;" onclick="AddRow2<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-plus" aria-hidden="true" ></span> Agregar Fila</button>
		</div>
	</div>
	<input type="hidden" name="TotRows2<?php echo $NumWindow; ?>" id="TotRows2<?php echo $NumWindow; ?>" value="<?php echo $Item; ?>">
</div>
	  </div>

</div>

</div>
</div>
</form>

<script >

<?php 
if ($CodigoHCT!="") {
	echo "
		document.frm_form".$NumWindow.".Codigo_HCT".$NumWindow.".value='".$_GET["HCTNew"]."';
		document.frm_form".$NumWindow.".Nombre_HCT".$NumWindow.".value='".$_GET["HCTName"]."';
		document.frm_form".$NumWindow.".Activo_HCT".$NumWindow.".value='".$_GET["HCTActive"]."';
		";
	if (isset($_GET["FromHC"])) {
		echo "document.frm_form".$NumWindow.".cmb_from".$NumWindow.".value='".$_GET["FromHC"]."';
		";
	}
	$SQL="Select * from hctipos Where Codigo_HCT='".$CodigoHCT."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		if ($_GET["HCTNew"]==$CodigoHCT) {
			$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hctipos' AND COLUMN_NAME not in ('Codigo_HCT')";
		} else {
			$SQL="SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hctipos' AND COLUMN_NAME not in ('Codigo_HCT', 'Nombre_HCT', 'Activo_HCT')";
		}
		$resultHCA = mysqli_query($conexion, $SQL);
		while ($rowHCA = mysqli_fetch_row($resultHCA)) {
			echo "document.frm_form".$NumWindow.".".$rowHCA[0].$NumWindow.".value='".$row[$rowHCA[0]]."';
		";
		}
		mysqli_free_result($resultHCA);
	}
	mysqli_free_result($result); 
} else {
	echo '
		$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();
';
}
?>
AddRow<?php echo $NumWindow; ?>();
AddRow2<?php echo $NumWindow; ?>();

function selecthc<?php echo $NumWindow; ?>(FromHCT) {
	HCTNew=document.getElementById('Codigo_HCT<?php echo $NumWindow; ?>').value;
	HCTName=encodeURI(document.getElementById('Nombre_HCT<?php echo $NumWindow; ?>').value);
	HCTActive=document.getElementById('Activo_HCT<?php echo $NumWindow; ?>').value;
	AbrirForm('application/forms/hcmodelos.php', '<?php echo $NumWindow; ?>', '&FromHC='+FromHCT+'&HCTNew='+HCTNew+'&HCTActive='+HCTActive+'&HCTName='+HCTName);
}

function namehc<?php echo $NumWindow; ?>() {
	HCTName=document.getElementById('Nombre_HCT<?php echo $NumWindow; ?>').value;
	document.getElementById('Descripcion_HCT<?php echo $NumWindow; ?>').value=HCTName.toUpperCase();
	document.getElementById('Nombre_HCT<?php echo $NumWindow; ?>').value=HCTName.toUpperCase();
}

function edithc<?php echo $NumWindow; ?>() {
	HCTNew=document.getElementById('Codigo_HCT<?php echo $NumWindow; ?>').value;
	HCTName=encodeURI(document.getElementById('Nombre_HCT<?php echo $NumWindow; ?>').value);
	HCTActive=document.getElementById('Activo_HCT<?php echo $NumWindow; ?>').value;
	if (HCTNew!="") {
		AbrirForm('application/forms/hcmodelos.php', '<?php echo $NumWindow; ?>', '&HCTNew='+HCTNew+'&HCTActive='+HCTActive+'&HCTName='+HCTName);
	}
}

function edithckey<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
  	edithc<?php echo $NumWindow; ?>();
  }
}

function AddRow<?php echo $NumWindow; ?>() {
	TotalFilas=document.getElementById("TotRows<?php echo $NumWindow; ?>").value;
	var miTabla = document.getElementById("tbDetalle<?php echo $NumWindow; ?>"); 
    var fila = document.createElement("tr"); 
    TotalFilas++;
    Komillas="\'";
    fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
<?php
$SQL="SELECT COLUMN_NAME, COLUMN_DEFAULT, case DATA_TYPE when 'int' then 'number' when 'enum' then 'select' else 'text' end , COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hccampos' AND COLUMN_NAME not in ('Codigo_HCT')";
$resultHCA = mysqli_query($conexion, $SQL);
while ($rowHCA = mysqli_fetch_row($resultHCA)) {
	$TotField++;
	$CampType=$rowHCA[2];
	$NameCamp=$rowHCA[0].'\'+TotalFilas+\''.$NumWindow;
	echo 'var celda'.$TotField.' = document.createElement("td");';
	if ($rowHCA[3]=="char(1)") {
		echo 'celda'.$TotField.'.innerHTML = \'<div class="checkbox checkbox-success"> <input name="chk_'.$NameCamp.'" id="chk_'.$NameCamp.'" type="checkbox" value=""  onclick="javascript:nxs_chkhctype(\'+Komillas+\''.$NameCamp.'\'+Komillas+\');" class="styled"><label for="chk_'.$NameCamp.'"></label> </div><input name="'.$NameCamp.'" type="hidden" id="'.$NameCamp.'" value="0" />\';';
	} else {
		if ($CampType=="select") {
			echo 'celda'.$TotField.'.innerHTML = \'<select  name="'.$rowHCA[0].'\'+TotalFilas+\''.$NumWindow.'" id="'.$rowHCA[0].'\'+TotalFilas+\''.$NumWindow.'" value="'.$rowHCA[1].'" style="border-width: 0px; background-color: white; font-size: smaller; border-bottom-width: 2px;border-bottom-style: dotted; width: 78px; padding: 5px;" class="form-control">		<option value="text">TEXTO</option>		<option value="textarea">PARRAFO</option>		<option value="check">CHECK</option>		<option value="image">IMAGEN</option>		<option value="date">FECHA</option>		<option value="time">HORA</option>		<option value="label">ETIQUETA</option>		<option value="select">SELECCION</option>		<option value="well">GRUPO</option>		<option value="collapse">GRUPO COLAPSE</option>  </select>\';';
		} else {
			echo 'celda'.$TotField.'.innerHTML = \'<input type="'.$CampType.'" name="'.$rowHCA[0].'\'+TotalFilas+\''.$NumWindow.'" id="'.$rowHCA[0].'\'+TotalFilas+\''.$NumWindow.'" value="'.$rowHCA[1].'" style="border-width: 0px; background-color: white; font-size: 11px; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px; text-transform: none;" class="form-control">\';';
		}
	}
	echo 'fila.appendChild(celda'.$TotField.');
	';

}
mysqli_free_result($resultHCA);
?>
	miTabla.appendChild(fila);
    document.getElementById("TotRows<?php echo $NumWindow; ?>").value=TotalFilas; 
}

function nxs_chkhctype(namex) {
	if (document.getElementById(namex).value=="1") {
		document.getElementById(namex).value='0';
	} else {
		document.getElementById(namex).value='1';
	}
}

function nxs_chkhctypex(namex) {
	if (document.getElementById(namex).value=="1") {
		document.getElementById(namex).value='0';
	} else {
		document.getElementById(namex).value='1';
	}
}

function AddRow2<?php echo $NumWindow; ?>() {
	TotalFilasx=document.getElementById("TotRows2<?php echo $NumWindow; ?>").value;
	var miTablax = document.getElementById("tbDetalle2<?php echo $NumWindow; ?>"); 
    var filax = document.createElement("tr"); 
    TotalFilasx++;
    Komillasx="\'";
    filax.id="trx"+TotalFilasx+"<?php echo $NumWindow; ?>";
<?php
$SQL="SELECT concat('l',COLUMN_NAME), COLUMN_DEFAULT, case DATA_TYPE when 'int' then 'number' when 'enum' then 'select' else 'text' end , COLUMN_TYPE FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hccamposlistas' AND COLUMN_NAME not in ('Codigo_HCT')";
$resultHCA = mysqli_query($conexion, $SQL);
while ($rowHCA = mysqli_fetch_row($resultHCA)) {
	$TotField++;
	$CampTypex=$rowHCA[2];
	$NameCampx=$rowHCA[0].'\'+TotalFilasx+\''.$NumWindow;
	echo 'var celdax'.$TotField.' = document.createElement("td");';	
	if ($rowHCA[3]=="char(1)") {
		echo 'celdax'.$TotField.'.innerHTML = \'<div class="checkbox checkbox-success"> <input name="chk_'.$NameCamp.'" id="chk_'.$NameCamp.'" type="checkbox" value=""  onclick="javascript:nxs_chkhctypex(\'+Komillas+\''.$NameCamp.'\'+Komillas+\');" class="styled"><label for="chk_'.$NameCamp.'"></label> </div><input name="'.$NameCamp.'" type="hidden" id="'.$NameCamp.'" value="0" />\';';
	} else {
			echo 'celdax'.$TotField.'.innerHTML = \'<input type="'.$CampType.'" name="'.$rowHCA[0].'\'+TotalFilasx+\''.$NumWindow.'" id="'.$rowHCA[0].'\'+TotalFilasx+\''.$NumWindow.'" value="'.$rowHCA[1].'" style="border-width: 0px; background-color: white; font-size: 11px; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px; text-transform: none;" class="form-control">\';';
	}
	echo 'filax.appendChild(celdax'.$TotField.');
	';
}
mysqli_free_result($resultHCA);
?>
	miTablax.appendChild(filax);
    document.getElementById("TotRows2<?php echo $NumWindow; ?>").value=TotalFilasx; 
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
</script>
<script src="functions/nexus/hcmodelos.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
