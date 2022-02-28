<?php
	session_start();
  $NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	include '../../functions/php/nexus/operaciones.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
  
?>
<div class="container">
  <form action="" method="" name="frm_form<?php echo $NumWindow; ?>">
	<label class="label label-default">Cuentas por Pagar</label>
  <div class="row well well-sm">

<div class="col-md-12">
<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style="height:35%">
        <table  width="99%" cellpadding="1" cellspacing="2"  class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
        <tr id="trh<?php echo $NumWindow; ?>"> 
            <th id="th1<?php echo $NumWindow; ?>">#</th> 
            <th id="th1<?php echo $NumWindow; ?>">Tercero</th> 
            <th id="th1<?php echo $NumWindow; ?>">Proveedor</th> 
            <th id="th2<?php echo $NumWindow; ?>">Documento</th> 
            <th id="th2<?php echo $NumWindow; ?>">Fecha</th> 
            <th id="th2<?php echo $NumWindow; ?>">Vence</th> 
            <th id="th2<?php echo $NumWindow; ?>">Observaciones</th> 
            <th id="th2<?php echo $NumWindow; ?>">Valor</th> 
            <th id="th2<?php echo $NumWindow; ?>">Pagado</th> 
            <th id="th2<?php echo $NumWindow; ?>">Saldo</th> 
            <th id="th2<?php echo $NumWindow; ?>">Opciones</th> 
        </tr> 
        <tbody id="tbDetalle<?php echo $NumWindow; ?>">
<?php
    $SQL="Select Codigo_CXP, ID_TER, Nombre_TER, Consec_FAC, Fecha_FAC, Vence_FAC, Referencia_CXP, Valor_FAC, Pagado_CXP, Saldo_CXP From czterceros a, czcxp b Where a.Codigo_TER=b.Codigo_TER and Saldo_CXP>0 Order By Codigo_CXP desc";
    $result = mysqli_query($conexion, $SQL);
    while($row = mysqli_fetch_array($result)) {
?>
        <tr id="trh<?php echo $NumWindow; ?>"> 
            <td ><?php echo $row[0]; ?></td> 
            <td ><?php echo $row[1]; ?></td> 
            <td ><?php echo $row[2]; ?></td> 
            <td ><?php echo $row[3]; ?></td> 
            <td ><?php echo $row[4]; ?></td> 
            <td ><?php echo $row[5]; ?></td> 
            <td ><?php echo $row[6]; ?></td> 
            <td style="text-align:right;"><?php echo '$ '.number_format($row[7],2,'.',','); ?></td> 
            <td style="text-align:right;"><?php echo '$ '.number_format($row[8],2,'.',','); ?></td> 
            <td style="text-align:right;"><?php echo '$ '.number_format($row[9],2,'.',','); ?></td> 
            <td ><button type="button" class="btn btn-xs btn-block btn-primary" data-toggle="modal" data-target="#GnmX_WinModal" onclick="javascript:payCxP<?php echo $NumWindow; ?>('<?php echo $row[0]; ?>');"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> Pagar</button></td> 
        </tr> 
<?php
    }
    mysqli_free_result($result); 
?>
        </tbody>
        </table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="0" />
</div>

    </div>
</div>
</form>

</div>
<script>
    function payCxP<?php echo $NumWindow; ?>(cxp) {
        CargarWind('CxP '+cxp, 'forms/pagar.php?cxp='+cxp, 'reseller_account_template.png', 'cuentasxpagar.php','<?php echo $NumWindow; ?>' );
    }
</script>
