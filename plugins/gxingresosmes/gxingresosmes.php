<?php
session_start();
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<div class="box box-success">
  <div class="box-header">
    <i class="fa fa-line-chart"></i>
    <h3 class="box-title">Comportamiento Ventas</h3>
    <div class="pull-right box-tools">
      <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
    </div>
    <!-- /. tools -->
  </div>
  <div class="box-body no-padding">
    <div class="row">
      <div class="col-md-12 col-sm-12">
        <div class="chart" id="lineChartVentas" name="lineChartVentas" style="height:330px">
          <span class="center-block"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/loadingform.gif" class="img-responsive" alt="Cargando..."></span>
        </div>
      </div>
    </div>
  </div>
</div>

