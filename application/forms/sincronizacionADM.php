<?php

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="col-sm-12">
		<div class="table-responsive">
			<table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered">
				<tbody>
		                <tr>
		                    <td align="left" style="vertical-align:  width: 100%;">Fecha Inicial</td>
		                    <td colspan="">
		                        <input type="date" name="txt_fecha-inicial<?php echo $NumWindow; ?>"
		                            id="txt_fecha-inicial<?php echo $NumWindow; ?>" value="" min="" max="" />
		                    </td>
		                    <td align="left" style="vertical-align:  width: 100%;">Fecha Final</td>
		                    <td colspan="">
		                        <input type="date" name="txt_fecha-final<?php echo $NumWindow; ?>"
		                            id="txt_fecha-final<?php echo $NumWindow; ?>" value="" min="" max="" />
		                    </td>
		                    <td colspan="">
                        <div class="progress" style="display: none; margin-top: 0px;" name="prgImport<?php echo $NumWindow; ?>" id="prgImport<?php echo $NumWindow; ?>">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%; height: 16px; margin-top: 0px;"> <span class="sr-only">Importando Informacion</span>  </div></div>
		                        <button name="btn_Sync<?php echo $NumWindow; ?>" id="btn_Sync<?php echo $NumWindow; ?>" type="button" onclick="javascript:RefreshList<?php echo $NumWindow; ?>();">Sincronzar</button>
		                    </td>
		                </tr>
		        </tbody>
		    </table> 
	    </div>
    </div>        
</form>
<div id="resultadPaciente"></div>

<script>
  FechaActual('txt_fecha-inicial<?php echo $NumWindow; ?>');
  FechaActual('txt_fecha-final<?php echo $NumWindow; ?>');
  document.getElementById("prgImport<?php echo $NumWindow; ?>").style.display="none";
  <?php
  if (isset($_GET["fechainicial"])) {
    echo '
    document.getElementById("prgImport'.$NumWindow.'").style.display="block";
    document.getElementById("btn_Sync'.$NumWindow.'").style.display="none";
    putPacienteCM("'.$_GET["fechainicial"].'","'.$_GET["fechafinal"].'");
    ';
    
  }
  ?>

function RefreshList<?php echo $NumWindow; ?>() {
  fechainicial=document.getElementById("txt_fecha-inicial<?php echo $NumWindow; ?>").value;
  fechafinal=document.getElementById("txt_fecha-final<?php echo $NumWindow; ?>").value;
  AbrirForm('application/forms/sincronizacionADM.php', '<?php echo $NumWindow; ?>', '&page=1&fechainicial='+fechainicial+'&fechafinal='+fechafinal);
  // putPacienteCM(fechainicial,fechafinal);

}

function putPacienteCM(fechainicial,fechafinal){
    $.ajax({
        type: 'POST',
        url: 'functions/php/GenomaXBackend/putPacientesCM.php',
        data: {
            fechainicial: fechainicial,
            fechafinal: fechafinal
        },
        beforeSend: function()
          {
          },
          success: function (data) {
          	obj = JSON.parse(data);

            //$("#resultadPaciente").html(obj[2]['descripcion'])
            //$("#resultadPaciente").html(data)

            

            $.each(obj, function(item){

            	insertarPacienteCM(obj,item);
            //$("#resultadPaciente").append('<div><div>'+obj[item].id+'</div><div>'+obj[item].descripcion+'</div><div>'+obj[item].fecha_confi+'</div></div>');
           });
           document.getElementById("prgImport<?php echo $NumWindow; ?>").style.display="none";
          document.getElementById("btn_Sync<?php echo $NumWindow; ?>").style.display="block";
    

          },
          error: function() { 
            console.log(data);
            $("#resultadPaciente").html("Error al procesar peticion");
          }
        });
   }

function encontrarID(tabla, campo) 
{
/*
var Funciones="functions/php/nexus/functions.php";
	

	$.get(Funciones,{'Func':'encontrarID','tabla':tabla, 'campo': campo},function(data){ 
		//alert(data)
		return data;
		
	});
*/

	$.ajax({
        type: 'GET',
        url: 'functions/php/nexus/functions.php',
        async: false,
        data: {
            Func: 'encontrarID',
            tabla: tabla,
            campo: campo
        },
        beforeSend: function()
          {
          },
          success: function (data) {
          	
          	alert (data)

          },
          error: function() { 
            console.log(data);
            $("#resultadPaciente").html("Error al procesar peticion");
          }
        });
	
}


function insertarPacienteCM(obj,item){
   
	
   	$.ajax({
        type: 'POST',
        url: 'functions/php/transactions/pacientes.php',
        data: {
            idpaciente: obj[item].num_id,
            nombre1: obj[item].primer_nom,
            nombre2: obj[item].segundo_nom,
            apellido1: obj[item].primer_ape,
            apellido2: obj[item].segundo_ape,
            tipoid: '1',
            Direccion: obj[item].direccion,
            Telefonos: obj[item].telefono,
            expedicion: '',
            correo: '',
            Departamento: obj[item].cod_dep,
            Municipio: obj[item].cod_muni,
            fechanac: '2000-01-01',
            EstCivil: 'SOLTERO (A)',
            Sexo: 'M',
            zona: 'U',
            TipoPaciente: '1',
            TipoAfiliado: '1',
            Contrato: '1',
            Plan: '3',
            Rango: '1'    

        },
        beforeSend: function()
          {
          },
          success: function (data) {
          	
          	putAdmisionCM(obj[item].estudio,obj[item].num_id,'1',obj,item);

          },
          error: function() { 
            console.log(data);
            $("#resultadPaciente").html("Error al procesar peticion");
          }
        });


        

   }


function putAdmisionCM(estudio,paciente,eps,obj,item){
    console.log(estudio);

    $.ajax({
        type: 'POST',
        url: 'functions/php/transactions/ingresos.php',
        data: {
            Ingreso_sinc: estudio,
            Ingreso: estudio,
            paciente: obj[item].num_id,
            Contrato: '1', // eps,
            Plan: '4',
            riesgo: '13',
            finconsulta: '10',
            TipoIng: 'A0',
            FechaIngSync: obj[item].fecha_confi,
            fechaadm:  obj[item].fecha_confi,
            fechahosp: obj[item].fecha_confi,
            cama: '',
            diagnostico: 'Z000',//obj[item].cups,
            remitido: 0,
            remision: '',
            fecremision: obj[item].fecha_confi,
            ips: '',
            motivo: obj[item].descripcion,
            acudiente: '',
            direccion: '',
            telefono: '',
            autorizacion: obj[item].estudio,
            fecautorizacion: obj[item].fecha_confi,
            observacion: obj[item].descripcion,

            copago: 0,
            cuota: 0,
            fecfin: obj[item].fecha_confi,
            sede: 'MNT',
            tipopct: 1,
            citax: estudio,

            covid19: '0',
            covid19gr:'0',
            escovid: '0'
           

        },
        beforeSend: function()
          {
          },
          success: function (data) {
            //alert(data);
            admision = data;
            fecha_adm_uci = obj[item].fecha_confi;
            des_ser_uci = obj[item].descripcion;
            //insertarOrdenesCM(data,obj[item].estudio,obj[item].num_id,eps);

          },
          error: function() { 
            console.log(data);
            $("#resultadPaciente").html("Error al procesar peticion");
          }
        });



    $.ajax({
        type: 'POST',
        url: 'functions/php/GenomaXBackend/putAdmisionCM.php',
        data: {
            estudio: estudio,
            paciente: paciente,
            eps: eps
        },
        beforeSend: function()
          {
          },
          success: function (data) {
          	obj = JSON.parse(data);

            //$("#resultadPaciente").html(obj[2]['descripcion'])
            //$("#resultadPaciente").html(data)

            

            //$.each(obj, function(item){

            agregarServivio(obj);
// Descomentar para traer ordenes de servicio

			// insertarOrdenesCM(admision,fecha_adm_uci,des_ser_uci,estudio,paciente,obj,eps);
            	
            //$("#resultadPaciente").append('<div><div>'+obj[item].id+'</div><div>'+obj[item].descripcion+'</div><div>'+obj[item].fecha_confi+'</div></div>');
           //});


          },
          error: function() { 
            console.log(data);
            $("#resultadPaciente").html("Error al procesar peticion");
          }
        });

   }


function agregarServivio(obj){

    $.ajax({
        type: 'POST',
        url: 'functions/php/transactions/servicios_sinc.php',
        data: {
            obj: obj
        },
        beforeSend: function()
          {
          },
          success: function (data) {
            
            
          },
          error: function() { 
            console.log(data);
            $("#resultadPaciente").html("Error al procesar peticion");
          }
        });

} 



function insertarOrdenesCM(admision,fecha_adm_uci,des_ser_uci,estudio,paciente,obj,eps){
    var regex = /(\d+)/g;
    var admision = admision.match(regex);
   
   	$.ajax({
        type: 'POST',
        url: 'functions/php/transactions/ordenesdeservicio_sinc.php',
        data: {
            Ingreso: admision[0],
            fechaord: fecha_adm_uci,
            area: '5',
            descripcion: des_ser_uci,
            autorizaord: estudio,


            obj: obj,


            //Codigo_SER: 

        },
        beforeSend: function()
          {
          },
          success: function (data) {
          	
          	
          },
          error: function() { 
            console.log(data);
            $("#resultadPaciente").html("Error al procesar peticion");
          }
        });

   }

 	$("form").addClass("form-inline container");
	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
  $("input[type=date]").addClass("form-control");

</script>