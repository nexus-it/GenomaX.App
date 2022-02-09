// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function Guardar_periodoscont(Ventana) 
{
	xError="";
	/*
	NomGuardar="Guardar"+Ventana;
	Ventana="zWind_"+Ventana;
	*/
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		xError="Se requiere el código del periodo contable";
	}
	if (document.getElementById('txt_nombre'+Ventana).value=="") {
		xError="Describa el periodo contable";
	}
	var FormPostx="";
	codigo=document.getElementById('txt_codigo'+Ventana).value;
	nombre=document.getElementById('txt_nombre'+Ventana).value;
	fechaini=document.getElementById('txt_fechaini'+Ventana).value;
	fechafin=document.getElementById('txt_fechafin'+Ventana).value;
	periodoant=document.getElementById('txt_periodoant'+Ventana).value;
	periodosig=document.getElementById('txt_periodosig'+Ventana).value;
	estado=document.getElementById('cmb_estado'+Ventana).value;
	FormPostx=FormPostx+'codigo='+codigo+"&"+'nombre='+nombre+"&"+'fechaini='+fechaini+"&"+'fechafin='+fechafin+"&"+'periodoant='+periodoant+"&"+'periodosig='+periodosig+"&"+'estado='+estado+"&";
	FormPostx=String(FormPostx).substring(0,String(FormPostx).length-1);
	if (xError=="") {
		document.getElementById('btn_save'+Ventana).innerHTML='<img src="themes/ghenx/img/loading.gif" align="left"> Guardadndo el periodo contable.';
		$.ajax({  
		  type: "POST",  
		  url: Transact+"ctperiodoscont.php",  
		  data: FormPostx,  
		  success: function(respuesta) { 
		  	MsgBox1("Periodo Contable", respuesta); 
		  	AbrirForm('application/forms/ctperiodoscont.php', Ventana, '');
		  }
		}); 
	} else {
		MsgBox1("Error", xError);
	}
}

