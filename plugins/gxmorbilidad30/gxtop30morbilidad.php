<?php
session_start();
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>

<script >
<?php
    $SQL="SELECT c.Codigo_DGN, d.Descripcion_DGN, COUNT(b.Codigo_ADM) FROM hcfolios a, hcdiagnosticos c, gxadmision b, gxdiagnostico d WHERE a.Codigo_HCF =c.Codigo_HCF AND a.Codigo_TER=c.Codigo_TER AND b.Estado_ADM<>'A' AND b.Codigo_ADM=a.Codigo_ADM AND d.Codigo_DGN=c.Codigo_DGN AND a.Fecha_HCF BETWEEN DATE_ADD(NOW(), INTERVAL -1 MONTH)  AND (NOW()) GROUP BY c.Codigo_DGN, d.Descripcion_DGN ORDER BY 3 DESC, 2 ASC LIMIT 10";
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
 
LoadTop30Morbilityx();

function LoadTop30Morbilityx()
{
    Highcharts.chart(\'barChartTop30Morb\', {
  chart: {
    type: \'bar\'
  },
  title: {
    style: {
            color: \'#729d3b\',
            fontWeight: \'bold\',
            fontSize: \'15px\'
        },
    text: \'Top 10 Diagnósticos\'
  },
  colors: [\'#3A9A6C\', \'#90ee7e\', \'#32C018\', \'#32C018\', \'#60E747\', \'#32C018\', \'#60E747\', \'#32C018\', \'#60E747\', \'#32C018\'],
  xAxis: {
    categories: ['.$kategoriex.'],
    title: {
      text: null
    }
  },
  yAxis: {
    min: 0,
    title: {
      text: \'# Pacientes\',
      align: \'high\'
    },
    labels: {
      overflow: \'justify\'
    }
  },
  plotOptions: {
    bar: {
      dataLabels: {
        enabled: true
      }
    }
  },
  legend: {
    enabled: false,
    layout: \'vertical\',
    align: \'right\',
    verticalAlign: \'top\',
    x: -40,
    y: 80,
    floating: true,
    borderWidth: 1,
    backgroundColor: ((Highcharts.theme && Highcharts.theme.legendBackgroundColor) || \'#668e33\'),
    shadow: true
  },
  credits: {
    enabled: false
  },
  series: [{
    data: ['.$seriex.']
  }]
});
}';
?>
</script>