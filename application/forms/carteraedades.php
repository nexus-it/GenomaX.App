<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$totregistros=0;
	$limitsql='150';
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
    <input name="hdn_empresa<?php echo $NumWindow; ?>" type="hidden" id="hdn_empresa<?php echo $NumWindow; ?>" value="" />
            
	<div class="row">
		<div class="col-md-8 well well-sm" id="graphedad<?php echo $NumWindow; ?>">
            <span class="center-block"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/loadingform.gif" class="img-responsive" alt="Cargando..."></span>
		</div>
		<div class="col-md-4">
            <div class="row well well-sm hidden-print">
                <div class="col-md-12">
            <button type="button" class="btn btn-success btn-block btn-sm" title="Refrescar Datos"  onclick="veriffechas<?php echo $NumWindow; ?>();"> 
                <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> 
            </button>
                </div>
            </div>
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive" style="border: none;height: auto;">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallelun<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallelun<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th2<?php echo $NumWindow; ?>" colspan=2>EDAD</th> 
					<th id="th2<?php echo $NumWindow; ?>" ># FACTURAS</th> 
					<th id="th2<?php echo $NumWindow; ?>" >VALOR TOTAL</th> 
				</tr> 
	<?php
	$SumCartera=0;
	$CountCartera=0;
	$SQL="SELECT count(a.Codigo_FAC), sum(Saldo_CAR), h.Nombre_EDA, h.Color_EDA, h.Codigo_EDA FROM czcartera a, czcarteraedades h WHERE  (DATEDIFF(NOW(), a.Fecha_CAR) BETWEEN h.Minimo_EDA AND h.Maximo_EDA) AND  a.Saldo_CAR>0  GROUP BY h.Nombre_EDA, h.Color_EDA, h.Codigo_EDA Order BY h.Codigo_EDA ";
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
       echo '<tr><td style="background-color:'.$row1[3].'; color:'.$row1[3].';" width="10px"> <span class="glyphicon glyphicon-stop" aria-hidden="true"></span> </td><td>'.$row1[2].'</td><td align="right">'.$row1[0].'</td><td align="right">$'.number_format($row1[1],2,'.',',').'</td></tr>';
       $SumCartera=$SumCartera+$row1[1];
       $CountCartera=$CountCartera+$row1[0];
    }
    mysqli_free_result($result1);
    ?>
    		<tr><td colspan="2"><b>T O T A L</b></td><td align="right"><b> <?php echo $CountCartera; ?></td><td align="right"><b> $<?php echo number_format($SumCartera,2,'.',','); ?></b></td></tr>
				</tbody>
				</table><input name="hdn_controwlun<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwlun<?php echo $NumWindow; ?>" value="0" />
			</div>	
            <div class="row">
              <div class="visible-print-inline-block col-md-12">
                <hr>
                <p style="color: #B0B0B0; font-family: times; text-align: right; font-size: 9px;">
                    <em>Información suministrada por <b>GenomaX</b> para <b><span id="Nempresa<?php echo $NumWindow; ?>"></span></b></em>
                </p>
              </div>
              <div class="col-xs-6">
                <button type="button" class="btn btn-success btn-block hidden-print" title="Imprimir" data-toggle="modal"  onclick="printwndw('<?php echo $NumWindow; ?>', 'Cartera Por Edades')"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </button>
              </div>
              <div class="col-xs-6">
                <button type="button" class="btn btn-success btn-block hidden-print" title="Exportar" data-toggle="modal" data-target="#GnmX_WinModal" onclick="printcartedad<?php echo $NumWindow; ?>()"> <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> </button>
              </div>
            </div>
		</div>
	</div>

</form>

<script >
NEmpresa('<?php echo $NumWindow; ?>');

function veriffechas<?php echo $NumWindow; ?>() {
    AbrirForm('application/forms/carteraedades.php', '<?php echo $NumWindow; ?>', '');
}

function printcartedad<?php echo $NumWindow; ?>() {
    <?php
    $SQL="Select Nombre_ITM, Enlace_ITM, Icono_ITM From ".$_SESSION['DB_NXS'].".ititems Where Codigo_ITM='520';";
    $resulthc = mysqli_query($conexion, $SQL);
    if ($rowhc = mysqli_fetch_array($resulthc)) 
        {
    ?>
    CargarWind('<?php echo $rowhc[0]; ?>', '<?php echo $rowhc[1]; ?>', '<?php echo $rowhc[2]; ?>', 'carteraedades.php','<?php echo $NumWindow; ?>' );
    <?php
        }
    mysqli_free_result($resulthc); 
    ?>
}

<?php
session_start();

/* EDADES CARTERA */
$TotalCAR=0;
$SQL="SELECT count(a.Fecha_CAR) FROM czcartera a, czcarteraedades h WHERE a.Saldo_CAR>0 ";
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $TotalCAR= $row1[0];
    }
    mysqli_free_result($result1);

echo '
Loadgxcarteraedades'.$NumWindow.'("graphedad'.$NumWindow.'");

function Loadgxcarteraedades'.$NumWindow.'(deztino)
{
    Highcharts.chart(deztino, {
    chart: {
        type: \'pie\',
        options3d: {
            enabled: true,
            alpha: 45,
            beta: 0
        }
    },
    title: {
        style: {
            color: \'#729d3b\',
            fontWeight: \'bold\',
            fontSize: \'16px\'
        },
        text: \'Cartera por Edades \'
    },
     accessibility: {
        point: {
            valueSuffix: \'%\'
        }
    },
    tooltip: {
        pointFormat: \'{series.name}: <b>{point.percentage:.1f}%</b>\'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: \'pointer\',
            innerSize: 100,
            depth: 45
        }
    },
    colors: [';

$SQL="SELECT (count(a.Fecha_CAR)/".$TotalCAR."*100), h.Nombre_EDA, h.Color_EDA, h.Codigo_EDA FROM czcartera a, czcarteraedades h WHERE  (DATEDIFF(NOW(), a.Fecha_CAR) BETWEEN h.Minimo_EDA AND h.Maximo_EDA) AND  a.Saldo_CAR>0  GROUP BY h.Nombre_EDA, h.Color_EDA, h.Codigo_EDA Order BY h.Codigo_EDA ";
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $datax=$datax."'".$row1[2]."', ";
    }
    mysqli_free_result($result1);
    $datax=substr($datax, 0,-2);    
    echo $datax;

    echo '],
    series: [{
        name: \'Porcentaje\',
        data: [';

$SQL="SELECT (count(a.Fecha_CAR)/".$TotalCAR."*100), h.Nombre_EDA, h.Color_EDA, h.Codigo_EDA FROM czcartera a, czcarteraedades h WHERE  (DATEDIFF(NOW(), a.Fecha_CAR) BETWEEN h.Minimo_EDA AND h.Maximo_EDA) AND  a.Saldo_CAR>0  GROUP BY h.Nombre_EDA, h.Color_EDA, h.Codigo_EDA Order BY h.Codigo_EDA ";
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $datax=$datax."{ name: '".$row1[1]."',    y: ".$row1[0]." }, ";
    }
    mysqli_free_result($result1);
    $datax=substr($datax, 0,-2);    
    echo $datax;

    echo ']
    }]
})
}
';
?>

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
