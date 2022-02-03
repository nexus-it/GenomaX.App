<?php

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal col-md-12" id="frm_form<?php echo $NumWindow; ?>"  enctype="multipart/form-data" onreset="KlResetea<?php echo $NumWindow; ?>();">
	  		<div class="row well well-sm">
	  		<div class="col-md-12">
	  		<div class="row">

	  	<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_prefijo<?php echo $NumWindow; ?>">Prefijo</label>
		<input  name="txt_prefijo<?php echo $NumWindow; ?>" id="txt_prefijo<?php echo $NumWindow; ?>" type="text" required  value="<?php echo $_SESSION['Kl_Prefijo']; ?>" class="form-control" />
	</div>
	<input name="hdn_tercero<?php echo $NumWindow; ?>" type="hidden" id="hdn_tercero<?php echo $NumWindow; ?>" value="" />
		</div>
		<?php
			$xPoliza="";
			if (isset($_GET["Poliza"])) {
				$xPoliza=$_GET["Poliza"];
			}
		?>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_poliza<?php echo $NumWindow; ?>">Poliza</label>
		<div class="input-group">
			<input  name="txt_poliza<?php echo $NumWindow; ?>" id="txt_poliza<?php echo $NumWindow; ?>" type="text" required  value="<?php echo $xPoliza; ?>" onchange="BuscarPoliza<?php echo $NumWindow; ?>();" onkeypress="BuscarPolizaX<?php echo $NumWindow; ?>(event);" class="form-control" />
			<span class="input-group-btn"> 		
	 		  <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-bs-toggle="modal" data-bs-target="#GnmX_Search" data-whatever="Poliza" onclick="javascript:CargarSearch('KlPoliza', 'txt_poliza<?php echo $NumWindow; ?>', 'Estado_EMI<>*A*');"><i class="fas fa-search"></i></button>
			</span>
		</div>
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_femision<?php echo $NumWindow; ?>">Fecha Emision</label>
		<input  name="txt_femision<?php echo $NumWindow; ?>" id="txt_femision<?php echo $NumWindow; ?>" type="date" required class="form-control" />
	</div>

		</div>
		<div class="col-md-2 col-md-offset-4">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_cotizacion<?php echo $NumWindow; ?>">Cotizacion No</label>
		<input  name="txt_cotizacion<?php echo $NumWindow; ?>" id="txt_cotizacion<?php echo $NumWindow; ?>" type="text" required  disabled="disabled" value="000000" style="font-size:15px; text-align:right;font-weight: bold;" class="form-control" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_voucher<?php echo $NumWindow; ?>">No Voucher</label>
		<input  name="txt_voucher<?php echo $NumWindow; ?>" id="txt_voucher<?php echo $NumWindow; ?>" type="text" required disabled="disabled" value="XXXXX-XXXXX" class="form-control" />
	</div>

		</div>
		<div class="col-md-2 offset-md-1">
	
	<div class="form-group">
		<label for="cmb_estado<?php echo $NumWindow; ?>">Estado</label>
		  <select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>" class="form-select">
		 	<option value="E" >Activa</option>
		 	<option value="S" >StandBy</option>
		 	<option value="A" >Anulada</option>
		  </select>
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_nombres<?php echo $NumWindow; ?>">Nombres</label>
		<input  name="txt_nombres<?php echo $NumWindow; ?>" id="txt_nombres<?php echo $NumWindow; ?>" type="text" required class="form-control" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_apellidos<?php echo $NumWindow; ?>">Apellidos</label>
		<input  name="txt_apellidos<?php echo $NumWindow; ?>" id="txt_apellidos<?php echo $NumWindow; ?>" type="text" class="form-control" required/>
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_pasaporte<?php echo $NumWindow; ?>">Pasaporte</label>
		<input  name="txt_pasaporte<?php echo $NumWindow; ?>" id="txt_pasaporte<?php echo $NumWindow; ?>" type="text" required class="form-control" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_nacionalidad<?php echo $NumWindow; ?>">Nacionalidad</label>
		<input  name="txt_nacionalidad<?php echo $NumWindow; ?>" id="txt_nacionalidad<?php echo $NumWindow; ?>" type="text" required class="form-control" />
	</div>

		</div>
		<div class="col-md-2">
	
	<div class="form-group">
		<label for="cmb_procedencia<?php echo $NumWindow; ?>">Procedencia</label>
		  <select name="cmb_procedencia<?php echo $NumWindow; ?>" id="cmb_procedencia<?php echo $NumWindow; ?>" class="form-select">
		  <?php 
	  		$SQL="Select Codigo_dst, Nombre_dst from kldestinos  where  Estado_dst='1' Order by 2";
	  		$resultd = mysqli_query($conexion, $SQL);
			while ($rowd = mysqli_fetch_array($resultd)) {
				echo '<option value="'.$rowd[0].'" >'.$rowd[1].'</option>
				';
			}
			mysqli_free_result($resultd);
		  ?>
		  </select>
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_correo<?php echo $NumWindow; ?>">Correo</label>
		<input  name="txt_correo<?php echo $NumWindow; ?>" id="txt_correo<?php echo $NumWindow; ?>" type="text" required class="form-control" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_direccion<?php echo $NumWindow; ?>">Direccion</label>
		<input  name="txt_direccion<?php echo $NumWindow; ?>" id="txt_direccion<?php echo $NumWindow; ?>" type="text" required class="form-control" />
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_telefono<?php echo $NumWindow; ?>">Telefono</label>
		<input  name="txt_telefono<?php echo $NumWindow; ?>" id="txt_telefono<?php echo $NumWindow; ?>" type="text" required class="form-control" />
	</div>

		</div>
		<div class="col-md-5">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_contacto<?php echo $NumWindow; ?>">Contacto caso de emergencia</label>
		<input  name="txt_contacto<?php echo $NumWindow; ?>" id="txt_contacto<?php echo $NumWindow; ?>" type="text" required class="form-control" />
	</div>

		</div>
		
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_fnac<?php echo $NumWindow; ?>">F. Nac.</label>
		<input  name="txt_fnac<?php echo $NumWindow; ?>" id="txt_fnac<?php echo $NumWindow; ?>" type="date" required  class="form-control"/>
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_edad<?php echo $NumWindow; ?>">Edad</label>
			<input name="txt_edad<?php echo $NumWindow; ?>" id="txt_edad<?php echo $NumWindow; ?>" type="text" disabled class="form-control" />
	</div>

		</div>
		<div class="col-md-3">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="cmb_agencia<?php echo $NumWindow; ?>">Agencia</label>
		  <select name="cmb_agencia<?php echo $NumWindow; ?>" id="cmb_agencia<?php echo $NumWindow; ?>" class="form-select">
		  <?php 
	  		$SQL="Select Codigo_age, Nombre_age from klagencias where Estado_age='1' Order by 2";
	  		$resultd = mysqli_query($conexion, $SQL);
			while ($rowd = mysqli_fetch_array($resultd)) {
				echo '<option value="'.$rowd[0].'" >'.$rowd[1].'</option>
				';
			}
			mysqli_free_result($resultd);
		  ?>
		  </select>
	</div>

		</div>
		<div class="col-md-3">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="cmb_plan<?php echo $NumWindow; ?>">Plan</label>
		  <select name="cmb_plan<?php echo $NumWindow; ?>" id="cmb_plan<?php echo $NumWindow; ?>" onchange="selecplan<?php echo $NumWindow; ?>();" class="form-select">
		    <option value="0" >-- Seleccione --</option>
		  <?php
		  $xPlan="";
		  if (isset($_GET["Poliza"])) {
		  	$SQL=" Select Codigo_PLA From klemisiones a, klcotizaciones b Where a.Codigo_CTZ=b.Codigo_CTZ and Codigo_EMI='".$_GET["Poliza"]."'";
		  	$result = mysqli_query($conexion, $SQL);
			if ($row = mysqli_fetch_array($result)) {
				$xPlan=$row[0];
			}
			mysqli_free_result($result);
		  }

		  $SQL="Select Codigo_PLA, Nombre_PLA From klplanes Order By Codigo_PLA";
			$result = mysqli_query($conexion, $SQL);
			while ($row = mysqli_fetch_array($result)) {
			?>
		    <option value="<?php echo $row[0]; ?>" <?php if ($row[0]==$xPlan) { echo 'selected="selected"'; } ?> ><?php echo $row[1]; ?></option>
		  	<?php
			 }
			mysqli_free_result($result);
			?>
		  </select>
	</div>

		</div>
		<div class="col-md-3">
	
	<div class="form-group" id="grp_txt_hora<?php echo $NumWindow; ?>">
		<label for="cmb_modalidad<?php echo $NumWindow; ?>">Modalidad</label>
		  <select name="cmb_modalidad<?php echo $NumWindow; ?>" id="cmb_modalidad<?php echo $NumWindow; ?>" onchange="selecmod<?php echo $NumWindow; ?>();" class="form-select">
		  <?php 
		  	if ($xPlan!="") {
		  		$SQL="Select Sum(Individual_PLA), Sum(Pareja_PLA), Sum(Hijos_PLA) from klplanesprecios where Codigo_PLA='".$xPlan."'";
		  		$resultm = mysqli_query($conexion, $SQL);
				while ($rowm = mysqli_fetch_array($resultm)) {
					if($rowm[0]!="0"){
				?>
			    <option value="Individual_PLA" >Individual</option>
			  	<?php
			  		}
			  		if($rowm[1]!="0"){
				?>
			    <option value="Pareja_PLA" >Pareja</option>
			  	<?php
			  		}
			  		if($rowm[2]!="0"){
				?>
			    <option value="Hijos_PLA" >Familia</option>
			  	<?php
			  		}
				}
				mysqli_free_result($resultm);
		  	} else {
		  ?>
		    <option value="X" >-- Seleccione Plan --</option>
		  <?php
		    }
		  ?>
		  </select>
	</div>

		</div>
		<div class="col-md-3">
	
	<div class="form-group">
		<label for="cmb_destino<?php echo $NumWindow; ?>">Destino</label>
		  <select name="cmb_destino<?php echo $NumWindow; ?>" id="cmb_destino<?php echo $NumWindow; ?>" class="form-select">
		  <?php 
		  	if ($xPlan!="") {
		  		$SQL="Select a.Codigo_dst, Nombre_dst from klplanesdestinos a, kldestinos b where a.Codigo_DST=b.Codigo_dst and Codigo_PLA='".$xPlan."' and Estado_dst='1' Order by 2";
		  		$resultd = mysqli_query($conexion, $SQL);
				while ($rowd = mysqli_fetch_array($resultd)) {
					echo '<option value="'.$rowd[0].'" >'.$rowd[1].'</option>
					';
				}
				mysqli_free_result($resultd);
		    } else {
		  ?>
		    <option value="X" >-- Seleccione Plan --</option>
		  <?php
		    }
		  ?>
		  </select>
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_fini<?php echo $NumWindow; ?>">Fec. Ini</label>
		<input  name="txt_fini<?php echo $NumWindow; ?>" id="txt_fini<?php echo $NumWindow; ?>" type="date" required class="form-control" onkeyup="CalcularDias<?php echo $NumWindow; ?>();"/>
	</div>

		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
		<label for="txt_ffin<?php echo $NumWindow; ?>">Fec Fin</label>
		<input  name="txt_ffin<?php echo $NumWindow; ?>" id="txt_ffin<?php echo $NumWindow; ?>" type="date" required class="form-control" onkeyup="CalcularDias<?php echo $NumWindow; ?>();"/>
	</div>

		</div>
		<div class="col-md-1">
			<div class="form-group" id="grp_txt_idhc0<?php echo $NumWindow; ?>">
				<label for="txt_dias<?php echo $NumWindow; ?>">Días</label>
				<input style="font-size:15px;" name="txt_dias<?php echo $NumWindow; ?>" id="txt_dias<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="form-control" />
			</div>
		</div>
		
		</div>

		<!-- PAREJA -->
		<div id="div_pareja<?php echo $NumWindow; ?>" name="div_pareja<?php echo $NumWindow; ?>">
				<label class="label label-info"> Acompañante </label>
			<div class="col-md-12 alert alert-info">
			<div class="row">
				<div class="col-md-2">
		  			
		  			<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
						<label for="txt_parentesco1<?php echo $NumWindow; ?>">Parentesco </label>
						<input  name="txt_parentesco1<?php echo $NumWindow; ?>" id="txt_parentesco1<?php echo $NumWindow; ?>" type="text" class="form-control" />
					</div>

		  		</div>
		  		<div class="col-md-4">
		  			
		  			<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
						<label for="txt_nombre1<?php echo $NumWindow; ?>">Nombre Completo </label>
						<input  name="txt_nombre1<?php echo $NumWindow; ?>" id="txt_nombre1<?php echo $NumWindow; ?>" type="text" class="form-control" />
					</div>

		  		</div>
		  		<div class="col-md-2">
		  			
		  			<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
						<label for="txt_fecnac1<?php echo $NumWindow; ?>">Fec. Nac.</label>
						<input  name="txt_fecnac1<?php echo $NumWindow; ?>" id="txt_fecnac1<?php echo $NumWindow; ?>" type="date" onchange="CalcEdad<?php echo $NumWindow; ?>('txt_fecnac1<?php echo $NumWindow; ?>', 'hdn_edad1<?php echo $NumWindow; ?>');" class="form-control" />
						<input name="hdn_edad1<?php echo $NumWindow; ?>" type="hidden" id="hdn_edad1<?php echo $NumWindow; ?>" value="" />
					</div>

		  		</div>
		  		<div class="col-md-4">
		  			
		  			<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
						<label for="txt_pasaporte1<?php echo $NumWindow; ?>">Pasaporte </label>
						<input  name="txt_pasaporte1<?php echo $NumWindow; ?>" id="txt_pasaporte1<?php echo $NumWindow; ?>" type="text" class="form-control" />
					</div>

		  		</div>
		  		<input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="1" />
			</div>
			</div>
		</div>
		<!-- FIN PAREJA -->
		<!-- FAMILIA -->
		<div id="div_familia<?php echo $NumWindow; ?>" name="div_familia<?php echo $NumWindow; ?>">
					<label class="label label-info"> Acompañantes </label>
			<div class="col-md-12 alert alert-info">
			<div class="row">
				<div class="col-md-2">
		  			
		  			<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
						<label for="txt_parentesco<?php echo $NumWindow; ?>">Parentesco </label>
						<input  name="txt_parentesco<?php echo $NumWindow; ?>" id="txt_parentesco<?php echo $NumWindow; ?>" type="text" class="form-control" />
					</div>

		  		</div>
		  		<div class="col-md-4">
		  			
		  			<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
						<label for="txt_nombre<?php echo $NumWindow; ?>">Nombre Completo </label>
						<input  name="txt_nombre<?php echo $NumWindow; ?>" id="txt_nombre<?php echo $NumWindow; ?>" type="text" class="form-control" />
					</div>

		  		</div>
		  		<div class="col-md-2">
		  			
		  			<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
						<label for="txt_fecnac0<?php echo $NumWindow; ?>">Fec. Nac.</label>
						<input  name="txt_fecnac0<?php echo $NumWindow; ?>" id="txt_fecnac0<?php echo $NumWindow; ?>" type="text" class="datepickerX<?php echo $NumWindow; ?>"  onchange="CalcEdad<?php echo $NumWindow; ?>('txt_fecnac0<?php echo $NumWindow; ?>', 'hdn_edad0<?php echo $NumWindow; ?>');"/>
						<input name="hdn_edad0<?php echo $NumWindow; ?>" type="hidden" id="hdn_edad0<?php echo $NumWindow; ?>" value="" class="form-control" />
					</div>

		  		</div>
		  		<div class="col-md-4">
		  			
		  			<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
						<label for="txt_pasaporte0<?php echo $NumWindow; ?>">Pasaporte </label>
						<div class="input-group">
							<input  name="txt_pasaporte0<?php echo $NumWindow; ?>" id="txt_pasaporte0<?php echo $NumWindow; ?>" type="text" class="form-control" />
							 <span class="input-group-btn"> 		
					 		  <button class="btn btn-success" type="button"  onclick="javascript:Addpersona<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i></button>
							 </span>
						</div>
					</div>

		  		</div>
			  	<div class="col-md-12">

				 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
				<tbody id="tbcob<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th1<?php echo $NumWindow; ?>">Parentesco</th> 
					<th id="th2<?php echo $NumWindow; ?>">Nombre Completo</th> 
					<th id="th2<?php echo $NumWindow; ?>">Fec. Nacimiento</th> 
					<th id="th2<?php echo $NumWindow; ?>">Pasaporte</th> 
				    <th id="th2<?php echo $NumWindow; ?>"><i class="fas fa-eraser"></i> </th> 
				</tr> 
					 <?php 
					 if (isset($_GET["PLA"])) {	
					$SQL="Select nOMBRE_COB, DESCRIPCION_COB FROM klplanescobertura a, klplanes b WHERE a.Codigo_PLA=b.Codigo_PLA and  Nombre_PLA='".str_replace('_', ' ', $_GET["PLA"])."' Order by Orden_COB";
					$resulthc = mysqli_query($conexion, $SQL);
					$contarow=0;
					while($rowhc = mysqli_fetch_array($resulthc)) 
						{
							$contarow=$contarow+1;
							echo '
					  <tr id="tr'.$contarow.$NumWindow.'"><td align="left"><input name="hdn_cobertura'.$contarow.$NumWindow.'" type="hidden" id="hdn_cobertura'.$contarow.$NumWindow.'" value="'.$rowhc[0].'" />'.$rowhc[0].'</td><td align="right"><input name="hdn_descripcion'.$contarow.$NumWindow.'" type="hidden" id="hdn_descripcion'.$contarow.$NumWindow.'" value="'.$rowhc[1].'" />'.$rowhc[1].'</td><td>
					  <button onclick="EliminarFilaCOB'.$NumWindow.'(\''.$contarow.'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>
					  </td></tr>
					  ';
						}
					mysqli_free_result($resulthc); 
					 }
					 ?>
				</tbody>
				</table>
				 </div>

		  		</div>
		  		<input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="0" />
		  		<input name="hdn_controwx<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwx<?php echo $NumWindow; ?>" value="0" />
			</div>
			</div>

		</div>
			<!-- FIN FAMILIA -->
		<input name="hdn_mas18<?php echo $NumWindow; ?>" type="hidden" id="hdn_mas18<?php echo $NumWindow; ?>" value="0" />
		<input name="hdn_menos18<?php echo $NumWindow; ?>" type="hidden" id="hdn_menos18<?php echo $NumWindow; ?>" value="0" />


		</div>
 		</div>

<div id="divemitir<?php echo $NumWindow; ?>">
  	<div class="row well well-sm">
		<div class="col-md-12" id="dvbtnemi<?php echo $NumWindow; ?>">
		
		</div>
	</div>
</div>
	<!-- STANDBY -->
	<div id="div_standby<?php echo $NumWindow; ?>" name="div_standby<?php echo $NumWindow; ?>">
					<label class="label label-warning"> Histórico StandBy </label>
			<div class="col-md-12 alert alert-warning">
			<div class="row">
				<div class="col-md-2">
		  			
		  			<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
						<label for="txt_fechasby<?php echo $NumWindow; ?>">Fecha StandBy</label>
						<input  name="txt_fechasby<?php echo $NumWindow; ?>" id="txt_fechasby<?php echo $NumWindow; ?>" type="date" class="form-control" value="<?php echo date("Y-m-d"); ?>" />
					</div>

		  		</div>
		  		<div class="col-md-6">
		  			
		  			<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
						<label for="txt_obssby<?php echo $NumWindow; ?>">Observaciones</label>
						<input  name="txt_obssby<?php echo $NumWindow; ?>" id="txt_obssby<?php echo $NumWindow; ?>" type="text" class="form-control" />
					</div>

		  		</div>
		  		<div class="col-md-2">
		  			
		  			<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
						<label for="txt_vencesby<?php echo $NumWindow; ?>">Fecha Vence</label>
						<input  name="txt_vencesby<?php echo $NumWindow; ?>" id="txt_vencesby<?php echo $NumWindow; ?>" type="date" class="form-control" value="<?php echo date("Y-m-d", strtotime ('+1 year' , strtotime(date("Y-m-d")))); ?>"  />
					</div>

		  		</div>
		  		<div class="col-md-2">
		  			
		  			<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
						<label for="txt_valorsby<?php echo $NumWindow; ?>">Valor </label>
						<div class="input-group">
							<input  name="txt_valorsby<?php echo $NumWindow; ?>" id="txt_valorsby<?php echo $NumWindow; ?>" type="number" class="form-control" value="0" min="0" />
							 <span class="input-group-btn"> 		
					 		  <button class="btn btn-success" type="button"  onclick="javascript:AddStandBy<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i></button>
							 </span>
						</div>
					</div>

		  		</div>
			  	<div class="col-md-12">

				 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
				<tbody id="tbcobsby<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th1<?php echo $NumWindow; ?>">Fecha StandBy</th> 
					<th id="th2<?php echo $NumWindow; ?>">Observaciones</th> 
					<th id="th2<?php echo $NumWindow; ?>">Fecha Vence</th> 
					<th id="th2<?php echo $NumWindow; ?>">Cobro</th> 
				</tr> 
					 <?php 
					 if (isset($_GET["Poliza"])) {	
					$SQL="Select Fecha_SBY, Observaciones_SBY, Vence_SBY, Cobro_SBY FROM klstandby a, klemisiones b WHERE a.Codigo_CTZ=b.Codigo_CTZ Order by Fecha_SBY";
					$resulthc = mysqli_query($conexion, $SQL);
					$contarow=0;
					while($rowhc = mysqli_fetch_array($resulthc)) 
						{
							$contarow=$contarow+1;
							echo '
					  <tr id="tr'.$contarow.$NumWindow.'">
					  <td align="left"><input name="hdn_fechastby'.$contarow.$NumWindow.'" type="hidden" id="hdn_fechastby'.$contarow.$NumWindow.'" value="'.$rowhc[0].'" />'.$rowhc[0].'</td>
					  <td align="right"><input name="hdn_descripcionstby'.$contarow.$NumWindow.'" type="hidden" id="hdn_descripcionstby'.$contarow.$NumWindow.'" value="'.$rowhc[1].'" />'.$rowhc[1].'</td>
					  <td align="left"><input name="hdn_fechavencestby'.$contarow.$NumWindow.'" type="hidden" id="hdn_fechavencestby'.$contarow.$NumWindow.'" value="'.$rowhc[2].'" />'.$rowhc[2].'</td> 
					  <td align="left"><input name="hdn_cobrostby'.$contarow.$NumWindow.'" type="hidden" id="hdn_cobrostby'.$contarow.$NumWindow.'" value="'.$rowhc[3].'" />'.$rowhc[3].'</td> 
					  </tr>
					  ';
						}
					mysqli_free_result($resulthc); 
					 }
					 ?>
				</tbody>
				</table>
				 </div>

		  		</div>
		  		<input name="hdn_controwsby<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwsby<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
		  		<input name="hdn_controwx<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwx<?php echo $NumWindow; ?>" value="0" />
			</div>
			</div>

		</div>
			<!-- FIN STANDBY -->
</form>

<script >
/*
document.getElementById('divcotiza<?php echo $NumWindow; ?>').style.visibility = 'hidden';
document.getElementById('divemitir<?php echo $NumWindow; ?>').style.visibility = 'hidden';
document.getElementById('calc<?php echo $NumWindow; ?>').style.visibility = 'hidden';
*/
document.getElementById('div_familia<?php echo $NumWindow; ?>').style.display = 'none';
document.getElementById('div_pareja<?php echo $NumWindow; ?>').style.display = 'none';

<?php 
if (isset($_GET["Poliza"])) {
	$SQL="Select date(Fecha_EMI), a.Codigo_CTZ, Voucher_EMI, Nombres_KLI, Apellidos_KLI, FechaNac_KLI, Contacto_KLI, ID_TER, Correo_TER, Direccion_TER, Telefono_TER, Codigo_PLA, Codigo_AGE, Modalidad_CTZ, Codigo_DST, FechaIni_CTZ, FechaFin_CTZ, Dias_CTZ, c.Codigo_TER, Estado_EMI, Nacionalidad_KLI, Procedencia_CTZ From klcotizaciones a, klemisiones b, czterceros c, klclientes d Where a.Codigo_CTZ=b.Codigo_CTZ and a.Codigo_TER=c.Codigo_TER and a.Codigo_TER=d.Codigo_TER  and Estado_EMI='A' and Codigo_EMI='".$_GET["Poliza"]."'";
	$resultp = mysqli_query($conexion, $SQL);
	if($rowp = mysqli_fetch_array($resultp)) {
		echo "MsgBox1('Edicion de Polizas','La poliza ".$_GET["Poliza"]." se encuentra anulada');";
	} else {
		$SQL="Select FechaIni_CTZ, FechaFin_CTZ From klcotizaciones a, klemisiones b, czterceros c, klclientes d Where a.Codigo_CTZ=b.Codigo_CTZ and a.Codigo_TER=c.Codigo_TER and a.Codigo_TER=d.Codigo_TER  and Estado_EMI='E' and Codigo_EMI='".$_GET["Poliza"]."' and date(now()) > FechaIni_CTZ";
		$resultv = mysqli_query($conexion, $SQL);
		if($rowv = mysqli_fetch_array($resultv)) {
			echo "MsgBox1('Edicion de Polizas','La poliza ".$_GET["Poliza"]." se encuentra en vigencia (".$rowv[0]." - ".$rowv[1]."). No es posible editarla.');";
		} else {
			$SQL="Select date(Fecha_EMI), a.Codigo_CTZ, Voucher_EMI, Nombres_KLI, Apellidos_KLI, FechaNac_KLI, Contacto_KLI, ID_TER, Correo_TER, Direccion_TER, Telefono_TER, Codigo_PLA, Codigo_AGE, Modalidad_CTZ, Codigo_DST, FechaIni_CTZ, FechaFin_CTZ, Dias_CTZ, c.Codigo_TER, Estado_EMI, Nacionalidad_KLI, Procedencia_CTZ From klcotizaciones a, klemisiones b, czterceros c, klclientes d Where a.Codigo_CTZ=b.Codigo_CTZ and a.Codigo_TER=c.Codigo_TER and a.Codigo_TER=d.Codigo_TER  and Estado_EMI<>'A' and Codigo_EMI='".$_GET["Poliza"]."'";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_array($result)) {
				echo "
				document.frm_form".$NumWindow.".txt_femision".$NumWindow.".value='".$row[0]."';
				document.frm_form".$NumWindow.".txt_cotizacion".$NumWindow.".value='".$row[1]."';
				document.frm_form".$NumWindow.".txt_voucher".$NumWindow.".value='".$row[2]."';
				document.frm_form".$NumWindow.".txt_nombres".$NumWindow.".value='".$row[3]."';
				document.frm_form".$NumWindow.".txt_apellidos".$NumWindow.".value='".$row[4]."';
				document.frm_form".$NumWindow.".txt_fnac".$NumWindow.".value='".($row[5])."';
				document.frm_form".$NumWindow.".txt_contacto".$NumWindow.".value='".$row[6]."';
				document.frm_form".$NumWindow.".txt_pasaporte".$NumWindow.".value='".$row[7]."';
				document.frm_form".$NumWindow.".txt_correo".$NumWindow.".value='".$row[8]."';
				document.frm_form".$NumWindow.".txt_direccion".$NumWindow.".value='".$row[9]."';
				document.frm_form".$NumWindow.".txt_telefono".$NumWindow.".value='".$row[10]."';
				document.frm_form".$NumWindow.".cmb_agencia".$NumWindow.".value='".$row[12]."';
				document.frm_form".$NumWindow.".cmb_modalidad".$NumWindow.".value='".ucwords(strtolower($row[13]))."_PLA';
				document.frm_form".$NumWindow.".cmb_destino".$NumWindow.".value='".$row[14]."';
				document.frm_form".$NumWindow.".txt_fini".$NumWindow.".value='".($row[15])."';
				document.frm_form".$NumWindow.".txt_ffin".$NumWindow.".value='".($row[16])."';
				document.frm_form".$NumWindow.".txt_dias".$NumWindow.".value='".$row[17]."';
				document.frm_form".$NumWindow.".hdn_tercero".$NumWindow.".value='".$row[18]."';
				document.frm_form".$NumWindow.".cmb_estado".$NumWindow.".value='".$row[19]."';
				document.frm_form".$NumWindow.".txt_nacionalidad".$NumWindow.".value='".$row[20]."';
				document.frm_form".$NumWindow.".cmb_procedencia".$NumWindow.".value='".$row[21]."';
				CalcEdad".$NumWindow."('txt_fnac".$NumWindow."', 'txt_edad".$NumWindow."');
				";
			}
			mysqli_free_result($result); 
		}
		mysqli_free_result($resultv); 
	}
	mysqli_free_result($resultp); 

}
?>

function BuscarPolizaX<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
  	BuscarPoliza<?php echo $NumWindow; ?>();
  }
}

function BuscarPoliza<?php echo $NumWindow; ?>() {
	poliza=document.getElementById('txt_poliza<?php echo $NumWindow; ?>').value;
	AbrirForm('application/forms/klpolizaedit.php', '<?php echo $NumWindow; ?>', '&Poliza='+poliza);
}

function selecmod<?php echo $NumWindow; ?>() {
	document.getElementById('div_familia<?php echo $NumWindow; ?>').style.display = 'none';
	document.getElementById('div_pareja<?php echo $NumWindow; ?>').style.display = 'none';
	if (document.getElementById("cmb_modalidad<?php echo $NumWindow; ?>").value=="Hijos_PLA") {
		document.getElementById('div_familia<?php echo $NumWindow; ?>').style.display = 'block';
		document.getElementById('hdn_controw<?php echo $NumWindow; ?>').value=document.getElementById('hdn_controwx<?php echo $NumWindow; ?>').value;
	}
	if (document.getElementById("cmb_modalidad<?php echo $NumWindow; ?>").value=="Pareja_PLA") {
		document.getElementById('div_pareja<?php echo $NumWindow; ?>').style.display = 'block';
		document.getElementById('hdn_controw<?php echo $NumWindow; ?>').value="1";
	}
}

function ShowCoti<?php echo $NumWindow; ?>() {
	document.getElementById('divcotiza<?php echo $NumWindow; ?>').style.visibility = 'visible';
}

<?php 

if(isset($_GET["Plan"])) {
	echo '
	document.getElementById("cmb_plan'.$NumWindow.'").value="'.$_GET["Plan"].'";
	document.getElementById("txt_fnac'.$NumWindow.'").value="'.$_GET["FecNac"].'";
	document.getElementById("txt_fini'.$NumWindow.'").value="'.$_GET["FecIni"].'";
	document.getElementById("txt_ffin'.$NumWindow.'").value="'.$_GET["FecFin"].'";
	if (document.getElementById("txt_ffin'.$NumWindow.'").value!="") {
		CalcularDias'.$NumWindow.'();
	}
	';
} 
?>

function CalcularDias<?php echo $NumWindow; ?>() {
	FecINI=new Date(document.getElementById('txt_fini<?php echo $NumWindow; ?>').value);
	FecFIN=new Date(document.getElementById('txt_ffin<?php echo $NumWindow; ?>').value);
	if(FecINI=="") {
		MsgBox1("Error", "Fecha inicial no puede estar en blanco");
		return false;
	}
	if(FecFIN=="") {
		MsgBox1("Error", "Fecha final no puede estar en blanco");
		return false;
	}
	if (FecFIN>FecINI) {
		var diff = FecFIN.getTime() - FecINI.getTime();
		document.getElementById('txt_dias<?php echo $NumWindow; ?>').value = Math.round(diff / (1000 * 60 * 60 * 24))+1;
		return true;
	}
	else if (FecFIN != null && FecFIN < FecINI) {
		MsgBox1("Error", "Fechas de viaje no concuerdan");
		return false;
	}
}

function Calcular<?php echo $NumWindow; ?>() {
	document.getElementById('calc<?php echo $NumWindow; ?>').style.visibility = 'hidden';
	mas18=1;
	menos18=0;

	if (document.getElementById("cmb_modalidad<?php echo $NumWindow; ?>").value=="Pareja_PLA") {
		if (document.getElementById('txt_parentesco1<?php echo $NumWindow; ?>').value=="") {
			MsgBox1("Atención", "No ha digitado el parentesco");
			return false;
		}
		if (document.getElementById('txt_nombre1<?php echo $NumWindow; ?>').value=="") {
			MsgBox1("Atención", "No ha digitado el nombre del acompañante");
			return false;
		}
		if (document.getElementById('txt_fecnac1<?php echo $NumWindow; ?>').value=="") {
			MsgBox1("Atención", "No ha digitado la fecha de nacimiento del acompañante");
			return false;
		}
		if (document.getElementById('txt_pasaporte1<?php echo $NumWindow; ?>').value=="") {
			MsgBox1("Atención", "No ha digitado el pasaporte del acompañante");
			return false;
		}
		document.getElementById('hdn_menos18<?php echo $NumWindow; ?>').value="0";
		document.getElementById('hdn_mas18<?php echo $NumWindow; ?>').value="2";
		mas18=2;
		menos18=0;

	}

	if (document.getElementById("cmb_modalidad<?php echo $NumWindow; ?>").value=="Hijos_PLA") {
		TotalTHC=document.getElementById('hdn_controw<?php echo $NumWindow; ?>').value;
		if (TotalTHC==0) {
			MsgBox1("Atención", "No ha ingresado acompañantes");
			return false;
		}
		for (i = 1; i <= TotalTHC; i++) { 
			if ( document.getElementById('hdn_parentesco'+i+'<?php echo $NumWindow; ?>')) {
				if (document.getElementById('hdn_parentesco'+i+'<?php echo $NumWindow; ?>').value=="") {
					MsgBox1("Atención", "No ha digitado el parentesco");
					return false;
				}
				if (document.getElementById('hdn_nombre'+i+'<?php echo $NumWindow; ?>').value=="") {
					MsgBox1("Atención", "No ha digitado el nombre del acompañante");
					return false;
				}
				if (document.getElementById('hdn_fecnac'+i+'<?php echo $NumWindow; ?>').value=="") {
					MsgBox1("Atención", "No ha digitado la fecha de nacimiento del acompañante");
					return false;
				}
				if (document.getElementById('hdn_pasaporte'+i+'<?php echo $NumWindow; ?>').value=="") {
					MsgBox1("Atención", "No ha digitado el pasaporte del acompañante");
					return false;
				}
				CalcEdad<?php echo $NumWindow; ?>('hdn_fecnac'+i+'<?php echo $NumWindow; ?>', 'hdn_edad'+i+'<?php echo $NumWindow; ?>');
				LaEdad0=document.getElementById('hdn_edad'+i+'<?php echo $NumWindow; ?>').value;
				if (LaEdad0>=18) {
					mas18=mas18+1;
				} else {
					menos18=menos18+1;
				}
			}
		}
		document.getElementById('hdn_menos18<?php echo $NumWindow; ?>').value=menos18;
		document.getElementById('hdn_mas18<?php echo $NumWindow; ?>').value=mas18;
	}
	//PRIMERO LA SELECCION DEL PLAN
	if(document.getElementById('cmb_plan<?php echo $NumWindow; ?>').value=="0") {
		MsgBox1("Atención", "No ha selecciondo el plan");
		return false;
	}
	//CALCULAMOS EDAD
	document.getElementById('txt_edad<?php echo $NumWindow; ?>').value="";
	if (CalcEdad<?php echo $NumWindow; ?>('txt_fnac<?php echo $NumWindow; ?>', 'txt_edad<?php echo $NumWindow; ?>')==false) {
		return false;
	}
	//CALCULAR DIAS DEL VIAJE
    if (CalcularDias<?php echo $NumWindow; ?>()==false) {
    	MsgBox1("Error de fechas", "Por favor verifique las fechas seleccionadas");
    	return false;
    }
    plan=document.getElementById('cmb_plan<?php echo $NumWindow; ?>').value;
    edad=document.getElementById('txt_edad<?php echo $NumWindow; ?>').value;
    modalidad=document.getElementById('cmb_modalidad<?php echo $NumWindow; ?>').value;
    dias=document.getElementById('txt_dias<?php echo $NumWindow; ?>').value;
	klcalculo(plan, edad, modalidad, dias,'<?php echo $NumWindow; ?>', mas18, menos18);
	document.getElementById('calc<?php echo $NumWindow; ?>').style.visibility = 'visible';
}

function CalcEdad<?php echo $NumWindow; ?>(ifecha, iedad) {
	if (document.getElementById(ifecha).value=="") {
		MsgBox1("Error de cáculo", "No ha introducido una fecha de nacimiento válida");
	}
	var fecha=new Date(document.getElementById(ifecha).value);
 	    var dia = fecha.getDate();
        var mes = fecha.getMonth();
        var ano = fecha.getYear();
        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth();
        var ahora_dia = fecha_hoy.getDate();
        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if ( ahora_mes < (mes - 1)) {
            edad--;
        }
        if (((mes - 1) == ahora_mes) && (ahora_dia < dia)) {
            edad--;
        }
        if (edad > 1900) {
            edad -= 1900;
        }
 		document.getElementById(iedad).value=edad;
 		return true;

}

function isValidDate<?php echo $NumWindow; ?>(day,month,year)
{
    var dteDate;
 	month=month-1;
    dteDate=new Date(year,month,day);
 	return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
}

function validate_fecha<?php echo $NumWindow; ?>(fecha)
{
	values0=fecha.split("/");
	fecha0=values0[2].concat('-', values0[1], '-',values0[0]);
	var patron=new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");

    if(fecha0.search(patron)==0)   {
    	var values=fecha0.split("-");
        if(isValidDate<?php echo $NumWindow; ?>(values[2],values[1],values[0]))  {
            return true;
        }
    }
    return false;
}

function CalcTRM<?php echo $NumWindow; ?>() {
	dolares=document.getElementById('txt_dolares<?php echo $NumWindow; ?>').value;
	trm=document.getElementById('txt_trm<?php echo $NumWindow; ?>').value;
	desc=document.getElementById('txt_descuento<?php echo $NumWindow; ?>').value;
	pesos=dolares*trm;
	total=pesos*(100-desc)/100;
   	document.getElementById('txt_pesos<?php echo $NumWindow; ?>').value=nxscurrency(pesos, 2, [',', "'", '.']);
   	document.getElementById('hdn_pesos0<?php echo $NumWindow; ?>').value=pesos;
   	document.getElementById('txt_total<?php echo $NumWindow; ?>').value=nxscurrency(total, 2, [',', "'", '.']);
   	document.getElementById('hdn_total0<?php echo $NumWindow; ?>').value=total;
}

function selecplan<?php echo $NumWindow; ?>() {
	if(document.getElementById('cmb_plan<?php echo $NumWindow; ?>').value!="0") {
		document.getElementById("txt_fnac<?php echo $NumWindow; ?>").disabled=true;
		poliza=document.getElementById('txt_poliza<?php echo $NumWindow; ?>').value;
		AbrirForm('application/forms/klpolizaedit.php', '<?php echo $NumWindow; ?>', '&Poliza='+poliza+'&Plan='+document.getElementById('cmb_plan<?php echo $NumWindow; ?>').value+'&FecNac='+document.getElementById('txt_fnac<?php echo $NumWindow; ?>').value+'&FecIni='+document.getElementById('txt_fini<?php echo $NumWindow; ?>').value+'&FecFin='+document.getElementById('txt_ffin<?php echo $NumWindow; ?>').value);
	}
}

function KlResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/klpolizaedit.php', '<?php echo $NumWindow; ?>', '');	
}

function Addpersona<?php echo $NumWindow; ?>() {
	Parentesco=document.getElementById('txt_parentesco<?php echo $NumWindow; ?>').value;
	NombreCompletos=document.getElementById('txt_nombre<?php echo $NumWindow; ?>').value;
	FecNac=document.getElementById('txt_fecnac0<?php echo $NumWindow; ?>').value;
	LaEdad=document.getElementById('hdn_edad0<?php echo $NumWindow; ?>').value;
	Passaporte=document.getElementById('txt_pasaporte0<?php echo $NumWindow; ?>').value;
		
	if (Parentesco!="") {
		Parentesco=Parentesco.toUpperCase();
		NombreCompletos=NombreCompletos.toUpperCase();
		Passaporte=Passaporte.toUpperCase();
		TotalFilas=document.getElementById("hdn_controwx<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbcob<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
	    var celda5 = document.createElement("td"); 
		TotalFilas++;
		fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
	    celda1.innerHTML = '<input name="hdn_parentesco'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_parentesco'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Parentesco+''+'" /> '+Parentesco; 
		celda2.innerHTML = '<input name="hdn_nombre'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_nombre'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+NombreCompletos+''+'" /> '+NombreCompletos; 
		celda3.innerHTML = '<input name="hdn_fecnac'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_fecnac'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+FecNac+''+'" /> '+FecNac+'<input name="hdn_edad'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_edad'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+LaEdad+''+'" /> ';  
	    celda4.innerHTML = '<input name="hdn_pasaporte'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_pasaporte'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Passaporte+''+'" /> '+Passaporte; 
	    celda5.innerHTML = '<button onclick="EliminarFilaPER<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    fila.appendChild(celda4); 
	    fila.appendChild(celda5); 
	    miTabla.appendChild(fila); 
	    document.getElementById('hdn_controwx<?php echo $NumWindow; ?>').value=TotalFilas;
		document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_parentesco<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_nombre<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_fecnac0<?php echo $NumWindow; ?>').value="";
		document.getElementById('hdn_edad0<?php echo $NumWindow; ?>').value="0";
		document.getElementById('txt_pasaporte0<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_parentesco<?php echo $NumWindow; ?>').focus();
	}
}
function AddStandBy<?php echo $NumWindow; ?>() {
	fechastby=document.getElementById('txt_fechasby<?php echo $NumWindow; ?>').value;
	obstsby=document.getElementById('txt_obssby<?php echo $NumWindow; ?>').value;
	vencestby=document.getElementById('txt_vencesby<?php echo $NumWindow; ?>').value;
	valorstby=document.getElementById('txt_valorsby<?php echo $NumWindow; ?>').value;
		
	if (obstsby!="") {
		obstsby=obstsby.toUpperCase();
		TotalFilas=document.getElementById("hdn_controwsby<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbcobsby<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
		TotalFilas++;
		fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
	    celda1.innerHTML = '<input name="hdn_fechastby'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_fechastby'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+fechastby+''+'" /> '+fechastby; 
		celda2.innerHTML = '<input name="hdn_descripcionstby'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_descripcionstby'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+obstsby+''+'" /> '+obstsby; 
		celda3.innerHTML = '<input name="hdn_fechavencestby'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_fechavencestby'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+vencestby+''+'" /> '+vencestby;  
	    celda4.innerHTML = '<input name="hdn_cobrostby'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_cobrostby'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+valorstby+''+'" /> '+valorstby; 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    fila.appendChild(celda4); 
	    miTabla.appendChild(fila); 
	    document.getElementById('hdn_controwsby<?php echo $NumWindow; ?>').value=TotalFilas;
		document.getElementById('txt_fechasby<?php echo $NumWindow; ?>').value="<?php echo date("Y-m-d"); ?>";
		document.getElementById('txt_obssby<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_vencesby<?php echo $NumWindow; ?>').value="<?php echo date("Y-m-d", strtotime ('+1 year' , strtotime(date("Y-m-d")))); ?>";
		document.getElementById('txt_valorsby<?php echo $NumWindow; ?>').value="0";
		document.getElementById('txt_fechasby<?php echo $NumWindow; ?>').focus();
	} else {
		MsgBox1("Edicion de Pólizas","Falta la observacion del StandBy");
		document.getElementById('txt_obssby<?php echo $NumWindow; ?>').focus();
	}
}

function EliminarFilaPER<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalle<?php echo $NumWindow; ?>");     
    $('#tr'+Numero+"<?php echo $NumWindow; ?>").remove();
} 

	$(".datepicker0<?php echo $NumWindow; ?>").on("dp.change", function (e) {
        if (document.getElementById("txt_fnac<?php echo $NumWindow; ?>").value!="") {
        	CalcEdad<?php echo $NumWindow; ?>('txt_fnac<?php echo $NumWindow; ?>', 'txt_edad<?php echo $NumWindow; ?>');
        }
        EdadOnBlur<?php echo $NumWindow; ?>();
    });
    $(".datepicker1<?php echo $NumWindow; ?>").on("dp.change", function (e) {
    	if (document.getElementById('txt_ffin<?php echo $NumWindow; ?>').value!="") {
    		CalcularDias<?php echo $NumWindow; ?>();
    	}
        $('.datepicker2<?php echo $NumWindow; ?>').data("DateTimePicker").minDate(e.date);
    });
    $(".datepicker2<?php echo $NumWindow; ?>").on("dp.change", function (e) {
    	CalcularDias<?php echo $NumWindow; ?>();
        $('.datepicker1<?php echo $NumWindow; ?>').data("DateTimePicker").maxDate(e.date);
    });

	$('.datepicker').datepicker({
		format: "dd/mm/yyyy",
		language: "es",
		autoclose: true
	});

 	$("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-select");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=checkbox]").addClass("form-check-input");
	$("input[type=radio]").addClass("form-check-input");

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
