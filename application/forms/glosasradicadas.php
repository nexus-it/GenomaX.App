<?php

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>

<form>
	<label class="label label-success"> DATOS DE RESPUESTA A RADICAR</label>
		<div class="row well well-sm 12">
			
			<div class="col-md-2 " >
				<div class="form-group">
			      <label for="txt_nresp">N° Respuesta</label>
				  <input type="text" class="form-control" id="txt_nresp">
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
			      <label for="txt_nglosa">N° Glosa</label>
				  <input type="text" class="form-control" id="txt_nglosa">
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
			      <label for="txt_nfact">N° Factura</label>
				  <input type="text" class="form-control" id="txt_nfact">
				</div>
			</div>
			<div class="col-md-4">
				<div class="form-group">
			      <label for="txt_pac">Paciente</label>
				  <input type="text" class="form-control" id="txt_pac">
				</div>
			</div>
			<div class="col-md-1"></div>
			<div class="col-md-1"></div>
			<div class="col-md-4">
				<div class="form-group">
			      <label for="txt_responsable">Responsable</label>
				  <input type="text" class="form-control" id="txt_responsable">
				</div>
			</div>
			<div class="col-md-3"></div>

			<div class="col-md-2">
				<div class="form-group" type="datepicker">
					<form method="post">
					    <div class="form-group"> <!-- Date input -->
					    	<label class="control-label" for="date">Fecha</label>
					        <label class="control-label" for="date">  Respuesta  </label>
					        <input type="date" name="fecha" step="1" min="2013-01-01" max="2025-12-31" value="AAAA-MM-DD">
					    </div>
					</form>
				</div>
			</div>
			<div class="col-md-3"></div>

			<div class="col-md-4">
				<div class="form-group" type="datepicker">
					<form method="post">
					    <div class="form-group"> <!-- Date input -->
					    	<label class="control-label" for="date">Fecha de radicacion a colocar</label>
					        <input type="date" name="fecha" step="1" min="2013-01-01" max="2025-12-31" value="AAAA-MM-DD">
					    </div>
					</form>
				</div>
			</div>
		</div>

		<div class="row well well-sm 12">
			<div class="col-md-2"></div>
			<div class="col-md-3">
				<div class="form-group">
					<button type="button" for="control-label" class="col-md-6 btn btn-success">Radicar</button>
				</div>
			</div>	
			<div class="col-md-3">
				<div class="form-group">
					<button type="button" for="control-label" class="col-md-6 btn btn-success">Cancelar</button>
				</div>
			</div>	
			<div class="col-md-3">
				<div class="form-group">
					<button type="button" for="control-label" class="col-md-6 btn btn-success">Salir</button>
				</div>
			</div>	

		</div>

	</form>
	

<script >

<?php
	
	if (isset($_GET["IdMed"])) {
		if (trim($_GET["IdMed"])!="") {
			$SQL="Select Codigo_TER, Nombre_TER From  czterceros a Where  ID_TER='".$_GET["IdMed"]."'";
			$result = mysqli_query($conexion, $SQL);
			if ($row = mysqli_fetch_array($result)) {
			echo "
				document.frm_form".$NumWindow.".txt_idempleado".$NumWindow.".value='".$_GET["IdMed"]."';
				document.frm_form".$NumWindow.".txt_paciente".$NumWindow.".value='".$row[1]."';
				document.frm_form".$NumWindow.".hdn_tercero".$NumWindow.".value='".$row[0]."';";
			}
			mysqli_free_result($result); 
		}
	} else {
		
	}
	echo "
	document.frm_form".$NumWindow.".txt_hini".$NumWindow.".value='08:00';
	document.frm_form".$NumWindow.".txt_hfin".$NumWindow.".value='18:00';
	document.frm_form".$NumWindow.".txt_minutos".$NumWindow.".value='15';
	";
	$SQL="Select date(now());";
	$result = mysqli_query($conexion, $SQL);
	if ($row = mysqli_fetch_array($result))  {
		echo "
		document.frm_form".$NumWindow.".txt_fecha".$NumWindow.".value='".$row[0]."';";
	}
	mysqli_free_result($result); 
	
	$SQL="Select HoraIni_ARE, HoraFin_ARE, TiempoConsulta_ARE From gxareas Where Codigo_ARE in (Select Codigo_ARE from gxareas where Estado_ARE='1' and AgendaCitas_ARE='1' order by Nombre_ARE ) Limit 1;";
	$result = mysqli_query($conexion, $SQL);
	if ($row = mysqli_fetch_array($result))  {
		echo "
		document.frm_form".$NumWindow.".txt_hini".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".txt_hfin".$NumWindow.".value='".$row[1]."';
		document.frm_form".$NumWindow.".txt_minutos".$NumWindow.".value='".$row[2]."';";
	}
	mysqli_free_result($result); 
	
	if (isset($_GET["Fecha"])) {
		echo "
		document.frm_form".$NumWindow.".txt_fecha".$NumWindow.".value='".$_GET["Fecha"]."';";	
	}
	if (isset($_GET["Area"])) {
		echo "
		document.frm_form".$NumWindow.".cmb_area".$NumWindow.".value='".$_GET["Area"]."';";
	}
	if (isset($_GET["HIni"])) {
		echo "
		document.frm_form".$NumWindow.".txt_hini".$NumWindow.".value='".$_GET["HIni"]."';";	
	}
	if (isset($_GET["HFin"])) {
		echo "
		document.frm_form".$NumWindow.".txt_hfin".$NumWindow.".value='".$_GET["HFin"]."';";	
	}
	if (isset($_GET["Time"])) {
		echo "
		document.frm_form".$NumWindow.".txt_minutos".$NumWindow.".value='".$_GET["Time"]."';";	
	}
?>

semana<?php echo $NumWindow; ?>(document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value);
AgendaZero<?php echo $NumWindow; ?>();
AgendaIni<?php echo $NumWindow; ?>();

function semana<?php echo $NumWindow; ?>(Fecha) 
{
	Fechaz ="" + Fecha;
	dia=Fechaz.substring(8, 10);
	anio=Fechaz.substring(0, 4);
	mez=Fechaz.substring(5, 7);
	meses = ["January","February","March","April","May","June","July","August","September" ,"October","November","December"];
	mes=meses[mez-1];
	dt = new Date(mes+' '+dia+', '+anio);
	diasemana=dt.getUTCDay();
	d1 = dt.getTime() + ((1-diasemana)*24*60*60*1000);
	dlun=new Date(d1);
	document.getElementById('txt_fini<?php echo $NumWindow; ?>').value=dlun.getFullYear()+"-"+(('0' + (dlun.getMonth()+1)).slice(-2))+"-"+(('0' + dlun.getDate()).slice(-2));
	document.getElementById('spnlunes<?php echo $NumWindow; ?>').innerHTML=dlun.getFullYear()+"-"+(('0' + (dlun.getMonth()+1)).slice(-2))+"-"+(('0' + dlun.getDate()).slice(-2));
	document.getElementById('hdn_fechalun<?php echo $NumWindow; ?>').value=dlun.getFullYear()+"-"+(('0' + (dlun.getMonth()+1)).slice(-2))+"-"+(('0' + dlun.getDate()).slice(-2));
	d2 = dt.getTime() + ((2-diasemana)*24*60*60*1000);
	dmar=new Date(d2);
	document.getElementById('spnmartes<?php echo $NumWindow; ?>').innerHTML=dmar.getFullYear()+"-"+(('0' + (dmar.getMonth()+1)).slice(-2))+"-"+(('0' + dmar.getDate()).slice(-2));
	document.getElementById('hdn_fechamar<?php echo $NumWindow; ?>').value=dmar.getFullYear()+"-"+(('0' + (dmar.getMonth()+1)).slice(-2))+"-"+(('0' + dmar.getDate()).slice(-2));
	d3 = dt.getTime() + ((3-diasemana)*24*60*60*1000);
	dmie=new Date(d3);
	document.getElementById('spnmiercoles<?php echo $NumWindow; ?>').innerHTML=dmie.getFullYear()+"-"+(('0' + (dmie.getMonth()+1)).slice(-2))+"-"+(('0' + dmie.getDate()).slice(-2));
	document.getElementById('hdn_fechamie<?php echo $NumWindow; ?>').value=dmie.getFullYear()+"-"+(('0' + (dmie.getMonth()+1)).slice(-2))+"-"+(('0' + dmie.getDate()).slice(-2));
	d4 = dt.getTime() + ((4-diasemana)*24*60*60*1000);
	djue=new Date(d4);
	document.getElementById('spnjueves<?php echo $NumWindow; ?>').innerHTML=djue.getFullYear()+"-"+(('0' + (djue.getMonth()+1)).slice(-2))+"-"+(('0' + djue.getDate()).slice(-2));
	document.getElementById('hdn_fechajue<?php echo $NumWindow; ?>').value=djue.getFullYear()+"-"+(('0' + (djue.getMonth()+1)).slice(-2))+"-"+(('0' + djue.getDate()).slice(-2));
	d5 = dt.getTime() + ((5-diasemana)*24*60*60*1000);
	dvie=new Date(d5);
	document.getElementById('spnviernes<?php echo $NumWindow; ?>').innerHTML=dvie.getFullYear()+"-"+(('0' + (dvie.getMonth()+1)).slice(-2))+"-"+(('0' + dvie.getDate()).slice(-2));
	document.getElementById('hdn_fechavie<?php echo $NumWindow; ?>').value=dvie.getFullYear()+"-"+(('0' + (dvie.getMonth()+1)).slice(-2))+"-"+(('0' + dvie.getDate()).slice(-2));
	d6 = dt.getTime() + ((6-diasemana)*24*60*60*1000);
	dsab=new Date(d6);
	document.getElementById('spnsabado<?php echo $NumWindow; ?>').innerHTML=dsab.getFullYear()+"-"+(('0' + (dsab.getMonth()+1)).slice(-2))+"-"+(('0' + dsab.getDate()).slice(-2));
	document.getElementById('hdn_fechasab<?php echo $NumWindow; ?>').value=dsab.getFullYear()+"-"+(('0' + (dsab.getMonth()+1)).slice(-2))+"-"+(('0' + dsab.getDate()).slice(-2));
	document.getElementById('txt_ffin<?php echo $NumWindow; ?>').value=dsab.getFullYear()+"-"+(('0' + (dsab.getMonth()+1)).slice(-2))+"-"+(('0' + dsab.getDate()).slice(-2));

	
}

function CalcHorasCons<?php echo $NumWindow; ?>() {
	MsgBox1("Advertencia","Esta accion eliminará cualquier apertura de agenda previa del profesional "+document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value+" en el periodo comprendido entre el "+document.frm_form<?php echo $NumWindow; ?>.txt_fini<?php echo $NumWindow; ?>.value+" y el "+document.frm_form<?php echo $NumWindow; ?>.txt_ffin<?php echo $NumWindow; ?>.value);
	AgendaZero<?php echo $NumWindow; ?>();
	AgendaIni<?php echo $NumWindow; ?>();
} 

function AgendaIni<?php echo $NumWindow; ?>() {
	var horaini = (document.getElementById('txt_hini<?php echo $NumWindow; ?>').value).split(":");
    horafin = (document.getElementById('txt_hfin<?php echo $NumWindow; ?>').value).split(":");
    tini = new Date();
    tfin = new Date();
    ttotal = new Date();
	 
	tini.setHours(horaini[0], horaini[1], '00');
	tfin.setHours(horafin[0], horafin[1], '00');
	 
	//Aquí hago la resta
	ttotal.setHours(tfin.getHours() - tini.getHours(), tfin.getMinutes() - tini.getMinutes(), '00');
	TotalMins=ttotal.getHours()*60+ttotal.getMinutes();
	TiempoConsulta=document.getElementById('txt_minutos<?php echo $NumWindow; ?>').value;
	NumConsxDia=Math.floor(TotalMins/TiempoConsulta);
	
	tactual = new Date();
	tactual=tini;
	for (i = 1; i <= NumConsxDia; i++) { 
		
		lahora=tactual.getHours();
		if (lahora <10) lahora='0'+lahora;
		elminuto=tactual.getMinutes();
		if (elminuto <10) elminuto='0'+elminuto;
		
		horaactual=lahora +':' + elminuto +':00';

		FillHours<?php echo $NumWindow; ?>('lun', horaactual);
		FillHours<?php echo $NumWindow; ?>('mar', horaactual);
		FillHours<?php echo $NumWindow; ?>('mie', horaactual);
		FillHours<?php echo $NumWindow; ?>('jue', horaactual);
		FillHours<?php echo $NumWindow; ?>('vie', horaactual);
		FillHours<?php echo $NumWindow; ?>('sab', horaactual);

		tactual.setSeconds(TiempoConsulta*60);
	}
	
}

function FillHours<?php echo $NumWindow; ?>(diasemana, horaactual) {
	
	    TotalFilas=document.getElementById("hdn_controw"+diasemana+"<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tblDetalle"+diasemana+"<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda1 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="tr"+diasemana+TotalFilas+"<?php echo $NumWindow; ?>";
		celda1.innerHTML = '<div class="checkbox checkbox-success">	<input name="chk_'+diasemana+TotalFilas+'chk<?php echo $NumWindow; ?>" id="chk_'+diasemana+TotalFilas+'chk<?php echo $NumWindow; ?>" type="checkbox" value="0"  onclick="javascript:calcconsultas<?php echo $NumWindow; ?>(\''+diasemana+'\');" class="styled"> <label for="chk_'+diasemana+TotalFilas+'chk<?php echo $NumWindow; ?>">'+ horaactual +'</label> <input name="hdn_'+diasemana+'time'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_'+diasemana+'time'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ horaactual +'" /> </div>'; 
		fila.appendChild(celda1); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controw"+diasemana+"<?php echo $NumWindow; ?>").value=TotalFilas;
		
}

function MarcarTodos<?php echo $NumWindow; ?>(dia) {
	TotalConsultas=document.getElementById('hdn_controw'+dia+'<?php echo $NumWindow; ?>').value;
	Chekear="false";
	if(document.getElementById('chk_'+dia+'<?php echo $NumWindow; ?>').checked) {
		Chekear="true";
	}
	for (i = 1; i <= TotalConsultas; i++) { 
		eval('window.document.frm_form<?php echo $NumWindow; ?>.chk_'+dia+i+'chk<?php echo $NumWindow; ?>.checked='+Chekear);
	}
	calcconsultas<?php echo $NumWindow; ?>(dia);
}

function calcconsultas<?php echo $NumWindow; ?>(dia){
	TotalConsultas=document.getElementById('hdn_controw'+dia+'<?php echo $NumWindow; ?>').value;
	Contador=0;
	for (i = 1; i <= TotalConsultas; i++) { 
		document.getElementById('chk_'+dia+i+'chk<?php echo $NumWindow; ?>').value="0";
		if(document.getElementById('chk_'+dia+i+'chk<?php echo $NumWindow; ?>').checked) {
			document.getElementById('chk_'+dia+i+'chk<?php echo $NumWindow; ?>').value="1";
			Contador++;
		}
	}
	document.getElementById('cns_'+dia+'x<?php echo $NumWindow; ?>').value=Contador+ " CONSULTAS";
	document.getElementById('cns_'+dia+'<?php echo $NumWindow; ?>').value=Contador;
	Total=0;
	Total=Total+parseInt(document.getElementById('cns_lun<?php echo $NumWindow; ?>').value)+parseInt(document.getElementById('cns_mar<?php echo $NumWindow; ?>').value)+parseInt(document.getElementById('cns_mie<?php echo $NumWindow; ?>').value)+parseInt(document.getElementById('cns_jue<?php echo $NumWindow; ?>').value)+parseInt(document.getElementById('cns_vie<?php echo $NumWindow; ?>').value)+parseInt(document.getElementById('cns_sab<?php echo $NumWindow; ?>').value);
	document.getElementById('txt_totcons<?php echo $NumWindow; ?>').value=Total;
}

function AgendaZero<?php echo $NumWindow; ?>() {
	totallun=document.frm_form<?php echo $NumWindow; ?>.hdn_controwlun<?php echo $NumWindow; ?>.value;
	for (i = 1; i <= totallun; i++) { 
	    $('#trlun'+i+"<?php echo $NumWindow; ?>").remove();
	}
	document.frm_form<?php echo $NumWindow; ?>.hdn_controwlun<?php echo $NumWindow; ?>.value="0";
	totalmar=document.frm_form<?php echo $NumWindow; ?>.hdn_controwmar<?php echo $NumWindow; ?>.value;
	for (i = 1; i <= totalmar; i++) { 
	    $('#trmar'+i+"<?php echo $NumWindow; ?>").remove();
	}
	document.frm_form<?php echo $NumWindow; ?>.hdn_controwmar<?php echo $NumWindow; ?>.value="0";
	totalmie=document.frm_form<?php echo $NumWindow; ?>.hdn_controwmie<?php echo $NumWindow; ?>.value;
	for (i = 1; i <= totalmie; i++) { 
	    $('#trmie'+i+"<?php echo $NumWindow; ?>").remove();
	}
	document.frm_form<?php echo $NumWindow; ?>.hdn_controwmie<?php echo $NumWindow; ?>.value="0";
	totaljue=document.frm_form<?php echo $NumWindow; ?>.hdn_controwjue<?php echo $NumWindow; ?>.value;
	for (i = 1; i <= totaljue; i++) { 
	    $('#trjue'+i+"<?php echo $NumWindow; ?>").remove();
	}
	document.frm_form<?php echo $NumWindow; ?>.hdn_controwjue<?php echo $NumWindow; ?>.value="0";
	totalvie=document.frm_form<?php echo $NumWindow; ?>.hdn_controwvie<?php echo $NumWindow; ?>.value;
	for (i = 1; i <= totalvie; i++) { 
	    $('#trvie'+i+"<?php echo $NumWindow; ?>").remove();
	}
	document.frm_form<?php echo $NumWindow; ?>.hdn_controwvie<?php echo $NumWindow; ?>.value="0";
	totalsab=document.frm_form<?php echo $NumWindow; ?>.hdn_controwsab<?php echo $NumWindow; ?>.value;
	for (i = 1; i <= totalsab; i++) { 
	    $('#trsab'+i+"<?php echo $NumWindow; ?>").remove();
	}
	document.frm_form<?php echo $NumWindow; ?>.hdn_controwsab<?php echo $NumWindow; ?>.value="0";
	
}

function AddHoraDia<?php echo $NumWindow; ?>(dia, fecha, hora) {
	Indicacion=Indicacion.toUpperCase();
		TotalFilas=document.getElementById("hdn_controwTto<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbTtmntoX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
		TotalFilas++;
		fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
	    celda1.innerHTML = '<input name="hdn_indicacion'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_indicacion'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Indicacion+''+'" /> - '+Indicacion; 
		celda2.innerHTML = '<button onclick="EliminarFilaTto<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwTto<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_indicaciones<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_indicaciones<?php echo $NumWindow; ?>').focus();
}

function LoadAgenda<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
  	CargarAgenda<?php echo $NumWindow; ?>();
  }
}

function CargarAgenda<?php echo $NumWindow; ?>() {
	HoraIni=document.getElementById('txt_hini<?php echo $NumWindow; ?>').value;
	HoraFin=document.getElementById('txt_hfin<?php echo $NumWindow; ?>').value;
	Tiempoz=document.getElementById('txt_minutos<?php echo $NumWindow; ?>').value;
	Area=document.getElementById('cmb_area<?php echo $NumWindow; ?>').value;
	Fechaz=document.getElementById('txt_fecha<?php echo $NumWindow; ?>').value;
  	if (document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/agenda.php', '<?php echo $NumWindow; ?>', '&Area='+Area+'&Fecha='+Fechaz+'&HIni='+HoraIni+'&HFin='+HoraFin+'&Time='+Tiempoz);
	} else {
		AbrirForm('application/forms/agenda.php', '<?php echo $NumWindow; ?>', '&IdMed='+document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value+'&Area='+Area+'&Fecha='+Fechaz+'&HIni='+HoraIni+'&HFin='+HoraFin+'&Time='+Tiempoz);
	}  
}

function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/agenda.php', '<?php echo $NumWindow; ?>', '');	
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
