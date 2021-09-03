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

function Loadgxcarteraedades(deztino)
{
    Highcharts.chart(deztino, {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: 0,
        plotShadow: false,
        type: \'pie\'
    },
    title: {
        style: {
            color: \'#729d3b\',
            fontWeight: \'bold\',
            fontSize: \'15px\'
        },
        text: \'\'
    },
    colors: [\'#3A9A6C\', \'#B4710C\', \'#32C018\', \'#32C018\', \'#60E747\', \'#32C018\', \'#60E747\', \'#32C018\', \'#60E747\', \'#32C018\'],
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
            dataLabels: {
                enabled: false,
                distance: -50,
                style: {
                    fontWeight: \'bold\',
                    color: \'white\'
                }
            }, 
            showInLegend: true,
            startAngle: -90,
            endAngle: 90,
            center: [\'50%\', \'75%\'],
            size: \'110%\'
        }
    },
    series: [{
        name: \'Cantidad\',
        colorByPoint: true,
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
