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
    if ($_SESSION["it_CodigoPRF"]=="0") {
        $SQL="SELECT DATE_FORMAT(a.Fecha_EMI, '%y'), month(a.Fecha_EMI), case month(a.Fecha_EMI) when '1' then 'Ene.' when '2' then 'Feb.' when '3' then 'Mar.' when '4' then 'Abr.' when '5' then 'May.' when '6' then 'Jun.' when '7' then 'Jul.' when '8' then 'Ago.' when '9' then 'Sep.' when '10' then 'Oct.' when '11' then 'Nov.' when '12' then 'Dic.' end, SUM(b.Dolares_CTZ) FROM klemisiones a, klcotizaciones b WHERE a.Codigo_CTZ=b.Codigo_CTZ AND a.Estado_EMI<>'A' AND a.Fecha_EMI BETWEEN DATE_ADD(NOW(), INTERVAL -6 MONTH)  AND (NOW()) GROUP BY DATE_FORMAT(a.Fecha_EMI, '%y'),month(a.Fecha_EMI) ORDER BY 1 ASC, 2 ASC";
    } else {
        $SQL="SELECT DATE_FORMAT(a.Fecha_EMI, '%y'), month(a.Fecha_EMI), case month(a.Fecha_EMI) when '1' then 'Ene.' when '2' then 'Feb.' when '3' then 'Mar.' when '4' then 'Abr.' when '5' then 'May.' when '6' then 'Jun.' when '7' then 'Jul.' when '8' then 'Ago.' when '9' then 'Sep.' when '10' then 'Oct.' when '11' then 'Nov.' when '12' then 'Dic.' end, SUM(b.Dolares_CTZ) FROM klemisiones a, klcotizaciones b WHERE a.Codigo_CTZ=b.Codigo_CTZ  AND a.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' AND a.Estado_EMI<>'A' AND a.Fecha_EMI BETWEEN DATE_ADD(NOW(), INTERVAL -6 MONTH)  AND (NOW()) GROUP BY DATE_FORMAT(a.Fecha_EMI, '%y'),month(a.Fecha_EMI) ORDER BY 1 ASC, 2 ASC";
    }
    $kategoriex="";
    $seriex="";
    $result0 = mysqli_query($conexion, $SQL);
    while($row0 = mysqli_fetch_array($result0)) {
        $kategoriex=$kategoriex."'".$row0[2]."/".$row0[0]."',";
        $seriex=$seriex.$row0[3].",";
    }
    $kategoriex=substr($kategoriex, 0,-1);
    $seriex=substr($seriex, 0,-1);
    mysqli_free_result($result0);
echo '


function LoadMesesVentas()
{
    Highcharts.chart(\'lineChartVentas\', {
        type: \'spline\',
        scrollablePlotArea: {
            minWidth: 300,
            scrollPositionX: 1
    },
    title: {
        text: \'Ventas últimos 6 meses \',
        style: {
            color: \'#3f5b9c\',
            fontWeight: \'bold\',
            fontSize: \'15px\'
        }
    },
    yAxis: {
        title: {
            text: \'Valores en U$\'
        }
    },
    xAxis: {
        categories: ['.$kategoriex.'],
        title: {
          text: null
        }
    },
    plotOptions: {
        line: {
            dataLabels: {
                enabled: true
            },
            enableMouseTracking: false
        }
    },
    series: [{
        name: \'Venta Mes\',
        data: ['.$seriex.']
    }]
});
  
}';
?>
</script>