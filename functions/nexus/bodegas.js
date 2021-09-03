// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function CodigoResponsable(Ventana, Nombre) 
{
	$.get(Funciones,{'Func':'CodUsrBdg','value':Nombre},function(data){ 
		document.getElementById('hdn_usuario'+Ventana).value=data;
	});
}

function Guardar_bodegas(Ventana) 
{
	xError="";
	/*
	NomGuardar="Guardar"+Ventana;
	Ventana="zWind_"+Ventana;
	*/
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		xError="Se requiere el código de la bodega";
	}
	if (document.getElementById('txt_nombre'+Ventana).value=="") {
		xError="Describa el nombre de la bodega";
	}
	if (document.getElementById('txt_responsable'+Ventana).value=="") {
		xError="Diligencie el nombre del usuario responsable";
	}
	var FormPostx="";
	codigo=document.getElementById('txt_codigo'+Ventana).value;
	nombre=document.getElementById('txt_nombre'+Ventana).value;
	responsable=document.getElementById('hdn_usuario'+Ventana).value;
	sede=document.getElementById('cmb_sede'+Ventana).value;
	inventario=document.getElementById('cmb_inventario'+Ventana).value;
	estado=document.getElementById('cmb_estado'+Ventana).value;
	FormPostx=FormPostx+'codigo='+codigo+"&"+'nombre='+nombre+"&"+'responsable='+responsable+"&"+'sede='+sede+"&"+'inventario='+inventario+"&"+'estado='+estado+"&";
	FormPostx=String(FormPostx).substring(0,String(FormPostx).length-1);
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"bodegas.php",  
		  data: FormPostx,  
		  success: function(respuesta) { 
		  	Consecutivo=respuesta.substr(126, respuesta.length-126);
			MsgBox1("Bodegas", respuesta); 
		  	AbrirForm('application/forms/bodegas.php', Ventana, '');
		  }
		}); 
	} else {
		MsgBox1("Error", xError);
	
	}
}

