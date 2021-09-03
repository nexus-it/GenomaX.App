// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";


function Guardar_hc(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById("txt_idhc"+Ventana).disabled==true) {
		xError="El folio ya fue guardado.";
	}
	document.getElementById("txt_idhc"+Ventana).disabled=true;
	if (document.getElementById('hdn_codigoter'+Ventana).value=="X") {
		xError="Ingrese un paciente válido";}
	if (document.getElementById('hdn_formatohc'+Ventana).value=="") {
		xError="Seleccione un formato de historia clínica a diligenciar";}
//Revisamos los campos obligatorios
/*
	var x = document.getElementsByClassName("hcx_"+Ventana);
	for (var i=0; i < x.length; i++) {
		var rekerido=x[i].required;
		if (rekerido) {
			var elValor =x[i].value;
			if (elValor=="") {
				xError="Existen campos requeridos sin diligenciar. "+x[i].id;
		        var elID=x[i].id;
		        $("#grp_"+elID).addClass("has-error");
			}
		}
	}
*/
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"hc.php",  
		  data: "Func=hc&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Historia Clínica", respuesta); 
		  	if (respuesta.indexOf("folio")>5) {
				Consecutivo=respuesta.substr(respuesta.length-5,5);
				historiac=document.getElementById('txt_idhc'+Ventana).value;
				$("#frm_form"+Ventana)[0].reset();
//				CargarReport("application/reports/hc.php?HISTORIA="+historiac+"&FOLIO_INICIAL="+Consecutivo+"&FOLIO_FINAL="+Consecutivo, "HC "+historiac);
				$('#GnmX_WinModal').modal('show');
				CargarWind('HC '+historiac, 'reports/hc.php?HISTORIA='+historiac+'&FOLIO_INICIAL='+Consecutivo+'&FOLIO_FINAL='+Consecutivo, 'default.png', 'hc.php',Ventana );
//				PrintMedicamentos(historiac,Consecutivo, Consecutivo);
//				PrintHlpDx(historiac,Consecutivo, Consecutivo);
//				PrintOrdenes(historiac,Consecutivo, Consecutivo);
//				PrintIncapacidad(historiac,Consecutivo, Consecutivo);
				document.getElementById(NomGuardar).style.display  = 'block';
				CerrarVentana(Ventana, event);
			}
		  }  
		});  
		return false;  
	} else {
		document.getElementById("txt_idhc"+Ventana).disabled=false;
		document.getElementById(NomGuardar).style.display  = 'block';
		MsgBoxErr("Historia Clínica", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

