<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">
 
    <div class="col-lg-8">
       <label for="txt_pcmuestra"<?php echo $NumWindow; ?>>Parametros de Cultivos Y muestras</label>
	</div>

    <div class="row well well-sm ">
		<div class="container"> 
            <label for="txt_muetras"<?php echo $NumWindow; ?> class="label label-success ">MUESTRAS</label>
			<div class="row well well-sm">
				<div class="col-md-12">
				<div id="zero_tblmuestras" class="detalleord"><span id="muestras<?php echo $NumWindow; ?>">
		            <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table tblexamenes" id="tblexamenes">
				        <tbody id="tbmuestras">
					       <tr id="trhmuestras"></tr>
						</tbody>
					</table>
                </div>
				</div>
			</div>	
			<label for="txt_microorganismo<?php echo $NumWindow; ?>" class="label label-success "><span class="">MICROORGANISMO</span></label>
			<div class="row well well-sm">
				<div class="col-md-7">
				<div id="zero_tblmicroorganismo" class="detalleord"><span id="microorganismo<?php echo $NumWindow; ?>">
		            <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table tblexamenes" id="tblexamenes">
				        <tbody id="tbmicroorganismo">
					       <tr id="trhmicroorganismo"></tr>
						</tbody>
					</table>
                </div>
				</div>
				<div class="col-md-5">
				<div id="zero_tblmicroorganismo2" class="detalleord"><span id="microorganismo2<?php echo $NumWindow; ?>">
		            <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table tblexamenes" id="tblexamenes">
				        <tbody id="tbmicroorganismo2">
					       <tr id="trhmicroorganismo2"></tr>
						</tbody>
					</table>
                </div>
				</div>                 
		   </div>
			
			<label for="txt_antibiograma<?php echo $NumWindow; ?>" class="label label-success "><span class="">ANTIBIOGRAMA</span></label>
			<div class="row well well-sm">
				<div class="col-md-5">
				<div id="zero_tblantibiograma" class="detalleord"><span id="antibiograma">
		            <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table tblexamenes" id="tblexamenes">
				        <tbody id="tbantibiograma">
					       <tr id="trhantibiograma"></tr>
						</tbody>
					</table>
                </div>
				</div>
				<div class="col-md-7">
				<div id="zero_tblantibiograma2" class="detalleord"><span id="antibiograma2<?php echo $NumWindow; ?>">
		            <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table tblexamenes" id="tblexamenes">
				        <tbody id="tbantibiograma">
					       <tr id="trantibiograma"></tr>
						</tbody>
					</table>
                </div>
				</div>                 
		   </div>
	</div>
</form>

<script>

$("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    

	$("input[type=text]").addClass("nxs_<?php echo $NumWindow; ?>");
    $("textarea").addClass("nxs_<?php echo $NumWindow; ?>");
	$("select").addClass("nxs_<?php echo $NumWindow; ?>");

</script>