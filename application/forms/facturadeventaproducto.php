
<body>
    

    <?php 

session_start();

include 'Invoice.php';
include '../../functions/php/FacturaElectronicaEstandarBackend/api.php';
$invoice = new Invoice();
//$invoice->checkLoggedIn();

$verficarEmpresaReg = $invoice->verficarEmpresaReg();
$datosEmp = validarRegistroEmp($verficarEmpresaReg["NIT_DCD"]);

?>

<title>Tecnowebs : Sistema de Facturacion</title>
<script src="functions/js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php');?>
<div class="container">		
<h2 class="title">Sistema de Facturacion - Productos</h2>
<?php include('menu.php');?>


<body>
<div id="mainWrapper">
  
  <div id="content">
  
	
<section class="artworks">
	<div class="productRow">
<div class="table-responsive">
			
			
			<table class='table-responsive table-bordered table-striped table-hover' align="center">
				<tr>
					<td colspan="6"><br><br><a class="btn btn-success" data-toggle="modal" data-target="#nuevoProducto" title="Crear Productos"><span class="glyphicon glyphicon-download-alt"></span></a><br><br></td>
				</tr>
				<tr>
					<td><h4>Id</h4></td><td><h4>Referencia</h4></td><td><h4>Nombre</h4></td><td><h4><span class="glyphicon glyphicon-wrench"></h4></span></td>
				</tr>			
<?php
			
			$productList = $invoice->getProductList();
            foreach($productList as $productDetails){	
					echo "<tr>";
					echo "<td>".$productDetails["id"]."</td>";	//
					echo "<td>".$productDetails["referencia"]."</td>";
					echo "<td>".$productDetails["nombre"]."</td>";
					echo"<td>";						
				    echo "<a data-toggle='modal' data-target='#editProducto' data-id='" .$productDetails["id"] ."' data-referencia='" .$productDetails["referencia"] ."' data-nombre='" .$productDetails["nombre"]  ."' class='btn btn-warning'><span class='glyphicon glyphicon-pencil'></span></a> ";			
					echo "<a href='#' id='".$productDetails["id"]."' class='deleteProduct'  title='Borrar Producto'><div class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span></div></a>";		
					echo "</td>";
					echo "</tr>";
			}
						
	

?>
	        </table>




		<div class="modal" id="nuevoProducto" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Nuevo Producto</h4>                       
                    </div>
                    <div class="modal-body">
                       <form action="insertar.php" method="GET">              		
                       		<div class="form-group">
                       			<label for="referencia">Referencia:</label>
                       			<input class="form-control" id="referencia" name="referencia" type="text" placeholder="referencia"></input>
                       		</div>
							<div class="form-group">
                       			<label for="nombre">Nombre:</label>
                       			<input class="form-control" id="nombre" name="nombre" type="text" placeholder="nombre"></input>
                       		</div>
							<input type="submit" class="btn btn-success" value="Salvar Producto" name="salvarproducto">
                       </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 

        <div class="modal" id="editProducto" tabindex="-1" role="dialog" aria-labellebdy="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4>Editar Producto</h4>
                    </div>
                    <div class="modal-body">                      
                       <form action="actualizar.php" method="POST">                       		
                       		        
                       		        <input  id="id" name="id" type="hidden" ></input>   		
		                       		
		                       		<div class="form-group">
		                       			<label for="referencia">Referencia:</label>
		                       			<input class="form-control" id="referencia" name="referencia" type="text"></input>
		                       		</div>
					                <div class="form-group">
										<label for="nombre">Nombre:</label>
										<input class="form-control" id="nombre" name="nombre" type="text" ></input>
									</div>
				
									<input type="submit" class="btn btn-success" name="actualizarproducto">							
                       </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-warning" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div> 



	</div>
	</div>
	</section>
	<script>			 
		  $('#editProducto').on('show.bs.modal', function (event) {
		  var button = $(event.relatedTarget) // Button that triggered the modal
		  var recipient0 = button.data('id')
		  var recipient1 = button.data('referencia')
		  var recipient2 = button.data('nombre')
		  
		   // Extract info from data-* attributes
		  // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
		  // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
		 
		  var modal = $(this)		 
		  modal.find('.modal-body #id').val(recipient0)
		  modal.find('.modal-body #referencia').val(recipient1)		  	
		  modal.find('.modal-body #nombre').val(recipient2)	
		});
		
	</script>
	 
	  
  </div>

</div>
</body>
</html>


   
</body>
</html>