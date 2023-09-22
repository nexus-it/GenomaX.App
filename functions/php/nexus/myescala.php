<?php
include '../../../config.php';


session_start();
include 'database.php';
$conexion=Conexion();
$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
mysqli_query($conexion, $MyZone);

function ConectarFomplus($BDatos) {
	$SQL="Select Nombre_MYE, Servidor_MYE, UsuarioBD_MYE, ClaveBD_MYE from myempresas a, myescala b Where a.Codigo_MYE='".$BDatos."';";
	$conexionX=Conexion();
	$result = mysql_query($SQL, $conexionX);
	if ($row = mysqli_fetch_row($result)) {
		//echo $row[1].'-'.$row[2].'-'.$row[3];
		$conexionFPx = mssql_connect($row[1], $row[2], $row[3]);
		mssql_select_db($row[0], $conexionFPx);
		return $conexionFPx;
	}
}

function ConectarSIP() {
	$SQL="Select NombreBD_MYE, Servidor_MYE, UsuarioBD_MYE, ClaveBD_MYE from myescala";
	$conexionX=Conexion();
	$result = mysql_query($SQL, $conexionX);
	if ($row = mysqli_fetch_row($result)) {
		//echo $row[1].'-'.$row[2].'-'.$row[3];
		$conexionFPx = mssql_connect($row[1], $row[2], $row[3]);
		mssql_select_db($row[0], $conexionFPx);
		return $conexionFPx;
	}
}

function NuevoTercero($Cedula, $Nombre, $Direccion, $Telefonos, $Email, $conexion) {
	$SQL="Select Consecutivo_CNS + 1 from itconsecutivos Where Tabla_CNS='czterceros' and Campo_CNS='Codigo_TER'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$SQL="Update itconsecutivos set Consecutivo_CNS=$row[0] Where Tabla_CNS='czterceros' and Campo_CNS='Codigo_TER'";
		mysqli_query($conexion, $SQL);
		$SQL="Insert into czterceros(Codigo_TER, ID_TER, Nombre_TER, Codigo_TID, Direccion_TER, Telefono_TER, Correo_TER, Expedicion_TER) Values ('$row[0]', '$Cedula', '$Nombre', 1, '$Direccion', '$Telefonos','$Email', '')";
		mysqli_query($conexion, $SQL);
		return $row[0];
	}
	mysqli_free_result($result);
	
}
	
$SQL="START TRANSACTION;";
mysqli_query($conexion, $SQL) or die($MSG='<div class="message_error"></div>Se presentaron errores en la transaccion: <br><br><span class="codigo"><strong>Error:</strong> '.mysql_error().'</span>');

switch ($_GET['Func']) {

case "CopiarEmp":
try {
	if (trim($_GET['Cod'])!="") {
		$conexionFPx=ConectarFomplus($_GET['Cod']);
		$SQL="SELECT replace(NOM_CEDULA, '.',''), NOM_CODIGO, replace(NOM_NOMBRE, '.',''), NOM_DIRECC, NOM_TELEFO, NOM_EMAIL, NOM_CARGO, CASE NOM_SEXO WHEN 2 THEN 'F' ELSE 'M' END AS Sexo, CONVERT(char(10), NOM_FECING, 103), CONVERT(char(10), NOM_FECRET, 103), CAST(NOM_SALACT*30 AS money), CAST(NOM_SALANT*30 AS money), NOM_CLASE, NOM_TIPCON, CASE NOM_ESTCIV WHEN '0' THEN 'Soltero (a)' WHEN '1' THEN 'Casado (a)' WHEN '2' THEN 'Viudo (a)' WHEN '3' THEN 'Union Libre' WHEN '4' THEN 'Separado (a)/ Divorciado (a)' END AS ESTCIVIL, CASE NOM_ESTADO WHEN '0' THEN '1' ELSE '0' END AS ESTADO, CONVERT(char(10), NOM_FECNAC, 103), NOM_OBSERV, NOM_CODCAR FROM MAENOM;";
		$resultFPx = mssql_query($SQL, $conexionFPx);
		$contaemp=0;
		while($rowFPx = mssql_fetch_row($resultFPx)) {
			$SQL="Select Codigo_TER from czterceros where ID_TER='".$rowFPx[0]."';";
			$result = mysqli_query($conexion, $SQL);
			if ($row = mysqli_fetch_row($result)) {
				$CodigoTER=$row[0];
			} else {
				$contaemp++;
				$CodigoTER=NuevoTercero($rowFPx[0], $rowFPx[2], $rowFPx[3], $rowFPx[4], $rowFPx[5], $conexion);
				
				$SQL="Delete from czempleados Where Codigo_TER='$CodigoTER';";
				mysqli_query($conexion, $SQL);
				$Apellidos= trim(substr($rowFPx[2], 0,strpos($rowFPx[2], ' ')));
				$Nombres=trim(substr($rowFPx[2], strlen($Apellidos),strlen($rowFPx[2])-strlen($Apellidos)));
				
				$SQL="Insert Into czempleados(Codigo_TER, ID_EMP, Nombre1_EMP, Apellido1_EMP, FechaNac_EMP, EstCivil_EMP, Codigo_SEX, Codigo_TCL, SalarioAct_EMP, SalarioAnt_EMP, FechaIng_EMP, FechaRet_EMP, Observaciones_EMP, Estado_EMP) Values('$CodigoTER', '$rowFPx[1]', '$Nombres', '$Apellidos', '".($rowFPx[16])."', '$rowFPx[14]', '$rowFPx[7]', '$rowFPx[13]', $rowFPx[10], $rowFPx[11], '".($rowFPx[8])."', '".($rowFPx[9])."', '$rowFPx[17]', '$rowFPx[15]');";
				mysqli_query($conexion, $SQL);
				
				$SQL="Delete from czcargoemp Where Codigo_TER='$CodigoTER' and FechaIni_CRG='".($rowFPx[8])."';";
				mysqli_query($conexion, $SQL);
				
				$SQL="Insert Into czcargoemp(Codigo_TER, FechaIni_CRG, Codigo_CRG) Select '$CodigoTER', '".($rowFPx[8])."', a.Codigo_CRG From mycargos a Where Codigo_MYE='".$_GET['Cod']."' and Codigo_MYC='".$rowFPx[18]."';";
				mysqli_query($conexion, $SQL);

				$SQL="Delete from myempleados Where Codigo_TER='$CodigoTER' and Fecha_MYP='".($rowFPx[8])."';";
				mysqli_query($conexion, $SQL);
				
				$SQL="Insert Into myempleados(Codigo_MYE, Codigo_TER, Fecha_MYP) Values('".$_GET['Cod']."', '$CodigoTER', '".($rowFPx[8])."');";
				mysqli_query($conexion, $SQL);

				$SQL="Update czempleados set Codigo_TCL='".($_GET['Cod']-1)."' Where Codigo_TER='$CodigoTER';";
				mysqli_query($conexion, $SQL);
			}
			mysqli_free_result($result);
			
				
		}
		/*
		$SQL="Update czempleados A Set A.Codigo_TCL=(Select B.Codigo_MYE From myempleados B Where A.Codigo_TER=B.codigo_ter);";
		mysqli_query($conexion, $SQL);
		*/
		echo 'Se actualizaron '.$contaemp.' empleados.';
		mssql_free_result($resultFPx);
		mssql_close($conexionFPx);
	}
} catch (Exception $e) {
    echo "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
}	
break;

case "NomEmpresa":
try {
	if (trim($_GET['Cod'])!="") {
		$conexionFP=ConectarFomplus($_GET['Cod']);
		$SQL="Select CON_NOMEMP from NOMEMP;";
		$resultFP = mssql_query($SQL, $conexionFP);
		if($rowFP = mssql_fetch_row($resultFP)) {
			echo ($rowFP[0]);
		} else {
			echo '<span class="error">No se conecta a la empresa en Fomplus</span>';
		}
		mssql_free_result($resultFP);
		mssql_close($conexionFP);
		
	}
} catch (Exception $e) {
    echo "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
}	
break;

case "CargarProdu":
try {
	
		$SQL="SELECT [PRO_Programacion1].Fuera, [PRO_Programacion1].[En Espera] AS Espera, [PRO_Programacion1].ID, [PRO_Programacion1].[ID Cliente] AS idCli, [PRO_Programacion1].[ID Vendedor] AS idVend, Z_Vendedores.[Nombre Vendedor] AS Vendedor, [PRO_Programacion1].[Número Orden] AS OP, [PRO_Programacion1].OrdenCompra, [PRO_Programacion1].NumPedido, [PRO_Programacion1].OrdenPedido, convert(char(8),[PRO_Programacion1].[Fecha Orden],3) AS FechaOP, convert(char(8),[PRO_Programacion1].[Fecha Entrega],3) AS FechaEntrega, convert(char(8),[PRO_Programacion1].FechaEntregaFin,3) AS FechaActual, Z_Clientes.[Nombre Cliente] AS Cliente, [PRO_Programacion1].Titulo AS NomReferencia, [PRO_Programacion1].Cantidad, [PRO_Programacion1].nEstado, [PRO_Programacion1].Tiro, [PRO_Programacion1].Retiro, [PRO_Programacion1].Maquina, [PRO_Programacion1].cartulina AS Material, [PRO_Programacion1].PliegosImp, [PRO_Programacion1].PliegosPlast, [PRO_Programacion1].PliegosTroq, [PRO_Programacion1].AnchoImp, [PRO_Programacion1].LargoImp, [PRO_Programacion1].TamFinal, [PRO_Programacion1].CabidaImp, [PRO_Programacion1].CantDesp, [PRO_Programacion1].FechaDesp, [PRO_Programacion1].DespachoPeriodo, [PRO_Programacion1].CarasPlast, [PRO_Programacion1].Cartulina, [PRO_Programacion1].PliegosConv, [PRO_Programacion1].AnchoConv, [PRO_Programacion1].LargoConv, [PRO_Programacion1].MetrosConv, [PRO_Programacion1].KilosConv, [PRO_Programacion1].tImpresion, [PRO_Programacion1].tTroquelado, [PRO_Programacion1].tLaminado, [PRO_Programacion1].PrecioUnitario, [PRO_Programacion1].Revision FROM (PRO_Programacion1 INNER JOIN Z_Clientes ON [PRO_Programacion1].[ID Cliente] = Z_Clientes.[ID Cliente]) INNER JOIN Z_Vendedores ON [PRO_Programacion1].[ID Vendedor] = Z_Vendedores.[ID Vendedor]";
		$SQL=$SQL." Where ";
		if ($_GET['op']!="") {
			$SQL=$SQL."[PRO_Programacion1].[Número Orden]='".$_GET['op']."'";
		} else {
			if ($_GET['pedido']!="") {
				$SQL=$SQL."[PRO_Programacion1].NumPedido='".$_GET['pedido']."'";
			} else {
				$SQL=$SQL.$_GET['estado'];
		
			}
		}
		$resultado='    <table  cellpadding="1" cellspacing="1" border="1" width="1900px" class="scrollTable tblProdu">
		<thead class="fixedHeader">
			<tr>
			  <th style="width:1.9%">OP</th>
			  <th style="width:3%">Orden Comp.</th> 
			  <th style="width:1.9%">Ped. Fomp.</th> 
			  <th style="width:2.1%">Pedido</th> 
			  <th style="width:2.2%">Fecha OP</th> 
			  <th style="width:2.2%">Fecha Entrega</th> 
			  <th style="width:2.2%">Fecha Actual</th> 
			  <th style="width:4.3%">Cliente</th> 
			  <th style="width:10%">Nombre Referencia</th> 
			  <th style="width:2.4%">Cantidad Pedido</th> 
			  <th style="width:2.4%">Cantidad x Despach</th> 
			  <th style="width:2.4%">Valor x Despach</th> 
			  <th style="width:4%">Estado</th> 
			  <th colspan="2" style="width:2.4%">Plancha</th> 
			  <th style="width:3.9%">M&aacute;quina</th> 
			  <th style="width:1.9%">Pliegos Imprimir</th> 
			  <th style="width:1.9%">Pliegos Plastificar</th> 
			  <th style="width:1.9%">Pliegos Troquelar</th> 
			  <th style="width:1.9%">Tama&ntilde;o Impresi&oacute;n</th> 
			  <th style="width:1.9%">Tama&ntilde;o Final</th> 
			  <th style="width:1.9%">Cab Imp</th> 
			  <th style="width:1.9%">Cantidad Desp.</th> 
			  <th style="width:1.9%">Valor Desp</th> 
			  <th style="width:1.9%">Desp. en Periodo</th> 
			  <th style="width:1.9%">Vlr. Desp en Periodo</th> 
			  <th style="width:1.9%">D&iacute;as Entr</th> 
			  <th style="width:1.9%">Caras Plast</th> 
			  <th style="width:1.9%">Cartulina</th> 	
			  <th style="width:1.9%">Conver / Pliegos</th> 
			  <th style="width:1.9%">Conver / Tama&ntilde;o</th> 
			  <th style="width:1.9%">Conver / Metros</th> 
			  <th style="width:1.9%">Conver / Kilos</th> 
			  <th style="width:1.9%">Tiempo Impresi&oacute;n</th> 
			  <th style="width:1.9%">Tiempo Troquelado</th> 
			  <th style="width:1.9%">Tiempo Laminado</th> 
			  <th >Precio Unitario</th> 
			  <th style="width:1%">Susp.</th> 
			  <th >Ord Cerrada</th> 
			 </tr> 
		</thead>
		<tbody class="scrollContent">';
			 
		$ContFila=0;
/*		echo $SQL;*/
		$conexionFP=ConectarSIP();
		$resultFP = mssql_query($SQL, $conexionFP);
		
		while($rowFP = mssql_fetch_row($resultFP)) {
			$resultado=$resultado.'<tr>
		<td style="width:1.9%"><b>'.$rowFP[6].'</b></td>
		<td style="width:3%">'.$rowFP[7].'</td>
		<td style="width:1.9%">'.$rowFP[8].'</td>
		<td style="width:2.1%">'.$rowFP[9].'</td>
		<td style="width:2.2%">'.$rowFP[10].'</td>
		<td style="width:2.2%">'.$rowFP[11].'</td>
		<td style="width:2.2%">'.$rowFP[12].'</td>
		<td style="width:4.3%">'.$rowFP[13].'</td>
		<td style="width:10%">'.$rowFP[14].'</td>
		<td style="width:2.4%">'.$rowFP[15].'</td>
		<td style="width:2.4%">'.$rowFP[28].'</td>
		<td style="width:2.4%">'.$rowFP[41].'</td>
		<td style="width:4%">'.$rowFP[16].'</td>
		<td style="width:1.3%">'.$rowFP[17].'</td>
		<td style="width:1.1%">'.$rowFP[18].'</td>
		<td style="width:3.9%">'.$rowFP[19].'</td>
		<td style="width:1.9%">'.$rowFP[21].'</td>
		<td>'.$rowFP[2].'
		</td>
		<td>'.$rowFP[20].'
		</td>
		<td>'.$rowFP[3].'
		</td>
		<td>'.$rowFP[22].'
		</td>
		<td>'.$rowFP[23].'
		</td>
		<td>'.$rowFP[24].'
		</td>
		<td>'.$rowFP[25].'
		</td>
		<td>'.$rowFP[26].'
		</td>
		<td>'.$rowFP[27].'
		</td>
		<td>'.$rowFP[4].'
		</td>
		<td>'.$rowFP[29].'
		</td>
		<td>'.$rowFP[30].'
		</td>
		<td>'.$rowFP[31].'
		</td>
		<td>'.$rowFP[32].'
		</td>
		<td>'.$rowFP[33].'
		</td>
		<td>'.$rowFP[34].'
		</td>
		<td>'.$rowFP[35].'
		</td>
		<td>'.$rowFP[37].'
		</td>
		<td>'.$rowFP[38].'
		</td>
		<td>'.$rowFP[39].'
		</td>
		<td>'.$rowFP[40].'
		</td>
		<td>'.$rowFP[5].'
		</td>
</tr>
			';
		}
		mssql_free_result($resultFP);
		mssql_close($conexionFP);
		$resultado=$resultado.'</tbody>
		</table>';
		echo $resultado;
} catch (Exception $e) {
    echo "Caught Exception ('{$e->getMessage()}')\n{$e}\n";
}	
break;

case  'origenes':
	$SQL="Select Codigo_MYE from myempresas Where Estado_MYE='1' Order By Codigo_MYE;";	
	$result = mysqli_query($conexion, $SQL);
	$Empresas="";
	while ($row = mysqli_fetch_row($result)) {
		$Empresas=$Empresas.$row[0].",";
	}
	mysqli_free_result($result);
	if ($Empresas=="") {
		echo '<span class="error">No se encuentran las empresas a conectar</span>';
	} else {
		echo ($Empresas);
	}
break;

case "empleados":
	$CodRAD= rtrim($_GET['value']);
	$SQL="Select rtrim(a.Codigo_EPS), a.Estado_RAD, LPAD(a.Codigo_RAD,10,'0') From czradicacionescab as a Where LPAD(a.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0');";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		if ($row[1]=="0"){
			$resultado='<span class="error">La radicacion '.$row[2].' se encuentra anulada.</span>';
		} else {
			$CodEPS= $row[0];
			$CodRAD= $row[2];
			mysqli_free_result($result);
			$resultado='<p><label>Archivos de la radicaci&oacute;n:</label> '.$CodRAD;
			//Se crea la carpeta si no existe...
			$RutaRIPS='../../../files/rips/';
			if (!(is_dir($RutaRIPS.$CodEPS))) {
				mkdir ($RutaRIPS.$CodEPS, 0777);
			}
			$resultado=$resultado.'<label>Carpeta:</label> ../'.$CodEPS.'/ ';
			//Verifico el siguiente numero de remision...
			$SQL="Update gxeps Set RemisionRIPS_EPS=RemisionRIPS_EPS+1 Where Codigo_EPS='".$CodEPS."';";
			mysqli_query($conexion, $SQL);
			$SQL="Select LPAD(a.RemisionRIPS_EPS,6,'0') From gxeps as a Where a.Codigo_EPS='".$CodEPS."';";
			$result = mysqli_query($conexion, $SQL);
			if($row = mysqli_fetch_row($result)) {
				$CodREM= $row[0];
				$resultado=$resultado.'<label>Remisi&oacute;n No.</label> '.$CodREM.'</p><hr align="center" width="90%" size="1" class="anulado"/>';
			}
			mysqli_free_result($result);
			
			//=================== R.I.P.S. ======================
			$NoFiles=0;
		//Archivo AF
	$NoAF=0;
	$SQL = "Select '',trim(a.Prestador_FCN), ucase(trim(a.RazonSocial_FCN)), trim(a.TipoId_FCN), trim(a.Identificacion_FCN), trim(b.Codigo_FAC), date_format(b.Fecha_FAC,'%d/%m/%Y'), date_format(h.Fecha_ADM,'%d/%m/%Y'), date_format(adddate(b.Fecha_FAC,c.VenceFactura_EPS) ,'%d/%m/%Y'), trim(c.Codigo_EPS), trim(d.Nombre_TER), trim(c.Contrato_EPS), trim(ucase(f.Nombre_PLA)), '', ROUND(b.ValPaciente_FAC), 0, ROUND(b.ValDcto_FAC), ROUND(b.ValEntidad_FAC) 
From gxfacturaconf as a, gxfacturas as b, gxeps as c, czterceros as d, czradicacionesdet as e, gxplanes as f, gxadmision as h 
Where b.Codigo_EPS=c.Codigo_EPS and d.Codigo_TER=c.Codigo_TER and e.Codigo_FAC=b.Codigo_FAC and f.Codigo_PLA=b.Codigo_PLA and h.Codigo_ADM=b.Codigo_ADM and LPAD(e.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0') Order By b.Codigo_FAC;";
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
	$resultado=$resultado.'<label class="manito" onclick="window.open(\'download.php?file=/rips/'.$CodEPS.'/AF'.$CodREM.'.TXT\');"  alt="AF" title="Archivo de Facturas AF'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/images/txt.png" align="absmiddle" />AF'.$CodREM.'.TXT</label>';
	$NoFiles++;
	}

		//Archivo US
	$NoUS=0;
	$SQL = "Select distinct trim(d.Sigla_TID), trim(d.Sigla_TID), trim(b.ID_TER), trim(a.Codigo_EPS), trim(e.Codigo_TAF), trim(e.Apellido1_PAC), trim(e.Apellido2_PAC), trim(e.Nombre1_PAC), trim(e.Nombre2_PAC), year(now())-year(e.FechaNac_PAC), '1', e.Codigo_SEX, e.Codigo_DEP, e.Codigo_MUN, e.Codigo_ZNA From gxfacturas as a, czterceros as b, gxadmision as c, cztipoid as d, gxpacientes as e, czradicacionesdet as f
Where a.Codigo_ADM=c.Codigo_ADM and c.Codigo_TER=b.Codigo_TER and d.Codigo_TID=b.Codigo_TID and e.Codigo_TER=c.Codigo_TER and a.Codigo_FAC=f.Codigo_FAC and LPAD(f.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0');";
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
	$resultado=$resultado.'<label class="manito" onclick="window.open(\'download.php?file=/rips/'.$CodEPS.'/US'.$CodREM.'.TXT\');"  alt="US" title="Archivo de Usuarios US'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/images/txt.png" align="absmiddle" />US'.$CodREM.'.TXT</label>';
	$NoFiles++;
	}

		//Archivo AM
	$NoAM=0;
	$SQL = "Select trim(a.Codigo_FAC),trim(a.Codigo_FAC), trim(e.Prestador_FCN), trim(h.Sigla_TID), trim(f.ID_TER), '', CUPS_MED, case i.Codigo_CFC when '12' then '1' when '13' then '2' end, d.Nombre_MED, 'SOLUCION INYECTABLE', '100 Mg', 'Amp', SUM(b.Cantidad_ORD), ROUND(AVG(b.ValorServicio_ORD)), ROUND(sum(b.Cantidad_ORD* b.ValorServicio_ORD))
From gxfacturas as a, gxordenesdet as b, gxordenescab as c, gxmedicamentos as d, gxfacturaconf as e, czterceros as f, gxadmision as g, cztipoid as h, gxservicios as i, czradicacionesdet as j
Where a.Codigo_ADM=c.Codigo_ADM and b.Codigo_ORD=c.Codigo_ORD and b.Codigo_EPS=a.Codigo_EPS and b.Codigo_PLA=a.Codigo_PLA and d.Codigo_SER=b.Codigo_SER
and f.Codigo_TER=g.Codigo_TER and g.Codigo_ADM=a.Codigo_ADM and h.Codigo_TID=f.Codigo_TID and i.Codigo_SER=d.Codigo_SER and i.Codigo_CFC in ('12','13') and a.Codigo_FAC=j.Codigo_FAC and c.Estado_ORD='1' and LPAD(j.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0') 
Group By trim(a.Codigo_FAC), trim(e.Prestador_FCN), trim(h.Sigla_TID), trim(f.ID_TER), '', d.CUM_MED, case i.Codigo_CFC when '12' then '1' when '13' then '2' end, d.Nombre_MED, 'SOLUCION INYECTABLE', '100 Mg', 'Amp';";
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
	$resultado=$resultado.'<label class="manito" onclick="window.open(\'download.php?file=/rips/'.$CodEPS.'/AM'.$CodREM.'.TXT\');"  alt="AM" title="Archivo de Medicamentos AM'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/images/txt.png" align="absmiddle" />AM'.$CodREM.'.TXT</label>';
	$NoFiles++;
	}

		//Archivo AC
	$NoAC=0;
	$SQL = "Select trim(a.Codigo_FAC),trim(a.Codigo_FAC), trim(b.Prestador_FCN), trim(e.Sigla_TID), trim(d.ID_TER), date_format(f.Fecha_ORD,'%d/%m/%Y'), trim(c.Autorizacion_ADM), trim(h.CUPS_PRC), '10', '13', 'K297', 'K297', '', '', '1', ROUND(g.ValorServicio_ORD), ROUND(g.ValorPaciente_ORD), ROUND(g.ValorEntidad_ORD) 
From gxfacturas as a, gxfacturaconf as b, gxadmision as c, czterceros as d, cztipoid as e, gxordenescab as f, gxordenesdet as g, gxprocedimientos as h, czradicacionesdet as i, gxservicios as j
Where a.Codigo_ADM=c.Codigo_ADM and d.Codigo_TER=c.Codigo_TER and e.Codigo_TID=d.Codigo_TID and f.Codigo_ADM=a.Codigo_ADM and g.Codigo_ORD=f.Codigo_ORD and j.Codigo_SER=h.Codigo_SER and j.Codigo_CFC='01'
and g.Codigo_EPS=a.Codigo_EPS and g.Codigo_PLA=a.Codigo_PLA and h.Codigo_SER=g.Codigo_SER and i.Codigo_FAC=a.Codigo_FAC and f.Estado_ORD='1' and 	 LPAD(i.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0')";
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
	{	
		if (file_exists($RutaRIPS.$CodEPS.'/AC'.$CodREM.'.TXT')) {
			file_put_contents($RutaRIPS.$CodEPS.'/AC'.$CodREM.'.TXT', chr(13).chr(10), FILE_APPEND);
		}
		$TextLine=$row[0].','.$row[2].','.$row[3].','.$row[4].','.$row[5].','.$row[6].','.$row[7].','.$row[8].','.$row[9].','.$row[10].','.$row[11].','.$row[12].','.$row[13].','.$row[14].','.number_format($row[15],0,'','').','.number_format($row[16],0,'','').','.number_format($row[17],0,'','');
		file_put_contents($RutaRIPS.$CodEPS.'/AC'.$CodREM.'.TXT', $TextLine, FILE_APPEND);	
		$NoAC++;
	}
	mysqli_free_result($result);
	if ($NoAC!=0){
	if (($NoFiles % 4)==0){
	$resultado=$resultado.'<br>';
	}
	$resultado=$resultado.'<label class="manito" onclick="window.open(\'download.php?file=/rips/'.$CodEPS.'/AC'.$CodREM.'.TXT\');"  alt="AC" title="Archivo de Consultas AC'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/images/txt.png" align="absmiddle" />AC'.$CodREM.'.TXT</label>';
	$NoFiles++;
	}

		//Archivo AP
	$NoAP=0;
	$SQL = "Select trim(a.Codigo_FAC), trim(b.Prestador_FCN), trim(e.Sigla_TID), trim(d.ID_TER), date_format(f.Fecha_ORD,'%d/%m/%Y'), trim(c.Autorizacion_ADM), trim(h.CUPS_PRC), '1', '2', '','K297', 'K297', '', '',  ROUND(g.ValorEntidad_ORD) 
From gxfacturas as a, gxfacturaconf as b, gxadmision as c, czterceros as d, cztipoid as e, gxordenescab as f, gxordenesdet as g, gxprocedimientos as h, czradicacionesdet as i, gxservicios as j
Where a.Codigo_ADM=c.Codigo_ADM and d.Codigo_TER=c.Codigo_TER and e.Codigo_TID=d.Codigo_TID and f.Codigo_ADM=a.Codigo_ADM and g.Codigo_ORD=f.Codigo_ORD and j.Codigo_SER=h.Codigo_SER and j.Codigo_CFC in('04','03','02')
and g.Codigo_EPS=a.Codigo_EPS and g.Codigo_PLA=a.Codigo_PLA and h.Codigo_SER=g.Codigo_SER and i.Codigo_FAC=a.Codigo_FAC and f.Estado_ORD='1' and  LPAD(i.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0')";
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
	$resultado=$resultado.'<label class="manito" onclick="window.open(\'download.php?file=/rips/'.$CodEPS.'/AP'.$CodREM.'.TXT\');"  alt="AP" title="Archivo de Procedimientos AP'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/images/txt.png" align="absmiddle" />AP'.$CodREM.'.TXT</label>';
	$NoFiles++;
	}

		//Archivo AT
	$NoAT=0;
	$SQL = "Select trim(a.Codigo_FAC),trim(a.Codigo_FAC), trim(b.Prestador_FCN), trim(e.Sigla_TID), trim(d.ID_TER), trim(c.Autorizacion_ADM), case j.Codigo_CFC when '09' then '1' when '06' then '3' when '07' then '4' when '14' then '2' end, trim(j.Codigo_SER), trim(ucase(j.Nombre_SER)), ROUND(sum(g.Cantidad_ORD)), ROUND(avg(g.ValorEntidad_ORD)), ROUND(sum(g.Cantidad_ORD* g.ValorEntidad_ORD)) 
From gxfacturas as a, gxfacturaconf as b, gxadmision as c, czterceros as d, cztipoid as e, gxordenescab as f, gxordenesdet as g,  czradicacionesdet as i, gxservicios as j
Where a.Codigo_ADM=c.Codigo_ADM and d.Codigo_TER=c.Codigo_TER and e.Codigo_TID=d.Codigo_TID and f.Codigo_ADM=a.Codigo_ADM and g.Codigo_ORD=f.Codigo_ORD and j.Codigo_CFC in ('06','07','09','14')
and g.Codigo_EPS=a.Codigo_EPS and g.Codigo_PLA=a.Codigo_PLA and j.Codigo_SER=g.Codigo_SER and i.Codigo_FAC=a.Codigo_FAC and f.Estado_ORD='1' and    LPAD(i.Codigo_RAD,10,'0')=LPAD('".$CodRAD."',10,'0')
Group By trim(a.Codigo_FAC), trim(b.Prestador_FCN), trim(e.Sigla_TID), trim(d.ID_TER), trim(c.Autorizacion_ADM), case j.Codigo_CFC when '09' then '1' when '06' then '3' when '07' then '4' when '14' then '2' end, trim(j.Codigo_SER), trim(ucase(j.Nombre_SER));";
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
	$resultado=$resultado.'<label class="manito" onclick="window.open(\'download.php?file=/rips/'.$CodEPS.'/AT'.$CodREM.'.TXT\');"  alt="AT" title="Archivo de Transacciones AT'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/images/txt.png" align="absmiddle" />AT'.$CodREM.'.TXT</label>';
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
		$resultado=$resultado.'<label class="manito" onclick="window.open(\'download.php?file=/rips/'.$CodEPS.'/CT'.$CodREM.'.TXT\');"  alt="CT" title="Archivo de Control CT'.$CodREM.'.TXT" ><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/images/txt.png" align="absmiddle" />CT'.$CodREM.'.TXT</label>';
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
	die("Error : ".$zip->errorInfo(true));
	}
	$resultado=$resultado.'    <hr align="center" width="90%" size="1" class="anulado"/>
	<label class="manito" onclick="window.open(\'download.php?file=/rips/'.$CodEPS.'/RAD'.$CodRAD.'REM'.$CodREM.'.zip\');"><img src="themes/'.$_SESSION["THEME_DEFAULT"].'/images/zip.png"  alt="Archivo Comprimido" align="absmiddle" title="Archivo Comprimido" />RAD'.$CodRAD.'REM'.$CodREM.'.zip</label>';
	echo $resultado;
break;

}

$SQL="COMMIT;";
mysqli_query($conexion, $SQL) or die($MSG='<div class="message_error"></div>Se presentaron errores para completar la transaccion: <br><br><span class="codigo"><strong>Error:</strong> '.mysql_error().'</span>');

?>