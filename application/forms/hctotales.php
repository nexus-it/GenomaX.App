<?php

session_start();
  $NumWindow=$_GET["target"];
  include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php'; 
  include '../../functions/php/nexus/database.php'; 
  $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
  mysqli_query ($conexion, "SET NAMES 'utf8'");  
?>
<div class="well well-sm container-fluid">
  <div class="row">
<?php
  $SQL="SELECT a.Codigo_TER, d.Sigla_TID, b.ID_TER, trim(b.Nombre_TER), c.Codigo_SEX, c.FechaNac_PAC, COUNT(a.Codigo_HCF) FROM hcfolios a, czterceros b, gxpacientes c, cztipoid d WHERE a.Codigo_TER=b.Codigo_TER AND b.Codigo_TER=c.Codigo_TER AND d.Codigo_TID=b.Codigo_TID GROUP BY a.Codigo_TER, d.Sigla_TID, b.ID_TER, b.Nombre_TER, c.Codigo_SEX, c.FechaNac_PAC ORDER BY 4";
  $result = mysqli_query($conexion, $SQL);
  while ($row = mysqli_fetch_row($result)) {
    $imgsexo='<img src="themes/ghenx/img/icons/16x16/user_female.png">';
    if ($row[4]=="M") {
      $imgsexo='<img src="themes/ghenx/img/icons/16x16/user.png">';
    }
    echo '<div class="col-sm-2">
    <button type="button" class="btn btn-default btn-sm btn-block" onclick="ShowFolio'.$NumWindow.'(\''.$row[2].'\')" role="button">'.$row[1].' <strong>'.$row[2].'</strong> '.$imgsexo.'<br><small>'.$row[3].'</small></button>
    </div>';
  }
  mysqli_free_result($result);

?>  
  </div>
</div>
<script type="text/javascript">
  function ShowFolio<?php echo $NumWindow; ?>(Tercero) {
    /*
    $('#GnmX_WinModal').modal('show');
    CargarWind('HC '+Tercero, 'reports/hc.php?HISTORIA='+Tercero+'&FOLIO_INICIAL=1&FOLIO_FINAL=99999', 'default.png', 'hc.php','<?php echo $NumWindow; ?>' );
    */
    ruta='application/reports/hc?HISTORIA='+Tercero+'&FOLIO_INICIAL=1&FOLIO_FINAL=99999&download=D';
    window.open(ruta, "HC Download", "width=300, height=200");
  }
</script>