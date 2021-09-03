<?php

session_start();
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
	mysqli_query($conexion, $MyZone);

?>
<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Llamado a Triage</title>
<link rel="shortcut icon" href="../../themes/triage/images/favicon.ico">
<link type="text/css" href="../../settings/css/allinone_carousel.css?v=<?php echo $_GET["v"]; ?>001" rel="stylesheet" />
<link type="text/css" href="../../settings/css/normalize.css?v=<?php echo $_GET["v"]; ?>001" rel="stylesheet" />
<link type="text/css" href="../../themes/triage/bootstrap.css?v=<?php echo $_GET["v"]; ?>001" rel="stylesheet" />
<link type="text/css" href="../../themes/triage/bootstrap.datetimepicker.min.css?v=<?php echo $_GET["v"]; ?>001" rel="stylesheet" />
<link type="text/css" href="../../themes/triage/datepicker.min.css?v=<?php echo $_GET["v"]; ?>001" rel="stylesheet" />
<link type="text/css" href="../../themes/triage/login.css?v=<?php echo $_GET["v"]; ?>001" rel="stylesheet" />
<link type="text/css" href="../../themes/triage/scrollpane.css?v=<?php echo $_GET["v"]; ?>001" rel="stylesheet" />
<link type="text/css" href="../../themes/triage/select2.min.css?v=<?php echo $_GET["v"]; ?>001" rel="stylesheet" />
<link type="text/css" href="../../themes/triage/sweetalert.css?v=<?php echo $_GET["v"]; ?>001" rel="stylesheet" />
<link type="text/css" href="../../themes/triage/z-style.css?v=<?php echo $_GET["v"]; ?>XxrX2" rel="stylesheet" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
<audio id="nxs_sound_error" src="../../themes/triage/sounds/error-03.mp3" preload="auto"></audio>
<audio id="nxs_sound_info" src="../../themes/triage/sounds/info-03.mp3" preload="auto"></audio>
<audio id="nxs_sound_ok" src="../../themes/triage/sounds/ok-03.mp3" preload="auto"></audio>
<audio id="nxs_sound_done" src="../../themes/triage/sounds/done-03.mp3" preload="auto"></audio>
<audio id="nxs_sound_intro" src="../../themes/triage/sounds/intro.mp3" preload="auto"></audio>
<audio id="nxs_sound_msg" src="../../themes/triage/sounds/ding.mp3" preload="auto"></audio>

<div class="container">
<div class="row well well-lg">
	<div class="col-md-6 col-lg-5" >
		<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
		  <!-- Indicators -->
		  <ol class="carousel-indicators">
		    <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
		    <li data-target="#carousel-example-generic" data-slide-to="1"></li>
		    <li data-target="#carousel-example-generic" data-slide-to="2"></li>
		  </ol>

		  <!-- Wrapper for slides -->
		  <div class="carousel-inner" role="listbox">
		    <div class="item active">
		      <img src="../../triage1.jpg" alt="...">
		      <div class="carousel-caption">
		        
		      </div>
		    </div>
		    <div class="item">
		      <img src="../../triage2.jpg" alt="...">
		      <div class="carousel-caption">
		        
		      </div>
		    </div>
		    <div class="item">
		      <img src="../../triage3.jpg" alt="...">
		      <div class="carousel-caption">
		        
		      </div>
		    </div>
		    
		  </div>

		  <!-- Controls -->
		  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
		    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
		    <span class="sr-only">Previous</span>
		  </a>
		  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
		    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
		    <span class="sr-only">Next</span>
		  </a>
		</div>
	</div>
	<div class="col-md-6 col-lg-7" >
		<div class="table-responsive">
			<table class="table table-condensed table-striped table-hover tblDetalleTriage">
			    <tbody id="tbCallTriage1">
					<tr id="trh"> 
						<th id="th1">MÓDULO</th> 
						<th id="th2">PACIENTE</th> 
					</tr> 
				</tbody>
		    </table>
		</div>
	</div>
	<div class="col-md-6 col-lg-7" >
		<div class="table-responsive">
			<table class="table table-condensed table-striped table-hover tblDetalleTriage">
			    <tbody id="tbCallTriage2">
					<tr id="trh"> 
						<th id="th1">CONSULTORIO</th> 
						<th id="th2">PACIENTE</th> 
					</tr> 
				</tbody>
		    </table>
		</div>
	</div>	
</div>
<div class="row well well-lg" >
	<div class="col-md-12" id="logoshowtriage">

		
	</div>
</div>
</div>
<script src="../../themes/triage/js/1.jquery-1.11.2.min.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>
<script src="../../themes/triage/js/2.bootstrap.min.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>
<script src="../../themes/triage/js/2.nxs.moment.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>
<script src="../../themes/triage/js/3.jquery-migrate-1.2.1.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>
<script src="../../themes/triage/js/4.jquery-ui.min.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>
<script src="../../themes/triage/js/5.ajax.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>
<script src="../../themes/triage/js/6.bootstrap-tabcollapse.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>
<script src="../../themes/triage/js/7.bootstrap-datetimepicker.min.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>
<script src="../../themes/triage/js/8.es.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>
<script src="../../themes/triage/js/9.select2.min.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>
<script src="../../themes/triage/js/9.sweetalert.min.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>
<script src="../../themes/triage/loadform.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>

<script src="../../functions/js/nexus.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>
<script src="../../functions/js/validar.js?v=<?php echo $_GET["v"]; ?>19.02.03.001"></script>

<script >
var Funciones="../../functions/php/nexus/functions.php";
var TrgCallTmer =setInterval(function(){ RefreshCllTriage(); }, 5500);	

function RefreshCllTriage() {
	RefreshCallTriageX('X');
}
function RefreshCallTriageX(Tipo) {
	$.get(Funciones,{'Func':'RefreshCallTriage', 'Tipo':'1'},function(data){
		document.getElementById('tbCallTriage1').innerHTML=data;
		$.get(Funciones,{'Func':'RefreshCallTriage', 'Tipo':'2'},function(data){
			document.getElementById('tbCallTriage2').innerHTML=data;
			$.get(Funciones,{'Func':'SoundCallTriage'},function(data){
				if (data=="Llamar") {
					document.getElementById('nxs_sound_msg').play();
				}
			});
		});
	});	
}

</script>

  </body>
</html>