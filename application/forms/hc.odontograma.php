<div role="tabpanel" class="tab-pane fade " id="hc_odontograma<?php echo $NumWindow; ?>">
	<div class="row">
	<input type="hidden" name="hdn_odontonow<?php echo $NumWindow; ?>" id="hdn_odontonow<?php echo $NumWindow; ?>" value="">
		<div id="divodonto<?php echo $NumWindow; ?>" class="col-md-12">
			<label class="label label-success"> ODONTOGRAMA</label>
			<div class="btn-group pull-right">
			  <button type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Histórico <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" style="background-color: #fffced;">
			  	<li><a href="javascript:actualOdonto('<?php echo $NumWindow; ?>');"><strong>Tratamiento Actual</strong></a></li>
			  <?php 
			    $SQL="Select Estados_ODG, Fecha_HCF, Nota_ODG From hcodontograma a, hcfolios b, czterceros c Where a.Codigo_TER=b.Codigo_TER and a.Codigo_HCF=b.Codigo_HCF and c.Codigo_TER=b.Codigo_TER and ID_TER='".$Hystory."';";
			    //error_log($SQL);
			    $resultodt = mysqli_query($conexion, $SQL);
			    while($rowodt = mysqli_fetch_array($resultodt)) {
			  ?>
			    <li><a href="javascript:paintOdonto('<?php echo $rowodt[0]; ?>', '<?php echo $rowodt[1]; ?>', '<?php echo $NumWindow; ?>');" title="<?php echo $rowodt[2]; ?>"><strong><?php echo $rowodt[1]; ?></strong> <?php echo $rowodt[2]; ?></a></li>
			  <?php
				}
				mysqli_free_result($resultodt);
			  ?>
			  </ul>
			</div>
			<div class="row well well-sm">
				<div id="seccionDientes" class="displayInlineBlockTop col-md-12" style="padding: 10px; height: 500px; border-style: double; text-align: center;">
				<!-- onmouseout="symbolsOut('<?php echo $NumWindow; ?>');" --> 
					<div class="nxsanimation"  style="height: 460px;text-align: left;background-color: #EFEFEF; width: 120px; border-color: #004040; position: absolute; border-width: thin;border-style: dotted;z-index:99; overflow: auto;" onmouseover="symbolsHover('<?php echo $NumWindow; ?>');" id="div_symbols<?php echo $NumWindow; ?>" >
						<?php 
						$SQL="Select Codigo_OGS, Descripcion_OGS, Tipo_OGS from hcodontogramasimbolos Where Estado_OGS='1' order by 1";
						$result = mysqli_query($conexion, $SQL);
						while ($row = mysqli_fetch_array($result)) {
						?>
						<button type="button" class="btn btn-default odontobutton " id="btn_odnt_<?php echo $row[0].$NumWindow; ?>" name="btn_odnt_<?php echo $row[0].$NumWindow; ?>" onclick="TtoDentalD('<?php echo $row[0]; ?>', '<?php echo $row[1]; ?>', '<?php echo $row[2]; ?>', '<?php echo $NumWindow; ?>');" title="<?php echo $row[1]; ?>" style="background-color: #f4f4f400; width: 161px;text-align: left;">
							<img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/odontog/<?php echo $row[0]; ?>.png" />
							<span class="odontolabel " style="color: #668e33;text-align: left; width: 116px;"><small><?php echo $row[1]; ?></small></span>
						</button>
						<?php
						}
						mysqli_free_result($result);
						?>
					</div>
				<?php
				include "hc.odontograma.dientes.php";
				?>
				</div>
				<div id="seccionRegistrarTratamiento" class="textAlignLeft sombraFormulario col-md-12" style="background-color: white;">
					<div class="displayInlineBlockMiddle col-md-3" style="display: none;">
						<div class="dienteGeneral" id="dienteGeneral"><div id="C1" onclick="seleccionarCara(this.id, '<?php echo $NumWindow; ?>');"></div><div id="C2" onclick="seleccionarCara(this.id, '<?php echo $NumWindow; ?>');"></div><div id="C3" onclick="seleccionarCara(this.id, '<?php echo $NumWindow; ?>');"></div><div id="C4" onclick="seleccionarCara(this.id, '<?php echo $NumWindow; ?>');"></div><div id="C5" onclick="seleccionarCara(this.id, '<?php echo $NumWindow; ?>');"></div><input type="text" id="txtIdentificadorDienteGeneral" name="txtIdentificadorDienteGeneral" value="DXX" readonly="readonly" style="display: none;"></div>
					</div>
					<div class="displayInlineBlockMiddle col-md-7">
						<span class="label label-default" id="spntitulo<?php echo $NumWindow; ?>">Datos del Tratamiento</span>
						<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive ">
							<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-condensed tblDetalle table-striped table-bordered" id="tblDetalleodt<?php echo $NumWindow; ?>" >
							<thead id="tbDetalled<?php echo $NumWindow; ?>">
							<tr id="trh<?php echo $NumWindow; ?>"> 
								<th id="thddt<?php echo $NumWindow; ?>"> Diente Tratado </th>
								<th id="thct<?php echo $NumWindow; ?>"> Cara Tratada </th>
								<th id="thant<?php echo $NumWindow; ?>"> Estado </th>
								<th id="thant<?php echo $NumWindow; ?>"> Eliminar </th>
							</tr>
							</thead>
							<tbody></tbody>
							</table>
							<input type="hidden" name="hdn_TotRowsOdont<?php echo $NumWindow; ?>" id="hdn_TotRowsOdont<?php echo $NumWindow; ?>" value="0">
						</div>
					</div>
					<div class="col-md-5">
	
				<div class="form-group">
					<label for="txt_odontodesc<?php echo $NumWindow; ?>">Descripción</label>
				  	<textarea name="txt_odontodesc<?php echo $NumWindow; ?>" rows="5" id="txt_odontodesc<?php echo $NumWindow; ?>" ></textarea>
				</div>

					</div>
					<!-- <div>
						<form class="formulario sombraFormulario labelPequenio" style="text-align: left;">
							<div class="tituloFormulario">DATOS DEL TRATAMIENTO</div>
							<div class="contenidoInterno">
								<label for=""><b>DIENTE TRATADO</b></label>
								<input type="text" id="txtDienteTratado" name="txtDienteTratado" class="textAlignCenter" size="4" readonly="readonly">
								<br>
								<label for=""><b>CARA TRATADA</b></label>
								<input type="text" id="txtCaraTratada" name="txtCaraTratada" class="textAlignCenter" size="4" readonly="readonly">
								<br>
								<label for=""><b>ESTADO</b></label>
								<select id="cbxEstado" name="cbxEstado">
									<option value="1-DIENTE INTACTO">DIENTE INTACTO</option>
									<option value="2-DIENTE AUSENTE">DIENTE AUSENTE</option>
									<option value="3-REMANENTE RADICULAR">REMANENTE RADICULAR</option>
									<option value="4-EXTRUSION">EXTRUSION</option>
									<option value="5-INTRUSION">INTRUSION</option>
									<option value="6-GIROVERSION">GIROVERSION</option>
									<option value="7-MIGRASION">MIGRASION</option>
									<option value="8-MICRODONCIA">MICRODONCIA</option>
									<option value="9-MACRODONCIA">MACRODONCIA</option>
									<option value="10-ECTOPICO">ECTOPICO</option>
									<option value="11-TRANSPOSICION">TRANSPOSICION</option>
									<option value="12-CLAVIJA">CLAVIJA</option>
									<option value="13-FRACTURA">FRACTURA</option>
									<option value="14-DIENTE DISCROMICO">DIENTE DISCROMICO</option>
									<option value="15-GEMINACION">GEMINACION</option>
									<option value="16-CARIES">CARIES</option>
									<option value="17-OBTURACION TEMPORAL">OBTURACION TEMPORAL</option>
									<option value="18-AMALGAMA">AMALGAMA</option>
									<option value="19-RESINA">RESINA</option>
									<option value="20-INCRUSTACION">INCRUSTACION</option>
									<option value="21-ENDODONCIA">ENDODONCIA</option>
									<option value="22-DESGASTADO">DESGASTADO</option>
									<option value="23-DIASTEMA">DIASTEMA</option>
									<option value="24-MOVILIDAD">MOVILIDAD</option>
									<option value="25-CORONA TEMPORAL">CORONA TEMPORAL</option>
									<option value="26-CORONA COMPLETA">CORONA COMPLETA</option>
									<option value="27-CORONA VEENER">CORONA VEENER</option>
									<option value="28-CORONA FEXESTRADA">CORONA FEXESTRADA</option>
									<option value="29-CORONA TRES CUARTOS">CORONA TRES CUARTOS</option>
									<option value="30-CORONA PORCELANA">CORONA PORCELANA</option>
									<option value="31-PROTESIS FIJA">PROTESIS FIJA</option>
									<option value="32-PROTESIS REMOVIBLE">PROTESIS REMOVIBLE</option>
									<option value="33-ODONTULO TOTAL">ODONTULO TOTAL</option>
									<option value="34-APARAT. ORTO. FIJO">APARAT. ORTO. FIJO</option>
									<option value="35-APARAT. ORTO. REMOV.">APARAT. ORTO. REMOV.</option>
									<option value="36-IMPLANTE">IMPLANTE</option>
									<option value="37-SUPERNUMERARIO">SUPERNUMERARIO</option>
									<option value="38-DIENTE POR EXTRAER">DIENTE POR EXTRAER</option>
								</select>
								<hr>
								<input type="hidden" id="txtCodigoPaciente" name="txtCodigoPaciente" value="PACIENTE0000001">
								<div class="seccionBotones">
									<input type="button" value="Agregar Tratamiento" onclick="agregarTratamiento($('#txtDienteTratado').val(), $('#txtCaraTratada').val(), $('#cbxEstado').val());">
								</div>
							</div>
						</form>
					</div>
					<section class="displayInlineBlockTop textAlignCenter" style="margin-left: 10px;width: 230px;">
						<div id="divTratamiento" class="displayInlineBlockTop sombraFormulario" style="width: 700px;height:150px;overflow-y: scroll;">
							<table id="tablaTratamiento" width="100%">
								<tbody></tbody>
							</table>
						</div>
						<div class="displayInlineBlockTop">
							<label><b>DESCRIPCIÓN</b></label>
							<br>
							<textarea name="txtDescripcion" id="txtDescripcion" rows="3" cols="74" class="textArea"></textarea>
						</div>
					</section>
					<hr>
					<div>
						<section id="seccionPaginaAjax"></section>
						<input type="button" class="button anchoCompleto" value="Guardar Tratamiento" onclick="guardarTratamiento();">
					</div> -->
				</div>
			</div>
		</div> 

	</div>
</div>
<script>
	cargarTratamientos("seccionTablaTratamientos", "verodontograma.php", $('#txtCodigoPaciente').val());
	cargarDientes("seccionDientes", "dientes.php", '', $('#txtCodigoPaciente').val());
</script>
<script src="functions/nexus/hc.odontograma.js?v=<?php echo $_SESSION["VERSION_CONTROL"].'.'.uniqid(); ?>"></script>