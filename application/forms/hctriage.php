<?php
	
	session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" action="functions/php/nexus/uploads.php?route=images&class=terceros&style=profile&wind=<?php echo $NumWindow; ?>" enctype="multipart/form-data" target="upload_target" onreset="HCResetea<?php echo $NumWindow; ?>();">
	<div class="row">
		<div class="col-md-9 ">
			<div class="row well well-sm">
				<input name="hdn_pretriage<?php echo $NumWindow; ?>" type="hidden" id="hdn_pretriage<?php echo $NumWindow; ?>" value="0" />
				<div class="col-md-3">
					<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
						<label for="txt_idhc<?php echo $NumWindow; ?>">Paciente</label>
						<div class="input-group">	
							<input style="font-size:15px;font-weight: bold;" name="txt_idhc<?php echo $NumWindow; ?>" id="txt_idhc<?php echo $NumWindow; ?>" type="text" required onkeypress="BuscarHCPte<?php echo $NumWindow; ?>(event);" onblur="HCPteOnBlur<?php echo $NumWindow; ?>()" />
							<span class="input-group-btn">	
								<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('PacientesHC', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
							</span>
						</div>
						<input name="hdn_codigoter<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoter<?php echo $NumWindow; ?>" value="X" />
					</div>
				</div>
				<div class="col-md-5">
					<div class="form-group">
						<label for="txt_paciente<?php echo $NumWindow; ?>">Nombre</label>
						<input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
					</div>	
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="cmb_modulo<?php echo $NumWindow; ?>">Consultorio</label>
						<select name="cmb_modulo<?php echo $NumWindow; ?>" id="cmb_modulo<?php echo $NumWindow; ?>">
						<?php 
					$SQL="Select Codigo_CNS, Nombre_CNS From gxconsultorios Where Estado_CNS='1' and Triage_CNS='1' Order By Codigo_CNS;";
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
					<div class="row well well-sm">
					<button type="button" class="btn btn-success btn-block" onclick="javascript:llamartrg<?php echo $NumWindow; ?>();">Volver a Llamar <span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span></button>	
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label for="cmb_sexo<?php echo $NumWindow; ?>">Sexo</label>
						<select name="cmb_sexo<?php echo $NumWindow; ?>" id="cmb_sexo<?php echo $NumWindow; ?>">
						<?php 
					$SQL="Select Codigo_SEX, Nombre_SEX From gxtiposexo;";
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
				<div class="col-md-1">
					<div class="form-group" id="grp_txt_hora<?php echo $NumWindow; ?>">
						<label for="txt_edad<?php echo $NumWindow; ?>">Edad</label>
						<input name="txt_edad<?php echo $NumWindow; ?>" id="txt_edad<?php echo $NumWindow; ?>" type="number" min="0" max="120" required value="0"/>
					</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
						<label for="cmb_tipoe<?php echo $NumWindow; ?>">Tipo</label>
						<select name="cmb_tipoe<?php echo $NumWindow; ?>" id="cmb_tipoe<?php echo $NumWindow; ?>">
					  		<option value="Día(s)">Día(s)</option>
					  		<option value="Mes(es)">Mes(es)</option>
					  		<option value="Año(s)">Año(s)</option>
						</select>
					</div>
				</div>
				<div class="col-md-1">
					<div class="form-group">
					  <label for="txt_Contrato<?php echo $NumWindow; ?>">Contrato</label>
					  	<div class="input-group">	
					  		<input name="txt_Contrato<?php echo $NumWindow; ?>" type="text" id="txt_Contrato<?php echo $NumWindow; ?>"  onkeypress="BuscarContrato<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Contrato', 'txt_Contrato<?php echo $NumWindow; ?>', 'estado_EPS=*1*')};" required />
					  		<span class="input-group-btn">	
					  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Contrato" onclick="javascript:CargarSearch('Contrato', 'txt_Contrato<?php echo $NumWindow; ?>', 'estado_EPS=*1*');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
					  		</span>
					  	</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label for="txt_NombreEPS<?php echo $NumWindow; ?>">Nombre Contrato	</label>
						<input name="txt_NombreEPS<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreEPS<?php echo $NumWindow; ?>" />
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group" id="grp_txt_fecha1<?php echo $NumWindow; ?>">
						<label for="txt_fecha1<?php echo $NumWindow; ?>">Fecha y Hora Llegada</label>
						<input name="txt_fecha1<?php echo $NumWindow; ?>" id="txt_fecha1<?php echo $NumWindow; ?>" type="text" required value="00:00:00" disabled="disabled"/>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group" id="grp_txt_fecha2<?php echo $NumWindow; ?>">
						<label for="txt_fecha2<?php echo $NumWindow; ?>">Fecha y Hora Atención</label>
						<input name="txt_fecha2<?php echo $NumWindow; ?>" id="txt_fecha2<?php echo $NumWindow; ?>" type="text" required value="00:00:00" disabled="disabled"/>
					</div>
				</div>
					
			</div>
		</div>
		<input name="hdn_formatohc<?php echo $NumWindow; ?>" type="hidden" id="hdn_formatohc<?php echo $NumWindow; ?>" value="TRIAGE" />
		<div class="col-md-3 ">
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
				<tbody id="tbDetalle<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th1<?php echo $NumWindow; ?>">#</th> 
					<th id="th2<?php echo $NumWindow; ?>">Fecha</th> 
				    <th id="th2<?php echo $NumWindow; ?>">Triage</th> 
				</tr> 
					 <?php 
					 if (isset($_GET["Historia"])) {
					$SQL="Select a.Codigo_HCF, ID_TER, c.Estado_TRG, c.Fecha2_TRG From hcfolios a, hctriage c , czterceros e Where e.Codigo_TER=a.Codigo_TER AND c.Codigo_HCF=a.Codigo_HCF AND e.Codigo_TER=c.Codigo_TER and e.ID_TER='".$_GET["Historia"]."' Order By a.Fecha_HCF desc, a.Hora_HCF, a.Codigo_HCF desc";
					$resulthc = mysqli_query($conexion, $SQL);
					$contarow=0;
					while($rowhc = mysqli_fetch_array($resulthc)) 
						{
							$contarow=$contarow+1;
							echo '
					  <tr onclick="CargarReport(\'application/reports/hctriage.php?HISTORIA='.$rowhc["ID_TER"].'&FOLIO_INICIAL='.$rowhc[0].'&FOLIO_FINAL='.$rowhc[0].'\', \'HC '.$rowhc["ID_TER"].'\');"><td align="center">'.$rowhc[0].'</td><td align="center">'.$rowhc[3].'</td><td> Triage '.$rowhc[2].'</td></tr>
					  ';
						}
					mysqli_free_result($resulthc); 
					 }
					 ?>  

				</tbody>
				</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
			</div>
	  	</div>

	  	<div id="divformatohc<?php echo $NumWindow; ?>" class="col-md-12 divformatohc">
	  		<?php
	  			$SQL="Select * from hctipos where Activo_HCT='1' and Codigo_HCT='TRIAGE';";
				$result = mysqli_query($conexion, $SQL);
				$FormatHCYes=0;
				while($row = mysqli_fetch_array($result)) {
					$FormatHCYes=1;
	  		?>
	  		<div class="row well well-sm">
			  	<div class="col-md-1">
			  		<ul class="nav nav-pills nav-stacked">
			  		  <?php if ($row["Antecedentes_HCT"]=="1") { ?>
					  <li role="presentation"><a href="#hc_antecedentes<?php echo $NumWindow; ?>" data-toggle="pill">Antecedentes</a></li>
					  <?php } ?>
					  <li role="presentation" class="active"><a href="#hc_tipo<?php echo $NumWindow; ?>" data-toggle="pill">Triage</a></li>
					</ul>
			  	</div>
	  			<div class="col-md-11 tab-content">
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
		  				$IncapacidadHCT=$row["Incapacidad_HCT"];
		  				//Antecedentes
						if ($AntecedentesHCT=="1") {
		  					echo '
		  				<div role="tabpanel" class="tab-pane fade" id="hc_antecedentes'.$NumWindow.'">
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
		  				echo '
		  				<div role="tabpanel" class="tab-pane fade active in" id="hc_tipo'.$NumWindow.'">
		  					<div class="row">
		  				';
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
											<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch(\'Diagnostico\', \'txt_dxppal'.$NumWindow.'\', \'NULL\');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
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
			  							<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
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
													<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch(\'Diagnostico\', \'txt_dxrel1'.$NumWindow.'\', \'NULL\');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
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
													<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch(\'Diagnostico\', \'txt_dxrel2'.$NumWindow.'\', \'NULL\');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
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
													<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch(\'Diagnostico\', \'txt_dxrel3'.$NumWindow.'\', \'NULL\');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
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
		  			$SQL="Select * from hccampos where Codigo_HCT='TRIAGE' and Grupo_HCC='0' Order By Orden_HCC;";
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
					$SQL="Select Valor_HCC, Texto_HCC, Orden_HCC, Seleccionado_HCC, Comando_HCC from hccamposlistas Where Codigo_HCT='TRIAGE' and Codigo_HCC='".$row["Codigo_HCC"]."' Order by 3";
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

				  			$SQL="Select * from hccampos where Codigo_HCT='TRIAGE' and Grupo_HCC='".$row["Orden_HCC"]."' Order By Orden_HCC;";
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
							$SQL="Select Valor_HCC, Texto_HCC, Orden_HCC, Seleccionado_HCC, Comando_HCC from hccamposlistas Where Codigo_HCT='TRIAGE' and Codigo_HCC='".$rowx["Codigo_HCC"]."' Order by 3";
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

		  		  
			  		echo '
			  		</div>
			  	</div>
			  		';
		  			
				?>
			</div>
		</div>
	</div>
</div>
<div class="row well well-sm">
	<div class="col-md-offset-6 col-md-6">
		<div class="form-group">
			<label for="cmb_triage<?php echo $NumWindow; ?>">Clasificación Triage</label>
			<select name="cmb_triage<?php echo $NumWindow; ?>" id="cmb_triage<?php echo $NumWindow; ?>"  style="font-size:15px; font-weight: bold;">
			<?php 
		$SQL="Select Codigo_HTR, Nombre_HTR, Descripcion_HTR, Color_HTR From hcclasiftriage;";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) 
			{
		 ?>
		  <option value="<?php echo $row[0]; ?>" style="font-size:15px; font-weight: bold; color:<?php echo $row[3]; ?>; "><?php echo '<span class="label label-default">'.$row[1].'</span>  '.$row[2]; ?></option>
		<?php
			}
		mysqli_free_result($result); 
		 ?>  
			</select>
		</div>
	</div>				
</div>

</form>

<script >
<?php
	if (isset($_GET["Area"])) {
		echo "document.getElementById('cmb_modulo".$NumWindow."').value = '".$_GET["Area"]."';";
	}
	if (isset($_GET["Historia"])) {
		if (trim($_GET["Historia"])!="") {
			$SQL="Select a.Codigo_TER, a.Nombre_TER, b.Codigo_EPS, b.Fecha_TRG, now(), c.Codigo_SEX from czterceros a, hctriage b, gxpacientes c Where c.Codigo_TER=a.Codigo_TER and a.Codigo_TER=b.Codigo_TER and b.Codigo_TRG='".$_GET["pre"]."' and a.ID_TER='".$_GET["Historia"]."'";
			$result = mysqli_query($conexion, $SQL);
			echo "
				document.frm_form".$NumWindow.".txt_idhc".$NumWindow.".value='".$_GET["Historia"]."';";
			if($row = mysqli_fetch_array($result)) {
			echo "
				document.getElementById('hdn_pretriage".$NumWindow."').value = '".$_GET["pre"]."';
				document.getElementById('txt_Contrato".$NumWindow."').value = '".$row[2]."';
				document.getElementById('hdn_codigoter".$NumWindow."').value = '".$row[0]."';
				document.getElementById('txt_paciente".$NumWindow."').value = '".$row[1]."';
				document.getElementById('txt_fecha1".$NumWindow."').value = '".$row[3]."';
				document.getElementById('txt_fecha2".$NumWindow."').value = '".$row[4]."';
				document.getElementById('cmb_sexo".$NumWindow."').value = '".$row[5]."';
				NombreContrato('".$NumWindow."', document.frm_form".$NumWindow.".txt_Contrato".$NumWindow.".value);
				";
			}
			else {
				echo "
				MsgBox1('Clasificación Triage','No se encuentran datos para el paciente ".$_GET["Historia"].".');
			document.frm_form".$NumWindow.".cmb_modulo".$NumWindow.".focus();
				";
			}
			mysqli_free_result($result); 
		}
	}
	else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function BuscarHCPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/hctriage.php', '<?php echo $NumWindow; ?>', '&FormatoHC='+document.getElementById('hdn_formatohc<?php echo $NumWindow; ?>').value+'&Area='+document.getElementById('cmb_modulo<?php echo $NumWindow; ?>').value+'&pre='+document.getElementById('hdn_pretriage<?php echo $NumWindow; ?>').value);
	} else {
		AbrirForm('application/forms/hctriage.php', '<?php echo $NumWindow; ?>', '&FormatoHC='+document.getElementById('hdn_formatohc<?php echo $NumWindow; ?>').value+'&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value+'&Area='+document.getElementById('cmb_modulo<?php echo $NumWindow; ?>').value+'&pre='+document.getElementById('hdn_pretriage<?php echo $NumWindow; ?>').value);
	}  
  }
}

function HCPteOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value!="") {
		AbrirForm('application/forms/hctriage.php', '<?php echo $NumWindow; ?>', '&FormatoHC='+document.getElementById('hdn_formatohc<?php echo $NumWindow; ?>').value+'&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value+'&Area='+document.getElementById('cmb_modulo<?php echo $NumWindow; ?>').value+'&pre='+document.getElementById('hdn_pretriage<?php echo $NumWindow; ?>').value);
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
?>

function BuscarContrato<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreContrato('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Contrato<?php echo $NumWindow; ?>.value);
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
	AbrirForm('application/forms/hctriage.php', '<?php echo $NumWindow; ?>', '');	
}

function llamartrg<?php echo $NumWindow; ?>() {
	Pretrg=document.getElementById("hdn_pretriage<?php echo $NumWindow; ?>").value;
	BackCallTRG(Pretrg);
}

    $("input[type=text]").addClass("form-control");
    $("input[type=number]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
    $("input[type=text]").addClass("hcx_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hcx_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hcx_<?php echo $NumWindow; ?>");
	$("select").addClass("hcx_<?php echo $NumWindow; ?>");
</script>
