<?php
 
include '00trnsctns.php';

	$Consec=LoadConsecFact($conexion, $_POST['sede']);
	if ($MSG=='Datos registrados correctamente. ') {
		$MSG='Se ha generado correctamente la factura '.add_ceros($Consec,10);
	}
	$SQL="Insert into gxfacturas(Codigo_AFC, Codigo_FAC, Codigo_ADM, Fecha_FAC, ValPaciente_FAC, ValEntidad_FAC, ValTotal_FAC, Codigo_EPS, Codigo_PLA, Codigo_USR, Nota_FAC, Month_FAC, Year_FAC) Values ('".$_POST['sede']."','".$Consec."', '".(int)$_POST['Ingreso']."', '".$_POST["fechafac"]."', '".$_POST['totalpte']."',  '".$_POST["totalent"]."', '".$_POST["totalent"]."', '".$_POST["contrato"]."', '".$_POST["plan"]."', '".$_SESSION["it_CodigoUSR"]."', '".$_POST["nota"]."', '".$_POST["mes"]."', '".$_POST["anyo"]."')";
	EjecutarSQL($SQL, $conexion);

	$contador=0; 
	$SQL="Update gxadmision Set Estado_ADM='F' Where Codigo_ADM='".(int)$_POST['Ingreso']."';";
	EjecutarSQL($SQL, $conexion);

	// Verifico si se generó la factura del ingreso..
	$SQL="Select count(*) from gxfacturas where Codigo_ADM='".(int)$_POST['Ingreso']."' and Estado_FAC='1'";
	$result = mysqli_query($Conn, $SQL);
	if($row = mysqli_fetch_row($result)) {
		if ($row[0]=="0") {
			// se intenta generar nuevamente la factura
			$Consec=LoadConsecFact($conexion, $_POST['sede']);
			$MSG='Se ha generado correctamente la factura '.add_ceros($Consec,10);
			$SQL="Insert into gxfacturas(Codigo_AFC, Codigo_FAC, Codigo_ADM, Fecha_FAC, ValPaciente_FAC, ValEntidad_FAC, ValTotal_FAC, Codigo_EPS, Codigo_PLA, Codigo_USR, Nota_FAC, Month_FAC, Year_FAC) Values ('".$_POST['sede']."','".$Consec."', '".(int)$_POST['Ingreso']."', '".$_POST["fechafac"]." ".$_POST["horafac"]."', '".$_POST['totalpte']."',  '".$_POST["totalent"]."', '".$_POST["totalent"]."', '".$_POST["contrato"]."', '".$_POST["plan"]."', '".$_SESSION["it_CodigoUSR"]."', '".$_POST["nota"]."', '".$_POST["mes"]."', '".$_POST["anyo"]."')";
			error_log("Fecha y hora: ".$SQL);
			EjecutarSQL($SQL, $conexion);
		}
	}
	mysqli_free_result($result);
/*
	$SQL="Insert into czcartera(Codigo_AFC, Codigo_FAC, ValorFac_CAR, Saldo_CAR, Estado_CAR) Values('".$_POST['sede']."', '".$Consec."', '".$_POST["totalent"]."', '".$_POST["totalent"]."','1')";
	EjecutarSQL($SQL, $conexion);
	*/
	while($contador <= $_POST['controw']) { 
		$contador++;
		if (isset($_POST['codigoser'.$contador])) {
		//Antes de esto, verificar si la tarifa es soat o es iss, para realizar bien el redondeo
		
			$SQL="Update gxordenesdet Set ValorPaciente_ORD=ROUND(".$_POST['pteser'.$contador]."),  ValorEntidad_ORD=ROUND(".($_POST['totser'.$contador]-$_POST['pteser'.$contador])."), ValorServicio_ORD=ROUND(".$_POST['totser'.$contador].") Where Codigo_ORD='".$_POST['ordenser'.$contador]."' and Codigo_SER='".$_POST['codigoser'.$contador]."' and Codigo_EPS='".$_POST['contrato']."' and Codigo_PLA='".$_POST['plan']."'";
			EjecutarSQL($SQL, $conexion);
		}
	}

	$SQL="Update gxordenesdet b, gxordenescab a, gxmanualestarifarios c, gxcontratos d, gxadmision e Set b.ValorServicio_ORD= c.Valor_TAR, b.ValorEntidad_ORD=c.Valor_TAR where a.Codigo_ORD=b.Codigo_ORD and d.Codigo_TAR=c.Codigo_TAR and b.Codigo_EPS=d.Codigo_EPS and b.Codigo_PLA=d.Codigo_PLA and c.Codigo_SER=b.Codigo_SER AND a.Fecha_ORD between c.FechaIni_TAR and c.FechaFin_TAR and e.Codigo_ADM=a.Codigo_ADM AND a.Codigo_ADM IN (".(int)$_POST['Ingreso'].") ;";
		EjecutarSQL($SQL, $conexion);
		error_log($SQL);
	$SQL="UPDATE gxfacturas T1, ( SELECT b.Codigo_ADM, SUM(a.Cantidad_ORD * a.ValorEntidad_ORD) total  FROM gxordenesdet a, gxordenescab b where a.Codigo_ORD=b.Codigo_ORD and b.Estado_ORD='1'   GROUP BY b.Codigo_ADM ) T2    SET T1.ValTotal_FAC = T2.total- (T1.ValPaciente_FAC + T1.ValCredito_FAC) , T1.ValEntidad_FAC = T2.total     WHERE T1.Codigo_ADM = T2.Codigo_ADM AND T1.ValEntidad_FAC <> T2.total  AND T1.codigo_adm='".(int)$_POST['Ingreso']."'";
	EjecutarSQL($SQL, $conexion);
	
	if ($_POST["reingreso"]=="1") { //Si se realiza reingreso
		$Consecing=LoadConsec("gxadmision", "Codigo_ADM", "0000000000", $conexion, "LPAD(Codigo_ADM,10,'0')");
		$SQL="Insert Into gxadmision(Codigo_ADM, Codigo_TER, Fecha_ADM, Codigo_EPS, Codigo_PLA, Codigo_CXT, Codigo_FNC, Ingreso_ADM, FechaHosp_ADM, Codigo_CAM, Codigo_DGN, Motivo_ADM, Acudiente_ADM, Direccion_ADM, Telefono_ADM, Responsable_ADM, TelResp_ADM, Parentesco_ADM, Observaciones_ADM, Copago_ADM, Cuota_ADM, Codigo_SDE, Codigo_PTT, Codigo_ATE, Codigo_USR) Select ".$Consecing.", Codigo_TER, now(), Codigo_EPS, Codigo_PLA,Codigo_CXT, Codigo_FNC, Ingreso_ADM, curdate(), Codigo_CAM, Codigo_DGN, Motivo_ADM, Acudiente_ADM, Direccion_ADM, Telefono_ADM, Responsable_ADM, TelResp_ADM, Parentesco_ADM, '', Copago_ADM, Cuota_ADM, Codigo_SDE, Codigo_PTT, Codigo_ATE, '".$_SESSION["it_CodigoUSR"]."' from gxadmision x Where x.Estado_ADM='F' and x.Codigo_ADM='".(int)$_POST['Ingreso']."'";
		EjecutarSQL($SQL, $conexion);
		
		it_aud('1', 'Admisiones', 'Reingreso '.$Consecing);
	}

	// Si hay Factura Electronica...
	$strHeaderFac="";
	$strAccount="";
	$strServices="";
	$strPayments="";
	
	if (!(is_null($_SESSION["SiigoToken"]))) {
		// Se crean los productos que no existan en Siigo
		$SQL="SELECT distinct e.CUPS_PRC, y.Nombre_SER, y.Tipo_SER, d.GrupoFE_SER, x.Codigo_SER FROM gxordenesdet x, gxservicios y, gxordenescab z, gxfacturas a, czautfacturacion b, gxserviciostipos d, gxprocedimientos e WHERE e.Codigo_SER=y.Codigo_SER and d.Tipo_SER=y.Tipo_SER and z.Codigo_ORD=x.Codigo_ORD and x.Codigo_SER=y.Codigo_SER and z.codigo_adm=a.codigo_adm and a.Codigo_AFC=b.Codigo_AFC AND b.IdFormSiigo_AFC<>'' AND a.Estado_FAC='1' and IdFE_FAC=0 and a.Codigo_FAC='".$Consec."' and xPortSiigo_SER<>'1';";
		error_log($SQL);
		$resultyy = mysqli_query($conexion, $SQL);
		$contador=0;
		while($rowyy = mysqli_fetch_row($resultyy)) {
		    createProduct($rowyy[4], $rowyy[1], $rowyy[2], $rowyy[3], $rowyy[0]);
		    $SQL="Update gxservicios Set xPortSiigo_SER='1' where codigo_ser='".$rowyy[4]."'";
    		EjecutarSQL($SQL, $conexion);
    		error_log($SQL);
		}
		mysqli_free_result($resultyy);
		// Se crean los productos que no existan en Siigo
		$SQL="SELECT distinct e.CUM_MED, y.Nombre_SER, y.Tipo_SER, d.GrupoFE_SER, x.Codigo_SER FROM gxordenesdet x, gxservicios y, gxordenescab z, gxfacturas a, czautfacturacion b, gxserviciostipos d, gxmedicamentos e WHERE e.Codigo_SER=y.Codigo_SER and d.Tipo_SER=y.Tipo_SER and z.Codigo_ORD=x.Codigo_ORD and x.Codigo_SER=y.Codigo_SER and z.codigo_adm=a.codigo_adm and a.Codigo_AFC=b.Codigo_AFC AND b.IdFormSiigo_AFC<>'' AND a.Estado_FAC='1' and IdFE_FAC=0 and a.Codigo_FAC='".$Consec."' and xPortSiigo_SER<>'1';";
		error_log($SQL);
		$resultyy = mysqli_query($conexion, $SQL);
		$contador=0;
		while($rowyy = mysqli_fetch_row($resultyy)) {
		    createProduct($rowyy[4], $rowyy[1], $rowyy[2], $rowyy[3], $rowyy[0]);
		    $SQL="Update gxservicios Set xPortSiigo_SER='1' where codigo_ser='".$rowyy[4]."'";
    		EjecutarSQL($SQL, $conexion);
    		error_log($SQL);
		}
		mysqli_free_result($resultyy);

		// Traemos la info de la cabecera de la factura
$SQL="SELECT a.Codigo_FAC, b.Prefijo_AFC, a.Fecha_FAC, a.Codigo_ADM, b.Codigo_AFC, c.VenceFactura_EPS, c.Codigo_EPS FROM gxfacturas a, czautfacturacion b, gxeps c WHERE c.Codigo_EPS=a.Codigo_EPS and a.Codigo_AFC=b.Codigo_AFC AND b.IdFormSiigo_AFC<>'' AND a.Estado_FAC='1' and IdFE_FAC='0' and a.Codigo_FAC='".$Consec."';";
error_log($SQL);
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
		$SQL="SELECT a.IdFormSiigo_AFC AS 'DocCode', cast(right(b.Codigo_FAC, 10) AS UNSIGNED) AS 'Number', DATE_FORMAT(b.Fecha_FAC, '%Y%m%d') AS 'DocDate',  'COP' AS 'MoneyCode', -1 AS 'SelfWithholdingTaxID', b.ValPaciente_FAC AS 'AdvancePaymentValue', b.ValTotal_FAC AS 'TotalValue',  b.ValTotal_FAC AS 'TotalBase', UsuarioAPP_XFE AS 'SalesmanIdentification',Concat('Contrato ', g.Contrato_EPS, ' Plan: ', h.Nombre_PLA,' <br>Pcte: ',d.Nombre_TER, ' ', e.Sigla_TID,' ',d.ID_TER, ' <br>Dir. ', d.Direccion_TER, ' Tel.',d.Telefono_TER, ' Barrio ', i.Barrio_PAC, ' - ',j.Nombre_MUN, ' <br>Admision: ',f.Codigo_ADM,' Ing.',f.Fecha_ADM,' Egr.', f.FechaFin_ADM, ' <br>Dx: ', f.Codigo_DGN, ' ',k.Descripcion_DGN,' <br>',IFNULL(b.Nota_FAC,'')) AS 'Observations', Payments_XFE as 'Payments', DATE_FORMAT(DATE_ADD(b.Fecha_FAC, INTERVAL ".$rowxxx[5]." DAY), '%Y%m%d') as 'Vencim' FROM czautfacturacion a, gxfacturas b, itconfig_fe c, czterceros d, cztipoid e, gxadmision f, gxeps g, gxplanes h, gxpacientes i, czmunicipios j, gxdiagnostico k WHERE k.Codigo_DGN=f.Codigo_DGN and j.Codigo_MUN=i.Codigo_MUN and j.Codigo_DEP=i.Codigo_DEP and i.Codigo_TER=f.Codigo_TER and g.Codigo_EPS=b.Codigo_EPS and h.Codigo_PLA=b.Codigo_PLA and e.Codigo_TID=d.Codigo_TID AND f.Codigo_ADM=b.Codigo_ADM AND c.Estado_XFE='1' and d.Codigo_TER=f.Codigo_TER and a.Codigo_AFC=b.Codigo_AFC AND b.Codigo_FAC='".$rowxxx[0]."' and b.Codigo_ADM='".$rowxxx[3]."';";
        error_log($SQL);
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
        error_log($strHeaderFac);
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
		$SQL="SELECT distinct c.Nombre_TER, c.ID_TER, c.Direccion_TER, c.Telefono_TER, PhoneContact_EPS, CellContact_EPS, lower(EmailContact_EPS), NameContact_EPS, LastnameContact_EPS FROM gxeps a, gxfacturas b, czterceros c WHERE a.Codigo_EPS=b.Codigo_EPS AND a.Codigo_TER=c.Codigo_TER AND b.Codigo_FAC='".$rowxxx[0]."' and b.Codigo_ADM='".$rowxxx[3]."';";
		error_log($SQL);
		$result = mysqli_query($conexion, $SQL);
		$contador=0;
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
        }
		mysqli_free_result($result);
		// Verificamos que los productos se encuentren en Siigo
		$SQL="SELECT a.Codigo_SER, b.Nombre_SER, b.Tipo_SER, avg(a.ValorEntidad_ORD), sum(a.Cantidad_ORD) FROM gxordenesdet a, gxservicios b, gxordenescab c, gxprocedimientos d WHERE d.Codigo_SER=b.Codigo_SER and c.Codigo_ORD=a.Codigo_ORD and a.Codigo_SER=b.Codigo_SER and c.codigo_adm='".(int)$rowxxx[3]."' and c.Estado_ORD='1' Group By a.Codigo_SER, b.Nombre_SER, b.Tipo_SER Order By 1";
		error_log($SQL);
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
//			createProduct($rowp[0], $rowp[1], $rowp[2]);
		}
		mysqli_free_result($result);
	$strServices=$strServices.'
],';	
	$BodyInvoice=$strHeaderFac. $strAccount. $strServices. $strPayments;
	error_log('Empresa: '.$_SESSION["DB_NAME"].' ---'.$BodyInvoice);
	$resultado=createInvoice($BodyInvoice);
	error_log('factura: '.$resultado);
	$ConsecFE=json_decode($resultado, true);
	foreach ($ConsecFE as $NumFac) {
		if($NumFac['Number']!="") {
			$SQL="Insert Into gxfacturaselectronicas(Codigo_FAC, IdFE_FAC, NumFE_FAC) Values('".$rowxxx[0]."', '".$NumFac['Id']."', '".$NumFac['Number']."')";
			error_log($SQL);
			EjecutarSQL($SQL, $conexion);
			$SQL="Update gxfacturas a, czautfacturacion b Set IdFE_FAC='".$NumFac['Id']."', Codigo_FAC=Concat(trim(Prefijo_AFC),b.Separador_AFC,trim(LPAD(".$NumFac['Number'].",10,b.Ceros_AFC))) Where a.Codigo_AFC=b.Codigo_AFC and Codigo_FAC='".$rowxxx[0]."' and Codigo_ADM='".$rowxxx[3]."';";
			error_log($SQL);
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
	}
	it_aud('1', 'Facturación Salud', 'Factura por eventos No.'.$Consec);
	

include '99trnsctns.php';

?>