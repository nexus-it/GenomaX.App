// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function DespMedSol(Ventana, FiltroArea, FiltroPcte, FiltroFecIni, FiltroFecFin) {
	document.getElementById('zero_detalle'+Ventana).innerHTML='...';
	$.get(Funciones,{'Func':'DespMedSol','filtroarea':FiltroArea, 'filtropcte':FiltroPcte,'filfecini':FiltroFecIni,'filfecfin':FiltroFecFin,'ventana':Ventana},function(data){ 
		document.getElementById('zero_detalle'+Ventana).innerHTML=data;
	});
}

function EditSolFarm(NumSol, Ventana) {
  CargarWind('Editar Solicitud a Farmacia ['+NumSol+'] ', 'forms/inventariosolfarm2.php?numsol='+NumSol, '1.Pills.png', 'inventariosolfarm.php',Ventana );
}

function NewSolFarm(NumSol, Ventana) {
  CargarWind('Nueva Solicitud a Farmacia ', 'forms/inventariosolfarm2.php?numsol='+NumSol, '1.Pills.png', 'inventariosolfarm.php',Ventana );
}

function Guardar_camas(Ventana) 
{
	xError="";
	/*
	NomGuardar="Guardar"+Ventana;
	Ventana="zWind_"+Ventana;
	*/
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		xError="Se requiere el código de la cama";
	}
	if (document.getElementById('txt_nombre'+Ventana).value=="") {
		xError="Describa el nombre de la cama";
	}
	if (document.getElementById('txt_descripcion'+Ventana).value=="") {
		xError="Diligencie la descripcion de la cama";
	}
	var FormPostx="";
	codigo=document.getElementById('txt_codigo'+Ventana).value;
	nombre=document.getElementById('txt_nombre'+Ventana).value;
	descripcion=document.getElementById('txt_descripcion'+Ventana).value;
	pabellon=document.getElementById('cmb_pabellon'+Ventana).value;
	area=document.getElementById('cmb_area'+Ventana).value;
	ocupada=document.getElementById('cmb_ocupada'+Ventana).value;
	estado=document.getElementById('cmb_estado'+Ventana).value;
	FormPostx=FormPostx+'codigo='+codigo+"&"+'nombre='+nombre+"&"+'descripcion='+descripcion+"&"+'pabellon='+pabellon+"&"+'area='+area+"&"+'ocupada='+ocupada+"&"+'estado='+estado+"&";
	FormPostx=String(FormPostx).substring(0,String(FormPostx).length-1);
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"camas.php",  
		  data: FormPostx,  
		  success: function(respuesta) { 
		  	Consecutivo=respuesta.substr(126, respuesta.length-126);
			MsgBox1("Camas", respuesta); 
		  	AbrirForm('application/forms/camas.php', Ventana, '');
		  }
		}); 
	} else {
		MsgBox1("Error", xError);
	
	}
}

