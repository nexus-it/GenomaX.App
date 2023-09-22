// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function Guardar_gruposcamas(Ventana) 
{
	xError="";
	/*
	NomGuardar="Guardar"+Ventana;
	Ventana="zWind_"+Ventana;
	*/
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		xError="Se requiere el código del grupo de camas";
	}
	if (document.getElementById('txt_descripcion'+Ventana).value=="") {
		xError="Describa el nombre del grupo de camas";
	}
	var FormPostx="";
	codigo=document.getElementById('txt_codigo'+Ventana).value;
	descripcion=document.getElementById('txt_descripcion'+Ventana).value;
	FormPostx=FormPostx+'codigo='+codigo+"&"+'descripcion='+descripcion+"&";
	FormPostx=String(FormPostx).substring(0,String(FormPostx).length-1);
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"gruposcamas.php",  
		  data: FormPostx,  
		  success: function(respuesta) { 
		  	Consecutivo=respuesta.substr(126, respuesta.length-126);
			MsgBox1("Grupos de Camas", respuesta); 
		  	AbrirForm('application/forms/gruposcamas.php', Ventana, '');
		  }
		}); 
	} else {
		MsgBox1("Error", xError);
	
	}
}

