<?php
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	$SQL="Select Nombre_APP from itaplicaciones where Activo_APP='1' and Codigo_APP='".$_SESSION["NEXUS_APP"]."';";	
	$resultX = mysqli_query($conexion, $SQL);
	if($rowX = mysqli_fetch_array($resultX)) {
?>
<div id="head">:: <?php echo $_SESSION["NOMBRE_APP"]; ?> :: <span id="razonsocial">[Ingreso de Licencia]</span>
</div>
<div class="barmenu" id="barmenu"></div>
<div id="logincontainer">
	
<div id="idloginx" class="idlogin" style="border-style: dashed;border-width: thin;">
<div class="logintitlex" id="ztitles_1" ><div id="logo"></div><h3 style="padding-left: 60px;background-color: darkseagreen;">Activación de Licencia</h3></div>
	<div class="container-fluid">
  <div class="row">
  	<form action="functions/php/nexus/nxscode.php?nxsdb=<?php echo $_GET["nxsdb"]; ?>" method="post" id="frm_authsecure" class="form-horizontal">
  	<div class="alert alert-warning alert-dismissible text-center" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      <strong>Licencia no válida:</strong> Por favor digite el código de licencia válido correspondiente a su identificación.<span class="glyphicon glyphicon-certificate" aria-hidden="hiden"></span>
    </div>

<div id="divtxtuserx" class="form-group">
<label for="txt_nitsecure" class="col-sm-offset-1 col-sm-2 control-label">Nit:</label>
<div class="col-sm-8">
<input name="txt_nitsecure" type="text" id="txt_nitsecure" size="15" placeholder="123456789-0" class="form-control input-sm" />
</div>
</div>
<div id="divtxtpassx" class="form-group">
<label for="txt_securecode" class="col-sm-offset-1 col-sm-2 control-label">Licencia:</label>
<div class="col-sm-8">
<input name="txt_securecode" type="text"  id="txt_securecode" value="" size="40"  placeholder="1abc2def3ghi4jkl5mno6pqr7stu8vwx9yzy0xwv" class="form-control input-sm" />
</div>
</div>
    <input name="hdn_browsername" type="hidden" id="hdn_browsername"  />
    <input name="hdn_browserversion" type="hidden" id="hdn_browserversion"  />
    <input name="hdn_plataforma" type="hidden" id="hdn_plataforma"  />
  
  <div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
      <button class="btn btn-default btn-sm" type="submit" >REGISTRAR <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
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
		<img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/user_green.png" align="center">Inicie Sesión...
	</div>
</div>
<?php
	}
?>