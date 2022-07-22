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

<div class="panel-group col-md-2" id="accordion<?php echo $NumWindow; ?>" role="tablist" aria-multiselectable="true">
    <div class="panel panel-success">
        <div class="panel-heading" role="tab" id="headingOnezRpt_3">
        <h4 class="panel-title">
            <a role="button" data-bs-toggle="collapse" data-toggle="collapse" data-parent="#accordionzRpt_3" href="#collapseOnezRpt_3" aria-expanded="true" aria-controls="collapseOnezRpt_3">
            <span class="glyphicon glyphicon-check" aria-hidden="true"></span> Parámetros
            </a>
        </h4>
        </div>

    <div id="collapseOnezRpt_3" class="panel-collapse collapse show in" role="tabpanel" aria-labelledby="headingOnezRpt_3">

    <form id="frm_formzRpt_3"><div class="panel-body contreport" id="div_contzRpt_3">
    <div class="form-group">
            <label for="txt_MEDICOzRpt_3">ID Profesional</label><div class="input-group"><input type="text" name="txt_MEDICOzRpt_3" id="txt_MEDICOzRpt_3" class="form-control zRpt_3" value="" onclick="javascript: rpthideoptionszRpt_3();"><span class="input-group-btn">	
                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-bs-toggle="modal" data-bs-target="#GnmX_Search" data-whatever="RptSearch" onclick="javascript:CargarSearch('ProfesionalesSalud', 'txt_MEDICOzRpt_3', 'NULL');"> <i class="fas fa-search"></i> </button>
                </span>
            </div>
    </div><div class="form-group">
            <label for="txt_VARFECHAzRpt_3">Tipo Fecha</label>
    <select name="txt_VARFECHAzRpt_3" id="txt_VARFECHAzRpt_3" class="form-control" onclick="javascript: rpthideoptionszRpt_3();">    <option value="c.Fecha_AGE" selected="selected">F. Programada</option>     <option value="c.FechaGraba_CIT">F. Registro</option> 
    </select>
    </div>
    <div class="form-group">
            <label for="txt_FECHA_INICIALzRpt_3">Fecha Inicial</label><input type="date" name="txt_FECHA_INICIALzRpt_3" id="txt_FECHA_INICIALzRpt_3" class="form-control zRpt_3" value="2022-03-04" onclick="javascript: rpthideoptionszRpt_3();">
    </div><div class="form-group">
            <label for="txt_FECHA_FINALzRpt_3">Fecha Final</label><input type="date" name="txt_FECHA_FINALzRpt_3" id="txt_FECHA_FINALzRpt_3" class="form-control zRpt_3" value="2022-03-04" onclick="javascript: rpthideoptionszRpt_3();">
    </div><button class="btn btn-success btn-sm btn-block" type="button" onclick="javascript: rptpreviewzRpt_3('application/reports/citasprogramadas?');"><span class="glyphicon glyphicon-duplicate" aria-hidden="true"></span> Vista Previa</button>


    </div></form>
    </div>
    </div>

</div>

<div class="col-md-10">
    

</div>

</div>

</form>

<script >
<?php
    $title="";
    switch ($type) {
        // Estado de Resultados
        case 'ct_incomestatement':
            $title="Estado de Resultados";
        break;
    }
    echo 'document.getElementById("'.$NumWindow.'").value="'.$title.'";';
?>

	$("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");


</script>

