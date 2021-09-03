// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function Guardar_mantarifas(Ventana) 
{
	xError="";
	/*
	NomGuardar="Guardar"+Ventana;
	Ventana="zWind_"+Ventana;
	*/
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		xError="Se requiere el código del manual tarifario";
	}
	if (document.getElementById('txt_nombre'+Ventana).value=="") {
		xError="Describa el nombre del manual tarifario";
	}
	if (document.getElementById('txt_variacion'+Ventana).value=="") {
		xError="Diligencie el porcentaje de variacion";
	}
	var FormPostx="";
	codigo=document.getElementById('txt_codigo'+Ventana).value;
	nombre=document.getElementById('txt_nombre'+Ventana).value;
	variacion=document.getElementById('txt_variacion'+Ventana).value;
	base=document.getElementById('cmb_base'+Ventana).value;
	tipo=document.getElementById('cmb_tipo'+Ventana).value;
	FormPostx=FormPostx+'codigo='+codigo+"&"+'nombre='+nombre+"&"+'variacion='+variacion+"&"+'base='+base+"&"+'tipo='+tipo+"&";
	FormPostx=String(FormPostx).substring(0,String(FormPostx).length-1);
	if (xError=="") {
		document.getElementById('btn_save'+Ventana).innerHTML='<img src="themes/ghenx/img/loading.gif" align="left"> Guardadndo el manual tarifario. Dependiendo del numero de excepciones, esta tarea puede  tardar un poco.';
		$.ajax({  
		  type: "POST",  
		  url: Transact+"mantarifas.php",  
		  data: FormPostx,  
		  success: function(respuesta) { 
		  	Consecutivo=respuesta.substr(126, respuesta.length-126);
			MsgBox1("Manuales Tarifarios", respuesta); 
		  	AbrirForm('application/forms/mantarifas.php', Ventana, '');
		  }
		}); 
	} else {
		MsgBox1("Error", xError);
	}
}

