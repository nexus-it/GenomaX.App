<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" enctype="multipart/form-data" target="upload_target" >
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
		<div class="col-md-6">

	<div class="form-group">
		<label for="txt_paciente<?php echo $NumWindow; ?>">Nombre</label>
		<input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>
	
		</div>
		<div class="col-md-1">

	<div class="form-group">
		<label for="txt_fechaing<?php echo $NumWindow; ?>">Fecha Ingreso</label>
		<input name="txt_fechaing<?php echo $NumWindow; ?>" id="txt_fechaing<?php echo $NumWindow; ?>" type="text" value="00/00/0000" disabled="disabled" />
	</div>
	
		</div>
		<div class="col-md-1">
	
	<div class="form-group" id="grp_txt_hora<?php echo $NumWindow; ?>">
		<label for="txt_hora<?php echo $NumWindow; ?>">Hora</label>
		<input name="txt_hora<?php echo $NumWindow; ?>" id="txt_hora<?php echo $NumWindow; ?>" type="text" value="00:00:00" disabled="disabled" />
	</div>

		</div>
		<div class="col-md-1">
	
	<div class="form-group">
		<label for="txt_ingreso<?php echo $NumWindow; ?>">Ingreso</label>
		<input style="font-size:15px; text-align:right;font-weight: bold;" name="txt_ingreso<?php echo $NumWindow; ?>" id="txt_ingreso<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>

		</div>
		<div class="col-md-1">
	
	<div class="form-group" id="grp_txt_hora<?php echo $NumWindow; ?>">
		<label for="txt_hora<?php echo $NumWindow; ?>">Servicio</label>
		<input name="txt_hora<?php echo $NumWindow; ?>" id="txt_hora<?php echo $NumWindow; ?>" type="text" value="" disabled="disabled" />
	</div>

		</div>
		<div class="col-md-9 alert alert-success">
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
			<label>Rango: </label> <span id="spn_rango<?php echo $NumWindow; ?>">Sin datos</span>
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

	</div>
		</div>
		<div class="btn-group col-md-3 well well-sm">
			  
			<span class="label label-success center-block">VISUALIZAR EPICRISIS ANTERIORES</span>
			

			 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
			<tbody id="tbDetalle<?php echo $NumWindow; ?>">
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th1<?php echo $NumWindow; ?>">Fecha</th> 
				<th id="th2<?php echo $NumWindow; ?>">Ingreso</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Servicio</th> 
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
				  <tr onclick="CargarReport(\'application/reports/hcepicrisis.php?HISTORIA='.$rowhc["ID_TER"].'&FOLIO_INICIAL='.$rowhc[0].'&FOLIO_FINAL='.$rowhc[0].'\', \'HC '.$rowhc["ID_TER"].'\');"><td align="center">'.$rowhc[0].'</td><td align="center">'.formatofecha($rowhc[1]).'</td><td>'.$rowhc[2].'</td></tr>
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

	  		<label class="label label-default"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> Resumen de H.C. - Epicrisis</label>
	  		<div class="row well well-sm">
	  		<input name="hdn_codigoser<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoser<?php echo $NumWindow; ?>" value="<?php echo $row["Codigo_SER"]; ?>" />

	  		<div class="col-md-12">
				<label class="label label-success"> DATOS DEL INGRESO</label>
				<div class="row well well-sm">
					<div class="col-md-6">

						<div class="form-group">
							<label for="txt_motcons<?php echo $NumWindow; ?>">Motivo de Consulta</label>
							<textarea class="form-control hc_<?php echo $NumWindow; ?>" rows="2" id="txt_motcons<?php echo $NumWindow; ?>" name="txt_motcons<?php echo $NumWindow; ?>" maxlength="2000" required=""></textarea>					
						</div>
					
					</div>
					<div class="col-md-6">

						<div class="form-group">
							<label for="txt_estgral<?php echo $NumWindow; ?>">Estado General al Ingreso</label>
							<textarea class="form-control hc_<?php echo $NumWindow; ?>" rows="2" id="txt_estgral<?php echo $NumWindow; ?>" name="txt_estgral<?php echo $NumWindow; ?>" maxlength="2000" required=""></textarea>
						</div>
					
					</div>
					<div class="col-md-6">

						<div class="form-group">
							<label for="txt_enfact<?php echo $NumWindow; ?>">Enfermedad Actual</label>
							<textarea class="form-control hc_<?php echo $NumWindow; ?>" rows="2" id="txt_enfact<?php echo $NumWindow; ?>" name="txt_enfact<?php echo $NumWindow; ?>" maxlength="2000" required=""></textarea>
						</div>
					
					</div>
					<div class="col-md-6">

						<div class="form-group">
							<label for="txt_revsist<?php echo $NumWindow; ?>">Revisión por Sistemas</label>
							<textarea class="form-control hc_<?php echo $NumWindow; ?>" rows="2" id="txt_revsist<?php echo $NumWindow; ?>" name="txt_revsist<?php echo $NumWindow; ?>" maxlength="2000" required=""></textarea>
						</div>
						</div>
					
					</div>


					<div class="col-md-12">
	  						<label class="label label-success"> Antecedentes</label>
							<div class="row well well-sm">
    
						    <div class="col-md-4">
						    <div class="input-group" id="tipoant<?php echo $NumWindow; ?>">
							  <div class="input-group-addon">Tipo</div>
						    	<select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>"  class="form-control">
						<?php
						$SQL="Select Codigo_HCA, ucase(Nombre_HCA) from hctipoantecedentes where Estado_HCA='1' order by 1";
						$resultz = mysqli_query($conexion, $SQL);
						while($rowz = mysqli_fetch_array($resultz)) 
							{
						 	echo '
						  <option value="'.$rowz[0].'">'.$rowz[1].'</option>
							';
							}
						mysqli_free_result($resultz); 
  						?>  
								</select>
							  </div>
							  <textarea class="form-control" rows="3" id="txt_antecdentext<?php echo $NumWindow; ?>"></textarea>
							  <button class="btn btn-success btn-block" type="button">
	  							Agregar <span class="glyphicon glyphicon-menu-right" aria-hidden="true"></span>  
							  </button>
						    </div>
						    <div class="col-md-8">

								 <div id="zero_detalleX<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleX<?php echo $NumWindow; ?>" >
								<tbody id="tbDetalleX<?php echo $NumWindow; ?>">
								<tr id="trhX<?php echo $NumWindow; ?>"> 
									<th id="th1X<?php echo $NumWindow; ?>">Tipo</th> 
									<th id="th2X<?php echo $NumWindow; ?>">Antecedentes</th> 
								</tr> 

								</tbody>
								</table><input name="hdn_controwX<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwX<?php echo $NumWindow; ?>" value="0" />
								 </div>
						    </div>

						  </div>
						</div>




						<div class="col-md-12">
	  						<label class="label label-success"> Diagnóstico de Ingreso</label>
							<div class="row well well-sm">

						<div class="col-md-3">
							<div class="form-group" id="grp_cmb_estado'.$NumWindow.'">
								<label for="cmb_tipodx<?php echo $NumWindow; ?>">Tipo Dx</label>
								<select name="cmb_tipodx<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>">
								  <option value="1">1 - IMPRESION DIAGNOSTICA</option>
								  <option value="2">2 - CONFIRMADO NUEVO</option>
								  <option value="3">3 - CONFIRMADO REPETIDO</option>
								</select>
							</div>
					
						</div>
						<div class="col-md-2">

							<div class="form-group" id="grp_txt_dxppal<?php echo $NumWindow; ?>">
								<label for="txt_dxppal<?php echo $NumWindow; ?>">Dx Ppal</label>
								<div class="input-group">	
									<input name="txt_dxppal<?php echo $NumWindow; ?>" id="txt_dxppal<?php echo $NumWindow; ?>" type="text" required onblur="HCDxOnBlur<?php echo $NumWindow; ?>();"/>
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('Diagnostico', 'txt_dxppal<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
									</span>
								</div>
							</div>

						</div>
						<div class="col-md-6">

							<div class="form-group">
								<label for="txt_dxppal1<?php echo $NumWindow; ?>">Nombre Diagnóstico Principal</label>
								<input name="txt_dxppal1<?php echo $NumWindow; ?>" id="txt_dxppal1<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
							</div>
						
						</div>
						<div class="col-md-1">

							<div class="form-group">
								<label for="txt_modelo<?php echo $NumWindow; ?>">Más Dx</label>
								<button class="btn btn-success btn-block" type="button" data-toggle="collapse" data-target="#div_diagnosticos<?php echo $NumWindow; ?>" aria-expanded="false" aria-controls="collapseExample">
		  							<i class="fas fa-plus"></i>
								</button>
							</div>
						
						</div>
						<div class="collapse col-md-12" id="div_diagnosticos<?php echo $NumWindow; ?>">
						  <div class="row">

						<div class="col-md-8">
							<div class="row">
								 <div class="col-md-3">
								 	<div class="form-group">
										<label for="txt_dxrel1<?php echo $NumWindow; ?>">Dx Rel</label>
										<div class="input-group">	
											<input name="txt_dxrel1<?php echo $NumWindow; ?>" id="txt_dxrel1<?php echo $NumWindow; ?>" type="text" onblur="HCDxR1OnBlur<?php echo $NumWindow; ?>();" />
											<span class="input-group-btn">	
												<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('Diagnostico', 'txt_dxrel1<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								 </div>
								 <div class="col-md-9">
								 	<div class="form-group">
										<label for="txt_dxrel11<?php echo $NumWindow; ?>">Diagnóstico Relacionado</label>
										<input name="txt_dxrel11<?php echo $NumWindow; ?>" id="txt_dxrel11<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
									</div>
								 </div>
								 <div class="col-md-3">
								 	<div class="form-group">
										<label for="txt_dxrel2<?php echo $NumWindow; ?>">Dx Rel2</label>
										<div class="input-group">	
											<input name="txt_dxrel2<?php echo $NumWindow; ?>" id="txt_dxrel2<?php echo $NumWindow; ?>" type="text" onblur="HCDxR2OnBlur<?php echo $NumWindow; ?>();" />
											<span class="input-group-btn">	
												<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('Diagnostico', 'txt_dxrel2<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								 </div>
								 <div class="col-md-9">
								 	<div class="form-group">
										<label for="txt_dxrel22<?php echo $NumWindow; ?>">Diagnóstico Relacionado 2</label>
										<input name="txt_dxrel22<?php echo $NumWindow; ?>" id="txt_dxrel22<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
									</div>
								 </div>
								 <div class="col-md-3">
								 	<div class="form-group">
										<label for="txt_dxrel3<?php echo $NumWindow; ?>">Dx Rel3</label>
										<div class="input-group">	
											<input name="txt_dxrel3<?php echo $NumWindow; ?>" id="txt_dxrel3<?php echo $NumWindow; ?>" type="text" onblur="HCDxR3OnBlur<?php echo $NumWindow; ?>();" />
											<span class="input-group-btn">	
												<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('Diagnostico', 'txt_dxrel3<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								 </div>
								 <div class="col-md-9">
								 	<div class="form-group">
										<label for="txt_dxrel33<?php echo $NumWindow; ?>">Diagnóstico Relacionado 3</label>
										<input name="txt_dxrel33<?php echo $NumWindow; ?>" id="txt_dxrel33<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
									</div>
								 </div>
							</div>
						</div>
						<div class="col-md-4">

							<div class="form-group">
								<label for="txt_dxmanejo<?php echo $NumWindow; ?>">Diagnóstico de manejo</label>
								<textarea class="form-control" rows="9" id="txt_dxmanejo<?php echo $NumWindow; ?>"></textarea>
							</div>
						
						</div>

						  </div>
						</div>
							</div>
						</div>
	  			
					<div class="col-md-12">
				<div class="form-group" id="grp_txt_evolucion<?php echo $NumWindow; ?>">
					<label for="txt_evolucion<?php echo $NumWindow; ?>">Evolución Médica</label>
					<textarea class="form-control hc_<?php echo $NumWindow; ?>" rows="4" id="txt_evolucion<?php echo $NumWindow; ?>" name="txt_evolucion<?php echo $NumWindow; ?>" maxlength="2000" required=""></textarea>
				</div>
					</div>


				</div>
			</div>


			<div class="col-md-12">
				<label class="label label-success"> DATOS DEL EGRESO</label>
				<div class="row well well-sm">
			


						<div class="col-md-12">
	  						<label class="label label-success"> Diagnóstico de Egreso</label>
							<div class="row well well-sm">

						<div class="col-md-3">
							<div class="form-group" id="grp_cmb_estado'.$NumWindow.'">
								<label for="cmb_etipodx<?php echo $NumWindow; ?>">Tipo Dx</label>
								<select name="cmb_etipodx<?php echo $NumWindow; ?>" id="cmb_etipodx<?php echo $NumWindow; ?>">
								  <option value="1">1 - IMPRESION DIAGNOSTICA</option>
								  <option value="2">2 - CONFIRMADO NUEVO</option>
								  <option value="3">3 - CONFIRMADO REPETIDO</option>
								</select>
							</div>
					
						</div>
						<div class="col-md-2">

							<div class="form-group" id="grp_txt_dxppal<?php echo $NumWindow; ?>">
								<label for="txt_edxppal<?php echo $NumWindow; ?>">Dx Ppal</label>
								<div class="input-group">	
									<input name="txt_edxppal<?php echo $NumWindow; ?>" id="txt_edxppal<?php echo $NumWindow; ?>" type="text" required onblur="HCDxOnBlurE<?php echo $NumWindow; ?>();"/>
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('Diagnostico', 'txt_edxppal<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
									</span>
								</div>
							</div>

						</div>
						<div class="col-md-6">

							<div class="form-group">
								<label for="txt_edxppal1<?php echo $NumWindow; ?>">Nombre Diagnóstico Principal</label>
								<input name="txt_edxppal1<?php echo $NumWindow; ?>" id="txt_edxppal1<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
							</div>
						
						</div>
						<div class="col-md-1">

							<div class="form-group">
								<label for="txt_modelo<?php echo $NumWindow; ?>">Más Dx</label>
								<button class="btn btn-success btn-block" type="button" data-toggle="collapse" data-target="#div_ediagnosticos<?php echo $NumWindow; ?>" aria-expanded="false" aria-controls="collapseExample">
		  							<i class="fas fa-plus"></i>
								</button>
							</div>
						
						</div>
						<div class="collapse col-md-12" id="div_ediagnosticos<?php echo $NumWindow; ?>">
						  <div class="row">

						<div class="col-md-8">
							<div class="row">
								 <div class="col-md-3">
								 	<div class="form-group">
										<label for="txt_edxrel1<?php echo $NumWindow; ?>">Dx Rel</label>
										<div class="input-group">	
											<input name="txt_edxrel1<?php echo $NumWindow; ?>" id="txt_edxrel1<?php echo $NumWindow; ?>" type="text" onblur="HCDxR1OnBlurE<?php echo $NumWindow; ?>();" />
											<span class="input-group-btn">	
												<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('Diagnostico', 'txt_edxrel1<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								 </div>
								 <div class="col-md-9">
								 	<div class="form-group">
										<label for="txt_edxrel11<?php echo $NumWindow; ?>">Diagnóstico Relacionado</label>
										<input name="txt_edxrel11<?php echo $NumWindow; ?>" id="txt_edxrel11<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
									</div>
								 </div>
								 <div class="col-md-3">
								 	<div class="form-group">
										<label for="txt_edxrel2<?php echo $NumWindow; ?>">Dx Rel2</label>
										<div class="input-group">	
											<input name="txt_edxrel2<?php echo $NumWindow; ?>" id="txt_edxrel2<?php echo $NumWindow; ?>" type="text" onblur="HCDxR2OnBlurE<?php echo $NumWindow; ?>();" />
											<span class="input-group-btn">	
												<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('Diagnostico', 'txt_edxrel2<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								 </div>
								 <div class="col-md-9">
								 	<div class="form-group">
										<label for="txt_edxrel22<?php echo $NumWindow; ?>">Diagnóstico Relacionado 2</label>
										<input name="txt_edxrel22<?php echo $NumWindow; ?>" id="txt_edxrel22<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
									</div>
								 </div>
								 <div class="col-md-3">
								 	<div class="form-group">
										<label for="txt_edxrel3<?php echo $NumWindow; ?>">Dx Rel3</label>
										<div class="input-group">	
											<input name="txt_edxrel3<?php echo $NumWindow; ?>" id="txt_edxrel3<?php echo $NumWindow; ?>" type="text" onblur="HCDxR3OnBlurE<?php echo $NumWindow; ?>();" />
											<span class="input-group-btn">	
												<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('Diagnostico', 'txt_edxrel3<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
											</span>
										</div>
									</div>
								 </div>
								 <div class="col-md-9">
								 	<div class="form-group">
										<label for="txt_edxrel33<?php echo $NumWindow; ?>">Diagnóstico Relacionado 3</label>
										<input name="txt_edxrel33<?php echo $NumWindow; ?>" id="txt_edxrel33<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
									</div>
								 </div>
							</div>
						</div>
						<div class="col-md-4">

							<div class="form-group">
								<label for="txt_edxmanejo<?php echo $NumWindow; ?>">Diagnóstico de manejo</label>
								<textarea class="form-control" rows="9" id="txt_edxmanejo<?php echo $NumWindow; ?>"></textarea>
							</div>
						
						</div>

						  </div>
						</div>
							</div>
						</div>
	  			

	  			
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
	  			</div>
		  		
	  		</div>
 		</div>
 	</div>
</div>

</form>

<script >

<?php
	if (isset($_GET["Historia"])) {
		if (trim($_GET["Historia"])!="") {
			$SQL="Select a.Codigo_TER, b.Nombre_TER, c.Codigo_ADM, e.Nombre_TER, f.Nombre_PLA, g.Nombre_RNG, a.fechanac_pac, a.Codigo_SEX, a.EstCivil_PAC, b.direccion_ter, b.telefono_ter, a.Actividad_PAC, c.Acudiente_ADM, c.Parentesco_ADM, c.Telefono_ADM, h.Descripcion_ADM, c.Observaciones_ADM, left(Fecha_ADM,10), c.Autorizacion_ADM, c.Codigo_EPS, c.Codigo_PLA from gxpacientes a, czterceros b, gxadmision c, gxeps d, czterceros e, gxplanes f, gxrangosalario g, gxtipoingreso h where h.Tipo_ADM=c.Ingreso_ADM and g.Codigo_RNG=a.Codigo_RNG and f.codigo_pla=c.codigo_pla and d.codigo_eps=c.codigo_eps and d.codigo_ter=e.codigo_ter and a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=a.Codigo_TER and c.Estado_ADM='I' and b.ID_TER='".$_GET["Historia"]."' order by fecha_adm desc limit 1";
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
				MsgBox1('Historia Clínica','No se encuentran datos para la H.C. ".$_GET["Historia"]." o no posee ingresos activos.');
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

function selecthc<?php echo $NumWindow; ?>(CodigoHCT)
{
	AbrirForm('application/forms/hcepicrisis.php', '<?php echo $NumWindow; ?>', '&FormatoHC='+CodigoHCT+'&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
}

function BuscarHCPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/hcepicrisis.php', '<?php echo $NumWindow; ?>', '&FormatoHC='+document.getElementById('hdn_formatohc<?php echo $NumWindow; ?>').value);
	} else {
		AbrirForm('application/forms/hcepicrisis.php', '<?php echo $NumWindow; ?>', '&FormatoHC='+document.getElementById('hdn_formatohc<?php echo $NumWindow; ?>').value+'&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
	}  
  }
}

function HCPteOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value!="") {
		AbrirForm('application/forms/hcepicrisis.php', '<?php echo $NumWindow; ?>', '&FormatoHC='+document.getElementById('hdn_formatohc<?php echo $NumWindow; ?>').value+'&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
	}
}

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


function chekear<?php echo $NumWindow; ?>(checqbox) {
	tmpchk=document.getElementById("hdn_"+checqbox+"<?php echo $NumWindow; ?>").value;
	if (tmpchk=='1') {
		document.getElementById("hdn_"+checqbox+"<?php echo $NumWindow; ?>").value='0';
	} else {
		document.getElementById("hdn_"+checqbox+"<?php echo $NumWindow; ?>").value='1';
	}
}

function HCDxOnBlurE<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_edxppal<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_edxppal<?php echo $NumWindow; ?>').value, document.getElementById('txt_edxppal1<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_edxppal1<?php echo $NumWindow; ?>').value = '';
	}
}

function HCDxR1OnBlurE<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_edxrel1<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_edxrel1<?php echo $NumWindow; ?>').value, document.getElementById('txt_edxrel11<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_edxrel11<?php echo $NumWindow; ?>').value = '';
	}
}

function HCDxR2OnBlurE<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_edxrel2<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_edxrel2<?php echo $NumWindow; ?>').value, document.getElementById('txt_edxrel22<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_edxrel22<?php echo $NumWindow; ?>').value = '';
	}
}

function HCDxR3OnBlurE<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_edxrel3<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_edxrel3<?php echo $NumWindow; ?>').value, document.getElementById('txt_edxrel33<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_edxrel33<?php echo $NumWindow; ?>').value = '';
	}
}
function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/hcepicrisis.php', '<?php echo $NumWindow; ?>', '');	
}
	HoraActual("txt_hora<?php echo $NumWindow; ?>");

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
