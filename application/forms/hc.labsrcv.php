
<div role="tabpanel" class="tab-pane fade " id="hc_labsrcv<?php echo $NumWindow; ?>">
	  					<div class="row">
	  				
		  		<div id="divlabrcvx<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Laboratorios RCV</label>
	  				<div class="row well well-sm">
	  					<div class="col-sm-12">
	  					  <div class="table-responsive ">
					        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbllabsrcv<?php echo $NumWindow; ?>" >
					          <thead>
					          	<tr>
					          	  <th width="30%">Examen</th><th colspan="5">Resultados</th>
					          	</tr>
					          </thead>
							  <tbody id="tblabsrcv<?php echo $NumWindow; ?>">
							  	<?php
							  $SQL="Select Codigo_PQT, Orden_PQT, a.Codigo_SER, Mide_PQT, b.Nombre_SER from  hcpqservicios a, gxservicios b Where a.Codigo_SER=b.Codigo_SER and Codigo_PQT='Laboratorios RCV 1' Order By 2";
							  $resultLBx = mysqli_query($conexion, $SQL);
							  while ($rowLBx = mysqli_fetch_row($resultLBx)) {
							  	?>
							  <tr>
							  	<td><?php $Codlb=$rowLBx[2]; echo $rowLBx[4] ?><input type="hidden" name="hdn_lbvrcv<?php echo $Codlb.$NumWindow; ?>" id="hdn_lbvrcv<?php echo $Codlb.$NumWindow; ?>" ></td>
								<td width="15%"><input type="text" name="txt_lbrcv<?php echo $Codlb.$NumWindow; ?>" id="txt_lbrcv<?php echo $Codlb.$NumWindow; ?>" >
								</td>
								<td width="10%"><input type="date" name="txt_lbdrcv<?php echo $Codlb.$NumWindow; ?>" id="txt_lbdrcv<?php echo $Codlb.$NumWindow; ?>" >
								</td>
								<?php
								  $SQL="SELECT c.Valor_LAB, c.Fecha_LAB FROM hclabsrcv c, czterceros d WHERE c.Codigo_SER='".$Codlb."' and c.Codigo_TER=d.Codigo_TER and ID_TER='".$Hystory."' LIMIT 3";
								  $kontlb=3;
								  $resultLB = mysqli_query($conexion, $SQL);
								  while ($rowLB = mysqli_fetch_row($resultLB)) {
								  	$kontlb=$kontlb-1;
								?>
								<td width="15%" align="center"><b><?php echo $rowLB[0]; ?></b> <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"></span> <?php echo $rowLB[1]; ?></td>
								<?php
								  }
								  mysqli_free_result($resultLB);
								  if ($kontlb!=0) {
								  	echo '<td colspan="'.$kontlb.'"> </td>';
								  }
								?>
							  </tr>
							  <?php
							}
							mysqli_free_result($resultLBx);
							?>
							<tr><td colspan="6"><hr width="90%"></td></tr>
							<?php
							$SQL="Select Codigo_PQT, Orden_PQT, a.Codigo_SER, Mide_PQT, b.Nombre_SER from  hcpqservicios a, gxservicios b Where a.Codigo_SER=b.Codigo_SER and Codigo_PQT='Laboratorios RCV 2' Order By 2, 5";
							  $resultLBx = mysqli_query($conexion, $SQL);
							  while ($rowLBx = mysqli_fetch_row($resultLBx)) {
							  	?>
							  <tr>
							  	<td><?php $Codlb=$rowLBx[2]; echo $rowLBx[4] ?><input type="hidden" name="hdn_lbvrcv<?php echo $Codlb.$NumWindow; ?>" id="hdn_lbvrcv<?php echo $Codlb.$NumWindow; ?>" ></td>
								<td width="15%"><input type="text" name="txt_lbrcv<?php echo $Codlb.$NumWindow; ?>" id="txt_lbrcv<?php echo $Codlb.$NumWindow; ?>" >
								</td>
								<td width="10%"><input type="date" name="txt_lbdrcv<?php echo $Codlb.$NumWindow; ?>" id="txt_lbdrcv<?php echo $Codlb.$NumWindow; ?>" >
								</td>
								<?php
								  $SQL="SELECT c.Valor_LAB, c.Fecha_LAB FROM hclabsrcv c, czterceros d WHERE c.Codigo_SER='".$Codlb."' and c.Codigo_TER=d.Codigo_TER and ID_TER='".$Hystory."' LIMIT 3";
								  $kontlb=3;
								  $resultLB = mysqli_query($conexion, $SQL);
								  while ($rowLB = mysqli_fetch_row($resultLB)) {
								  	$kontlb=$kontlb-1;
								?>
								<td width="15%" align="center"><b><?php echo $rowLB[0]; ?></b> <span class="glyphicon glyphicon-option-vertical" aria-hidden="true"> <?php echo $rowLB[1]; ?></td>
								<?php
								  }
								  mysqli_free_result($resultLB);
								  if ($kontlb!=0) {
								  	echo '<td colspan="'.$kontlb.'"> </td>';
								  }
								?>
							  </tr>
							  <?php
							}
							mysqli_free_result($resultLBx);
							  ?>
							  </tbody>
							</table>
						  </div>
	  					</div>
	  				</div>
	  			</div>

	  					</div>
	  			</div>