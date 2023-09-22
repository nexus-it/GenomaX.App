<?php
session_start();

/* PACIENTES ATENDIDOS x SEXO */
echo 
'
Highcharts.chart(\'nxs_plg10\', {
    chart: {
        type: \'column\'
    },
    title: {
        text: \'Atenciones Recientes\'
    },
    subtitle: {
        text: \'\'
    },
    xAxis: {
        categories: [';
	$SQL="Select b.Fecha_HCF, a.Codigo_SEX, count(*) From gxpacientes a, hcfolios b Where a.Codigo_TER=b.Codigo_TER and b.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' Group by a.Codigo_SEX, b.Fecha_HCF Order by 1 desc, 2 Limit 10";
	$kategoriex="";
    $Fecha="";
	$result0 = mysqli_query($conexion, $SQL);
	while($row0 = mysqli_fetch_array($result0)) {
        if ($Fecha!=$row0[0]) {
            $Fecha=$row0[0];
    		$kategoriex=$kategoriex."'".$row0[0]."',";
        }
	}
	$kategoriex=substr($kategoriex, 0,-1);
	mysqli_free_result($result0);
    $SQL="Select b.Fecha_HCF From hcfolios b Where b.Fecha_HCF in (".$kategoriex.") Order by 1 asc";
    $SQLx=$SQL;
    $kategoriex="";
    $Fecha="";
    $result0 = mysqli_query($conexion, $SQL);
    while($row0 = mysqli_fetch_array($result0)) {
        if ($Fecha!=$row0[0]) {
            $Fecha=$row0[0];
            $kategoriex=$kategoriex."'".$row0[0]."',";
        }
    }
    $kategoriex=substr($kategoriex, 0,-1);
    mysqli_free_result($result0);
echo $kategoriex;

echo '	]
    },
    yAxis: {
        min: 0,
        title: {
            text: \'Número de Pacientes\'
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: \'bold\',
                color: (Highcharts.theme && Highcharts.theme.textColor) || \'gray\'
            }
        }
    },
    legend: {
        align: \'right\',
        x: -30,
        verticalAlign: \'top\',
        y: 25,
        floating: true,
        backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || \'white\',
        borderColor: \'#CCC\',
        borderWidth: 1,
        shadow: false
    },
    tooltip: {
        headerFormat: \'<b>{point.x}</b><br/>\',
        pointFormat: \'{series.name}: {point.y}<br/>Total: {point.stackTotal}\'
    },
    plotOptions: {
        column: {
            stacking: \'normal\',
            dataLabels: {
                enabled: true,
                color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || \'green\'
            }
        }
    },
    series: [';

$SQL="Select distinct Case a.Codigo_SEX When 'F' Then 'Femenino' Else 'Masculino' End From gxpacientes a, hcfolios b Where a.Codigo_TER=b.Codigo_TER and b.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' group by a.Codigo_SEX, b.Fecha_HCF Order by 1 Limit 10";
	$seriex="";
	$result1 = mysqli_query($conexion, $SQL);
    $Sexo="";                
	while($row1 = mysqli_fetch_array($result1)) {
        if ($row1[0]=="Femenino") {
            $Sexo="F";                
        } else  {
            $Sexo="M";
        }
		$seriex=$seriex."{ name: '".$row1[0]."', 	data: [";
        $SQL=$SQLx;
        $result0 = mysqli_query($conexion, $SQL);
        $Fecha="";
        while($row0 = mysqli_fetch_array($result0)) {
            if ($Fecha!=$row0[0]) {
                $Fecha=$row0[0];
                $SQL="Select count(*) From gxpacientes a, hcfolios b Where a.Codigo_TER=b.Codigo_TER and b.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' and b.Fecha_HCF='".$row0[0]."' and a.Codigo_SEX='".$Sexo."'";
                $result2 = mysqli_query($conexion, $SQL);
                if($row2 = mysqli_fetch_array($result2)) {
                    $seriex=$seriex.$row2[0].", ";
                } else {
                    $seriex=$seriex."0, ";
                }
                mysqli_free_result($result2);
            }
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