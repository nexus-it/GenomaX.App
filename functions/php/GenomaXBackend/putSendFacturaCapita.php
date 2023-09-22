<?php
//var_dump($_POST);exit();
include('params.php');
include '../php/nexus/database.php';

$bearer = ValidarBearer(verficarEmpresaReg());

$conexion = mysqli_connect("localhost","root", "", "gnx_prueba");
	mysqli_query ($conexion, "SET NAMES 'utf8'");

$SQL = "Select a.Razonsocial_DCD, a.NIT_DCD, a.Direccion_DCD, a.Telefonos_DCD, a.EncabezadoFact_DCD, a.PiePaginaFact_DCD, 
 b.ConsecIni_AFC, b.ConsecFin_AFC, b.Resolucion_AFC, b.Fecha_AFC, c.Codigo_FAC, '', c.Fecha_FAC, c.ValPaciente_FAC, 
 c.ValEntidad_FAC, c.ValCredito_FAC, c.Estado_FAC, e.ID_TER,e.DigitoVerif_TER, e.Nombre_TER, e.Direccion_TER, e.Telefono_TER, e.Correo_TER, 
 '', ' * * * * * ', 'POBLACION CAPITADA - PTES. VARIOS', i.Nombre_PLA, c.Codigo_EPS, c.Codigo_PLA, adddate(c.Fecha_FAC,d.VenceFactura_EPS), d.Contrato_EPS, a.Ciudad_DCD, 'Direccion', 'Telefono', 'Barrio', 'mun', 'dx', 'ndx', Prefijo_AFC, ValCredito_FAC, f.fechaini_fac, f.FechaFin_fac  
 , SPLIT_STR(c.CODIGO_FAC, '-', 1) AS PREFIJO, SPLIT_STR(c.CODIGO_FAC, '-', 2) as NUMERACION
 From itconfig a, czautfacturacion b, gxfacturas c, gxeps d, czterceros e, gxfacturascapita f, gxplanes i
Where c.Codigo_AFC = b.Codigo_AFC and  d.Codigo_EPS= c.Codigo_EPS and e.Codigo_TER= d.Codigo_TER and f.Codigo_FAC =c.Codigo_FAC 
 and i.Codigo_PLA= c.Codigo_PLA and 
  c.Codigo_FAC = '".$_POST["factura"]."' and estado_fac = 1
  ";

/*"AND SPLIT_STR(c.CODIGO_FAC, '-', 1)  = '".trim($_GET["PREFIJO"])."'
AND (SPLIT_STR(c.CODIGO_FAC, '-', 2)  >= '".($_GET["CODIGO_INICIAL"])."'
AND SPLIT_STR(c.CODIGO_FAC, '-', 2)  <= '".($_GET["CODIGO_FINAL"])."')
";*/

//echo $SQL;



$resultH = mysqli_query($conexion, $SQL);
while ($rowH = mysqli_fetch_array($resultH)) {


	$SQL_DET="SELECT '*', a.Servicio_FAC, concat(a.FechaIni_FAC,' - ',a.FechaFin_FAC), a.Cantidad_FAC, a.ValServicio_FAC, a.ValTotal_FAC FROM  gxfacturascapita a WHERE  a.Codigo_FAC= '".$_POST["factura"]."'";
	//echo $SQL_DET;
	$result = mysqli_query($conexion, $SQL_DET);
	
	while ($row = mysqli_fetch_array($result)) {
		$detalle =array(
			"unit_measure_id"=> 70,
			"invoiced_quantity"=> "1",
			"line_extension_amount"=> $row['ValTotal_FAC'],
			"free_of_charge_indicator"=> false,
			/*"tax_totals"=> [array(
					"tax_id"=> 1,
					"tax_amount"=> "0",
					"taxable_amount"=> $row['valor'],
					"percent"=> "0"
			)
			],*/
			"description"=> $row['Servicio_FAC'],
			"notes"=> $row['Servicio_FAC'],
			"code"=> "SERVICIOS",
			"type_item_identification_id"=> 4,
			"price_amount"=> $row['ValTotal_FAC'],
			"base_quantity"=>  "1"
		);
	}

	$payload= array('number'=>$rowH['NUMERACION'],
					'type_document_id'=>1,
					'date'=>$rowH['Fecha_FAC'],
					'time'=>'00:00:00',
					'resolution_number'=>$rowH['Resolucion_AFC'],
					'prefix'=>$rowH['PREFIJO'],
					'notes'=>'factura electronica',
					'disable_confirmation_text'=>true,
					'establishment_name'=>$rowH['Razonsocial_DCD'],
					'establishment_address'=>$rowH['Direccion_DCD'],
					'establishment_phone'=>$rowH['Telefonos_DCD'],
					'establishment_municipality'=>126,
					'atacheddocument_name_prefix'=>$rowH['Codigo_FAC'],
					'establishment_email'=>"ing.leandro.castro@gmail.com",
					'sendmail'=> true,
					'sendmailtome'=> true,
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
						"payment_method_id"=> 60,
						"payment_due_date"=> $rowH['Fecha_FAC'],
						"duration_measure"=> "60"
					),
					"legal_monetary_totals"=> array(
						"line_extension_amount"=> $rowH['ValEntidad_FAC'],
						"tax_exclusive_amount"=> "0",
						"tax_inclusive_amount"=> $rowH['ValEntidad_FAC'],
						"payable_amount"=> $rowH['ValEntidad_FAC']
					),
					/*"tax_totals"=>[array( 
							"tax_id"=> "1",
							"tax_amount"=> "0",
							"percent"=> "0",
							"taxable_amount"=> $rowH['ValEntidad_FAC']
					)],*/
					"invoice_lines"=>[$detalle]
					);

}

//var_dump($payload);exit();

$payload = json_encode($payload);



$curl = curl_init();


curl_setopt_array($curl, array(
  CURLOPT_URL => $prefixUrl.'invoice/cfa3b4f4-ea97-4a2e-b7d1-6506131ca8c8',
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
    'Authorization: Bearer 5de658704d41e7f34cdb752ed5d3379301b9fabcc7604b894904b3953b1bfeec'
  ),
));

$response = curl_exec($curl);

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