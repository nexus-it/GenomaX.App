// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function ProcQx(Ventana, tiposerv) {
	if (tiposerv=="0") {
		document.getElementById('txt_uvr'+Ventana).value="0";
		document.getElementById('txt_gruposoat'+Ventana).value="0";

		document.getElementById('txt_uvr'+Ventana).disabled=true;
		document.getElementById('txt_uvrmin'+Ventana).disabled=false;
		document.getElementById('txt_uvrmax'+Ventana).disabled=false;
		document.getElementById('cmb_tipoqx'+Ventana).disabled=false;
		document.getElementById('txt_gruposoat'+Ventana).disabled=true;
		document.getElementById('txt_puntossoat'+Ventana).disabled=false;		
	} else {
		document.getElementById('cmb_tipoqx'+Ventana).value="0";
		document.getElementById('txt_uvrmin'+Ventana).value="0";
		document.getElementById('txt_uvrmax'+Ventana).value="0";
		document.getElementById('txt_puntossoat'+Ventana).value="0";

		document.getElementById('txt_uvr'+Ventana).disabled=false;
		document.getElementById('cmb_tipoqx'+Ventana).disabled=true;
		document.getElementById('txt_uvrmin'+Ventana).disabled=true;
		document.getElementById('txt_uvrmax'+Ventana).disabled=true;
		document.getElementById('txt_gruposoat'+Ventana).disabled=false;
		document.getElementById('txt_puntossoat'+Ventana).disabled=true;
	}
}

function NombreServicioPQ(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreServicio','value':Codigo},function(data){ 																	  
		document.getElementById('lbl_servicionom'+Ventana).value=data;
		document.getElementById('txt_cant'+Ventana).focus();
	}); 
}

function CodigoServicioPQ(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'CodigoServicio','value':Codigo},function(data){ 																	  
		document.getElementById('txt_codigopq'+Ventana).value=data;
		document.getElementById('txt_cant'+Ventana).focus();
	}); 
}

function ShowHideServicios(Opcion, Ventana) 
{
	if (Opcion=="1") {
	document.getElementById("div_productos"+Ventana).style.display='none';
	document.getElementById("div_servicios"+Ventana).style.display='block';
	document.getElementById("div_paquete"+Ventana).style.display='none';
	}
	if (Opcion=="2") {
	document.getElementById("div_productos"+Ventana).style.display='block';
	document.getElementById("div_servicios"+Ventana).style.display='none';
	document.getElementById("div_paquete"+Ventana).style.display='none';
	}
	if (Opcion=="3") {
	document.getElementById("div_productos"+Ventana).style.display='none';
	document.getElementById("div_servicios"+Ventana).style.display='none';
	document.getElementById("div_paquete"+Ventana).style.display='block';
	}
}

function Guardar_servicios(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_nombre'+Ventana).value=="") {
		xError="Digite el nombre del servicio.";}
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		xError="Digite el codigo del servicio.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "servicios.php",  
		  data: "Func=servicios&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Servicios", respuesta); 
				$("#frm_form"+Ventana)[0].reset();
				document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_servicios2(Ventana)
{
	xError="";	
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_nombre'+Ventana).value=="") {
		xError="Digite el nombre del servicio.";}
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		xError="Digite el codigo del servicio.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "servicios.php",  
		  data: "Func=servicios&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Servicios", respuesta); 
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);	
	}
}
