<?php
	include '../../functions/php/nexus/buscarsql.php';
	
session_start();	
?>
<form action="" method="post" name="frm_searchNxs" id="frm_searchNxs" class="form-inline container row">
<div class="col-md-4">
  
  <select name="cmb_camposNxs" id="cmb_camposNxs"  onchange="javascript:document.frm_searchNxs.txt_buscarNxs.focus();" class="form-control form-select">
    <?php 
$SQL="Select ".$SQL." and 1=0";
$SQLx="Select ".$SQLx." and 1=0";
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
mysqli_query ($conexion, "SET NAMES 'utf8'");

$result = mysqli_query($conexion, $SQL);
$resultx = mysqli_query( $conexion, $SQLx);
$totalcols = mysqli_num_fields($result);
$contacols=0;

while ($finfo = mysqli_fetch_field($result)) {
  $info_campo = $resultx->fetch_field_direct($contacols);
    $contacols++;
?>
  <option value=<?php echo '"'.$info_campo->name.'"'; if ($contacols==2) {echo ' selected ';} ?>><?php echo $finfo->name; ?></option>
<?php
}
mysqli_free_result($result); 
mysqli_free_result($resultx); 
 ?>
  </select>
</div>
<div class="col-md-4">

    <select name="cmb_criterioNxs" id="cmb_criterioNxs"  onchange="javascript:document.frm_searchNxs.txt_buscarNxs.focus();" class="form-control form-select">
      <option value="igual">Igual a </option>
      <option value="contenga">Contenga </option>
      <option value="empiece" selected="selected">Empiece por </option>
      <option value="finalice">Finalice en </option>
      <option value="diferente">Diferente a </option>
      <option value="notenga">No Contenga</option>
    </select>
</div>
<div class="col-md-4">

    <input type="text" name="txt_buscarNxs" id="txt_buscarNxs"  onkeypress="valSearch(event)" class="form-control">
</div>
<div class="col-md-12">  
    <div id="loadsearchNxs" title="Buscando..." class="loadsearch" style="visibility:hidden" ></div>
</div>
    <div id="resultadosNxs" class="zerosearch"></div>
    <div class="form-group">
      <label for="txt_nombreSel">Selección</label>
      <input name="txt_selSearch" type="text" disabled id="txt_selSearch" class="form-control">
    </div>
<input name="hdn_TargetNxs" type="hidden" id="hdn_TargetNxs" value="<?php echo $_GET['box']; ?>" />
</form>
<script>
document.frm_searchNxs.txt_buscarNxs.focus();
function SelSearch(Valor){
	document.frm_searchNxs.txt_selSearch.value=Valor;
}
function valSearch(e){
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
    document.getElementById('loadsearchNxs').style.visibility='visible';
    document.getElementById('resultadosNxs').innerHTML='<div class="center-block"><img src="http://cdn.genomax.co/media/image/loading.gif" class="img-responsive" alt="Cargando..." align="center"></div>';
    ExecSearch(document.getElementById('txt_buscarNxs').value, document.getElementById('cmb_criterioNxs').value, document.getElementById('cmb_camposNxs').value, '<?php echo $_GET['req']; ?>', '<?php echo $_GET['cond']; ?>');
    document.getElementById('loadsearchNxs').style.visibility='hidden';
    
  }
}
</script>