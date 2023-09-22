// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function Guardar_hcenfdisp(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	tError="";
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('hdn_codigoter'+Ventana).value=="X") {
		tError="Paciente No Activo"
		xError="Ingrese un paciente válido";
	}
	
	//Revisamos los campos obligatorios
	var x = document.getElementsByClassName("hc_"+Ventana);
	for (var i=0; i < x.length; i++) {
		var rekerido=x[i].required;
		if (rekerido) {
			var elValor =x[i].value;
			if (elValor=="") {
				tError="Campos Obligatorios"
				xError="Existen campos requeridos sin diligenciar.";
		        var elID=x[i].id;
		        $("#grp_"+elID).addClass("has-error");
			}
		}
	}
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"hcenfdisp.php",  
		  data: "Func=hcenfdisp&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Registro de Enfermería", respuesta); 
			if (respuesta.indexOf("folio")>5) {
				Consecutivo=respuesta.substr(respuesta.length-5,5);
				historiac=document.getElementById('txt_idhc'+Ventana).value;
				$("#frm_form"+Ventana)[0].reset();
				CargarReport("application/reports/hc.php?HISTORIA="+historiac+"&FOLIO_INICIAL="+Consecutivo+"&FOLIO_FINAL="+Consecutivo, "HC "+historiac);
				
	
			}
		  }  
		});  
		return false;  
	} else {
		MsgBoxErr(tError, xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}
