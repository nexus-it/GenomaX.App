<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$totregistros=0;
	$limitsql='150';
    // ob_
    
    $promedio=50;
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
					<th id="th2<?php echo $NumWindow; ?>" colspan=2>MUNICIPIO</th> 
					<th id="th2<?php echo $NumWindow; ?>" >POBLACION</th> 
				</tr> 
	<?php
    
	$contadoor=0;
	$CountCartera=0;
	$SQL="SELECT b.Nombre_DEP, c.Nombre_MUN, count(d.Codigo_TER), c.Codigo_MUN FROM gxadmision a, czdepartamentos b, czmunicipios c, gxpacientes d WHERE a.Codigo_TER=d.Codigo_TER AND d.Codigo_DEP=b.Codigo_DEP AND d.Codigo_MUN=c.Codigo_MUN AND b.Codigo_DEP=c.Codigo_DEP AND a.Estado_ADM='I' GROUP BY b.Nombre_DEP, c.Nombre_MUN, c.Codigo_MUN ORDER BY b.Nombre_DEP, c.Codigo_MUN";
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    $sedex="";
    while($row1 = mysqli_fetch_array($result1)) {
        if ($sedex!=$row1[0]) {
            $sedex=$row1[0];
            echo '<tr><td colspan=4><em>Departamento: <b>'.$row1[0].'</b></em></td></tr>';
        }
        $contadoor++;
       echo '<tr><td style="background-color:'.$row1[0].'; color:'.$row1[0].';" width="10px"> <span class="glyphicon glyphicon-stop" aria-hidden="true"></span> </td><td>'.$row1[1].'</td><td align="right">'.$row1[2].'</td></tr>';
       $CountCartera=$CountCartera+$row1[2];
    }
    mysqli_free_result($result1);
    $promedio=$CountCartera/$contadoor;
    ?>
    		<tr><td colspan="2"><b>T O T A L</b></td><td align="right"><b> <?php echo $CountCartera; ?></td></tr>
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
                <button type="button" class="btn btn-success btn-block hidden-print" title="Exportar" data-toggle="modal" data-target="#GnmX_WinModal" onclick="detalle<?php echo $NumWindow; ?>()"> <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> </button>
              </div>
            </div>
		</div>
	</div>

</form>

<script >
NEmpresa('<?php echo $NumWindow; ?>');

function veriffechas<?php echo $NumWindow; ?>() {
    AbrirForm('application/forms/nxsstatgeograph.php', '<?php echo $NumWindow; ?>', '');
}

function detalle<?php echo $NumWindow; ?>() {
    <?php
    $SQL="Select Nombre_ITM, Enlace_ITM, Icono_ITM From ".$_SESSION['DB_NXS'].".ititems Where Codigo_ITM='661';";
    $resulthc = mysqli_query($conexion, $SQL);
    if ($rowhc = mysqli_fetch_array($resulthc)) 
        {
    ?>
    CargarWind('<?php echo $rowhc[0]; ?>', '<?php echo $rowhc[1]; ?>', '<?php echo $rowhc[2]; ?>', 'detorigenpctes.php','<?php echo $NumWindow; ?>' );
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
        type: \'packedbubble\',
        height: \'70%\'
    },
    title: {
        style: {
            color: \'#729d3b\',
            fontWeight: \'bold\',
            fontSize: \'16px\'
        },
        text: \'Población Geográfica \'
    },
    subtitle: {
        style: {
            color: \'#729d3b\'
        },
        text: \'Admisiones Activas\'
    }, 
    tooltip: {
        useHTML: true,
        pointFormat: \'<b>{point.name}:</b> {point.value} pacientes\'
    },
    plotOptions: {
        packedbubble: {
            minSize: \'20%\',
            maxSize: \'100%\',
            zMin: 0,
            zMax: 900,
            layoutAlgorithm: {
                gravitationalConstant: 0.05,
                splitSeries: true,
                seriesInteraction: false,
                dragBetweenSeries: true,
                parentNodeLimit: true
            },
            dataLabels: {
                enabled: true,
                format: \'{point.name}\',
                filter: {
                    property: \'y\',
                    operator: \'>\',
                    value: '.$promedio.'
                },
                style: {
                    color: \'black\',
                    textOutline: \'none\',
                    fontWeight: \'normal\'
                }
            }
        }
    },
    colors: [\'#7cb5ec\', \'#f7a35c\', \'#90ee7e\', \'#DF5353\', \'#BFD52B\', \'#55BF3B\', \'#FF8000\', \'#808000\', \'#7798BF\', \'#eeaaee\', \'#ff0066\'],
    series: [';

    $SQL="SELECT distinct b.Nombre_DEP, b.Codigo_DEP FROM gxadmision a, czdepartamentos b, czmunicipios c, gxpacientes d WHERE a.Codigo_TER=d.Codigo_TER AND d.Codigo_DEP=b.Codigo_DEP AND d.Codigo_MUN=c.Codigo_MUN AND b.Codigo_DEP=c.Codigo_DEP AND a.Estado_ADM='I' GROUP BY b.Nombre_DEP ORDER BY b.Nombre_DEP";
    $seriex="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $seriex=$seriex."{ name: '".$row1[0]."', data: [";
        $SQL="SELECT c.Nombre_MUN, count(d.Codigo_TER) 
FROM gxadmision a, czdepartamentos b, czmunicipios c, gxpacientes d WHERE a.Codigo_TER=d.Codigo_TER AND d.Codigo_DEP=b.Codigo_DEP AND d.Codigo_MUN=c.Codigo_MUN AND b.Codigo_DEP=c.Codigo_DEP AND a.Estado_ADM='I' and b.Codigo_DEP='".$row1[1]."' GROUP BY c.Nombre_MUN ORDER BY c.Nombre_MUN";
        $result0 = mysqli_query($conexion, $SQL);
        while($row0 = mysqli_fetch_array($result0)) {
                $seriex=$seriex."{ name: '".$row0[0]."', value: ".$row0[1]." }, ";
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
