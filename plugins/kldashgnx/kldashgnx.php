<?php
session_start();
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>


<script>
updtdashboard();

function updtdashboard()
{
	Loadnxswdgcotiza();
	Loadnxswdgpoliza();
	Loadnxswdgcotizano();
	Loadnxswdgpolizano();
}

function Loadnxswdgcotiza()
{
    $.ajax({
        type: "POST",
        url: 'plugins/kldashboard/klwdgcotiza.php',
        data: 'tipo=1',
        success: function(resp){
            $('#nxswdgcotiza').html(resp);
        }
    });
}

function Loadnxswdgpoliza()
{
    $.ajax({
        type: "POST",
        url: 'plugins/kldashboard/klwdgpoliza.php',
        data: 'tipo=1',
        success: function(resp){
            $('#nxswdgpoliza').html(resp);
        }
    });
}

function Loadnxswdgcotizano()
{
    $.ajax({
        type: "POST",
        url: 'plugins/kldashboard/klwdgcotizano.php',
        data: 'tipo=1',
        success: function(resp){
            $('#nxswdgcotizano').html(resp);
        }
    });
}

function Loadnxswdgpolizano()
{
    $.ajax({
        type: "POST",
        url: 'plugins/kldashboard/klwdgpolizano.php',
        data: 'tipo=1',
        success: function(resp){
            $('#nxswdgpolizano').html(resp);
        }
    });
}

</script>