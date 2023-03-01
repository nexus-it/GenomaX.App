<?php
include 'params.php';
include 'consultas.php';
//var_dump($_POST);exit();

$string = $_POST['factura'];
		
$number = preg_replace('/[^0-9]/', '', $string);
$cadena = explode($number,$string);
$prefix = $cadena[0];

$bearer = ValidarBearer(verficarEmpresaReg());

/*
$cad = explode("-",$_POST['factura']);
$prefix = $cad[0];
$number = $cad[1];
*/



$conexion = mysqli_connect("localhost","root", "Tg@82071560763", "php_factura_shaima");
mysqli_query ($conexion, "SET NAMES 'utf8'");

$SQL = "SELECT order_id, date(order_date), time(order_date),order_resolution,order_prefix,
razon, t2.address, t2.phone, municipality_id, concat(order_prefix,'',order_id), t2.email,
encabezado_fact, pie_fact, t2.identification_number, t2.dv, razon, t2.phone, t2.address, t2.email,
merchant_registration, type_document_identification_id, type_organization_id, type_liability_id,
municipality_id, type_regime_id, date(order_date) as fecha_fact, order_total_after_tax,
order_total_tax,order_tax_per,order_total_before_tax,
order_receiver_nit,order_receiver_name,order_receiver_address,t3.phone AS phonecustomer,t3.email AS emailcustomer
FROM factura_orden t1, factura_companies t2, factura_clientes t3  where t1.user_id = t2.user_id
    AND t1.order_receiver_nit = concat(t3.identification_number,'-',t3.dv) 
    and order_prefix = '$prefix' AND order_id = '$number'
	
";

//echo $SQL;



$resultH = mysqli_query($conexion, $SQL);
while ($rowH = mysqli_fetch_array($resultH)) {


	$SQL_DET="SELECT order_item_quantity, order_item_price, order_item_iva, item_name	 FROM factura_orden_producto t1
	          WHERE order_prefix = '$prefix' AND order_id = '$number'
	";
	//echo $SQL_DET;
	$result = mysqli_query($conexion, $SQL_DET);
	

	while ($row = mysqli_fetch_array($result)) {

		if ($row['order_item_iva'] > 0){
			$tax_id = 1;
			$tax_totals = [array(
				"tax_id"=> $tax_id,
				"tax_amount"=> ($row['order_item_price']*$row['order_item_quantity'])*($row['order_item_iva']/100),
				"taxable_amount"=> $row['order_item_price']*$row['order_item_quantity'],
				"percent"=> $row['order_item_iva']			
			)];
		}else{
			$tax_id = 10;
			$tax_totals = array();
		}

		

		$detalle[] =array(
			"unit_measure_id"=> 70,
			"invoiced_quantity"=> $row['order_item_quantity'],
			"line_extension_amount"=> $row['order_item_price']*$row['order_item_quantity'],
			"free_of_charge_indicator"=> false,
			"tax_totals" => $tax_totals,
			"description"=> $row['item_name'],
			"notes"=> $row['item_name'],
			"code"=> "PRODUCTOS",
			"type_item_identification_id"=> 4,
			"price_amount"=> ($row['order_item_price'])+($row['order_item_price']*($row['order_item_iva']/100)),
			"base_quantity"=>  1
		);

		
	}

	//var_dump($detalle);exit();

    $cad = explode("-",$rowH['order_receiver_nit']);
    $order_receiver_nit = $cad[0];
    $order_receiver_nit_dv = $cad[1];

    $cad = explode("--",$rowH['order_receiver_name']);
    $order_receiver_name = $cad[1];

	$payload= array('number'=>$rowH[0],
					'type_document_id'=>1,
					'date'=>$rowH[1],
					'time'=>$rowH[2],
					'resolution_number'=>$rowH[3],
					'prefix'=>$rowH[4],
					'notes'=>'factura electronica',
					'disable_confirmation_text'=>true,
					'establishment_name'=>$rowH[5],
					'establishment_address'=>$rowH[6],
					'establishment_phone'=>$rowH[7],
					'establishment_municipality'=>$rowH[8],
					'atacheddocument_name_prefix'=>$rowH[9],
					'establishment_email'=>$rowH[10],
					'sendmail'=> false,
					'sendmailtome'=> false,
					'seze'=> "2021-2017",
					'head_note'=>$rowH[11],
					'foot_note'=> $rowH[12],
					"customer"=> array(
						"identification_number"=> $order_receiver_nit,
						"dv"=> $order_receiver_nit_dv,
						"name"=> $order_receiver_name,
						"phone"=> $rowH['phonecustomer'],
						"address"=> $rowH['order_receiver_address'],
						"email"=> $rowH['emailcustomer'],
						"merchant_registration"=> $rowH[19],
						"type_document_identification_id"=> $rowH[20],
						"type_organization_id"=> 1,  //$rowH[21],
						"type_liability_id"=> 117, ///$rowH[22],
						"municipality_id"=> 149, //$rowH[23],
						"type_regime_id"=> 1,//$rowH[24]
					),
					"payment_form"=> array(
						"payment_form_id"=> 2,
						"payment_method_id"=> 60,
						"payment_due_date"=> $rowH['fecha_fact'],
						"duration_measure"=> "60"
					),
					"legal_monetary_totals"=> array(
						"line_extension_amount"=> $rowH['order_total_before_tax'],
						"tax_exclusive_amount"=> $rowH['order_total_before_tax'],
						"tax_inclusive_amount"=> $rowH['order_total_after_tax'],
						"payable_amount"=> $rowH['order_total_after_tax']
					),
					"tax_totals"=>[array( 
							"tax_id"=> "1",
							"tax_amount"=> $rowH['order_total_tax'],
							"percent"=> $rowH['order_tax_per'],
							"taxable_amount"=> $rowH['order_total_before_tax']
					)],
					"invoice_lines"=>$detalle
					);

}

//print_r($payload);exit();

$payload = json_encode($payload);

//print_r($payload);//;exit();


$curl = curl_init();


curl_setopt_array($curl, array(
  CURLOPT_URL => $prefixUrl.'invoice',
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

$response = curl_exec($curl);

curl_close($curl);
echo $response;

?>