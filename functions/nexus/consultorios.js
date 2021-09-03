// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function Guardar_consultorios(Ventana) 
{
	xError="";
	/*
	NomGuardar="Guardar"+Ventana;
	Ventana="zWind_"+Ventana;
	*/
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		xError="Se requiere el código del consultorio";
	}
	if (document.getElementById('txt_nombre'+Ventana).value=="") {
		xError="Describa el nombre del consultorio";
	}
	if (document.getElementById('txt_descripcion'+Ventana).value=="") {
		xError="Diligencie la descripcion del consultorio";
	}
	var FormPostx="";
	codigo=document.getElementById('txt_codigo'+Ventana).value;
	nombre=document.getElementById('txt_nombre'+Ventana).value;
	descripcion=document.getElementById('txt_descripcion'+Ventana).value;
	area=document.getElementById('cmb_area'+Ventana).value;
	triage=document.getElementById('cmb_triage'+Ventana).value;
	urgencia=document.getElementById('cmb_urgencia'+Ventana).value;
	estado=document.getElementById('cmb_estado'+Ventana).value;
	FormPostx=FormPostx+'codigo='+codigo+"&"+'nombre='+nombre+"&"+'descripcion='+descripcion+"&"+'triage='+triage+"&"+'area='+area+"&"+'urgencia='+urgencia+"&"+'estado='+estado+"&";
	FormPostx=String(FormPostx).substring(0,String(FormPostx).length-1);
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"consultorios.php",  
		  data: FormPostx,  
		  success: function(respuesta) { 
		  	Consecutivo=respuesta.substr(126, respuesta.length-126);
			MsgBox1("Consultorios", respuesta); 
		  	AbrirForm('application/forms/consultorios.php', Ventana, '');
		  }
		}); 
	} else {
		MsgBox1("Error", xError);
	
	}
}

