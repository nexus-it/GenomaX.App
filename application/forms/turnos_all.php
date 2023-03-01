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
	$ContaSedes=0;
	if  (!(isset($_GET["sede"]))) {	
	?>
		<div class="col-md-offset-2 col-md-8" id="grpsede<?php echo $NumWindow; ?>" name="grpsede<?php echo $NumWindow; ?>">
	<div class="form-group">
		<label for="cmb_sede<?php echo $NumWindow; ?>">Especifique Sede</label>
		<select name="cmb_sede<?php echo $NumWindow; ?>" id="cmb_sede<?php echo $NumWindow; ?>">
	<?php 
		$SQL="Select Codigo_SDE, Nombre_SDE From czsedes Where Estado_SDE='1' Order By Codigo_SDE;";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) 
		{
			$ContaSedes++;
	 	?>
	    	<option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
	    <?php
	    	$LaSede=$row[0];
	    	$NombreSede=$row[1];
		}
		mysqli_free_result($result); 
 	?>
 		</select>
	</div>
		<?php echo '<a href="javascript:selSede'.$NumWindow.'();" class="btn btn-success btn-sm btn-block" role="button" > Continuar </a>'; ?>
		</div>
		
	<?php 
	} else {
		$LaSede=$_GET["sede"];
	    $ContaSedes=$_GET["contasedes"];
	}
?>
<input type="hidden" name="hdn_sede<?php echo $NumWindow; ?>" id="hdn_sede<?php echo $NumWindow; ?>" value="<?php echo $LaSede; ?>"/>
<input type="hidden" name="hdn_contasedes<?php echo $NumWindow; ?>" id="hdn_contasedes<?php echo $NumWindow; ?>" value="<?php echo $ContaSedes; ?>"/>
<?php
	if  (((!(isset($_GET["sede"]))) && ($ContaSedes==1))||(isset($_GET["sede"]))) {
		$SQL="Select Codigo_SDE, Nombre_SDE From czsedes Where Estado_SDE='1' and Codigo_SDE='".$LaSede."';";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) 
		{
	    	$NombreSede=$row[1];
		}
		mysqli_free_result($result); 
		$ChngSde='<a href="javascript:ChngSde'.$NumWindow.'();" role="button" class="btn btn-default btn-xs" title="Cambiar Sede"> <span class="glyphicon glyphicon-retweet" aria-hidden="true"></span> </a>';
	?>


		<div class="panel panel-default ">
			<label class="label label-default"> SEDE: <?php echo $NombreSede.' '; if ($ContaSedes>1) { echo $ChngSde; } ?></label>
		  <div class="panel-body">

	<div class="col-md-2">
<div class="form-group">
	<label for="txt_idpaciente<?php echo $NumWindow; ?>" title="No utilice puntos ni comas">Identificación</label>
	<div class="input-group">		
		<input name="txt_idpaciente<?php echo $NumWindow; ?>" id="txt_idpaciente<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarPte<?php echo $NumWindow; ?>(event);" style="font-size:16px; font-weight: bold; color:#0E5012; "  onblur="HCPteOnBlur<?php echo $NumWindow; ?>()"/>
		<span class="input-group-btn">			
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Paciente" onclick="CargarSearch('Paciente', 'txt_idpaciente<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>			
		</span>
	</div>
</div>
	</div>	
	<div class="col-md-2">
<div class="form-group">
	<label for="txt_nombre1<?php echo $NumWindow; ?>">Nombre 1</label>
	<input name="txt_nombre1<?php echo $NumWindow; ?>" type="text"   id="txt_nombre1<?php echo $NumWindow; ?>"  style="font-size:15px; font-weight: bold; color:#0E5012; "/>
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
	<label for="txt_nombre2<?php echo $NumWindow; ?>">Nombre 2</label>
	<input name="txt_nombre2<?php echo $NumWindow; ?>" type="text"   id="txt_nombre2<?php echo $NumWindow; ?>"  style="font-size:15px; font-weight: bold; color:#0E5012; "/>
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
	<label for="txt_apellido1<?php echo $NumWindow; ?>">Apellido 1</label>
	<input name="txt_apellido1<?php echo $NumWindow; ?>" type="text"   id="txt_apellido1<?php echo $NumWindow; ?>"  style="font-size:15px; font-weight: bold; color:#0E5012; "/>
</div>
	</div>
	<div class="col-md-2">
<div class="form-group">
	<label for="txt_apellido2<?php echo $NumWindow; ?>">Apellido 2</label>
	<input name="txt_apellido2<?php echo $NumWindow; ?>" type="text"   id="txt_apellido2<?php echo $NumWindow; ?>"  style="font-size:15px; font-weight: bold; color:#0E5012; "/>
</div>
	</div>	
	<div class="col-md-2">
<div class="form-group">
	<label for="cmb_entidad<?php echo $NumWindow; ?>">Entidad</label>
	 <select name="cmb_entidad<?php echo $NumWindow; ?>" id="cmb_entidad<?php echo $NumWindow; ?>">	 	
	<?php 
	$SQL="Select Codigo_EPS, Nombre_EPS From gxeps Where Estado_EPS='1' Order By Codigo_EPS;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{
 	?>
    	<option value="<?php echo $row[0]; ?>" > <?php echo $row[1]; ?> </option>
    <?php
	}
	mysqli_free_result($result); 
 	?>
	 </select>
</div>
	</div>

	<div class="col-md-4">
<div class="form-group">
	<label for="cmb_area<?php echo $NumWindow; ?>">Área</label>
	 <select name="cmb_area<?php echo $NumWindow; ?>" id="cmb_area<?php echo $NumWindow; ?>" style="font-size:15px; font-weight: bold; color:#0E5012; " onchange>
	 	<option value="X" > Seleccione... </option>
	<?php 
	$SQL="Select Codigo_ARE, Nombre_ARE From gxareas Where Estado_ARE='1' and Turnos_ARE='1' and Codigo_SDE='".$LaSede."' Order By Nombre_ARE;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{
 	?>
    	<option value="<?php echo $row[0]; ?>" > <?php echo $row[1]; ?> </option>
    <?php
	}
	mysqli_free_result($result); 
 	?>
	 </select>
</div>
	</div>

	<div class="col-md-4">
<div class="form-group">
	<label for="cmb_proceso<?php echo $NumWindow; ?>">Proceso</label>
	 <select name="cmb_proceso<?php echo $NumWindow; ?>" id="cmb_proceso<?php echo $NumWindow; ?>" style="font-size:15px; font-weight: bold; color:#0E5012; ">	 	
	<?php 
	$SQL="Select Codigo_TPR, Nombre_TPR From gxturnosprocesos Where Codigo_ARE in (Select Codigo_ARE From gxareas Where Estado_ARE='1' and Turnos_ARE='1' and Codigo_SDE='".$LaSede."' Order By Nombre_ARE limit 1) Order By 2;";
	echo $SQL;
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{
 	?>
    	<option value="<?php echo $row[0]; ?>" > <?php echo $row[1]; ?> </option>
    <?php
	}
	mysqli_free_result($result); 
 	?>
	 </select>
</div>
	</div>

	<div class="col-md-4">
<div class="form-group">
	<label for="cmb_tipopcte<?php echo $NumWindow; ?>">Tipo Pcte.</label>
	 <select name="cmb_tipopcte<?php echo $NumWindow; ?>" id="cmb_tipopcte<?php echo $NumWindow; ?>" style="font-size:15px; font-weight: bold; color:#0E5012; ">	 	
		<?php 
	$SQL="Select Codigo_TPC, Nombre_TPC, Preferencial_TPC From gxtipopcte Order By Preferencial_TPC;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{
 	?>
    	<option value="<?php echo $row[0]; ?>" > <?php echo $row[1]; ?> </option>
    <?php
	}
	mysqli_free_result($result); 
 	?>
     </select>
</div>
	</div>

		  </div>
		  <?php echo '<a href="javascript:addPreTurno'.$NumWindow.'();" class="btn btn-success btn-sm btn-block" role="button" > <i class="fas fa-plus"></i> AGREGAR </a>'; ?>
		</div>

	</div>

	<div class="row">
	<div class="table-responsive">
		<table class="table table-condensed table-striped table-hover tblDetalle">
		    <tbody id="tbDetalle<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th1<?php echo $NumWindow; ?>">Area</th> 
					<th id="th1<?php echo $NumWindow; ?>">Proceso</th> 
					<th id="th1<?php echo $NumWindow; ?>">Documento</th> 
					<th id="th2<?php echo $NumWindow; ?>">Nombre Paciente</th> 
				    <th id="th2<?php echo $NumWindow; ?>">Entidad</th> 
				    <th id="th2<?php echo $NumWindow; ?>">Fecha</th> 
				    <th id="th2<?php echo $NumWindow; ?>">Tipo Pcte.</th> 
				</tr> 
					<?php 
					$SQL="SELECT d.Nombre_ARE, e.Nombre_TPR, a.ID_TER, a.Nombre_TER, c.Nombre_EPS, b.Fecha_TRN, f.Nombre_TPC, Preferencial_TPC FROM czterceros a, gxturnos b, gxeps c, gxareas d, gxturnosprocesos e, gxtipopcte f WHERE f.Codigo_TPC=b.Codigo_TPC and e.Codigo_TPR=b.Codigo_TPR and d.Codigo_ARE=b.Codigo_ARE and a.Codigo_TER = b.Codigo_TER AND b.Codigo_EPS = c.Codigo_EPS AND b.Estado_TRN = '1' AND b.Codigo_SDE='".$LaSede."' ORDER BY 6 desc limit 200";
					$resulthc = mysqli_query($conexion, $SQL);
					$contarow=0;
					while($rowhc = mysqli_fetch_array($resulthc)) 
						{
							$contarow=$contarow+1;
							$negrita1="";
							$negrita2="";
							if ($rowhc[7]=="1") {
								$negrita1='<strong>';
								$negrita2='</strong>';
							}
							echo '
					  <tr  ><td >'.$negrita1.$rowhc[0].$negrita2.'</td><td >'.$negrita1.$rowhc[1].$negrita2.'</td><td>'.$negrita1.$rowhc[2].$negrita2.'</td><td >'.$negrita1.$rowhc[3].$negrita2.'</td><td >'.$negrita1.$rowhc[4].$negrita2.'</td><td align="center">'.$negrita1.$rowhc[5].$negrita2.'</td><td >'.$negrita1.$rowhc[6].$negrita2.'</td></tr>
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
if  ((!(isset($_GET["sede"]))) && ($ContaSedes==1)) {
	echo "$('#grpsede".$NumWindow."').hide();";
}

if (isset($_GET["IdPte"])) {
	$SQL="Select * from gxpacientes a, czterceros b where a.Codigo_TER=b.Codigo_TER and ID_TER='".$_GET["IdPte"]."'";
	$result = mysqli_query($conexion, $SQL);
	echo "
		document.frm_form".$NumWindow.".txt_idpaciente".$NumWindow.".value='".$_GET["IdPte"]."';";
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_nombre1".$NumWindow.".value='".$row["Nombre1_PAC"]."';
		document.frm_form".$NumWindow.".txt_nombre2".$NumWindow.".value='".$row["Nombre2_PAC"]."';
		document.frm_form".$NumWindow.".txt_apellido1".$NumWindow.".value='".$row["Apellido1_PAC"]."';
		document.frm_form".$NumWindow.".txt_apellido2".$NumWindow.".value='".$row["Apellido2_PAC"]."';
		document.frm_form".$NumWindow.".cmb_entidad".$NumWindow.".value='".$row["Codigo_EPS"]."';
	";
	}
	mysqli_free_result($result);
}
?>

function BuscarPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idpaciente<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/turnos_all.php', '<?php echo $NumWindow; ?>', '&sede=<?php echo $LaSede; ?>&contasedes=<?php echo $ContaSedes; ?>');
	} else {
		AbrirForm('application/forms/turnos_all.php', '<?php echo $NumWindow; ?>', '&IdPte='+document.getElementById('txt_idpaciente<?php echo $NumWindow; ?>').value+'&sede=<?php echo $LaSede; ?>&contasedes=<?php echo $ContaSedes; ?>');
	}  
  }
}

function HCPteOnBlur<?php echo $NumWindow; ?>() {
  	if (document.getElementById('txt_idpaciente<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/turnos_all.php', '<?php echo $NumWindow; ?>', '&sede=<?php echo $LaSede; ?>&contasedes=<?php echo $ContaSedes; ?>');
	} else {
		AbrirForm('application/forms/turnos_all.php', '<?php echo $NumWindow; ?>', '&IdPte='+document.getElementById('txt_idpaciente<?php echo $NumWindow; ?>').value+'&sede=<?php echo $LaSede; ?>&contasedes=<?php echo $ContaSedes; ?>');
	}  
}

function addPreTurno<?php echo $NumWindow; ?>() {
	xError="";
	Ventana='<?php echo $NumWindow; ?>';
	if (document.getElementById('txt_apellido1'+Ventana).value=="") {
		xError="Digite el apellido del paciente.";}
	if (document.getElementById('txt_nombre1'+Ventana).value=="") {
		xError="Digite el nombre del paciente.";}
	if (document.getElementById('txt_idpaciente'+Ventana).value=="") {
		xError="Digite el código de identificacion del paciente.";}
	//Ejecucion de las intrucciones para guardar los registros
	ID=document.getElementById('txt_idpaciente'+Ventana).value;
	Nombre1=document.getElementById('txt_nombre1'+Ventana).value;
	Nombre2=document.getElementById('txt_nombre2'+Ventana).value;
	Eps=document.getElementById('cmb_entidad'+Ventana).value;
	Apellido1=document.getElementById('txt_apellido1'+Ventana).value;
	Apellido2=document.getElementById('txt_apellido2'+Ventana).value;
	Sede=document.getElementById('hdn_sede'+Ventana).value;
	ContaSedes=document.getElementById('hdn_contasedes'+Ventana).value;
	if (xError=="") {
		addPreTurno('<?php echo $NumWindow; ?>', Sede, ContaSedes);
	} else {
		MsgBox1("Error", xError);
	}
}

function selSede<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/turnos_all.php', '<?php echo $NumWindow; ?>', '&sede='+document.getElementById('cmb_sede<?php echo $NumWindow; ?>').value+'&contasedes='+document.getElementById('hdn_contasedes<?php echo $NumWindow; ?>').value);	
}

function ChngSde<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/turnos_all.php', '<?php echo $NumWindow; ?>', '');	
}

<?php 
$SQL="Select Codigo_ARE From gxareas Where Estado_ARE='1' and Turnos_ARE='1' and Codigo_SDE='".$LaSede."' Order By Nombre_ARE;";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) 
{
?>
	var lst_<?php echo $row[0]; ?> = [
	<?php 
	$cadenax="";
	$SQL="Select Codigo_TPR, Nombre_TPR From gxturnosprocesos Where Codigo_ARE ='".$row[0]."' Order By 2;";
	$resultx = mysqli_query($conexion, $SQL);
	while($rowx = mysqli_fetch_array($resultx)) 
	{ 
		$cadenax=$cadenax.'{display: "'.$rowx[1].'", value: "'.$rowx[0].'" },';
	}
	mysqli_free_result($resultx); 
	$cadenax= substr($cadenax, 0, -1);
	echo $cadenax;
	?>
    ];
<?php
}
mysqli_free_result($result); 
?>

	// Aqui creamos verificamos cual opciones apareceran dependiendo de la seleccion@superservicios

	$("#cmb_area<?php echo $NumWindow; ?>").change(function() {
		    var parent = $(this).val();
		    switch(parent){
		    	<?php 
		    	$SQL="Select Codigo_ARE From gxareas Where Estado_ARE='1' and Turnos_ARE='1' and Codigo_SDE='".$LaSede."' Order By Nombre_ARE;";
				$result = mysqli_query($conexion, $SQL);
				while($row = mysqli_fetch_array($result)) 
				{
			 	?>
			    	case '<?php echo $row[0]; ?>':
					    list<?php echo $NumWindow; ?>(lst_<?php echo $row[0]; ?>);
					break;
			    <?php
				}
				mysqli_free_result($result); 
		    	?>
		    }
		});
//function to populate child select box
function list<?php echo $NumWindow; ?>(array_list)
{
    $("#cmb_proceso<?php echo $NumWindow; ?>").html(""); //reset child options
    $(array_list).each(function (i) { //populate child options
        $("#cmb_proceso<?php echo $NumWindow; ?>").append("<option value=\""+array_list[i].value+"\">"+array_list[i].display+"</option>");
    });
}
    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

</script>
