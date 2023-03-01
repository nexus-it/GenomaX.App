<?php
session_start();
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
        <div class="panel-group" id="nx_meet_form" role="tablist" aria-multiselectable="true">
<?php
	if ($_GET["modo"]!="hc") {
?>
  <div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#nx_meet_form" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Unirse a una sesión de Chat por Video
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="container panel-collapse collapse in " role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body row">
        <div class="col-md-12">
          <select name="cmb_nxschannels" id="cmb_nxschannels">
          <?php 
        $contachanel=0;
        $SQL="Select Codigo_MET, Fecha_MET, time(Fecha_MET) from nxs_meet where Codigo_USR='".$_SESSION["it_CodigoUSR"]."' order by 2 desc limit 3";
        $result = mysqli_query($conexion, $SQL);
        while($row = mysqli_fetch_array($result)) 
          {
            $contachanel++;
            $usr="";
         	$SQL="Select Nombre_USR from itusuarios a, nxs_meet b Where a.Codigo_USR=b.Codigo_USR and b.Codigo_MET='".$row[0]."' and Ingreso_MET='1'";
         	$results = mysqli_query($conexion, $SQL);
         	if ($rows = mysqli_fetch_array($results)) {
         		$usr=$rows[0];
         	}
         	mysqli_free_result($results); 
         ?>
          <option value="<?php echo $row[0]; ?>"><?php echo $row[0]." Creada por ".$usr." a las ".$row[2]; ?></option>
        <?php
          }
        mysqli_free_result($result); 
        if ($contachanel==0) {
         ?>
         <option value="- -">No se encuentran sesiones creadas para participar</option>
         <?php
        }
         ?>  
          </select>
        </div>
        <div class="col-md-12">
        <button type="button" class="btn btn-success btn-sm btn-block" data-dismiss="modal" onclick="nxs_meeting('1')">Unirse <span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> </button> 
        </div>
      </div>
    </div>
  </div>
<?php
		$xpand="false";
		$In="";
		$SessionChat="GenomaX".strtoupper($_SESSION["DB_SUFFIX"])."n".date("y")."e".date("w")."x".date("z")."u".date("H")."s".date("i")."i".date("s")."t".$_SESSION["it_CodigoUSR"];
		$Klass='class="collapsed"';
	} else {
		$xpand="true";
		$SessionChat="GenomaX".strtoupper($_SESSION["DB_SUFFIX"])."HCn".date("y")."e".date("w")."x".date("z")."u".date("H")."s".date("i")."i".date("s")."t".$_SESSION["it_CodigoUSR"];
		$Klass='';
		$In="in";
	}
	$MeetURL="http://meet.nexus-it.co/?channel=".$SessionChat;
?>
  <div class="panel panel-primary">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a <?php echo $Klass; ?> role="button" data-toggle="collapse" data-parent="#nx_meet_form" href="#collapseTwo" aria-expanded="<?php echo $xpand; ?>" aria-controls="collapseTwo">
          Iniciar una nueva Video Conferencia Segura
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="container panel-collapse collapse <?php echo $In; ?>" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="<?php echo $xpand; ?>">
      <div class="panel-body row">
        <div class="input-group col-md-12">
          <span class="input-group-addon" id="basic-addon1"> <span class="glyphicon glyphicon-link" aria-hidden="true"></span> </span>
          <input type="text" class="form-control" placeholder="Username" aria-describedby="basic-addon1" disabled="disabled" value="<?php echo $MeetURL; ?>" style="text-transform: none;">
        </div>
        <p><em>Puede invitar a otras personas a través del enlace generado, o usar las siguientes opciones:</em></p>
        <div class="input-group col-md-12">
          <span class="input-group-addon" id="basic-addon1"> <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> </span>
          <input type="text" class="form-control" placeholder="Escriba los correos electrónicos separados por comas" aria-describedby="basic-addon1"  style="text-transform: none;" id="targetnxsmeet" name="targetnxsmeet">
        </div>
        <p>O seleccione los usuarios participantes</p>
          <div id="zero_detallemeet" class="detalleord table-responsive col-md-12">
      <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallemeet" >
      <tbody id="tbDetallemeet">
      <tr id="trh0meet"> 
        <th id="th1meet" width="32"> <span class="glyphicon glyphicon-check" aria-hidden="true"></span> </th> 
        <th id="th2meet" width="60%">Usuario</th> 
          <th id="th2meet">Perfil</th> 
      </tr> 
         <?php 
        $SQL="SELECT a.Nombre_USR, b.Nombre_PRF, a.Codigo_USR FROM itusuarios a, itperfiles b WHERE a.Codigo_PRF=b.Codigo_PRF and a.Activo_USR='1' AND a.Codigo_USR>'1' AND a.Codigo_USR<> '".$_SESSION["it_CodigoUSR"]."' ORDER BY 1";
        $resultmeet = mysqli_query($conexion, $SQL);
        $contarow=0;
        // echo $SQL;
        while($rowmeet = mysqli_fetch_array($resultmeet)) 
          {
            $contarow=$contarow+1;
            echo '
          <tr><td align="center"><input name="hdn_usrmeet'.$contarow.'" type="hidden" id="hdn_usrmeet'.$contarow.'" value="0" /><div class="checkbox checkbox-success" style="margin-top: 1px; margin-bottom: 1px;"><input name="chk_usrmeetok'.$contarow.'" id="chk_usrmeetok'.$contarow.'" type="checkbox" value=""  onclick="javascript:Okmeet(\''.$contarow.'\');" class="styled"><label for="chk_usrmeetok'.$contarow.'"></label></div><input name="hdn_meett'.$contarow.'" type="hidden" id="hdn_meett'.$contarow.'" value="'.$rowmeet[2].'" /></td><td align="left">'.$rowmeet[0].'</td><td align="left">'.$rowmeet[1].'</td></tr>
          ';
          }
        mysqli_free_result($resultmeet); 
         ?>  

      </tbody>
      </table><input name="hdn_controwmeet" type="hidden" id="hdn_controwmeet" value="<?php echo $contarow; ?>" />
          </div>
          <div class="col-md-12">
        	<button type="button" class="btn btn-success btn-sm btn-block" data-dismiss="modal" onclick="nxs_meeting('0')">Iniciar <span class="glyphicon glyphicon-new-window" aria-hidden="true"></span> </button> 
          </div>
        </div>
        
      </div>
    
  </div>
  </div>

<script >
function nxs_meeting(tipo) {
	if(tipo=="1") {
		channel=document.getElementById('cmb_nxschannels').value;
	} else {
		channel='<?php echo $SessionChat; ?>';
		nxs_meet_mail(channel);
		nxs_mmet_users(channel);
	}
	if (channel!="- -") {
		nxs_meet2(channel);
	} else {
		MsgBox1('NEXUS.Meet', 'No hay canal disponible para unirse. Si lo desea, puede iniciar una nueva video conferencia segura.');
	}
}

function nxs_meet_mail(channel) {
	losdestinatarios=document.getElementById('targetnxsmeet').value;
	if (losdestinatarios.indexOf("@")>2) {
		eltitulo="GenomaX - Usted ha sido invitado a una Video Conferencia";
		elmensaje='<p>Saludos,<br><br>Para conectarse a nuestro chat de video seguro, se ha habilitado el canal <b><a href="http://meet.nexus-it.co/?channel='+channel+'" style="color:#3C763C; text-decoration: none;">'+channel+'</a></b>.</p><p>Si el enlace no funciona, puede copiar y pegar en su navegador la siguiente dirección:<br><em>http://meet.nexus-it.co/?channel='+channel+'</em></p><p> <br>Cordialmente, <br><br><b><? echo $_SESSION["it_NombreUSR"]; ?></b></p>';
		$.ajax({  
		  type: "POST",  
		  url: "functions/php/nexus/sendmail.php",  
		  data: "tipo=notificaciones&losdestinatarios="+losdestinatarios+"&eltitulo="+eltitulo+"&elmensaje="+elmensaje,  
		  success: function(respuesta) { 
			//alert (respuesta.indexOf("message_ok"));
		  	MsgBox1("Envío de correos", respuesta); 
		  }  
		});  
		return false;  
	}
}

function nxs_mmet_users(channel) {
	uxuarios="";
	totalux=document.getElementById('hdn_controwmeet').value;
	conta=0;
	while (conta<totalux) {
		conta++;
		if (document.getElementById('hdn_usrmeet'+conta).value=="1") {
			uxuarios=uxuarios+document.getElementById('hdn_meett'+conta).value+', ';
		}
	}
	if ('<? echo $_SESSION["it_CodigoUSR"]; ?>'!='0') {
		uxuarios=uxuarios+'0';
	} else {
		uxuarios=uxuarios+'X';
	}
	$.ajax({  
	  type: "POST",  
	  url: "functions/php/transactions/nxs.meet.php",  
	  data: "channel="+channel+"&uxuarios="+uxuarios,  
	  success: function(respuesta) { 
		//alert (respuesta.indexOf("message_ok"));
	  	MsgBox1("NEXUS.Meet", "Usuarios invitados."+respuesta); 
	  }  
	});  
	return false;  
}

function Okmeet(fila) {
	if (document.getElementById('hdn_usrmeet'+fila).value=="1") {
		document.getElementById('hdn_usrmeet'+fila).value='0';
	} else {
		document.getElementById('hdn_usrmeet'+fila).value='1';
	}
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");


</script>
