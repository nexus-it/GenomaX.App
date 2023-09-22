<?php
session_start();
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>

<script >
<?php
    $kategoriex="";
    $seriex="";
    $result0 = mysqli_query($conexion, $SQL);
    while($row0 = mysqli_fetch_array($result0)) {
        $kategoriex=$kategoriex."'".$row0[1]."',";
        $seriex=$seriex.$row0[2].",";
    }
    $kategoriex=substr($kategoriex, 0,-1);
    $seriex=substr($seriex, 0,-1);
    mysqli_free_result($result0);
echo '

LoadTopEtareox();

function LoadTopEtareox()
{
    Highcharts.chart(\'pieTop30Etareo\', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: \'pie\'
    },
    title: {
        text: \'Atención por Grupo Etáreo \',
        style: {
            color: \'#729d3b\',
            fontWeight: \'bold\',
            fontSize: \'15px\'
        }
    },
    tooltip: {
        pointFormat: \'{series.name}: <b>{point.percentage:.1f}%</b>\'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            cursor: \'pointer\',
            dataLabels: {
                enabled: false
            },
            showInLegend: true
        }
    },
    series: [{
        name: \'Cantidad\',
        colorByPoint: true,
        data: [';

    $SQL="SELECT a.Codigo_ETA, a.Nombre_ETA, COUNT(*) FROM gxgruposetareos a, gxadmision b, gxpacientes c WHERE b.Codigo_TER=c.Codigo_TER AND TIMESTAMPDIFF(YEAR,c.FechaNac_PAC,b.Fecha_ADM) BETWEEN a.Min_ETA AND (a.Max_ETA+1) AND b.Fecha_ADM BETWEEN DATE_ADD(NOW(), INTERVAL -1 MONTH)  AND (NOW()) GROUP BY a.Nombre_ETA ORDER BY a.Codigo_ETA";
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $datax=$datax."{ name: '".$row1[1]."',    y: ".$row1[2]." }, ";
    }
    mysqli_free_result($result1);
    $datax=substr($datax, 0,-2);    
    echo $datax;

    echo ']
    }]
});
}';
?>
</script>