<?php 
session_start();
	$NumWindow=$_GET["target"];
	include 'Invoice.php';

	//include '../../functions/php/nexus/database.php';
	//include '../../functions/php/nexus/operaciones.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
     
	
include '../../functions/php/FacturaElectronicaEstandarBackend/consultas.php';

$invoice = new Invoice();
/*
$invoice->checkLoggedIn();
*/
if(!empty($_POST['companyName']) && $_POST['companyName']) {	
	$invoice->saveInvoice($_POST);
	echo "<script>CargarForm('application/forms/facturadeventalista.php', 'Facturacion de Venta Lista', 'invoice.png');</script>"; 
	//header("Location:facturadeventalista.php");	
}

?>
<script src="themes/ghenx/js/loadform.js"></script>
<script src="functions/js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container content-invoice">
<form action="application/forms/facturadeventa.php" id="invoice-form" method="post" class="invoice-form" role="form" > <!--novalidate-->
<div class="load-animate animated fadeInUp">
<div class="row">
<div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
    <h2 class="title">Sistema de Facturacion - Crear Factura</h2>
    <?php include('menu.php');?>	
</div>		    		
</div>
<input id="currency" type="hidden" value="$">
<div class="row">
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
    <h3>De,</h3>
    <?php echo $_SESSION["NOMBRE_APP"]; ?><br>	
    <?php echo $_SESSION['address']; ?><br>	
    <?php echo $_SESSION['mobile']; ?><br>
    <?php echo $_SESSION['email']; ?><br>	
</div>      		
<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 pull-right">
    <h3>Para,</h3>
    <div class="form-group">
        <?php 
        $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
        mysqli_query ($conexion, "SET NAMES 'utf8'");
        $sql="SELECT Direccion_TER,concat(ID_TER,'-',IFNULL(DigitoVerif_TER,'') ) as nit ,  Nombre_TER FROM `czterceros` ";
        $result = mysqli_query($conexion, $sql);
        $DataX = '<datalist id="companyNamelist">';
        while($row = mysqli_fetch_array($result)) {
            $DataX=$DataX.'<option value="'.$row[1].' -- '.$row[2].'"></option>';
        }
        $DataX=$DataX.'</datalist>';
        echo $DataX;
        ?>
        <input required="true" type="text" class="form-control" name="companyName" id="companyName" placeholder="Nombre de Empresa" list="companyNamelist" required   >
    </div>
    <div class="form-group">
        <textarea class="form-control" rows="3" name="address" id="address" placeholder="Su dirección"></textarea>
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
                <?php 
                $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
                mysqli_query ($conexion, "SET NAMES 'utf8'");
                $sql="SELECT * FROM `factura_producto` ";
                $result = mysqli_query($conexion, $sql);
                $DataX = '<datalist id="productCode_1list">';
                while($row = mysqli_fetch_array($result)) {
                    $DataX=$DataX.'<option value="'.$row[1].' -- '.$row[2].'"></option>';
                }
                $DataX=$DataX.'</datalist>';
                echo $DataX;
                ?>
                <input type="text" name="productCode[]" id="productCode_1" size="30" class="form-control" placeholder="Ingrese codigo de producto" list="productCode_1list">
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
        <input data-loading-text="Guardando factura..." type="submit" name="invoice_btn" value="Guardar Factura" class="btn btn-success submit_btn invoice-save-btm">						
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

