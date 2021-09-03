
<div role="tabpanel" class="tab-pane fade " id="hc_antecedentes<?php echo $NumWindow; ?>">
	<div class="row">

		<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#tbantper<?php echo $NumWindow; ?>" aria-controls="tbantper<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Personales</a></li>
    <li role="presentation"><a href="#tbanttox<?php echo $NumWindow; ?>" aria-controls="tbanttox<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Toxicológicos</a></li>
    <li role="presentation"><a href="#tbantaler<?php echo $NumWindow; ?>" aria-controls="tbantaler<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Alérgicos</a></li>
    <li role="presentation"><a href="#tbantfam<?php echo $NumWindow; ?>" aria-controls="tbantfam<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Familiares</a></li>
<?php if($SexoPcte=="F") { ?>
	<li role="presentation"><a href="#tbangobst<?php echo $NumWindow; ?>" aria-controls="tbangobst<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Gineco-Obstétricos</a></li>
<?php } ?>
  </ul>
	  				
		  		<div id="divtantcdt<?php echo $NumWindow; ?>" class="col-md-12 tab-content">
		  			<div id="tbantper<?php echo $NumWindow; ?>" class="row tab-pane fade in active" role="tabpanel">
	  				<?php require 'hc.antpersonal.php'; ?>
	  				</div>
		  			<div id="tbanttox<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
					<?php require 'hc.anttoxicol.php'; ?>
	  				</div>
	  				<div id="tbantaler<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
					<?php require 'hc.antalergico.php'; ?>
	  				</div>
	  				<div id="tbantfam<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
					<?php require 'hc.antfamiliar.php'; ?>
	  				</div>
<?php if($SexoPcte=="F") { ?>
	  				<div id="tbangobst<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
					<?php require 'hc.antginecoobst.php'; ?>
	  				</div>
<?php } ?>
	  			</div>

	  		</div>
	  	</div>