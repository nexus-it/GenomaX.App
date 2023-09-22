
    <?php
	
	session_start();
		$NumWindow=$_GET["target"];
		// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
		include '../../functions/php/nexus/database.php';	
		$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
		mysqli_query ($conexion, "SET NAMES 'utf8'");	
		$contarow=0;
	?>
	
	<form action="" method="post" name="frm_formRG<?php echo $NumWindow; ?>" class="form-horizontal container" id="frm_formRG<?php echo $NumWindow; ?>" style="margin-top: 15px;">
  <!-- Buscador-->
  <div class="col-md-12" style="margin-top: 15px;">
    <div class="col-md-3">
        <div class="input-group">
            <input type="text" class="form-control" id="text_RgBuscador" name="text_RgBuscador" placeholder="No. de Glosa">
        <span class="input-group-btn">
            <button class="btn btn-success BtnBuscador_<?php echo $NumWindow; ?>" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC"  onclick="javascript:CargarSearch('Ingreso', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');">
              <i class="fas fa-search"></i>
            </button>
        </span>

        </div>
    </div>
    <div class="col-md-4" style="margin-left: -30px">
        <input type="text"  id="text_RgBuscadorR" name="text_RgBuscadorR" class="form-control" disabled >
    </div>    
</div>

  <!--Informacion de Glosa-->
  <div class="row well well-sm">
    <div class="col-md-12 ">
        <div class="col-md-3">
            <label for="">Factura</label>
            <input type="text"  id="text_RgIGfactura" name="text_RgIGfactura" class="form-control" disabled>
        </div>
        <div class="col-md-3">
            <label for="">Estado</label>
            <input type="text" id="text_RgIGsestado" name="text_RgIGsestado" class="form-control" disabled>
        </div>
        <div class="col-md-3">
            <label for="">Fecha de Factura</label>
            <input type="date" id="text_RgIGffactura" name="text_RgIGffactura" class="form-control" disabled>
        </div>
        <div class="col-md-3">
            <label for="">Fecha de Glosa</label>
            <input type="date" id="text_RgIGfglosa" name="text_RgIGfglosa" class="form-control" disabled>
        </div>
    </div>
    <div class="col-md-12 ">
        <div class="col-md-3">
            <label for="">Tercero</label>
            <input type="text" id="text_RgIGtercero" name="text_RgIGtercero" class="form-control" disabled>
        </div>
        <div class="col-md-3">
            <label for="">Plan de Beneficio</label>
            <input type="text" id="text_RgIGpbeneficio" name="text_RgIGpbeneficio" class="form-control" disabled>
        </div>
        <div class="col-md-3">
            <label for="">Contrato</label>
            <input type="text" id="text_RgIGcontrato" name="text_RgIGcontrato" class="form-control" disabled>
        </div>
        <div class="col-md-3">
            <label for="">Referencia</label>
            <input type="text" id="text_RgIGreferencia" name="text_RgIGreferencia" class="form-control" disabled>
        </div>
    </div>
    <div class="col-md-12 ">
        <div class="col-md-3">
            <label for="">Valor Factura</label>
            <input type="text" id="text_RgIGvfactura" name="text_RgIGfactura" class="form-control" disabled>
        </div>
        <div class="col-md-3">
            <label for="">Valor Glosa</label>
            <input type="text"  id="text_RgIGvglosa" name="text_RgIGvglosa"class="form-control" disabled>
        </div>
        <div class="col-md-3">
            <label for="">Saldo Factura</label>
            <input type="text" id="text_RgIGsfactura" name="text_RgIGsfactura" class="form-control" disabled>
        </div>
    </div>
  </div>

  <!--Conceptos de Recepcion de Glosas-->
  <div class="row well well-sm">
    <div id="zero_detallezWind_2" class="detalleord table-responsive">
        <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle" id="tblDetallezWind_2">
            <thead>
                <tr>
                  <th id="th1zWind_2">Codigo concepto</th>
                  <th id="th1zWind_2">Nombre concepto</th>
                  <th id="th1zWind_2">Servicio</th>
                  <th id="th1zWind_2">Valor Glosa</th>
                  <th id="th1zWind_2">Observaciones</th>
                </tr>
            </thead>
            <tbody id="tbDetallezWind_2">
                
            </tbody>
        </table>
        <input name="hdn_controwzWind_2" type="hidden" id="hdn_controwzWind_2" value="0">
    </div>
    </div>
  </div>
  
  <!--Respuesta de Glosa-->
  <div class="row well well-sm">
    <!--Concepto-->
    <div class="col-md-12">
        <div class="col-md-3">
            <div class="input-group">
                <input type="text" id="text_RgRGconcepto" name="text_RgRGconcepto" class="form-control" placeholder="Concepto">
            <span class="input-group-btn">
                <button class="btn btn-success RgRGBtnconcepto_<?php echo $NumWindow; ?>" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC"  onclick="javascript:CargarSearch('Ingreso', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');">
                  <i class="fas fa-search"></i>
                </button>
            </span>

            </div>
        </div>
        <div class="col-md-4" style="margin-left: -30px">
            <input type="text" id="text_RgRGconceptoR" name="text_RgRGconceptoR"  class="form-control" disabled >
        </div>    
    </div>
    <!--Valor Aceptado-->
    <div class="col-md-12">
        <div class="col-md-2">
            <input type="number" id="text_RgRGvaceptado" name="text_RgRGvaceptado"  class="form-control" placeholder="Valor Aceptado" >
        </div>
    </div>
    <!--Tercero-->
    <div class="col-md-12">
        <div class="col-md-3">
            <div class="input-group">
                <input type="text" id="text_RgRGtercero" name="text_RgRGtercero"  class="form-control" placeholder="Tercero">
            <span class="input-group-btn">
                <button class="btn btn-success hcx_<?php echo $NumWindow; ?>" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC"  onclick="javascript:CargarSearch('Ingreso', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');">
                  <i class="fas fa-search"></i>
                </button>
            </span>

            </div>
        </div>
        <div class="col-md-4" style="margin-left: -30px">
            <input type="text" id="text_RgRGterceroR" name="text_RgRGterceroR"  class="form-control" disabled >
        </div>    
    </div>
    <!--Observaciones-->
    <div class="col-md-12">
        <div class="col-md-12">
            <textarea id="text_RgRGobservaciones" name="text_RgRGobservaciones" rows="3" class="form-control" placeholder="Observaciones"></textarea>
        </div>
    </div>
  </div>
 
</form>
	

<script >

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
