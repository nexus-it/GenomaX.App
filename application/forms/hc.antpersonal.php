
<div class="col-sm-12">
  <div class="table-responsive ">
    <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" >
	  <tbody >
	  <tr>
	  	<td align="right" style="vertical-align: middle;" width="20%">Patológicos</td>
	  	<td colspan="7">
	  	  <input type="text" name="txt_antPatologia<?php echo $NumWindow; ?>" id="txt_antPatologia<?php echo $NumWindow; ?>" >
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Farmacológicos</td>
	  	<td colspan="7">
	  	  <input type="text" name="txt_antFarmacos<?php echo $NumWindow; ?>" id="txt_antFarmacos<?php echo $NumWindow; ?>" >
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Quirúrgicos</td>
	  	<td colspan="7">
	  	  <input type="text" name="txt_antQuirurgico<?php echo $NumWindow; ?>" id="txt_antQuirurgico<?php echo $NumWindow; ?>" >
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Traumatológicos</td>
	  	<td colspan="7">
	  	  <input type="text" name="txt_antTrauma<?php echo $NumWindow; ?>" id="txt_antTrauma<?php echo $NumWindow; ?>" >
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">TBC</td>
	  	<td>
	  	  <?php nxs_chk('antTBC', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Diabates</td>
	  	<td>
	  	  <?php nxs_chk('antDiabetes', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Hipertensión</td>
	  	<td>
	  	  <?php nxs_chk('antHTA', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Preclamsia</td>
	  	<td>
	  	  <?php nxs_chk('antPreclamsia', $NumWindow); ?>
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Eclamsia</td>
	  	<td>
	  	  <?php nxs_chk('antEclamsia', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Cirugía Pélvica</td>
	  	<td>
	  	  <?php nxs_chk('antQxpelvica', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Infertilidad</td>
	  	<td>
	  	  <?php nxs_chk('antInfertilidad', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">VIH+</td>
	  	<td>
	  	  <?php nxs_chk('antVIH', $NumWindow); ?>
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Cardiopatía</td>
	  	<td>
	  	  <?php nxs_chk('antCardiopatia', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Nefropatía</td>
	  	<td>
	  	  <?php nxs_chk('antNefropatia', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Mola</td>
	  	<td>
	  	  <?php nxs_chk('antMola', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Embarazo ectópico</td>
	  	<td>
	  	  <?php nxs_chk('antEmbectopico', $NumWindow); ?>
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Cifoescoliosis</td>
	  	<td>
	  	  <?php nxs_chk('antCifoescoliosis', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Asma</td>
	  	<td>
	  	  <?php nxs_chk('antAsma', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Antecedentes de ETS</td>
	  	<td>
	  	  <?php nxs_chk('antETS', $NumWindow); ?>
	  	</td>
	  	<td align="right" style="vertical-align: middle;">Rinitis</td>
	  	<td>
	  	  <?php nxs_chk('antRinitis', $NumWindow); ?>
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;">Condición médica grave</td>
	  	<td>
	  	  <?php nxs_chk('antConmedgrave', $NumWindow); ?>
	  	</td>
	  </tr>
	  </tbody>
	</table>
  </div>
</div>