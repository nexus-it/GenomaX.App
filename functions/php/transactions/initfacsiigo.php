<?php
session_start();
function EjecutarSQL($Cons, $Conn) {
	$Flag=0;
	if(mysqli_query($Conn, $Cons)) {
		$Flag=1;
	  } else {
        error_log("gnmx_ERROR: No se ejecuto $Cons. " . mysqli_error($Conn));
    }
}
include '../../../config.php';
include '../nexus/database.php';
include '../nexus/auditoria.php';
if (!(is_null($_SESSION["SiigoToken"]))) {
	include '../nexus/nxs_api_siigo.php';
}
$MSG='Datos registrados correctamente. ';
$error = 0;
$conexion=Conexion();
$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
mysqli_query($conexion, $MyZone);
// $SQL="SELECT a.Codigo_SER, b.Nombre_SER, b.Tipo_SER, d.GrupoFE_SER, avg(a.ValorEntidad_ORD), sum(a.Cantidad_ORD) FROM gxordenesdet a, gxservicios b, gxordenescab c, gxserviciostipos d WHERE d.Tipo_SER=b.Tipo_SER and c.Codigo_ORD=a.Codigo_ORD and a.Codigo_SER=b.Codigo_SER and c.codigo_adm='".(int)$rowxxx[3]."' Group By a.Codigo_SER, b.Nombre_SER, b.Tipo_SER, d.GrupoFE_SER Order By 1";
      

$SQL="Update gxordenesdet b, gxordenescab a, gxmanualestarifarios c, gxcontratos d, gxadmision e Set b.ValorServicio_ORD= c.Valor_TAR, b.ValorEntidad_ORD=c.Valor_TAR where a.Codigo_ORD=b.Codigo_ORD and d.Codigo_TAR=c.Codigo_TAR and b.Codigo_EPS=d.Codigo_EPS and b.Codigo_PLA=d.Codigo_PLA and c.Codigo_SER=b.Codigo_SER AND a.Fecha_ORD between c.FechaIni_TAR and c.FechaFin_TAR and e.Codigo_ADM=a.Codigo_ADM AND a.Codigo_ADM IN (SELECT codigo_adm FROM gxfacturas WHERE codigo_fac LIKE 'tmp%') ;";
EjecutarSQL($SQL, $conexion);
/* init */
// Se crean los productos y servicios que no existan en Siigo
$SQL="SELECT distinct e.CUM_MED, y.Nombre_SER, y.Tipo_SER, d.GrupoFE_SER, x.Codigo_SER FROM gxordenesdet x, gxservicios y, gxordenescab z, gxfacturas a, czautfacturacion b, gxserviciostipos d, gxmedicamentos e WHERE e.Codigo_SER=y.Codigo_SER and d.Tipo_SER=y.Tipo_SER and z.Codigo_ORD=x.Codigo_ORD and x.Codigo_SER=y.Codigo_SER and z.codigo_adm=a.codigo_adm and a.Codigo_AFC=b.Codigo_AFC AND b.IdFormSiigo_AFC<>'' AND a.Estado_FAC='1' and IdFE_FAC=0 and xPortSiigo_SER<>'1' UNION SELECT distinct e.CUPS_PRC, y.Nombre_SER, y.Tipo_SER, d.GrupoFE_SER, x.Codigo_SER FROM gxordenesdet x, gxservicios y, gxordenescab z, gxfacturas a, czautfacturacion b, gxserviciostipos d, gxprocedimientos e WHERE e.Codigo_SER=y.Codigo_SER and d.Tipo_SER=y.Tipo_SER and z.Codigo_ORD=x.Codigo_ORD and x.Codigo_SER=y.Codigo_SER and z.codigo_adm=a.codigo_adm and a.Codigo_AFC=b.Codigo_AFC AND b.IdFormSiigo_AFC<>'' AND a.Estado_FAC='1' and IdFE_FAC=0 and xPortSiigo_SER<>'1';";
//error_log($SQL);
$resultyy = mysqli_query($conexion, $SQL);
$contador=0;
while($rowyy = mysqli_fetch_row($resultyy)) {
    createProduct($rowyy[4], $rowyy[1], $rowyy[2], $rowyy[3], $rowyy[0]);
    $SQL="Update gxservicios Set xPortSiigo_SER='1' where codigo_ser='".$rowyy[4]."'";
    EjecutarSQL($SQL, $conexion);
    //error_log($SQL);
}
mysqli_free_result($resultyy);
/* end */

$SQL="SELECT a.Codigo_FAC, b.Prefijo_AFC, a.Fecha_FAC, a.Codigo_ADM, b.Codigo_AFC, c.VenceFactura_EPS, a.Tipo_FAC FROM gxfacturas a, czautfacturacion b, gxeps c WHERE c.Codigo_EPS=a.Codigo_EPS and a.Codigo_AFC=b.Codigo_AFC AND b.IdFormSiigo_AFC<>'' AND a.Estado_FAC='1' and IdFE_FAC='0' ORDER BY 2,3,1;";
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
        if ($rowxxx[6]=='E') {
          $SQL="UPDATE gxfacturas T1, ( SELECT b.Codigo_ADM, SUM(a.Cantidad_ORD * a.ValorEntidad_ORD) total FROM gxordenesdet a, gxordenescab b where a.Codigo_ORD=b.Codigo_ORD and b.Estado_ORD='1'  GROUP BY b.Codigo_ADM ) T2 SET T1.ValTotal_FAC = T2.total- T1.ValCredito_FAC , T1.ValEntidad_FAC = T2.total     WHERE T1.Codigo_ADM = T2.Codigo_ADM AND T1.ValEntidad_FAC <> T2.total AND T1.codigo_adm IN ('".$rowxxx[3]."')";
          EjecutarSQL($SQL, $conexion);
		  $SQL="SELECT a.IdFormSiigo_AFC AS 'DocCode', cast(right(b.Codigo_FAC, 10) AS UNSIGNED) AS 'Number', DATE_FORMAT(b.Fecha_FAC, '%Y%m%d') AS 'DocDate',  'COP' AS 'MoneyCode', -1 AS 'SelfWithholdingTaxID', b.ValPaciente_FAC AS 'AdvancePaymentValue', b.ValTotal_FAC AS 'TotalValue',  b.ValTotal_FAC AS 'TotalBase', UsuarioAPP_XFE AS 'SalesmanIdentification',Concat('Contrato ', g.Contrato_EPS, ' Plan: ', h.Nombre_PLA,' <br>Pcte: ',d.Nombre_TER, ' ', e.Sigla_TID,' ',d.ID_TER, ' <br>Dir. ', d.Direccion_TER, ' Tel.',d.Telefono_TER, ' Barrio ', i.Barrio_PAC, ' - ',j.Nombre_MUN, ' <br>Admision: ',f.Codigo_ADM,' Ing.',f.Fecha_ADM,' Egr.', f.FechaFin_ADM, ' <br>Dx: ', f.Codigo_DGN, ' ',k.Descripcion_DGN,' <br>',IFNULL(b.Nota_FAC,'')) AS 'Observations', Payments_XFE as 'Payments', DATE_FORMAT(DATE_ADD(b.Fecha_FAC, INTERVAL ".$rowxxx[5]." DAY), '%Y%m%d') as 'Vencim' FROM czautfacturacion a, gxfacturas b, itconfig_fe c, czterceros d, cztipoid e, gxadmision f, gxeps g, gxplanes h, gxpacientes i, czmunicipios j, gxdiagnostico k WHERE k.Codigo_DGN=f.Codigo_DGN and j.Codigo_MUN=i.Codigo_MUN and j.Codigo_DEP=i.Codigo_DEP and i.Codigo_TER=f.Codigo_TER and g.Codigo_EPS=b.Codigo_EPS and h.Codigo_PLA=b.Codigo_PLA and e.Codigo_TID=d.Codigo_TID AND f.Codigo_ADM=b.Codigo_ADM AND c.Estado_XFE='1' and d.Codigo_TER=f.Codigo_TER and a.Codigo_AFC=b.Codigo_AFC AND b.Codigo_FAC='".$rowxxx[0]."' and b.Codigo_ADM='".$rowxxx[3]."';";
        } else {
            $SQL="SELECT a.IdFormSiigo_AFC AS 'DocCode', cast(right(b.Codigo_FAC, 10) AS UNSIGNED) AS 'Number', DATE_FORMAT(b.Fecha_FAC, '%Y%m%d') AS 'DocDate',  'COP' AS 'MoneyCode', -1 AS 'SelfWithholdingTaxID', b.ValPaciente_FAC AS 'AdvancePaymentValue', b.ValTotal_FAC AS 'TotalValue',  b.ValTotal_FAC AS 'TotalBase', UsuarioAPP_XFE AS 'SalesmanIdentification',Concat('Contrato ', g.Contrato_EPS, ' Plan: ', h.Nombre_PLA,' <br>',IFNULL(b.Nota_FAC,'')) AS 'Observations', Payments_XFE as 'Payments', DATE_FORMAT(DATE_ADD(b.Fecha_FAC, INTERVAL ".$rowxxx[5]." DAY), '%Y%m%d') as 'Vencim' FROM czautfacturacion a, gxfacturas b, itconfig_fe c, czterceros d, gxeps g, gxplanes h WHERE g.Codigo_EPS=b.Codigo_EPS and h.Codigo_PLA=b.Codigo_PLA and c.Estado_XFE='1' and  a.Codigo_AFC=b.Codigo_AFC AND b.Codigo_FAC='".$rowxxx[0]."' and b.Tipo_FAC='C';";
        }
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
        // Formas de Pago
        $strPayments=$strPayments.'
		"Payments": [
        {
            "PaymentMeansCode": '.$rowp[10].',
            "Value": '.$rowp[6].',
            "DueDate": "'.$rowp[2].'",
            "DueQuote": 1
        }
    ]
}';
        }
		mysqli_free_result($result);
		// Informacion de la cuenta y el contacto
		$SQL="SELECT distinct c.Nombre_TER, c.ID_TER, c.Direccion_TER, c.Telefono_TER, PhoneContact_EPS, CellContact_EPS, lower(EmailContact_EPS), NameContact_EPS, LastnameContact_EPS, b.Codigo_EPS, CodMin_EPS  FROM gxeps a, gxfacturas b, czterceros c WHERE a.Codigo_EPS=b.Codigo_EPS AND a.Codigo_TER=c.Codigo_TER AND b.Codigo_FAC='".$rowxxx[0]."' and b.Codigo_ADM='".$rowxxx[3]."';";
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
        $entidad=$rowp[10];
        }
		mysqli_free_result($result);
		// Verificamos que los productos se encuentren en Siigo
        if ($rowxxx[6]=='E') {
            $SQL="SELECT a.Codigo_SER, b.Nombre_SER, b.Tipo_SER, avg(a.ValorEntidad_ORD), sum(a.Cantidad_ORD) FROM gxordenesdet a, gxservicios b, gxordenescab c WHERE c.Codigo_ORD=a.Codigo_ORD and a.Codigo_SER=b.Codigo_SER and c.codigo_adm='".(int)$rowxxx[3]."' and c.Estado_ORD='1' Group By a.Codigo_SER, b.Nombre_SER, b.Tipo_SER Order By 1;";
        } else {
            $CodProd='C'.$entidad;
            $SQL="SELECT concat('".$CodProd."', MONTH(NOW())), concat(Servicio_FAC, ' PERIODO: Del ', FechaIni_FAC, ' Al ',FechaFin_FAC), '1', ValTotal_FAC/Cantidad_FAC, Cantidad_FAC, GrupoFE_SER FROM gxfacturascapita, gxserviciostipos  WHERE Codigo_FAC='".$rowxxx[0]."' and Tipo_SER ='1'";
        }
		$result = mysqli_query($conexion, $SQL);
		$contador=0;
		while($rowp = mysqli_fetch_row($result)) {
			$contador++;
            $sufix="";
            if ($rowxxx[6]!='E') {
                $sufix=number_format($rowp[3]*$rowp[4],0,'.','');
            }
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
        if ($rowxxx[6]!='E') {
            createProduct($rowp[0], $rowp[1], $rowp[2], $rowp[5],$rowp[0]);
        }
		}
		mysqli_free_result($result);
	$strServices=$strServices.'
],';	
	
	$BodyInvoice=$strHeaderFac. $strAccount. $strServices. $strPayments;
    error_log('Empresa: '.$_SESSION["DB_NAME"].' ---'.$BodyInvoice);
	$resultado=createInvoice($BodyInvoice);
	error_log('Factura '.$_SESSION["DB_NAME"].': '.$resultado);
	$ConsecFE=json_decode($resultado, true);
	foreach ($ConsecFE as $NumFac) {
		if($NumFac['Number']!="") {
			$SQL="Insert Into gxfacturaselectronicas(Codigo_FAC, IdFE_FAC, NumFE_FAC) Values('".$rowxxx[0]."', '".$NumFac['Id']."', '".$NumFac['Number']."')";
			//error_log($SQL);
			EjecutarSQL($SQL, $conexion);
            if ($rowxxx[6]=='E') {
                $SQL="Update gxfacturas a, czautfacturacion b Set IdFE_FAC='".$NumFac['Id']."', Codigo_FAC=Concat(trim(Prefijo_AFC),b.Separador_AFC,trim(LPAD(".$NumFac['Number'].",10,b.Ceros_AFC)))  Where a.Codigo_AFC=b.Codigo_AFC and Codigo_FAC='".$rowxxx[0]."' and Codigo_ADM='".$rowxxx[3]."';";
            } else {
                $SQL="Update gxfacturas a, czautfacturacion b Set IdFE_FAC='".$NumFac['Id']."', Codigo_FAC=Concat(trim(Prefijo_AFC),b.Separador_AFC,trim(LPAD(".$NumFac['Number'].",10,b.Ceros_AFC))) Where a.Codigo_AFC=b.Codigo_AFC and Codigo_FAC='".$rowxxx[0]."' and Tipo_FAC='C';";
            }
			//error_log($SQL);
			EjecutarSQL($SQL, $conexion);
            $SQL="Update czautfacturacion Set ConsecNow_AFC='".$NumFac['Number']."' Where Codigo_AFC='".$rowxxx[4]."';";
            EjecutarSQL($SQL, $conexion);
		}
	}
	}
	// Fin interfaz FE (Siigo)
}
mysqli_free_result($resultxxx);

// include '99trnsctns.php';
?>