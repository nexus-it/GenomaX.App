<?php
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">
  
	<label class="label label-success"> Editar Bodega/Almacén</label>
	<div class="row well well-sm">
		<div class="col-md-1 col-sm-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_codigo<?php echo $NumWindow; ?>">Código</label>
		<input name="txt_codigo<?php echo $NumWindow; ?>" id="txt_codigo<?php echo $NumWindow; ?>" type="text" required  />
	</div>

		</div>
		<div class="col-md-3 col-sm-4">

	<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
		<label for="txt_nombre<?php echo $NumWindow; ?>">Nombre</label>
		<input name="txt_nombre<?php echo $NumWindow; ?>" id="txt_nombre<?php echo $NumWindow; ?>" type="text" required  />
	</div>

		</div>
		<div class="col-md-4 col-sm-6">

	<div class="form-group" id="grp_txt_idhc3<?php echo $NumWindow; ?>">
		<label for="txt_responsable<?php echo $NumWindow; ?>">Usuario Responsable</label>
		<input name="txt_responsable<?php echo $NumWindow; ?>" id="txt_responsable<?php echo $NumWindow; ?>" type="text" required  placeholder="Ingrese el nombre del usuario" class="typeahead" />
		<input name="hdn_usuario<?php echo $NumWindow; ?>" type="hidden" id="hdn_usuario<?php echo $NumWindow; ?>">
	</div>

		</div>
		
		<div class="col-md-2 col-sm-3">

	<div class="form-group">
		<label for="cmb_sede<?php echo $NumWindow; ?>">Sede</label>
		<select name="cmb_sede<?php echo $NumWindow; ?>" id="cmb_sede<?php echo $NumWindow; ?>">
		<?php 
	$SQL="Select Codigo_SDE, Nombre_SDE from czsedes Where Estado_SDE='1' order by 2";
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
		<div class="col-md-1 col-sm-3">

<div class="form-group">
	<label for="cmb_inventario<?php echo $NumWindow; ?>" title="Maneja Control de Inventario?">Inventario</label>
	<select name="cmb_inventario<?php echo $NumWindow; ?>" id="cmb_inventario<?php echo $NumWindow; ?>">
	  <option value="0">NO</option>
	  <option value="1">SI</option>
	</select>
</div>
		</div>
		<div class="col-md-1 col-sm-3">

<div class="form-group">
	<label for="cmb_estado<?php echo $NumWindow; ?>">Estado</label>
	<select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>">
	  <option value="1">ACTIVO</option>
	  <option value="0">INACTIVO</option>
	</select>
</div>
		</div>
		<div class="col-md-12">
			<button type="button" class="btn btn-success btn-sm btn-block" onclick="javascript:Save<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-floppy-save" aria-hidden="true"></span> GUARDAR</button>
		</div>
	</div>

	<label class="label label-success">
		<i class="fas fa-plus"></i> BODEGAS 
	</label>
	<div class="row well well-sm">
		<div class="col-md-12">
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive "  >
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetCitas<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallemar<?php echo $NumWindow; ?>">
				<tr> 
					<th>Codigo</th>
					<th>Nombre</th>
					<th>Responsable</th>
					<th>Sede</th>
					<th>Control de Inventario</th>
					<th>Activo</th>
					<th>Usuarios</th>
				</tr>
				<?php 
				$SQL="Select Codigo_BDG, Nombre_BDG, Nombre_USR, Nombre_SDE, Inventario_BDG, Estado_BDG from czbodegas a, czsedes b, itusuarios c where c.Codigo_USR=a.Responsable_BDG and  a.Codigo_SDE=b.Codigo_SDE Order By 1 ";
				$contafila=0;
				$result = mysqli_query($conexion, $SQL);
				while ($row = mysqli_fetch_array($result)) {
					if ($row[4]=="0") {
						$invent="unchecked";
					} else {
						$invent="check";
					}
				 	if ($row[5]=="0") {
						$estado="unchecked";
					} else {
						$estado="check";
					}
				 	echo '<tr onclick="javascript:ReLoad'.$NumWindow.'(\''.$row[0].'\');">
					<td>'.$row[0].'</td>
					<td>'.$row[1].'</td>
					<td>'.$row[2].'</td>
					<td>'.$row[3].'</td>
					<td align="center"> <span class="glyphicon glyphicon-'.$invent.'" aria-hidden="true"></span> </td>
					<td align="center"> <span class="glyphicon glyphicon-'.$estado.'" aria-hidden="true"></span> </td>
					<td align="center" >
		            <button class="btn btn-success btn-sm" type="button" title="Ver Usuarios Habilitados en '.$row[1].'" data-toggle="modal" data-target="#GnmX_WinModal" onclick="javascript:ShowBodegaUsers'.$NumWindow.'(\''.$row[0].'\', \''.$row[1].'\')"> <span class="glyphicon glyphicon-user" aria-hidden="true" ></span> 
		            </button>
		          	</td>
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
<script src="functions/nexus/bodegas.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
