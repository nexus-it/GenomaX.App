// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";
var nxs_cdn="https://cdn.genomax.app/";

function haySession() {
	/*$.ajax({  
	  type: "POST",  
	  url: Funciones,  
	  data: "Func=haySession",  
	  success: function(respuesta) { 
		//alert (respuesta.indexOf("message_ok"));
	  	//MsgBox1("sdss", respuesta); 
	  }  
	});  
	return false; */
}
// Cargar ventana modal con las opciones para crear o unirse a una vide conferencia
function nxs_meet1(modo ) {
	$("#bodyMeet").load("application/forms/nxs_meet.php?modo="+modo);	
}

// Cargar nueva ventana con el canal escogido
function nxs_meet2(channel) {
	window.open("http://meet.nexus-it.co/?channel="+channel, "Iniciando Canal...", "width=800, height=600")
}

function nxs_chkd(namex) {
	if (document.getElementById('hdn_'+namex).value=="1") {
		document.getElementById('hdn_'+namex).value='0';
	} else {
		document.getElementById('hdn_'+namex).value='1';
	}
}

function calcDV(thenit, thedv) {
	// Verificar que haya un numero
	let nit = document.getElementById(thenit).value;
	let isNitValid = nit >>> 0 === parseFloat(nit) ? true : false; // Validate a positive integer
	
	// Se limpia el Nit
	nit = nit.replace ( /\s/g, "" ) ; // Espacios
	nit = nit.replace ( /,/g,  "" ) ; // Comas
	nit = nit.replace ( /\./g, "" ) ; // Puntos
	nit = nit.replace ( /-/g,  "" ) ; // Guiones

	// Si es un número se calcula el Dígito de Verificación
	if ( isNitValid ) {
		let inputDigVerificacion = document.getElementById(thedv);
		inputDigVerificacion.value = calcularDigitoVerificacion (nit);
	}
}
function  calcularDigitoVerificacion ( myNit )  {
	var vpri,
		x,
		y,
		z;
	
	// Se valida el nit
	if  ( isNaN ( myNit ) )  {
	  console.log ("El nit/cédula '" + myNit + "' no es válido(a).") ;
	  return "" ;
	};
	
	// Procedimiento
	vpri = new Array(16) ; 
	z = myNit.length ;
  
	vpri[1]  =  3 ;
	vpri[2]  =  7 ;
	vpri[3]  = 13 ; 
	vpri[4]  = 17 ;
	vpri[5]  = 19 ;
	vpri[6]  = 23 ;
	vpri[7]  = 29 ;
	vpri[8]  = 37 ;
	vpri[9]  = 41 ;
	vpri[10] = 43 ;
	vpri[11] = 47 ;  
	vpri[12] = 53 ;  
	vpri[13] = 59 ; 
	vpri[14] = 67 ; 
	vpri[15] = 71 ;
  
	x = 0 ;
	y = 0 ;
	for  ( var i = 0; i < z; i++ )  { 
	  y = ( myNit.substr (i, 1 ) ) ;
	  // console.log ( y + "x" + vpri[z-i] + ":" ) ;
  
	  x += ( y * vpri [z-i] ) ;
	  // console.log ( x ) ;    
	}
  
	y = x % 11 ;
	// console.log ( y ) ;
  
	return ( y > 1 ) ? 11 - y : y ;
  }
function printwndw(elemento0, titulo) {
  var elemento = document.querySelector("#"+elemento0);
  var ventana = window.open('', 'PRINT', 'height=400,width=600');
  ventana.document.write('<html><head><title>'+titulo+'</title>');
  // ventana.document.write('<link rel="stylesheet" href="imprimir.css">'); 
  ventana.document.write('<link rel="stylesheet" href="themes/ghenx/bower_components/bootstrap/dist/css/bootstrap.min.css">'); 
  ventana.document.write('<link rel="stylesheet" href="themes/ghenx/css/genomax_style.css">'); 
  ventana.document.write('</head><body >');
  ventana.document.write(elemento.innerHTML);
  ventana.document.write('</body></html>');
  ventana.document.close();
  ventana.focus();
  ventana.onload = function() {
    ventana.print();
    ventana.close();
  };
  return true;
}

function NxsCanvasEdit(titulo, destino, retorno, ventana) {
	CargarWind(titulo, 'forms/nxs_canvas.php?nxstrgt='+destino, 'image_edit.png', retorno, ventana );
}


function VerificarF5()
{
var tecla=window.event.keyCode;
if (tecla==116) {MsgBox1('Atención','Tecla F5 deshabilitada!');
event.keyCode=0;
event.returnValue=false;}
}

function New_Reset(Ventana) {
	Ventana="zWind_"+Ventana;
	$("#frm_form"+Ventana)[0].reset();
	/* $(":input:text:visible:first", "#frm_form"+Ventana).focus(); */
}

function nxs_sleep(milliseconds) {
  var start = new Date().getTime();
  for (var i = 0; i < 1e7; i++) {
    if ((new Date().getTime() - start) > milliseconds){
      break;
    }
  }
}

function addPreTurno(Ventana, Sede, ContaSedes) {
	$.ajax({  
	  type: "POST",  
	  url: Transact +"preturnos.php",  
	  data: "Func=preturnos&"+RecorrerForm($("#frm_form"+Ventana)),  
	  success: function(respuesta) { 
		//alert (respuesta.indexOf("message_ok"));
	  	MsgBox1("Control de Turnos", respuesta); 
		if (respuesta.indexOf("correctamente")>10) {
			AbrirForm('application/forms/turnos_all.php', Ventana, '&sede='+Sede+'&contasedes='+ContaSedes);					
		}
	  }  
	});  
	return false;  
}

function CallTurno(PreTri, Modulo, Paciente) {
	$.get(Updates,{'Func':'CallTurno','value':PreTri,'mod':Modulo},function(data){
		MsgBox1("Control de Turno", data);
	});
}


function addPreTriage(Ventana, Sede, ContaSedes) {
	$.ajax({  
	  type: "POST",  
	  url: Transact +"pretriage.php",  
	  data: "Func=pretriage&"+RecorrerForm($("#frm_form"+Ventana)),  
	  success: function(respuesta) { 
		//alert (respuesta.indexOf("message_ok"));
	  	MsgBox1("Control Triage", respuesta); 
		if (respuesta.indexOf("correctamente")>10) {
			AbrirForm('application/forms/pretriage.php', Ventana, '&sede='+Sede+'&contasedes='+ContaSedes);					
		}
	  }  
	});  
	return false;  
}

function RefreshTriage(Ventana, Tipo, Valor) {
	if ($('#tbDetalle'+Ventana).length) {
		$.get(Funciones,{'Func':'RefreshTriage','tipo':Tipo,'value':Valor,'ventana':Ventana},function(data){
			document.getElementById('tbDetalle'+Ventana).innerHTML=data;
		});
	} 
}

function RefreshListaTriage(Ventana, Modulo) {
	$.get(Funciones,{'Func':'RefreshListaTriage','ventana':Ventana, 'value': Modulo},function(data){
		document.getElementById('tbDetalleX'+Ventana).innerHTML=data;
	});
	$.get(Funciones,{'Func':'ReCallListaTriage','ventana':Ventana, 'value': Modulo},function(data){
		document.getElementById('tbDetalleY'+Ventana).innerHTML=data;
	});
}

function closetrg(PreTri, Modulo) {
	$.get(Updates,{'Func':'closetrg','value':PreTri,'mod':Modulo},function(data){
		MsgBox1("Atención de Urgencias", "Paciente en turno de atención");
	});
}

function BackCallTRG(PreTri) {
	$.get(Updates,{'Func':'BackCallTRG','value':PreTri},function(data){
		MsgBox1("Llamado de pacientes", "Paciente se volvió a llamar");
	});
}

function CallTriage(PreTri, Modulo, Paciente) {
	$.get(Updates,{'Func':'CallTriage','value':PreTri,'mod':Modulo},function(data){
		CargarForm('application/forms/hctriage.php?Area='+Modulo+'&pre='+PreTri+'&Historia='+Paciente, 'Clasificar Triage', 'table_heatmap.png');
	});
}

function ShowNotes() {
	$.get(Funciones,{'Func':'ContaNotas'},function(data){ 
		document.getElementById('NumNts').innerHTML=data;
	});
	$.get(Funciones,{'Func':'ShowNotas'},function(data){ 
		document.getElementById('gx_Notes').innerHTML=data;
	});
}

function deletenote(LaNota){
	xError="";
	if (document.getElementById('txt_AddNewNote').value==''){
		xError="No se ha digitado una nueva nota.";}
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"deletenote.php",   
		  data: "Func=deletenote&Note="+LaNota,  
		  success: function(respuesta) { 
		  	$("#frm_login"+Ventana)[0].reset();
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
	}
	alert(LaNota);
}
	
function showNewNote() {
	$('#AddNewNote').toggle();
	$('#btn_AddNote').toggle();
}

function RecorrerForm(miForm) {
var FormPost="";
var Var1="";
$(':input', miForm).each(function() {
	Var1=this.name;
	Var1=Var1.substring(4,Var1.indexOf('zW'));
	FormPost=FormPost+Var1+"="+this.value.toUpperCase()+"&";
});
FormPost=String(FormPost).substring(0,String(FormPost).length-1)
return FormPost;
}

function RecorrerForm2(miForm) {
var FormPost="";
var Var1="";
$(':input', miForm).each(function() {
	Var1=this.name;
	Var1=Var1.substring(0,Var1.indexOf('zW'));
	FormPost=FormPost+Var1+"="+this.value.toUpperCase()+"&";
});
FormPost=String(FormPost).substring(0,String(FormPost).length-1)
console.log(FormPost);
return FormPost;
}

function RecorrerFormPass(miForm) {
var FormPost="";
var Var1="";
$(':input', miForm).each(function() {
	Var1=this.name;
	Var1=Var1.substring(4,Var1.indexOf('zW'));
	FormPost=FormPost+Var1+"="+this.value+"&";
});
FormPost=String(FormPost).substring(0,String(FormPost).length-1)
return FormPost;
}

function DiaSemana(fecha) {
	fecha=fecha.split('/');  
    if(fecha.length!=3){  
            return null;  
    }  
    var regular =[0,3,3,6,1,4,6,2,5,0,3,5];   
    var bisiesto=[0,3,4,0,2,5,0,3,6,1,4,6];   
    var semana=['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];  
    var dia=fecha[0];  
    var mes=fecha[1]-1;  
    var anno=fecha[2];  
    if((anno % 4 == 0) && !(anno % 100 == 0 && anno % 400 != 0))  
        mes=bisiesto[mes];  
    else  
        mes=regular[mes];  
    return semana[Math.ceil(Math.ceil(Math.ceil((anno-1)%7)+Math.ceil((Math.floor((anno-1)/4)-Math.floor((3*(Math.floor((anno-1)/100)+1))/4))%7)+mes+dia%7)%7)]; 
}

function NombreMes(fecha) {
	fecha=fecha.split('/');  
	if(fecha.length!=3){  
        return null;  
    }
	var meses=["Enero", "Febrero", "Marzo","Abril","Mayo", "Junio","Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
	var mes=fecha[1]-1;  
	return meses[mes];
}

function ShowHide(Div1, Div2) 
{
	document.getElementById(Div1).style.visibility=block;
	document.getElementById(Div2).style.visibility=none;
}

function authsecure(ni)
{	
	//document.getElementById("hdn_ni0").value=hex_md5("901073245-9");
	$.get(Funciones,{'Func':'authsecure','ni':hex_md5(ni)},function(data){ 
		document.getElementById("hdn_ni0").value=hex_md5(data);
		nishal=document.getElementById("hdn_ni0").value;
		nisha2=$("#hdn_sha1").val();
		if (nishal==hex_md5(nisha2)) {
			a=1+1;
		} else {
			/*alert ("Licencia no válida");
			var div1 = document.getElementById('dvlgn');
			div1.style.visibility = 'hidden';
			div1.style.height= '0px';
			var div2 = document.getElementById('dvauth');
			div2.style.visibility = 'visible';*/
		}
	}); 
}

function ExtraerImagen(Destino, Value, Campo, Div)
{
	$.get(Funciones,{'Func':'ExtraerImagen','value':Value, 'campo':Campo},function(data){ 
		document.getElementById(Destino).innerHTML=data;
	}); 
}

function NombreTercero(Ventana, Codigo, tabla)
{
	$.get(Funciones,{'Func':'NombreTercero','value':Codigo, 'tabla':tabla},function(data){ 
		if (data=="No se encuentra el tercero") {
			swal('DOCUMENTO NO SE ENCUENTRA', data,'error');
			document.getElementById('txt_paciente2'+Ventana).value="";
		} else {
			document.getElementById('txt_paciente2'+Ventana).value=data;
		}
	}); 
}

function EpsPcte(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'EpsPcte','value':Codigo},function(data){ 
		if (data=="No se encuentra el tercero") {
			document.getElementById('txt_Contrato'+Ventana).value="";
		} else {
			document.getElementById('txt_Contrato'+Ventana).value=data;
		}
	}); 
}

function EpsPcteCont(Ventana, Codigo)
{
	document.getElementById('txt_Contrato'+Ventana).value="";
	$.get(Funciones,{'Func':'EpsPcte','value':Codigo},function(data){ 
		if (data!="No se encuentra el tercero") {
			document.getElementById('txt_Contrato'+Ventana).value=data;
			CodCont=document.getElementById('txt_Contrato'+Ventana).value;
			NombreContratoPlan(Ventana, CodCont);
		}
	}); 
}

function AcompPcte(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'AcompPcte','value':Codigo,'Ventana':Ventana},function(data){ 
		if (data!="") {
			eval(data);
		}
	}); 
}

function NxsToolBar(NomWind,NombrePag) 
{
	$.get(Funciones,{'Func':'NxsToolBar','NombrePag':NombrePag, 'NumeroPag':NumeroPag},function(data){ 
		eval(data);
	}); 
}

function PlanPcte(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'PlanPcte','value':Codigo},function(data){ 
		if (data="No se encuentra el tercero") {
			document.getElementById('txt_Plan'+Ventana).value="";
		} else {
			document.getElementById('txt_Plan'+Ventana).value=data;
		}
	}); 
}

function NombreEPS(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreEPS','value':Codigo},function(data){ 
		document.getElementById('lbl_eps'+Ventana).innerHTML=data;
	}); 
}

function NombreTarifa(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreTarifa','value':Codigo},function(data){ 
		document.getElementById('lbl_tarifanom'+Ventana).value=data;
		document.getElementById('ManTarif'+Ventana).innerHTML=data;
	}); 
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

function BuscarPerfilX(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombrePerfil','value':Codigo},function(data){ 
		document.getElementById('txt_nombreperfilx'+Ventana).value=data;
	}); 
}

function NombreServicioX(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreServicio','value':Codigo},function(data){ 																	  
		document.getElementById('lbl_servicionom'+Ventana).value=data;
		document.getElementById('txt_valor'+Ventana).focus();
	}); 
}

function NombreAreaHC(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreAreaHC','value':Codigo},function(data){ 
		document.getElementById('lbl_areahc'+Ventana).innerHTML=data;
	}); 
}

function NombreUsuariox(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreUsuariox','value':Codigo},function(data){ 
		document.getElementById('txt_descripcionx'+Ventana).value=data;
	}); 
}

function cargarcuentaslote(Ventana) {

	xError="";
	if (document.getElementById('txt_Contrato'+Ventana).value=="") {
		xError="Digite el código del contrato de las facturas a cargar.";}
	if (document.getElementById('txt_fechaini'+Ventana).value=="") {
		xError="Digite la fecha inicial del rango de facturas.";}
	if (document.getElementById('txt_fechafin'+Ventana).value=="") {
		xError="Digite la fecha final del rango de facturas.";}
	//Ejecucion de las intrucciones para guardar los registros
	FechaFin=document.getElementById('txt_fechafin'+Ventana).value;
	FechaIni=document.getElementById('txt_fechaini'+Ventana).value;
	Plan=document.getElementById('txt_Plan'+Ventana).value;
	Eps=document.getElementById('txt_Contrato'+Ventana).value;
	Sede=document.getElementById('txt_sede'+Ventana).value;
	orden=document.getElementById('hdn_ordenar'+Ventana).value;
	document.getElementById('txt_cantidad'+Ventana).value='0';
	document.getElementById('hdn_total'+Ventana).value='0';
	document.getElementById('hdn_total'+Ventana).value='0';
	if (xError=="") {
		$.get(Funciones,{'Func':'CargarFactLote','fechaini':FechaIni,'orden':orden,'fechafin':FechaFin,'codigopla':Plan,'codigoeps':Eps,'codigoafc':Sede,'value':Ventana},function(data){ 
			document.getElementById('zero_detalle'+Ventana).innerHTML=data;
		}); 
	} else {
		MsgBox1("Error", xError);
	}

}

function cargarcuentascapita(Ventana) {

	xError="";
	if (document.getElementById('txt_fechaini'+Ventana).value=="") {
		xError="Digite la fecha inicial del rango.";}
	if (document.getElementById('txt_fechafin'+Ventana).value=="") {
		xError="Digite la fecha final del rango.";}
	//Ejecucion de las intrucciones para guardar los registros
	FechaFin=document.getElementById('txt_fechafin'+Ventana).value;
	FechaIni=document.getElementById('txt_fechaini'+Ventana).value;
	Plan=document.getElementById('txt_Plan'+Ventana).value;
	Eps=document.getElementById('txt_Contrato'+Ventana).value;
	Sede=document.getElementById('txt_sede'+Ventana).value;
	if (xError=="") {
		$.get(Funciones,{'Func':'CargarFactCapita','fechaini':FechaIni,'fechafin':FechaFin,'codigopla':Plan,'codigoeps':Eps,'codigoafc':Sede,'value':Ventana},function(data){ 
			document.getElementById('zero_detalle'+Ventana).innerHTML=data;
		}); 
	} else {
		MsgBox1("Error", xError);
	}

}

function cargarcuentasgrupal(Ventana) {

	xError="";
	if (document.getElementById('txt_fechaini'+Ventana).value=="") {
		xError="Digite la fecha inicial del rango.";}
	if (document.getElementById('txt_fechafin'+Ventana).value=="") {
		xError="Digite la fecha final del rango.";}
	//Ejecucion de las intrucciones para guardar los registros
	FechaFin=document.getElementById('txt_fechafin'+Ventana).value;
	FechaIni=document.getElementById('txt_fechaini'+Ventana).value;
	Plan=document.getElementById('txt_Plan'+Ventana).value;
	Eps=document.getElementById('txt_Contrato'+Ventana).value;
	Sede=document.getElementById('txt_sede'+Ventana).value;
	if (xError=="") {
		$.get(Funciones,{'Func':'CargarFactGrupal','fechaini':FechaIni,'fechafin':FechaFin,'codigopla':Plan,'codigoeps':Eps,'codigoafc':Sede,'value':Ventana},function(data){ 
			document.getElementById('zero_detalle'+Ventana).innerHTML=data;
		}); 
	} else {
		MsgBox1("Error", xError);
	}

}

function ExecSearch(Valor, Criterio, Campo, Query, Cond)
{
	if (Valor!="") {
		switch(Criterio)
		{
			case "igual":
				sql=Campo+"='"+Valor+"'";
			break;
			case "contenga":
				sql=Campo+" like '%"+Valor+"%'";
			break;
			case "empiece":
				sql=Campo+" like '"+Valor+"%'";
			break;
			case "finalice":
				sql=Campo+" like '%"+Valor+"'";
			break;
			case "diferente":
				sql=Campo+" <> '"+Valor+"'";
			break;
			case "notenga":
				sql=Campo+" not like '%"+Valor+"%'";
			break;
		}
		sql=sql+" order by "+Campo;
	} else {
		sql="NULL";
	}
	//document.getElementById('resultadosNxs').innerHTML="  :: Un momento por favor...";
	$.get(Funciones,{'Func':'ExecSearch','value':sql, 'req':Query, 'cond':Cond},function(data){	 
		document.getElementById('resultadosNxs').innerHTML=data;
	}); 
}

function AcceptOk(Origen, Destino){
	if (document.getElementById(Origen).value!=''){
	document.getElementById(Destino).value=document.getElementById(Origen).value;	
	}
	document.getElementById(Destino).focus();
}

function AcceptPass(Ventana){
	xError="";
	if (document.getElementById('txt_pass2'+Ventana).value!=document.getElementById('txt_pass'+Ventana).value){
		xError="La nueva contraseña no coincide con su confirmacion.";}
	if (document.getElementById('txt_pass2'+Ventana).value==''){
		xError="Confirme la nueva contraseña.";}
	if (document.getElementById('txt_pass'+Ventana).value==''){
		xError="Digite la nueva contraseña.";}
	if (document.getElementById('txt_clave'+Ventana).value==''){
		xError="Digite la contraseña actual.";}
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"clave.php",  
		  data: "Func=clave&"+RecorrerFormPass($("#frm_login"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Cambio de Clave", respuesta);
				$("#frm_login"+Ventana)[0].reset();
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
	}
  }

function ComprobarClave(Ventana, Codigo, Tema)
{
	$.get(Funciones,{'Func':'ComprobarClave','value':hex_md5(Codigo)},function(data){ 
		var ObjetoX=document.getElementById("pw_actual"+Ventana);
		var resultado=data.toString;
		if (parseInt(data)==1) {
			ObjetoX.style.backgroundImage="url(themes/"+Tema+"/img/pw_green.png)";
			ObjetoX.style.borderColor="#006600";		
			ObjetoX.innerHTML="CORRECTA";	
		}
		else
		{
			ObjetoX.style.backgroundImage="url(themes/"+Tema+"/img/pw_red.png)";
			ObjetoX.style.borderColor="#990000";	
			ObjetoX.innerHTML="INCORRECTA";	
		}
		ObjetoX.style.color=ObjetoX.style.borderColor;
	}); 
}

function NombreContrato(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreContrato','value':Codigo},function(data){ 
		document.getElementById('txt_NombreEPS'+Ventana).value=data;
	}); 
}

function NombreContratoPlan(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreContrato','value':Codigo},function(data){ 
		document.getElementById('txt_NombreEPS'+Ventana).value=data;
		CargarPlan(Ventana, Codigo);
	}); 
}

function NumeroContrato(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NumeroContrato','value':Codigo},function(data){ 
		document.getElementById('txt_numcontrato'+Ventana).value=data;
	}); 
}

function NombreCama(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreCama','value':Codigo},function(data){ 
		document.getElementById('lbl_cama'+Ventana).innerHTML=data;
	}); 
}

function NombreDiagnostico(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreDiagnostico','value':Codigo},function(data){ 
		document.getElementById('txt_NombreDx'+Ventana).value=data;
	}); 
}

function NombreDx(Codigo, Inputx)
{
	$.get(Funciones,{'Func':'NombreDiagnostico','value':Codigo},function(data){ 
		Inputx.value= data;
	});
}

function NombreDpto(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreDpto','value':Codigo},function(data){ 
		document.getElementById('txt_NombreDepto'+Ventana).value=data;
	}); 
}

function NombreEmple(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreEmple','value':Codigo},function(data){ 
		document.getElementById('txt_responsable'+Ventana).value=data;
	}); 
}

function NombreEmple2(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'NombreEmple','value':Codigo},function(data){ 
		document.getElementById('txt_nomemple'+Ventana).value=data;
	}); 
}

function NombreMUN(Ventana, Codigo, Codigo2)
{
	$.get(Funciones,{'Func':'NombreMUN','value':Codigo, 'value2':Codigo2},function(data){ 
		document.getElementById('txt_NombreMnpio'+Ventana).value=data;
	}); 
}

function CargarMun(Ventana, Codigo, Muni)
{
	$.get(Funciones,{'Func':'CargarMun','value':Codigo},function(data){ 
		document.getElementById('txt_Municipio'+Ventana).innerHTML=data;
		if (Muni!='') {
			document.getElementById('txt_Municipio'+Ventana).value=Muni;
		}
	}); 
}
function CargarPlan(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'CargarPlan','value':Codigo},function(data){ 
		document.getElementById('txt_Plan'+Ventana).innerHTML=data;
	}); 
}
function CargarPlanR(Ventana, Codigo)
{
	$.get(Funciones,{'Func':'CargarPlanR','value':Codigo},function(data){ 
		document.getElementById('txt_Plan'+Ventana).innerHTML=data;
	}); 
}
function CargarMedicosCx(Ventana, Area, Fecha)
{
	$.get(Funciones,{'Func':'CargarMedicosCx','area':Area,'fecha':Fecha},function(data){ 
		document.getElementById('cmb_medico'+Ventana).innerHTML=data;
		var Medico = document.getElementById('cmb_medico'+Ventana).options[0].value ;
		FillAgenda(Ventana, Medico, Fecha, Area)
	}); 	
}

function CargarMedicosCxR(Ventana, Area, Fecha)
{
	$.get(Funciones,{'Func':'CargarMedicosCx','area':Area,'fecha':Fecha},function(data){ 
		document.getElementById('cmb_medico'+Ventana).innerHTML=data;
		var Medico = document.getElementById('cmb_medico'+Ventana).options[0].value ;
		FillAgendaR(Ventana, Medico, Fecha, Area)
	}); 	
}

function FormatoFecha(fecha){ 
	NewFecha=fecha.split("-");
	var dia = NewFecha[2];
  	var mes = NewFecha[1];
  	var anio = NewFecha[0];
	return (dia)+"/"+(mes)+"/"+(anio); 
} 

function ConfirmarCita(Cita, Nota, Ventana)
{
	$.ajax({  
	  type: "POST",  
	  url: Transact + "confirmarcita.php",  
	  data: "Func=confirmarcita&cita="+Cita+"&nota="+Nota,  
	  success: function(respuesta) { 
	  	MsgBox1("Confirmacion de Citas", respuesta);
	  	eval( 'RefreshCitas'+Ventana +'()' );
	  }  
	});
}

function AbrirCaja(Caja)
{
	$.ajax({  
	  type: "POST",  
	  url: Transact +"abrircaja.php",  
	  data: "Func=abrircaja&caja="+Caja,  
	  success: function(respuesta) { 
	  	MsgBox1("Apertura de Caja", respuesta);
	  }  
	});
}

function AtenderCita(Cita, Ventana)
{
	$.ajax({  
	  type: "POST",  
	  url: Transact +"atendercita.php",  
	  data: "Func=atendercita&cita="+Cita,  
	  success: function(respuesta) { 
	  	eval( 'RefreshCts'+Ventana +'()' );
	  }  
	});
}

function FillConfCitas(Ventana, Paciente, Fecha)
{
	$.get(Funciones,{'Func':'FillConfCitas','paciente':Paciente,'fecha':Fecha,'ventana':Ventana},function(data){ 
		document.getElementById('tbDetallemar'+Ventana).innerHTML=data;
	}); 	
}

function FillCitasAtencion(Ventana, Paciente, Fecha)
{
	$.get(Funciones,{'Func':'FillCitasAtencion','paciente':Paciente,'fecha':Fecha,'ventana':Ventana},function(data){ 
		document.getElementById('tbDetallemar'+Ventana).innerHTML=data;
	}); 	
}

function FillAgenda(Ventana, Medico, Fecha, Area)
{
	$.get(Funciones,{'Func':'FillAgenda','medico':Medico,'fecha':Fecha,'area':Area,'ventana':Ventana},function(data){ 
		document.getElementById('tbDetallemar'+Ventana).innerHTML=data;
	}); 	
}

function FillAgendaR(Ventana, Medico, Fecha, Area)
{
	$.get(Funciones,{'Func':'FillAgendaR','medico':Medico,'fecha':Fecha,'area':Area,'ventana':Ventana},function(data){ 
		document.getElementById('tbDetallemar'+Ventana).innerHTML=data;
	}); 	
}

function FillAgendaNo(Ventana, Servicio, Fecha1, Medico, Paciente, Fecha2)
{
	$.get(Funciones,{'Func':'FillAgendaNo','paciente':Paciente,'servicio':Servicio,'medico':Medico,'fecha1':Fecha1,'fecha2':Fecha2,'ventana':Ventana},function(data){ 
		document.getElementById('tbDetCitas'+Ventana).innerHTML=data;
	}); 	
}

function CloseSession(Enterprise)
{
	window.location.href="functions/php/nexus/nosession.php"+Enterprise;
}

function NombreEmpresa(Codigo)
{
	$.get(Funciones,{'Func':'NombreEmpresa','value':Codigo},function(data){ 
		document.getElementById('razonsocial').innerHTML=data;
	}); 
}

function NEmpresa(Ventana)
{
	var Nempresa="-";
	$.get(Funciones,{'Func':'NombreEmpresa','value':Ventana},function(data){ 
		document.getElementById('Nempresa'+Ventana).innerHTML=data;
	}); 
}

function InsertarHTML(Control, Codigo)
{
	document.getElementById(Control).innerHTML=Codigo;
}

function Guardar_usuarios(Ventana)
{
	xError="";
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "usuarios.php",  
		  data: "Func=usuarios&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Usuarios", respuesta); 
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", '<div class="message_alert"></div>'+xError);
	}
}

function Guardar_ctinterface(Ventana)
{
	xError="";
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "ctinterface.php",  
		  data: "Func=ctinterface&"+RecorrerForm2($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Interface Contable", respuesta); 
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", '<div class="message_alert"></div>'+xError);
	}
}

function Guardar_lbordenes(Ventana)
{
	xError="";
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "lbordenes.php",  
		  data: "Func=lbordenes&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Exámenes", respuesta); 
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
	}
}

function Guardar_pacientesmod(Ventana)
{
	NomGuardar="Guardar"+Ventana;
	xError="";
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_Barrio'+Ventana).value=="") {
		xError="Digite el barrio del paciente.";}
	if (document.getElementById('txt_Direccion'+Ventana).value=="") {
		xError="Digite la direccion del paciente.";}
	if (document.getElementById('txt_Municipio'+Ventana).value=="") {
		xError="Digite el municipio del paciente.";}
	if (document.getElementById('txt_Departamento'+Ventana).value=="") {
		xError="Digite el departamento del paciente.";}
	if (document.getElementById('txt_fechanac'+Ventana).value=="") {
		xError="Digite la fecha de nacimiento del paciente.";}
	if (document.getElementById('cmb_Contrato'+Ventana).value=="") {
		xError="Digite el contrato del paciente.";}
	if (document.getElementById('txt_apellido1'+Ventana).value=="") {
		xError="Digite el apellido del paciente.";}
	if (document.getElementById('txt_nombre1'+Ventana).value=="") {
		xError="Digite el nombre del paciente.";}
	if (document.getElementById('txt_idpaciente'+Ventana).value=="") {
		xError="No se encuentra el Id del paciente.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "pacientes.php",  
		  data: "Func=pacientes&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Pacientes", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
				$("#frm_form"+Ventana)[0].reset();
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
	}
}

function Guardar_pacientes(Ventana)
{
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	xError="";
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_Barrio'+Ventana).value=="") {
		xError="Digite el barrio del paciente.";}
	if (document.getElementById('txt_Direccion'+Ventana).value=="") {
		xError="Digite la direccion del paciente.";}
	if (document.getElementById('txt_Municipio'+Ventana).value=="") {
		xError="Digite el municipio del paciente.";}
	if (document.getElementById('txt_Departamento'+Ventana).value=="") {
		xError="Digite el departamento del paciente.";}
	if (document.getElementById('txt_fechanac'+Ventana).value=="") {
		xError="Digite la fecha de nacimiento del paciente.";}
	if (document.getElementById('cmb_Contrato'+Ventana).value=="") {
		xError="Digite el contrato del paciente.";}
	if (document.getElementById('txt_apellido1'+Ventana).value=="") {
		xError="Digite el apellido del paciente.";}
	if (document.getElementById('txt_nombre1'+Ventana).value=="") {
		xError="Digite el nombre del paciente.";}
	if (document.getElementById('txt_expedicion'+Ventana).value=="") {
		xError="Digite el lugar de expedicion del documento.";}
	if (document.getElementById('txt_idpaciente'+Ventana).value=="") {
		xError="No se encuentra el Id del paciente.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "pacientes.php",  
		  data: "Func=pacientes&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Pacientes", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
				$("#frm_form"+Ventana)[0].reset();
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function FechaActual(Destino)
{
	$.get(Funciones,{'Func':'FechaActual'},function(data){ 
		vfec=data;
		document.getElementById(Destino).value=vfec;
	}); 
}

function HoraActual(Destino)
{
	$.get(Funciones,{'Func':'HoraActual'},function(data){ 
		document.getElementById(Destino).value=data;
	}); 
}

function ListadoPlanes(Destino)
{
	$.get(Funciones,{'Func':'ListadoPlanes'},function(data){ 
		document.getElementById(Destino).innerHTML=data;
	}); 
}

function IngresosAbiertos(Ventana) {
	idpte=document.getElementById('txt_paciente'+Ventana).value;
	$.get(Funciones,{'Func':'IngresosAbiertos','value':idpte},function(data){ 
	document.getElementById('txt_paciente'+Ventana).value=idpte;
		if (parseInt(data)==0) {
			FechaActual('txt_fechaadm'+Ventana);
			HoraActual('txt_horaadm'+Ventana);
		} else {
			if (parseInt(data)==1) {
				MsgBox1("Atencion", 'El paciente ya posee un ingreso abierto');
			} else {
				MsgBox1("Atencion", 'El paciente posee '+data+' ingresos abiertos');
			}
		}
		ContratoPte(Ventana);
	}); 
}

function nxscurrency(value, decimals, separators) {
    decimals = decimals >= 0 ? parseInt(decimals, 0) : 2;
    separators = separators || ['.', "'", ','];
    var number = (parseFloat(value) || 0).toFixed(decimals);
    if (number.length <= (4 + decimals))
        return number.replace('.', separators[separators.length - 1]);
    var parts = number.split(/[-.]/);
    value = parts[parts.length > 1 ? parts.length - 2 : 0];
    var result = value.substr(value.length - 3, 3) + (parts.length > 1 ?
        separators[separators.length - 1] + parts[parts.length - 1] : '');
    var start = value.length - 6;
    var idx = 0;
    while (start > -3) {
        result = (start > 0 ? value.substr(start, 3) : value.substr(0, 3 + start))
            + separators[idx] + result;
        idx = (++idx) % 2;
        start -= 3;
    }
    return (parts.length == 3 ? '-' : '') + result;
}

function klcalculo(plan, edad, modalidad, dias, ventana) {
	$.get(Funciones,{'Func':'KlCalculo','plan':plan, 'edad':edad, 'modalidad':modalidad, 'dias': dias, 'mas18': mas18, 'menos18': menos18},function(data){ 
		document.getElementById('txt_dolares'+ventana).value=data;
		document.getElementById('hdn_dolares0'+ventana).value=data;
		eval( 'CalcTRM'+ventana + '()' );
	})
}

function NombreServicioDx(Valor, Ventana)
{
	$.get(Funciones,{'Func':'NombreServicio','value':Valor},function(data){ 																	  
		document.getElementById('txt_serviciodx'+Ventana).value=data;
		document.getElementById('txt_cantservdx'+Ventana).value='1';
		document.getElementById('txt_cantservdx'+Ventana).focus();
	}); 
}

function NombreServicioQx(Valor, Ventana)
{
	$.get(Funciones,{'Func':'NombreServicio','value':Valor},function(data){ 																	  
		document.getElementById('txt_servicioqx'+Ventana).value=data;
		document.getElementById('txt_cantservqx'+Ventana).value='1';
		document.getElementById('txt_cantservqx'+Ventana).focus();
	}); 
}

function NombreServicioCons(Valor, Ventana)
{
	$.get(Funciones,{'Func':'NombreServicio','value':Valor},function(data){ 																	  
		document.getElementById('txt_serviciocons'+Ventana).value=data;
		document.getElementById('txt_cantservcons'+Ventana).value='1';
		document.getElementById('txt_cantservcons'+Ventana).focus();
	}); 
}

function NombreMedicamento(Valor, Ventana) {
	$.get(Funciones,{'Func':'NombreServicio','value':Valor},function(data){ 
		document.getElementById('txt_medicamento'+Ventana).value=data;
		DosisMedicamento(Valor, Ventana);
		UnidadMedicamento(Valor, Ventana);
		ViaMedicamento(Valor, Ventana);
		if (document.getElementById("txt_dosis"+Ventana).value=="") {
			document.getElementById("txt_dosis"+Ventana).focus();
		} else {
			document.getElementById("cmb_frecuencia"+Ventana).focus();
		}
	})
}

function DosisMedicamento(Valor, Ventana) {
	$.get(Funciones,{'Func':'DosisMedicamento','value':Valor},function(data){ 
		document.getElementById('txt_dosis'+Ventana).value=data;
		document.getElementById('hdn_dosish'+Ventana).value=data;
	})
}

function UnidadMedicamento(Valor, Ventana) {
	$.get(Funciones,{'Func':'UnidadMedicamento','value':Valor},function(data){ 
		document.getElementById('cmb_unidad'+Ventana).value=data;
	})
}

function ViaMedicamento(Valor, Ventana) {
	$.get(Funciones,{'Func':'ViaMedicamento','value':Valor},function(data){ 
		document.getElementById('cmb_via'+Ventana).value=data;
	})
}

function NombreServicio(Valor, Ventana) {
	$.get(Funciones,{'Func':'NombreServicio','value':Valor},function(data){ 
		document.getElementById('txt_nombreserv'+Ventana).value=data;
		$.get(Funciones,{'Func':'CodigoServicio','value':Valor},function(data){ 
			document.getElementById('hdn_codigox'+Ventana).value=data;
			document.getElementById("txt_cantidad"+Ventana).focus();
		})
	})
}

function ValorServicio(Valor, Ventana, Eps, Plan) {
	$.get(Funciones,{'Func':'ValorServicio','value':Valor, 'eps':Eps, 'plan':Plan},function(data){ 
		document.getElementById('txt_valorservicio'+Ventana).value=data;
	})
}

function NombreDispositivo(Valor, Ventana) {
	$.get(Funciones,{'Func':'NombreServicio','value':Valor},function(data){ 
		document.getElementById('txt_nombreserv'+Ventana).value=data;
	})
}

function ContratoPte(Ventana) {
	idpte=document.getElementById('txt_paciente'+Ventana).value;
	$.get(Funciones,{'Func':'ContratoPte','value':idpte},function(data){ 
		//document.getElementById('txt_NombreCAMA'+Ventana).value="";
		document.getElementById('txt_NombreDx'+Ventana).value="";
		if (data.substring(2,9)!="Select ") {
			document.getElementById('txt_Contrato'+Ventana).value=data;
			NombreContrato(Ventana, String(data));
			CargarPlan(Ventana, data)
		}
	}); 
}

function Anular_ingresosno(Ventana) {
	xError="";
	Ventana="zWind_"+Ventana;
	if (document.getElementById('txt_Ingreso'+Ventana).value=="") {
		xError="Digite el codigo del ingreso.";}
	if (document.getElementById('hdn_Ingreso'+Ventana).value=="") {
		xError="Numero de ingreso invalido. No se puede anular.";}
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.get(Updates,{'Func':'NoIngresos','value':document.getElementById('txt_Ingreso'+Ventana).value},function(data){ 
				MsgBox1("Ingreso "+document.getElementById('txt_Ingreso'+Ventana).value, data);
		}); 
	} else {
		MsgBox1("Error", xError);
	}
}

function Guardar_ingresos(Ventana)
{
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	xError="";
	xWind=Ventana;
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_Contrato'+Ventana).value=="N/A") {
		xError="Verifique los datos de contrato y plan del paciente.";}
	if (document.getElementById('txt_autorizacion'+Ventana).value=="") {
		xError="Digite el numero de autorizacion.";}
	if (document.getElementById('cmb_TipoIng'+Ventana).value=="H7") {
		if (document.getElementById('txt_ips'+Ventana).value=="") {
			xError="Digite el nombre de la I.P.S. de la cual es remitido el paciente.";}
		if (document.getElementById('txt_fecremision'+Ventana).value=="") {
			xError="Digite la fecha de remision del paciente.";}
		if (document.getElementById('txt_remision'+Ventana).value=="") {
			xError="Digite el numero de remision.";}
		var elemento=document.getElementById('txt_diagnostico'+Ventana);
		if(elemento.required) {
			if (document.getElementById('txt_diagnostico'+Ventana).value=="") {
				xError="Digite el codigo del diagnostico.";}
			if (document.getElementById('txt_NombreDx'+Ventana).value=="No se encuentra el diagnostico") {
				xError="Digite el codigo del diagnostico.";}
		}
		if (document.getElementById('txt_remitido'+Ventana).value=="") {
			xError="Digite el valor remitido.";}
	}
	ClaseHA=document.getElementById('cmb_TipoIng'+Ventana).value;
	if (ClaseHA.substring(0,1)=="H") {
		if (document.getElementById('cmb_hosp'+Ventana).value=="1") {
			if (document.getElementById('cmb_cama'+Ventana).value=="") {
				xError="Digite la cama del paciente.";}
			if (document.getElementById('txt_fechahosp'+Ventana).value=="") {
				xError="Digite la fecha de hospitalizacion del paciente.";}
		}
	}
	if (document.getElementById('txt_Contrato'+Ventana).value=="") {
		xError="Digite el codigo del contrato.";}
	if (document.getElementById('txt_paciente'+Ventana).value=="") {
		xError="Digite la identificacion del paciente.";}
//Revisamos los campos obligatorios
	var x = document.getElementsByClassName("nxs_"+Ventana);
	for (var i=0; i < x.length; i++) {
		var rekerido=x[i].required;
		if (rekerido) {
			var elValor =x[i].value;
			if (elValor=="") {
				xError="Existen campos requeridos sin diligenciar. "+x[i].name;
		        var elID=x[i].id;
		        $("#grp_"+elID).addClass("has-error");
			}
		}
	}
	
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"ingresos.php",  
		  data: "Func=ingresos&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			//alert (respuesta.indexOf("message_ok"));
		  	MsgBox1("Admisiones", respuesta); 
			if (respuesta.indexOf("correctamente")>10) {
				Consecutivo=respuesta.substr(respuesta.length-10,10);
				New_Reset(xWind);
				document.getElementById(NomGuardar).style.display  = 'block';
	
				CargarReport("application/reports/ingresos.php?CODIGO_INICIAL="+Consecutivo+"&CODIGO_FINAL="+Consecutivo, "Ingreso");
			}
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_ingresoscx(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	xWind=Ventana;
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_Contrato'+Ventana).value=="N/A") {
		xError="Verifique los datos de contrato y plan del paciente.";}
	if (document.getElementById('txt_observacion'+Ventana).value=="") {
		xError="Digite una descripcion del ingreso en el campo de observacion.";}
	if (document.getElementById('txt_autorizacion'+Ventana).value=="") {
		xError="Digite el numero de autorizacion.";}
	if (document.getElementById('txt_motivo'+Ventana).value=="") {
		xError="Digite el motivo de la consulta.";}
	if (document.getElementById('cmb_TipoIng'+Ventana).value=="H7") {
		var elemento=document.getElementById('txt_diagnostico'+Ventana);
		if(elemento.required) {
			if (document.getElementById('txt_diagnostico'+Ventana).value=="") {
				xError="Digite el codigo del diagnostico.";}
			if (document.getElementById('txt_NombreDx'+Ventana).value=="No se encuentra el diagnostico") {
				xError="Digite el codigo del diagnostico.";}
		}
	}
	ClaseHA=document.getElementById('cmb_TipoIng'+Ventana).value;
	if (document.getElementById('txt_Contrato'+Ventana).value=="") {
		xError="Digite el codigo del contrato.";}
	if (document.getElementById('txt_paciente'+Ventana).value=="") {
		xError="Digite la identificacion del paciente.";}
//Revisamos los campos obligatorios
	var x = document.getElementsByClassName("nxs_"+Ventana);
	for (var i=0; i < x.length; i++) {
		var rekerido=x[i].required;
		if (rekerido) {
			var elValor =x[i].value;
			if (elValor=="") {
				xError="Existen campos requeridos sin diligenciar. "+x[i].name;
		        var elID=x[i].id;
		        $("#grp_"+elID).addClass("has-error");
			}
		}
	}
	
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"ingresos.php",  
		  data: "Func=ingresos&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			//alert (respuesta.indexOf("message_ok"));
		  	MsgBox1("Admisiones", respuesta); 
			if (respuesta.indexOf("correctamente")>10) {
				Consecutivo=respuesta.substr(respuesta.length-10,10);
				ElPte=document.getElementById('txt_paciente'+Ventana).value;
				New_Reset(xWind);
				document.getElementById(NomGuardar).style.display  = 'block';
	
				CargarReport("application/reports/ingresos.php?CODIGO_INICIAL="+Consecutivo+"&CODIGO_FINAL="+Consecutivo, "Ingreso");
				CargarForm('application/forms/cajasmov.php?ElMov=RC&ElTipIng=CMOD&ElIngreso='+Consecutivo+'&ElPte='+ElPte+'&ElOrigen=Ingresos', 'Recibo de Caja', 'cash_register_2.png');
				
			}
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_cajasmov(Ventana)
{
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	xError="";
	Ventana="zWind_"+Ventana;
	
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_paciente'+Ventana).value=="") {
		xError="Digite el ID del tercero.";}
	if (document.getElementById('txt_valor'+Ventana).value=="") {
		xError="Digite el valor del movimiento.";}
	/*if (document.getElementById('txt_valor'+Ventana).value=="0") {
		xError="Debe indicar un valor mayor que cero";}*/
	if (document.getElementById('txt_idcaja'+Ventana).value=="") {
		xError="Debe seleccionar una caja abierta válida";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"cajasmov.php",  
		  data: "Func=cajasmov&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			MsgBox1("movimiento de Caja", respuesta);
			if (respuesta.indexOf("correctamente")>10) {
				Consecutivo=respuesta.substr(respuesta.length-10,10);
				$("#frm_form"+Ventana)[0].reset();
				document.getElementById(NomGuardar).style.display  = 'block';
				CargarReport("application/reports/cajasmov.php?CODIGO_INICIAL="+Consecutivo+"&CODIGO_FINAL="+Consecutivo, "Comprobante Movimiento de Caja");
			}
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	}
}

function Guardar_cajascierre(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_idcaja'+Ventana).value=="") {
		xError="Debe seleccionar una caja abierta válida";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "cajascierre.php",  
		  data: "Func=cajascierre&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			MsgBox1("Cierre de Caja", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		});  
		return false;  
	} else {
		document.getElementById(NomGuardar).style.display  = 'block';
		MsgBox1("Error", xError);
	}
}
function Guardar_agenda(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_idempleado'+Ventana).value=="") {
		xError="Digite el profesional a agendar.";}
	/*if (document.getElementById('txt_totcons'+Ventana).value=="0") {
		xError="Debe seleccionar las horas de atención para la agenda";}*/

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"agenda.php",  
		  data: "Func=agenda&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			MsgBox1("Creación de Agenda Médica", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_agendatrasl(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('hdn_contage'+Ventana).value=="0") {
		xError="Debe seleccionar los turnos a trasladar de la agenda";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"agendatrasl.php",  
		  data: "Func=agenda&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			MsgBox1("Traslado de Agenda Médica", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

/*function CitaOcupada()
{

}*/

function Guardar_agendacitas(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('hdn_controwcitas'+Ventana).value=="0") {
		xError="Seleccione un dia para agendar.";}
	 
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"agendacitas.php",  
		  data: "Func=agendacitas&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			MsgBox1("Programación de citas", respuesta); 
			fECHAZ=document.getElementById('hdn_fecha1'+Ventana).value;
			mEDICOZ=document.getElementById('cmb_medico'+Ventana).value;
			NumConsxDia=document.getElementById('hdn_controwcitas'+Ventana).value;
			if (respuesta.indexOf("El cupo ya fue asignado")=-1) {
				for (i = 1; i <= NumConsxDia; i++) { 
					ThePacient=document.getElementById('txt_paciente'+i+Ventana).value;
					if (ThePacient!="") {
						CargarReport("application/reports/citasprogramadasusuario.php?PACIENTE="+ThePacient+"&FECHA_INICIAL="+(fECHAZ)+"&FECHA_FINAL="+(fECHAZ), "Cita Programada");
					}
				}
				CargarReport("application/reports/citasprogramadasx.php?MEDICO="+mEDICOZ+"&FECHA_INICIAL="+(fECHAZ)+"&FECHA_FINAL="+(fECHAZ), "Planilla Pacientes");
			} 
			eval( 'ShowAgendas'+Ventana + '("'+fECHAZ+'")' );	
			document.getElementById(NomGuardar).style.display  = 'block';
			document.getElementById('cmb_medico'+Ventana).value=mEDICOZ;
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_agendacitasnew(Ventana, Ventana2)
{
	xError="";
	
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_idhc'+Ventana).value=="") {
		xError="Ingrese el documento del paciente";}
	 
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"agendanewcita.php",  
		  data: "Func=agendanewcita&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			MsgBox1("Programación de citas", respuesta); 
			$('#GnmX_WinModal').modal('hide');
			eval( 'getCal'+Ventana2 + '()' );
			if (respuesta.indexOf("El cupo ya fue asignado")=-1) {
				$("#frm_form"+Ventana)[0].reset();
			} 
			
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
	
	}
}

function Guardar_agendacitasrpgr(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('hdn_controwcitas'+Ventana).value=="0") {
		xError="Seleccione un dia para agendar.";}
	if (document.getElementById('txt_notarep'+Ventana).value=="") {
		xError="Ingrese la causa de la reprogramación.";}
		
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "agendacitasrpgr.php",  
		  data: "Func=agendacitasrpgr&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			MsgBox1("Reprogramación de citas", respuesta); 
			fECHAZ=document.getElementById('hdn_fecha1'+Ventana).value;
			mEDICOZ=document.getElementById('cmb_medico'+Ventana).value;
			NumConsxDia=document.getElementById('hdn_controwcitas'+Ventana).value;
			for (i = 1; i <= NumConsxDia; i++) { 
				ThePacient=document.getElementById('txt_paciente'+i+Ventana).value;
				if (ThePacient!="") {
					CargarReport("application/reports/citasprogramadasusuario.php?PACIENTE="+ThePacient+"&FECHA_INICIAL="+(fECHAZ)+"&FECHA_FINAL="+(fECHAZ), "Cita Programada");
				}
			}
			CargarReport("application/reports/citasprogramadasx.php?MEDICO="+mEDICOZ+"&FECHA_INICIAL="+(fECHAZ)+"&FECHA_FINAL="+(fECHAZ), "Planilla Pacientes");
			eval( 'ShowAgendas'+Ventana + '("'+fECHAZ+'")' );	
			document.getElementById(NomGuardar).style.display  = 'block';
			
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Anular_agendacitascncl(Ventana) {
	Ventana="zWind_"+Ventana;
	$.ajax({  
	  type: "POST",  
	  url: Transact +"agendacitascncl.php",  
	  data: "Func=agendacitascncl&"+RecorrerForm($("#frm_form"+Ventana)),  
	  success: function(respuesta) { 
		MsgBox1("Cancelación de citas", respuesta); 
	  }  
	});  
	return false;
}

function Guardar_planeseps(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_nombre'+Ventana).value=="") {
		xError="Digite el nombre del plan de atencion.";}
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		xError="Digite el codigo del plan de atencion.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "planeseps.php",  
		  data: "Func=planeseps&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			ListadoPlanes('listaplanes'+Ventana);
		  	MsgBox1("Planes EPS", respuesta); 
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

function Guardar_terceros(Ventana) {
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	//Se verifica la validez de los campos...
	if (document.getElementById('ID_TER'+Ventana).value=="") {
		xError="Digite una identificación válida.";}
	if (document.getElementById('Nombre_TER'+Ventana).value=="") {
		xError="Se requiere el nombre del tercero";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"terceros.php",  
		  data: RecorrerForm2($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			MsgBox1("Terceros", respuesta); 
				document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_tercerosupdte(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_paciente'+Ventana).value=="") {
		xError="Digite un código de identificacion válido.";}
	if (document.getElementById('txt_idreal'+Ventana).value=="") {
		xError="El código correcto no puede estar vacío";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"tercerosupdte.php",  
		  data: RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			MsgBox1("Correción ID Terceros", respuesta); 
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

function Guardar_trmupdate(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_valor'+Ventana).value=="") {
		xError="Digite el valor de la TRM actual.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"trm.php",  
		  data: "Func=trm&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			MsgBox1("TRM ", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_klagencias(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_idagencia'+Ventana).value=="") {
		xError="Digite el ID de la Agencia.";}

	if (document.getElementById('txt_ncomercial'+Ventana).value=="") {
		xError="Digite el Nombre de la Agencia.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"klagencias.php",  
		  data: "Func=klagencias&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			MsgBox1("Agencias ", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_contratos(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_fechafin'+Ventana).value=="") {
		xError="Digite la fecha final del contrato.";}
	if (document.getElementById('txt_fechaini'+Ventana).value=="") {
		xError="Digite la fecha inicial del contrato.";}
	if (document.getElementById('txt_contrato'+Ventana).value=="") {
		xError="Digite el contrato.";}
	if (document.getElementById('txt_Direccion'+Ventana).value=="") {
		xError="Digite la direccion.";}
	if (document.getElementById('txt_nombre'+Ventana).value=="") {
		xError="Digite el nombre de la entidad.";}
	if (document.getElementById('txt_nit'+Ventana).value=="") {
		xError="Digite el nit de la entidad.";}
	if (document.getElementById('txt_codmin'+Ventana).value=="") {
		xError="Digite el codigo otorgado por el ministerio.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"contratos.php",  
		  data: "Func=contratos&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Contratos", respuesta); 
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

function Guardar_inventariodesp(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('hdn_controwMed'+Ventana).value=="0") {
		xError="Seleccione la solicitud a despachar.";}
	
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "inventariodesp.php",  
		  data: "Func=inventariodesp&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Despacho a Pacientes", respuesta); 
			AbrirForm('application/forms/inventariodesp.php', Ventana, '&CodigoARE='+document.getElementById('cmb_filtroarea'+Ventana).value+'&CodigoSDE='+document.getElementById('cmb_filtrosede'+Ventana).value+'&FiltroFecINI='+document.getElementById('txt_fitrofecini'+Ventana).value+'&FiltroFecFIN='+document.getElementById('txt_fitrofecfin'+Ventana).value);
			CargarReport("application/reports/inventariodesp.php?CODIGO_INICIAL="+Consecutivo+"&CODIGO_FINAL="+Consecutivo, "Despacho");
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		});  
		return false;  
	} else {
		swal('DESPACHO A PACIENTES', xError,'error');
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_cubrimientocontrato(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_tarifa'+Ventana).value=="") {
		xError="Digite el codigo de la tarifa.";}
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		xError="Digite el codigo del contrato.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "cubrimientocontrato.php",  
		  data: "Func=cubrimientocontrato&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			ListadoPlanes('listaplanes'+Ventana);
		  	MsgBox1("Planes EPS", respuesta); 
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

function Guardar_egresos(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_Ingreso'+Ventana).value=="") {
		xError="Digite el codigo de la admision.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"egresos.php",  
		  data: "Func=egresos&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Egreso de Pacientes", respuesta.substr(respuesta.length-10,10)); 
				Consecutivo=respuesta.substr(respuesta.length-10,10);
				$("#frm_form"+Ventana)[0].reset();
				CargarReport("application/reports/egresos.php?CODIGO_INICIAL="+Consecutivo+"&CODIGO_FINAL="+Consecutivo, "Egreso");
				document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_ordenesdeservicio(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_paciente'+Ventana).value=="") {
		xError="Confirme el codigo de la admision.";}
	if (document.getElementById('txt_Ingreso'+Ventana).value=="") {
		xError="Digite el codigo de la admision.";}
	if (document.getElementById('hdn_controw'+Ventana).value=="0") {
		xError="No ha cargado servicios a la orden.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "ordenesdeservicio.php",  
		  data: "Func=ordenesdeservicio&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Ordenes de Servicios", respuesta); 
				if (respuesta.indexOf("correctamente")>10) {
				Consecutivo=respuesta.substr(respuesta.length-10,10);
				$("#frm_form"+Ventana)[0].reset();
				var MyDiv2=document.getElementById('detalleproc'+Ventana);
				MyDiv2.innerHTML='';
					CargarReport("application/reports/ordenesdeservicio.php?CODIGO_INICIAL="+Consecutivo+"&CODIGO_FINAL="+Consecutivo, "ordenesdeservicio");
					var miDiv = document.getElementById("zero_detalle"+Ventana); 
					miDiv.innerHTML ='<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblDetalle'+Ventana+'" ><tbody id="tbDetalle'+Ventana+'"><tr id="trh'+Ventana+'"> <th id="th1'+Ventana+'">Codigo</td> <th id="th2'+Ventana+'">Servicio</td> <th id="th3'+Ventana+'">Cantidad</td> <th id="th4'+Ventana+'">X</td> </tr> </tbody></table>';
					document.getElementById(NomGuardar).style.display  = 'block';
	
			}
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function EliminarFilaOrden(Numero, Ventana) { 
    var miTabla = document.getElementById("tblDetalle"+Ventana);     
    $('#tr'+Numero+Ventana).remove();
}  

function AgregarFilaOrden(Codigo1, Codigo2, Nombre, Cantidad, Empleado, Empleado2, Ventana, TotalFilas, Tema)  { 
	xError="";
	if ((Cantidad=="")||(Cantidad<=0)) {
		xError="Digite la cantidad del servicio.";}
	if (Nombre=="") {
		xError="Confirme el codigo del servicio pulsando la tecla {Enter}.";}
	if (Codigo1=="") {
		xError="Digite el codigo del servicio a cargar.";}
	
	if (xError=="") {
				
    var miTabla = document.getElementById("tbDetalle"+Ventana); 
    var fila = document.createElement("tr"); 
    var celda1 = document.createElement("td"); 
    var celda2 = document.createElement("td"); 
    var celda25 = document.createElement("td"); 
    var celda3 = document.createElement("td"); 
    var celda4 = document.createElement("td"); 
	TotalFilas++;
	fila.id="tr"+TotalFilas+Ventana;
    celda1.innerHTML = '<input name="hdn_codigoser'+TotalFilas+Ventana+'" type="hidden" id="hdn_codigoser'+TotalFilas+Ventana+'" value="'+Codigo1+''+'" />'+Codigo2; 
    celda2.innerHTML = Nombre; 
    celda25.innerHTML = '<input name="hdn_codigoter'+TotalFilas+Ventana+'" type="hidden" id="hdn_codigoter'+TotalFilas+Ventana+'" value="'+Empleado2+''+'" />'+Empleado; 
    celda3.innerHTML = '<input class="sinborde" name="hdn_cantidadser'+TotalFilas+Ventana+'" type="number" id="hdn_cantidadser'+TotalFilas+Ventana+'" value="'+Cantidad+'" min="1" />'; 
    celda4.innerHTML = '<a href="javascript:EliminarFilaOrden(\''+TotalFilas+'\',\''+Ventana+'\');"><img src="'+nxs_cdn+'/image/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar servicio de la orden" /></a>'; 
    fila.appendChild(celda1); 
    fila.appendChild(celda2); 
    fila.appendChild(celda25); 
    fila.appendChild(celda3); 
    fila.appendChild(celda4); 
    miTabla.appendChild(fila); 
	
	document.getElementById("hdn_controw"+Ventana).value=TotalFilas;
	document.getElementById("txt_codigo"+Ventana).value="";
	document.getElementById("hdn_codigox"+Ventana).value="";
	document.getElementById("txt_nombreserv"+Ventana).value="";
	document.getElementById("txt_cantidad"+Ventana).value="";	
	document.getElementById("txt_codigo"+Ventana).focus();
	SiEsQx(Codigo1, Cantidad, Ventana);
	
	} else {
		MsgBox1("Error", xError);
	}
} 

function AgregarFilaCargo(Fecha, Cargo, Ventana, TotalFilas, Tema)  {
	xError="";
	if (Fecha=="") {
		xError="Digite la fecha de asignación del cargo.";}
	if (Cargo=="") {
		xError="Seleccione el cargo asignado.";}
	
	if (xError=="") {

    var miTabla = document.getElementById("tbDetalle"+Ventana); 
    var fila = document.createElement("tr"); 
    var celda1 = document.createElement("td"); 
    var celda2 = document.createElement("td"); 
    var celda4 = document.createElement("td"); 
	TotalFilas++;
	fila.id="tr"+TotalFilas+Ventana;
    celda1.innerHTML = '<input name="hdn_fechaini'+TotalFilas+Ventana+'" type="hidden" id="hdn_fechaini'+TotalFilas+Ventana+'" value="'+Fecha+''+'" />'+Fecha; 
	$.get(Funciones,{'Func':'NombreCargo','codigo':Cargo},function(data){
	    celda2.innerHTML = '<input name="hdn_codcargo'+TotalFilas+Ventana+'" type="hidden" id="hdn_codcargo'+TotalFilas+Ventana+'" value="'+Cargo+''+'" />'+data; 
	}); 
    celda4.innerHTML = '<a href="javascript:EliminarFilaOrden(\''+TotalFilas+'\',\''+Ventana+'\');"><img src="'+nxs_cdn+'/image/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar cargo del empleado" /></a>'; 
    fila.appendChild(celda1); 
    fila.appendChild(celda2); 
    fila.appendChild(celda4); 
    miTabla.appendChild(fila); 
	
	document.getElementById("hdn_controw"+Ventana).value=TotalFilas;
	document.getElementById("txt_fechaini"+Ventana).value="";
	document.getElementById("txt_fechaini"+Ventana).focus();
	
	} else {
		MsgBox1("Error", xError);
	}
} 

function AgregarFilaSalario(Fecha, Salario, Ventana, TotalFilas, Tema)  { 
	xError="";
	if (Fecha=="") {
		xError="Digite la fecha de asignación del salario.";}
	if (Salario=="") {
		xError="Digite el valor del salario.";}
	
	if (xError=="") {

    var miTabla = document.getElementById("tbDetalle"+Ventana); 
    var fila = document.createElement("tr"); 
    var celda1 = document.createElement("td"); 
    var celda2 = document.createElement("td"); 
    var celda4 = document.createElement("td"); 
	TotalFilas++;
	fila.id="tr"+TotalFilas+Ventana;
    celda1.innerHTML = '<input name="hdn_fechaini'+TotalFilas+Ventana+'" type="hidden" id="hdn_fechaini'+TotalFilas+Ventana+'" value="'+Fecha+''+'" />'+Fecha; 
    celda2.innerHTML = '<input name="hdn_valorslr'+TotalFilas+Ventana+'" type="hidden" id="hdn_valorslr'+TotalFilas+Ventana+'" value="'+Salario+''+'" />'+Salario; 
    celda4.innerHTML = '<a href="javascript:EliminarFilaOrden(\''+TotalFilas+'\',\''+Ventana+'\');"><img src="'+nxs_cdn+'/image/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar salario del empleado" /></a>'; 
    fila.appendChild(celda1); 
    fila.appendChild(celda2); 
    fila.appendChild(celda4); 
    miTabla.appendChild(fila); 
	
	document.getElementById("hdn_controw"+Ventana).value=TotalFilas;
	document.getElementById("txt_fechaini"+Ventana).value="";
	document.getElementById("txt_fechaini"+Ventana).focus();
	
	} else {
		MsgBox1("Error", xError);
	}
} 

function AgregarFilaArea(IdArea, NomArea, Ventana, TotalFilas, Tema)  {
	xError="";
	
	if (xError=="") {

    var miTabla = document.getElementById("tbDetalle"+Ventana); 
    var fila = document.createElement("tr"); 
    var celda2 = document.createElement("td"); 
    var celda4 = document.createElement("td"); 
	TotalFilas++;
	fila.id="tr"+TotalFilas+Ventana;
    celda2.innerHTML = '<input name="hdn_codarea'+TotalFilas+Ventana+'" type="hidden" id="hdn_codarea'+TotalFilas+Ventana+'" value="'+IdArea+''+'" />'+NomArea; 
	celda4.innerHTML = '<a href="javascript:EliminarFilaOrden(\''+TotalFilas+'\',\''+Ventana+'\');"><img src="'+nxs_cdn+'/image/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar area del empleado" /></a>'; 
    fila.appendChild(celda2); 
    fila.appendChild(celda4); 
    miTabla.appendChild(fila); 
	
	document.getElementById("hdn_controw"+Ventana).value=TotalFilas;
	
	} else {
		MsgBox1("Error", xError);
	}
} 

function AgregarFilaEmple(IdEmple, NomEmple, Ventana, TotalFilas, Tema)  {
	xError="";
	
	if (xError=="") {

    var miTabla = document.getElementById("tbDetalle"+Ventana); 
    var fila = document.createElement("tr"); 
    var celda2 = document.createElement("td"); 
    var celda4 = document.createElement("td"); 
	TotalFilas++;
	fila.id="tr"+TotalFilas+Ventana;
    celda2.innerHTML = '<input name="hdn_codemple'+TotalFilas+Ventana+'" type="hidden" id="hdn_codemple'+TotalFilas+Ventana+'" value="'+IdEmple+''+'" />'+NomEmple; 
	celda4.innerHTML = '<a href="javascript:EliminarFilaOrden(\''+TotalFilas+'\',\''+Ventana+'\');"><img src="'+nxs_cdn+'/image/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar empleado de esta area" /></a>'; 
    fila.appendChild(celda2); 
    fila.appendChild(celda4); 
    miTabla.appendChild(fila); 
	
	document.getElementById("hdn_contro"+Ventana).value=TotalFilas;
	
	} else {
		MsgBox1("Error", xError);
	}
} 

function Guardar_factsiigo(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	NomProgress='nxsprogress'+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	InsertarHTML(NomProgress, '<div class="progress" style="width: 50%; float: left;">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%">    <span class="sr-only">Generando Factura</span>  </div></div>');
	
	Ventana="zWind_"+Ventana;
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "initfacsiigo.php",  
		  data: "Func=initfacsiigo",  
		  success: function(respuesta) { 
		  	MsgBox1("Exportar Facturas Siigo", respuesta); 
				InsertarHTML(NomProgress, '');
				document.getElementById(NomGuardar).style.display  = 'block';
	
		}	 
		});  
		return false;  
	} else {
		InsertarHTML(NomProgress, '');
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	}
}


function Guardar_facturasaludcapita(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_Contrato'+Ventana).value=="") {
		xError="Digite el codigo del contrato";}
	if (document.getElementById('txt_valfactura'+Ventana).value=="") {
		xError="Digite el valor total de la capita a facturar";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "facturasaludcapita.php",  
		  data: "Func=facturasaludcapita&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Liquidación de Cuentas Capitadas", respuesta); 
				if (respuesta.indexOf("correctamente")>10) {
				Consecutivo=respuesta.substr(respuesta.length-10,10);
				TamPref=respuesta.length-50;
				Pref=respuesta.substr(40,TamPref);
				Pref=Pref.trim();
				$("#frm_form"+Ventana)[0].reset();
				/*if (document.getElementById('hdn_controw'+Ventana).value>11) {
				CargarReport("application/reports/facturasalud.php?PREFIJO="+Pref+"&CODIGO_INICIAL="+Consecutivo+"&CODIGO_FINAL="+Consecutivo, "facturasalud");
				CargarReport("application/reports/anexofacturasalud.php?PREFIJO="+Pref+"&CODIGO_FACTURA="+Consecutivo, "anexofacturasalud");
				} else {*/
				CargarReport("application/reports/facturasaluddet.php?PREFIJO="+Pref+"&CODIGO_INICIAL="+Consecutivo+"&CODIGO_FINAL="+Consecutivo, "facturasaludcapita");
				/*}
				var miDiv = document.getElementById("zero_detalle"+Ventana); 
				miDiv.innerHTML ='<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblDetalle'+Ventana+'" ><tbody id="tbDetalle'+Ventana+'"><tr id="trh'+Ventana+'"> <th id="th1'+Ventana+'">Codigo</th> <th id="th2'+Ventana+'">Servicio</th> <th id="th3'+Ventana+'">Cant.</th> <th id="th4'+Ventana+'">Paciente</th> <th id="th4'+Ventana+'">Entidad</th> <th id="th4'+Ventana+'">Total</th></tr></tbody></table>';
				*/
				document.getElementById(NomGuardar).style.display  = 'block';
	
			}
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_facturasaludgrupal(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_Contrato'+Ventana).value=="") {
		xError="Digite el codigo del contrato";}
	if (document.getElementById('txt_valfactura'+Ventana).value=="0") {
		xError="Digite el valor total  a facturar";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "facturasaludgrupal.php",  
		  data: "Func=facturasaludgrupal&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Liquidación Grupal de Cuentas", respuesta); 
				if (respuesta.indexOf("correctamente")>10) {
				Consecutivo=respuesta.substr(respuesta.length-10,10);
				TamPref=respuesta.length-50;
				Pref=respuesta.substr(40,TamPref);
				Pref=Pref.trim();
				$("#frm_form"+Ventana)[0].reset();
				/*if (document.getElementById('hdn_controw'+Ventana).value>11) {
				CargarReport("application/reports/facturasalud.php?PREFIJO="+Pref+"&CODIGO_INICIAL="+Consecutivo+"&CODIGO_FINAL="+Consecutivo, "facturasalud");
				CargarReport("application/reports/anexofacturasalud.php?PREFIJO="+Pref+"&CODIGO_FACTURA="+Consecutivo, "anexofacturasalud");
				} else {*/
				CargarReport("application/reports/facturasaludgrupal.php?PREFIJO="+Pref+"&CODIGO_INICIAL="+Consecutivo+"&CODIGO_FINAL="+Consecutivo, "facturasaludgrupal");
				/*}
				var miDiv = document.getElementById("zero_detalle"+Ventana); 
				miDiv.innerHTML ='<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblDetalle'+Ventana+'" ><tbody id="tbDetalle'+Ventana+'"><tr id="trh'+Ventana+'"> <th id="th1'+Ventana+'">Codigo</th> <th id="th2'+Ventana+'">Servicio</th> <th id="th3'+Ventana+'">Cant.</th> <th id="th4'+Ventana+'">Paciente</th> <th id="th4'+Ventana+'">Entidad</th> <th id="th4'+Ventana+'">Total</th></tr></tbody></table>';
				*/
				document.getElementById(NomGuardar).style.display  = 'block';
	
			}
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_hcordenarfecha(Ventana)
{
	eval('guardar_hcordenarfechazWind_'+Ventana+'('+Ventana+')');	
}

function Guardar_facturasaludlote(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_cantidad'+Ventana).value=="0") {
		xError="Seleccione por lo menos un ingreso";}
	TotalING=document.getElementById('txt_cantidad'+Ventana).value;
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "facturasaludlote.php",  
		  data: "Func=facturasaludlote&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Liquidación de Lote de Cuentas", respuesta); 
				if (respuesta.indexOf("message_ok")>10) {
				Consecutivo=respuesta.substr(respuesta.length-10,10);
				Consecutivo2=Consecutivo;
				Consecutivo1=Consecutivo-TotalING+1;
				TamPref=respuesta.length-81;
				Pref=document.getElementById('hdn_prefijo'+Ventana).value;
				Pref=Pref.trim(); 
				cadf1="ordenar";
				eval(cadf1+Ventana+"('1')");
				CargarReport("application/reports/facturasaluddet.php?PREFIJO="+Pref+"&CODIGO_INICIAL="+Consecutivo1+"&CODIGO_FINAL="+Consecutivo2, "facturasaluddet");
				document.getElementById(NomGuardar).style.display  = 'block';
	
			}
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function AgregarFilaInvEntra(Codigo1, Nombre, Presentacion, Laboratorio, Lote, Vence, Invima, Riesgo, Cantidad, Ventana, TotalFilas, Tema)  { 
	xError="";
	if ((Cantidad=="")||(Cantidad<=0)) {
		xError="Digite la cantidad del servicio.";}
	if (Nombre=="") {
		xError="Confirme el codigo del producto pulsando la tecla {Enter}.";}
	if (Codigo1=="") {
		xError="Digite el codigo del producto a cargar.";}
	
	if (xError=="") {
				
    var miTabla = document.getElementById("tbDetalle"+Ventana); 
    var fila = document.createElement("tr"); 
    var celda1 = document.createElement("td"); 
    var celda2 = document.createElement("td"); 
    var celda3 = document.createElement("td"); 
    var celda4 = document.createElement("td");
	var celda5 = document.createElement("td");
	var celda6 = document.createElement("td");
	var celda7 = document.createElement("td");
	var celda8 = document.createElement("td");
	var celda9 = document.createElement("td");
	var celda10 = document.createElement("td");
	TotalFilas++;
	fila.id="tr"+TotalFilas+Ventana;
    celda1.innerHTML = '<input name="hdn_codigoprod'+TotalFilas+Ventana+'" type="hidden" id="hdn_codigoprod'+TotalFilas+Ventana+'" value="'+Codigo1+''+'" />'+Codigo1; 
    celda2.innerHTML = Nombre; 
    celda3.innerHTML = '<input name="hdn_presentacion'+TotalFilas+Ventana+'" type="hidden" id="hdn_presentacion'+TotalFilas+Ventana+'" value="'+Presentacion+'" />'+Presentacion; 
    celda4.innerHTML = '<input name="hdn_laboratorio'+TotalFilas+Ventana+'" type="hidden" id="hdn_laboratorio'+TotalFilas+Ventana+'" value="'+Laboratorio+'" />'+Laboratorio; 
    celda5.innerHTML = '<input name="hdn_lote'+TotalFilas+Ventana+'" type="hidden" id="hdn_lote'+TotalFilas+Ventana+'" value="'+Lote+'" />'+Lote; 
    celda6.innerHTML = '<input name="hdn_vence'+TotalFilas+Ventana+'" type="hidden" id="hdn_vence'+TotalFilas+Ventana+'" value="'+Vence+'" />'+Vence; 
    celda7.innerHTML = '<input name="hdn_invima'+TotalFilas+Ventana+'" type="hidden" id="hdn_invima'+TotalFilas+Ventana+'" value="'+Invima+'" />'+Invima; 
    celda8.innerHTML = '<input name="hdn_riesgo'+TotalFilas+Ventana+'" type="hidden" id="hdn_riesgo'+TotalFilas+Ventana+'" value="'+Riesgo+'" />'+Riesgo; 
    celda9.innerHTML = '<input name="hdn_cantidad'+TotalFilas+Ventana+'" type="hidden" id="hdn_cantidad'+TotalFilas+Ventana+'" value="'+Cantidad+'" />'+Cantidad; 
    celda10.innerHTML = '<a href="javascript:EliminarFilaOrden(\''+TotalFilas+'\',\''+Ventana+'\');"><img src="'+nxs_cdn+'/image/remove.png"  alt="Eliminar" align="absmiddle" title="Eliminar producto de la entrada" /></a>'; 

    fila.appendChild(celda1); 
    fila.appendChild(celda2); 
    fila.appendChild(celda3); 
    fila.appendChild(celda4); 
    fila.appendChild(celda5); 
    fila.appendChild(celda6); 
    fila.appendChild(celda7); 
    fila.appendChild(celda8); 
    fila.appendChild(celda9); 
    fila.appendChild(celda10); 
    miTabla.appendChild(fila); 
	
	document.getElementById("hdn_controw"+Ventana).value=TotalFilas;
	document.getElementById("txt_producto"+Ventana).value="";
	document.getElementById("txt_nombreserv"+Ventana).value="";
	document.getElementById("txt_cantidad"+Ventana).value="";	
	document.getElementById("txt_producto"+Ventana).focus();
	
	} else {
		MsgBox1("Error", xError);
	}
} 

function Guardar_inventarioentra(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_Ingreso'+Ventana).value=="") {
		document.getElementById('txt_Ingreso'+Ventana).value="0";}
	if (document.getElementById('txt_compra'+Ventana).value=="") {
		document.getElementById('txt_compra'+Ventana).value="0";}
	if (document.getElementById('txt_fechaent'+Ventana).value=="") {
		xError="Digite la fecha de la entrada a almacen";}
	if (document.getElementById('txt_fechainsp'+Ventana).value=="") {
		xError="Digite la fecha de inspeccion";}
	if (document.getElementById('txt_idproveedor'+Ventana).value=="") {
		xError="seleccione un proveedor";}	
	/*if (document.getElementById('hdn_controw'+Ventana).value=="0") {
		xError="No ha agregado productos a cargar.";}
	*/
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "inventarioentra.php",  
		  data: "Func=inventarioentra&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Entrada a Inventario", respuesta); 
				if (respuesta.indexOf("message_ok")>10) {
				Consecutivo=respuesta.substr(respuesta.length-10,10);
				$("#frm_form"+Ventana)[0].reset();
				var MyDiv2=document.getElementById('detalleproc'+Ventana);
				MyDiv2.innerHTML='';
				CargarReport("application/reports/inventarioentra.php?CODIGO_INICIAL="+Consecutivo+"&CODIGO_FINAL="+Consecutivo, "inventarioentra");
				var miDiv = document.getElementById("zero_detalle"+Ventana); 
				miDiv.innerHTML ='<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblDetalle'+Ventana+'" ><tbody id="tbDetalle'+Ventana+'"><tr id="trh'+Ventana+'"> <th id="th1'+Ventana+'">Codigo</td> <th id="th2'+Ventana+'">Servicio</td> <th id="th3'+Ventana+'">Cantidad</td> <th id="th4'+Ventana+'">X</td> </tr> </tbody></table>';
				document.getElementById(NomGuardar).style.display  = 'block';
	
			}
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_proveedores(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_ncomercial'+Ventana).value=="") {
		xError="Digite el nombre del proveedor";}
		if (document.getElementById('txt_Direccion'+Ventana).value=="") {
		xError="Digite la direccion del empleado.";}
	if (document.getElementById('txt_Municipio'+Ventana).value=="") {
		xError="Digite el municipio del empleado.";}
	if (document.getElementById('txt_Departamento'+Ventana).value=="") {
		xError="Digite el departamento del empleado.";}
/*if (document.getElementById('hdn_controw'+Ventana).value=="0") {
		xError="No ha agregado productos a cargar.";}
	*/
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "proveedores.php",  
		  data: "Func=proveedores&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Proveedores", respuesta); 
			if (respuesta.indexOf("message_ok")>10) {
				Consecutivo=respuesta.substr(respuesta.length-10,10);
				$("#frm_form"+Ventana)[0].reset();
				document.getElementById(NomGuardar).style.display  = 'block';
	
			}
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_klcotizaciones(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_nombres'+Ventana).value=="") {
		xError="Digite el nombre del cliente.";}
	if (document.getElementById('txt_apellidos'+Ventana).value=="") {
		xError="Digite apellido del cliente.";}
	if (document.getElementById('txt_pasaporte'+Ventana).value=="") {
		xError="Digite el pasaporte del cliente.";}
	if (document.getElementById('txt_nacionalidad'+Ventana).value=="") {
		xError="Digite la nacionalidad del cliente.";}
	if (document.getElementById('txt_correo'+Ventana).value=="") {
		xError="Digite el email del cliente.";}
	if (document.getElementById('txt_direccion'+Ventana).value=="") {
		xError="Digite la direccion del cliente.";}
	if (document.getElementById('txt_telefono'+Ventana).value=="") {
		xError="Digite el telefono del cliente.";}
	if (document.getElementById('txt_contacto'+Ventana).value=="") {
		xError="Digite el contacto en caso de emergencia.";}
	if (document.getElementById('txt_voucher'+Ventana).value=="") {
		xError="Digite el voucher.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "klcotizaciones.php",  
		  data: "Func=klcotizaciones&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	document.getElementById("txt_voucher"+Ventana).value="XXX"+respuesta+"-";
		  	document.getElementById("txt_fnac"+Ventana).disabled=true;
		  	document.getElementById("txt_fini"+Ventana).disabled=true;
		  	document.getElementById("txt_ffin"+Ventana).disabled=true;
		  	document.getElementById("cmb_modalidad"+Ventana).disabled=true;
		  	document.getElementById("cmb_destino"+Ventana).disabled=true;
		  	document.getElementById("txt_trm"+Ventana).disabled=true;
		  	document.getElementById("cmb_agencia"+Ventana).disabled=true;
		  	document.getElementById("txt_nombres"+Ventana).disabled=true;
		  	document.getElementById("txt_apellidos"+Ventana).disabled=true;
		  	document.getElementById("txt_pasaporte"+Ventana).disabled=true;
		  	document.getElementById("txt_nacionalidad"+Ventana).disabled=true;
		  	document.getElementById("cmb_procedencia"+Ventana).disabled=true;
		  	document.getElementById("txt_correo"+Ventana).disabled=true;
		  	document.getElementById("txt_direccion"+Ventana).disabled=true;
		  	document.getElementById("txt_telefono"+Ventana).disabled=true;
		  	document.getElementById("txt_contacto"+Ventana).disabled=true;
		  	document.getElementById("txt_voucher"+Ventana).disabled=true;
		  	document.getElementById("dvbtnemi"+Ventana).innerHTML='<button type="button" class="btn btn-warning btn-xs btn-block" onclick="CargarForm(\'application/forms/klemisiones.php?CTZ='+respuesta+'\', \'Emisiones\', \'travel.png\')">Generar Emisión <span class="glyphicon glyphicon-plane" aria-hidden="true"></span> </button>';
		  	document.getElementById('divemitir'+Ventana).style.visibility = 'visible';
			document.getElementById(NomGuardar).style.display  = 'block';
			document.getElementById("txt_cotizacion"+Ventana).value=respuesta;
			MsgBox1("Cotizaciones", "Cotizacion No. "+respuesta+" realizada con éxito."); 
			
		  }  
		});  
		return false;  
	} else {
		MsgBoxErr("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_klemisiones(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_cotizacion'+Ventana).value=="") {
		xError="Digite la cotizacion del cliente.";}
	if (document.getElementById('txt_cotizacion'+Ventana).value=="000000") {
		xError="Digite la cotizacion del cliente.";}
	if (document.getElementById('txt_emision'+Ventana).value!="000000") {
		xError="La poliza ya ha sido emitida.";}
	
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		document.getElementById("txt_cotizacion"+Ventana).disabled=true;
		Prefijo=document.getElementById('hdn_prefijo'+Ventana).value;
		/*document.getElementById("Guardar"+Ventana).disabled=true; 
		document.getElementById("Nuevo"+Ventana).style.display  = 'block'; 	*/
		$.ajax({  
		  type: "POST",  
		  url: Transact + "klemisiones.php",  
		  data: "Func=klemisiones&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  	if (respuesta.substr(0, 41)=="No se pudo realizar el registro de datos.") {
		  		MsgBoxErr("Emisiones", respuesta); 
		  		document.getElementById("txt_cotizacion"+Ventana).disabled=false;
		  	} else {
			  	document.getElementById("txt_emision"+Ventana).value=respuesta;
				MsgBox1("Emisiones", "Emisión No. "+respuesta+" realizada con éxito."); 
				CargarReport("application/reports/klemisiones.php?EMISION_INICIAL="+respuesta+"&EMISION_FINAL="+respuesta+"&PREFIJO="+Prefijo , "Emisiones");
			}
		  } 
		});  
		return false;  
	} else {
		MsgBoxErr("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Anular_klemisionesno(Ventana) {
	xError="";
	Ventana="zWind_"+Ventana;
	if (document.getElementById('txt_poliza'+Ventana).value=="") {
		xError="Digite el numero de la poliza.";}
		nopoliza=document.getElementById('txt_poliza'+Ventana).value;
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "klnoemision.php",  
		  data: "Func=klnoemision&poliza="+nopoliza,  
		  success: function(respuesta) { 
		  	MsgBox1("Anulacion Poliza", respuesta); 
		  } 
		});  
		return false; 
	} else {
		MsgBox1("Error", xError);
	}
}

function Guardar_klplanes(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_plan'+Ventana).value=="") {
		xError="Digite el nombre del plan.";}
	if (document.getElementById('txt_descripcion'+Ventana).value=="") {
		xError="Digite una descripcion del plan.";}
	
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		/*document.getElementById("txt_cotizacion"+Ventana).disabled=true;
		document.getElementById("txt_voucher"+Ventana).disabled=true; */
		$.ajax({  
		  type: "POST",  
		  url: Transact + "klplanes.php",  
		  data: "Func=klplanes&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Planes", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  } 
		});  
		return false;  
	} else {
		MsgBoxErr("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_klmodfamilia(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_plan'+Ventana).value=="") {
		xError="Digite el nombre del plan.";}
	
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		/*document.getElementById("txt_cotizacion"+Ventana).disabled=true;
		document.getElementById("txt_voucher"+Ventana).disabled=true; */
		$.ajax({  
		  type: "POST",  
		  url: Transact + "klmodfamilia.php",  
		  data: "Func=klmodfamilia&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Modalidad Familia", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  } 
		});  
		return false;  
	} else {
		MsgBoxErr("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_klmodpareja(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_plan'+Ventana).value=="") {
		xError="Digite el nombre del plan.";}
	
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		/*document.getElementById("txt_cotizacion"+Ventana).disabled=true;
		document.getElementById("txt_voucher"+Ventana).disabled=true; */
		$.ajax({  
		  type: "POST",  
		  url: Transact + "klmodpareja.php",  
		  data: "Func=klmodpareja&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Modalidad Pareja", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  } 
		});  
		return false;  
	} else {
		MsgBoxErr("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_klmodindividual(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_plan'+Ventana).value=="") {
		xError="Digite el nombre del plan.";}
	
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		/*document.getElementById("txt_cotizacion"+Ventana).disabled=true;
		document.getElementById("txt_voucher"+Ventana).disabled=true; */
		$.ajax({  
		  type: "POST",  
		  url: Transact + "klmodindividual.php",  
		  data: "Func=klmodindividual&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Modalidad Individual", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  } 
		});  
		return false;  
	} else {
		MsgBoxErr("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_kldestinos(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_plan'+Ventana).value=="") {
		xError="Digite el nombre del plan.";}
	
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		/*document.getElementById("txt_cotizacion"+Ventana).disabled=true;
		document.getElementById("txt_voucher"+Ventana).disabled=true; */
		$.ajax({  
		  type: "POST",  
		  url: Transact + "kldestinos.php",  
		  data: "Func=kldestinos&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Destinos", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  } 
		});  
		return false;  
	} else {
		MsgBoxErr("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_mantarifas(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_tarifa'+Ventana).value=="") {
		xError="Digite el codigo del manual tarifario.";}
	if (document.getElementById('txt_valor'+Ventana).value=="") {
		xError="Digite el valor del servicio.";}
	if (document.getElementById('txt_servicio'+Ventana).value=="") {
		xError="Digite el codigo del servicio.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "mantarifas.php",  
		  data: "Func=mantarifas&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Manuales Tarifarios", respuesta); 
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

function Anular_ordenesdeserviciono(Ventana) {
	xError="";
	Ventana="zWind_"+Ventana;
	if (document.getElementById('txt_Orden'+Ventana).value=="") {
		xError="Digite el codigo de la orden de servicio.";}
	if (document.getElementById('hdn_Orden'+Ventana).value=="") {
		xError="Numero de orden de servicio invalido. No se puede anular.";}
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.get(Updates,{'Func':'NoOrden','value':document.getElementById('txt_Orden'+Ventana).value},function(data){ 
				MsgBox1("Orden de Servicio "+document.getElementById('txt_Orden'+Ventana).value, data);
		}); 
	} else {
		MsgBoxErr("Anulacion de Ordenes de Servicio", xError);
	}
}

function Anular_facturasaludno(Ventana) {
	xError="";
	Ventana="zWind_"+Ventana;
	if (document.getElementById('txt_Ingreso'+Ventana).value=="") {
		xError="Digite el numero del ingreso de la factura a anular.";}
	if (document.getElementById('txt_Motivo'+Ventana).value=="") {
		xError="Digite el motivo de la anulacion de la factura.";}
	if (document.getElementById('hdn_Ingreso'+Ventana).value=="") {
		xError="Numero de ingreso invalido. No se puede anular.";}
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.get(Updates,{'Func':'NoFactura','value':document.getElementById('txt_Ingreso'+Ventana).value,'value2':document.getElementById('txt_Motivo'+Ventana).value},function(data){ 
				MsgBox1("Facturas del ingreso "+document.getElementById('txt_Ingreso'+Ventana).value, data);
		}); 
	} else {
		MsgBoxErr("Anulacion de Facturas", xError);
	}
}

function Guardar_autorizaciones(Ventana) {
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	if (document.getElementById('txt_Ingreso'+Ventana).value=="") {
		xError="Digite el numero del ingreso de la factura a anular.";}
	if (document.getElementById('txt_Motivo'+Ventana).value=="") {
		xError="Digite el numero de autorizacion.";}
	if (document.getElementById('txt_Fecha'+Ventana).value=="") {
		xError="Digite la fecha de autorizacion.";}
	if (document.getElementById('hdn_Ingreso'+Ventana).value=="") {
		xError="Numero de ingreso invalido. No se puede actualizar.";}
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.get(Updates,{'Func':'Autorizar','value':document.getElementById('txt_Ingreso'+Ventana).value,'value2':document.getElementById('txt_Motivo'+Ventana).value,'value3':document.getElementById('txt_Fecha'+Ventana).value},function(data){ 
				MsgBox1("Facturas del ingreso "+document.getElementById('txt_Ingreso'+Ventana).value, data);
				document.getElementById(NomGuardar).style.display  = 'block';
	
		}); 
	} else {
		MsgBoxErr("Autorizaciones", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function SiEsQx(Codigo1, Cantidad, Ventana) {
	TotalItem=document.getElementById('hdn_cantporctotal'+Ventana).value;
	$.get(Funciones,{'Func':'SiEsQx','Codigo1':Codigo1,'Cantidad':Cantidad,'Ventana':Ventana, 'Items':TotalItem},function(data){ 
		if (data!="") {
			var eUL = $(document.createElement('span')).attr('id','detPROC'+Codigo1+'Qx'+Ventana).appendTo('#detalleproc'+Ventana);
			document.getElementById('detPROC'+Codigo1+'Qx'+Ventana).innerHTML=data;
			TotalItem=document.getElementById('hdn_contproc'+Codigo1+Ventana).value;
			document.getElementById('hdn_cantporctotal'+Ventana).value=TotalItem;
		}
	})	
}

function AddFavsForm(Item) {
	$.ajax({  
		  type: "POST",  
		  url: Transact + "addfavsform.php",  
		  data: "Func=addfavsform&item="+Item,  
		  success: function(respuesta) { 
		  	LoadFavs(); 
		  } 
		}); 
}
function LoadFavs() {
	$.get(Funciones,{'Func':'LoadFavs'},function(data){
		document.getElementById('Favz0').innerHTML=data;
	})
}

function CargarFacturasRad(Ventana) {
	xError="";
	if (document.getElementById('txt_Contrato'+Ventana).value=="") {
		xError="Digite el codigo del contrato";}
	if (document.getElementById('txt_fecini'+Ventana).value=="00/00/0000") {
		xError="Digite la fecha inicial del periodo";}
	if (document.getElementById('txt_fecfin'+Ventana).value=="00/00/0000") {
		xError="Digite la fecha final del periodo";}
	if ((document.getElementById('txt_fecini'+Ventana).value.split("/")).reverse().join("-")>(document.getElementById('txt_fecfin'+Ventana).value.split("/")).reverse().join("-")) {
		xError="La fecha inicial no puede ser mayor que la final";}
	if (xError=="") {
		var el = document.getElementById('recalcular'+Ventana); 
		el.style.display = 'block';
		Eps=document.getElementById('txt_Contrato'+Ventana).value;
		Plan=document.getElementById('txt_Plan'+Ventana).value;
		Sede=document.getElementById('txt_Sede'+Ventana).value;
		FechaFin=document.getElementById('txt_fecfin'+Ventana).value;
		FechaIni=document.getElementById('txt_fecini'+Ventana).value;
		$.get(Funciones,{'Func':'CargarFacturasRad','sede':Sede,'fechaini':FechaIni,'fechafin':FechaFin,'plan':Plan,'eps':Eps,'Ventana':Ventana},function(data){ 
			document.getElementById('factrad'+Ventana).innerHTML=data;
			document.getElementById('txt_total'+Ventana).value='0,00';
			document.getElementById('hdn_total'+Ventana).value='0';
			document.getElementById('txt_radicacion'+Ventana).value='0000000000';
		}); 
		el.style.display = 'none';
	} else {
		MsgBox1("Error", xError);
	}
}

function formatCurrency(num) {
	num = num.toString().replace(/\$|\,/g,'');
	if(isNaN(num)) num = "0";
	sign = (num == (num = Math.abs(num)));
	num = Math.floor(num*100+0.50000000001);
	cents = num%100;
	num = Math.floor(num/100).toString();
	if(cents<10) cents = "0" + cents;
	for (var i = 0; i < Math.floor((num.length-(1+i))/3); i++)
		num = num.substring(0,num.length-(4*i+3))+'.'+ num.substring(num.length-(4*i+3));
	return (((sign)?'':'-') + num + ',' + cents);
}

function Guardar_radicaciones(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_Contrato'+Ventana).value=="") {
		xError="Digite el codigo del contrato";}
	if (document.getElementById('txt_fecini'+Ventana).value=="00/00/0000") {
		xError="Digite la fecha inicial del periodo";}
	if (document.getElementById('txt_fecfin'+Ventana).value=="00/00/0000") {
		xError="Digite la fecha final del periodo";}
	if ((document.getElementById('txt_fecini'+Ventana).value.split("/")).reverse().join("-")>(document.getElementById('txt_fecfin'+Ventana).value.split("/")).reverse().join("-")) {
		xError="La fecha inicial no puede ser mayor que la final";}
	/* if (document.getElementById('hdn_total'+Ventana).value=="0") {
		xError="No se han seleccionado facturas para la radicacion.";}
	if (document.getElementById('hdn_controw'+Ventana).value=="0") {
		xError="No existen facturas con los parametros dados.";} */

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		FacturasRad="";

		TotalFacs=document.getElementById('hdn_controw'+Ventana).value;
		for (i = 1; i <= TotalFacs; i++) { 
			jj=i.toString();
			cuadro=document.getElementById('hdn_radicar'+jj+Ventana).value;
			if (cuadro=="1") {
				LaFactura= document.getElementById('hdn_factura'+jj+Ventana).value;
			    FacturasRad += "'"+ LaFactura.trim() +"',";
			}
		}
		FacturasRad=FacturasRad+"''";
		txtradicaion=document.getElementById('txt_radicacion'+Ventana).value;
		txtfecrad=document.getElementById('txt_fecrad'+Ventana).value;
		txtContrato=document.getElementById('txt_Contrato'+Ventana).value;
		txtPlan=document.getElementById('txt_Plan'+Ventana).value;
		txtfecini=document.getElementById('txt_fecini'+Ventana).value;
		txtfecfin=document.getElementById('txt_fecfin'+Ventana).value;
		txtcontrow=document.getElementById('hdn_controw'+Ventana).value;

		$.ajax({  
		  type: "POST",  
		  url: Transact + "radicaciones.php",  
		  data: "Func=radicaciones&Facturas="+FacturasRad+"&radicacion="+txtradicaion+"&fecrad="+txtfecrad+"&Contrato="+txtContrato+"&Plan="+txtPlan+"&fecini="+txtfecini+"&fecfin="+txtfecfin+"&controw="+txtcontrow,  
		  success: function(respuesta) { 

		  	MsgBox1("Radicacion de Cuentas", respuesta); 
		  	CargarFacturasRad(Ventana);
		  	document.getElementById(NomGuardar).style.display  = 'block';
			if (respuesta.indexOf("message_ok")>10) {
				Consecutivo=respuesta.substr(respuesta.length-10,10);
				$("#frm_form"+Ventana)[0].reset();
				CargarReport("application/reports/radicaciones.php?CODIGO_INICIAL="+Consecutivo, "radicaciones");

			}
		  }  
		});  
		return false;  
	} else {
		MsgBoxErr("Radicaciones", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_medicos(Ventana)

{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('cmb_espe1'+Ventana).value=="XXX") {
		xError="Seleccione la especialidad del profesional.";}
//Revisamos los campos obligatorios
	var x = document.getElementsByClassName("md_"+Ventana);
	for (var i=0; i < x.length; i++) {
		var rekerido=x[i].required;
		if (rekerido) {
			var elValor =x[i].value;
			if (elValor=="") {
				xError="Existen campos requeridos sin diligenciar."+x[i].name;
		        var elID=x[i].id;
		        $("#grp_"+elID).addClass("has-error");
			}
		}
	}
	xpass=document.getElementById('txt_pass'+Ventana).value;
	TotalTHC=document.getElementById('hdn_conttipohc'+Ventana).value;
	TotalAreas=document.getElementById('hdn_contare'+Ventana).value;
	FormatosHC="";
	for (i = 1; i <= TotalTHC; i++) { 
		jj=i.toString();
		cuadro=document.getElementById('hdn_hct'+jj+Ventana).value;
		if (cuadro=="1") {
			ElFormatoHC= document.getElementById('hdn_tipohc'+jj+Ventana).value;
		    FormatosHC += "'"+ ElFormatoHC.trim() +"',";
		}
	}
	AccesoAreas="";
	for (i2 = 1; i2 <= TotalAreas; i2++) { 
		jj2=i2.toString();
		cuadro2=document.getElementById('hdn_areaa'+jj2+Ventana).value;
		if (cuadro2=="1") {
			ElAccesoAreas= document.getElementById('hdn_area'+jj2+Ventana).value;
		    AccesoAreas += "'"+ ElAccesoAreas.trim() +"',";
		}
	}
	passl=$("#txt_pass"+Ventana).val();
	$("#txt_pass").attr('value', hex_md5(passl));
	$("#txt_pass2").attr('value', hex_md5(passl));
	FormatosHC=FormatosHC+"''";
	AccesoAreas=AccesoAreas+"''";
	document.getElementById('hdn_formatoshc'+Ventana).value=FormatosHC;
	document.getElementById('hdn_accesosareas'+Ventana).value=AccesoAreas;
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		/*var formData = new FormData();
        var files = $('#file'+Ventana)[0].files[0];
        formData.append('file',files);
        //var FormPost="";
		var Var1="";
		$(':input', miForm).each(function() {
			Var1=this.name;
			Var1=Var1.substring(4,Var1.indexOf('zW'));
			//FormPost=FormPost+Var1+"="+this.value.toUpperCase()+"&";
			formData.append(Var1, this.value.toUpperCase());
		});
		FormPost=String(FormPost).substring(0,String(FormPost).length-1)
		*/
		$.ajax({  
		  type: "POST",  
		  url: Transact + "medicos.php",  
		  /* data: formData,//"Func=medicos&"+RecorrerForm($("#frm_form"+Ventana)),  
		  contentType: false,
          processData: false, */
		  data: "Func=medicos&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Profesionales de la Salud", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		});  
		return false;  
	} else {
		MsgBoxErr("Profesionales de la Salud", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_hcnotas(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_idhc'+Ventana).value=="") {
		xError="Digite el número de identificación del paciente.";}
		
	if (document.getElementById('hdn_folio'+Ventana).value=="0") {
		xError="Seleccione el folio al cual se le asignará la nota aclaratoria";}
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "hcnotas.php",  
		  data: "Func=hcnotas&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Notas Aclaratorias", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
			AbrirForm('application/forms/hcnotas.php', Ventana, '');
		  }  
		});  
		return false;  
	} else {
		MsgBoxErr("Notas Aclaratorias", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_hctriage(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById("txt_idhc"+Ventana).disabled==true) {
		xError="El folio ya fue guardado.";
	}
	document.getElementById("txt_idhc"+Ventana).disabled=true;
	if (document.getElementById('hdn_codigoter'+Ventana).value=="X") {
		xError="Ingrese un paciente válido";}
//Revisamos los campos obligatorios
/*
	var x = document.getElementsByClassName("hcx_"+Ventana);
	for (var i=0; i < x.length; i++) {
		var rekerido=x[i].required;
		if (rekerido) {
			var elValor =x[i].value;
			if (elValor=="") {
				xError="Existen campos requeridos sin diligenciar. "+x[i].id;
		        var elID=x[i].id;
		        $("#grp_"+elID).addClass("has-error");
			}
		}
	}
*/
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"hctriage.php",  
		  data: "Func=hctriage&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("TRIAGE", respuesta); 
		  	document.getElementById(NomGuardar).style.display  = 'block';
		  	if (respuesta.indexOf("folio")>5) {
				Consecutivo=respuesta.substr(respuesta.length-5,5);
				historiac=document.getElementById('txt_idhc'+Ventana).value;
				$("#frm_form"+Ventana)[0].reset();
				CargarReport("application/reports/hctriage.php?HISTORIA="+historiac+"&FOLIO_INICIAL="+Consecutivo+"&FOLIO_FINAL="+Consecutivo, "HC "+historiac);
				document.getElementById(NomGuardar).style.display  = 'block';
				CerrarVentana(Ventana, event)
			}
		  }  
		});  
		return false;  
	} else {
		document.getElementById("txt_idhc"+Ventana).disabled=false;
		document.getElementById(NomGuardar).style.display  = 'block';
		MsgBoxErr("TRIAGE", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_pagoscartconf(Ventana)
{
	xError="";
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_pago'+Ventana).value=="") {
		xError="Ingrese un número de pago válido";}
	if (document.getElementById('txt_valor'+Ventana).value=="0") {
		xError="Ingrese un número de pago válido";}
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact+"pagoscartconf.php",  
		  data: "Func=pagoscartconf&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Confirmación de Pagos", respuesta); 
		  	Consecutivo=document.getElementById('txt_pago'+Ventana).value;
			$("#frm_form"+Ventana)[0].reset();
			$('#GnmX_WinModal').modal('show');
			CargarWind('Pago '+Consecutivo+' Confirmado', 'reports/pagoscartera.php?CODIGO_INICIAL='+Consecutivo+'&CODIGO_FINAL='+Consecutivo, 'default.png', 'pagoscartconf.php',Ventana );
//				CerrarVentana(Ventana, event)
		  }  
		});  
		return false;  
	} else {
		MsgBoxErr("Confirmación de Pagos", xError);	
	}
}

function Guardar_hc_facturado(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById("txt_idhc"+Ventana).disabled==true) {
		xError="El folio ya fue guardado.";
	}
	document.getElementById("txt_idhc"+Ventana).disabled=true;
	if (document.getElementById('hdn_codigoter'+Ventana).value=="X") {
		xError="Ingrese un paciente válido";}
	if (document.getElementById('hdn_formatohc'+Ventana).value=="") {
		xError="Seleccione un formato de historia clínica a diligenciar";}
//Revisamos los campos obligatorios
	var x = document.getElementsByClassName("hcx_"+Ventana);
	for (var i=0; i < x.length; i++) {
		var rekerido=x[i].required;
		if (rekerido) {
			var elValor =x[i].value;
			if (elValor=="") {
				xError="Existen campos requeridos sin diligenciar. "+x[i].id;
		        var elID=x[i].id;
		        $("#grp_"+elID).addClass("has-error");
			}
		}
	}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "hc.php",  
		  data: "Func=hc&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Historia Clínica", respuesta); 
		  	if (respuesta.indexOf("folio")>5) {
				Consecutivo=respuesta.substr(respuesta.length-5,5);
				historiac=document.getElementById('txt_idhc'+Ventana).value;
				$("#frm_form"+Ventana)[0].reset();
				CargarReport("application/reports/hc.php?HISTORIA="+historiac+"&FOLIO_INICIAL="+Consecutivo+"&FOLIO_FINAL="+Consecutivo, "HC "+historiac);
				PrintMedicamentos(historiac,Consecutivo, Consecutivo);
				PrintHlpDx(historiac,Consecutivo, Consecutivo);
				PrintOrdenes(historiac,Consecutivo, Consecutivo);
				PrintIncapacidad(historiac,Consecutivo, Consecutivo);
				document.getElementById(NomGuardar).style.display  = 'block';
			}
		  }  
		});  
		return false;  
	} else {
		document.getElementById("txt_idhc"+Ventana).disabled=false;
		MsgBoxErr("Historia Clínica", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function PrintMedicamentos(Historia,FolioIni, folioFin)
{
	$.get(Funciones,{'Func':'HayOrdenesHC','historia':Historia,'folioini':FolioIni,'foliofin':folioFin,'tabla':'hcordenesmedica'},function(data){ 
		if(data=="true") {
			CargarReport("application/reports/hcformulamedica.php?HISTORIA="+historiac+"&FOLIO_INICIAL="+Consecutivo+"&FOLIO_FINAL="+Consecutivo, "hc");
		}
	}); 
	
}

function PrintHlpDx(Historia,FolioIni, folioFin)
{
	$.get(Funciones,{'Func':'HayOrdenesHC','historia':Historia,'folioini':FolioIni,'foliofin':folioFin,'tabla':'hcordenesdx'},function(data){ 
		if(data=="true") {
			CargarReport("application/reports/hcayudasdx.php?HISTORIA="+historiac+"&FOLIO_INICIAL="+Consecutivo+"&FOLIO_FINAL="+Consecutivo, "hc");
		}
	}); 
	
}

function PrintOrdenes(Historia,FolioIni, folioFin)
{
	$.get(Funciones,{'Func':'HayOrdenesHC','historia':Historia,'folioini':FolioIni,'foliofin':folioFin,'tabla':'hcordenesmedica'},function(data){ 
		if(data=="true") {
			CargarReport("application/reports/hcordservicios.php?HISTORIA="+historiac+"&FOLIO_INICIAL="+Consecutivo+"&FOLIO_FINAL="+Consecutivo, "hc");
		}
	}); 
	
}

function PrintIncapacidad(Historia,FolioIni, folioFin)
{
	$.get(Funciones,{'Func':'HayOrdenesHC','historia':Historia,'folioini':FolioIni,'foliofin':folioFin,'tabla':'hcordenesmedica'},function(data){ 
		if(data=="true") {
			CargarReport("application/reports/hcordservicios.php?HISTORIA="+historiac+"&FOLIO_INICIAL="+Consecutivo+"&FOLIO_FINAL="+Consecutivo, "hc");
		}
	}); 
	
}

function RIPS(xRips, Ventana, Tema) {
	InsertarHTML('datosrips'+Ventana, '<div class="progress">  <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">    <span class="sr-only">Generando Archivos</span>  </div></div>');
	
	$.get(Funciones,{'Func':'RIPS','value':xRips},function(data){ 
		InsertarHTML('datosrips'+Ventana,data);
	}); 
}

function ContarMSG() {
	document.getElementById('NumMsg').innerHTML=data;
	
	$.get(Funciones,{'Func':'ContarMSG'},function(data){ 
		document.getElementById('NumMsg').innerHTML=data;
	});
}

function Guardar_radicacionesconf(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_radicacion'+Ventana).value=="") {
		xError="Digite el numero de radicacion";}
	if (document.getElementById('txt_fecrad'+Ventana).value=="00/00/0000") {
		xError="Digite la fecha de confirmación de la radicación";}
	if (document.getElementById('txt_fecrad'+Ventana).value=="") {
		xError="Digite la fecha de confirmación de la radicación";}
	if ((document.getElementById('txt_fecenv'+Ventana).value.split("/")).reverse().join("-")>(document.getElementById('txt_fecrad'+Ventana).value.split("/")).reverse().join("-")) {
		xError="La fecha de confirmación no puede ser menor que la del envío";}
	if (document.getElementById('hdn_total'+Ventana).value=="0") {
		xError="No se han seleccionado facturas para confirmar la radicacion.";}
	if (document.getElementById('txt_numrad'+Ventana).value=="") {
		xError="digite el número de confirmacion (sello) de la entidad.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		FacturasRad="";

		TotalFacs=document.getElementById('hdn_controw'+Ventana).value;
		for (i = 1; i <= TotalFacs; i++) { 
			jj=i.toString();
			cuadro=document.getElementById('hdn_radicar'+jj+Ventana).value;
			if (cuadro=="1") {
				LaFactura= document.getElementById('hdn_factura'+jj+Ventana).value;
			    FacturasRad += "'"+ LaFactura.trim() +"',";
			}
		}
		FacturasRad=FacturasRad+"''";
		txtradicacion0=document.getElementById('txt_radicacion'+Ventana).value;
		txtradicacion=parseInt(txtradicacion0,10);
		txtfecrad=document.getElementById('txt_fecrad'+Ventana).value;
		txtnumrad=document.getElementById('txt_numrad'+Ventana).value;
		txtcontrow=document.getElementById('hdn_controw'+Ventana).value;

		$.ajax({  
		  type: "POST",  
		  url: Transact + "radicacionesconf.php",  
		  data: "Func=radicacionesconf&Facturas="+FacturasRad+"&radicacion="+txtradicacion+"&fecrad="+txtfecrad+"&numrad="+txtnumrad+"&controw="+txtcontrow,  
		  success: function(respuesta) { 

		  	MsgBox1("Radicacion de Cuentas", respuesta); 
				Consecutivo=respuesta.substr(respuesta.length-10,10);
				$("#frm_form"+Ventana)[0].reset();
				CargarReport("application/reports/radicaciones.php?CODIGO_INICIAL="+Consecutivo, "radicaciones");
				document.getElementById(NomGuardar).style.display  = 'block';
	
			
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function ContarFavs()
{
	$.get(Funciones,{'Func':'ContarFavs'},function(data){ 
		document.getElementById('hdn_favs').value=data;
	});
}	

function Guardar_empleados(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_Barrio'+Ventana).value=="") {
		xError="Digite el barrio del empleado.";}
	if (document.getElementById('txt_Direccion'+Ventana).value=="") {
		xError="Digite la direccion del empleado.";}
	if (document.getElementById('txt_Municipio'+Ventana).value=="") {
		xError="Digite el municipio del empleado.";}
	if (document.getElementById('txt_Departamento'+Ventana).value=="") {
		xError="Digite el departamento del empleado.";}
	if (document.getElementById('txt_fechanac'+Ventana).value=="") {
		xError="Ingrese la fecha de nacimiento del empleado.";}
	if (document.getElementById('txt_apellido1'+Ventana).value=="") {
		xError="Digite el apellido del empleado.";}
	if (document.getElementById('txt_nombre1'+Ventana).value=="") {
		xError="Digite el nombre del empleado.";}
	if (document.getElementById('txt_expedicion'+Ventana).value=="") {
		xError="Digite el lugar de expedicion del documento.";}
	if (document.getElementById('txt_idempleado'+Ventana).value=="") {
		xError="No se encuentra el Id del empleado.";}
	if  ((document.getElementById('txt_fechaing'+Ventana).value=="")||(document.getElementById('txt_fecharet'+Ventana).value=="//")) {
		xError="La fecha de ingreso no es válida";}
	if  ((document.getElementById('txt_fecharet'+Ventana).value=="")||(document.getElementById('txt_fecharet'+Ventana).value=="//")) {
		document.getElementById('txt_fecharet'+Ventana).value='01/01/1900';}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "empleados.php",  
		  data: "Func=empleados&"+RecorrerForm($("#frm_form"+Ventana)),
		  success: function(respuesta) { 
		  	MsgBox1("Empleados", respuesta); 
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

function GuardarTercero(TipoID, TheID, LugarExp, NombreTer) {
	xError="";
	if (TheID=="") {	xError="No";	}
	if (LugarExp=="") {		xError="No";	}
	if (NombreTer=="") {		xError="No";	}
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"terceros.php",  
		  data: "Func=terceros&TipoID="+TipoID+"&ID="+TheID+"&Expedicion="+LugarExp+"&RazonSocial="+NombreTer,
		  success: function(respuesta) { 
		  	MsgBox1("Terceros", respuesta); 
		  }  
		});  
		return false;  
	}
}

function startUpload(ventana,clase){
	document.getElementById("div_preupload"+ventana).style.visibility='visible';
	archivo=document.getElementById("hdn_"+clase+ventana).value;
	target=document.getElementById("upload_target"+ventana);
	var asignar=setInterval(function(){
		if(target){
			if(window.ActiveXObject){
				target.onreadystatechange=function(){
					if(target.readyState=='complete'){
	ExtensionImagen("files/images/"+clase+"/"+archivo);
						document.getElementById("div_foto"+ventana).style.backgroundImage="url("+ExtensionImagen("files/images/"+clase+"/"+archivo)+")";
						document.getElementById("div_preupload"+ventana).style.visibility = 'hidden';
					}
				}
				clearInterval(asignar);
				return;
			}
			target.onload=function(){
				document.getElementById("div_foto"+ventana).style.backgroundImage="url("+ExtensionImagen("files/images/"+clase+"/"+archivo)+")";
				document.getElementById("div_preupload"+ventana).style.visibility = 'hidden';
			}
			clearInterval(asignar);
		}
	},10);
return true;
}            

function startUpload2(ventana,clase){
	document.getElementById("div_preupload2"+ventana).style.visibility='visible';
	archivo=document.getElementById("hdn_"+clase+ventana).value;
	target=document.getElementById("upload_target2"+ventana);
	var asignar=setInterval(function(){
		if(target){
			if(window.ActiveXObject){
				target.onreadystatechange=function(){
					if(target.readyState=='complete'){
	ExtensionImagen("files/images/"+clase+"/"+archivo);
						document.getElementById("div_firma"+ventana).style.backgroundImage="url("+ExtensionImagen("files/images/"+clase+"/"+archivo)+")";
						document.getElementById("div_preupload2"+ventana).style.visibility = 'hidden';
					}
				}
				clearInterval(asignar);
				return;
			}
			target.onload=function(){
				document.getElementById("div_firma"+ventana).style.backgroundImage="url("+ExtensionImagen("files/images/"+clase+"/"+archivo)+")";
				document.getElementById("div_preupload2"+ventana).style.visibility = 'hidden';
			}
			clearInterval(asignar);
		}
	},10);
return true;
}            

function ExtensionImagen(archivo){
	if(file_exists(archivo+'.png')){
		archivoext=archivo+'.png';
	}else {
		if(file_exists(archivo+'.jpg')){
			archivoext=archivo+'.jpg';
		}else {
			if(file_exists(archivo+'.jpeg')){
				archivoext=archivo+'.jpeg';
			}else {
				if(file_exists(archivo+'.gif')){
					archivoext=archivo+'.gif';
				}
			}								
		}
	}
	return archivoext;
 }
 
function file_exists (url) {
    var req = this.window.ActiveXObject ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
    if (!req) {
        throw new Error('XMLHttpRequest not supported');
    }
    // HEAD Results are usually shorter (faster) than GET
    req.open('HEAD', url, false);
    req.send(null);
    if (req.status == 200) {
        return true;
    }
    return false;
}

function KillPic(ruta,archivo, ventana) {
	document.getElementById("div_preupload"+ventana).style.visibility='visible';
	$.get(Funciones,{'Func':'KillPic','value':ExtensionImagen(ruta+archivo), 'ruta':ruta, 'archivo':archivo},function(data){ 
		document.getElementById("div_foto"+ventana).style.backgroundImage="url("+ruta+"0.png)";
		MsgBox1("Imagen eliminada", "<b>[X]</b> "+data+"Si desea deshacer esta acción cierre el formulario sin guardar los datos. <b>[X]</b>");
	});
	document.getElementById("div_preupload"+ventana).style.visibility='hidden';
}

function KillFirma(ruta,archivo, ventana) {
	document.getElementById("div_preupload2"+ventana).style.visibility='visible';
	$.get(Funciones,{'Func':'KillFirma','value':ExtensionImagen(ruta+archivo), 'ruta':ruta, 'archivo':archivo},function(data){ 
		document.getElementById("div_firma"+ventana).style.backgroundImage="";
		MsgBox1("Firma eliminada", "<b>[X]</b> "+data+"Si desea deshacer esta acción cierre el formulario sin guardar los datos. <b>[X]</b>");
	});
	document.getElementById("div_preupload2"+ventana).style.visibility='hidden';
}

function Guardar_idnexusconf(Ventana)
{
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Ejecucion de las intrucciones para guardar los registros
		$.ajax({  
		  type: "POST",  
		  url: Transact +"idnexusconf.php",  
		  data: "Func=idnexusconf&"+RecorrerForm($("#frm_form"+Ventana)),
		  success: function(respuesta) { 
		  	MsgBox1("ID Nexus", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		});  
		return false;  
}

function Guardar_cargosemp(Ventana)
{
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Ejecucion de las intrucciones para guardar los registros
	$.ajax({ 
	  type: "POST", 
	  url: Transact + "cargosemp.php", 
	  data: "Func=cargosemp&"+RecorrerForm($("#frm_form"+Ventana)),
	  success: function(respuesta) { 
		MsgBox1("Actualización de cargos", respuesta); 
		document.getElementById(NomGuardar).style.display  = 'block';
	
	  }  
	});  
	return false;  
}

function Guardar_klpolizaedit(Ventana)
{
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Ejecucion de las intrucciones para guardar los registros
	$.ajax({ 
	  type: "POST", 
	  url: Transact +"klpolizaedit.php", 
	  data: "Func=klpolizaedit&"+RecorrerForm($("#frm_form"+Ventana)),
	  success: function(respuesta) { 
		MsgBox1("Edicion de Polizas", respuesta); 
		document.getElementById(NomGuardar).style.display  = 'block';
	
	  }  
	});  
	return false;  
}
function rptND(Pref,Consecutivo)
{
	CargarWind("Nota Debito "+Pref+Consecutivo, 'reports/notacredito.php?TIPO_NOTA=D&PREFIJO='+Pref+'&CODIGO_INICIAL='+Consecutivo+'&CODIGO_FINAL='+Consecutivo, 'default.png', 'notadebitolista.php',"rptND" );
}
function rptNC(Pref,Consecutivo)
{
	CargarWind("Nota Debito "+Pref+Consecutivo, 'reports/notacredito.php?TIPO_NOTA=C&PREFIJO='+Pref+'&CODIGO_INICIAL='+Consecutivo+'&CODIGO_FINAL='+Consecutivo, 'default.png', 'notadebitolista.php',"rptNC" );
}

function rptInvoice(Pref,Consecutivo)
{
	CargarWind("Factura "+Pref+Consecutivo, 'reports/facturasaluddet.php?PREFIJO='+Pref+'&CODIGO_INICIAL='+Consecutivo+'&CODIGO_FINAL='+Consecutivo, 'default.png', 'facturasaludlista.php',"rptinvoice" );
}
function Guardar_facturaedit(Ventana)
{
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Ejecucion de las intrucciones para guardar los registros
	$.ajax({ 
	  type: "POST", 
	  url: Transact +"facturaedit.php", 
	  data: "Func=facturaedit&"+RecorrerForm($("#frm_form"+Ventana)),
	  success: function(respuesta) { 
		MsgBox1("Edicion de Facturas", respuesta); 
		document.getElementById(NomGuardar).style.display  = 'block';
	
	  }  
	});  
	return false;  
}

function Guardar_salariosemp(Ventana)
{
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Ejecucion de las intrucciones para guardar los registros
	$.ajax({ 
	  type: "POST", 
	  url: Transact +"salariosemp.php", 
	  data: "Func=salariosemp&"+RecorrerForm($("#frm_form"+Ventana)),
	  success: function(respuesta) { 
		MsgBox1("Actualización de Salarios", respuesta); 
		document.getElementById(NomGuardar).style.display  = 'block';
	
	  }  
	});  
	return false;  
}

function Guardar_areasemp(Ventana)
{
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Ejecucion de las intrucciones para guardar los registros
	$.ajax({ 
	  type: "POST", 
	  url: Transact +"czareasterceros.php", 
	  data: "Func=czareasterceros&"+RecorrerForm($("#frm_form"+Ventana)),
	  success: function(respuesta) { 
		MsgBox1("Actualización de áreas asignadas", respuesta); 
		document.getElementById(NomGuardar).style.display  = 'block';
	
	  }  
	});  
	return false;  
}

function Guardar_festivos(Ventana)
{
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Ejecucion de las intrucciones para guardar los registros
	$.ajax({ 
	  type: "POST", 
	  url: Transact + "festivos.php", 
	  data: "Func=festivos&"+RecorrerForm($("#frm_form"+Ventana)),
	  success: function(respuesta) { 
		MsgBox1("Configuración de Festivos", respuesta); 
		document.getElementById(NomGuardar).style.display  = 'block';
	
	  }  
	});  
	return false;  
}

function Guardar_areascz(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		document.getElementById('txt_codigo'+Ventana).value='0';}
		
	if (document.getElementById('txt_nombre'+Ventana).value=="") {
		xError="Digite el nombre del área.";}
	if (document.getElementById('txt_idempleado'+Ventana).value=="") {
		xError="Digite la identificación del responsable.";}
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "areascz.php",  
		  data: "Func=areascz&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Areas", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
				AbrirForm('application/forms/areascz.php', Ventana, '');
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_notasdebito(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_fecha'+Ventana).value=="") {
		xError="Digite fecha de la nota.";}
	if (document.getElementById('txt_factura'+Ventana).value=="") {
		xError="Digite el numero de factura.";}
	if (document.getElementById('txt_valornc'+Ventana).value=="0") {
		xError="El valor de la nota credito no puede ser cero.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"notasdebito.php",  
		  data: "Func=notasdebito&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  MsgBox1("Notas Debito", respuesta); 
		  if (respuesta.indexOf("message_ok")>10) {
			Consecutivo=respuesta.substr(respuesta.length-10,10);
			CargarReport("application/reports/notadebito.php?CODIGO_INICIAL="+Consecutivo+"CODIGO_FINAL="+Consecutivo, "Nota Debito");
			$("#frm_form"+Ventana)[0].reset();
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		  }
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_notascredito(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_fecha'+Ventana).value=="") {
		xError="Digite fecha de la nota.";}
	if (document.getElementById('txt_factura'+Ventana).value=="") {
		xError="Digite el numero de factura.";}
	if (document.getElementById('txt_valornc'+Ventana).value=="0") {
		xError="El valor de la nota credito no puede ser cero.";}

	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact +"notascredito.php",  
		  data: "Func=notascredito&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  MsgBox1("Notas Credito", respuesta); 
		  if (respuesta.indexOf("message_ok")>10) {
			Consecutivo=respuesta.substr(respuesta.length-10,10);
			CargarReport("application/reports/notacredito.php?CODIGO_INICIAL="+Consecutivo+"CODIGO_FINAL="+Consecutivo, "Nota Credito");
			$("#frm_form"+Ventana)[0].reset();
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		  }
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_perfilesusuarios(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "perfilesusuarios.php",  
		  data: "Func=perfilesusuarios&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Perfiles de Usuarios", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_cargos(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_codigo'+Ventana).value=="") {
		document.getElementById('txt_codigo'+Ventana).value='-';}
		
	if (document.getElementById('txt_nombre'+Ventana).value=="") {
		xError="Digite el nombre del cargo.";}
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "cargos.php",  
		  data: "Func=cargos&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Cargos", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
				AbrirForm('application/forms/cargos.php', Ventana, '');
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_marcacionesid(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById('txt_idempleado'+Ventana).value=="") {
		xError="Digite el empleado.";}
		
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "marcacionesid.php",  
		  data: "Func=marcacionesid&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Ingreso Manual de Marcaciones", respuesta); 
			document.getElementById(NomGuardar).style.display  = 'block';
	
				AbrirForm('application/forms/marcacionesid.php', Ventana, '');
		  }  
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Guardar_solicitudods(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	NoVentana=Ventana;
	Ventana="zWind_"+Ventana;
	document.getElementById("txt_ods"+Ventana).value=document.getElementById("hdn_odsx"+Ventana).value;
	if (document.getElementById("txt_nombreods"+Ventana).value=="") {
		xError="Debe colocar un título a la orden de servicio.";}
	if (document.getElementById("txt_solicitud"+Ventana).value=="") {
		xError="Debe describir la solicitud de la orden de servicio.";}
	
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "solicitudods.php",  
		  data: "Func=solicitudods&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Solicitud ODS", respuesta); 
			if (respuesta.indexOf("message_ok")>10) {
				Consecutivo=respuesta.substr(respuesta.length-6,6);
				Consecutivo=Consecutivo+1-1;
				Consecutivo=Consecutivo.substr(respuesta.length-1,1);
				$("#frm_form"+Ventana)[0].reset();
				document.getElementById(NomGuardar).style.display  = 'block';
	
				AbrirForm('application/forms/solicitudods.php', Ventana, '&numods='+Consecutivo);
		  	}
		 } 
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}

}

function Guardar_respuestaods(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	NoVentana=Ventana;
	Ventana="zWind_"+Ventana;
	document.getElementById("txt_ods"+Ventana).value=document.getElementById("hdn_odsx"+Ventana).value;
	if (document.getElementById("txt_nombreods"+Ventana).value=="") {
		xError="Debe colocar un título a la orden de servicio.";}
	if (document.getElementById("txt_solicitud"+Ventana).value=="") {
		xError="Debe describir la solicitud de la orden de servicio.";}
	
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "respuestaods.php",  
		  data: "Func=respuestaods&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Tareas ODS", respuesta); 
			if (respuesta.indexOf("message_ok")>10) {
				Consecutivo=respuesta.substr(respuesta.length-6,6);
				Consecutivo=Consecutivo+1-1;
				Consecutivo=Consecutivo.substr(respuesta.length-1,1);
				$("#frm_form"+Ventana)[0].reset();
				document.getElementById(NomGuardar).style.display  = 'block';
	
				AbrirForm('application/forms/respuestaods.php', Ventana, '&numods='+Consecutivo);
		  	}
		 } 
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}

}

function Guardar_turnosmes(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	NoVentana=Ventana;
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById("hdn_conta"+Ventana).value=="0") {
		xError="Verfique los datos y de click a la imagen 'Cargar Horario'";}
		
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "turnosmes.php",  
		  data: "Func=turnosmes&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	MsgBox1("Programación de turnos", respuesta); 
		  	CargueTurno='CargarHorario'+Ventana+'();';
			eval(CargueTurno);
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  } 
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Imprimir_turnosmes(Ventana)
{
	Ventana="zWind_"+Ventana;
	Anyop=document.getElementById("txt_anyo"+Ventana).value;	
	Mesp=document.getElementById("cmb_mes"+Ventana).value;
	Contratop=document.getElementById("cmb_contrato"+Ventana).value;
	Areap=document.getElementById("cmb_areas"+Ventana).value;
	CargarReport("application/reports/turnosmes.php?CODIGO_AREA="+Areap+"&CODIGO_CONTRATO="+Contratop+"&CODIGO_MES="+Mesp+"&CODIGO_ANYO="+Anyop, "Turnos Mes");
}

function Guardar_myturnos(Ventana)
{
	xError="";
	NomGuardar="Guardar"+Ventana;
	document.getElementById(NomGuardar).style.display  = 'none';
	
	NoVentana=Ventana;
	Ventana="zWind_"+Ventana;
	//Se verifica la validez de los campos...
	if (document.getElementById("hdn_controw"+Ventana).value=="0") {
		xError="No ha cargado turnos en la plantilla";}
	if (document.getElementById("txt_nombre"+Ventana).value=="") {
		xError="Debe asiganrle un nombre a la programación";}
	if (document.getElementById("txt_fechaini"+Ventana).value=="") {
		xError="Seleccione la fecha inicial de la programación";}
	if (document.getElementById("txt_fechafin"+Ventana).value=="") {
		xError="Seleccione la fecha final de la programación";}
	var array_fecha1 = document.getElementById("txt_fechaini"+Ventana).value.split("/") ;
	var array_fecha2 = document.getElementById("txt_fechafin"+Ventana).value.split("/") ;
	var f1 =  new Date(array_fecha1[2], array_fecha1[1], array_fecha1[0]);
	var f2 =  new Date(array_fecha2[2], array_fecha2[1], array_fecha2[0]);
	var diffec = f2.getTime() -f1.getTime();
	if (diffec<0) {
		xError="La fecha final de la programación no puede ser menor que la inicial";}
		
	//Ejecucion de las intrucciones para guardar los registros
	if (xError=="") {
		$.ajax({  
		  type: "POST",  
		  url: Transact + "myturnos.php",  
		  data: "Func=myturnos&"+RecorrerForm($("#frm_form"+Ventana)),  
		  success: function(respuesta) { 
		  	$.get(Funciones,{'Func':'MaxMyTurnos'},function(data){
				document.getElementById("txt_codtrn"+Ventana).value=data;
			});
		  	MsgBox1("Programación semanal de turnos", respuesta); 
		  	document.getElementById("Imprimir"+NoVentana).style.display='inline';
			document.getElementById(NomGuardar).style.display  = 'block';
	
		  } 
		});  
		return false;  
	} else {
		MsgBox1("Error", xError);
		document.getElementById(NomGuardar).style.display  = 'block';
	
	}
}

function Imprimir_myturnos(Ventana)
{
	Ventana="zWind_"+Ventana;
	MyCode=document.getElementById("txt_codtrn"+Ventana).value;	
	CargarReport("application/reports/myturnos.php?CODIGO="+MyCode, "Programación semanal de turnos");
}