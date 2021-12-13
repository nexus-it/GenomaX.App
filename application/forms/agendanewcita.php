<?php

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;

    $area="";
    $medico="";
    $SQL="Select b.Nombre_ARE, c.Nombre_TER From gxagendacab a, gxareas b, czterceros c Where c.Codigo_TER=a.Codigo_TER and a.Codigo_ARE=b.Codigo_ARE and a.Codigo_AGE='".$_GET["agenda"]."'";
    $result = mysqli_query($conexion, $SQL);
    while($row = mysqli_fetch_array($result)) {
        $area=$row[0];
        $medico=$row[1];
    }
    mysqli_free_result($result);
    

?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
    <div class="row well well-sm">
        <div class="col-md-2">

    <div class="form-group">
        <label for="txt_fechaage<?php echo $NumWindow; ?>">Fecha Agenda</label>
        <input  name="txt_fechaage<?php echo $NumWindow; ?>" id="txt_fechaage<?php echo $NumWindow; ?>" type="date" disabled="disabled" class="form-control" value="<?php echo $_GET["fecha"]; ?>"" />		
    </div>

        </div>
        <div class="col-md-2">

	<div class="form-group">
		<label for="txt_horaage<?php echo $NumWindow; ?>">Hora Agenda</label>
        <input  name="txt_horaage<?php echo $NumWindow; ?>" id="txt_horaage<?php echo $NumWindow; ?>" type="time" disabled="disabled" class="form-control" value="<?php echo $_GET["hora"]; ?>"" />		
	</div>
	
		</div>
        <div class="col-md-offset-3 col-md-1">

    <div class="form-group">
    <label for="txt_codigo<?php echo $NumWindow; ?>">Servicio</label>
        <div class="input-group">
        <input name="txt_codigo<?php echo $NumWindow; ?>" type="text" id="txt_codigo<?php echo $NumWindow; ?>" size="3"  onchange="NombreServicio(this.value, '<?php echo $NumWindow; ?>' );" onblur="NombreServicio(this.value, '<?php echo $NumWindow; ?>' );" />
            <span class="input-group-btn">	
                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ServiciosX" onclick="javascript:CargarSearch('ServiciosX1', 'txt_codigo<?php echo $NumWindow; ?>', 'Tipo_SER=*1*');" onblur="NombreServicio(document.getElementById('txt_codigo<?php echo $NumWindow; ?>')..value, '<?php echo $NumWindow; ?>' );"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
        </div>
    </div>
  
        </div>
        <div class="col-md-4">

    <div class="form-group">
    <label for="txt_nombreserv<?php echo $NumWindow; ?>">Nombre
    <input type="hidden" name="hdn_codigox<?php echo $NumWindow; ?>" id="hdn_codigox<?php echo $NumWindow; ?>" />
    </label>
    <input name="txt_nombreserv<?php echo $NumWindow; ?>" type="text" disabled="disabled" id="txt_nombreserv<?php echo $NumWindow; ?>" />
    </div>

        </div>
    </div>
	<div class="row well well-sm">
    <input type="hidden" name="hdn_agenda<?php echo $NumWindow; ?>" value="<?php echo $_GET["agenda"]; ?>" id="hdn_agenda<?php echo $NumWindow; ?>" />
    
		<div class="col-md-2">

	<div class="form-group">
		<label for="txt_area<?php echo $NumWindow; ?>">Area</label>
        <input  name="txt_area<?php echo $NumWindow; ?>" id="txt_area<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="form-control" value="<?php echo $area; ?>" />
	</div>
	
		</div>
		<div class="col-md-1">

	<div class="form-group">
		<label for="cmb_primeravez<?php echo $NumWindow; ?>">Tipo Consulta</label>
		<select name="cmb_primeravez<?php echo $NumWindow; ?>" id="cmb_primeravez<?php echo $NumWindow; ?>" onchange="javascript:FechaCerca<?php echo $NumWindow; ?>(document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value);">
		  <option value="1" >Primera Vez</option>
		  <option value="C" >Control</option>
		</select>
	</div>
	
		</div>
		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha Deseada</label>
		<input  name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="date" required class="form-control" onchange="FechaCerca<?php echo $NumWindow; ?>(document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value, document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value);" value="<?php echo $_GET["fecha"]; ?>"" />
	</div>

		</div>
		<div class="col-md-1 col-sm-2">

	<div class="form-group">
		<label for="cmb_tipoatencion<?php echo $NumWindow; ?>">Tipo Atención</label>
		<select name="cmb_tipoatencion<?php echo $NumWindow; ?>" id="cmb_tipoatencion<?php echo $NumWindow; ?>">
		<?php 
	$SQL="Select Codigo_TAH, Nombre_TAH from hctipoatencion Where Estado_TAH='1' order by 1";
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
		<div class="col-md-3">

	<div class="form-group">
		<label for="cmb_medico<?php echo $NumWindow; ?>">Profesional</label>
		<input  name="cmb_medico<?php echo $NumWindow; ?>" id="cmb_medico<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="form-control" value="<?php echo $medico; ?>" />		
	</div>
	
		</div>
		<div class="col-md-3">

	<div class="form-group">
		<label for="txt_nota<?php echo $NumWindow; ?>">Nota</label>
		<input  name="txt_nota<?php echo $NumWindow; ?>" id="txt_nota<?php echo $NumWindow; ?>" type="text"  />
	</div>
	
		</div>
			
	</div>
	<div class="row well well-sm alert alert-success">
        <div class="col-md-2 col-sm-4">

    <div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
        <label for="txt_idhc<?php echo $NumWindow; ?>">Paciente</label>
        <div class="input-group">	
            <span class="input-group-btn">	
                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_WinModal" onclick="javascript:LoadPcte<?php echo $NumWindow; ?>();" title="Editar datos de Paciente"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
            </span>
            <input style="font-size:15px;" name="txt_idhc<?php echo $NumWindow; ?>" id="txt_idhc<?php echo $NumWindow; ?>" type="text" required  onblur="NombreTercero('<?php echo $NumWindow; ?>', this.value, 'gxpacientes');" />
            <span class="input-group-btn">	
                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('PacientesHC', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
            </span>
        </div>
        <input name="hdn_codigoter<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoter<?php echo $NumWindow; ?>" value="X" />
    </div>

        </div>
        <div class="col-md-4 col-sm-8">

    <div class="form-group">
        <label for="txt_paciente<?php echo $NumWindow; ?>">Nombre</label>
        <input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
    </div>

        </div>
        <div class="col-md-12 col-sm-12 ">
	<div class="row well well-sm">
		<input name="hdn_autorizacion<?php echo $NumWindow; ?>" type="hidden" id="hdn_autorizacion<?php echo $NumWindow; ?>" value="" />
		<div class="col-md-5 col-sm-5">
			<label>Contrato: </label> <span id="spn_contrato<?php echo $NumWindow; ?>">Sin datos</span>
			<input name="hdn_contrato<?php echo $NumWindow; ?>" type="hidden" id="hdn_contrato<?php echo $NumWindow; ?>" value="" />
		</div>
		<div class="col-md-5 col-sm-5">
			<label>Plan: </label> <span id="spn_plan<?php echo $NumWindow; ?>">Sin datos</span>
			<input name="hdn_plan<?php echo $NumWindow; ?>" type="hidden" id="hdn_plan<?php echo $NumWindow; ?>" value="" />
		</div>
		<div class="col-md-2 col-sm-2">
			<label>Rango: </label> <span id="spn_rango<?php echo $NumWindow; ?>">--</span>
		</div>
		<div class="col-md-3 col-sm-3">
			<label>Fec Nacimiento: </label> <small><span id="spn_fechanac<?php echo $NumWindow; ?>">00/00/0000</span></small>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Edad: </label> <small><span id="spn_edad<?php echo $NumWindow; ?>">00 Años</span></small>
		</div>
		<div class="col-md-2 col-sm-2">
			<label>Sexo: </label> <small><span id="spn_sexo<?php echo $NumWindow; ?>">-</span></small>
		</div>
		<div class="col-md-3 col-sm-3">
			<label>Est. Civil: </label> <small><span id="spn_estcivil<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Dirección: </label> <small><span id="spn_direccion<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-2 col-sm-2">
			<label>Teléfono: </label> <small><span id="spn_telefono<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-3 col-sm-3">
			<label>Correo: </label> <small><span id="spn_correoel<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-3 col-sm-3">
			<label>Ocupación: </label> <small><span id="spn_ocupacion<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-5 col-sm-5">
			<label>Acompañante: </label> <small><span id="spn_acomp<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-3 col-sm-3">
			<label>Teléfono: </label> <small><span id="spn_telacomp<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Parentesco: </label> <small><span id="spn_parentesco<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Ingreso Por: </label> <small><span id="spn_ingpor<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Observaciones: </label> <small><span id="spn_obs<?php echo $NumWindow; ?>">Sin datos</span></small>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Fecha Ingreso: </label> <span id="spn_fechaing<?php echo $NumWindow; ?>" class="badge">00/00/0000</span>
		</div>
		<div class="col-md-4 col-sm-4">
			<label>Tipo Paciente: </label> <span id="spn_tipopte<?php echo $NumWindow; ?>" >Sin datos</span>
		</div>
	</div>
	
		</div>

	</div>
<?php
if (isset($_GET["genesis"])) {
?>
<button type="button" class="btn btn-success btn-xs btn-block" onclick="javascript:Guardar_agendacitasnew('<?php echo $NumWindow; ?>');">Guardar</button>
<?php
	}
?>
</form>

<script >

function NombreTer<?php echo $NumWindow; ?>(fila, Codigo, tabla)
{
	$.get(Funciones,{'Func':'NombreTercero','value':Codigo, 'tabla':tabla},function(data){ 
		if (data=="No se encuentra el tercero") {
			swal('DOCUMENTO NO SE ENCUENTRA', data,'error');
			document.getElementById('txt_paciente2x'+fila+'<?php echo $NumWindow; ?>').value="";
			Texto="";
		} else {
			document.getElementById('txt_paciente2x'+fila+'<?php echo $NumWindow; ?>').value=data;
			Texto=data;
		}
		ShowHistoryx<?php echo $NumWindow; ?>(Texto, Codigo, fila);
	}); 
}


function ShowHistoryx<?php echo $NumWindow; ?>(Texto, Pcte, Konta) {
 if(Texto=="") {
	document.getElementById('spn_pctex'+Konta+'<?php echo $NumWindow; ?>').innerHTML='<button class="btn btn-default" type="button" disabled><span class="glyphicon glyphicon-folder-close" aria-hidden="true"></span></button>';
 } else {
	document.getElementById('spn_pctex'+Konta+'<?php echo $NumWindow; ?>').innerHTML='<button title="Ver histórico de citas" class="btn btn-primary" type="button" data-toggle="modal" data-target="#GnmX_WinModal" data-whatever="Paciente" onclick="javascript:PcteCitas<?php echo $NumWindow; ?>(\''+Pcte+'\');"><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span></button>';
 }
}

function PcteCitas<?php echo $NumWindow; ?>(history) {
	CargarWind('Historial Citas Pacientes ', 'forms/citashistory.php?IdPte='+history+'&mode=modal&wnd=agendacitas', 'folder_user.png', 'agendacitasrpgr.php','<?php echo $NumWindow; ?>' );
}

function FechaCerca<?php echo $NumWindow; ?>(FechaD, Especialidad) {

	getCal<?php echo $NumWindow; ?>();
}	

function UpdtMonth<?php echo $NumWindow; ?>(fechaNueva) {
	document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value=fechaNueva;
	getCal<?php echo $NumWindow; ?>();
}

function AgendaDia<?php echo $NumWindow; ?>(Medico,TheFecha, TheAre) {
	FillAgenda('<?php echo $NumWindow; ?>', Medico, TheFecha, TheAre);
}

function ShowAgendas<?php echo $NumWindow; ?>(TheFecha) {
	document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value=TheFecha;
	CargarMedicosCx('<?php echo $NumWindow; ?>', '<?php echo $theArea; ?>', TheFecha);
	
}

function getCal<?php echo $NumWindow; ?>() {
	variaBles="";
	if (document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value!="0000-00-00") {
		variaBles=variaBles+"&mescal="+document.frm_form<?php echo $NumWindow; ?>.hdn_mescal<?php echo $NumWindow; ?>.value;
	}
	variaBles=variaBles+"&TheArea="+document.frm_form<?php echo $NumWindow; ?>.cmb_areas<?php echo $NumWindow; ?>.value;
	variaBles=variaBles+"&fechadeseada="+document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value;
	variaBles=variaBles+"&tipoconsulta="+document.frm_form<?php echo $NumWindow; ?>.cmb_primeravez<?php echo $NumWindow; ?>.value;
	AbrirForm('application/forms/agendacitas.php', '<?php echo $NumWindow; ?>', variaBles);
}

function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/agendacitas.php', '<?php echo $NumWindow; ?>', '');	
}

function LoadPcte<?php echo $NumWindow; ?>(fila) {
	IdPte=document.getElementById('txt_paciente'+fila+'<?php echo $NumWindow; ?>').value;
	CargarWind('Pacientes ', 'forms/pacientes.php?IdPte='+IdPte+'&mode=modal&wnd=agendacitas', '1.PatientMale.png', 'agendacitas.php','<?php echo $NumWindow; ?>' );
}

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");
 

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
