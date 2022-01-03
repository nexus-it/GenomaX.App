<?php
	
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal container">

<input type="hidden" name="hdn_tarifa<?php echo $NumWindow; ?>" id="hdn_tarifa<?php echo $NumWindow; ?>" value="<?php echo $_GET["tarifa"]; ?>">

    <label class="label label-info " style="background-color: #dc6d00;"> <span class="glyphicon glyphicon-star-empty" aria-hidden="true" ></span> Excepciones</label>
   <div class="row well well-sm">

  <div class="col-md-2">
<div class="form-group">
<label for="cmb_tiposervicio<?php echo $NumWindow; ?>">Tipo Excepcion</label>
<select name="cmb_tiposervicio<?php echo $NumWindow; ?>" id="cmb_tiposervicio<?php echo $NumWindow; ?>" onclick="javascript: addExcept<?php echo $NumWindow; ?>();">
  <option value="-" selected="selected">- Seleccione -</option>
  <option value="0">Tarifa por Grupo CUPS</option>
  <option value="9">Tarifa por Tipo Producto</option>
  <option value="X">Valor por Servicio</option>
  <option value="Z">Ampliar Rangos</option>
</select>
</div>
  </div>
  
  <div class="col-md-2 ">
<div class="form-group">
<label for="txt_fechaini<?php echo $NumWindow; ?>">Fecha Inicial</label>
<input name="txt_fechaini<?php echo $NumWindow; ?>" type="date" id="txt_fechaini<?php echo $NumWindow; ?>"  value="<?php echo date("Y").'-01-01';?>" />
</div>
  </div>

  <div class="col-md-2">
<div class="form-group">
<label for="txt_fechafin<?php echo $NumWindow; ?>">Fecha Final</label>
<input name="txt_fechafin<?php echo $NumWindow; ?>" type="date" id="txt_fechafin<?php echo $NumWindow; ?>"  value="<?php echo date("Y").'-12-31';?>" />
</div>
  </div>

  

<div class="col-md-12" id="div_det0<?php echo $NumWindow; ?>">
  <div class="col-md-2">
<div class="form-group">
<label for="cmb_grupo<?php echo $NumWindow; ?>">Grupo</label>
<select name="cmb_grupo<?php echo $NumWindow; ?>" id="cmb_grupo<?php echo $NumWindow; ?>" onchange="javascript:CargarSubgrupo('<?php echo $NumWindow; ?>', this.value, 'S');" >
  <option value="" selected="selected">- Seleccione -</option>
  <?php 
  $SQL="Select Codigo_CUP, Nombre_CUP from gxgruposcups Where Tipo_CUP='G' Order By 2";
  $result = mysqli_query($conexion, $SQL);
  while ($row = mysqli_fetch_array($result)) {
  ?>
  <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
  <?php
  }
  mysqli_free_result($result);
  ?>
</select>
</div>
  </div>
  <div class="col-md-2">
<div class="form-group">
<label for="cmb_subgrupo<?php echo $NumWindow; ?>">Sub-Grupo</label>
<select name="cmb_subgrupo<?php echo $NumWindow; ?>" id="cmb_subgrupo<?php echo $NumWindow; ?>" disabled  onchange="javascript:PrepararCateg<?php echo $NumWindow; ?>(this.value);">
  <option value="" selected="selected">Seleccione un grupo</option>
</select>
</div>
  </div>
  <div class="col-md-2">
<div class="form-group">
<label for="cmb_categoria<?php echo $NumWindow; ?>">Categoría</label>
<select name="cmb_categoria<?php echo $NumWindow; ?>" id="cmb_categoria<?php echo $NumWindow; ?>" disabled >
  <option value="" selected="selected">Seleccione un subgrupo</option>
</select>
</div>
  </div>
  <div class="col-md-2">
<div class="form-group">
<label for="cmb_tarifab<?php echo $NumWindow; ?>">Tarifa Base</label>
<select name="cmb_tarifab<?php echo $NumWindow; ?>" id="cmb_tarifab<?php echo $NumWindow; ?>"  >
  <?php 
  $SQL="Select a.Codigo_TAR, a.Nombre_TAR  from gxtarifas a Order By 1";
  $result = mysqli_query($conexion, $SQL);
  while($row = mysqli_fetch_array($result)) 
    {
   ?>
    <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
  <?php
    }
  mysqli_free_result($result); 
   ?>
</select>
</div>
  </div>
  <div class="col-md-2">

  <div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
    <label for="txt_variacion<?php echo $NumWindow; ?>">Porcentaje</label>
      <div class="input-group">
    <input name="txt_variacion<?php echo $NumWindow; ?>" id="txt_variacion<?php echo $NumWindow; ?>" type="number" required value="0"  max="300" />
    <span class="input-group-addon" id="badn<?php echo $NumWindow; ?>">%</span>
      </div>
  </div>

    </div>
    <div class="col-md-2 ">
      <button class="btn btn-warning btn-md btn-block" type="button" onclick="javascript:ExcTarifa<?php echo $NumWindow; ?>('0');" style="height: 35px; margin-top: 25px;margin-left: 15px;"> <span class="glyphicon glyphicon-star" aria-hidden="true" ></span>  Agregar Excepción
      </button>
    </div>
</div>
<div class="col-md-12" id="div_det9<?php echo $NumWindow; ?>">
    <div class="col-md-2">
<div class="form-group">
<label for="cmb_matins<?php echo $NumWindow; ?>">Materiales e Insumos</label>
<select name="cmb_matins<?php echo $NumWindow; ?>" id="cmb_matins<?php echo $NumWindow; ?>" >
  <option value="" selected="selected">NO</option>
  <option value="09" >SI</option>
</select>
</div>
  </div>
  <div class="col-md-2">
<div class="form-group">
<label for="cmb_medpos<?php echo $NumWindow; ?>">Medicamentos POS</label>
<select name="cmb_medpos<?php echo $NumWindow; ?>" id="cmb_medpos<?php echo $NumWindow; ?>" >
  <option value="" selected="selected">NO</option>
  <option value="12" >SI</option>
</select>
</div>
  </div>
  <div class="col-md-2">
<div class="form-group">
<label for="cmb_mednopos<?php echo $NumWindow; ?>">Medicamentos NO POS</label>
<select name="cmb_mednopos<?php echo $NumWindow; ?>" id="cmb_mednopos<?php echo $NumWindow; ?>" >
  <option value="" selected="selected">NO</option>
  <option value="13" >SI</option>
</select>
</div>
  </div>
  <div class="col-md-2">
<div class="form-group">
<label for="cmb_tarifab9<?php echo $NumWindow; ?>">Tarifa Base</label>
<select name="cmb_tarifab9<?php echo $NumWindow; ?>" id="cmb_tarifab9<?php echo $NumWindow; ?>"  >
  <?php 
  $SQL="Select a.Codigo_TAR, a.Nombre_TAR  from gxtarifas a Order By 1";
  $result = mysqli_query($conexion, $SQL);
  while($row = mysqli_fetch_array($result)) 
    {
   ?>
    <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
  <?php
    }
  mysqli_free_result($result); 
   ?>
</select>
</div>
  </div>
  <div class="col-md-2">

  <div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
    <label for="txt_variacion9<?php echo $NumWindow; ?>">Porcentaje</label>
      <div class="input-group">
    <input name="txt_variacion9<?php echo $NumWindow; ?>" id="txt_variacion9<?php echo $NumWindow; ?>" type="number" required value="0"  max="300" />
    <span class="input-group-addon" id="badn9<?php echo $NumWindow; ?>">%</span>
      </div>
  </div>

    </div>
    <div class="col-md-2 ">
      <button class="btn btn-warning btn-md btn-block" type="button" onclick="javascript:ExcTarifa<?php echo $NumWindow; ?>('9');" style="height: 35px; margin-top: 25px;margin-left: 15px;"> <span class="glyphicon glyphicon-star" aria-hidden="true" ></span>  Agregar Excepción
      </button>
    </div>
</div>
<div class="col-md-12" id="div_detX<?php echo $NumWindow; ?>">
    <div class="col-md-1">
  <div class="form-group">
  <label for="txt_codigo<?php echo $NumWindow; ?>">Código</label>
  <input name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" onblur="NombreServicio<?php echo $NumWindow; ?>();" onkeypress="NombreServicio0<?php echo $NumWindow; ?>(event);"  />
  </div>
    </div>
    <div class="col-md-7">
  <div class="form-group">
  <label for="lbl_servicionom<?php echo $NumWindow; ?>">Descripción</label>
  <input name="lbl_servicionom<?php echo $NumWindow; ?>" type="text" id="lbl_servicionom<?php echo $NumWindow; ?>" placeholder="Ingrese las palabras clave para la búsqueda" class="typeahead" />
  </div>
    </div>

    <div class="col-md-2">
  <div class="form-group">
  <label for="txt_valor<?php echo $NumWindow; ?>">Valor Venta</label>
  <input name="txt_valor<?php echo $NumWindow; ?>" type="number" id="txt_valor<?php echo $NumWindow; ?>" value="0"  />
  </div>
    </div>
    <div class="col-md-2 ">
      <button class="btn btn-warning btn-md btn-block" type="button" onclick="javascript:ExcTarifa<?php echo $NumWindow; ?>('X');" style="height: 35px; margin-top: 25px;margin-left: 15px;"> <span class="glyphicon glyphicon-star" aria-hidden="true" ></span>  Agregar Excepción
      </button>
    </div>
</div>
<div class="col-md-12" id="div_detZ<?php echo $NumWindow; ?>">
  <div class="col-md-2">
<div class="form-group">
<label for="cmb_servz<?php echo $NumWindow; ?>">Servicios</label>
<select name="cmb_servz<?php echo $NumWindow; ?>" id="cmb_servz<?php echo $NumWindow; ?>" >
  <option value="S" selected="selected">Si</option>
  <option value="N" >No</option>
</select>
</div>
  </div>
  <div class="col-md-2">
<div class="form-group">
<label for="cmb_prodz<?php echo $NumWindow; ?>">Productos</label>
<select name="cmb_prodz<?php echo $NumWindow; ?>" id="cmb_prodz<?php echo $NumWindow; ?>" >
  <option value="S" selected="selected">Si</option>
  <option value="N" >No</option>
</select>
</div>
  </div>
  <div class="col-md-2">
<div class="form-group">
<label for="cmb_paqz<?php echo $NumWindow; ?>">Paquetes</label>
<select name="cmb_paqz<?php echo $NumWindow; ?>" id="cmb_paqz<?php echo $NumWindow; ?>" >
  <option value="S" selected="selected">Si</option>
  <option value="N" >No</option>
</select>
</div>
  </div>
  <div class="col-md-2 ">
      <button class="btn btn-warning btn-md btn-block" type="button" onclick="javascript:ExcTarifa<?php echo $NumWindow; ?>('Z');" style="height: 35px; margin-top: 25px;margin-left: 15px;"> <span class="glyphicon glyphicon-star" aria-hidden="true" ></span>  Agregar Excepción
      </button>
    </div>
</div>

    <div class="table-responsive detalleord col-md-12" style="border-color: #dc6d00;">
      <table width="100%" border="0" align="center" cellpadding="2" cellspacing="1" class="table table-striped table-condensed tblDetalle table-bordered">
        <tbody style="font-size: 12px;">
          <tr><th style="background-color: #dc6d00;">TIPO</th><th style="background-color: #dc6d00;">DESCRIPCION</th><th style="background-color: #dc6d00;">FECHA INICIAL</th><th style="background-color: #dc6d00;">FECHA FINAL</th><th style="background-color: #dc6d00;">TARIFA BASE</th><th style="background-color: #dc6d00;">VALOR</th><th style="background-color: #dc6d00;">ELIMINAR</th></tr>
          <?php 
          $SQL="Select Tipo_TRX, case Tipo_TRX when '0' then 'Tarifa por Grupo CUPS' when '9' then 'Tarifa por Tipo Producto' else 'Valor por Servicio' end , a.FechaIni_TAR, a.FechaFin_TAR,  a.Codigo_TRX, b.Nombre_TAR, Valor_TRX from gxtarifaexcepciones a left outer join gxtarifas b on a.Tarifa_TRX=b.Codigo_TAR Where a.Codigo_TAR='".$_GET["tarifa"]."' Order By 1";
          $result = mysqli_query($conexion, $SQL);
          while($row = mysqli_fetch_array($result)) 
            {
              $Pre="";
              $Pos="";
              if($row[0]=="0") {
                $SQL="Select Nombre_CUP from gxgruposcups Where Codigo_CUP='".$row[4]."'";
                $Pos="%";
              } elseif($row[0]=="9"){
                $SQL="Select Nombre_CFC from gxconceptosfactura Where Codigo_CFC='".$row[4]."'";
                $Pos="%";
              } else {
                $SQL="Select Nombre_SER from gxservicios where codigo_SER='".$row[4]."'";
                $Pre="$ ";
              }
              $resultx=mysqli_query($conexion,$SQL);
              while ($rowx=mysqli_fetch_array(($resultx))) {
                echo '<tr>
                <td>'.$row[1].'</td><td>'.$rowx[0].'</td><td>'.$row[2].'</td><td>'.$row[3].'</td><td>'.$row[5].'</td><td>'.$Pre.$row[6].$Pos.'</td><td align="center"><button class="btn btn-danger btn-xs" type="button" onclick="javascript:Guardar_tarifas(\''.$row[0].'\', \''.$row[4].'\', \'-\', \'-\', \''.$NumWindow.'\');" > <span class="glyphicon glyphicon-remove" aria-hidden="true" ></span> 
      </button></td>
                </tr>';
              }
              mysqli_free_result($resultx);
            }
            mysqli_free_result($result);
          ?>
        </tbody>
      </table>
    </div>

  </div> 


<div class="panel panel-default">
<div class="panel-heading">Manual Tarifario <span id="ManTarif<?php echo $NumWindow; ?>"></span>:</div>
<div class="panel-body">

<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
  <div class="panel panel-warning">
    <div class="panel-heading" role="tab" id="headingOne">
      <h4 class="panel-title">
        <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          Servicios
        </a>
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
      <div class="panel-body" id="serv<?php echo $NumWindow; ?>">
        Digite el codigo del manual...
      </div>
    </div>
  </div>
  <div class="panel panel-warning">
    <div class="panel-heading" role="tab" id="headingTwo">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          Medicamentos e Insumos
        </a>
      </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo">
      <div class="panel-body" id="prod<?php echo $NumWindow; ?>">
        Digite el codigo del manual...
      </div>
    </div>
  </div>
  <div class="panel panel-warning">
    <div class="panel-heading" role="tab" id="headingThree">
      <h4 class="panel-title">
        <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Paquetes
        </a>
      </h4>
    </div>
    <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree">
      <div class="panel-body" id="paq<?php echo $NumWindow; ?>">
        Digite el codigo del manual...
      </div>
    </div>
  </div>
</div>

</div>
</div>

</form>

<script >


<?php
	if (isset($_GET["tarifa"])) {
		echo "
    addExcept".$NumWindow."();
    BuscarNombreTarifa".$NumWindow."();
	";
	} 
?>

function BuscarNombreTarifa<?php echo $NumWindow; ?>() {
  	document.getElementById('serv<?php echo $NumWindow; ?>').innerHTML='<img src="themes/ghenx/img/loading.gif" align="left">';
  	document.getElementById('prod<?php echo $NumWindow; ?>').innerHTML='<img src="themes/ghenx/img/loading.gif" align="left">';
  	document.getElementById('paq<?php echo $NumWindow; ?>').innerHTML='<img src="themes/ghenx/img/loading.gif" align="left">';
	  LoadTarifas('<?php echo $NumWindow; ?>', '<?php echo $_GET["tarifa"]; ?>');
}

function NombreServicio0<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	 NombreServicio<?php echo $NumWindow; ?>();
  }
}

function NombreServicio<?php echo $NumWindow; ?>() {
  NombreServicioX('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_codigo<?php echo $NumWindow; ?>.value);
}

function PrepararCateg<?php echo $NumWindow; ?>(SubG) {
  grupo=document.getElementById("cmb_grupo<?php echo $NumWindow; ?>").value;
  CargarSubgrupo('<?php echo $NumWindow; ?>', grupo+''+SubG, 'C');
}
function addExcept<?php echo $NumWindow; ?>() {
    Tipo=document.getElementById("cmb_tiposervicio<?php echo $NumWindow; ?>").value;
    document.getElementById("div_det0<?php echo $NumWindow; ?>").style.display='none';
    document.getElementById("div_det9<?php echo $NumWindow; ?>").style.display='none';
    document.getElementById("div_detX<?php echo $NumWindow; ?>").style.display='none';
    document.getElementById("div_detZ<?php echo $NumWindow; ?>").style.display='none';
    if (Tipo!="-") {
      document.getElementById("div_det"+Tipo+"<?php echo $NumWindow; ?>").style.display='block';
    }
}

function ExcTarifa<?php echo $NumWindow; ?>(Typo) {
  CUPS="";
  CFC="";
  if (Typo=="0") {
    CUPS=''
    grup=document.getElementById("cmb_grupo<?php echo $NumWindow; ?>").value;
    subgrp=document.getElementById("cmb_subgrupo<?php echo $NumWindow; ?>").value;
    categ=document.getElementById("cmb_categoria<?php echo $NumWindow; ?>").value;
    Tarifa=document.getElementById("cmb_tarifab<?php echo $NumWindow; ?>").value;
    Valor=document.getElementById("txt_variacion<?php echo $NumWindow; ?>").value;
    CUPS=''+grup+''+subgrp+''+categ+'';
    Guardar_tarifas(Typo, CUPS, Tarifa, Valor, '<?php echo $NumWindow; ?>');
  }
  if (Typo=="9") {
    CFC="";
    matins=document.getElementById("cmb_matins<?php echo $NumWindow; ?>").value;
    if (matins!="") { CFC="'"+matins+"'," }
    medpos=document.getElementById("cmb_medpos<?php echo $NumWindow; ?>").value;
    if (medpos!="") { CFC=CFC+"'"+medpos+"'," }
    mednopos=document.getElementById("cmb_mednopos<?php echo $NumWindow; ?>").value;
    if (mednopos!="") { CFC=CFC+"'"+mednopos+"', " }
    CFC=CFC+"'X'"
    Tarifa=document.getElementById("cmb_tarifab9<?php echo $NumWindow; ?>").value;
    Valor=document.getElementById("txt_variacion9<?php echo $NumWindow; ?>").value;
    Guardar_tarifas(Typo, CFC, Tarifa, Valor, '<?php echo $NumWindow; ?>');
  }
  if (Typo=="X") {
    CodServ=document.getElementById("txt_codigo<?php echo $NumWindow; ?>").value;
    Tarifa="";
    Valor=document.getElementById("txt_valor<?php echo $NumWindow; ?>").value;
    Guardar_tarifas(Typo, CodServ, Tarifa, Valor, '<?php echo $NumWindow; ?>'); 
  }
  if (Typo=="Z") {
    CodServ='NXS';
    Tarifa="";
    Valor='0';
    Guardar_tarifas(Typo, CodServ, Tarifa, Valor, '<?php echo $NumWindow; ?>'); 
  }
}

var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
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
$SQL="SELECT trim(a.Nombre_SER) FROM gxservicios a WHERE a.Estado_SER='1' AND (a.Codigo_CFC<>'04' or Tipo_ser='3' ) ORDER BY 1";
$resultx=mysqli_query($conexion,$SQL);
  while ($rowx=mysqli_fetch_array(($resultx))) {
    $nombres=$nombres."'".$rowx[0]."',";
  }
  mysqli_free_result($resultx);
  $nombres=$nombres."''";
?>
var nombres = [<?php echo $nombres; ?>];
$('#lbl_servicionom<?php echo $NumWindow; ?>').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'nombres',
  source: substringMatcher(nombres)
  }).on('typeahead:selected', function(e) {
    var result = $('#lbl_servicionom<?php echo $NumWindow; ?>').val();
    $('#txt_codigo<?php echo $NumWindow; ?>').val('');
    CodigoServicioX('<?php echo $NumWindow; ?>', result);
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
<script src="functions/nexus/tarifas.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>