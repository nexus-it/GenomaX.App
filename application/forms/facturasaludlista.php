<?php
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
  if ($ini=="1") { $ini="0"; }
  $fin=$page*$showRows;
  if(isset($_GET["fechaini"])){
    $fechaini = $_GET["fechaini"];
    $fechafin = $_GET["fechafin"];
    $numfact= $_GET["numfact"];
    $contrato = $_GET["contrato"];
    $paciente = $_GET["paciente"];
    $filtro= " Where t1.codigo_fac like '%".$numfact."%' and Nombre_TER like '%".$paciente."%' and Nombre_EPS like '%".$contrato."%' and fecha_fac between '".$fechaini."' and '".$fechafin." 23:59:59' ";
  } else {
    $SQL="Select curdate(), date(DATE_ADD(NOW(),INTERVAL -60 DAY));";
    $result = mysqli_query($conexion, $SQL);
    if($row = mysqli_fetch_array($result)) {
      $fechaini=$row[1];
      $fechafin=$row[0];
    }
    mysqli_free_result($result);
    $numfact= "";
    $contrato = "";
    $paciente = "";
    $filtro= " Where fecha_fac between '".$fechaini."' and '".$fechafin." 23:59:59' ";
  }
?>
<div class="container">
  <form action="" method="post" name="frm_form<?php echo $NumWindow; ?>">
	<label class="label label-default">Listado de facturas</label>
  <div class="row well well-sm">
   
    <div class="col-md-2">
	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_factura<?php echo $NumWindow; ?>">Factura</label>
		<input  name="txt_factura<?php echo $NumWindow; ?>" id="txt_factura<?php echo $NumWindow; ?>" type="text" required class="form-control"  value="<?php echo $numfact; ?>" />
	</div>
		</div>
		<div class="col-md-2">
	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicial</label>
		<input  name="txt_fechaini<?php echo $NumWindow; ?>" id="txt_fechaini<?php echo $NumWindow; ?>" type="date" required class="form-control"  value="<?php echo $fechaini; ?>" />
	</div>
		</div>
		<div class="col-md-2">
	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Final</label>
		<input  name="txt_fechafin<?php echo $NumWindow; ?>" id="txt_fechafin<?php echo $NumWindow; ?>" type="date" required class="form-control"  value="<?php echo $fechafin; ?>" />
	</div>
		</div>
    <div class="col-md-2">
	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_paciente<?php echo $NumWindow; ?>">Paciente</label>
		<input  name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" required class="form-control"  value="<?php echo $paciente; ?>" />
	</div>
		</div>
    <div class="col-md-2">
	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_contrato<?php echo $NumWindow; ?>">Contrato</label>
    <div class="input-group" id="grp_txt_idempleado<?php echo $NumWindow; ?>">
      <input  name="txt_contrato<?php echo $NumWindow; ?>" id="txt_contrato<?php echo $NumWindow; ?>" type="text" required class="form-control"  value="<?php echo $contrato; ?>" />
      <span class="input-group-btn">	
				<button class="btn btn-success" type="button" onclick="javascript:RefreshList<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></button>
			</span>
		</div>
	</div>
		</div>

		<div class="col-md-2 btn-group">
      <button class="btn btn-success dropdown-toggle" title="Crear nueva factura" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Facturar Nueva Cuenta <i class="fa fa-file"></i>  <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li><a href="javascript: CargarForm('application/forms/facturasalud.php', 'Facturacion de Cuenta Evento', 'invoice.png'); ">Contrato por Evento</a></li>
        <li><a href="javascript: CargarForm('application/forms/facturasaludcapita.php', 'Facturacion de Cuenta Cápita', 'invoice.png'); ">Contrato Capitado</a></li>
        <li><a href="javascript: CargarForm('application/forms/facturasaludgrupal.php', 'Facturacion de Cuentas Grupal', 'invoice.png'); ">Contrato Global</a></li>
      </ul>
		</div>
</form>
<?php
echo '<table class="table table-striped table-condensed tblDetalle table-bordered">'; 
			$conteo = listarFacturas($filtro,$ini,$fin);
echo '</table>';

contarFacts($filtro,$page, $showRows);
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

      estadoFacturaDoc(factura,cufe)
    });
});
</script>
