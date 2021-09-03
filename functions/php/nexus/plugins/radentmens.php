<?php
session_start();

/* RADICACION ULTIMOS 6 MESES */
echo 
'
Highcharts.chart(\'nxs_plg2\', {
    title: {
        text: \'Radicación Mensual\'
    },
    subtitle: {
        text: \'Últimos 6 Meses\'
    },
    xAxis: {
        categories: [
';
	$SQL="Select distinct LEFT(MONTHNAME(a.FechaConf_RAD),3), year(a.FechaConf_RAD), MONTH(a.FechaConf_RAD) From czradicacionescab a Where a.FechaConf_RAD BETWEEN DATE_ADD(NOW(), INTERVAL -5 MONTH) AND NOW()  Order By year(a.FechaConf_RAD), month(a.FechaConf_RAD)";
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
            text: \'Radicado ($)\'
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
flush();
$SQL="Select distinct b.Nombre_EPS, b.Codigo_EPS From czradicacionescab a  Inner Join gxeps b On b.Codigo_EPS=a.Codigo_EPS Where a.Estado_RAD='2' and a.FechaConf_RAD BETWEEN DATE_ADD(NOW(), INTERVAL -5 MONTH) AND NOW()  Order By b.Nombre_EPS";
	$seriex="";
	$result1 = mysqli_query($conexion, $SQL);
	while($row1 = mysqli_fetch_array($result1)) {
		$seriex=$seriex."{ name: '".$row1[0]."', 	data: [";
        $SQL="Select distinct year(a.FechaConf_RAD), MONTH(a.FechaConf_RAD) From czradicacionescab a Where a.FechaConf_RAD BETWEEN DATE_ADD(NOW(), INTERVAL -5 MONTH) AND NOW()  Order By year(a.FechaConf_RAD), month(a.FechaConf_RAD)";
        $result0 = mysqli_query($conexion, $SQL);
        while($row0 = mysqli_fetch_array($result0)) {
            $SQL="Select month(a.FechaConf_RAD), ifnull(sum(c.ValTotal_FAC),'null') From gxeps b, gxfacturas c, czradicacionesdet d, czradicacionescab a Where b.Codigo_EPS=a.Codigo_EPS and d.Codigo_RAD=a.Codigo_RAD and c.Codigo_FAC=d.Codigo_FAC and month(a.FechaConf_RAD)='".$row0[1]."' and year(a.FechaConf_RAD)='".$row0[0]."' and a.Codigo_EPS='".$row1[1]."' Group By month(a.FechaConf_RAD)";
            $result2 = mysqli_query($conexion, $SQL);
            if($row2 = mysqli_fetch_array($result2)) {
                $seriex=$seriex.$row2[1].", ";
            } else {
                $seriex=$seriex."null, ";
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