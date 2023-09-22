<?php
include '../../../config.php';
error_reporting(E_ERROR | E_PARSE);

session_start();
include 'database.php';
include 'auditoria.php';
$conexion=Conexion();
mysqli_query ($conexion, "SET NAMES 'utf8'");	
$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
mysqli_query($conexion, $MyZone);

switch ($_GET['Func']) {

case 'haySession':
	// echo 'Estado Session: '.session_status();
break;
 
case 'nxs_mailing':
	// ($desde, $para, $titulo, $mensaje)
	$mensaje = '<html>
	  <head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>'.$titulo.'</title>
	  </head>
	<body>
	<table width="98%" border="0" cellspacing="0" cellpadding="1">
	  <tr>
		<td height="180px" align="right" valign="middle" style="background-color:#FCFCFC; background-image:url(http://fongracetales.com/wp-content/themes/fongracetales/img/head_back2.jpg)">
		<table width="98%" border="0" align="center" cellpadding="1" cellspacing="0">
		  <tr>
			<td><a href="http://fongracetales.com/"><img src="http://fongracetales.com/wp-content/themes/fongracetales/img/logo.png" align="left" height="124" width="230" alt="FonGracetales"/></a></td>
			<td align="right" valign="top"><a href="http://twitter.com/fongracetales">
			<img src="http://fongracetales.com/wp-content/themes/fongracetales/img/glyphicons_392_twitter.png" alt="twitter" width="24" height="24" title="Síguenos en twitter!"/>
		  </a>
		  <a href="http://facebook.com/fongracetales">
			<img src="http://fongracetales.com/wp-content/themes/fongracetales/img/glyphicons_390_facebook.png" alt="facebook" width="24" height="24" title="También estamos en facebook!"/>
		  </a></td>
		  </tr>
		</table>
		</td>
	  </tr>
	  <tr>
		<td style="border-top:thin; border-top-color:#063"><h3 style="color:#073; font-family:Verdana, Geneva, sans-serif; text-shadow:3px 3px 4px rgba( 10, 10, 10, 0.4 )">'.$titulo.'</h3></td>
	  </tr>
	  <tr>
		<td style="color:#333; font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size:14px"><p>
		'.$mensaje.'
		</p>
	  </tr>
	  <tr>
		<td height="55" align="right" valign="middle" background="http://fongracetales.com/wp-content/themes/fongracetales/img/foot_back.jpg" style="background-color:#006600">
			<span>
				<small style="color:#FDFDFD">Powered By:</small>
			</span> <br>
			<a href="http://skygen.co">
			  <img src="http://skygen.co/resources/img/skygen.co-logo.png" alt="SkyGen.co" width="100" height="23" align="absmiddle" title=":: skygen.co ::"/>
			</a>
		</td>
	  </tr>
	</table>
	</body>
	</html>
	';
	$cabeceras  = 'MIME-Version: 1.0' . "\r\n";
	$cabeceras .= 'Content-type: text/html; charset=UTF-8' . "\r\n";
	$cabeceras .= 'From: '.$desde . "\r\n";
	if (mail($para, $titulo, $mensaje, $cabeceras)) {
		echo "Se envió un mensaje al correo ".$para.".";
	} else {
		echo "No se pudo enviar el mensaje al correo ".$para.".";
	}	
break;

case 'NxsToolBar':
	$SQL="Select OptPrinter_ITM, OptNew_ITM, OptNo_ITM, OpSave_ITM from ".$_SESSION['DB_NXS'].".ititems where Enlace_ITM='forms/".$_GET['NombrePag'].".php';";	
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SQL="";
		if ($row[0]=="0") {
			$SQL=$SQL." document.getElementById('Imprimir".$_GET['NumeroPag']."').style.display  = 'none';";
		}
		if ($row[1]=="0") {
			$SQL=$SQL." document.getElementById('Nuevo".$_GET['NumeroPag']."').style.display  = 'none';";
		}
		if ($row[2]=="0") {
			$SQL=$SQL." document.getElementById('Anular".$_GET['NumeroPag']."').style.display  = 'none';";
		}
		if ($row[3]=="0") {
			$SQL=$SQL." document.getElementById('Guardar".$_GET['NumeroPag']."').style.display  = 'none';";
		}
		echo ($SQL);
	} else {
		echo '';
	}
	mysqli_free_result($result);
break;

case 'LoadCal':
	$varfecini = rtrim($_GET['varfecini']) ;
	$varfecfin = rtrim($_GET['varfecfin']) ;
	$ventana = rtrim($_GET['ventana']) ;

	$MesCal=$varfecini;
	if (isset($_GET["mescal"])) {
		$MesCal=$_GET["mescal"];
	}
	$month=date("n",strtotime($MesCal));
	$year=date("Y", strtotime($MesCal));
	$diaActual=date("j", strtotime($MesCal));
	 
	# Obtenemos el dia de la semana del primer dia
	# Devuelve 0 para domingo, 6 para sabado
	$diaSemana=date("w",mktime(0,0,0,$month,1,$year))+7;
	# Obtenemos el ultimo dia del mes
	$ultimoDiaMes=date("d",(mktime(0,0,0,$month+1,1,$year)-1));
	 
	$meses=array(1=>"Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio",
	"Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	
	$Tabla='<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetCitas<?php echo $NumWindow; ?>" >
        	  <tbody id="tbDetallemar<?php echo $NumWindow; ?>">
			   <tr>
			   <th width="10%"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> </th><th width="15%">Lun</th><th width="15%">Mar</th><th width="15%">Mie</th><th width="15%">Jue</th><th width="15%">Vie</th><th width="15%">Sab</th>
			   </tr>
			   
			  </tbody>
			</table>';
			
break;

case 'KlCalculo':
	if (rtrim($_GET['modalidad'])=="Hijos_PLA") { 
		$ValorMas18=0;
		$ValorMenos18=0;
		$Pareja=floor($_GET['mas18']/2);
		$Hijos=$_GET['menos18'];
		$Individual=$_GET['mas18'] % 2;
		$SQL="Select (Hijos_PLA*".$Hijos." + Pareja_PLA*".$Pareja." + individual_PLA*".$Individual.") from klplanesprecios where dias_pla= '".rtrim($_GET['dias'])."' and codigo_pla='".rtrim($_GET['plan'])."';";
	} else {
		$SQL="Select ".rtrim($_GET['modalidad'])." from klplanesprecios where dias_pla= '".rtrim($_GET['dias'])."' and codigo_pla='".rtrim($_GET['plan'])."';";
	}
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		echo ($row[0]);
	} else {
		echo '0';
	}
	mysqli_free_result($result);
break;

case 'NombreUsuariox':
	$SQL="Select Nombre_USR from itusuarios where ID_USR= '".rtrim($_GET['value'])."';";	
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		echo ($row[0]);
	} else {
		echo 'No se encuentra el usuario';
	}
	mysqli_free_result($result);
break;

case  'NombreCargo':
	$SQL="Select Nombre_CRG from czcargos where Codigo_CRG= '".rtrim($_GET['codigo'])."';";	
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		echo ($row[0]);
	} else {
		echo 'No se encuentra el cargo';
	}
	mysqli_free_result($result);
break;

case  'ComprobarClave':
	$SQL="Select Codigo_USR from itusuarios where ID_USR= '".$_SESSION["it_user"]."' and Clave_USR = SHA1('".rtrim($_GET['value'])."') and Activo_USR='1';";	
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		echo '1';
	} else {
		echo '0';
	}
	mysqli_free_result($result);
break;
	
case  'authsecure':
	$SQL="Select sha1('".rtrim($_GET['ni'])."');";
	//	echo $SQL;
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		echo ($row[0]);
	} else {
		echo '0';
	}
	mysqli_free_result($result);
break;
	
case  'NombreEmpresa':
	$SQL="Select RazonSocial_DCD from itconfig;";	
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		echo ($row[0]);
	} else {
		echo '<span class="error">No se encuentra el tercero</span>';
	}
	mysqli_free_result($result);
break;

case  'NombreTercero':
	$codigoter = rtrim($_GET['value']) ;
	if($codigoter != '' ){
		$SQL="Select a.Nombre_TER from czterceros a, ".$_GET['tabla']." b where a.Codigo_TER=b.Codigo_TER and a.ID_TER='".$codigoter."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo 'No se encuentra el tercero';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'NombreCuenta':
	$codigocta = rtrim($_GET['value']) ;
	if($codigocta != '' ){
		$SQL="Select Nombre_CTA from czcuentascont where Codigo_CTA='".$codigocta."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo 'No se encuentra la cuenta';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'EpsPcte':
	$codigoter = rtrim($_GET['value']) ;
	if($codigoter != '' ){
		$SQL="Select c.Codigo_EPS from czterceros a, gxpacientes b, gxeps c where a.Codigo_TER=b.Codigo_TER and c.Codigo_EPS=b.Codigo_EPS and Estado_EPS='1' and a.ID_TER='".$codigoter."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo 'No se encuentra el tercero';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'AcompPcte':
	$codigoter = rtrim($_GET['value']) ;
	$Ventana = rtrim($_GET['Ventana']) ;
	$msg="";
	if($codigoter != '' ){
		$SQL="Select Acudiente_ADM, Direccion_ADM, Telefono_ADM, Fecha_ADM  from czterceros a, gxadmision b where a.Codigo_TER=b.Codigo_TER and a.ID_TER='".$codigoter."' Order By 4 desc limit 1;";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			$msg="document.getElementById('txt_acudiente".$Ventana."').value='".$row[0]."'; document.getElementById('txt_direccion".$Ventana."').value='".$row[1]."'; document.getElementById('txt_telefono".$Ventana."').value='".$row[2]."'; ";
		} 
		mysqli_free_result($result);
	}
	echo $msg;
break;

case  'PlanPcte':
	$codigoter = rtrim($_GET['value']) ;
	if($codigoter != '' ){
		$SQL="Select Codigo_EPS from czterceros a, gxpacientes b where a.Codigo_TER=b.Codigo_TER and a.ID_TER='".$codigoter."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo 'No se encuentra el tercero';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'NombreEmple':
	$codigoter = rtrim($_GET['value']) ;
	if($codigoter != '' ){
		$SQL="Select Nombre_TER from czterceros a, czempleados b where a.Codigo_TER=b.Codigo_TER and a.ID_TER='".$codigoter."';";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '<span class="error">No se encuentra el tercero</span>';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'NombreCama':
	$codigoter = rtrim($_GET['value']);
	if($codigoter != '' ){
		$SQL="Select Descripcion_CAM from gxcamas where Nombre_CAM='".$codigoter."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '<span class="error">No se encuentra la cama</span>';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'NombreServicio':
	$codigoter = rtrim($_GET['value']) ;
	if($codigoter != '' ){
		$SQL="Select Nombre_MED from gxmedicamentos where trim(CODIGO_SER)=trim('".$codigoter."') union Select Nombre_PRC from gxprocedimientos where trim(CODIGO_SER)=trim('".$codigoter."');";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo 'ERROR: No se encuentra el servicio '.$codigoter;
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'CodigoServicio':
	$codigoter = rtrim($_GET['value']) ;
	if($codigoter != '' ){
		$SQL="Select CODIGO_SER from gxservicios where trim(Nombre_SER)=trim('".$codigoter."');";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo 'ERROR: No se encuentra el servicio'.$codigoter;
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'ValorServicio':
	$codigoser = rtrim($_GET['value']) ;
	$codigoeps = rtrim($_GET['eps']) ;
	$codigoplan = rtrim($_GET['plan']) ;
	if($codigoser != '' ){
		$SQL="Select Valor_TAR from gxmanualestarifarios a, gxcontratos b where trim(CODIGO_SER)=trim('".$codigoser."') and curdate() between FechaIni_TAR and FechaFin_TAR and a.Codigo_TAR= b.Codigo_TAR and Codigo_EPS='".$codigoeps."' and Codigo_PLA='".$codigoplan."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '0';
		}
		mysqli_free_result($result);
	}else{
		echo '0';
	}
break;

case  'DosisMedicamento':
	$codigoter = rtrim($_GET['value']) ;
	if($codigoter != '' ){
		$SQL="Select Concentracion_MED from gxmedicamentos where trim(CODIGO_SER)=trim('".$codigoter."') union Select Nombre_PRC from gxprocedimientos where trim(CODIGO_SER)=trim('".$codigoter."');";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '<span class="error">No se encuentra el servicio</span>';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'UnidadMedicamento':
	$codigoter = rtrim($_GET['value']) ;
	if($codigoter != '' ){
		$SQL="Select Codigo_UNM from gxmedicamentos where trim(CODIGO_SER)=trim('".$codigoter."') union Select Nombre_PRC from gxprocedimientos where trim(CODIGO_SER)=trim('".$codigoter."');";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '<span class="error">No se encuentra el servicio</span>';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'ViaMedicamento':
	$codigoter = rtrim($_GET['value']) ;
	if($codigoter != '' ){
		$SQL="Select Codigo_VIA from gxmedicamentos where trim(CODIGO_SER)=trim('".$codigoter."') union Select Nombre_PRC from gxprocedimientos where trim(CODIGO_SER)=trim('".$codigoter."');";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '<span class="error">No se encuentra el servicio</span>';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'NombrePerfil':
	$codigoter = rtrim($_GET['value']) ;
	if($codigoter != '' ){
		$SQL="Select Nombre_PRF from itperfiles where trim(Codigo_PRF)=trim('".$codigoter."');";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '<span class="error">No se encuentra el perfil de usuario</span>';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'CodigoServicio':
	$codigoter = rtrim($_GET['value']) ;
	if($codigoter != '' ){
		$SQL="Select Codigo_MED from gxmedicamentos where trim(CODIGO_SER)=trim('".$codigoter."') union Select CUPS_PRC from gxprocedimientos where trim(CODIGO_SER)=trim('".$codigoter."');";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '<span class="error">No se encuentra el servicio</span>';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'NombreDiagnostico':
	$codigo = rtrim($_GET['value']) ;
	if($codigo != '' ){
		$SQL="Select Descripcion_DGN from gxdiagnostico where Codigo_DGN='".$codigo."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo 'No se encuentra el diagnostico';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'NombreEPS':
	$codigoter = rtrim($_GET['value']) ;
	if($codigoter != '' ){
		$SQL="Select Nombre_TER from czterceros a, gxeps b where a.Codigo_TER=b.Codigo_TER and b.Codigo_EPS='".$codigoter."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '<span class="error">No se encuentra la entidad</span>';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case  'NombreTarifa':
	$codigotar = rtrim($_GET['value']) ;
	if($codigotar != '' ){
		$SQL="Select Nombre_TAR from gxtarifas where Codigo_TAR='".$codigotar."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '<span class="error">No se encuentra la tarifa</span>';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case 'ListadoAreas':
	$resultado=$resultado.'<table width="99%" border="0" align="center" cellpadding="2" cellspacing="1" class="tblDetalle"><tbody class="tbDetalle"><tr><th>Codigo</th><th>Area</th><th>C. Costo</th><th>Responsable</th><th>Estado</th></tr>';
	$SQL="Select Codigo_ARE, Nombre_ARE, Nombre_CCT, Nombre_TER, case Estado_ARE when '1' then 'Activo' else 'Inactivo' end from czareas a, czcentrocosto b, czterceros c Where a.Codigo_CCT=b.Codigo_CCT and c.Codigo_TER=a.Codigo_TER;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
  	$resultado=$resultado.'<tr onclick="javascript:AbrirForm(\'application/forms/areascz.php\', \''. $_GET["ventana"].'\', \'&CodigoARE='.$row[0].'\');"><td>'.$row[0].'</td><td>'.($row[1]).'</td><td>'.($row[2]).'</td><td>'.($row[3]).'</td><td>'.$row[4].'</td></tr>';
	} 
	mysqli_free_result($result);
	$resultado=$resultado.'</tbody></table>';
	echo $resultado;
break;

case 'ListadoCargos':
	$resultado=$resultado.'<table width="99%" border="0" align="center" cellpadding="2" cellspacing="1" class="tblDetalle"><tbody class="tbDetalle"><tr><th>Codigo</th><th>Cargo</th><th>Nivel</th><th>Dependencia</th><th>Area</th><th>Estado</th></tr>';
	$SQL="Select a.Codigo_CRG, a.Nombre_CRG, c.Nombre_NVL, b.Nombre_CRG, d.Nombre_ARE, case a.Estado_CRG when '1' then 'Activo' else 'Inactivo' end FROM czcargos a, czcargos b, czcargosniveles c, czareas d Where a.Dependencia_CRG=b.Codigo_CRG and c.Codigo_NVL=a.Codigo_NVL and d.Codigo_ARE=a.Codigo_ARE Order By a.Codigo_NVL, a.Codigo_CRG;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
  	$resultado=$resultado.'<tr onclick="javascript:AbrirForm(\'application/forms/cargos.php\', \''. $_GET["ventana"].'\', \'&CodigoCRG='.$row[0].'\');"><td>'.$row[0].'</td><td>'.($row[1]).'</td><td>'.($row[2]).'</td><td>'.($row[3]).'</td><td>'.$row[4].'</td><td>'.$row[5].'</td></tr>';
	} 
	mysqli_free_result($result);
	$resultado=$resultado.'</tbody></table>';
	echo $resultado;
break;

case 'NombreContrato':
	$Codigo= rtrim($_GET['value']);
	$Codigo= ltrim($Codigo);
	if($Codigo != '' ){
		$SQL="Select Nombre_EPS from czterceros a, gxeps b where a.Codigo_TER=b.Codigo_TER and b.Codigo_EPS='".$Codigo."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo 'ERROR EN CONTRATO';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case 'CodProdSF':
	$Codigo= rtrim($_GET['value']);
	$Codigo= ltrim($Codigo);
	if($Codigo != '' ){
		$SQL="Select Codigo_SER from gxservicios where Nombre_SER='".$Codigo."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case 'NumeroContrato':
	$Codigo= rtrim($_GET['value']);
	$Codigo= ltrim($Codigo);
	if($Codigo != '' ){
		$SQL="Select Contrato_EPS from czterceros a, gxeps b where a.Codigo_TER=b.Codigo_TER and b.Codigo_EPS='".$Codigo."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case 'NombreDpto':
	$Codigo= rtrim($_GET['value']);
	if($Codigo != '' ){
		$SQL="Select Nombre_DEP from czdepartamentos where Codigo_DEP='".$Codigo."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '<span class="error">Codigo Errado</span>';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case 'NombreMUN' :
	$Codigo= rtrim($_GET['value']);
	$Codigo2= rtrim($_GET['value2']);
	if($Codigo != '' ){
		$SQL="Select Nombre_MUN from czmunicipios where Codigo_DEP='".$Codigo."' and Codigo_MUN='".$Codigo2."';";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '<span class="error">Codigo Errado</span>';
		}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case 'CargarSubgrupoCUPS' :
	$Codigo= rtrim($_GET['value']);
	$Codigo= ltrim($Codigo);
	$tipe= rtrim($_GET['type']);
	if($Codigo != '' ){
		$SQL="SELECT SUBSTRING(Codigo_CUP, CHAR_LENGTH('".$Codigo."')+1), nombre_cup FROM gxgruposcups WHERE tipo_cup='".$tipe."' AND codigo_cup LIKE '".$Codigo."%' ORDER BY 1;";	
		$result = mysqli_query($conexion, $SQL);
		//if ($row = mysqli_fetch_row($result)) {
			if ($tipe=="S") {
				echo "<option value=''>Todos Los Sub Grupos</option>";
			} else {
				echo "<option value=''>Todas las Categorías</option>";
			}
			while($row = mysqli_fetch_row($result)) {
				echo "<option value='".($row[0])."'>".($row[1])."</option>";
			} 
		//} else {
		//	echo "<option value='--'>Verifique el Contrato</option>";
		//}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case 'refreshlistpuc' :
	$texto= ltrim(rtrim($_GET['value']));
	if($texto != '' ){
		$SQL="SELECT concat(Codigo_CTA, ' ', Nombre_CTA) from czcuentascont where Codigo_NVL=5 and codigo_cta like '%".$texto."%' order by 1 limit 10 ;";	
		error_log($SQL);
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_row($result)) {
			echo '<option value="'.$row[0].'">';
		} 
		mysqli_free_result($result);
	}
break;

case 'CargarMun' :
	$Codigo= rtrim($_GET['value']);
	$Codigo= ltrim($Codigo);
	if($Codigo != '' ){
		$SQL="Select Codigo_MUN, Nombre_MUN from czmunicipios where Codigo_DEP='".$Codigo."'Order By 2;";	
		$result = mysqli_query($conexion, $SQL);
		//if ($row = mysqli_fetch_row($result)) {
			while($row = mysqli_fetch_row($result)) {
				echo "<option value='".($row[0])."'>".($row[1])."</option>";
			} 
		//} else {
		//	echo "<option value='--'>Verifique el Contrato</option>";
		//}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case 'CargarPlan' :
	$Codigo= rtrim($_GET['value']);
	$Codigo= ltrim($Codigo);
	if($Codigo != '' ){
		$SQL="Select a.Codigo_Pla, Nombre_PLA from gxplanes a, gxcontratos b where a.Codigo_Pla=b.Codigo_Pla and Codigo_EPS='".$Codigo."' and Estado_CON='1' Order By a.Codigo_Pla;";	
		$result = mysqli_query($conexion, $SQL);
		//if ($row = mysqli_fetch_row($result)) {
			while($row = mysqli_fetch_row($result)) {
				echo "<option value='".($row[0])."'>".($row[1])."</option>";
			} 
		//} else {
		//	echo "<option value='--'>Verifique el Contrato</option>";
		//}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case 'CargarPlanR' :
	$Codigo= rtrim($_GET['value']);
	$Codigo= ltrim($Codigo);
	if($Codigo != '' ){
		$SQL="Select a.Codigo_Pla, Nombre_PLA from gxplanes a, gxcontratos b where a.Codigo_Pla=b.Codigo_Pla and Codigo_EPS='".$Codigo."' Order By a.Codigo_Pla;";	
		$result = mysqli_query($conexion, $SQL);
		//if ($row = mysqli_fetch_row($result)) {
			while($row = mysqli_fetch_row($result)) {
				echo "<option value='".($row[0])."'>".($row[1])."</option>";
			} 
		//} else {
		//	echo "<option value='--'>Verifique el Contrato</option>";
		//}
		mysqli_free_result($result);
	}else{
		echo '';
	}
break;

case 'FillCitasAtencion' :
	$array_dias['Sunday'] = "Domingo";
	$array_dias['Monday'] = "Lunes";
	$array_dias['Tuesday'] = "Martes";
	$array_dias['Wednesday'] = "Miercoles";
	$array_dias['Thursday'] = "Jueves";
	$array_dias['Friday'] = "Viernes";
	$array_dias['Saturday'] = "Sabado";

	$fecha = $_GET['fecha'];
	$paciente = $_GET['paciente'];
	
	$tabla='<tr> <th id="thh'.$_GET['ventana'].'" colspan="10"><span id="NombreDia'.$_GET['ventana'].'"> '.$array_dias[date('l', strtotime($fecha))].'. '.$_GET['fecha'].' </span></th> </tr> <tr id="trh'.$_GET['ventana'].'"> <th id="thd2'.$_GET['ventana'].'" >Hora</th> <th id="thd3'.$_GET['ventana'].'" >Paciente</th> <th id="thd3'.$_GET['ventana'].'">Nombre</th> <th id="thd3'.$_GET['ventana'].'" >Llegada</th> <th id="thd5'.$_GET['ventana'].'" >Area</th> <th id="thd6'.$_GET['ventana'].'" >Consultorio</th> <th id="thd6'.$_GET['ventana'].'" >Atención</th> <th id="thd6'.$_GET['ventana'].'" >Nota</th> <th id="thd7'.$_GET['ventana'].'" >Histórico</th> <th id="thd7'.$_GET['ventana'].'" >Atender</th></tr>  ';
	$SQL="Select g.Codigo_CIT, c.Nombre_ARE, d.Nombre_CNS, b.Fecha_AGE, b.Hora_AGE, e.Nombre_TER, f.Nombre_ESP, h.Nombre_TER, h.ID_TER, g.Codigo_CIT, Confirma_CIT, FechaConf_CIT, Nota_CIT, Atiende_CIT, Nombre_TAH From gxagendacab a, gxagendadet b, gxareas c, gxconsultorios d, czterceros e, gxespecialidades f, gxcitasmedicas g, czterceros h, gxmedicos i, hctipoatencion j Where j.Codigo_TAH=g.Codigo_TAH and a.Codigo_AGE=b.Codigo_AGE and c.Codigo_ARE=a.Codigo_ARE and d.Codigo_CNS=a.Codigo_CNS and e.Codigo_TER=a.Codigo_TER and f.Codigo_ESP=a.Codigo_ESP and g.Codigo_AGE=a.Codigo_AGE and h.Codigo_TER=g.Codigo_TER and b.Fecha_AGE=g.Fecha_AGE and b.Hora_AGE=g.Hora_AGE and i.Codigo_TER=e.Codigo_TER and i.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' and b.Fecha_AGE='".$_GET['fecha']."' and a.Estado_AGE='1' and b.Estado_AGE='1' and g.Estado_CIT='P' /* and Confirma_CIT='1' */ Order By b.Hora_AGE, c.Nombre_ARE";
	$result = mysqli_query($conexion, $SQL);
	$counter=0;
	while($row = mysqli_fetch_row($result)) {
		$counter++;
		$butoun="";
		if ($row[13]=="1") {
			$butoun='disabled="disabled"';
		}
		$TheButoncito='<button class="btn btn-success" type="button" '.$butoun.' onclick="javascript:AtndCita'.$_GET['ventana'].'(\''.$counter.'\');"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> </button>';
		if ($row[10]=="0") {
			$TheButoncito='<span class="label label-default">Sin Confirmar</span>';
		}
		$tabla=$tabla.'<tr style="vertical-align:bottom">
					<td  align="center"><strong>'.$row[4].'</strong></td>
					<td  align="left">'.$row[8].'</td>
					<td  align="left"><strong>'.$row[7].'</strong></td>
					<td  align="left">'.$row[11].'</td>
					<td  align="left">'.$row[6].'</td>
					<td  align="left">'.$row[2].'</td>
					<td  align="left">'.$row[14].'</td>
					<td  align="left">'.$row[12].'</td>
					<td  align="center">
				        <button class="btn btn-default" type="button" data-toggle="modal" title="Histórico de Citas" data-target="#GnmX_WinModal"  onclick="javascript:CitasxPcte'.$_GET['ventana'].'(\''.$row[8].'\');"> <span class="glyphicon glyphicon-time" aria-hidden="true"></span> </button>
					</td>
					<td  align="center">
					<input name="hdn_pte'.$counter.$_GET['ventana'].'" type="hidden" id="hdn_pte'.$counter.$_GET['ventana'].'" value="'.$row[8].'">
						<input name="hdn_cita'.$counter.$_GET['ventana'].'" type="hidden" id="hdn_cita'.$counter.$_GET['ventana'].'" value="'.$row[9].'">
				        '.$TheButoncito.'
					</td>
				</tr>';
	} 
	mysqli_free_result($result);
	echo $tabla.'<input name="hdn_controwcitas'.$_GET['ventana'].'" type="hidden" id="hdn_controwcitas'.$_GET['ventana'].'" value="'.$counter.'" />';
break;

case 'FillConfCitas' :
	$array_dias['Sunday'] = "Domingo";
	$array_dias['Monday'] = "Lunes";
	$array_dias['Tuesday'] = "Martes";
	$array_dias['Wednesday'] = "Miercoles";
	$array_dias['Thursday'] = "Jueves";
	$array_dias['Friday'] = "Viernes";
	$array_dias['Saturday'] = "Sabado";

	$fecha = $_GET['fecha'];
	$paciente = $_GET['paciente'];

	$tabla='<tr> <th id="thh'.$_GET['ventana'].'" colspan="10"><span id="NombreDia'.$_GET['ventana'].'"> '.$array_dias[date('l', strtotime($fecha))].'. '.$_GET['fecha'].' </span></th> </tr> <tr id="trh'.$_GET['ventana'].'"> <th id="thd2'.$_GET['ventana'].'" >Hora</th> <th id="thd3'.$_GET['ventana'].'" >Paciente</th> <th id="thd3'.$_GET['ventana'].'">Nombre</th> <th id="thd3'.$_GET['ventana'].'">Nota</th> <th id="thd3'.$_GET['ventana'].'" >Profesional</th> <th id="thd4'.$_GET['ventana'].'" >Especialidad</th> <th id="thd5'.$_GET['ventana'].'" >Area</th> <th id="thd6'.$_GET['ventana'].'" >Consultorio</th> <th id="thd6'.$_GET['ventana'].'" >Atención</th> <th id="thd8'.$_GET['ventana'].'" >Confirmar</th> </tr> ';
	$SQL="Select g.Codigo_CIT, c.Nombre_ARE, d.Nombre_CNS, b.Fecha_AGE, time_format(b.Hora_AGE, '%H:%i'), e.Nombre_TER, f.Nombre_ESP, h.Nombre_TER, h.ID_TER, g.Codigo_CIT, Nota_CIT, Nombre_TAH From gxagendacab a, gxagendadet b, gxareas c, gxconsultorios d, czterceros e, gxespecialidades f, gxcitasmedicas g, czterceros h, hctipoatencion i Where i.Codigo_TAH=g.Codigo_TAH and a.Codigo_AGE=b.Codigo_AGE and c.Codigo_ARE=a.Codigo_ARE and d.Codigo_CNS=a.Codigo_CNS and e.Codigo_TER=a.Codigo_TER and f.Codigo_ESP=a.Codigo_ESP and g.Codigo_AGE=a.Codigo_AGE and h.Codigo_TER=g.Codigo_TER and b.Fecha_AGE=g.Fecha_AGE and b.Hora_AGE=g.Hora_AGE and b.Fecha_AGE='".$_GET['fecha']."' and a.Estado_AGE='1' and b.Estado_AGE='1' and g.Estado_CIT='P' and Confirma_CIT='0' ";	
	if ($paciente!="") {
		$SQL=$SQL." and h.ID_TER='".$paciente."'";
	}
	$SQL=$SQL."  Order By b.Hora_AGE, c.Nombre_ARE";
	$result = mysqli_query($conexion, $SQL);
	$counter=0;
	while($row = mysqli_fetch_row($result)) {
		$counter++;
		$notica="";
		if (trim($row[10])!="") {
			$notica=' value="'.$row[10].'"';
		}
		$tabla=$tabla.'<tr style="vertical-align:bottom">
					<td  align="center"><strong>'.$row[4].'</strong></td>
					<td  align="left">'.$row[8].'</td>
					<td  align="left"><strong>'.$row[7].'</strong></td>
					<td  align="left">'.$row[10].'</td>
					<td  align="left">'.$row[5].'</td>
					<td  align="left">'.$row[6].'</td>
					<td  align="left">'.$row[1].'</td>
					<td  align="left">'.$row[2].'</td>
					<td  align="left">'.$row[11].'</td>
					<td  align="center">
						<div class="input-group">
							<input name="hdn_admisionar'.$counter.$_GET['ventana'].'" type="hidden" id="hdn_admisionar'.$counter.$_GET['ventana'].'" value="1">
							<input name="hdn_cita'.$counter.$_GET['ventana'].'" type="hidden" id="hdn_cita'.$counter.$_GET['ventana'].'" value="'.$row[9].'">
					      <input id="txt_nota'.$counter.$_GET['ventana'].'" name="txt_nota'.$counter.$_GET['ventana'].'" type="text" class="form-control input-sm" placeholder="Nota..." title="Coloque aquí anotación para el profesional" '.$notica.' value="'.$row[10].'">
					      <span class="input-group-btn">
					        <button class="btn btn-success" type="button"  onclick="javascript:RepCita'.$_GET['ventana'].'(\''.$counter.'\');"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> </button>
					      </span>
					    </div>
					</td>
				</tr>';
	} 
	mysqli_free_result($result);
	echo $tabla.'<input name="hdn_controwcitas'.$_GET['ventana'].'" type="hidden" id="hdn_controwcitas'.$_GET['ventana'].'" value="'.$counter.'" />';
break;

case 'CargarMedicosCx' :
	$SQL="Select distinct a.Codigo_TER, e.Nombre_TER, d.Nombre_ESP From gxagendacab a, gxagendadet b, gxmedicos c, gxespecialidades d, czterceros e Where a.Codigo_AGE=b.Codigo_AGE and a.Codigo_TER=c.Codigo_TER and a.Codigo_ESP=d.Codigo_ESP and e.Codigo_TER=c.Codigo_TER and a.Codigo_ARE='".$_GET['area']."' and b.Fecha_AGE='".$_GET['fecha']."';";	
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
		echo "<option value='".($row[0])."'>".$row[1]." (".$row[2].")</option>";
	} 
	mysqli_free_result($result);
break;
// Mensaje a enviar por texto para recordarle la cita programada a los pacientes
case 'txtrSchedule' :
	$cita=$_GET['cita'];
	$pcte="";
	$ips="";
	$esp="";
	$med="";
	$fecha="";
	$hora="";
	$area="";
	$dir="";
	$tel="";
	$mensaje="";
	$SQL="SELECT CONCAT(b.Nombre1_PAC,' ',b.Apellido1_PAC) AS nombre, c.Razonsocial_DCD, f.Nombre_ESP, e.Nombre_TER, DATE_FORMAT(a.Fecha_AGE,'%d/%m/%Y'), DATE_FORMAT(concat(a.Fecha_AGE,' ',a.Hora_AGE),'%h:%i %p'), g.Nombre_ARE, h.Direccion_SDE, h.Telefonos_SDE, J.Nombre_TAH, i.MensajeCita_XCX FROM gxcitasmedicas a, gxpacientes b, itconfig c, gxagendacab d, czterceros e, gxespecialidades f, gxareas g, czsedes h, itconfig_cx i, hctipoatencion j WHERE j.Codigo_TAH=a.Codigo_TAH AND a.Codigo_TER=b.Codigo_TER AND d.Codigo_AGE=a.Codigo_AGE AND e.Codigo_TER=d.Codigo_TER AND f.Codigo_ESP=d.Codigo_ESP AND g.Codigo_ARE=d.Codigo_ARE AND g.Codigo_SDE=h.Codigo_SDE and a.Codigo_CIT='".$cita."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$pcte=$row[0];
		$ips=$row[1];
		$esp=$row[2];
		$med=$row[3];
		$fecha=$row[4];
		$hora=$row[5];
		$area=$row[6];
		$dir=$row[7];
		$tel=$row[8];
		$mod=$row[9];
		$mensaje=$row[10];
	} 
	mysqli_free_result($result);
	$mensaje=str_replace("{PACIENTE}",strtoupper($pcte),$mensaje);
	$mensaje=str_replace("{IPS}",strtoupper($ips),$mensaje);
	$mensaje=str_replace("{ESPECIALIDAD}",strtoupper($esp),$mensaje);
	$mensaje=str_replace("{MEDICO}",strtoupper($med),$mensaje);
	$mensaje=str_replace("{FECHA}",strtoupper($fecha),$mensaje);
	$mensaje=str_replace("{HORA}",strtoupper($hora),$mensaje);
	$mensaje=str_replace("{AREA}",strtoupper($area),$mensaje);
	$mensaje=str_replace("{DIRECCION}",strtoupper($dir),$mensaje);
	$mensaje=str_replace("{TELEFONO}",strtoupper($tel),$mensaje);
	$mensaje=str_replace("{MODALIDAD}",strtoupper($mod),$mensaje);
	echo urlencode($mensaje);
break;

case 'loadSchedule' :
	$fecha=$_GET['fecha'];
	$areas=$_GET['areas'];
	$wind=$_GET['wind'];
	$tabla ='<table class="table table-condensed table-bordered table-hover tblDetalle" style="cursor:auto;"> <thead> <tr> <th width="64px" style="font-size: 12px; text-align: center;"> <span class="glyphicon glyphicon-time" aria-hidden="true"></span> </th>';
	/* CONSULTA DE AGENDAS ABIERTAS PARA ESTE DIA */
	$areas=" and a.Codigo_ARE in (".$areas.") ";

	$SQL="SELECT DISTINCT b.Codigo_AGE, c.Codigo_TER, concat(c.Apellido1_MED, ' ', left(c.Apellido2_MED,1), ' ', c.Nombre1_MED, ' ', left(c.Nombre2_MED,1)) FROM gxagendacab a, gxagendadet b, gxmedicos c WHERE a.Codigo_AGE=b.Codigo_AGE AND c.Codigo_TER=a.Codigo_TER AND a.Estado_AGE='1' ".$areas." AND b.Fecha_AGE='".$fecha."'";
	error_log($SQL);
	$result = mysqli_query($conexion, $SQL);
	$i=0;
	while($row = mysqli_fetch_row($result)) {
		$i++;
		$array_agendas[$i] = $row[0];
		$tabla=$tabla.'<th  style="font-size: 10px; text-align: center; white-space: nowrap;"> '.$row[2].' </th>';
	} 
	mysqli_free_result($result);
	$SQL="SELECT min(b.Hora_AGE), MAX(b.Hora_AGE), round(TIMESTAMPDIFF(minute,min(b.Hora_AGE), MAX(b.Hora_AGE))/5) FROM gxagendadet b, gxagendacab a WHERE a.Codigo_AGE=b.Codigo_AGE AND a.Estado_AGE='1' ".$areas." AND b.Fecha_AGE='".$fecha."'";
	error_log($SQL);
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$horamin = $row[0];
		$horamax = $row[1];
		$totalfilas = $row[2];
	} 
	mysqli_free_result($result);
	$tabla=$tabla.'</tr> </thead> <tbody>';
	$SQL="SET @numero='".$horamin."'; Select @numero:= ADDTIME(@numero, '00:05:00') FROM gxagendadet WHERE @numero<='".$horamax."';";
	$SQL1="SELECT time_format(t0.horaagenda, '%H:%i') ";
	$SQL2=" FROM gxagendahoras t0";
	$j=0;
	while($j<=$i) {
		$j++;
		$SQL1=$SQL1.", t".$j.".Estado_AGE";
		$SQL2=$SQL2." LEFT OUTER JOIN gxagendadet t".$j." ON t".$j.".Hora_AGE=t0.horaagenda AND t".$j.".Codigo_AGE='".$array_agendas[$j]."' AND t".$j.".Fecha_AGE='".$fecha."'";
	}
	$SQL=$SQL1.$SQL2. " Where t0.horaagenda between '".$horamin."' and '".$horamax."'";
	error_log($SQL);
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
		$tabla=$tabla.'<tr height="27px"><td style="font-size:11px;">'.$row[0].'</td>';
		$j=0;
		while($j<=$i) {
			$j++;
			if($row[$j]=="") {
			$tabla=$tabla.'<td style="cursor: not-allowed;"></td>';
			} else {
				$SQL="Select Tiempo_AGE, Codigo_CNS, Codigo_ESP From gxagendacab Where Codigo_AGE='".$array_agendas[$j]."'";
				$resultx = mysqli_query($conexion, $SQL);
				if($rowx = mysqli_fetch_row($resultx)) {
					$rowspan = ' rowspan="'.($rowx[0]/5).'" style="font-size:11px;"';
					$html="";
					if($row[$j]=="1") {
						$SQL="SELECT '".$row[0]."', time_format(ADDTIME('".$row[0]."', '00:".$rowx[0].":00'), '%H:%i'), CONCAT(b.Nombre1_PAC,' ',LEFT(b.Nombre2_PAC,1),' ',b.Apellido1_PAC,' ',LEFT(b.Apellido2_PAC,1)), c.Nombre_EPS, a.Confirma_CIT, a.Atiende_CIT, e.ID_TER, a.Codigo_CIT, e.Telefono_TER FROM gxcitasmedicas a, gxpacientes b, gxeps c, gxagendacab d, czterceros e WHERE e.Codigo_TER=b.Codigo_TER and a.Codigo_TER=b.Codigo_TER AND d.Codigo_AGE=a.Codigo_AGE AND b.Codigo_EPS=c.Codigo_EPS AND a.Estado_CIT='P' AND a.Fecha_AGE='".$fecha."' AND a.Hora_AGE='".$row[0]."' AND a.Codigo_AGE='".$array_agendas[$j]."'";
						error_log($SQL);
						$resulty = mysqli_query($conexion, $SQL);
						if($rowy = mysqli_fetch_row($resulty)) {
							switch ($rowy[4]) {
								case '1':
									if ($rowy[5]=="1") {
										$stilo=' class="bg-primary"';
										$conf="";

									} else {
										$stilo=' class="bg-info"';
										$conf='<li><a class="text-primary" onclick="javascript:confcita'.$wind.'(\''.$rowy[6].'\', \''. $wind.'\');" data-toggle="modal" data-target="#GnmX_WinModal"> <span class="glyphicon glyphicon-repeat"></span> Desconfirmar</a></li>';
									}

								break;
								case '0':
									$stilo=' class="bg-success"';
									$conf='<li><a class="text-success" onclick="javascript:confcita'.$wind.'(\''.$rowy[6].'\', \''. $wind.'\');" data-toggle="modal" data-target="#GnmX_WinModal"> <span class="glyphicon glyphicon-ok-circle"></span> Confirmar Llegada</a></li>';
								break;
							}
							$msgcita="";
							if ($rowy[8]!="") {
								$msgcita='<li role="separator" class="divider"></li>
								<li><a class="text-primary" onclick="javascript:sendWhatsapp'.$wind.'(\''.$rowy[8].'\', \''.$rowy[7].'\');" > <span class="glyphicon glyphicon-earphone"></span> Enviar por Whatsapp</a></li>';
							}
							$button='<button class="btn dropdown-toggle" type="button" id="drpmn'.$j.'" style="background-color:transparent; border-color:transparent; text-align:left; padding:2px" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
							$opciones='<ul class="dropdown-menu" aria-labelledby="drpmn'.$j.'">
							'.$conf.'
							<li><a class="text-primary" onclick="javascript:ReprogCitas'.$wind.'(\''.$rowy[7].'\', \''. $wind.'\');" data-toggle="modal" data-target="#GnmX_WinModal"> <span class="glyphicon glyphicon-calendar"></span> Reprogramar Cita</a></li>
							<li><a class="text-danger" onclick="javascript:CancelCitas'.$wind.'(\''.$rowy[7].'\', \''. $wind.'\');" data-toggle="modal" data-target="#GnmX_WinModal"> <span class="glyphicon glyphicon-remove-circle"></span> Cancelar Cita</a></li>
							'.$msgcita.'
							<li role="separator" class="divider"></li>
							<li><a onclick="javascript:PcteCitas'.$wind.'(\''.$rowy[6].'\', \''. $wind.'\');" data-toggle="modal" data-target="#GnmX_WinModal"> <span class="glyphicon glyphicon-list-alt"></span> Ver Historico</a></li>
							<li role="separator" class="divider"></li>
							<li><a class="text-warning" onclick="javascript:CancelCitas'.$wind.'(\''.$rowy[7].'\', \''. $wind.'\');" data-toggle="modal" data-target="#GnmX_WinModal"> <span class="glyphicon glyphicon-ban-circle"></span> No asiste</a></a></li>
						  </ul>';
							$html='<div class="dropdown">'.$button.'<small>['.$rowy[0].' - '.$rowy[1].']<br><b>'.$rowy[2].'</b><br><span class="glyphicon glyphicon-phone-alt"></span> '.$rowy[8].' <br>Contrato: '.$rowy[3].'</small></button>'.$opciones.'</div>';
						} 
						mysqli_free_result($resulty);
					} else {
						$stilo=' style="background-color: #efefef;"';
						$button='<button class="btn dropdown-toggle" type="button" id="drpmn'.$j.'" style="background-color:transparent; border-color:transparent; text-align:left; padding:2px" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">';
						$opciones='<ul class="dropdown-menu" aria-labelledby="drpmn'.$j.'">
						<li><a onclick="javascript:newcita'.$wind.'(\''.$array_agendas[$j].'\', \''.$fecha.'\', \''.$row[0].'\', \''. $wind.'\');" data-toggle="modal" data-target="#GnmX_WinModal">Programar Nueva Cita</a></li>
						</ul>';
						$html='<div class="dropdown">'.$button.'...</button>'.$opciones.'</div>';
					}
					$tabla=$tabla.'<td '.$stilo.' '.$rowspan.'>'.$html.'</td>';
				}
				mysqli_free_result($resultx);
			}
		}
		$tabla=$tabla.'</tr>';
	} 
	mysqli_free_result($result);
	
	$tabla=$tabla.'</tbody>	</table>';

	echo $tabla;
break;

case 'FillAgenda' :
	$array_dias['Sunday'] = "Domingo";
	$array_dias['Monday'] = "Lunes";
	$array_dias['Tuesday'] = "Martes";
	$array_dias['Wednesday'] = "Miercoles";
	$array_dias['Thursday'] = "Jueves";
	$array_dias['Friday'] = "Viernes";
	$array_dias['Saturday'] = "Sabado";

	$fecha = $_GET['fecha'];

	$tabla='<tr> <th id="thh'.$_GET['ventana'].'" colspan="3"><span id="NombreDia'.$_GET['ventana'].'"> '.$array_dias[date('l', strtotime($fecha))].'. '.$_GET['fecha'].' </span></th> </tr> <tr id="trh'.$_GET['ventana'].'"> <th  width="10%" id="thd2'.$_GET['ventana'].'">Hora</th> <th  width="12%" id="thd1'.$_GET['ventana'].'">Consultorio</th> <th  width="78%" id="thd0'.$_GET['ventana'].'">Paciente</th> </tr> ';
	$SQL="Select a.Hora_AGE, c.Nombre_CNS, a.codigo_age, '' as 'habil', '', '' From gxagendadet a, gxagendacab b, gxconsultorios c Where a.Codigo_AGE=b.Codigo_AGE and b.Codigo_CNS=c.Codigo_CNS and b.Estado_AGE='1' and a.Estado_AGE='0' and a.Fecha_AGE='".$_GET['fecha']."' and b.Codigo_TER='".$_GET['medico']."' and b.Codigo_ARE='".$_GET['area']."'
	Union 
	Select z.Hora_AGE, m.Nombre_CNS, z.codigo_age, 'disabled' as 'habil', x.ID_TER, x.Nombre_TER From czterceros x, gxcitasmedicas y, gxagendadet z, gxagendacab n, gxconsultorios m Where x.Codigo_TER=y.Codigo_TER and y.Codigo_AGE=z.Codigo_AGE and y.Fecha_AGE=z.fecha_age and y.hora_age=z.hora_age and z.Codigo_AGE=n.Codigo_AGE and n.Codigo_CNS=m.Codigo_CNS and n.Estado_AGE='1' and z.Estado_AGE='1' and z.Fecha_AGE='".$_GET['fecha']."' and n.Codigo_TER='".$_GET['medico']."' and n.Codigo_ARE='".$_GET['area']."'
	Order by 1,2;";
	error_log($SQL);
	$result = mysqli_query($conexion, $SQL);
	$counter=0;
	while($row = mysqli_fetch_row($result)) {
		$counter++;
		$tabla=$tabla.'<tr > <td align="center" valign="middle">
		<input name="hdn_hora'.$counter.$_GET['ventana'].'" type="hidden" id="hdn_hora'.$counter.$_GET['ventana'].'" value="'.$row[0].'" /><label style="cursor: pointer;" for="txt_paciente'.$counter.$_GET['ventana'].'">'.$row[0].'</label></td> <td  valign="middle"><input name="hdn_fecha'.$counter.$_GET['ventana'].'" type="hidden" id="hdn_fecha'.$counter.$_GET['ventana'].'" value="'.$_GET['fecha'].'" />'.$row[1].'<input name="hdn_agenda'.$counter.$_GET['ventana'].'" type="hidden" id="hdn_agenda'.$counter.$_GET['ventana'].'" value="'.$row[2].'" /></td> <td  valign="middle"> <div class="row"> <div class="col-sm-4 col-md-4"><div class="input-group">
		<span class="input-group-btn"> <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_WinModal" onclick="javascript:LoadPcte'.$_GET['ventana'].'(\''.$counter.'\');" title="Edición de Pacientes"  '.$row[3].'><span class="glyphicon glyphicon-user" aria-hidden="true"></span></button> </span>
		<input required class="form-control input-sm" name="txt_paciente'.$counter.$_GET['ventana'].'"  type="text" id="txt_paciente'.$counter.$_GET['ventana'].'" onblur="javascript:NombreTer'.$_GET['ventana'].'(\''.$counter.'\', this.value, \'gxpacientes\');" onkeypress="BuscarPte'.$_GET['ventana'].'(event);" onkeydown="if(event.keyCode==115){CargarSearch(\'Paciente\', \'txt_paciente'.$counter.$_GET['ventana'].'\', \'NULL\')};" style="font-size:14px; font-weight: bold; " value="'.$row[4].'" '.$row[3].'/> <span class="input-group-btn"> <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Paciente" onclick="javascript:CargarSearch(\'Paciente\', \'txt_paciente'.$counter.$_GET['ventana'].'\', \'NULL\');" '.$row[3].'><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button> </div> </div>
		<div class="col-sm-8 col-md-8"><div class="input-group">
		<input class="form-control input-sm" style="font-size:12px; font-weight: bold; color:#0E5012; " name="txt_paciente2x'.$counter.$_GET['ventana'].'" id="txt_paciente2x'.$counter.$_GET['ventana'].'" type="text" disabled="disabled" class="lead" value="'.$row[5].'" /><span class="input-group-btn" id="spn_pctex'.$counter.$_GET['ventana'].'" name="spn_pctex'.$counter.$_GET['ventana'].'"> <button class="btn btn-default" type="button" disabled><span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span></button></span> </div></div> </div>
		 </td> </tr>';
	} 
	mysqli_free_result($result);
	echo $tabla.'<input name="hdn_controwcitas'.$_GET['ventana'].'" type="hidden" id="hdn_controwcitas'.$_GET['ventana'].'" value="'.$counter.'" />';
break;

case 'FillAgendaR' :
	$array_dias['Sunday'] = "Domingo";
	$array_dias['Monday'] = "Lunes";
	$array_dias['Tuesday'] = "Martes";
	$array_dias['Wednesday'] = "Miercoles";
	$array_dias['Thursday'] = "Jueves";
	$array_dias['Friday'] = "Viernes";
	$array_dias['Saturday'] = "Sabado";

	$fecha = $_GET['fecha'];

	$tabla='<tr> <th id="thh'.$_GET['ventana'].'" colspan="4"><span id="NombreDia'.$_GET['ventana'].'"> '.$array_dias[date('l', strtotime($fecha))].'. '.$_GET['fecha'].' </span></th> </tr> <tr id="trh'.$_GET['ventana'].'"> <th  width="10%" id="thd2'.$_GET['ventana'].'">Hora</th> <th  width="20%" id="thd1'.$_GET['ventana'].'">Consultorio</th> <th  width="60%" id="thd0'.$_GET['ventana'].'">Paciente</th> <th  width="10%" id="thd0'.$_GET['ventana'].'">Asignar</th></tr> ';
	$SQL="Select a.Hora_AGE, c.Nombre_CNS, a.codigo_age From gxagendadet a, gxagendacab b, gxconsultorios c Where a.Codigo_AGE=b.Codigo_AGE and b.Codigo_CNS=c.Codigo_CNS and b.Estado_AGE='1' and a.Estado_AGE='0' and a.Fecha_AGE='".$_GET['fecha']."' and b.Codigo_TER='".$_GET['medico']."' and b.Codigo_ARE='".$_GET['area']."' order by 1,2;";	
	$result = mysqli_query($conexion, $SQL);
	$counter=0;
	while($row = mysqli_fetch_row($result)) {
		$counter++;
		$tabla=$tabla.'<tr > <td align="center" valign="middle"><input name="hdn_hora'.$counter.$_GET['ventana'].'" type="hidden" id="hdn_hora'.$counter.$_GET['ventana'].'" value="'.$row[0].'" /><label style="cursor: pointer;" for="txt_paciente'.$counter.$_GET['ventana'].'">'.$row[0].'</label></td> <td  valign="middle"><input name="hdn_fecha'.$counter.$_GET['ventana'].'" type="hidden" id="hdn_fecha'.$counter.$_GET['ventana'].'" value="'.$_GET['fecha'].'" />'.$row[1].'<input name="hdn_agenda'.$counter.$_GET['ventana'].'" type="hidden" id="hdn_agenda'.$counter.$_GET['ventana'].'" value="'.$row[2].'" /></td> <td  valign="middle"> <div class="row"> <div class="col-sm-4 col-md-4"><input required disabled class="form-control input-sm" name="txt_paciente'.$counter.$_GET['ventana'].'" type="text" id="txt_paciente'.$counter.$_GET['ventana'].'" /> </div> <div class="col-sm-8 col-md-8"><input class="form-control input-sm" style="font-size:12px; font-weight: bold; color:#0E5012; " name="txt_paciente2'.$counter.$_GET['ventana'].'" id="txt_paciente2'.$counter.$_GET['ventana'].'" type="text" disabled="disabled" class="lead" /> </div> </div> </td> <td align="center"><button class="btn btn-default" type="button" onclick="javascript:RepCita'.$_GET['ventana'].'(\''.$counter.'\');"> <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> </button> </td></tr>';
	} 
	mysqli_free_result($result);
	echo $tabla.'<input name="hdn_controwcitas'.$_GET['ventana'].'" type="hidden" id="hdn_controwcitas'.$_GET['ventana'].'" value="'.$counter.'" />';
break;

case 'FillAgendaNo' :
	$servicio = $_GET['servicio'];
	$fecha1 = $_GET['fecha1'];
	$fecha2 = $_GET['fecha2'];
	$medico = $_GET['medico'];
	$paciente = $_GET['paciente'];
	$ventana = $_GET['ventana'];
	$tabla='<tr id="trh'.$ventana.'"> <th id="thd2'.$ventana.'" width="11%" >Area</th> <th id="thd1'.$ventana.'" width="6%" >Consultorio</th> <th id="thd1'.$ventana.'" width="8%" >Fecha</th> <th id="thd1'.$ventana.'" width="18%" >Profesional</th> <th id="thd1'.$ventana.'" width="10%" >Especialidad</th> <th id="thd1'.$ventana.'" width="6%" >Tipo Atencion</th> <th id="thd0'.$ventana.'" width="18%" >Paciente</th> <th id="thd0'.$ventana.'" width="8%" >Nota</th> <th id="thd1'.$ventana.'" width="15%" >Acción</th> </tr> ';
	$SQL="Select g.Codigo_CIT, c.Nombre_ARE, d.Nombre_CNS, b.Fecha_AGE, time_format(b.Hora_AGE, '%H:%i'), e.Nombre_TER, f.Nombre_ESP, h.Nombre_TER, h.ID_TER, h.Correo_TER, Nombre_TAH, g.Nota_CIT From gxagendacab a, gxagendadet b, gxareas c, gxconsultorios d, czterceros e, gxespecialidades f, gxcitasmedicas g, czterceros h, hctipoatencion i Where i.Codigo_TAH=g.Codigo_TAH and a.Codigo_AGE=b.Codigo_AGE and c.Codigo_ARE=a.Codigo_ARE and d.Codigo_CNS=a.Codigo_CNS and e.Codigo_TER=a.Codigo_TER and f.Codigo_ESP=a.Codigo_ESP and g.Codigo_AGE=a.Codigo_AGE and h.Codigo_TER=g.Codigo_TER and b.Fecha_AGE=g.Fecha_AGE and b.Hora_AGE=g.Hora_AGE and a.Estado_AGE='1' and b.Estado_AGE='1' and g.Estado_CIT='P'";	
	if ($servicio!="*") {
		$SQL=$SQL." and c.Codigo_ARE='".$servicio."'";
	}
	$SQL=$SQL." and b.Fecha_AGE>='".$fecha1."'  and b.Fecha_AGE<='".$fecha2." 23:59:59'";
	if ($medico!="*") {
		$SQL=$SQL." and e.Codigo_TER='".$medico."'";
	}
	if ($paciente!="") {
		$SQL=$SQL." and h.ID_TER='".$paciente."'";
	}
	$SQL=$SQL." Order By 2,3,4,5";
	$result = mysqli_query($conexion, $SQL);
	$counter=0;
	while($row = mysqli_fetch_row($result)) {
		$counter++;
		if (trim($row[9]=="")) {
			$statemail=" disabled";
		} else {
			$statemail="";
		}
		$tabla=$tabla.'<tr>
					<td align="left" style="font-size: 10px;">'.$row[1].'</td>
					<td align="left" style="font-size: 10px;">'.$row[2].'</td>
					<td align="center" style="font-size: 10px;">'.FormatoFecha($row[3]).' - '.$row[4].'</td>
					<td align="left" style="font-size: 10px;">'.$row[5].'</td>
					<td align="left" style="font-size: 10px;">'.$row[6].'</td>
					<td align="left" style="font-size: 10px;">'.$row[10].'</td>
					<td align="left" style="font-size: 10px;">'.$row[7].'</td>
					<td align="left" style="font-size: 10px;">'.$row[11].'</td>
					<td align="center">
						<div class="btn-group btn-group-sm" role="group" aria-label="...">
							<button class="btn btn-info" type="button" title="Imprimir Recordatorio" onclick="javascript:PrintCitas'.$ventana.'(\''.$row[8].'\',\''.$row[3].'\');"><span class="glyphicon glyphicon-print" aria-hidden="true"></span></button>
							<button class="btn btn-success" type="button" title="Enviar recordatorio por email" onclick="javascript:MailCitas'.$ventana.'(\''.$row[0].'\');" '.$statemail.' ><span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></button>
							<button class="btn btn-primary" type="button" title="Mostrar histórico de citas" onclick="javascript:PcteCitas'.$ventana.'(\''.$row[8].'\');" data-target="#GnmX_WinModal" data-toggle="modal"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></button>
							<button class="btn btn-warning" type="button" title="Reprogramar Cita" onclick="javascript:ReprogCitas'.$ventana.'(\''.$row[0].'\');"><span class="glyphicon glyphicon-time" aria-hidden="true"></span></button>
							<button class="btn btn-danger" type="button" title="Cancelar Cita" onclick="javascript:CancelCitas'.$ventana.'(\''.$row[0].'\');"><span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span></button>
						</div>
					</td>
				</tr>';
	} 
	mysqli_free_result($result);
	echo $tabla.'<input name="hdn_controwcitas'.$_GET['ventana'].'" type="hidden" id="hdn_controwcitas'.$_GET['ventana'].'" value="'.$counter.'" />';
break;

case 'CargarFactLote':
	$resultado=$resultado.'<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle'.$_GET['value'].'" ><tbody id="tbDetalle'.$_GET['value'].'"><tr id="trh'.$_GET['value'].'"> <th id="th1'.$_GET['value'].'">Ingreso</th> <th id="th2'.$_GET['value'].'">Id. Paciente</th> <th id="th2'.$_GET['value'].'">Nombre</th> <th id="th2'.$_GET['value'].'">Fecha Ing.</th> <th id="th2'.$_GET['value'].'">Diagnostico</th> <th id="th2'.$_GET['value'].'">Autorizacion</th> <th id="th2'.$_GET['value'].'">Finaliza</th> <th id="th2'.$_GET['value'].'">Pte.</th> <th id="th2'.$_GET['value'].'" >Entidad</th> <th id="th2'.$_GET['value'].'"><span class="glyphicon glyphicon-check" aria-hidden="true"></span></th> </tr> ';
	$SQL="Select lpad(a.Codigo_ADM, 10, '0'), d.ID_TER, concat(j.Apellido1_PAC,' ',j.Apellido2_PAC,' ', j.Nombre1_PAC,' ',j.Nombre2_PAC), date(a.Fecha_ADM), e.Descripcion_DGN, a.Autorizacion_ADM, sum(h.Valor_TAR * c.Cantidad_ORD), FechaFin_ADM, Ingreso_ADM, a.Codigo_ADM  From gxadmision a, gxordenescab b, gxordenesdet c, czterceros d, gxdiagnostico e, czsedes g, gxmanualestarifarios h, gxcontratos i, gxpacientes j Where j.Codigo_TER=d.Codigo_TER and a.Codigo_ADM=b.Codigo_ADM and b.Codigo_ORD=c.Codigo_ORD and d.Codigo_TER=a.Codigo_TER and i.Codigo_TAR=h.Codigo_TAR and e.Codigo_DGN=a.Codigo_DGN and g.Codigo_SDE=a.Codigo_SDE and i.Codigo_EPS=a.Codigo_EPS and i.Codigo_PLA=a.Codigo_PLA and b.Fecha_ORD between h.FechaIni_TAR and h.FechaFin_TAR and h.Codigo_SER=c.Codigo_SER  and a.Estado_ADM='I' and b.Estado_ORD='1' and a.Codigo_EPS='". $_GET["codigoeps"]."' and a.Codigo_PLA='". $_GET["codigopla"]."' and a.Fecha_ADM between '". ($_GET["fechaini"])."' and '". ($_GET["fechafin"])." 23:59:59' and g.Codigo_AFC='". $_GET["codigoafc"]."' Group By a.Codigo_ADM, d.ID_TER, d.Nombre_TER, a.Fecha_ADM, e.Descripcion_DGN, a.Autorizacion_ADM Order by ".$_GET["orden"].";";
	error_log($SQL);
	$result = mysqli_query($conexion, $SQL);
	$contarow=0;
	while($row = mysqli_fetch_row($result)) {
		$tipopte=0;
		$copagoadm=0;
		$cuotaadm=0;
		$porcentaje=0;
		$valorCuota=0;
		$valorCopago=0;
		$TipoADM=0;
		$TotalFactura=0;

		$tipopte=$row[8];
		$copagoadm=$row[9];
		$cuotaadm=$row[10];
		$porcentaje=$row[12];
		$valorCuota=$row[11];
		$valorCopago=$row[13];
		$TipoADM=$row[15];
		$TotalFactura=$row[6];

		$Pte=0;
		$Ent=$TotalFactura;
		if ($TipoADM=="A2") {
			if ($cuotaadm=='1') {
				$Pte=(($row[4]*$row[3])/$TotalFactura)*$valorCuota/$row[3];
				$Ent=$row[4]-$Pte;
			}
		}
		if ($copagoadm=='1') {
			if ($totalpaciente < $valorCopago) {
				$Pte=$row[4]*$porcentaje/100;
				$Ent=$row[4]-$Pte;
			}
		}
		$totalpaciente=$totalpaciente+($Pte*$row[3]);
		if ($copagoadm=='1') {
			if ($totalpaciente > $valorCopago) {
				//$Ent=($totalpaciente - $valorCopago)/$row[3];
				//$Pte=($row[4]*$porcentaje/100);
				$Pte=$Pte*$row[3]- ($totalpaciente - $valorCopago)/$row[3];
				$Ent=$row[4]-$Pte;
				$totalpaciente=$totalpaciente+($Pte*$row[3]);

			}
			if ($totalpaciente == $valorCopago) {
				$Pte=0;
				$Ent=$row[4];
				$totalpaciente=$totalpaciente+($Pte*$row[3]);
			}
		}
		$totalentidad=$totalentidad+($Ent*$row[3]);

		$contarow=$contarow+1;
	  	$resultado=$resultado.'<tr ><td><input name="hdn_ingreso'.$contarow.$_GET['value'].'" type="hidden" id="hdn_ingreso'.$contarow.$_GET['value'].'" value="'.(int)$row[0].'" />'.$row[0].'</td><td>'.($row[1]).'</td><td>'.($row[2]).'</td><td>'.FormatoFecha($row[3]).'</td><td>'.$row[4].'</td><td>'.$row[5].'</td><td>'.FormatoFecha($row['FechaFin_ADM']).'</td><td align="right"><input name="hdn_valorPte'.$contarow.$_GET['value'].'" type="hidden" id="hdn_valorPte'.$contarow.$_GET['value'].'" value="'.$Pte.'" />'.number_format($Pte, 0, ",", ".").'</td><td align="right"><input name="hdn_valorEnt'.$contarow.$_GET['value'].'" type="hidden" id="hdn_valorEnt'.$contarow.$_GET['value'].'" value="'.$Ent.'" />'.number_format($Ent, 0, ",", ".").'</td><td align="center"><div class="checkbox checkbox-success"><input name="chk_facturarok'.$contarow.$_GET['value'].'" id="chk_facturarok'.$contarow.$_GET['value'].'" checked="true" type="checkbox" value=""  onclick="javascript:totalfac'.$_GET['value'].'();" class="styled"><label for="chk_radicarok'.$contarow.$NumWindow.'"></label></div><input name="hdn_facturar'.$contarow.$_GET['value'].'" type="hidden" id="hdn_facturar'.$contarow.$_GET['value'].'" value="1" /></td></tr>';
	} 
	mysqli_free_result($result);
	if ($contarow==0) {
		$resultado=$resultado.'</tbody></table><p>NO SE ENCUENTRAN REGISTROS DE INGRESOS CON ESTOS PARAMETROS.</p>';
	} else {
		$resultado='<input name="hdx_contfila'.$_GET['value'].'" type="hidden" id="hdx_contfila'.$_GET['value'].'" value="'.$contarow.'" />'.$resultado.'</tbody></table>';
	}
	echo $resultado;
break;

case 'CargarFactCapita':
	$SQL="Select Codigo_TAR From gxcontratos Where Codigo_EPS='". $_GET["codigoeps"]."' and Codigo_PLA='". $_GET["codigopla"]."';";
	$resultt = mysqli_query($conexion, $SQL);
	while($rowt = mysqli_fetch_row($resultt)) {
	  	$resultado=$resultado.'<input type="hidden" name="hdn_tarifa'.$_GET['value'].'" id="hdn_tarifa'.$_GET['value'].'" value="'.$rowt[0].'"/> ';
	} 
	mysqli_free_result($result);
	$resultado=$resultado.'<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle'.$_GET['value'].'" ><tbody id="tbDetalle'.$_GET['value'].'"><tr id="trh'.$_GET['value'].'"> <th id="th1'.$_GET['value'].'">Ingreso</th> <th id="th2'.$_GET['value'].'">Id. Paciente</th> <th id="th2'.$_GET['value'].'">Nombre</th> <th id="th2'.$_GET['value'].'">Fecha Ing.</th> <th id="th2'.$_GET['value'].'">Diagnostico</th> </tr> ';
	$SQL="Select lpad(a.Codigo_ADM, 10, '0'), d.ID_TER, concat(j.Apellido1_PAC,' ',j.Apellido2_PAC,' ', j.Nombre1_PAC,' ',j.Nombre2_PAC), date(a.Fecha_ADM), e.Descripcion_DGN From gxadmision a, czterceros d, gxdiagnostico e,  czsedes g, gxpacientes j, gxeps k Where j.Codigo_TER=d.Codigo_TER and d.Codigo_TER=a.Codigo_TER and e.Codigo_DGN=a.Codigo_DGN and g.Codigo_SDE=a.Codigo_SDE and k.TipoContrato_EPS='CAPITA' and k.Codigo_EPS=a.Codigo_EPS and a.Estado_ADM='I' and a.Codigo_EPS='". $_GET["codigoeps"]."' and a.Codigo_PLA='". $_GET["codigopla"]."' and a.Fecha_ADM between '". ($_GET["fechaini"])."' and '". ($_GET["fechafin"])." 23:59:59' and g.Codigo_AFC='". $_GET["codigoafc"]."' Group By a.Codigo_ADM, d.ID_TER, d.Nombre_TER, a.Fecha_ADM, e.Descripcion_DGN, a.Autorizacion_ADM Order by 1;";
	$result = mysqli_query($conexion, $SQL);
	$contarow=0;
	// $resultado=$SQL;
	while($row = mysqli_fetch_row($result)) {
		$contarow=$contarow+1;
	  	$resultado=$resultado.'<tr ><td><input name="hdn_ingreso'.$contarow.$_GET['value'].'" type="hidden" id="hdn_ingreso'.$contarow.$_GET['value'].'" value="'.(int)$row[0].'" />'.$row[0].'</td><td>'.($row[1]).'</td><td>'.($row[2]).'</td><td>'.FormatoFecha($row[3]).'</td><td>'.$row[4].'</td></tr>';
	} 
	mysqli_free_result($result);
	if ($contarow==0) {
		$resultado=$resultado.'</tbody></table><p>NO SE ENCUENTRAN REGISTROS DE INGRESOS CON ESTOS PARAMETROS.</p>';
	} else {
		$resultado='<input name="hdx_contfila'.$_GET['value'].'" type="hidden" id="hdx_contfila'.$_GET['value'].'" value="'.$contarow.'" />'.$resultado.'</tbody></table>';
	}
	echo $resultado;
break;
 
case 'CargarFactGrupal':
	$resultado=$resultado.'<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle'.$_GET['value'].'" ><tbody id="tbDetalle'.$_GET['value'].'"><tr id="trh'.$_GET['value'].'"> <th id="th1'.$_GET['value'].'">Ingreso</th> <th id="th2'.$_GET['value'].'">Id. Paciente</th> <th id="th2'.$_GET['value'].'">Nombre</th> <th id="th2'.$_GET['value'].'">Fecha Ing.</th> <th id="th2'.$_GET['value'].'">Diagnostico</th> </tr> ';
	$SQL="Select lpad(a.Codigo_ADM, 10, '0'), d.ID_TER, d.Nombre_TER, date(a.Fecha_ADM), e.Descripcion_DGN From gxadmision a, czterceros d, gxdiagnostico e, gxeps k Where  d.Codigo_TER=a.Codigo_TER and e.Codigo_DGN=a.Codigo_DGN and k.TipoContrato_EPS='EVENTO' and k.Codigo_EPS=a.Codigo_EPS and a.Estado_ADM='I' and a.Codigo_EPS='". $_GET["codigoeps"]."' and a.Codigo_PLA='". $_GET["codigopla"]."' and a.Fecha_ADM between '". ($_GET["fechaini"])."' and '". ($_GET["fechafin"])."' and a.Codigo_SDE='". $_GET["codigoafc"]."' Group By a.Codigo_ADM, d.ID_TER, d.Nombre_TER, a.Fecha_ADM, e.Descripcion_DGN, a.Autorizacion_ADM Order by 1;";
	
	$result = mysqli_query($conexion, $SQL);
	$contarow=0;
	// $resultado=$SQL;
	while($row = mysqli_fetch_row($result)) {
		$contarow=$contarow+1;
	  	$resultado=$resultado.'<tr ><td><input name="hdn_ingreso'.$contarow.$_GET['value'].'" type="hidden" id="hdn_ingreso'.$contarow.$_GET['value'].'" value="'.(int)$row[0].'" />'.$row[0].'</td><td>'.($row[1]).'</td><td>'.($row[2]).'</td><td>'.FormatoFecha($row[3]).'</td><td>'.$row[4].'</td></tr>';
	} 
	mysqli_free_result($result);
	if ($contarow==0) {
		$resultado=$resultado.'</tbody></table><p>NO SE ENCUENTRAN REGISTROS DE INGRESOS CON ESTOS PARAMETROS.</p>';
	} else {
		$resultado='<input name="hdx_contfila'.$_GET['value'].'" type="hidden" id="hdx_contfila'.$_GET['value'].'" value="'.$contarow.'" />'.$resultado.'</tbody></table>';
	}
	echo $resultado;
break;

case 'FechaActual':
	$SQL="Select curdate();";	
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
		echo trim($row[0]);
	} 
	mysqli_free_result($result);
break;

case 'HoraActual':
	$SQL="Select curtime();";	
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
		echo trim($row[0]);
	} 
	mysqli_free_result($result);
break;

case 'LoadFavs':
	if ($_SESSION["it_CodigoPRF"]!='0') {
		$SQL="Select distinct a.Codigo_ITM, Icono_ITM, Nombre_ITM, Enlace_ITM, Contador_FAV from itfavoritos a, ".$_SESSION['DB_NXS'].".ititems b, itpermisos c, itusuarios d Where a.Codigo_ITM=b.Codigo_ITM and a.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' and Activo_ITM='1' and c.Codigo_PRF=d.Codigo_PRF and a.Codigo_USR=d.Codigo_USR and a.Codigo_ITM=c.Codigo_ITM Order by Contador_FAV desc Limit 6;";
	} else {
		$SQL="Select distinct a.Codigo_ITM, Icono_ITM, Nombre_ITM, Enlace_ITM, Contador_FAV from itfavoritos a, ".$_SESSION['DB_NXS'].".ititems b, itusuarios d Where a.Codigo_ITM=b.Codigo_ITM and a.Codigo_USR='".$_SESSION["it_CodigoUSR"]."' and Activo_ITM='1' and  a.Codigo_USR=d.Codigo_USR Order by Contador_FAV desc Limit 6;";
	}
	$result = mysqli_query($conexion, $SQL);
	$ItemFav="";
	while($row = mysqli_fetch_row($result)) {
		$iconito=$row[1];
		if ($row[1]=="default.png") {
			$iconito="logo-nexus-it.png";
			if (substr($row[3], 0, 3)=="rep") {
				$iconito="report.png";
			}
		}
		$ItemFav=$ItemFav.'
		<div class="col-md-2 col-sm-4 col-xs-6">
<div class="box manito" id="nxsFavDiv-'.$row[0].'" onclick="CargarForm(\'application/'.$row[3].'\',\''.$row[2].'\', \''.$iconito.'\')"  style="margin-bottom: 0px;">
  <div class="box-header" style="margin-top:2px; background-image: url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/icons/32x32/'.$iconito.');background-position: center;background-repeat: no-repeat;">
    <small><span class="glyphicon glyphicon-share-alt" aria-hidden="true"></span> </small>
  </div>
  <div class="box-body no-padding center-block" >
    <p class="text-center"><small>'.$row[2].'</small></p>
  </div>
</div>
		</div>
		';
	} 
	mysqli_free_result($result);
	echo $ItemFav;
break; 

case 'DespMedSol':
	$resultado=$resultado.'<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle" id="tblDetalle'.$NumWindow.'" ><tbody id="tbDetalle'.$NumWindow.'"><tr id="trh'.$NumWindow.'"><th id="th1'.$NumWindow.'">Solicitud</td><th id="th2'.$NumWindow.'">Fecha</td><th id="th2'.$NumWindow.'">Hora</td><th id="th2'.$NumWindow.'">Paciente</td><th id="th2'.$NumWindow.'">Cama</td><th id="th2'.$NumWindow.'">Servicio</td><th id="th2'.$NumWindow.'">Usuario</td></tr> ';
	$SQL="Select distinct a.Codigo_ISF, a.Fecha_ISF, a.Hora_ISF, b.Nombre_TER, d.Nombre_CAM, f.Nombre_ARE, g.Nombre_USR From czinvsolfarmacia a, czterceros b, gxcamas d, gxadmision e, gxareas f, itusuarios g, itusuarios h, itusuariossedes i Where i.Codigo_USR=h.Codigo_USR and h.Codigo_USR=e.Codigo_USR and b.Codigo_TER=a.Codigo_TER and a.Ordena_ISF=g.Codigo_USR and f.Codigo_ARE=a.Codigo_ARE and e.Codigo_ADM=a.Codigo_ADM and d.Codigo_CAM=e.Codigo_CAM and a.Estado_ISF in ('S', 'P')  and a.Pendiente_ISF > 0";
	if ($_GET['filtroarea']!='X') {	
		$SQL=$SQL." and c.Codigo_ARE='".$_GET['filtroarea']."'";
	}
	if (ltrim(rtrim($_GET['filtropcte']))!='') {	
		$SQL=$SQL." and b.Nombre_TER like '%".$_GET['filtropcte']."%'";
	}
	$SQL=$SQL." and a.Fecha_ISF >= '".($_GET['filfecini'])."' and a.Fecha_ISF <='".($_GET['filfecfin'])."'";
	$SQL=$SQL." Order by 2, 3, 1;";
	$result = mysqli_query($conexion, $SQL);
	//$resultado=$resultado.$SQL;
	while($row = mysqli_fetch_row($result)) {
  	$resultado=$resultado.'<tr onclick="javascript:EditSolFarm(\''.$row[0].'\', \''. $_GET["ventana"].'\');" data-toggle="modal" data-target="#GnmX_WinModal"><td>'.add_ceros($row[0],6).'</td><td>'.($row[1]).'</td><td>'.($row[2]).'</td><td>'.($row[3]).'</td><td>'.$row[4].'</td><td>'.$row[5].'</td><td>'.$row[6].'</td></tr>';
	} 
	mysqli_free_result($result);
	$resultado=$resultado.'</tbody></table>';
	echo $resultado;
break;

case 'DespMedSol2':
	$resultado=$resultado.'<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle" id="tblDetalle'.$NumWindow.'" ><tbody id="tbDetalle'.$NumWindow.'"><tr id="trh'.$NumWindow.'"><th id="th1'.$NumWindow.'">Solicitud</td><th id="th2'.$NumWindow.'">Fecha</td><th id="th2'.$NumWindow.'">Hora</td><th id="th2'.$NumWindow.'">Paciente</td><th id="th2'.$NumWindow.'">Cama</td><th id="th2'.$NumWindow.'">Servicio</td><th id="th2'.$NumWindow.'">Usuario</td></tr> ';
	$SQL="Select distinct a.Codigo_ISF, a.Fecha_ISF, a.Hora_ISF, b.Nombre_TER, d.Nombre_CAM, f.Nombre_ARE, g.Nombre_USR From czinvsolfarmacia a, czterceros b, gxcamas d, gxadmision e, gxareas f, itusuarios g, itusuarios h, itusuariossedes i Where i.Codigo_USR=h.Codigo_USR and h.Codigo_USR=e.Codigo_USR and b.Codigo_TER=a.Codigo_TER and a.Ordena_ISF=g.Codigo_USR and f.Codigo_ARE=a.Codigo_ARE and e.Codigo_ADM=a.Codigo_ADM and d.Codigo_CAM=e.Codigo_CAM and a.Estado_ISF in ('S')  and a.Pendiente_ISF > 0";
	error_log($SQL);
	if ($_GET['filtroarea']!='X') {	
		$SQL=$SQL." and c.Codigo_ARE='".$_GET['filtroarea']."'";
	}
	if (ltrim(rtrim($_GET['filtropcte']))!='') {	
		$SQL=$SQL." and b.Nombre_TER like '%".$_GET['filtropcte']."%'";
	}
	$SQL=$SQL." and a.Fecha_ISF >= '".($_GET['filfecini'])."' and a.Fecha_ISF <='".($_GET['filfecfin'])."'";
	$SQL=$SQL." Order by 2, 3, 1;";
	$result = mysqli_query($conexion, $SQL);
	//$resultado=$resultado.$SQL;
	while($row = mysqli_fetch_row($result)) {
  	$resultado=$resultado.'<tr onclick="javascript:invdesppac(\''.$row[0].'\', \''. $_GET["ventana"].'\');" data-toggle="modal" data-target="#GnmX_WinModal"><td>'.add_ceros($row[0],6).'</td><td>'.($row[1]).'</td><td>'.($row[2]).'</td><td>'.($row[3]).'</td><td>'.$row[4].'</td><td>'.$row[5].'</td><td>'.$row[6].'</td></tr>';
	} 
	mysqli_free_result($result);
	$resultado=$resultado.'</tbody></table>';
	echo $resultado;
break;

case 'HayOrdenesHC':
	$SQL="Select Codigo_HCF from ".$_GET['tabla']." a, czterceros b Where a.Codigo_TER=b.Codigo_TER and ID_TER='".$_GET['historia']."' and Codigo_HCF between ".$_GET['folioini']." and ".$_GET['foliofin'].";";
	$result = mysqli_query($conexion, $SQL);
	if ($row = mysqli_fetch_row($result)) {
  		$resultado="true";
	} else {
		$resultado="false";
	}
	mysqli_free_result($result);
	echo $SQL;
break;


case 'ListadoPlanes':
	$resultado=$resultado.'<table width="99%" border="0" align="center" cellpadding="2" cellspacing="1" class="tblDetalle"><tbody class="tbDetalle"><tr><th>Codigo</th><th>Plan de Atencion</th><th>Estado</th></tr>';
	$SQL="Select Codigo_PLA, Nombre_PLA, case Estado_PLA when '1' then 'Activo' else 'Inactivo' end from gxplanes;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
  	$resultado=$resultado.'<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td></tr>';
	} 
	mysqli_free_result($result);
	$resultado=$resultado.'</tbody></table>';
	echo $resultado;
break;

case 'ManualTarifarioServ':
	$resultado='<div id="zero_tarifa'.$_GET['value'].'" class="detalleord table-responsive "  ><table width="99%" border="0" align="center" cellpadding="2" cellspacing="1" class="table table-striped table-condensed tblDetalle table-bordered"><tbody style="font-size: 12px;"><tr><th>Codigo</th><th>CUPS</th><th>Servicio</th><th>Valor</th></tr>';
	$SQL="Select b.Codigo_SER, Nombre_SER, Valor_TAR, c.CUPS_PRC from gxmanualestarifarios a, gxservicios b, gxprocedimientos c where c.Codigo_SER=a.Codigo_SER and a.Codigo_SER=b.Codigo_SER and Tipo_SER='1' and Codigo_TAR='".$_GET['value']."' and CURDATE() between FechaIni_TAR and FechaFin_TAR Order By 2;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
  	$resultado=$resultado.'<tr><td>'.$row[0].'</td><td>'.$row[3].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td></tr>';
	} 
	mysqli_free_result($result);
	$resultado=$resultado.'</tbody></table></div>';
	echo $resultado;
break;

case 'ManualTarifarioProd':
	$resultado='<div id="zero_tarifa'.$_GET['value'].'" class="detalleord table-responsive "  ><table width="99%" border="0" align="center" cellpadding="2" cellspacing="1" class="table table-striped table-condensed tblDetalle table-bordered"><tbody style="font-size: 12px;"><tr><th>Codigo</th><th>Producto</th><th>Valor</th></tr>';
	$SQL="Select b.Codigo_SER, Nombre_SER, Valor_TAR end from gxmanualestarifarios a, gxservicios b where a.Codigo_SER=b.Codigo_SER and Tipo_SER='2' and Codigo_TAR='".$_GET['value']."' and CURDATE() between FechaIni_TAR and FechaFin_TAR Order By 2;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
  	$resultado=$resultado.'<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td></tr>';
	} 
	mysqli_free_result($result);
	$resultado=$resultado.'</tbody></table></div>';
	echo $resultado;
break;

case 'ManualTarifarioPaq':
	$resultado='<div id="zero_tarifa'.$_GET['value'].'" class="detalleord table-responsive "  ><table width="99%" border="0" align="center" cellpadding="2" cellspacing="1" class="table table-striped table-condensed tblDetalle table-bordered"><tbody style="font-size: 12px;"><tr><th>Codigo</th><th>Paquete</th><th>Valor</th></tr>';
	$SQL="Select b.Codigo_SER, Nombre_SER, Valor_TAR end from gxmanualestarifarios a, gxservicios b where a.Codigo_SER=b.Codigo_SER and Tipo_SER='3' and Codigo_TAR='".$_GET['value']."' and CURDATE() between FechaIni_TAR and FechaFin_TAR Order By 2;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
  	$resultado=$resultado.'<tr><td>'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td></tr>';
	} 
	mysqli_free_result($result);
	$resultado=$resultado.'</tbody></table></div>';
	echo $resultado;
break;

case 'IngresosAbiertos':
	$Codigo= rtrim($_GET['value']);
	$SQL="Select count(Codigo_ADM) from gxadmision a, czterceros b Where a.Codigo_TER=b.Codigo_TER and ID_TER='".$Codigo."' and Estado_ADM='I';";
	$resultado="0";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) {
		$resultado= $row[0];
	} 
	mysqli_free_result($result);
	echo $resultado;
break;

case 'ContratoPte':
	$Codigo= rtrim($_GET['value']);
	$SQL="Select a.Codigo_EPS from gxpacientes a, czterceros b, gxeps c Where a.Codigo_TER=b.Codigo_TER and ID_TER='".$Codigo."' and a.Codigo_EPS=c.Codigo_EPS and Estado_EPS='1' and curdate() between FechaIni_EPS and FechaFin_EPS;";
	$resultado=$SQL;
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$resultado= $row[0];
	} else {
		$resultado="N/A";
	}
	mysqli_free_result($result);
	echo $resultado;
break;

case 'ExtraerImagen':
	$SQL = "SELECT ".rtrim($_GET['campo'])." FROM itusuarios WHERE Codigo_USR='".rtrim($_GET['value'])."'";
	$result = mysqli_query($conexion, $SQL);
	$result_array = mysqli_fetch_array($result);
	if (file_exists('../../../files/images/users/'.rtrim($_GET['campo']).'_'.rtrim($_GET['value']).'.jpg')) {
		file_put_contents('../../../files/images/users/'.rtrim($_GET['campo']).'_'.rtrim($_GET['value']).'.jpg', chr(13).chr(10), FILE_APPEND);
	}
	file_put_contents('../../../files/images/users/'.rtrim($_GET['campo']).'_'.rtrim($_GET['value']).'.jpg', $result_array[0], FILE_APPEND);	
		
	mysqli_free_result($result);
break;

case 'ExecSearch':
	set_time_limit(180);
	include 'buscarsql.php';
	$MyQuery = str_replace('\\','',rtrim($_GET['value']));
	if($MyQuery != '' ){
		$SQL1="Select ".$SQL." and 1=0";
		$resultado ='
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" class="table table-striped table-condensed ">
		  <tr>';
		$result1 = mysqli_query( $conexion, $SQL1);
		$totalcols = mysqli_num_fields($result1);
		$contacols=0;
		while($totalcols>$contacols) 
			{
				$Object=mysqli_fetch_field($result1, $contacols);
				$contacols++;
				$resultado=$resultado.'
				    <td align="center" valign="middle" class="tablehead">'.$Object->name.'</td>';
			}
		mysqli_free_result($result1); 
		$resultado=$resultado.'
		  </tr>';
		if ($MyQuery=="NULL") {  
			$SQL2="Select ".$SQLx;	
		} else {
			$SQL2="Select ".$SQLx." and ".$MyQuery;	
		}
		$result2 = mysqli_query($conexion, $SQL2);
		$Si='No';
//				$resultado=$resultado.$SQL2;
		 while($row = mysqli_fetch_row($result2)) {
			$Si='Si';
		    $contacols=0;			
			$resultado=$resultado.'
   		  <tr class="tabledetrow" onclick="SelSearch(\''.$row[0].'\');" >';
			while($totalcols>$contacols) 
				{
				$resultado=$resultado.'
			<td valign="middle" class="tabledet1">'.($row[$contacols]).'</td>';
				$contacols++;
				}
		  $resultado=$resultado.'
		  </tr>';
		 }
		if($Si=='No'){
			$resultado=$resultado.'
			<tr class="tabledetrow";">
    			<td colspan="'.$totalcols.'" align="center" valign="middle" class="tabledet1"><span class="error">BUSQUEDA SIN RESULTADOS.</span></td>
    		</tr>';
		}
		mysqli_free_result($result2);
			$resultado=$resultado.'
		</table>';
		echo $resultado;
	}else{
		echo '';
	}
break;

case 'ContarMSG':
	$resultado='0';
	$SQL="Select count(a.Codigo_USR) From itmensajes a Where a.Codigo_USR='".$_SESSION["it_CodigoUSR"]."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$resultado=$row[0];
	}
	mysqli_free_result($result);
	echo $resultado;	
break;

case 'SiEsQx':
	$resultado='';
	$SQL="Select Nombre_PRC, UVR_PRC, Codigo_SER From gxprocedimientos Where Procedimiento_PRC='1' and trim(Codigo_SER)=trim('".$_GET['Codigo1']."');";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$resultado=$resultado.' <table width="50%" border="0" align="left" cellpadding="2" cellspacing="2">
   <tr>
     <th colspan="4" class="nombre" scope="col">'.$row[0].'</th>
    </tr>
   <tr>
     <td align="center" class="tablehead">Codigo</td>
     <td align="center" class="tablehead">Servicio</td>
     <td align="center" class="tablehead">Cantidad</td>
     <td align="center" class="tablehead">%</td>
   </tr>
';
		$CONTAPRC=$_GET['Items'];
		//especialista
		$SQL="Select a.Codigo_SER, Nombre_PRC, CUPS_PRC, '1' From gxprocedimientos as a, gxservicios as b Where Especialista_PRC='1' and a.Codigo_SER=b.Codigo_SER and b.Estado_SER='1' Union 
		Select a.Codigo_SER, Nombre_PRC, CUPS_PRC, '2' From gxprocedimientos as a, gxservicios as b Where Anestesiologo_PRC='1' and a.Codigo_SER=b.Codigo_SER and b.Estado_SER='1' Union 
		Select a.Codigo_SER, Nombre_PRC, CUPS_PRC, '3' From gxprocedimientos as a, gxservicios as b Where Ayudante_PRC='1' and a.Codigo_SER=b.Codigo_SER and b.Estado_SER='1' Union 
		Select a.Codigo_SER, Nombre_PRC, CUPS_PRC, '4' From gxprocedimientos as a, gxservicios as b Where Sala_PRC='1' and UVRMin_PRC <= ".$row[1]." and UVRMax_PRC >= ".$row[1]." and a.Codigo_SER=b.Codigo_SER and b.Estado_SER='1' Union 
		Select a.Codigo_SER, Nombre_PRC, CUPS_PRC, '5' From gxprocedimientos as a, gxservicios as b Where Material_PRC='1' and UVRMin_PRC <= ".$row[1]." and UVRMax_PRC >= ".$row[1]." and a.Codigo_SER=b.Codigo_SER and b.Estado_SER='1';";
		$resultX = mysqli_query($conexion, $SQL);
		while($rowX = mysqli_fetch_row($resultX)) {
			$CONTAPRC++;
			$resultado=$resultado.'<tr class="tabledetrow" >
     <td align="center" class="tabledet1"><input name="hdn_codigoproc1'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_codigoproc1'.$CONTAPRC.$_GET['Ventana'].'" value="'.$row[2].'"/>
       '.$rowX[2].'
       <input name="hdn_tipoproc'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_tipoproc'.$CONTAPRC.$_GET['Ventana'].'" value="'.$rowX[3].'" /></td>
     <td align="left" class="tabledet1"><input name="hdn_codigoproc2'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_codigoproc2'.$CONTAPRC.$_GET['Ventana'].'" value="'.$rowX[0].'"/>
       '.$rowX[1].'</td>
     <td align="center" class="tabledet1"><input name="hdn_evento'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_evento'.$CONTAPRC.$_GET['Ventana'].'" value="1" />
       <input name="txt_cantproc'.$CONTAPRC.$_GET['Ventana'].'" type="text" id="txt_cantproc'.$CONTAPRC.$_GET['Ventana'].'" value="1" size="2" />
	   </td><td align="center" class="tabledet1">
      <input name="txt_porcproc'.$CONTAPRC.$_GET['Ventana'].'" type="text" id="txt_porcproc'.$CONTAPRC.$_GET['Ventana'].'" value="100"  size="3"/></td>
   </tr>';
		}
		mysqli_free_result($resultX);
/*		//anestesiologo
		$SQL=";";
		$resultX = mysqli_query($conexion, $SQL);
		if($rowX = mysqli_fetch_row($resultX)) {
			$CONTAPRC++;
			$resultado=$resultado.'<tr class="tabledetrow" >
     <td align="center" class="tabledet1"><input name="hdn_codigoproc1'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_codigoproc1'.$CONTAPRC.$_GET['Ventana'].'" value="'.$row[2].'"/>
       '.$rowX[2].'
       <input name="hdn_tipoproc'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_tipoproc'.$CONTAPRC.$_GET['Ventana'].'" value="2" /></td>
     <td align="left" class="tabledet1"><input name="hdn_codigoproc2'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_codigoproc2'.$CONTAPRC.$_GET['Ventana'].'" value="'.$rowX[0].'"/>
       '.$rowX[1].'</td>
     <td align="center" class="tabledet1"><input name="hdn_evento'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_evento'.$CONTAPRC.$_GET['Ventana'].'" value="1" />
       <input name="txt_cantproc'.$CONTAPRC.$_GET['Ventana'].'" type="text" id="txt_cantproc'.$CONTAPRC.$_GET['Ventana'].'" value="1" size="2" />
      <input name="hdn_porcproc'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_porcproc'.$CONTAPRC.$_GET['Ventana'].'" value="100"/></td>
   </tr>';
		}
		mysqli_free_result($resultX);
		//ayudante
		$SQL=";";
		$resultX = mysqli_query($conexion, $SQL);
		if($rowX = mysqli_fetch_row($resultX)) {
			$CONTAPRC++;
			$resultado=$resultado.'<tr class="tabledetrow" >
     <td align="center" class="tabledet1"><input name="hdn_codigoproc1'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_codigoproc1'.$CONTAPRC.$_GET['Ventana'].'" value="'.$row[2].'"/>
       '.$rowX[2].'
       <input name="hdn_tipoproc'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_tipoproc'.$CONTAPRC.$_GET['Ventana'].'" value="3" /></td>
     <td align="left" class="tabledet1"><input name="hdn_codigoproc2'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_codigoproc2'.$CONTAPRC.$_GET['Ventana'].'" value="'.$rowX[0].'"/>
       '.$rowX[1].'</td>
     <td align="center" class="tabledet1"><input name="hdn_evento'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_evento'.$CONTAPRC.$_GET['Ventana'].'" value="1" />
       <input name="txt_cantproc'.$CONTAPRC.$_GET['Ventana'].'" type="text" id="txt_cantproc'.$CONTAPRC.$_GET['Ventana'].'" value="1" size="2" />
      <input name="hdn_porcproc'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_porcproc'.$CONTAPRC.$_GET['Ventana'].'" value="100"/></td>
   </tr>';
		}
		mysqli_free_result($resultX);		

		//sala
		$SQL=";";
		$resultX = mysqli_query($conexion, $SQL);
		if($rowX = mysqli_fetch_row($resultX)) {
			$CONTAPRC++;
			$resultado=$resultado.'<tr class="tabledetrow" >
     <td align="center" class="tabledet1"><input name="hdn_codigoproc1'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_codigoproc1'.$CONTAPRC.$_GET['Ventana'].'" value="'.$row[2].'"/>
       '.$rowX[2].'
       <input name="hdn_tipoproc'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_tipoproc'.$CONTAPRC.$_GET['Ventana'].'" value="4" /></td>
     <td align="left" class="tabledet1"><input name="hdn_codigoproc2'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_codigoproc2'.$CONTAPRC.$_GET['Ventana'].'" value="'.$rowX[0].'"/>
       '.$rowX[1].'</td>
     <td align="center" class="tabledet1"><input name="hdn_evento'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_evento'.$CONTAPRC.$_GET['Ventana'].'" value="1" />
       <input name="txt_cantproc'.$CONTAPRC.$_GET['Ventana'].'" type="text" id="txt_cantproc'.$CONTAPRC.$_GET['Ventana'].'" value="1" size="2" />
      <input name="hdn_porcproc'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_porcproc'.$CONTAPRC.$_GET['Ventana'].'" value="100"/></td>
   </tr>';
		}
		mysqli_free_result($resultX);	
		
		//materiales
		$SQL=";";
		$resultX = mysqli_query($conexion, $SQL);
		if($rowX = mysqli_fetch_row($resultX)) {
			$CONTAPRC++;
			$resultado=$resultado.'<tr class="tabledetrow" >
     <td align="center" class="tabledet1"><input name="hdn_codigoproc1'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_codigoproc1'.$CONTAPRC.$_GET['Ventana'].'" value="'.$row[2].'"/>
       '.$rowX[2].'
       <input name="hdn_tipoproc'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_tipoproc'.$CONTAPRC.$_GET['Ventana'].'" value="5" /></td>
     <td align="left" class="tabledet1"><input name="hdn_codigoproc2'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_codigoproc2'.$CONTAPRC.$_GET['Ventana'].'" value="'.$rowX[0].'"/>
       '.$rowX[1].'</td>
     <td align="center" class="tabledet1"><input name="hdn_evento'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_evento'.$CONTAPRC.$_GET['Ventana'].'" value="1" />
       <input name="txt_cantproc'.$CONTAPRC.$_GET['Ventana'].'" type="text" id="txt_cantproc'.$CONTAPRC.$_GET['Ventana'].'" value="1" size="2" />
      <input name="hdn_porcproc'.$CONTAPRC.$_GET['Ventana'].'" type="hidden" id="hdn_porcproc'.$CONTAPRC.$_GET['Ventana'].'" value="100"/></td>
   </tr>';
		}	
		mysqli_free_result($resultX);	
*/				
		$resultado=$resultado.' </table><input name="hdn_contproc'.$_GET['Codigo1'].$_GET['Ventana'].'" type="hidden" id="hdn_contproc'.$_GET['Codigo1'].$_GET['Ventana'].'" value="'.$CONTAPRC.'" />';
	} 
	mysqli_free_result($result);
	echo $resultado;
break;

case "CloseSession":
	session_destroy();
break;

case "KillPic":
	if (file_exists('../../../'.$_GET["value"])){ 
	    unlink('../../../'.$_GET["value"]); 
	}
	copy('../../../'.$_GET["ruta"].'0.png', '../../../'.$_GET["ruta"].$_GET["archivo"].'.png');
break;

case "KillFirma":
	if (file_exists('../../../'.$_GET["value"])){ 
	    unlink('../../../'.$_GET["value"]); 
	}
	copy('../../../'.$_GET["ruta"].'0.png', '../../../'.$_GET["ruta"].$_GET["archivo"].'.png');
break;

case  'CargarFacturasRad':
	$fechaini = rtrim($_GET['fechaini']);
	$fechafin = rtrim($_GET['fechafin']);
	$sede = rtrim($_GET['sede']);
	$plan = rtrim($_GET['plan']);
	$eps = rtrim($_GET['eps']);
	if($fechaini != '' ){
		$SQL="Select a.Codigo_FAC, d.Nombre_PLA, concat(e.Sigla_TID,' ', c.ID_TER), c.Nombre_TER, a.Fecha_FAC, a.ValEntidad_FAC, '0' 
From gxfacturas as a, gxadmision as b, czterceros as c, gxplanes as d, cztipoid as e
Where b.Codigo_SDE='".($sede)."' and a.Codigo_ADM=b.Codigo_ADM and b.Codigo_TER=c.Codigo_TER and a.Codigo_PLA=d.Codigo_PLA and c.Codigo_TID=e.Codigo_TID 
and a.Estado_FAC='1' and a.Fecha_FAC >='".($fechaini)."' and a.Fecha_FAC<='".($fechafin)." 23:59:59' and a.Codigo_PLA='".$plan."' and a.Codigo_EPS='".$eps."' 
 and a.Codigo_FAC not in (select codigo_fac from czradicacionesdet)  

Union

Select w.Codigo_FAC, s.Nombre_PLA, concat(v.FechaIni_FAC, ' - ', v.FechaFin_FAC) , v.Servicio_FAC, w.Fecha_FAC, w.ValEntidad_FAC, '0' 
From gxfacturas as w, gxfacturascapita as v, gxplanes as s
Where w.Codigo_FAC=v.Codigo_FAC and w.Codigo_PLA=s.Codigo_PLA 
and w.Estado_FAC='1' and w.Fecha_FAC >='".($fechaini)."' and w.Fecha_FAC<='".($fechafin)." 23:59:59' and w.Codigo_PLA='".$plan."' and w.Codigo_EPS='".$eps."' 
 and w.Codigo_FAC not in (select codigo_fac from czradicacionesdet)    

Order by 1 asc;";	
		$contarow=0;
		$resultado='<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblDetalle'.$_GET['Ventana'].'" >
<tbody id="tbDetalle'.$_GET['Ventana'].'">
<tr id="trh'.$_GET['Ventana'].'"> 
		  <th id="th4'.$_GET['Ventana'].'">[::]</th>
          <th id="th1'.$_GET['Ventana'].'">Factura</th> 
          <th id="th2'.$_GET['Ventana'].'">Plan</th> 
          <th id="th3'.$_GET['Ventana'].'">Documento</th> 
          <th id="th3'.$_GET['Ventana'].'">Paciente</th> 
          <th id="th3'.$_GET['Ventana'].'">Fecha</th>    
          <th id="th3'.$_GET['Ventana'].'">Valor</th>  
</tr>';
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_row($result)) {
			$contarow++;
			$resultado=$resultado.'<tr><td align="center"><input name="chk_radicarok'.$contarow.$_GET['Ventana'].'" id="chk_radicarok'.$contarow.$_GET['Ventana'].'" type="checkbox" value="" onclick="javascript:totalrad'.$_GET['Ventana'].'();"><input name="hdn_radicar'.$contarow.$_GET['Ventana'].'" type="hidden" id="hdn_radicar'.$contarow.$_GET['Ventana'].'" value="'.$row[5].'"></td><td align="center"><input name="hdn_factura'.$contarow.$_GET['Ventana'].'" type="hidden" id="hdn_factura'.$contarow.$_GET['Ventana'].'" value="'.$row[0].'">'.$row[0].'</td><td>'.$row[1].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[4].'</td><td align="right"><input name="hdn_valor'.$contarow.$_GET['Ventana'].'" type="hidden" id="hdn_valor'.$contarow.$_GET['Ventana'].'" value="'.$row[5].'">'.number_format($row[5], 2, ",", ".").'</td></tr>
			';
		}
		if ($contarow==0) {
			$resultado=$resultado.'<tr><td colspan="6" align="center"><span class="error">Los par&aacute;metros dados no arrojaron cuentas por radicar.</span></td></tr>';
		}
		$resultado=$resultado.'</tbody>
</table>
<input name="hdn_controw'.$_GET['Ventana'].'" type="hidden" id="hdn_controw'.$_GET['Ventana'].'" value="'.$contarow.'" />
';
		mysqli_free_result($result);
		echo $resultado;
	}else{
		echo '';
	}
break;

case "RIPS":
	require('pclzip.lib.php');	
	$CodRAD= rtrim($_GET['value']);
	$SQL="Select RIPSdx_XFC from itconfig_fc";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$OrigenDx=$row[0];
	}
	mysqli_free_result($result);
	$SQL="Select rtrim(a.Codigo_EPS), a.Estado_RAD, LPAD(a.Codigo_RAD,10,'0'), '".$_SESSION["DB_SUFFIX"]."', LPAD(a.Codigo_RAD,6,'0') From czradicacionescab as a, gxprestadores as b Where LPAD(a.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0');";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		if ($row[1]=="0"){
			$resultado='La radicacion '.$row[2].' se encuentra anulada.';
		} else {
			$CodEPS= $row[0];
			$CodRAD= $row[2];
			mysqli_free_result($result);
			$resultado='<p><label>Archivos de la radicaci&oacute;n:</label> '.$CodRAD;
			//Se crea la carpeta si no existe...
			$RutaRIPS='../../../files/'.$_SESSION["DB_SUFFIX"].'/rips/';
			$RutaRIPS0='';
			if (!(is_dir('../../../files/'.$_SESSION["DB_SUFFIX"].'/rips'))) {
				mkdir ('../../../files/'.$_SESSION["DB_SUFFIX"].'/rips', 0777);
			}
			if (!(is_dir($RutaRIPS.$CodEPS))) {
				mkdir ($RutaRIPS.$CodEPS, 0777);
			}
			$resultado=$resultado.' <label>Carpeta:</label> ../'.$CodEPS.'/ ';
			//Verifico el siguiente numero de remision...
			$SQL="Update gxeps Set RemisionRIPS_EPS='".$row[4]."' Where Codigo_EPS='".$CodEPS."';";
			mysqli_query($conexion, $SQL);
			$SQL="Select '".$row[4]."', LPAD(a.RemisionRIPS_EPS,6,'0') From gxeps as a Where a.Codigo_EPS='".$CodEPS."';";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$CodREM= $row[0];
				$resultado=$resultado.' <label>Remisi&oacute;n No.</label> '.$CodREM.'</p>				<ul class="list-inline text-center">';
			}
			mysqli_free_result($result);
			
			//=================== R.I.P.S. ======================
			$NoFiles=0;
			//Primero borramos RIPS previos
			$filex = glob($RutaRIPS.$CodEPS.'/*'.$CodREM.'.TXT'); //obtenemos todos los nombres de los ficheros
			foreach($filex as $filez){
				if(is_file($filez))
				unlink($filez); //elimino el fichero
			}
		//Archivo AF
	$NoAF=0;
	$SQL = "Select '',trim(a.Prestador_FCN), ucase(trim(a.RazonSocial_FCN)), trim(a.TipoId_FCN), trim(a.Identificacion_FCN), trim(b.Codigo_FAC), date_format(b.Fecha_FAC,'%d/%m/%Y'), date_format(h.Fecha_ADM,'%d/%m/%Y'), date_format(b.Fecha_FAC,'%d/%m/%Y'), trim(c.CodMin_EPS), trim(d.Nombre_TER), trim(c.Contrato_EPS), trim(ucase(f.Nombre_PLA)), '', ROUND(b.ValPaciente_FAC), 0, ROUND(b.ValDcto_FAC), ROUND(b.ValTotal_FAC) From gxprestadores as a, gxfacturas as b, gxeps as c, czterceros as d, czradicacionesdet as e, gxplanes as f, gxadmision as h, czsedes j Where j.Codigo_SDE=h.Codigo_SDE and j.codigo_PRS=a.Codigo_PRS and b.Codigo_EPS=c.Codigo_EPS and d.Codigo_TER=c.Codigo_TER and e.Codigo_FAC=b.Codigo_FAC and f.Codigo_PLA=b.Codigo_PLA and h.Codigo_ADM=b.Codigo_ADM and LPAD(e.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0') and b.Estado_FAC<>'0' Union Select '',trim(a.Prestador_FCN), ucase(trim(a.RazonSocial_FCN)), trim(a.TipoId_FCN), trim(a.Identificacion_FCN), trim(b.Codigo_FAC), date_format(b.Fecha_FAC,'%d/%m/%Y'), date_format(k.FechaIni_FAC ,'%d/%m/%Y'), date_format(k.FechaFin_FAC ,'%d/%m/%Y'), trim(c.CodMin_EPS), trim(d.Nombre_TER), trim(c.Contrato_EPS), trim(ucase(f.Nombre_PLA)), '', ROUND(b.ValPaciente_FAC), 0, ROUND(b.ValDcto_FAC), ROUND(b.ValTotal_FAC) From gxprestadores as a, gxfacturas as b, gxeps as c, czterceros as d, czradicacionesdet as e, gxplanes as f, gxfacturascapita as k Where b.Codigo_EPS=c.Codigo_EPS and d.Codigo_TER=c.Codigo_TER and (e.Codigo_FAC)=(b.Codigo_FAC) and f.Codigo_PLA=b.Codigo_PLA and k.Codigo_FAC=b.Codigo_FAC and LPAD(e.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0') and b.Estado_FAC<>'0' Order By 6;";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{	
		if (file_exists($RutaRIPS.$CodEPS.'/AF'.$CodREM.'.TXT')) {
			file_put_contents($RutaRIPS.$CodEPS.'/AF'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
		}
		$TextLine=$row[1].','.$row[2].','.$row[3].','.$row[4].','.$row[5].','.$row[6].','.$row[7].','.$row[8].','.$row[9].','.$row[10].','.$row[11].','.$row[12].','.$row[13].','.$row[14].','.number_format($row[15],0,'','').','.number_format($row[16],0,'','').','.number_format($row[17],0,'','');
		file_put_contents($RutaRIPS.$CodEPS.'/AF'.$CodREM.'.TXT', $TextLine, FILE_APPEND);	
		$NoAF++;
		$CodigoIPS=$row[1];
	}
	mysqli_free_result($result);
	if ($NoAF!=0){
	$resultado=$resultado.'<li><a download="" class="label label-success" href="files/'.$_SESSION["DB_SUFFIX"].'/rips/'.$RutaRIPS0.$CodEPS.'/AF'.$CodREM.'.TXT"  alt="AF" title="Archivo de Facturas AF'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/img/icons/16x16/file_extension_txt.png" align="absmiddle" />AF'.$CodREM.'.TXT</a></li>';
	$NoFiles++;
	}

		//Archivo US
	$NoUS=0;
	$SQL = "Select distinct trim(d.Sigla_TID), trim(d.Sigla_TID), trim(b.ID_TER), trim(CodMin_EPS), trim(a.Codigo_PLA), trim(e.Apellido1_PAC), trim(e.Apellido2_PAC), trim(e.Nombre1_PAC), trim(e.Nombre2_PAC), year(now())-year(e.FechaNac_PAC), '1', e.Codigo_SEX, e.Codigo_DEP, e.Codigo_MUN, e.Codigo_ZNA From gxfacturas as a, czterceros as b, gxadmision as c, cztipoid as d, gxpacientes as e, czradicacionesdet as f, gxeps as g Where a.Codigo_ADM=c.Codigo_ADM and c.Codigo_TER=b.Codigo_TER and d.Codigo_TID=b.Codigo_TID and g.Codigo_EPS=a.Codigo_EPS and a.Estado_FAC<>'0' and e.Codigo_TER=c.Codigo_TER and a.Codigo_FAC=f.Codigo_FAC and LPAD(f.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0') Union Select distinct trim(d.Sigla_TID), trim(d.Sigla_TID), trim(b.ID_TER), trim(CodMin_EPS), trim(a.Codigo_PLA), trim(e.Apellido1_PAC), trim(e.Apellido2_PAC), trim(e.Nombre1_PAC), trim(e.Nombre2_PAC), year(now())-year(e.FechaNac_PAC), '1', e.Codigo_SEX, e.Codigo_DEP, e.Codigo_MUN, e.Codigo_ZNA From gxfacturas as a, czterceros as b, gxadmision as c, cztipoid as d, gxpacientes as e, czradicacionesdet as f, gxeps as g Where a.Codigo_FAC=c.Codigo_FAC and c.Codigo_TER=b.Codigo_TER and d.Codigo_TID=b.Codigo_TID and g.Codigo_EPS=a.Codigo_EPS and a.Estado_FAC<>'0' and e.Codigo_TER=c.Codigo_TER and trim(a.Codigo_FAC)=trim(f.Codigo_FAC) and LPAD(f.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0');";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{	
		if (file_exists($RutaRIPS.$CodEPS.'/US'.$CodREM.'.TXT')) {
			file_put_contents($RutaRIPS.$CodEPS.'/US'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
		}
		$TextLine=$row[0].','.$row[2].','.$row[3].','.$row[4].','.$row[5].','.$row[6].','.$row[7].','.$row[8].','.$row[9].','.$row[10].','.$row[11].','.$row[12].','.$row[13].','.$row[14];
		file_put_contents($RutaRIPS.$CodEPS.'/US'.$CodREM.'.TXT', $TextLine, FILE_APPEND);	
		$NoUS++;
	}
	mysqli_free_result($result);
	if ($NoUS!=0){
	if (($NoFiles % 4)==0){
	$resultado=$resultado.'<br>';
	}
	$resultado=$resultado.'<li><a download="" class="label label-success" href="files/'.$_SESSION["DB_SUFFIX"].'/rips/'.$RutaRIPS0.$CodEPS.'/US'.$CodREM.'.TXT"  alt="US" title="Archivo de Usuarios US'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/img/icons/16x16/file_extension_txt.png" align="absmiddle" />US'.$CodREM.'.TXT</a></li>';
	$NoFiles++;
	}

		//Archivo AM
	$NoAM=0;
	$SQL = "Select trim(a.Codigo_FAC),trim(a.Codigo_FAC), trim(e.Prestador_FCN), trim(h.Sigla_TID), trim(f.ID_TER), c.Autorizacion_ORD, CUPS_MED, case i.Codigo_CFC when '12' then '1' when '13' then '2' end, d.Nombre_MED, 'SOLUCION INYECTABLE', '100 Mg', 'Amp', SUM(b.Cantidad_ORD), ROUND(AVG(b.ValorServicio_ORD)), ROUND(sum(b.Cantidad_ORD* b.ValorServicio_ORD)) From gxfacturas as a, gxordenesdet as b, gxordenescab as c, gxmedicamentos as d, gxprestadores as e, czterceros as f, gxadmision as g, cztipoid as h, gxservicios as i, czradicacionesdet as j, czsedes AS k WHERE k.Codigo_PRS=e.Codigo_PRS AND g.Codigo_SDE=k.Codigo_SDE AND a.Codigo_ADM=c.Codigo_ADM and b.Codigo_ORD=c.Codigo_ORD and b.Codigo_EPS=a.Codigo_EPS and b.Codigo_PLA=a.Codigo_PLA and d.Codigo_SER=b.Codigo_SER and f.Codigo_TER=g.Codigo_TER and g.Codigo_ADM=a.Codigo_ADM and h.Codigo_TID=f.Codigo_TID and i.Codigo_SER=d.Codigo_SER and i.Codigo_CFC in ('12','13') and a.Codigo_FAC=j.Codigo_FAC and c.Estado_ORD<>'0' and a.Estado_FAC<>'0' and LPAD(j.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0') Group By trim(a.Codigo_FAC), trim(e.Prestador_FCN), trim(h.Sigla_TID), trim(f.ID_TER), '', d.CUM_MED, case i.Codigo_CFC when '12' then '1' when '13' then '2' end, d.Nombre_MED, 'SOLUCION INYECTABLE', '100 Mg', 'Amp'   Union   Select trim(a.Codigo_FAC),trim(a.Codigo_FAC), trim(e.Prestador_FCN), trim(h.Sigla_TID), trim(f.ID_TER), c.Autorizacion_ORD, CUPS_MED, case i.Codigo_CFC when '12' then '1' when '13' then '2' end, d.Nombre_MED, 'SOLUCION INYECTABLE', '100 Mg', 'Amp', SUM(b.Cantidad_ORD), ROUND(AVG(b.ValorServicio_ORD)), ROUND(sum(b.Cantidad_ORD* b.ValorServicio_ORD)) From gxfacturas as a, gxordenesdet as b, gxordenescab as c, gxmedicamentos as d, gxprestadores as e, czterceros as f, gxadmision as g, cztipoid as h, gxservicios as i, czradicacionesdet as j, czsedes AS k WHERE k.Codigo_PRS=e.Codigo_PRS AND g.Codigo_SDE=k.Codigo_SDE AND a.Codigo_ADM=c.Codigo_ADM and b.Codigo_ORD=c.Codigo_ORD and b.Codigo_EPS=a.Codigo_EPS and b.Codigo_PLA=a.Codigo_PLA and d.Codigo_SER=b.Codigo_SER and f.Codigo_TER=g.Codigo_TER and g.Codigo_FAC=a.Codigo_FAC and h.Codigo_TID=f.Codigo_TID and i.Codigo_SER=d.Codigo_SER and i.Codigo_CFC in ('12','13') and a.Codigo_FAC=j.Codigo_FAC and c.Estado_ORD<>'0' and a.Estado_FAC<>'0'  and LPAD(j.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0') Group By trim(a.Codigo_FAC), trim(e.Prestador_FCN), trim(h.Sigla_TID), trim(f.ID_TER), '', d.CUM_MED, case i.Codigo_CFC when '12' then '1' when '13' then '2' end, d.Nombre_MED, 'SOLUCION INYECTABLE', '100 Mg', 'Amp';";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{	
		if (file_exists($RutaRIPS.$CodEPS.'/AM'.$CodREM.'.TXT')) {
			file_put_contents($RutaRIPS.$CodEPS.'/AM'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
		}
		$TextLine=$row[0].','.$row[2].','.$row[3].','.$row[4].','.$row[5].','.$row[6].','.$row[7].','.$row[8].','.$row[9].','.$row[10].','.$row[11].','.$row[12].','.number_format($row[13],0,'','').','.number_format($row[14],0,'','');
		file_put_contents($RutaRIPS.$CodEPS.'/AM'.$CodREM.'.TXT', $TextLine, FILE_APPEND);	
		$NoAM++;
	}
	mysqli_free_result($result);
	if ($NoAM!=0){
	if (($NoFiles % 4)==0){
	$resultado=$resultado.'<br>';
	}
	$resultado=$resultado.'<li><a download="" class="label label-success" href="files/'.$_SESSION["DB_SUFFIX"].'/rips/'.$RutaRIPS0.$CodEPS.'/AM'.$CodREM.'.TXT"  alt="AM" title="Archivo de Medicamentos AM'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/img/icons/16x16/file_extension_txt.png" align="absmiddle" />AM'.$CodREM.'.TXT</a></li>';
	$NoFiles++;
	}

		//Archivo AC
	$NoAC=0;
	if ($OrigenDx=='HCD') {
		$SQL = "Select  distinct concat (trim(a.Codigo_FAC),',', trim(b.Prestador_FCN),',', trim(e.Sigla_TID),',', trim(d.ID_TER),',',date_format(k.Fecha_HCF,'%d/%m/%Y'),',',trim(f.Autorizacion_ORD),',', trim(h.CUPS_PRC),',', Codigo_FNC,',', Codigo_CXT,',', IFNULL(l.Codigo_DGN,c.Codigo_DGN),',', IFNULL(l.CodigoR_DGN,c.Codigo_DGN),',', '',',', '',',', '1',',', REPLACE(format(ROUND(g.ValorServicio_ORD*g.Cantidad_ORD),0), ',',''),',',replace(format(ROUND(g.ValorPaciente_ORD*g.Cantidad_ORD),0), ',',''),',', replace(format(ROUND(g.ValorEntidad_ORD*g.Cantidad_ORD), 0), ',','') ) From gxfacturas as a, gxprestadores as b, gxadmision as c, czterceros as d, cztipoid as e, gxordenescab as f, gxordenesdet as g, gxprocedimientos as h, czradicacionesdet as i, gxservicios as j, czsedes as m, hctipos w, hcfolios as k left join hcdiagnosticos as l On l.Codigo_TER=k.Codigo_TER and l.Codigo_HCF=k.Codigo_HCF WHERE m.Codigo_PRS=b.Codigo_PRS AND c.Codigo_SDE=m.Codigo_SDE AND k.Codigo_ADM=c.Codigo_ADM AND w.Codigo_HCT=k.Codigo_HCT and a.Codigo_ADM=c.Codigo_ADM and d.Codigo_TER=c.Codigo_TER and e.Codigo_TID=d.Codigo_TID AND w.RipsAC_HCT='1' and f.Codigo_ADM=a.Codigo_ADM and g.Codigo_ORD=f.Codigo_ORD and j.Codigo_SER=h.Codigo_SER and j.Codigo_CFC='01' and g.Codigo_EPS=a.Codigo_EPS and g.Codigo_PLA=a.Codigo_PLA and h.Codigo_SER=g.Codigo_SER and i.Codigo_FAC=a.Codigo_FAC and f.Estado_ORD<>'0' and a.Estado_FAC<>'0' and LPAD(i.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0') Union Select  distinct concat (trim(a.Codigo_FAC),',', trim(b.Prestador_FCN),',', trim(e.Sigla_TID),',', trim(d.ID_TER),',',date_format(k.Fecha_HCF,'%d/%m/%Y'),',',trim(c.Autorizacion_ADM),',', trim(h.CUPS_PRC),',', Codigo_FNC,',', Codigo_CXT,',', IFNULL(l.Codigo_DGN,c.Codigo_DGN),',', IFNULL(l.CodigoR_DGN,c.Codigo_DGN),',', '',',', '',',', '1',',', REPLACE(format(0,0), ',',''),',',replace(format(0,0), ',',''),',', replace(format(0, 0), ',','') ) From gxfacturas as a, gxprestadores as b, gxadmision as c, czterceros as d, cztipoid as e, hctipos as w, gxprocedimientos as h, czradicacionesdet as i, gxservicios as j, czsedes as m, hcfolios as k left join hcdiagnosticos as l On l.Codigo_TER=k.Codigo_TER and l.Codigo_HCF=k.Codigo_HCF Where m.Codigo_PRS=b.Codigo_PRS AND c.Codigo_SDE=m.Codigo_SDE AND k.Codigo_ADM=c.Codigo_ADM and a.Codigo_ADM=c.Codigo_ADM and d.Codigo_TER=c.Codigo_TER and e.Codigo_TID=d.Codigo_TID and w.Codigo_SER =h.Codigo_SER  and j.Codigo_SER=h.Codigo_SER and j.Codigo_CFC='01'  and i.Codigo_FAC=a.Codigo_FAC and a.Estado_FAC<>'0' and LPAD(i.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0');";
	} else {
		$SQL = "Select  distinct concat (trim(a.Codigo_FAC),',', trim(b.Prestador_FCN),',', trim(e.Sigla_TID),',', trim(d.ID_TER),',',date_format(f.Fecha_ORD,'%d/%m/%Y'),',',trim(f.Autorizacion_ORD),',', trim(h.CUPS_PRC),',', Codigo_FNC,',', Codigo_CXT,',', c.Codigo_DGN,',', c.Codigo_DGN,',', '',',', '',',', '1',',', REPLACE(format(ROUND(g.ValorServicio_ORD*g.Cantidad_ORD),0), ',',''),',', replace(format(ROUND(g.ValorPaciente_ORD*g.Cantidad_ORD),0), ',',''),',', replace(format(ROUND(g.ValorEntidad_ORD*g.Cantidad_ORD), 0), ',','') ), f.Codigo_ORD From gxfacturas as a, gxprestadores as b, gxadmision as c, czterceros as d, cztipoid as e, gxordenescab as f, gxordenesdet as g, gxprocedimientos as h, czradicacionesdet as i, gxservicios as j, czsedes as m Where m.Codigo_PRS=b.Codigo_PRS AND c.Codigo_SDE=m.Codigo_SDE AND a.Codigo_ADM=c.Codigo_ADM and d.Codigo_TER=c.Codigo_TER and e.Codigo_TID=d.Codigo_TID and f.Codigo_ADM=a.Codigo_ADM and g.Codigo_ORD=f.Codigo_ORD and j.Codigo_SER=h.Codigo_SER  and j.Codigo_CFC='01' and g.Codigo_EPS=a.Codigo_EPS and g.Codigo_PLA=a.Codigo_PLA and h.Codigo_SER=g.Codigo_SER and i.Codigo_FAC=a.Codigo_FAC and f.Estado_ORD<>'0' and a.Estado_FAC<>'0' and LPAD(i.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0') Union  Select  distinct concat (trim(a.Codigo_FAC),',', trim(b.Prestador_FCN),',', trim(e.Sigla_TID),',', trim(d.ID_TER),',',date_format(f.Fecha_ORD,'%d/%m/%Y'),',',trim(f.Autorizacion_ORD),',', trim(h.CUPS_PRC),',', Codigo_FNC,',', Codigo_CXT,',', c.Codigo_DGN,',', c.Codigo_DGN,',', '',',', '',',', '1',',', REPLACE(format(ROUND(0),0), ',',''),',', replace(format(ROUND(0),0), ',',''),',', replace(format(ROUND(0), 0), ',','') ), f.Codigo_ORD From gxfacturas as a, gxprestadores as b, gxadmision as c, czterceros as d, cztipoid as e, gxordenescab as f, gxordenesdet as g, gxprocedimientos as h, czradicacionesdet as i, gxservicios as j, czsedes as m Where m.Codigo_PRS=b.Codigo_PRS AND c.Codigo_SDE=m.Codigo_SDE AND a.Codigo_FAC=c.Codigo_FAC and d.Codigo_TER=c.Codigo_TER and e.Codigo_TID=d.Codigo_TID and f.Codigo_ADM=c.Codigo_ADM and g.Codigo_ORD=f.Codigo_ORD and j.Codigo_SER=h.Codigo_SER and j.Codigo_CFC='01' and g.Codigo_EPS=c.Codigo_EPS and g.Codigo_PLA=c.Codigo_PLA and h.Codigo_SER=g.Codigo_SER and i.Codigo_FAC=a.Codigo_FAC and f.Estado_ORD<>'0' and a.Estado_FAC<>'0' and LPAD(i.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0');";
	}
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{	
		if (file_exists($RutaRIPS.$CodEPS.'/AC'.$CodREM.'.TXT')) {
			file_put_contents($RutaRIPS.$CodEPS.'/AC'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
		}
		$TextLine=$row[0];
		/*$TextLine=$row[0].','.$row[2].','.$row[3].','.$row[4].','.$row[5].','.$row[6].','.$row[7].','.$row[8].','.$row[9].','.$row[10].','.$row[11].','.$row[12].','.$row[13].','.$row[14].','.number_format($row[15],0,'','').','.number_format($row[16],0,'','').','.number_format($row[17],0,'','');
		echo $TextLine;*/
		file_put_contents($RutaRIPS.$CodEPS.'/AC'.$CodREM.'.TXT', $TextLine, FILE_APPEND);	
		$NoAC++;
	}
	mysqli_free_result($result);
	if ($NoAC!=0){
	if (($NoFiles % 4)==0){
	$resultado=$resultado.'<br>';
	}
	$resultado=$resultado.'<li><a download="" class="label label-success" href="files/'.$_SESSION["DB_SUFFIX"].'/rips/'.$RutaRIPS0.$CodEPS.'/AC'.$CodREM.'.TXT"  alt="AC" title="Archivo de Consultas AC'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/img/icons/16x16/file_extension_txt.png" align="absmiddle" />AC'.$CodREM.'.TXT</a></li>';
	$NoFiles++;
	}

		//Archivo AP
	$NoAP=0;
	$SQL = "Select trim(a.Codigo_FAC), trim(b.Prestador_FCN), trim(e.Sigla_TID), trim(d.ID_TER), date_format(f.Fecha_ORD,'%d/%m/%Y'), trim(REPLACE(f.Autorizacion_ORD,',',';')), trim(h.CUPS_PRC), '1', '2', o.Codigo_TES,Codigo_DGN, Codigo_DGN, '', '1',  ROUND(g.ValorEntidad_ORD*g.Cantidad_ORD) 
From gxfacturas as a, gxprestadores as b, gxadmision as c, czterceros as d, cztipoid as e, gxordenescab as f, gxordenesdet as g, gxprocedimientos as h, czradicacionesdet as i, gxservicios as j, czsedes as m , gxmedicosesp as n, gxespecialidades as o 
Where m.Codigo_PRS=b.Codigo_PRS AND c.Codigo_SDE=m.Codigo_SDE AND a.Codigo_ADM=c.Codigo_ADM and d.Codigo_TER=c.Codigo_TER and e.Codigo_TID=d.Codigo_TID and f.Codigo_ADM=a.Codigo_ADM and g.Codigo_ORD=f.Codigo_ORD and j.Codigo_SER=h.Codigo_SER and j.Codigo_CFC in('04','03','02') and n.Codigo_TER=g.Codigo_TER and Tipo_ESP='1' and o.Codigo_ESP=n.Codigo_ESP
and g.Codigo_EPS=a.Codigo_EPS and g.Codigo_PLA=a.Codigo_PLA and h.Codigo_SER=g.Codigo_SER and i.Codigo_FAC=a.Codigo_FAC and f.Estado_ORD<>'0' and a.Estado_FAC<>'0' and  LPAD(i.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0')";

	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{	
		if (file_exists($RutaRIPS.$CodEPS.'/AP'.$CodREM.'.TXT')) {
			file_put_contents($RutaRIPS.$CodEPS.'/AP'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
		}
		$TextLine=$row[0].','.$row['trim(b.Prestador_FCN)'].','.$row['trim(e.Sigla_TID)'].','.$row[3].','.$row[4].','.$row[5].','.$row[6].','.$row[7].','.$row[8].','.$row[9].','.$row[10].','.$row[11].','.$row[12].','.$row[13].','.number_format($row[14],0,'','');
		file_put_contents($RutaRIPS.$CodEPS.'/AP'.$CodREM.'.TXT', $TextLine, FILE_APPEND);	
		$NoAP++;
	}
	mysqli_free_result($result);
	if ($NoAP!=0){
	if (($NoFiles % 4)==0){
	$resultado=$resultado.'<br>';
	}
	$resultado=$resultado.'<li><a download="" class="label label-success" href="files/'.$_SESSION["DB_SUFFIX"].'/rips/'.$RutaRIPS0.$CodEPS.'/AP'.$CodREM.'.TXT"  alt="AP" title="Archivo de Procedimientos AP'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/img/icons/16x16/file_extension_txt.png" align="absmiddle" />AP'.$CodREM.'.TXT</a></li>';
	$NoFiles++;
	}

		//Archivo AT
	$NoAT=0;
	$SQL = "Select trim(a.Codigo_FAC),trim(a.Codigo_FAC), trim(b.Prestador_FCN), trim(e.Sigla_TID), trim(d.ID_TER), trim(f.Autorizacion_ORD), case j.Codigo_CFC when '09' then '1' when '06' then '3' when '07' then '4' when '14' then '2' end, trim(CUPS_PRC), trim(ucase(j.Nombre_SER)), ROUND(sum(g.Cantidad_ORD)), ROUND(avg(g.ValorEntidad_ORD)), ROUND(sum(g.Cantidad_ORD* g.ValorEntidad_ORD)) 
From gxfacturas as a, gxprestadores as b, gxadmision as c, czterceros as d, cztipoid as e, gxordenescab as f, gxordenesdet as g,  czradicacionesdet as i, gxservicios as j, gxprocedimientos as pro, czsedes as m
Where m.Codigo_PRS=b.Codigo_PRS AND c.Codigo_SDE=m.Codigo_SDE AND pro.Codigo_SER=j.Codigo_SER and a.Codigo_ADM=c.Codigo_ADM and d.Codigo_TER=c.Codigo_TER and e.Codigo_TID=d.Codigo_TID and f.Codigo_ADM=a.Codigo_ADM and g.Codigo_ORD=f.Codigo_ORD and j.Codigo_CFC in ('06','07','09','14')
and g.Codigo_EPS=a.Codigo_EPS and g.Codigo_PLA=a.Codigo_PLA and j.Codigo_SER=g.Codigo_SER and (i.Codigo_FAC)=(a.Codigo_FAC) and f.Estado_ORD<>'0' and    LPAD(i.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0') and a.Estado_FAC<>'0' 
Group By trim(a.Codigo_FAC), trim(b.Prestador_FCN), trim(e.Sigla_TID), trim(d.ID_TER), trim(c.Autorizacion_ADM), case j.Codigo_CFC when '09' then '1' when '06' then '3' when '07' then '4' when '14' then '2' end, trim(CUPS_PRC), trim(ucase(j.Nombre_SER))
Union 
		Select trim(a.Codigo_FAC),trim(a.Codigo_FAC), trim(b.Prestador_FCN), trim(e.Sigla_TID), trim(d.ID_TER), trim(f.Autorizacion_ORD), case j.Codigo_CFC when '09' then '1' when '06' then '3' when '07' then '4' when '14' then '2' end, trim(Codigo_MED), trim(ucase(j.Nombre_SER)), ROUND(sum(g.Cantidad_ORD)), ROUND(avg(g.ValorEntidad_ORD)), ROUND(sum(g.Cantidad_ORD* g.ValorEntidad_ORD)) 
From gxfacturas as a, gxprestadores as b, gxadmision as c, czterceros as d, cztipoid as e, gxordenescab as f, gxordenesdet as g,  czradicacionesdet as i, gxservicios as j, gxmedicamentos as med, czsedes as m 
Where m.Codigo_PRS=b.Codigo_PRS AND c.Codigo_SDE=m.Codigo_SDE AND med.Codigo_SER=j.Codigo_SER and a.Codigo_ADM=c.Codigo_ADM and d.Codigo_TER=c.Codigo_TER and e.Codigo_TID=d.Codigo_TID and f.Codigo_ADM=a.Codigo_ADM and g.Codigo_ORD=f.Codigo_ORD and j.Codigo_CFC in ('06','07','09','14')
and g.Codigo_EPS=a.Codigo_EPS and g.Codigo_PLA=a.Codigo_PLA and j.Codigo_SER=g.Codigo_SER and (i.Codigo_FAC)=(a.Codigo_FAC) and f.Estado_ORD<>'0' and    LPAD(i.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0') and a.Estado_FAC<>'0' 
Group By trim(a.Codigo_FAC), trim(b.Prestador_FCN), trim(e.Sigla_TID), trim(d.ID_TER), trim(c.Autorizacion_ADM), case j.Codigo_CFC when '09' then '1' when '06' then '3' when '07' then '4' when '14' then '2' end, trim(Codigo_MED), trim(ucase(j.Nombre_SER));";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{	
		if (file_exists($RutaRIPS.$CodEPS.'/AT'.$CodREM.'.TXT')) {
			file_put_contents($RutaRIPS.$CodEPS.'/AT'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
		}
		$TextLine=$row[0].','.$row[2].','.$row[3].','.$row[4].','.$row[5].','.$row[6].','.$row[7].','.$row[8].','.$row[9].','.number_format($row[10],0,'','').','.number_format($row[11],0,'','');
		file_put_contents($RutaRIPS.$CodEPS.'/AT'.$CodREM.'.TXT', $TextLine, FILE_APPEND);	
		$NoAT++;
	}
	mysqli_free_result($result);
	if ($NoAT!=0){
	if (($NoFiles % 4)==0){
	$resultado=$resultado.'<br>';
	}
	$resultado=$resultado.'<li><a download="" class="label label-success" href="files/'.$_SESSION["DB_SUFFIX"].'/rips/'.$RutaRIPS0.$CodEPS.'/AT'.$CodREM.'.TXT"  alt="AT" title="Archivo de Transacciones AT'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/img/icons/16x16/file_extension_txt.png" align="absmiddle" />AT'.$CodREM.'.TXT</a></li>';
	$NoFiles++;
	}

		//Archivo CT
		if (file_exists($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT')) {
			file_put_contents($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
		}
		$CadenaZIP='';
		$TextLine='';
		if ($NoAF!=0){
			$TextLine=$CodigoIPS.','.date("d/m/Y").',AF'.$CodREM.','.$NoAF;
			file_put_contents($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT', $TextLine, FILE_APPEND);
			$CadenaZIP=$CadenaZIP.$RutaRIPS.$CodEPS.'/AF'.$CodREM.'.TXT,';
		}
		if ($NoUS!=0){
			$TextLine=$CodigoIPS.','.date("d/m/Y").',US'.$CodREM.','.$NoUS;
			file_put_contents($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
			file_put_contents($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT', $TextLine, FILE_APPEND);	
			$CadenaZIP=$CadenaZIP.$RutaRIPS.$CodEPS.'/US'.$CodREM.'.TXT,';
		}
		if ($NoAC!=0){
			$TextLine=$CodigoIPS.','.date("d/m/Y").',AC'.$CodREM.','.$NoAC;
			file_put_contents($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
			file_put_contents($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT', $TextLine, FILE_APPEND);	
			$CadenaZIP=$CadenaZIP.$RutaRIPS.$CodEPS.'/AC'.$CodREM.'.TXT,';
		}
		if ($NoAP!=0){
			$TextLine=$CodigoIPS.','.date("d/m/Y").',AP'.$CodREM.','.$NoAP;
			file_put_contents($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
			file_put_contents($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT', $TextLine, FILE_APPEND);	
			$CadenaZIP=$CadenaZIP.$RutaRIPS.$CodEPS.'/AP'.$CodREM.'.TXT,';
		}
		if ($NoAT!=0){
			$TextLine=$CodigoIPS.','.date("d/m/Y").',AT'.$CodREM.','.$NoAT;
			file_put_contents($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
			file_put_contents($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT', $TextLine, FILE_APPEND);	
			$CadenaZIP=$CadenaZIP.$RutaRIPS.$CodEPS.'/AT'.$CodREM.'.TXT,';
		}
		if ($NoAM!=0){
			$TextLine=$CodigoIPS.','.date("d/m/Y").',AM'.$CodREM.','.$NoAM;
			file_put_contents($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
			file_put_contents($RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT', $TextLine, FILE_APPEND);	
			$CadenaZIP=$CadenaZIP.$RutaRIPS.$CodEPS.'/AM'.$CodREM.'.TXT,';
		}	
		$CadenaZIP=$CadenaZIP.$RutaRIPS.$CodEPS.'/CT'.$CodREM.'.TXT';		
		if (($NoFiles % 4)==0){
		$resultado=$resultado.'<br>';
		}
		$resultado=$resultado.'<li><a download="" class="label label-success" href="files/'.$_SESSION["DB_SUFFIX"].'/rips/'.$RutaRIPS0.$CodEPS.'/CT'.$CodREM.'.TXT"  alt="CT" title="Archivo de Control CT'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/img/icons/16x16/file_extension_txt.png" align="absmiddle" />CT'.$CodREM.'.TXT</a></li>';
		}
		it_aud('1', 'RIPS', 'Entidad: '.$CodEPS.' - Radicación: '.$CodRAD.' - Remisión: '.$CodREM);		
	} 
	else {
		$resultado='<span class="error">No se encuentran los datos de la radicacion '.$CodRAD.'</span>';
		mysqli_free_result($result);
		it_aud('1', 'RIPS', 'Entidad: '.$CodEPS.' - Fallido: No se encuentran datos de radicación '.$CodRAD.'.');		
	}
	
	$zip = new PclZip($RutaRIPS.$CodEPS.'/RAD'.$CodRAD.'REM'.$CodREM.'.zip');
	
	$Archivo=$zip->create($CadenaZIP,PCLZIP_OPT_REMOVE_PATH, $RutaRIPS.$CodEPS);
	if ($Archivo==0) {
	die("Error : ".$RutaRIPS.$CodEPS." ".$zip->errorInfo(true));
	}
	$resultado=$resultado.'    </ul>
	<a download="" class="label label-success" href="files/'.$_SESSION["DB_SUFFIX"].'/rips/'.$RutaRIPS0.$CodEPS.'/RAD'.$CodRAD.'REM'.$CodREM.'.zip" title="Archivo comprimido"><span class="glyphicon glyphicon-compressed" aria-hidden="true"></span> RAD'.$CodRAD.'REM'.$CodREM.'.zip</a>';
	echo $resultado;
break;

case "CargarHorario":
	$HayReg=0;
	$resultx = '';
	$ContaFilas = 0;
    $NumWindow = $_GET["ventana"];
    $elanyo = $_GET["anyo"];
    $elmes = $_GET["mes"];
    $CodArea = $_GET["area"];
    $Contrato = $_GET["contrato"];
    $resultx = '<div id="datempresa'.$NumWindow.'" class="tblDetalle1">
  <label for="txt_ordhours'.$NumWindow.'">Horas Ordinarias: </label><input name="txt_ordhours'.$NumWindow.'" type="text" disabled="disabled" id="txt_ordhours'.$NumWindow.'" value="';
    $NumDia=0;
	  $totalh=0;
	  //SE CALCULAN LOS DIAS HABILES DEL MES * 8
    while (UltimoDia($elanyo, $elmes)> $NumDia) {
	  $NumDia++;
		$SQL="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$elanyo."-".$elmes."-".$NumDia."'";
		$result = mysqli_query($conexion, $SQL);
		if(!($row=mysqli_fetch_array($result))) {
			if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))!=0) 
			{
				$totalh++;
			}
		}
		mysqli_free_result($result); 
	  }
	  $resultx = $resultx.($totalh*8).'" size="3" maxlength="3" readonly="readonly" /> <span id="print'.$NumWindow.'"></span>
  </div>
  <br>  
  <table width="100%" align="center" cellpadding="0" cellspacing="0" class="tblDetalle" >
  <tr>
    <th rowspan="2" align="center" valign="middle"> EMPLEADO </th>';
  	$Weekday="";
	$Colorday="";
	$NumDia=0;
	while (UltimoDia($elanyo, $elmes)> $NumDia) {
	$NumDia++;
	$Colorday="2";
	$SQL="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$elanyo."-".$elmes."-".$NumDia."'";
	$result = mysqli_query($conexion, $SQL);
	if($row=mysqli_fetch_array($result)) {
	 $Colorday='class="festivo"';
	}
	else
	{
		$Colorday="";
	}
	mysqli_free_result($result); 
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==1) $Weekday= "Lu";
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==2) $Weekday= "Ma";
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==3) $Weekday= "Mi";
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==4) $Weekday= "Ju";
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==5) $Weekday= "Vi";
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==6) $Weekday= "Sa";
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==0) 
	{
		$Weekday= "Do";
		$Colorday='class="festivo"';
	}
	$resultx = $resultx.'<th  '.$Colorday.'>'.$Weekday.'</th>';
	}
	$resultx = $resultx.'
  </tr>
  <tr>';
  	$Weekday="";
	$Colorday="";
	$NumDia=0;
	while (UltimoDia($elanyo, $elmes)> $NumDia) {
	$NumDia++;
	$SQL="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$elanyo."-".$elmes."-".$NumDia."'";
	$result = mysqli_query($conexion, $SQL);
	if($row=mysqli_fetch_array($result)) {
		$Colorday='class="festivo2"';
	} else {
		$Colorday="";
	}
	mysqli_free_result($result); 
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==0) 
	{
		$Colorday='class="festivo2"';
	}
	$resultx = $resultx. '<td align="center" valign="middle" bgcolor="#DFDFDF" '.$Colorday.'>'.$NumDia.'</td>';
	}
	$resultx = $resultx.'
  </tr>';
  $SQL="SELECT distinct Nombre_TER, A.Codigo_TER FROM czempleados A, czterceros B, czareasterceros C WHERE A.Codigo_TER=B.Codigo_TER AND A.Codigo_TER=C.Codigo_TER AND C.Codigo_ARE='".$CodArea."' AND Codigo_TCL='".$Contrato."' AND Estado_EMP='1';";
  $result = mysqli_query($conexion, $SQL);
  while($row=mysqli_fetch_array($result)) {
  	$ContaFilas++;
$resultx = $resultx.'
  <tr>
    <td align="left">'.ucwords(strtolower($row[0])).'</td>
  ';
	$NumDia=0;
	while (UltimoDia($elanyo, $elmes)> $NumDia) {
	$NumDia++;
$resultx = $resultx.'
    <td align="center" valign="middle">
  ';
	$SQL="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$elanyo."-".$elmes."-".$NumDia."'";
	$result2 = mysqli_query($conexion, $SQL);
	if($row2=mysqli_fetch_array($result2)) {
		$Colorday='class="festivo2"';
	}
	else
	{
		$Colorday="";
		if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==0) 
		{
			$Colorday='class="festivo2"';
		}
	}
	mysqli_free_result($result2);
	$Observa="";
	$SQL="Select rtrim(Codigo_TRN), a.Fecha_TUR, month(a.Fecha_TUR), day(a.Fecha_TUR), year(a.Fecha_TUR), Observaciones_TUR From czturnosdet a, czturnosenc b Where a.Codigo_TUR=b.Codigo_TUR and Codigo_TER='".$row[1]."' and month(a.Fecha_TUR)='".$elmes."' and year(a.Fecha_TUR)='".$elanyo."' and day(a.Fecha_TUR)='".$NumDia."'";
	$result1 = mysqli_query($conexion, $SQL);
	if($row1=mysqli_fetch_array($result1)) {
	  $Observa=$row1[5];
      $resultx = $resultx. '<input name="txt_dia'.$NumDia.'_'.rtrim($row[1]).$NumWindow.'" type="text" id="txt_dia'.$NumDia.'_'.rtrim($row[1]).$NumWindow.'" '.$Colorday.' value="'.$row1[0].'" size="1" maxlength="2" onkeydown="if(event.keyCode==115){CargarSearch(\'Turnos\', \'txt_dia'.$NumDia.'_'.rtrim($row[1]).$NumWindow.'\', \'NULL\')};" title="<F4> Para buscar tipos de turnos activos" />';
	} else {
      $resultx = $resultx. '<input name="txt_dia'.$NumDia.'_'.rtrim($row[1]).$NumWindow.'" type="text" id="txt_dia'.$NumDia.'_'.rtrim($row[1]).$NumWindow.'" '.$Colorday.' value="L" size="1" maxlength="2" onkeydown="if(event.keyCode==115){CargarSearch(\'Turnos\', \'txt_dia'.$NumDia.'_'.rtrim($row[1]).$NumWindow.'\', \'NULL\')};" title="<F4> Para buscar tipos de turnos activos" />';
	}
	mysqli_free_result($result1);
$resultx = $resultx.'
      </td>';
	}
$resultx = $resultx.'
  </tr>';
	}
	mysqli_free_result($result);
$resultx = $resultx.'</table>
<hr align="center" width="95%" size="1"  class="anulado" />
<table align="left" cellpadding="0" cellspacing="0" class="tblDetalle" >
    <tr>
      <th align="left" scope="col">Observaciones</th>
    </tr>
    <tr>
      <td align="left" valign="top">
        <textarea name="txt_observaciones'.$NumWindow.'" cols="60" rows="5" wrap="physical" id="txt_observaciones'.$NumWindow.'">'.$Observa.'</textarea>
      </td>
    </tr>
</table>
<table border="1" align="right" cellpadding="0" cellspacing="0"class="tblDetalle" >
    <tr>
      <th colspan="4" align="center" valign="middle">Consolidado</th>
    </tr>
    <tr>
      <td align="center" valign="middle" bgcolor="#DFDFDF">Asociado</td>
      <td align="center" valign="middle" bgcolor="#DFDFDF">Horas/Mes</td>
      <td align="center" valign="middle" bgcolor="#DFDFDF">Base H. E.</td>
      <td align="center" valign="middle" bgcolor="#DFDFDF">Total H.E.</td>
    </tr>';
$SQL="SELECT distinct Nombre_TER, A.Codigo_TER FROM czempleados A, czterceros B, czareasterceros C WHERE A.Codigo_TER=B.Codigo_TER AND A.Codigo_TER=C.Codigo_TER AND C.Codigo_ARE='".$CodArea."' AND Codigo_TCL='".$Contrato."' AND Estado_EMP='1';";
//$SQL="SELECT distinct Nombre_TER, E.Codigo_TER FROM czterceros E, czturnosdet T, czareasterceros A WHERE T.Codigo_TER=A.Codigo_TER and T.Codigo_TER=E.Codigo_TER and A.Codigo_ARE='".$CodArea."' and month(Fecha_TUR)='".$elmes."' and year(Fecha_TUR)='".$elanyo."' AND Codigo_TCL='".$Contrato."' and Estado_EMP='1'";
$result = mysqli_query($conexion, $SQL);
  while($row=mysqli_fetch_array($result)) {
  $resultx = $resultx.'    <tr>
    <td align="left">'.ucwords(strtolower($row[0])).'</td>
    <td align="right">';
    $HorasDesc=0;
    $SQL="SELECT sum(Descanso_TRN) From cztipoturnos H, czturnosdet T, czterceros E Where H.Codigo_TRN=T.Codigo_TRN and E.Codigo_TER=T.Codigo_TER and E.Codigo_TER='".$row[1]."' and month(Fecha_TUR)='".$elmes."' and year(Fecha_TUR)='".$elanyo."'";
    $result2 = mysqli_query($conexion, $SQL);
    if($row2=mysqli_fetch_array($result2)) {
    $HorasDesc = $row2[0];
    }
    mysqli_free_result($result2);
    $SQL="SELECT sum(TotalHoras_TRN) From cztipoturnos H, czturnosdet T, czterceros E Where H.Codigo_TRN=T.Codigo_TRN and E.Codigo_TER=T.Codigo_TER and E.Codigo_TER='".$row[1]."' and month(Fecha_TUR)='".$elmes."' and year(Fecha_TUR)='".$elanyo."'";
    $result2 = mysqli_query($conexion, $SQL);
    if($row2=mysqli_fetch_array($result2)) {
      $resultx = $resultx.($row2[0] - $HorasDesc);
    }
    mysqli_free_result($result2);
    $resultx = $resultx.'</td>
    <td align="right">';
    $HorasTotales=0;
    $HorasFest=0;
    $HorasDesc=0;
    $SQL="SELECT ifnull(sum(TotalHoras_TRN),0) From cztipoturnos H, czturnosdet T, czterceros E Where H.Codigo_TRN=T.Codigo_TRN and E.Codigo_TER=T.Codigo_TER and E.Codigo_TER='".$row[1]."' and month(Fecha_TUR)='".$elmes."' and year(Fecha_TUR)='".$elanyo."'";
    $result2 = mysqli_query($conexion, $SQL);
    if($row2=mysqli_fetch_array($result2)) {
      $HorasTotales = $row2[0];
      if ($HorasTotales>0) {
      	$HayReg=1;
  	  }
    }
    mysqli_free_result($result2);
    //CALCULO DE HORAS DE LOS FESTIVOS
    $SQL="Select T1.Codigo_TRN, T1.Fecha_TUR, H1.Inicia_TRN, H1.Termina_TRN, CASE DAY(T1.Fecha_TUR) WHEN '01' THEN '00:00' ELSE H2.Inicia_TRN END, CASE DAY(T1.Fecha_TUR) WHEN '01' THEN '00:00' ELSE H2.Termina_TRN END 
    From czturnosdet T1, cztipoturnos H1, czturnosdet T2, cztipoturnos H2
    Where  T1.Fecha_TUR in (Select DiaFest_FST from czfestivos where month(DiaFest_FST)='".$elmes."' and year(DiaFest_FST)='".$elanyo."') and T1.Codigo_TER='".$row[1]."' and T1.Codigo_TRN=H1.Codigo_TRN 
    AND T2.Codigo_TER=T1.Codigo_TER AND T2.Fecha_TUR=(DateAdd(d, -1 ,T1.Fecha_TUR)) and T2.Codigo_TRN=H2.Codigo_TRN";
    $result2 = mysqli_query($conexion, $SQL);
    while($row2=mysqli_fetch_array($result2)) {
      if ($row2[4] > $row2[5]) {
        $HorasFest = $HorasFest + $row2[5];
      }
      if ($row2[2] > $row2[3]) {
        $HorasFest = $HorasFest + (24 - $row2[2]);
      }
      else
      {
        $HorasFest = $HorasFest + ($row2[3] - $row2[2]);
      }
    }
    mysqli_free_result($result2);
    //CALCULO DE LOS DESCANSOS
    $SQL="SELECT sum(Descanso_TRN) From cztipoturnos H, czturnosdet T, czterceros E Where H.Codigo_TRN=T.Codigo_TRN and E.Codigo_TER=T.Codigo_TER and E.Codigo_TER='".$row[1]."' and month(Fecha_TUR)='".$elmes."' and year(Fecha_TUR)='".$elanyo."'
    and Fecha_TUR not in (Select DiaFest_FST from czfestivos where month(DiaFest_FST)='".$elanyo."' and year(DiaFest_FST)='".$elanyo."')";
    $result2 = mysqli_query($conexion, $SQL);
    if($row2=mysqli_fetch_array($result2)) {
      $HorasDesc = $row2[0];
    }
    mysqli_free_result($result2);
    //TOTALIZAR
    $HorasTotales = $HorasTotales - ($HorasFest + $HorasDesc);
    $resultx = $resultx.$HorasTotales;
    $resultx = $resultx.'</td>
      <td align="right">';
    if (($HorasTotales)-($totalh*8)>0) {
      $resultx = $resultx.(($HorasTotales)-($totalh*8));
    }
    else {
      $resultx = $resultx.'--';
    }
    $resultx = $resultx.'</td>
    </tr>';
}
$resultx = $resultx.'
</table>
<input type="hidden" name="hdn_conta'.$NumWindow.'" id="hdn_conta'.$NumWindow.'" value="'.$ContaFilas.'"/>
<input type="hidden" name="hdn_printear'.$NumWindow.'" id="hdn_printear'.$NumWindow.'" value="'.$HayReg.'"/>';

echo $resultx;
break;

case 'MyTurnos':
	$Codigo= rtrim($_GET['Cod']);
	$SQL="Select A.Orden_TUR, C.Codigo_ARE, C.Nombre_ARE, A.Codigo_TER, D.Nombre_TER, A.Codigo_TRN, E.Nombre_TRN, B.Codigo_TER, F.Nombre_TER, B.Codigo_TRN, G.Nombre_TRN 
	From czmyturnosdet A Left Join czterceros D On D.Codigo_TER=A.Codigo_TER Left Join cztipoturnos E On E.Codigo_TRN=A.Codigo_TRN, 
 	 czmyturnosdet B Left Join czterceros F On F.Codigo_TER=B.Codigo_TER Left join cztipoturnos G On G.Codigo_TRN=B.Codigo_TRN, czareas C  
	Where A.Tipo_TUR='1' and B.Tipo_TUR='2' and  C.Codigo_ARE=A.Codigo_ARE  
 	 and A.Orden_TUR=B.Orden_TUR and A.Codigo_ARE=B.Codigo_ARE 
 	 and A.Codigo_TUR=B.Codigo_TUR and A.Codigo_TUR='".$Codigo."' 
 	Order By 
 	 2 asc, 6 desc, 10 desc, 4, 8;";
	$resultado='<table  width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="tblDetalle" id="tblProgramacion'.$_GET["Ventana"].'" >
	<tbody id="tbDetalle'.$_GET["Ventana"].'">
	<tr id="trh'.$_GET["Ventana"].'"> 
      <th id="th1'.$_GET["Ventana"].'">Area</td> 
      <th id="th2'.$_GET["Ventana"].'">Turno 1</td> 
      <th id="th3'.$_GET["Ventana"].'">Empleado</td> 
      <th id="th4'.$_GET["Ventana"].'">Turno 2</td> 
      <th id="th5'.$_GET["Ventana"].'">Empleado</td> 
      <th id="th6'.$_GET["Ventana"].'">X</td> 
     </tr> ';
     
	$result = mysqli_query($conexion, $SQL);
	$ContFila=0;
	while($row = mysqli_fetch_row($result)) {
		$ContFila++;
		$resultado= $resultado.'<tr id="tr'.$ContFila.$_GET["Ventana"].'">
		<td><input name="hdn_codarea'.$ContFila.$_GET["Ventana"].'" type="hidden" id="hdn_codarea'.$ContFila.$_GET["Ventana"].'" value="'.$row[1].'" />'.$row[2].'</td>
		<td><input name="hdn_turno1'.$ContFila.$_GET["Ventana"].'" type="hidden" id="hdn_turno1'.$ContFila.$_GET["Ventana"].'" value="'.$row[5].'" />'.$row[6].'</td>
		<td><input name="hdn_empleado1'.$ContFila.$_GET["Ventana"].'" type="hidden" id="hdn_empleado1'.$ContFila.$_GET["Ventana"].'" value="'.$row[3].'" />'.$row[4].'</td>
		<td><input name="hdn_turno2'.$ContFila.$_GET["Ventana"].'" type="hidden" id="hdn_turno2'.$ContFila.$_GET["Ventana"].'" value="'.$row[9].'" />'.$row[10].'</td>
		<td><input name="hdn_empleado2'.$ContFila.$_GET["Ventana"].'" type="hidden" id="hdn_empleado2'.$ContFila.$_GET["Ventana"].'" value="'.$row[7].'" />'.$row[8].'</td>
		<td><a href="javascript:EliminarFilaOrden(\''.$ContFila.'\',\''.$_GET["Ventana"].'\');"><img src="'.$_SESSION["NEXUS_CDN"].'/image/remove.png" alt="Eliminar" align="absmiddle" title="Eliminar fila de la programación" /></a></td>
		</tr>';
	}
	mysqli_free_result($result);
	$resultado=$resultado.'</tbody>
	</table><input name="hdn_controw'.$_GET["Ventana"].'" type="hidden" id="hdn_controw'.$_GET["Ventana"].'" value="'.$ContFila.'" />';
	echo $resultado;
break;

case  'MaxMyTurnos':
		$SQL="Select max(Codigo_TUR*1) From czmyturnosenc;";	
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			echo ($row[0]);
		} else {
			echo '0';
		}
		mysqli_free_result($result);
break;

case 'UpdQuincena':
	$Mes= rtrim($_GET['Mes']);
	$Quincena= rtrim($_GET['Quincena']);
	$Anyo= rtrim($_GET['Anyo']);
	$Emple= rtrim($_GET['Emple']);
	if ($Quincena=='1') {
		$SQL="Select distinct day(A.Fecha_TUR), concat(B.Codigo_TRN,' => ', B.Nombre_TRN), B.Codigo_TRN, B.Inicia_TRN, B.Termina_TRN From czturnosdet A, cztipoturnos B Where B.Codigo_TRN=A.Codigo_TRN and A.Codigo_TER='".$Emple."' and month(A.Fecha_TUR)='".$Mes."' and year(A.Fecha_TUR)='".$Anyo."' and day(A.Fecha_TUR)<'16' Order By A.Fecha_TUR;";	
	} else {
		$SQL="Select distinct day(A.Fecha_TUR), concat(B.Codigo_TRN,' => ', B.Nombre_TRN), B.Codigo_TRN, B.Inicia_TRN, B.Termina_TRN From czturnosdet A, cztipoturnos B Where B.Codigo_TRN=A.Codigo_TRN and A.Codigo_TER='".$Emple."' and month(A.Fecha_TUR)='".$Mes."' and year(A.Fecha_TUR)='".$Anyo."' and day(A.Fecha_TUR)>='16' Order By A.Fecha_TUR;";	
	}
	$result = mysqli_query($conexion, $SQL);
	$resultado="";
	while($row = mysqli_fetch_row($result)) {
		$SQL="SELECT Codigo_TRN, Nombre_TRN, Inicia_TRN, Termina_TRN, TotalHoras_TRN, Descanso_TRN, Estado_TRN FROM cztipoturnos Where Estado_TRN <>'0' Order By Estado_TRN, Inicia_TRN, Termina_TRN;";
		$resultx = mysqli_query($conexion, $SQL);
		$CmbTRN="";
		while($rowx = mysqli_fetch_row($resultx)) {
			if($row[2]==$rowx[0]) {
				$CmbTRN=$CmbTRN.'<option value="'.$rowx[0].'" selected="selected">'.$rowx[1].'</option>';
			} else {
				$CmbTRN=$CmbTRN.'<option value="'.$rowx[0].'">'.$rowx[1].'</option>';
			}
		}
		mysqli_free_result($resultx);

		$resultado=$resultado.' <tr>  <td align="center" ><input name="hdn_dia'.$_GET["Ventana"].'" type="hidden" id="hdn_dia'.$_GET["Ventana"].'" value="'.$row[0].'" /> '.$row[0].' </td>  <td align="center" ><input name="hdn_turno'.$_GET["Ventana"].'" type="hidden" id="hdn_turno'.$_GET["Ventana"].'" value="'.$row[2].'" />'.$row[1].'</td>  <td align="center" ><select name="cmb_cambio'.$_GET["Ventana"].'" id="cmb_cambio'.$_GET["Ventana"].'"> '.$CmbTRN.' <option value="___">- NUEVO -</option>  </select>  </td>    <td align="center" ><input name="txt_horaini'.$_GET["Ventana"].'" type="text" disabled="disabled" id="txt_horaini'.$_GET["Ventana"].'" value="'.$row[3].'" size="5" /> - <input name="txt_horafin'.$_GET["Ventana"].'" type="text" disabled="disabled" id="txt_horafin'.$_GET["Ventana"].'" value="'.$row[4].'" size="5" /></td></tr>';
	}
	mysqli_free_result($result);
	echo $resultado;
break;

}

?>