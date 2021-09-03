// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function LoadTarifas(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'ManualTarifarioServ','value':Codigo},function(data){ 
		document.getElementById('serv'+Ventana).innerHTML=data;
	});
	$.get(Funciones,{'Func':'ManualTarifarioProd','value':Codigo},function(data){ 
		document.getElementById('prod'+Ventana).innerHTML=data;
	});
	$.get(Funciones,{'Func':'ManualTarifarioPaq','value':Codigo},function(data){ 
		document.getElementById('paq'+Ventana).innerHTML=data;
	});
}

function CargarSubgrupo(Ventana, Grupo, Tipo) 
{
	if (Tipo=="S") {
		cmb_select="cmb_subgrupo";
		document.getElementById("cmb_categoria"+Ventana).disabled=true;
		document.getElementById("cmb_categoria"+Ventana).innerHTML="<option value=''>Seleccione un subgrupo</option>";
	} else {
		cmb_select="cmb_categoria";
	}
	$.get(Funciones,{'Func':'CargarSubgrupoCUPS','value':Grupo, 'type':Tipo},function(data){ 
		document.getElementById(cmb_select+Ventana).innerHTML=data;
		document.getElementById(cmb_select+Ventana).disabled=false;
	});
}

function CodigoServicioX(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'CodigoServicio','value':Codigo},function(data){ 																	  
		document.getElementById('txt_codigo'+Ventana).value=data;
		document.getElementById('txt_valor'+Ventana).focus();
	}); 
}

function Guardar_tarifas(Tipo, Codigo, Tarifa, Valor, Ventana) 
{
	xError="";
	/*
	NomGuardar="Guardar"+Ventana;
	Ventana="zWind_"+Ventana;
	*/
	if (Codigo=="") {
		xError="Se requiere seleccionar la excepcion";
	}
	if (Valor=="") {
		xError="Describa el valor de la excepcion";
	}
	var FormPostx="";
	Tariff=document.getElementById('hdn_tarifa'+Ventana).value;
	FecIni=document.getElementById('txt_fechaini'+Ventana).value;
	FecFin=document.getElementById('txt_fechafin'+Ventana).value;
	FormPostx=FormPostx+'tarifa='+Tariff+"&"+'fechaini='+FecIni+"&"+'fechafin='+FecFin+"&"+'tipo='+Tipo+"&"+'codigo='+Codigo+"&"+'tbase='+Tarifa+"&"+'valor='+Valor+"&";
	FormPostx=String(FormPostx).substring(0,String(FormPostx).length-1);
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"tarifas.php",  
		  data: FormPostx,  
		  success: function(respuesta) { 
		  	$('#GnmX_WinModal').modal('hide');
		  	Consecutivo=respuesta.substr(126, respuesta.length-126);
			MsgBox1("Excepciones Manuales Tarifarios", respuesta); 
			CargarWind('Manual Tarifario ['+Tariff+'] ', 'forms/tarifas.php?tarifa='+Tarifa, 'blogs.png', 'mantarifas.php','<?php echo $NumWindow; ?>' );
		  }
		}); 
	} else {
		MsgBox1("Error", xError);
	
	}
}

