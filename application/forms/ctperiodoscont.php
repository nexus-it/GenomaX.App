<?php
session_start();
  $NumWindow=$_GET["target"];
  // include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php'; 
  include '../../functions/php/nexus/database.php'; 
  $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
  mysqli_query ($conexion, "SET NAMES 'utf8'"); 
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">
  
  <label class="label label-success"> Editar Periodo  </label>
  <div class="row well well-sm">
    <div class="col-md-1 col-sm-2">

  <div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
    <label for="txt_codigo<?php echo $NumWindow; ?>">Código</label>
    <input name="txt_codigo<?php echo $NumWindow; ?>" id="txt_codigo<?php echo $NumWindow; ?>" type="text" required length="6" maxlength="6" />
  </div>

    </div>
    <div class="col-md-3 col-sm-3">

  <div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
    <label for="txt_nombre<?php echo $NumWindow; ?>">Nombre</label>
    <input name="txt_nombre<?php echo $NumWindow; ?>" id="txt_nombre<?php echo $NumWindow; ?>" type="text" required  />
  </div>

    </div>
    <div class="col-md-2 col-sm-6">

  <div class="form-group" id="grp_txt_idhc3<?php echo $NumWindow; ?>">
    <label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicial</label>
    <input name="txt_fechaini<?php echo $NumWindow; ?>" id="txt_fechaini<?php echo $NumWindow; ?>" type="date" required  />
  </div>

    </div>
    <div class="col-md-2 col-sm-6">

  <div class="form-group" id="grp_txt_idhc3<?php echo $NumWindow; ?>">
    <label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Final</label>
    <input name="txt_fechafin<?php echo $NumWindow; ?>" id="txt_fechafin<?php echo $NumWindow; ?>" type="date" required  />
  </div>

    </div>
    <div class="col-md-1 col-sm-3">

  <div class="form-group" id="grp_txt_idhc3<?php echo $NumWindow; ?>">
    <label for="txt_periodoant<?php echo $NumWindow; ?>">P. Anterior</label>
    <input name="txt_periodoant<?php echo $NumWindow; ?>" id="txt_periodoant<?php echo $NumWindow; ?>" type="text"   />
  </div>

    </div>
    <div class="col-md-1 col-sm-3">

  <div class="form-group" id="grp_txt_idhc3<?php echo $NumWindow; ?>">
    <label for="txt_periodosig<?php echo $NumWindow; ?>">P. Siguiente</label>
    <input name="txt_periodosig<?php echo $NumWindow; ?>" id="txt_periodosig<?php echo $NumWindow; ?>" type="text"   />
  </div>

    </div>
    <div class="col-md-2 col-sm-2">

  <div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
    <label for="cmb_estado<?php echo $NumWindow; ?>">Estado</label>
    <select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>" >
    <option value="A">Abierto</option>
    <option value="C">Cerrado</option>
    </select>
  </div>

    </div>
    
    <div class="col-md-12" id="btn_save<?php echo $NumWindow; ?>">
      <button type="button" class="btn btn-success btn-sm btn-block" onclick="javascript:Save<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> GUARDAR</button>
    </div>
  </div>

  <label class="label label-success">
    <i class="fas fa-plus"></i> Periodos Contables
  </label>
  <div class="row well well-sm">
    <div class="col-md-12">
      <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style="height: 50%;" >
        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetMT<?php echo $NumWindow; ?>" >
        <tbody id="tbDetallemt<?php echo $NumWindow; ?>">
        <tr> 
          <th>Codigo</th>
          <th>Nombre Periodo</th>
          <th>Fecha Inicial</th>
          <th>Fecha Final</th>
          <th >Periodo Anterior</th>
          <th >Periodo Siguiente</th>
          <th >Abierto</th>
        </tr>
        <?php 
        $SQL="Select Codigo_PCT, Nombre_PCT, FechaIni_PCT, FechaFin_PCT, Anterior_PCT, Siguiente_PCT, Estado_PCT from czperiodoscont Order By 1 desc";
        $contafila=0;
        $result = mysqli_query($conexion, $SQL);
        while ($row = mysqli_fetch_array($result)) {
          if ($row[6]=="A") {
            $varchk=" checked ";
          } else {
            $varchk="";
          }
          echo '<tr>
          <td onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">'.$row[0].'</td>
          <td onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">'.$row[1].'</td>
          <td onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">'.$row[2].'</td>
          <td onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">'.$row[3].'</td>
          <td onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">'.$row[4].'</td>
          <td onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">'.$row[5].'</td>
          <td onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');"><div class="checkbox checkbox-success" style="padding-top: 4px; height: 24px;"> <input name="chk_'.$row[0].$NumWindow.'" id="chk_'.$row[0].$NumWindow.'" type="checkbox" value="'.$row[6].'"  class="styled" disabled '.$varchk.' ><label for="chk_'.$row[0].$NumWindow.'"></label> </div></td>
          </tr>';
        }
        mysqli_free_result($result);
        ?>
        </tbody>
        </table>
      </div>
    </div>
  </div>

</form>

<script >
<?php
  if (isset($_GET["CodigoPCT"])) {
    echo "
      document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["CodigoPCT"]."';
    ";
  $SQL="Select Codigo_PCT, Nombre_PCT, date(FechaIni_PCT), date(FechaFin_PCT), Anterior_PCT, Siguiente_PCT, Estado_PCT from czperiodoscont where Codigo_PCT='".$_GET["CodigoPCT"]."'";
  $result = mysqli_query($conexion, $SQL);
  if($row = mysqli_fetch_array($result)) {
    echo "
      document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".$row[1]."';
      document.frm_form".$NumWindow.".txt_fechaini".$NumWindow.".value='".$row[2]."';    
      document.frm_form".$NumWindow.".txt_fechafin".$NumWindow.".value='".$row[3]."';
      document.frm_form".$NumWindow.".txt_periodoant".$NumWindow.".value='".$row[4]."';
      document.frm_form".$NumWindow.".txt_periodosig".$NumWindow.".value='".$row[5]."';
      document.frm_form".$NumWindow.".cmb_estado".$NumWindow.".value='".$row[6]."';
    ";
    }
  mysqli_free_result($result); 
  echo "document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".focus();";
  } 
?>

function ReLoad<?php echo $NumWindow; ?>(Periodo) {
  AbrirForm('application/forms/ctperiodoscont.php', '<?php echo $NumWindow; ?>', '&CodigoPCT='+Periodo);
}

function Save<?php echo $NumWindow; ?>() {
  Guardar_periodoscont('<?php echo $NumWindow; ?>');
}

  $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
  $("textarea").addClass("form-control");
  $("select").addClass("form-control");
  $("input[type=date]").addClass("form-control");
  $("input[type=number]").addClass("form-control");
  $("input[type=time]").addClass("form-control");

</script>
<script src="functions/nexus/ctperiodoscont.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
