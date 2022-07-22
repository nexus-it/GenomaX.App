<?php
	
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>

<form action="" method="post" name="frm_formCDNA<?php echo $NumWindow; ?>" class="form-horizontal container" id="frm_formCDNA<?php echo $NumWindow; ?>" style="margin-top: 15px;">
  <!-- concept code search-->
    <div  >
        <div class="col-md-12 " style="margin-top: 10px;">
            <div class="col-md-2" >
                <label for="">Codigo</label>
                <input type="text"  id="text_CDNAcodigo" name="text_CDNAcodigo" class="form-control"  >
            </div>
            <div class="col-md-2"  style="margin-left: -23px">
                <label for="">Cod.Generales</label>
                <select id="text_CDNAcG" name="text_CDNAcG"  class="form-control" >
                    <option value="">Codigo 1</option>
                    <option value="">Codigo 2</option>
                    <option value="">Codigo 3</option>
                </select>
            </div> 
            <div class="col-md-2" style="margin-left: -23px">
                <label for="">Cod.Especificos</label>
                <select id="text_CDNAcE"  name="text_CDNAcE" class="form-control" >
                    <option value="">Codigo 1</option>
                    <option value="">Codigo 2</option>
                    <option value="">Codigo 3</option>
                </select>
            </div> 
            
            <div class="col-md-6" style="margin-left: -23px" >
                <label for="">Nombre</label>
                <div class="input-group">
                <input type="text"  id="text_CDNAcodigoNombre" name="text_CDNAcodigoNombre" class="form-control"  >
                <span class="input-group-btn">
                    <button class="btn btn-success BtnAgregar_<?php echo $NumWindow; ?>" type="button">
                        <i class="fas fa-plus"> Agregar</i>
                    </button>
                </span>

                </div> 
            </div>
        </div>
    </div>

  <!--Notes Concept Table-->
    <div class="col-md-12" style="margin-top: 15px;">
        <div id="zero_detallezWind_2" class="detalleord table-responsive" >
            <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle" id="tblDetallezWind_2" >
                <thead>
                    <tr>
                        <th id="th1zWind_2" style="width:20%">Cod. concepto</th>
                        <th id="th1zWind_2" style="width:20%"> Cod. Generales</th>
                        <th id="th1zWind_2" style="width:20%">Cod.Especificos</th>
                        <th id="th1zWind_2" style="width:40%">Nombre concepto</th>
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