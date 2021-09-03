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
    
    $SQL="SELECT DISTINCT a.Codigo_MNU, a.Nombre_MNU, COUNT(c.Codigo_ITM) FROM itdashboard k, nxs_gnx.itmenu a, nxs_gnx.ititems b, itpermisos c, itperfiles d, itusuarios e 
WHERE k.Codigo_DSH=a.Codigo_MNU AND k.Reporte_DSH IS not null AND a.Codigo_APP='2' AND c.Codigo_ITM=b.Codigo_ITM AND d.Codigo_PRF=c.Codigo_PRF AND e.Codigo_PRF=d.Codigo_PRF AND b.Codigo_APP='2' AND b.Codigo_MOD=a.Codigo_MOD AND a.Codigo_MNU=b.Codigo_MNU AND e.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' and k.Codigo_DSH in (select Codigo_DSH from itperfildashboard where codigo_prf ='".$_SESSION["it_CodigoPRF"]."') GROUP BY a.Codigo_MNU, a.Nombre_MNU ORDER BY 1 ASC  LIMIT 0,2";
error_log('Dash0: '.$SQL);
     $resultX = mysqli_query($conexion, $SQL);
     $Chardena="";
     $CountDsh=0;
     $ColDsh=0;
     $ClasSection="col-sm-7 connectedSortable";
      if($rowX = mysqli_fetch_array($resultX)) {
        $CountDsh= mysqli_num_rows($resultX);
      }
     mysqli_free_result($resultX);
     $CountDsh=12/$CountDsh;
    $SQL="SELECT DISTINCT a.Codigo_MNU, a.Nombre_MNU, COUNT(c.Codigo_ITM) FROM itdashboard k, nxs_gnx.itmenu a, nxs_gnx.ititems b, itpermisos c, itperfiles d, itusuarios e 
WHERE k.Codigo_DSH=a.Codigo_MNU AND k.Reporte_DSH IS not null AND a.Codigo_APP='2' AND c.Codigo_ITM=b.Codigo_ITM AND d.Codigo_PRF=c.Codigo_PRF AND e.Codigo_PRF=d.Codigo_PRF AND b.Codigo_APP='2' AND b.Codigo_MOD=a.Codigo_MOD AND a.Codigo_MNU=b.Codigo_MNU AND e.Codigo_USR='".$_SESSION["it_CodigoUSR"]."'  and k.Codigo_DSH in (select Codigo_DSH from itperfildashboard where codigo_prf ='".$_SESSION["it_CodigoPRF"]."') GROUP BY a.Codigo_MNU, a.Nombre_MNU ORDER BY 1 ASC  LIMIT 0,2";
error_log('Dash1: '.$SQL);
     $resultX = mysqli_query($conexion, $SQL);
     $Chardena="";
     $ClasSection="col-sm-7 connectedSortable";
      while($rowX = mysqli_fetch_array($resultX)) {
          
          $Chardena=$Chardena.' <section id="nxs_sectiondsh'.$CountDsh.'" class="col-sm-'.$CountDsh.' connectedSortable"> <div class="box box-success"> <div class="box-header" style="color: #729d3b;"> <i class="glyphicon glyphicon-equalizer"  aria-hidden="true"></i> <h3 class="box-title">'.$rowX[1].'</h3> <div class="box-tools pull-right"> <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> </div> </div> <div class="box-body no-padding"> <div class="row"> <div class="col-md-12 col-sm-12"> <div class="chart" id="nxs_'.$rowX[0].'dsh" name="nxs_'.$rowX[0].'dsh" style="height:300px"> </div> </div> </div> </div> </div> </section> ';
        
      }
      mysqli_free_result($resultX);

       
    $SQL="SELECT DISTINCT a.Codigo_MNU, a.Nombre_MNU, COUNT(c.Codigo_ITM) FROM itdashboard k, nxs_gnx.itmenu a, nxs_gnx.ititems b, itpermisos c, itperfiles d, itusuarios e 
WHERE k.Codigo_DSH=a.Codigo_MNU AND k.Reporte_DSH IS not null AND a.Codigo_APP='2' AND c.Codigo_ITM=b.Codigo_ITM AND d.Codigo_PRF=c.Codigo_PRF AND e.Codigo_PRF=d.Codigo_PRF AND b.Codigo_APP='2' AND b.Codigo_MOD=a.Codigo_MOD AND a.Codigo_MNU=b.Codigo_MNU AND e.Codigo_USR='".$_SESSION["it_CodigoUSR"]."'  and k.Codigo_DSH in (select Codigo_DSH from itperfildashboard where codigo_prf ='".$_SESSION["it_CodigoPRF"]."') GROUP BY a.Codigo_MNU, a.Nombre_MNU ORDER BY 1 ASC  LIMIT 2,2";
error_log('Dash2: '.$SQL);
     $resultX = mysqli_query($conexion, $SQL);
     $CountDsh=0;
     $ColDsh=0;
     $ClasSection="col-sm-7 connectedSortable";
      if($rowX = mysqli_fetch_array($resultX)) {
        $CountDsh= mysqli_num_rows($resultX);
      }
     mysqli_free_result($resultX);
     $CountDsh=12/$CountDsh;
    $SQL="SELECT DISTINCT a.Codigo_MNU, a.Nombre_MNU, COUNT(c.Codigo_ITM) FROM itdashboard k, nxs_gnx.itmenu a, nxs_gnx.ititems b, itpermisos c, itperfiles d, itusuarios e 
WHERE k.Codigo_DSH=a.Codigo_MNU AND k.Reporte_DSH IS not null AND a.Codigo_APP='2' AND c.Codigo_ITM=b.Codigo_ITM AND d.Codigo_PRF=c.Codigo_PRF AND e.Codigo_PRF=d.Codigo_PRF AND b.Codigo_APP='2' AND b.Codigo_MOD=a.Codigo_MOD AND a.Codigo_MNU=b.Codigo_MNU AND e.Codigo_USR='".$_SESSION["it_CodigoUSR"]."'  and k.Codigo_DSH in (select Codigo_DSH from itperfildashboard where codigo_prf ='".$_SESSION["it_CodigoPRF"]."') GROUP BY a.Codigo_MNU, a.Nombre_MNU ORDER BY 1 ASC  LIMIT 2,2";
     $resultX = mysqli_query($conexion, $SQL);
     $ClasSection="col-sm-7 connectedSortable";
      while($rowX = mysqli_fetch_array($resultX)) {
          
          $Chardena=$Chardena.' <section id="nxs_sectiondsh'.$CountDsh.'" class="col-sm-'.$CountDsh.' connectedSortable"> <div class="box box-success"> <div class="box-header" style="color: #729d3b;"> <i class="glyphicon glyphicon-equalizer"  aria-hidden="true"></i> <h3 class="box-title">'.$rowX[1].'</h3> <div class="box-tools pull-right"> <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button> </div> </div> <div class="box-body no-padding"> <div class="row"> <div class="col-md-12 col-sm-12"> <div class="chart" id="nxs_'.$rowX[0].'dsh" name="nxs_'.$rowX[0].'dsh" style="height:300px"> </div> </div> </div> </div> </div> </section> ';
        
      }
      mysqli_free_result($resultX);

      echo 'var expan = document.getElementById("nxs_chartboard");
      ';
      echo "expan.innerHTML ='".$Chardena."';";
      
    $SQL="SELECT DISTINCT a.Codigo_MNU, a.Nombre_MNU, k.reporte_dsh FROM itdashboard k, nxs_gnx.itmenu a, nxs_gnx.ititems b, itpermisos c, itperfiles d, itusuarios e WHERE a.Codigo_APP='2' AND k.Reporte_DSH IS not null AND c.Codigo_ITM=b.Codigo_ITM AND d.Codigo_PRF=c.Codigo_PRF AND e.Codigo_PRF=d.Codigo_PRF AND b.Codigo_APP='2' AND b.Codigo_MOD=a.Codigo_MOD AND a.Codigo_MNU=b.Codigo_MNU AND k.Codigo_DSH=a.Codigo_MNU AND e.Codigo_USR='".$_SESSION["it_CodigoUSR"]."'  and k.Codigo_DSH in (select Codigo_DSH from itperfildashboard where codigo_prf ='".$_SESSION["it_CodigoPRF"]."') ORDER BY 1 ASC LIMIT 0,4";
    $resultDSH = mysqli_query($conexion, $SQL);
    while($rowDSH = mysqli_fetch_array($resultDSH)) {
        echo '
        Load'.$rowDSH[2].'("nxs_'.$rowDSH[0].'dsh");';
        include $rowDSH[2].'.php';
    }
    mysqli_free_result($result0);
echo '

';
?>
</script>