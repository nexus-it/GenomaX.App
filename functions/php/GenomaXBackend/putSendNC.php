<?php
//var_dump($_POST);exit();
include('params.php');
include '../nexus/database.php';
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
mysqli_query ($conexion, "SET NAMES 'utf8'");

$SQL = "Select a.Razonsocial_DCD, a.NIT_DCD, a.Direccion_DCD, a.Telefonos_DCD, a.EncabezadoFact_DCD, a.PiePaginaFact_DCD, b.ConsecIni_AFC, b.ConsecFin_AFC, b.Resolucion_AFC, b.Fecha_AFC, c.Codigo_FAC, c.Codigo_ADM, c.Fecha_FAC, c.ValPaciente_FAC, c.ValEntidad_FAC, c.ValCredito_FAC, c.ValTotal_FAC , c.Estado_FAC, e.ID_TER,e.DigitoVerif_TER, e.Nombre_TER, e.Direccion_TER, e.Telefono_TER, e.Correo_TER, LPAD(f.Codigo_ADM,10,'0'), CONCAT(h.Sigla_TID,' ', g.ID_TER), g.Nombre_TER, i.Nombre_PLA, c.Codigo_EPS, c.Codigo_PLA, adddate(c.Fecha_FAC,d.VenceFactura_EPS), f.Autorizacion_ADM, a.Ciudad_DCD
, SPLIT_STR(c.CODIGO_FAC, '-', 1) AS PREFIJO, SPLIT_STR(c.CODIGO_FAC, '-', 2) as NUMERACION
,nc.Codigo_NCT, nc.Descripcion_NCT, date(nc.Fecha_NCT) as Fecha_NCT, time(nc.Fecha_NCT) as Time_NCT
From itconfig a, czautfacturacion b, gxfacturas c, gxeps d, czterceros e, gxadmision f, 
czterceros g, cztipoid h, gxplanes i, cznotascontablesenc nc WHERE c.Codigo_AFC = b.Codigo_AFC  and d.Codigo_EPS= c.Codigo_EPS  and e.Codigo_TER= d.Codigo_TER   and f.Codigo_ADM =c.Codigo_ADM   and g.Codigo_TER=f.Codigo_TER and h.Codigo_TID=g.Codigo_TID and i.Codigo_PLA= c.Codigo_PLA 
AND nc.NumeroDoc_NCT = c.Codigo_FAC
AND nc.Codigo_NCT='".$_POST["notacredito"]."' and estado_fac = 1
";
/*"AND SPLIT_STR(c.CODIGO_FAC, '-', 1)  = '".trim($_GET["PREFIJO"])."'
AND (SPLIT_STR(c.CODIGO_FAC, '-', 2)  >= '".($_GET["CODIGO_INICIAL"])."'
AND SPLIT_STR(c.CODIGO_FAC, '-', 2)  <= '".($_GET["CODIGO_FINAL"])."')
";*/

//echo $SQL;



$resultH = mysqli_query($conexion, $SQL);
while ($rowH = mysqli_fetch_array($resultH)) {


	$SQL_DET="SELECT c.Codigo_CFC, c.Nombre_CFC, SUM(b.Cantidad_ORD*(b.ValorPaciente_ORD+ b.ValorEntidad_ORD))  , d.Codigo_SER , d.Nombre_SER, ncd.ValorDet_NCT AS valor FROM gxordenescab a, gxordenesdet b, gxconceptosfactura c, gxservicios d, cznotascontablesdet ncd WHERE a.Codigo_ORD=b.Codigo_ORD AND c.Codigo_CFC= d.Codigo_CFC AND d.Codigo_SER=b.Codigo_SER AND a.Estado_ORD='1' AND b.Codigo_EPS='".$rowH['Codigo_EPS']."' AND b.Codigo_PLA='".$rowH['Codigo_PLA']."' AND LPAD(a.Codigo_ADM,10,'0')=LPAD('".$rowH['Codigo_ADM']."',10,'0') and ncd.Codigo_NCT='".$_POST["notacredito"]."' GROUP BY c.Codigo_CFC, c.Nombre_CFC";
	$result = mysqli_query($conexion, $SQL_DET);
	//echo $SQL_DET;
	while ($row = mysqli_fetch_array($result)) {
		$detalle =array(
					"unit_measure_id"=> 70,
					"invoiced_quantity"=> "1",
					"line_extension_amount"=> $row['valor'],
					"free_of_charge_indicator"=> false,
					/*"tax_totals": [
						{
							"tax_id": 1,
							"tax_amount": "159663.865",
							"taxable_amount": "840336.134",
							"percent": "19.00"
						}
					],*/
					"description"=> $row['Nombre_CFC'],
					"notes"=> $row['Nombre_CFC'],
					"code"=> "SERVICIOS",
					"type_item_identification_id"=> 4,
					"price_amount"=> $row['valor'],
					"base_quantity"=>  "1"
				);
	}


	$cufe = ValidarCUfe($rowH['NIT_DCD'],$rowH['PREFIJO'],$rowH['NUMERACION']);


	$payload= array("billing_reference"=> array (
			"number"=> $rowH['Codigo_FAC'],
			"uuid"=> $cufe,
			"issue_date"=> $rowH['Fecha_NCT']
	),
		"discrepancyresponsecode"=> 2,
		"discrepancyresponsedescription"=> $rowH['Descripcion_NCT'],
		"notes"=> $rowH['Descripcion_NCT'],
		"resolution_number"=> "0000000000",
		"prefix"=> "NC",
		"number"=> $rowH['Codigo_NCT'],
		"type_document_id"=> 4,
		"date"=> $rowH['Fecha_NCT'],
		"time"=> $rowH['Time_NCT'],
		"establishment_name"=> $rowH['Razonsocial_DCD'],
		"establishment_address"=>$rowH['Direccion_DCD'],
		"establishment_phone"=>$rowH['Telefonos_DCD'],
		"establishment_municipality"=> 126,
		"sendmail"=> true,
		"sendmailtome"=> true,
		"seze"=> "2021-2017",
		"head_note"=> $rowH['EncabezadoFact_DCD'],
		"foot_note"=> $rowH['PiePaginaFact_DCD'],
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
		/*"tax_totals": [
			{
				"tax_id": 1,
				"tax_amount": "159663.865",
				"percent": "19",
				"taxable_amount": "840336.134"
			}
		],*/
		"legal_monetary_totals"=> array(
			"line_extension_amount"=> $rowH['ValEntidad_FAC'],
			"tax_exclusive_amount"=> "0",
			"tax_inclusive_amount"=> $rowH['ValEntidad_FAC'],
			"payable_amount"=> $rowH['ValEntidad_FAC']
		),
		"credit_note_lines"=>[$detalle] 
		);

}

//var_dump($payload);exit();

$payload = json_encode($payload);



$curl = curl_init();


curl_setopt_array($curl, array(
  CURLOPT_URL => $prefixUrl.'credit-note/442810ba-2837-4e22-ae53-0180e6731747',
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



