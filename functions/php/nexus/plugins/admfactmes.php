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
Highcharts.chart(\'nxs_plg3\', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: \'pie\'
    },
    title: {
        text: \'Admisiones / Facturado Mes \'
    },
    subtitle: {
        text: \''.$TotalADM.' Admisiones\'
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
$SQL="Select count(*), 'Ingresos Sin Facturar' From gxadmision a Where a.Estado_ADM ='I' and month(a.Fecha_ADM)=month(now()) and year(a.Fecha_ADM)=year(now()) Union Select count(*), 'Ingresos Facturados' From gxadmision a Where a.Estado_ADM ='F' and month(a.Fecha_ADM)=month(now()) and year(a.Fecha_ADM)=year(now()) Union Select count(*), 'Ingresos Anulados' From gxadmision a Where a.Estado_ADM ='A' and month(a.Fecha_ADM)=month(now()) and year(a.Fecha_ADM)=year(now())";
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
});
';

?>