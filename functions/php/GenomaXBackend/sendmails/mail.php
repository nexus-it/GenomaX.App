<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';
//include '../../nexus/database.php';




function send($recipiente,$factura,$datosEnvioMail){
        //Instantiation and passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
            $mail->SMTPDebug = 0;//SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'genomax.app';//'mail.genomax.co';                     //Set the SMTP server to send through
            $mail->Host       = 'servieslat.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            
            $mail->Username   = 'facturacion@genomax.app';                    //SMTP username
            $mail->Username   = 'fe@servieslat.com'; 

            
            $mail->Password   = 'Genomax2019*';                               //SMTP password
            $mail->Password   = 'Tg@820715';
          
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; //PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $mail->Port       = 465;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

            //Remitente
            $mail->setFrom('fe@servieslat.com','Tu factura se encuentra lista');
           //Destinatario
            $mail->addAddress($recipiente);     //Add a recipient

            //Attachments esta es la parte de los adjuntos
            //$mail->addAttachment('/var/www/html/createZipFiles/z0900581036000210000'.$factura.'.zip');         //Add attachments
            //$mail->addAttachment('https://backend.estrateg.com/API/storage/app/public/901508950/FES-'.$factura.'.zip');         //Add attachments

            //$mail->addAttachment(dirname(__DIR__,2).'\GenomaXBackend\sendmails\archivos\FES-'.$factura.'.pdf', $factura.'.pdf'); 
            //$mail->addAttachment(dirname(__DIR__,2).'\GenomaXBackend\sendmails\archivos\FES-'.$factura.'.xml', $factura.'.xml');    //Optional name
            //$mail->addAttachment(dirname(__DIR__,2).'\GenomaXBackend\sendmails\archivos\FES-'.$factura.'.zip', $factura.'.zip');    //Optional name
            $mail->addAttachment('archivos/FES-'.$factura.'.zip', $factura.'.zip');    //Optional name
               //Optional name

	    $nit = explode("-",$datosEnvioMail[0]);//aqui separao el nit del dv
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $nit[0].';'.$datosEnvioMail[1].';'.$factura.';01;'.$datosEnvioMail[1];
            $mail->Body    = '<p>Estimado usuario, adjunto en este e-mail encontrará el detalle de tu factura </p><p>Atentamente,</p><p>'.$datosEnvioMail[1].'</p>';
           

          if ($mail->send()) {
              echo 'Message has been sent';
              actualizarEstadoEnvioFact($factura, true); // Actualiza el estado de envío a true o éxito
          } else {
              echo 'Message could not be sent. Mailer Error: ' . $mail->ErrorInfo;
              actualizarEstadoEnvioFact($factura, false); // Actualiza el estado de envío a false o error
          }
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
}        

/*
//$indice=8572;
//while($indice<=8700){


$indice='SETP990000003';
while($indice<='SETP990000003'){
  send('ing.leandro.castro@gmail.com',$indice);
  $indice++;
}
*/
?>

