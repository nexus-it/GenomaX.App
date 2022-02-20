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
  <form action="" method="post" name="frm_form<?php echo $NumWindow; ?>">
	<label class="label label-default">Listado de facturas</label>
  <div class="row well well-sm">

		<div class="col-md-2 ">
      <button class="btn btn-success" title="Ingresar nueva factura"  onclick="javascript: CargarForm('application/forms/factcompra.php', 'Facturacion de Compra', 'invoice.png');" >Nueva Factura de Compra <i class="fa fa-plus"></i> </button>
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

function RefreshList<?php echo $NumWindow; ?>() {
  numfact=document.getElementById("txt_factura<?php echo $NumWindow; ?>").value;
  fechaini=document.getElementById("txt_fechaini<?php echo $NumWindow; ?>").value;
  fechafin=document.getElementById("txt_fechafin<?php echo $NumWindow; ?>").value;
  paciente=document.getElementById("txt_paciente<?php echo $NumWindow; ?>").value;
  contrato=document.getElementById("txt_contrato<?php echo $NumWindow; ?>").value;
  AbrirForm('application/forms/facturasaludlista.php', '<?php echo $NumWindow; ?>', '&page=1&numfact='+numfact+'&fechaini='+fechaini+'&fechafin='+fechafin+'&paciente='+paciente+'&contrato='+contrato);
}

function filtrarFactura(filtro){
    $.ajax({
        type: 'POST',
        url: 'application/forms/facturacompralista.php',
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
  filtrarFactura($("#filtro<?php echo $NumWindow; ?>").val());
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
editarFactura($("#factura<?php echo $NumWindow; ?>").val());
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
function showProgress(Sw, factura) {
  if (Sw=="1") {
   document.getElementById("prgFE"+factura).style.display="block";
   document.getElementById("btngrp"+factura).style.display="none";
  } else {
   document.getElementById("prgFE"+factura).style.display="none";
   document.getElementById("btngrp"+factura).style.display="inherit";
  }
  
}
function putSendFactura(factura){
  showProgress("1", factura)
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
            obj = JSON.parse(data);

            $("#resultadoEnvioFactura").html(obj['cufe'])

            estadoFacturaDoc(obj['cufe'],factura)
          },
          error: function() { 
            showProgress("0", factura)
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
          },
          error: function() { 
            console.log(data);
          }
        });
   }
   function NoCuFE(factura, msg) {
    showProgress("1", factura)
      $.ajax({
        type: 'POST',
        url: 'functions/php/GenomaXBackend/estadoFacturaDoc.php',
        data: {
          cufe: "0",
          factura: factura
        },
        beforeSend: function()
          {
            
          },
          success: function (data) {
            MsgBox1('Error en envío de Factura',msg);
          },
          error: function() { 
            console.log(data);
          }
        });
        showProgress("0", factura)
   }
   function estadoFacturaDoc(cufe,factura){
    showProgress("1", factura)
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
            obj = JSON.parse(data);
            showProgress("0", factura)
            //$("#resultadoEnvioFacturaEstado").html(obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['StatusMessage'])
            
            //alert(obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['IsValid']);
            if(obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['IsValid'] == 'false'){
              $("#resultadoEnvioFacturaEstado").html(obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['ErrorMessage']['string'])
              NoCuFE(factura,obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['StatusMessage']+'"<br> "'+obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['ErrorMessage']['string'])
            }else{
              if(obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['StatusMessage']=="Documento con errores en campos mandatorios") {
                NoCuFE(factura, obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['ErrorMessage']['string']);
              } else {
              $("#resultadoEnvioFacturaEstado").html(obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['StatusMessage'])
                MsgBox1('Envío de Factura correcto',obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['StatusMessage']);
                document.getElementById("btnedit"+factura).disabled = true;
                document.getElementById("btnsend"+factura).disabled = true;
                mailFE(cufe, factura)
                //adjuntarArvhivos(factura);
              }
            }
          },
          error: function() { 
            showProgress("0", factura)
            console.log(data);
          }
        });        
   }   
   function mailFE(cufe, fact) {
    Consecutivo = fact.replace('/[^0-9]/', '' );
    Consecutivo = parseInt(fact);
    // alert (Consecutivo);
    cadena = explode(Consecutivo,fact);
    Pref = $cadena[0];
    
    urlrpt="application/reports/facturasaluddet.php?PREFIJO="+Pref+"&CODIGO_INICIAL="+Consecutivo+"&CODIGO_FINAL="+Consecutivo+"&namedoc=1";
    $.get(urlrpt,{'Func':'CodUsrBdg','value':Nombre},function(data){ 
      document.getElementById('hdn_usuario'+Ventana).value=data;
    });
    adjuntarArvhivos(fact);
    
   }
   function adjuntarArvhivos(factura){
  $.ajax({
            type: 'POST',
            url: 'functions/php/GenomaXBackend/sendmails/adjuntarArchivos.php',
            data: {
              factura: factura

            },
            beforeSend: function()
             {
                
             },
              success: function (data) {
                obj = JSON.parse(data);
                alert("correo enviado");
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

      estadoFacturaDoc(factura,cufe);
    });
});
</script>
