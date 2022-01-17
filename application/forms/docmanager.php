<?php

session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
	$Vent = (int) filter_var($NumWindow, FILTER_SANITIZE_NUMBER_INT);  
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" >
    <div class="well well-sm row">
        <div class="progress" style="background: slategray;">
            <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="min-width: 2em; width: 60%;">
                60%
            </div>
        </div>
    </div>

    <div class="well well-sm row">
    
    <div class="col-md-2">
<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
    <label for="txt_idhc<?php echo $NumWindow; ?>">Paciente</label>
    <div class="input-group">	
        <input style="font-size:15px;" name="txt_idhc<?php echo $NumWindow; ?>" id="txt_idhc<?php echo $NumWindow; ?>" type="text" required onkeypress="BuscarHCPte<?php echo $NumWindow; ?>(event);" onblur="HCPteOnBlur<?php echo $NumWindow; ?>()" />
        <span class="input-group-btn">	
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('PacientesHC', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
        </span>
    </div>
    <input name="hdn_codigoter<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoter<?php echo $NumWindow; ?>" value="X" />
</div>
    </div>
    <div class="col-md-10">
<div class="form-group">
    <label for="txt_paciente<?php echo $NumWindow; ?>">Nombre</label>
    <div class="input-group">	
        <input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
        <span class="input-group-btn">	
            <button class="btn btn-success" type="button" data-toggle="collapse" href="#collapseNewDoc<?php echo $NumWindow; ?>" aria-expanded="false" aria-controls="collapseNewDoc<?php echo $NumWindow; ?>"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> Nuevo documento</button>
        </span>
    </div>
</div>
    </div>
    <div class="collapse col-md-12" id="collapseNewDoc<?php echo $NumWindow; ?>">
        <div class="row well well-sm">
    
    <div class="col-md-4">
<div class="form-group">
    <label for="cmb_category<?php echo $NumWindow; ?>">Categoría</label>
    <select name="cmb_category<?php echo $NumWindow; ?>" id="cmb_category<?php echo $NumWindow; ?>">
        <option value="0" selected="selected">Autorizaciones</option>
        <option value="1">Primer Trimestre</option>
        <option value="2">Segundo Trimestre</option>
        <option value="3">Tercer Trimestre</option>
    </select>
</div>
    </div>
    <div class="col-md-4">
<div class="form-group">
    <label for="txt_documento<?php echo $NumWindow; ?>">Archivo</label>
    <input  name="txt_documento<?php echo $NumWindow; ?>" id="txt_documento <?php echo $NumWindow; ?>" type="file" accept=".pdf" />
</div>
    </div>
    <div class="col-md-4">
<div class="form-group">
    <label for="txt_nombre<?php echo $NumWindow; ?>">Guardar como...</label>
    <div class="input-group">	
        <input style="font-size:14px; font-weight: bold; color:#0E5012; " name="txt_nombre<?php echo $NumWindow; ?>" id="txt_nombre<?php echo $NumWindow; ?>" type="text" />
        <span class="input-group-btn">	
            <button class="btn btn-success" type="button" href="saveFilepdf<?php echo $NumWindow; ?>();" ><span class="glyphicon glyphicon-save" aria-hidden="true"></span> </button>
        </span>
    </div>
</div>
    </div>
    
        </div>
    </div>
     
	</div>
	<div class="well well-sm row">
        <div class="col-md-3"></div>
        <div class="col-md-9"></div>

	</div>
	<?php
if (isset($_GET["genesis"])) {
?>
<button type="button" class="btn btn-success btn-xs btn-block" onclick="javascript:Anular_agendacitascncl('<?php echo $Vent; ?>'); eval( 'getCal<?php echo $_GET["genesis"]; ?>()' );">Guardar</button>
<?php
	}
?>
</form>

<script >
	
	var NumWin='<?php echo $NumWindow; ?>';
	NumWin=NumWin.substring(6, NumWin.length);
	document.getElementById('Nuevo'+NumWin).style.display  = 'none';
	document.getElementById('Imprimir'+NumWin).style.display  = 'none';
    document.getElementById('Guardar'+NumWin).style.display  = 'none';

    document.getElementById('Anular'+NumWin).innerHTML='<span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Cancelar Cita';
    
    $("input[type=text]").addClass("form-control");
    $("input[type=file]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
