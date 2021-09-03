<?php
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	$SQL="Select Nombre_APP from itaplicaciones where Activo_APP='1' and Codigo_APP='".$_SESSION["NEXUS_APP"]."';";
	$resultX = mysqli_query($conexion, $SQL);
	if($rowX = mysqli_fetch_array($resultX)) {
		if (is_file('themes/'.$_SESSION["THEME_DEFAULT"].'/login.php')) {
			include 'themes/'.$_SESSION["THEME_DEFAULT"].'/login.php'; 
		} else {
?>
<div id="head"><div id="logo"></div>:: <?php echo $_SESSION["NOMBRE_APP"]; ?> :: <span id="razonsocial"></span>
</div>
<div class="barmenu" id="barmenu"></div>
<div id="logincontainer">
<?php if (isset($_GET["action"])) { 
	if ($_GET["action"]=="1") {
		$msg_login="Usuario no se encuentra.";
	} else {
		$msg_login="La contraseña digitada no es correcta";
	}?>
	<div class="alert alert-warning alert-dismissible text-center" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Error de Acceso:</strong> <?php echo $msg_login; ?> <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="hiden"></span>
    </div>
<?php } ?>
<div id="idlogin" class="idlogin">
<div class="logintitle" id="ztitles_1">
<img src="http://cdn.genomax.co/media/image/loginico.png" border="0" align="left"/>
Acceso de Usuarios
</div>
	<div class="container-fluid">
  <div class="row">
  	<form action="functions/php/nexus/validar.php?nxsdb=<?php echo $_GET["nxsdb"]; ?>" method="post" id="frm_login" class="form-horizontal">
<div id="divtxtuser" class="form-group">
<label for="txt_loginuser" class="col-sm-offset-1 col-sm-2 control-label">Usuario:</label>
<div class="col-sm-8">
<input name="txt_loginuser" type="text" id="txt_loginuser" size="15" placeholder="nombre.usuario" class="form-control input-sm" />
</div>
</div>
<div id="divtxtpass" class="form-group">
<label for="txt_loginpass" class="col-sm-offset-1 col-sm-2 control-label">Clave:</label>
<div class="col-sm-8">
<input name="txt_loginpass" type="password"  id="txt_loginpass" value="" size="15" placeholder="contraseña" class="form-control input-sm" />
</div>
</div>
    <input name="hdn_browsername" type="hidden" id="hdn_browsername"  />
    <input name="hdn_browserversion" type="hidden" id="hdn_browserversion"  />
    <input name="hdn_plataforma" type="hidden" id="hdn_plataforma"  />
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button class="btn btn-default btn-sm" type="submit" onclick="encrypt();">Ingresar <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
    </div>
  </div>      
  </form>
</div>
</div>

</div>
</div>
<div id="status"><div id="connectdb" > Conectado con: <?php echo $_SESSION["DB_NAME"]; ?></div>
	<div id="gxversion" class="version" >
		Versión: 0.9.0.5
	</div>
	<div id="userbar" >
		<img src="http://cdn.genomax.co/media/image/user_green.png" align="center">Inicie Sesión...
	</div>
</div>
<?php
		}
	}
?>