<?php


session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
?>
<div class="row" style="height:98%;">

<div class="panel-group col-md-2" id="accordion<?php echo $NumWindow; ?>" role="tablist" aria-multiselectable="true">

<div class="panel panel-success">
	<div class="panel-heading" role="tab" id="headingOne<?php echo $NumWindow; ?>">
      <h4 class="panel-title">
        <a role="button" data-bs-toggle="collapse" data-toggle="collapse" data-parent="#accordion<?php echo $NumWindow; ?>" href="#collapseOne<?php echo $NumWindow; ?>" aria-expanded="true" aria-controls="collapseOne<?php echo $NumWindow; ?>">
          <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Parámetros
        </a>
      </h4>
    </div>

<div id="collapseOne<?php echo $NumWindow; ?>" class="panel-collapse collapse show in" role="tabpanel" aria-labelledby="headingOne<?php echo $NumWindow; ?>">

<form id="frm_form<?php echo $NumWindow; ?>"><div class="panel-body contreport" id="div_cont<?php echo $NumWindow; ?>">
<?php 
$SQL="Select Campo_RPT, Titulo_RPT, Tipo_RPT, Value_RPT, Script_RPT, Search_RPT from nxs_gnx.itreportsparam where trim(codigo_rpt)=trim('".$_GET["reporte"]."') Order By Orden_RPT";
//echo $SQL;
$conexion=Conexion();
$result = mysqli_query($conexion, $SQL);
$AutoExecuteRpt=0;
$AutoExecuteStr="";
$destino="application/reports/".$_GET["reporte"]."?";
/* $datespickers=0; */
while($row = mysqli_fetch_array($result)) {
	$type="text";
	$value="";
	$clase="";
	$enabled="";
	$autoFill="";
	if (substr($row["Campo_RPT"],-8)=="_INICIAL") {
		$autoFill=' onblur="printIni'.$NumWindow.'(\''.substr($row["Campo_RPT"],0,strlen($row["Campo_RPT"])-8).'\')"';
	}
	if ($row["Value_RPT"]!=" ") {
		$value=$row["Value_RPT"];
		eval ($value);
	}
	if ($row["Tipo_RPT"]=="D") {
	/*	$datespickers++; 
		$clase="datepicker datepicker".$datespickers; */
		$type="date";
		$value=date('Y-m-d');
	}
	if ($row["Tipo_RPT"]=="M") {
	/*	$datespickers++; 
		$clase="datepicker datepicker".$datespickers; */
		$type="time";
		$value=date('G');
	}
	if (isset($_GET[$row["Campo_RPT"]])) {
		$value=$_GET[$row["Campo_RPT"]];
		$AutoExecuteRpt=1;
		$enabled=' disabled="disabled" ';
		$AutoExecuteStr=$AutoExecuteStr.$row["Campo_RPT"]."=".$_GET[$row["Campo_RPT"]]."&";
		$destino=$destino.$row["Campo_RPT"]."=".$_GET[$row["Campo_RPT"]]."&";
	}
	if ($row["Tipo_RPT"]=="H") {
		echo '<input type="hidden" name="txt_'.$row["Campo_RPT"].$NumWindow.'" id="txt_'.$row["Campo_RPT"].$NumWindow.'" value="'.$value.'" '.$enabled.'  >
  ';
	} elseif ($row["Tipo_RPT"]=="L"){
		echo '<div class="form-group">
		<label for="txt_'.$row["Campo_RPT"].$NumWindow.'">'.htmlspecialchars($row["Titulo_RPT"]).'</label>
  <select name="txt_'.$row["Campo_RPT"].$NumWindow.'" id="txt_'.$row["Campo_RPT"].$NumWindow.'" class="form-control '.$clase.'" '.$enabled.' ';
  		eval($row["Script_RPT"]);
	    echo '>';
  		$SQL="Select Valor_RPT, Texto_RPT, Comando_RPT, Seleccionado_RPT from nxs_gnx.itreportslistas where trim(Codigo_rpt)=trim('".$_GET["reporte"]."') and trim(Campo_rpt)=trim('".$row["Campo_RPT"]."') Order By Orden_RPT";
//		echo $SQL;
		$resultx = mysqli_query($conexion, $SQL);
		while($rowx = mysqli_fetch_array($resultx)) {
			$Seleccion="";
			if ($rowx["Seleccionado_RPT"]=="1") {
				$Seleccion=' selected="selected" ';
			}
			echo '    <option value="'.$rowx["Valor_RPT"].'"'.$Seleccion;
			if ($rowx["Comando_RPT"]!=' ') {
				eval($rowx["Comando_RPT"]);
			}
			echo '>'.$rowx["Texto_RPT"].'</option> ';
		}
		echo '
  </select>
  </div>
  ';
	} elseif ($row["Tipo_RPT"]=="S"){ /* Select a traves de consulta */
		echo '<div class="form-group">
		<label for="txt_'.$row["Campo_RPT"].$NumWindow.'">'.htmlspecialchars($row["Titulo_RPT"]).'</label>
  <select name="txt_'.$row["Campo_RPT"].$NumWindow.'" id="txt_'.$row["Campo_RPT"].$NumWindow.'" class="form-control '.$clase.'" '.$enabled.' ';
  		eval($row["Script_RPT"]);
	    echo '>';
  		$SQL="Select Consulta_RPT, Comando_RPT from nxs_gnx.itreportsselects where trim(Codigo_rpt)=trim('".$_GET["reporte"]."') and trim(Campo_rpt)=trim('".$row["Campo_RPT"]."') ";
//		echo $SQL;
		$resultxt = mysqli_query($conexion, $SQL);
		if($rowxt = mysqli_fetch_array($resultxt)) {
			$SQL=$rowxt["Consulta_RPT"];
		}
		$resultx = mysqli_query($conexion, $SQL);
		while($rowx = mysqli_fetch_array($resultx)) {
			echo '    <option value="'.$rowx[0].'"'.$Seleccion;
			if ($rowx[2]!=' ') {
				eval($rowx[2]);
			}
			echo '>'.$rowx[1].'</option> ';
		}
		echo '
  </select>
  </div>
  ';
	}  else {
		
		echo '<div class="form-group">
		<label for="txt_'.$row["Campo_RPT"].$NumWindow.'">'.htmlspecialchars($row["Titulo_RPT"]).'</label>';
		if ($datespickers==12){
			echo '<div class="form-group">
            <div class="input-group date" id="'.$clase.$NumWindow.'">';
		}
		if ($row["Search_RPT"]!="") {
			echo '<div class="input-group">';
		}
  		echo '<input type="'.$type.'" name="txt_'.$row["Campo_RPT"].$NumWindow.'" id="txt_'.$row["Campo_RPT"].$NumWindow.'" class="form-control '.$clase.$NumWindow.'" value="'.$value.'"  '.$autoFill.$enabled.' ';
  		eval($row["Script_RPT"]);
	    echo '>';
	    if ($row["Search_RPT"]!="") {
			echo '<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-bs-toggle="modal" data-target="#GnmX_Search" data-bs-target="#GnmX_Search" data-whatever="RptSearch" onclick="javascript:CargarSearch(\''.$row["Search_RPT"].'\', \'txt_'.$row["Campo_RPT"].$NumWindow.'\', \'NULL\');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			</span>
		</div>';
		}
		if ($datespickers==12){
			echo '<span class="input-group-addon bg-info">
                    <span class="glyphicon glyphicon-calendar"></span>
                </span>
            </div>
        </div>';
		}
	    echo '
  </div>';
	}
}
$AutoExecuteStr=$AutoExecuteStr."Cero=0";
mysqli_free_result($result);
?>
<button id="btn_exect<?php echo $NumWindow; ?>" class="btn btn-success btn-sm btn-block" type="button" onClick="javascript: rptpreview<?php echo $NumWindow; ?>('<?php echo $destino; ?>');"><span id="nxs_previw<?php echo $NumWindow; ?>"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Vista Previa</span><span id="nxs_load<?php echo $NumWindow; ?>"><i class="far fa-hourglass"></i> </span></button>
</form>

</div>
</div>
</div>



</div>
<div class="col-md-10">	
<div id="pdfrpt<?php echo $NumWindow; ?>" class="panel panel-success rpt-border">

  <iframe src='' frameborder='0' allowtransparency='true' style='margin:0; padding:0; width:100%; height: 90%; ' name='iframecont<?php echo $NumWindow; ?>' id="iframecont<?php echo $NumWindow; ?>" class="pdf1 panel-body" onload="frameLoaded<?php echo $NumWindow; ?>();">   
     </iframe> 
</div>
</div>

</div>


  <script >
  	$('#nxs_load<?php echo $NumWindow; ?>').css('display', 'none');
    $('#nxs_previw<?php echo $NumWindow; ?>').css('display', 'block');
  	destino="application/reports/rpt/nxs_rpt.php";
<?php 
	if ($AutoExecuteRpt==1) {
?>
	destino="application/reports/nxs_rpt.php?nxsrpt=<?php echo $_GET["reporte"]; ?>&<?php echo $AutoExecuteStr; ?>";
<?php
	}
	/*if ($datespickers!=0){
?>
	$('.datepicker').datepicker({
		format: "dd/mm/yyyy",
		language: "es",
		autoclose: true
	});
	
	$(".datepicker1<?php echo $NumWindow; ?>").on("dp.change", function (e) {
        $('.datepicker2<?php echo $NumWindow; ?>').data("DateTimePicker").minDate(e.date);
    });
    $(".datepicker2<?php echo $NumWindow; ?>").on("dp.change", function (e) {
        $('.datepicker1<?php echo $NumWindow; ?>').data("DateTimePicker").maxDate(e.date);
    });
<?php		
	} */
?>
	window.frames.iframecont<?php echo $NumWindow; ?>.location.href = destino;
	// $('#pdfrpt<?php echo $NumWindow; ?>').height()=$('#<?php echo $NumWindow; ?>').height()-100;
	
function upd_mesfincot<?php echo $NumWindow; ?>()
{
	anyo=$('#txt_ANYO<?php echo $NumWindow; ?>').value;
	mes1=$('#txt_MES_INICIAL<?php echo $NumWindow; ?>').value;
	totalmese=$('#txt_MESES<?php echo $NumWindow; ?>').value;
	
$('#txt_MES_FINAL<?php echo $NumWindow; ?>').value=mes1-totalmeses-1;
}
function printIni<?php echo $NumWindow; ?>(Tipo)
{
	valIni=document.getElementById('txt_'+Tipo+'_INICIAL<?php echo $NumWindow; ?>').value;
	valFin=document.getElementById('txt_'+Tipo+'_FINAL<?php echo $NumWindow; ?>').value;
	if (valFin=="") {
		document.getElementById('txt_'+Tipo+'_FINAL<?php echo $NumWindow; ?>').value=valIni;
	}
}
function rptpreview<?php echo $NumWindow; ?>(Pagina)
{
	$('#iframecont<?php echo $NumWindow; ?>').css("opacity",".5");
	$('#btn_exect<?php echo $NumWindow; ?>').css('background-color', '#EFEFEF');
	$('#nxs_load<?php echo $NumWindow; ?>').css('display', 'block');
    $('#nxs_previw<?php echo $NumWindow; ?>').css('display', 'none');
	var FormPost="";
	var FormPostx="";
	var Var1="";
	$(':input', "#frm_form<?php echo $NumWindow; ?>").each(function() {
		Var1=this.name;
		Var1=Var1.substring(4,Var1.indexOf('zR'));
		if (this.type=="select-one") {
			FormPost=FormPost+Var1+"*"+this.value+"|";
			FormPostx=FormPostx+Var1+"="+this.value+"&";
		} else {
			FormPost=FormPost+Var1+"*"+this.value.toUpperCase()+"|";
			FormPostx=FormPostx+Var1+"="+this.value.toUpperCase()+"&";
		}
	});
	FormPost=String(FormPost).substring(0,String(FormPost).length-1);
	window.frames.iframecont<?php echo $NumWindow; ?>.location.href = "application/reports/rpt/nxs_rpt.php?nxsdb=<?php echo $_SESSION["DB_SUFFIX"]; ?>&nxsrpt=<?php echo $_GET["reporte"]; ?>&nxsget="+FormPost+FormPostx;
}
function frameLoaded<?php echo $NumWindow; ?>() {
    $('#nxs_load<?php echo $NumWindow; ?>').css('display', 'none');
    $('#nxs_previw<?php echo $NumWindow; ?>').css('display', 'block');
    $('#btn_exect<?php echo $NumWindow; ?>').css('background-color', '#398439');
    $('#iframecont<?php echo $NumWindow; ?>').css("opacity","");
}
</script>