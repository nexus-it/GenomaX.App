<body>


<?php 

session_start();
include 'Invoice.php';
$invoice = new Invoice();
//$invoice->checkLoggedIn();

?>

<script src="functions/js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container">		
<h2 class="title">Sistema de Facturacion - Listado de facturas</h2>
<?php include('menu.php');?>			  
<table id="data-table" class="table table-condensed table-striped">
<thead>
  <tr>
  <th width="2%">Prefijo</th>
    <th width="5%">Fac. No.</th>
    <th width="15%">Fecha Creación</th>
    <th width="35%">Cliente</th>
    <th width="15%">Fatura Total</th>
    <th width="3%"></th>
    <th width="3%"></th>
    <th width="3%"></th>
  </tr>
</thead>
<?php		
$invoiceList = $invoice->getInvoiceList();
foreach($invoiceList as $invoiceDetails){
    $invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceDetails["order_date"]));
    echo '
      <tr>
        <td>'.$invoiceDetails["order_prefix"].'</td>
        <td>'.$invoiceDetails["order_id"].'</td>
        <td>'.$invoiceDate.'</td>
        <td>'.$invoiceDetails["order_receiver_name"].'</td>
        <td>'.$invoiceDetails["order_total_after_tax"].'</td>     
        <td><a href="print_invoice.php?invoice_id='.$invoiceDetails["order_prefix"].$invoiceDetails["order_id"].'" title="Vista previa Factura"><div class="btn btn-primary"><span class="glyphicon glyphicon-print"></span></div></a></td>
        <td><a href="invoicelist/editInvoice/'.$invoiceDetails["order_prefix"].$invoiceDetails["order_id"].'" title="Editar Factura"><div class="btn btn-primary"><span class="glyphicon glyphicon-edit"></span></div></a></td>
        <td><a href="https://backend.estrateg.com/API/storage/app/public/901487514/FES-'.$invoiceDetails["order_prefix"].$invoiceDetails["order_id"].'.pdf" title="Imprimir Factura Electronica"><div class="btn btn-success"><span class="glyphicon glyphicon-print"></span></div></a></td>
        <td><a href="#" id="'.$invoiceDetails["order_id"].'" class="deleteInvoice"  title="Borrar Factura"><div class="btn btn-danger"><span class="glyphicon glyphicon-remove"></span></div></a></td>
      </tr>
    ';
}       
?>
</table>	
</div>	

    <?php //require 'views/footer.php' ?>
</body>
</html>