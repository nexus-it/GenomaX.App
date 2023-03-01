<?php
session_start();
  $NumWindow=$_GET["target"];
  // include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php'; 
  include '../../functions/php/nexus/database.php'; 
  $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
  mysqli_query ($conexion, "SET NAMES 'utf8'"); 
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">
  
  <label class="label label-success"> Editar Tarifa  </label>
  <div class="row well well-sm">
    <div class="col-md-1 col-sm-2">

  <div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
    <label for="txt_codigo<?php echo $NumWindow; ?>">Código</label>
    <input name="txt_codigo<?php echo $NumWindow; ?>" id="txt_codigo<?php echo $NumWindow; ?>" type="text" required  />
  </div>

    </div>
    <div class="col-md-4 col-sm-4">

  <div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
    <label for="txt_nombre<?php echo $NumWindow; ?>">Tarifa</label>
    <input name="txt_nombre<?php echo $NumWindow; ?>" id="txt_nombre<?php echo $NumWindow; ?>" type="text" required  />
  </div>

    </div>
    <div class="col-md-2 col-sm-6">

  <div class="form-group" id="grp_txt_idhc3<?php echo $NumWindow; ?>">
    <label for="cmb_tipo<?php echo $NumWindow; ?>">Tipo</label>
    <select name="cmb_tipo<?php echo $NumWindow; ?>" id="cmb_tipo<?php echo $NumWindow; ?>">
      <option value="SOAT">SOAT</option>
      <option value="ISS2001">ISS2001</option>
    </select>
  </div>

    </div>
    <div class="col-md-3 col-sm-3">

  <div class="form-group">
    <label for="cmb_base<?php echo $NumWindow; ?>">Tarifa Base</label>
    <select name="cmb_base<?php echo $NumWindow; ?>" id="cmb_base<?php echo $NumWindow; ?>">
      <option value="">- Ninguna -</option>
    <?php 
  $SQL="Select a.Codigo_TAR, a.Nombre_TAR  from gxtarifas a Order By 2";
  $result = mysqli_query($conexion, $SQL);
  while($row = mysqli_fetch_array($result)) 
    {
   ?>
    <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
  <?php
    }
  mysqli_free_result($result); 
   ?>  
    </select>
  </div>
  
    </div>
    <div class="col-md-2 col-sm-2">

  <div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
    <label for="txt_variacion<?php echo $NumWindow; ?>">Porcentaje</label>
      <div class="input-group">
    <input name="txt_variacion<?php echo $NumWindow; ?>" id="txt_variacion<?php echo $NumWindow; ?>" type="number" required value="0"  max="300" />
    <span class="input-group-addon" id="badn<?php echo $NumWindow; ?>">%</span>
      </div>
  </div>

    </div>
    
    <div class="col-md-12" id="btn_save<?php echo $NumWindow; ?>">
      <button type="button" class="btn btn-success btn-sm btn-block" onclick="javascript:Save<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> GUARDAR</button>
    </div>
  </div>

  <label class="label label-success">
    <i class="fas fa-plus"></i> Manuales Tarifarios
  </label>
  <div class="row well well-sm">
    <div class="col-md-12">
      <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive "  >
        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetMT<?php echo $NumWindow; ?>" >
        <tbody id="tbDetallemt<?php echo $NumWindow; ?>">
        <tr> 
          <th>Codigo</th>
          <th>Nombre Tarifa</th>
          <th>Tipo</th>
          <th>Tarifa Base</th>
          <th >Variación</th>
          <th >Ver Servicios</th>
        </tr>
        <?php 
        $SQL="Select a.Codigo_TAR, a.Nombre_TAR, a.Tipo_TAR, b.Nombre_TAR, ((a.Variacion_TAR*100)-100) from gxtarifas a left outer join gxtarifas b on a.Base_TAR=b.Codigo_TAR Order By 1 ";
        $contafila=0;
        $result = mysqli_query($conexion, $SQL);
        while ($row = mysqli_fetch_array($result)) {
          if ($row[4]<0) {
            $varope="";
          } else {
            $varope="+ ";
          }
          echo '<tr>
          <td onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">'.$row[0].'</td>
          <td onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">'.$row[1].'</td>
          <td onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">'.$row[2].'</td>
          <td onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">'.$row[3].'</td>
          <td onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">'.$varope.round($row[4]).'%</td>
          <td align="center" >
            <button class="btn btn-success btn-sm" type="button" title="Ver Valores de Servicios de la Tarifa: '.$row[1].'" data-toggle="modal" data-target="#GnmX_WinModal" onclick="javascript:ShowTarifa'.$NumWindow.'(\''.$row[0].'\', \''.$row[1].'\')"> <span class="glyphicon glyphicon-th-list" aria-hidden="true" ></span> 
            </button>
          </td>
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
  if (isset($_GET["CodigoTAR"])) {
    echo "
      document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["CodigoTAR"]."';
    ";
  $SQL="Select a.Codigo_TAR, a.Nombre_TAR, a.Tipo_TAR, Base_TAR, ((a.Variacion_TAR*100)-100) from gxtarifas a where Codigo_TAR='".$_GET["CodigoTAR"]."'";
  $result = mysqli_query($conexion, $SQL);
  if($row = mysqli_fetch_array($result)) {
    echo "
      document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".$row[1]."';
      document.frm_form".$NumWindow.".cmb_tipo".$NumWindow.".value='".$row[2]."';    
      document.frm_form".$NumWindow.".cmb_base".$NumWindow.".value='".$row[3]."';
      document.frm_form".$NumWindow.".txt_variacion".$NumWindow.".value='".round($row[4])."';
    ";
    }
  mysqli_free_result($result); 
  echo "document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".focus();";
  } 
?>

function ShowTarifa<?php echo $NumWindow; ?>(Tarifa, Nombre) {
  CargarWind('Manual Tarifario ['+Tarifa+'] '+Nombre, 'forms/tarifas.php?tarifa='+Tarifa, 'blogs.png', 'mantarifas.php','<?php echo $NumWindow; ?>' );
}

function ReLoad<?php echo $NumWindow; ?>(Tarifa) {
  AbrirForm('application/forms/mantarifas.php', '<?php echo $NumWindow; ?>', '&CodigoTAR='+Tarifa);
}

function Save<?php echo $NumWindow; ?>() {
  Guardar_mantarifas('<?php echo $NumWindow; ?>');
}

  $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
  $("textarea").addClass("form-control");
  $("select").addClass("form-control");
  $("input[type=date]").addClass("form-control");
  $("input[type=number]").addClass("form-control");
  $("input[type=time]").addClass("form-control");

</script>
<script src="functions/nexus/mantarifas.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
