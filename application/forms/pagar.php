<?php
	session_start();
  $NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	include '../../functions/php/nexus/operaciones.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
  
?>
<div class="container">
  <form action="" method="" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>">
	<label class="label label-default">Cuentas por Pagar</label>
  <div class="row well well-sm">

<div class="col-md-12">
<div id="zero_detalle<?php echo $NumWindow; ?>" class="table-responsive " style="height:35%">
        <table  width="100%" cellpadding="1" cellspacing="2"  class="table table-striped table-condensed  table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
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
            <th id="th2<?php echo $NumWindow; ?>">Fecha Pago</th> 
            <th id="th2<?php echo $NumWindow; ?>">Banco</th> 
            <th id="th2<?php echo $NumWindow; ?>">Valor Pago</th> 
        </tr> 
        <tbody id="tbDetalle<?php echo $NumWindow; ?>">
<?php
    $SQL="Select Codigo_CXP, ID_TER, Nombre_TER, Consec_FAC, date(Fecha_FAC), date(Vence_FAC), Referencia_CXP, Valor_FAC, Pagado_CXP, Saldo_CXP From czterceros a, czcxp b Where Codigo_CXP='".$_GET["cxp"]."' and a.Codigo_TER=b.Codigo_TER and Saldo_CXP>0 Order By Codigo_CXP desc";
    $result = mysqli_query($conexion, $SQL);
    while($row = mysqli_fetch_array($result)) {
?>
        <tr id="trh<?php echo $NumWindow; ?>"> 
            <td ><input name="Codigo_CXP<?php echo $NumWindow; ?>" type="hidden" id="Codigo_CXP<?php echo $NumWindow; ?>" value="<?php echo $row[0]; ?>" /><?php echo $row[0]; ?></td> 
            <td ><?php echo $row[1]; ?></td> 
            <td ><?php echo $row[2]; ?></td> 
            <td ><?php echo $row[3]; ?></td> 
            <td ><?php echo $row[4]; ?></td> 
            <td ><?php echo $row[5]; ?></td> 
            <td ><?php echo $row[6]; ?></td> 
            <td style="text-align:right;"><?php echo '$'.number_format($row[7],2,'.',','); ?></td> 
            <td style="text-align:right;"><?php echo '$'.number_format($row[8],2,'.',','); ?></td> 
            <td style="text-align:right;"><?php echo '$'.number_format($row[9],2,'.',','); ?></td> 
            <td ><input  name="Fecha_CXP<?php echo $NumWindow; ?>" id="Fecha_CXP<?php echo $NumWindow; ?>" type="date" required  /></td> 
            <td><select name="Codigo_CCT<?php echo $NumWindow; ?>" id="Codigo_CCT<?php echo $NumWindow; ?>">
    <?php 
  $SQL="Select Codigo_BCO, concat(Nombre_BCO,' ', CuentaNo_BCO, ' ', TipoCta_BCO) from czbancos a Order By 2";
  $resultx = mysqli_query($conexion, $SQL);
  while($rowx = mysqli_fetch_array($resultx)) 
    {
   ?>
    <option value="<?php echo $rowx[0]; ?>"><?php echo ($rowx[1]); ?></option>
  <?php
    }
  mysqli_free_result($resultx); 
   ?>  
    </select>
            </td>
            <td ><input  name="Valor_CXP<?php echo $NumWindow; ?>" id="Valor_CXP<?php echo $NumWindow; ?>" type="number" max="<?php echo $row[9]; ?>" value="<?php echo $row[9]; ?>" required  /></td> 
        </tr> 
<?php
    }
    mysqli_free_result($result); 
?>
        </tbody>
        </table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="0" />
        <button id="btn_save<?php echo $NumWindow; ?>"  name="btn_save<?php echo $NumWindow; ?>" type="button" class="btn btn-xs btn-block btn-success" onclick="javascript:payCxP<?php echo $NumWindow; ?>('<?php echo $NumWindow; ?>');"><span class="glyphicon glyphicon-credit-card" aria-hidden="true"></span> Realizar Pago</button>
</div>

    </div>
</div>
</form>

</div>
<script>
    FechaActual('Fecha_CXP<?php echo $NumWindow; ?>');
    function payCxP<?php echo $NumWindow; ?>(Ventana) {
        xError="";
        NomGuardar="btn_save"+Ventana;
        document.getElementById(NomGuardar).style.display  = 'none';
        
        //Se verifica la validez de los campos...
        if (document.getElementById('Valor_CXP'+Ventana).value=="0") {
            xError="El valor a pagar debe ser mayor que cero (0)";}                
                                    
        //Ejecucion de las intrucciones para guardar los registros
        if (xError=="") {
            $.ajax({  
            type: "POST",  
            url: Transact + "pagar.php",  
            data: "Func=pagar&"+RecorrerForm2($("#frm_form"+Ventana)),  
            success: function(respuesta) { 
                    document.getElementById(NomGuardar).style.display  = 'block';
                    MsgBox1("Pagos", respuesta); 
                
                }  
            });  
            return false;  
        } else {
            MsgBox1("Error", xError);
            document.getElementById(NomGuardar).style.display  = 'block';
        }

    }
    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
    $("textarea").addClass("form-control");
    $("select").addClass("form-control");
    $("input[type=date]").addClass("form-control");
    $("input[type=number]").addClass("form-control");
    $("input[type=time]").addClass("form-control");
</script>
