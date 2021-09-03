<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$totregistros=0;
	$limitsql='150';

    if (isset($_GET["fechaini"])) {
        $fechaini=$_GET["fechaini"];
        $fechafin=$_GET["fechafin"];
    } else {
        $SQL="Select date(now()), date(DATE_ADD(NOW(), INTERVAL -1 MONTH));";
        $result = mysqli_query($conexion, $SQL);
        if ($row = mysqli_fetch_array($result))  {
            $fechaini=$row[1];
            $fechafin=$row[0];
        }
        mysqli_free_result($result); 
        // ob_
        
    }
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
    <input name="hdn_empresa<?php echo $NumWindow; ?>" type="hidden" id="hdn_empresa<?php echo $NumWindow; ?>" value="" />
            
	<div class="row">
		<div class="col-md-8 well well-sm" id="grapfacsede<?php echo $NumWindow; ?>">
            <span class="center-block"><img src="http://cdn.genomax.co/media/image/loadingform.gif" class="img-responsive" alt="Cargando..."></span>
		</div>
		<div class="col-md-4">
            <div class="row well well-sm hidden-print">
                <div class="col-md-6">
            <div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
                <label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicial</label>
                <input  name="txt_fechaini<?php echo $NumWindow; ?>" id="txt_fechaini<?php echo $NumWindow; ?>" type="date" required class="form-control" value="<?php echo $fechaini; ?>"  />
            </div>
                </div>
                <div class="col-md-6">
            <div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
                <label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Final</label>
                <input  name="txt_fechafin<?php echo $NumWindow; ?>" id="txt_fechafin<?php echo $NumWindow; ?>" type="date" required class="form-control" value="<?php echo $fechafin; ?>"  />
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
					<th id="th2<?php echo $NumWindow; ?>" colspan=2>AREA</th> 
					<th id="th2<?php echo $NumWindow; ?>" ># FACTURAS</th> 
					<th id="th2<?php echo $NumWindow; ?>" >VALOR TOTAL</th> 
				</tr> 
	<?php
    
	$SumCartera=0;
	$CountCartera=0;
	$SQL="SELECT h.Nombre_SDE, h.Codigo_SDE, b.Codigo_ARE, f.Nombre_ARE, COUNT(distinct(a.Codigo_ADM)), SUM(c.Cantidad_ORD * c.ValorEntidad_ORD) FROM gxadmision a, gxordenescab b, gxordenesdet c, gxfacturas d, gxareas f, czsedes h WHERE a.Codigo_ADM=b.Codigo_ADM AND b.Codigo_ORD=c.Codigo_ORD AND b.Codigo_ADM=d.Codigo_ADM  AND f.Codigo_ARE=b.Codigo_ARE AND h.Codigo_SDE=f.Codigo_SDE AND a.Estado_ADM='F' AND b.Estado_ORD<>'0' AND d.Fecha_FAC BETWEEN '".$fechaini."' AND '".$fechafin."' GROUP BY h.Nombre_SDE, h.Codigo_SDE, b.Codigo_ARE, f.Nombre_ARE ORDER BY 2,3";
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    $sedex="";
    while($row1 = mysqli_fetch_array($result1)) {
        if ($sedex!=$row1[1]) {
            $sedex=$row1[1];
            echo '<tr><td colspan=4><em>SEDE: <b>'.$row1[0].'</b></em></td></tr>';
        }
       echo '<tr><td style="background-color:'.$row1[3].'; color:'.$row1[3].';" width="10px"> <span class="glyphicon glyphicon-stop" aria-hidden="true"></span> </td><td>'.$row1[3].'</td><td align="right">'.$row1[4].'</td><td align="right">$'.number_format($row1[5],2,'.',',').'</td></tr>';
       $SumCartera=$SumCartera+$row1[5];
       $CountCartera=$CountCartera+$row1[4];
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
                <button type="button" class="btn btn-success btn-block hidden-print" title="Imprimir" data-toggle="modal"  onclick="printwndw('<?php echo $NumWindow; ?>', 'FACTURADO EN UN PERIODO')"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </button>
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
    fechaini=document.getElementById('txt_fechaini<?php echo $NumWindow; ?>').value;
    fechafin=document.getElementById('txt_fechafin<?php echo $NumWindow; ?>').value;
    if (fechaini>fechafin) {
        MsgBox1("Error en Fechas", "La fecha final debe ser mayor o igual a la fecha final");
    } else {
        AbrirForm('application/forms/nxsfactsedearea.php', '<?php echo $NumWindow; ?>', '&fechaini='+fechaini+'&fechafin='+fechafin);
    }
}

function printcartedad<?php echo $NumWindow; ?>() {
    <?php
    $SQL="Select Nombre_ITM, Enlace_ITM, Icono_ITM From nxs_gnx.ititems Where Codigo_ITM='520';";
    $resulthc = mysqli_query($conexion, $SQL);
    if ($rowhc = mysqli_fetch_array($resulthc)) 
        {
    ?>
    CargarWind('<?php echo $rowhc[0]; ?>', '<?php echo $rowhc[1]; ?>', '<?php echo $rowhc[2]; ?>', 'nxsfactsedearea.php','<?php echo $NumWindow; ?>' );
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
        type: \'column\',
        options3d: {
            enabled: true,
            alpha: 15,
            beta: 15,
            viewDistance: 90,
            depth: 50
        }
    },
    title: {
        style: {
            color: \'#729d3b\',
            fontWeight: \'bold\',
            fontSize: \'16px\'
        },
        text: \'Facturado por Area de Servicio \'
    },
    subtitle: {
        style: {
            color: \'#729d3b\'
        },
        text: \'Entre el '.$fechaini.' y el '.$fechafin.'\'
    },
    xAxis: {
        categories: [
';
    $SQL="SELECT distinct h.Nombre_SDE, h.Codigo_SDE FROM gxadmision a, gxordenescab b, gxordenesdet c, gxfacturas d, gxareas f, czsedes h WHERE a.Codigo_ADM=b.Codigo_ADM AND b.Codigo_ORD=c.Codigo_ORD AND b.Codigo_ADM=d.Codigo_ADM  AND f.Codigo_ARE=b.Codigo_ARE AND h.Codigo_SDE=f.Codigo_SDE AND a.Estado_ADM='F' AND b.Estado_ORD<>'0' AND f.Estado_ARE<>'0' AND d.Fecha_FAC BETWEEN '".$fechaini."' AND '".$fechafin."' Order By 2";
    $kategoriex="";
    $result0 = mysqli_query($conexion, $SQL);
    while($row0 = mysqli_fetch_array($result0)) {
        $kategoriex=$kategoriex."'".$row0[0]."',";
    }
    $kategoriex=substr($kategoriex, 0,-1);
    mysqli_free_result($result0);
   
echo $kategoriex;

echo '
    ], 
        labels: {
            skew3d: true,
            style: {
                fontSize: \'14px\'
            }
        }
    },
    yAxis: {
        min: 100,
        title: {
            text: \'Total Facturado ($)\',
            skew3d: true
        }
    },
    tooltip: {
        headerFormat: \'<span style="font-size:10px">{point.key}</span><table>\',
        pointFormat: \'<tr><td style="color:{series.color};padding:0;font-size:10px">{series.name}: </td>\' +
            \'<td style="padding:0;font-size:11px" align="right"><b>${point.y:.0f} </b></td></tr>\',
        footerFormat: \'</table>\',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            stacking: \'normal\',
            dataLabels: {
                enabled: false
            },
            depth: 60,
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    colors: [\'#7cb5ec\', \'#f7a35c\', \'#90ee7e\', \'#DF5353\', \'#aaeeee\', \'#ff0066\', \'#eeaaee\', \'#808000\', \'#55BF3B\', \'#FF8000\', \'#7798BF\'],
    series: [';

    $SQL="SELECT distinct b.Codigo_ARE, f.Nombre_ARE FROM gxadmision a, gxordenescab b, gxordenesdet c, gxfacturas d, gxareas f, czsedes h WHERE a.Codigo_ADM=b.Codigo_ADM AND b.Codigo_ORD=c.Codigo_ORD AND b.Codigo_ADM=d.Codigo_ADM  AND f.Codigo_ARE=b.Codigo_ARE AND h.Codigo_SDE=f.Codigo_SDE AND a.Estado_ADM='F' AND b.Estado_ORD<>'0' AND f.Estado_ARE<>'0' AND d.Fecha_FAC BETWEEN '".$fechaini."' AND '".$fechafin."' GROUP BY b.Codigo_ARE, f.Nombre_ARE ORDER BY 1";
    $seriex="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $seriex=$seriex."{ name: '".$row1[1]."',    data: [";
        $SQL="SELECT distinct h.Nombre_SDE, h.Codigo_SDE FROM gxadmision a, gxordenescab b, gxordenesdet c, gxfacturas d, gxareas f, czsedes h WHERE a.Codigo_ADM=b.Codigo_ADM AND b.Codigo_ORD=c.Codigo_ORD AND b.Codigo_ADM=d.Codigo_ADM  AND f.Codigo_ARE=b.Codigo_ARE AND h.Codigo_SDE=f.Codigo_SDE AND a.Estado_ADM='F' AND b.Estado_ORD<>'0' AND f.Estado_ARE<>'0' AND d.Fecha_FAC BETWEEN '".$fechaini."' AND '".$fechafin."' Order By 2";
        $result0 = mysqli_query($conexion, $SQL);
        while($row0 = mysqli_fetch_array($result0)) {
            $SQL="SELECT h.Nombre_SDE, h.Codigo_SDE, b.Codigo_ARE, f.Nombre_ARE, COUNT(distinct(a.Codigo_ADM)), SUM(c.Cantidad_ORD * c.ValorEntidad_ORD) FROM gxadmision a, gxordenescab b, gxordenesdet c, gxfacturas d, gxareas f, czsedes h WHERE a.Codigo_ADM=b.Codigo_ADM AND b.Codigo_ORD=c.Codigo_ORD AND b.Codigo_ADM=d.Codigo_ADM  AND f.Codigo_ARE=b.Codigo_ARE AND h.Codigo_SDE=f.Codigo_SDE AND a.Estado_ADM='F' AND b.Estado_ORD<>'0' AND b.Codigo_ARE='".$row1[0]."' AND h.Codigo_SDE='".$row0[1]."' AND d.Fecha_FAC BETWEEN '".$fechaini."' AND '".$fechafin."' GROUP BY h.Nombre_SDE, h.Codigo_SDE, b.Codigo_ARE, f.Nombre_ARE ORDER BY 2,3";
            $result2 = mysqli_query($conexion, $SQL);
            if($row2 = mysqli_fetch_array($result2)) {
                $seriex=$seriex.$row2[5].", ";
            } else {
                $seriex=$seriex."0, ";
            }
            mysqli_free_result($result2);
        }
        mysqli_free_result($result0);
        $seriex=substr($seriex, 0,-2);    
        $seriex=$seriex."]  }, ";
    }
    mysqli_free_result($result1);
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
