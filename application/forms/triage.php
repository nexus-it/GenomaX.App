<?php

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
	mysqli_query($conexion, $MyZone);

?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="row well well-sm">

	<?php 
	$Contamodulos=0;
	if  (!(isset($_GET["modulo"]))) {	
	?>
		<div class="col-md-offset-2 col-md-8" id="grpmodulo<?php echo $NumWindow; ?>" name="grpmodulo<?php echo $NumWindow; ?>">
	<div class="form-group">
		<label for="cmb_modulo<?php echo $NumWindow; ?>">Seleccione Su Consultorio</label>
		<select name="cmb_modulo<?php echo $NumWindow; ?>" id="cmb_modulo<?php echo $NumWindow; ?>">
	<?php 
		$SQL="Select Codigo_CNS, Nombre_CNS From gxconsultorios Where Estado_CNS='1' and Triage_CNS='1' Order By Codigo_CNS;";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) 
		{
			$Contamodulos++;
	 	?>
	    	<option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
	    <?php
	    	$Elmodulo=$row[0];
	    	$Nombremodulo=$row[1];
		}
		mysqli_free_result($result); 
 	?>
 		</select>
	</div>
		<?php echo '<a href="javascript:selmodulo'.$NumWindow.'();" class="btn btn-success btn-sm btn-block" role="button" > Continuar </a>'; ?>
		</div>
		
	<?php 
	} else {
		$Elmodulo=$_GET["modulo"];
	    $Contamodulos=$_GET["contamodulos"];
	}
?>
<input type="hidden" name="hdn_modulo<?php echo $NumWindow; ?>" id="hdn_modulo<?php echo $NumWindow; ?>" value="<?php echo $Elmodulo; ?>"/>
<input type="hidden" name="hdn_contamodulos<?php echo $NumWindow; ?>" id="hdn_contamodulos<?php echo $NumWindow; ?>" value="<?php echo $Contamodulos; ?>"/>
<?php
	if  (((!(isset($_GET["modulo"]))) && ($Contamodulos==1))||(isset($_GET["modulo"]))) {
		$SQL="Select Codigo_CNS, Nombre_CNS From gxconsultorios Where Estado_CNS='1' and Triage_CNS='1' and Codigo_CNS='".$Elmodulo."';";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) 
		{
	    	$Nombremodulo=$row[1];
		}
		mysqli_free_result($result); 
		$ChngMod='<a href="javascript:ChngMod'.$NumWindow.'();" role="button" class="btn btn-default btn-xs" title="Cambiar Modulo"> <span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> </a>';
	?>

	<label class="label label-default"> CONSULTORIO: <?php echo $Nombremodulo.' '; if ($Contamodulo>1) { echo $ChngMod; } ?></label>
	<div class="table-responsive">
		<table class="table table-condensed table-striped table-hover tblDetalle">
		    <tbody id="tbDetalle<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
				    <th id="th1<?php echo $NumWindow; ?>">Consecutivo</th> 
				    <th id="th2<?php echo $NumWindow; ?>">Fecha</th> 
					<th id="th3<?php echo $NumWindow; ?>">Documento</th> 
					<th id="th4<?php echo $NumWindow; ?>">Nombre Paciente</th> 
					<th id="th5<?php echo $NumWindow; ?>">Minutos</th>
					<th id="th6<?php echo $NumWindow; ?>">Clasificar</th>
				</tr> 
					<?php 
					$SQL="SELECT b.Codigo_TRG, b.Fecha_TRG, a.ID_TER, a.Nombre_TER, TIMESTAMPDIFF(MINUTE, b.Fecha_TRG,NOW()) FROM czterceros a, hctriage b, gxconsultorios c, gxareas d WHERE a.Codigo_TER = b.Codigo_TER AND c.Codigo_ARE=d.Codigo_ARE AND d.Codigo_SDE=b.Codigo_SDE AND  b.Estado_TRG = '1' AND c.Codigo_CNS='".$Elmodulo."' ORDER BY 2 ASC ";
					$resulthc = mysqli_query($conexion, $SQL);
					$contarow=0;
					while($rowhc = mysqli_fetch_array($resulthc)) 
						{
							$contarow=$contarow+1;
							echo '
					  <tr ><td ><input type="hidden" name="hdn_pretri'.$contarow.$NumWindow.'" id="hdn_pretri'.$contarow.$NumWindow.'" value="'.$rowhc[0].'"/>'.$rowhc[0].'</td><td align="center">'.$rowhc[1].'</td><td>'.$rowhc[2].'</td><td>'.$rowhc[3].'</td><td align="center">'.$rowhc[4].'</td><td align="center"> <a href="javascript:Clasificar'.$NumWindow.'(\''.$rowhc[0].'\', \''.$rowhc[2].'\');" role="button" class="btn btn-default btn-sm" title="Llamar paciente '.$rowhc[3].' a clasificación"> <span class="glyphicon glyphicon-check" aria-hidden="true"></span> </a></td></tr>
					  ';
						}
					mysqli_free_result($resulthc); 
					?> 
			</tbody>
	    </table>
	</div>
</div>
	<?php
	}
	?>

</form>

<script >
<?php
if  (((!(isset($_GET["modulo"]))) && ($Contamodulos==1))||(isset($_GET["modulo"]))) {
	echo "var myTimer".$NumWindow." =setInterval(function(){ RefreshTriage".$NumWindow."(); }, 3600);";
}

if  ((!(isset($_GET["modulo"]))) && ($Contamodulos==1)) {
	echo "$('#grpmodulo".$NumWindow."').hide();";
}
?>

function RefreshTriage<?php echo $NumWindow; ?>() {
	RefreshTriage('<?php echo $NumWindow; ?>', 'modulo', '<?php echo $Elmodulo; ?>');
}

function Clasificar<?php echo $NumWindow; ?>(NumPre, Pac) {
	CallTriage(NumPre, '<?php echo $Elmodulo; ?>', Pac);
}

function selmodulo<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/triage.php', '<?php echo $NumWindow; ?>', '&modulo='+document.getElementById('cmb_modulo<?php echo $NumWindow; ?>').value+'&contamodulos='+document.getElementById('hdn_contamodulos<?php echo $NumWindow; ?>').value);	
}

function ChngMod<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/triage.php', '<?php echo $NumWindow; ?>', '');	
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

</script>
