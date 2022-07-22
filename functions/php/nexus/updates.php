<?php


session_start();
include '../../../config.php';
include 'database.php';
include 'auditoria.php';

$SQL="START TRANSACTION;";
$conexion=Conexion();
mysqli_query ($conexion, "SET NAMES 'utf8'");	
$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
mysqli_query($conexion, $MyZone);
mysqli_query($conexion, $SQL);

switch ($_GET['Func']) {

case  'CallTurno':
		$MSG="";
		$SQL="Update gxturnos set Estado_TRN='2', Call_TRN='1', Codigo_CNS='".$_GET['mod']."', Fecha2_TRN=now() Where Codigo_TRN=".$_GET['value'].";";
		mysqli_query($conexion, $SQL);
		/* Llamado por monitor */
		$SQL="Select Urgencias_ARE, Laboratorio_ARE, Imagenes_ARE, ConsExt_ARE from gxareas Where Codigo_ARE in (Select Codigo_ARE from gxturnos Where Codigo_TRN=".$_GET['value'].")";
		$Monitor="CExterna";
		$result = mysqli_query($conexion, $SQL);
		if ($row = mysqli_fetch_array($result)) 
		{
			if ($row[0]=="1") { $Monitor="Urgencias"; }
			if ($row[1]=="1") { $Monitor="Laboratorio"; }
			if ($row[2]=="1") { $Monitor="ImagenDx"; }
		}
		mysqli_free_result($result);
		$SQL="Select Monitor".$Monitor."_XHC, Estado_TRN, Codigo_CNS, Fecha_TRN, Codigo_TER From itconfig_hc, gxturnos Where Codigo_TRN=".$_GET['value'].";";
		$result = mysqli_query($conexion, $SQL);
		if ($row = mysqli_fetch_array($result)) 
		{
			if ($row[0]!='0') {
				$SQL="Insert Into nxsturnocall(Codigo_TER, Fecha_TRN, Codigo_CNS, Monitor_TRN) Values ('".$row[4]."', now(), '".$row[2]."', '".$row[0]."');";
				mysqli_query($conexion, $SQL);
			}
		}
		mysqli_free_result($result); 
		/* Fin llamado por monitor */
		it_aud('3', 'Turnos', 'Llamado a paciente: '.$_GET['value']);
break;

case  'BackCallTRG':
		$MSG="";
		$SQL="Update hctriage set Call_TRG='1' Where Codigo_TRG=".$_GET['value'].";";
		mysqli_query($conexion, $SQL);

		/* Llamado por monitor */
		$SQL="Select MonitorTriage_XHC, Estado_TRG, Codigo_CNS, Consultorio_TRG, Codigo_TER From itconfig_hc, hctriage Where Codigo_TRG=".$_GET['value'].";";
		$result = mysqli_query($conexion, $SQL);
		if ($row = mysqli_fetch_array($result)) 
		{
			if ($row[0]!='0') {
				if ($row[1]=='2') {
					$SQL="Insert Into nxsturnocall(Codigo_TER, Fecha_TRN, Codigo_CNS, Monitor_TRN) Values ('".$row[4]."', now(), '".$row[2]."', '".$row[0]."');";
					mysqli_query($conexion, $SQL);
				} 
				if ($row[1]=='4') {
					$SQL="Insert Into nxsturnocall(Codigo_TER, Fecha_TRN, Codigo_CNS, Monitor_TRN) Values ('".$row[4]."', now(), '".$row[3]."', '".$row[0]."');";
					mysqli_query($conexion, $SQL);
				}
			}
		}
		mysqli_free_result($result); 
		/* Fin llamado por monitor */
		
		it_aud('3', 'Triage', 'Volver a llamar paciente: '.$_GET['value']);
break;

case  'CallTriage':
		$MSG="";
		$SQL="Update hctriage set Estado_TRG='2', Call_TRG='1', Codigo_CNS='".$_GET['mod']."', Fecha2_TRG=now() Where Codigo_TRG=".$_GET['value'].";";
		mysqli_query($conexion, $SQL);
		/* Llamado por monitor */
		$SQL="Select MonitorTriage_XHC, Estado_TRG, Codigo_CNS, Consultorio_TRG, Codigo_TER From itconfig_hc, hctriage Where Codigo_TRG=".$_GET['value'].";";
		$result = mysqli_query($conexion, $SQL);
		if ($row = mysqli_fetch_array($result)) 
		{
			if ($row[0]!='0') {
				$SQL="Insert Into nxsturnocall(Codigo_TER, Fecha_TRN, Codigo_CNS, Monitor_TRN) Values ('".$row[4]."', now(), '".$row[2]."', '".$row[0]."');";
				mysqli_query($conexion, $SQL);
			}
		}
		mysqli_free_result($result); 
		/* Fin llamado por monitor */
		it_aud('3', 'Triage', 'Llamado a clasificar PreTriage: '.$_GET['value']);
break;

case 'closetrg':
	$MSG="";
		$SQL="Update hctriage set Estado_TRG='4', Call_TRG='1', Consultorio_TRG='".$_GET['mod']."', Fecha3_TRG=now() Where Codigo_TRG=".$_GET['value'].";";
		mysqli_query($conexion, $SQL);
		/* Llamado por monitor */
		$SQL="Select MonitorTriage_XHC, Estado_TRG, Codigo_CNS, Consultorio_TRG, Codigo_TER From itconfig_hc, hctriage Where Codigo_TRG=".$_GET['value'].";";
		$result = mysqli_query($conexion, $SQL);
		if ($row = mysqli_fetch_array($result)) 
		{
			if ($row[0]!='0') {
				$SQL="Insert Into nxsturnocall(Codigo_TER, Fecha_TRN, Codigo_CNS, Monitor_TRN) Values ('".$row[4]."', now(), '".$row[3]."', '".$row[0]."');";
				mysqli_query($conexion, $SQL);
			}
		}
		mysqli_free_result($result); 
		/* Fin llamado por monitor */
		it_aud('3', 'Triage', 'Llamado a atencion de paciente: '.$_GET['value']);
break;

case  'NoIngresos':
		$MSG= 'Ingreso anulado correctamente.';
		$SQL="Update gxadmision set Estado_ADM='A', UsuarioAnula_USR='".$_SESSION["it_CodigoUSR"]."', FechaAnula_ADM=now() where LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET['value']."',10,'0');";	
		mysqli_query($conexion, $SQL);
		it_aud('3', 'Ingreso', 'N�mero de Admisi�n '.$_GET['value']);
break;

case  'NoOrden':
		$MSG= 'Orden de Servicio anulada correctamente.<div class="message_ok"></div>';
		$SQL="Update gxordenescab set Estado_ORD='0', UsuarioAnula_ORD='".$_SESSION["it_CodigoUSR"]."', FechaAnula_ORD=now() where LPAD(Codigo_ORD,10,'0')=LPAD('".$_GET['value']."',10,'0');";	
		mysqli_query($conexion, $SQL);
		it_aud('3', 'Orden de Servicio', 'N�mero de Orden '.$_GET['value']);
break;

case  'NoFactura':
		$MSG= 'Factura anulada correctamente. <br>El ingreso se encuentra activo nuevamente.';
		$SQL="Select LPAD(Codigo_RAD,10,'0') from czradicacionesdet as a, gxfacturas as b Where a.Codigo_FAC =b.Codigo_FAC and LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET['value']."',10,'0') and Estado_FAC<>'0'";
		$result = mysqli_query($conexion, $SQL);
		if($row = mysqli_fetch_row($result)) {
			$MSG= '<div class="message_error"></div>La factura hace parte de la radicacion '.$row[0].'. <br>No se puede anular la factura.';
		}else {
			$SQL="Update gxfacturas set Estado_FAC='0', UsuarioAnula_FAC='".$_SESSION["it_CodigoUSR"]."', FechaAnula_FAC=now(), MotivoAnula_FAC='".$_GET['value2']."' where LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET['value']."',10,'0');";	
			mysqli_query($conexion, $SQL);
			$SQL="Update gxadmision set Estado_ADM='I' where LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET['value']."',10,'0');";	
			mysqli_query($conexion, $SQL);
			$SQL="Update czcartera set Saldo_CAR=0, ValorCre_CAR=ValorFac_CAR where Codigo_FAC in (Select Codigo_FAC From gxfacturas where LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET['value']."',10,'0'));";
			mysqli_query($conexion, $SQL);
			$SQL="Select Codigo_FAC from gxfacturas where LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET['value']."',10,'0');";	
			mysqli_free_result($result);
			$result = mysqli_query($conexion, $SQL);
			while($row = mysqli_fetch_array($result)) {
				it_aud('3', 'Factura', 'N�mero de Factura '.$row[0]);
			}
		}
	mysqli_free_result($result);
break;

case 'Autorizar':
	$MSG= 'Ingreso actualizado correctamente.';
	$SQL="Update gxadmision set Autorizacion_ADM='".$_GET['value2']."', FechaAutorizacion_ADM='".($_GET['value3'])."' where LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET['value']."',10,'0');";	
	mysqli_query($conexion, $SQL);
	$SQL="Update gxordenescab set Autorizacion_ORD='".$_GET['value2']."' where LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET['value']."',10,'0');";	
	mysqli_query($conexion, $SQL);
	it_aud('2', 'Autorizaciones', 'N�mero de Ingreso '.$_GET['value']);
	mysqli_free_result($result);
break;

}
$SQL="COMMIT;";
mysqli_query($conexion, $SQL);
echo $MSG;

?>
