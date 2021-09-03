// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function CodUsrBdg(Ventana, Nombre) 
{
	$.get(Funciones,{'Func':'CodUsrBdg','value':Nombre},function(data){ 

		document.getElementById('hdn_codigo'+Ventana).value=data;
	});
}

function Guardar_bodegausers(Ventana) 
{
	xError="";
	/*
	NomGuardar="Guardar"+Ventana;
	Ventana="zWind_"+Ventana;
	*/
	var FormPostx="";
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"bodegausers.php",  
		  data: "Func=bodegausers&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1('Bodegas', 'Usuarios Actualizados')
		  }
		}); 
	} else {
		MsgBox1("Error", xError);
	
	}
}

