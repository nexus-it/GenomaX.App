<?php
session_start();
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<div class="box box-success">
    <div class="box-header">
      <i class="fa fa-calculator"></i>

      <h3 class="box-title">Cotizador</h3>

      <div class="box-tools pull-right">
        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
        
      </div>
    </div>
    <div class="box-body" >
      <form id="frm_cotiza" name="frm_cotiza">

      <div class="form-group col-md-6">
        <label for="cmb_plan">Plan</label>
        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="cmb_plan" name="cmb_plan"  onchange="LoadModalidades(this.value);">
        	<option value="0" selected="selected">-- Seleccione --</option>
          <?php
        $SQL="SELECT a.Codigo_PLA, a.Nombre_PLA FROM klplanes a WHERE a.Estado_PLA='1'";
        $result = mysqli_query($conexion, $SQL);
        while($row = mysqli_fetch_array($result)) {
          echo '<option value="'.$row[0].'">'.$row[1].'</option>';
        }
        mysqli_free_result($result);
        ?>
        </select>
      </div>

      <div class="form-group col-md-4">
        <label for="cmb_modalidad">Modalidad</label>
        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="cmb_modalidad" name="cmb_modalidad">
          <option value="0" selected="selected">-- Seleccione un plan --</option>
        </select>
      </div>

      <div class="form-group col-md-2">
        <label>Días</label>
        <div class="input-group">
          <input type="number" min="1" max="365" class="form-control pull-right" id="dias"  value="1">
        </div>
      </div>

      <div class="form-group col-md-9">
        <a href="javascript:nxsCotiza();" type="button" role="button" class="btn btn-success btn-block" id="calccotiz">Calcular
        <i class="fa fa-arrow-circle-right"></i></a>
      </div>

      <div class="form-group col-md-2 col-xs-8">
        <h3 style="margin-top: 7;"> <span id="valorCotiza" name="valorCotiza" class="label label-success"> U$ 0.00</span> </h3>
      </div>

      <div class="form-group col-md-1 col-xs-4">
        <a href="javascript:nxsNewCotiza()" title="Continuar Cotización">
        	<h4 style="margin-top: 9;"> <span id="exeCotizar" name="exeCotizar" class="label label-success"></span> </h4>
        </a>
      </div>

      </form>
    </div>
  </div>
<script>
function LoadModalidades(val)
{
    $.ajax({
        type: "POST",
        url: 'plugins/klcotizador/klmodalidades.php',
        data: 'Plan='+val,
        success: function(resp){
            $('#cmb_modalidad').html(resp);
        }
    });
}

function nxsCotiza()
{
	$('#calccotiz').html('Calculando...');
	$('#calccotiz').addClass('disabled');
	
	dias=document.getElementById('dias').value;
	val=document.getElementById('cmb_plan').value;
	mod=document.getElementById('cmb_modalidad').value;     	
	$.ajax({
		type: "POST",
        url: 'plugins/klcotizador/klcalcular.php',
        data: 'nxsplan='+val+'&nxsdias='+dias+'&nxsmod='+mod,
        success: function(resp){
        	$('#valorCotiza').html('U$ '+resp);
        	$('#exeCotizar').html(' <i class="fa fa-paper-plane"></i> ');
        	$('#calccotiz').html('Calcular <i class="fa fa-arrow-circle-right"></i>');
    		$('#calccotiz').removeClass('disabled');
        }
    });
    
}

function nxsNewCotiza()
{
	CargarForm('application/forms/klcotizaciones.php', 'Nueva Cotizacion', 'reseller_account_template.png')
}

</script>