
<div role="tabpanel" class="tab-pane fade " id="hc_riesgoespecif<?php echo $NumWindow; ?>">
				<div class="row">
			
		<div id="divriesgoespecif<?php echo $NumWindow; ?>" class="col-md-12">
			<label class="label label-success"> Identificación de Riesgos Especificos</label>
			<div class="row well well-sm">


			<div class="panel-body table-responsive hcorden">
		        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetIREx<?php echo $row[0].$NumWindow; ?>" >
				<tbody id="tbDetIREx<?php echo $row[0].$NumWindow; ?>">
				<tr id="trDetIREX<?php echo $row[0].$NumWindow; ?>"> 
					<th>Fecha</th> 
					<th>Sospecha de Cáncer</th> 
					<th>Sangre Oculta en Heces</th> 
					<th>Sintomático Respiratorio</th> 
					<th>Mujer o Menor Víctima de Maltrato</th> 
					<th>Víctima de Violencia Sexual</th> 
					<th>Pre Test de VIH</th> 
					<th>Post Test de VIH</th> 
					
				</tr> 
				<tr>
					<td ><strong>Actual</strong></td>
					<td align="center">
						<?php nxs_chk('ireSospcancer', $NumWindow); ?>
					</td>
					<td align="center">
						<?php nxs_chk('ireSangheces', $NumWindow); ?>
					</td>
					<td align="center">
						<?php nxs_chk('ireSintresp', $NumWindow); ?>
					</td>
					<td align="center">
						<?php nxs_chk('ireMaltrato', $NumWindow); ?>
					</td>
					<td align="center">
						<?php nxs_chk('ireVsexual', $NumWindow); ?>
					</td>
					<td align="center">
						<?php nxs_chk('irePrevih', $NumWindow); ?>
					</td>
					<td align="center">
						<?php nxs_chk('irePstvih', $NumWindow); ?>
					</td>
				</tr>
				<?php
				$SQL="SELECT b.Fecha_HCF, a.Sospcancer_HCA, a.Sangheces_HCA, a.Sintresp_HCA, a.Maltrato_HCA, a.Vsexual_HCA, a.Previh_HCA, a.Pstvih_HCA FROM hcidriesgoesp a, hcfolios b, czterceros c WHERE a.Codigo_TER=b.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF AND c.Codigo_TER=a.Codigo_TER and a.Sospcancer_HCA in ('0','1') AND c.ID_TER='".$Hystory."' Order By 1 desc";
				$resmed = mysqli_query($conexion, $SQL);
				$konrwmd=0;
				while($rowmd = mysqli_fetch_array($resmed)) {
					$konrwmd++;
				?>
				<tr>
					<td><?php echo $rowmd[0]; ?></td>
				<?php
					for ($i = 1; $i <= 7; $i++) {
						if ($rowmd[$i]=="0") {
							echo '<td align="center"> <span class="glyphicon glyphicon-unchecked" aria-hidden="true"></span> </td>';
						} else {
							echo '<td align="center"> <span class="glyphicon glyphicon-check" aria-hidden="true"></span> </td>';
						}
					}
				?>
				</tr>
				<?php
				}
				mysqli_free_result($resmed);
				if ($konrwmd==0) {
				?>
				<tr>
					<td ><strong>00/00/0000</strong></td>
					<td colspan="7" align="center">NO SE ENCONTRARON REGISTROS ANTERIORES EN EL SISTEMA</td>
				</tr>
				<?php
				}
				?>
				</tbody>
			</table>
		      </div>
			</div>
		</div>

				</div>
		</div>