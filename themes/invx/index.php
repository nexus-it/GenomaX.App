<?php
$SQL="Select Update_DCD  From itconfig";
$resultrt = mysqli_query($conexion, $SQL);
$version="0";
if ($rowrt = mysqli_fetch_array($resultrt)) {
	$version=$rowrt[0];
	$_SESSION["VERSION_CONTROL"]= $version;
}
mysqli_free_result($resultrt);

LoadHead($version);
$NoSession="";
if (isset($_GET["nxsdb"])){
	$NoSession="?nxsdb=".$_GET["nxsdb"];
}
?>
<body  class=" fixed sidebar-mini skin-blue">
<audio id="nxs_sound_error" src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/audio/error-03.mp3" preload="auto"></audio>
<audio id="nxs_sound_info" src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/audio/beep-29.mp3" preload="auto"></audio>
<audio id="nxs_sound_ok" src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/audio/ok-03.mp3" preload="auto"></audio>
<audio id="nxs_sound_done" src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/audio/done-03.mp3" preload="auto"></audio>
<audio id="nxs_sound_intro" src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/audio/intro.mp3" preload="auto"></audio>
<div id="TodoAll" class="wrapper">
<!-- Tema nuevo -->
<header class="main-header">
    <!-- Logo -->
    <a href="" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/logo_invoix.png" alt="InvoiX" height="45px" title="InvoiX <?php ShowVersion(); ?>"></span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/titinvoix_45.png" height="45px" style="margin-top: 2;" alt="InvoiX" title="InvoiX <?php ShowVersion(); ?>"> </span>
      <!-- <div id="logo" title="Mostrar página inicial" ></div> -->
 	</a>
  
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">...</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages: style can be found in dropdown.less-->
          <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="cursor: default">
              <i class="fa fa-building-o"></i>
              <span id="razonsocial" class="hidden-xs"></span>
            </a>
          </li>
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-user"></i>
              <span class="hidden-xs"><?php echo utf8_encode($_SESSION["it_NombreUSR"]); ?></span>
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <img src="files/logo<?php echo $_GET["nxsdb"]; ?>.jpg" class="img-circle" alt="User Image">
                <?php
                
                /*
                $SQL="SELECT a.Codigo_USR, a.Nombre_USR, b.Nombre_PRF FROM itusuarios a, itperfiles b WHERE b.Codigo_PRF=a.Codigo_PRF AND a.Codigo_USR='".$_SESSION["it_CodigoUSR"]."'";
                $result = mysqli_query($conexion, $SQL);
                if($row = mysqli_fetch_array($result)) {
                  echo '<p>
                  '.$row[1].' <br> <small>Perfil: '.$row[2].'</small>
                </p>';
                }
                mysqli_free_result($result);
                */
                  echo '<p>
                  '.utf8_decode($_SESSION["it_NombreUSR"]).' <br> <small>Perfil: '.utf8_decode($_SESSION["it_NombrePRF"]).'</small>
                </p>';
                
                ?>
              </li>
              <!-- Menu Body -->
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-left">
                  <a href="javascript:CargarChngPass();" class="btn btn-success btn-flat">Cambio Clave</a>
                </div>
                <div class="pull-right">
                  <a href="javascript:CloseSession('<?php echo $NoSession; ?>');" class="btn btn-success btn-flat">Cerrar Sesión</a>
                </div>
              </li>
            </ul>
          </li>
          <!-- Control Sidebar Toggle Button -->
          <li class="dropdown user user-menu">
            <a href="#" data-toggle="control-sidebar" class="dropdown-toggle"><i class="fa fa-folder-o" id="nxs_folder"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>
<!-- Menu Barra Lateral -->
  <aside class="main-sidebar" style="background-position: center;background-size: cover;background-image: url('<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/bcksidebar.jpg');">
    <section class="sidebar" style="background-color: rgba(34, 45, 50, 0.95);">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="files/logo<?php echo $_GET["nxsdb"]; ?>.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info" style="margin-top: 10px;">
          OPCIONES
        </div>
      </div>
      <ul class="sidebar-menu" data-widget="tree" id="nxs_mainmenu">
      	<?php
        //error_log("Menu... ");
			nxsLoadModules($_SESSION["NEXUS_APP"], $_SESSION["it_CodigoPRF"]);
      //error_log("...Menu ");
		?>
		<li class="header"> -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -   -  </li>
        <li class="manito"><a onClick="nxs_meet1('normal')" title="Video Conferencias Seguras" data-toggle="modal" data-target="#GnmX_NXSMeet"> <i class="glyphicon glyphicon-facetime-video" aria-hidden="true" id="nxs_callin"></i> <span><b>NEXUS.<em>Meet</em></b></span> </a></li>
        <li class="manito"><a onClick="CargarChngPass()"><i class="fa fa-key text-yellow"></i> <span>Cambio de Clave</span></a></li>
        <li class="manito"><a onClick="AboutGNX();"><i class="fa fa-play-circle text-blue"></i> <span>Acerca de...</span></a></li>
        <li class="manito"><a onClick="CloseSession('<?php echo $NoSession; ?>')"><i class="fa fa-sign-out text-red"></i> <span>Cerrar Sesión</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>


<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper nxsWindow" id="nxscontainer">
<?php
  $SQL="Select Class_ALR, Titulo_ALR, Texto_ALR From italertas Where Estado_ALR='1'";
  $resultrt = mysqli_query($conexion, $SQL);
  while ($rowrt = mysqli_fetch_array($resultrt)) {
    echo '<div class="alert alert-'.$rowrt[0].'" role="alert" style="color:#FEFEFE; padding: 5px;margin-bottom: 2px;""><strong>'.$rowrt[1].'</strong> '.$rowrt[2].'</div>';
  }
  mysqli_free_result($resultrt);

?>

    <div id="gx-tabs" class="tab-content">
      <div role="tabpanel" class="tab-pane fade container  active in" id="Window_0">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          Dashboard
          <small>Página de Inicio</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Inicio</a></li>
          <li class="active">Dashboard</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content">
        <!-- Small boxes (Stat box) -->
        <?php 
        include 'plugins/gxfrecuentes/gxfrecuentes.php';
        ?>
        <!-- Main row -->
        <div class="row">
          <span id="nxs_chartboard" name="nxs_chartboard">
           
          </span>
          <!-- Left col -->
          <section class="col-sm-7 connectedSortable">
            <!-- Cotizador -->
            <?php 
            include 'plugins/gxmorbilidad30/gxmorbilidad30.php';

            /* include 'plugins/klplanestop/klplanestop.php'; */
            ?>

          </section>
          <!-- /.Left col -->
          <!-- right col (We are only adding the ID to make the widgets sortable)-->
          <section class="col-sm-5 connectedSortable">

          <?php 
            include 'plugins/gxetareo30/gxetareo30.php';

           /* include 'plugins/klventas30/klventas30.php'; */
          ?>
            
          </section>
          <!-- right col -->
        </div>
        <!-- /.row (main row) -->
      </section>
      </div>
      
      <!-- /.content -->
    </div>
  </div>
<!-- Fin tema nuevo -->

</div>  
	
	</div>
</div>

</div>

<!-- Acceso Reciente -->
<!--
	<div id="lastaccess" class="col-md-12 text-right">
		<pre >
		<?php 
		
		$SQL="Select concat('Acceso reciente el ',a.Fecha_AUD,' vía ', a.BrowserName_AUD,' ', a.BrowserVersion_AUD, ' desde ', a.Direccion_AUD) from itauditoria a Where Codigo_USR='".$_SESSION["it_CodigoUSR"]."' and a.Registro_AUD='LogIn' order by 1 desc limit 2";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_array($result)) {
		echo $row[0];
		}
		mysqli_free_result($result);
		
		?>
		</pre>
	</div>
-->
<!-- Fin Acceso Reciente -->
<!-- MsgBox 1 -->
<div class="modal fade" id="msgbox1">
  <div class="modal-dialog" id="GnmX_ModMsgBox">
    <div class="modal-content panel-success">
      <div class="modal-header panel-heading bg-success" id="GnmX_TitMsgBox">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="label label-warning"><span class="glyphicon glyphicon-alert"></span></span> <span id="titleMsgBox" class="label label-success"><?php echo $_SESSION["NOMBRE_APP"];?></span></h4>
      </div>
      <div class="modal-body" id="bodyMsgBox">
        <div class="cargando"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal" >Aceptar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Fin MsgBox1 -->

<!-- Cambio de Clave -->
<div class="modal fade" id="GnmX_ChngPass">
  <div class="modal-dialog" id="GnmX_ModChngPass">
    <div class="modal-content panel-success" id="ChngPassX">
      <div class="modal-header panel-heading" id="GnmX_TitChngPass">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-user"></span> Cambio de Clave <span id="idChngPass">&hellip;</span></h4>
      </div>
      <div class="modal-body" id="bodyChngPass">
        <div class="cargando"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:PassCoDe();" data-dismiss="modal">Actualizar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Fin Cambio de Clave -->
<!-- Formulario de búsqueda -->
<div class="modal fade" id="GnmX_Search" style="z-index: 1100;">
  <div class="modal-dialog" id="GnmX_ModSearch">
    <div class="modal-content panel-success">
      <div class="modal-header panel-heading" id="GnmX_TitSearch">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span class="glyphicon glyphicon-search"></span> Buscar <span id="idSearch">&hellip;</span></h4>
      </div>
      <div class="modal-body" id="bodySearch">
        <div class="cargando"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="javascript:AcceptOk('txt_selSearch',document.getElementById('hdn_TargetNxs').value);" data-dismiss="modal">Seleccionar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Fin Formulario de búsqueda -->
<!-- Ventanas Modales -->
<div class="modal fade" id="GnmX_WinModal">
  <div class="modal-dialog modal-lg" id="GnmX_ModWind" style="width: 94%;">
    <div class="modal-content panel-success row">
      <div class="modal-header panel-heading" id="GnmX_TitWind">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span id="idWindModal"></span></h4>
      </div>
      <div class="modal-body col-md-12" id="bodyWind">
        <div class="cargando"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="GnmX_WinModal2">
  <div class="modal-dialog modal-lg" id="GnmX_ModWind2" style="width: 90%;">
    <div class="modal-content panel-success row">
      <div class="modal-header panel-heading" id="GnmX_TitWind2">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span id="idWindModal2"></span></h4>
      </div>
      <div class="modal-body col-md-12" id="bodyWind2">
        <div class="cargando"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Fin Ventanas Modales -->
<!-- NEXUS Meet -->
<div class="modal fade" id="GnmX_NXSMeet">
  <div class="modal-dialog modal-lg" id="GnmX_ModMeet" style="width: 55%;">
    <div class="modal-content panel-success row">
      <div class="modal-header panel-heading" id="GnmX_TitMeet">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title"><span id="idWindNXSMeet"> <span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span> <b>NEXUS.<em>Meet</em></b> <small>[Video Conferencias Seguras]</small></span></h4>
      </div>
      <div class="modal-body col-md-12" id="bodyMeet">
        


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning " data-dismiss="modal">Salir <span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> </button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- Fin NEXUS Meet -->
</div>
<?php 
LoadFoot($version);
?>
</div>
</div>
</body>
<!--[if IE]>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/chrome-frame/1/CFInstall.min.js"></script>
<script>
   CFInstall.check({
      destination: "<?php echo "http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']; ?>"
   });
</script>
<![endif]-->	
</html>
