<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	

?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>">
<fieldset>
  <legend>Actualizar Intercalación en BD:</legend>

  <p align="center">CHARACTER SET =&gt; utf8</p>
  <p align="center">COLLATE =&gt;  utf8_general_ci</p>
  <div class="generartxt" onClick="javascript: SyncEmpFP<?php echo $NumWindow; ?>();">Iniciar proceso</div>
</fieldset>
<fieldset>
<legend>Progreso</legend>
  <div id="prgsyncfp<?php echo $NumWindow; ?>" class="tblDetalle1">
    -- No se ha iniciado la actualización de tablas y campos -- 
  </div>
</fieldset>
</form>

<script >

function ProgresSync<?php echo $NumWindow; ?>(Orden, Contender, Datos) {
	InsertarHTML(Contender+'<?php echo $NumWindow; ?>', '<div align="center"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/button_ok.png" border="0" align="absmiddle" /></div>');
	InsertarHTML(Contender+'<?php echo $NumWindow; ?>',Datos+'<div id="Sync_'+Orden+'_<?php echo $NumWindow; ?>" ></div>');

	InsertarHTML('Sync_'+Orden+'_<?php echo $NumWindow; ?>', '<div align="center"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/loadingform.gif" border="0" align="absmiddle" /></div>');
}

function SyncEmpFP<?php echo $NumWindow; ?>() {
	
	ProgresSync<?php echo $NumWindow; ?>('0', 'prgsyncfp', "Iniciando Actualización...");
<?php 
$tabs = array();
$contatabs=0;
$res = mysqli_query ($conexion, "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.tables where table_type='BASE TABLE' and Table_schema='".$_SESSION["DB_NAME"]."' ORDER BY TABLE_NAME");

while (($row = mysqli_fetch_row($res)) != null) {
        $tabs[] = $row[0];
}
foreach ($tabs as $tab)
{
	$contatabs++;
?>
$.ajax({  
  type: "POST",  
  url: Transac,  
  data: "Func=collate&tabla=<?php echo $tab; ?>",  
  success: function(respuesta) { 
	ProgresSync<?php echo $NumWindow; ?>('<?php echo $contatabs; ?>', 'Sync_<?php echo ($contatabs-1); ?>_', "Intercalación Restaurada en <?php echo $tab; ?>");
  }  
});  
<?php
}	
?>	

}

</script>