<?php
	$NumWindow="zWind_0";	

	session_start();	
	include '../../functions/php/nexus/database.php';		
?>
<form action="" method="post" name="frm_login<?php echo $NumWindow; ?>" id="frm_login<?php echo $NumWindow; ?>" class="form-horizontal container">
<div id="dialog-form" class="row well well-sm" style="margin-bottom: 1px;">
	  
<div class="col-sm-7">
	<div class="form-group"> 
		<label for="txt_clave<?php echo $NumWindow; ?>">Contraseña Actual:</label>
		<input name="txt_clave<?php echo $NumWindow; ?>" type="password" id="txt_clave<?php echo $NumWindow; ?>" onblur="javascript:pw<?php echo $NumWindow; ?>_actual();" />
    	<input type="hidden" name="hdn_clavex<?php echo $NumWindow; ?>" id="hdn_clavex<?php echo $NumWindow; ?>" />
    </div>
</div>

<div id="pw_actual<?php echo $NumWindow; ?>" class="col-sm-5 label" title="Digite su clave">
		<span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span>
</div>

<div class="col-sm-7">
	<div class="form-group"> 
		<label for="txt_pass<?php echo $NumWindow; ?>">Nueva Contraseña:</label>
		<input name="txt_pass<?php echo $NumWindow; ?>" type="password"  id="txt_pass<?php echo $NumWindow; ?>" value=""   onkeyup="javascript:pw<?php echo $NumWindow; ?>_secure();" /> 
	   	<input type="hidden" name="hdn_passx<?php echo $NumWindow; ?>" id="hdn_passx<?php echo $NumWindow; ?>" />
	</div>
</div>   

<div id="pw_secure<?php echo $NumWindow; ?>" class="col-sm-5 label" title="Nivel de seguridad de la contraseña">
	NIVEL
</div>
  
<div class="col-sm-7">
	<div class="form-group"> 
    	<label for="txt_pass2<?php echo $NumWindow; ?>">Confirme Nueva:</label>
    	<input name="txt_pass2<?php echo $NumWindow; ?>" type="password"  id="txt_pass2<?php echo $NumWindow; ?>" value=""   onkeyup="javascript:pw<?php echo $NumWindow; ?>_same();"/>
    	<input type="hidden" name="hdn_pass2x<?php echo $NumWindow; ?>" id="hdn_pass2x<?php echo $NumWindow; ?>" />
    </div>
</div> 

<div id="pw_igual<?php echo $NumWindow; ?>" class="col-sm-5 label" title="Confirmación nueva contraseña">
	CONFIRMACION
</div>
  
</div>
</form>
<script>
$(":input:text:visible:first", "#frm_login").focus();
function PassCoDe()
{
	document.frm_login<?php echo $NumWindow; ?>.hdn_clavex<?php echo $NumWindow; ?>.value=hex_md5(document.getElementById("txt_clave<?php echo $NumWindow; ?>").value);
	document.frm_login<?php echo $NumWindow; ?>.hdn_passx<?php echo $NumWindow; ?>.value=hex_md5(document.getElementById('txt_pass<?php echo $NumWindow; ?>').value);
	document.frm_login<?php echo $NumWindow; ?>.hdn_pass2x<?php echo $NumWindow; ?>.value=hex_md5(document.getElementById('txt_pass2<?php echo $NumWindow; ?>').value);
	AcceptPass('<?php echo $NumWindow; ?>');
}
<?php 
	$PassMin=4;
	$SQL="Select PassMin_DCD from itconfig;";
	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");		
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_row($result)) {
		$PassMin=$row[0];
	}
	mysqli_free_result($result);
?>
  pw_min = <?php echo $PassMin; ?>; // caracteres minimos para validar
  pw_max = 25; // caracteres maximos para validar
  pw_validate = /^[a-z0-9]+$/i; // regexp para validar password
  
function pw<?php echo $NumWindow; ?>_actual() {
	TextoPassX=document.getElementById("txt_clave<?php echo $NumWindow; ?>").value;
	var ObjetoX=document.getElementById("pw_actual<?php echo $NumWindow; ?>");
	ObjetoX.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/loading.gif)";
	if (TextoPassX!="") {
		ComprobarClave('<?php echo $NumWindow; ?>',TextoPassX, '<?php echo $_SESSION["THEME_DEFAULT"]; ?>')
	}
	else
	{
		ObjetoX.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_titit.png)";
		ObjetoX.style.borderColor="#6CF";		
		ObjetoX.innerHTML=' <span class="glyphicon glyphicon-circle-arrow-left" aria-hidden="true"></span> ';
		ObjetoX.style.color="#333";
	}
}

function pw<?php echo $NumWindow; ?>_same() {
	TextoPass1=document.getElementById("txt_pass<?php echo $NumWindow; ?>").value;
	TextoPass2=document.getElementById("txt_pass2<?php echo $NumWindow; ?>").value;
	var ObjetoX=document.getElementById("pw_igual<?php echo $NumWindow; ?>");
	ObjetoX.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/loading.gif)";
	if (TextoPass2!="") {
		if (TextoPass1==TextoPass2) {
			ObjetoX.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_green.png)";
			ObjetoX.style.borderColor="#006600";		
			ObjetoX.innerHTML="IDENTICAS";	
		}
		else
		{
			ObjetoX.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_red.png)";
			ObjetoX.style.borderColor="#990000";	
			ObjetoX.innerHTML="DIFERENTES"	
		}
		ObjetoX.style.color=ObjetoX.style.borderColor;
	}
	else
	{
		ObjetoX.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_titit.png)";
		ObjetoX.style.borderColor="#6CF";		
		ObjetoX.innerHTML="CONFIRMACION";
		ObjetoX.style.color="#333";
	}
}

function pw<?php echo $NumWindow; ?>_secure() {
	TextoPass=document.getElementById("txt_pass<?php echo $NumWindow; ?>").value;
	var Objeto=document.getElementById("pw_secure<?php echo $NumWindow; ?>");
	Objeto.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/loading.gif)";
	if (TextoPass!="") {
		if (TextoPass.length < pw_min || TextoPass.length > pw_max)
		{
			Objeto.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_red.png)";
			Objeto.style.borderColor="#990000";	
			Objeto.innerHTML="INVALIDA"	
		}
		else if (!pw_validate.test(TextoPass))
		{
			Objeto.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_red.png)";
			Objeto.style.borderColor="#990000";		
			Objeto.innerHTML="INVALIDA";	
		}
		else if (TextoPass.toLowerCase() == TextoPass || TextoPass.toUpperCase() == TextoPass) 
		{
			Objeto.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_yellow.png)";
			Objeto.style.borderColor="#CC9900";		
			Objeto.innerHTML="INSEGURA";	
		}
		else if (/^[a-z]+$/i.test(TextoPass) || /^[0-9]+$/i.test(TextoPass)) 
		{
			Objeto.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_yellow.png)";
			Objeto.style.borderColor="#CC9900";		
			Objeto.innerHTML="INSEGURA";	
		}
		else 
		{
			Objeto.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_green.png)";
			Objeto.style.borderColor="#006600";		
			Objeto.innerHTML="SEGURA";	
		}
		Objeto.style.color=Objeto.style.borderColor;
	} else {
		Objeto.style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_titit.png)";
		Objeto.style.borderColor="#6CF";		
		Objeto.innerHTML="NIVEL";
		Objeto.style.color="#333";		
	}
	pw<?php echo $NumWindow; ?>_same();
   }

   document.getElementById("pw_secure<?php echo $NumWindow; ?>").style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_titit.png)";
   document.getElementById("pw_igual<?php echo $NumWindow; ?>").style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_titit.png)";
   document.getElementById("pw_actual<?php echo $NumWindow; ?>").style.backgroundImage="url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/pw_titit.png)";

  	$("input[type=text]").addClass("form-control");
  	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");


</script>
