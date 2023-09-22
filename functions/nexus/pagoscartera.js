// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function Guardar_pagoscartera(Ventana) 
{
	xError="";

	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	Ventana="zWind_"+Ventana;
	
	if (document.getElementById('hdn_totregistros'+Ventana).value=="0") {
		xError="No existen facturas para generar pago";
	}
	if (document.getElementById('txt_NombreTER'+Ventana).value=="") {
		xError="Debe seleccionar un tercero válido";
	}
	if (document.getElementById('txt_total'+Ventana).value=="0") {
		xError="La suma total del pago debe ser mayor de cero.";
	}
	if (document.getElementById('txt_total'+Ventana).value=="$0.00") {
		xError="La suma total del pago debe ser mayor de cero.";
	}
	TotalFacturas=document.getElementById('hdn_totregistros'+Ventana).value;
	var FormPostx="";
	CodPago=document.getElementById('txt_pago'+Ventana).value;
	CodFec=document.getElementById('txt_fecha'+Ventana).value;
	CodTer=document.getElementById('txt_tercero'+Ventana).value;
	CodFPG=document.getElementById('cmb_formapago'+Ventana).value;
	CodBCO=document.getElementById('cmb_banco'+Ventana).value;
	CodTotal=document.getElementById('txt_total'+Ventana).value;
	CodObs=document.getElementById('txt_observacion'+Ventana).value;
	
	FormPostx=FormPostx+'CodPago='+CodPago+"&"+'CodFec='+CodFec+"&"+'CodTer='+CodTer+"&"+'CodFPG='+CodFPG+"&"+'CodBCO='+CodBCO+"&"+'CodTotal='+CodTotal+"&"+'CodObs='+CodObs+"&";
	FacPagos=0;
	for (i = 1; i <= TotalFacturas; i++) { 
		LaFaktura=document.getElementById('hdn_factura'+i+Ventana).value;
		Abono=document.getElementById('hdn_pagara'+i+Ventana).value;
		Valor=document.getElementById('txt_pagado'+i+Ventana).value;
		if (Abono=="1"){
			FormPostx=FormPostx+'LaFaktura'+i+"="+LaFaktura+"&"+'Abono'+i+"="+Abono+"&"+'Valor'+i+"="+Valor+"&";
			FacPagos++;
		}
	}
	FormPostx=FormPostx+'FacPagos='+FacPagos+"&";
	FormPostx=String(FormPostx).substring(0,String(FormPostx).length-1);
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"pagoscartera.php",  
		  data: FormPostx,  
		  success: function(respuesta) { 
		  	Consecutivo=respuesta.substr(126, respuesta.length-126);
			MsgBox1("Recepcion de Pagos", respuesta); 
		  	AbrirForm('application/forms/pagoscartera.php', Ventana, '');
		  	document.getElementById(NomGuardar).style.display  = 'block';
		  	$('#GnmX_WinModal').modal('show');
			CargarWind("Pago Sin Confirmar "+Consecutivo, 'reports/pagoscartera.php?CODIGO_INICIAL='+Consecutivo+'&CODIGO_FINAL='+Consecutivo, 'default.png', 'pagoscartera.php',Ventana );
		  }
		}); 
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

