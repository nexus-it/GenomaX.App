<?php
// Antecedentes GinecoObstetricos
if ($AntGineObsHCT=="1") {
  
}
?>

<div class="col-sm-12">
  <div class="table-responsive ">
    <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" >
	  <tbody >
	  <tr>
	  	<td align="right" style="vertical-align: middle;" >Gravidez</td>
	  	<td>
	  	  <input type="number" name="txt_antgGravindez<?php echo $NumWindow; ?>" id="txt_antgGravindez<?php echo $NumWindow; ?>" min="0" max="25" value="0">
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Partos</td>
	  	<td>
	  	  <input type="number" name="txt_antgPartos<?php echo $NumWindow; ?>" id="txt_antgPartos<?php echo $NumWindow; ?>" min="0" max="25" value="0">
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Vaginales</td>
	  	<td>
	  	  <input type="number" name="txt_antgVaginal<?php echo $NumWindow; ?>" id="txt_antgVaginal<?php echo $NumWindow; ?>" min="0" max="25" value="0">
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Cesáreas</td>
	  	<td>
	  	  <input type="number" name="txt_antgCesareas<?php echo $NumWindow; ?>" id="txt_antgCesareas<?php echo $NumWindow; ?>" min="0" max="25" value="0">
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;" >Abortos</td>
	  	<td>
	  	  <input type="number" name="txt_antgAbortos<?php echo $NumWindow; ?>" id="txt_antgAbortos<?php echo $NumWindow; ?>" min="0" max="25" value="0">
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Ectópicos</td>
	  	<td>
	  	  <input type="number" name="txt_antgEctopicos<?php echo $NumWindow; ?>" id="txt_antgEctopicos<?php echo $NumWindow; ?>" min="0" max="25" value="0">
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Nac. Vivos</td>
	  	<td>
	  	  <input type="number" name="txt_antgNvivos<?php echo $NumWindow; ?>" id="txt_antgNvivos<?php echo $NumWindow; ?>" min="0" max="25" value="0">
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Nac. Muertos</td>
	  	<td>
	  	  <input type="number" name="txt_antgNmuertos<?php echo $NumWindow; ?>" id="txt_antgNmuertos<?php echo $NumWindow; ?>" min="0" max="25" value="0">
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;" >Viven</td>
	  	<td>
	  	  <input type="number" name="txt_antgViven<?php echo $NumWindow; ?>" id="txt_antgViven<?php echo $NumWindow; ?>" min="0" max="25" value="0">
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Muertos 1° Semana</td>
	  	<td>
	  	  <input type="number" name="txt_antgNmuertossem1<?php echo $NumWindow; ?>" id="txt_antgNmuertossem1<?php echo $NumWindow; ?>" min="0" max="25" value="0">
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Muertos > 1 semana</td>
	  	<td>
	  	  <input type="number" name="txt_antgNmuertossem2<?php echo $NumWindow; ?>" id="txt_antgNmuertossem2<?php echo $NumWindow; ?>" min="0" max="25" value="0">
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Nacido Peso inferior 2500 grs</td>
	  	<td>
	  	  <select name="cmb_antgPesomenor<?php echo $NumWindow; ?>" id="cmb_antgPesomenor<?php echo $NumWindow; ?>">	
		  	<option value="0">NO</option>
		  	<option value="1">SI</option>
		  </select>
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;" >Menarca</td>
	  	<td colspan="3">
	  	  <input type="text" name="txt_antgMenarca<?php echo $NumWindow; ?>" id="txt_antgMenarca<?php echo $NumWindow; ?>" >
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Menopausia</td>
	  	<td colspan="3">
	  	  <input type="text" name="txt_antgMenopausia<?php echo $NumWindow; ?>" id="txt_antgMenopausia<?php echo $NumWindow; ?>" >
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;" >F.U.M.</td>
	  	<td>
	  	  <input type="date" name="txt_antgFUM<?php echo $NumWindow; ?>" id="txt_antgFUM<?php echo $NumWindow; ?>" value="1900-01-01">
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >F.U.P.</td>
	  	<td>
	  	  <input type="date" name="txt_antgFUP<?php echo $NumWindow; ?>" id="txt_antgFUP<?php echo $NumWindow; ?>"  value="1900-01-01">
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Última citología</td>
	  	<td>
	  	  <input type="date" name="txt_antgFUC<?php echo $NumWindow; ?>" id="txt_antgFUC<?php echo $NumWindow; ?>"  value="1900-01-01">
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Resultado última citología</td>
	  	<td>
	  	  <select name="cmb_antgCitologia<?php echo $NumWindow; ?>" id="cmb_antgCitologia<?php echo $NumWindow; ?>">	
		  	<option value="NORMAL /NEGATIVA">NORMAL /NEGATIVA</option>
		  	<option value="INADECUADA">INADECUADA</option>
		  	<option value="ATIPICA DE SIGNIFICADO INDETERMINADO (ASCUS)">ATIPICA DE SIGNIFICADO INDETERMINADO (ASCUS)</option>
		  	<option value="LESION DE BAJO GRADO (LSIL)">LESION DE BAJO GRADO (LSIL)</option>
		  	<option value="LESION DE ALTO GRADO (HSIL)">LESION DE ALTO GRADO (HSIL)</option>
		  	<option value="CANCER">CANCER</option>
		  </select>
	  	</td>
	  </tr>
	  <tr>
	  	<td align="right" style="vertical-align: middle;" >Inicio rel. sexuales</td>
	  	<td>
	  	  <select name="cmb_antgRelsex<?php echo $NumWindow; ?>" id="cmb_antgRelsex<?php echo $NumWindow; ?>">	
		  	<option value="0">NO</option>
		  	<option value="1">SI</option>
		  </select>
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Ciclos menstruales</td>
	  	<td>
	  	  <input type="text" name="txt_antgCiclosmenst<?php echo $NumWindow; ?>" id="txt_antgCiclosmenst<?php echo $NumWindow; ?>" >
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Actividad sexual</td>
	  	<td>
	  	  <input type="text" name="txt_antgActsex<?php echo $NumWindow; ?>" id="txt_antgActsex<?php echo $NumWindow; ?>" >
	  	</td>
	  	<td align="right" style="vertical-align: middle;" >Método de planificación</td>
	  	<td>
	  	  <select name="cmb_antgMetplanif<?php echo $NumWindow; ?>" id="cmb_antgMetplanif<?php echo $NumWindow; ?>">	
		  <option value="Ninguno">Ninguno</option>
	  	  <option value="Píldora anticonceptiva">Píldora anticonceptiva</option>
	  	  <option value="Sistema intrauterino">Sistema intrauterino</option>
	  	  <option value="Condón masculino">Condón masculino</option>
	  	  <option value="Parche anticonceptivo">Parche anticonceptivo</option>
	  	  <option value="Anillo anticonceptivo">Anillo anticonceptivo</option>
	  	  <option value="Implante anticonceptivo">Implante anticonceptivo</option>
	  	  <option value="Inyección anticonceptiva">Inyección anticonceptiva</option>
	  	  <option value="Dispositivo intrauterino- DIU">Dispositivo intrauterino- DIU</option>
	  	  <option value="Condón femenino">Condón femenino</option>
	  	  <option value="Diafragma">Diafragma</option>
	  	  <option value="Capuchón cervical">Capuchón cervical</option>
	  	  <option value="Esponja">Esponja</option>
	  	  <option value="Espermicidas">Espermicidas</option>
	  	  <option value="Esterilización">Esterilización</option>
	  	  <option value="Anticonceptivos de emergencia">Anticonceptivos de emergencia</option>
		  </select>
	  	</td>
	  </tr>
	  </tbody>
	</table>
  </div>
</div>
