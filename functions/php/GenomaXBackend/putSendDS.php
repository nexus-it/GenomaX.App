<?php
//var_dump($_POST);exit();
ob_start();
include('params.php');
include '../nexus/database.php';
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
mysqli_query ($conexion, "SET NAMES 'utf8'");

$SQL = "SELECT a.Razonsocial_DCD, a.NIT_DCD, a.Direccion_DCD, a.Telefonos_DCD, a.EncabezadoFact_DCD, a.PiePaginaFact_DCD, b.ConsecIni_AFC, 
b.ConsecFin_AFC, b.Resolucion_AFC, b.Fecha_AFC, c.Codigo_FAC
, '' AS Codigo_ADM, date(c.date) as 'fechafac', c.valor AS ValPaciente_FAC, c.valor AS ValEntidad_FAC, c.valor AS ValCredito_FAC, 
c.valor AS ValTotal_FAC,'' as Estado_FAC, e.ID_TER,e.DigitoVerif_TER, e.Nombre_TER, e.Direccion_TER, e.Telefono_TER, e.Correo_TER
FROM itconfig a, czautfacturacion b, gxdocumentosoporte c, czterceros e
WHERE a.NIT_DCD = c.cliente 
AND b.Descripcion_AFC LIKE 'DS'
AND c.proveedor = e.ID_TER
AND c.factura = '".$_POST["factura"]."' GROUP BY a.Razonsocial_DCD ";


//echo $SQL;


$resultH = mysqli_query($conexion, $SQL);
while ($rowH = mysqli_fetch_array($resultH)) {
	
if($rowH['CorreoTER'] <> '--'){
$correoter = $rowH['CorreoTER'];
}
if($rowH['Correo_TER'] <> '--'){
$correoter = $rowH['Correo_TER'];
}

	

		$identification_number = $rowH['ID_TER'];
		$dv = $rowH['DigitoVerif_TER'];
		$name = $rowH['Nombre_TER'];
		$phone = $rowH['Telefono_TER'];
		$address = $rowH['Direccion_TER'];
		$email = $rowH['Correo_TER'];
		$merchant_registration = "0000000-00";
		$type_document_identification_id = $rowH['type_document_identification_id'];
		$type_organization_id = $rowH['type_organization_id'];
		$type_liability_id = $rowH['type_liability_id'];
		$municipality_id = $rowH['municipality_id'];
		$type_regime_id = 2;

	



$string = $_POST["factura"];
//var_dump($_POST["factura"]);
$NUMERACION = preg_replace('/[^0-9]/', '', $string);
$cadena = explode($NUMERACION,$string);
$PREFIJO = $cadena[0];

//var_dump($prefijo);

	$bearer = ValidarBearer(verficarEmpresaReg());

	

$SQL_DET = "SELECT c.producto AS Descripcion_SER, '' AS CUPS_PRC, c.producto AS Nombre_SER, c.cantidad, c.valor, '' AS  ValIVA_FAC
FROM itconfig a, czautfacturacion b, gxdocumentosoporte c, czterceros e
WHERE a.NIT_DCD = c.cliente 
AND b.Descripcion_AFC LIKE 'DS'
AND c.proveedor = e.ID_TER
AND c.factura = '".$_POST["factura"]."' GROUP BY a.Razonsocial_DCD ";

	$result = mysqli_query($conexion, $SQL_DET);

	//print_r($SQL_DET);exit();
	
	$CUPSant="";
	while ($row = mysqli_fetch_array($result)) {
		if ($row['CUPS_PRC']!=$CUPSant) {
			$sufij="";
		} else {
			$sufij="-X";
		}


		//AQUI AGREGO EL IVA SI ESTE EXISTE  -- LEANDRO CASTRO 2022-05-15 --
		if ($row['ValIVA_FAC'] > 0){
			$tax_id = 1;
			$tax_totals = [array(
				"tax_id"=> $tax_id,
				"tax_amount"=> $row['ValIVA_FAC'],
				"taxable_amount"=> $row['valor']*$row['cantidad'],
				"percent"=> 19			
			)];
		}else{
			$tax_id = 10;
			$tax_totals = [array()];
		}
		//AQUI AGREGO EL IVA SI ESTE EXISTE  -- LEANDRO CASTRO 2022-05-15 --

		
		if ($row['ValIVA_FAC'] > 0){

		$detalle[] =array(
			"unit_measure_id"=> 70,// UNIDAD DE MEDIDA 
			"invoiced_quantity"=> $row['cantidad'],
			"line_extension_amount"=> $row['valor']*$row['cantidad'],
			"free_of_charge_indicator"=> false,
			"tax_totals" => $tax_totals,//AQUI AGREGO EL IVA SI ESTE EXISTE  -- LEANDRO CASTRO 2022-05-15 --
			/*
			"tax_totals"=> [array(
					"tax_id"=> 1,
					"tax_amount"=> "0",
					"taxable_amount"=> $row['valor'],
					"percent"=> "0"
			)
			],*/
			"description"=> $row['Nombre_SER'].$sufij,
			"notes"=> $row['Nombre_SER'].$sufij,
			"code"=>  $row['CUPS_PRC'].$sufij,
			"type_item_identification_id"=> 4,
			"price_amount"=> $row['valor'],
			"base_quantity"=>  $row['cantidad']
		);
		$CUPSant=$row['CUPS_PRC'];

		
		}else{

		$detalle[] =array(
			"unit_measure_id"=> 70,// UNIDAD DE MEDIDA 
			"invoiced_quantity"=> $row['cantidad'],
			"line_extension_amount"=> $row['valor']*$row['cantidad'],
			"free_of_charge_indicator"=> false,
			//"tax_totals" => $tax_totals,//AQUI AGREGO EL IVA SI ESTE EXISTE  -- LEANDRO CASTRO 2022-05-15 --
			/*
			"tax_totals"=> [array(
					"tax_id"=> 1,
					"tax_amount"=> "0",
					"taxable_amount"=> $row['valor'],
					"percent"=> "0"
			)
			],*/
			"description"=> $row['Nombre_SER'].$sufij,
			"notes"=> $row['Nombre_SER'].$sufij,
			"code"=>  $row['CUPS_PRC'].$sufij,
			"type_item_identification_id"=> 4,
			"price_amount"=> $row['valor'],
			"base_quantity"=>  $row['cantidad']
		);
		$CUPSant=$row['CUPS_PRC'];

		}
	}



	if ($rowH['ValIVA_FAC'] > 0){


		//AQUI AGREGO EL IVA SI ESTE EXISTE PERO AL VALOR TOTAL DE LA FACTURA -- LEANDRO CASTRO 2022-05-15 --
		if ($rowH['ValIVA_FAC'] > 0){
			$tax_id = 1;
			$tax_totals = [array(
				"tax_id"=> $tax_id,
				"tax_amount"=> $rowH['ValIVA_FAC'],
				"taxable_amount"=> $rowH['ValSubTotal_FAC'],
				"percent"=> 19			
			)];
		}else{
			$tax_id = 10;
			$tax_totals = [array()];
		}
		//AQUI AGREGO EL IVA SI ESTE EXISTE PERO AL VALOR TOTAL DE LA FACTURA -- LEANDRO CASTRO 2022-05-15 --


	

		$payload= array('number'=>$NUMERACION, //$rowH['NUMERACION'],
					'type_document_id'=>11,
					'date'=>$rowH['fechafac'],
					'time'=>$rowH['horafac'],
					'resolution_number'=>$rowH['Resolucion_AFC'],
					'prefix'=>$PREFIJO, //$rowH['PREFIJO'],
					'notes'=>'Documento Soporte Electronico',
					'disable_confirmation_text'=>true,
					'establishment_name'=>$rowH['Razonsocial_DCD'],
					'establishment_address'=>$rowH['Direccion_DCD'],
					'establishment_phone'=>$rowH['Telefonos_DCD'],
					'establishment_municipality'=>126,
					'atacheddocument_name_prefix'=>$rowH['Codigo_FAC'],
					'establishment_email'=>$correoter, //$rowH['CorreoTER'],//$rowH['Correo_TER'],
					'sendmail'=> false,
					'sendmailtome'=> false,
					'seze'=> "2021-2017",
					'head_note'=>$rowH['EncabezadoFact_DCD'],
					'foot_note'=> $rowH['PiePaginaFact_DCD'],
					"seller"=> array(
						"identification_number"=> $identification_number,
						"dv"=> $dv,
						"name"=> $name,
						"phone"=> $phone,
						"address"=> $address,
						"email"=> $email,
						"merchant_registration"=> $merchant_registration,
						"type_document_identification_id"=> $type_document_identification_id,
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
					),/*
					 "allowance_charges"=> array(
						
							"discount_id"=> 1,
							"charge_indicator"=> false,
							"allowance_charge_reason"=> "DESCUENTO COPAGO",
							"amount"=> $rowH['ValPaciente_FAC'],
							"base_amount"=> $rowH['ValPaciente_FAC'] + $rowH['ValTotal_FAC']
						
					), */
					"legal_monetary_totals"=> array(
						"line_extension_amount"=> $rowH['ValSubTotal_FAC'],
						"tax_exclusive_amount"=> $rowH['ValSubTotal_FAC'],
						"tax_inclusive_amount"=> $rowH['ValTotal_FAC'],
						"payable_amount"=> $rowH['ValTotal_FAC']
					),
					"tax_totals" => $tax_totals,//AQUI AGREGO EL IVA SI ESTE EXISTE  -- LEANDRO CASTRO 2022-05-15 --
					/*"tax_totals"=>[array( 
							"tax_id"=> "1",
							"tax_amount"=> "0",
							"percent"=> "0",
							"taxable_amount"=> $rowH['ValCredito_FAC']
					)],*/
					"invoice_lines"=>$detalle
					);		

	}else{

		$payload= array('number'=>$NUMERACION, //$rowH['NUMERACION'],
					'type_document_id'=>1,
					'date'=>$rowH['fechafac'],
					'time'=>$rowH['horafac'],
					'resolution_number'=>$rowH['Resolucion_AFC'],
					'prefix'=>$PREFIJO, //$rowH['PREFIJO'],
					'notes'=>'Documento Soporte Electronico',
					'disable_confirmation_text'=>true,
					'establishment_name'=>$rowH['Razonsocial_DCD'],
					'establishment_address'=>$rowH['Direccion_DCD'],
					'establishment_phone'=>$rowH['Telefonos_DCD'],
					'establishment_municipality'=>126,
					'atacheddocument_name_prefix'=>$rowH['Codigo_FAC'],
					'establishment_email'=>$correoter,//$rowH['CorreoTER'],//$rowH['Correo_TER'],
					'sendmail'=> false,
					'sendmailtome'=> false,
					'seze'=> "2021-2017",
					'head_note'=>$rowH['EncabezadoFact_DCD'],
					'foot_note'=> $rowH['PiePaginaFact_DCD'],
					"seller"=> array(
						"identification_number"=> $identification_number,
						"dv"=> $dv,
						"name"=> $name,
						"phone"=> $phone,
						"address"=> $address,
						"email"=> $email,
						"merchant_registration"=> $merchant_registration,
						"type_document_identification_id"=> $type_document_identification_id,
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
					),/*
					 "allowance_charges"=> array(
						
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
					//"tax_totals" => $tax_totals,//AQUI AGREGO EL IVA SI ESTE EXISTE  -- LEANDRO CASTRO 2022-05-15 --
					/*"tax_totals"=>[array( 
							"tax_id"=> "1",
							"tax_amount"=> "0",
							"percent"=> "0",
							"taxable_amount"=> $rowH['ValCredito_FAC']
					)],*/
					"invoice_lines"=>$detalle
					);

	}	

}


//print_r($payload);exit();

$payload = json_encode($payload);
//print_r($payload);exit();
// error_log('pay: '.$payload);
// error_log('Payload : '.$_POST["factura"].': '.$payLoad);

$curl = curl_init();

//$TestSetId_sadinca="/812626b9-8779-414f-a03c-22a75dc826ae";
//$TestSetId_hid="/c91a2f28-e1a3-4586-be86-b06578eb86fc";
//$TestSetId_tecnowebs =   'cfa3b4f4-ea97-4a2e-b7d1-6506131ca8c8';
//$TestSetId_vision = '442810ba-2837-4e22-ae53-0180e6731747';
$TestSetId_sadinca="";

curl_setopt_array($curl, array(
  CURLOPT_URL => $prefixUrl.'support-document'.$TestSetId_sadinca,
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

ob_end_clean();
curl_close($curl);
echo $response;
ob_end_flush();



