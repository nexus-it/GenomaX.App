<?php
	
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	$contarow=0;
	$elanyo = date("Y");
	$elmes = date("m");	
	if (isset($_GET["elmes"])) { $elmes=$_GET["elmes"];	}
	if (isset($_GET["elanyo"])) { $elanyo=$_GET["elanyo"];	}

	$varmant="";
	$varyant="";
	$varmsig="";
	$varysig="";
	if ($elmes=="1") {$varmant='12';}
	else {$varmant=$elmes-1;}
	if ($elmes=="1") {$varyant=$elanyo-1;}
	else {$varyant=$elanyo;}
	if ($elmes=="12") {$varmsig='1';}
	else {$varmsig=$elmes+1;}
	if ($elmes=="12") {$varysig=$elanyo+1;}
	else {$varysig=$elanyo;}
?>
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  action="" >

<label class="label label-success"> Configuración de Festivos</label>
<div class="row well well-sm">

	<div class="col-sm-1">
		<button class="btn btn-success btn-lg btn-block" onclick="javascript:LoadMonth<?php echo $NumWindow; ?>('<?php echo $varmant; ?>', '<?php echo $varyant; ?>');"  title="Mes Anterior" type="button" > <span class="glyphicon glyphicon-triangle-left" aria-hidden="true"></span> </button> 
	</div>
	<div class="col-sm-10 center-block" align="center">
		<p align="center">
			<h4>
		MES: <strong> <input name="hdn_mes<?php echo $NumWindow; ?>" type="hidden" id="hdn_mes<?php echo $NumWindow; ?>" value="<?php echo $elmes; ?>" />
    <?php
  if ($elmes=="01") echo "ENERO";
  if ($elmes=="02") echo "FEBRERO";
  if ($elmes=="03") echo "MARZO";
  if ($elmes=="04") echo "ABRIL";
  if ($elmes=="05") echo "MAYO";
  if ($elmes=="06") echo "JUNIO";
  if ($elmes=="07") echo "JULIO";
  if ($elmes=="08") echo "AGOSTO";
  if ($elmes=="09") echo "SEPTIEMBRE";
  if ($elmes=="10") echo "OCTUBRE";
  if ($elmes=="11") echo "NOVIEMBRE";
  if ($elmes=="12") echo "DICIEMBRE";
  ?></strong> - A&Ntilde;O: 
    <strong> <input name="hdn_anyo<?php echo $NumWindow; ?>" type="hidden" id="hdn_anyo<?php echo $NumWindow; ?>" value="<?php echo $elanyo; ?>" /> <?php echo $elanyo; ?></strong>
			</h4>
		</p>
	</div>
	<div class="col-sm-1">
		<button class="btn btn-success btn-lg btn-block" onclick="javascript:LoadMonth<?php echo $NumWindow; ?>('<?php echo $varmsig; ?>', '<?php echo $varysig; ?>');" title="Siguiente Mes" type="button" > <span class="glyphicon glyphicon-triangle-right" aria-hidden="true"></span> </button> 
	</div>

	<div class="col-sm-12" align="center" >
	 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive "  >
	   <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetCitas<?php echo $NumWindow; ?>" >
	  <tbody id="tbDetalle<?php echo $NumWindow; ?>">
	  <tr>
	  <?php
	  	$Weekday="";
		$Colorday="";
		$NumDia=0;
		while (UltimoDia($elanyo, $elmes)> $NumDia) {
		$NumDia++;
		$Colorday="";
		$SQL="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$elanyo."-".$elmes."-".$NumDia."'";
		$result = mysqli_query($conexion, $SQL);
		if($row=mysqli_fetch_array($result)) {
			$Colorday='class="festivo"';
		} else {
			$Colorday="";
		}
		mysqli_free_result($result); 
		if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==1) $Weekday= "Lu";
		if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==2) $Weekday= "Ma";
		if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==3) $Weekday= "Mi";
		if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==4) $Weekday= "Ju";
		if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==5) $Weekday= "Vi";
		if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==6) $Weekday= "Sa";
		if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==0) 
		{
			$Weekday= "Do";
			$Colorday='class="festivo"';
		}
		echo '<th align="center" valign="bottom" '.$Colorday.'>'.$Weekday.'</th>';
		
		}
		?>
	  </tr>
	  <tr>
	  <?php
	  	$Weekday="";
		$Colorday="";
		$NumDia=0;
		while (UltimoDia($elanyo, $elmes)> $NumDia) {
			$NumDia++;
			$SQL="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$elanyo."-".$elmes."-".$NumDia."'";
			$result = mysqli_query($conexion, $SQL);
			if($row=mysqli_fetch_array($result)) {
				$Colorday='class="festivo2"';
			}
			else
			{
				$Colorday="";
			}
			mysqli_free_result($result); 
			if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==0) 
			{
				$Colorday='class="festivo2"';
			}
		?>
		    <td align="center" valign="middle" <?php echo $Colorday; ?>><?php echo $NumDia; ?></td>
		<?php
			
		}
		?>
	  </tr>
	  <tr>
	  <?php
	  	$Weekday="";
		$Colorday="";
		$NumDia=0;
		while (UltimoDia($elanyo, $elmes)> $NumDia) {
			$NumDia++;
		?>
		    <td align="center" valign="top"><input name="chk_dia<?php echo $NumDia.$NumWindow; ?>" type="checkbox" id="chk_dia<?php echo $NumDia.$NumWindow; ?>"  
		<?php
			$SQL="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$elanyo."-".$elmes."-".$NumDia."'";
			$result = mysqli_query($conexion, $SQL);
			if($row=mysqli_fetch_array($result)) {
				echo 'value="1" checked="CHECKED" ';
			}
			else
			{
				if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==0) {
					echo 'value="1" checked="CHECKED" ';
				} else {
					echo 'value="0" ';
				}
			}
			mysqli_free_result($result); 
			?> onclick="javascript: ChangeValue<?php echo $NumWindow; ?>(this);"/></td>
		<?php
			
		}
		?>
	  		</tr>
	  	</tbody>
		</table>
	  </div>
	  <div class="alert alert-warning" role="alert">
	   <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 
	   Los días marcados serán tomados por el sistema como festivos.
	  </div>
	</div>
</div>


</form>
<script >
function LoadMonth<?php echo $NumWindow; ?>(Month, Year) {
	AbrirForm('application/forms/festivos.php', '<?php echo $NumWindow; ?>', '&elmes='+Month+'&elanyo='+Year);
}
function ChangeValue<?php echo $NumWindow; ?>(objeto) 
{
	if (objeto.value=="1") {
		objeto.value="0";
	} else {
		objeto.value="1";
	}
}
</script>