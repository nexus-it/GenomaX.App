<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$totregistros=0;
	$limitsql='150';

    if (isset($_GET["meses"])) {
        $meses=$_GET["meses"];
    } else {
        $meses="6";
        
    }
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
            <div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
                <label for="txt_meses<?php echo $NumWindow; ?>"> <span class="glyphicon glyphicon-signal" aria-hidden="true"></span> </label>
                <div class="input-group">
                    <span class="input-group-addon" id="pre-<?php echo $NumWindow; ?>">Últimos</span>
                    <input  name="txt_meses<?php echo $NumWindow; ?>" id="txt_meses<?php echo $NumWindow; ?>" type="number" required class="form-control" value="<?php echo $meses; ?>" min="2" max="12" style="font-weight: bolder; text-align: center;" />
                    <span class="input-group-addon" id="pos-<?php echo $NumWindow; ?>">Meses</span>
                </div>
            </div>
                </div>
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
					<th id="th2<?php echo $NumWindow; ?>" >FACTURADO</th> 
					<th id="th2<?php echo $NumWindow; ?>" >RADICADO</th> 
				</tr> 
	<?php
	$SumFactura=0;
	$SumRadica=0;
	$SQL="Select distinct LEFT(MONTHNAME(a.Fecha_FAC),3), year(a.Fecha_FAC), MONTH(a.Fecha_FAC) From gxfacturas a Where a.Fecha_FAC BETWEEN DATE_ADD(NOW(), INTERVAL -".$meses." MONTH) AND NOW()  Order By year(a.Fecha_FAC), month(a.Fecha_FAC)";
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
       echo '<tr><td style="background-color:'.$row1[3].'; color:'.$row1[3].';" width="10px"> <span class="glyphicon glyphicon-stop" aria-hidden="true"></span> </td><td>'.$row1[0].'/'.$row1[1].'</td>';
       $SQL="Select month(a.Fecha_FAC), sum(a.ValTotal_FAC) From gxfacturas a Where a.Estado_FAC<>'0' and month(a.Fecha_FAC)='".$row1[2]."' and year(a.Fecha_FAC)='".$row1[1]."' Group By month(a.Fecha_FAC)";
        $result2 = mysqli_query($conexion, $SQL);
        if($row2 = mysqli_fetch_array($result2)) {
            echo '<td align="right">$'.number_format($row2[1],2,'.',',').'</td>';
           $SumFactura=$SumFactura+$row2[1];
        }
        mysqli_free_result($result2);
        $SQL="Select MONTH(b.FechaConf_RAD), sum(a.ValTotal_FAC) From gxfacturas a, czradicacionescab b, czradicacionesdet c Where a.Estado_FAC<>'0' AND b.Codigo_RAD=c.Codigo_RAD AND c.Codigo_FAC=a.Codigo_FAC and MONTH(b.FechaConf_RAD)='".$row1[2]."' and YEAR(b.FechaConf_RAD)='".$row1[1]."' Group By MONTH(b.FechaConf_RAD)";
        $result2 = mysqli_query($conexion, $SQL);
        if($row2 = mysqli_fetch_array($result2)) {
            echo '<td align="right">$'.number_format($row2[1],2,'.',',').'</td></tr>';
           $SumRadica=$SumRadica+$row2[1];
        }
        mysqli_free_result($result2);

        
    }
    mysqli_free_result($result1);
    ?>
    		<tr><td colspan="2"><b>T O T A L</b></td><td align="right"><b> $<?php echo number_format($SumFactura,2,'.',','); ?></td><td align="right"><b> $<?php echo number_format($SumRadica,2,'.',','); ?></b></td></tr>
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
                <button type="button" class="btn btn-success btn-block hidden-print" title="Imprimir" data-toggle="modal"  onclick="printwndw('<?php echo $NumWindow; ?>', 'COMPARATIVO FACTURACION / RADICACION')"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </button>
              </div>
              <div class="col-xs-6">
                <button type="button" class="btn btn-success btn-block hidden-print" title="Exportar" data-toggle="modal" data-target="#GnmX_WinModal" onclick="printcartVS<?php echo $NumWindow; ?>()"> <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> </button>
              </div>
            </div>
		</div>
	</div>

</form>

<script >
NEmpresa('<?php echo $NumWindow; ?>');

function veriffechas<?php echo $NumWindow; ?>() {
    meses=document.getElementById('txt_meses<?php echo $NumWindow; ?>').value;
    AbrirForm('application/forms/carteraradvsfactura.php', '<?php echo $NumWindow; ?>', '&meses='+meses);
}

function printcartVS<?php echo $NumWindow; ?>() {
    <?php
    $SQL="Select Nombre_ITM, Enlace_ITM, Icono_ITM From ".$_SESSION['DB_NXS'].".ititems Where Codigo_ITM='520';";
    $resulthc = mysqli_query($conexion, $SQL);
    if ($rowhc = mysqli_fetch_array($resulthc)) 
        {
    ?>
    CargarWind('Facturado Vs Radicado Vs Recaudado', 'reports/carterafacvsrad.php?MESES='+meses, 'default.png', 'carteraradvsfactura.php','<?php echo $NumWindow; ?>' );
    <?php
        }
    mysqli_free_result($resulthc); 
    ?>
}

<?php
session_start();

echo '
Loadgxfactmesames'.$NumWindow.'("grapfacsede'.$NumWindow.'");

function Loadgxfactmesames'.$NumWindow.'(deztino)
{
    Highcharts.chart(deztino, {
    title: {
        style: {
            color: \'#729d3b\',
            fontWeight: \'bold\',
            fontSize: \'16px\'
        },
        text: \'Facturado Vs. Radicado \'
    },
    subtitle: {
        text: \'Últimos '.$meses.' Meses\'
    },
    tooltip: {
        headerFormat: \'<span style="font-size:10px">{point.key}</span><table>\',
        pointFormat: \'<tr><td style="color:{series.color};padding:0;font-size:10px">{series.name}: </td>\' +
            \'<td style="padding:0;font-size:10px" align="right"><b>${point.y:.0f} </b></td></tr>\',
        footerFormat: \'</table>\',
        shared: true,
        useHTML: true
    },
    xAxis: {
        categories: [
';
    $SQL="Select distinct LEFT(MONTHNAME(a.Fecha_FAC),3), year(a.Fecha_FAC), MONTH(a.Fecha_FAC) From gxfacturas a Where a.Fecha_FAC BETWEEN DATE_ADD(NOW(), INTERVAL -".$meses." MONTH) AND NOW()  Order By year(a.Fecha_FAC), month(a.Fecha_FAC)";
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
    yAxis: {
        title: {
            text: \'Valor Total ($)\'
        }
    },
    plotOptions: {
        series: {
            label: {
                connectorAllowed: true
            }
        }
    },
    colors: [\'#8080FF\', \'#FF9900\'],
    series: [';

    $seriex="";
    $seriex=$seriex."{ name: 'Facturado',    data: [";
    $SQL="Select distinct year(a.Fecha_FAC), MONTH(a.Fecha_FAC) From gxfacturas a Where a.Fecha_FAC BETWEEN DATE_ADD(NOW(), INTERVAL -".$meses." MONTH) AND NOW()  Order By year(a.Fecha_FAC), month(a.Fecha_FAC)";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $SQL="Select month(a.Fecha_FAC), sum(a.ValTotal_FAC) From gxfacturas a Where a.Estado_FAC<>'0' and month(a.Fecha_FAC)='".$row1[1]."' and year(a.Fecha_FAC)='".$row1[0]."' Group By month(a.Fecha_FAC)";
        $result2 = mysqli_query($conexion, $SQL);
        if($row2 = mysqli_fetch_array($result2)) {
            $seriex=$seriex.$row2[1].", ";
        } else {
            $seriex=$seriex."0, ";
        }
        mysqli_free_result($result2);
    }
    mysqli_free_result($result1);
    $seriex=substr($seriex, 0,-2);    
    $seriex=$seriex."]  }, ";
    $seriex=$seriex."{ name: 'Radicado',    data: [";
    $SQL="Select distinct year(a.Fecha_FAC), MONTH(a.Fecha_FAC) From gxfacturas a Where a.Fecha_FAC BETWEEN DATE_ADD(NOW(), INTERVAL -".$meses." MONTH) AND NOW()  Order By year(a.Fecha_FAC), month(a.Fecha_FAC)";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $SQL="Select MONTH(b.FechaConf_RAD), sum(a.ValTotal_FAC) From gxfacturas a, czradicacionescab b, czradicacionesdet c Where a.Estado_FAC<>'0' AND b.Codigo_RAD=c.Codigo_RAD AND c.Codigo_FAC=a.Codigo_FAC and MONTH(b.FechaConf_RAD)='".$row1[1]."' and YEAR(b.FechaConf_RAD)='".$row1[0]."' Group By MONTH(b.FechaConf_RAD)";
        $result2 = mysqli_query($conexion, $SQL);
        if($row2 = mysqli_fetch_array($result2)) {
            $seriex=$seriex.$row2[1].", ";
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
    ]
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
