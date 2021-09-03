<?php
session_start();


    function getToken() {
        $SQL="Select URLToken_XFE, BodyToken_XFE, NombreClave_XFE, UserAPI_XFE, PasswAPI_XFE, ScopeToken_XFE, HeaderToken_XFE, KeyAPI_XFE, URL_XFE from itconfig_fe Where Estado_XFE='1';";
        $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
        $result = mysqli_query($conexion, $SQL);
        if($row = mysqli_fetch_row($result)) {
            $URLToken_XFE=$row[0];
            $BodyToken_XFE=$row[1];
            $BodyToken_XFE=str_replace("@NombreClave",$row[2]."%5C",$BodyToken_XFE);
            $BodyToken_XFE=str_replace("@UserAPI",$row[3],$BodyToken_XFE);
            $BodyToken_XFE=str_replace("@PaswAPI",$row[4],$BodyToken_XFE);
            $BodyToken_XFE=str_replace("@ScopeToken",$row[5],$BodyToken_XFE);
            $HeaderToken_XFE=explode(",",$row[6]);
            $_SESSION["SiigoKey"] = $row[7];
            $_SESSION["Siigourl"] = $row[8];

            $url = $URLToken_XFE;
            $body = $BodyToken_XFE;
            // error_log($body);
            // error_log($_SESSION["SiigoKey"]);
            $ch = curl_init();
            $header = array(
        $HeaderToken_XFE[0],
        $HeaderToken_XFE[1],
        $HeaderToken_XFE[2]
            );
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
            curl_setopt($ch, CURLOPT_ENCODING , '');
            curl_setopt($ch, CURLOPT_MAXREDIRS , 10);
            curl_setopt($ch, CURLOPT_TIMEOUT , 30);
            curl_setopt($ch, CURLOPT_VERBOSE, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION , true);
            curl_setopt($ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST , 'POST'); 
            curl_setopt($ch, CURLOPT_POST, 1);
            try
            {
                $response = curl_exec($ch);
                curl_close($ch);
                $response = json_decode($response);
                return $response;
            }
            catch (HttpException $ex)
            {
                echo $ex;
                return null;
            }

        } else {
            return null;
        }
        mysqli_free_result($result);

    }

    $_SESSION["SiigoToken"] = json_encode(getToken());
    
    // error_log('Token: '.$_SESSION["SiigoToken"]);

?>

