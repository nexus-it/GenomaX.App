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
		<div class="col-md-8 well well-sm" id="grapfacsede<?php echo $NumWindow; ?>">
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
					<th id="th2<?php echo $NumWindow; ?>" colspan=2>PERIODO</th> 
					<th id="th2<?php echo $NumWindow; ?>" ># ADMISIONES</th> 
					<th id="th2<?php echo $NumWindow; ?>" >VALOR VENTA</th> 
				</tr> 
	<?php
	$SumCartera=0;
	$CountCartera=0;
	$SQL="SELECT LEFT(MONTHNAME(a.Fecha_ADM),3), year(a.Fecha_ADM), month(a.Fecha_ADM), COUNT(distinct(a.Codigo_ADM)), SUM(c.Cantidad_ORD * d.Valor_TAR) FROM gxadmision a, gxordenescab b, gxordenesdet c, gxmanualestarifarios d, gxcontratos e WHERE a.Codigo_ADM=b.Codigo_ADM AND b.Codigo_ORD=c.Codigo_ORD AND e.Codigo_EPS=c.Codigo_EPS  AND e.Codigo_PLA=c.Codigo_PLA AND e.Codigo_TAR=d.Codigo_TAR AND d.Codigo_SER=c.Codigo_SER  AND (b.Fecha_ORD BETWEEN d.FechaIni_TAR AND d.FechaFin_TAR) AND a.Estado_ADM='I' AND b.Estado_ORD<>'0' GROUP BY  year(a.Fecha_ADM), month(a.Fecha_ADM)";
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
       echo '<tr><td style="background-color:'.$row1[3].'; color:'.$row1[3].';" width="10px"> <span class="glyphicon glyphicon-stop" aria-hidden="true"></span> </td><td>'.$row1[0].'/'.$row1[1].'</td><td align="right">'.$row1[3].'</td><td align="right">$'.number_format($row1[4],2,'.',',').'</td></tr>';
       $SumCartera=$SumCartera+$row1[4];
       $CountCartera=$CountCartera+$row1[3];
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
                <button type="button" class="btn btn-success btn-block hidden-print" title="Imprimir" data-toggle="modal"  onclick="printwndw('<?php echo $NumWindow; ?>', 'VENTA PENDIENTE POR FACTURAR')"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </button>
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
    AbrirForm('application/forms/nxsfactpendiente.php', '<?php echo $NumWindow; ?>', '');
}

function printcartedad<?php echo $NumWindow; ?>() {
    <?php
    $SQL="Select Nombre_ITM, Enlace_ITM, Icono_ITM From ititems Where Codigo_ITM='520';";
    $resulthc = mysqli_query($conexion, $SQL);
    if ($rowhc = mysqli_fetch_array($resulthc)) 
        {
    ?>
    CargarWind('<?php echo $rowhc[0]; ?>', '<?php echo $rowhc[1]; ?>', '<?php echo $rowhc[2]; ?>', 'nxsfactpendiente.php','<?php echo $NumWindow; ?>' );
    <?php
        }
    mysqli_free_result($resulthc); 
    ?>
}

<?php
session_start();

echo '
Loadgxfactsedefecha'.$NumWindow.'("grapfacsede'.$NumWindow.'");

function Loadgxfactsedefecha'.$NumWindow.'(deztino)
{
    Highcharts.chart(deztino, {
    chart: {
        type: \'cylinder\',
        options3d: {
            enabled: true,
            alpha: 20,
            beta: 5,
            depth: 80,
            viewDistance: 80
        }
    },
    title: {
        style: {
            color: \'#729d3b\',
            fontWeight: \'bold\',
            fontSize: \'16px\'
        },
        text: \'Venta por Facturar \'
    },
    tooltip: {
        headerFormat: \'<span style="font-size:10px">{point.key}</span><table>\',
        pointFormat: \'<tr><td style="color:{series.color};padding:0;font-size:10px">Venta: </td>\' +
            \'<td style="padding:0;font-size:10px" align="right"><b>${point.y:.0f} </b></td></tr>\',
        footerFormat: \'</table>\',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        series: {
            depth: 80,
            colorByPoint: true
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: \'Total Venta ($)\'
        }
    },
    colors: [\'#CECE00\'],
    xAxis: {
        categories: [
';
    $SQL="SELECT LEFT(MONTHNAME(a.Fecha_ADM),3), year(a.Fecha_ADM), month(a.Fecha_ADM), COUNT(distinct(a.Codigo_ADM)), SUM(c.Cantidad_ORD * d.Valor_TAR) FROM gxadmision a, gxordenescab b, gxordenesdet c, gxmanualestarifarios d, gxcontratos e WHERE a.Codigo_ADM=b.Codigo_ADM AND b.Codigo_ORD=c.Codigo_ORD AND e.Codigo_EPS=c.Codigo_EPS  AND e.Codigo_PLA=c.Codigo_PLA AND e.Codigo_TAR=d.Codigo_TAR AND d.Codigo_SER=c.Codigo_SER  AND (b.Fecha_ORD BETWEEN d.FechaIni_TAR AND d.FechaFin_TAR) AND a.Estado_ADM='I' AND b.Estado_ORD<>'0' GROUP BY  year(a.Fecha_ADM), month(a.Fecha_ADM)";
    $kategoriex="";
    $result0 = mysqli_query($conexion, $SQL);
    while($row0 = mysqli_fetch_array($result0)) {
        $kategoriex=$kategoriex."'".$row0[0]."/".$row0[1]."',";
    }
    $kategoriex=substr($kategoriex, 0,-1);
    mysqli_free_result($result0);
   
echo $kategoriex;

echo '
    ]
    },
    series: [';
    $seriex="";
    $seriex=$seriex."{ data: [";
    $SQL="SELECT LEFT(MONTHNAME(a.Fecha_ADM),3), year(a.Fecha_ADM), month(a.Fecha_ADM), COUNT(distinct(a.Codigo_ADM)), SUM(c.Cantidad_ORD * d.Valor_TAR) FROM gxadmision a, gxordenescab b, gxordenesdet c, gxmanualestarifarios d, gxcontratos e WHERE a.Codigo_ADM=b.Codigo_ADM AND b.Codigo_ORD=c.Codigo_ORD AND e.Codigo_EPS=c.Codigo_EPS  AND e.Codigo_PLA=c.Codigo_PLA AND e.Codigo_TAR=d.Codigo_TAR AND d.Codigo_SER=c.Codigo_SER  AND (b.Fecha_ORD BETWEEN d.FechaIni_TAR AND d.FechaFin_TAR) AND a.Estado_ADM='I' AND b.Estado_ORD<>'0' GROUP BY  year(a.Fecha_ADM), month(a.Fecha_ADM)";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $SQL="SELECT LEFT(MONTHNAME(a.Fecha_ADM),3), year(a.Fecha_ADM), month(a.Fecha_ADM), COUNT(distinct(a.Codigo_ADM)), SUM(c.Cantidad_ORD * d.Valor_TAR) FROM gxadmision a, gxordenescab b, gxordenesdet c, gxmanualestarifarios d, gxcontratos e WHERE a.Codigo_ADM=b.Codigo_ADM AND b.Codigo_ORD=c.Codigo_ORD AND e.Codigo_EPS=c.Codigo_EPS  AND e.Codigo_PLA=c.Codigo_PLA AND e.Codigo_TAR=d.Codigo_TAR AND d.Codigo_SER=c.Codigo_SER  AND (b.Fecha_ORD BETWEEN d.FechaIni_TAR AND d.FechaFin_TAR) AND a.Estado_ADM='I' AND b.Estado_ORD<>'0' and month(a.Fecha_ADM)='".$row1[2]."' and year(a.Fecha_ADM)='".$row1[1]."' GROUP BY  year(a.Fecha_ADM), month(a.Fecha_ADM)";
        $result2 = mysqli_query($conexion, $SQL);
        if($row2 = mysqli_fetch_array($result2)) {
            $seriex=$seriex.$row2[4].", ";
        } else {
            $seriex=$seriex."0, ";
        }
        mysqli_free_result($result2);
    }
    mysqli_free_result($result1);
    $seriex=substr($seriex, 0,-2);    
    $seriex=$seriex."]  }, ";
    $seriex=substr($seriex, 0,-2);    
    echo $seriex;

    echo '
    ],
    name: \'Periodo\',
    showInLegend: false
});
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
