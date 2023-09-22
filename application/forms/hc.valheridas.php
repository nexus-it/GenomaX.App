<div role="tabpanel" class="tab-pane fade " id="hc_valheridas<?php echo $NumWindow; ?>">
	<div class="row">
	<input type="hidden" name="hdn_valher<?php echo $NumWindow; ?>" id="hdn_valher<?php echo $NumWindow; ?>" value="">
		<div id="divvalher<?php echo $NumWindow; ?>" class="col-md-12">
			<label class="label label-success"> Valoración de Heridas</label>
			<div class="btn-group pull-right">
			  <button type="button" class="btn btn-warning btn-xs dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-time" aria-hidden="true"></span> Histórico <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu" style="background-color: #fffced;">
			  	<li><a href="javascript:actualOdonto('<?php echo $NumWindow; ?>');"><strong>Tratamiento Actual</strong></a></li>
			  <?php 
			    $SQL="Select Estados_ODG, Fecha_HCF, Nota_ODG From hcodontograma a, hcfolios b, czterceros c Where a.Codigo_TER=b.Codigo_TER and a.Codigo_HCF=b.Codigo_HCF and c.Codigo_TER=b.Codigo_TER and ID_TER='".$Hystory."';";
			    //error_log($SQL);
			    $resultodt = mysqli_query($conexion, $SQL);
			    while($rowodt = mysqli_fetch_array($resultodt)) {
			  ?>
			    <li><a href="javascript:paintOdonto('<?php echo $rowodt[0]; ?>', '<?php echo $rowodt[1]; ?>', '<?php echo $NumWindow; ?>');" title="<?php echo $rowodt[2]; ?>"><strong><?php echo $rowodt[1]; ?></strong> <?php echo $rowodt[2]; ?></a></li>
			  <?php
				}
				mysqli_free_result($resultodt);
			  ?>
			  </ul>
			</div>
			<div class="row well well-sm">
				<div id="seccionImg" class="displayInlineBlockTop col-md-12 " style="padding: 10px; height: 500px; border-style: double; text-align: center; background-image: url(<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/valher/posanatombas<?php echo $SexoPcte; ?>.jpg); background-repeat: no-repeat; background-position: center;background-color: white;">
                    <div class="vlgrid">
                        <?php
                        for ($i = 1; $i <= 47; $i++) {
                            for ($j = 1; $j <= 66; $j++) {
                        ?>
                        <div id="<?php echo 'dv'.$j.'-'.$i.$NumWindow; ?>" class="vhcell0" onclick="paintVH<?php echo $NumWindow; ?>('<?php echo $j; ?>', '<?php echo $i; ?>');" ></div>
                        <?php
                            }
                        }
                        ?>
                    </div>
				</div>
				
			</div>
		</div> 

	</div>
</div>
<script>
	/* cargarTratamientos("seccionTablaTratamientos", "verodontograma.php", $('#txtCodigoPaciente').val());
	cargarDientes("seccionDientes", "dientes.php", '', $('#txtCodigoPaciente').val()); */
    function paintVH<?php echo $NumWindow; ?>(varj, vari) {
        var varval = !!document.getElementById('hdn_VH'+varj+'-'+vari+'<?php echo $NumWindow; ?>');
        var element =document.getElementById('dv'+varj+'-'+vari+'<?php echo $NumWindow; ?>');
        if (varval!=true) {
            varvalold="0";
            varvalnew="1";
            var li0 = $(document.createElement('input')).attr('type','hidden').appendTo('#dv'+varj+'-'+vari+'<?php echo $NumWindow; ?>');
	        $(li0).attr('id','hdn_VH'+varj+'-'+vari+'<?php echo $NumWindow; ?>');
            $(li0).attr('name','hdn_VH'+varj+'-'+vari+'<?php echo $NumWindow; ?>');
            $(li0).attr('value','1');
	    } else {
            varvalold="1";
            varvalnew="0";
            element.innerHTML='';
        }
        element.classList.remove("vhcell"+varvalold);
        element.classList.add("vhcell"+varvalnew);
    }
</script> 
<script src="functions/nexus/hc.valheridas.js?v=<?php echo $_SESSION["VERSION_CONTROL"].'.'.uniqid(); ?>"></script>