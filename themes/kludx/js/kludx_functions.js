var varMenu=0;
var Funciones="functions/php/nexus/kfunctions.php";
(function(){
    function init(){
        loadElements();
        percentCover("0.6");
        loadInfoTop();

        addFunctions();
        percentCover("1");
        locateTop();
        setWMenu("0");
    }
    function loadDatafetch(url, params) {
        if (params!="") {
            url=url+"?"+params;
        }
        resp="";
        fetch(url)
        .then(response => {response.text()})
        .then(data => {return data});
    }
    function createDivs(iddiv){
        var loading = '<div class="loadingio-spinner-pulse-k1yr7g9iihb"><div class="ldio-cm9jib51jwb"><div></div><div></div><div></div></div></div>';
        return '<div id="'+iddiv+'">'+loading+'</div>';        
    }
    function loadElements(){
        var cover = createDivs('kld_top');
        var menu = createDivs('kld_menu');
        var nxs = createDivs('kld_nexus');
        var dashboard = createDivs('kld_container');
        document.getElementById('bdy_kludx').innerHTML = cover+nxs;
        document.getElementById('kld_nexus').innerHTML = menu+dashboard;
        document.getElementById('kld_top').classList.add('cover_lazy'); 
        document.getElementById('kld_top').innerHTML = "";
        document.getElementById('kld_menu').classList.add('menu_init');
        document.getElementById('kld_container').classList.add('dashboard_init');
    }
    function percentCover(perc) {
        document.getElementById('kld_top').style.opacity=perc; 
    }
    function loadInfoTop() {
        var logo = createDivs('kld_logo');
        var ctrlmenu = createDivs('kld_ctrlmenu');
        var nameagency = createDivs('kld_nameagency');
        var nameuser = createDivs('kld_nameuser');
        var search = createDivs('kld_search');
        document.getElementById('kld_top').innerHTML = logo+ctrlmenu+nameagency+nameuser+search;
        loadDataIni();
        document.getElementById('kld_logo').innerHTML = '<a href="index.php?nxsdb=klud" class="logo"> <span id="lgmini" class="logo-mini"><img src="http://cdn.genomax.co/media/image/logoklud_32mini.png" alt="Kl\'ud"></span> <span id="lglg" class="logo-lg"><img src="http://cdn.genomax.co/media/image/logoklud_32.png" alt="Kl\'ud"> </span> </a>';
        document.getElementById('kld_ctrlmenu').innerHTML = '<a href="#" role="button" id="toogle_menu" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16"> <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5zm0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5z"/> </svg> </a>';
        document.getElementById('kld_search').innerHTML = '<a href="#" role="button" > <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16"> <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/> </svg> </a>';
    }
    function loadDataIni() {
        document.getElementById('kld_nameagency').innerHTML=loadDatafetch(Funciones, 'Func=NombreEmpresa');
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
    function addFunctions() {
        var toogle_menu = document.getElementById("toogle_menu");
        toogle_menu.onclick = function() {
            if (varMenu=="0") {
                setWMenu("1");
            } else {
                setWMenu("0");
            }
        }
    }
    function locateTop() {
        document.getElementById('kld_top').classList.remove('cover_lazy');
        document.getElementById('kld_top').classList.add('top_bar'); 
    }

    init();

    
})();