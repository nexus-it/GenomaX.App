

<body>


<?php 
session_start();
include 'Invoice.php';
include '../../functions/php/FacturaElectronicaEstandarBackend/api2.php';
include '../../functions/php/FacturaElectronicaEstandarBackend/consultas.php';

$invoice = new Invoice();
//$invoice->checkLoggedIn();
if(!empty($_POST['companyName']) && $_POST['companyName']) {	
	$invoice->saveNd($_POST);
	header("Location:ndlist");	
}
	

/*
	$verficarEmpresaReg = $invoice->verficarEmpresaReg();
	//echo "empresa = ".$verficarEmpresaReg["NIT_DCD"];exit();
	if(isset($verficarEmpresaReg["NIT_DCD"])){
    $datosEmp = validarRegistroEmpRes($verficarEmpresaReg["NIT_DCD"]);
	}else{
		echo "<script>alert('No podras generar ND sin antes haber registrado tu empresa, seras redireccionado a el modulo de registro para completar los datos...');
		      window.location= 'client'
			  </script>";
		//header("Location: client");
	}

*/	
?>
<?php //require 'views/header.php'; ?>
<title>Sistema de Facturacion</title>

<script src="themes/ghenx/js/loadform.js"></script>
<script src="functions/js/invoice.js"></script>

<div class="container content-invoice">
<form action="application/forms/facturadeventaND.php" id="invoice-form" method="post" class="invoice-form" role="form" > <!--novalidate-->
<div class="load-animate animated fadeInUp">
<div class="row">
<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
    <h2 class="title">Sistema de Facturacion - Crear Nota Debito</h2>
</div>		    		
</div>
<input id="currency" type="hidden" value="$">
<div class="row">
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
    <h3>De,</h3>
    <?php echo $_SESSION['user']; ?><br>	
    <?php echo $_SESSION['address']; ?><br>	
    <?php echo $_SESSION['mobile']; ?><br>
    <?php echo $_SESSION['email']; ?><br>	
</div>      		
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
	<div class="form-group">
        <?php $facturaCode = llenarSelect("SELECT   order_receiver_address,concat(order_prefix,'',order_id) , order_receiver_name FROM `factura_orden` ", "php_factura_shaima");?>
		
        <script>
            $(document).on('click', "#facturasId", function(){
                    var listadofacturas = <?php echo $facturaCode; ?> 
                    $("#facturasId").autocomplete({
                    source: listadofacturas,
                    minLength: 1
                    }); 
            });
        </script>
        <input required="true" type="text" class="form-control" name="facturasId" id="facturasId" placeholder="Factura debitar" autocomplete="off" required   >
    </div>
    <h3>Para,</h3>
    <div class="form-group">
        <?php $clienteCode = llenarSelect("SELECT Direccion_TER,concat(ID_TER,'-',IFNULL(DigitoVerif_TER,'') ) as nit ,  Nombre_TER FROM `czterceros` ", "nxs_demo");?>
		
        <script>
            $(document).on('click', "#companyName", function(){
                    var listadocli = <?php echo $clienteCode; ?> 
                    $("#companyName").autocomplete({
                    source: listadocli,
                    minLength: 1
                    }); 
            });
			
			$(document).on('change', "#facturasId", function(){
			  	var cadena = $('#facturasId').val();
				cadena = cadena.split(' -- ')
				if(cadena[2]){
					$("#facturasId").val(cadena[0]);
					$("#companyName").val(cadena[1]+' -- '+cadena[2]);
					$("#address").val(cadena[3]);
				}
			  
			});
        </script>
        <input required="true" type="text" class="form-control" name="companyName" id="companyName" placeholder="Nombre de Empresa" autocomplete="off" required   >
    </div>
    <div class="form-group">
        <textarea class="form-control" rows="3" name="address" id="address" placeholder="Su dirección"></textarea>
    </div>

	<div class="form-group">
        				<label for="cars">Forma de pago:</label>

						<select name="payment_forms" id="payment_forms">
						  <option value="1">Contado</option>
						  <option value="2">Credito</option>
						</select>
							</div>
						<div class="form-group">
							<label for="cars">Tipo de pago:</label>

					<select name="payment_methods" id="payment_methods">
					  <option value="10">Efectivo</option>
					  <option value="20">Cheque</option>
					  <option value="30">Trasferencia</option>
					</select>
						</div>      

</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <table class="table table-bordered table-hover" id="invoiceItem">	
        <tr>
            <th width="2%"><input id="checkAll" class="formcontrol" type="checkbox"></th>
            <th width="10%">Prod. No</th>
            <th width="20%">Nombre Producto</th>
            <th width="10%">Cantidad</th>
            <th width="10%">Precio</th>	
            <th width="10%">Iva</th>
            <th width="10%">Desc</th>							
            <th width="10%">Total</th>
        </tr>							
        <tr>
            <td><input class="itemRow" type="checkbox"></td>
            <td>
                <?php $productCode = llenarSelect("SELECT * FROM `factura_producto` ", "php_factura_shaima");?>
                <script>
                    $(document).on('click', "[id^=productCode_]", function(){
                        var count = $(".itemRow").length;
                        var listado = <?php echo $productCode; ?> 
                        for(i=0;i<=count;i++){ 
                            $("#productCode_"+i+"").autocomplete({
                            source: listado,
                            minLength: 1
                            }); 
                                                       
                        }
                    });
                </script>
                <input type="text" name="productCode[]" id="productCode_1" size="30" class="form-control" placeholder="Ingrese codigo de producto">
            </td>
            <td><input type="text" name="productName[]" id="productName_1" class="form-control" autocomplete="off"></td>			
            <td><input type="number" name="quantity[]" id="quantity_1" class="form-control quantity" autocomplete="off"></td>
            <td><input type="number" name="price[]" id="price_1" class="form-control price" autocomplete="off"></td>
            <td><input type="number" name="iva[]" id="iva_1" class="form-control iva" autocomplete="off"></td>
            <td><input type="number" name="desc[]" id="inc_1" class="form-control desc" autocomplete="off"></td>
            <td><input type="number" name="total[]" id="total_1" class="form-control total" autocomplete="off"></td>
        </tr>						
    </table>
</div>
</div>
<div class="row">
<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
    <button class="btn btn-danger delete" id="removeRows" type="button">- Borrar</button>
    <button class="btn btn-success" id="addRows" type="button">+ Agregar Más</button>
</div>
</div>
<div class="row">	
<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
    <h3>Notas: </h3>
    <div class="form-group">
        <textarea class="form-control txt" rows="5" name="notes" id="notes" placeholder="Notas"></textarea>
    </div>
    <br>
    <div class="form-group">
        <input type="hidden" value="<?php echo $_SESSION["NOMBRE_APP"]; ?>" class="form-control" name="userId">
		<input type="hidden" value="<?php echo $datosEmp['prefijo']; ?>" class="form-control" name="prefijo">
		<input type="hidden" value="<?php echo $datosEmp['resolution']; ?>" class="form-control" name="resolucion">
        <input data-loading-text="Guardando ND..." type="submit" name="invoice_btn" value="Guardar ND" class="btn btn-success submit_btn invoice-save-btm">						
    </div>
    
</div>
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
    <span class="form-inline">
        <div class="form-group">
            <label>Subtotal: &nbsp;</label>
            <div class="input-group">
                <div class="input-group-addon currency">$</div>
                <input value="" type="number" class="form-control" name="subTotal" id="subTotal" placeholder="Subtotal">
            </div>
        </div>
        <input value="19" type="hidden" class="form-control" name="taxRate" id="taxRate" placeholder="Tasa de Impuestos">
        <!--
        <div class="form-group">
            <label>Tasa Impuesto: &nbsp;</label>
            <div class="input-group">
                <input value="" type="number" class="form-control" name="taxRate" id="taxRate" placeholder="Tasa de Impuestos">
                <div class="input-group-addon">%</div>
            </div>
        </div>
        -->
        
        <div class="form-group">
            <label>Monto Inpuesto: &nbsp;</label>
            <div class="input-group">
                <div class="input-group-addon currency">$</div>
                <input value="" type="number" class="form-control" name="taxAmount" id="taxAmount" placeholder="Monto de Impuesto">
            </div>
        </div>							
        <div class="form-group">
            <label>Total: &nbsp;</label>
            <div class="input-group">
                <div class="input-group-addon currency">$</div>
                <input value="" type="number" class="form-control" name="totalAftertax" id="totalAftertax" placeholder="Total">
            </div>
        </div>
        <div class="form-group">
            <label>Cantidad pagada: &nbsp;</label>
            <div class="input-group">
                <div class="input-group-addon currency">$</div>
                <input value="" type="number" class="form-control" name="amountPaid" id="amountPaid" placeholder="Cantidad pagada">
            </div>
        </div>
        <div class="form-group">
            <label>Cantidad debida: &nbsp;</label>
            <div class="input-group">
                <div class="input-group-addon currency">$</div>
                <input value="" type="number" class="form-control" name="amountDue" id="amountDue" placeholder="Cantidad debida">
            </div>
        </div>
    </span>
</div>
</div>
<div class="clearfix"></div>		      	
</div>
</form>			
</div>
</div>	

    <?php //require 'views/footer.php' ?>
