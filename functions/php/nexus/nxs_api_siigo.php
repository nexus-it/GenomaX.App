<?php
	
	function AccesToken() {
		$result = explode(",",$_SESSION["SiigoToken"]);
        $Tkn=substr($result[0],17,strlen($result[0])-18);
        return $Tkn;
	}
	function createInvoice($Cadena) {
		$result=postInvoice($Cadena);
		return $result;
	}
	function createProduct($nCode, $nDesc, $nType, $nGroup, $nRef) {
		$result=findProduct($nCode);
		if ($result=="NO") {
			$creaProducto=postProduct($nCode, $nDesc, $nType, $nGroup, $nRef);
			error_log($creaProducto);
		
		}
	}
	function findProduct($nCode) {
		$respuesta="NO";
		$result = getProductsAll();
        foreach ($result as $product) {
        	if ($product['Code']==$nCode) {
        		$respuesta="SI";
        	}
        }
        return $respuesta;
	}
	function getProductsAll() {
        $url = $_SESSION["Siigourl"]."Products/GetAll?numberPage=0&namespace=v1";
        $ch = curl_init();

        $Tkn=AccesToken();
        
        $header = array(
            'Ocp-Apim-Subscription-Key: '. $_SESSION["SiigoKey"],
            'Authorization: '. $Tkn
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_ENCODING , '');
        curl_setopt($ch, CURLOPT_MAXREDIRS , 10);
        curl_setopt($ch, CURLOPT_TIMEOUT , 30);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        try
        {
            $response = curl_exec($ch);
            // error_log($response);
            $response = json_decode($response, true);
            return ($response);
        }
        catch (HttpException $ex)
        {
            echo $ex;
            return null;
        }
    }
    function getProduct($nCode) {
    	$url = $_SESSION["Siigourl"]."Products/GetAllByCode?codes=".$nCode."&namespace=v1";
        $ch = curl_init();

        $Tkn=AccesToken();
        $header = array(
            'Ocp-Apim-Subscription-Key: '. $_SESSION["SiigoKey"],
            'Authorization: '. $Tkn
        );
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_ENCODING , '');
        curl_setopt($ch, CURLOPT_MAXREDIRS , 10);
        curl_setopt($ch, CURLOPT_TIMEOUT , 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
		curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        

        try
        {
            $response = curl_exec($ch);
            curl_close($ch);
            $response = json_decode($response, true);
            return ($response);
        }
        catch (HttpException $ex)
        {
            echo $ex;
            return null;
        }
    }
    function postProduct($nCode, $nDesc, $nType, $nGroup, $nRef) {
    	if ($nType=="2") {
    		$nType="ProductType_Product";
    	} else {
    		$nType="ProductType_Service";
    	}
    	$Tkn=AccesToken();
    	$body= '{
    "Code": "'.$nCode.'",
    "Description": "'.$nDesc.'",
    "AccountGroupID":  '.$nGroup.',
    "MeasurementUnitCode": 94,
    "ProductTypeKey": "'.$nType.'",
    "ReferenceManufactures": "'.$nRef.'",
    "State": 1
}';
    	$url = $_SESSION["Siigourl"]."Products/Create?namespace=v1";
		$ch = curl_init();
		$header = array(
		'Ocp-Apim-Subscription-Key: '. $_SESSION["SiigoKey"],
		'Authorization: '. $Tkn,
		'Content-Type: application/json'
		);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_ENCODING , '');
        curl_setopt($ch, CURLOPT_MAXREDIRS , 10);
        curl_setopt($ch, CURLOPT_TIMEOUT , 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST , 'POST'); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		  $data = curl_exec($ch);
		  curl_close($ch);
		  return $data;
    }
    function postInvoice($Cadena) {
    	$Tkn=AccesToken();
    	error_log($Tkn);
    	$body= $Cadena;
    	$url = $_SESSION["Siigourl"]."Invoice/Save?namespace=v1";
		$ch = curl_init();
		$header = array(
		'Ocp-Apim-Subscription-Key: '. $_SESSION["SiigoKey"],
		'Authorization: '. $Tkn,
		'Content-Type: application/json'
		);

		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_ENCODING , '');
        curl_setopt($ch, CURLOPT_MAXREDIRS , 10);
        curl_setopt($ch, CURLOPT_TIMEOUT , 30);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
        curl_setopt($ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST , 'POST'); 
		curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
		
		  $data = curl_exec($ch);
		  curl_close($ch);
		  return $data;
    }



/*
422c570597a542d595fd222d28953fb7

eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiIsIng1dCI6ImhtMnFEV284cmlHQ0ZiZlJFSnFxdTlxZUoyOCIsImtpZCI6ImhtMnFEV284cmlHQ0ZiZlJFSnFxdTlxZUoyOCJ9.eyJpc3MiOiJodHRwczovL3NpaWdvbnViZS5zaWlnby5jb206NTAwNTAiLCJhdWQiOiJodHRwczovL3NpaWdvbnViZS5zaWlnby5jb206NTAwNTAvcmVzb3VyY2VzIiwiZXhwIjoxNjEyNTc5NzAyLCJuYmYiOjE2MTI0ODk3MDIsImNsaWVudF9pZCI6IlNpaWdvV2ViIiwic2NvcGUiOlsib2ZmbGluZV9hY2Nlc3MiLCJXZWJBcGkiXSwic3ViIjoiOTk5MDk2IiwiYXV0aF90aW1lIjoxNjEyNDg5NzAyLCJpZHAiOiJpZHNydiIsIm5hbWUiOiJJTlRFR1IwOTQ2MUBhcGlvbm1pY3Jvc29mdC5jb20iLCJtYWlsX3NpaWdvIjoiSU5URUdSMDk0NjFAYXBpb25taWNyb3NvZnQuY29tIiwiY2xvdWRfdGVuYW50X2NvbXBhbnlfa2V5IjoiSU5URUdSQUxIT01FQ0FSRVNBUyIsInVzZXJzX2lkIjoiMTA5OSIsInRlbmFudF9pZCI6IjB4MDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAwMDAzNTc0MzEiLCJ1c2VyX2xpY2Vuc2VfdHlwZSI6IjUiLCJwbGFuX3R5cGUiOiIxMiIsInRlbmFudF9zdGF0ZSI6IjEiLCJtdWx0aXRlbmFudF9pZCI6IjM1NSIsImFtciI6WyJwYXNzd29yZCJdfQ.b5MjRuy4degeTxwfwnyBk8GVpRlf6ujFY4gYE-NSvypBMa3c-Av8lpADaIDjAZ7AR7zU5nldZQphTN0GYetfTCQDlDCSiHs8cjkZiDm3Pifd5ytcKjs3SFIQD1nfYDQhd_dBEEnKUK7lNYQusNPw7sovJf5mquhlYckYizkbzFMuJXlc3ht7N83rE1ZJebCiKFqSdJLtb3O7lpaBQQgO8zGy9uSvBct28EAObcGq3y-gGWaWJt-PQOZWLD0ZE_r55-zZReynHmOI54rRGKrOAJTlLHURvLaog38E8u7ZkMtUaFJYV9jbw4Y6jmWrsEHR1PWzgoeuPAC6CLOweEuLkg
*/
?>