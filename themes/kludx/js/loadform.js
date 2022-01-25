// JavaScript Document
var CurTab=1; // para saber cual es la ventana a posicionar arriba
var ContaForms=1;
var ContaReports=0;
var ContaSearch=0;
var ContaPass=0;

function AbrirForm(Pagina, Contenedor, Params)
{
	// haySession();
	$("#"+Contenedor).load(Pagina+"?target="+Contenedor+Params);
	MngrToolBar(Pagina, Contenedor+".");
}

function ExecRpt(Pagina, Contenedor)
{
	$("#"+Contenedor).load(Pagina);
}

function AbrirReport(Pagina, Contenedor, Params)
{
	Temporal=Pagina.substring(Pagina.indexOf('?'),Pagina.length);
	Params=Params+"&"+Temporal.substring(1,Temporal.length);
	Pagina=Pagina.substring(20,Pagina.indexOf('.'))
	$("#"+Contenedor).load("application/reports/reports.php?reporte="+Pagina+"&target="+Contenedor+Params);
}

function OpenRpt(Pagina, Contenedor, Params)
{
	Temporal=Pagina.substring(Pagina.indexOf('?'),Pagina.length);
	Params=Params+"&"+Temporal.substring(1,Temporal.length);
	Pagina=Pagina.substring(20,Pagina.indexOf('.'))
	$("#"+Contenedor).load("application/reports/rpt.php?reporte="+Pagina+"&target="+Contenedor+Params);
}

function inicioEnvio(Destino)
{
  var x=$(Destino);
  x.html('<img src="../loadingform.gif">');
}

function AbrirSearch(Contenedor, Destino, Titulo, Where)
{
	$("#"+Contenedor).load('application/forms/buscar.php?box='+Destino+'&target='+Contenedor+'&req='+Titulo+'&cond='+Where);

}

function AbrirChngPass(Contenedor)
{
	$("#"+Contenedor).load('application/forms/clave.php');
}

function MngrToolBar(NomWind,NumWind) {
		NombrePag=NomWind.substring(18,NomWind.indexOf('.'));
		NumeroPag=NumWind.substring(6,NumWind.indexOf('.'));
		NxsToolBar(NomWind,NombrePag);
}

$(".GhenWindow").scroll(function () {
    if ($(this).scrollTop() >= 30) {
        alert($(this).scrollTop());
    }
});

function gxFullScreen() {
	HideOptions();
	HideModules();
}
function gxNormalScreen() {
	ShowOptions();
	ShowModules();
}
function HideModules() {
	$('.WokArea').css('border-style','none');
	$('.barmodulos').fadeOut(700);
	$("#zerocontainer").css("top", "32px");
	$('#MainMenu').fadeOut(500);
	$('#gxWindowsTabs').css('background-image','none');
	$('#gxWindowsTabs').css('background-color','#346702');
	$('#ShowOptions').fadeOut(400);
	$('#logo').css('transform','scale(0.5,0.5)');
	$('#logo').css('top','-10px');
	$('#logo').css('left','-10px');
	$('#Show_menu').fadeIn(800);
}
function ShowModules() {
	$('#Show_menu').fadeOut(800);
	$('.WokArea').css('border-style','ridge');
	$("#zerocontainer").css("top", "123px");
	$('#MainMenu').fadeIn(400);
	$('.barmodulos').fadeIn(600);
	$('#logo').css('transform','scale(1,1)');
	$('#logo').css('top','4px');
	$('#logo').css('left','5px');
}
function HideOptions() {
	$('.ContItems').fadeOut(600);
	$('#TitItems').fadeOut(800);
	document.getElementById("OptItems").style.width = '1px';
	$(".WokArea").css("left", "0px");
	$('#ShowOptions').fadeIn(900);
}
function ShowOptions() {
	document.getElementById("ShowOptions").style.display = 'none';
	$(".WokArea").css("left", "200px");
	document.getElementById("OptItems").style.width = '200px';
	$('#TitItems').fadeIn(2400);
	$('.ContItems').fadeIn(2500);

}
function MostrarOpcines(Grupo, Opcion, Titulo) {
	ShowOptions();
	document.getElementById('gxOpciones').innerHTML=Titulo;
	$('.GrupoItems').fadeOut(40);
	$('#'+Grupo).fadeIn(800);
}
function ShowDashboard() {
	MostrarOpcines('GenomaX', '-','Mi Escritorio');
	$('#gxtabs a:first').tab('show');
}
function CargarForm(Pag, Tit, Ico) {
	var Parametros="";
	var SwParam=0;
	SwParam=Pag.indexOf('?');
	if (SwParam>0) {
		Parametros='&'+Pag.substring(SwParam+1);
		Pag=Pag.substring(0,SwParam);
	}
	if ("application/../"==Pag.substring(0,15)) {
		Pag=Pag.substring(15,(Pag.length -15));
	} 
	if ("application/reports"==Pag.substring(0,19)) {
		if (Ico=="database_table.png") {
			CargarDataReport(Pag, Tit);
		} else {
			CargarReport(Pag, Tit);
		}
	} else {
	ContaForms++;
	//Primero el tab...
	var li0 = $(document.createElement('li')).attr('role','presentation').appendTo('#gxtabs');
	$(li0).attr('id','gxt' + ContaForms);
	$(li0).attr('title', Tit);
	$(li0).attr('class','nav-item');
	imagenlogo="<img src=\"http://cdn.genomax.co/media/image/icons/16x16/"+Ico+"\" align=\"left\"/> ";
	var a0 = $(document.createElement('button')).attr('id','gxta' + ContaForms).html(imagenlogo+Tit+' <a id="gxtbtn'+ContaForms+'" type="button" class="close closeico" aria-label="Close" onclick="javascript:CerrarVentana(\''+ContaForms+'\', event)"><span aria-hidden="true">&times;</span></a>').appendTo('#gxt' + ContaForms);
	$(a0).attr('aria-controls','Window_'+ContaForms);
	$(a0).attr('role','tab');
	$(a0).attr('data-bs-toggle', 'tab');
	$(a0).attr('data-bs-target', '#Window_'+ContaForms);
	$(a0).attr('type','button');
	$(a0).attr('class','nav-link');
	
	//Luego el contenido del form...
	var div = $(document.createElement('div')).attr('class','tab-pane fade show').appendTo('#nxs_tabcontent');
	$(div).attr('id','Window_' + ContaForms);
	$(div).attr('role','tabpanel');
	$(div).attr('aria-labelledby','gxta' + ContaForms);
	$(div).append("<div class='panel-heading' id='ztitle_" + ContaForms+"'><h4 class='panel-title'><img src=\"http://cdn.genomax.co/media/image/icons/32x32/"+Ico+"\" align=\"left\"/>"+Tit+'<button title="Cerrar Ventana" id="gxtbtn'+ContaForms+'" type="button" class="close closeico" aria-label="Close" onclick="javascript:CerrarVentana(\''+ContaForms+'\', event)"><span aria-hidden="true">&times;</span></button></h4></div>');
		
	var div3 = $(document.createElement('div')).attr('class','gxFullScreen').html(' <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>').appendTo('#ztitle_' + ContaForms);
	$(div3).attr('title','Maximizar');
	$(div3).attr('onclick','gxFullScreen();');
	var div4 = $(document.createElement('div')).attr('class','panel-body').appendTo('#Window_' + ContaForms);
	$(div4).attr('id','gxWind_' + ContaForms);
	var divgx = $(document.createElement('div')).attr('class','container').html('<div class="cargando"></div>').appendTo('#gxWind_' + ContaForms);
	$(divgx).attr('id','zWind_' + ContaForms);
	pagX=Pag.substring(18,Pag.indexOf('.'));
	var div5 = $(document.createElement('div')).attr('class','toolbar panel-footer').html('<form class="form-horizontal" id="ToolBar_'+ContaForms+'"><span id="nxsprogress'+ContaForms+'"></span><div class="btn-group toolbar_buttons" role="group" aria-label="...">	<button type="button" class="btn btn-success" id="Nuevo'+ContaForms+'" onclick="javascript:New_Reset(\''+ContaForms+'\')"><span class="glyphicon glyphicon glyphicon-file" aria-hidden="true"></span> Nuevo</button>  		<button type="button" class="btn btn-warning" id="Anular'+ContaForms+'" onclick="javascript:Anular_'+pagX+'(\''+ContaForms+'\')"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> Anular</button>  		<button type="button" class="btn btn-success" id="Imprimir'+ContaForms+'" onclick="javascript:Imprimir_'+pagX+'(\''+ContaForms+'\')"><span class="glyphicon glyphicon-print" aria-hidden="true"></span> Imprimir</button>  		<button type="button" class="btn btn-success" id="Guardar'+ContaForms+'" onclick="javascript:Guardar_'+pagX+'(\''+ContaForms+'\');" ><span class="glyphicon glyphicon-check" aria-hidden="true"></span> Guardar</button>  		<!--<button type="button" class="btn btn-danger" id="Cerrar'+ContaForms+'" onclick="javascript:CerrarVentana(\'Window_'+ContaForms+'\')"><span class="glyphicon glyphicon-off" aria-hidden="true"></span> Cerrar</button>-->	</div>	</form>	 ').appendTo('#Window_' + ContaForms);
	$(div5).attr('id','zTools_' + ContaForms);
	
	var Taby = document.querySelector('#gxta' + ContaForms)
	var tab = new bootstrap.Tab(Taby)
	
	tab.show()
	//$('#gxtabs a:last').tab('show');
	AbrirForm(Pag, 'zWind_' + ContaForms, Parametros);
	
	$("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-select");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=checkbox]").addClass("form-check-input");
	$("input[type=radio]").addClass("form-check-input");

	AddItemX('Window_'.ContaForms, Tit);

	VerificarFavs(Tit, Pag);
	

	}
}	

function CerrarVentana(Ventana, e) {

	lastestid=0;
	if (($("#gxtabs li:last a").attr("href") == undefined)) {
		lastestid = 0
	} else {
		lastestid = parseInt( $("#gxtabs li:last a").attr("href").split(/#Window_(\d+)/)[1]);
	}

	var parentli = $("#gxta"+Ventana).parent().parent();

	var parliindex =parseInt( $("#gxt"+Ventana).index());

	if(parliindex == lastestid) {
	 	var nextaname = $("#gxt"+Ventana).prev("li").index();
	} else{
		var nextaname = $("#gxt"+Ventana).next("li").index();
	}

	$('#Window_'+Ventana).fadeOut(250, function() { $('#Window_'+Ventana).remove(); });
	$("#gxt"+Ventana).remove();
	
	$('#gxtabs li:eq('+nextaname+') a').tab('show');
	
	$('#itemX'+Ventana).remove();
}

function AddItemX(Ventana, Titulo) {
	$('#itemXX').append("<div class='gxItem' id='itemXWindow_" + ContaForms+"' onclick='javascript:MostrarVentana(\"Window_"+ContaForms+"\")'> &#8226; "+Titulo+"<div id='itemXFavs_" + ContaForms+"'></div></div>");
}

function VerificarFavs(Titulo, Pagina) {

	var divF3 = $(document.createElement('a')).attr('href','javascript:InsertFavs("'+Pagina+'")').html('+').appendTo('#itemXFavs_' + ContaForms);
	$(divF3).attr('class','addfav');
	$(divF3).attr('title','Agregar '+ Titulo + ' a barra de favoritos');

}

function MostrarVentana(Ventana) {
	ContaForms++;
	document.getElementById(Ventana).style.zIndex = ContaForms; 
	$('#'+Ventana).resizable();
}

function CargarReport(Pag, Tit) {
	var Parametros="";
	var SwParam=0;
	SwParam=Pag.indexOf('?');
	if (SwParam>0) {
		Parametros='&'+Pag.substring(SwParam+1);
		Pag=Pag.substring(0,SwParam);
	}
	if ("application/../"==Pag.substring(0,15)) {
		Pag=Pag.substring(15,(Pag.length -15));
	} 
	
	ContaForms++;
	ContaReports=ContaForms;
	//Primero el tab...
	var li0 = $(document.createElement('li')).attr('role','presentation').appendTo('#gxtabs');
	$(li0).attr('id','gxt' + ContaReports);
	$(li0).attr('title', Tit);
	$(li0).attr('class','nav-item');
	imagenlogo="<img src=\"http://cdn.genomax.co/media/image/icons/16x16/report.png\" align=\"left\"/> ";
	var a0 = $(document.createElement('button')).attr('id','gxta' + ContaReports).html(imagenlogo+Tit+' <a id="gxtbtn'+ContaReports+'" type="button" class="close closeico" aria-label="Close" onclick="javascript:CerrarVentana(\''+ContaReports+'\', event)"><span aria-hidden="true">&times;</span></a>').appendTo('#gxt' + ContaReports);
	$(a0).attr('aria-controls','Report_'+ContaReports);
	$(a0).attr('role','tab');
	$(a0).attr('data-bs-toggle', 'tab');
	$(a0).attr('data-bs-target', '#Report_'+ContaReports);
	$(a0).attr('type','button');
	$(a0).attr('class','nav-link');
	
	//Luego el contenido del report...
	var div = $(document.createElement('div')).attr('class','tab-pane fade show').appendTo('#nxs_tabcontent');
	$(div).attr('id','Report_' + ContaReports);
	$(div).attr('role','tabpanel');
	$(div).attr('aria-labelledby','gxta' + ContaForms);
	$(div).append("<div class='panel-heading' id='ztitle_" + ContaReports+"'><h4 class='panel-title'><img src=\"http://cdn.genomax.co/media/image/icons/32x32/report.png\" align=\"left\"/>"+Tit+'<button title="Cerrar Ventana" id="gxtbtn'+ContaForms+'" type="button" class="close closeico" aria-label="Close" onclick="javascript:CerrarVentana(\''+ContaForms+'\', event)"><span aria-hidden="true">&times;</span></button></h4></div>');

	var div3 = $(document.createElement('div')).attr('class','gxFullScreen').html(' <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>').appendTo('#ztitle_' + ContaReports);
	$(div3).attr('title','Maximizar');
	$(div3).attr('onclick','gxFullScreen();');
	var div4 = $(document.createElement('div')).attr('class','panel-body').appendTo('#Report_' + ContaReports);
	$(div4).attr('id','gxWind_' + ContaReports);
	var divgx = $(document.createElement('div')).attr('class','container').html('<div class="cargando"></div>').appendTo('#gxWind_' + ContaReports);
	$(divgx).attr('id','zRpt_' + ContaReports);
	pagX=Pag.substring(18,Pag.indexOf('.'));
	
	var Taby = document.querySelector('#gxta' + ContaReports)
	var tab = new bootstrap.Tab(Taby)
	
	tab.show();
	// $('#gxtabs a:last').tab('show');
	AbrirReport(Pag, 'zRpt_' + ContaReports, Parametros);
	//AbrirReport(Pag, 'zRpt_' + ContaReports, Parametros);
	
	AddItemXr('Report_'.ContaReports, Tit);
	/*
	VerificarFavs(Tit, Pag);

	gxFullScreen();
	*/
// - - - - - - - -- -  - -- -  - - 
	
}

function CargarDataReport(Pag, Tit) {
	var Parametros="";
	var SwParam=0;
	SwParam=Pag.indexOf('?');
	if (SwParam>0) {
		Parametros='&'+Pag.substring(SwParam+1);
		Pag=Pag.substring(0,SwParam);
	}
	if ("application/../"==Pag.substring(0,15)) {
		Pag=Pag.substring(15,(Pag.length -15));
	} 
	
	ContaForms++;
	ContaReports=ContaForms;
	//Primero el tab...
	var li0 = $(document.createElement('li')).attr('role','presentation').appendTo('#gxtabs');
	$(li0).attr('id','gxt' + ContaReports);
	$(li0).attr('title', Tit);
	$(li0).attr('class','nav-item');
	imagenlogo="<img src=\"http://cdn.genomax.co/media/image/icons/16x16/database_table.png\" align=\"left\"/> ";
	var a0 = $(document.createElement('button')).attr('id','gxta' + ContaReports).html(imagenlogo+Tit+' <a id="gxtbtn'+ContaReports+'" type="button" class="close closeico" aria-label="Close" onclick="javascript:CerrarVentana(\''+ContaReports+'\', event)"><span aria-hidden="true">&times;</span></a>').appendTo('#gxt' + ContaReports);
	$(a0).attr('aria-controls','Report_'+ContaReports);
	$(a0).attr('role','tab');
	$(a0).attr('data-bs-toggle', 'tab');
	$(a0).attr('data-bs-target', '#Report_'+ContaReports);
	$(a0).attr('type','button');
	$(a0).attr('class','nav-link');
	
	// $(a0).attr('aria-controls','Ghen_'+ContaReports);
	
	//Luego el contenido del report...
	var div = $(document.createElement('div')).attr('class','tab-pane fade show').appendTo('#nxs_tabcontent');
	$(div).attr('id','Report_' + ContaReports);
	$(div).attr('role','tabpanel');
	$(div).attr('aria-labelledby','gxta' + ContaForms);
	$(div).append("<div class='panel-heading' id='ztitle_" + ContaReports+"'><h4 class='panel-title'><img src=\"http://cdn.genomax.co/media/image/icons/32x32/database_table.png\" align=\"left\"/>"+Tit+'<button title="Cerrar Ventana" id="gxtbtn'+ContaForms+'" type="button" class="close closeico" aria-label="Close" onclick="javascript:CerrarVentana(\''+ContaForms+'\', event)"><span aria-hidden="true">&times;</span></button></h4></div>');

	var div3 = $(document.createElement('div')).attr('class','gxFullScreen').html(' <span class="glyphicon glyphicon-fullscreen" aria-hidden="true"></span>').appendTo('#ztitle_' + ContaReports);
	$(div3).attr('title','Maximizar');
	$(div3).attr('onclick','gxFullScreen();');
	var div4 = $(document.createElement('div')).attr('class','panel-body').appendTo('#Report_' + ContaReports);
	$(div4).attr('id','gxWind_' + ContaReports);
	var divgx = $(document.createElement('div')).attr('class','container').html('<div class="cargando"></div>').appendTo('#gxWind_' + ContaReports);
	$(divgx).attr('id','zRpt_' + ContaReports);
	pagX=Pag.substring(18,Pag.indexOf('.'));
	
	var Taby = document.querySelector('#gxta' + ContaReports)
	var tab = new bootstrap.Tab(Taby)
	
	tab.show();
	
	OpenRpt(Pag, 'zRpt_' + ContaReports, Parametros);
	//AbrirReport(Pag, 'zRpt_' + ContaReports, Parametros);
	
	AddItemXr('Report_'.ContaReports, Tit);
	/*
	VerificarFavs(Tit, Pag);

	gxFullScreen();
	*/
// - - - - - - - -- -  - -- -  - - 
	
}

function MostrarVentanaR(Ventana) {
	ContaForms++
	ContaReports=ContaForms;
	document.getElementById(Ventana).style.zIndex = ContaReports; 
	$('#'+Ventana).resizable();
}

function AddItemXr(Ventana, Titulo) {
	$('#itemXX').append("<div class='gxItem' id='itemXReport_" + ContaReports+"' onclick='javascript:MostrarVentanaR(\"Report_"+ContaReports+"\")'> &#8226; Reporte "+Titulo+"</div>");
}

function CerrarReporte(Ventana, e) {
	lastestid=0;
	if (($("#gxtabs li:last a").attr("href") == undefined)) {
		lastestid = 0
	} else {
		lastestid = parseInt( $("#gxtabs li:last a").attr("href").split(/#Report_(\d+)/)[1]);
	}

	var parentli = $("#gxta"+Ventana).parent().parent();

	var parliindex =parseInt( $("#gxt"+Ventana).index());

	if(parliindex == lastestid) {
	 	var nextaname = $("#gxt"+Ventana).prev("li").index();
	} else{
		var nextaname = $("#gxt"+Ventana).next("li").index();
	}

	$('#Report_'+Ventana).fadeOut(250, function() { $('#Report_'+Ventana).remove(); });
	$("#gxt"+Ventana).remove();
	
	$('#gxtabs li:eq('+nextaname+') a').tab('show');
	
	$('#itemX'+Ventana).remove();}

function CargarSearch(Tit, Destino, Where) {
	$(document.createElement('div')).attr('class','cargando').appendTo('#bodySearch');
	AbrirSearch('bodySearch', Destino, Tit, Where);
	document.frm_searchNxs.txt_buscarNxs.focus();
}	

function CargarWind(Tit, form, Icono, origen, ventana) {
	var Parametros="";
	var SwParam=0;
	SwParam=form.indexOf('?');
	if (SwParam>0) {
		Parametros='&genesis='+ventana+'&'+form.substring(SwParam+1);
		form=form.substring(0,SwParam);
	}
	ContaForms++;
	typo="reports";
	SwParam=form.indexOf('/');
	if (SwParam>0) {
		forma=form.substring(SwParam+1);
		typo=form.substring(0,SwParam);
	}
	/* $(document.createElement('div')).attr('class','cargando').appendTo('#bodyWind');
	$("#bodyWind").load('application/'+form); */

	if (typo=="reports") {
		ContaReports=ContaForms;
		document.getElementById('bodyWind').innerHTML='<span id="zRpt_'+ ContaForms+'"><img src="http://cdn.genomax.co/media/image/loading.gif" align="left"></span>';
		if (Icono=="database_table.png") {
			document.getElementById('idWindModal').innerHTML='<img src="http://cdn.genomax.co/media/image/icons/32x32/database_table.png" align="left">'+Tit;
			OpenRpt('application/'+form, "zRpt_" + ContaReports, Parametros)
		} else {
			document.getElementById('idWindModal').innerHTML='<img src="http://cdn.genomax.co/media/image/icons/32x32/report.png" align="left">'+Tit;
			AbrirReport('application/'+form, "zRpt_" + ContaReports, Parametros);
		}
	} else {
		document.getElementById('bodyWind').innerHTML='<span id="zWind_'+ ContaForms+'"><img src="http://cdn.genomax.co/media/image/loading.gif" align="left"></span>';
		document.getElementById('idWindModal').innerHTML='<img src="http://cdn.genomax.co/media/image/icons/32x32/'+Icono+'" align="left">'+Tit;
		$("#zWind_" + ContaForms).load('application/'+form+"?target=zWind_" + ContaForms+Parametros);
		console.log('application/'+form+"?target=zWind_" + ContaForms+Parametros);
	}
}	

function CargarWind2(Tit, form, Icono, origen, ventana) {
	var Parametros="";
	var SwParam=0;
	SwParam=form.indexOf('?');
	if (SwParam>0) {
		Parametros='&genesis='+ventana+'&'+form.substring(SwParam+1);
		form=form.substring(0,SwParam);
	}
	ContaForms++;
	typo="reports";
	SwParam=form.indexOf('/');
	if (SwParam>0) {
		forma=form.substring(SwParam+1);
		typo=form.substring(0,SwParam);
	}
	/* $(document.createElement('div')).attr('class','cargando').appendTo('#bodyWind');
	$("#bodyWind").load('application/'+form); */

	if (typo=="reports") {
		ContaReports=ContaForms;
		document.getElementById('bodyWind2').innerHTML='<span id="zRpt_'+ ContaForms+'"><img src="http://cdn.genomax.co/media/image/loading.gif" align="left"></span>';
		if (Icono=="database_table.png") {
			document.getElementById('idWindModal2').innerHTML='<img src="http://cdn.genomax.co/media/image/icons/32x32/database_table.png" align="left">'+Tit;
			OpenRpt('application/'+form, "zRpt_" + ContaReports, Parametros)
		} else {
			document.getElementById('idWindModal2').innerHTML='<img src="http://cdn.genomax.co/media/image/icons/32x32/report.png" align="left">'+Tit;
			AbrirReport('application/'+form, "zRpt_" + ContaReports, Parametros);
		}
	} else {
		document.getElementById('bodyWind2').innerHTML='<span id="zWind_'+ ContaForms+'"><img src="http://cdn.genomax.co/media/image/loading.gif" align="left"></span>';
		document.getElementById('idWindModal2').innerHTML='<img src="http://cdn.genomax.co/media/image/icons/32x32/'+Icono+'" align="left">'+Tit;
		$("#zWind_" + ContaForms).load('application/'+form+"?target=zWind_" + ContaForms+Parametros);
		console.log('application/'+form+"?target=zWind_" + ContaForms+Parametros);
	}
}	

function CerrarVentanaSearch(Ventana) {
	$('#'+Ventana).slideUp('slow', function() { $('#'+Ventana).remove(); });
}

function CargarChngPass() {
	$('#GnmX_ChngPass').modal()
	$(document.createElement('div')).attr('class','cargando').appendTo('#bodyChngPass');
	AbrirChngPass('bodyChngPass');
}	

function ShowMenuX(id) {
	if (document.getElementById){ 
		var el = document.getElementById(id); 
		el.style.display = (el.style.display == 'none') ? 'block' : 'none'; 
	}
}

function HideMenuX() {
	document.getElementById("czMenu").style.display  = 'none';
}

function MsgBox1(Titulo, Mensaje) {
	$("#titleMsgBox").html(':: '+Titulo.toUpperCase());
	$("#bodyMsgBox").html(Mensaje);
	if (Mensaje=="Su sessión ha expirado!") {
		swal(Titulo, Mensaje,'error');
		window.open(window.location.href, "nxs_session" , "width=500,height=650,scrollbars=NO");
	} else {
		swal(Titulo, Mensaje,'info');
	}
	document.getElementById('nxs_sound_info').play();
	/*$("#msgbox1").modal( "show" );*/
}

function AboutGNX() {
	$("#titleMsgBox").html('GENOMAX HIS');
	$("#bodyMsgBox").html('vIBRANIUM');
	/*swal(Titulo, Mensaje,'info');*/
	document.getElementById('nxs_sound_info').play();
	$("#msgbox1").modal( "show" );
}

function MsgBoxErr(Titulo, Mensaje) {
	document.getElementById('nxs_sound_error').play();
	swal(Titulo, Mensaje,'error');
}

function MsgBox2(Titulo, Mensaje) {
	var divX = $(document.createElement('div')).attr('id','nXconfirm').appendTo('#TodoAll');
	$(divX).attr('title',':: '+Titulo);
	var divXX = $(document.createElement('p')).attr('class','confirm').html(Mensaje).appendTo(divX);
	$( divX ).dialog({
		autoOpen: false,
		modal: true,
		show: "fold",
		hide: "fold",
		buttons: {
			Ok: function() {
				$( this ).dialog( "close" );
			}
		}	
	});
	$(divX).dialog( "open" );
}

function CargarPass(Tit, Destino, Where) {
	ContaPass++;
//	$('#zerocontainer').append(CrearVentana(ContaForms));
	var div = $(document.createElement('div')).attr('class','zeroFormPass panel panel-success').appendTo('#zerocontainer');
	$(div).attr('id','Pass_' + ContaPass);
	var div2 = $(document.createElement('div')).attr('class','panel-heading').html('<img src="settings/images/pass.png" border="0" align="left">:: Cambio de Clave ').appendTo('#Pass_' + ContaPass);
	$(div2).attr('id','ztitlesP_' + ContaPass);
	var div3 = $(document.createElement('a')).attr('href','javascript:CerrarVentanaPass("Pass_'+ContaPass+'")').html('X').appendTo('#ztitlesP_' + ContaPass);
	$(div3).attr('class','zclose');
	$(div3).attr('title','Cancelar y Cerrar');
	var div4 = $(document.createElement('div')).attr('class','contformsearch panel-body').html('<div class="cargando"></div>').appendTo('#Pass_' + ContaPass);
	$(div4).attr('id','zPass_' + ContaPass);
	$(div).draggable({handle: '#ztitlesP_' + ContaPass});
	div.css({
	'left' : 250 ,
	'top' : 150 ,
	'z-index' : 999,
	})
	AbrirForm('application/forms/clave.php', 'zPass_' + ContaPass, '');
}	


function CerrarVentanaPass(Ventana) {
$('#'+Ventana).slideUp('slow', function() { $('#'+Ventana).remove(); });
}