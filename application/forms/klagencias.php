<?php
	

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  >

<label class="label label-default"><span class="glyphicon glyphicon-map-marker" aria-hidden="true"></span> Datos Empresa</label>
<div class="row well well-sm">
		<div class="col-md-1">

	<input name="hdn_terceros<?php echo $NumWindow; ?>" type="hidden" id="hdn_terceros<?php echo $NumWindow; ?>" value="<?php echo session_id(); ?>" />
<div class="form-group">
<label for="cmb_tipoid<?php echo $NumWindow; ?>">Tipo Id</label>
<select name="cmb_tipoid<?php echo $NumWindow; ?>" id="cmb_tipoid<?php echo $NumWindow; ?>" >
<?php 
$SQL="Select Codigo_TID, Nombre_TID, case Sigla_TID when 'NI' then 'NIT' else Sigla_TID end from cztipoid Where Codigo_TID Not in ('8','4', '5', '6', '7') order by Codigo_TID desc";
$result = mysqli_query($conexion, $SQL);
while($row = mysqli_fetch_array($result)) 
	{
 ?>
  <option value="<?php echo $row[0]; ?>"><?php echo ($row[2]); ?></option>
<?php
	}
mysqli_free_result($result); 
 ?>
</select>
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
	<label for="txt_idagencia<?php echo $NumWindow; ?>">No.</label>
	<div class="input-group">	
		<input name="txt_idagencia<?php echo $NumWindow; ?>" id="txt_idagencia<?php echo $NumWindow; ?>" type="text"  maxlength="15" onkeypress="BuscarAGE<?php echo $NumWindow; ?>(event);" />
		<span class="input-group-btn">	
			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-bs-toggle="modal" data-bs-target="#GnmX_Search" data-whatever="Klagencias" onclick="javascript:CargarSearch('Klagencias', 'txt_idagencia<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
		</span>
	</div>
</div>

	</div>
	<div class="col-md-1">

<div class="form-group" id="idjuridicaX<?php echo $NumWindow; ?>">
<label for="txt_id<?php echo $NumWindow; ?>">DV</label>
<input name="txt_id<?php echo $NumWindow; ?>" type="text"  maxlength="1" id="txt_id<?php echo $NumWindow; ?>"  />
</div>

	</div>
	<div class="col-md-6">

<div class="form-group">
<label for="txt_ncomercial<?php echo $NumWindow; ?>">Nombre Agencia</label>
<input name="txt_ncomercial<?php echo $NumWindow; ?>" type="text"  id="txt_ncomercial<?php echo $NumWindow; ?>"  />
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
<label for="cmb_estado<?php echo $NumWindow; ?>"> Estado</label>
  <select name="cmb_estado<?php echo $NumWindow; ?>" id="cmb_estado<?php echo $NumWindow; ?>">
    <option value="0" style="color:#C00" >Inactivo</option>
    <option value="1" style="color:#060" >Activo</option>
  </select>
</div>

	</div>
	<div class="col-md-4">

<div class="form-group">
<label for="txt_rsocial<?php echo $NumWindow; ?>">Razon Social</label>
<input name="txt_rsocial<?php echo $NumWindow; ?>" type="text"  id="txt_rsocial<?php echo $NumWindow; ?>"  />
</div>

	</div>
	<div class="col-md-4">

<div class="form-group">
<label for="txt_descripcion<?php echo $NumWindow; ?>">Descripcion</label>
<input name="txt_descripcion<?php echo $NumWindow; ?>" type="text"  id="txt_descripcion<?php echo $NumWindow; ?>"  />
</div>

	</div>
	<div class="col-md-4">

<div class="form-group">
  <label for="txt_webpage<?php echo $NumWindow; ?>">Página Web</label>
  <input name="txt_webpage<?php echo $NumWindow; ?>" type="text"  id="txt_webpage<?php echo $NumWindow; ?>"  />
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="cmb_pais<?php echo $NumWindow; ?>">Pais</label>
  <select name="cmb_pais<?php echo $NumWindow; ?>" id="cmb_pais<?php echo $NumWindow; ?>">
    <?php 
$SQL="Select Codigo_dst, Nombre_dst from kldestinos  where  Estado_dst='1' Order by 2";
$resultz = mysqli_query($conexion, $SQL);
while($rowz = mysqli_fetch_array($resultz)) 
	{
	?>
    <option value="<?php echo $rowz[0]; ?>"><?php echo ($rowz[1]); ?></option>
    <?php
	}
mysqli_free_result($resultz); 
 ?>
  </select>  
</div>

	</div>
	<div class="col-md-1">

<div class="form-group">
  <label for="txt_Departamento<?php echo $NumWindow; ?>">Cod Dep.</label>
  	<div class="input-group">	
  		<input name="txt_Departamento<?php echo $NumWindow; ?>" type="text" id="txt_Departamento<?php echo $NumWindow; ?>" maxlength="2" onkeypress="BuscarDpto<?php echo $NumWindow; ?>(event);" />
  		<span class="input-group-btn">	
  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-bs-toggle="modal" data-bs-target="#GnmX_Search" data-whatever="Departamentos" onclick="javascript:CargarSearch('Departamentos', 'txt_Departamento<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
  		</span>
  </div>
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_NombreDepto<?php echo $NumWindow; ?>">Nom. Departamento</label>
	<input name="txt_NombreDepto<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreDepto<?php echo $NumWindow; ?>" />
</div>
  
 	</div>
	<div class="col-md-1">

<div class="form-group">
  <label for="txt_Municipio<?php echo $NumWindow; ?>">Municipio</label>
  	<div class="input-group">	
  		<input name="txt_Municipio<?php echo $NumWindow; ?>" type="text" id="txt_Municipio<?php echo $NumWindow; ?>"  maxlength="3" onkeypress="BuscarMUN<?php echo $NumWindow; ?>(event);" />
   		<span class="input-group-btn">	
   			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-bs-toggle="modal" data-bs-target="#GnmX_Search" data-whatever="Municipio" onclick="javascript:CargarMUN(document.frm_form<?php echo $NumWindow; ?>.txt_Departamento<?php echo $NumWindow; ?>.value);"><i class="fas fa-search"></i></button>
   		</span>
   </div>
</div>


	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_NombreMnpio<?php echo $NumWindow; ?>">Nom. Municipio</label>
	<input name="txt_NombreMnpio<?php echo $NumWindow; ?>" type="text"  disabled="disabled" id="txt_NombreMnpio<?php echo $NumWindow; ?>" />
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_Direccion<?php echo $NumWindow; ?>">Direccion</label>
  <input type="text" name="txt_Direccion<?php echo $NumWindow; ?>" id="txt_Direccion<?php echo $NumWindow; ?>" />
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="txt_Telefonos<?php echo $NumWindow; ?>">Telefono</label>
  <input type="text" name="txt_Telefonos<?php echo $NumWindow; ?>" id="txt_Telefonos<?php echo $NumWindow; ?>" /> 
</div>  

	</div>
	<div class="col-md-3">

<div class="form-group">
  <label for="txt_email<?php echo $NumWindow; ?>">Correo</label>
  <input type="text" name="txt_email<?php echo $NumWindow; ?>" id="txt_email<?php echo $NumWindow; ?>" />
</div>

	</div>
	<div class="col-md-3">


<div class="form-group">
  <label for="txt_replegal<?php echo $NumWindow; ?>">Representante Legal</label>
  <input type="text" name="txt_replegal<?php echo $NumWindow; ?>" id="txt_replegal<?php echo $NumWindow; ?>" />
</div>

	</div>
	<div class="col-md-3">

<div class="form-group">
  <label for="txt_contacto<?php echo $NumWindow; ?>">Contacto</label>
  <input type="text" name="txt_contacto<?php echo $NumWindow; ?>" id="txt_contacto<?php echo $NumWindow; ?>" />  
</div>  

	</div>
	<div class="col-md-3">

<div class="form-group">
  <label for="txt_cargo<?php echo $NumWindow; ?>">Cargo</label>
  <input type="text" name="txt_cargo<?php echo $NumWindow; ?>" id="txt_cargo<?php echo $NumWindow; ?>" />
</div>

	</div>


</div>
<label class="label label-default"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Configuración Impresión</label>
<div class="row well well-sm">

	<div class="col-md-2">

<div class="form-group">
  <label for="cmb_rsocialprint<?php echo $NumWindow; ?>">Razon Social</label>
  <select name="cmb_rsocialprint<?php echo $NumWindow; ?>" id="cmb_rsocialprint<?php echo $NumWindow; ?>">
    <option value="0">AXISMEDICAL</option>
    <option value="1">PROPIA</option>
  </select>  
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="cmb_nitprint<?php echo $NumWindow; ?>">N.I.T.</label>
  <select name="cmb_nitprint<?php echo $NumWindow; ?>" id="cmb_nitprint<?php echo $NumWindow; ?>">
    <option value="0">AXISMEDICAL</option>
    <option value="1">PROPIO</option>
  </select>  
</div>

	</div>
	<div class="col-md-2">

<div class="form-group">
  <label for="cmb_valorprint<?php echo $NumWindow; ?>">Valores de Venta</label>
  <select name="cmb_valorprint<?php echo $NumWindow; ?>" id="cmb_valorprint<?php echo $NumWindow; ?>">
    <option value="1">MOSTRAR</option>
    <option value="0">NO MOSTRAR</option>
  </select>  
</div>

	</div>
	

</div>

<label class="label label-default"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Promotores</label>
	<div class="row well well-sm">
	  		<div class="col-md-2">
	  			<div class="input-group">
					<input name="txt_codigousr<?php echo $NumWindow; ?>" id="txt_codigousr<?php echo $NumWindow; ?>" type="text" onblur="javascript:NombreUser<?php echo $NumWindow; ?>();" />
					 <span class="input-group-btn"> 		
			 		  <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-bs-toggle="modal" data-bs-target="#GnmX_Search" data-whatever="Usuario" onclick="javascript:CargarSearch('Usuarios2', 'txt_codigousr<?php echo $NumWindow; ?>', 'Activo_USR=*1*');"><i class="fas fa-search"></i></button>
					 </span>
				</div>
	  		</div>
	  		<div class="col-md-9">
					<input name="txt_descripcionx<?php echo $NumWindow; ?>" id="txt_descripcionx<?php echo $NumWindow; ?>" type="text" disabled="disabled"/>
	  		</div>
	  		<div class="col-md-1">
					<button class="btn btn-success" type="button"  onclick="javascript:Addusuario<?php echo $NumWindow; ?>();"><i class="fas fa-plus"></i></button>
	  		</div>
			<div class="col-md-12">

			 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
			<tbody id="tbcob<?php echo $NumWindow; ?>">
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th1<?php echo $NumWindow; ?>">Usuario</th> 
				<th id="th2<?php echo $NumWindow; ?>">Nombre</th> 
			    <th id="th2<?php echo $NumWindow; ?>"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span> </th> 
			</tr> 
				 <?php 
				 if (isset($_GET["IdAGE"])) {	
				$SQL="Select ID_USR, Nombre_USR FROM klagenciasusuarios a, itusuarios b, czterceros c, klagencias d WHERE a.Codigo_USR=b.Codigo_USR and a.Codigo_AGE=d.Codigo_AGE and d.Codigo_TER=c.Codigo_TER and ID_TER= '".$_GET["IdAGE"]."' and Activo_USR='1' and ID_USR not in ('nexus', 'ROOT') Order by 2";
				$resulthc = mysqli_query($conexion, $SQL);
				$contarow=0;
				while($rowhc = mysqli_fetch_array($resulthc)) 
					{
						$contarow=$contarow+1;
						echo '
				  <tr id="tr'.$contarow.$NumWindow.'"><td align="left"><input name="hdn_idusr'.$contarow.$NumWindow.'" type="hidden" id="hdn_idusr'.$contarow.$NumWindow.'" value="'.$rowhc[0].'" />'.$rowhc[0].'</td><td align="right">'.$rowhc[1].'</td><td>
				  <button onclick="EliminarFilaUSR'.$NumWindow.'(\''.$contarow.'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>
				  </td></tr>
				  ';
					}
				mysqli_free_result($resulthc); 
				 }
				 ?>
			</tbody>
			</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
			 </div>

	  		</div>

	</div>

</form>
<script>
<?php
	if (isset($_GET["IdAGE"])) {
	$SQL="Select * from czterceros b left join klagencias a on b.Codigo_TER=a.Codigo_TER where ID_TER='".$_GET["IdAGE"]."'";
	$result = mysqli_query($conexion, $SQL);
	echo "
		document.frm_form".$NumWindow.".txt_idagencia".$NumWindow.".value='".$_GET["IdAGE"]."';";
	if($row = mysqli_fetch_array($result)) {
		if ($row["Estado_AGE"]=='0'){
			echo "
			MsgBox1('Agencias','La agencia ".$_GET["IdAGE"]." se encuentra inactiva');
			";}
	echo "
		document.frm_form".$NumWindow.".cmb_tipoid".$NumWindow.".value='".$row["Codigo_TID"]."';
		document.frm_form".$NumWindow.".txt_rsocial".$NumWindow.".value='".$row["RazonSocial_TER"]."';
		document.frm_form".$NumWindow.".txt_ncomercial".$NumWindow.".value='".$row["Nombre_TER"]."';
		document.frm_form".$NumWindow.".txt_descripcion".$NumWindow.".value='".$row["Nombre_TER"]."';
		document.frm_form".$NumWindow.".txt_id".$NumWindow.".value='".$row["DigitoVerif_TER"]."';		
		document.frm_form".$NumWindow.".txt_email".$NumWindow.".value='".$row["Correo_TER"]."';
		document.frm_form".$NumWindow.".cmb_pais".$NumWindow.".value='".$row["Codigo_PAI"]."';
		document.frm_form".$NumWindow.".txt_Departamento".$NumWindow.".value='".$row["Codigo_DEP"]."';
		document.frm_form".$NumWindow.".txt_Municipio".$NumWindow.".value='".$row["Codigo_MUN"]."';
		NombreDpto('".$NumWindow."', document.frm_form".$NumWindow.".txt_Departamento".$NumWindow.".value);
		NombreMUN('".$NumWindow."', document.frm_form".$NumWindow.".txt_Departamento".$NumWindow.".value, document.frm_form".$NumWindow.".txt_Municipio".$NumWindow.".value);
		document.frm_form".$NumWindow.".txt_Direccion".$NumWindow.".value='".$row["Direccion_TER"]."';
		document.frm_form".$NumWindow.".txt_Telefonos".$NumWindow.".value='".$row["Telefono_TER"]."';
		document.frm_form".$NumWindow.".txt_replegal".$NumWindow.".value='".$row["Representante_AGE"]."';
		document.frm_form".$NumWindow.".txt_cargo".$NumWindow.".value='".$row["Cargo_AGE"]."';
		document.frm_form".$NumWindow.".txt_contacto".$NumWindow.".value='".$row["Contacto_AGE"]."';
		document.frm_form".$NumWindow.".cmb_estado".$NumWindow.".value='".$row["Estado_AGE"]."';
		document.frm_form".$NumWindow.".hdn_terceros".$NumWindow.".value='".$row["Codigo_TER"]."';
		document.frm_form".$NumWindow.".txt_webpage".$NumWindow.".value='".$row["Web_TER"]."';	

		document.frm_form".$NumWindow.".cmb_rsocialprint".$NumWindow.".value='".$row["RazonPrint_AGE"]."';	
		document.frm_form".$NumWindow.".cmb_nitprint".$NumWindow.".value='".$row["NITPrint_AGE"]."';	
		document.frm_form".$NumWindow.".cmb_valorprint".$NumWindow.".value='".$row["ValVentaPrint_AGE"]."';	
		
		";
		
	}
	else {
		echo "
	document.frm_form".$NumWindow.".cmb_tipoid".$NumWindow.".focus();
		";
	}
	mysqli_free_result($result); 
	}
	else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	echo "document.frm_form".$NumWindow.".cmb_pais".$NumWindow.".value='42';";
	}
?>

function CargarMUN(Dpto) {
	if (Dpto=="") {
		VarM="NULL";
	} else {
		VarM="Codigo_DEP=*"+Dpto+"*";
	}
	CargarSearch('Municipios', 'txt_Municipio<?php echo $NumWindow; ?>', VarM);
}

function BuscarAGE<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idagencia<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/klagencias.php', '<?php echo $NumWindow; ?>', '');
	} else {
		AbrirForm('application/forms/klagencias.php', '<?php echo $NumWindow; ?>', '&IdAGE='+document.getElementById('txt_idagencia<?php echo $NumWindow; ?>').value);
	}  
  }
}

function BuscarDpto<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreDpto('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Departamento<?php echo $NumWindow; ?>.value);
  }
}

function BuscarMUN<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	  NombreMUN('<?php echo $NumWindow; ?>', document.frm_form<?php echo $NumWindow; ?>.txt_Departamento<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.txt_Municipio<?php echo $NumWindow; ?>.value);
  }
}

function NombreUser<?php echo $NumWindow; ?>() {
	NombreUsuariox("<?php echo $NumWindow; ?>", document.frm_form<?php echo $NumWindow; ?>.txt_codigousr<?php echo $NumWindow; ?>.value)	
}

function Addusuario<?php echo $NumWindow; ?>() {
	CodigoUSR=document.getElementById('txt_codigousr<?php echo $NumWindow; ?>').value;
	DescripcionUSR=document.getElementById('txt_descripcionx<?php echo $NumWindow; ?>').value;
		
	if (CodigoUSR!="") {
		CodigoUSR=CodigoUSR.toUpperCase();
		DescripcionUSR=DescripcionUSR.toUpperCase();
		TotalFilas=document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbcob<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
		TotalFilas++;
		fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
	    celda1.innerHTML = '<input name="hdn_idusr'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_idusr'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodigoUSR+''+'" /> '+CodigoUSR; 
		celda2.innerHTML = ' '+DescripcionUSR; 
		celda3.innerHTML = '<button onclick="EliminarFilaUSR<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controw<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_codigousr<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_descripcionx<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_codigousr<?php echo $NumWindow; ?>').focus();
	}
}

function EliminarFilaUSR<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalle<?php echo $NumWindow; ?>");     
    $('#tr'+Numero+"<?php echo $NumWindow; ?>").remove();
}  


	$("form").addClass(" container");
	$("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-select");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=checkbox]").addClass("form-check-input");
	$("input[type=radio]").addClass("form-check-input");

</script>