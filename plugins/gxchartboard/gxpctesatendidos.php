<?php
session_start();

/* # PACIENTES REECIENTES  */
echo 
'
function Loadgxpctesatendidos(deztino)
{
    Highcharts.chart(deztino, {
    chart: {
        type: \'column\'
    },
    title: {
        style: {
            color: \'#729d3b\',
            fontWeight: \'bold\',
            fontSize: \'15px\'
        },
        text: \'\'
    },
    subtitle: {
        text: \'Reciente\'
    },
    colors: [\'#A23158\', \'#245471\', \'#32C018\', \'#32C018\', \'#60E747\', \'#32C018\', \'#60E747\', \'#32C018\', \'#60E747\', \'#32C018\'],
    xAxis: {
        categories: [
';
    $SQL="Select distinct Fecha_HCF, year(a.Fecha_HCF), MONTH(a.Fecha_HCF) From hcfolios a WHERE a.Fecha_HCF BETWEEN DATE_ADD(NOW(), INTERVAL -10 DAY) AND NOW()  Order By Fecha_HCF";
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
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: \'# Pacientes\'
        }
    },
    tooltip: {
        headerFormat: \'<span style="font-size:10px">{point.key}</span><table>\',
        pointFormat: \'<tr><td style="color:{series.color};padding:0;font-size:11px">{series.name}: </td>\' +
            \'<td style="padding:0;font-size:11px"><b>{point.y:.1f} </b></td></tr>\',
        footerFormat: \'</table>\',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.2,
            borderWidth: 0
        }
    },
    series: [';

$SQL="Select distinct c.Nombre_sex, b.Codigo_sex From hcfolios a Inner Join gxpacientes b On b.Codigo_TER=a.Codigo_TER INNER JOIN gxtiposexo c ON c.Codigo_SEX=b.Codigo_SEX WHERE a.Fecha_HCF BETWEEN DATE_ADD(NOW(), INTERVAL -10 DAY) AND NOW() Order By c.Nombre_SEX";
    $seriex="";
    $result1 = mysqli_query($conexion, $SQL);
    while($row1 = mysqli_fetch_array($result1)) {
        $seriex=$seriex."{ name: '".$row1[0]."',    data: [";
        $SQL="Select distinct Fecha_HCF From hcfolios a WHERE a.Fecha_HCF BETWEEN DATE_ADD(NOW(), INTERVAL -10 DAY) AND NOW()  Order By Fecha_HCF";
        $result0 = mysqli_query($conexion, $SQL);
        while($row0 = mysqli_fetch_array($result0)) {
            $SQL="Select a.Fecha_HCF, count(a.Codigo_TER) From hcfolios a  Inner Join gxpacientes b On b.Codigo_TER=a.Codigo_TER INNER JOIN gxtiposexo c ON c.Codigo_SEX=b.Codigo_SEX WHERE a.Fecha_HCF ='".$row0[0]."'  and c.Codigo_SEX='".$row1[1]."' Group By a.Fecha_HCF";
            // $seriex=$seriex.$SQL;
            $result2 = mysqli_query($conexion, $SQL);
            if($row2 = mysqli_fetch_array($result2)) {
                $seriex=$seriex.$row2[1].", ";
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