<?php

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$SexoPcte=$_GET["SexoPcte"];
?>

<div class="row">
	<?php
	$iSexPcte="";
  	// Si se cargó un pcte, verificamoslas condiciones de los tipos de hc
  	if ($SexoPcte!="") {
  		$iSexPcte=" and Sexo".$SexoPcte."_HCT='1' ";
  	}
  	if ($_SESSION["it_CodigoPRF"]=='0') {
  		$SQL="Select Codigo_HCT, Descripcion_HCT, Icono_HCT from hctipos where Activo_HCT='1' and Triage_HCT='0' ".$iSexPcte." order by 2";
  	} else {
  		$SQL="Select Codigo_HCT, Descripcion_HCT, Icono_HCT from hctipos where Activo_HCT='1' and Triage_HCT='0' and Codigo_HCT in (Select Codigo_HCT From hcusuarioshc Where Codigo_USR ='".$_SESSION["it_CodigoUSR"]."') ".$iSexPcte." order by 2";
  	}
  	echo '
  	<input name="hdn_modehc'.$NumWindow.'" type="hidden" id="hdn_modehc'.$NumWindow.'" value="'.$_GET["ModeHC"].'" />
  	<input name="hdn_historia'.$NumWindow.'" type="hidden" id="hdn_historia'.$NumWindow.'" value="'.$_GET["Historia"].'" />
  	<input name="hdn_area'.$NumWindow.'" type="hidden" id="hdn_area'.$NumWindow.'" value="'.$_GET["Area"].'" />
  	<input name="hdn_cita'.$NumWindow.'" type="hidden" id="hdn_cita'.$NumWindow.'" value="'.$_GET["Cita"].'" />
  	<input name="hdn_window'.$NumWindow.'" type="hidden" id="hdn_window'.$NumWindow.'" value="'.$_GET["Window"].'" />
  	';
	$result = mysqli_query($conexion, $SQL);
	$contarow=0;
	while($row = mysqli_fetch_array($result)) 
		{
		$contarow++;
		echo '<div class="col-xs-6 col-sm-6 col-md-2">
    <a href="javascript:selecthc'.$NumWindow.'(\''.$row[0].'\');" class="thumbnail">
      <img src="http://cdn.genomax.co/media/image/icons/32x32/'.$row[2].'.png" alt="'.$row[1].'">
      <div class="caption bg-success center-block" style="height:65px;">
      <p ><h5 class="text-success text-center text-capitalize">'.$row[1].'</h5></p>
        
      </div>
    </a>
  </div>
		';
		}
		mysqli_free_result($result);
		?>
  
</div>

<script type="text/javascript">
function selecthc<?php echo $NumWindow; ?>(CodigoHCT) {
	AbrirForm('application/forms/hc.php', document.getElementById('hdn_window<?php echo $NumWindow; ?>').value, '&FormatoHC='+CodigoHCT+'&Historia='+document.getElementById('hdn_historia<?php echo $NumWindow; ?>').value+'&Area='+document.getElementById('hdn_area<?php echo $NumWindow; ?>').value+'&ModeHC='+document.getElementById('hdn_modehc<?php echo $NumWindow; ?>').value+'&Cita='+document.getElementById('hdn_cita<?php echo $NumWindow; ?>').value);
	$('#GnmX_WinModal').modal('hide');
}
</script>