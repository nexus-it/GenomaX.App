<?php
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">
  
	
    <div class="row well well-sm">
        <div class="col-md-12">
			<button type="button" class="btn btn-success btn-sm btn-block" onclick="javascript:NewProduct('<?php echo $NumWindow; ?>');" data-toggle="modal" data-target="#GnmX_WinModal"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span> Nuevo Producto</button>
		</div>
		<div class="col-md-12">
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive " style="height:70%" >
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetCitas<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallemar<?php echo $NumWindow; ?>">
				<tr> 
					<th>Codigo</th>
					<th>Nombre</th>
					<th>CUM</th>
					<th>Concentración</th>
					<th>Unidad de Medida</th>
                    <th>Costo</th>
					<th>Activo</th>
				</tr>
				<?php 
				$SQL="Select a.Codigo_SER, Nombre_MED, CUM_MED, Concentracion_MED, Sigla_UNM, Costo_MED, Estado_SER from gxmedicamentos a, gxunidadmed b, gxservicios c  where c.Codigo_SER=a.Codigo_SER and a.Codigo_UNM=b.Codigo_UNM and a.Inventario_MED='1' Order By 1 ";
				$contafila=0;
				$result = mysqli_query($conexion, $SQL);
				while ($row = mysqli_fetch_array($result)) {
                    if ($row[6]=="0") {
						$estado="unchecked";
					} else {
						$estado="check";
					}
					echo '<tr onclick="javascript:EditProduct(\''.$row[0].'\', \''.$NumWindow.'\');" data-toggle="modal" data-target="#GnmX_WinModal">
					<td>'.$row[0].'</td>
					<td>'.$row[1].'</td>
					<td>'.$row[2].'</td>
					<td>'.$row[3].'</td>
					<td>'.$row[4].'</td>
					<td>'.$row[5].'</td>
					<td> <span class="glyphicon glyphicon-'.$estado.'" aria-hidden="true"></span> </td>
					</tr>';
					$contafila++;
				}
				mysqli_free_result($result);
				?>
				
				</tbody>
				</table>
				<input name="hdn_controwcitas<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwcitas<?php echo $NumWindow; ?>" value="<?php echo $contafila; ?>">
			</div>
		</div>
	</div>

</form>

<script >
<?php
	if (isset($_GET["CodigoBDG"])) {
		echo "
			document.frm_form".$NumWindow.".txt_codigo".$NumWindow.".value='".$_GET["CodigoBDG"]."';
		";
	$SQL="Select Codigo_BDG, Nombre_BDG, Nombre_USR, a.Codigo_SDE, Inventario_BDG, Estado_BDG, Codigo_USR from czbodegas a, itusuarios c where c.Codigo_USR=a.Responsable_BDG and Codigo_BDG='".$_GET["CodigoBDG"]."'";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
			document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".value='".$row[1]."';
			document.frm_form".$NumWindow.".txt_responsable".$NumWindow.".value='".$row[2]."';		
			document.frm_form".$NumWindow.".cmb_sede".$NumWindow.".value='".$row[3]."';
			document.frm_form".$NumWindow.".cmb_inventario".$NumWindow.".value='".$row[4]."';
			document.frm_form".$NumWindow.".cmb_estado".$NumWindow.".value='".$row[5]."';
			document.frm_form".$NumWindow.".hdn_usuario".$NumWindow.".value='".$row[6]."';
		";
		}
	mysqli_free_result($result); 
	echo "document.frm_form".$NumWindow.".txt_nombre".$NumWindow.".focus();";
	} else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>
function ReLoad<?php echo $NumWindow; ?>(Consult) {
	AbrirForm('application/forms/bodegas.php', '<?php echo $NumWindow; ?>', '&CodigoBDG='+Consult);
}

function Save<?php echo $NumWindow; ?>() {
	Guardar_bodegas('<?php echo $NumWindow; ?>');
}

function ShowBodegaUsers<?php echo $NumWindow; ?>(Bodega) {
  CargarWind('Bodega ['+Bodega+'] ', 'forms/bodegausers.php?bodega='+Bodega, 'folder_user.png', 'bodegas.php','<?php echo $NumWindow; ?>' );
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
$SQL="SELECT trim(a.Nombre_USR) FROM itusuarios a WHERE a.Activo_USR='1' and codigo_usr >'1' ORDER BY 1";
$resultx=mysqli_query($conexion,$SQL);
  while ($rowx=mysqli_fetch_array(($resultx))) {
    $nombres=$nombres."'".$rowx[0]."',";
  }
  mysqli_free_result($resultx);
  $nombres=$nombres."''";
?>
var nombres = [<?php echo $nombres; ?>];
$('#txt_responsable<?php echo $NumWindow; ?>').typeahead({
  hint: true,
  highlight: true,
  minLength: 1
},
{
  name: 'nombres',
  source: substringMatcher(nombres)
  }).on('typeahead:selected', function(e) {
    var result = $('#txt_responsable<?php echo $NumWindow; ?>').val();
    $('#hdn_usuario<?php echo $NumWindow; ?>').val('0');
    CodigoResponsable('<?php echo $NumWindow; ?>', result);
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
<script src="functions/nexus/productos.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
