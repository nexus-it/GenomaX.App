<?php	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	// ob_
    
    $totregistros=0;
    $limitsql='15';
    $dx="";

    if (isset($_GET["fechaini"])) {
        $fechaini=$_GET["fechaini"];
        $fechafin=$_GET["fechafin"];
        $limitsql=$_GET["limitex"];
        $dx=$_GET["dx"];
    } else {
        $SQL="Select date(now()), date(DATE_ADD(NOW(), INTERVAL -1 MONTH));";
        $result = mysqli_query($conexion, $SQL);
        if ($row = mysqli_fetch_array($result))  {
            $fechaini=$row[1];
            $fechafin=$row[0];
        }
        mysqli_free_result($result); 
        
    }
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
    <input name="hdn_empresa<?php echo $NumWindow; ?>" type="hidden" id="hdn_empresa<?php echo $NumWindow; ?>" value="" />
            
	<div class="row">
		<div class="col-md-8 well well-sm" id="grappctedx<?php echo $NumWindow; ?>">
            <span class="center-block"><img src="http://cdn.genomax.co/media/image/loadingform.gif" class="img-responsive" alt="Cargando..."></span>
		</div>
		<div class="col-md-4">
            <div class="row well well-sm hidden-print">
                <div class="col-md-12">
            <div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
                <label for="txt_dx<?php echo $NumWindow; ?>">Diagnóstico</label>
                <input  name="txt_dx<?php echo $NumWindow; ?>" id="txt_dx<?php echo $NumWindow; ?>" type="text"  class="form-control typeahead" value="<?php echo $dx; ?>" placeholder="Ingrese las palabras clave para la búsqueda"   />
            </div>
                </div>
                <div class="col-md-5">
            <div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
                <label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicial</label>
                <input  name="txt_fechaini<?php echo $NumWindow; ?>" id="txt_fechaini<?php echo $NumWindow; ?>" type="date" required class="form-control" value="<?php echo $fechaini; ?>"  />
            </div>
                </div>
                <div class="col-md-5">
            <div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
                <label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Final</label>
                <input  name="txt_fechafin<?php echo $NumWindow; ?>" id="txt_fechafin<?php echo $NumWindow; ?>" type="date" required class="form-control" value="<?php echo $fechafin; ?>"  />
            </div>
                </div>
                <div class="col-md-2">
            <div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
                <label for="txt_limitex<?php echo $NumWindow; ?>">Mostrar</label>
                <input  name="txt_limitex<?php echo $NumWindow; ?>" id="txt_limitex<?php echo $NumWindow; ?>" type="number" min="1" required class="form-control" value="<?php echo $limitsql; ?>"  />
            </div>
                </div>
                <div class="col-md-12">
            <button type="button" class="btn btn-success btn-block btn-sm" title="Refrescar Datos"  onclick="veriffechas<?php echo $NumWindow; ?>();"> 
                <span class="glyphicon glyphicon-refresh" aria-hidden="true"></span> 
            </button>
                </div>
            </div>
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive" style="border: none;height: auto;">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallelun<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallelun<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th2<?php echo $NumWindow; ?>" colspan=2>DIAGNOSTICO</th> 
					<th id="th2<?php echo $NumWindow; ?>" ># PCTES.</th> 
				</tr> 
	<?php
    
	$contadoor=0;
	$CountCartera=0;
    if ($dx!="") {
        $diag="AND d.Descripcion_DGN like '%".$dx."%'";
    } else {
        $diag="";
    }
	$SQL="SELECT c.Codigo_DGN, d.Descripcion_DGN, COUNT(b.Codigo_ADM) FROM hcfolios a, hcdiagnosticos c, gxadmision b, gxdiagnostico d WHERE a.Codigo_HCF =c.Codigo_HCF AND a.Codigo_TER=c.Codigo_TER AND b.Estado_ADM<>'A' AND b.Codigo_ADM=a.Codigo_ADM AND d.Codigo_DGN=c.Codigo_DGN ".$diag." AND a.Fecha_HCF BETWEEN '".$fechaini."'  AND '".$fechafin."' GROUP BY c.Codigo_DGN, d.Descripcion_DGN ORDER BY 3 DESC, 2 ASC LIMIT ".$limitsql;
    $datax="";
    $result1 = mysqli_query($conexion, $SQL);
    $sedex="";
    while($row1 = mysqli_fetch_array($result1)) {
        $contadoor++;
       echo '<tr><td width="10px"> '.$row1[0].' </td><td style="font-size:10px;">'.$row1[1].'</td><td align="right">'.$row1[2].'</td></tr>';
       $CountCartera=$CountCartera+$row1[2];
    }
    mysqli_free_result($result1);
    $promedio=$CountCartera/$contadoor;
    ?>
    		<tr><td colspan="2"><b>T O T A L</b></td><td align="right"><b> <?php echo $CountCartera; ?></td></tr>
				</tbody>
				</table><input name="hdn_controwlun<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwlun<?php echo $NumWindow; ?>" value="0" />
			</div>	
            <div class="row">
              <div class="visible-print-inline-block col-md-12">
                <hr>
                <p style="color: #B0B0B0; font-family: times; text-align: right; font-size: 9px;">
                    <em>Información suministrada por <b>GenomaX</b> para <b><span id="Nempresa<?php echo $NumWindow; ?>"></span></b></em>
                </p>
              </div>
              <div class="col-xs-6">
                <button type="button" class="btn btn-success btn-block hidden-print" title="Imprimir" data-toggle="modal"  onclick="printwndw('<?php echo $NumWindow; ?>', 'DIAGNÓSTICOS EN UN PERIODO')"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </button>
              </div>
              <div class="col-xs-6">
                <button type="button" class="btn btn-success btn-block hidden-print" title="Exportar" data-toggle="modal" data-target="#GnmX_WinModal" onclick="printcartedad<?php echo $NumWindow; ?>()"> <span class="glyphicon glyphicon-save-file" aria-hidden="true"></span> </button>
              </div>
            </div>
		</div>
	</div>

</form>

<script >
NEmpresa('<?php echo $NumWindow; ?>');

function veriffechas<?php echo $NumWindow; ?>() {
    fechaini=document.getElementById('txt_fechaini<?php echo $NumWindow; ?>').value;
    fechafin=document.getElementById('txt_fechafin<?php echo $NumWindow; ?>').value;
    limitex=document.getElementById('txt_limitex<?php echo $NumWindow; ?>').value;
    dx=document.getElementById('txt_dx<?php echo $NumWindow; ?>').value;
    if (fechaini>fechafin) {
        MsgBox1("Error en Fechas", "La fecha final debe ser mayor o igual a la fecha final");
    } else {
        AbrirForm('application/forms/nxsstatptesdx.php', '<?php echo $NumWindow; ?>', '&fechaini='+fechaini+'&fechafin='+fechafin+'&limitex='+limitex+'&dx='+dx);
    }
}

function printcartedad<?php echo $NumWindow; ?>() {
    <?php
    $SQL="Select Nombre_ITM, Enlace_ITM, Icono_ITM From nxs_gnx.ititems Where Codigo_ITM='520';";
    $resulthc = mysqli_query($conexion, $SQL);
    if ($rowhc = mysqli_fetch_array($resulthc)) 
        {
    ?>
    CargarWind('<?php echo $rowhc[0]; ?>', '<?php echo $rowhc[1]; ?>', '<?php echo $rowhc[2]; ?>', 'nxsstatptesdx.php','<?php echo $NumWindow; ?>' );
    <?php
        }
    mysqli_free_result($resulthc); 
    ?>
}

<?php

    if ($dx!="") {
        $diag="AND d.Descripcion_DGN like '%".$dx."%'";
    } else {
        $diag="";
    }
    $SQL="SELECT c.Codigo_DGN, d.Descripcion_DGN, COUNT(b.Codigo_ADM) FROM hcfolios a, hcdiagnosticos c, gxadmision b, gxdiagnostico d WHERE a.Codigo_HCF =c.Codigo_HCF AND a.Codigo_TER=c.Codigo_TER AND b.Estado_ADM<>'A' AND b.Codigo_ADM=a.Codigo_ADM AND d.Codigo_DGN=c.Codigo_DGN ".$diag." AND a.Fecha_HCF BETWEEN '".$fechaini."'  AND '".$fechafin."' GROUP BY c.Codigo_DGN, d.Descripcion_DGN ORDER BY 3 DESC, 2 ASC LIMIT ".$limitsql;
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
Loadgxpctesdx'.$NumWindow.'("grappctedx'.$NumWindow.'");

function Loadgxpctesdx'.$NumWindow.'(deztino)
{
    Highcharts.chart(deztino, {
  chart: {
    type: \'bar\'
  },
  title: {
    style: {
            color: \'#729d3b\',
            fontWeight: \'bold\',
            fontSize: \'15px\'
        },
    text: \''.$limitsql.' Diagnósticos más Frecuentes\'
  },
  subtitle: {
        style: {
            color: \'#729d3b\'
        },
        text: \'Periodo: '.$fechaini.' - '.$fechafin.'\'
    },
  colors: [ \'#803220\', \'#60E747\', \'#32C018\', \'#60E747\', \'#32C018\', \'#60E747\',\'#90ee7e\',\'#32C018\',\'#60E747\',   \'#32C018\'],
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
}
';
?>

var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;
    matches = [];
    substrRegex = new RegExp(q, 'i');
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });
    cb(matches);
  };
};

<?php
$nombres="";
$SQL="SELECT trim(a.Descripcion_DGN) FROM gxdiagnostico a where a.Codigo_DGN in (select distinct Codigo_DGN from hcdiagnosticos) ORDER BY 1";
$resultx=mysqli_query($conexion,$SQL);
  while ($rowx=mysqli_fetch_array(($resultx))) {
    $nombres=$nombres."'".$rowx[0]."',";
  }
  mysqli_free_result($resultx);
  $nombres=$nombres."''";
?>
var nombres = [<?php echo $nombres; ?>];
$('#txt_dx<?php echo $NumWindow; ?>').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'nombres',
  source: substringMatcher(nombres)
  }).on('typeahead:selected', function(e) {
    var result = $('#txt_dx<?php echo $NumWindow; ?>').val();
});


    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    $(".twitter-typeahead").addClass("form-control");
    

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
