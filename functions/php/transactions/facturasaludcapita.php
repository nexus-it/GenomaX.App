<?php

include '00trnsctns.php';
	// Definir Area en la cual se va a trabajar
	
	// Generar un ingreso para la capita 
	$Consec=LoadConsec("gxadmision", "Codigo_ADM", "0", $conexion, "LPAD(Codigo_ADM,10,'0')");
	$SQL="Insert into gxadmision(Codigo_ADM, Codigo_TER, Fecha_ADM, Codigo_EPS, Codigo_PLA, Codigo_CXT, Codigo_FNC, Ingreso_ADM, FechaHosp_ADM, Codigo_CAM, Codigo_DGN, ValorRemitido_ADM, Remision_ADM, FechaRemision_ADM, IPS_ADM, Motivo_ADM, Acudiente_ADM, Direccion_ADM, Telefono_ADM, Autorizacion_ADM, FechaAutorizacion_ADM, Observaciones_ADM, Codigo_USR, UsuarioAnula_USR, Estado_ADM, Copago_ADM, Cuota_ADM, FechaFin_ADM, Codigo_PTT, Codigo_SDE) Select '".$Consec."', '0', now(), '".trim($_POST["Contrato"])."', '".$_POST['Plan']."', '13', '10', 'H3', now(), '', 'R066', '0', '', now(), '', 'CUENTA CAPITADA', '', '--', '--', Contrato_EPS, now(), 'CONTRATO CAPITADO', '".$_SESSION["it_CodigoUSR"]."', '', 'F', '0', '0', FechaFin_EPS, '1', Codigo_SDE From gxeps, czsedes where Codigo_AFC='".$_POST['sede']."' and Codigo_EPS='".trim($_POST["Contrato"])."' limit 1";
	// error_log('Fact Capita: '.$SQL);
	$ConsecIng=$Consec;
	EjecutarSQL($SQL, $conexion);
	it_aud('1', 'Admisiones', 'Ingreso Capita No.'.$Consec);

	// Generar ordenes de servicio para la capita
	$Consec=LoadConsec("gxordenescab", "Codigo_ORD", "0", $conexion, "LPAD(Codigo_ORD,10,'0')");
	$SQL="Insert into gxordenescab(Codigo_ORD, Codigo_ADM, Fecha_ORD, Codigo_ARE, Descripcion_ORD, Codigo_USR, Estado_ORD, Autorizacion_ORD) Select '".$Consec."', '".$ConsecIng."', now(), Codigo_ARE, 'CUENTA CAPITADA',  '".$_SESSION["it_CodigoUSR"]."', '1', 'C A P I T A' From gxareas Where Codigo_SDE in (Select codigo_sde from czsedes where Codigo_AFC='".$_POST['sede']."') limit 1";
	// error_log('Fact Capita: '.$SQL);
	$ConsecOrd=$Consec;
	EjecutarSQL($SQL, $conexion);
	// Servicios 
	$Consec=LoadConsec("gxservicios", "Codigo_SER", "0", $conexion, "LPAD(Codigo_SER,6,'0')");
	$Consec="X".$Consec;
	$SQL="Insert into gxservicios(Codigo_SER, Nombre_SER, Tipo_SER, Codigo_CFC, EdadMinima_SER, EdadMaxima_SER, SexoM_SER, SexoF_SER, Complejidad_SER, Estado_SER) Values ('".$Consec."', '".$_POST["nombreserv"]."', '1', '00', '0',  '43800', '1', '1', '2', '1')";
	// error_log('Fact Capita: '.$SQL);
	$ConsecSer=$Consec;
	EjecutarSQL($SQL, $conexion);
	$SQL="Replace into gxprocedimientos(Codigo_SER, Nombre_PRC, CUPS_PRC, ISS2001_PRC, ISS2000_PRC, SOAT_PRC, MAPIPOS_PRC, Procedimiento_PRC, UVR_PRC, GRUPOSOAT_PRC, PuntosSOAT_PRC, Tercerizar_PRC, UVRMin_PRC, UVRMax_PRC) VALUES ('".$ConsecSer."', '".$_POST["nombreserv"]."', 'CAPITA', 'CAPITA', 'CAPITA', '000000', '000000',0, 0, 0, 0, 0, 0, 0)";
	EjecutarSQL($SQL, $conexion);
	// error_log('Fact Capita: '.$SQL);
	$SQL="Insert Into gxtarifaexcepciones(Codigo_TAR, FechaINI_TAR, FechaFin_TAR, Tipo_TRX, Codigo_TRX, Tarifa_TRX, Valor_TRX) Select Codigo_TAR, '".$_POST["fechafin"]."', '".$_POST["fechafin"]." 23:59:59', 'X', '".$ConsecSer."', '', ".$_POST['valfactura']." From gxcontratos Where Codigo_EPS='".TRIM($_POST['Contrato'])."' and Codigo_PLA='".$_POST['Plan']."' ";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert Into gxmanualestarifarios(Codigo_TAR, FechaIni_TAR, FechaFin_TAR, Codigo_SER, Valor_TAR) Select Codigo_TAR, '".$_POST["fechafin"]."', '".$_POST["fechafin"]." 23:59:59', '".$ConsecSer."', ".$_POST['valfactura']." From gxcontratos Where Codigo_EPS='".TRIM($_POST['Contrato'])."' and Codigo_PLA='".$_POST['Plan']."' ";
	EjecutarSQL($SQL, $conexion);
	$SQL="Insert into gxordenesdet(Codigo_ORD, Codigo_SER, Cantidad_ORD, Codigo_EPS, Codigo_PLA, Codigo_TER, ValorServicio_ORD, ValorEntidad_ORD) Values('".$ConsecOrd."', '".$ConsecSer."', ".$_POST["cantidad"].", '".TRIM($_POST['Contrato'])."', '".$_POST['Plan']."', '', ".$_POST["valorservicio"].", ".$_POST["valorservicio"].");";
	// error_log('Fact Capita: '.$SQL);
	EjecutarSQL($SQL, $conexion);
	it_aud('1', 'Ordenes de Servicios', 'Servicio Capita No.'.$Consec);
 
	// Registro factura
	$Consec=LoadConsecFact($conexion, $_POST['sede']);
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha generado correctamente la factura '.add_ceros($Consec,10);
	}
	$ent=$_POST["valfactura"]+$_POST["valorpaciente"];
	$SQL="Insert into gxfacturas(Codigo_AFC, Codigo_FAC, Fecha_FAC, Codigo_ADM, Codigo_EPS, Codigo_PLA, Codigo_USR, Tipo_FAC, ValEntidad_FAC, ValTotal_FAC, ValPaciente_FAC, Month_FAC, Year_FAC) Values ('".$_POST['sede']."','".$Consec."', curdate(), '".$ConsecIng."', '".$_POST["Contrato"]."', '".$_POST["Plan"]."', '".$_SESSION["it_CodigoUSR"]."', 'C',  '".$_POST["valorservicio"]*$_POST["cantidad"]."',  '".$_POST["valfactura"]."',  '".$_POST["valorpaciente"]."', '".$_POST["mes"]."', '".$_POST["anyo"]."')";
	EjecutarSQL($SQL, $conexion);
	// error_log($SQL);
	$SQL="Insert into gxfacturascapita(Codigo_FAC, FechaIni_FAC, FechaFin_FAC, ValPaciente_FAC, Servicio_FAC, ValServicio_FAC, Cantidad_FAC, ValTotal_FAC) 
	Values ('".$Consec."', '".$_POST["fechaini"]."', '".$_POST["fechafin"]."', '".$_POST["valorpaciente"]."', '".$_POST["nombreserv"]."', '".$_POST["valorservicio"]."',  '".$_POST["cantidad"]."',  '".$_POST["valfactura"]."')";
	EjecutarSQL($SQL, $conexion);

	$contador=0; 
/*	
	$SQL="Insert into czcartera(Codigo_AFC, Codigo_FAC, ValorFac_CAR, Saldo_CAR, Estado_CAR) Values('".$_POST['sede']."', '".$Consec."', '".$_POST["valfactura"]."', '".$_POST["valfactura"]."','1')";
	EjecutarSQL($SQL, $conexion);
	*/
	while($contador <= $_POST['contfila']) { 
		$contador++;
		
		if (isset($_POST['ingreso'.$contador])) {
		
		$SQL="Update gxadmision Set Estado_ADM='F', Codigo_FAC='".$Consec."' Where Codigo_ADM='".$_POST['ingreso'.$contador]."';";
		EjecutarSQL($SQL, $conexion);

		//Antes de esto, verificar si la tarifa es soat o es iss, para realizar bien el redondeo
		
		}
	} 

		// Traemos la info de la cabecera de la factura
$SQL="SELECT a.Codigo_FAC, b.Prefijo_AFC, a.Fecha_FAC, a.Codigo_ADM, b.Codigo_AFC, c.VenceFactura_EPS FROM gxfacturas a, czautfacturacion b, gxeps c WHERE c.Codigo_EPS=a.Codigo_EPS and a.Codigo_AFC=b.Codigo_AFC AND b.IdFormSiigo_AFC<>'' AND a.Estado_FAC='1' and IdFE_FAC='0' and a.Codigo_FAC='".$Consec."';";
$resultxxx = mysqli_query($conexion, $SQL);
$contador=0;
while($rowxxx = mysqli_fetch_row($resultxxx)) {

// Si hay Factura Electronica...
	$strHeaderFac="";
	$strAccount="";
	$strServices="";
	$strPayments="";
	
	if (!(is_null($_SESSION["SiigoToken"]))) {
		// Traemos la info de la cabecera de la factura
		$SQL="SELECT a.IdFormSiigo_AFC AS 'DocCode', cast(right(b.Codigo_FAC, 10) AS UNSIGNED) AS 'Number', DATE_FORMAT(b.Fecha_FAC, '%Y%m%d') AS 'DocDate',  'COP' AS 'MoneyCode', -1 AS 'SelfWithholdingTaxID', b.ValPaciente_FAC AS 'AdvancePaymentValue', b.ValTotal_FAC AS 'TotalValue',  b.ValTotal_FAC AS 'TotalBase', UsuarioAPP_XFE AS 'SalesmanIdentification',Concat('Contrato ', g.Contrato_EPS, ' Plan: ', h.Nombre_PLA,' <br>',IFNULL(b.Nota_FAC,'')) AS 'Observations', Payments_XFE as 'Payments', DATE_FORMAT(DATE_ADD(b.Fecha_FAC, INTERVAL ".$rowxxx[4]." DAY), '%Y%m%d') as 'Vencim' FROM czautfacturacion a, gxfacturas b, itconfig_fe c, czterceros d, gxeps g, gxplanes h WHERE g.Codigo_EPS=b.Codigo_EPS and h.Codigo_PLA=b.Codigo_PLA and c.Estado_XFE='1' and  a.Codigo_AFC=b.Codigo_AFC AND b.Codigo_FAC='".$rowxxx[0]."' and b.Tipo_FAC='C';";
        // error_log($SQL);
		$result = mysqli_query($conexion, $SQL);
		$contador=0;
		if($rowp = mysqli_fetch_row($result)) {
			$strHeaderFac=$strHeaderFac.'{
    "Header": {
        "DocCode": '.$rowp[0].', 
        "Number": 0,
        "DocDate": "'.$rowp[2].'",
        "VATTotalValue": 0,
        "RetVATTotalID": -1,
        "RetVATTotalPercentage": -1,
        "RetVATTotalValue": 0,
        "RetICATotalID": -1,
        "RetICATotalValue": 0,
        "RetICATotaPercentage": -1,
        "SelfWithholdingTaxID": -1,
        "TotalValue": '.number_format($rowp[6],2,'.','').',
        "TotalBase": '.number_format($rowp[7],2,'.','').',
        "SalesmanIdentification": "'.$rowp[8].'",
        "Observations": "'.str_replace('<br>','\r\n',$rowp[9]).'",';
        // error_log($strHeaderFac);
        // Formas de Pago
        $strPayments=$strPayments.'
		"Payments": [
        {
            "PaymentMeansCode": '.$rowp[10].',
            "Value": '.$rowp[6].',
            "DueDate": "'.$rowp[11].'",
            "DueQuote": 1
        }
    ]
}';
        }
		mysqli_free_result($result);
		// Informacion de la cuenta y el contacto
		$SQL="SELECT distinct c.Nombre_TER, c.ID_TER, c.Direccion_TER, c.Telefono_TER, PhoneContact_EPS, CellContact_EPS, lower(EmailContact_EPS), NameContact_EPS, LastnameContact_EPS, b.Codigo_EPS, CodMin_EPS  FROM gxeps a, gxfacturas b, czterceros c WHERE a.Codigo_EPS=b.Codigo_EPS AND a.Codigo_TER=c.Codigo_TER AND b.Codigo_FAC='".$rowxxx[0]."' and b.Tipo_FAC='C';";
		// error_log($SQL);
		$result = mysqli_query($conexion, $SQL);
		$contador=0;
		$entidad="";
		if($rowp = mysqli_fetch_row($result)) {
			$strAccount=$strAccount.'
		"Account": {
            "IsSocialReason": true,
            "FullName": "'.$rowp[0].'",
            "IdTypeCode": "31",
            "Identification": "'.$rowp[1].'",
            "BranchOffice": 0,
            "IsVATCompanyType": false,
            "City": {
                "CountryCode": "CO",
                "StateCode": "08",
                "CityCode": "08001"
            },
            "Address": "'.$rowp[2].'",
            "Phone": {
                "Number": '.$rowp[3].'
            }
        },
        "Contact": {
            "Phone1": {
                "Number": '.$rowp[4].'
            },
            "Mobile": {
                "Number": '.$rowp[5].'
            },
            "EMail": "'.$rowp[6].'",
            "FirstName": "'.$rowp[7].'",
            "LastName": "'.$rowp[8].'",
            "IsPrincipal": true
        }
    },';
		$entidad=$rowp[9].$rowp[10];
        }
		mysqli_free_result($result);
		$CodProd='CPT'.$entidad;
		// Verificamos que los productos se encuentren en Siigo
		$SQL="SELECT concat('".$CodProd."', year(NOW()),MONTH(NOW())), concat(Servicio_FAC, ' PERIODO: Del ', FechaIni_FAC, ' Al ',FechaFin_FAC), '1', ValTotal_FAC/Cantidad_FAC, Cantidad_FAC, GrupoFE_SER FROM gxfacturascapita, gxserviciostipos  WHERE Codigo_FAC='".$rowxxx[0]."' and Tipo_SER ='1'";
		// error_log($SQL);
		$result = mysqli_query($conexion, $SQL);
		$contador=0;
		while($rowp = mysqli_fetch_row($result)) {
			$contador++;
			// Crear extracto de la cadena creacion de factura (productos)
			if ($contador>1) {
				$strServices=$strServices.',';	
			} else {
				$strServices=$strServices.'
"Items": [';
			}
			$strServices=$strServices.'
{
    "ProductCode": "'.$rowp[0].'",
    "Description": "'.$rowp[1].'",
    "GrossValue": '.number_format($rowp[3]*$rowp[4],2,'.','').',
    "BaseValue": '.number_format($rowp[3]*$rowp[4],2,'.','').',
    "Quantity": '.$rowp[4].',
    "UnitValue": '.number_format($rowp[3],2,'.','').',
    "TaxAddName": "",
    "TaxAddId": -1,
    "TaxDiscountId": -1,
    "TotalValue": '.number_format($rowp[3]*$rowp[4],2,'.','').',
    "TaxAdd2Id": -1
}';
			// error_log($rowp[0]);
			createProduct($rowp[0], $rowp[1], $rowp[2], $rowp[5], $rowp[0]);
		}
		mysqli_free_result($result);
	$strServices=$strServices.'
],';	
	
	$BodyInvoice=$strHeaderFac. $strAccount. $strServices. $strPayments;
	$resultado=createInvoice($BodyInvoice);
	// error_log('factura: '.$resultado);
	$ConsecFE=json_decode($resultado, true);
	foreach ($ConsecFE as $NumFac) {
		if($NumFac['Number']!="") {
			$SQL="Insert Into gxfacturaselectronicas(Codigo_FAC, IdFE_FAC, NumFE_FAC) Values('".$rowxxx[0]."', '".$NumFac['Id']."', '".$NumFac['Number']."')";
			// error_log($SQL);
			EjecutarSQL($SQL, $conexion);
			$NewFact=$rowxxx[0];
			$SQL="Select Concat(trim(Prefijo_AFC),b.Separador_AFC,trim(LPAD(".$NumFac['Number'].",10,b.Ceros_AFC))) from gxfacturas a, czautfacturacion b Where a.Codigo_AFC=b.Codigo_AFC and Codigo_FAC='".$rowxxx[0]."' and Tipo_FAC='C';";
			$result = mysqli_query($conexion, $SQL);
			while($rownf = mysqli_fetch_row($result)) {
				$NewFact=$rownf[0];
			}
			// error_log('Nueva Factura: '.$NewFact);
			mysqli_free_result($result);
			$SQL="Update gxfacturas Set IdFE_FAC='".$NumFac['Id']."', Codigo_FAC='".$NewFact."' Where Codigo_FAC='".$rowxxx[0]."' and Tipo_FAC='C';";
			// error_log($SQL);
			EjecutarSQL($SQL, $conexion);
			$SQL="Update gxfacturascapita Set Codigo_FAC='".$NewFact."' Where Codigo_FAC='".$rowxxx[0]."';";
			// error_log($SQL);
			EjecutarSQL($SQL, $conexion);
			$SQL="Update gxadmision Set Codigo_FAC='".$NewFact."' Where Codigo_FAC='".$rowxxx[0]."';";
			// error_log($SQL);
			EjecutarSQL($SQL, $conexion);
			$SQL="Update czautfacturacion Set ConsecNow_AFC='".$NumFac['Number']."' Where Codigo_AFC='".$rowxxx[4]."';";
			EjecutarSQL($SQL, $conexion);
			$Consec=$rowxxx[1].' '.$NumFac['Number'];
			$MSG=$rowxxx[1]."-".$NumFac['Number']."correcto";
		}
	}
	}
	// Fin interfaz FE (Siigo)
}
mysqli_free_result($resultxxx);

	it_aud('1', 'Facturación Salud', 'Factura por cápita No. '.$Consec);

include '99trnsctns.php';

?>