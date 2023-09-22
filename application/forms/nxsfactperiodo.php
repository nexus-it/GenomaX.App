<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
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
					<th id="th2<?php echo $NumWindow; ?>" colspan=2>ENTIDAD</th> 
					<th id="th2<?php echo $NumWindow; ?>" ># FACTURAS</th> 
					<th id="th2<?php echo $NumWindow; ?>" >VALOR TOTAL</th> 
				</tr> 
	<?php
	$SumCartera=0;
	$CountCartera=0;
	$SQL="Select distinct b.Nombre_EPS, b.Codigo_EPS, count(a.Codigo_FAC), sum(a.ValTotal_FAC) From gxfacturas a Inner Join gxeps b On b.Codigo_EPS=a.Codigo_EPS Where a.Estado_FAC<>'0' and a.Fecha_FAC BETWEEN '".$fechaini."' AND '".$fechafin." 23:59:59' Group By b.Nombre_EPS, b.Codigo_EPS Order By b.Nombre_EPS";
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
       echo '<tr><td style="background-color:'.$row1[3].'; color:'.$row1[3].';" width="10px"> <span class="glyphicon glyphicon-stop" aria-hidden="true"></span> </td><td>'.$row1[0].'</td><td align="right">'.$row1[2].'</td><td align="right">$'.number_format($row1[3],2,'.',',').'</td></tr>';
       $SumCartera=$SumCartera+$row1[3];
       $CountCartera=$CountCartera+$row1[2];
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
        AbrirForm('application/forms/nxsfactperiodo.php', '<?php echo $NumWindow; ?>', '&fechaini='+fechaini+'&fechafin='+fechafin);
    }
}

function printcartedad<?php echo $NumWindow; ?>() {
    <?php
    $SQL="Select Nombre_ITM, Enlace_ITM, Icono_ITM From ".$_SESSION['DB_NXS'].".ititems Where Codigo_ITM='520';";
    $resulthc = mysqli_query($conexion, $SQL);
    if ($rowhc = mysqli_fetch_array($resulthc)) 
        {
    ?>
    CargarWind('<?php echo $rowhc[0]; ?>', '<?php echo $rowhc[1]; ?>', '<?php echo $rowhc[2]; ?>', 'nxsfactperiodo.php','<?php echo $NumWindow; ?>' );
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
            beta: 7,
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
        text: \'Facturado por Periodo \'
    },
    subtitle: {
        style: {
            color: \'#729d3b\'
        },
        text: \'Entre el '.$fechaini.' y el '.$fechafin.'\'
    },
    xAxis: {
        categories: [\'Entidades\'],
        labels: {
            skew3d: true,
            style: {
                fontSize: \'16px\'
            }
        }
    },
    yAxis: {
        min: 0,
        title: {
            text: \'Total Facturado ($)\'
        }
    },
    plotOptions: {
        column: {
            stacking: \'normal\',
            dataLabels: {
                enabled: false
            },
            depth: 70,
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    colors: [\'#7cb5ec\', \'#f7a35c\', \'#90ee7e\', \'#7798BF\', \'#aaeeee\', \'#ff0066\', \'#eeaaee\', \'#55BF3B\', \'#DF5353\', \'#7798BF\', \'#aaeeee\'],
    series: [';

    $SQL="Select distinct b.Nombre_EPS, b.Codigo_EPS From gxfacturas a Inner Join gxeps b On b.Codigo_EPS=a.Codigo_EPS Where a.Estado_FAC<>'0' and a.Fecha_FAC BETWEEN '".$fechaini."' AND '".$fechafin." 23:59:59' Order By b.Nombre_EPS";
    $seriex="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $seriex=$seriex."{ name: '".$row1[0]."',    data: [";
        $SQL="Select a.Codigo_EPS, sum(a.ValTotal_FAC) From gxfacturas a Where a.Estado_FAC<>'0' and a.Fecha_FAC BETWEEN '".$fechaini."' AND '".$fechafin." 23:59:59' and a.Codigo_EPS='".$row1[1]."' Group By a.Codigo_EPS";
        $result2 = mysqli_query($conexion, $SQL);
        if($row2 = mysqli_fetch_array($result2)) {
            $seriex=$seriex.$row2[1].", ";
        } else {
            $seriex=$seriex."0, ";
        }
        mysqli_free_result($result2);
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
