<?php
	

session_start();
	include 'auditoria.php';	
	it_aud('0', 'LogOut', 'Cierre de Sesi�n');
	$Enterprise="";
	if (isset($_GET["nxsdb"])) {
		$Enterprise="&nxsdb=".$_GET["nxsdb"];
	} else {
		$Enterprise="&nxsdb=".$_SESSION["DB_SUFFIX"];
	}
	session_destroy();
	if (isset($_GET["timeout"])) {
		header('Location: ../../../index.php?app='.$_SESSION["NEXUS_APP"].$Enterprise);
		}
	else {
		if (isset($_GET["exit"])) {
			header('Location: ../../../index.php?app='.$_SESSION["NEXUS_APP"].$Enterprise);
		}
		else {
			header('Location: ../../../index.php?app='.$_SESSION["NEXUS_APP"].$Enterprise);
		}
	}
?>