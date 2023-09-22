
<div role="tabpanel" class="tab-pane fade " id="hc_ctrprenat<?php echo $NumWindow; ?>">
	  					<div class="row">
	  				
		  		<div  class="col-md-12">
	  				<label class="label label-success"> Control prenatal</label>
	  				<div class="row well well-sm">
	  					<div class="col-sm-12">
	  					  <div class="table-responsive ">
					        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered"  >
							  <tbody >
						  	<?php
						  	$SQL="SELECT COLUMN_NAME, COLUMN_TYPE, COLUMN_COMMENT, ORDINAL_POSITION FROM information_schema.COLUMNS WHERE TABLE_SCHEMA  LIKE '".$_SESSION["DB_NAME"]."' AND TABLE_NAME = 'hcctrlprentl' AND COLUMN_NAME not in ('Codigo_HCF', 'Codigo_TER') ORDER BY ORDINAL_POSITION;";
							$resultANT1 = mysqli_query($conexion, $SQL);
							$kontcols=0;
							$lstcontrol="multi";
							while ($rowANT1 = mysqli_fetch_row($resultANT1)) {
								$eltypo="";
								if ($rowANT1[1]!="char(1)") {
									if ($rowANT1[1]=="int(11)") {
										$eltypo="number";
									} else {
										if ($rowANT1[1]=="date") {
											$eltypo="date";
										} else {
											$eltypo="text";
										}
									}
							?>
							  <tr>
							  	<td align="left" style="vertical-align: middle; font-weight: bolder;"><?php echo $rowANT1[2]; ?></td>
								<td>
									<input type="<?php echo $eltypo; ?>" name="txt_<?php echo $rowANT1[0].$NumWindow; ?>" id="txt_<?php echo $rowANT1[0].$NumWindow; ?>"  ></td>
							  </tr>
							<?php
								} else {
							?>
							<tr>
							  	<td align="left" style="vertical-align: middle; font-weight: bolder;"><?php echo $rowANT1[2]; ?></td>
								<td>
									<?php nxs_chk($rowANT1[0], $NumWindow); ?>
							  </tr>
							<?php
								}
							}
							mysqli_free_result($resultANT1);
							?>
							  
							  </tbody>
							</table>
						  </div>
	  					</div>
	  				</div>
	  			</div>

	  					</div>
	  			</div>