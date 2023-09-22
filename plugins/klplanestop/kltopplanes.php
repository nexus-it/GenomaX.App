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


function LoadTopPlanes()
{
    Highcharts.chart(\'pieChartPlanes\', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: \'pie\'
    },
    title: {
        text: \'Planes Clientes Actuales \',
        style: {
            color: \'#3f5b9c\',
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

    if ($_SESSION["it_CodigoPRF"]=="0") {
        $SQL="SELECT c.Codigo_PLA, c.Nombre_PLA, COUNT(*) FROM klemisiones a, klcotizaciones b, klplanes c WHERE a.Codigo_CTZ=b.Codigo_CTZ AND c.Codigo_PLA=b.Codigo_PLA AND a.Estado_EMI<>'A' AND NOW() BETWEEN b.FechaIni_CTZ AND b.FechaFin_CTZ GROUP BY c.Codigo_PLA, c.Nombre_PLA";
    } else {
        $SQL="SELECT c.Codigo_PLA, c.Nombre_PLA, COUNT(*) FROM klemisiones a, klcotizaciones b, klplanes c WHERE a.Codigo_CTZ=b.Codigo_CTZ AND c.Codigo_PLA=b.Codigo_PLA AND a.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' AND a.Estado_EMI<>'A' AND NOW() BETWEEN b.FechaIni_CTZ AND b.FechaFin_CTZ GROUP BY c.Codigo_PLA, c.Nombre_PLA ";
    }
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