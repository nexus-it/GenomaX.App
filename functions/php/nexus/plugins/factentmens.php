<?php
session_start();

/* FACTURACION ULTIMOS 6 MESES */
echo 
'
Highcharts.chart(\'nxs_plg1\', {
    chart: {
        type: \'column\'
    },
    title: {
        text: \'Facturación Mensual\'
    },
    subtitle: {
        text: \'Últimos 6 Meses\'
    },
    xAxis: {
        categories: [
';
	$SQL="Select distinct LEFT(MONTHNAME(a.Fecha_FAC),3), year(a.Fecha_FAC), MONTH(a.Fecha_FAC) From gxfacturas a Where a.Fecha_FAC BETWEEN DATE_ADD(NOW(), INTERVAL -5 MONTH) AND NOW()  Order By year(a.Fecha_FAC), month(a.Fecha_FAC)";
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
            text: \'Facturado ($)\'
        }
    },
    tooltip: {
        headerFormat: \'<span style="font-size:10px">{point.key}</span><table>\',
        pointFormat: \'<tr><td style="color:{series.color};padding:0;font-size:11px">{series.name}: </td>\' +
            \'<td style="padding:0;font-size:11px"><b>${point.y:.1f} </b></td></tr>\',
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

$SQL="Select distinct b.Nombre_EPS, b.Codigo_EPS From gxfacturas a Inner Join gxeps b On b.Codigo_EPS=a.Codigo_EPS Where a.Estado_FAC<>'0' and a.Fecha_FAC BETWEEN DATE_ADD(NOW(), INTERVAL -5 MONTH) AND NOW() Order By b.Nombre_EPS";
	$seriex="";
	$result1 = mysqli_query($conexion, $SQL);
	while($row1 = mysqli_fetch_array($result1)) {
		$seriex=$seriex."{ name: '".$row1[0]."', 	data: [";
        $SQL="Select distinct year(a.Fecha_FAC), MONTH(a.Fecha_FAC) From gxfacturas a Where a.Fecha_FAC BETWEEN DATE_ADD(NOW(), INTERVAL -5 MONTH) AND NOW()  Order By year(a.Fecha_FAC), month(a.Fecha_FAC)";
        $result0 = mysqli_query($conexion, $SQL);
        while($row0 = mysqli_fetch_array($result0)) {
            $SQL="Select month(a.Fecha_FAC), sum(a.ValTotal_FAC) From gxfacturas a  Inner Join gxeps b On b.Codigo_EPS=a.Codigo_EPS Where a.Estado_FAC<>'0' and month(a.Fecha_FAC)='".$row0[1]."' and year(a.Fecha_FAC)='".$row0[0]."' and a.Codigo_EPS='".$row1[1]."' Group By month(a.Fecha_FAC)";
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
';

?>