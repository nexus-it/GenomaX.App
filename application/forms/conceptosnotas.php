<?php
	
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>

<form action="" method="post" name="frm_formCDN<?php echo $NumWindow; ?>" class="form-horizontal container" id="frm_formCDN<?php echo $NumWindow; ?>" style="margin-top: 15px;">
  <!-- concept code search-->
    <div  >
        <div class="col-md-12 " style="margin-top: 10px;">
            <div class="col-md-3" >
                <div class="input-group">
                    <input type="text" class="form-control" id="text_CdnBuscador" name="text_CdnBuscador" placeholder="Codigo">
                    <span class="input-group-btn">
                        <button class="btn btn-success BtnBuscador_<?php echo $NumWindow; ?>" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC"  onclick="javascript:CargarSearch('Ingreso', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');">
                            <i class="fas fa-search"></i>
                        </button>
                    </span>
                </div>
            </div>
            <div class="col-md-9" style="margin-left: -30px">
                <input type="text"  id="text_CdnBuscadorR" name="text_CdnBuscadorR" class="form-control" disabled >
            </div> 
        </div>
    </div>

  <!--bookkeeping account finder-->
    <div class="col-md-12" style="margin-top: 15px;">
        <div class="col-md-3">
            <div class="input-group">
                <span class="input-group-btn">
                    <button class="btn btn-success BtnAgregar_<?php echo $NumWindow; ?>" type="button">
                        <i class="fas fa-plus"> Agregar</i>
                    </button>
                </span>
                <input type="text" class="form-control" id="text_CdnCuentasC" name="text_CdnCuentasC" placeholder="Cuenta Contable">
                <span class="input-group-btn">
                    <button class="btn btn-success BtnBuscador_<?php echo $NumWindow; ?>" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC"  onclick="javascript:CargarSearch('Ingreso', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');">
                      <i class="fas fa-search"></i>
                    </button>
                </span>
            </div>
        </div>
        <div class="col-md-9" style="margin-left: -30px">
            <div class="input-group">
                <input type="text"  id="text_CdnCuentasCR" name="text_CdnCuentasCR" class="form-control" disabled >
                <span class="input-group-btn">
                    <button class="btn btn-success BtnAgregar_<?php echo $NumWindow; ?>" type="button">
                        <i class="fas fa-plus"> Agregar</i>
                    </button>
                </span>
            </div>
        </div>    
    </div>

  <!--Notes Concept Table-->
    <div class="col-md-12" style="margin-top: 15px;">
        <div id="zero_detallezWind_2" class="detalleord table-responsive" >
            <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle" id="tblDetallezWind_2" >
                <thead>
                    <tr>
                        <th id="th1zWind_2">Cod. concepto</th>
                        <th id="th1zWind_2">Nombre concepto</th>
                        <th id="th1zWind_2"> Cod. Cuenta Contable</th>
                        <th id="th1zWind_2">Cuenta Contable</th>
                    </tr>
                </thead>
                <tbody id="tbDetallezWind_2"></tbody>
            </table>
            <input name="hdn_controwzWind_2" type="hidden" id="hdn_controwzWind_2" value="0">
        </div>
    </div>

</form>
<script>
	  
    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>