<?php


session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
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
$SQL="Select Campo_RPT, Titulo_RPT, Tipo_RPT, Value_RPT, Script_RPT, Search_RPT from ".$_SESSION['DB_NXS'].".itreportsparam where trim(codigo_rpt)=trim('".$_GET["reporte"]."') Order By Orden_RPT";
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
  		$SQL="Select Valor_RPT, Texto_RPT, Comando_RPT, Seleccionado_RPT from ".$_SESSION['DB_NXS'].".itreportslistas where trim(Codigo_rpt)=trim('".$_GET["reporte"]."') and trim(Campo_rpt)=trim('".$row["Campo_RPT"]."') Order By Orden_RPT";
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
  		$SQL="Select Consulta_RPT, Comando_RPT from ".$_SESSION['DB_NXS'].".itreportsselects where trim(Codigo_rpt)=trim('".$_GET["reporte"]."') and trim(Campo_rpt)=trim('".$row["Campo_RPT"]."') ";
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
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-bs-toggle="modal" data-bs-target="#GnmX_Search" data-whatever="RptSearch" onclick="javascript:CargarSearch(\''.$row["Search_RPT"].'\', \'txt_'.$row["Campo_RPT"].$NumWindow.'\', \'NULL\');"> <i class="fas fa-search"></i> </button>
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
<button class="btn btn-success btn-sm btn-block" type="button" onClick="javascript: rptpreview<?php echo $NumWindow; ?>('<?php echo $destino; ?>');"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Vista Previa</button>
</form>

</div>
</div>
</div>

<div class="panel panel-success">
    <div class="panel-heading" role="tab" id="headingTwo<?php echo $NumWindow; ?>">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-bs-toggle="collapse" data-toggle="collapse" data-parent="#accordion<?php echo $NumWindow; ?>" href="#collapseTwo<?php echo $NumWindow; ?>" aria-expanded="false" aria-controls="collapseTwo<?php echo $NumWindow; ?>">
          <span class="glyphicon glyphicon-share" aria-hidden="true"></span> Exportar...
        </a>
      </h4>
    </div>

	<div id="collapseTwo<?php echo $NumWindow; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo<?php echo $NumWindow; ?>">
      <div class="list-group">    
    
    	<button type="button" class="btn exportrpt list-group-item" onClick="javascript: rpthideoptions<?php echo $NumWindow; ?>();">Archivo de texto</button>

    	<button type="button" class="exportrpt list-group-item" onClick="javascript: rptxls<?php echo $NumWindow; ?>('<?php echo $destino; ?>');">Hoja de cálculo</button>

	  </div>
	</div>
</div>

</div>
<div class="col-md-10">
<div id="pdfrpt<?php echo $NumWindow; ?>" class="panel panel-success rpt-border">
<iframe src='' frameborder='0' allowtransparency='true' style='margin:0; padding:0; width:100%; height: 90%; ' name='iframecont<?php echo $NumWindow; ?>' id="iframecont<?php echo $NumWindow; ?>" class="pdf1 panel-body">   
     </iframe>
</div>
</div>

</div>


<script>
	destino="settings/report.html";
<?php 
	if ($AutoExecuteRpt==1) {
?>
	destino="application/reports/<?php echo $_GET["reporte"]; ?>.php?<?php echo $AutoExecuteStr; ?>";
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
	$('#pdfrpt<?php echo $NumWindow; ?>').height()=$('#<?php echo $NumWindow; ?>').height()-100;
	
function upd_mesfincot<?php echo $NumWindow; ?>()
{
	anyo=$('#txt_ANYO<?php echo $NumWindow; ?>').value;
	mes1=$('#txt_MES_INICIAL<?php echo $NumWindow; ?>').value;
	totalmese=$('#txt_MESES<?php echo $NumWindow; ?>').value;
	
$('#txt_MES_FINAL<?php echo $NumWindow; ?>').value=mes1-totalmeses-1;
}

function rptpreview<?php echo $NumWindow; ?>(Pagina)
{
	var FormPost="";
	var Var1="";
	$(':input', "#frm_form<?php echo $NumWindow; ?>").each(function() {
		Var1=this.name;
		Var1=Var1.substring(4,Var1.indexOf('zR'));
		FormPost=FormPost+Var1+"="+this.value.toUpperCase()+"&";
	});
	FormPost=String(FormPost).substring(0,String(FormPost).length-1);
	theUrl="http://app.genomax.co/his/"+"application/reports/<?php echo $_GET["reporte"] ?>.php?"+FormPost;
	theUrl="https://docs.google.com/viewerng/viewer?url="+theUrl;
	theUrl="application/reports/<?php echo $_GET["reporte"] ?>.php?"+FormPost;
	window.frames.iframecont<?php echo $NumWindow; ?>.location.href = theUrl;
}
function printIni<?php echo $NumWindow; ?>(Tipo)
{
	valIni=document.getElementById('txt_'+Tipo+'_INICIAL<?php echo $NumWindow; ?>').value;
	valFin=document.getElementById('txt_'+Tipo+'_FINAL<?php echo $NumWindow; ?>').value;
	if (valFin=="") {
		document.getElementById('txt_'+Tipo+'_FINAL<?php echo $NumWindow; ?>').value=valIni;
	}
}
function rptxls<?php echo $NumWindow; ?>(Pagina)
{
	var FormPost="";
	var Var1="";
	$(':input', "#frm_form<?php echo $NumWindow; ?>").each(function() {
		Var1=this.name;
		Var1=Var1.substring(4,Var1.indexOf('zR'));
		FormPost=FormPost+Var1+"="+this.value.toUpperCase()+"&";
	});
	FormPost=String(FormPost).substring(0,String(FormPost).length-1)
	// window.open("application/reports/export-excel.php?reporte=<?php echo $_GET["reporte"] ?>&"+FormPost,"","");
	window.open("application/reports/report-excel.php?rpt=<?php echo $_GET["reporte"] ?>&"+FormPost,"","");
}
</script>