// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function getNumbersInString(string) {
	var tmp = string.split("");
	var map = tmp.map(function(current) {
	  if (!isNaN(parseInt(current))) {
		return current;
	  }
	});
  
	var numbers = map.filter(function(value) {
	  return value != undefined;
	});
  
	return numbers.join("");
  }
  function getCharsInString(string) {
	var tmp = string.split("");
	var map = tmp.map(function(current) {
	  if (isNaN(parseInt(current))) {
		return current;
	  }
	});
  
	var chars = map.filter(function(value) {
	  return value != undefined;
	});
  
	return chars.join("");
  }

function Guardar_factcompra(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	NomProgress='nxsprogress'+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	InsertarHTML(NomProgress, '<div class="progress" style="width: 50%; float: left;">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%">    <span class="sr-only">Generando Factura</span>  </div></div>');
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('Codigo_TER'+Ventana).value=="") {
		xError="Se requiere la identificacion del proveedor";}
    if (document.getElementById('Consec_FAC'+Ventana).value=="") {
        xError="Digite el numero de la factura del documento";}
    if (document.getElementById('hdn_controw'+Ventana).value=="") {
        xError="Agregue el concepto en el detalle de la factura";}
    if (document.getElementById('Total_FAC'+Ventana).value=="0") {
        xError="El valor de la factura debe ser mayor que cero (0)";}
            
                                  
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "factcompra.php",  
		  data: "Func=factcompra&"+RecorrerForm2($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
                InsertarHTML(NomProgress, '');
                document.getElementById(NomGuardar).style.display  = 'block';
                $("#frm_form"+Ventana)[0].reset();
				MsgBox1("Factura de Compra", respuesta); 
		  	
		  	}  
		});  
		return false;  
	} else {
		InsertarHTML(NomProgress, '');
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	}
}


