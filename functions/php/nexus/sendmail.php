<?php
    session_start();
    include 'database.php';
    include 'auditoria.php';
    $Tipo=$_POST["tipo"];
    $conexion=Conexion();
    $MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
    mysqli_query($conexion, $MyZone);
    $SQL="Select Username_EML, Password_EML, Usermail_EML, NameMail_EML, Host_EML, Port_EML, SMTPSecure_EML, Mailer_EML from nxs_mail Where Codigo_EML='".$Tipo."'";
    $result = mysqli_query($conexion, $SQL);
    while($row = mysqli_fetch_row($result)) {
        $Username_EML=$row[0];
        $Password_EML=$row[1];
        $Usermail_EML=$row[2];
        $NameMail_EML=$row[3];
        $Host_EML=$row[4];
        $Port_EML=$row[5];
        $SMTPSecure_EML=$row[6];
        $Mailer_EML=$row[7];
    } 
    mysqli_free_result($result);
    require_once ('phpmailer/class.phpmailer.php');
    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->SMTPDebug = 0;
    $mail->SMTPAuth = TRUE;

    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    
    $mail->Port = $Port_EML;
    
    $mail->Username = $Username_EML;
    $mail->Password = $Password_EML;
    
    $mail->Mailer = $Mailer_EML;
    
    if (isset($_POST["eltitulo"])) {
        $subject = $_POST["eltitulo"];
    }
    if (isset($_POST["elmensaje"])) {
        $message ='<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>'.$subject.'</title>
  </head>
<body style="color:#3C763C; font-family: Arial;">
<table width="100%" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td height="70px" align="right" valign="middle" style="background-position:middle center; background-repeat:no-repeat; background-color:#3C763C; background-image:url(http://meet.nexus-it.co/img/titgenomax_45.png)">
    </td>
  </tr>
  <tr>
    <td style="border-top:thin; border-top-color:#063"><h3 style="color:#073; font-family:Verdana, Geneva, sans-serif; text-shadow:3px 3px 4px rgba( 10, 10, 10, 0.4 )">'.$subject.'</h3></td>
  </tr>
  <tr>
    <td style="color:#333; font-family:\'Helvetica Neue\',Helvetica,Arial,sans-serif; font-size:14px"><p>
    '.$_POST["elmensaje"].'
    </p>
  </tr>
  <tr>
    <td height="45" align="left" valign="middle" style="color:#FFFFFF; background-position:center right; background-repeat:no-repeat; background-color:#3C763C; background-image:url(http://meet.nexus-it.co/img/nexus.meet.back.jpg)">
      <small>
      <em>Powered By:</em>
          <a href="http://nexus-it.co" style="color:#FFFFFF; text-decoration: none;"><b>          :: NEXUS-IT.co ::    </b></a>
      </small>
    </td>
  </tr>
</table>
</body>
</html>';
    }
    $mail->SetFrom($Usermail_EML, $NameMail_EML);
    $mail->AddReplyTo($Usermail_EML, $NameMail_EML);
    $mail->AddAddress($_POST["losdestinatarios"]); // set recipient email address
    
    $mail->Subject = $subject;
    $mail->WordWrap = 80;
    $mail->MsgHTML($message);
    
    $mail->IsHTML(true);
    
    $mail->SMTPSecure = $SMTPSecure_EML;
    $mail->Host = $Host_EML;
    
    /* //Archivos adjuntos
    if (! empty($_FILES['attachment'])) {
        $count = count($_FILES['attachment']['name']);
        if ($count > 0) {
            // Attaching multiple files with the email
            for ($i = 0; $i < $count; $i ++) {
                if (! empty($_FILES["attachment"]["name"])) {
                    
                    $tempFileName = $_FILES["attachment"]["tmp_name"][$i];
                    $fileName = $_FILES["attachment"]["name"][$i];
                    $mail->AddAttachment($tempFileName, $fileName);
                }
            }
        }
    }
    */
    if (! $mail->Send()) {
        $MSG = "Problemas al enviar correo";
        $type = "error";
    } else {
        $MSG = "Mail Enviado correctamente";
        $type = "success";
    }
    it_aud('1', 'eMail', $type.'- '.$subject.' - '.$_POST["losdestinatarios"]);
    echo $MSG;
 