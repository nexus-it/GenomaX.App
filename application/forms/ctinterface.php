<?php
	session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	

?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal" id="frm_form<?php echo $NumWindow; ?>" action="functions/php/nexus/uploads.php?route=images&class=terceros&style=profile&wind=<?php echo $NumWindow; ?>" enctype="multipart/form-data" target="upload_target" onreset="HCResetea<?php echo $NumWindow; ?>();">

<div class="row well well-sm">
	<div class="col-md-2 col-sm-2">
		<ul class="nav nav-pills nav-stacked">
		  <li role="presentation"><a href="#ct_facturacion<?php echo $NumWindow; ?>" data-toggle="pill"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> FACTURACION</a></li>
		  <li role="presentation"><a href="#ct_cartera<?php echo $NumWindow; ?>" data-toggle="pill"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> CARTERA</a></li>
		  <li role="presentation"><a href="#ct_inventario<?php echo $NumWindow; ?>" data-toggle="pill"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> INVENTARIO</a></li>
		  <li role="presentation"><a href="#ct_tesoreria<?php echo $NumWindow; ?>" data-toggle="pill"><span class="glyphicon glyphicon-search" aria-hidden="true"></span> TESORERÍA</a></li>
		
			
		</ul>
	</div>
	<div class="col-md-10 col-sm-10 tab-content">
  		<div role="tabpanel" class="tab-pane fade active in" id="ct_facturacion<?php echo $NumWindow; ?>">
	  		<div class="well well-sm">

	  		</div>
	  	</div>
	  	<div role="tabpanel" class="tab-pane fade" id="ct_cartera<?php echo $NumWindow; ?>">
	  		<div class="well well-sm">

	  		</div>
	  	</div>
	  	<div role="tabpanel" class="tab-pane fade" id="ct_inventario<?php echo $NumWindow; ?>">
	  		<div class="well well-sm">

	  		</div>
	  	</div>
	  	<div role="tabpanel" class="tab-pane fade" id="ct_tesoreria<?php echo $NumWindow; ?>">
	  		<div class="well well-sm">

	  		</div>
	  	</div>

 	</div>
</div>

</form>

<script >

    $("input[type=text]").addClass("input-sm form-control");
    $("input[type=date]").addClass("input-sm form-control");
	$("input[type=number]").addClass("input-sm form-control");
	$("input[type=time]").addClass("input-sm form-control");
    
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("input-sm form-control");

</script>
