<?php
	
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal container">

<input type="hidden" name="hdn_bodega<?php echo $NumWindow; ?>" id="hdn_bodega<?php echo $NumWindow; ?>" value="<?php echo $_GET["bodega"]; ?>">

    <label class="label label-success " > <span class="glyphicon glyphicon-user" aria-hidden="true" ></span> Usuarios Con Permiso a la Bodega</label>
   <div class="row well well-sm">
  <div class="col-md-10">
  <div class="form-group">
    <label for="txt_usuario<?php echo $NumWindow; ?>">Nombre Usuario</label>
    <input name="txt_usuario<?php echo $NumWindow; ?>" type="text" id="txt_usuario<?php echo $NumWindow; ?>" placeholder="Ingrese las palabras clave para la búsqueda" class="typeahead" />
    <input name="hdn_codigo<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigo<?php echo $NumWindow; ?>">
  </div>
    </div>

    <div class="col-md-2 ">
      <button class="btn btn-success btn-md btn-block" type="button" onclick="javascript:AddUsrBdg<?php echo $NumWindow; ?>();" style="height: 35px; margin-top: 25px;margin-left: 15px;"> <span class="glyphicon glyphicon-user" aria-hidden="true" ></span>  Agregar Usuario
      </button>
    </div>


    <div class="table-responsive detalleord col-md-12" >
      <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="table table-striped table-condensed tblDetalle table-bordered" id="tblliqadm<?php echo $NumWindow; ?>" name="tblliqadm<?php echo $NumWindow; ?>">
        <tbody style="font-size: 12px;" id="tblbdgusr<?php echo $NumWindow; ?>">
          <tr><th >USUARIO</th><th >ELIMINAR</th></tr>
          <?php 
          $SQL="Select a.Codigo_USR, Nombre_USR from itusuariosbodegas a, itusuarios b Where a.Codigo_USR=b.Codigo_USR and a.Codigo_BDG='".$_GET["bodega"]."' Order By 1";
          $result = mysqli_query($conexion, $SQL);
          $contabdg=0;
          while($row = mysqli_fetch_array($result)) 
            {
              $contabdg++;
              echo '<tr id="trladm'.$contabdg.$NumWindow.'">
                <td><input name="hdn_codusr'.$contabdg.$NumWindow.'" type="hidden" id="hdn_codusr'.$contabdg.$NumWindow.'" value="'.$row[0].'" /> '.$row[1].'</td><td align="center"><button class="btn btn-danger btn-xs" type="button" onclick="javascript:DelUserBDG'.$NumWindow.'(\''.$contabdg.'\');" > <span class="glyphicon glyphicon-remove" aria-hidden="true" ></span>       </button></td>
                </tr>';
            }
            mysqli_free_result($result);
          ?>
        </tbody>
      </table>
      <input name="hdn_controwusr<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwusr<?php echo $NumWindow; ?>" value="<?php echo $contabdg; ?>">
    </div>

  </div> 

</div>

</form>

<script >

function DelUserBDG<?php echo $NumWindow; ?>(Numero) {
  var miTabla = document.getElementById("tblDetalle<?php echo $NumWindow; ?>");     
    $('#trladm'+Numero+"<?php echo $NumWindow; ?>").remove();
    Guardar_bodegausers('<?php echo $NumWindow; ?>'); 
}

function AddUsrBdg<?php echo $NumWindow; ?>() {
CodigoUSR=document.getElementById('hdn_codigo<?php echo $NumWindow; ?>').value;
NombreUSR=document.getElementById('txt_usuario<?php echo $NumWindow; ?>').value;
  if (CodigoUSR=="0"){
    MsgBox1("Verifique Usuario", "Usuario No se encuentra");
  } else {
    TotalFilas=document.getElementById("hdn_controwusr<?php echo $NumWindow; ?>").value;
    var miTabla = document.getElementById("tblbdgusr<?php echo $NumWindow; ?>"); 
    var fila = document.createElement("tr"); 
    var celda1 = document.createElement("td"); 
    var celda2 = document.createElement("td"); 
    TotalFilas++;
  fila.id="trladm"+TotalFilas+"<?php echo $NumWindow; ?>";
  celda1.innerHTML = '<input name="hdn_codusr'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codusr'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodigoUSR+'" /> '+NombreUSR; 
  celda2.innerHTML = '<button class="btn btn-danger btn-xs" type="button" onclick="javascript:DelUserBDG<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" > <span class="glyphicon glyphicon-remove" aria-hidden="true" ></span> </button>'; 
  fila.appendChild(celda1); 
  fila.appendChild(celda2); 
  miTabla.appendChild(fila); 
  document.getElementById('txt_usuario<?php echo $NumWindow; ?>').value="";
  document.getElementById('hdn_codigo<?php echo $NumWindow; ?>').value="0";
  document.getElementById("hdn_controwusr<?php echo $NumWindow; ?>").value=TotalFilas;
  Guardar_bodegausers('<?php echo $NumWindow; ?>'); 
  document.getElementById('txt_usuario<?php echo $NumWindow; ?>').focus();
  }
}

var substringMatcherx = function(strs) {
  return function findMatchesx(q, cb) {
    var matches, substringRegex;
    matches = [];
    substrRegex = new RegExp(q, 'i');
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });
    cb(matches);
  };
};

<?php
$nombres="";
$SQL="SELECT trim(a.Nombre_USR) FROM itusuarios a WHERE a.Activo_USR='1' and codigo_usr >'1' ORDER BY 1";
$resultx=mysqli_query($conexion,$SQL);
  while ($rowx=mysqli_fetch_array(($resultx))) {
    $nombres=$nombres."'".$rowx[0]."',";
  }
  mysqli_free_result($resultx);
  $nombres=$nombres."''";
?>
var nombres = [<?php echo $nombres; ?>];
$('#txt_usuario<?php echo $NumWindow; ?>').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'nombres',
  source: substringMatcherx(nombres)
  }).on('typeahead:selected', function(e) {
    var result = $('#txt_usuario<?php echo $NumWindow; ?>').val();
    CodUsrBdg('<?php echo $NumWindow; ?>', result);
});


  $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
  $("textarea").addClass("form-control");
  $("select").addClass("form-control");
  $("input[type=date]").addClass("form-control");
  $("input[type=number]").addClass("form-control");
  $("input[type=time]").addClass("form-control");
  $(".twitter-typeahead").addClass("form-control");
    
   
</script>
<script src="functions/nexus/bodegausers.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>