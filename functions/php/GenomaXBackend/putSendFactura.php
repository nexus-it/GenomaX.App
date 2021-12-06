<?php
//var_dump($_POST);exit();
include('params.php');
include '../nexus/database.php';
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
mysqli_query ($conexion, "SET NAMES 'utf8'");

$SQL = "Select a.Razonsocial_DCD, a.NIT_DCD, a.Direccion_DCD, a.Telefonos_DCD, a.EncabezadoFact_DCD, a.PiePaginaFact_DCD, b.ConsecIni_AFC, b.ConsecFin_AFC, b.Resolucion_AFC, b.Fecha_AFC, c.Codigo_FAC, c.Codigo_ADM, date(c.Fecha_FAC) as 'fechafac', c.ValPaciente_FAC, c.ValEntidad_FAC, c.ValCredito_FAC, c.ValTotal_FAC, c.Estado_FAC, e.ID_TER,e.DigitoVerif_TER, e.Nombre_TER, e.Direccion_TER, e.Telefono_TER, e.Correo_TER, LPAD(f.Codigo_ADM,10,'0'), CONCAT(h.Sigla_TID,' ', g.ID_TER), g.Nombre_TER as nompasciente, i.Nombre_PLA, c.Codigo_EPS, c.Codigo_PLA, adddate(c.Fecha_FAC,d.VenceFactura_EPS), f.Autorizacion_ADM, a.Ciudad_DCD
, SPLIT_STR(c.CODIGO_FAC, '-', 1) AS PREFIJO, SPLIT_STR(c.CODIGO_FAC, '-', 2) as NUMERACION, e.Correo_TER, time(c.Fecha_FAC) as 'horafac', date(adddate(c.Fecha_FAC,d.VenceFactura_EPS)) as fechavence, d.VenceFactura_EPS as diasvence
From itconfig a, czautfacturacion b, gxfacturas c, gxeps d, czterceros e, gxadmision f, 
czterceros g, cztipoid h, gxplanes i WHERE c.Codigo_AFC = b.Codigo_AFC  and d.Codigo_EPS= c.Codigo_EPS  and e.Codigo_TER= d.Codigo_TER   and f.Codigo_ADM =c.Codigo_ADM   and g.Codigo_TER=f.Codigo_TER and h.Codigo_TID=g.Codigo_TID and i.Codigo_PLA= c.Codigo_PLA 
AND c.Codigo_FAC = '".$_POST["factura"]."' and estado_fac = 1
";
/*"AND SPLIT_STR(c.CODIGO_FAC, '-', 1)  = '".trim($_GET["PREFIJO"])."'
AND (SPLIT_STR(c.CODIGO_FAC, '-', 2)  >= '".($_GET["CODIGO_INICIAL"])."'
AND SPLIT_STR(c.CODIGO_FAC, '-', 2)  <= '".($_GET["CODIGO_FINAL"])."')
";*/

//echo $SQL;


$resultH = mysqli_query($conexion, $SQL);
while ($rowH = mysqli_fetch_array($resultH)) {
	


$string = $_POST["factura"];
//var_dump($_POST["factura"]);
$NUMERACION = preg_replace('/[^0-9]/', '', $string);
$cadena = explode($NUMERACION,$string);
$PREFIJO = $cadena[0];

//var_dump($prefijo);

	$bearer = ValidarBearer(verficarEmpresaReg());

	$SQL_DET="SELECT c.Codigo_CFC, c.Nombre_CFC, SUM(b.Cantidad_ORD*(b.ValorPaciente_ORD+ b.ValorEntidad_ORD)) AS valor FROM gxordenescab a, gxordenesdet b, gxconceptosfactura c, gxservicios d WHERE a.Codigo_ORD=b.Codigo_ORD AND c.Codigo_CFC= d.Codigo_CFC AND d.Codigo_SER=b.Codigo_SER AND a.Estado_ORD='1' AND b.Codigo_EPS='".$rowH['Codigo_EPS']."' AND b.Codigo_PLA='".$rowH['Codigo_PLA']."' AND LPAD(a.Codigo_ADM,10,'0')=LPAD('".$rowH["Codigo_ADM"]."',10,'0') GROUP BY c.Codigo_CFC, c.Nombre_CFC";
	$SQL_DET="SELECT f.Descripcion_SER, c.CUPS_PRC, e.Nombre_SER, a.ValorServicio_ORD as valor, SUM(a.Cantidad_ORD) AS cantidad FROM gxtiposervicios f, gxordenesdet a, gxordenescab b, gxprocedimientos c, gxfacturas d, gxservicios e WHERE b.Estado_ORD='1' AND f.Tipo_SER=e.Tipo_SER and a.Codigo_ORD=b.Codigo_ORD AND c.Codigo_SER=a.Codigo_SER AND e.Codigo_SER=a.Codigo_SER AND d.Codigo_ADM=b.Codigo_ADM AND e.Tipo_SER='1' AND d.Codigo_FAC='".$_POST["factura"]."' GROUP BY e.Tipo_SER, c.CUPS_PRC, e.Nombre_SER UNION SELECT g.Descripcion_SER, j.Codigo_MED, l.Nombre_SER, h.ValorServicio_ORD as valor, SUM(h.Cantidad_ORD) AS cantidad FROM gxtiposervicios g, gxordenesdet h, gxordenescab i, gxmedicamentos j, gxfacturas k, gxservicios l WHERE i.Estado_ORD='1' AND g.Tipo_SER=l.Tipo_SER and h.Codigo_ORD=i.Codigo_ORD AND j.Codigo_SER=h.Codigo_SER AND l.Codigo_SER=h.Codigo_SER AND k.Codigo_ADM=i.Codigo_ADM AND l.Tipo_SER='2' AND k.Codigo_FAC='".$_POST["factura"]."' GROUP BY l.Tipo_SER, j.Codigo_MED, l.Nombre_SER";
	// UNION SELECT e.Tipo_SER, e.Codigo_SER, e.Nombre_SER, SUM(a.Cantidad_ORD*a.ValorServicio_ORD) AS valor FROM gxordenesdet a, gxordenescab b, gxfacturas d, gxservicios e WHERE a.Codigo_ORD=b.Codigo_ORD AND e.Codigo_SER=a.Codigo_SER AND d.Codigo_ADM=b.Codigo_ADM AND e.Tipo_SER<>'1' AND d.Codigo_FAC='".$_POST["factura"]."' GROUP BY e.Tipo_SER, e.Codigo_SER, e.Nombre_SER ORDER BY 1,2";
	error_log($SQL_DET);
	$result = mysqli_query($conexion, $SQL_DET);
	//echo $SQL_DET;
	while ($row = mysqli_fetch_array($result)) {
		$detalle[] =array(
			"unit_measure_id"=> 70,// UNIDAD DE MEDIDA 
			"invoiced_quantity"=> $row['cantidad'],
			"line_extension_amount"=> $row['valor']*$row['cantidad'],
			"free_of_charge_indicator"=> false,
			/*"tax_totals"=> [array(
					"tax_id"=> 1,
					"tax_amount"=> "0",
					"taxable_amount"=> $row['valor'],
					"percent"=> "0"
			)
			],*/
			"description"=> $row['Nombre_SER'],
			"notes"=> $row['Nombre_SER'],
			"code"=>  $row['CUPS_PRC'],
			"type_item_identification_id"=> 4,
			"price_amount"=> $row['valor'],
			"base_quantity"=>  $row['cantidad']
		);
	}

	$payload= array('number'=>$NUMERACION, //$rowH['NUMERACION'],
					'type_document_id'=>1,
					'date'=>$rowH['fechafac'],
					'time'=>$rowH['horafac'],
					'resolution_number'=>$rowH['Resolucion_AFC'],
					'prefix'=>$PREFIJO, //$rowH['PREFIJO'],
					'notes'=>'factura electronica',
					'disable_confirmation_text'=>true,
					'establishment_name'=>$rowH['Razonsocial_DCD'],
					'establishment_address'=>$rowH['Direccion_DCD'],
					'establishment_phone'=>$rowH['Telefonos_DCD'],
					'establishment_municipality'=>126,
					'atacheddocument_name_prefix'=>$rowH['Codigo_FAC'],
					'establishment_email'=>$rowH['Correo_TER'],
					'sendmail'=> false,
					'sendmailtome'=> false,
					'seze'=> "2021-2017",
					'head_note'=>$rowH['EncabezadoFact_DCD'],
					'foot_note'=> $rowH['PiePaginaFact_DCD'],
					"customer"=> array(
						"identification_number"=> $rowH['ID_TER'],
						"dv"=> $rowH['DigitoVerif_TER'],
						"name"=> $rowH['Nombre_TER'],
						"phone"=> $rowH['Telefono_TER'],
						"address"=> $rowH['Direccion_TER'],
						"email"=> $rowH['Correo_TER'],
						"merchant_registration"=> "0000000-00",
						"type_document_identification_id"=> 6,
						"type_organization_id"=> 1,
						"type_liability_id"=> 7,
						"municipality_id"=> 822,
						"type_regime_id"=> 1
					),
					"payment_form"=> array(
						"payment_form_id"=> 2,
						"payment_method_id"=> $rowH['diasvence'],
						"payment_due_date"=> $rowH['fechavence'],
						"duration_measure"=> $rowH['diasvence']
					),
					/* "allowance_charges"=> array(
						
							"discount_id"=> 1,
							"charge_indicator"=> false,
							"allowance_charge_reason"=> "DESCUENTO COPAGO",
							"amount"=> $rowH['ValPaciente_FAC'],
							"base_amount"=> $rowH['ValPaciente_FAC'] + $rowH['ValTotal_FAC']
						
					), */
					"legal_monetary_totals"=> array(
						"line_extension_amount"=> $rowH['ValTotal_FAC'],
						"tax_exclusive_amount"=> "0",
						"tax_inclusive_amount"=> $rowH['ValTotal_FAC'],
						"payable_amount"=> $rowH['ValTotal_FAC']
					),
					/*"tax_totals"=>[array( 
							"tax_id"=> "1",
							"tax_amount"=> "0",
							"percent"=> "0",
							"taxable_amount"=> $rowH['ValCredito_FAC']
					)],*/
					"invoice_lines"=>$detalle
					);

}


//error_log('bearer: '.$bearer);exit();
//var_dump($payload);exit();
$payload = json_encode($payload);
// print_r($payload);exit();
// error_log('pay: '.$payload);

$curl = curl_init();

//$TestSetId_sadinca="/812626b9-8779-414f-a03c-22a75dc826ae";
//$TestSetId_hid="/c91a2f28-e1a3-4586-be86-b06578eb86fc";
//$TestSetId_tecnowebs =   'cfa3b4f4-ea97-4a2e-b7d1-6506131ca8c8';
//$TestSetId_vision = '442810ba-2837-4e22-ae53-0180e6731747';
$TestSetId_sadinca="";

curl_setopt_array($curl, array(
  CURLOPT_URL => $prefixUrl.'invoice'.$TestSetId_sadinca,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$payload,
  CURLOPT_SSL_VERIFYPEER => false, 
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Accept: application/json',
    'Authorization: Bearer '.$bearer 
  ),
));

//error_log('curl: '.$curl);
$response = curl_exec($curl);
//error_log('response: '.$response);

if($errno = curl_errno($curl)){
	$errno_message = curl_errno($errno);
	echo "cURL error ({$errno}):\n {$errno_message}";
	var_dump($errno);
}

curl_close($curl);

echo $response;

/*


'{
	"number": 990000001,
	"type_document_id": 1,
	"date": "2021-09-23",
	"time": "04:08:12",
	"resolution_number": "18760000001",
	"prefix": "SETP",
    "notes": "ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA",
    "disable_confirmation_text": true,
    "establishment_name": "TECNOWEBS S.A.S",
    "establishment_address": "BRR LIMONAR MZ 6 CS 3 ET 1 PISO 2",
    "establishment_phone": "3226563672",
    "establishment_municipality": 600,
    "atacheddocument_name_prefix": "SETP990000001",
    "establishment_email": "ing.leandro.castro@gmail.com",
	"sendmail": true,
    "sendmailtome": true,
    "seze": "2021-2017",
    "head_note": "PRUEBA DE TEXTO LIBRE QUE DEBE POSICIONARSE EN EL ENCABEZADO DE PAGINA DE LA REPRESENTACION GRAFICA DE LA FACTURA ELECTRONICA VALIDACION PREVIA DIAN",
    "foot_note": "PRUEBA DE TEXTO LIBRE QUE DEBE POSICIONARSE EN EL PIE DE PAGINA DE LA REPRESENTACION GRAFICA DE LA FACTURA ELECTRONICA VALIDACION PREVIA DIAN",
	"customer": {
		"identification_number": 900166483,
		"dv": 1,
		"name": "INVERSIONES DAVAL SAS",
		"phone": 3103891693,
		"address": "CLL 4 NRO 33-90",
		"email": "ing.leandro.castro@gmail.com",
		"merchant_registration": "0000000-00",
		"type_document_identification_id": 6,
		"type_organization_id": 1,
        "type_liability_id": 7,
		"municipality_id": 822,
		"type_regime_id": 1
	},
	"payment_form": {
		"payment_form_id": 2,
		"payment_method_id": 30,
		"payment_due_date": "2021-09-24",
		"duration_measure": "30"
	},	
	"legal_monetary_totals": {
		"line_extension_amount": "840336.134",
		"tax_exclusive_amount": "840336.134",
		"tax_inclusive_amount": "1000000.00",
		"payable_amount": "1000000.00"
	},
	"tax_totals": 
	[
		{
			"tax_id": 1,
			"tax_amount": "159663.865",
			"percent": "19.00",
			"taxable_amount": "840336.134"
		}
	],
	"invoice_lines": 
	[
		{
			"unit_measure_id": 70,
			"invoiced_quantity": "1",
			"line_extension_amount": "840336.134",
			"free_of_charge_indicator": false,
			"tax_totals": [
				{
					"tax_id": 1,
					"tax_amount": "159663.865",
					"taxable_amount": "840336.134",
					"percent": "19.00"
				}
			],
			"description": "COMISION POR SERVICIOS",
            "notes": "ESTA ES UNA PRUEBA DE NOTA DE DETALLE DE LINEA.",
			"code": "COMISION",
			"type_item_identification_id": 4,
			"price_amount": "1000000.00",
			"base_quantity": "1"
		}
	]
}

'

*/