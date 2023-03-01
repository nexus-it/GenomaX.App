<?php	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form  method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" action="functions/php/nexus/upld.php?xwindow=<?php echo $NumWindow; ?>&class=terceros&style=profile&wind=" ENCTYPE='multipart/form-data' >
	<div class="row">
    <input name="nxs_filez" type="file" class="input_file_upload" id="nxs_filez" size="1" accept="image/x-png, image/gif, image/jpeg" style="width: 1px; height: 1px;">
    <div id="div_preupload2" class="preuploadx" style="visibility:hidden"></div>

    <input type='hidden' name='imagen' id='imagen' />

	  <div class="col-md-9" id="divxs" style="height: 70%">
      <canvas id="canvaxs" >
        <p>Su navegador no soporta canvas</p>
      </canvas>
		</div>
    <div class="col-md-3 btn-group-vertical" role="group" aria-label="...">
      <div class="btn-group" role="group"> 
        <button type="button" class="btn btn-primary"  onclick="nxs_filez.click();" title="Abrir desde archivo"> <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></button>
      </div>
      <div class="btn-group" role="group">
        <button type="button" class="btn btn-danger" title="Borrar" id="btn_clearimg" onclick='LimpiarTrazado()'> <span class="glyphicon glyphicon-erase" aria-hidden="true"></button>
      </div>
      <div class="btn-group" role="group">
        <button type="button" class="btn btn-success" title="Aceptar" id="btn_saveimg" onclick='GuardarTrazado()'> <span class="glyphicon glyphicon-ok-circle" aria-hidden="true"></button>
      </div>
    </div>
 
  </div>

</form>

<script >
/*
    var idCanvas='canvaxs';
    var idForm='formCanvas';
    var inputImagen='imagen';
    var estiloDelCursor='crosshair';
    var colorDelTrazo='#555';
    var colorDeFondo='#fff';
    var grosorDelTrazo=2;

    // Variables necesarias 
    var ctx=null;
    var valX=0;
    var valY=0;
    var flag=false;
    var imagen=document.getElementById(inputImagen); 
    var anchoCanvas=document.getElementById(idCanvas).offsetWidth;
    var altoCanvas=document.getElementById(idCanvas).offsetHeight;
    var canvas=document.getElementById(idCanvas);

    var X,Y,W,H,r; 
          
    // canvas.height = 400; 
    // canvas.width = 800;
    
    // Esperamos el evento load 
    window.addEventListener('load',IniciarDibujo,false);


  function IniciarDibujo(){ 
     // Creamos la pizarra 
    canvas.style.cursor=estiloDelCursor;
    ctx=canvas.getContext('2d');
    ctx.fillStyle=colorDeFondo;
    ctx.fillRect(0,0,anchoCanvas,altoCanvas);
    ctx.strokeStyle=colorDelTrazo;
    ctx.lineWidth=grosorDelTrazo;
    ctx.lineJoin='round';
    ctx.lineCap='round';
    // Capturamos los diferentes eventos 
    canvas.addEventListener('mousedown',MouseDown,false);// Click pc
    canvas.addEventListener('mouseup',MouseUp,false);// fin click pc
    canvas.addEventListener('mousemove',MouseMove,false);// arrastrar pc

    canvas.addEventListener('touchstart',TouchStart,false);// tocar pantalla tactil
    canvas.addEventListener('touchmove',TouchMove,false);// arrastras pantalla tactil
    canvas.addEventListener('touchend',TouchEnd,false);// fin tocar pantalla dentro de la pizarra
    canvas.addEventListener('touchleave',TouchEnd,false);// fin tocar pantalla fuera de la pizarra
  
  <?php
    $RutaImage='../../files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/session/';
    $urly= explode('application/forms/nxs_canvas.php', $_SERVER['REQUEST_URI'], 2);
    $RutaImage0='http://'.$_SERVER["SERVER_NAME"] .$urly[0].'files/'.$_SESSION["DB_SUFFIX"].'/images/firmas/session/';
    $filepath = $RutaImage.session_id().".jpg"; // or image.jpg
    $filepath0 = $RutaImage0.session_id().".jpg"; // or image.jpg
    if(is_file($filepath)) {
     echo "
     console.log('Existe un archivo en ".$filepath."...');
     var imgsession = new Image();
     imgsession.src = '".$filepath0."';
     imgsession.onload = function(){
      ctx.drawImage(imgsession, 0, 0, 300, 180);
     }
     ";
    }
  ?>
  }

  function Resixe() {
    if (ctx) {
     var s = getComputedStyle(canvas);
     var w = s.width;
     var h = s.height;
        
     W = canvas.width = w.split("px")[0];
     H = canvas.height = h.split("px")[0];
     
     X = Math.floor(W/2);
     Y = Math.floor(H/2);
     r = Math.floor(W/3);

    }
  }

  function MouseDown(e){
      flag=true;
      ctx.beginPath();
      valX=e.pageX-posicionX(canvas); valY=e.pageY-posicionY(canvas);
      ctx.moveTo(valX,valY);
    }

    function MouseUp(e){
      ctx.closePath();
      flag=false;
    }

    function MouseMove(e){
      if(flag){
        ctx.beginPath();
        ctx.moveTo(valX,valY);
        valX=e.pageX-posicionX(canvas); valY=e.pageY-posicionY(canvas);
        ctx.lineTo(valX,valY);
        ctx.closePath();
        ctx.stroke();
      }
    }

    function TouchMove(e){
      e.preventDefault();
      if (e.targetTouches.length == 1) { 
        var touch = e.targetTouches[0]; 
        MouseMove(touch);
      }
    }

    function TouchStart(e){
      if (e.targetTouches.length == 1) { 
        var touch = e.targetTouches[0]; 
        MouseDown(touch);
      }
    }

    function TouchEnd(e){
      if (e.targetTouches.length == 1) { 
        var touch = e.targetTouches[0]; 
        MouseUp(touch);
      }
    }

    function posicionY(obj) {
      var valor = obj.offsetTop;
      if (obj.offsetParent) valor += posicionY(obj.offsetParent);
      return valor;
    }

    function posicionX(obj) {
      var valor = obj.offsetLeft;
      if (obj.offsetParent) valor += posicionX(obj.offsetParent);
      return valor;
    }

    // Limpiar pizarra 
    function LimpiarTrazado(){
      ctx=document.getElementById(idCanvas).getContext('2d');
      ctx.fillStyle=colorDeFondo;
      ctx.fillRect(0,0,anchoCanvas,altoCanvas);
    }

    // Enviar el trazado 
    function GuardarTrazado(){
      var image = canvas.toDataURL(); //image/png.....

      $.ajax({
        url:"functions/php/nexus/nxsupld.php",
        // Enviar un parámetro post con el nombre base64 y con la imagen en el
        data:{
            base64: image
        },
        // Método POST
        type:"post",
        complete:function(){
          var ImgOrigen = document.getElementById('<?php echo $_GET["nxstrgt"]; ?>');
          ImgOrigen.style.backgroundImage="files/<?php echo $_SESSION["DB_SUFFIX"]; ?>/images/firmas/<?php echo session_id(); ?>.jpg";
          MsgBox1("Edición de imágenes", "Imagen almacenada temporalmente. Si no la va a modificar, cierre el editor y continúe con el formulario.");
            console.log("Todo en orden");
        }
      });
    }

function dibujarEnElCanvas(ctx){
  ctx.strokeStyle = "#006400";
  ctx.fillStyle = "#6ab155";
  ctx.lineWidth = 5;
  ctx.arc(X,Y,r,0,2*Math.PI);
  ctx.fill();
  ctx.stroke();
}
        

setTimeout(function() {
  IniciarDibujo();
  //addEventListener("resize", Resixe);
  }, 10);
*/

function mostrarImagen(input) {
 if (input.files && input.files[0]) {
  var reader = new FileReader();
  reader.onload = function (e) {
   $('#canvaxs').attr('src', e.target.result);
  }
  reader.readAsDataURL(input.files[0]);
 }
}

$("#nxs_filez").change(function(){
 mostrarImagen(this);
});
    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    
	$("input[type=text]").addClass("md_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("md_<?php echo $NumWindow; ?>");
	$("textarea").addClass("md_<?php echo $NumWindow; ?>");
	$("select").addClass("md_<?php echo $NumWindow; ?>");

</script>
