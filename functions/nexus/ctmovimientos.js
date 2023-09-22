// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function Guardar_ctmovimientos(Ventana) 
{
	xError="";
	Ventana="zWind_"+Ventana;
	if (document.getElementById('Referencia_CNT'+Ventana).value=="") {
		xError="Se requiere una descripción en el campo Referencia";
	}
	Diff=document.getElementById("Diff"+Ventana).value;
	if (Diff!="0") {
		xError="Asiento descuadrado. [$"+Diff+"]";
	}
	totRows=document.getElementById("TotRows"+Ventana).value;
	var FormPostx="";
	var ContaRows=0;
	for (var i = totRows; i >= 1; i--) {
		if (document.getElementById("Codigo_CTA"+i+Ventana).value!="") {
			if (document.getElementById("Debito_CNT"+i+Ventana).value==document.getElementById("Credito_CNT"+i+Ventana).value) {
				xError="El valor debito debe ser diferente al credito en cada cuenta registrada.";			
			} else {
				ContaRows++;
				Tercero=document.getElementById("ID_TER"+i+Ventana).value;
				Cuenta=document.getElementById("Codigo_CTA"+i+Ventana).value;
				Descripcion=document.getElementById("Descripcion_CNT"+i+Ventana).value;
				CCosto=document.getElementById("Codigo_CCT"+i+Ventana).value;
				Debito=document.getElementById("Debito_CNT"+i+Ventana).value;
				Credito=document.getElementById("Credito_CNT"+i+Ventana).value;
				FormPostx=FormPostx+'tercero'+ContaRows+'='+Tercero+'&cuenta'+ContaRows+'='+Cuenta+'&descripcion'+ContaRows+'='+Descripcion+'&ccosto'+ContaRows+'='+CCosto+'&debito'+ContaRows+'='+Debito+'&credito'+ContaRows+'='+Credito+'&';
			}
		}
	}
	total=document.getElementById('Total_CNT'+Ventana).value;
	fuente=document.getElementById('Codigo_FNC'+Ventana).value;
	fecha=document.getElementById('Fecha_CNT'+Ventana).value;
	referencia=document.getElementById('Referencia_CNT'+Ventana).value.toUpperCase();
	consecutivo=document.getElementById('Consec_FNC'+Ventana).value;
	asiento=document.getElementById('Codigo_CNT'+Ventana).value;
	observaciones=document.getElementById('Observaciones_CNT'+Ventana).value.toUpperCase();
	FormPostx=FormPostx+'total='+total+'&totalrows='+ContaRows+'&fuente='+fuente+'&fecha='+fecha+'&referencia='+referencia+'&consecutivo='+consecutivo+'&asiento='+asiento+'&observaciones='+observaciones;
	if (xError=="") {
		console.log(Transact);
		$.ajax({  
		  type: "POST",
		  url: Transact+"ctmovimientos.php",  
		  data: FormPostx,  
		  success: function(respuesta) { 
		  	Consecutivo=respuesta;
			MsgBox1("Asiento Contable", "Asiento registrado correctamente. #"+respuesta); 
		  	$('#GnmX_WinModal').modal('show');
			CargarWind('Asiento Contable # '+Consecutivo, 'reports/ctmovcont.php?CNT1='+Consecutivo+'&CNT2='+Consecutivo, 'default.png', 'ctmovcont.php',Ventana );
		  }
		}); 
	} else {
		MsgBox1("Error", xError);
	
	}
}

