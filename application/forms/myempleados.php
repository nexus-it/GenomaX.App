<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	

$SQL="SELECT NOM_CEDULA, NOM_CODIGO, NOM_NOMBRE, NOM_DIRECC, NOM_TELEFO, NOM_EMAIL, NOM_CARGO, NOM_SEXO, NOM_FECING, NOM_FECRET, NOM_SALACT, NOM_SALANT, NOM_CLASE, NOM_TIPCON, NOM_ESTCIV, NOM_ESTADO, NOM_FECNAC, NOM_OBSERV, NOM_CODCAR FROM MAENOM";
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>">
<fieldset>
  <legend>Sincronización Fomplus-MyEscala:</legend>

  <p align="center"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/fomplusnet_logo.jpg" width="200" height="34" align="baseline" /> ==&gt;&gt;<img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/aquamark.png" width="100" height="100" align="absmiddle" /></p>
  <div class="generartxt" onClick="javascript: SyncEmpFP<?php echo $NumWindow; ?>();">Iniciar proceso</div>
</fieldset>
<fieldset>
<legend>Progreso</legend>
  <div id="prgsyncfp<?php echo $NumWindow; ?>" class="tblDetalle1">
    -- No se ha iniciado la sincronización de datos con Fomplus -- 
  </div>
</fieldset>
</form>

<script >
var MyEscala="functions/php/nexus/myescala.php";

function ProgresSync<?php echo $NumWindow; ?>(Orden, Contender, Datos) {
	InsertarHTML(Contender+'<?php echo $NumWindow; ?>', '<div align="center"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/button_ok.png" border="0" align="absmiddle" /></div>');
	InsertarHTML(Contender+'<?php echo $NumWindow; ?>',Datos+'<div id="Sync_'+Orden+'_<?php echo $NumWindow; ?>" ></div>');

	InsertarHTML('Sync_'+Orden+'_<?php echo $NumWindow; ?>', '<div align="center"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/loadingform.gif" border="0" align="absmiddle" /></div>');
	if (Orden=='7') {
		setTimeout(InsertarHTML('Sync_'+Orden+'_<?php echo $NumWindow; ?>', '[Cargos Homologados]<div align="center"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/button_ok.png" border="0" align="absmiddle" /></div>'), 7000);
	}
}

function SyncEmpFP<?php echo $NumWindow; ?>() {
	
	ProgresSync<?php echo $NumWindow; ?>('0', 'prgsyncfp', "Iniciando Sincronización...");
	
	$.get(MyEscala,{'Func':'origenes'},function(data){ 
		ProgresSync<?php echo $NumWindow; ?>('1', 'Sync_0_', "Reconociendo orígenes de datos...");
		var empresas = data.split(",");
		var contafp=1;
		var precontafp=0;
		for(var i in empresas){
			var actEmp=empresas[i];
			if (actEmp!="") {
				$.get(MyEscala,{'Func':'NomEmpresa', 'Cod':actEmp},function(data){
					contafp++;
					precontafp=contafp-1;
					setTimeout(ProgresSync<?php echo $NumWindow; ?>(contafp, 'Sync_'+precontafp+'_', "Empresa: <b>"+data+"</b>"), 2000);
				});
				$.get(MyEscala,{'Func':'CopiarEmp', 'Cod':actEmp},function(datax){
					contafp++;
					precontafp=contafp-1;
					setTimeout(ProgresSync<?php echo $NumWindow; ?>(contafp, 'Sync_'+precontafp+'_', " :: <i>"+datax+"</i>"), 2000);
				});
			}
		}
	}); 
}

</script>