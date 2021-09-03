<?php

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
	<div class="row">
<input name="hdn_codage<?php echo $NumWindow; ?>" type="hidden" id="hdn_codage<?php echo $NumWindow; ?>" value="0" />
			
		<div class="col-md-2">

	<div class="form-group" >
		<label for="txt_idempleado<?php echo $NumWindow; ?>">Profesional</label>
		<div class="input-group" id="grp_txt_idempleado<?php echo $NumWindow; ?>">	
			<input name="hdn_tercero<?php echo $NumWindow; ?>" type="hidden" id="hdn_tercero<?php echo $NumWindow; ?>" value="" />
			<input name="txt_idempleado<?php echo $NumWindow; ?>" id="txt_idempleado<?php echo $NumWindow; ?>" type="text" maxlength="15" onkeypress="LoadAgenda<?php echo $NumWindow; ?>(event);" onblur="CargarAgenda<?php echo $NumWindow; ?>();" required/>
			<span class="input-group-btn">	
				<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Medico" onclick="javascript:CargarSearch('ProfesionalesSalud', 'txt_idempleado<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
			</span>
		</div>
	</div>
	
		</div>
		<div class="col-md-4">

	<div class="form-group">
		<label for="txt_paciente<?php echo $NumWindow; ?>">Nombre</label>
		<input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>
	
		</div>
		<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_especialidad<?php echo $NumWindow; ?>">Especialidad</label>
		<select name="cmb_especialidad<?php echo $NumWindow; ?>" id="cmb_especialidad<?php echo $NumWindow; ?>">
		<?php 
	if (isset($_GET["IdMed"])) {
		$SQL="Select a.Codigo_ESP, a.Nombre_ESP from gxespecialidades a, gxmedicosesp b, czterceros c where a.Codigo_ESP=b.Codigo_ESP and b.Codigo_TER=c.Codigo_TER and ID_TER='".$_GET["IdMed"]."' and a.Estado_ESP='1' order by 2";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) 
			{
		 ?>
		  <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
		<?php
			}
		mysqli_free_result($result);
	} 
	 	?>  
		</select>
	</div>
	
		</div>
		<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_area<?php echo $NumWindow; ?>">Area de Servicio</label>
		<select name="cmb_area<?php echo $NumWindow; ?>" id="cmb_area<?php echo $NumWindow; ?>" onchange="CargarAgenda<?php echo $NumWindow; ?>();">
		<?php 
		$Area="0";
		if (isset($_GET["IdMed"])) {
			$SQL="Select a.Codigo_ARE, Nombre_ARE from gxareas a where Estado_ARE='1' and AgendaCitas_ARE='1' and a.Codigo_ARE in (Select b.Codigo_ARE from itusuariosareas b, czterceros c, gxmedicos d where d.Codigo_TER=c.Codigo_TER and b.Codigo_USR=d.Codigo_USR and ID_TER='".$_GET["IdMed"]."') order by 2";
		} else {
			$SQL="Select Codigo_ARE, Nombre_ARE from gxareas where Estado_ARE='1' and AgendaCitas_ARE='1' order by 2";
		}
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_array($result)) 
		{
	 ?>
	  <option value="<?php echo $row[0]; ?>"><?php echo ($row[1]); ?></option>
	<?php
			if ($Area=="0") {
				$Area=$row[0];
			}
		}
	mysqli_free_result($result); 
	 ?>  
		</select>
	</div>
	
		</div>	
		<div class="col-md-2">

	<div class="form-group">
		<label for="cmb_consultorio<?php echo $NumWindow; ?>">Consultorio</label>
		<select name="cmb_consultorio<?php echo $NumWindow; ?>" id="cmb_consultorio<?php echo $NumWindow; ?>">
		<?php 
		if (isset($_GET["Area"])) {
			$Area=$_GET["Area"];
		}
		$SQL="Select a.Codigo_CNS, a.Nombre_CNS from gxconsultorios a where Codigo_ARE='".$Area."' and a.Estado_CNS='1' order by 2";
		echo $SQL;
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
		
	</div>
	<div class="row">

		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_fecha<?php echo $NumWindow; ?>">Fecha Programación</label>
		<input  name="txt_fecha<?php echo $NumWindow; ?>" id="txt_fecha<?php echo $NumWindow; ?>" type="date" required class="form-control" onchange="semana<?php echo $NumWindow; ?>(document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value);" />
	</div>

		</div>
		<div class="col-md-2">

		<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
			<label for="txt_fini<?php echo $NumWindow; ?>">Fecha Inicial</label>
			<input  name="txt_fini<?php echo $NumWindow; ?>" style="font-size:15px; font-weight: bold; color:#0E5012; " id="txt_fini<?php echo $NumWindow; ?>" type="date" required class="form-control" disabled="disabled" />
		</div>

			</div>
			<div class="col-md-2">

		<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
			<label for="txt_ffin<?php echo $NumWindow; ?>">Fecha Final</label>
			<input  name="txt_ffin<?php echo $NumWindow; ?>" style="font-size:15px; font-weight: bold; color:#0E5012; " id="txt_ffin<?php echo $NumWindow; ?>" type="date" required class="form-control"  disabled="disabled" />
		</div>

			</div>
			<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_hini<?php echo $NumWindow; ?>">Hora Inicial</label>
		<input  name="txt_hini<?php echo $NumWindow; ?>" id="txt_hini<?php echo $NumWindow; ?>" type="time" required class="form-control" />
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
		<label for="txt_hfin<?php echo $NumWindow; ?>">Hora Final</label>
		<input  name="txt_hfin<?php echo $NumWindow; ?>" id="txt_hfin<?php echo $NumWindow; ?>" type="time" required class="form-control" onkeyup=""/>
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_minutos<?php echo $NumWindow; ?>" title="Minutos por Consulta">Tiempo</label>
		<input  name="txt_minutos<?php echo $NumWindow; ?>" id="txt_minutos<?php echo $NumWindow; ?>" type="number" min="2" class="form-control" required title="Minutos por Consulta" />
	</div>

		</div>
			<div class="col-md-1">

		<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
			<label for="txt_totcons<?php echo $NumWindow; ?>">No. Consultas</label>
			<input  name="txt_totcons<?php echo $NumWindow; ?>" style="font-size:15px; font-weight: bold; color:#0E5012; " id="txt_totcons<?php echo $NumWindow; ?>" type="number" required class="form-control" disabled="disabled" value="0"/>
		</div>

			</div>
			<div class="col-md-2 ">

		<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
			<label for="btnagenda<?php echo $NumWindow; ?>">Generar </label><br>
			<button type="button" class="btn btn-success btn-block" id="btnagenda<?php echo $NumWindow; ?>" onclick="CalcHorasCons<?php echo $NumWindow; ?>();"> <span class="glyphicon glyphicon-cog" aria-hidden="true"></span></button>
		</div>

			</div>

	</div>
	<div class="row">

		<div class="col-md-2">
			<span class="label label-default" id="spnlunes<?php echo $NumWindow; ?>">.</span>
			<input name="hdn_fechalun<?php echo $NumWindow; ?>" type="hidden" id="hdn_fechalun<?php echo $NumWindow; ?>" value="0000-00-00" />
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallelun<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallelun<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th2<?php echo $NumWindow; ?>" colspan="2">LUNES</th> 
				</tr> 


				</tbody>
				</table><input name="hdn_controwlun<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwlun<?php echo $NumWindow; ?>" value="0" />
			</div>
			<div class="row">
				<div class="col-lg-12">
				    <div class="input-group">
				      <span class="input-group-addon btn-success">
				        <input type="checkbox" aria-label="..." id="chk_lun<?php echo $NumWindow; ?>" onclick="javascript:MarcarTodos<?php echo $NumWindow; ?>('lun');">
				      </span>
				      <input type="text" class="form-control" aria-label="..." disabled="disabled" value="0 Consultas" id="cns_lunx<?php echo $NumWindow; ?>"><input name="cns_lun<?php echo $NumWindow; ?>" type="hidden" id="cns_lun<?php echo $NumWindow; ?>" value="0" />
				    </div><!-- /input-group -->
				  </div>
			</div>
		</div>
		<div class="col-md-2">
			<span class="label label-default" id="spnmartes<?php echo $NumWindow; ?>">..</span>
			<input name="hdn_fechamar<?php echo $NumWindow; ?>" type="hidden" id="hdn_fechamar<?php echo $NumWindow; ?>" value="0000-00-00" />
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallemar<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallemar<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th2<?php echo $NumWindow; ?>" colspan="2">MARTES</th> 
				</tr> 


				</tbody>
				</table><input name="hdn_controwmar<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwmar<?php echo $NumWindow; ?>" value="0" />
			</div>
			<div class="row">
				<div class="col-lg-12">
				    <div class="input-group">
				      <span class="input-group-addon btn-success">
				        <input type="checkbox" aria-label="..." id="chk_mar<?php echo $NumWindow; ?>" onclick="javascript:MarcarTodos<?php echo $NumWindow; ?>('mar');">
				      </span>
				      <input type="text" class="form-control" aria-label="..." disabled="disabled" value="0 Consultas" id="cns_marx<?php echo $NumWindow; ?>"><input name="cns_mar<?php echo $NumWindow; ?>" type="hidden" id="cns_mar<?php echo $NumWindow; ?>" value="0" />
				    </div><!-- /input-group -->
				  </div>
			</div>
		</div>
		<div class="col-md-2">
			<span class="label label-default" id="spnmiercoles<?php echo $NumWindow; ?>">...</span>
			<input name="hdn_fechamie<?php echo $NumWindow; ?>" type="hidden" id="hdn_fechamie<?php echo $NumWindow; ?>" value="0000-00-00" />
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallemie<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallemie<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th2<?php echo $NumWindow; ?>" colspan="2">MIERCOLES</th> 
				</tr> 


				</tbody>
				</table><input name="hdn_controwmie<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwmie<?php echo $NumWindow; ?>" value="0" />
			</div>
			<div class="row">
				<div class="col-lg-12">
				    <div class="input-group">
				      <span class="input-group-addon btn-success">
				        <input type="checkbox" aria-label="..." id="chk_mie<?php echo $NumWindow; ?>" onclick="javascript:MarcarTodos<?php echo $NumWindow; ?>('mie');">
				      </span>
				      <input type="text" class="form-control" aria-label="..." disabled="disabled" value="0 Consultas" id="cns_miex<?php echo $NumWindow; ?>"><input name="cns_mie<?php echo $NumWindow; ?>" type="hidden" id="cns_mie<?php echo $NumWindow; ?>" value="0" />
				    </div><!-- /input-group -->
				  </div>
			</div>
		</div>
		<div class="col-md-2">
			<span class="label label-default" id="spnjueves<?php echo $NumWindow; ?>">....</span>
			<input name="hdn_fechajue<?php echo $NumWindow; ?>" type="hidden" id="hdn_fechajue<?php echo $NumWindow; ?>" value="0000-00-00" />
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallejue<?php echo $NumWindow; ?>" >
				<tbody id="tblDetallejue<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th2<?php echo $NumWindow; ?>" colspan="2">JUEVES</th> 
				</tr> 


				</tbody>
				</table><input name="hdn_controwjue<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwjue<?php echo $NumWindow; ?>" value="0" />
			</div>
			<div class="row">
				<div class="col-lg-12">
				    <div class="input-group">
				      <span class="input-group-addon btn-success">
				        <input type="checkbox" aria-label="..." id="chk_jue<?php echo $NumWindow; ?>" onclick="javascript:MarcarTodos<?php echo $NumWindow; ?>('jue');">
				      </span>
				      <input type="text" class="form-control" aria-label="..." disabled="disabled" value="0 Consultas" id="cns_juex<?php echo $NumWindow; ?>"><input name="cns_jue<?php echo $NumWindow; ?>" type="hidden" id="cns_jue<?php echo $NumWindow; ?>" value="0" />
				    </div><!-- /input-group -->
				  </div>
			</div>
		</div>
		<div class="col-md-2">
			<span class="label label-default" id="spnviernes<?php echo $NumWindow; ?>">.....</span>
			<input name="hdn_fechavie<?php echo $NumWindow; ?>" type="hidden" id="hdn_fechavie<?php echo $NumWindow; ?>" value="0000-00-00" />
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallevie<?php echo $NumWindow; ?>" >
				<tbody id="tbDetallevie<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th2<?php echo $NumWindow; ?>" colspan="2">VIERNES</th> 
				</tr> 
				

				</tbody>
				</table><input name="hdn_controwvie<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwvie<?php echo $NumWindow; ?>" value="0" />
			</div>
			<div class="row">
				<div class="col-lg-12">
				    <div class="input-group">
				      <span class="input-group-addon btn-success">
				        <input type="checkbox" aria-label="..." id="chk_vie<?php echo $NumWindow; ?>" onclick="javascript:MarcarTodos<?php echo $NumWindow; ?>('vie');">
				      </span>
				      <input type="text" class="form-control" aria-label="..." disabled="disabled" value="0 Consultas" id="cns_viex<?php echo $NumWindow; ?>"><input name="cns_vie<?php echo $NumWindow; ?>" type="hidden" id="cns_vie<?php echo $NumWindow; ?>" value="0" />
				    </div><!-- /input-group -->
				  </div>
			</div>
		</div>
		<div class="col-md-2">
			<span class="label label-default" id="spnsabado<?php echo $NumWindow; ?>">......</span>
			<input name="hdn_fechasab<?php echo $NumWindow; ?>" type="hidden" id="hdn_fechasab<?php echo $NumWindow; ?>" value="0000-00-00" />
			<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
				<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallesab<?php echo $NumWindow; ?>" >
				<tbody id="tblDetallesab<?php echo $NumWindow; ?>">
				<tr id="trh<?php echo $NumWindow; ?>"> 
					<th id="th2<?php echo $NumWindow; ?>" colspan="2">SABADO</th> 
				</tr> 


				</tbody>
				</table><input name="hdn_controwsab<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwsab<?php echo $NumWindow; ?>" value="0" />
			</div>
			<div class="row">
				<div class="col-lg-12">
				    <div class="input-group">
				      <span class="input-group-addon btn-success">
				        <input type="checkbox" aria-label="..." id="chk_sab<?php echo $NumWindow; ?>" onclick="javascript:MarcarTodos<?php echo $NumWindow; ?>('sab');">
				      </span>
				      <input type="text" class="form-control" aria-label="..." disabled="disabled" value="0 Consultas" id="cns_sabx<?php echo $NumWindow; ?>"><input name="cns_sab<?php echo $NumWindow; ?>" type="hidden" id="cns_sab<?php echo $NumWindow; ?>" value="0" />
				    </div><!-- /input-group -->
				  </div>
			</div>
		</div>
	</div>
	<div class="row panel-default">
		<div class="col-md-2">
		<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
			<label for="txt_fext<?php echo $NumWindow; ?>">Extender hasta</label>
			<input  name="txt_fext<?php echo $NumWindow; ?>" id="txt_fext<?php echo $NumWindow; ?>" type="date" required class="form-control" onchange="LoadCal<?php echo $NumWindow; ?>();"/>
   	    </div>
		</div>
		<div class="col-md-10" >
		  <div id="CalExt<?php echo $NumWindow; ?>" name="CalExt<?php echo $NumWindow; ?>" class="detallecx table-responsive panel-body" >
		    <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetCitas<?php echo $NumWindow; ?>" >
        	  <tbody id="tbDetallemar<?php echo $NumWindow; ?>">
			   <tr>
			   <th width="10%"><span class="glyphicon glyphicon-check" aria-hidden="true"></span> </th><th width="15%">Lun</th><th width="15%">Mar</th><th width="15%">Mie</th><th width="15%">Jue</th><th width="15%">Vie</th><th width="15%">Sab</th>
			   </tr>
			   
			  </tbody>
			</table>
		  </div>
		</div>
	</div>
</div>

</form>

<script >

<?php
	
	if (isset($_GET["IdMed"])) {
		if (trim($_GET["IdMed"])!="") {
			$SQL="Select Codigo_TER, Nombre_TER From  czterceros a Where  ID_TER='".$_GET["IdMed"]."'";
			$result = mysqli_query($conexion, $SQL);
			if ($row = mysqli_fetch_array($result)) {
			echo "
				document.frm_form".$NumWindow.".txt_idempleado".$NumWindow.".value='".$_GET["IdMed"]."';
				document.frm_form".$NumWindow.".txt_paciente".$NumWindow.".value='".$row[1]."';
				document.frm_form".$NumWindow.".hdn_tercero".$NumWindow.".value='".$row[0]."';";
			}
			mysqli_free_result($result); 
		}
	} else {
		
	}
	echo "
	document.frm_form".$NumWindow.".txt_hini".$NumWindow.".value='08:00';
	document.frm_form".$NumWindow.".txt_hfin".$NumWindow.".value='18:00';
	document.frm_form".$NumWindow.".txt_minutos".$NumWindow.".value='15';
	";
	$SQL="Select date(now());";
	$result = mysqli_query($conexion, $SQL);
	if ($row = mysqli_fetch_array($result))  {
		echo "
		document.frm_form".$NumWindow.".txt_fecha".$NumWindow.".value='".$row[0]."';";
	}
	mysqli_free_result($result); 
	
	$SQL="Select HoraIni_ARE, HoraFin_ARE, TiempoConsulta_ARE From gxareas Where Codigo_ARE in (Select Codigo_ARE from gxareas where Estado_ARE='1' and AgendaCitas_ARE='1' order by Nombre_ARE ) Limit 1;";
	$result = mysqli_query($conexion, $SQL);
	if ($row = mysqli_fetch_array($result))  {
		echo "
		document.frm_form".$NumWindow.".txt_hini".$NumWindow.".value='".$row[0]."';
		document.frm_form".$NumWindow.".txt_hfin".$NumWindow.".value='".$row[1]."';
		document.frm_form".$NumWindow.".txt_minutos".$NumWindow.".value='".$row[2]."';";
	}
	mysqli_free_result($result); 
	
	if (isset($_GET["Fecha"])) {
		echo "
		document.frm_form".$NumWindow.".txt_fecha".$NumWindow.".value='".$_GET["Fecha"]."';";	
	}
	if (isset($_GET["Area"])) {
		echo "
		document.frm_form".$NumWindow.".cmb_area".$NumWindow.".value='".$_GET["Area"]."';";
	}
	if (isset($_GET["HIni"])) {
		echo "
		document.frm_form".$NumWindow.".txt_hini".$NumWindow.".value='".$_GET["HIni"]."';";	
	}
	if (isset($_GET["HFin"])) {
		echo "
		document.frm_form".$NumWindow.".txt_hfin".$NumWindow.".value='".$_GET["HFin"]."';";	
	}
	if (isset($_GET["Time"])) {
		echo "
		document.frm_form".$NumWindow.".txt_minutos".$NumWindow.".value='".$_GET["Time"]."';";	
	}
?>

semana<?php echo $NumWindow; ?>(document.frm_form<?php echo $NumWindow; ?>.txt_fecha<?php echo $NumWindow; ?>.value);
AgendaZero<?php echo $NumWindow; ?>();
AgendaIni<?php echo $NumWindow; ?>();

function LoadCal<?php echo $NumWindow; ?>()
{

}

function semana<?php echo $NumWindow; ?>(Fecha) 
{
	Fechaz ="" + Fecha;
	dia=Fechaz.substring(8, 10);
	anio=Fechaz.substring(0, 4);
	mez=Fechaz.substring(5, 7);
	meses = ["January","February","March","April","May","June","July","August","September" ,"October","November","December"];
	mes=meses[mez-1];
	dt = new Date(mes+' '+dia+', '+anio);
	diasemana=dt.getUTCDay();
	d1 = dt.getTime() + ((1-diasemana)*24*60*60*1000);
	dlun=new Date(d1);
	document.getElementById('txt_fini<?php echo $NumWindow; ?>').value=dlun.getFullYear()+"-"+(('0' + (dlun.getMonth()+1)).slice(-2))+"-"+(('0' + dlun.getDate()).slice(-2));
	document.getElementById('spnlunes<?php echo $NumWindow; ?>').innerHTML=dlun.getFullYear()+"-"+(('0' + (dlun.getMonth()+1)).slice(-2))+"-"+(('0' + dlun.getDate()).slice(-2));
	document.getElementById('hdn_fechalun<?php echo $NumWindow; ?>').value=dlun.getFullYear()+"-"+(('0' + (dlun.getMonth()+1)).slice(-2))+"-"+(('0' + dlun.getDate()).slice(-2));
	d2 = dt.getTime() + ((2-diasemana)*24*60*60*1000);
	dmar=new Date(d2);
	document.getElementById('spnmartes<?php echo $NumWindow; ?>').innerHTML=dmar.getFullYear()+"-"+(('0' + (dmar.getMonth()+1)).slice(-2))+"-"+(('0' + dmar.getDate()).slice(-2));
	document.getElementById('hdn_fechamar<?php echo $NumWindow; ?>').value=dmar.getFullYear()+"-"+(('0' + (dmar.getMonth()+1)).slice(-2))+"-"+(('0' + dmar.getDate()).slice(-2));
	d3 = dt.getTime() + ((3-diasemana)*24*60*60*1000);
	dmie=new Date(d3);
	document.getElementById('spnmiercoles<?php echo $NumWindow; ?>').innerHTML=dmie.getFullYear()+"-"+(('0' + (dmie.getMonth()+1)).slice(-2))+"-"+(('0' + dmie.getDate()).slice(-2));
	document.getElementById('hdn_fechamie<?php echo $NumWindow; ?>').value=dmie.getFullYear()+"-"+(('0' + (dmie.getMonth()+1)).slice(-2))+"-"+(('0' + dmie.getDate()).slice(-2));
	d4 = dt.getTime() + ((4-diasemana)*24*60*60*1000);
	djue=new Date(d4);
	document.getElementById('spnjueves<?php echo $NumWindow; ?>').innerHTML=djue.getFullYear()+"-"+(('0' + (djue.getMonth()+1)).slice(-2))+"-"+(('0' + djue.getDate()).slice(-2));
	document.getElementById('hdn_fechajue<?php echo $NumWindow; ?>').value=djue.getFullYear()+"-"+(('0' + (djue.getMonth()+1)).slice(-2))+"-"+(('0' + djue.getDate()).slice(-2));
	d5 = dt.getTime() + ((5-diasemana)*24*60*60*1000);
	dvie=new Date(d5);
	document.getElementById('spnviernes<?php echo $NumWindow; ?>').innerHTML=dvie.getFullYear()+"-"+(('0' + (dvie.getMonth()+1)).slice(-2))+"-"+(('0' + dvie.getDate()).slice(-2));
	document.getElementById('hdn_fechavie<?php echo $NumWindow; ?>').value=dvie.getFullYear()+"-"+(('0' + (dvie.getMonth()+1)).slice(-2))+"-"+(('0' + dvie.getDate()).slice(-2));
	d6 = dt.getTime() + ((6-diasemana)*24*60*60*1000);
	dsab=new Date(d6);
	document.getElementById('spnsabado<?php echo $NumWindow; ?>').innerHTML=dsab.getFullYear()+"-"+(('0' + (dsab.getMonth()+1)).slice(-2))+"-"+(('0' + dsab.getDate()).slice(-2));
	document.getElementById('hdn_fechasab<?php echo $NumWindow; ?>').value=dsab.getFullYear()+"-"+(('0' + (dsab.getMonth()+1)).slice(-2))+"-"+(('0' + dsab.getDate()).slice(-2));
	document.getElementById('txt_ffin<?php echo $NumWindow; ?>').value=dsab.getFullYear()+"-"+(('0' + (dsab.getMonth()+1)).slice(-2))+"-"+(('0' + dsab.getDate()).slice(-2));
	document.getElementById('txt_fext<?php echo $NumWindow; ?>').value=dsab.getFullYear()+"-"+(('0' + (dsab.getMonth()+1)).slice(-2))+"-"+(('0' + dsab.getDate()).slice(-2));
	
}

function CalcHorasCons<?php echo $NumWindow; ?>() {
	MsgBox1("Advertencia","Esta accion modificará cualquier agendamiento previo del profesional "+document.frm_form<?php echo $NumWindow; ?>.txt_paciente<?php echo $NumWindow; ?>.value+" en el periodo comprendido entre el "+document.frm_form<?php echo $NumWindow; ?>.txt_fini<?php echo $NumWindow; ?>.value+" y el "+document.frm_form<?php echo $NumWindow; ?>.txt_ffin<?php echo $NumWindow; ?>.value);
	AgendaZero<?php echo $NumWindow; ?>();
	AgendaIni<?php echo $NumWindow; ?>();
} 

function AgendaIni<?php echo $NumWindow; ?>() {
	var horaini = (document.getElementById('txt_hini<?php echo $NumWindow; ?>').value).split(":");
    horafin = (document.getElementById('txt_hfin<?php echo $NumWindow; ?>').value).split(":");
    tini = new Date();
    tfin = new Date();
    ttotal = new Date();
	 
	tini.setHours(horaini[0], horaini[1], '00');
	tfin.setHours(horafin[0], horafin[1], '00');
	 
	//Aquí hago la resta
	ttotal.setHours(tfin.getHours() - tini.getHours(), tfin.getMinutes() - tini.getMinutes(), '00');
	TotalMins=ttotal.getHours()*60+ttotal.getMinutes();
	TiempoConsulta=document.getElementById('txt_minutos<?php echo $NumWindow; ?>').value;
	NumConsxDia=Math.floor(TotalMins/TiempoConsulta);
	
	tactual = new Date();
	tactual=tini;
	for (i = 1; i <= NumConsxDia; i++) { 
		
		lahora=tactual.getHours();
		if (lahora <10) lahora='0'+lahora;
		elminuto=tactual.getMinutes();
		if (elminuto <10) elminuto='0'+elminuto;
		
		horaactual=lahora +':' + elminuto +':00';

		FillHours<?php echo $NumWindow; ?>('lun', horaactual, i);
		FillHours<?php echo $NumWindow; ?>('mar', horaactual, i);
		FillHours<?php echo $NumWindow; ?>('mie', horaactual, i);
		FillHours<?php echo $NumWindow; ?>('jue', horaactual, i);
		FillHours<?php echo $NumWindow; ?>('vie', horaactual, i);
		FillHours<?php echo $NumWindow; ?>('sab', horaactual, i);

		tactual.setSeconds(TiempoConsulta*60);
	}
	
}

function FillHours<?php echo $NumWindow; ?>(diasemana, horaactual, TotalFilas) {
	/*
	    TotalFilas=document.getElementById("hdn_controw"+diasemana+"<?php echo $NumWindow; ?>").value;
	    */
	    var miTabla = document.getElementById("tblDetalle"+diasemana+"<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    /* TotalFilas++; */
		fila.id="tr"+diasemana+TotalFilas+"<?php echo $NumWindow; ?>";
		StateHour='0';
		StateChck="";
		prof=document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value;
		area=document.getElementById('cmb_area<?php echo $NumWindow; ?>').value;
		fechadia=document.getElementById('hdn_fecha'+diasemana+'<?php echo $NumWindow; ?>').value;
		
		$.get(Funciones,{'Func':'HourAgenda','prof':prof,'hora':horaactual,'fecha':fechadia,'area':area},function(data){ 
			StateHour=data;
			StateChck="";
			if (StateHour=="1") {
				StateChck=" checked ";
				console.log(fechadia+'. '+horaactual+': '+StateHour);
			}
			celda1.innerHTML = '<div class="checkbox checkbox-success">	<input name="chk_'+diasemana+TotalFilas+'chk<?php echo $NumWindow; ?>" id="chk_'+diasemana+TotalFilas+'chk<?php echo $NumWindow; ?>" type="checkbox" value="'+StateHour+'"  onclick="javascript:calcconsultas<?php echo $NumWindow; ?>(\''+diasemana+'\');" '+StateChck+' class="styled"> <label for="chk_'+diasemana+TotalFilas+'chk<?php echo $NumWindow; ?>"></label>  </div>'; 
			celda2.innerHTML = '<input name="hdn_'+diasemana+'time'+TotalFilas+'<?php echo $NumWindow; ?>" type="time" id="hdn_'+diasemana+'time'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ horaactual +'" style="height: 24px; border:none;"/>';
			fila.appendChild(celda1); 
			fila.appendChild(celda2); 
		    miTabla.appendChild(fila); 
			document.getElementById("hdn_controw"+diasemana+"<?php echo $NumWindow; ?>").value=TotalFilas;
			calcconsultas<?php echo $NumWindow; ?>(diasemana);
		}); 

}

function MarcarTodos<?php echo $NumWindow; ?>(dia) {
	TotalConsultas=document.getElementById('hdn_controw'+dia+'<?php echo $NumWindow; ?>').value;
	Chekear="false";
	if(document.getElementById('chk_'+dia+'<?php echo $NumWindow; ?>').checked) {
		Chekear="true";
	}
	for (i = 1; i <= TotalConsultas; i++) { 
		eval('window.document.frm_form<?php echo $NumWindow; ?>.chk_'+dia+i+'chk<?php echo $NumWindow; ?>.checked='+Chekear);
	}
	calcconsultas<?php echo $NumWindow; ?>(dia);
}

function calcconsultas<?php echo $NumWindow; ?>(dia){
	TotalConsultas=document.getElementById('hdn_controw'+dia+'<?php echo $NumWindow; ?>').value;
	Contador=0;
	for (i = 1; i <= TotalConsultas; i++) { 
		document.getElementById('chk_'+dia+i+'chk<?php echo $NumWindow; ?>').value="0";
		if(document.getElementById('chk_'+dia+i+'chk<?php echo $NumWindow; ?>').checked) {
			document.getElementById('chk_'+dia+i+'chk<?php echo $NumWindow; ?>').value="1";
			Contador++;
		}
	}
	document.getElementById('cns_'+dia+'x<?php echo $NumWindow; ?>').value=Contador+ " CONSULTAS";
	document.getElementById('cns_'+dia+'<?php echo $NumWindow; ?>').value=Contador;
	Total=0;
	Total=Total+parseInt(document.getElementById('cns_lun<?php echo $NumWindow; ?>').value)+parseInt(document.getElementById('cns_mar<?php echo $NumWindow; ?>').value)+parseInt(document.getElementById('cns_mie<?php echo $NumWindow; ?>').value)+parseInt(document.getElementById('cns_jue<?php echo $NumWindow; ?>').value)+parseInt(document.getElementById('cns_vie<?php echo $NumWindow; ?>').value)+parseInt(document.getElementById('cns_sab<?php echo $NumWindow; ?>').value);
	document.getElementById('txt_totcons<?php echo $NumWindow; ?>').value=Total;
}

function AgendaZero<?php echo $NumWindow; ?>() {
	totallun=document.frm_form<?php echo $NumWindow; ?>.hdn_controwlun<?php echo $NumWindow; ?>.value;
	for (i = 1; i <= totallun; i++) { 
	    $('#trlun'+i+"<?php echo $NumWindow; ?>").remove();
	}
	document.frm_form<?php echo $NumWindow; ?>.hdn_controwlun<?php echo $NumWindow; ?>.value="0";
	totalmar=document.frm_form<?php echo $NumWindow; ?>.hdn_controwmar<?php echo $NumWindow; ?>.value;
	for (i = 1; i <= totalmar; i++) { 
	    $('#trmar'+i+"<?php echo $NumWindow; ?>").remove();
	}
	document.frm_form<?php echo $NumWindow; ?>.hdn_controwmar<?php echo $NumWindow; ?>.value="0";
	totalmie=document.frm_form<?php echo $NumWindow; ?>.hdn_controwmie<?php echo $NumWindow; ?>.value;
	for (i = 1; i <= totalmie; i++) { 
	    $('#trmie'+i+"<?php echo $NumWindow; ?>").remove();
	}
	document.frm_form<?php echo $NumWindow; ?>.hdn_controwmie<?php echo $NumWindow; ?>.value="0";
	totaljue=document.frm_form<?php echo $NumWindow; ?>.hdn_controwjue<?php echo $NumWindow; ?>.value;
	for (i = 1; i <= totaljue; i++) { 
	    $('#trjue'+i+"<?php echo $NumWindow; ?>").remove();
	}
	document.frm_form<?php echo $NumWindow; ?>.hdn_controwjue<?php echo $NumWindow; ?>.value="0";
	totalvie=document.frm_form<?php echo $NumWindow; ?>.hdn_controwvie<?php echo $NumWindow; ?>.value;
	for (i = 1; i <= totalvie; i++) { 
	    $('#trvie'+i+"<?php echo $NumWindow; ?>").remove();
	}
	document.frm_form<?php echo $NumWindow; ?>.hdn_controwvie<?php echo $NumWindow; ?>.value="0";
	totalsab=document.frm_form<?php echo $NumWindow; ?>.hdn_controwsab<?php echo $NumWindow; ?>.value;
	for (i = 1; i <= totalsab; i++) { 
	    $('#trsab'+i+"<?php echo $NumWindow; ?>").remove();
	}
	document.frm_form<?php echo $NumWindow; ?>.hdn_controwsab<?php echo $NumWindow; ?>.value="0";
	
}

function AddHoraDia<?php echo $NumWindow; ?>(dia, fecha, hora) {
	Indicacion=Indicacion.toUpperCase();
		TotalFilas=document.getElementById("hdn_controwTto<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbTtmntoX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
		TotalFilas++;
		fila.id="tr"+TotalFilas+"<?php echo $NumWindow; ?>";
	    celda1.innerHTML = '<input name="hdn_indicacion'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_indicacion'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Indicacion+''+'" /> - '+Indicacion; 
		celda2.innerHTML = '<button onclick="EliminarFilaTto<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwTto<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_indicaciones<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_indicaciones<?php echo $NumWindow; ?>').focus();
}

function LoadAgenda<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
  	CargarAgenda<?php echo $NumWindow; ?>();
  }
}

function CargarAgenda<?php echo $NumWindow; ?>() {
	HoraIni=document.getElementById('txt_hini<?php echo $NumWindow; ?>').value;
	HoraFin=document.getElementById('txt_hfin<?php echo $NumWindow; ?>').value;
	Tiempoz=document.getElementById('txt_minutos<?php echo $NumWindow; ?>').value;
	Area=document.getElementById('cmb_area<?php echo $NumWindow; ?>').value;
	Fechaz=document.getElementById('txt_fecha<?php echo $NumWindow; ?>').value;
  	if (document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/agenda.php', '<?php echo $NumWindow; ?>', '&Area='+Area+'&Fecha='+Fechaz+'&HIni='+HoraIni+'&HFin='+HoraFin+'&Time='+Tiempoz);
	} else {
		AbrirForm('application/forms/agenda.php', '<?php echo $NumWindow; ?>', '&IdMed='+document.getElementById('txt_idempleado<?php echo $NumWindow; ?>').value+'&Area='+Area+'&Fecha='+Fechaz+'&HIni='+HoraIni+'&HFin='+HoraFin+'&Time='+Tiempoz);
	}  
}

function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/agenda.php', '<?php echo $NumWindow; ?>', '');	
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
