<?php

if(isset($_POST["filtro"])){
	$filtro = $_POST["filtro"];
	//echo $filtro;
}
 
	session_start();
  $NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	include '../../functions/php/nexus/operaciones.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
  $showRows=50;
  $page="1";
  if (isset($_GET["page"])) {
    $page = $_GET["page"];
  }
  $ini=(($page-1)*$showRows)+1;
  $fin=$page*$showRows;
?>

<div class="col-md-12">

	<?php if(isset($_POST["filtro"])==""){ ?><label class="label label-default">Listado de facturas</label><?php }?>
	  <div class="row well well-sm">

	        <div class="container">  
<button class="btn btn-success" title="Crear nueva cuenta evento " onclick="CargarForm('application/forms/facturasalud.php', 'Facturacion de Cuentas', 'resources.png'); ">Facturar Nueva Cuenta <i class="fa fa-file"></i></button>


			</div>
			<br>
	<div class="col-md-12">

<div class="form-group">

<?php


if($filtro == ""){
?>
<form method="POST" action="">
	<input type="text" name="filtro" id="filtro">
	<button type="button" name="filtrar" id="filtrar">Filtrar</button>
</form>
<div id="resultadofiltro"></div>
<?php
}
echo '<table class="table table-striped table-condensed tblDetalle table-bordered">'; 
		
			$conteo = listarFacturas($filtro,$ini,$fin);
		
echo '</table>';

contarFacts($page, $showRows);
?>

<script>

function filtrarFactura(filtro){
    $.ajax({
            type: 'POST',
            url: 'application/forms/facturasaludlista.php',
            data: {
                filtro: filtro

            },
            beforeSend: function()
             {
                
             },

              success: function (data) {
                
                $("#resultadofiltro").html(data)
				
              },
              error: function() { 
                console.log(data);
              }
            });

   }

$(document).ready(function() {
           $( "#filtrar" ).click(function() {
			  
			$('.items').html('<div class="loading"><img src="files/loading.gif" width="70px" height="70px"/><br/>Un momento por favor...</div>');
			 filtrarFactura($("#filtro<?php echo $NumWindow; ?>").val()
                            );
            });
			
      });

function editarFactura(filtro){
    $.ajax({
            type: 'GET',
            url: 'application/forms/facturaedit.php',
            data: {
                filtro: filtro

            },
            beforeSend: function()
             {
                
             },
              success: function (data) {
                $("#resultadofiltro").html(data)
              },
              error: function() { 
                console.log(data);
              }
            });
   }

$(document).ready(function() {
           $( "#editar" ).click(function() {
			editarFactura($("#factura<?php echo $NumWindow; ?>").val()
                            );
            });
      });

$(document).ready(function() {	
    $( ".enviarfactdian" ).click(function() {
      var ingreso = $(this).attr('data');
		  //alert(ingreso);
      $("#resultadoEnvioFactura").html("")
      putSendFactura(ingreso)
    });
});

$(document).ready(function() {	
    $( ".pagefact" ).click(function() {
      var newpage = $(this).attr('data');
		  AbrirForm('application/forms/facturasaludlista.php', '<?php echo $NumWindow; ?>', '&page='+newpage);
    });
});
function putSendFactura(factura){
    $.ajax({
            type: 'POST',
            url: 'functions/php/GenomaXBackend/putSendFactura.php',
            data: {
              factura: factura

            },
            beforeSend: function()
             {
                
             },

              success: function (data) {
                //alert(data);
                //$("#resultadoEnvioFactura").html(data)
                
                obj = JSON.parse(data);

                //obj['ResponseDian']['Envelope']['Body']['SendTestSetAsyncResponse']['SendTestSetAsyncResult']['ZipKey']
                $("#resultadoEnvioFactura").html(obj['cufe'])
                
               // estadoFactura(obj['ResponseDian']['Envelope']['Body']['SendTestSetAsyncResponse']['SendTestSetAsyncResult']['ZipKey']);
                
                //estadoFactura('4466cf19-40e3-440d-b6fd-3363769f4d07');
                //$("#resultadoEnvioFactura").html("Factura Enviada con exito")

                estadoFacturaDoc(obj['cufe'],factura)

              },
              error: function() { 
                console.log(data);
              }
            });
   }

   function estadoFactura(zipkey){
      $.ajax({
            type: 'POST',
            url: 'functions/php/GenomaXBackend/estadoFactura.php',
            data: {
              zipkey: zipkey

            },
            beforeSend: function()
             {
                
             },

              success: function (data) {
                
                $("#resultadoEnvioFactura1").html(data)
                
                //obj = JSON.parse(data);
                //$("#resultadoEnvioFactura").html(obj['ResponseDian']['Envelope']['Body']['SendTestSetAsyncResponse']['SendTestSetAsyncResult']['ZipKey'])
                //$("#resultadoEnvioFactura").html("Factura Enviada con exito")

              },
              error: function() { 
                console.log(data);
              }
            });
   }

   function estadoFacturaDoc(cufe,factura){
      $.ajax({
            type: 'POST',
            url: 'functions/php/GenomaXBackend/estadoFacturaDoc.php',
            data: {
              cufe: cufe,
              factura: factura

            },
            beforeSend: function()
             {
                
             },

              success: function (data) {
                
                //$("#resultadoEnvioFactura").html(data)
                
                obj = JSON.parse(data);
                //$("#resultadoEnvioFacturaEstado").html(obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['StatusMessage'])
                
                //alert(obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['IsValid']);
                if(obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['IsValid'] == 0){
                  $("#resultadoEnvioFacturaEstado").html(obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['ErrorMessage']['string'])
                }else{
                $("#resultadoEnvioFacturaEstado").html(obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['StatusMessage'])
                }

                //$("#resultadoEnvioFactura").html("Factura Enviada con exito")

              },
              error: function() { 
                console.log(data);
              }
            });
   }   

   $(document).ready(function() {	
    $( ".estadoFacturaDoc" ).click(function() {
      var cufe = $(this).attr('data-f');
      var factura = $(this).attr('data-c');
      
		  //alert(ingreso);
      //$("#resultadoEnvioFactura").html("")
      estadoFacturaDoc(factura,cufe)
    });
});
</script>
