<?php
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
  <div class="row">
    
    <div class="col-md-2 ">

<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
    <label for="Codigo_TER<?php echo $NumWindow; ?>">Proveedor</label>
    <div class="input-group">
        <input  name="Codigo_TER<?php echo $NumWindow; ?>" id="Codigo_TER<?php echo $NumWindow; ?>" type="text" required class="form-control" />
        <span class="input-group-btn">	
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Tercero" onclick="javascript:CargarSearch('Tercero', 'Codigo_TER<?php echo $NumWindow; ?>', 'Proveedor_TER=*1*');"><i class="fas fa-search"></i></button>
        </span>
    </div>
</div>

    </div>
    <div class="col-md-3">

<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
    <label for="Nombre_TER<?php echo $NumWindow; ?>">Nombre Tercero</label>
    <input  name="Nombre_TER<?php echo $NumWindow; ?>" id="Nombre_TER<?php echo $NumWindow; ?>" type="text" required disabled="disabled" />
</div>

    </div>
    <div class="col-md-1">

<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
    <label for="Consec_FAC<?php echo $NumWindow; ?>" title="Numero de Factura o Referencia">Documento</label>
    <input  name="Consec_FAC<?php echo $NumWindow; ?>" id="Consec_FAC<?php echo $NumWindow; ?>" type="text" required  />
</div>

    </div>
    <div class="col-md-2">

<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
    <label for="Fecha_FAC<?php echo $NumWindow; ?>" title="Fecha de Factura o Referencia">Fecha Doc.</label>
    <input  name="Fecha_FAC<?php echo $NumWindow; ?>" id="Fecha_FAC<?php echo $NumWindow; ?>" type="date" required  />
</div>

    </div>
    <div class="col-md-2">

<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
    <label for="Vence_FAC<?php echo $NumWindow; ?>" >Vencimiento</label>
    <input  name="Vence_FAC<?php echo $NumWindow; ?>" id="Vence_FAC<?php echo $NumWindow; ?>" type="date" required  />
</div>

    </div>
    <div class="col-md-2">

<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
    <label for="Codigo_CCT<?php echo $NumWindow; ?>" title="">Centro Costo</label>
    <select name="Codigo_CCT<?php echo $NumWindow; ?>" id="Codigo_CCT<?php echo $NumWindow; ?>">
    <?php 
  $SQL="Select Codigo_CCT, Nombre_CCT from czcentrocosto a Order By 2";
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
  </div>

    <div class="col-md-12">
    <label>Detalle</label>
<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style="height:50%">
        <table  width="99%" cellpadding="1" cellspacing="2"  class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
        <tbody id="tbDetalle<?php echo $NumWindow; ?>">
        <tr id="trh<?php echo $NumWindow; ?>"> 
            <th id="th1<?php echo $NumWindow; ?>">Servicio</th> 
            <th id="th2<?php echo $NumWindow; ?>">Val Unit.</th> 
            <th id="th2<?php echo $NumWindow; ?>">Cant. Factura</th> 
            <th id="th2<?php echo $NumWindow; ?>">Val Total</th> 
            <th id="th2<?php echo $NumWindow; ?>">Cant. NC</th> 
            <th id="th2<?php echo $NumWindow; ?>">Val Crédito</th> 
        </tr> 

        </tbody>
        </table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="0" />
</div>

    </div>
    <div class="col-md-3">

    <div class="row">
        <div class="col-md-12">
<div class="form-group">
    <label for="txt_valfact<?php echo $NumWindow; ?>">Valor Factura</label>
    <input style="font-size:14px; font-weight: bold; color:#828427; " name="txt_valfact<?php echo $NumWindow; ?>" id="txt_valfact<?php echo $NumWindow; ?>" type="number" min="1" class="izq form-control" disabled value="<?php echo $sumtotal; ?>"/>
</div>
        </div>
        <div class="col-md-12">
<div class="form-group">
    <label for="txt_valornc<?php echo $NumWindow; ?>">Valor Nota Credito</label>
    <input style="font-size:15px; font-weight: bold; color:#843232; " name="txt_valornc<?php echo $NumWindow; ?>" id="txt_valornc<?php echo $NumWindow; ?>" type="number" min="1" class="izq form-control" disabled value="0"/>
</div>
        </div>
        <div class="col-md-12">
<div class="form-group">
    <label for="txt_valfactnew<?php echo $NumWindow; ?>">Nuevo Valor Factura</label>
    <input style="font-size:14px; font-weight: bold; color:#0E5012; " name="txt_valfactnew<?php echo $NumWindow; ?>" id="txt_valfactnew<?php echo $NumWindow; ?>" type="number" min="1" class="izq form-control" disabled value="<?php echo $sumtotal; ?>"/>
</div>
        </div>
        <div class="col-md-12">
<div class="form-group">
    <label for="txt_observacion<?php echo $NumWindow; ?>">Observaciones</label>
    <textarea name="txt_observacion<?php echo $NumWindow; ?>" rows="2" id="txt_observacion<?php echo $NumWindow; ?>" required="required" ></textarea>
</div>
        </div>

</form>

<script >
    document.frm_form<?php echo $NumWindow; ?>.Codigo_TER<?php echo $NumWindow; ?>.focus();

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
