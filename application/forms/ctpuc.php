<?php
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
	function idTer($CodigoTER, $conn) {
		$terId="";
		if ($CodigoTER!="") {
			$SQL="Select Id_TER from czterceros Where Codigo_TER='".$CodigoTER."'";
			$resultter = mysqli_query($conn, $SQL);
			if ($rowter = mysqli_fetch_row($resultter)) {
				error_log($rowter[0]);
				return $rowter[0];
			} else {
				return "";
			}
			mysqli_free_result($resultter);
		} else {
			return "";
		}
	}
	function nameTer($CodigoTER, $conn) {
		$terId="";
		if ($CodigoTER!="") {
			$SQL="Select Nombre_TER from czterceros Where Codigo_TER='".$CodigoTER."'";
			$resultter = mysqli_query($conn, $SQL);
			if ($rowter = mysqli_fetch_row($resultter)) {
				return $rowter[0];
			} else {
				return "";
			}
			mysqli_free_result($resultter);
		} else {
			return "";
		}
	}
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>"  enctype="multipart/form-data"  >
	<div class="row">

<?php
	// NIVEL 1
  $SQL="Select Codigo_CTA, Nombre_CTA, Codigo_NVL from czcuentascont Where Codigo_NVL='1' order by Codigo_CTA";
  $resultnvl1 = mysqli_query($conexion, $SQL);
  while ($rowNVL1 = mysqli_fetch_row($resultnvl1)) {
  	$contarow++;
  	if ($contarow==1) {
		$Expanded="true";
		$KolaKlass="collapse in";
	} else {
		$Expanded="false";
		$KolaKlass="collapse";
	}
?>
<div id="div<?php echo $rowNVL1[0].$NumWindow; ?>" class=" col-md-12"  style="padding: 1;">
	<button class="btn btn-default btn-sm btn-block" type="button" data-toggle="collapse" data-target="#x<?php echo $rowNVL1[0].$NumWindow?>" aria-expanded="<?php echo $Expanded; ?>" aria-controls="x<?php echo $rowNVL1[0].$NumWindow?>" style="font-weight: bold;color: #ffffff;background-color: darkseagreen;font-size: 15px;text-align: left;"> <?php echo $rowNVL1[0].' '.$rowNVL1[1]; ?> </button>
	<div class="<?php echo $KolaKlass; ?>" id="x<?php echo $rowNVL1[0].$NumWindow; ?>" aria-expanded="<?php echo $Expanded; ?>">
<?php
	// NIVEL 2
  $SQL="Select Codigo_CTA, Nombre_CTA, Codigo_NVL from czcuentascont Where Codigo_NVL='2' and Codigo_CTA like '".$rowNVL1[0]."%' order by Codigo_CTA";
  $resultnvl2 = mysqli_query($conexion, $SQL);
  while ($rowNVL2 = mysqli_fetch_row($resultnvl2)) {
  	$contarow++;
?>
		<div class="panel panel-success">
			<div class="panel-heading" style="padding-bottom: 2px; padding-top: 2px;"> <strong><?php echo $rowNVL2[0].' '.$rowNVL2[1]; ?></strong> </div>
			<div id="zero_detalle<?php echo $rowNVL2[0].$NumWindow; ?>" class=" table-responsive ">
			  <table  align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $rowNVL2[0].$NumWindow; ?>" >
				<thead id="thDetalle<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $rowNVL2[0].$NumWindow; ?>" style=" font-size: 11px; cursor: auto;"> 
				  <th style="font-size: 8px;">CUENTA</th><th style="font-size: 8px;">NOMBRE</th><th style="font-size: 8px;">TERCERO</th><th style="font-size: 8px;">CIERRE TER</th><th style="font-size: 8px;">ID TERCERO</th><th style="font-size: 8px;">RETENCION</th><th style="font-size: 8px;">C. DE COSTO</th><th style="font-size: 8px;">ES ACTIVO</th><th style="font-size: 8px;">CONCILIAR</th><th style="font-size: 8px;">DISPONIBILIDAD</th><th style="font-size: 8px;">AJUSTES</th><th style="font-size: 8px;">CTA AJUSTE</th><th style="font-size: 8px;">CTA CORRECCION</th><th style="font-size: 8px; width: 60px;">ACCIONES</th>
				</tr> 
				</thead>
				<tbody>
<?php 
	$contarow++;
?>
<tr style="cursor: auto;">
  <td style=" padding-top: 3px; padding-bottom: 2px;"><input type="text" name="<?php echo 'Codigo_CTA'.$contarow.$NumWindow; ?>" id="<?php echo 'Codigo_CTA'.$contarow.$NumWindow; ?>" value="" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none; height: 24px; width: 80px;" disabled ></td> 
  <td style=" padding-top: 3px; padding-bottom: 2px;" ><input name="<?php echo 'Codigo_TER'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'Codigo_TER'.$contarow.$NumWindow; ?>" value="" /><input type="text" name="<?php echo 'Nombre_CTA'.$contarow.$NumWindow; ?>" id="<?php echo 'Nombre_CTA'.$contarow.$NumWindow; ?>" value="" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none; height: 24px;" disabled ></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" align="center"><div class="checkbox checkbox-success"  style="padding-top: 4px; height: 24px;"> <input name="chk_<?php echo 'ManTer_CTA'.$contarow.$NumWindow; ?>" id="chk_<?php echo 'ManTer_CTA'.$contarow.$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:nxs_chkpuc<?php echo $NumWindow; ?>('<?php echo 'ManTer_CTA'.$contarow.$NumWindow; ?>');" class="styled" disabled ><label for="chk_<?php echo 'ManTer_CTA'.$contarow.$NumWindow; ?>"></label> </div><input name="<?php echo 'ManTer_CTA'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'ManTer_CTA'.$contarow.$NumWindow; ?>" value="0" /></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" align="center"><div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_<?php echo 'CierreTer_CTA'.$contarow.$NumWindow; ?>" id="chk_<?php echo 'CierreTer_CTA'.$contarow.$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:nxs_chkpuc<?php echo $NumWindow; ?>('<?php echo 'CierreTer_CTA'.$contarow.$NumWindow; ?>');" class="styled" disabled  ><label for="chk_<?php echo 'CierreTer_CTA'.$contarow.$NumWindow; ?>"></label> </div><input name="<?php echo 'CierreTer_CTA'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'CierreTer_CTA'.$contarow.$NumWindow; ?>" value="0" /></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" ><input name="<?php echo 'Codigo_TER'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'Codigo_TER'.$contarow.$NumWindow; ?>" value="" />
  <div class="input-group" style="width: 120px;">
  <input type="text" name="<?php echo 'Tercero'.$contarow.$NumWindow; ?>" id="<?php echo 'Tercero'.$contarow.$NumWindow; ?>" value="" title="" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none; height: 24px; width: 95px;" disabled readonly >
    <span class="input-group-btn">	
	  <button id="btntercero<?php echo $contarow.$NumWindow; ?>" name="btntercero<?php echo $contarow.$NumWindow; ?>" class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ctpuc" onclick="javascript:CargarSearch('Tercero', '<?php echo 'Tercero'.$contarow.$NumWindow; ?>', 'NULL');" style="height: 24px; width: 24px; padding: 1px;" disabled><span class="glyphicon glyphicon-search" aria-hidden="true" ></span></button>
	</span>
	</div>
  </td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" ><select  name="<?php echo 'ManRet_CTA'.$contarow.$NumWindow; ?>" id="<?php echo 'ManRet_CTA'.$contarow.$NumWindow; ?>" value="'.$rowHCA[1].'" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: uppercase; height: 24px; width: 130px;" class="form-control" disabled > <option value="Ninguna" >Ninguna</option> <option value="ReteFuente" >ReteFuente</option> <option value="ReteIVA" >ReteIVA</option> <option value="ReteICA" >ReteICA</option> <option value="Otras" >Otras</option> </select></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" align="center"><div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_<?php echo 'ManCC_CTA'.$contarow.$NumWindow; ?>" id="chk_<?php echo 'ManCC_CTA'.$contarow.$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:nxs_chkpuc<?php echo $NumWindow; ?>('<?php echo 'ManCC_CTA'.$contarow.$NumWindow; ?>');" class="styled" disabled  ><label for="chk_<?php echo 'ManCC_CTA'.$contarow.$NumWindow; ?>"></label> </div><input name="<?php echo 'ManCC_CTA'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'ManCC_CTA'.$contarow.$NumWindow; ?>" value="0" /></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" align="center"><div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_<?php echo 'Activo_CTA'.$contarow.$NumWindow; ?>" id="chk_<?php echo 'Activo_CTA'.$contarow.$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:nxs_chkpuc<?php echo $NumWindow; ?>('<?php echo 'Activo_CTA'.$contarow.$NumWindow; ?>');" class="styled" disabled  ><label for="chk_<?php echo 'Activo_CTA'.$contarow.$NumWindow; ?>"></label> </div><input name="<?php echo 'Activo_CTA'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'Activo_CTA'.$contarow.$NumWindow; ?>" value="0" /></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" align="center"><div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_<?php echo 'Concilia_CTA'.$contarow.$NumWindow; ?>" id="chk_<?php echo 'Concilia_CTA'.$contarow.$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:nxs_chkpuc<?php echo $NumWindow; ?>('<?php echo 'Concilia_CTA'.$contarow.$NumWindow; ?>');" class="styled" disabled  ><label for="chk_<?php echo 'Concilia_CTA'.$contarow.$NumWindow; ?>"></label> </div><input name="<?php echo 'Concilia_CTA'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'Concilia_CTA'.$contarow.$NumWindow; ?>" value="0" /></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" ><select  name="<?php echo 'Disponibilidad_CTA'.$contarow.$NumWindow; ?>" id="<?php echo 'Disponibilidad_CTA'.$contarow.$NumWindow; ?>" value="'.$rowHCA[1].'" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: uppercase; height: 24px; width: 130px;" class="form-control" disabled > <option value="Corriente" >Corriente</option> <option value="No Corriente" >No Corriente</option> <option value="Ambas" >Ambas</option> </select></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" align="center"><div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_<?php echo 'ManAjuste_CTA'.$contarow.$NumWindow; ?>" id="chk_<?php echo 'ManAjuste_CTA'.$contarow.$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:nxs_chkpuc<?php echo $NumWindow; ?>('<?php echo 'ManAjuste_CTA'.$contarow.$NumWindow; ?>');" class="styled" disabled  ><label for="chk_<?php echo 'ManAjuste_CTA'.$contarow.$NumWindow; ?>"></label> </div><input name="<?php echo 'ManAjuste_CTA'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'ManAjuste_CTA'.$contarow.$NumWindow; ?>" value="0" /></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" >
  <div class="input-group" style="width: 120px;">
  <input type="text" name="<?php echo 'Ajuste_CTA'.$contarow.$NumWindow; ?>" id="<?php echo 'Ajuste_CTA'.$contarow.$NumWindow; ?>" value="" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none; height: 24px; width: 80px;" disabled readonly>
    <span class="input-group-btn">	
	  <button id="btnajuste<?php echo $contarow.$NumWindow; ?>" name="btnajuste<?php echo $contarow.$NumWindow; ?>" class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ctpuc" onclick="javascript:CargarSearch('PUC', '<?php echo 'Ajuste_CTA'.$contarow.$NumWindow; ?>', 'NULL');" style="height: 24px; width: 24px; padding: 1px;" disabled><span class="glyphicon glyphicon-search" aria-hidden="true" ></span></button>
	</span>
  </div>
  </td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" >
  <div class="input-group" style="width: 120px;">
  <input type="text" name="<?php echo 'Correccion_CTA'.$contarow.$NumWindow; ?>" id="<?php echo 'Correccion_CTA'.$contarow.$NumWindow; ?>" value="" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none; height: 24px; width: 80px;" disabled readonly>
    <span class="input-group-btn">	
	  <button id="btncorreccion<?php echo $contarow.$NumWindow; ?>" name="btncorreccion<?php echo $contarow.$NumWindow; ?>" class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ctpuc" onclick="javascript:CargarSearch('PUC', '<?php echo 'Correccion_CTA'.$contarow.$NumWindow; ?>', 'NULL');" style="height: 24px; width: 24px; padding: 1px;" disabled><span class="glyphicon glyphicon-search" aria-hidden="true" ></span></button>
	</span>
  </div>
  </td>
  <td align="center" >
  	<div class="progress" style="display: none; margin-top: 0px;" name="prgSaving<?php echo $contarow.$NumWindow; ?>" id="prgSaving<?php echo $contarow.$NumWindow; ?>">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%; height: 16px; margin-top: 0px;">    <span class="sr-only">Guardando</span>  </div></div>
  		<div class="btn-group btn-group-xs" role="group" aria-label="...">
  		<button id="btnCancelar<?php echo $contarow.$NumWindow; ?>" name="btnCancelar<?php echo $contarow.$NumWindow; ?>" style="display: none;" type="button" class="btn btn-danger" title="Cancelar" onclick="CancelEdit<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')"> <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> </button> 
  		<button id="btnEdit<?php echo $contarow.$NumWindow; ?>" name="btnEdit<?php echo $contarow.$NumWindow; ?>" style="display: block;" type="button" class="btn btn-info" title="Nueva Cuenta" onclick="Edit<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
  		<button id="btnSave<?php echo $contarow.$NumWindow; ?>" name="btnSave<?php echo $contarow.$NumWindow; ?>" style="display: none;" type="button" class="btn btn-success" title="Guardar Cuenta" onclick="SaveEdit<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> </button></div>
  		
  </td>
</tr>				
<?php
	// NIVEL 3
  $SQL="Select Codigo_CTA, Nombre_CTA, Codigo_NVL from czcuentascont Where Codigo_NVL='3' and Codigo_CTA like '".$rowNVL2[0]."%' order by Codigo_CTA";
  $resultnvl3 = mysqli_query($conexion, $SQL);
  while ($rowNVL3 = mysqli_fetch_row($resultnvl3)) {
  	$contarow++;
?>
<tr style="background-color: #8fbc8f; font-weight: bold; color: #FEFEFE; font-size: 11px; cursor: auto;">
  <td style="text-align: right; padding-top: 3px; padding-bottom: 2px;"><?php echo $rowNVL3[0]; ?></td> <td colspan="13" style="text-align: left; padding-top: 3px; padding-bottom: 2px;"><?php echo $rowNVL3[1]; ?></td>
</tr>
<?php
	// NIVEL 4
  $SQL="Select Codigo_CTA, Nombre_CTA, Codigo_NVL from czcuentascont Where Codigo_NVL='4' and Codigo_CTA like '".$rowNVL3[0]."%' order by Codigo_CTA";
  $resultnvl4 = mysqli_query($conexion, $SQL);
  while ($rowNVL4 = mysqli_fetch_row($resultnvl4)) {
  	$contarow++;
?>
<tr style="background-color: #bedebe; font-weight: bold; color: #668e33; font-size: 11px; cursor: auto;">
  <td style="text-align: right; padding-top: 3px; padding-bottom: 2px;"><?php echo $rowNVL4[0]; ?></td> <td colspan="13" style="text-align: left; padding-top: 3px; padding-bottom: 2px;"><?php echo $rowNVL4[1]; ?></td>
</tr>
<?php
	// NIVEL 5
  $SQL="Select Codigo_CTA, Nombre_CTA, Codigo_NVL, ManTer_CTA, CierreTer_CTA, Codigo_TER, ManRet_CTA, ManCC_CTA, Activo_CTA, Concilia_CTA, Disponibilidad_CTA, ManAjuste_CTA, Ajuste_CTA, Correccion_CTA from czcuentascont Where Codigo_NVL='5' and Codigo_CTA like '".$rowNVL4[0]."%' order by Codigo_CTA";
  $resultnvl5 = mysqli_query($conexion, $SQL);
  while ($rowNVL5 = mysqli_fetch_row($resultnvl5)) {
  	$contarow++;
?>
<tr style="cursor: auto;">
  <td style=" padding-top: 3px; padding-bottom: 2px;"><input type="text" name="<?php echo 'Codigo_CTA'.$contarow.$NumWindow; ?>" id="<?php echo 'Codigo_CTA'.$contarow.$NumWindow; ?>" value="<?php echo $rowNVL5[0]; ?>" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none; height: 24px; width: 80px;" disabled ></td> 
  <td style=" padding-top: 3px; padding-bottom: 2px;" ><input name="<?php echo 'Codigo_TER'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'Codigo_TER'.$contarow.$NumWindow; ?>" value="<?php echo $rowNVL5[2]; ?>" /><input type="text" name="<?php echo 'Nombre_CTA'.$contarow.$NumWindow; ?>" id="<?php echo 'Nombre_CTA'.$contarow.$NumWindow; ?>" value="<?php echo $rowNVL5[1]; ?>" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none; height: 24px;" disabled ></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" align="center"><div class="checkbox checkbox-success"  style="padding-top: 4px; height: 24px;"> <input name="chk_<?php echo 'ManTer_CTA'.$contarow.$NumWindow; ?>" id="chk_<?php echo 'ManTer_CTA'.$contarow.$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:nxs_chkpuc<?php echo $NumWindow; ?>('<?php echo 'ManTer_CTA'.$contarow.$NumWindow; ?>');" class="styled" disabled <?php if ($rowNVL5[3]=="1") { echo 'checked';} ?>><label for="chk_<?php echo 'ManTer_CTA'.$contarow.$NumWindow; ?>"></label> </div><input name="<?php echo 'ManTer_CTA'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'ManTer_CTA'.$contarow.$NumWindow; ?>" value="<?php echo $rowNVL5[3]; ?>" /></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" align="center"><div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_<?php echo 'CierreTer_CTA'.$contarow.$NumWindow; ?>" id="chk_<?php echo 'CierreTer_CTA'.$contarow.$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:nxs_chkpuc<?php echo $NumWindow; ?>('<?php echo 'CierreTer_CTA'.$contarow.$NumWindow; ?>');" class="styled" disabled <?php if ($rowNVL5[4]=="1") { echo 'checked';} ?> ><label for="chk_<?php echo 'CierreTer_CTA'.$contarow.$NumWindow; ?>"></label> </div><input name="<?php echo 'CierreTer_CTA'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'CierreTer_CTA'.$contarow.$NumWindow; ?>" value="<?php echo $rowNVL5[4]; ?>" /></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" ><input name="<?php echo 'Codigo_TER'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'Codigo_TER'.$contarow.$NumWindow; ?>" value="<?php echo $rowNVL5[5]; ?>" />
  <div class="input-group" style="width: 120px;">
  <input type="text" name="<?php echo 'Tercero'.$contarow.$NumWindow; ?>" id="<?php echo 'Tercero'.$contarow.$NumWindow; ?>" value="<?php echo idTer($rowNVL5[5], $conexion); ?>" title="<?php echo nameTer($rowNVL5[5], $conexion); ?>" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none; height: 24px; width: 95px;" disabled readonly >
    <span class="input-group-btn">	
	  <button id="btntercero<?php echo $contarow.$NumWindow; ?>" name="btntercero<?php echo $contarow.$NumWindow; ?>" class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ctpuc" onclick="javascript:CargarSearch('Tercero', '<?php echo 'Tercero'.$contarow.$NumWindow; ?>', 'NULL');" style="height: 24px; width: 24px; padding: 1px;" disabled><span class="glyphicon glyphicon-search" aria-hidden="true" ></span></button>
	</span>
	</div>
  </td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" ><select  name="<?php echo 'ManRet_CTA'.$contarow.$NumWindow; ?>" id="<?php echo 'ManRet_CTA'.$contarow.$NumWindow; ?>" value="'.$rowHCA[1].'" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: uppercase; height: 24px; width: 130px;" class="form-control" disabled > <option value="Ninguna" <?php if($rowNVL5[6]=="Ninguna") { echo 'selected="selected"';} ?>>Ninguna</option> <option value="ReteFuente" <?php if($rowNVL5[6]=="ReteFuente") { echo 'selected="selected"';} ?>>ReteFuente</option> <option value="ReteIVA" <?php if($rowNVL5[6]=="ReteIVA") { echo 'selected="selected"';} ?>>ReteIVA</option> <option value="ReteICA" <?php if($rowNVL5[6]=="ReteICA") { echo 'selected="selected"';} ?>>ReteICA</option> <option value="Otras" <?php if($rowNVL5[6]=="Otras") { echo 'selected="selected"';} ?>>Otras</option> </select></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" align="center"><div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_<?php echo 'ManCC_CTA'.$contarow.$NumWindow; ?>" id="chk_<?php echo 'ManCC_CTA'.$contarow.$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:nxs_chkpuc<?php echo $NumWindow; ?>('<?php echo 'ManCC_CTA'.$contarow.$NumWindow; ?>');" class="styled" disabled <?php if ($rowNVL5[7]=="1") { echo 'checked';} ?> ><label for="chk_<?php echo 'ManCC_CTA'.$contarow.$NumWindow; ?>"></label> </div><input name="<?php echo 'ManCC_CTA'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'ManCC_CTA'.$contarow.$NumWindow; ?>" value="<?php echo $rowNVL5[7]; ?>" /></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" align="center"><div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_<?php echo 'Activo_CTA'.$contarow.$NumWindow; ?>" id="chk_<?php echo 'Activo_CTA'.$contarow.$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:nxs_chkpuc<?php echo $NumWindow; ?>('<?php echo 'Activo_CTA'.$contarow.$NumWindow; ?>');" class="styled" disabled <?php if ($rowNVL5[8]=="1") { echo 'checked';} ?> ><label for="chk_<?php echo 'Activo_CTA'.$contarow.$NumWindow; ?>"></label> </div><input name="<?php echo 'Activo_CTA'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'Activo_CTA'.$contarow.$NumWindow; ?>" value="<?php echo $rowNVL5[8]; ?>" /></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" align="center"><div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_<?php echo 'Concilia_CTA'.$contarow.$NumWindow; ?>" id="chk_<?php echo 'Concilia_CTA'.$contarow.$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:nxs_chkpuc<?php echo $NumWindow; ?>('<?php echo 'Concilia_CTA'.$contarow.$NumWindow; ?>');" class="styled" disabled <?php if ($rowNVL5[9]=="1") { echo 'checked';} ?> ><label for="chk_<?php echo 'Concilia_CTA'.$contarow.$NumWindow; ?>"></label> </div><input name="<?php echo 'Concilia_CTA'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'Concilia_CTA'.$contarow.$NumWindow; ?>" value="<?php echo $rowNVL5[9]; ?>" /></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" ><select  name="<?php echo 'Disponibilidad_CTA'.$contarow.$NumWindow; ?>" id="<?php echo 'Disponibilidad_CTA'.$contarow.$NumWindow; ?>" value="'.$rowHCA[1].'" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: uppercase; height: 24px; width: 130px;" class="form-control" disabled > <option value="Corriente" <?php if($rowNVL5[10]=="Corriente") { echo 'selected="selected"';} ?>>Corriente</option> <option value="No Corriente" <?php if($rowNVL5[10]=="No Corriente") { echo 'selected="selected"';} ?>>No Corriente</option> <option value="Ambas" <?php if($rowNVL5[10]=="Ambas") { echo 'selected="selected"';} ?>>Ambas</option> </select></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" align="center"><div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_<?php echo 'ManAjuste_CTA'.$contarow.$NumWindow; ?>" id="chk_<?php echo 'ManAjuste_CTA'.$contarow.$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:nxs_chkpuc<?php echo $NumWindow; ?>('<?php echo 'ManAjuste_CTA'.$contarow.$NumWindow; ?>');" class="styled" disabled  <?php if ($rowNVL5[11]=="1") { echo 'checked';} ?> ><label for="chk_<?php echo 'ManAjuste_CTA'.$contarow.$NumWindow; ?>"></label> </div><input name="<?php echo 'ManAjuste_CTA'.$contarow.$NumWindow; ?>" type="hidden" id="<?php echo 'ManAjuste_CTA'.$contarow.$NumWindow; ?>" value="<?php echo $rowNVL5[11]; ?>" /></td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" >
  <div class="input-group" style="width: 120px;">
  <input type="text" name="<?php echo 'Ajuste_CTA'.$contarow.$NumWindow; ?>" id="<?php echo 'Ajuste_CTA'.$contarow.$NumWindow; ?>" value="<?php echo $rowNVL5[12]; ?>" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none; height: 24px; width: 80px;" disabled readonly>
    <span class="input-group-btn">	
	  <button id="btnajuste<?php echo $contarow.$NumWindow; ?>" name="btnajuste<?php echo $contarow.$NumWindow; ?>" class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ctpuc" onclick="javascript:CargarSearch('PUC', '<?php echo 'Ajuste_CTA'.$contarow.$NumWindow; ?>', 'NULL');" style="height: 24px; width: 24px; padding: 1px;" disabled><span class="glyphicon glyphicon-search" aria-hidden="true" ></span></button>
	</span>
  </div>
  </td>
  <td style=" padding-top: 3px; padding-bottom: 2px;" >
  <div class="input-group" style="width: 120px;">
  <input type="text" name="<?php echo 'Correccion_CTA'.$contarow.$NumWindow; ?>" id="<?php echo 'Correccion_CTA'.$contarow.$NumWindow; ?>" value="<?php echo $rowNVL5[13]; ?>" style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none; height: 24px; width: 80px;" disabled readonly>
    <span class="input-group-btn">	
	  <button id="btncorreccion<?php echo $contarow.$NumWindow; ?>" name="btncorreccion<?php echo $contarow.$NumWindow; ?>" class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ctpuc" onclick="javascript:CargarSearch('PUC', '<?php echo 'Correccion_CTA'.$contarow.$NumWindow; ?>', 'NULL');" style="height: 24px; width: 24px; padding: 1px;" disabled><span class="glyphicon glyphicon-search" aria-hidden="true" ></span></button>
	</span>
  </div>
  </td>
  <td align="center" >
  	<div class="progress" style="display: none; margin-top: 0px;" name="prgSaving<?php echo $contarow.$NumWindow; ?>" id="prgSaving<?php echo $contarow.$NumWindow; ?>">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%; height: 16px; margin-top: 0px;">    <span class="sr-only">Generando Archivos</span>  </div></div>
  		<div class="btn-group btn-group-xs" role="group" aria-label="...">
  		<button id="btnCancelar<?php echo $contarow.$NumWindow; ?>" name="btnCancelar<?php echo $contarow.$NumWindow; ?>" style="display: none;" type="button" class="btn btn-danger" title="Cancelar Edición" onclick="CancelEdit<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')"> <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> </button> 
  		<button id="btnEdit<?php echo $contarow.$NumWindow; ?>" name="btnEdit<?php echo $contarow.$NumWindow; ?>" style="display: block;" type="button" class="btn btn-info" title="Editar Registro" onclick="Edit<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> </button>
  		<button id="btnSave<?php echo $contarow.$NumWindow; ?>" name="btnSave<?php echo $contarow.$NumWindow; ?>" style="display: none;" type="button" class="btn btn-success" title="Guardar Registro" onclick="SaveEdit<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> </button></div>
  		
  </td>
</tr>
<?php
		}
		mysqli_free_result($resultnvl5);	
	}
	mysqli_free_result($resultnvl4);	
  }
  mysqli_free_result($resultnvl3);
?>			
				</tbody>
			  </table>
			</div>
		</div>
<?php
  }
  mysqli_free_result($resultnvl2);
?>			

	</div>
</div>

<?php
  }
  mysqli_free_result($resultnvl1);

?>			
</div>
</form>

<script >

function Edit<?php echo $NumWindow; ?>(Fila)
{
	document.getElementById("btnCancelar"+Fila+"<?php echo $NumWindow; ?>").style.display="block";
	document.getElementById("btnSave"+Fila+"<?php echo $NumWindow; ?>").style.display="block";
	document.getElementById("btnEdit"+Fila+"<?php echo $NumWindow; ?>").style.display="none";

	document.getElementById("Codigo_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("Nombre_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("chk_ManTer_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("chk_CierreTer_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("Tercero"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("ManRet_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("chk_ManCC_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("chk_Activo_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("chk_Concilia_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("Disponibilidad_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("chk_ManAjuste_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("Ajuste_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("Correccion_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("btntercero"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("btnajuste"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
	document.getElementById("btncorreccion"+Fila+"<?php echo $NumWindow; ?>").disabled = false;
}

function CancelEdit<?php echo $NumWindow; ?>(Fila)
{
	document.getElementById("btnCancelar"+Fila+"<?php echo $NumWindow; ?>").style.display="none";
	document.getElementById("btnSave"+Fila+"<?php echo $NumWindow; ?>").style.display="none";
	document.getElementById("btnEdit"+Fila+"<?php echo $NumWindow; ?>").style.display="block";

	document.getElementById("Codigo_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("Nombre_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("chk_ManTer_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("chk_CierreTer_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("Tercero"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("ManRet_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("chk_ManCC_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("chk_Activo_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("chk_Concilia_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("Disponibilidad_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("chk_ManAjuste_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("Ajuste_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("Correccion_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("btntercero"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("btnajuste"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("btncorreccion"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
}

function SaveEdit<?php echo $NumWindow; ?>(Fila)
{
	document.getElementById("btnCancelar"+Fila+"<?php echo $NumWindow; ?>").style.display="none";
	document.getElementById("btnSave"+Fila+"<?php echo $NumWindow; ?>").style.display="none";
	document.getElementById("prgSaving"+Fila+"<?php echo $NumWindow; ?>").style.display="block";
	
	CodigoCTA=document.getElementById("Codigo_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	NombreCTA=document.getElementById("Nombre_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	ManTerCTA=document.getElementById("ManTer_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	CierreTerCTA=document.getElementById("CierreTer_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	IDTER=document.getElementById("Tercero"+Fila+"<?php echo $NumWindow; ?>").value;
	ManRetCTA=document.getElementById("ManRet_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	ManCCCTA=document.getElementById("ManCC_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	ActivoCTA=document.getElementById("Activo_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	ConciliaCTA=document.getElementById("Concilia_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	DisponibilidadCTA=document.getElementById("Disponibilidad_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	ManAjusteCTA=document.getElementById("ManAjuste_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	AjusteCTA=document.getElementById("Ajuste_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	CorreccionCTA=document.getElementById("Correccion_CTA"+Fila+"<?php echo $NumWindow; ?>").value;
	
	document.getElementById("Codigo_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("Nombre_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("chk_ManTer_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("chk_CierreTer_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("Tercero"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("ManRet_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("chk_ManCC_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("chk_Activo_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("chk_Concilia_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("Disponibilidad_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("chk_ManAjuste_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("Ajuste_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("Correccion_CTA"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("btntercero"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("btnajuste"+Fila+"<?php echo $NumWindow; ?>").disabled = true;
	document.getElementById("btncorreccion"+Fila+"<?php echo $NumWindow; ?>").disabled = true;

	$.ajax({  
		type: "POST",  
		url: Transact + "ctpuc.php",  
		data: "Func=SavePUC&CodigoCTA="+CodigoCTA+"&NombreCTA="+NombreCTA+"&ManTerCTA="+ManTerCTA+"&CierreTerCTA="+CierreTerCTA+"&IDTER="+IDTER+"&ManRetCTA="+ManRetCTA+"&ManCCCTA="+ManCCCTA+"&ActivoCTA="+ActivoCTA+"&ConciliaCTA="+ConciliaCTA+"&DisponibilidadCTA="+DisponibilidadCTA+"&ManAjusteCTA="+ManAjusteCTA+"&AjusteCTA="+AjusteCTA+"&CorreccionCTA="+CorreccionCTA,
		success: function(respuesta) { 
		  MsgBox1("Cuenta Contable", respuesta); 
		  document.getElementById("prgSaving"+Fila+"<?php echo $NumWindow; ?>").style.display="none";
		  document.getElementById("btnEdit"+Fila+"<?php echo $NumWindow; ?>").style.display="block";
		}
	});
}

function nxs_chkpuc<?php echo $NumWindow; ?>(TheCheck)
{
	if (document.getElementById(TheCheck).value=="1") {
		document.getElementById(TheCheck).value='0';
	} else {
		document.getElementById(TheCheck).value='1';
	}	
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
</script>
<!-- <script src="functions/nexus/ctpuc.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script> -->
