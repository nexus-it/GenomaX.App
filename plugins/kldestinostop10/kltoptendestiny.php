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
    if ($_SESSION["it_CodigoPRF"]=="0") {
        $SQL="SELECT c.Codigo_DST, c.Nombre_DST, COUNT(*) FROM klemisiones a, klcotizaciones b, kldestinos c WHERE a.Codigo_CTZ=b.Codigo_CTZ AND c.Codigo_DST=b.Codigo_DST AND a.Estado_EMI<>'A' AND NOW() BETWEEN b.FechaIni_CTZ AND b.FechaFin_CTZ GROUP BY c.Codigo_DST, c.Nombre_DST ORDER BY 3 DESC, 2 ASC LIMIT 10";
    } else {
        $SQL="SELECT c.Codigo_DST, c.Nombre_DST, COUNT(*) FROM klemisiones a, klcotizaciones b, kldestinos c WHERE a.Codigo_CTZ=b.Codigo_CTZ AND c.Codigo_DST=b.Codigo_DST AND a.Estado_EMI<>'A' AND a.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' AND NOW() BETWEEN b.FechaIni_CTZ AND b.FechaFin_CTZ GROUP BY c.Codigo_DST, c.Nombre_DST ORDER BY 3 DESC, 2 ASC LIMIT 10";
    }
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

LoadTopTenDestiny();

function LoadTopTenDestiny()
{
    Highcharts.chart(\'barChartTop10\', {
  chart: {
    type: \'bar\'
  },
  title: {
    style: {
            color: \'#729d3b\',
            fontWeight: \'bold\',
            fontSize: \'15px\'
        },
    text: \'Distribución Destinos Actuales\'
  },
  colors: [\'#7dc423\', \'#7dc423\', \'#7dc423\', \'#7dc423\', \'#7dc423\', \'#7dc423\', \'#7dc423\', \'#7dc423\', \'#7dc423\', \'#7dc423\'],
  xAxis: {
    categories: ['.$kategoriex.'],
    title: {
      text: null
    }
  },
  yAxis: {
    min: 0,
    title: {
      text: \'# Clientes\',
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