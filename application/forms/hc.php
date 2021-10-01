<?php
	session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	if (isset($_GET["ModeHC"])) {
		$ModeHC=$_GET["ModeHC"];
	} else {
		$ModeHC="HC";
	}
	if (isset($_GET["Area"])) {
		$Area=$_GET["Area"];
	} else {
		$Area="";
	}
	$Kollapse=0;
	$Hystory=""; 
	$contarow=0;
	$SVHCT="0";
	$GlasgowHCT="0";
	$ConsentimientoHCT="0";
	$InsumosHCT="0";
	$AyudasDiagHCT="0";
	$MedHCT="0";
	$OrdenesHCT="0";
	$OrdQxHCT="0";
	$IndicacionesHCT="0";
	$ImgHCT="0";
	$Medico2HCT="0";
	$AntecedentesHCT="0";
	$DxHCT="0";
	$OdontogramaHCT="0";
	$ValHeridasHCT="0";
	$IncapacidadHCT="0";
	$FormatHCYes="0";
	$RiesgoEspecifHCT="0";
	$AntGineObsHCT="0";
	$EmbarazoActHCT="0";
	$RiesgoObstHCT="0";
	$CtrlParacObsHCT="0";
	$CtrlPreNatHCT="0";
	$RiesgoCardVHCT="0";
	$FraminghamHCT="0";
	$MedQuimioHCT="0";
	// Datos generales del pcte
	if (isset($_GET["Historia"])) {
		if (trim($_GET["Historia"])!="") {
			$Hystory=$_GET["Historia"];
			$SQL="Select a.Codigo_TER, b.Nombre_TER, YEAR(CURDATE())-YEAR(a.FechaNac_PAC) + IF(DATE_FORMAT(CURDATE(),'%m-%d') > DATE_FORMAT(a.FechaNac_PAC,'%m-%d'), 0 , -1 ) , a.Codigo_SEX  from  gxpacientes a, czterceros b where a.Codigo_TER=b.Codigo_TER and b.ID_TER='".$_GET["Historia"]."' ";
			$result = mysqli_query($conexion, $SQL);
			$SexoPcte="";
			$EdadPcte="";
			if($row = mysqli_fetch_array($result)) {
				$SexoPcte=$row[3];
				$EdadPcte= $row[2];
			}
			mysqli_free_result($result);
		}
	} else {
		$Hystory="";
	}
	
	$FormatHCX=1;
	if (isset($_GET["FormatoHC"])) {
		$SQL="Select Activo_HCT from hctipos where Codigo_HCT='".$_GET["FormatoHC"]."' ".$iSexPcte.";";
		$result = mysqli_query($conexion, $SQL);
		while($row = mysqli_fetch_array($result)) {
			$FormatHCX=$row[0];
		}
		mysqli_free_result($result);
	}
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" action="functions/php/nexus/uploads.php?route=images&class=terceros&style=profile&wind=<?php echo $NumWindow; ?>" enctype="multipart/form-data" target="upload_target" onreset="HCResetea<?php echo $NumWindow; ?>();">
	<div class="row">

		<div class="col-md-2 col-sm-4">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_idhc<?php echo $NumWindow; ?>">Paciente</label>
		<div class="input-group">	
			<span class="input-group-btn">	
	  			<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_WinModal" onclick="javascript:LoadPcte<?php echo $NumWindow; ?>();" title="Editar datos de Paciente"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></button>
	  		</span>
			<input style="font-size:15px;" name="txt_idhc<?php echo $NumWindow; ?>" id="txt_idhc<?php echo $NumWindow; ?>" type="text" required onkeypress="BuscarHCPte<?php echo $NumWindow; ?>(event);" onblur="HCPteOnBlur<?php echo $NumWindow; ?>()" />
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
		<div class="col-md-2 col-sm-3">

	<div class="form-group">
		<label for="cmb_area<?php echo $NumWindow; ?>">Area de Servicio</label>
		<select name="cmb_area<?php echo $NumWindow; ?>" id="cmb_area<?php echo $NumWindow; ?>">
		<?php 
	$SQL="Select Codigo_ARE, Nombre_ARE from gxareas where Estado_ARE='1' and Codigo_ARE in (Select Codigo_ARE from itusuariosareas where Codigo_USR='".$_SESSION["it_CodigoUSR"]."') order by 2";
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
		<div class="col-md-2 col-sm-3">
	
	<div class="form-group" id="grp_txt_hora<?php echo $NumWindow; ?>">
		<label for="txt_hora<?php echo $NumWindow; ?>">Hora</label>
		<input name="txt_hora<?php echo $NumWindow; ?>" id="txt_hora<?php echo $NumWindow; ?>" type="time" required value="00:00:00"/>
	</div>

		</div>
		<div class="col-md-1 col-sm-3">
	
	<div class="form-group">
		<label for="txt_ingreso<?php echo $NumWindow; ?>">Ingreso</label>
		<input style="font-size:15px; text-align:right;font-weight: bold;" name="txt_ingreso<?php echo $NumWindow; ?>" id="txt_ingreso<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
	</div>

		</div>
		<div class="col-md-1 col-sm-3">

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
		<?php 
		if ($FormatHCX=="1") {
			$coloralert="warning";
		} else {
			$coloralert="info";
		}
		?>
		<div class="col-md-9 col-sm-9 alert alert-<?php echo $coloralert; ?>">
	<div class="row">
		<div class="col-md-12 col-sm-12 label label-danger hidden" id="div_alertas">
			...
		</div>
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
	<div class="row">
		<div class="col-md-6 col-xs-6">
			<button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#GnmX_NXSMeet" onclick="nxs_meet1('hc')">
			  Iniciar Atención por Video <span class="glyphicon glyphicon-facetime-video" aria-hidden="true"></span> 
			</button>
		</div>
	</div>
		</div>
<?php 
if ($FormatHCX=="1") {
?>		
		<div class="btn-group col-md-3 col-sm-3">
			<button type="button" class="btn btn-success btn-sm btn-block" data-toggle="modal" data-target="#GnmX_WinModal" onclick="Selhc<?php echo $NumWindow; ?>();">
			  Seleccione Tipo HC <span class="glyphicon glyphicon-file" aria-hidden="true"></span> 
			</button>
		  
			
		</div>
<?php
}
?>
<input name="hdn_formatohc<?php echo $NumWindow; ?>" type="hidden" id="hdn_formatohc<?php echo $NumWindow; ?>" value="<?php if (isset($_GET["FormatoHC"])) { echo $_GET["FormatoHC"]; } ?>" />
		<div class="col-md-3 col-sm-3">

			 <div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
			<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalle<?php echo $NumWindow; ?>" >
			<tbody id="tbDetalle<?php echo $NumWindow; ?>">
			<tr id="trh<?php echo $NumWindow; ?>"> 
				<th id="th1<?php echo $NumWindow; ?>">#</th> 
				<th id="th2<?php echo $NumWindow; ?>">Fecha</th> 
			    <th id="th2<?php echo $NumWindow; ?>">Tipo</th> 
			</tr> 
				 <?php 
				 if (isset($_GET["Historia"])) {
				$SQL="Select a.Codigo_HCF, a.Fecha_HCF, b.Nombre_HCT, c.Nombre_ARE, d.Nombre_USR, e.ID_TER, a.Hora_HCF, Folio_HCF From hcfolios a, hctipos b, gxareas c, itusuarios d, czterceros e Where a.Codigo_HCT=b.Codigo_HCT and c.Codigo_ARE=a.Codigo_ARE and d.Codigo_USR=a.Codigo_USR and e.Codigo_TER=a.Codigo_TER and e.ID_TER='".$_GET["Historia"]."' Order By a.Fecha_HCF desc, a.Hora_HCF desc, a.Folio_HCF desc";
				$resulthc = mysqli_query($conexion, $SQL);
				$contarow=0;
				while($rowhc = mysqli_fetch_array($resulthc)) 
					{
						$contarow=$contarow+1;
						echo '
				  <tr onclick="ShowFolio'.$NumWindow.'(\''.$rowhc["ID_TER"].'\', \''.$rowhc["Folio_HCF"].'\');"><td align="center">'.$rowhc["Folio_HCF"].'</td><td align="center">'.formatofecha($rowhc[1]).'</td><td>'.$rowhc[2].'</td></tr>
				  ';
					}
				mysqli_free_result($resulthc); 
				 }
				 ?>  

			</tbody>
			</table><input name="hdn_controw<?php echo $NumWindow; ?>" type="hidden" id="hdn_controw<?php echo $NumWindow; ?>" value="<?php echo $contarow; ?>" />
			 </div>

	  		</div>
	  	<div id="divformatohc<?php echo $NumWindow; ?>" class="col-md-12 col-sm-12 divformatohc">
	  		<?php
	  		if (isset($_GET["FormatoHC"])) {
		  		$SQL="Select * from hctipos where Activo_HCT<>'0' and Codigo_HCT='".$_GET["FormatoHC"]."' ".$iSexPcte.";";
				$result = mysqli_query($conexion, $SQL);
				$FormatHCYes=0;
				while($row = mysqli_fetch_array($result)) {
					$FormatHCYes=1;
	  		?>
	  		<h4><label class="label label-default"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> <?php echo $row["Nombre_HCT"]; ?> <span id="NombrePCTE<?php echo $NumWindow; ?>"></span></label></h4>
	  		<div class="row well well-sm">
	  	<div class="col-md-2 col-sm-2">
	  		<ul class="nav nav-pills nav-stacked">
	  		  <?php if ($row["Antecedentes_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_antecedentes<?php echo $NumWindow; ?>" data-toggle="pill">Antecedentes</a></li>
			  <?php } ?>
			  <li role="presentation" class="active"><a href="#hc_tipo<?php echo $NumWindow; ?>" data-toggle="pill">Formato HC</a></li>
			  <?php if ($row["Dx_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_diagnosticos<?php echo $NumWindow; ?>" data-toggle="pill">Diagnósticos</a></li>
			  <?php } ?>
			  <?php if ($row["Odontograma_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_odontograma<?php echo $NumWindow; ?>" data-toggle="pill">Odontograma</a></li>
			  <?php } ?>
			  <?php if ($row["ValHeridas_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_valheridas<?php echo $NumWindow; ?>" data-toggle="pill">Ubicación Anatómica</a></li>
			  <?php } ?>
			  <?php if ($row["RiesgoEspecif_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_riesgoespecif<?php echo $NumWindow; ?>" data-toggle="pill">Ident. Riesgos Especif.</a></li>
			  <?php } ?>
			  <?php if ($row["RiesgoCardV_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_riesgocardv<?php echo $NumWindow; ?>" data-toggle="pill">Factores riesgo cardiovascular</a></li>
			  <?php } ?>
			  <?php if ($row["Framingham_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_framingham<?php echo $NumWindow; ?>" data-toggle="pill">Test de Framingham</a></li>
			  <?php } ?>
			  <?php if ($row["EmbarazoAct_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_embactual<?php echo $NumWindow; ?>" data-toggle="pill">Embarazo Actual</a></li>
			  <?php } ?>
			  <?php if ($row["RiesgoObst_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_riesgobst<?php echo $NumWindow; ?>" data-toggle="pill">Riesgo Obstétrico</a></li>
			  <?php } ?>
			  <?php if ($row["CtrlParacObs_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_ctrparaobs<?php echo $NumWindow; ?>" data-toggle="pill">Control Paraclínicos</a></li>
			  <?php } ?>
			  <?php if ($row["CtrlPreNat_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_ctrprenat<?php echo $NumWindow; ?>" data-toggle="pill">Control Pre Natal</a></li>
			  <?php } ?>
			  <?php if ($row["MedQuimio_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_medquimio<?php echo $NumWindow; ?>" data-toggle="pill">Reg. Quimioterapia</a></li>
			  <?php } ?>
			  <?php if ($row["Insumos_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_insumos<?php echo $NumWindow; ?>" data-toggle="pill">Insumos</a></li>
			  <?php } ?>
			  <?php if ($row["RiesgoCardV_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_labsrcv<?php echo $NumWindow; ?>" data-toggle="pill">Laboratorios RCV</a></li>
			  <?php } ?>
			  <?php if ($row["AyudasDiag_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_paraclinicos<?php echo $NumWindow; ?>" data-toggle="pill">Ayudas Dx</a></li>
			  <?php } ?>
			  <?php if ($row["Qx_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_ordqx<?php echo $NumWindow; ?>" data-toggle="pill">Procedimientos</a></li>
			  <?php } ?>
			  <?php if ($row["Ordenes_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_ordenaciones<?php echo $NumWindow; ?>" data-toggle="pill">Ord Servicio</a></li>
			  <?php } ?>
			  <?php if ($row["Med_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_medicamentos<?php echo $NumWindow; ?>" data-toggle="pill">Formulación</a></li>
			  <?php } ?>
			  <?php if ($row["Indicaciones_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_indicaciones<?php echo $NumWindow; ?>" data-toggle="pill">Indicaciones</a></li>
			  <?php } ?>
			  <?php if ($row["Incapacidad_HCT"]=="1") { ?>
			  <li role="presentation"><a href="#hc_incapacidad<?php echo $NumWindow; ?>" data-toggle="pill">Incapacidad</a></li>
			  <?php } ?>
			</ul>
	  	</div>
	  	<div class="col-md-10 col-md-10 tab-content">
	  		<input name="hdn_codigoser<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoser<?php echo $NumWindow; ?>" value="<?php echo $row["Codigo_SER"]; ?>" />
	  			<?php
	  				$SVHCT=$row["SV_HCT"];
	  				$GlasgowHCT=$row["Glasgow_HCT"];
	  				$ConsentimientoHCT=$row["Consentimiento_HCT"];
	  				$InsumosHCT=$row["Insumos_HCT"];
	  				$MedQuimioHCT=$row["MedQuimio_HCT"];
	  				$AyudasDiagHCT=$row["AyudasDiag_HCT"];
	  				$MedHCT=$row["Med_HCT"];
	  				$OrdenesHCT=$row["Ordenes_HCT"];
	  				$OrdQxHCT=$row["Qx_HCT"];
	  				$IndicacionesHCT=$row["Indicaciones_HCT"];
	  				$ImgHCT=$row["Img_HCT"];
	  				$Medico2HCT=$row["Medico2_HCT"];
	  				$AntecedentesHCT=$row["Antecedentes_HCT"];
	  				$DxHCT=$row["Dx_HCT"];
	  				$OdontogramaHCT=$row["Odontograma_HCT"];
					$ValHeridasHCT=$row["ValHeridas_HCT"];
	  				$IncapacidadHCT=$row["Incapacidad_HCT"];
	  				$RiesgoEspecifHCT=$row["RiesgoEspecif_HCT"];
	  				$AntGineObsHCT=$row["AntGineObs_HCT"];
	  				$EmbarazoActHCT=$row["EmbarazoAct_HCT"];
	  				$RiesgoObstHCT=$row["RiesgoObst_HCT"];
	  				$CtrlParacObsHCT=$row["CtrlParacObs_HCT"];
	  				$CtrlPreNatHCT=$row["CtrlPreNat_HCT"];
					$RiesgoCardVHCT=$row["RiesgoCardV_HCT"];
					$FraminghamHCT=$row["Framingham_HCT"];  
	  				//Antecedentes
					if ($AntecedentesHCT=="1") {
					  require 'hc.antecedentes.php'; 
	  					
	  				}//Antecedentes
	  				echo '
	  				<div role="tabpanel" class="tab-pane fade active in" id="hc_tipo'.$NumWindow.'">
	  					<div class="row">
	  				';
	  				//SIGNOS VITALES
	  				if ($SVHCT!="0") {
	  					echo '
	  					<div class="col-md-12">
	  						<label class="label label-success"> Signos Vitales</label>
							<div class="row alert alert-success">
						';
						$SQL="Select a.* from hcsv2 a, hcsv3 b where a.Codigo_HSV=b.Codigo_HSV and Codigo_SV1='".$SVHCT."' order by Orden_HSV";
						$resultz = mysqli_query($conexion, $SQL);
						$contasv=0;
						while($rowz = mysqli_fetch_array($resultz)) 
							{
							$contasv=$contasv+1;
							if (($rowz["Prefijo_HSV"]!="")||($rowz["Sufijo_HSV"]!="")) {
								$tamsv="2";
							} else  {
								$tamsv="1";
							}
						 	echo '
						 	<div class="col-md-'.$tamsv.' col-sm-'.$tamsv.'">
						 		<input name="hdn_codsv'.$contasv.$NumWindow.'" type="hidden" id="hdn_codsv'.$contasv.$NumWindow.'" value="'.$rowz["Codigo_HSV"].'" />
						 		<div class="form-group" id="grp_txt_valorsv'.$contasv.$NumWindow.'">
							 		<label for="txt_valorsv'.$contasv.$NumWindow.'">'.$rowz["Sigla_HSV"].'</label>
							';
							if (($rowz["Prefijo_HSV"]!="")||($rowz["Sufijo_HSV"]!="")) {
								echo '<div class="input-group">';
							}
							if ($rowz["Prefijo_HSV"]!="") {
								echo '<div class="input-group-addon">'.$rowz["Prefijo_HSV"].'</div>';
							}
							$calculosv="";
							$disabledsv="";
							
							if ($rowz["Vinculado_HSV"]!="") {
								$calculosv=' onchange="calc_sv'.$rowz["Vinculado_HSV"].$NumWindow.'();" ';
							}
							/*
							if ($rowz["Calculo_HSV"]!="") {
								$disabledsv=' disabled="disabled" ';
							}
							*/
							echo '
										<input name="txt_valorsv'.$contasv.$NumWindow.'" id="txt_valorsv'.$contasv.$NumWindow.'" type="'.$rowz["Tipo_HSV"].'"  required '.$calculosv.$disabledsv.' class="sv_'.$rowz["Codigo_HSV"].$NumWindow.'" />
							';
							if ($rowz["Sufijo_HSV"]!="") {
								echo '<div class="input-group-addon">'.$rowz["Sufijo_HSV"].'</div>';
							}
							if (($rowz["Prefijo_HSV"]!="")||($rowz["Sufijo_HSV"]!="")) {
								echo '</div>';
							}
							echo '
								</div>
							</div>
							';
							}
						mysqli_free_result($resultz); 

						echo '
							</div>
						</div>
						';
	  				} // SIGNOS VITALES
	  				
	  				//GLASGOW
	  				if ($GlasgowHCT!="0") {
	  					echo '
	  					<div class="col-md-12">
	  						<label class="label label-warning"> Escala Glasgow [ <b><span id="glasgow'.$NumWindow.'" style="font-size:14; font-weight:bold;">15/15</span></b> ]</label>
							<div class="row alert alert-warning">
						';
						$TipoGLW="0";
						$TitGLW="";
						$SQL="Select Tipo_GLW, Codigo_GLW, Nombre_GLW from hctipoglasgow order by Tipo_GLW asc, Codigo_GLW desc";
						$resultz = mysqli_query($conexion, $SQL);
						while($rowz = mysqli_fetch_array($resultz)) 
							{
							if ($rowz[0]!=$TipoGLW) {
								$TipoGLW=$rowz[0];
								if ($TipoGLW=="1") {
									$TitGLW="Apertura Ocular";
								} else {
									echo '</select>
								</div>					
							</div>';
									if ($TipoGLW=="2") {
										$TitGLW="Respuesta Verbal";
									} else {
										if ($TipoGLW=="3") {
											$TitGLW="Respuesta Motora";
										}
									}
								}
								echo '
						 	<div class="col-md-4 col-sm-4">
						 		<div class="form-group" id="grp_txt_glasgow'.$TipoGLW.$NumWindow.'">
							 		<label for="cmb_glasgow'.$TipoGLW.$NumWindow.'">'.$TitGLW.'</label>
							 		<select name="cmb_glasgow'.$TipoGLW.$NumWindow.'" id="cmb_glasgow'.$TipoGLW.$NumWindow.'" onchange="javascript:CalcGlasgow'.$NumWindow.'();">
							';
							}
						 	echo '<option value="'.$rowz[1].'">'.$rowz[2].'</option>';
							}
						mysqli_free_result($resultz); 

						echo '</select>
								</div>					
							</div>
							</div>
						</div>
						';
	  				} // GLASGOW

	  				
	  				// Consentimiento Informado 
	  				if ($ConsentimientoHCT=="1") {
	  					$SQL="Select Texto_HCT from hcplantconsinform Where Estado_HCT='1' and Codigo_HCT='".$_GET["FormatoHC"]."'";
						$resultz = mysqli_query($conexion, $SQL);
						if ($rowz = mysqli_fetch_array($resultz)) {
		  					echo '
		  					<div class="col-md-12">
		  						<label class="label label-info"> <b><span id="cinf'.$NumWindow.'" style="font-size:14; font-weight:bold;">CONSENTIMIENTO INFORMADO</span></b> </label>
								<div class="row alert alert-info">
									<div class="col-md-8">
									<div class="col-md-6 col-sm-6 input-group" style="float:left;">
									  <span class="input-group-addon" id="baddyo'.$NumWindow.'">Yo</span>
									  <input type="text" class="form-control" placeholder="Nombre Completo" aria-describedby="baddyo'.$NumWindow.'">
									</div>
									<div class="col-md-3 col-sm-3 input-group" style="float:left;">
									  <span class="input-group-addon" id="baddcon'.$NumWindow.'">Con</span>
									  <select name="cmb_consinfcon'.$NumWindow.'" id="cmb_consinfcon'.$NumWindow.'" aria-describedby="baddcon'.$NumWindow.'" class="form-control" >';
							$SQL="Select Sigla_TID, Nombre_TID, Codigo_TID from cztipoid Order By Codigo_TID";
							$resulta = mysqli_query($conexion, $SQL);
							while ($rowa = mysqli_fetch_array($resulta)) {
								echo '<option value="'.$rowa[0].'">'.$rowa[1].'</option>';
							}
							mysqli_free_result($resulta);
							echo '
									  </select>
									</div>
									<div class="col-md-3 col-sm-3 input-group" style="float:left;">
									  <span class="input-group-addon" id="baddno'.$NumWindow.'">No.</span>
									  <input type="text" class="form-control" placeholder="Número ID" aria-describedby="baddno'.$NumWindow.'">
									</div>
									<div class="col-md-5 col-sm-5 input-group" style="float:left;">
									  <span class="input-group-addon" id="baddde'.$NumWindow.'">de</span>
									  <input type="text" class="form-control" placeholder="Lugar ID" aria-describedby="baddde'.$NumWindow.'">
									</div>
									<div class="col-md-7 col-sm-7 input-group" style="float:left;">
									  <span class="input-group-addon" id="baddcal'.$NumWindow.'">en calidad de</span>
									  <input type="text" class="form-control" placeholder="" aria-describedby="baddcal'.$NumWindow.'">
									</div>
									
										<p style="text-align: justify; text-justify: inter-word;">
										'.$rowz[0].'
										</p>
									</div>
									<div class="col-md-4">
										<div class="form-group">
								  			<label >Firma </label>
							<input name="hdn_firmas'.$NumWindow.'" type="hidden" id="hdn_firmas'.$NumWindow.'" value="'.session_id().'" />
							<input name="hdn_jpg'.$NumWindow.'" type="hidden" id="hdn_jpg'.$NumWindow.'" value="" />
							<div id="div_firmas'.$NumWindow.'" class="img-thumbnail img-responsive center-block" style="background-repeat: no-repeat;background-position: center; background-size: contain; height: 136px;" onclick="NxsCanvasEdit(\'Firma\', \'div_firmas'.$NumWindow.'\', \'hc.php\', \''.$NumWindow.'\');" data-toggle="modal" data-target="#GnmX_WinModal">
								<div id="div_preupload2'.$NumWindow.'" class="preuploadx" style="visibility:hidden"></div>
								
							</div>

									    </div>
									</div>
								</div>
							</div>
							';
						}
						mysqli_free_result($resultz);
	  				}	  				
	  			}
	  			mysqli_free_result($result);
	  			//Campos del formato HC
	  			$SQL="Select a.* from hccampos a, hctipos b where a.Codigo_HCT=b.Codigo_HCT and a.Codigo_HCT='".$_GET["FormatoHC"]."' and Grupo_HCC='0' ".$iSexPcte." Order By Orden_HCC;";
				$result = mysqli_query($conexion, $SQL);
				$rekerido="";
				while($row = mysqli_fetch_array($result)) {
					if ($row["Obligatorio_HCC"]=="1") {
						$rekerido="required";
					} else {
						$rekerido="";
					}
					switch ($row["Tipo_HCC"]) {
						//label
						case 'label':
	  			?>
					<div class="col-md-<?php echo $row["Largo_HCC"]; ?>">

				<label id="lbl_<?php echo $row["Codigo_HCC"].$NumWindow; ?>"><?php echo $row["Etiqueta_HCC"]; ?></label>
				
					</div>
	  			<?php
	  					break;
						//check box
						case 'check':
	  			?>
					<div class="col-md-<?php echo $row["Largo_HCC"]; ?>">

				<div class="checkbox checkbox-success">
					<input name="chk_x<?php echo $row["Codigo_HCC"].$NumWindow; ?>" id="chk_x<?php echo $row["Codigo_HCC"].$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:chekear<?php echo $NumWindow; ?>('<?php echo $row["Codigo_HCC"]; ?>');" class="styled" <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?> <?php echo $rekerido; ?>>
					<label for="chk_x<?php echo $row["Codigo_HCC"].$NumWindow; ?>"><?php echo $row["Etiqueta_HCC"]; ?></label>
				</div>
				<input name="hdn_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" type="hidden" id="hdn_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" value="0" />

					</div>
	  			<?php
	  					break;
	  					//text box
						case 'text':
	  			?>
	  				<div class="col-md-<?php echo $row["Largo_HCC"]; ?>">
				<div class="form-group" id="grp_txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>">
					<label for="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>"><?php echo $row["Etiqueta_HCC"]; ?></label>
					<input name="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" id="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" type="text" value="<?php echo trim($row["Defecto_HCC"]); ?>" maxlength="<?php echo $row["Maximo_HCC"]; ?>" <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?> <?php echo $rekerido; ?> />
				</div>
					</div>
	  			<?php
	  					break;
	  					//time
						case 'time':
	  			?>
	  				<div class="col-md-<?php echo $row["Largo_HCC"]; ?>">
				<div class="form-group" id="grp_txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>">
					<label for="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>"><?php echo $row["Etiqueta_HCC"]; ?></label>
					<input name="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" id="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" type="time" value="<?php echo trim($row["Defecto_HCC"]); ?>" maxlength="<?php echo $row["Maximo_HCC"]; ?>" <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?> <?php echo $rekerido; ?> />
				</div>
					</div>
	  			<?php
	  					break;
	  					//date
						case 'date':
	  			?>
	  				<div class="col-md-<?php echo $row["Largo_HCC"]; ?>">
				<div class="form-group" id="grp_txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>">
					<label for="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>"><?php echo $row["Etiqueta_HCC"]; ?></label>
					<input name="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" id="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" type="date" value="<?php echo trim($row["Defecto_HCC"]); ?>" maxlength="<?php echo $row["Maximo_HCC"]; ?>" <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?> <?php echo $rekerido; ?> />
				</div>
					</div>
	  			<?php
	  					break;
	  					// text area
	  					case "textarea":
	  			?>
	  				<div class="col-md-<?php echo $row["Largo_HCC"]; ?>">
				<div class="form-group" id="grp_txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>">
					<label for="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>"><?php echo $row["Etiqueta_HCC"]; ?></label>
					<textarea class="form-control" rows="<?php echo $row["Lineas_HCC"]; ?>" id="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" name="txt_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" maxlength="<?php echo $row["Maximo_HCC"]; ?>" <?php echo $rekerido; ?> <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?>><?php echo trim($row["Defecto_HCC"]); ?></textarea>
				</div>
					</div>
				<?php
	  					break;
	  					// Select
	  					case "select":
	  			?>
					<div class="col-md-<?php echo $row["Largo_HCC"]; ?>">
				<div class="form-group" id="grp_cmb_<?php echo $row["Codigo_HCC"].$NumWindow; ?>">
					<label for="cmb_<?php echo $row["Codigo_HCC"].$NumWindow; ?>"><?php echo $row["Etiqueta_HCC"]; ?></label>
					<select name="cmb_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" id="cmb_<?php echo $row["Codigo_HCC"].$NumWindow; ?>" <?php echo $rekerido; ?> <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?>>
					<?php 
				$SQL="Select Valor_HCC, Texto_HCC, Orden_HCC, Seleccionado_HCC, Comando_HCC from hccamposlistas Where Codigo_HCT='".$_GET["FormatoHC"]."' and Codigo_HCC='".$row["Codigo_HCC"]."' Order by 3";
				$resultl = mysqli_query($conexion, $SQL);
				while($rowl = mysqli_fetch_array($resultl)) 
					{
						$sel="";
						if ($rowl["Seleccionado_HCC"]=="1") {
							$sel=' selected="selected" ';
						}
				 ?>
				  <option value="<?php echo $rowl[0]; ?>" <?php echo $sel; echo($rowl["Comando_HCC"]); ?>  ><?php echo ($rowl[1]); ?></option>
				<?php
					}
				mysqli_free_result($resultl); 
				 ?>  
					</select>
				</div>
					</div>
	  			<?php
	  					break;
	  					// Grupo de controles
	  					default:

	  						if ($row["Tipo_HCC"]=="well") {
	  			?>
	  			<div id="div<?php echo $row["Codigo_HCC"].$NumWindow; ?>" class="col-md-<?php echo $row["Largo_HCC"]; ?>" <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?>>
	  				<label class="label label-success"> <?php echo $row["Etiqueta_HCC"]; ?></label> 
	  				<?php 
	  					$ClassNormal="";
	  					if($row["Normalizar_HCC"]=="1") {
	  						$ClassNormal="Nrml".$row["Codigo_HCC"];
	  				?>
	  				<button type="button" class="btn btn-warning btn-xs" style="float: right;" onclick="normalizar<?php echo $NumWindow; ?>('<?php echo $row["Codigo_HCC"]; ?>');">Normalizar Valores <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
	  				<?php
	  					} 
	  						}
	  						if ($row["Tipo_HCC"]=="collapse") {
	  							$Kollapse++;
	  							if ($Kollapse==1) {
	  								$Expanded="true";
	  								$KolaKlass="collapse in";
	  							} else {
	  								$Expanded="false";
	  								$KolaKlass="collapse";
	  							}
	  			?>

	  			<div id="div<?php echo $row["Codigo_HCC"].$NumWindow; ?>" class=" col-md-<?php echo $row["Largo_HCC"]; ?>" <?php echo(str_replace('.WINDOW.',$NumWindow,$row["Parametros_HCC"])); ?> style="padding: 1;">
	  				<button class="btn btn-default btn-sm btn-block" type="button" data-toggle="collapse" data-target="#x<?php echo $row["Codigo_HCC"].$NumWindow?>" aria-expanded="<?php echo $Expanded; ?>" aria-controls="x<?php echo $row["Codigo_HCC"].$NumWindow?>" style="font-weight: bold; color: #3c763d;"> <?php echo $row["Etiqueta_HCC"]; ?> </button>
	  				<?php 
	  					$ClassNormal="";
	  					if($row["Normalizar_HCC"]=="1") {
	  						$ClassNormal="Nrml".$row["Codigo_HCC"];
	  				?>
	  				<button type="button" class="btn btn-warning btn-xs" style="float: right;" onclick="normalizar<?php echo $NumWindow; ?>('<?php echo $row["Codigo_HCC"]; ?>');">Normalizar Valores <span class="glyphicon glyphicon-ok" aria-hidden="true"></span></button>
	  				<?php
	  					} 
	  					echo '<div class="'.$KolaKlass.'" id="x'.$row["Codigo_HCC"].$NumWindow.'" aria-expanded="'.$Expanded.'">';
	  						}
	  				?>
	  				<div class="row well well-sm">
	  			<?php

			  			$SQL="Select * from hccampos where Codigo_HCT='".$_GET["FormatoHC"]."' and Grupo_HCC='".$row["Orden_HCC"]."' Order By Orden_HCC;";
						$resultx = mysqli_query($conexion, $SQL);
						while($rowx = mysqli_fetch_array($resultx)) {
							if ($rowx["Obligatorio_HCC"]=="1") {
								$rekerido="required";
							} else {
								$rekerido="";
							}
							switch ($rowx["Tipo_HCC"]) {
								//label
								case 'label':
			  			?>
							<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">

						<div class="alert alert-success" id="lbl_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" style="padding: 7px;"><?php echo $rowx["Etiqueta_HCC"]; ?></div>
						
							</div>
			  			<?php
			  					break;
								//image
								case 'image':
			  			?>
							<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">

						<div class="row">
						  <div class="col-md-12">
						    <a href="#" class="thumbnail">
						      <img id="img_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" name="img_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" data-src="holder.js/300x200" alt="" style="height: <?php echo $rowx["Lineas_HCC"]; ?>px; width: 100%; display: block;">
							  <input name="file-input<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" id="file-input<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" type="file" onchange="addImage<?php echo $NumWindow; ?>(event, 'img_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>');" />
						    </a>
						  </div>
						</div>

							</div>
			  			<?php
			  					break;
			  					//check box
								case 'check':
			  			?>
							<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">

						<div class="checkbox checkbox-success">
							<input name="chk_x<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" id="chk_x<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" type="checkbox" value=""  onclick="javascript:chekear<?php echo $NumWindow; ?>('<?php echo $rowx["Codigo_HCC"]; ?>');" class="styled" <?php echo(str_replace('.WINDOW.',$NumWindow,$rowx["Parametros_HCC"])); ?> <?php echo $rekerido; ?>>
							<label for="chk_x<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>"><?php echo $rowx["Etiqueta_HCC"]; ?></label>
						</div>
						<input name="hdn_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" type="hidden" id="hdn_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" value="0" />

							</div>
			  			<?php
			  					break;
			  					//text box
								case 'text':
			  			?>
			  				<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">
						<div class="form-group" id="grp_txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>">
							<label for="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>"><?php echo $rowx["Etiqueta_HCC"]; ?></label>
							<?php 
							$hcdefecto=trim($rowx["Defecto_HCC"]);
							if ($hcdefecto!="") {
								echo '
								<input name="hdn_nrmltxt_'.$rowx["Codigo_HCC"].$NumWindow.'" type="hidden" id="hdn_nrmltxt_'.$rowx["Codigo_HCC"].$NumWindow.'" value="'.$hcdefecto.'" />
								';
								$hcdefecto=$ClassNormal;
							}
							?>
							<input name="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" id="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" type="text" value="" class="<?php echo $hcdefecto; ?>" maxlength="<?php echo $rowx["Maximo_HCC"]; ?>" <?php echo(str_replace('.WINDOW.',$NumWindow,$rowx["Parametros_HCC"])); ?> <?php echo $rekerido; ?> />
						</div>
							</div>
			  			<?php
			  					break;
			  					//time
								case 'time':
			  			?>
			  				<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">
						<div class="form-group" id="grp_txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>">
							<label for="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>"><?php echo $rowx["Etiqueta_HCC"]; ?></label>
							<?php 
							$hcdefecto=trim($rowx["Defecto_HCC"]);
							if ($hcdefecto!="") {
								echo '
								<input name="hdn_nrmltxt_'.$rowx["Codigo_HCC"].$NumWindow.'" type="hidden" id="hdn_nrmltxt_'.$rowx["Codigo_HCC"].$NumWindow.'" value="'.$hcdefecto.'" />
								';
								$hcdefecto=$ClassNormal;
							}
							?>
							<input name="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" id="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" type="time" value="" class="<?php echo $hcdefecto; ?>" maxlength="<?php echo $rowx["Maximo_HCC"]; ?>" <?php echo(str_replace('.WINDOW.',$NumWindow,$rowx["Parametros_HCC"])); ?> <?php echo $rekerido; ?> />
						</div>
							</div>
			  			<?php
			  					break;
			  					//date
								case 'date':
			  			?>
			  				<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">
						<div class="form-group" id="grp_txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>">
							<label for="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>"><?php echo $rowx["Etiqueta_HCC"]; ?></label>
							<?php 
							$hcdefecto=trim($rowx["Defecto_HCC"]);
							if ($hcdefecto!="") {
								echo '
								<input name="hdn_nrmltxt_'.$rowx["Codigo_HCC"].$NumWindow.'" type="hidden" id="hdn_nrmltxt_'.$rowx["Codigo_HCC"].$NumWindow.'" value="'.$hcdefecto.'" />
								';
								$hcdefecto=$ClassNormal;
							}
							?>
							<input name="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" id="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" type="date" value="" class="<?php echo $hcdefecto; ?>" maxlength="<?php echo $rowx["Maximo_HCC"]; ?>" <?php echo(str_replace('.WINDOW.',$NumWindow,$rowx["Parametros_HCC"])); ?> <?php echo $rekerido; ?> />
						</div>
							</div>
			  			<?php
			  					break;
			  					// text area
			  					case "textarea":
			  			?>
			  				<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">
						<div class="form-group" id="grp_txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>">
							<label for="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>"><?php echo $rowx["Etiqueta_HCC"]; ?></label>
							<?php 
							$hcdefecto=trim($rowx["Defecto_HCC"]);
							if ($hcdefecto!="") {
								echo '
								<input name="hdn_nrmltxt_'.$rowx["Codigo_HCC"].$NumWindow.'" type="hidden" id="hdn_nrmltxt_'.$rowx["Codigo_HCC"].$NumWindow.'" value="'.$hcdefecto.'" />
								';
								$hcdefecto=$ClassNormal;
							}
							?>
							<textarea class="form-control <?php echo $hcdefecto; ?>" rows="<?php echo $rowx["Lineas_HCC"]; ?>" id="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" name="txt_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" maxlength="<?php echo $rowx["Maximo_HCC"]; ?>" <?php echo $rekerido; ?> <?php echo(str_replace('.WINDOW.',$NumWindow,$rowx["Parametros_HCC"])); ?>></textarea>
						</div>
							</div>
						<?php
			  					break;
			  					// Select
			  					case "select":
			  			?>
							<div class="col-md-<?php echo $rowx["Largo_HCC"]; ?>">
						<div class="form-group" id="grp_cmb_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>">
							<label for="cmb_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>"><?php echo $rowx["Etiqueta_HCC"]; ?></label>
							<select name="cmb_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" id="cmb_<?php echo $rowx["Codigo_HCC"].$NumWindow; ?>" <?php echo $rekerido; ?> <?php echo(str_replace('.WINDOW.',$NumWindow,$rowx["Parametros_HCC"])); ?>>
							<?php 
						$SQL="Select Valor_HCC, Texto_HCC, Orden_HCC, Seleccionado_HCC, Comando_HCC from hccamposlistas Where Codigo_HCT='".$_GET["FormatoHC"]."' and Codigo_HCC='".$rowx["Codigo_HCC"]."' Order by 3";
						$resultlx = mysqli_query($conexion, $SQL);
						while($rowlx = mysqli_fetch_array($resultlx)) 
							{
								$sel="";
								if ($rowlx["Seleccionado_HCC"]=="1") {
									$sel=' selected="selected" ';
								}
						 ?>
						  <option value="<?php echo $rowlx[0]; ?>" <?php echo $sel; echo($rowlx["Comando_HCC"]); ?>  ><?php echo ($rowlx[1]); ?></option>
						<?php
							}
						mysqli_free_result($resultlx); 
								
						 ?>  
							</select>
						</div>
							</div>	  			
				<?php
								break;
							}
						}
	  					mysqli_free_result($resultx);
	  			?>
	  				</div>
	  				<?php
	  				if ($row["Tipo_HCC"]=="collapse") {
	  					echo '</div>';
	  				}
	  					?>
	  				
	  			</div>
	  			<?php
	  					break;
	  				}
	  			}
	  			mysqli_free_result($result);

	  		   echo '
		  		</div>
		  	</div>
		  		';
		  		//Diagnosticos
	  			if ($DxHCT=="1") {
	  				require 'hc.diagnosticos.php';
	  			}

	  			// Odontograma
	  			if ($OdontogramaHCT=="1") {
	  			  require 'hc.odontograma.php';
	  			}
		  		// Valoracion Heridas
	  			if ($ValHeridasHCT=="1") {
	  			  require 'hc.valheridas.php?sexo='.$SexoPcte;
	  			}
		  		// Identificación de Riesgos especificos
		  		if ($RiesgoEspecifHCT=="1") {
		  		  require 'hc.riegespecif.php';
		  		}
		  		// Factores de Riesgo Cardiovascular
		  		if ($RiesgoCardVHCT=="1") {
		  		  require 'hc.riecardiov.php';
		  		}
		  		// Test de Framingham
		  		if ($FraminghamHCT=="1") {
		  		  require 'hc.framingham.php';
		  		}
		  		// Laboratorios Riesgo Cardiovascular
		  		if ($RiesgoCardVHCT=="1") {
		  		  require 'hc.labsrcv.php';
		  		}
		  		// Embarazo Actual
		  		if ($EmbarazoActHCT=="1") {
		  		  require 'hc.embactual.php';
		  		}
		  		// Calificación del Riesgo Obstétrico
		  		if ($RiesgoObstHCT=="1") {
		  		  require 'hc.riesgobst.php';
		  		}
	  		    // Calificación del Riesgo Obstétrico
		  		if ($CtrlParacObsHCT=="1") {
		  		  require 'hc.ctrlparaobs.php';
		  		}
		  		// Calificación del Riesgo Obstétrico
		  		if ($CtrlPreNatHCT=="1") {
		  		  require 'hc.ctrprenat.php';
		  		}
	  		    // Insumos
		  		if ($InsumosHCT=="1") {
		  		  require 'hc.insumos.php';
		  		}
		  		// Med Quimio Enf
		  		if ($MedQuimioHCT=="1") {
		  		  require 'hc.medquimio.php';
		  		}
		  		// Imagenes Diagnosticas y Laboratorios
		  		if ($AyudasDiagHCT=="1") {
		  		  require 'hc.paraclinicos.php';
		  		}

		  	   // Procedimmientos
		  		if ($OrdQxHCT=="1") {
		  		?>
		  		<div role="tabpanel" class="tab-pane fade " id="hc_ordqx<?php echo $NumWindow; ?>">
	  					<div class="row">
	  				
		  		<div id="divordqx<?php echo $NumWindow; ?>" class="col-md-12">
	  				<label class="label label-success"> Procedimientos</label>
	  				<div class="row well well-sm">
	  					<div class="col-md-2">
						    <div class="form-group">
								<label for="txt_codserqx<?php echo $NumWindow; ?>">Código</label>
								<div class="input-group">	
									<input name="txt_codserqx<?php echo $NumWindow; ?>" id="txt_codserqx<?php echo $NumWindow; ?>" type="text" onkeypress="BuscarCodServQx<?php echo $NumWindow; ?>(event);" onblur="CodServQxOnBlur<?php echo $NumWindow; ?>()" />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="MedicaHC" onclick="javascript:CargarSearch('ServiciosX1', 'txt_codserqx<?php echo $NumWindow; ?>', '(Codigo_CFC=*04*!or!Codigo_CFC=*03*!or!Codigo_CFC=*05*)');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
									</span>
								</div>
							</div>
						</div>

						<div class="col-md-5">
							<div class="form-group">
								<label for="txt_servicioqx<?php echo $NumWindow; ?>">Servicio</label>
								<input  name="txt_servicioqx<?php echo $NumWindow; ?>" id="txt_servicioqx<?php echo $NumWindow; ?>" type="text" disabled="disabled" />
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_cantservqx<?php echo $NumWindow; ?>">Cantidad</label>
								<input  name="txt_cantservqx<?php echo $NumWindow; ?>" id="txt_cantservqx<?php echo $NumWindow; ?>" type="text" value="1"/>
							</div>			
						</div>
						
						<div class="col-md-4">
							<div class="form-group">
								<label for="txt_obsserqx<?php echo $NumWindow; ?>">Observaciones</label>
								<div class="input-group">	
									<input name="txt_obsserqx<?php echo $NumWindow; ?>" id="txt_obsserqx<?php echo $NumWindow; ?>" type="text"  />
									<span class="input-group-btn">	
										<button class="btn btn-success" type="button" data-toggle="modal"  data-whatever="AddMedicaHC" onclick="javascript:AddOrdQx<?php echo $NumWindow; ?>();"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></button>
									</span>
								</div>
							</div>			
						</div>
						
						<div class="col-md-12">
						  	<div id="zero_detalleordqx<?php echo $NumWindow; ?>" class="detalleord table-responsive alturahc">
								<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleordqx<?php echo $NumWindow; ?>" >
								<tbody id="tbordqx<?php echo $NumWindow; ?>">
								<tr id="trhordqxX'.$NumWindow.'"> 
									<th id="th1ordqxX'.$NumWindow.'">Codigo</th> 
									<th id="th2ordqxX'.$NumWindow.'">Servicio</th> 
									<th id="th3ordqxX'.$NumWindow.'">Cantidad</th> 
									<th id="th4ordqxX'.$NumWindow.'">Observaciones</th> 
									<th id="th5ordqxX'.$NumWindow.'">Eliminar</th> 
								</tr> 

								</tbody>
								</table><input name="hdn_controwordqx<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwordqx<?php echo $NumWindow; ?>" value="0" />
							</div>
						</div>
	  				</div>
	  			</div>

	  		</div>
	  	</div>
		  		<?php
		  		}

		  		// Medicamentos
		  		if ($MedHCT=="1") {
		  		  require 'hc.medicamentos.php';	
		  		}

		  		// Ordenes de Servicio
		  		if ($OrdenesHCT=="1") {
		  		  require 'hc.ordenaciones.php';	
		  		}

		  	   // Indicaciones y Tratamiento
		  		if ($IndicacionesHCT=="1") {
		  		  require 'hc.indicaciones.php';
		  		}
		  		//Incapacidad
				if ($IncapacidadHCT=="1") {
  					echo '
  				<div role="tabpanel" class="tab-pane fade" id="hc_incapacidad'.$NumWindow.'">
  					  <label class="label label-success"> Incapacidad Médica</label>
  					<div class="row alert alert-success">
					    
				<div class="row well well-sm">

						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_claseincap'.$NumWindow.'">Clasificación </label>
								<select name="cmb_claseincap'.$NumWindow.'" id="cmb_claseincap'.$NumWindow.'" >
						';
						$SQL="Select Codigo_HCI, Nombre_HCI  From hcclaseincapacidad Order By 1";
			  			$resultmx = mysqli_query($conexion, $SQL);
						while($rowmx = mysqli_fetch_array($resultmx)) {
							echo '
							<option value="'.$rowmx[0].'" >'.$rowmx[1].'</option>
							';
						}
						mysqli_free_result($resultmx);		
						echo '
								</select>
							</div>			
						</div>
						
						<div class="col-md-2">
							<div class="form-group">
								<label for="txt_fecincapini'.$NumWindow.'">Fec Inicial </label>
								<input type="date" class="form-control" id="txt_fecincapini'.$NumWindow.'" name="txt_fecincapini'.$NumWindow.'" onchange="RecalcIncap'.$NumWindow.'(\'fecini\');">
								
								</select>
							</div>			
						</div>

						<div class="col-md-1">
							<div class="form-group">
								<label for="txt_diasincap'.$NumWindow.'">Días</label>
								<input type="number" class="form-control" id="txt_diasincap'.$NumWindow.'" name="txt_diasincap'.$NumWindow.'" onchange="RecalcIncap'.$NumWindow.'(\'dias\');" min="0" value="0">
								
								</select>
							</div>			
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="txt_fecincapfin'.$NumWindow.'">Fec Final </label>
								<input type="date" class="form-control" id="txt_fecincapfin'.$NumWindow.'" name="txt_fecincapfin'.$NumWindow.'" onchange="RecalcIncap'.$NumWindow.'(\'fecfin\');">
								
								</select>
							</div>			
						</div>

						<div class="col-md-2">
							<div class="form-group">
								<label for="cmb_motivoincap'.$NumWindow.'">Tipo Generación </label>
								<select name="cmb_motivoincap'.$NumWindow.'" id="cmb_motivoincap'.$NumWindow.'" >
						';
						$SQL="Select Codigo_HMI, Nombre_HMI  From hcmotivoincapacidad Order By 1";
			  			$resultmx = mysqli_query($conexion, $SQL);
						while($rowmx = mysqli_fetch_array($resultmx)) {
							echo '
							<option value="'.$rowmx[0].'" >'.$rowmx[1].'</option>
							';
						}
						mysqli_free_result($resultmx);		
						echo '
								</select>
							</div>			
						</div>
						
						<div class="col-md-1">
							<div class="form-group">
								<label for="cmb_tipoincap'.$NumWindow.'">Tipo </label>
								<select name="cmb_tipoincap'.$NumWindow.'" id="cmb_tipoincap'.$NumWindow.'" >
						';
						$SQL="Select Codigo_HTI, Nombre_HTI From hctipoincapacidad Order By 1";
			  			$resultmx = mysqli_query($conexion, $SQL);
						while($rowmx = mysqli_fetch_array($resultmx)) {
							echo '
							<option value="'.$rowmx[0].'" >'.$rowmx[1].'</option>
							';
						}
						mysqli_free_result($resultmx);		
						echo '
								</select>
							</div>			
						</div>

						<div class="col-md-3">
							<div class="form-group">
								<label for="txt_observincap'.$NumWindow.'">Observaciones</label>
								<input type="text" class="form-control" id="txt_observincap'.$NumWindow.'" name="txt_observincap'.$NumWindow.'" >
								
								</select>
							</div>			
						</div>

	  			</div>

					  </div>
 					</div>
						';
	  				}//Incapacidad

		  	   // Adjuntar Imágenes
		  		if ($ImgHCT=="1") {

		  		}
		  	   // Cargar imagen a pantalla completa
		  		if ($ImgHCT=="2") {
		  			
		  		}
		  	   // Seleccionar Médico 2
				if ($Medico2HCT=="1") {

				}
			?>
		</div>
	  		</div>
			<?php
	  		} else {
	  		 	echo '
	  		<label class="label label-default"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> H.C.  <span id="NombrePCTE'.$NumWindow.'"></span></label>
	  		<div class="row well well-sm">
	  			Seleccione el formato de historia clínica a diligenciar en el botón [+ Nuevo Folio]
	  		</div>'; 
	  		} 
	  		if ($FormatHCYes==0) {
	  			echo '
	  		<label class="label label-default"> <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> H.C.  <span id="NombrePCTE'.$NumWindow.'"></span></label>
	  		<div class="row well well-sm">
	  			Seleccione el formato de historia clínica a diligenciar en el botón [+ Nuevo Folio]
	  		</div>'; 
	  		}
	  		?>
 		</div>
</div>

</form>

<script >
	var varHystory="<?php echo $Hystory; ?>";
	<?php 
	if (isset($_GET["FormatoHC"])) {
		echo 'var varFormatoHC="'.$_GET["FormatoHC"].'";';
	} else {
		echo 'var varFormatoHC="";';
	}
	?>;

<?php if ($FraminghamHCT=="1") { ?>
function calcframingham<?php echo $NumWindow; ?>() {
	puntos=0;
	porcent='0%';
	Edad=document.getElementById('txt_edadf<?php echo $NumWindow; ?>').value;
	tCOL=document.getElementById('txt_totcf<?php echo $NumWindow; ?>').value;
	HDLc=document.getElementById('txt_hdlf<?php echo $NumWindow; ?>').value;
	TAsis=document.getElementById('txt_tsaf<?php echo $NumWindow; ?>').value;
	Medica=document.getElementById('cmb_medicf<?php echo $NumWindow; ?>').value;
	Fuma=document.getElementById('cmb_fumaf<?php echo $NumWindow; ?>').value;
    if (document.getElementById('cmb_sexof<?php echo $NumWindow; ?>').value=="M") {
		if ((TAsis>=120)||(TAsis<=129)) {
			if (Medica==1) {
				puntos=puntos+1;
			} else {
				puntos=puntos+0;
			}
		}
		if ((TAsis>=130)||(TAsis<=139)) {
			if (Medica==1) {
				puntos=puntos+2;
			} else {
				puntos=puntos+1;
			}
		}
		if ((TAsis>=140)||(TAsis<=159)) {
			if (Medica==1) {
				puntos=puntos+2;
			} else {
				puntos=puntos+1;
			}
		}
		if ((TAsis>=160)) {
			if (Medica==1) {
				puntos=puntos+3;
			} else {
				puntos=puntos+2;
			}
		}
		if (HDLc<40) {
			puntos=puntos+2;
		} else {
			if((HDLc>=40)||(HDLc<=49)) {
				puntos=puntos+1;
			} else {
				if((HDLc>=60)) {
					puntos=puntos-1;
				}
			}
		}
		if ((Edad>=20)||(Edad<=34) ) {
			puntos=puntos-9;
			if (Fuma==1) {
				puntos=puntos+8;
			}
			if ((tCOL>=160)||(tCOL<=199)) {
				puntos=puntos+4;
			} else {
				if ((tCOL>=200)||(tCOL<=239)) {
					puntos=puntos+7;
				} else {
					if ((tCOL>=240)||(tCOL<=279)) {
						puntos=puntos+9;
					} else {
						if ((tCOL>=280)) {
							puntos=puntos+11;
						} else {
							
						}
					}
				}
			}
		} else {
			if ((Edad>=35)||(Edad<=39) ) {
				puntos=puntos-4;
				if (Fuma==1) {
					puntos=puntos+8;
				}
				if ((tCOL>=160)||(tCOL<=199)) {
					puntos=puntos+4;
				} else {
					if ((tCOL>=200)||(tCOL<=239)) {
						puntos=puntos+7;
					} else {
						if ((tCOL>=240)||(tCOL<=279)) {
							puntos=puntos+9;
						} else {
							if ((tCOL>=280)) {
								puntos=puntos+11;
							}
						}
					}
				}
			} else {
				if ((Edad>=40)||(Edad<=44) ) {
					puntos=puntos+0;
					if (Fuma==1) {
						puntos=puntos+5;
					}
					if ((tCOL>=160)||(tCOL<=199)) {
						puntos=puntos+3;
					} else {
						if ((tCOL>=200)||(tCOL<=239)) {
							puntos=puntos+5;
						} else {
							if ((tCOL>=240)||(tCOL<=279)) {
								puntos=puntos+6;
							} else {
								if ((tCOL>=280)) {
									puntos=puntos+8;
								}
							}
						}
					}
				} else {
					if ((Edad>=45)||(Edad<=49) ) {
						puntos=puntos+3;
						if (Fuma==1) {
							puntos=puntos+5;
						}
						if ((tCOL>=160)||(tCOL<=199)) {
							puntos=puntos+3;
						} else {
							if ((tCOL>=200)||(tCOL<=239)) {
								puntos=puntos+5;
							} else {
								if ((tCOL>=240)||(tCOL<=279)) {
									puntos=puntos+6;
								} else {
									if ((tCOL>=280)) {
										puntos=puntos+8;
									}
								}
							}
						}
					} else {
						if ((Edad>=50)||(Edad<=54) ) {
							puntos=puntos+6;
							if (Fuma==1) {
								puntos=puntos+3;
							}
							if ((tCOL>=160)||(tCOL<=199)) {
								puntos=puntos+2;
							} else {
								if ((tCOL>=200)||(tCOL<=239)) {
									puntos=puntos+3;
								} else {
									if ((tCOL>=240)||(tCOL<=279)) {
										puntos=puntos+4;
									} else {
										if ((tCOL>=280)) {
											puntos=puntos+5;
										}
									}
								}
							}
						} else {
							if ((Edad>=55)||(Edad<=59) ) {
								puntos=puntos+8;
								if (Fuma==1) {
									puntos=puntos+3;
								}
								if ((tCOL>=160)||(tCOL<=199)) {
									puntos=puntos+2;
								} else {
									if ((tCOL>=200)||(tCOL<=239)) {
										puntos=puntos+3;
									} else {
										if ((tCOL>=240)||(tCOL<=279)) {
											puntos=puntos+4;
										} else {
											if ((tCOL>=280)) {
												puntos=puntos+5;
											}
										}
									}
								}
							} else {
								if ((Edad>=60)||(Edad<=64) ) {
									puntos=puntos+10;
									if (Fuma==1) {
										puntos=puntos+1;
									}
									if ((tCOL>=160)||(tCOL<=199)) {
										puntos=puntos+1;
									} else {
										if ((tCOL>=200)||(tCOL<=239)) {
											puntos=puntos+1;
										} else {
											if ((tCOL>=240)||(tCOL<=279)) {
												puntos=puntos+2;
											} else {
												if ((tCOL>=280)) {
													puntos=puntos+3;
												}
											}
										}
									}
								} else {
									if ((Edad>=65)||(Edad<=69) ) {
										puntos=puntos+11;
										if (Fuma==1) {
											puntos=puntos+1;
										}
										if ((tCOL>=160)||(tCOL<=199)) {
											puntos=puntos+1;
										} else {
											if ((tCOL>=200)||(tCOL<=239)) {
												puntos=puntos+1;
											} else {
												if ((tCOL>=240)||(tCOL<=279)) {
													puntos=puntos+2;
												} else {
													if ((tCOL>=280)) {
														puntos=puntos+3;
													}
												}
											}
										}
									} else {
										if ((Edad>=70)||(Edad<=74) ) {
											puntos=puntos+12;
											if (Fuma==1) {
												puntos=puntos+1;
											}
											if ((tCOL>=160)||(tCOL<=199)) {
												puntos=puntos+0;
											} else {
												if ((tCOL>=200)||(tCOL<=239)) {
													puntos=puntos+0;
												} else {
													if ((tCOL>=240)||(tCOL<=279)) {
														puntos=puntos+1;
													} else {
														if ((tCOL>=280)) {
															puntos=puntos+1;
														}
													}
												}
											}
										} else {
											if ((Edad>=75) ) {
												puntos=puntos+13;
												if (Fuma==1) {
													puntos=puntos+1;
												}
												if ((tCOL>=160)||(tCOL<=199)) {
													puntos=puntos+0;
												} else {
													if ((tCOL>=200)||(tCOL<=239)) {
														puntos=puntos+0;
													} else {
														if ((tCOL>=240)||(tCOL<=279)) {
															puntos=puntos+1;
														} else {
															if ((tCOL>=280)) {
																puntos=puntos+1;
															}
														}
													}
												}
											} 
										}
									}
								}
							}
						}
					}	
				}	
			}
		}
		if (puntos==0) {
			porcent="< 1%";
		}
		if ((puntos>=1)||(puntos<=4)) {
			porcent="1%";
		}
		if ((puntos>=5)||(puntos<=6)) {
			porcent="2%";
		}
		if (puntos==7) {
			porcent="3%";
		}
		if (puntos==8) {
			porcent="4%";
		}
		if (puntos==9) {
			porcent="5%";
		}
		if (puntos==10) {
			porcent="6%";
		}
		if (puntos==11) {
			porcent="8%";
		}
		if (puntos==12) {
			porcent="10%";
		}
		if (puntos==13) {
			porcent="12%";
		}
		if (puntos==14) {
			porcent="16%";
		}
		if (puntos==15) {
			porcent="20%";
		}
		if (puntos==16) {
			porcent="25%";
		}
		if (puntos>=17) {
			porcent="> 30%";
		}
	} else {
		if ((TAsis>=120)||(TAsis<=129)) {
			if (Medica==1) {
				puntos=puntos+3;
			} else {
				puntos=puntos+1;
			}
		}
		if ((TAsis>=130)||(TAsis<=139)) {
			if (Medica==1) {
				puntos=puntos+4;
			} else {
				puntos=puntos+2;
			}
		}
		if ((TAsis>=140)||(TAsis<=159)) {
			if (Medica==1) {
				puntos=puntos+5;
			} else {
				puntos=puntos+3;
			}
		}
		if ((TAsis>=160)) {
			if (Medica==1) {
				puntos=puntos+6;
			} else {
				puntos=puntos+4;
			}
		}
		if (HDLc<40) {
			puntos=puntos+2;
		} else {
			if((HDLc>=40)||(HDLc<=49)) {
				puntos=puntos+1;
			} else {
				if((HDLc>=60)) {
					puntos=puntos-1;
				}
			}
		}
		if ((Edad>=20)||(Edad<=34) ) {
			puntos=puntos-7;
			if (Fuma==1) {
				puntos=puntos+9;
			}
			if ((tCOL>=160)||(tCOL<=199)) {
				puntos=puntos+4;
			} else {
				if ((tCOL>=200)||(tCOL<=239)) {
					puntos=puntos+8;
				} else {
					if ((tCOL>=240)||(tCOL<=279)) {
						puntos=puntos+11;
					} else {
						if ((tCOL>=280)) {
							puntos=puntos+13;
						} else {
							
						}
					}
				}
			}
		} else {
			if ((Edad>=35)||(Edad<=39) ) {
				puntos=puntos-3;
				if (Fuma==1) {
					puntos=puntos+9;
				}
				if ((tCOL>=160)||(tCOL<=199)) {
					puntos=puntos+4;
				} else {
					if ((tCOL>=200)||(tCOL<=239)) {
						puntos=puntos+8;
					} else {
						if ((tCOL>=240)||(tCOL<=279)) {
							puntos=puntos+11;
						} else {
							if ((tCOL>=280)) {
								puntos=puntos+13;
							}
						}
					}
				}
			} else {
				if ((Edad>=40)||(Edad<=44) ) {
					puntos=puntos+0;
					if (Fuma==1) {
						puntos=puntos+7;
					}
					if ((tCOL>=160)||(tCOL<=199)) {
						puntos=puntos+3;
					} else {
						if ((tCOL>=200)||(tCOL<=239)) {
							puntos=puntos+6;
						} else {
							if ((tCOL>=240)||(tCOL<=279)) {
								puntos=puntos+8;
							} else {
								if ((tCOL>=280)) {
									puntos=puntos+10;
								}
							}
						}
					}
				} else {
					if ((Edad>=45)||(Edad<=49) ) {
						puntos=puntos+3;
						if (Fuma==1) {
							puntos=puntos+7;
						}
						if ((tCOL>=160)||(tCOL<=199)) {
							puntos=puntos+3;
						} else {
							if ((tCOL>=200)||(tCOL<=239)) {
								puntos=puntos+6;
							} else {
								if ((tCOL>=240)||(tCOL<=279)) {
									puntos=puntos+8;
								} else {
									if ((tCOL>=280)) {
										puntos=puntos+10;
									}
								}
							}
						}
					} else {
						if ((Edad>=50)||(Edad<=54) ) {
							puntos=puntos+6;
							if (Fuma==1) {
								puntos=puntos+4;
							}
							if ((tCOL>=160)||(tCOL<=199)) {
								puntos=puntos+2;
							} else {
								if ((tCOL>=200)||(tCOL<=239)) {
									puntos=puntos+4;
								} else {
									if ((tCOL>=240)||(tCOL<=279)) {
										puntos=puntos+5;
									} else {
										if ((tCOL>=280)) {
											puntos=puntos+7;
										}
									}
								}
							}
						} else {
							if ((Edad>=55)||(Edad<=59) ) {
								puntos=puntos+8;
								if (Fuma==1) {
									puntos=puntos+4;
								}
								if ((tCOL>=160)||(tCOL<=199)) {
									puntos=puntos+2;
								} else {
									if ((tCOL>=200)||(tCOL<=239)) {
										puntos=puntos+4;
									} else {
										if ((tCOL>=240)||(tCOL<=279)) {
											puntos=puntos+5;
										} else {
											if ((tCOL>=280)) {
												puntos=puntos+7;
											}
										}
									}
								}
							} else {
								if ((Edad>=60)||(Edad<=64) ) {
									puntos=puntos+10;
									if (Fuma==1) {
										puntos=puntos+2;
									}
									if ((tCOL>=160)||(tCOL<=199)) {
										puntos=puntos+1;
									} else {
										if ((tCOL>=200)||(tCOL<=239)) {
											puntos=puntos+2;
										} else {
											if ((tCOL>=240)||(tCOL<=279)) {
												puntos=puntos+3;
											} else {
												if ((tCOL>=280)) {
													puntos=puntos+4;
												}
											}
										}
									}
								} else {
									if ((Edad>=65)||(Edad<=69) ) {
										puntos=puntos+12;
										if (Fuma==1) {
											puntos=puntos+2;
										}
										if ((tCOL>=160)||(tCOL<=199)) {
											puntos=puntos+1;
										} else {
											if ((tCOL>=200)||(tCOL<=239)) {
												puntos=puntos+2;
											} else {
												if ((tCOL>=240)||(tCOL<=279)) {
													puntos=puntos+3;
												} else {
													if ((tCOL>=280)) {
														puntos=puntos+4;
													}
												}
											}
										}
									} else {
										if ((Edad>=70)||(Edad<=74) ) {
											puntos=puntos+14;
											if (Fuma==1) {
												puntos=puntos+1;
											}
											if ((tCOL>=160)||(tCOL<=199)) {
												puntos=puntos+0;
											} else {
												if ((tCOL>=200)||(tCOL<=239)) {
													puntos=puntos+1;
												} else {
													if ((tCOL>=240)||(tCOL<=279)) {
														puntos=puntos+2;
													} else {
														if ((tCOL>=280)) {
															puntos=puntos+2;
														}
													}
												}
											}
										} else {
											if ((Edad>=75) ) {
												puntos=puntos+16;
												if (Fuma==1) {
													puntos=puntos+1;
												}
												if ((tCOL>=160)||(tCOL<=199)) {
													puntos=puntos+0;
												} else {
													if ((tCOL>=200)||(tCOL<=239)) {
														puntos=puntos+1;
													} else {
														if ((tCOL>=240)||(tCOL<=279)) {
															puntos=puntos+2;
														} else {
															if ((tCOL>=280)) {
																puntos=puntos+2;
															}
														}
													}
												}
											} 
										}
									}
								}
							}
						}
					}	
				}	
			}
		}
		if ((puntos>=0)||(puntos<=8)) {
			porcent="< 1%";
		}
		if ((puntos>=9)||(puntos<=12)) {
			porcent="1%";
		}
		if ((puntos>=13)||(puntos<=14)) {
			porcent="2%";
		}
		if (puntos==15) {
			porcent="3%";
		}
		if (puntos==16) {
			porcent="4%";
		}
		if (puntos==17) {
			porcent="5%";
		}
		if (puntos==18) {
			porcent="6%";
		}
		if (puntos==19) {
			porcent="8%";
		}
		if (puntos==20) {
			porcent="11%";
		}
		if (puntos==21) {
			porcent="14%";
		}
		if (puntos==22) {
			porcent="17%";
		}
		if (puntos==23) {
			porcent="22%";
		}
		if (puntos==24) {
			porcent="27%";
		}
		if (puntos>=25) {
			porcent="> 30%";
		}
	}
	document.getElementById('txt_puntosf<?php echo $NumWindow; ?>').value=puntos;
	document.getElementById('txt_porcf<?php echo $NumWindow; ?>').value=porcent;
}
<?php } ?>
$(':input', $("#frm_form<?php echo $NumWindow; ?>")).each(function() {
	Var1=this.id;
	$(this).addClass("hcx_<?php echo $NumWindow; ?>");
});

function ShowFolio<?php echo $NumWindow; ?>(Tercero, Folio) {
	$('#GnmX_WinModal').modal('show');
	CargarWind('HC '+Tercero, 'reports/hc.php?HISTORIA='+Tercero+'&FOLIO_INICIAL='+Folio+'&FOLIO_FINAL='+Folio, 'default.png', 'hc.php','<?php echo $NumWindow; ?>' );
}

function ShowHlpRes<?php echo $NumWindow; ?>(NumSol, CodSER) {
	$('#GnmX_WinModal').modal('show');
	CargarWind('Resultados Examenes', 'forms/lbordenes.php?NumSol='+NumSol+'&Mode=hc&CodSER='+CodSER, '1.TestTubes.png', 'hc.php','<?php echo $NumWindow; ?>' );
}

<?php

if ($IncapacidadHCT=="1") {
	$SQL="Select date(now());";
	$result = mysqli_query($conexion, $SQL);
	if ($row = mysqli_fetch_array($result))  {
		echo "
		document.getElementById('txt_fecincapini".$NumWindow."').value='".$row[0]."';
		document.getElementById('txt_fecincapfin".$NumWindow."').value='".$row[0]."';";
	}
	mysqli_free_result($result); 
	 
?>

	function RecalcIncap<?php echo $NumWindow; ?>(Cambio) {
		fecini=document.getElementById('txt_fecincapini<?php echo $NumWindow; ?>').value;
		fecfin=document.getElementById('txt_fecincapfin<?php echo $NumWindow; ?>').value;
		dias=parseInt(document.getElementById('txt_diasincap<?php echo $NumWindow; ?>').value);
		mes="00";
		dia="00";
		var xfecfin = new Date(document.getElementById('txt_fecincapini<?php echo $NumWindow; ?>').value);
		var xfecini = new Date(document.getElementById('txt_fecincapini<?php echo $NumWindow; ?>').value);
		
		if (Cambio=="fecfin") {
			if (fecfin<=fecini) {
				document.getElementById('txt_fecincapfin<?php echo $NumWindow; ?>').value=document.getElementById('txt_fecincapini<?php echo $NumWindow; ?>').value;
				document.getElementById('txt_diasincap<?php echo $NumWindow; ?>').value="1";
			} else {
				var fechaini = new Date(fecini).getTime();
				var fechafin = new Date(fecfin).getTime();
				var diff = fechafin - fechaini;
				dias=(diff/86400000)+1;
				document.getElementById('txt_diasincap<?php echo $NumWindow; ?>').value=dias;
			}
		} else {
				xfecfin.setDate(xfecfin.getDate() + dias );
				mes=(xfecfin.getMonth() + 1).toString();
				if (mes.toString().length==1) {
					mes="0"+mes;
				}
				dia=(xfecfin.getDate()).toString();
				if (dia.toString().length==1) {
					dia="0"+dia;
				}
				fecfin= xfecfin.getFullYear() + '-' + mes + '-' + dia;
				document.getElementById('txt_fecincapfin<?php echo $NumWindow; ?>').value=fecfin;
		}
	}

<?php
	
}

	if (isset($_GET["Cita"])) {
		$SQL="Select Codigo_ARE from gxcitasmedicas a, gxagendacab b Where a.Codigo_AGE=b.Codigo_AGE and Codigo_CIT='".$_GET["Cita"]."'";
		$resultvf = mysqli_query($conexion, $SQL);
		if($rowvf = mysqli_fetch_array($resultvf)) {
			echo "
			document.getElementById('cmb_area".$NumWindow."').value = '".$rowvf[0]."';
			";
		}
		mysqli_free_result($resultvf); 
	}
	if (isset($_GET["Area"])) {
		echo "document.getElementById('cmb_area".$NumWindow."').value = '".$_GET["Area"]."';";
	}
	if (isset($_GET["Historia"])) {
		if (trim($_GET["Historia"])!="") {
			$SQL="Select a.Codigo_TER, b.Nombre_TER, c.Codigo_ADM, e.Nombre_TER, f.Nombre_PLA, g.Nombre_RNG, a.fechanac_pac, a.Codigo_SEX, a.EstCivil_PAC, b.direccion_ter, b.telefono_ter, a.Actividad_PAC, c.Acudiente_ADM, c.Parentesco_ADM, c.Telefono_ADM, h.Descripcion_ADM, c.Observaciones_ADM, left(Fecha_ADM,10), c.Autorizacion_ADM, c.Codigo_EPS, c.Codigo_PLA, Nombre_PTT, b.Correo_TER from gxpacientestipos z, gxpacientes a, czterceros b, gxadmision c, gxeps d, czterceros e, gxplanes f, gxrangosalario g, gxtipoingreso h where z.Codigo_PTT=c.Codigo_PTT and h.Tipo_ADM=c.Ingreso_ADM and g.Codigo_RNG=a.Codigo_RNG and f.codigo_pla=c.codigo_pla and d.codigo_eps=c.codigo_eps and d.codigo_ter=e.codigo_ter and a.Codigo_TER=b.Codigo_TER and c.Codigo_TER=a.Codigo_TER and c.Estado_ADM='I' and b.ID_TER='".$_GET["Historia"]."' order by fecha_adm desc limit 1";
			$result = mysqli_query($conexion, $SQL);
			echo "
				document.frm_form".$NumWindow.".txt_idhc".$NumWindow.".value='".$_GET["Historia"]."';";
			if($row = mysqli_fetch_array($result)) {
			echo "
				document.getElementById('spn_contrato".$NumWindow."').innerHTML = '".$row[3]."';
				document.getElementById('spn_plan".$NumWindow."').innerHTML = '".$row[4]."';
				document.getElementById('spn_rango".$NumWindow."').innerHTML = '".$row[5]."';
				document.getElementById('spn_fechanac".$NumWindow."').innerHTML = '".formatofecha($row[6])."';
				document.getElementById('spn_edad".$NumWindow."').innerHTML = '".edad($row[6])."';
				document.getElementById('spn_sexo".$NumWindow."').innerHTML = '".$row[7]."';
				document.getElementById('spn_estcivil".$NumWindow."').innerHTML = '".$row[8]."';
				document.getElementById('spn_direccion".$NumWindow."').innerHTML = '".$row[9]."';
				document.getElementById('spn_telefono".$NumWindow."').innerHTML = '".$row[10]."';
				document.getElementById('spn_ocupacion".$NumWindow."').innerHTML = '".$row[11]."';
				document.getElementById('spn_acomp".$NumWindow."').innerHTML = '".$row[12]."';
				document.getElementById('spn_parentesco".$NumWindow."').innerHTML = '".$row[13]."';
				document.getElementById('spn_telacomp".$NumWindow."').innerHTML = '".$row[14]."';
				document.getElementById('spn_ingpor".$NumWindow."').innerHTML = '".$row[15]."';
				document.getElementById('spn_correoel".$NumWindow."').innerHTML = '".strtolower($row[22])."';
				document.getElementById('spn_tipopte".$NumWindow."').innerHTML = '".$row["Nombre_PTT"]."';
				document.getElementById('spn_obs".$NumWindow."').innerHTML = '".preg_replace("/\r\n|\n|\r/", "<br/>",$row[16])."';
				document.getElementById('spn_fechaing".$NumWindow."').innerHTML = '".formatofecha($row[17])."';
				document.getElementById('hdn_autorizacion".$NumWindow."').value = '".$row[18]."';
				document.getElementById('hdn_contrato".$NumWindow."').value = '".$row[19]."';
				document.getElementById('hdn_plan".$NumWindow."').value = '".$row[20]."';
				document.getElementById('hdn_codigoter".$NumWindow."').value = '".$row[0]."';
				document.getElementById('txt_paciente".$NumWindow."').value = '".$row[1]."';
				document.getElementById('txt_ingreso".$NumWindow."').value = '".$row[2]."';
				document.getElementById('NombrePCTE".$NumWindow."').innerHTML = ' - ".$_GET["Historia"]." - ".$row[1]."';
				";
			}
			else {
				echo "
				MsgBox1('Historia Clínica','No se encuentran datos para la H.C. ".$_GET["Historia"]." o no posee ingresos activos.');
			document.frm_form".$NumWindow.".cmb_area".$NumWindow.".focus();
				";
			}
			mysqli_free_result($result); 
		}
	}
	else {
	echo '$(":input:text:visible:first", "#frm_form'.$NumWindow.'").focus();';
	}
?>

function selecthc<?php echo $NumWindow; ?>(CodigoHCT) {
	AbrirForm('application/forms/hc.php', '<?php echo $NumWindow; ?>', '&ModeHC=<?php echo $ModeHC;?>&FormatoHC='+CodigoHCT+'&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value+'&Area='+document.getElementById('cmb_area<?php echo $NumWindow; ?>').value);
}

function BuscarHCPte<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	if (document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value=="") {
		AbrirForm('application/forms/hc.php', '<?php echo $NumWindow; ?>', '&ModeHC=<?php echo $ModeHC;?>&FormatoHC='+document.getElementById('hdn_formatohc<?php echo $NumWindow; ?>').value+'&Area='+document.getElementById('cmb_area<?php echo $NumWindow; ?>').value);
	} else {
		AbrirForm('application/forms/hc.php', '<?php echo $NumWindow; ?>', '&ModeHC=<?php echo $ModeHC;?>&FormatoHC='+document.getElementById('hdn_formatohc<?php echo $NumWindow; ?>').value+'&Historia='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value+'&Area='+document.getElementById('cmb_area<?php echo $NumWindow; ?>').value);
	}  
  }
}

function HCPteOnBlur<?php echo $NumWindow; ?>() {
	theHistory=document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value;
	theFormatoHC=document.getElementById('hdn_formatohc<?php echo $NumWindow; ?>').value;
	if (theHistory!=varHystory) {
		AbrirForm('application/forms/hc.php', '<?php echo $NumWindow; ?>', '&ModeHC=<?php echo $ModeHC;?>&FormatoHC='+theFormatoHC+'&Historia='+theHistory+'&Area='+document.getElementById('cmb_area<?php echo $NumWindow; ?>').value);
	}
}

<?php
	$SQL="Select a.* from hcsv2 a, hcsv3 b where a.Codigo_HSV=b.Codigo_HSV and Codigo_SV1='".$SVHCT."' and Calculo_HSV<>'' order by Orden_HSV";
	$resultz = mysqli_query($conexion, $SQL);
	while($rowz = mysqli_fetch_array($resultz)) {
?>
function calc_sv<?php echo $rowz["Codigo_HSV"].$NumWindow; ?>() {
	valorsv="0";
	<?php
		$SQL="Select Codigo_HSV from hcsv2 where Vinculado_HSV='".$rowz["Codigo_HSV"]."' and Activo_HSV='1' Order by Codigo_HSV";
		$resultxz = mysqli_query($conexion, $SQL);
		while($rowxz = mysqli_fetch_array($resultxz)) {
			echo '
			var clases'.$rowxz["Codigo_HSV"].' = document.getElementsByClassName("sv_'.$rowxz["Codigo_HSV"].$NumWindow.'");
			variable'.$rowxz["Codigo_HSV"].' = clases'.$rowxz["Codigo_HSV"].'[0].value;
			';

		}
		mysqli_free_result($resultxz); 
		$calcularsv=$rowz["Calculo_HSV"];
		$calcularsv=str_replace('{','variable',$calcularsv);
		$calcularsv=str_replace('}','',$calcularsv);
		
	?>
	
	valorsv=<?php echo $calcularsv; ?>;


	var clasesIMC = document.getElementsByClassName("sv_<?php echo $rowz["Codigo_HSV"].$NumWindow; ?>");
	if (isFinite(valorsv)==false) {
		valorsv="";
	}
	else {
		valorsv=parseFloat(Math.round(valorsv * 100) / 100).toFixed(2);
	}

	clasesIMC[0].value=valorsv;
	
}
<?php
	}
	mysqli_free_result($resultz); 
?>

function AddAnt<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_antecdentext<?php echo $NumWindow; ?>').value=="") {
		xError="Digite descripcion del antecedente";
	}
	if (xError=="") {
		TotalFilas=document.getElementById("hdn_controwantX<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tblDetalleantX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trant"+TotalFilas+"<?php echo $NumWindow; ?>";
		TipoAnte=document.getElementById('cmb_cmbant<?php echo $NumWindow; ?>').value;
		var combo = document.getElementById('cmb_cmbant<?php echo $NumWindow; ?>');
		var TextAnte = combo.options[combo.selectedIndex].text;
		DescrpAnte=document.getElementById('txt_antecdentext<?php echo $NumWindow; ?>').value;
		DescrpAnte=DescrpAnte.toUpperCase();
		celda1.innerHTML = '<input name="hdn_tantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_tantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+TipoAnte+'" /> '+TextAnte; 
		celda2.innerHTML = '<input name="hdn_dantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_dantecedente'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+DescrpAnte+''+'" /> '+DescrpAnte; 
		celda3.innerHTML = '<input name="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" value="O" /> <button onclick="EliminarFilaAnt<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
		fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwantX<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('cmb_cmbant<?php echo $NumWindow; ?>').focus();
		document.getElementById("txt_antecdentext<?php echo $NumWindow; ?>").value="";
	}
	
}

function EliminarFilaAnt<?php echo $NumWindow; ?>(Numero) {
	var miTabla = document.getElementById("tblDetalleantX<?php echo $NumWindow; ?>");     
    $('#trant'+Numero+"<?php echo $NumWindow; ?>").remove();
}

<?php 
	//Medicamentos
	if ($MedHCT=="1") {
?>
function CantidadMed<?php echo $NumWindow; ?>() {
	Frecx=document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').value;
	if (Frecx=="0") {
		document.getElementById('txt_cantmed<?php echo $NumWindow; ?>').value="1";
	} else {
		if (Frecx=="99") {
			document.getElementById('txt_cantmed<?php echo $NumWindow; ?>').value="1";
		} else {
			Duracx=document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value;
			Durac2x=document.getElementById('cmb_tiempo<?php echo $NumWindow; ?>').value;
			Dosisx=document.getElementById('txt_dosis<?php echo $NumWindow; ?>').value;
			Dosis2x=document.getElementById('hdn_dosish<?php echo $NumWindow; ?>').value;
			if (Dosis2x=="0") {
				document.getElementById('hdn_dosish<?php echo $NumWindow; ?>').value=Dosisx;
			}
			CantMedx=Duracx*(Durac2x/Frecx)*(Dosisx/Dosis2x);
			CantMedx=Math.round(CantMedx);
			/* alert(Duracx+'*('+Durac2x+'/'+Frecx+')*('+Dosisx+'/'+Dosis2x+')'); */
			document.getElementById('txt_cantmed<?php echo $NumWindow; ?>').value=CantMedx;
		}
	}
}

function CodMedOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value!="") {
		NombreMedicamento(document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');
	} else {
		document.getElementById('txt_medicamento<?php echo $NumWindow; ?>').value = '';
	}
}

function EliminarFilaMed<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalle<?php echo $NumWindow; ?>");     
    $('#trmed'+Numero+"<?php echo $NumWindow; ?>").remove();
}  

function AddMedica<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione la duracion del suministro del medicamento a ordenar";
	}
	if (document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value=="0") {
		xError="Seleccione una duracion del medicamento mayor";
	}
	if (document.getElementById('txt_dosis<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione la dosis del medicamento a ordenar";
	}
	if (document.getElementById('txt_dosis<?php echo $NumWindow; ?>').value=="0") {
		xError="Seleccione una dosis del medicamento mayor";
	}
	if (document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione el medicamento a ordenar";
	}
	if (document.getElementById('txt_medicamento<?php echo $NumWindow; ?>').value=='<SPAN CLASS="ERROR">NO SE ENCUENTRA EL SERVICIO</SPAN>') {
		xError="El codigo no es valido";
	}

	if (xError!="") {
		MsgBox1('Orden de Medicamentos', xError);
	} else {
		TotalFilas=document.getElementById("hdn_controwMed<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbMedX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
	    var celda5 = document.createElement("td"); 
	    var celda6 = document.createElement("td"); 
	    var celda9 = document.createElement("td"); 
	    var celda7 = document.createElement("td"); 
	    var celda8 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trmed"+TotalFilas+"<?php echo $NumWindow; ?>";
		CodMed=document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value;
		Medicamento=document.getElementById('txt_medicamento<?php echo $NumWindow; ?>').value;
		Dosis=document.getElementById('txt_dosis<?php echo $NumWindow; ?>').value+ ' '+document.getElementById('cmb_unidad<?php echo $NumWindow; ?>').options[document.getElementById('cmb_unidad<?php echo $NumWindow; ?>').selectedIndex].text;
		Via=document.getElementById('cmb_via<?php echo $NumWindow; ?>').value;
		Via2=document.getElementById('cmb_via<?php echo $NumWindow; ?>').options[document.getElementById('cmb_via<?php echo $NumWindow; ?>').selectedIndex].text;
		Frec=document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').value;
		Frec2=document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').options[document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').selectedIndex].text;
		Durac=document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value;
	    Durac2=document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value+ ' '+document.getElementById('cmb_tiempo<?php echo $NumWindow; ?>').options[document.getElementById('cmb_tiempo<?php echo $NumWindow; ?>').selectedIndex].text;
	    CantMed=document.getElementById('txt_cantmed<?php echo $NumWindow; ?>').value;
		ObsMed=document.getElementById('txt_obsmed<?php echo $NumWindow; ?>').value;
		celda2.innerHTML = '<input name="hdn_codmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodMed+''+'" /> '+Medicamento; 
		celda3.innerHTML = '<input name="hdn_dosis'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_dosis'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Dosis+''+'" /> '+Dosis; 
		celda4.innerHTML = '<input name="hdn_via'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_via'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Via+''+'" /> '+Via2; 
		celda5.innerHTML = '<input name="hdn_frecuencia'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_frecuencia'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Frec+''+'" /> '+Frec2; 
		celda6.innerHTML = '<input name="hdn_duracion'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_duracion'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Durac2+''+'" /> '+Durac2; 
		celda9.innerHTML = '<input name="hdn_cantmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_cantmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantMed+'" /> '+CantMed; 
		celda7.innerHTML = '<input name="hdn_obsmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_obsmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ObsMed+''+'" /> '+ObsMed; 
		celda8.innerHTML = '<input name="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" value="O" /><button onclick="EliminarFilaMed<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    fila.appendChild(celda4); 
	    fila.appendChild(celda5); 
	    fila.appendChild(celda6); 
	    fila.appendChild(celda9); 
	    fila.appendChild(celda7); 
	    fila.appendChild(celda8); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwMed<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_codmed<?php echo $NumWindow; ?>').focus();
	}
}

<?php 
	}
	//Ayudas Diagnosticas
	if ($AyudasDiagHCT=="1") {
?>

function CodServDxOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').value!="") {
		NombreServicioDx(document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');
	} else {
		document.getElementById('txt_serviciodx<?php echo $NumWindow; ?>').value = '';
	}
}

function EliminarFilaHlpDx<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetallehlpdx<?php echo $NumWindow; ?>");     
    $('#trhlpdx'+Numero+"<?php echo $NumWindow; ?>").remove();
}  

function AddHelpDx<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione el servicio a ordenar";
	}
	if (document.getElementById('txt_serviciodx<?php echo $NumWindow; ?>').value=='<SPAN CLASS="ERROR">NO SE ENCUENTRA EL SERVICIO</SPAN>') {
		xError="El codigo no es valido";
	}

	if (xError!="") {
		MsgBox1('Orden de Servicios Diagnósticos', xError);
	} else {
		TotalFilas=document.getElementById("hdn_controwhlpdx<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbhlpdx<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	     var celda0 = document.createElement("td"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trhlpdx"+TotalFilas+"<?php echo $NumWindow; ?>";
		CodHlpDx=document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').value;
		ServicioDx=document.getElementById('txt_serviciodx<?php echo $NumWindow; ?>').value;
		CantHlpDx=document.getElementById('txt_cantservdx<?php echo $NumWindow; ?>').value;
		ObsHlpDx=document.getElementById('txt_obsserdx<?php echo $NumWindow; ?>').value;
		celda0.innerHTML = '<input name="hdn_codhlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codhlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodHlpDx+''+'" /> '+CodHlpDx; 
		celda1.innerHTML = ' '+ServicioDx; 
		celda2.innerHTML = '<input name="hdn_canthlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_canthlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantHlpDx+'" /> '+CantHlpDx; 
		celda3.innerHTML = '<input name="hdn_obshlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_obshlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ObsHlpDx+''+'" /> '+ObsHlpDx; 
		celda4.innerHTML = '<button onclick="EliminarFilaHlpDx<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
		fila.appendChild(celda0); 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    fila.appendChild(celda4); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwhlpdx<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').focus();
	}
}

<?php 
	}

	// Medicamentos Quimio
	if ($MedQuimioHCT=="1") {
?>

function CodmquimOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_codmquim<?php echo $NumWindow; ?>').value!="") {
		NombreDispositivo(document.getElementById('txt_codmquim<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');
	} else {
		document.getElementById('txt_nombremquim<?php echo $NumWindow; ?>').value = '';
	}
}

function EliminarFilamquim<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetallemquim<?php echo $NumWindow; ?>");     
    $('#trhmquim'+Numero+"<?php echo $NumWindow; ?>").remove();
}  

function Addmquim<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_codmquim<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione el medicamento suministrado";
	}
	if (document.getElementById('txt_nombremquim<?php echo $NumWindow; ?>').value=='<SPAN CLASS="ERROR">NO SE ENCUENTRA EL SERVICIO</SPAN>') {
		xError="El codigo no es valido";
	}

	if (xError!="") {
		MsgBox1('Medicamentos Quimio', xError);
	} else {
		TotalFilas=document.getElementById("hdn_controwmquim<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbmquim<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	     var celda0 = document.createElement("td"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trhmquim"+TotalFilas+"<?php echo $NumWindow; ?>";
		CodIns=document.getElementById('txt_codmquim<?php echo $NumWindow; ?>').value;
		Insumo=document.getElementById('txt_nombremquim<?php echo $NumWindow; ?>').value;
		CantInsumo=document.getElementById('txt_cantmquim<?php echo $NumWindow; ?>').value;
		celda0.innerHTML = '<input name="hdn_codmquim'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codmquim'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodIns+''+'" /> '+CodIns; 
		celda1.innerHTML = ' '+Insumo; 
		celda2.innerHTML = '<input name="hdn_cantmquim'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_cantmquim'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantInsumo+'" /> '+CantInsumo; 
		celda4.innerHTML = '<button onclick="EliminarFilamquim<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
		fila.appendChild(celda0); 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda4); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwmquim<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_codmquim<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_nombremquim<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_codmquim<?php echo $NumWindow; ?>').focus();
	}
}

<?php 
	}	
	//Insumos
	if ($InsumosHCT=="1") {
?>

function CodInsumosOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_codinsumo<?php echo $NumWindow; ?>').value!="") {
		NombreDispositivo(document.getElementById('txt_codinsumo<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');
	} else {
		document.getElementById('txt_nombreserv<?php echo $NumWindow; ?>').value = '';
	}
}

function EliminarFilaInsumo<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalleins<?php echo $NumWindow; ?>");     
    $('#trhins'+Numero+"<?php echo $NumWindow; ?>").remove();
}  

function AddInsumo<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_codinsumo<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione el insumo a cargar";
	}
	if (document.getElementById('txt_nombreserv<?php echo $NumWindow; ?>').value=='<SPAN CLASS="ERROR">NO SE ENCUENTRA EL SERVICIO</SPAN>') {
		xError="El codigo no es valido";
	}

	if (xError!="") {
		MsgBox1('Insumos', xError);
	} else {
		TotalFilas=document.getElementById("hdn_controwins<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbins<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	     var celda0 = document.createElement("td"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trhins"+TotalFilas+"<?php echo $NumWindow; ?>";
		CodIns=document.getElementById('txt_codinsumo<?php echo $NumWindow; ?>').value;
		Insumo=document.getElementById('txt_nombreserv<?php echo $NumWindow; ?>').value;
		CantInsumo=document.getElementById('txt_cantinsumo<?php echo $NumWindow; ?>').value;
		celda0.innerHTML = '<input name="hdn_codinsumo'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codinsumo'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodIns+''+'" /> '+CodIns; 
		celda1.innerHTML = ' '+Insumo; 
		celda2.innerHTML = '<input name="hdn_cantinsumo'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_cantinsumo'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantInsumo+'" /> '+CantInsumo; 
		celda4.innerHTML = '<button onclick="EliminarFilaInsumo<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
		fila.appendChild(celda0); 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda4); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwins<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_codinsumo<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_nombreserv<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_codinsumo<?php echo $NumWindow; ?>').focus();
	}
}

<?php 
	}	
	//Procedimientos
	if ($OrdQxHCT=="1") {
?>

function CodServQxOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_codserqx<?php echo $NumWindow; ?>').value!="") {
		NombreServicioQx(document.getElementById('txt_codserqx<?php echo $NumWindow; ?>').value, '<?php echo $NumWindow; ?>');
	} else {
		document.getElementById('txt_servicioqx<?php echo $NumWindow; ?>').value = '';
	}
}

function EliminarFilaOrdQx<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalleordqx<?php echo $NumWindow; ?>");     
    $('#trordqx'+Numero+"<?php echo $NumWindow; ?>").remove();
}  

function AddOrdQx<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_codserqx<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione el servicio a ordenar";
	}
	if (document.getElementById('txt_servicioqx<?php echo $NumWindow; ?>').value=='<SPAN CLASS="ERROR">NO SE ENCUENTRA EL SERVICIO</SPAN>') {
		xError="El codigo no es valido";
	}

	if (xError!="") {
		MsgBox1('Orden de Procedimientos', xError);
	} else {
		TotalFilas=document.getElementById("hdn_controwordqx<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbordqx<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	     var celda0 = document.createElement("td"); 
	    var celda1 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trordqx"+TotalFilas+"<?php echo $NumWindow; ?>";
		CodOrdQx=document.getElementById('txt_codserqx<?php echo $NumWindow; ?>').value;
		ServicioQx=document.getElementById('txt_servicioqx<?php echo $NumWindow; ?>').value;
		CantOrdQx=document.getElementById('txt_cantservqx<?php echo $NumWindow; ?>').value;
		ObsOrdQx=document.getElementById('txt_obsserqx<?php echo $NumWindow; ?>').value;
		celda0.innerHTML = '<input name="hdn_codordqx'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codordqx'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodOrdQx+''+'" /> '+CodOrdQx; 
		celda1.innerHTML = ' '+ServicioQx; 
		celda2.innerHTML = '<input name="hdn_cantordqx'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_cantordqx'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantOrdQx+'" /> '+CantOrdQx; 
		celda3.innerHTML = '<input name="hdn_obsordqx'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_obsordqx'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ObsOrdQx+''+'" /> '+ObsOrdQx; 
		celda4.innerHTML = '<button onclick="EliminarFilaOrdQx<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
		fila.appendChild(celda0); 
	    fila.appendChild(celda1); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    fila.appendChild(celda4); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwordqx<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_codserqx<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_codserqx<?php echo $NumWindow; ?>').focus();
	}
}

<?php 
	}
	//ordenes de Servicio
	if ($OrdenesHCT=="1") {
?>
function CantidadServ<?php echo $NumWindow; ?>() {
	Frec=document.getElementById('cmb_frecuenciat<?php echo $NumWindow; ?>').value;
	Durac=document.getElementById('txt_duraciont<?php echo $NumWindow; ?>').value;
	Durac2=document.getElementById('cmb_tiempot<?php echo $NumWindow; ?>').value;
	CantTer=Frec*Durac*Durac2;
	CantTer=Math.round(CantTer);
	document.getElementById('txt_cantt<?php echo $NumWindow; ?>').value=CantTer;
}

function EliminarFilaServ<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalle<?php echo $NumWindow; ?>");     
    $('#trserv'+Numero+"<?php echo $NumWindow; ?>").remove();
}  


function AddServicio<?php echo $NumWindow; ?>() {
	xError="";
	if (document.getElementById('txt_duraciont<?php echo $NumWindow; ?>').value=="") {
		xError="Seleccione la duracion del servicio a ordenar";
	}
	if (document.getElementById('txt_duraciont<?php echo $NumWindow; ?>').value=="0") {
		xError="Seleccione una duracion de servicio mayor";
	}
	
	if (xError!="") {
		MsgBox1('Orden de Servicios', xError);
	} else {
		TotalFilas=document.getElementById("hdn_controwTer<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbTerX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda4 = document.createElement("td"); 
	    var celda5 = document.createElement("td"); 
	    var celda6 = document.createElement("td"); 
	    var celda2 = document.createElement("td"); 
	    var celda7 = document.createElement("td"); 
	    var celda9 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trserv"+TotalFilas+"<?php echo $NumWindow; ?>";
		Terapiat=document.getElementById('cmb_tipot<?php echo $NumWindow; ?>').value;
		Frec=document.getElementById('cmb_frecuenciat<?php echo $NumWindow; ?>').value;
		Frec2=document.getElementById('cmb_frecuenciat<?php echo $NumWindow; ?>').options[document.getElementById('cmb_frecuenciat<?php echo $NumWindow; ?>').selectedIndex].text;
		Durac=document.getElementById('txt_duraciont<?php echo $NumWindow; ?>').value;
	    Durac2=document.getElementById('txt_duraciont<?php echo $NumWindow; ?>').value+ ' '+document.getElementById('cmb_tiempot<?php echo $NumWindow; ?>').options[document.getElementById('cmb_tiempot<?php echo $NumWindow; ?>').selectedIndex].text;
	    CantTer=document.getElementById('txt_cantt<?php echo $NumWindow; ?>').value;
		ObsTer=document.getElementById('txt_obster<?php echo $NumWindow; ?>').value;
		celda4.innerHTML = '<input name="hdn_tipot'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_tipot'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Terapiat+'" /> '+Terapiat; 
		celda5.innerHTML = '<input name="hdn_frecuenciat'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_frecuenciat'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Frec+''+'" /> '+Frec2; 
		celda6.innerHTML = '<input name="hdn_duraciont'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_duraciont'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Durac+''+'" /> '+Durac2; 
		celda2.innerHTML = '<input name="hdn_cantt'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_cantt'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantTer+''+'" /> '+CantTer; 
		celda7.innerHTML = '<input name="hdn_obster'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_obster'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ObsTer+''+'" /> '+ObsTer; 
		celda9.innerHTML = '<input name="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" value="O" /> <button onclick="EliminarFilaServ<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
		fila.appendChild(celda4); 
	    fila.appendChild(celda5); 
	    fila.appendChild(celda6); 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda7); 
	    fila.appendChild(celda9); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwTer<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('cmb_tipot<?php echo $NumWindow; ?>').focus();
	}
}

<?php 
	}
	//Diagnosticos
	if ($DxHCT=="1") {
?>
function HCDxOnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_dxppal<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_dxppal<?php echo $NumWindow; ?>').value, document.getElementById('txt_dxppal1<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_dxppal1<?php echo $NumWindow; ?>').value = '';
	}
}

function HCDxR1OnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_dxrel1<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_dxrel1<?php echo $NumWindow; ?>').value, document.getElementById('txt_dxrel11<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_dxrel11<?php echo $NumWindow; ?>').value = '';
	}
}

function HCDxR2OnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_dxrel2<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_dxrel2<?php echo $NumWindow; ?>').value, document.getElementById('txt_dxrel22<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_dxrel22<?php echo $NumWindow; ?>').value = '';
	}
}

function HCDxR3OnBlur<?php echo $NumWindow; ?>() {
	if (document.getElementById('txt_dxrel3<?php echo $NumWindow; ?>').value!="") {
		NombreDx(document.getElementById('txt_dxrel3<?php echo $NumWindow; ?>').value, document.getElementById('txt_dxrel33<?php echo $NumWindow; ?>'));
	} else {
		document.getElementById('txt_dxrel33<?php echo $NumWindow; ?>').value = '';
	}
}
<?php 
	}

	//Indicaciones y Tratamientos
	if ($IndicacionesHCT=="1") {
?>
function ClickTabla<?php echo $NumWindow; ?>(e) {
  tecla = (document.all) ? e.keyCode : e.which;
  if (tecla==13){
	AgregarFilaTto<?php echo $NumWindow; ?>(document.getElementById('txt_indicaciones<?php echo $NumWindow; ?>').value);
  }
}
function EliminarFilaTto<?php echo $NumWindow; ?>(Numero) { 
    var miTabla = document.getElementById("tblDetalle<?php echo $NumWindow; ?>");     
    $('#tr'+Numero+"<?php echo $NumWindow; ?>").remove();
}  

function AgregarFilaTto<?php echo $NumWindow; ?>(Indicacion)  {
	if (Indicacion!="") {	
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
}

<?php 
	}
?>

function normalizar<?php echo $NumWindow; ?>(TheClass) {
	var clasesNRML = document.getElementsByClassName("Nrml"+TheClass);
	for (var i=0; i < clasesNRML.length; i++){
		if (document.getElementById(clasesNRML[i].id).value == "") {
			clasesNRML[i].value=document.getElementById('hdn_nrml'+clasesNRML[i].id).value;
		}
	}
}

function chekear<?php echo $NumWindow; ?>(checqbox) {
	tmpchk=document.getElementById("hdn_"+checqbox+"<?php echo $NumWindow; ?>").value;
	if (tmpchk=='1') {
		document.getElementById("hdn_"+checqbox+"<?php echo $NumWindow; ?>").value='0';
	} else {
		document.getElementById("hdn_"+checqbox+"<?php echo $NumWindow; ?>").value='1';
	}
}

function HCResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/hc.php', '<?php echo $NumWindow; ?>', '&ModeHC=<?php echo $ModeHC;?>');	
}

function addImage<?php echo $NumWindow; ?>(e, imgcontrol){
	var file = e.target.files[0],
	imageType = /image.*/;

	if (!file.type.match(imageType))
	return;

	var reader = new FileReader();
	reader.onload = fileOnload<?php echo $NumWindow; ?>(e, imgcontrol);
	reader.readAsDataURL(file);
}

function fileOnload(e, imgcontrol) {
	var result=e.target.result;
	$('#'+imgcontrol).attr("src",result);
}

<?php 
if ($OdontogramaHCT=="1"){
?>

<?php
}
if ($GlasgowHCT!="0") {
?>
function CalcGlasgow<?php echo $NumWindow; ?>() {
	Val1=document.getElementById("cmb_glasgow1<?php echo $NumWindow; ?>").value;
	Val2=document.getElementById("cmb_glasgow2<?php echo $NumWindow; ?>").value;
	Val3=document.getElementById("cmb_glasgow3<?php echo $NumWindow; ?>").value;
	Num1=parseInt(Val1.charAt(Val1.length-1));
	Num2=parseInt(Val2.charAt(Val2.length-1));
	Num3=parseInt(Val3.charAt(Val3.length-1));
	Total=Num1+Num2+Num3;
	document.getElementById("glasgow<?php echo $NumWindow; ?>").innerHTML=String(Total)+'/15';
}
<?php
}
?>
function ReLoadHlpDx<?php echo $NumWindow; ?>(Filah){
	$('#trhlpdxH'+Filah+'<?php echo $NumWindow; ?>').css("opacity",".5");
	CSER=document.getElementById("hdn_exam_CSER"+Filah+"<?php echo $NumWindow; ?>").value;
	CHCS=document.getElementById("hdn_exam_CHCS"+Filah+"<?php echo $NumWindow; ?>").value;
	OHCS=document.getElementById("hdn_exam_OHCS"+Filah+"<?php echo $NumWindow; ?>").value;
	NSER=document.getElementById("hdn_exam_NSER"+Filah+"<?php echo $NumWindow; ?>").value;
	TotalFilas=document.getElementById("hdn_controwhlpdx<?php echo $NumWindow; ?>").value;
    var miTabla = document.getElementById("tbhlpdx<?php echo $NumWindow; ?>"); 
    var fila = document.createElement("tr"); 
    var celda0 = document.createElement("td"); 
    var celda1 = document.createElement("td"); 
    var celda2 = document.createElement("td"); 
    var celda3 = document.createElement("td"); 
    var celda4 = document.createElement("td"); 
    TotalFilas++;
	fila.id="trhlpdx"+TotalFilas+"<?php echo $NumWindow; ?>";
	CodHlpDx=CSER;
	ServicioDx=NSER;
	CantHlpDx=CHCS;
	ObsHlpDx=OHCS;
	celda0.innerHTML = '<input name="hdn_codhlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codhlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodHlpDx+''+'" /> '+CodHlpDx; 
	celda1.innerHTML = ' '+ServicioDx; 
	celda2.innerHTML = '<input name="hdn_canthlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_canthlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantHlpDx+'" /> '+CantHlpDx; 
	celda3.innerHTML = '<input name="hdn_obshlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_obshlpdx'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ObsHlpDx+''+'" /> '+ObsHlpDx; 
	celda4.innerHTML = '<button onclick="EliminarFilaHlpDx<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
	fila.appendChild(celda0); 
    fila.appendChild(celda1); 
    fila.appendChild(celda2); 
    fila.appendChild(celda3); 
    fila.appendChild(celda4); 
    miTabla.appendChild(fila); 
	document.getElementById("hdn_controwhlpdx<?php echo $NumWindow; ?>").value=TotalFilas;
	document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').value="";
	document.getElementById('txt_codserdx<?php echo $NumWindow; ?>').focus();
	$('#trhlpdxH'+Filah+'<?php echo $NumWindow; ?>').css("opacity","");

}
function ReLoadForMed<?php echo $NumWindow; ?>(Filah){
	$('#trfmed'+Filah+'<?php echo $NumWindow; ?>').css("opacity",".5");
	CSER=document.getElementById("hdn_fmed_CSER"+Filah+"<?php echo $NumWindow; ?>").value;
	NMED=document.getElementById("hdn_fmed_NMED"+Filah+"<?php echo $NumWindow; ?>").value;
	DoHCM=document.getElementById("hdn_fmed_DoHCM"+Filah+"<?php echo $NumWindow; ?>").value;
	VHCM=document.getElementById("hdn_fmed_VHCM"+Filah+"<?php echo $NumWindow; ?>").value;
	FHCM=document.getElementById("hdn_fmed_FHCM"+Filah+"<?php echo $NumWindow; ?>").value;
	DuHCM=document.getElementById("hdn_fmed_DuHCM"+Filah+"<?php echo $NumWindow; ?>").value;
	CHCM=document.getElementById("hdn_fmed_CHCM"+Filah+"<?php echo $NumWindow; ?>").value;
	OHCM=document.getElementById("hdn_fmed_OHCM"+Filah+"<?php echo $NumWindow; ?>").value;
	TotalFilas=document.getElementById("hdn_controwMed<?php echo $NumWindow; ?>").value;
	    var miTabla = document.getElementById("tbMedX<?php echo $NumWindow; ?>"); 
	    var fila = document.createElement("tr"); 
	    var celda2 = document.createElement("td"); 
	    var celda3 = document.createElement("td"); 
	    var celda4 = document.createElement("td"); 
	    var celda5 = document.createElement("td"); 
	    var celda6 = document.createElement("td"); 
	    var celda9 = document.createElement("td"); 
	    var celda7 = document.createElement("td"); 
	    var celda8 = document.createElement("td"); 
	    TotalFilas++;
		fila.id="trmed"+TotalFilas+"<?php echo $NumWindow; ?>";
		CodMed=CSER;
		Medicamento=NMED;
		Dosis=DoHCM;
		Via=VHCM;
		document.getElementById('cmb_via<?php echo $NumWindow; ?>').value=VHCM;
		Via2=document.getElementById('cmb_via<?php echo $NumWindow; ?>').options[document.getElementById('cmb_via<?php echo $NumWindow; ?>').selectedIndex].text;
		Frec=FHCM;
		document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').value=FHCM;
		Frec2=document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').options[document.getElementById('cmb_frecuencia<?php echo $NumWindow; ?>').selectedIndex].text;
		Durac=DuHCM;
		document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value=DuHCM;
	    Durac2=document.getElementById('txt_duracion<?php echo $NumWindow; ?>').value+ ' '+document.getElementById('cmb_tiempo<?php echo $NumWindow; ?>').options[document.getElementById('cmb_tiempo<?php echo $NumWindow; ?>').selectedIndex].text;
	    CantMed=CHCM;
		ObsMed=OHCM;
		celda2.innerHTML = '<input name="hdn_codmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_codmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CodMed+''+'" /> '+Medicamento; 
		celda3.innerHTML = '<input name="hdn_dosis'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_dosis'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Dosis+''+'" /> '+Dosis; 
		celda4.innerHTML = '<input name="hdn_via'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_via'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Via+''+'" /> '+Via2; 
		celda5.innerHTML = '<input name="hdn_frecuencia'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_frecuencia'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Frec+''+'" /> '+Frec2; 
		celda6.innerHTML = '<input name="hdn_duracion'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_duracion'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+Durac+''+'" /> '+Durac; 
		celda9.innerHTML = '<input name="hdn_cantmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_cantmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+CantMed+'" /> '+CantMed; 
		celda7.innerHTML = '<input name="hdn_obsmed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_obsmed'+TotalFilas+'<?php echo $NumWindow; ?>" value="'+ObsMed+''+'" /> '+ObsMed; 
		celda8.innerHTML = '<input name="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" type="hidden" id="hdn_estadomed'+TotalFilas+'<?php echo $NumWindow; ?>" value="O" /><button onclick="EliminarFilaMed<?php echo $NumWindow; ?>(\''+TotalFilas+'\');" type="button" class="btn btn-danger btn-xs btn-block"> <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"></span> </button>'; 
	    fila.appendChild(celda2); 
	    fila.appendChild(celda3); 
	    fila.appendChild(celda4); 
	    fila.appendChild(celda5); 
	    fila.appendChild(celda6); 
	    fila.appendChild(celda9); 
	    fila.appendChild(celda7); 
	    fila.appendChild(celda8); 
	    miTabla.appendChild(fila); 
		document.getElementById("hdn_controwMed<?php echo $NumWindow; ?>").value=TotalFilas;
		document.getElementById('txt_codmed<?php echo $NumWindow; ?>').value="";
		document.getElementById('txt_codmed<?php echo $NumWindow; ?>').focus();
		$('#trfmed'+Filah+'<?php echo $NumWindow; ?>').css("opacity","");
}
function ReLoadTtmo<?php echo $NumWindow; ?>(Filah){

}

function LoadPcte<?php echo $NumWindow; ?>() {
	IdPte=document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value;
	CargarWind('Pacientes ', 'forms/pacientes.php?IdPte='+IdPte+'&mode=modal&wnd=hc', '1.PatientMale.png', 'hc.php','<?php echo $NumWindow; ?>' );
}

function Selhc<?php echo $NumWindow; ?>() {
	TheArea=document.getElementById('cmb_area<?php echo $NumWindow; ?>').value;
	CargarWind('Tipos HC', 'forms/hctiposhc.php?ModeHC=<?php echo $ModeHC; ?>&Historia=<?php echo $Hystory; ?>&Area='+TheArea+'&Cita=<?php echo $Cita; ?>&Window=<?php echo $NumWindow; ?>&SexoPcte=<?php echo $SexoPcte; ?>', 'GenomaX.png', 'hc.php','<?php echo $NumWindow; ?>' );
}
<?php
if (isset($_GET["FormatoHC"])) {
	if ($DxHCT=="1") {
		$SQL="SELECT b.Codigo_HCF, a.Codigo_DGN, a.CodigoR_DGN, a.CodigoR2_DGN, a.CodigoR3_DGN, a.Tipo_DGN, a.Manejo_DGN FROM hcdiagnosticos a, hcfolios b, czterceros c WHERE a.Codigo_TER=b.Codigo_TER AND a.Codigo_HCF=b.Codigo_HCF AND c.Codigo_TER=a.Codigo_TER AND a.Codigo_DGN<>'' AND c.ID_TER='".$Hystory."' ORDER BY 1 DESC ";
		$result = mysqli_query($conexion, $SQL);
		while ($row = mysqli_fetch_array($result)) {
			echo "document.frm_form".$NumWindow.".txt_dxppal".$NumWindow.".value='".$row[1]."';
			document.frm_form".$NumWindow.".txt_dxrel1".$NumWindow.".value='".$row[2]."';
			document.frm_form".$NumWindow.".txt_dxrel2".$NumWindow.".value='".$row[3]."';
			document.frm_form".$NumWindow.".txt_dxrel3".$NumWindow.".value='".$row[4]."';
			document.frm_form".$NumWindow.".cmb_tipodx".$NumWindow.".value='".$row[5]."';
			$(\"#txt_hora".$NumWindow."\").focus();";
		}
		mysqli_free_result($result); 
	}
}
?>
	HoraActual("txt_hora<?php echo $NumWindow; ?>");
<?php
if ($FormatHCYes==1) {
	if ($_GET["FormatoHC"]=="FORMMEDICA") {
		echo '$(\'a[href="#hc_medicamentos'.$NumWindow.'"]\').tab(\'show\');
		$(\'a[href="#tbfmed2'.$NumWindow.'"]\').tab(\'show\');
		';
	}

}
?>

    $("input[type=text]").addClass("input-sm form-control");
    $("input[type=date]").addClass("input-sm form-control");
	$("input[type=number]").addClass("input-sm form-control");
	$("input[type=time]").addClass("input-sm form-control");
    
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("input-sm form-control");

</script>
<script src="functions/nexus/hc.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
