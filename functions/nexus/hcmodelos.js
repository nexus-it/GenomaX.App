// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";

function HCForm(miForm) {
var FormPost="";
var Var1="";
$(':input', miForm).each(function() {
	Var1=this.name;
	Var1=Var1.substring(0,Var1.indexOf('zW'));
	FormPost=FormPost+Var1+"="+this.value+"&";
});
FormPost=String(FormPost).substring(0,String(FormPost).length-1)
return FormPost;
}


function Guardar_hcmodelos(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	/*
	if (document.getElementById("txt_idhc"+Ventana).disabled==true) {
		xError="El folio ya fue guardado.";
	}
	document.getElementById("txt_idhc"+Ventana).disabled=true;
	if (document.getElementById('hdn_codigoter'+Ventana).value=="X") {
		xError="Ingrese un paciente válido";}
	if (document.getElementById('hdn_formatohc'+Ventana).value=="") {
		xError="Seleccione un formato de historia clínica a diligenciar";}
		*/
//Revisamos los campos obligatorios

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"hcmodelos.php",  
		  data: "Func=hcmodelos&"+HCForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Formatos Historia Clínica", respuesta); 
		  	document.getElementById(NomGuardar).style.display  = 'block';
		  }  
		});  
		return false;  
	} else {
		MsgBoxErr("Formato Historia Clínica", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

