<?php

if (isset($_GET["qr"])) {

?>

<!DOCTYPE html>

<html lang="es">

  <head>

  <meta charset="utf-8">

  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Kl'ud [QrVerify]</title>

  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="shortcut icon" href="https://axistravellers.com/klud/themes/klud/img/favicon.ico">

  <link type="text/css" href="https://axistravellers.com/klud/settings/css/normalize.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://axistravellers.com/klud/themes/klud/bower_components/bootstrap/dist/css/bootstrap.min.css">

  
  <!--[if lt IE 9]>

  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js?v=19.04.03.005"></script>

  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js?v=19.04.03.005"></script>

  <![endif]-->


  <!-- Google Font -->

  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


  </head>

  
  <body>

  	<div class="panel panel-success">

  	  <div class="panel-heading">

	    <h1 class="panel-title" style="text-align: center; font-weight: bold;">Verificador de Póliza</h1>

	  </div>

	  <div class="panel-body center-block">

	  	<img src="https://axistravellers.com/klud/themes/klud/img/user_160.jpg" class="center-block">

	    <div class="well" >Código: <small><?php echo $_GET["qr"]; ?></small></div>

	  </div>

	  <div class="panel-footer" style="text-align: center; font-weight: bold;">

	  	<?php

	  	$qrValido=0;
	
	  	$conexion = mysqli_connect('localhost', 'klud', 'Clave12345*', 'kld_axis');

		mysqli_query ($conexion, "SET NAMES 'utf8'");

		$MyZone="SET time_zone = '-5:00';";

		mysqli_query($conexion, $MyZone);

		$SQL="Select * from klemisiones Where SHA1(Codigo_EMI) ='".$_GET["qr"]."'";
		error_log('Qr Code Klud: '.$SQL);

		$resultqr = mysqli_query($conexion, $SQL);

		if ($rowqr = mysqli_fetch_row($resultqr)) {

			$qrValido=1;

		} else {

			$qrValido=0;

		}


		if ($qrValido==0) {

		?>

		<div style="color: #EF0025; text-align: center;"><h2>

			<span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span> Código Inválido!

		</h2></div>

		<?php

		} else {

		?>

		<div style="color: #00CE25; text-align: center;"><h2>

			<span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></span> Código Válido!

		</h2></div>

		<?php

		}	    

	  	?>

	  </div>

	</div>

	<?php

	if ($qrValido==1) {

	?>

    <div class="well" >Verifique a continuación que la información sea la misma que la impresa en su póliza:</div>

	<div class="table-responsive">

	  <table class="table table-condensed table-hover table-bordered table-striped">

	  	<?php

	  	$SQL="SELECT a.Prefijo_EMI, LPAD(a.Codigo_EMI,10,'0'), c.Nombres_KLI, c.Apellidos_KLI, d.ID_TER, e.Nombre_DST, b.FechaIni_CTZ, b.FechaFin_CTZ, f.Nombre_PLA, b.Modalidad_CTZ, a.Fecha_EMI, case a.Estado_EMI when 'A' then 'ANULADA' when 'E' then 'ACTIVA' ELSE 'STAND BY' end FROM klemisiones a INNER JOIN klcotizaciones b ON a.Codigo_CTZ=b.Codigo_CTZ INNER JOIN klclientes c ON b.Codigo_TER=c.Codigo_TER INNER JOIN czterceros d ON c.Codigo_TER=d.Codigo_TER INNER JOIN kldestinos e ON b.Codigo_DST=e.Codigo_DST INNER JOIN klplanes f ON b.Codigo_PLA=f.Codigo_PLA WHERE SHA1(Codigo_EMI) ='".$_GET["qr"]."'";
		error_log('Qr Code Klud: '.$SQL);

	  	$result = mysqli_query($conexion, $SQL);

		if ($row = mysqli_fetch_row($result)) {

			$clase='success';

			if ($row[11]=="ANULADA") {

				$clase='danger';

			}

		?>

		<tr class="success">

  			<td >Póliza</td>

  			<td ><strong><?php echo $row[0].'-'.$row[1]; ?><strong></td>

  		</tr>



  		<tr class="<?php echo $clase; ?>">

  			<td >Estado</td>

  			<td ><p class="text-<?php echo $clase; ?>"><strong><?php echo $row[11]; ?></strong></td>

  		</tr>



  		<tr class="success">

  			<td >Cliente</td>

  			<td ><strong><?php echo $row[2].' '.$row[3]; ?><strong></td>

  		</tr>



  		<tr class="success">

  			<td >Pasaporte</td>

  			<td ><?php echo $row[4]; ?></td>

  		</tr>



  		<tr class="success">

  			<td >Destino</td>

  			<td ><?php echo $row[5]; ?></td>

  		</tr>



  		<tr class="success">

  			<td >Fechas</td>

  			<td ><?php echo $row[6].' - '.$row[7]; ?></td>

  		</tr>



  		<tr class="success">

  			<td >Plan</td>

  			<td ><?php echo $row[8]; ?></td>

  		</tr>



  		<tr class="success">

  			<td >Modalidad</td>

  			<td ><?php echo $row[9]; ?></td>

  		</tr>



  		<tr class="success">

  			<td >Emisión</td>

  			<td ><?php echo $row[10]; ?></td>

  		</tr>

		<?php	

		}



	  	?>


	  </table>

	</div>



    <?php

	}

	?>



    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->

<script src="https://axistravellers.com/klud/themes/klud/bower_components/jquery/dist/jquery.min.js"></script>

<script src="https://axistravellers.com/klud/themes/klud/bower_components/jquery-ui/jquery-ui.min.js"></script>

<script src="https://axistravellers.com/klud/themes/klud/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>


  </body>

</html>

<?php	

}

?>