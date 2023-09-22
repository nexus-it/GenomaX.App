
<div class="col-sm-12">
  <div class="table-responsive ">
    <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" >
	  <tbody >
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Fumador o ex-fumador</td>
	  	<td>
	  	  <select name="cmb_antFumador<?php echo $NumWindow; ?>" id="cmb_antFumador<?php echo $NumWindow; ?>" class="input-sm">	
	  	    <option value="0">NO</option>
	  	    <option value="1">Ex fumador</option>
	  	    <option value="2">Fumador</option>
	  	  </select>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">No. de cigarrillos al día</td>
	  	<td>
	  	  <input type="number" name="txt_antCigarrdia<?php echo $NumWindow; ?>" id="txt_antCigarrdia<?php echo $NumWindow; ?>" min="0" max="100" value="0" >
	  	</td>
	  	<td align="right" style="vertical-align: middle;">No. de años fumando</td>
	  	<td>
	  	  <input type="number" name="txt_antAnyosfum<?php echo $NumWindow; ?>" id="txt_antAnyosfum<?php echo $NumWindow; ?>" min="0" max="100" value="0" >
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Paquetes / año </td>
	  	<td>
	  	  <input type="number" name="txt_antPaqanyofum<?php echo $NumWindow; ?>" id="txt_antPaqanyofum<?php echo $NumWindow; ?>" min="0" max="100" value="0" >
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Alcohol</td>
	  	<td>
	  	  <select name="cmb_antAlcohol<?php echo $NumWindow; ?>" id="cmb_antAlcohol<?php echo $NumWindow; ?>" class="input-sm">	
	  	    <option value="0">NO</option>
	  	    <option value="1">SI</option>
	  	  </select>
	  	</td>
	  	<td align="right" style="vertical-align: middle;" colspan="6"> </td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Estimulantes</td>
	  	<td colspan="7">
	  	  <input type="text" name="txt_antEstimula<?php echo $NumWindow; ?>" id="txt_antEstimula<?php echo $NumWindow; ?>" >
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Otros ant. toxicológicos</td>
	  	<td colspan="7">
	  	  <input type="text" name="txt_antOtrosanttx<?php echo $NumWindow; ?>" id="txt_antOtrosanttx<?php echo $NumWindow; ?>" >
	  	</td>
	  </tr>
	  </tbody>
	</table>
  </div>
</div>