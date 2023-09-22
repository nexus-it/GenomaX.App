<div role="tabpanel" class="tab-pane fade " id="hc_odontograma<?php echo $NumWindow; ?>">
	<div class="row">

		<div id="divodonto<?php echo $NumWindow; ?>" class="col-md-12">
			<label class="label label-success"> ODONTOGRAMA</label>
			<div class="btn-group pull-right">
			  <button type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Histórico <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" style="background-color: #fffced;">
			  <?php 
			  ?>
			    <li><a href="cargarDientes('seccionDientes', 'dientes.php', this.id);"><strong>FECHA</strong> Tratamiento</a></li>
			  <?php
			  ?>
			  </ul>
			</div>
			<div class="row well well-sm">
				<div id="seccionDientes" class="displayInlineBlockTop col-md-12" style="padding: 15px; height: 500px; border-style: double; text-align: center;">
					<div class="nxsanimation"  style="height: 460px;text-align: left;background-color: #EFEFEF; width: 60px; border-color: #004040; position: absolute; border-width: thin;border-style: dotted;z-index:99; overflow: auto;" onmouseout="symbolsOut('<?php echo $NumWindow; ?>');" onmouseover="symbolsHover('<?php echo $NumWindow; ?>');" id="div_symbols<?php echo $NumWindow; ?>" >
						<?php 
						$SQL="Select Codigo_OGS, Descripcion_OGS, Simbolo_OGS from hcodontogramasimbolos Where Estado_OGS='1' order by 1";
						$result = mysqli_query($conexion, $SQL);
						while ($row = mysqli_fetch_array($result)) {
						?>
						<button type="button" class="btn btn-default odontobutton " id="btn_odnt_<?php echo $row[0].$NumWindow; ?>" name="btn_odnt_<?php echo $row[0].$NumWindow; ?>" onclick="TtoDentalD('<?php echo $row[0]; ?>', '<?php echo $row[1]; ?>', '<?php echo $row[2]; ?>', '<?php echo $NumWindow; ?>');" title="<?php echo $row[1]; ?>" style="background-color: #f4f4f400; width: 161px;text-align: left;">
							<img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/icons/16x16/1.PatientFile.png" />
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