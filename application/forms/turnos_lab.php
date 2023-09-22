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
		<label for="cmb_modulo<?php echo $NumWindow; ?>">Seleccione Su Módulo</label>
		<select name="cmb_modulo<?php echo $NumWindow; ?>" id="cmb_modulo<?php echo $NumWindow; ?>">
	<?php 
		$SQL="SELECT a.Codigo_CNS, a.Nombre_CNS FROM gxconsultorios a, gxareas b WHERE a.Codigo_ARE=b.Codigo_ARE AND a.Estado_CNS='1' AND b.Estado_ARE='1' AND b.Laboratorio_ARE='1' ORDER BY 2;";
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
		$SQL="SELECT a.Codigo_CNS, a.Nombre_CNS FROM gxconsultorios a, gxareas b WHERE a.Codigo_ARE=b.Codigo_ARE AND a.Estado_CNS='1' AND b.Estado_ARE='1' AND b.Laboratorio_ARE='1' and Codigo_CNS='".$Elmodulo."';";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) 
		{
	    	$Nombremodulo=$row[1];
		}
		mysqli_free_result($result); 
		$ChngMod='<a href="javascript:ChngMod'.$NumWindow.'();" role="button" class="btn btn-default btn-xs" title="Cambiar Modulo"> <span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> </a>';
	?>

	<label class="label label-default"> MÓDULO: <?php echo $Nombremodulo.' '; if ($Contamodulo>1) { echo $ChngMod; } ?></label>
	<div class=""> 
		<a href="javascript:RefreshTurno<?php echo $NumWindow; ?>();" role="button" class="btn btn-info btn-sm btn-block" title="Actualizar"> <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> Actualizar Listado</a>
	</div>
	<div class="table-responsive">
		<table class="table table-condensed table-striped table-hover tblDetalle">
		    <tbody id="tbDetalle<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th1<?php echo $NumWindow; ?>">Tipo Pcte</th> 
				    <th id="th1<?php echo $NumWindow; ?>">Consecutivo</th> 
				    <th id="th1<?php echo $NumWindow; ?>">Proceso</th> 
				    <th id="th2<?php echo $NumWindow; ?>">Fecha</th> 
					<th id="th3<?php echo $NumWindow; ?>">Documento</th> 
					<th id="th4<?php echo $NumWindow; ?>">Nombre Paciente</th> 
					<th id="th5<?php echo $NumWindow; ?>">Minutos</th>
					<th id="th5<?php echo $NumWindow; ?>">Contrato</th>
					<th id="th6<?php echo $NumWindow; ?>">Llamar</th>
				</tr> 
					<?php 
					$SQL="SELECT f.Nombre_TPC, b.Codigo_TRN, e.Nombre_TPR, b.Fecha_TRN, a.ID_TER, a.Nombre_TER, TIMESTAMPDIFF(MINUTE, b.Fecha_TRN, NOW()), c.Nombre_EPS, d.Nombre_ARE,  Preferencial_TPC FROM czterceros a, gxturnos b, gxeps c, gxareas d, gxturnosprocesos e, gxtipopcte f WHERE f.Codigo_TPC=b.Codigo_TPC and e.Codigo_TPR=b.Codigo_TPR and d.Codigo_ARE=b.Codigo_ARE and a.Codigo_TER = b.Codigo_TER AND b.Codigo_EPS = c.Codigo_EPS AND b.Estado_TRN = '1' AND d.Laboratorio_ARE='1' and Call_TRN='0' ORDER BY Preferencial_TPC desc, b.Fecha_TRN";
					$resulthc = mysqli_query($conexion, $SQL);
					$contarow=0;
					while($rowhc = mysqli_fetch_array($resulthc)) 
						{
							$pref="";
							if ($rowhc[9]=="1") {
								$pref= ' <span id="bliked'.$NumWindow.'" class="glyphicon glyphicon-alert " aria-hidden="true" style="transition:0.4s;" ></span> ';
							}
							$contarow=$contarow+1;
							echo '
					  <tr ><td ><input type="hidden" name="hdn_pretri'.$contarow.$NumWindow.'" id="hdn_pretri'.$contarow.$NumWindow.'" value="'.$rowhc[0].'"/>'.$pref.$rowhc[0].'</td><td align="center">'.$rowhc[1].'</td><td>'.$rowhc[2].'</td><td>'.$rowhc[3].'</td><td >'.$rowhc[4].'</td><td >'.$rowhc[5].'</td><td align="center">'.$rowhc[6].'</td><td align="center">'.$rowhc[7].'</td><td align="center"> <a href="javascript:Atender'.$NumWindow.'(\''.$rowhc[1].'\', \''.$rowhc[4].'\');" role="button" class="btn btn-default btn-sm" title="Llamar paciente '.$rowhc[5].'"> <span class="glyphicon glyphicon-check" aria-hidden="true"></span> </a></td></tr>
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
/*	echo "var myTimer".$NumWindow." =setInterval(function(){ RefreshTriage".$NumWindow."(); }, 3600);"; */
}

if  ((!(isset($_GET["modulo"]))) && ($Contamodulos==1)) {
	echo "$('#grpmodulo".$NumWindow."').hide();";
}
?>

function RefreshTurno<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/turnos_lab.php', '<?php echo $NumWindow; ?>', '&modulo=<?php echo $Elmodulo; ?>&contamodulos=<?php echo $Contamodulos; ?>');
}

function Atender<?php echo $NumWindow; ?>(NumPre, Pac) {
	CallTurno(NumPre, '<?php echo $Elmodulo; ?>', Pac);
	RefreshTurno<?php echo $NumWindow; ?>()
}

function selmodulo<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/turnos_lab.php', '<?php echo $NumWindow; ?>', '&modulo='+document.getElementById('cmb_modulo<?php echo $NumWindow; ?>').value+'&contamodulos='+document.getElementById('hdn_contamodulos<?php echo $NumWindow; ?>').value);	
}

function ChngMod<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/turnos_lab.php', '<?php echo $NumWindow; ?>', '');	
}

function blinktext<?php echo $NumWindow; ?>() {
  var f = document.getElementById('bliked<?php echo $NumWindow; ?>');
  setInterval(function() {
    f.style.opacity = (f.style.opacity == 1 ? 0.1 : 1);
  }, 1000);
}
    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

blinktext<?php echo $NumWindow; ?>();

</script>
