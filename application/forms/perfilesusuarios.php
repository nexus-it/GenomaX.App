<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	function MostrarItems($conn, $Aplicacion, $Modulo, $Menu, $Item, $Prefijo, $NumWindow1)
	{
		$SQL="Select Codigo_ITM, Nombre_ITM, Enlace_ITM from nxs_gnx.ititems where Activo_ITM='1' and Codigo_APP='".$Aplicacion."' and Codigo_MOD='".$Modulo."' and Codigo_MNU='".$Menu."' and Padre_ITM='".$Item."' order by Codigo_ITM;";	
//		echo $SQL;
		$resultXY = mysqli_query($conn, $SQL);
		while($rowXY = mysqli_fetch_array($resultXY)) 
		{
//			$Datos[]=$rowXY;
			if ($rowXY[2]=="#") {
				MostrarItems($conn, $Aplicacion, $Modulo, $Menu, $rowXY[0], $rowXY[1].' | ', $NumWindow1);
			} else {
				echo '
					<tr >
					  <td align="center" width="24"><strong>::</strong></td>
					  <td align="left" >'.($Prefijo.$rowXY["Nombre_ITM"]).'    </td>
					  <td align="center" width="24"><input type="checkbox"  name="chk_permiso'.$rowXY["Codigo_ITM"].$NumWindow1.'"  id="chk_permiso'.$rowXY["Codigo_ITM"].$NumWindow1.'" value="0" onclick="javascript: ChangeValue'.$NumWindow1.'(this);" /></td>
					</tr>
				';
			}
		}
		mysqli_free_result($resultXY);
//		return $Datos;	
	}
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-inline container row">
<div class="form-group col-1">
	<label for="txt_perfil<?php echo $NumWindow; ?>" class="form-label">Perfil</label>
	<div class="input-group">
		<input name="txt_perfil<?php echo $NumWindow; ?>" type="text" id="txt_perfil<?php echo $NumWindow; ?>" class="form-control" placeholder="Perfil" onkeypress="BuscarPerfil<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Perfiles', 'txt_perfil<?php echo $NumWindow; ?>', 'NULL')};">
		<span class="input-group-btn">
			<button class="btn btn-outline-secondary btn-success" type="button" data-bs-toggle="modal" data-bs-target="#GnmX_Search" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Perfil" onclick="javascript:CargarSearch('Perfiles', 'txt_perfil<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i> </button>
		</span>
	</div>
</div>
<div class="form-group col-9">
	<label for="txt_nombreperfil<?php echo $NumWindow; ?>" class="form-label">Nombre</label>	
	<input name="txt_nombreperfil<?php echo $NumWindow; ?>" type="text" id="txt_nombreperfil<?php echo $NumWindow; ?>" size="50" class="form-control"/>
</div>
<div class="form-group col-2">
  <label for="cmb_estado<?php echo $NumWindow; ?>" class="form-label">Estado</label>
  <select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>" class="form-control form-select">
    <option value="1" selected="selected">Activo</option>
    <option value="0">Inactivo</option>
  </select>
</div>
<div class="form-group col-2">
  <label for="txt_perfilx<?php echo $NumWindow; ?>" class="form-label"><i class="fas fa-copy"></i> </label>
  <div class="input-group col-xs-2">
  	<input name="txt_perfilx<?php echo $NumWindow; ?>" type="text" id="txt_perfilx<?php echo $NumWindow; ?>" onkeypress="BuscarPerfil2<?php echo $NumWindow; ?>(event);" onkeydown="if(event.keyCode==115){CargarSearch('Perfiles2', 'txt_perfil<?php echo $NumWindow; ?>', 'Codigo_PRF<>*'+document.frm_form<?php echo $NumWindow; ?>.txt_perfil<?php echo $NumWindow; ?>.value+'*')};" class="form-control"/>
  	<span class="input-group-btn">
      <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Perfiles" onclick="javascript:CargarSearch('Perfiles2', 'txt_perfilx<?php echo $NumWindow; ?>', 'Codigo_PRF<>*'+document.frm_form<?php echo $NumWindow; ?>.txt_perfil<?php echo $NumWindow; ?>.value+'*');"><i class="fas fa-search"></i></button>
    </span>
  </div>
</div>
<div class="form-group col-6">
  <label for="txt_nombreperfilx<?php echo $NumWindow; ?>" class="form-label">Copiar permisos de </label>
  <div class="input-group col-xs-6">
  	<input name="txt_nombreperfilx<?php echo $NumWindow; ?>" type="text" id="txt_nombreperfilx<?php echo $NumWindow; ?>" class="form-control" />
  	<span class="input-group-btn">
      <button class="btn btn-success" type="button" onclick="javascript:BuscarPerfilX<?php echo $NumWindow; ?>();">Cargar Perfil <span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span></button>
    </span>
  </div>
</div>

<div class="panel panel-default row">
 <?php  ?>
<?php 
	//Aplicaciones
	$SQL="Select Codigo_APP, Nombre_APP, Descripcion_APP From nxs_gnx.itaplicaciones Where Activo_APP='1' and Codigo_APP='".$_SESSION["NEXUS_APP"]."' Order By Codigo_APP";
	$resultX = mysqli_query($conexion, $SQL);
	//echo $SQL;
	while($rowX = mysqli_fetch_array($resultX)) {
		echo '<div class="panel-group" id="div_'.str_replace(" ","_",$rowX[1])."_".$rowX[0].'xAPP" role="tablist">
    	<div class="panel-heading"><h3><span class="label label-success">Permisos '.($rowX[1]).'</span></h3></div>
			<div class="panel-body">
				<div id="zero_detalle'.$NumWindow.'" >';
		//Modulos
		$SQL="Select Codigo_MOD, Nombre_MOD from nxs_gnx.itmodulos where Activo_MOD='1' and Codigo_APP='".$rowX[0]."' order by Codigo_MOD";
		$resultXX = mysqli_query($conexion, $SQL);
		while($rowXX = mysqli_fetch_array($resultXX)) {
				echo '
		<div class="panel panel-warning">
		    <div class="panel-heading manito" role="tab" id="div_'.str_replace(" ","_",$rowXX[1])."_".$rowXX[0].'x" onclick="SwapMenu'.$NumWindow.'(\'div_'.str_replace(" ","_",$rowXX[1])."_".$rowXX[0].'\');">
		      <h4 class="panel-title">
		        <span role="button">MODULO: '.($rowXX[1]).'</span>
		      </h4>
		    </div>
';
			//Menus
				echo '
			<div id="div_'.str_replace(" ","_",$rowXX[1])."_".$rowXX[0].'" >';
			
			$SQL="Select Codigo_MNU, Nombre_MNU from nxs_gnx.itmenu where Activo_MNU='1' and Codigo_APP='".$rowX[0]."' and Codigo_MOD='".$rowXX[0]."' order by Codigo_MNU;";
			$resultXXX = mysqli_query($conexion, $SQL);
			while($rowXXX = mysqli_fetch_array($resultXXX)) {
			
				echo '<div class="panel panel-success">
    <div class="panel-heading manito" role="tab" id="div_'.str_replace(" ","_",$rowXXX[1])."_".$rowXXX[0].'x" >
      <h3 class="panel-title">
        <span role="button" onclick="SwapMenu'.$NumWindow.'(\'div_'.str_replace(" ","_",$rowXXX[1])."_".$rowXXX[0].'\');">Men&uacute;: <em>'.($rowXXX[1]).'</em></span>
        <input type="hidden" name="hdn_chkall'.$rowXXX[0].$NumWindow.'" id="hdn_chkall'.$rowXXX[0].$NumWindow.'" value="0">
        <button type="button" class="btn btn-success btn-sm pull-right" onclick="MarcarChk'.$NumWindow.'(\''.$rowXXX[0].'\');"> <span class="glyphicon glyphicon-check" aria-hidden="true"> </span></button>
      </h3>
    </div>

    		<div id="div_'.str_replace(" ","_",$rowXXX[1])."_".$rowXXX[0].'" >
';
?>		
            <table border="0" align="center" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle1 tblDetalle">
<?php
            MostrarItems($conexion,$rowX[0], $rowXX[0], $rowXXX[0], '0', '', $NumWindow);
?>
			</table>
                <?php
				echo '</div></div>';
			}
			mysqli_free_result($resultXXX);
			
			echo '</div></div>
			';
		}
		mysqli_free_result($resultXX);
		
		echo '</div>';
	}
	mysqli_free_result($resultX);
	
?>     
</div>
 </div>
</div>
</div>
</form>
<script >

$(":input:text:visible:first", "#frm_form<?php echo $NumWindow; ?>").focus();
<?php
	$ThePerfil=0;
	if (isset($_GET["Perfil"])) {	
	$SQL="Select Nombre_PRF from itperfiles where trim(Codigo_PRF)=trim('".$_GET["Perfil"]."');";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_nombreperfil".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".txt_perfil".$NumWindow.".value='".$_GET["Perfil"]."';
	";
	$ThePerfil=$_GET["Perfil"];
	
	}
	else {
		echo "
		MsgBox1('Perfiles de usuario','No se encuentra el perfil digitado [".$_GET["Perfil"]."]. Para crear uno nuevo deje el código en blanco y coloque el nombre del nuevo perfil.');
		";
	}
	mysqli_free_result($result); 
	}
	if (isset($_GET["PerfilX"])) {	
	$SQL="Select Nombre_PRF from itperfiles where trim(Codigo_PRF)=trim('".$_GET["PerfilX"]."');";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
	echo "
		document.frm_form".$NumWindow.".txt_nombreperfilx".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".txt_perfilx".$NumWindow.".value='".$_GET["PerfilX"]."';
	";
	$ThePerfil=$_GET["PerfilX"];
	
	}
	else {
		echo "
		MsgBox1('Perfiles de usuario','No se encuentra el perfil digitado ".$_GET["PerfilX"]."');
		";
	}
	mysqli_free_result($result); 
	}
	
	if ($ThePerfil!='0') {
		$SQL="Select a.Codigo_ITM From itpermisos a, nxs_gnx.ititems b, nxs_gnx.itaplicaciones c Where b.Codigo_APP=c.Codigo_APP and Activo_ITM='1' and Enlace_ITM<>'#' and a.Codigo_ITM=b.Codigo_ITM and c.Activo_APP='1' and a.Codigo_PRF='".$ThePerfil."'";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) {
			echo"
document.frm_form".$NumWindow.".chk_permiso".$row[0].$NumWindow.".checked=true;
document.frm_form".$NumWindow.".chk_permiso".$row[0].$NumWindow.".value='1';";
		}
		mysqli_free_result($result); 
	}
?>

function BuscarPerfilX<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/perfilesusuarios.php', '<?php echo $NumWindow; ?>', '&PerfilX='+document.getElementById('txt_perfilx<?php echo $NumWindow; ?>').value+'&Perfil='+document.getElementById('txt_perfil<?php echo $NumWindow; ?>').value);
}

function BuscarPerfil2<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	BuscarPerfilX('<?php echo $NumWindow; ?>', document.getElementById('txt_perfilx<?php echo $NumWindow; ?>').value);
  }
}

function BuscarPerfil<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	AbrirForm('application/forms/perfilesusuarios.php', '<?php echo $NumWindow; ?>', '&Perfil='+document.getElementById('txt_perfil<?php echo $NumWindow; ?>').value);
  }
}

function ShowDiv<?php echo $NumWindow; ?>(NombreDiv) {
	alert (NombreDiv);
	if (document.getElementById(NombreDiv).style.display=='none') {
		document.getElementById(NombreDiv).style.display='block'
		}
	else {
		document.getElementById(NombreDiv).style.display='none'
		}
}
function SwapMenu<?php echo $NumWindow; ?>(id){
    if(document.getElementById(id).style.display=='none'){
    document.getElementById(id).style.display='';
    }else{
    document.getElementById(id).style.display='none';
    }
}
function ChangeValue<?php echo $NumWindow; ?>(objeto) 
{
	if (objeto.value=="1") {
		objeto.value="0";
	} else {
		objeto.value="1";
	}
}
function MarcarChk<?php echo $NumWindow; ?>(Menu) 
{
	var chequeo<?php echo $NumWindow; ?>=false;
	if (document.getElementById('hdn_chkall'+Menu+'<?php echo $NumWindow; ?>').value=='0') {
		document.getElementById('hdn_chkall'+Menu+'<?php echo $NumWindow; ?>').value='1';
		elvalor<?php echo $NumWindow; ?>='1';
		chequeo<?php echo $NumWindow; ?>=true;
	} else {
		document.getElementById('hdn_chkall'+Menu+'<?php echo $NumWindow; ?>').value='0';
		elvalor<?php echo $NumWindow; ?>='0';
		chequeo<?php echo $NumWindow; ?>=false;
	}
<?php
$MiMenu="";
$SQL="Select b.Codigo_MNU, b.Codigo_ITM From nxs_gnx.ititems b, nxs_gnx.itaplicaciones c Where b.Codigo_APP=c.Codigo_APP and Activo_ITM='1' and Enlace_ITM<>'#' and c.Activo_APP='1' Order By 1,2";
$result = mysqli_query($conexion, $SQL);
echo '	switch  (Menu) {
	';
while($row = mysqli_fetch_array($result)) {
	if ($MiMenu!=$row[0]) {
		if ($MiMenu!='') {
			echo 'break
';
		}
		echo 'case "'.$row[0].'":
		';
		$MiMenu=$row[0];
	}
	echo "
		eval('document.frm_form".$NumWindow.".chk_permiso".$row[1].$NumWindow.".checked=chequeo".$NumWindow."');
		document.frm_form".$NumWindow.".chk_permiso".$row[1].$NumWindow.".value=elvalor".$NumWindow.";
	";
}
echo '
}
';
mysqli_free_result($result);
?>
}
</script>
