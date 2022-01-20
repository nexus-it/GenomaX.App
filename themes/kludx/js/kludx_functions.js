var varMenu=0;
var varSearch=0;
var varUsrOpts=0;
var kFunciones="functions/php/nexus/kfunctions.php";
var Funciones="functions/php/nexus/functions.php";
var Menu="themes/kludx/menu.php";

var Modal_Msg = '<div class="modal fade" id="msgbox1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> <div class="modal-dialog" id="NXS_ModMsgBox"> <div class="modal-content"> <div class="modal-header" id="NXS_TitMsgBox"> <h5 class="modal-title" id="exampleModalLabel">Modal title</h5> <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> </div> <div class="modal-body" id="bodyMsgBox"> <div class="spinner-grow" role="status"> <span class="visually-hidden">Cargando...</span> </div> </div> <div class="modal-footer"> <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Aceptar</button> </div> </div> </div> </div>';
/*
var Modal_Msg = '<div class="modal fade" id="msgbox1">
<div class="modal-dialog" id="NXS_ModMsgBox">
  <div class="modal-content panel-success">
    <div class="modal-header panel-heading bg-success" id="NXS_TitMsgBox">
      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      <h4 class="modal-title"><span class="label label-warning"><span class="glyphicon glyphicon-alert"></span></span> <span id="titleMsgBox" class="label label-success">GenomaX</span></h4>
    </div>
    <div class="modal-body" id="bodyMsgBox">
      <div class="cargando"></div>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-primary" data-dismiss="modal">Aceptar</button>
    </div>
  </div></div></div>';
  */
(function(){
    function init(){
        loadElements();
        percentCover("0.4");
        loadInfoTop();
        percentCover("0.7");
        loadUserOpts();
        loadUserData();
        loadDashboard();
        loadInfoDash();
        addFunctions();
        percentCover("1");
        locateTop();
        setWMenu("0");
        showUsrOpts("0");
        loadMenuOpts();
        loadBoxes();
    }
    function loadDataFetch(obj, url, params) {
        url=url+'?'+params;
        console.log(url);
        fetch(url)
        .then(response => response.text())
        .then(commits => document.getElementById(obj).innerHTML=commits);
    }
    function createDivs(iddiv){
        var loading = '<div class="loadingio-spinner-pulse-k1yr7g9iihb"><div class="ldio-cm9jib51jwb"><div></div><div></div><div></div></div></div>';
        return '<div id="'+iddiv+'">'+loading+'</div>';        
    }
    function createSection(idsection){
        var loading = '<div class="spinner-grow" role="status"> <span class="visually-hidden">Cargando...</span> </div>';
        return '<section id="'+idsection+'">'+loading+'</section>'; 
    }
    function loadElements(){
        var cover = createDivs('kld_top');
        var menu = createDivs('kld_menu');
        var nxs = createDivs('kld_nexus');
        var dashboard = createDivs('kld_container');
        var usrpnl = createDivs('usrpnl');
        var mnupnl = createDivs('mnupnl');
        var usropt = createDivs('usropt');
        var imgpnl = createDivs('imgpnl');
        var infpnl = createDivs('infpnl');
        var usroptsep = createDivs('usroptsep');
        var usroptli = '<li class="manito"><a id="mnuvideomeet" name="mnuvideomeet" title="Video Conferencias Seguras" data-toggle="modal" data-target="#GnmX_NXSMeet"> <i class="fas fa-video text-black-50"></i> <span><b>NE<em>X</em>US.<em>Meet</em></b></span> </a></li>        <li class="manito"><a id="mnuchangepass" name="mnuchangepass"><i class="fa fa-key text-warning"></i> <span>Cambio de Clave</span></a></li>        <li class="manito"><a id="mnuaboutapp" name="mnuaboutapp"><i class="fa fa-play-circle text-success"></i> <span>Acerca de...</span></a></li>        <li class="manito"><a id="mnulogout" name="mnulogout" ><i class="fas fa-sign-out-alt text-danger"></i> <span>Cerrar Sesión</span></a></li>';

        document.getElementById('bdy_kludx').innerHTML = cover+nxs;
        document.getElementById('kld_nexus').innerHTML = menu+dashboard;
        document.getElementById('kld_top').classList.add('cover_lazy'); 
        // document.getElementById('kld_top').innerHTML = "";
        document.getElementById('kld_menu').classList.add('menu_init');
        document.getElementById('kld_container').classList.add('dashboard_init');
        document.getElementById('kld_menu').innerHTML = usrpnl+mnupnl+usropt;
        document.getElementById('usrpnl').classList.add('user-panel');
        document.getElementById('usropt').innerHTML = usroptsep+usroptli;
        document.getElementById('usrpnl').innerHTML = imgpnl+infpnl;
        document.getElementById('imgpnl').classList.add('image');
        document.getElementById('infpnl').classList.add('info');
        document.getElementById('infpnl').innerHTML ='OPCIONES';
        document.getElementById('usroptsep').classList.add('alert');
        document.getElementById('usroptsep').classList.add('alert-secondary');
        document.getElementById('usroptsep').classList.add('titmnu');
        document.getElementById('usroptsep').innerHTML = '- '.repeat(24);
        document.getElementById('imgpnl').classList.add('d-flex');
        document.getElementById('imgpnl').classList.add('justify-content-center');
    }
    function percentCover(perc) {
        document.getElementById('kld_top').style.opacity=perc; 
    }
    function loadInfoTop() {
        var logo = createDivs('kld_logo');
        var ctrlmenu = createDivs('kld_ctrlmenu');
        var nameagency = createDivs('kld_nameagency');
        var nameuser = createDivs('kld_nameuser');
        var useroptions = createDivs('user_options');
        var search = createDivs('kld_search');
        document.getElementById('kld_top').innerHTML = logo+ctrlmenu+nameagency+nameuser+search+useroptions;
        loadDataIni();
        document.getElementById('kld_logo').innerHTML = '<a href="index.php?nxsdb=klud" class="logo"> <span id="lgmini" class="logo-mini"><img src="http://cdn.genomax.co/media/image/logoklud_32mini.png" alt="Kl\'ud"></span> <span id="lglg" class="logo-lg"><img src="http://cdn.genomax.co/media/image/logoklud_32.png" alt="Kl\'ud"> </span> </a>';
        document.getElementById('kld_ctrlmenu').innerHTML = '<a href="#" role="button" id="toogle_menu" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/> </svg> </a>';
        document.getElementById('kld_search').innerHTML = '<a href="#" role="button" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"> <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/> </svg> </a>';
    }
    function loadDashboard() {
        var nxs_alert = createDivs('nxs_alert');
        var nxs_tabcontent = createDivs('nxs_tabcontent');
        var nxs_sidesearch = createDivs('nxs_sidesearch');
        var nxs_sidetabs = createDivs('nxs_sidetabs');
        var nxs_sectionsearch = createDivs('nxs_sectionsearch');
        var Window_0 = createDivs('Window_0');
        document.getElementById('kld_container').innerHTML = nxs_alert+nxs_tabcontent+nxs_sidesearch+Modal_Msg;
        document.getElementById('nxs_sidesearch').innerHTML = nxs_sectionsearch+nxs_sidetabs;
        document.getElementById('nxs_alert').classList.add('alert');
        document.getElementById('nxs_alert').classList.add('alert-warning');
        document.getElementById('nxs_alert').setAttribute("role", "alert");
        document.getElementById('nxs_tabcontent').classList.add('tab-content');
        document.getElementById('nxs_sidesearch').classList.add('sidesearch0'); 
        document.getElementById('nxs_sectionsearch').innerHTML = '<input id="txt_search" name="txt_search" class="form-control form-control-sm" type="text" placeholder="Buscar..." aria-label=".form-control-sm example">';
        document.getElementById('nxs_tabcontent').innerHTML = Window_0;
        document.getElementById('Window_0').classList.add('tab-pane');
        document.getElementById('Window_0').classList.add('fade');
        document.getElementById('Window_0').classList.add('show');
        document.getElementById('Window_0').classList.add('active');
        document.getElementById('Window_0').setAttribute("role", "tabpanel");
        document.getElementById('Window_0').setAttribute("aria-labelledby", "home-tab");
        document.getElementById('nxs_sidetabs').innerHTML = '<ul id="gxtabs" class="row"> <li role="presentation" id="gxt0" class=""> <a href="#Window_0" aria-controls="dashboard" role="tab" data-toggle="tab" aria-expanded="false"><div class="col-md-12"> Dashboard </div></a> </li> </ul>';

    }
    function loadInfoDash() {
        var titHeader = createSection('titHeader');
        var contItems = createSection('contItems');
        var row1kld = createDivs('row1kld');
        var col11kld = createDivs('col11kld');
        var col12kld = createDivs('col12kld');
        var col13kld = createDivs('col13kld');
        var col14kld = createDivs('col14kld');
        var row2kld = createDivs('row2kld');
        document.getElementById('Window_0').innerHTML = titHeader+contItems;
        document.getElementById('titHeader').classList.add('content-header');
        document.getElementById('contItems').classList.add('content');
        document.getElementById('titHeader').innerHTML = '<h1> Dashboard <small>Panel de Control</small> </h1>';
        document.getElementById('contItems').innerHTML = row1kld+row2kld;
        document.getElementById('row1kld').classList.add('row');
        document.getElementById('row2kld').classList.add('row');
        document.getElementById('row1kld').innerHTML = col11kld+col12kld+col13kld+col14kld;
        document.getElementById('col11kld').classList.add('col-lg-3');
        document.getElementById('col11kld').classList.add('col-sm-6');
        document.getElementById('col12kld').classList.add('col-lg-3');
        document.getElementById('col12kld').classList.add('col-sm-6');
        document.getElementById('col13kld').classList.add('col-lg-3');
        document.getElementById('col13kld').classList.add('col-sm-6');
        document.getElementById('col14kld').classList.add('col-lg-3');
        document.getElementById('col14kld').classList.add('col-sm-6');
        var card1kld = createDivs('card1kld');
        var card2kld = createDivs('card2kld');
        var card3kld = createDivs('card3kld');
        var card4kld = createDivs('card4kld');
        document.getElementById('col11kld').innerHTML = card1kld;
        document.getElementById('col12kld').innerHTML = card2kld;
        document.getElementById('col13kld').innerHTML = card3kld;
        document.getElementById('col14kld').innerHTML = card4kld;
        document.getElementById('card1kld').classList.add('card');
        document.getElementById('card2kld').classList.add('card');
        document.getElementById('card3kld').classList.add('card');
        document.getElementById('card4kld').classList.add('card');
        var cardbd1kld = createDivs('cardbd1kld');
        var cardbd2kld = createDivs('cardbd2kld');
        var cardbd3kld = createDivs('cardbd3kld');
        var cardbd4kld = createDivs('cardbd4kld');
        document.getElementById('card1kld').innerHTML = cardbd1kld;
        document.getElementById('card2kld').innerHTML = cardbd2kld;
        document.getElementById('card3kld').innerHTML = cardbd3kld;
        document.getElementById('card4kld').innerHTML = cardbd4kld;
        document.getElementById('cardbd1kld').classList.add('card-body');
        document.getElementById('cardbd1kld').classList.add('small-box');
        document.getElementById('cardbd1kld').classList.add('bg-info');
        document.getElementById('cardbd1kld').classList.add('text-white');
        document.getElementById('cardbd2kld').classList.add('card-body');
        document.getElementById('cardbd2kld').classList.add('small-box');
        document.getElementById('cardbd2kld').classList.add('bg-success');
        document.getElementById('cardbd2kld').classList.add('text-white');
        document.getElementById('cardbd3kld').classList.add('card-body');
        document.getElementById('cardbd3kld').classList.add('small-box');
        document.getElementById('cardbd3kld').classList.add('bg-warning');
        document.getElementById('cardbd3kld').classList.add('text-white');
        document.getElementById('cardbd4kld').classList.add('card-body');
        document.getElementById('cardbd4kld').classList.add('small-box');
        document.getElementById('cardbd4kld').classList.add('bg-danger');
        document.getElementById('cardbd4kld').classList.add('text-white');
        var cardinnerkld1 = createDivs('cardinnerkld1');
        var cardinnerkld3 = createDivs('cardinnerkld3');
        var cardinnerkld4 = createDivs('cardinnerkld4');
        var cardinnerkld2 = createDivs('cardinnerkld2');
        var cardiconkld1 = createDivs('cardiconkld1');
        var cardiconkld2 = createDivs('cardiconkld2');
        var cardiconkld3 = createDivs('cardiconkld3');
        var cardiconkld4 = createDivs('cardiconkld4');
        document.getElementById('cardbd1kld').innerHTML = cardinnerkld1+cardiconkld1;
        document.getElementById('cardbd2kld').innerHTML = cardinnerkld2+cardiconkld2;
        document.getElementById('cardbd3kld').innerHTML = cardinnerkld3+cardiconkld3;
        document.getElementById('cardbd4kld').innerHTML = cardinnerkld4+cardiconkld4;
        document.getElementById('cardinnerkld1').classList.add('inner');
        document.getElementById('cardinnerkld2').classList.add('inner');
        document.getElementById('cardinnerkld3').classList.add('inner');
        document.getElementById('cardinnerkld4').classList.add('inner');
        document.getElementById('cardiconkld1').classList.add('icon');
        document.getElementById('cardiconkld2').classList.add('icon');
        document.getElementById('cardiconkld3').classList.add('icon');
        document.getElementById('cardiconkld4').classList.add('icon');
        var cardwaiting = '<div class="spinner-grow text-light" role="status"> <span class="visually-hidden">Loading...</span> </div> <p class="card-text placeholder-glow"> <span class="placeholder col-12 bg-light"></span> </p>';
        document.getElementById('cardinnerkld1').innerHTML = cardwaiting;
        document.getElementById('cardinnerkld2').innerHTML = cardwaiting;
        document.getElementById('cardinnerkld3').innerHTML = cardwaiting;
        document.getElementById('cardinnerkld4').innerHTML = cardwaiting;
        var secSeven = createSection('secSeven');
        var secFive = createSection('secFive');
        document.getElementById('row2kld').innerHTML = secSeven+secFive;
        document.getElementById('secSeven').classList.add('col-lg-7');
        document.getElementById('secFive').classList.add('col-lg-5');
        var boxCotiz = createDivs('boxCotiz');
        var boxDistPln = createDivs('boxDistPln');
        var boxDestCli = createDivs('boxDestCli');
        var boxVentas = createDivs('boxVentas');
        document.getElementById('secSeven').innerHTML = boxCotiz+boxDistPln;
        document.getElementById('secFive').innerHTML = boxDestCli+boxVentas;
        document.getElementById('boxCotiz').classList.add('box');
        document.getElementById('boxDistPln').classList.add('box');
        document.getElementById('boxDestCli').classList.add('box');
        document.getElementById('boxVentas').classList.add('box');
        document.getElementById('cardiconkld1').innerHTML = '<i class="fa fa-calculator"></i>';
        document.getElementById('cardiconkld2').innerHTML = '<i class="fa fa-plane"></i>';
        document.getElementById('cardiconkld3').innerHTML = '<i class="fa fa-chart-pie"></i>';
        document.getElementById('cardiconkld4').innerHTML = '<i class="fa fa-chart-area"></i>';

    }
    function loadUserOpts() {
        var divData = createDivs('usr_dataopts');
        var divActions = createDivs('usr_actionopts');
        document.getElementById('user_options').innerHTML = divData+divActions;
        var divPhoto = createDivs('usr_imgopts');
        var divName = createDivs('usr_nameopts');
        var divPerfil = createDivs('usr_roleopts');
        document.getElementById('usr_dataopts').innerHTML = divPhoto+divName+divPerfil;
        var divBtnPass = createDivs('usr_passopts');
        var divBtnSession = createDivs('usr_sessionopts');
        document.getElementById('usr_actionopts').innerHTML = divBtnPass+divBtnSession;
        document.getElementById('usr_imgopts').classList.add('d-flex');
        document.getElementById('usr_imgopts').classList.add('justify-content-center');
        document.getElementById('usr_nameopts').classList.add('d-flex');
        document.getElementById('usr_nameopts').classList.add('justify-content-center');
        document.getElementById('usr_roleopts').classList.add('d-flex');
        document.getElementById('usr_roleopts').classList.add('justify-content-center');
        document.getElementById('usr_imgopts').innerHTML = '<img id="img_user" name="img_user" src="files/logosadinca.jpg" class="rounded-circle shadow-sm" alt="Imagen Usuario">';
        document.getElementById('usr_passopts').innerHTML = '<button id="btn_passusr" name="btn_passusr" type="button" class="btn btn-light" data-bs-toggle="modal" data-bs-target="#GnmX_ChngPass">Cambio Clave</button>';
        document.getElementById('usr_sessionopts').innerHTML = '<button id="btn_sessionusr" name="btn_sessionusr" type="button" class="btn btn-light">Cerrar Sesión</button>';
    }
    function loadUserData() {
        loadDataFetch('usr_nameopts', Funciones, 'Func=NombreUserx');
        loadDataFetch('usr_roleopts', Funciones, 'Func=NombreRolex');
    }
    function loadDataIni() {
        loadDataFetch('kld_nameagency', Funciones, 'Func=NombreEmpresa');
        loadDataFetch('kld_nameuser', Funciones, 'Func=NombreUserx');
    }
    function showUsrOpts(nxsW) {
        if ( nxsW=="0") {
            nxsY="1";
        } else {
            nxsY="0";
        }
        document.getElementById('user_options').classList.remove('showUsrOpts'+nxsY);
        document.getElementById('user_options').classList.add('showUsrOpts'+nxsW);
        varUsrOpts =nxsW;
    }
    function setXSearch(nxsW) {
        if ( nxsW=="0") {
            nxsY="1";
        } else {
            nxsY="0";
        }
        document.getElementById('nxs_sidesearch').classList.remove('sidesearch'+nxsY);
        document.getElementById('nxs_sidesearch').classList.add('sidesearch'+nxsW); 
        varSearch =nxsW;
    }
    function setWMenu(nxsW) {
        if ( nxsW=="0") {
            nxsY="1";
        } else {
            nxsY="0";
        }
        document.getElementById('kld_nameagency').classList.remove('wagency'+nxsY);
        document.getElementById('kld_nameagency').classList.add('wagency'+nxsW); 
        document.getElementById('kld_menu').classList.remove('menukl'+nxsY);
        document.getElementById('kld_menu').classList.add('menukl'+nxsW); 
        document.getElementById('kld_container').classList.remove('deskkl'+nxsY);
        document.getElementById('kld_container').classList.add('deskkl'+nxsW);
        document.getElementById('kld_logo').classList.remove('logokl'+nxsY);
        document.getElementById('kld_logo').classList.add('logokl'+nxsW); 
        document.getElementById('lglg').classList.remove('logo_lg'+nxsY);
        document.getElementById('lglg').classList.add('logo_lg'+nxsW); 
        document.getElementById('lgmini').classList.remove('logo_mini'+nxsY);
        document.getElementById('lgmini').classList.add('logo_mini'+nxsW); 
        
        varMenu =nxsW;
    }
    function loadChngPass() {
        // $('#GnmX_ChngPass').modal();
        var loading = '<div class="loadingio-spinner-pulse-k1yr7g9iihb"><div class="ldio-cm9jib51jwb"><div></div><div></div><div></div></div></div>';
        document.getElementById('bodyChngPass').innerHTML = loading;
        AbrirChngPass('bodyChngPass');
    }
    function sessionClose() {
        document.getElementById('kld_top').innerHTML = "";
        document.getElementById('kld_top').classList.add('cien');
        document.getElementById('kld_top').classList.remove('top_bar');
        setTimeout(function(){
            window.location.href="functions/php/nexus/nosession.php";
        }, 800);
    }
    function loadMenuOpts() {
        loadDataFetch('mnupnl', Menu, 'Func=menuInit');
        loadDataFetch('imgpnl', Funciones, 'Func=logoAxisKlud');
    }
    function loadBoxes() {
        loadDataFetch('boxCotiz', Funciones, 'Func=klcotizador');
        loadDataFetch('boxDistPln', Funciones, 'Func=kldistplan');
        loadDataFetch('boxDestCli', Funciones, 'Func=kldestclientes');
        loadDataFetch('boxVentas', Funciones, 'Func=klrepventas');
        loadDataFetch('cardinnerkld1', Funciones, 'Func=kltrm');
        loadDataFetch('cardinnerkld2', Funciones, 'Func=klpolvig');
        loadDataFetch('cardinnerkld3', Funciones, 'Func=klcotact');
        loadDataFetch('cardinnerkld4', Funciones, 'Func=klpolanul');
    }
    function addFunctions() {
        var toogle_menu = document.getElementById("toogle_menu");
        toogle_menu.onclick = function() {
            if (varMenu=="0") {
                setWMenu("1");
            } else {
                setWMenu("0");
            }
        }
        var toogle_useropts = document.getElementById("kld_nameuser");
        toogle_useropts.onclick = function() {
            if (varUsrOpts=="0") {
                showUsrOpts("1");
            } else {
                showUsrOpts("0");
            }
        }
        var toogle_search = document.getElementById("kld_search");
        toogle_search.onclick = function() {
            if (varSearch=="0") {
                setXSearch("1");
            } else {
                setXSearch("0");
            }
        }
        var passusr = document.getElementById("btn_passusr");
        passusr.onclick = function() {
            loadChngPass();
        }
        var sessionusr = document.getElementById("btn_sessionusr");
        sessionusr.onclick = function() {
            sessionClose();
        }
        var sessionusr2 = document.getElementById("mnulogout");
        sessionusr2.onclick = function() {
            sessionClose();
        }
        
    }
    function locateTop() {
        setTimeout(function(){
            document.getElementById('kld_top').classList.remove('cover_lazy');
            document.getElementById('kld_top').classList.add('top_bar');
        }, 600);
         
    }

    init();

    
})();

function LoadModalidades(val)
{
    url='plugins/klcotizador/klmodalidades.php?Plan='+val;
    console.log(url);
    fetch(url)
        .then(response => response.text())
        .then(commits => document.getElementById('cmb_modalidad').innerHTML=commits);
}

function nxsCotiza()
{
	document.getElementById('calccotiz').innerHTML='Calculando...';
	document.getElementById('calccotiz').classList.add('disabled');
	
	dias=document.getElementById('dias').value;
	val=document.getElementById('cmb_plan').value;
	mod=document.getElementById('cmb_modalidad').value;     	
	
    url= 'plugins/klcotizador/klcalcular.php';
    data = {nxsplan:val,nxsdias:dias,nxsmod:mod};
    console.log(url);
    fetch(url, {
        method: 'POST',
        body: 'nxsplan='+val+'&nxsdias='+dias+'&nxsmod='+mod,
        headers: 
        {
            "Content-Type": "application/x-www-form-urlencoded"
        }})
        .then(response => response.text())
        .then(commits =>{
        	document.getElementById('valorCotiza').innerHTML='U$ '+commits;
        	document.getElementById('exeCotizar').innerHTML=' <i class="fa fa-paper-plane"></i> ';
        	document.getElementById('calccotiz').innerHTML='Calcular <i class="fa fa-arrow-circle-right"></i>';
    		document.getElementById('calccotiz').classList.remove('disabled');
        });
        
    
}

function nxsNewCotiza()
{
	CargarForm('application/forms/klcotizaciones.php', 'Nueva Cotizacion', 'reseller_account_template.png')
}

