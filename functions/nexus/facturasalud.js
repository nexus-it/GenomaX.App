// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function Guardar_facturasalud(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	NomProgress='nxsprogress'+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	InsertarHTML(NomProgress, '<div class="progress" style="width: 50%; float: left;">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%">    <span class="sr-only">Generando Factura</span>  </div></div>');
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_Ingreso'+Ventana).value=="") {
		xError="Digite el codigo de la admision";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "facturasalud.php",  
		  data: "Func=facturasalud&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  		Tam=respuesta.length;
		  		Correcto=respuesta.substr(Tam-8,Tam);
				if (Correcto=="correcto") {
					Pref=respuesta.substr(0,respuesta.indexOf('-'));
					TamPref=Pref.length;
					Consecutivo=respuesta.substr(respuesta.indexOf('-')+1,Tam-(TamPref+9));
					Pref=Pref.trim();
					respuesta="Se ha generado correctamente la factura "+Pref+Consecutivo;
					$("#frm_form"+Ventana)[0].reset();
				
			  		$('#GnmX_WinModal').modal('show');
					CargarWind("Factura "+Pref+Consecutivo, 'reports/facturasaluddet.php?PREFIJO='+Pref+'&CODIGO_INICIAL='+Consecutivo+'&CODIGO_FINAL='+Consecutivo, 'default.png', 'facturasalud.php',Ventana );
				
					var miDiv = document.getElementById("zero_detalle"+Ventana); 
					miDiv.innerHTML ='<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblDetalle'+Ventana+'" ><tbody id="tbDetalle'+Ventana+'"><tr id="trh'+Ventana+'"> <th id="th1'+Ventana+'">Codigo</th> <th id="th2'+Ventana+'">Servicio</th> <th id="th3'+Ventana+'">Cant.</th> <th id="th4'+Ventana+'">Paciente</th> <th id="th4'+Ventana+'">Entidad</th> <th id="th4'+Ventana+'">Total</th></tr></tbody></table>';
					InsertarHTML(NomProgress, '');
					document.getElementById(NomGuardar).style.display  = 'block';
	
				} else {
					
				}
				MsgBox1("Liquidación de Cuentas", respuesta); 
		  	
		  	}  
		});  
		return false;  
	} else {
		InsertarHTML(NomProgress, '');
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	}
}


