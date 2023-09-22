<?php
	
	
	session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" action="functions/php/nexus/uploads.php?route=images&class=terceros&style=profile&wind=<?php echo $NumWindow; ?>" enctype="multipart/form-data" target="upload_target" onreset="HCResetea<?php echo $NumWindow; ?>();">
	<div class="row">

		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_idhc<?php echo $NumWindow; ?>">Paciente</label>
		<div class="input-group">	
			<input style="font-size:15px;" name="txt_idhc<?php echo $NumWindow; ?>" id="txt_idhc<?php echo $NumWindow; ?>" type="text" required onkeypress="BuscarHCPte<?php echo $NumWindow; ?>(event);" onblur="HCPteOnBlur<?php echo $NumWindow; ?>()" />
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('PacientesHC', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
			</span>
		</div>
		<input name="hdn_codigoter<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoter<?php echo $NumWindow; ?>" value="X" />
	</div>

		</div>
		<div class="col-md-5">

	<div class="form-group">
		<label for="txt_paciente<?php echo $NumWindow; ?>">Nombre</label>
		<input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>
	
		</div>
		<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_area<?php echo $NumWindow; ?>">Area de Servicio</label>
		<select name="cmb_area<?php echo $NumWindow; ?>" id="cmb_area<?php echo $NumWindow; ?>">
		<?php 
	$SQL="Select Codigo_ARE, Nombre_ARE from gxareas where Estado_ARE='1' and Codigo_ARE in (Select Codigo_ARE from itusuariosareas where Codigo_USR='".$_SESSION["it_CodigoUSR"]."') order by 2";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
		{
	 ?>
	  <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
	<?php
		}
	mysqli_free_result($result); 
	 ?>  
		</select>
	</div>
	
		</div>
		<div class="col-md-2">
	
	<div class="form-group" id="grp_txt_hora<?php echo $NumWindow; ?>">
		<label for="txt_hora<?php echo $NumWindow; ?>">Hora</label>
		<input name="txt_hora<?php echo $NumWindow; ?>" id="txt_hora<?php echo $NumWindow; ?>" type="time" required value="00:00:00"/>
	</div>

		</div>
		<div class="col-md-1">
	
	<div class="form-group">
		<label for="txt_ingreso<?php echo $NumWindow; ?>">Ingreso</label>
		<input style="font-size:15px; text-align:right;font-weight: bold;" name="txt_ingreso<?php echo $NumWindow; ?>" id="txt_ingreso<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>

		</div>
		<div class="col-md-9 alert alert-warning">
	<div class="row">
		<div class="col-md-12 label label-danger hidden" id="div_alertas">
			...
		</div>
		<input name="hdn_autorizacion<?php echo $NumWindow; ?>" type="hidden" id="hdn_autorizacion<?php echo $NumWindow; ?>" value="" />
		<div class="col-md-5">
			<label>Contrato: </label> <span id="spn_contrato<?php echo $NumWindow; ?>">Sin datos</span>
			<input name="hdn_contrato<?php echo $NumWindow; ?>" type="hidden" id="hdn_contrato<?php echo $NumWindow; ?>" value="" />
		</div>
		<div class="col-md-5">
			<label>Plan: </label> <span id="spn_plan<?php echo $NumWindow; ?>">Sin datos</span>
			<input name="hdn_plan<?php echo $NumWindow; ?>" type="hidden" id="hdn_plan<?php echo $NumWindow; ?>" value="" />
		</div>
		<div class="col-md-2">
			<label>Rango: </label> <span id="spn_rango<?php echo $NumWindow; ?>">--</span>
		</div>
		<div class="col-md-3">
			<label>Fec Nacimiento: </label> <small><span id="spn_fechanac<?php echo $NumWindow; ?>">00/00/0000</span></small>
		</div>
		<div class="col-md-4">
			<label>Edad: </label> <small><span id="spn_edad<?php echo $NumWindow; ?>">00 Años</span></small>
		</div>
		<div class="col-md-2">
			<label>Sexo: </label> <small><span id="spn_sexo<?php echo $NumWindow; ?>">-</span></small>
		</div>
		<div class="col-md-3">
			<label>Est. Civil: </label> <small><span id="spn_estcivil<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-5">
			<label>Dirección: </label> <small><span id="spn_direccion<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-3">
			<label>Teléfono: </label> <small><span id="spn_telefono<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4">
			<label>Ocupación: </label> <small><span id="spn_ocupacion<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-5">
			<label>Acompañante: </label> <small><span id="spn_acomp<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-3">
			<label>Teléfono: </label> <small><span id="spn_telacomp<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4">
			<label>Parentesco: </label> <small><span id="spn_parentesco<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4">
			<label>Ingreso Por: </label> <small><span id="spn_ingpor<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4">
			<label>Observaciones: </label> <small><span id="spn_obs<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4">
			<label>Fecha Ingreso: </label> <span id="spn_fechaing<?php echo $NumWindow; ?>" class="badge">00/00/0000</span>
		</div>
		<div class="col-md-4">
			<label>Tipo Paciente: </label> <span id="spn_tipopte<?php echo $NumWindow; ?>" >Sin datos</span>
		</div>
	</div>
		<?php 
			if (isset($_GET["Historia"])) {
		?>
	<div class="row">
		<div class="col-md-12">
			<div class="btn-group btn-group-sm bg-warning" role="group" style="float: right;">
				<button type="button" class="btn btn-success" onclick="CargarForm('application/forms/hclistaformedica.php?&Historia=<?php echo $_GET["Historia"]; ?>', 'Formula Médica', '1.Pills.png');">Ver Fórmula Médica</button>
				<button type="button" class="btn btn-success" onclick="CargarForm('application/reports/hcayudasdx.php', 'Ordenes Médicas', 'default.png');">Ver Paraclínicos</button>
			</div>	
		</div>
	</div>
		<?php 
			}
		?>
		</div>
		<div class="btn-group col-md-3">
			  <button type="button" class="btn btn-success btn-block dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			   <i class="fas fa-plus"></i> Nuevo Folio <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" >
			  	<?php
			  	if ($_SESSION["it_CodigoPRF"]=='0') {
			  		$SQL="Select Codigo_HCT, Nombre_HCT from hctipos where Activo_HCT='1' order by 2";
			  	} else {
			  		$SQL="Select Codigo_HCT, Nombre_HCT from hctipos where Activo_HCT='1' and Codigo_HCT in (Select Codigo_HCT From hcusuarioshc Where Codigo_USR ='".$_SESSION["it_CodigoUSR"]."') order by 2";
			  	}
				$result = mysqli_query($conexion, $SQL);
				$contarow=0;
				while($row = mysqli_fetch_array($result)) 
					{
						echo '<li ><a href="javascript:selecthc'.$NumWindow.'(\''.$row[0].'\');">'.$row[1].'</a></li>
					';
					}
					mysqli_free_result($result); 
					?>
			  </ul>
			  <input name="hdn_formatohc<?php echo $NumWindow; ?>" type="hidden" id="hdn_formatohc<?php echo $NumWindow; ?>" value="<?php if (isset($_GET["FormatoHC"])) { echo $_GET["FormatoHC"]; } ?>" />
			</div>
			

			<div class="col-md-3 ">

			 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
			<tbody id="tbDetalle<?php echo $NumWindow; ?>">
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th1<?php echo $NumWindow; ?>">#</th> 
				<th id="th2<?php echo $NumWindow; ?>">Fecha</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Tipo</th> 
			</tr> 
				 <?php 
				 if (isset($_GET["Historia"])) {
				$SQL="Select a.Codigo_HCF, a.Fecha_HCF, b.Nombre_HCT, c.Nombre_ARE, d.Nombre_USR, e.ID_TER, a.Hora_HCF From hcfolios a, hctipos b, gxareas c, itusuarios d, czterceros e Where a.Codigo_HCT=b.Codigo_HCT and c.Codigo_ARE=a.Codigo_ARE and d.Codigo_USR=a.Codigo_USR and e.Codigo_TER=a.Codigo_TER and e.ID_TER='".$_GET["Historia"]."' Order By a.Fecha_HCF desc, a.Hora_HCF, a.Codigo_HCF desc";
				$resulthc = mysqli_query($conexion, $SQL);
				$contarow=0;
				while($rowhc = mysqli_fetch_array($resulthc)) 
					{
						$contarow=$contarow+1;
						echo '
				  <tr onclick="CargarReport(\'application/reports/hc.php?HISTORIA='.$rowhc["ID_TER"].'&FOLIO_INICIAL='.$rowhc[0].'&FOLIO_FINAL='.$rowhc[0].'\', \'HC '.$rowhc["ID_TER"].'\');"><td align="center">'.$rowhc[0].'</td><td align="center">'.formatofecha($rowhc[1]).'</td><td>'.$rowhc[2].'</td></tr>
				  ';
					}
				mysqli_free_result($resulthc); 
				 }
				 ?>  

			</tbody>
			</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
			 </div>

	  		</div>
	  	<div id="divformatohc<?php echo $NumWindow; ?>" class="col-md-12">
	  		<?php
	  		if (isset($_GET["FormatoHC"])) {
		  		$SQL="Select * from hctipos where Activo_HCT='1' and Codigo_HCT='".$_GET["FormatoHC"]."';";
				$result = mysqli_query($conexion, $SQL);
				while($row = mysqli_fetch_array($result)) {

	  		?>
	  		<h4><label class="label label-default"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <?php echo $row["Nombre_HCT"]; ?></label></h4>
	  		<div class="row well well-sm">
	  		<input name="hdn_codigoser<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoser<?php echo $NumWindow; ?>" value="<?php echo $row["Codigo_SER"]; ?>" />
	  			<?php
	  				$SVHCT=$row["SV_HCT"];
	  				$AyudasDiagHCT=$row["AyudasDiag_HCT"];
	  				$MedHCT=$row["Med_HCT"];
	  				$OrdenesHCT=$row["Ordenes_HCT"];
	  				$IndicacionesHCT=$row["Indicaciones_HCT"];
	  				$ImgHCT=$row["Img_HCT"];
	  				$Medico2HCT=$row["Medico2_HCT"];
	  				$AntecedentesHCT=$row["Antecedentes_HCT"];
	  				$DxHCT=$row["Dx_HCT"];
	  				$OdontogramaHCT=$row["Odontograma_HCT"];
	  				//Antecedentes
					if ($AntecedentesHCT=="1") {
	  					echo '
	  					<button class="btn btn-warning btn-sm btn-block" type="button" data-toggle="collapse" data-target="#div_antecedentes'.$NumWindow.'" aria-expanded="false" aria-controls="collapseExample">
  							<span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>  Actualizar Antecedentes
						</button>

						<div class="collapse col-md-12" id="div_antecedentes'.$NumWindow.'">
						  <div class="row alert alert-warning">
						    
						    <div class="col-md-4">
						    <div class="input-group" id="tipoant'.$NumWindow.'">
							  <div class="input-group-addon">Tipo</div>
						    	<select name="cmb_cmbant'.$NumWindow.'" id="cmb_cmbant'.$NumWindow.'"  class="form-control">';
						$SQL="Select Codigo_HCA, ucase(Nombre_HCA) from hctipoantecedentes where Estado_HCA='1' order by 1";
						$resultz = mysqli_query($conexion, $SQL);
						while($rowz = mysqli_fetch_array($resultz)) 
							{
						 	echo '
						  <option value="'.$rowz[0].'">'.$rowz[1].'</option>
							';
							}
						mysqli_free_result($resultz); 
  						echo '  
								</select>
							  </div>
							  <textarea class="form-control" rows="3" id="txt_antecdentext'.$NumWindow.'"></textarea>
							  <button class="btn btn-warning btn-block" type="button" onclick="AddAnt'.$NumWindow.'();">
	  							Agregar <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>  
							  </button>
						    </div>
						    <div class="col-md-8">

								 <div id="zero_detalleantX'.$NumWindow.'" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleantX'.$NumWindow.'" >
								<tbody id="tbDetalleantX'.$NumWindow.'">
								<tr id="trhX'.$NumWindow.'"> 
									<th id="th1antX'.$NumWindow.'">Tipo</th> 
									<th id="th2antX'.$NumWindow.'">Antecedentes</th> 
									<th id="th3antX'.$NumWindow.'"> X </th> 
								</tr> 

								</tbody>
								</table><input name="hdn_controwantX'.$NumWindow.'" type="hidden" id="hdn_controwantX'.$NumWindow.'" value="0" />
								 </div>
						    </div>

						  </div>
						</div>
						';
	  				}//Antecedentes

	  				//SIGNOS VITALES
	  				if ($SVHCT!="0") {
	  					echo '
	  					<div class="col-md-12">
	  						<label class="label label-success"> Signos Vitales</label>
							<div class="row alert alert-success">
						';
						$SQL="Select a.* from hcsv2 a, hcsv3 b where a.Codigo_HSV=b.Codigo_HSV and Codigo_SV1='".$SVHCT."' order by Orden_HSV";
						$resultz = mysqli_query($conexion, $SQL);
						$contasv=0;
						while($rowz = mysqli_fetch_array($resultz)) 
							{
							$contasv=$contasv+1;
							if (($rowz["Prefijo_HSV"]!="")||($rowz["Sufijo_HSV"]!="")) {
								$tamsv="2";
							} else  {
								$tamsv="1";
							}
						 	echo '
						 	<div class="col-md-'.$tamsv.'">
						 		<input name="hdn_codsv'.$contasv.$NumWindow.'" type="hidden" id="hdn_codsv'.$contasv.$NumWindow.'" value="'.$rowz["Codigo_HSV"].'" />
						 		<div class="form-group" id="grp_txt_valorsv'.$contasv.$NumWindow.'">
							 		<label for="txt_valorsv'.$contasv.$NumWindow.'">'.$rowz["Sigla_HSV"].'</label>
							';
							if (($rowz["Prefijo_HSV"]!="")||($rowz["Sufijo_HSV"]!="")) {
								echo '<div class="input-group">';
							}
							if ($rowz["Prefijo_HSV"]!="") {
								echo '<div class="input-group-addon">'.$rowz["Prefijo_HSV"].'</div>';
							}
							$calculosv="";
							$disabledsv="";
							
							if ($rowz["Vinculado_HSV"]!="") {
								$calculosv=' onchange="calc_sv'.$rowz["Vinculado_HSV"].$NumWindow.'();" ';
							}
							/*
							if ($rowz["Calculo_HSV"]!="") {
								$disabledsv=' disabled="disabled" ';
							}
							*/
							echo '
										<input name="txt_valorsv'.$contasv.$NumWindow.'" id="txt_valorsv'.$contasv.$NumWindow.'" type="text"  required '.$calculosv.$disabledsv.' class="sv_'.$rowz["Codigo_HSV"].$NumWindow.'" />
							';
							if ($rowz["Sufijo_HSV"]!="") {
								echo '<div class="input-group-addon">'.$rowz["Sufijo_HSV"].'</div>';
							}
							if (($rowz["Prefijo_HSV"]!="")||($rowz["Sufijo_HSV"]!="")) {
								echo '</div>';
							}
							echo '
								</div>
							</div>
							';
							}
						mysqli_free_result($resultz); 

						echo '
							</div>
						</div>
						';
	  				} // SIGNOS VITALES
	  				

	  				//Diagnosticos
	  				if ($DxHCT=="1") {
	  					echo '
	  					<div class="col-md-12">
	  						<label class="label label-success"> Diagnóstico</label>
							<div class="row well well-sm">

						<div class="col-md-3">
							<div class="form-group" id="grp_cmb_estado'.$NumWindow.'">
								<label for="cmb_tipodx'.$NumWindow.'">Tipo Dx</label>
								<select name="cmb_tipodx'.$NumWindow.'" id="cmb_estado'.$NumWindow.'">
								  <option value="1">1 - IMPRESION DIAGNOSTICA</option>
								  <option value="2">2 - CONFIRMADO NUEVO</option>
								  <option value="3">3 - CONFIRMADO REPETIDO</option>
								</select>
							</div>
					
						</div>
						<div class="col-md-2">

							<div class="form-group" id="grp_txt_dxppal'.$NumWindow.'">
								<label for="txt_dxppal'.$NumWindow.'">Dx Ppal</label>
								<div class="input-group">	
									<input name="txt_dxppal'.$NumWindow.'" id="txt_dxppal'.$NumWindow.'" type="text" required onblur="HCDxOnBlur'.$NumWindow.'();"/>
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch(\'Diagnostico\', \'txt_dxppal'.$NumWindow.'\', \'NULL\');"><i class="fas fa-search"></i></button>
									</span>
								</div>
							</div>

						</div>
						<div class="col-md-6">

							<div class="form-group">
								<label for="txt_dxppal1'.$NumWindow.'">Nombre Diagnóstico Principal</label>
								<input name="txt_dxppal1'.$NumWindow.'" id="txt_dxppal1'.$NumWindow.'" type="text" disabled="disabled" />
							</div>
						
						</div>
						<div class="col-md-1">

							<div class="form-group">
								<label for="txt_modelo'.$NumWindow.'">Más Dx</label>
								<button class="btn btn-success btn-block" type="button" data-toggle="collapse" data-target="#div_diagnosticos'.$NumWindow.'" aria-expanded="false" aria-controls="collapseExample">
		  							<i class="fas fa-plus"></i>
								</button>
							</div>
						
						</div>
						<div class="collapse col-md-12" id="div_diagnosticos'.$NumWindow.'">
						  <div class="row">

						<div class="col-md-8">
							<div class="row">
								 <div class="col-md-3">
								 	<div class="form-group">
										<label for="txt_dxrel1'.$NumWindow.'">Dx Rel</label>
										<div class="input-group">	
											<input name="txt_dxrel1'.$NumWindow.'" id="txt_dxrel1'.$NumWindow.'" type="text" onblur="HCDxR1OnBlur'.$NumWindow.'();" />
											<span class="input-group-btn">	
												<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch(\'Diagnostico\', \'txt_dxrel1'.$NumWindow.'\', \'NULL\');"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								 </div>
								 <div class="col-md-9">
								 	<div class="form-group">
										<label for="txt_dxrel11'.$NumWindow.'">Diagnóstico Relacionado</label>
										<input name="txt_dxrel11'.$NumWindow.'" id="txt_dxrel11'.$NumWindow.'" type="text" disabled="disabled" />
									</div>
								 </div>
								 <div class="col-md-3">
								 	<div class="form-group">
										<label for="txt_dxrel2'.$NumWindow.'">Dx Rel2</label>
										<div class="input-group">	
											<input name="txt_dxrel2'.$NumWindow.'" id="txt_dxrel2'.$NumWindow.'" type="text" onblur="HCDxR2OnBlur'.$NumWindow.'();" />
											<span class="input-group-btn">	
												<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch(\'Diagnostico\', \'txt_dxrel2'.$NumWindow.'\', \'NULL\');"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								 </div>
								 <div class="col-md-9">
								 	<div class="form-group">
										<label for="txt_dxrel22'.$NumWindow.'">Diagnóstico Relacionado 2</label>
										<input name="txt_dxrel22'.$NumWindow.'" id="txt_dxrel22'.$NumWindow.'" type="text" disabled="disabled" />
									</div>
								 </div>
								 <div class="col-md-3">
								 	<div class="form-group">
										<label for="txt_dxrel3'.$NumWindow.'">Dx Rel3</label>
										<div class="input-group">	
											<input name="txt_dxrel3'.$NumWindow.'" id="txt_dxrel3'.$NumWindow.'" type="text" onblur="HCDxR3OnBlur'.$NumWindow.'();" />
											<span class="input-group-btn">	
												<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch(\'Diagnostico\', \'txt_dxrel3'.$NumWindow.'\', \'NULL\');"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								 </div>
								 <div class="col-md-9">
								 	<div class="form-group">
										<label for="txt_dxrel33'.$NumWindow.'">Diagnóstico Relacionado 3</label>
										<input name="txt_dxrel33'.$NumWindow.'" id="txt_dxrel33'.$NumWindow.'" type="text" disabled="disabled" />
									</div>
								 </div>
							</div>
						</div>
						<div class="col-md-4">

							<div class="form-group">
								<label for="txt_dxmanejo'.$NumWindow.'">Diagnóstico de manejo</label>
								<textarea class="form-control" rows="9" id="txt_dxmanejo'.$NumWindow.'"></textarea>
							</div>
						
						</div>


						  </div>
						</div>



							</div>
						</div>';


	  				}//Diagnosticos
	  			}
	  			mysqli_free_result($result);
	  			//Campos del formato HC
	  			$SQL="Select * from hccampos where Codigo_HCT='".$_GET["FormatoHC"]."' and Grupo_HCC='0' Order By Orden_HCC;";
				$result = mysqli_query($conexion, $SQL);
				$rekerido="";
				while($row = mysqli_fetch_array($result)) {
					if ($row["Obligatorio_HCC"]=="1") {
						$rekerido="required";
					} else {
						$rekerido="";
					}
					switch ($row["Tipo_HCC"]) {
						//check box
						case 'check':
	  			?>
					<div class="col-md-<?php echo $row["Largo_HCC"]; ?>">

				<div class="checkbox checkbox-success">
					<input name="chk_x<?php echo $row["Codigo_HCC"].$NumWindow; ?>" id="chk_x<?php echo $row["Codigo_HCC"].$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:chekear<?php echo $NumWindow; ?>('<?php echo $row["Codigo_HCC"]; ?>');" class="styled" <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?> <?php echo $rekerido; ?>>
					<label for="chk_x<?php echo $row["Codigo_HCC"].$NumWindow; ?>"><?php echo $row["Etiqueta_HCC"]; ?></label>
				</div>
				<input name="hdn_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" type="hidden" id="hdn_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" value="0" />

					</div>
	  			<?php
	  					break;
	  					//text box
						case 'text':
	  			?>
	  				<div class="col-md-<?php echo $row["Largo_HCC"]; ?>">
				<div class="form-group" id="grp_txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>">
					<label for="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>"><?php echo $row["Etiqueta_HCC"]; ?></label>
					<input name="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" id="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" type="text" value="<?php echo trim($row["Defecto_HCC"]); ?>" maxlength="<?php echo $row["Maximo_HCC"]; ?>" <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?> <?php echo $rekerido; ?> />
				</div>
					</div>
	  			<?php
	  					break;
	  					// text area
	  					case "textarea":
	  			?>
	  				<div class="col-md-<?php echo $row["Largo_HCC"]; ?>">
				<div class="form-group" id="grp_txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>">
					<label for="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>"><?php echo $row["Etiqueta_HCC"]; ?></label>
					<textarea class="form-control" rows="<?php echo $row["Lineas_HCC"]; ?>" id="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" name="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" maxlength="<?php echo $row["Maximo_HCC"]; ?>" <?php echo $rekerido; ?> <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?>><?php echo trim($row["Defecto_HCC"]); ?></textarea>
				</div>
					</div>
				<?php
	  					break;
	  					// Select
	  					case "select":
	  			?>
					<div class="col-md-<?php echo $row["Largo_HCC"]; ?>">
				<div class="form-group" id="grp_cmb_<?php echo $row["Codigo_HCC"].$NumWindow; ?>">
					<label for="cmb_<?php echo $row["Codigo_HCC"].$NumWindow; ?>"><?php echo $row["Etiqueta_HCC"]; ?></label>
					<select name="cmb_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" id="cmb_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" <?php echo $rekerido; ?> <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?>>
					<?php 
				$SQL="Select Valor_HCC, Texto_HCC, Orden_HCC, Seleccionado_HCC, Comando_HCC from hccamposlistas Where Codigo_HCT='".$_GET["FormatoHC"]."' and Codigo_HCC='".$row["Codigo_HCC"]."' Order by 3";
				$resultl = mysqli_query($conexion, $SQL);
				while($rowl = mysqli_fetch_array($resultl)) 
					{
						$sel="";
						if ($rowl["Seleccionado_HCC"]=="1") {
							$sel=' selected="selected" ';
						}
				 ?>
				  <option value="<?php echo $rowl[0]; ?>" <?php echo $sel; echo($rowl["Comando_HCC"]); ?>  ><?php echo ($rowl[1]); ?></option>
				<?php
					}
				mysqli_free_result($resultl); 
				 ?>  
					</select>
				</div>
					</div>
	  			<?php
	  					break;
	  					// Grupo de controles
	  					case "well":

	  			?>
	  			<div id="div<?php echo $row["Codigo_HCC"].$NumWindow; ?>" class="col-md-<?php echo $row["Largo_HCC"]; ?>" <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?>>
	  				<label class="label label-success"> <?php echo $row["Etiqueta_HCC"]; ?></label> 
	  				<?php 
	  					$ClassNormal="";
	  					if($row["Normalizar_HCC"]=="1") {
	  						$ClassNormal="Nrml".$row["Codigo_HCC"];
	  				?>
	  				<button type="button" class="btn btn-warning btn-xs" style="float: right;" onclick="normalizar<?php echo $NumWindow; ?>('<?php echo $row["Codigo_HCC"]; ?>');">Normalizar Valores <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
	  				<?php
	  					} 
	  				?>
	  				<div class="row well well-sm">
	  			<?php

			  			$SQL="Select * from hccampos where Codigo_HCT='".$_GET["FormatoHC"]."' and Grupo_HCC='".$row["Orden_HCC"]."' Order By Orden_HCC;";
						$resultx = mysqli_query($conexion, $SQL);
						while($rowx = mysqli_fetch_array($resultx)) {
							if ($rowx["Obligatorio_HCC"]=="1") {
								$rekerido="required";
							} else {
								$rekerido="";
							}
							switch ($rowx["Tipo_HCC"]) {
								//image
								case 'image':
			  			?>
							<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">

						<div class="row">
						  <div class="col-md-12">
						    <a href="#" class="thumbnail">
						      <img id="img_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" name="img_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" data-src="holder.js/300x200" alt="" style="height: <?php echo $rowx["Lineas_HCC"]; ?>px; width: 100%; display: block;">
							  <input name="file-input<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" id="file-input<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" type="file" onchange="addImage<?php echo $NumWindow; ?>(event, 'img_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>');" />
						    </a>
						  </div>
						</div>

							</div>
			  			<?php
			  					break;
			  					//check box
								case 'check':
			  			?>
							<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">

						<div class="checkbox checkbox-success">
							<input name="chk_x<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" id="chk_x<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:chekear<?php echo $NumWindow; ?>('<?php echo $rowx["Codigo_HCC"]; ?>');" class="styled" <?php echo(str_replace('.WINDOW.',$NumWindow,$rowx["Parametros_HCC"])); ?> <?php echo $rekerido; ?>>
							<label for="chk_x<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>"><?php echo $rowx["Etiqueta_HCC"]; ?></label>
						</div>
						<input name="hdn_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" type="hidden" id="hdn_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" value="0" />

							</div>
			  			<?php
			  					break;
			  					//text box
								case 'text':
			  			?>
			  				<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">
						<div class="form-group" id="grp_txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>">
							<label for="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>"><?php echo $rowx["Etiqueta_HCC"]; ?></label>
							<?php 
							$hcdefecto=trim($rowx["Defecto_HCC"]);
							if ($hcdefecto!="") {
								echo '
								<input name="hdn_nrmltxt_'.$rowx["Codigo_HCC"].$NumWindow.'" type="hidden" id="hdn_nrmltxt_'.$rowx["Codigo_HCC"].$NumWindow.'" value="'.$hcdefecto.'" />
								';
								$hcdefecto=$ClassNormal;
							}
							?>
							<input name="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" id="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" type="text" value="" class="<?php echo $hcdefecto; ?>" maxlength="<?php echo $rowx["Maximo_HCC"]; ?>" <?php echo(str_replace('.WINDOW.',$NumWindow,$rowx["Parametros_HCC"])); ?> <?php echo $rekerido; ?> />
						</div>
							</div>
			  			<?php
			  					break;
			  					// text area
			  					case "textarea":
			  			?>
			  				<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">
						<div class="form-group" id="grp_txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>">
							<label for="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>"><?php echo $rowx["Etiqueta_HCC"]; ?></label>
							<?php 
							$hcdefecto=trim($rowx["Defecto_HCC"]);
							if ($hcdefecto!="") {
								echo '
								<input name="hdn_nrmltxt_'.$rowx["Codigo_HCC"].$NumWindow.'" type="hidden" id="hdn_nrmltxt_'.$rowx["Codigo_HCC"].$NumWindow.'" value="'.$hcdefecto.'" />
								';
								$hcdefecto=$ClassNormal;
							}
							?>
							<textarea class="form-control <?php echo $hcdefecto; ?>" rows="<?php echo $rowx["Lineas_HCC"]; ?>" id="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" name="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" maxlength="<?php echo $rowx["Maximo_HCC"]; ?>" <?php echo $rekerido; ?> <?php echo(str_replace('.WINDOW.',$NumWindow,$rowx["Parametros_HCC"])); ?>></textarea>
						</div>
							</div>
						<?php
			  					break;
			  					// Select
			  					case "select":
			  			?>
							<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">
						<div class="form-group" id="grp_cmb_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>">
							<label for="cmb_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>"><?php echo $rowx["Etiqueta_HCC"]; ?></label>
							<select name="cmb_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" id="cmb_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" <?php echo $rekerido; ?> <?php echo(str_replace('.WINDOW.',$NumWindow,$rowx["Parametros_HCC"])); ?>>
							<?php 
						$SQL="Select Valor_HCC, Texto_HCC, Orden_HCC, Seleccionado_HCC, Comando_HCC from hccamposlistas Where Codigo_HCT='".$_GET["FormatoHC"]."' and Codigo_HCC='".$rowx["Codigo_HCC"]."' Order by 3";
						$resultlx = mysqli_query($conexion, $SQL);
						while($rowlx = mysqli_fetch_array($resultlx)) 
							{
								$sel="";
								if ($rowlx["Seleccionado_HCC"]=="1") {
									$sel=' selected="selected" ';
								}
						 ?>
						  <option value="<?php echo $rowlx[0]; ?>" <?php echo $sel; echo($rowlx["Comando_HCC"]); ?>  ><?php echo ($rowlx[1]); ?></option>
						<?php
							}
						mysqli_free_result($resultlx); 
								
						 ?>  
							</select>
						</div>
							</div>	  			
				<?php
								break;
							}
						}
	  					mysqli_free_result($resultx);
	  			?>
	  				</div>
	  			</div>
	  			<?php
	  					break;
	  				}
	  			}
	  			mysqli_free_result($result);

	  		   // Odontograma
	  			if ($OdontogramaHCT=="1") {
	  			?>
	  			<div id="divodonto<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> ODONTOGRAMA</label>
	  				<div class="row well well-sm">
	  					<div class="col-md-9">
	  					<canvas >
	  						
	  					</canvas>

	  					</div>
	  					<div class="col-md-3">
	  						<div id="zero_detallodonto<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallodonto<?php echo $NumWindow; ?>" >
								<tbody id="tbodonto<?php echo $NumWindow; ?>">
								<tr id="trhodontoX'.$NumWindow.'"> 
									<th colspan="2" id="th1odontoX'.$NumWindow.'"># Diente</th> 
									<th id="th2odontoX'.$NumWindow.'">Descripción</th> 
									<th id="th5odontoX'.$NumWindow.'">X</th> 
								</tr> 

								</tbody>
								</table><input name="hdn_controwodonto<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwodonto<?php echo $NumWindow; ?>" value="0" />
							</div>
	  					</div>
	  				</div>
	  			</div>
	  			<?php
	  			}
	  		   // Imagenes Diagnosticas y Laboratorios
		  		if ($AyudasDiagHCT=="1") {
		  		?>
		  		<div id="divhlpdx<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Paraclínicos</label>
	  				<div class="row well well-sm">
	  					<div class="col-md-2">
						    <div class="form-group">
								<label for="txt_codserdx<?php echo $NumWindow; ?>">Código</label>
								<div class="input-group">	
									<input name="txt_codserdx<?php echo $NumWindow; ?>" id="txt_codserdx<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarCodServDx<?php echo $NumWindow; ?>(event);" onblur="CodServDxOnBlur<?php echo $NumWindow; ?>()" />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="MedicaHC" onclick="javascript:CargarSearch('ServiciosX1', 'txt_codserdx<?php echo $NumWindow; ?>', 'Codigo_CFC=*02*');"><i class="fas fa-search"></i></button>
									</span>
								</div>
							</div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
								<label for="txt_serviciodx<?php echo $NumWindow; ?>">Servicio</label>
								<input  name="txt_serviciodx<?php echo $NumWindow; ?>" id="txt_serviciodx<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_cantservdx<?php echo $NumWindow; ?>">Cantidad</label>
								<input  name="txt_cantservdx<?php echo $NumWindow; ?>" id="txt_cantservdx<?php echo $NumWindow; ?>" type="text" value="1"/>
							</div>			
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="txt_obsserdx<?php echo $NumWindow; ?>">Observaciones</label>
								<div class="input-group">	
									<input name="txt_obsserdx<?php echo $NumWindow; ?>" id="txt_obsserdx<?php echo $NumWindow; ?>" type="text"  />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal"  data-whatever="AddMedicaHC" onclick="javascript:AddHelpDx<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i></button>
									</span>
								</div>
							</div>			
						</div>
						
						<div class="col-md-12">
						  	<div id="zero_detallehlpdx<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallehlpdx<?php echo $NumWindow; ?>" >
								<tbody id="tbhlpdx<?php echo $NumWindow; ?>">
								<tr id="trhhlpdxX'.$NumWindow.'"> 
									<th id="th1hlpdxX'.$NumWindow.'">Codigo</th> 
									<th id="th2hlpdxX'.$NumWindow.'">Servicio</th> 
									<th id="th3hlpdxX'.$NumWindow.'">Cantidad</th> 
									<th id="th4hlpdxX'.$NumWindow.'">Observaciones</th> 
									<th id="th5hlpdxX'.$NumWindow.'">Eliminar</th> 
								</tr> 

								</tbody>
								</table><input name="hdn_controwhlpdx<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwhlpdx<?php echo $NumWindow; ?>" value="0" />
							</div>
						</div>
	  				</div>
	  			</div>
		  		<?php
		  		}

		  	   // Medicamentos
		  		if ($MedHCT=="1") {
		  		?>
	  			<div id="divttmnto<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Ordenes de Medicamentos</label>
	  				<div class="row well well-sm">

						<div class="col-md-1">
						    <div class="form-group">
								<label for="txt_codmed<?php echo $NumWindow; ?>">Código</label>
								<div class="input-group">	
									<input name="txt_codmed<?php echo $NumWindow; ?>" id="txt_codmed<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarCodMed<?php echo $NumWindow; ?>(event);" onblur="CodMedOnBlur<?php echo $NumWindow; ?>()" />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="MedicaHC" onclick="javascript:CargarSearch('ServiciosX2', 'txt_codmed<?php echo $NumWindow; ?>', 'Codigo_CFC<>*09*');"><i class="fas fa-search"></i></button>
									</span>
								</div>
							</div>
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="txt_medicamento<?php echo $NumWindow; ?>">Medicamento</label>
								<input  name="txt_medicamento<?php echo $NumWindow; ?>" id="txt_medicamento<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_dosis<?php echo $NumWindow; ?>">Dosis</label>
								<input  name="txt_dosis<?php echo $NumWindow; ?>" id="txt_dosis<?php echo $NumWindow; ?>" type="text"  onchange="javascript:CantidadMed<?php echo $NumWindow; ?>();"/>
								<input  name="hdn_dosish<?php echo $NumWindow; ?>" id="hdn_dosish<?php echo $NumWindow; ?>" type="hidden" value="0"/>
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_unidad<?php echo $NumWindow; ?>">Unidad</label>
								<select name="cmb_unidad<?php echo $NumWindow; ?>" id="cmb_unidad<?php echo $NumWindow; ?>" >
							<?php 
								$SQL="Select Codigo_UNM, Sigla_UNM from gxunidadmed Order by 1";
								$resultlx = mysqli_query($conexion, $SQL);
								while($rowlx = mysqli_fetch_array($resultlx)) 
								{
							?>
						  			<option value="<?php echo $rowlx[0]; ?>" ><?php echo ($rowlx[1]); ?></option>
							<?php
								}
								mysqli_free_result($resultlx); 
						 	?>  
								</select>
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_via<?php echo $NumWindow; ?>">Vía</label>
								<select name="cmb_via<?php echo $NumWindow; ?>" id="cmb_via<?php echo $NumWindow; ?>" >
							<?php 
								$SQL="Select Codigo_VIA, Descripcion_VIA from gxviasmed Order by 2";
								$resultlx = mysqli_query($conexion, $SQL);
								while($rowlx = mysqli_fetch_array($resultlx)) 
								{
							?>
						  			<option value="<?php echo $rowlx[0]; ?>" ><?php echo ($rowlx[1]); ?></option>
							<?php
								}
								mysqli_free_result($resultlx); 
						 	?>  
								</select>
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_frecuencia<?php echo $NumWindow; ?>">Frecuencia</label>
								<select name="cmb_frecuencia<?php echo $NumWindow; ?>" id="cmb_frecuencia<?php echo $NumWindow; ?>"  onchange="javascript:CantidadMed<?php echo $NumWindow; ?>();">
							<?php 
								$SQL="Select Codigo_FRC, Descripcion_FRC from gxfrecuenciamed Order by 1";
								$resultlx = mysqli_query($conexion, $SQL);
								while($rowlx = mysqli_fetch_array($resultlx)) 
								{
							?>
						  			<option value="<?php echo $rowlx[0]; ?>" ><?php echo ($rowlx[1]); ?></option>
							<?php
								}
								mysqli_free_result($resultlx); 
						 	?>  
								</select>
							</div>			
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_duracion<?php echo $NumWindow; ?>">Durante</label>
								<input  name="txt_duracion<?php echo $NumWindow; ?>" id="txt_duracion<?php echo $NumWindow; ?>" type="text" value="1"  onchange="javascript:CantidadMed<?php echo $NumWindow; ?>();"/>
							</div>			
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_tiempo<?php echo $NumWindow; ?>">_ </label>
								<select name="cmb_tiempo<?php echo $NumWindow; ?>" id="cmb_tiempo<?php echo $NumWindow; ?>" onchange="javascript:CantidadMed<?php echo $NumWindow; ?>();" >
									<option value="1" >Hora(s)</option>
									<option value="24" >Día(s)</option>
									<option value="720" >Mes(es)</option>
								</select>
							</div>			
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_cantmed<?php echo $NumWindow; ?>">Cantidad</label>
								<input  name="txt_cantmed<?php echo $NumWindow; ?>" id="txt_cantmed<?php echo $NumWindow; ?>" type="text" value="1"/>
							</div>			
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="txt_obsmed<?php echo $NumWindow; ?>">Observaciones</label>
								<div class="input-group">	
									<input name="txt_obsmed<?php echo $NumWindow; ?>" id="txt_obsmed<?php echo $NumWindow; ?>" type="text"  />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal"  data-whatever="AddMedicaHC" onclick="javascript:AddMedica<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i></button>
									</span>
								</div>
							</div>			
						</div>
						
						<div class="col-md-12">
						  	<div id="zero_detalleMed<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleMed<?php echo $NumWindow; ?>" >
								<tbody id="tbMedX<?php echo $NumWindow; ?>">
								<tr id="trhmX'.$NumWindow.'"> 
									<th id="th2mX'.$NumWindow.'">Medicamento</th> 
									<th id="th3mX'.$NumWindow.'">Dosis</th> 
									<th id="th4mX'.$NumWindow.'">Vía</th> 
									<th id="th5mX'.$NumWindow.'">Frecuencia</th> 
									<th id="th6mX'.$NumWindow.'">Duración</th>
									<th id="th6mX'.$NumWindow.'">Cantidad</th> 
									<th id="th7mX'.$NumWindow.'">Observaciones</th> 
									<th id="th8mX'.$NumWindow.'">Estado</th> 
								</tr> 
								<?php 
								$filasMed=0;
								if (isset($_GET["Historia"])) {
									$SQL="Select MedicIntraHosp_ARE from gxareas Where Codigo_ARE='".$_GET["Area"]."'";
									$resultarea = mysqli_query($conexion, $SQL);
									if ($rowarea = mysqli_fetch_array($resultarea)) {
										if ($rowarea[0]=="1") {
											if (trim($_GET["Historia"])!="") {
												$SQL="Select a.Codigo_SER, b.Nombre_MED, a.Dosis_HCM, a.Via_HCM, c.Descripcion_VIA, a.Frecuencia_HCM, d.Descripcion_FRC, a.Duracion_HCM, a.Cantidad_HCM, a.Observaciones_HCM From hcordenesmedica a, gxmedicamentos b, gxviasmed c, gxfrecuenciamed d, czterceros e Where e.Codigo_TER=a.Codigo_TER and a.Codigo_SER=b.Codigo_SER and c.Codigo_VIA=b.Codigo_VIA and d.Codigo_FRC=a.Frecuencia_HCM and a.Estado_HCM<>'X' and e.ID_TER='".$_GET["Historia"]."'  and a.Codigo_HCF in (Select max(x.Codigo_HCF) From hcordenesmedica x, czterceros y Where y.Codigo_TER=x.Codigo_TER and y.ID_TER='".$_GET["Historia"]."')";
												$resultm = mysqli_query($conexion, $SQL);
												while($rowm = mysqli_fetch_array($resultm)) {
													$filasMed=$filasMed+1;
													echo '<tr id="trmedx'.$filasMed.$NumWindow.'">
													<td><input name="hdn_codmed'.$filasMed.$NumWindow.'" type="hidden" id="hdn_codmed'.$filasMed.$NumWindow.'" value="'.$rowm[0].'"> '.$rowm[1].'</td>
													<td><input name="hdn_dosis'.$filasMed.$NumWindow.'" type="hidden" id="hdn_dosis'.$filasMed.$NumWindow.'" value="'.$rowm[2].'"> '.$rowm[2].'</td>
													<td><input name="hdn_via'.$filasMed.$NumWindow.'" type="hidden" id="hdn_via'.$filasMed.$NumWindow.'" value="'.$rowm[3].'"> '.$rowm[4].'</td>
													<td><input name="hdn_frecuencia'.$filasMed.$NumWindow.'" type="hidden" id="hdn_frecuencia'.$filasMed.$NumWindow.'" value="'.$rowm[5].'"> '.$rowm[6].'</td>
													<td><input name="hdn_duracion'.$filasMed.$NumWindow.'" type="hidden" id="hdn_duracion'.$filasMed.$NumWindow.'" value="'.$rowm[7].'"> '.$rowm[7].'</td>
													<td><input name="hdn_cantmed'.$filasMed.$NumWindow.'" type="hidden" id="hdn_cantmed'.$filasMed.$NumWindow.'" value="'.$rowm[8].'"> '.$rowm[8].'</td>
													<td><input name="hdn_obsmed'.$filasMed.$NumWindow.'" type="hidden" id="hdn_obsmed'.$filasMed.$NumWindow.'" value="'.$rowm[9].'"> '.$rowm[9].'</td>
													<td><select class="form-control" id="cmb_estadomed'.$filasMed.$NumWindow.'" name="cmb_estadomed'.$filasMed.$NumWindow.'"><option value="O" selected>Ordenado</option><option value="X">Suspender</option></select></td>
													</tr>';
												}
												mysqli_free_result($resultm); 
											}
										}
									}
								}
								?>
								</tbody> 
								</table><input name="hdn_controwMed<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwMed<?php echo $NumWindow; ?>" value="<?php echo $filasMed; ?>" />
							</div>
						</div>
	  				</div>
	  			</div>
		  		<?php	
		  		}

		  		// Ordenes de Servicio
		  		if ($OrdenesHCT=="1") {
		  		?>
	  			<div id="divttmnto<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Ordenes de Servicio</label>
	  				<div class="row well well-sm">

						<div class="col-md-3">
							<div class="form-group">
								<label for="cmb_tipot<?php echo $NumWindow; ?>">Tipo </label>
								<select name="cmb_tipot<?php echo $NumWindow; ?>" id="cmb_tipot<?php echo $NumWindow; ?>" >
									<option value="Visita Médica" >VISITA MEDICA</option>
						  			<option value="Terapia Física" >TERAPIA FISICA</option>
						  			<option value="Terapia Respiratoria" >TERAPIA RESPIRATORIA</option>
						  			<option value="Terapia Ocupacional" >TERAPIA OCUPACIONAL</option>
						  			<option value="Fonoaudiología" >FONOAUDIOLOGIA</option>
						  			<option value="Valoración por Nutrición" >VALORACION NUTRICION</option>
						  			<option value="Valoración por Psicología" >VALORACION PSICOLOGIA</option>
						  			<option value="Aplicación de Medicamentos" >APLICACION MEDICAMENTOS</option>
						  			<option value="Curaciones I y II" >CURACIONES I Y II</option>
						  			<option value="Curaciones III y IV" >CURACIONES III Y IV</option>
						  			<option value="Procedimientos" >PROCEDIMIENTOS</option>
						  			<?php
						  			$SQL="Select concat('VALORACIÓN POR ',Nombre_ESP), Nombre_ESP  From gxespecialidades Where Estado_ESP='1' Order By 2";
						  			$resultmx = mysqli_query($conexion, $SQL);
									while($rowmx = mysqli_fetch_array($resultmx)) {
										echo '
										<option value="'.$rowmx[0].'" >'.$rowmx[1].'</option>
										';
									}
									mysqli_free_result($resultmx);		
						  			?>
								</select>
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_frecuenciat<?php echo $NumWindow; ?>">Frecuencia</label>
								<select name="cmb_frecuenciat<?php echo $NumWindow; ?>" id="cmb_frecuenciat<?php echo $NumWindow; ?>" onchange="javascript:CantidadServ<?php echo $NumWindow; ?>();">
							<?php 
								$SQL="Select Codigo_FRC, Descripcion_FRC, Orden_FRC from gxfrecuenciaserv Order by 3";
								$resultlx = mysqli_query($conexion, $SQL);
								while($rowlx = mysqli_fetch_array($resultlx)) 
								{
							?>
						  			<option value="<?php echo $rowlx[0]; ?>" ><?php echo ($rowlx[1]); ?></option>
							<?php
								}
								mysqli_free_result($resultlx); 
						 	?>  
								</select>
							</div>			
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_duraciont<?php echo $NumWindow; ?>">Durante</label>
								<input  name="txt_duraciont<?php echo $NumWindow; ?>" id="txt_duraciont<?php echo $NumWindow; ?>" type="text" value="1" onchange="javascript:CantidadServ<?php echo $NumWindow; ?>();"/>
							</div>			
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_tiempot<?php echo $NumWindow; ?>">_ </label>
								<select name="cmb_tiempot<?php echo $NumWindow; ?>" id="cmb_tiempot<?php echo $NumWindow; ?>" onchange="javascript:CantidadServ<?php echo $NumWindow; ?>();">
									<option value="1" >Día(s)</option>
									<option value="7" >Semana(s)</option>
									<option value="30" >Mes(es)</option>
								</select>
							</div>			
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_cantt<?php echo $NumWindow; ?>">Cantidad</label>
								<input name="txt_cantt<?php echo $NumWindow; ?>" id="txt_cantt<?php echo $NumWindow; ?>" type="text"  value="1" />
							</div>			
						</div>
						
						<div class="col-md-5">
							<div class="form-group">
								<label for="txt_obster<?php echo $NumWindow; ?>">Observaciones</label>
								<div class="input-group">	
									<input name="txt_obster<?php echo $NumWindow; ?>" id="txt_obster<?php echo $NumWindow; ?>" type="text"  />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal"  data-whatever="AddServicioHC" onclick="javascript:AddServicio<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i></button>
									</span>
								</div>
							</div>			
						</div>
						
						<div class="col-md-12">
						  	<div id="zero_detalleTer<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleTer<?php echo $NumWindow; ?>" >
								<tbody id="tbTerX<?php echo $NumWindow; ?>">
								<tr id="trhtsX'.$NumWindow.'"> 
									<th id="th1tsX'.$NumWindow.'">Tipo</th> 
									<th id="th2tsX'.$NumWindow.'">Frecuencia</th> 
									<th id="th3tsX'.$NumWindow.'">Duración</th> 
									<th id="th4tsX'.$NumWindow.'">Cantidad</th> 
									<th id="th5tsX'.$NumWindow.'">Observaciones</th> 
									<th id="th6tsX'.$NumWindow.'">Eliminar</th> 
								</tr> 

								</tbody>
								</table><input name="hdn_controwTer<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwTer<?php echo $NumWindow; ?>" value="0" />
							</div>
						</div>
	  				</div>
	  			</div>
		  		<?php	
		  		}

		  	   // Indicaciones y Tratamiento
		  		if ($IndicacionesHCT=="1") {
		  		?>
	  			<div id="divttmnto<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Indicaciones y Tratamiento</label>
	  				<div class="row well well-sm">

						<div class="col-md-12">
						    <div class="input-group">
						      <input type="text" class="form-control" placeholder="Digite la indicación y agréguela al listado" maxlength="200" id="txt_indicaciones<?php echo $NumWindow; ?>" name="txt_indicaciones<?php echo $NumWindow; ?>" onkeypress="ClickTabla<?php echo $NumWindow; ?>(event);">
						      <span class="input-group-btn">
						        <button class="btn btn-success" type="button" onclick="AgregarFilaTto<?php echo $NumWindow; ?>(document.getElementById('txt_indicaciones<?php echo $NumWindow; ?>').value);">Agregar</button>
						      </span>
						    </div><!-- /input-group -->
						  </div>
						  <div class="col-md-12">
						  	<div id="zero_detalleTto<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleTto<?php echo $NumWindow; ?>" >
								<tbody id="tbTtmntoX<?php echo $NumWindow; ?>">
								<tr id="trhtX'.$NumWindow.'"> 
									<th id="th1tX'.$NumWindow.'">Indicación</th> 
									<th id="th2tX'.$NumWindow.'">X</th> 
								</tr> 

								</tbody>
								</table><input name="hdn_controwTto<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwTto<?php echo $NumWindow; ?>" value="0" />
							</div>
						  </div>

	  				</div>
	  			</div>
		  		<?php
		  		}
		  	   // Adjuntar Imágenes
		  		if ($ImgHCT=="1") {

		  		}
		  	   // Cargar imagen a pantalla completa
		  		if ($ImgHCT=="2") {
		  			
		  		}
		  	   // Seleccionar Médico 2
				if ($Medico2HCT=="1") {

				}
			?>
	  		</div>
			<?php
	  		} else {
	  		 echo '
	  		<label class="label label-default"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> H.C.</label>
	  		<div class="row well well-sm">
	  			Seleccione el formato de historia clínica a diligenciar en el botón [+ Nuevo Folio]
	  		</div>'; 
	  		} 
	  		?>
 		</div>
</div>

</form>

<script >

<?php
	if (isset($_GET["Cita"])) {
		$SQL="Select Codigo_ARE from gxcitasmedicas a, gxagendacab b Where a.Codigo_AGE=b.Codigo_AGE and Codigo_CIT='".$_GET["Cita"]."'";
		$resultvf = mysqli_query($conexion, $SQL);
		if($rowvf = mysqli_fetch_array($resultvf)) {
			echo "
			document.getElementById('cmb_area".$NumWindow."').value = '".$rowvf[0]."';
			";
		}
		mysqli_free_result($resultvf); 
	}
	if (isset($_GET["Area"])) {
		echo "document.getElementById('cmb_area".$NumWindow."').value = '".$_GET["Area"]."';";
	}
	if (isset($_GET["Historia"])) {
		if (trim($_GET["Historia"])!="") {
			$SQL="Select a.Codigo_TER, b.Nombre_TER, c.Codigo_ADM, e.Nombre_TER, f.Nombre_PLA, g.Nombre_RNG, a.fechanac_pac, a.Codigo_SEX, a.EstCivil_PAC, b.direccion_ter, b.telefono_ter, a.Actividad_PAC, c.Acudiente_ADM, c.Parentesco_ADM, c.Telefono_ADM, h.Descripcion_ADM, c.Observaciones_ADM, left(Fecha_ADM,10), c.Autorizacion_ADM, c.Codigo_EPS, c.Codigo_PLA, Nombre_PTT from gxpacientestipos z, gxpacientes a, czterceros b, gxadmision c, gxeps d, czterceros e, gxplanes f, gxrangosalario g, gxtipoingreso h where z.Codigo_PTT=c.Codigo_PTT and h.Tipo_ADM=c.Ingreso_ADM and g.Codigo_RNG=a.Codigo_RNG and f.codigo_pla=c.codigo_pla and d.codigo_eps=c.codigo_eps and d.codigo_ter=e.codigo_ter and a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=a.Codigo_TER and c.Estado_ADM='F' and b.ID_TER='".$_GET["Historia"]."' order by fecha_adm desc limit 1";
			$result = mysqli_query($conexion, $SQL);
			echo "
				document.frm_form".$NumWindow.".txt_idhc".$NumWindow.".value='".$_GET["Historia"]."';";
			if($row = mysqli_fetch_array($result)) {
			echo "
				document.getElementById('spn_contrato".$NumWindow."').innerHTML = '".$row[3]."';
				document.getElementById('spn_plan".$NumWindow."').innerHTML = '".$row[4]."';
				document.getElementById('spn_rango".$NumWindow."').innerHTML = '".$row[5]."';
				document.getElementById('spn_fechanac".$NumWindow."').innerHTML = '".formatofecha($row[6])."';
				document.getElementById('spn_edad".$NumWindow."').innerHTML = '".edad($row[6])."';
				document.getElementById('spn_sexo".$NumWindow."').innerHTML = '".$row[7]."';
				document.getElementById('spn_estcivil".$NumWindow."').innerHTML = '".$row[8]."';
				document.getElementById('spn_direccion".$NumWindow."').innerHTML = '".$row[9]."';
				document.getElementById('spn_telefono".$NumWindow."').innerHTML = '".$row[10]."';
				document.getElementById('spn_ocupacion".$NumWindow."').innerHTML = '".$row[11]."';
				document.getElementById('spn_acomp".$NumWindow."').innerHTML = '".$row[12]."';
				document.getElementById('spn_parentesco".$NumWindow."').innerHTML = '".$row[13]."';
				document.getElementById('spn_telacomp".$NumWindow."').innerHTML = '".$row[14]."';
				document.getElementById('spn_ingpor".$NumWindow."').innerHTML = '".$row[15]."';
				document.getElementById('spn_tipopte".$NumWindow."').innerHTML = '".$row["Nombre_PTT"]."';
				document.getElementById('spn_obs".$NumWindow."').innerHTML = '".preg_replace("/\r\n|\n|\r/", "<br/>",$row[16])."';
				document.getElementById('spn_fechaing".$NumWindow."').innerHTML = '".formatofecha($row[17])."';
				document.getElementById('hdn_autorizacion".$NumWindow."').value = '".$row[18]."';
				document.getElementById('hdn_contrato".$NumWindow."').value = '".$row[19]."';
				document.getElementById('hdn_plan".$NumWindow."').value = '".$row[20]."';
				document.getElementById('hdn_codigoter".$NumWindow."').value = '".$row[0]."';
				document.getElementById('txt_paciente".$NumWindow."').value = '".$row[1]."';
				document.getElementById('txt_ingreso".$NumWindow."').value = '".$row[2]."';
				";
			}
			else {
				echo "
				MsgBox1('Historia Clínica','No se encuentran datos para la H.C. ".$_GET["Historia"]." o no posee ingresos facturados.');
			document.frm_form".$NumWindow.".cmb_area".$NumWindow.".focus();
				";
			}
			mysqli_free_result($result); 
		}
	}
	else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function selecthc<?php echo $NumWindow; ?>(CodigoHCT) {
	AbrirForm('application/forms/hc_facturado.php', '<?php echo $NumWindow; ?>', '&FormatoHC='+CodigoHCT+'&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value+'&Area='+document.getElementById('cmb_area<?php echo $NumWindow; ?>').value);
}

function BuscarHCPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/hc_facturado.php', '<?php echo $NumWindow; ?>', '&FormatoHC='+document.getElementById('hdn_formatohc<?php echo $NumWindow; ?>').value+'&Area='+document.getElementById('cmb_area<?php echo $NumWindow; ?>').value);
	} else {
		AbrirForm('application/forms/hc_facturado.php', '<?php echo $NumWindow; ?>', '&FormatoHC='+document.getElementById('hdn_formatohc<?php echo $NumWindow; ?>').value+'&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value+'&Area='+document.getElementById('cmb_area<?php echo $NumWindow; ?>').value);
	}  
  }
}

function HCPteOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value!="") {
		AbrirForm('application/forms/hc_facturado.php', '<?php echo $NumWindow; ?>', '&FormatoHC='+document.getElementById('hdn_formatohc<?php echo $NumWindow; ?>').value+'&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value+'&Area='+document.getElementById('cmb_area<?php echo $NumWindow; ?>').value);
	}
}

<?php
	$SQL="Select a.* from hcsv2 a, hcsv3 b where a.Codigo_HSV=b.Codigo_HSV and Codigo_SV1='".$SVHCT."' and Calculo_HSV<>'' order by Orden_HSV";
	$resultz = mysqli_query($conexion, $SQL);
	while($rowz = mysqli_fetch_array($resultz)) {
?>
function calc_sv<?php echo $rowz["Codigo_HSV"].$NumWindow; ?>() {
	valorsv="0";
	<?php
		$SQL="Select Codigo_HSV from hcsv2 where Vinculado_HSV='".$rowz["Codigo_HSV"]."' and Activo_HSV='1' Order by Codigo_HSV";
		$resultxz = mysqli_query($conexion, $SQL);
		while($rowxz = mysqli_fetch_array($resultxz)) {
			echo '
			var clases'.$rowxz["Codigo_HSV"].' = document.getElementsByClassName("sv_'.$rowxz["Codigo_HSV"].$NumWindow.'");
			variable'.$rowxz["Codigo_HSV"].' = clases'.$rowxz["Codigo_HSV"].'[0].value;
			';

		}
		mysqli_free_result($resultxz); 
		$calcularsv=$rowz["Calculo_HSV"];
		$calcularsv=str_replace('{','variable',$calcularsv);
		$calcularsv=str_replace('}','',$calcularsv);
		
	?>
	
	valorsv=<?php echo $calcularsv; ?>;


	var clasesIMC = document.getElementsByClassName("sv_<?php echo $rowz["Codigo_HSV"].$NumWindow; ?>");
	if (isFinite(valorsv)==false) {
		valorsv="";
	}
	else {
		valorsv=parseFloat(Math.round(valorsv * 100) / 100).toFixed(2);
	}

	clasesIMC[0].value=valorsv;
	
}
<?php
	}
	mysqli_free_result($resultz); 
?>

function AddAnt<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_antecdentext<?php echo $NumWindow; ?>').value=="") {
		xError="Digite descripcion del antecedente";
	}
	if (xError=="") {
		TotalFilas=document.getElementById("hdn_controwantX<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tblDetalleantX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trant"+TotalFilas+"<?php echo $NumWindow; ?>";
		TipoAnte=document.getElementById('cmb_cmbant<?php echo $NumWindow; ?>').value;
		var combo = document.getElementById('cmb_cmbant<?php echo $NumWindow; ?>');
		var TextAnte = combo.options[combo.selectedIndex].text;
		DescrpAnte=document.getElementById('txt_antecdentext<?php echo $NumWindow; ?>').value;
		DescrpAnte=DescrpAnte.toUpperCase();
		celda1.innerHTML = '<input name="hdn_tantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_tantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+TipoAnte+'" /> '+TextAnte; 
		celda2.innerHTML = '<input name="hdn_dantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_dantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+DescrpAnte+''+'" /> '+DescrpAnte; 
		celda3.innerHTML = '<input name="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" value="O" /> <button onclick="EliminarFilaAnt<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
		fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwantX<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('cmb_cmbant<?php echo $NumWindow; ?>').focus();
		document.getElementById("txt_antecdentext<?php echo $NumWindow; ?>").value="";
	}
	
}

function EliminarFilaAnt<?php echo $NumWindow; ?>(Numero) {
	var miTabla = document.getElementById("tblDetalleantX<?php echo $NumWindow; ?>");     
    $('#trant'+Numero+"<?php echo $NumWindow; ?>").remove();
}

<?php 
	//Medicamentos
	if ($MedHCT=="1") {
?>
function CantidadMed<?php echo $NumWindow; ?>() {
	Frecx=document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').value;
	if (Frecx=="0") {
		document.getElementById('txt_cantmed<?php echo $NumWindow; ?>').value="1";
	} else {
		if (Frecx=="99") {
			document.getElementById('txt_cantmed<?php echo $NumWindow; ?>').value="1";
		} else {
			Duracx=document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value;
			Durac2x=document.getElementById('cmb_tiempo<?php echo $NumWindow; ?>').value;
			Dosisx=document.getElementById('txt_dosis<?php echo $NumWindow; ?>').value;
			Dosis2x=document.getElementById('hdn_dosish<?php echo $NumWindow; ?>').value;
			if (Dosis2x=="0") {
				document.getElementById('hdn_dosish<?php echo $NumWindow; ?>').value=Dosisx;
			}
			CantMedx=Duracx*(Durac2x/Frecx)*(Dosisx/Dosis2x);
			CantMedx=Math.round(CantMedx);
			/* alert(Duracx+'*('+Durac2x+'/'+Frecx+')*('+Dosisx+'/'+Dosis2x+')'); */
			document.getElementById('txt_cantmed<?php echo $NumWindow; ?>').value=CantMedx;
		}
	}
}

function CodMedOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value!="") {
		NombreMedicamento(document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');
	} else {
		document.getElementById('txt_medicamento<?php echo $NumWindow; ?>').value = '';
	}
}

function EliminarFilaMed<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalle<?php echo $NumWindow; ?>");     
    $('#trmed'+Numero+"<?php echo $NumWindow; ?>").remove();
}  

function AddMedica<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione la duracion del suministro del medicamento a ordenar";
	}
	if (document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value=="0") {
		xError="Seleccione una duracion del medicamento mayor";
	}
	if (document.getElementById('txt_dosis<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione la dosis del medicamento a ordenar";
	}
	if (document.getElementById('txt_dosis<?php echo $NumWindow; ?>').value=="0") {
		xError="Seleccione una dosis del medicamento mayor";
	}
	if (document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione el medicamento a ordenar";
	}
	if (document.getElementById('txt_medicamento<?php echo $NumWindow; ?>').value=='<SPAN CLASS="ERROR">NO SE ENCUENTRA EL SERVICIO</SPAN>') {
		xError="El codigo no es valido";
	}

	if (xError!="") {
		MsgBox1('Orden de Medicamentos', xError);
	} else {
		TotalFilas=document.getElementById("hdn_controwMed<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbMedX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
	    var celda5 = document.createElement("td"); 
	    var celda6 = document.createElement("td"); 
	    var celda9 = document.createElement("td"); 
	    var celda7 = document.createElement("td"); 
	    var celda8 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trmed"+TotalFilas+"<?php echo $NumWindow; ?>";
		CodMed=document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value;
		Medicamento=document.getElementById('txt_medicamento<?php echo $NumWindow; ?>').value;
		Dosis=document.getElementById('txt_dosis<?php echo $NumWindow; ?>').value+ ' '+document.getElementById('cmb_unidad<?php echo $NumWindow; ?>').options[document.getElementById('cmb_unidad<?php echo $NumWindow; ?>').selectedIndex].text;
		Via=document.getElementById('cmb_via<?php echo $NumWindow; ?>').value;
		Via2=document.getElementById('cmb_via<?php echo $NumWindow; ?>').options[document.getElementById('cmb_via<?php echo $NumWindow; ?>').selectedIndex].text;
		Frec=document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').value;
		Frec2=document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').options[document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').selectedIndex].text;
		Durac=document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value;
	    Durac2=document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value+ ' '+document.getElementById('cmb_tiempo<?php echo $NumWindow; ?>').options[document.getElementById('cmb_tiempo<?php echo $NumWindow; ?>').selectedIndex].text;
	    CantMed=document.getElementById('txt_cantmed<?php echo $NumWindow; ?>').value;
		ObsMed=document.getElementById('txt_obsmed<?php echo $NumWindow; ?>').value;
		celda2.innerHTML = '<input name="hdn_codmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodMed+''+'" /> '+Medicamento; 
		celda3.innerHTML = '<input name="hdn_dosis'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_dosis'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Dosis+''+'" /> '+Dosis; 
		celda4.innerHTML = '<input name="hdn_via'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_via'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Via+''+'" /> '+Via2; 
		celda5.innerHTML = '<input name="hdn_frecuencia'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_frecuencia'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Frec+''+'" /> '+Frec2; 
		celda6.innerHTML = '<input name="hdn_duracion'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_duracion'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Durac2+''+'" /> '+Durac2; 
		celda9.innerHTML = '<input name="hdn_cantmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_cantmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantMed+'" /> '+CantMed; 
		celda7.innerHTML = '<input name="hdn_obsmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_obsmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ObsMed+''+'" /> '+ObsMed; 
		celda8.innerHTML = '<input name="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" value="O" /><button onclick="EliminarFilaMed<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    fila.appendChild(celda4); 
	    fila.appendChild(celda5); 
	    fila.appendChild(celda6); 
	    fila.appendChild(celda9); 
	    fila.appendChild(celda7); 
	    fila.appendChild(celda8); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwMed<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_codmed<?php echo $NumWindow; ?>').focus();
	}
}

<?php 
	}
	//Ayudas Diagnosticas
	if ($AyudasDiagHCT=="1") {
?>

function CodServDxOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').value!="") {
		NombreServicioDx(document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');
	} else {
		document.getElementById('txt_serviciodx<?php echo $NumWindow; ?>').value = '';
	}
}

function EliminarFilaHlpDx<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetallehlpdx<?php echo $NumWindow; ?>");     
    $('#trhlpdx'+Numero+"<?php echo $NumWindow; ?>").remove();
}  

function AddHelpDx<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione el servicio a ordenar";
	}
	if (document.getElementById('txt_serviciodx<?php echo $NumWindow; ?>').value=='<SPAN CLASS="ERROR">NO SE ENCUENTRA EL SERVICIO</SPAN>') {
		xError="El codigo no es valido";
	}

	if (xError!="") {
		MsgBox1('Orden de Servicios Diagnósticos', xError);
	} else {
		TotalFilas=document.getElementById("hdn_controwhlpdx<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbhlpdx<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	     var celda0 = document.createElement("td"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trhlpdx"+TotalFilas+"<?php echo $NumWindow; ?>";
		CodHlpDx=document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').value;
		ServicioDx=document.getElementById('txt_serviciodx<?php echo $NumWindow; ?>').value;
		CantHlpDx=document.getElementById('txt_cantservdx<?php echo $NumWindow; ?>').value;
		ObsHlpDx=document.getElementById('txt_obsserdx<?php echo $NumWindow; ?>').value;
		celda0.innerHTML = '<input name="hdn_codhlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codhlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodHlpDx+''+'" /> '+CodHlpDx; 
		celda1.innerHTML = ' '+ServicioDx; 
		celda2.innerHTML = '<input name="hdn_canthlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_canthlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantHlpDx+'" /> '+CantHlpDx; 
		celda3.innerHTML = '<input name="hdn_obshlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_obshlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ObsHlpDx+''+'" /> '+ObsHlpDx; 
		celda4.innerHTML = '<button onclick="EliminarFilaHlpDx<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
		fila.appendChild(celda0); 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    fila.appendChild(celda4); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwhlpdx<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').focus();
	}
}

<?php 
	}
	//ordenes de Servicio
	if ($OrdenesHCT=="1") {
?>
function CantidadServ<?php echo $NumWindow; ?>() {
	Frec=document.getElementById('cmb_frecuenciat<?php echo $NumWindow; ?>').value;
	Durac=document.getElementById('txt_duraciont<?php echo $NumWindow; ?>').value;
	Durac2=document.getElementById('cmb_tiempot<?php echo $NumWindow; ?>').value;
	CantTer=Frec*Durac*Durac2;
	CantTer=Math.round(CantTer);
	document.getElementById('txt_cantt<?php echo $NumWindow; ?>').value=CantTer;
}

function EliminarFilaServ<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalle<?php echo $NumWindow; ?>");     
    $('#trserv'+Numero+"<?php echo $NumWindow; ?>").remove();
}  


function AddServicio<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_duraciont<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione la duracion del servicio a ordenar";
	}
	if (document.getElementById('txt_duraciont<?php echo $NumWindow; ?>').value=="0") {
		xError="Seleccione una duracion de servicio mayor";
	}
	
	if (xError!="") {
		MsgBox1('Orden de Servicios', xError);
	} else {
		TotalFilas=document.getElementById("hdn_controwTer<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbTerX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda4 = document.createElement("td"); 
	    var celda5 = document.createElement("td"); 
	    var celda6 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda7 = document.createElement("td"); 
	    var celda9 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trserv"+TotalFilas+"<?php echo $NumWindow; ?>";
		Terapiat=document.getElementById('cmb_tipot<?php echo $NumWindow; ?>').value;
		Frec=document.getElementById('cmb_frecuenciat<?php echo $NumWindow; ?>').value;
		Frec2=document.getElementById('cmb_frecuenciat<?php echo $NumWindow; ?>').options[document.getElementById('cmb_frecuenciat<?php echo $NumWindow; ?>').selectedIndex].text;
		Durac=document.getElementById('txt_duraciont<?php echo $NumWindow; ?>').value;
	    Durac2=document.getElementById('txt_duraciont<?php echo $NumWindow; ?>').value+ ' '+document.getElementById('cmb_tiempot<?php echo $NumWindow; ?>').options[document.getElementById('cmb_tiempot<?php echo $NumWindow; ?>').selectedIndex].text;
	    CantTer=document.getElementById('txt_cantt<?php echo $NumWindow; ?>').value;
		ObsTer=document.getElementById('txt_obster<?php echo $NumWindow; ?>').value;
		celda4.innerHTML = '<input name="hdn_tipot'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_tipot'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Terapiat+'" /> '+Terapiat; 
		celda5.innerHTML = '<input name="hdn_frecuenciat'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_frecuenciat'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Frec+''+'" /> '+Frec2; 
		celda6.innerHTML = '<input name="hdn_duraciont'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_duraciont'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Durac+''+'" /> '+Durac2; 
		celda2.innerHTML = '<input name="hdn_cantt'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_cantt'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantTer+''+'" /> '+CantTer; 
		celda7.innerHTML = '<input name="hdn_obster'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_obster'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ObsTer+''+'" /> '+ObsTer; 
		celda9.innerHTML = '<input name="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" value="O" /> <button onclick="EliminarFilaServ<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
		fila.appendChild(celda4); 
	    fila.appendChild(celda5); 
	    fila.appendChild(celda6); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda7); 
	    fila.appendChild(celda9); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwTer<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('cmb_tipot<?php echo $NumWindow; ?>').focus();
	}
}

<?php 
	}
	//Diagnosticos
	if ($DxHCT=="1") {
?>
function HCDxOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_dxppal<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_dxppal<?php echo $NumWindow; ?>').value, document.getElementById('txt_dxppal1<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_dxppal1<?php echo $NumWindow; ?>').value = '';
	}
}

function HCDxR1OnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_dxrel1<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_dxrel1<?php echo $NumWindow; ?>').value, document.getElementById('txt_dxrel11<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_dxrel11<?php echo $NumWindow; ?>').value = '';
	}
}

function HCDxR2OnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_dxrel2<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_dxrel2<?php echo $NumWindow; ?>').value, document.getElementById('txt_dxrel22<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_dxrel22<?php echo $NumWindow; ?>').value = '';
	}
}

function HCDxR3OnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_dxrel3<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_dxrel3<?php echo $NumWindow; ?>').value, document.getElementById('txt_dxrel33<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_dxrel33<?php echo $NumWindow; ?>').value = '';
	}
}
<?php 
	}

	//Indicaciones y Tratamientos
	if ($IndicacionesHCT=="1") {
?>
function ClickTabla<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	AgregarFilaTto<?php echo $NumWindow; ?>(document.getElementById('txt_indicaciones<?php echo $NumWindow; ?>').value);
  }
}
function EliminarFilaTto<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalle<?php echo $NumWindow; ?>");     
    $('#tr'+Numero+"<?php echo $NumWindow; ?>").remove();
}  

function AgregarFilaTto<?php echo $NumWindow; ?>(Indicacion)  {
	if (Indicacion!="") {	
		Indicacion=Indicacion.toUpperCase();
		TotalFilas=document.getElementById("hdn_controwTto<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbTtmntoX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
		TotalFilas++;
		fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
	    celda1.innerHTML = '<input name="hdn_indicacion'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_indicacion'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Indicacion+''+'" /> - '+Indicacion; 
		celda2.innerHTML = '<button onclick="EliminarFilaTto<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwTto<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_indicaciones<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_indicaciones<?php echo $NumWindow; ?>').focus();
	}
}

<?php 
	}
?>

function normalizar<?php echo $NumWindow; ?>(TheClass) {
	var clasesNRML = document.getElementsByClassName("Nrml"+TheClass);
	for (var i=0; i < clasesNRML.length; i++){
		if (document.getElementById(clasesNRML[i].id).value == "") {
			clasesNRML[i].value=document.getElementById('hdn_nrml'+clasesNRML[i].id).value;
		}
	}
}

function chekear<?php echo $NumWindow; ?>(checqbox) {
	tmpchk=document.getElementById("hdn_"+checqbox+"<?php echo $NumWindow; ?>").value;
	if (tmpchk=='1') {
		document.getElementById("hdn_"+checqbox+"<?php echo $NumWindow; ?>").value='0';
	} else {
		document.getElementById("hdn_"+checqbox+"<?php echo $NumWindow; ?>").value='1';
	}
}

function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/hc_facturado.php', '<?php echo $NumWindow; ?>', '');	
}

function addImage<?php echo $NumWindow; ?>(e, imgcontrol){
	var file = e.target.files[0],
	imageType = /image.*/;

	if (!file.type.match(imageType))
	return;

	var reader = new FileReader();
	reader.onload = fileOnload<?php echo $NumWindow; ?>(e, imgcontrol);
	reader.readAsDataURL(file);
}

function fileOnload(e, imgcontrol) {
	var result=e.target.result;
	$('#'+imgcontrol).attr("src",result);
}

<?php 
if ($OdontogramaHCT=="1"){
?>

<?php
}
?>
	HoraActual("txt_hora<?php echo $NumWindow; ?>");

    $("input[type=text]").addClass("form-control");
     $("input[type=time]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

    $("input[type=text]").addClass("hcx_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hcx_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hcx_<?php echo $NumWindow; ?>");
	$("select").addClass("hcx_<?php echo $NumWindow; ?>");
</script>
