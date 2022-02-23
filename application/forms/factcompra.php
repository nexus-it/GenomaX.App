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
  <div class="row well well-sm">
  <div class="col-md-12">

<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
    <label for="txt_concepto<?php echo $NumWindow; ?>">Concepto</label>
    <div class="input-group">
        <input  name="txt_concepto<?php echo $NumWindow; ?>" id="txt_concepto<?php echo $NumWindow; ?>" type="text"  class="form-control" list="konceptos<?php echo $NumWindow; ?>" />
        <span class="input-group-btn">	
            <button class="btn btn-success" type="button" onclick="javascript:addKoncept<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i></button>
        </span>
    </div>
</div>

    </div>
    <div class="col-md-12">
    <label>Detalle</label>
<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style="height:50%">
        <table  width="99%" cellpadding="1" cellspacing="2"  class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
        <tr id="trh<?php echo $NumWindow; ?>"> 
            <th id="th1<?php echo $NumWindow; ?>">Codigo</th> 
            <th id="th2<?php echo $NumWindow; ?>">Concepto</th> 
            <th id="th2<?php echo $NumWindow; ?>">Precio</th> 
            <th id="th2<?php echo $NumWindow; ?>">Impuesto</th> 
            <th id="th2<?php echo $NumWindow; ?>">Cantidad</th> 
            <th id="th2<?php echo $NumWindow; ?>">Observaciones</th> 
            <th id="th2<?php echo $NumWindow; ?>">Total</th> 
        </tr> 
        <tbody id="tbDetalle<?php echo $NumWindow; ?>">

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
    
    </div>
    <datalist id="konceptos<?php echo $NumWindow; ?>">
<?php
$SQL="SELECT concat(Codigo_CTA, ' ', Nombre_CTA) from czcuentascont where Codigo_NVL=5  order by 1 ;";
$rstpuc = mysqli_query($conexion, $SQL);
while($rowPUC = mysqli_fetch_array($rstpuc)) {
	echo '<option value="'.$rowPUC[0].'">';
}
mysqli_free_result($rstpuc);
?>
    </datalist>
</form>

<script >
    document.frm_form<?php echo $NumWindow; ?>.Codigo_TER<?php echo $NumWindow; ?>.focus();

function addKoncept<?php echo $NumWindow; ?>(){
    var Koncepto=document.getElementById("txt_concepto<?php echo $NumWindow; ?>").value;
    if (Koncepto.trim()!="") {
        var TotalFilas=document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value;
        var miTabla = document.getElementById("tbDetalle<?php echo $NumWindow; ?>"); 
        var fila = document.createElement("tr");
        Kuenta=Koncepto.split(' ');
        KuentaX='';
        for (var i=1; i < Kuenta.length; i++) {
            KuentaX=KuentaX+Kuenta[i]+' ';
        }
        KuentaX=KuentaX.trim();
        TotalFilas++;
        Komillas="\'";
        fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
        <?php
        $SQL="Select Codigo_IVA, Nombre_IVA from czimpuestos Order By Porcentaje_IVA";
        $result = mysqli_query($conexion, $SQL);
        $Optinex='';
        while($row = mysqli_fetch_array($result)) {
            $Optinex=$Optinex.'<option value="'.$row[0].'">'.$row[1].'</option>';
        }
        mysqli_free_result($result);
        ?>
        var optionex = '<?php echo $Optinex; ?>';
        var celda1 = document.createElement("td");
        var celda2 = document.createElement("td");
        var celda3 = document.createElement("td");
        var celda4 = document.createElement("td");
        var celda5 = document.createElement("td");
        var celda6 = document.createElement("td");
        var celda7 = document.createElement("td");
        celda1.innerHTML = '<input type="text" name="Codigo_CTA'+TotalFilas+'<?php echo $NumWindow; ?>" id="Codigo_CTA'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Kuenta[0]+'" style="border-width: 0px; background-color: transparent; font-size: 11px; text-transform: none;" class="form-control input-sm" >';
        celda2.innerHTML = '<input type="text" name="Nombre_CTA'+TotalFilas+'<?php echo $NumWindow; ?>" id="Nombre_CTA'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+KuentaX+'" style="border-width: 0px; background-color: transparent; font-size: 11px; text-transform: none;" class="form-control input-sm" >';
        celda3.innerHTML = '<input onkeyup="TotalKoncept<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" onchange="TotalKoncept<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="number" name="Precio_FAC'+TotalFilas+'<?php echo $NumWindow; ?>" id="Precio_FAC'+TotalFilas+'<?php echo $NumWindow; ?>" value="" style="border-width: 0px; background-color: transparent; font-size: 11px; text-transform: none; text-align: right;" class="form-control input-sm" >';
        celda4.innerHTML = '<select onchange="TotalKoncept<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" name="Codigo_IVA'+TotalFilas+'<?php echo $NumWindow; ?>" id="Codigo_IVA'+TotalFilas+'<?php echo $NumWindow; ?>" value="" style="border-width: 0px; background-color: transparent; font-size: 11px; text-transform: none;" class="form-control input-sm" ><?php echo $Optinex; ?></select>';
        celda5.innerHTML = '<input onkeyup="TotalKoncept<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" onchange="TotalKoncept<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="number" name="Cantidad_FAC'+TotalFilas+'<?php echo $NumWindow; ?>" id="Cantidad_FAC'+TotalFilas+'<?php echo $NumWindow; ?>" value="1" style="border-width: 0px; background-color: transparent; font-size: 11px; text-transform: none; text-align: right;" class="form-control input-sm" >';
        celda6.innerHTML = '<input type="text" name="Nota_FAC'+TotalFilas+'<?php echo $NumWindow; ?>" id="Nota_FAC'+TotalFilas+'<?php echo $NumWindow; ?>" value="" style="border-width: 0px; background-color: transparent; font-size: 11px; text-transform: none;" class="form-control input-sm" >';
        celda7.innerHTML = '<input type="number" name="Total_FAC'+TotalFilas+'<?php echo $NumWindow; ?>" id="Total_FAC'+TotalFilas+'<?php echo $NumWindow; ?>" value="" style="border-width: 0px; background-color: transparent; font-size: 11px; text-transform: none; text-align: right;" class="form-control input-sm" >';
        fila.appendChild(celda1);
        fila.appendChild(celda2);
        fila.appendChild(celda3);
        fila.appendChild(celda4);
        fila.appendChild(celda5);
        fila.appendChild(celda6);
        fila.appendChild(celda7);

        miTabla.appendChild(fila);
        document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value=TotalFilas;
        document.getElementById("txt_concepto<?php echo $NumWindow; ?>").value="";

    } else {
        MsgBox1("Agregar Concepto", "Debe diligenciar el concepto a agregar");
    }
}

function TotalKoncept<?php echo $NumWindow; ?>(Fila) {
    precio=Number(document.getElementById("Precio_FAC"+Fila+"<?php echo $NumWindow; ?>").value);
    ivacode=document.getElementById("Codigo_IVA"+Fila+"<?php echo $NumWindow; ?>").value;
    cantidad=Number(document.getElementById("Cantidad_FAC"+Fila+"<?php echo $NumWindow; ?>").value);
    switch (ivacode) {
        <?php
        $SQL="Select Codigo_IVA, Porcentaje_IVA from czimpuestos Order By Porcentaje_IVA";
        $result = mysqli_query($conexion, $SQL);
        while($row = mysqli_fetch_array($result)) {
            echo 'case "'.$row[0].'":
            iva=Number("'.$row[1].'");
        break;
        ';
        }
        mysqli_free_result($result);
        ?>
    }
    total=(precio + (precio*iva/100)) *cantidad;
    document.getElementById("Total_FAC"+Fila+"<?php echo $NumWindow; ?>").value=total;
}

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
