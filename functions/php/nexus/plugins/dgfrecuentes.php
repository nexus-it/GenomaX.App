<?php
session_start();

/* ADMISIONES Vs FACTURADO MES */
$TotalADM=0;
$SQL="Select count(*) From gxadmision a Where month(a.Fecha_ADM)=month(now()) and year(a.Fecha_ADM)=year(now())";
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $TotalADM= $row1[0];
    }
    mysqli_free_result($result1);
echo 
'
Highcharts.chart(\'nxs_plg5\', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: \'pie\'
    },
    title: {
        text: \'Diagnósticos con más ingresos \'
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
flush();
$SQL="Select concat(b.Codigo_DGN, ' - ', b.Descripcion_DGN), count(a.Codigo_DGN) From hcdiagnosticos a, gxdiagnostico b Where a.Codigo_DGN=b.Codigo_DGN Group By concat(b.Codigo_DGN, ' - ', b.Descripcion_DGN) Order By 2 desc Limit 6";
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $datax=$datax."{ name: '".$row1[0]."',    y: ".$row1[1]." }, ";
    }
    mysqli_free_result($result1);
    $datax=substr($datax, 0,-2);    
    echo $datax;

    echo ']
    }]
});
';

?>