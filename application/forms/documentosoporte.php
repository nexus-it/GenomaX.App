
<?php
	session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form" id="frm_form" class="form-horizontal container">
	<input type="hidden" name="hdn_citax" id="hdn_citax">
<div class="col-md-12">

	<label class="label label-default">Datos de Proveedor</label>
	  <div class="row well well-sm">

	<div class="col-md-3">
<div class="form-group" id="grp_txt_paciente"> 
  <label for="txt_paciente">Identificacion</label>
  	<div class="input-group">	
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_WinModal" onclick="javascript:LoadPcte();" title="Edición de Pacientes"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></button>
  		</span>
  		<input required name="txt_paciente" type="text" id="txt_paciente" onblur="javascript:NombreTercero('', this.value, 'gxpacientes');EpsPcte('', this.value);" onkeypress="BuscarPte(event);" onkeydown="if(event.keyCode==115){CargarSearch('Paciente', 'txt_paciente', 'NULL')};" style="font-size:15px; font-weight: bold; color:#0E5012; "/>
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Paciente" onclick="javascript:CargarSearch('Paciente', 'txt_paciente', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
  		</span>
  	</div>
</div>
	</div>
	<div class="col-md-3">

	<div class="form-group">
		<label for="txt_paciente2">Nombre</label>
		<input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente2" id="txt_paciente2" type="text" disabled="disabled" class="lead" />
	</div>
	
		</div>

	<div class="col-md-3">
<div class="form-group" id="grp_txt_fechaadm">
<label for="txt_fechaadm">Fecha</label><P>
  <input name="txt_fechaadm"  id="txt_fechaadm" type="date" required 	<?php echo $EditDate_XAD; ?>>
</div>
	</div>

	
	<div class="col-md-6">
<div class="form-group" id="grp_retencion">
<label for="txt_retencion">Retencion</label><P>
	<select class="form-control" name="txt_retencion" id="txt_retencion">
		<option></option>
		<?php $TipoDoc = llenarSelect("SELECT * FROM czconceptosretencion where Estado_RTE = 1 ",""); 
		foreach($TipoDoc as $TipoDocs){
			echo $TipoDocs;
		}
		?>
	</select>
</div>
	</div>

	
	</div>

	

	</div>
	
		</div>

<div class="col-md-12">

	  <label class="label label-default">Detalle de docuento soporte</label>
	  <div class="row well well-sm">
			<div class="col-md-3">
					<div class="form-group" id="descripcion"> 
						<label for="txt_descripcion">Descripcion</label>
							<div class="input-group">	
								<input required name="txt_descripcion" type="text" id="txt_descripcion" />
							</div>
					</div>
			</div>

			<div class="col-md-3">
					<div class="form-group" id="cantidad"> 
						<label for="txt_cantidad">Cantidad</label>
							<div class="input-group">	
								<input required name="txt_cantidad" type="text" id="txt_cantidad" />
							</div>
					</div>
			</div>

			<div class="col-md-3">
					<div class="form-group" id="valorunitario"> 
						<label for="txt_valorunitario">Valor unitario</label>
							<div class="input-group">	
								<input required name="txt_valorunitario" type="text" id="txt_valorunitario" />
							</div>
					</div>
			</div>

			<div class="col-md-3">
			    <a id="agregar" class="btn btn-success">Agregar  datos </a>
				
			</div>

  	   </div>
</div>
	
<a id="generar" class="btn btn-success">Generar Factura </a>


</form>
<div id="estado" style="display:none;"></div>
<div id="tabla"></div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.2/jquery.min.js"></script>
  <script>

$(document).on('click', '#generar', function(e){
    	e.preventDefault();
    	var  txt_paciente = $('#txt_paciente').val();
    
    	$.ajax({
    		url: 'application/forms/documentosoporte_g.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
    		method: 'POST',
    		data: { txt_paciente: txt_paciente },
    		beforeSend: function(){
    			$('#estado').css('display','block');
    			$('#estado p').html('Guardando datos...');
    		},
    		success: function(r){
				obj = JSON.parse(r);
				//$('#estado').html(obj['mensaje']);
				if (obj['mensaje'] == '200') { // Si el php anterior, imprimió 200
    				//$('#estado').html(obj['mensaje']);
					$('#tabla').html(obj['tabla']);
					
    			} else {
					if (obj['mensaje'] != '200') {

						Imp_DocSop(obj['mensaje']);
						//MsgBox1('Alerta',"Guardado Documento Soporte"+obj['mensaje']);
					
						//$('#GnmX_WinModal').modal('show');
						//CargarWind("Factura "+obj['mensaje'], 'reports/documentosoporte.php?CODIGO_INICIAL='+obj['mensaje']+'&CODIGO_FINAL='+obj['mensaje'], 'default.png', 'docuemntosoporte.php',0 );
				
					}else{
    					$('#estado').html('<hr><p>Error al guardar los datos.</p><hr>');
					}
    			}
    		}
    	});
    });

    $(document).on('click', '#agregar', function(e){
    	e.preventDefault();
    	var  txt_paciente = $('#txt_paciente').val(),
			 nombre = $('#txt_paciente2').val(),
			 txt_fechaadm =  $('#txt_fechaadm').val(),
			 descripcion = $('#txt_descripcion').val(),
			 cantidad = $('#txt_cantidad').val(),
			 valorunitario = $('#txt_valorunitario').val(),
			 retencion = $('#txt_retencion').val();
    
    	$.ajax({
    		url: 'application/forms/documentosoporte_g.php', // Es importante que la ruta sea correcta si no, no se va a ejecutar
    		method: 'POST',
    		data: { txt_paciente: txt_paciente, nombre: nombre, txt_fechaadm: txt_fechaadm , descripcion: descripcion, cantidad: cantidad , valorunitario: valorunitario,  retencion:  retencion   },
    		beforeSend: function(){
    			$('#estado').css('display','block');
    			$('#estado p').html('Guardando datos...');
    		},
    		success: function(r){
				obj = JSON.parse(r);
				//$('#estado').html(obj['mensaje']);
				if (obj['mensaje'] == '200') { // Si el php anterior, imprimió 200
    				//$('#estado').html(obj['mensaje']);
					$('#tabla').html(obj['tabla']);
    			} else {
    				$('#estado').html('<hr><p>Error al guardar los datos.</p><hr>');
    			}
    		}
    	});
    });
  </script>


<script >


FechaActual('txt_fechahosp');
document.getElementById("cmb_covid19gr").disabled = true;
document.getElementById("cmb_covid19").disabled = true;
document.getElementById("txt_fechahosp").disabled = true;
document.getElementById("cmb_cama").disabled = true;


function cambiarhosp() {
	if(document.getElementById('cmb_cama').disabled) {
		document.getElementById("cmb_cama").disabled = false;
		document.getElementById("txt_fechahosp").disabled = false;
	} else {
		document.getElementById("cmb_cama").disabled = true;
		document.getElementById("txt_fechahosp").disabled = true;
	}
}

function cambiarcovid() {
	if(document.getElementById('cmb_escovid').value=="0") {
		document.getElementById("cmb_covid19").disabled = true;
		document.getElementById("cmb_covid19gr").disabled = true;
	} else {
		document.getElementById("cmb_covid19").disabled = false;
		document.getElementById("cmb_covid19gr").disabled = false;
	}
}

function CargarIngreso(Pcte) {
	if (Dpto=="") {
		VarAdm="NULL";
	} else {
		VarAdm="Codigo_TER=*"+Pcte+"*";
	}
	CargarSearch('Ingresos', 'txt_Ingreso', VarAdm);
}

function BuscarPte(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	NombreTercero('', document.frm_form.txt_paciente.value, 'gxpacientes');
	EpsPcteCont('', document.frm_form.txt_paciente.value);
	PlanPcte('', document.frm_form.txt_paciente.value);
	AcompPcte('', document.frm_form.txt_paciente.value);
	IngresosAbiertos('');
	document.frm_form.txt_Ingreso.focus();
  }
}

function BuscarIng(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){

	if ((document.getElementById('txt_Ingreso').value=="")||(document.getElementById('txt_Ingreso').value=="0000000000")) {
		document.frm_form.txt_Ingreso.value='0000000000';
		FechaActual('txt_fechaadm');
		HoraActual('txt_horaadm');
		document.frm_form.txt_Contrato.focus();
	} else {
		AbrirForm('application/forms/ingresos.php', '', '&Ingreso='+document.getElementById('txt_Ingreso').value);
	}  
  }
}

function BuscarContrato(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreContrato('', document.frm_form.txt_Contrato.value);
	  CargarPlan('', document.frm_form.txt_Contrato.value);
  }
}

function BuscarDpto(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreDpto('', document.frm_form.txt_Departamento.value);
  }
}

function BuscarMUN(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreMUN('', document.frm_form.txt_Departamento.value, document.frm_form.txt_Municipio.value);
  }
}

function HCDxOnBlur() {
	if (document.getElementById('txt_diagnostico').value!="") {
		NombreDx(document.getElementById('txt_diagnostico').value, document.getElementById('txt_NombreDx'));
	} else {
		document.getElementById('txt_NombreDx').value = '';
	}
}

function LoadPcte() {
	IdPte=document.getElementById('txt_paciente').value;
	CargarWind('Pacientes ', 'forms/pacientes.php?IdPte='+IdPte+'&mode=modal&wnd=ingresoscx', '1.PatientMale.png', 'ingresos.php','' );
}

	$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    

	$(':input', $("#frm_form")).each(function() {
		Var1=this.id;
		$(this).addClass("nxs_");
	});


function Imp_DocSop(data)
{
	//rptDocSop(data);
	MsgBox1('Alerta',"Guardado Documento Soporte No. "+data);

	//$('#GnmX_WinModal').modal('show');
	//CargarWind("Factura "+data, 'reports/documentosoporte.php?CODIGO_INICIAL='+data+'&CODIGO_FINAL='+data, 'default.png', 'docuemntosoporte.php',0 );
				
					
}
</script>
