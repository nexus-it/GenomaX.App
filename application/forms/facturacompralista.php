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
	<label class="label label-default">Listado de facturas</label>
  <div class="row well well-sm">

		<div class="col-md-2 ">
      <button class="btn btn-success" title="Ingresar nueva factura" type="button" onclick="javascript: CargarForm('application/forms/factcompra.php', 'Facturacion de Compra', 'invoice.png');" >Nueva Factura de Compra <i class="fa fa-plus"></i> </button>
		</div>
</form>
<?php
echo '<table class="table table-striped table-condensed tblDetalle table-bordered">'; 
			// $conteo = listarFacturasCompra($filtro,$ini,$fin);
echo '</table>';

//contarFacts($filtro,$page, $showRows);
?>
</div>
</div>
<script>

</script>
