<?php
session_start();
	$NumWindow=$_GET["target"];
	$nxsTabla=$_GET["table"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>"  enctype="multipart/form-data"  >
	<div class="row">

		<div class="panel panel-success">
			<div id="zero_detalle<?php echo $nxsTabla.$NumWindow; ?>" class=" table-responsive ">
			  <table  align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $nxsTabla.$NumWindow; ?>" >
				<thead id="thDetalle<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $nxsTabla.$NumWindow; ?>" style="font-size:11px; cursor:auto;">
<?php
  // Se buscan los nombres de los campos a mostrar
  $SQL="SELECT COLUMN_NAME, COLUMN_DEFAULT, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, COLUMN_TYPE, COLUMN_KEY, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$_SESSION["DB_NAME"]."' AND TABLE_NAME='".$nxsTabla."' ORDER BY ORDINAL_POSITION;";
  $rstColumns = mysqli_query($conexion, $SQL);
  $jk=0;
  $Kampox="";
  $OrderBY="";
  $Dexcribe = array();
  while ($rowCols = mysqli_fetch_row($rstColumns)) {
?>
				  <th style="font-size: 8px;"><?php echo strtoupper($rowCols[6]); ?></th>
<?php
	$Kampox=$Kampox.$rowCols[0].", ";
	if ($rowCols[5]=='PRI') {
		if ($OrderBY=="") {
			$OrderBY=" Order By ".$rowCols[0];
		} else {
			$OrderBY=$OrderBY.", ".$rowCols[0];
		}
	}
	$jk++;
	$Dexcribe['COLUMN_NAME'.$jk] = $rowCols[0];
	$Dexcribe['COLUMN_DEFAULT'.$jk] = $rowCols[1];
	$Dexcribe['DATA_TYPE'.$jk] = $rowCols[2];
	$Dexcribe['CHARACTER_MAXIMUM_LENGTH'.$jk] = $rowCols[3];
	$Dexcribe['COLUMN_TYPE'.$jk] = $rowCols[4];
	$Dexcribe['COLUMN_KEY'.$jk] = $rowCols[5];
	$Dexcribe['COLUMN_COMMENT'.$jk] = $rowCols[6];
  }
  mysqli_free_result($rstColumns);
  $Kampox=substr($Kampox, 0,strlen($Kampox)-2);
?>
				  <th style="font-size: 8px; width: 60px;">ACCIONES</th>
				</tr> 
				</thead>
				<tbody>
<?php
  $Xtyle=' style="border-width: 0px; background-color: transparent; font-size: 11px; padding: 5px; text-transform: none; height: 24px; width: 100%;"';
  // Data...
  $SQL="Select ".$Kampox." From ".$nxsTabla.$OrderBY;
  $rstRecord = mysqli_query($conexion, $SQL);
  while ($rowREC = mysqli_fetch_row($rstRecord)) {
  	$contarow++;
?>
<tr style="cursor: auto;">
<?php
	$kontaCol=0;
	// Buscamos la estructura de cada columna...
	while ($kontaCol<$jk) {
		$colValue=$rowREC[$kontaCol];
		$kontaCol++;
		$colName=$Dexcribe['COLUMN_NAME'.$kontaCol].$contarow.$NumWindow;
		$colCheck="";
		echo '<td style="padding-top: 3px; padding-bottom: 2px;" align="center">';
		if ($Dexcribe['DATA_TYPE'.$kontaCol]=="varchar") {
			echo '<input type="text" name="'.$colName.'" id="'.$colName.'" value="'.$colValue.'" disabled'.$Xtyle.' >';
		}
		if ($Dexcribe['DATA_TYPE'.$kontaCol]=="char") {
			if ($Dexcribe['CHARACTER_MAXIMUM_LENGTH'.$kontaCol]!="1") {
				echo '<input type="text" name="'.$colName.'" id="'.$colName.'" value="'.$colValue.'" disabled'.$Xtyle.' >';
			} else {
				if ($colValue=="1") { 
					$colCheck='checked';
				}
				echo '<div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_'.$colName.'" id="chk_'.$colName.'" type="checkbox" value="" onclick="javascript:nxs_chkchar'.$NumWindow.'(\''.$colName.'\');" class="styled" disabled '.$colCheck.'> <label for="chk_'.$colName.'"></label></div> <input name="'.$colName.'" type="hidden" id="'.$colName.'" value="'.$colValue.'" />';
			}
		}
		if ($Dexcribe['DATA_TYPE'.$kontaCol]=="int") {
			echo '<input type="number" name="'.$colName.'" id="'.$colName.'" value="'.$colValue.'" disabled'.$Xtyle.' >';
		}
		if ($Dexcribe['DATA_TYPE'.$kontaCol]=="text") {
			echo '<textarea name="'.$colName.'" rows="1" id="'.$colName.'"'.$Xtyle.' disabled >'.$colValue.'</textarea>';
		}
		if ($Dexcribe['DATA_TYPE'.$kontaCol]=="decimal") {
			echo '<input type="text" name="'.$colName.'" id="'.$colName.'" value="'.$colValue.'" disabled'.$Xtyle.' >';
		}
		if ($Dexcribe['DATA_TYPE'.$kontaCol]=="enum") {
			echo '<select  name="'.$colName.'" id="'.$colName.'" '.$Xtyle.' class="form-control" disabled >';
			$opxiones=str_replace("enum(", "", $Dexcribe['COLUMN_TYPE'.$kontaCol] );
			$opxiones=str_replace(")", "", $opxiones );
			$opxiones=str_replace("'", "", $opxiones );
			$arrayoptions=explode(",",$opxiones);
			foreach ($arrayoptions as $clave => $valor) {
				$Xeleted="";
				if ($valor==$colValue) {
					$Xeleted='selected="selected"';
				}
				echo '<option value="'.$valor.'" '.$Xeleted.'>'.$valor.'</option>';
			}
			echo '</select>';
		}
		echo '</td>';
	}
?>
  <td align="center" >
  	<div class="progress" style="display: none; margin-top: 0px;" name="prgSaving<?php echo $contarow.$NumWindow; ?>" id="prgSaving<?php echo $contarow.$NumWindow; ?>"> <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%; height: 16px; margin-top: 0px;"> <span class="sr-only">Generando Archivos</span> </div></div>
  		<div class="btn-group btn-group-xs" role="group" aria-label="...">
  		<button id="btnCancelar<?php echo $contarow.$NumWindow; ?>" name="btnCancelar<?php echo $contarow.$NumWindow; ?>" style="display: none;" type="button" class="btn btn-danger" title="Cancelar Edición" onclick="CancelEdit<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')"> <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> </button> 
  		<button id="btnEdit<?php echo $contarow.$NumWindow; ?>" name="btnEdit<?php echo $contarow.$NumWindow; ?>" style="display: block;" type="button" class="btn btn-info" title="Editar Registro" onclick="Edit<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> </button>
  		<button id="btnSave<?php echo $contarow.$NumWindow; ?>" name="btnSave<?php echo $contarow.$NumWindow; ?>" style="display: none;" type="button" class="btn btn-success" title="Guardar Registro" onclick="SaveEdit<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> </button></div>
  		
  </td>
</tr>
<?php
		}
		mysqli_free_result($rstRecord);
// Agregar nuevo registro		
	$Xtyle=' style="border-width: 1px; background-color: #FEFEFE; font-size: 11px; padding: 5px; text-transform: none; height: 24px; width: 100%; font-style: italic;font-weight: bold;"';
?>
<tr style="cursor: auto;">
<?php
	$kontaCol=0;
	$contarow++;
	// Buscamos la estructura de cada columna...
	while ($kontaCol<$jk) {
		$colValue="";
		$kontaCol++;
		$colValue=$Dexcribe['COLUMN_DEFAULT'.$kontaCol];
		$colName=$Dexcribe['COLUMN_NAME'.$kontaCol].$contarow.$NumWindow;
		$colCheck="";
		echo '<td style="padding-top: 3px; padding-bottom: 2px;" align="center">';
		if ($Dexcribe['DATA_TYPE'.$kontaCol]=="varchar") {
			echo '<input type="text" name="'.$colName.'" id="'.$colName.'" value="'.$colValue.'" disabled'.$Xtyle.' >';
		}
		if ($Dexcribe['DATA_TYPE'.$kontaCol]=="char") {
			if ($Dexcribe['CHARACTER_MAXIMUM_LENGTH'.$kontaCol]!="1") {
				echo '<input type="text" name="'.$colName.'" id="'.$colName.'" value="'.$colValue.'" disabled'.$Xtyle.' >';
			} else {
				if ($colValue=="1") { 
					$colCheck='checked';
				}
				echo '<div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_'.$colName.'" id="chk_'.$colName.'" type="checkbox" value="" onclick="javascript:nxs_chkchar'.$NumWindow.'(\''.$colName.'\');" class="styled" disabled '.$colCheck.'> <label for="chk_'.$colName.'"></label></div> <input name="'.$colName.'" type="hidden" id="'.$colName.'" value="'.$colValue.'" />';
			}
		}
		if ($Dexcribe['DATA_TYPE'.$kontaCol]=="int") {
			echo '<input type="number" name="'.$colName.'" id="'.$colName.'" value="'.$colValue.'" disabled'.$Xtyle.' >';
		}
		if ($Dexcribe['DATA_TYPE'.$kontaCol]=="text") {
			echo '<textarea name="'.$colName.'" rows="1" id="'.$colName.'"'.$Xtyle.' disabled >'.$colValue.'</textarea>';
		}
		if ($Dexcribe['DATA_TYPE'.$kontaCol]=="decimal") {
			echo '<input type="text" name="'.$colName.'" id="'.$colName.'" value="'.$colValue.'" disabled'.$Xtyle.' >';
		}
		if ($Dexcribe['DATA_TYPE'.$kontaCol]=="enum") {
			echo '<select  name="'.$colName.'" id="'.$colName.'" '.$Xtyle.' class="form-control" disabled >';
			$opxiones=str_replace("enum(", "", $Dexcribe['COLUMN_TYPE'.$kontaCol] );
			$opxiones=str_replace(")", "", $opxiones );
			$opxiones=str_replace("'", "", $opxiones );
			$arrayoptions=explode(",",$opxiones);
			foreach ($arrayoptions as $clave => $valor) {
				$Xeleted="";
				if ($valor==$colValue) {
					$Xeleted='selected="selected"';
				}
				echo '<option value="'.$valor.'" '.$Xeleted.'>'.$valor.'</option>';
			}
			echo '</select>';
		}
		echo '</td>';
	}
?>
  <td align="center" >
  	<div class="progress" style="display: none; margin-top: 0px;" name="prgSaving<?php echo $contarow.$NumWindow; ?>" id="prgSaving<?php echo $contarow.$NumWindow; ?>"> <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%; height: 16px; margin-top: 0px;"> <span class="sr-only">Generando Archivos</span> </div></div>
  		<div class="btn-group btn-group-xs" role="group" aria-label="...">
  		<button id="btnCancelar<?php echo $contarow.$NumWindow; ?>" name="btnCancelar<?php echo $contarow.$NumWindow; ?>" style="display: none;" type="button" class="btn btn-danger" title="Cancelar Edición" onclick="CancelEdit<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')"> <span class="glyphicon glyphicon-ban-circle" aria-hidden="true"></span> </button> 
  		<button id="btnEdit<?php echo $contarow.$NumWindow; ?>" name="btnEdit<?php echo $contarow.$NumWindow; ?>" style="display: block;" type="button" class="btn btn-warning" title="Agregar Registro" onclick="Edit<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </button>
  		<button id="btnSave<?php echo $contarow.$NumWindow; ?>" name="btnSave<?php echo $contarow.$NumWindow; ?>" style="display: none;" type="button" class="btn btn-success" title="Guardar Registro" onclick="SaveNew<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> </button></div>
  		
  </td>
</tr>
				</tbody>
			  </table>
			</div>
		</div>
</div>
</form>

<script >

function Edit<?php echo $NumWindow; ?>(Fila)
{
	document.getElementById("btnCancelar"+Fila+"<?php echo $NumWindow; ?>").style.display="block";
	document.getElementById("btnSave"+Fila+"<?php echo $NumWindow; ?>").style.display="block";
	document.getElementById("btnEdit"+Fila+"<?php echo $NumWindow; ?>").style.display="none";
<?php
  $SQL="SELECT COLUMN_NAME, COLUMN_DEFAULT, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, COLUMN_TYPE, COLUMN_KEY, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$_SESSION["DB_NAME"]."' AND TABLE_NAME='".$nxsTabla."' ORDER BY ORDINAL_POSITION;";
  $rstColumns = mysqli_query($conexion, $SQL);
  while ($rowCols = mysqli_fetch_row($rstColumns)) {
  	if ($rowCols[4]=="char(1)") {
  		echo '
  	document.getElementById("chk_'.$rowCols[0].'"+Fila+"'.$NumWindow.'").disabled = false;';
  	} else {
  		echo '
  	document.getElementById("'.$rowCols[0].'"+Fila+"'.$NumWindow.'").disabled = false;';
  	}
  }
  mysqli_free_result($rstColumns);	
?>
}

function CancelEdit<?php echo $NumWindow; ?>(Fila)
{
	document.getElementById("btnCancelar"+Fila+"<?php echo $NumWindow; ?>").style.display="none";
	document.getElementById("btnSave"+Fila+"<?php echo $NumWindow; ?>").style.display="none";
	document.getElementById("btnEdit"+Fila+"<?php echo $NumWindow; ?>").style.display="block";

<?php
  $SQL="SELECT COLUMN_NAME, COLUMN_DEFAULT, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, COLUMN_TYPE, COLUMN_KEY, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$_SESSION["DB_NAME"]."' AND TABLE_NAME='".$nxsTabla."' ORDER BY ORDINAL_POSITION;";
  $rstColumns = mysqli_query($conexion, $SQL);
  while ($rowCols = mysqli_fetch_row($rstColumns)) {
  	if ($rowCols[4]=="char(1)") {
  		echo '
  	document.getElementById("chk_'.$rowCols[0].'"+Fila+"'.$NumWindow.'").disabled = true;';
  	} else {
  		echo '
  	document.getElementById("'.$rowCols[0].'"+Fila+"'.$NumWindow.'").disabled = true;';
  	}
  }
  mysqli_free_result($rstColumns);	
?>
}

function SaveNew<?php echo $NumWindow; ?>(Fila)
{
	SaveEdit<?php echo $NumWindow; ?>(Fila);
	setTimeout(function(){AbrirForm('application/forms/mastercont.php', '<?php echo $NumWindow; ?>', '&table=<?php echo $nxsTabla; ?>');}, 2750);
}

function SaveEdit<?php echo $NumWindow; ?>(Fila)
{
	document.getElementById("btnCancelar"+Fila+"<?php echo $NumWindow; ?>").style.display="none";
	document.getElementById("btnSave"+Fila+"<?php echo $NumWindow; ?>").style.display="none";
	document.getElementById("prgSaving"+Fila+"<?php echo $NumWindow; ?>").style.display="block";
	
<?php
  $SQL="SELECT COLUMN_NAME, COLUMN_DEFAULT, DATA_TYPE, CHARACTER_MAXIMUM_LENGTH, COLUMN_TYPE, COLUMN_KEY, COLUMN_COMMENT FROM information_schema.COLUMNS WHERE TABLE_SCHEMA='".$_SESSION["DB_NAME"]."' AND TABLE_NAME='".$nxsTabla."' ORDER BY ORDINAL_POSITION;";
  $rstColumns = mysqli_query($conexion, $SQL);
  $nxsData='"Func=MasterCont';
  while ($rowCols = mysqli_fetch_row($rstColumns)) {
  	if ($rowCols[4]=="char(1)") {
  		echo '
  	document.getElementById("chk_'.$rowCols[0].'"+Fila+"'.$NumWindow.'").disabled = true;';
  	} else {
  		echo '
  	document.getElementById("'.$rowCols[0].'"+Fila+"'.$NumWindow.'").disabled = true;';
  	}
  		echo '
  	'.str_replace('_', '', $rowCols[0]).'=document.getElementById("'.$rowCols[0].'"+Fila+"'.$NumWindow.'").value;';
  	$nxsData=$nxsData.'&'.str_replace('_', '', $rowCols[0]).'="+'.str_replace('_', '', $rowCols[0]).'+"';
  }
  mysqli_free_result($rstColumns);
  $nxsData=$nxsData.'&nxsTabla='.$nxsTabla.'"';
?>

	$.ajax({  
		type: "POST",  
		url: Transact + "mastercont.php",  
		data: <?php echo $nxsData; ?>,
		success: function(respuesta) { 
		  MsgBox1("Guardar Registro", respuesta); 
		  document.getElementById("prgSaving"+Fila+"<?php echo $NumWindow; ?>").style.display="none";
		  document.getElementById("btnEdit"+Fila+"<?php echo $NumWindow; ?>").style.display="block";
		}
	});
}

function nxs_chkchar<?php echo $NumWindow; ?>(TheCheck)
{
	if (document.getElementById(TheCheck).value=="1") {
		document.getElementById(TheCheck).value='0';
	} else {
		document.getElementById(TheCheck).value='1';
	}	
}

	document.getElementById("Nuevo<?php echo substr($NumWindow, 6,strlen($NumWindow)); ?>").style.display="none";
	document.getElementById("Anular<?php echo substr($NumWindow, 6,strlen($NumWindow)); ?>").style.display="none";
	document.getElementById("Imprimir<?php echo substr($NumWindow, 6,strlen($NumWindow)); ?>").style.display="none";
	document.getElementById("Guardar<?php echo substr($NumWindow, 6,strlen($NumWindow)); ?>").style.display="none";
	
    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
</script>
<!-- <script src="functions/nexus/ctpuc.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script> -->
