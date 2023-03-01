// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function Guardar_inventariodelfarm(Ventana, Origen) 
{
	xError="";
	NomGuardar="guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	console.log(Origen);
	//Se verifica la validez de los campos...
	if (document.getElementById('hdn_controwMed'+Ventana).value=="0") {
		xError="No tiene procuctos a solicitar.";}
	
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "inventariodelfarm.php",  
		  data: "Func=inventariodelfarm&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Devolucion de Medicamentos", respuesta); 
			
		  }  
		});  
		return false;  
	} else {
		MsgBox1('Devolucion a Farmacia', 'Error: '+xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}