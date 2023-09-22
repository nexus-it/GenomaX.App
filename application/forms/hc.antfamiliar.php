
<div class="col-sm-12">
  <div class="table-responsive ">
    <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" >
	  <tbody >
	  <tr>
	    <td align="right" style="vertical-align: middle;" width="20%">TBC</td>
	  	<td>
	  	  <?php nxs_chk('antfTBC', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Diabates</td>
	  	<td>
	  	  <?php nxs_chk('antfDiabetes', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Hipertensión</td>
	  	<td>
	  	  <?php nxs_chk('antfHTA', $NumWindow); ?>
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Preclamsia</td>
	  	<td>
	  	  <?php nxs_chk('antfPreclamsia', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Eclamsia</td>
	  	<td>
	  	  <?php nxs_chk('antfEclamsia', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Cáncer de cervix</td>
	  	<td>
	  	  <?php nxs_chk('antfCancervix', $NumWindow); ?>
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;" >Otro tipo de cáncer</td>
	  	<td colspan="5">
	  	  <input type="text" name="txt_antfOtrocanc<?php echo $NumWindow; ?>" id="txt_antfOtrocanc<?php echo $NumWindow; ?>" >
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Otros ant. familiares</td>
	  	<td colspan="5">
	  	  <input type="text" name="txt_antOtrfam<?php echo $NumWindow; ?>" id="txt_antOtrfam<?php echo $NumWindow; ?>" >
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Otos ant. importantes</td>
	  	<td colspan="7">
	  	  <input type="text" name="txt_antOtrfimp<?php echo $NumWindow; ?>" id="txt_antOtrfimp<?php echo $NumWindow; ?>" >
	  	</td>
	  </tr>
	  </tbody>
	</table>
  </div>
</div>