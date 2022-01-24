<?php
session_start();
	$NumWindow=$_GET["target"];
	$nxsTabla=$_GET["table"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;

	$SQL="Select curdate();";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
 		$nxsFecNow=$row[0];
 	}
	mysqli_free_result($result);

	$nxsTercero="";
	$nxsCCosto="";
	$nxsFechaIni="";
	$nxsFechaFin="";
	$nxsFuente="";
	$nxsCuenta="";
	if (isset($_GET["nxsTercero"])) {
		$nxsTercero=$_GET["nxsTercero"];
	}
	if (isset($_GET["nxsFuente"])) {
		$nxsFuente=$_GET["nxsFuente"];
	}
	if (isset($_GET["nxsCCosto"])) {
		$nxsCCosto=$_GET["nxsCCosto"];
	}
	if (isset($_GET["nxsFechaIni"])) {
		$nxsFechaIni=$_GET["nxsFechaIni"];
	} else {
		$nxsFechaIni=$nxsFecNow;
	}
	if (isset($_GET["nxsFechaFin"])) {
		$nxsFechaFin=$_GET["nxsFechaFin"];
	} else {
		$nxsFechaFin=$nxsFecNow;
	}
	if (isset($_GET["nxsCuenta"])) {
		$nxsCuenta=$_GET["nxsCuenta"];
	}
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>"  enctype="multipart/form-data"  >
	<div class="row">
  <div class="col-md-10">
	<button class="btn btn-default btn-xs btn-block" type="button" data-toggle="collapse" data-target="#divFilter<?php echo $NumWindow; ?>" aria-expanded="false" aria-controls="divFilter<?php echo $NumWindow; ?>" style="font-weight: bold;color: #ffffff;background-color: darkseagreen;font-size: 15px;text-align: left;"> <span class="glyphicon glyphicon-filter" aria-hidden="true"></span> Filtrar Resultados </button>
	<div class="row well well-sm collapse" aria-expanded="false" id="divFilter<?php echo $NumWindow; ?>">
		
	<div class="col-md-2">
<div class="form-group">
  <label for="cmb_fuente<?php echo $NumWindow; ?>">Documento</label>
  <select name="cmb_fuente<?php echo $NumWindow; ?>" id="cmb_fuente<?php echo $NumWindow; ?>">
  	<option value="">-- Todos --</option>
    <?php 
    $SwSede=0;
    $SQL="Select Codigo_FNC, Nombre_FNC From czfuentescont Order By Nombre_FNC";
    $result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{
		$SwSede=1;
 	?>
    	<option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
    <?php
	}
	mysqli_free_result($result);
	?>
  </select>
</div>
	</div>

	<div class="col-md-2">
<div class="form-group">
  <label for="cmb_ccosto<?php echo $NumWindow; ?>">Centro de Costo</label>
  <select name="cmb_ccosto<?php echo $NumWindow; ?>" id="cmb_ccosto<?php echo $NumWindow; ?>">
  	<option value="">-- Todos --</option>
    <?php 
    $SwSede=0;
    $SQL="Select Codigo_CCT, Nombre_CCT From czcentrocosto Order By Nombre_CCT";
    $result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{
		$SwSede=1;
 	?>
    	<option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
    <?php
	}
	mysqli_free_result($result);
	?>
  </select>
</div>
	</div>

	<div class="col-md-2">
<div class="form-group">
  <label for="txt_cuenta<?php echo $NumWindow; ?>">Cuenta</label>
  	<div class="input-group">	
  		<input name="txt_cuenta<?php echo $NumWindow; ?>" type="text" id="txt_cuenta<?php echo $NumWindow; ?>" required />
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Contrato" onclick="javascript:CargarSearch('PUC', '<?php echo 'txt_cuenta'.$NumWindow; ?>', 'Codigo_NVL=*5*');"><i class="fas fa-search"></i></button>
  		</span>
  	</div>
</div>
	</div>

	<div class="col-md-2">
<div class="form-group">
  <label for="txt_tercero<?php echo $NumWindow; ?>">Tercero</label>
  	<div class="input-group">	
  		<input name="txt_tercero<?php echo $NumWindow; ?>" type="text" id="txt_tercero<?php echo $NumWindow; ?>" required />
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Contrato" onclick="javascript:CargarSearch('Tercero', '<?php echo 'txt_tercero'.$NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
  		</span>
  	</div>
</div>
	</div>

	<div class="col-md-2">
<div class="form-group">
  <label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicial</label>
  <input name="txt_fechaini<?php echo $NumWindow; ?>" type="date" id="txt_fechaini<?php echo $NumWindow; ?>" required />
</div>
	</div>

	<div class="col-md-2">
<div class="form-group">
  <label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Final</label>
  <input name="txt_fechafin<?php echo $NumWindow; ?>" type="date" id="txt_fechafin<?php echo $NumWindow; ?>" required />
</div>
	</div>

	<div class="col-md-12">
		<button type="button" class="btn btn-success btn-xs btn-block" onclick="javascript:filterMovCont<?php echo $NumWindow; ?>();">Actualizar <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
	</div>

	</div>
  </div>
  <div class="col-md-2">
  <div class="btn-group ">
	  <button type="button" class="btn btn-default btn-xs" style="font-weight: bold;color: #ffffff;background-color: darkseagreen;font-size: 15px;text-align: left;" onclick="NewMovCont<?php echo $NumWindow; ?>()"> <span class="glyphicon glyphicon-file" aria-hidden="true"></span> Nuevo Asiento</button>
	  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-weight: bold;color: #ffffff;background-color: darkseagreen;font-size: 15px;text-align: left; height: 26px; padding-bottom: 1px; padding-top: 1px;">
	    <span class="caret"></span>
	    <span class="sr-only">Toggle Dropdown</span>
	  </button>
	  <ul class="dropdown-menu" style="color: #ffffff;background-color: #e3ff4a; ">
	    <li><a href="javascript:InitMovCont<?php echo $NumWindow; ?>()"> <span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span> Saldos Iniciales</a></li>
	  </ul>
  </div>
  </div>
    </div>
	<div class="row">
		<div class="panel panel-success">
			<div id="zero_detalle<?php echo $nxsTabla.$NumWindow; ?>" class=" table-responsive ">
			  <table  align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $nxsTabla.$NumWindow; ?>" >
				<thead id="thDetalle<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $nxsTabla.$NumWindow; ?>" style="font-size:11px; cursor:auto;">
				  <th style="font-size: 8px;">#</th>
				  <th style="font-size: 8px;">ASIENTO</th>
				  <th style="font-size: 8px;">FECHA</th>
				  <th style="font-size: 8px;" >REFERENCIA</th>
				  <th style="font-size: 8px;">OBSERVACIONES</th>
				  <th style="font-size: 8px;">TOTAL</th>
				  <th style="font-size: 8px; width: 80px;">VER</th>
				</tr> 
				</thead>
				<tbody>
<?php
  $nxsCondx="";
  if ($nxsFuente!="") {
  	$nxsCondx=$nxsCondx." and Codigo_FNC='".$nxsFuente."' ";
  }
  if ($nxsCuenta!="") {
  	$nxsCondx=$nxsCondx." and Codigo_CTA='".$nxsCuenta."' ";
  }
  if ($nxsTercero!="") {
  	$nxsCondx=$nxsCondx." and Codigo_TER in (Select Codigo_TER from czterceros Where ID_TER='".$nxsTercero."') ";
  }
  if ($nxsCCosto!="") {
  	$nxsCondx=$nxsCondx." and Codigo_CCT='".$nxsCCosto."' ";
  }
  
  $SQL="Select distinct Codigo_FNC, Consec_FNC, Fecha_CNT, Referencia_CNT, Observaciones_CNT, Total_CNT, a.Codigo_CNT From czmovcontcab a, czmovcontdet b Where a.Codigo_CNT=b.Codigo_CNT and Fecha_CNT between '".$nxsFechaIni."' and '".$nxsFechaFin." 23:59:59' ".$nxsCondx." Order By a.Codigo_CNT desc";
  $rstRecord = mysqli_query($conexion, $SQL);
  while ($rowREC = mysqli_fetch_row($rstRecord)) {
  	$contarow++;
?>
<tr style="cursor: auto;font-size: 10px;">
  <td style="padding-top: 3px; padding-bottom: 2px;" align="center"><?php echo $rowREC[6]; ?></td>
  <td style="padding-top: 3px; padding-bottom: 2px;" align="center"><b><?php echo $rowREC[0].'-'.$rowREC[1]; ?></b></td>
  <td style="padding-top: 3px; padding-bottom: 2px;" align="center"><?php echo $rowREC[2]; ?></td>
  <td style="padding-top: 3px; padding-bottom: 2px;" align="left"><?php echo $rowREC[3]; ?></td>
  <td style="padding-top: 3px; padding-bottom: 2px;" align="left"><?php echo $rowREC[4]; ?></td>
  <td style="padding-top: 3px; padding-bottom: 2px;" align="right"><b><?php echo '$ '.number_format($rowREC[5],2,'.',','); ?></b></td>
  <td align="center" >
	<span class="label label-default" id="spn_viewdet<?php echo $contarow.$NumWindow; ?>" onclick="detShow<?php echo $NumWindow; ?>('<?php echo $contarow; ?>')" style="cursor: pointer;"> <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> </span>
  </td>
</tr>
<tr id="tr_detmcont<?php echo $contarow.$NumWindow; ?>" style="display: none;">
	<td style=" width: 100px; vertical-align: middle;" align="center" colspan="2">
		<span class="label label-default" style="background-color: darkseagreen; color: white;"><?php echo $rowREC[6].'-'.$rowREC[0].'-'.$rowREC[1]; ?> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </span>
	</td>
	<td colspan="5">
			 <table  align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-condensed tblDetalle table-striped table-bordered" id="tblDetalle<?php echo $nxsTabla.$NumWindow; ?>" style="margin-bottom: 0px;" >
				<thead id="thDetalle<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $nxsTabla.$NumWindow; ?>" style="font-size:11px; cursor:auto;">
				  <th style="font-size: 8px; background-color: #8fbc8f;">Tercero</th>
				  <th style="font-size: 8px; background-color: #8fbc8f;">Cuenta</th>
				  <th style="font-size: 8px; background-color: #8fbc8f;">Descripcion</th>
				  <th style="font-size: 8px; background-color: #8fbc8f;">C. Costo</th>
				  <th style="font-size: 8px; background-color: #8fbc8f;">Débito</th>
				  <th style="font-size: 8px; background-color: #8fbc8f;">Crédito</th>
				  <th style="font-size: 8px; width: 80px; background-color: #8fbc8f;">Acciones</th>
				</tr> 
				</thead>
				<tbody>
<?php
// Detalle Asiento Contable
	  $Kcont=0;
	  $SQL="SELECT Nombre_TER, a.Codigo_CTA, a.Descripcion_CNT, Nombre_CCT, Debito_CNT, Credito_CNT From czmovcontdet a LEFT JOIN czterceros b ON a.Codigo_TER=b.Codigo_TER LEFT JOIN cztipoid e ON b.Codigo_TID=e.Codigo_TID LEFT JOIN czcentrocosto d ON a.Codigo_CCT=d.Codigo_CCT Where Codigo_CNT=".$rowREC[6]." Order By 2";
	  error_log($SQL);
	  $rstRecordx = mysqli_query($conexion, $SQL);
	  while ($rowRECx = mysqli_fetch_row($rstRecordx)) {
	  	$Kcont++;
?>
<tr style="cursor: auto;font-size: 10px;">
  <td style="padding-top: 3px; padding-bottom: 2px;" align="left"><?php echo $rowRECx[0]; ?></td>
  <td style="padding-top: 3px; padding-bottom: 2px;" align="center"><?php echo $rowRECx[1]; ?></td>
  <td style="padding-top: 3px; padding-bottom: 2px;" align="left"><?php echo $rowRECx[2]; ?></td>
  <td style="padding-top: 3px; padding-bottom: 2px;" align="left"><?php echo $rowRECx[3]; ?></td>
  <td style="padding-top: 3px; padding-bottom: 2px;" align="right"><?php echo '$ '.number_format($rowRECx[4],2,'.',','); ?></td>
  <td style="padding-top: 3px; padding-bottom: 2px;" align="right"><?php echo '$ '.number_format($rowRECx[5],2,'.',','); ?></td>
  <td align="center" >
  	<?php
  	if ($Kcont==1) {
  	?>
	<div class="btn-group btn-group-xs" role="group" aria-label="...">
		<button id="btnEdit<?php echo $contarow.$NumWindow; ?>" name="btnEdit<?php echo $contarow.$NumWindow; ?>"  type="button" class="btn btn-info" title="Editar Asiento" onclick="EditMovCont<?php echo $NumWindow; ?>('<?php echo $rowREC[6]; ?>')"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> </button>
		<button id="btnPrint<?php echo $contarow.$NumWindow; ?>" name="btnPrint<?php echo $contarow.$NumWindow; ?>"  type="button" class="btn btn-warning" title="Imprimir Movimiento Contable" onclick="PrintMovCont<?php echo $NumWindow; ?>('<?php echo $rowREC[6]; ?>')"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </button>
	</div>
	<?php
	}
  	?>
  </td>
</tr>

<?php
	  }
	  mysqli_free_result($rstRecordx);
?>
				</tbody>
		  </table>
	</td>
</tr>
<?php
  }
  mysqli_free_result($rstRecord);
?>
				</tbody>
			  </table>
			</div>
		</div>
</div>
</form>

<script >

<?php
echo 'document.getElementById("txt_tercero'.$NumWindow.'").value="'.$nxsTercero.'";';
echo 'document.getElementById("cmb_ccosto'.$NumWindow.'").value="'.$nxsCCosto.'";';
echo 'document.getElementById("txt_fechaini'.$NumWindow.'").value="'.$nxsFechaIni.'";';
echo 'document.getElementById("txt_fechafin'.$NumWindow.'").value="'.$nxsFechaFin.'";';
echo 'document.getElementById("cmb_fuente'.$NumWindow.'").value="'.$nxsFuente.'";';
echo 'document.getElementById("txt_cuenta'.$NumWindow.'").value="'.$nxsCuenta.'";';
?>
function filterMovCont<?php echo $NumWindow; ?>() {
	nxsTercero=document.getElementById("txt_tercero<?php echo $NumWindow; ?>").value;
	nxsCCosto=document.getElementById("cmb_ccosto<?php echo $NumWindow; ?>").value;
	nxsFechaIni=document.getElementById("txt_fechaini<?php echo $NumWindow; ?>").value;
	nxsFechaFin=document.getElementById("txt_fechafin<?php echo $NumWindow; ?>").value;
	nxsFuente=document.getElementById("cmb_fuente<?php echo $NumWindow; ?>").value;
	nxsCuenta=document.getElementById("txt_cuenta<?php echo $NumWindow; ?>").value;

	AbrirForm('application/forms/ctmovcont.php', '<?php echo $NumWindow; ?>', '&nxsTercero='+nxsTercero+'&nxsCCosto='+nxsCCosto+'&nxsFechaIni='+nxsFechaIni+'&nxsFechaFin='+nxsFechaFin+'&nxsCuenta='+nxsCuenta+'&nxsFuente='+nxsFuente);
}

function detShow<?php echo $NumWindow; ?>(detRow)
{
	Extado=document.getElementById("tr_detmcont"+detRow+"<?php echo $NumWindow; ?>").style.display;
	if (Extado=="none") {
		document.getElementById("tr_detmcont"+detRow+"<?php echo $NumWindow; ?>").style.display="table-row";
		document.getElementById("spn_viewdet"+detRow+"<?php echo $NumWindow; ?>").innerHTML=' <span class="glyphicon glyphicon-minus" aria-hidden="true"></span> ';
	} else {
		document.getElementById("tr_detmcont"+detRow+"<?php echo $NumWindow; ?>").style.display="none";
		document.getElementById("spn_viewdet"+detRow+"<?php echo $NumWindow; ?>").innerHTML=' <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> ';
	}
}

function EditMovCont<?php echo $NumWindow; ?>(NumMov) 
{
	/* $('#GnmX_WinModal').modal('show'); */
	CargarForm('application/forms/ctmovimientos.php?CNT='+NumMov, 'Asiento Contable # '+NumMov, 'sallary_deferrais.png');
}

function PrintMovCont<?php echo $NumWindow; ?>(NumMov) 
{
	$('#GnmX_WinModal').modal('show');
	CargarWind('Asiento Contable # '+NumMov, 'reports/ctmovcont.php?CNT1='+NumMov+'&CNT2='+NumMov, 'default.png', 'ctmovcont.php','<?php echo $NumWindow; ?>' );
}

function NewMovCont<?php echo $NumWindow; ?>()
{
	/* $('#GnmX_WinModal').modal('show'); */
	CargarForm('application/forms/ctmovimientos.php','Nuevo Asiento Contable', 'sallary_deferrais.png');
}
	
function InitMovCont<?php echo $NumWindow; ?>()
{
	$('#GnmX_WinModal').modal('show');
	CargarWind('Saldos Iniciales Contabilidad', 'forms/ctmovimientos.php?CNT=0', 'info_rhombus.png', 'ctmovcont.php','<?php echo $NumWindow; ?>' );
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
