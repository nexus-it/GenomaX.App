<?php
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");
	$Mode="";
	$EstadoEXA="";
	if (isset($_GET["Mode"])) {
		$Mode=$_GET["Mode"];
	}
	$ventana=substr($NumWindow, (strpos($NumWindow,'_')+1) - strlen($NumWindow));
?>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal">

    <div class="row">
    	<div class="col-md-2">
	        <div class="input-group">
			  <span class="input-group-addon" id="addordenno">Orden No.</span>
			  <input type="text" class="form-control" aria-describedby="addordenno" name="txt_ordenno<?php echo $NumWindow; ?>" id="txt_ordenno<?php echo $NumWindow; ?>">
			</div>
		</div>
		<div class="col-md-2">
			<div class="input-group">
			  <span class="input-group-addon" id="addorigen">Origen</span>
            <select  class="form-control" name="cmb_origen<?php echo $NumWindow; ?>" id="cmb_origen<?php echo $NumWindow; ?>" aria-describedby="addorigen">
		        <option value="0">Institucional</option>
		        <option value="X">Venta Directa</option>
	        </select>
	    	</div>
        </div>
        <div class="col-md-6">
	        <div class="input-group">
			  <span class="input-group-addon" id="addordena">Ordena</span>
			  <input type="text" class="form-control" aria-describedby="addordena" name="txt_ordena<?php echo $NumWindow; ?>" id="txt_ordena<?php echo $NumWindow; ?>">
			</div>
		</div>
		<div class="col-md-2">
	        <div class="input-group">
			  <span class="input-group-addon" id="addordenfec">Fecha</span>
			  <input type="text" class="form-control" aria-describedby="addordenfec" name="txt_ordenfec<?php echo $NumWindow; ?>" id="txt_ordenfec<?php echo $NumWindow; ?>">
			</div>
		</div>
       </div>
       <?php 
       	if ($Mode!="hc") {
       ?>
       <div class="row well well-sm">
        			    <div class="col-md-9">
						    <label class="" for="txt_paciente<?php echo $NumWindow; ?>">Paciente</label>
                            <div class="input-group">
                                <input type="text" class="form-control"  name="" placeholder=""disabled>
                                <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="fas fa-search"></i></button>
								</span>
								<input class="form-control" type="text" name="" id=" <?php echo $NumWindow; ?>"disabled>
                            </div>
					    </div>
						<div class="col-md-1">
						    <label class="" for="txt_edad<?php echo $NumWindow; ?>">Edad</label>
						    <input class="form-control" type="text" name="" id=""disabled>
					    </div>
					</div>
				</div>
				<div class="row ">
					<div class="container">
                        <div class="col-md-3">
						    <label for="txt_ingreso<?php echo $NumWindow; ?>">Ingreso</label>
						    <input class="form-control" type="text" name="" id="ingreso<?php echo $NumWindow; ?>"disabled>
						</div>
						<div class="col-md-4">
						    <label for="txt_fec_ing<?php echo $NumWindow; ?>">Fec.ing</label>
						    <input class="form-control" type="text" name="" id="fec_ing<?php echo $NumWindow; ?>"disabled>
						</div>
						<div class="col-md-5">
						    <label for="txt_area<?php echo $NumWindow; ?>">Area</label>
						    <input class="form-control" type="text" name="" id="area<?php echo $NumWindow; ?>"disabled>
					    </div>
					</div>
				</div>
				<div class="row ">
					<div class="container">
                        <div class="col-md-5">
						    <label for="txt_entidad<?php echo $NumWindow; ?>">Entidad</label>
						    <input class="form-control" type="text" name="" id="entidad<?php echo $NumWindow; ?>"disabled>
						</div>
						<div class="col-md-5">
						    <label for="txt_institucion<?php echo $NumWindow; ?>">Institucion</label>
						    <input class="form-control" type="text" name="" id="institucion<?php echo $NumWindow; ?>">
						</div>
					</div>
                </div>
			</div>
			<div class="row well well-sm ">
					<div class="container">
                        <div class="col-md-6">
						    <label  class=""for="txt_servicio<?php echo $NumWindow; ?>">Servicio</label>
							<div class="input-group">
							    <span class="input-group-btn">
                                    <button class="btn btn-default" type="button"><i class="fas fa-search"></i></button>
                                </span>
						        <select class="form-control" name="" id="servicio<?php echo $NumWindow; ?>">
								    <option value=""></option>
								    <option value=""></option>
								    <option value=""></option>
								    <option value=""></option>
							    </select>
                            </div>
						</div>
						<div class="col-md-2">
						    <label class="" for="txt_cantidad<?php echo $NumWindow; ?>">Cantidad</label>
						    <input class="form-control" type="number" name="" id="cantidad<?php echo $NumWindow; ?>">
						</div>
						<div class="col-md-1">
						<div class="col-md-1 "><label for="">.</label></div>
						    <button class="btn btn-success" type="submit"><i class="fas fa-plus"></i></button>
					    </div>
					</div>
			</div>
	   <?php 
       	}
       ?>
			<div class="row well well-sm">
				<div class="col-md-12">
				  	<div id="zero_detallehlpdx<?php echo $NumWindow; ?>" class=" table-responsive" style="height: 64%">
						<table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table  table-condensed tblDetalle table-bordered" id="tblDetallehlpdx<?php echo $NumWindow; ?>" <?php if ($Mode=="hc"){ echo 'style="width: 80%;"'; } ?>>
						<tbody id="tbh1lpdx<?php echo $NumWindow; ?>">
						<tr id="trhhlpdxX<?php echo $NumWindow; ?>"> 
							<th id="th1hlp1dxX<?php echo $NumWindow; ?>" colspan="2">Examen</th> 
							<th id="th2hlp1dxX<?php echo $NumWindow; ?>" colspan="2">Resultado</th> 
							<th id="th3hlp1dxX<?php echo $NumWindow; ?>">Referencia</th> 
							
						</tr> 
						<?php 
						$HistResults=0;
						if (isset($_GET["NumSol"])) {
							if (trim($_GET["NumSol"])!="") {
								$Kond="";
								if (isset($_GET["CodSER"])) {
									$Kond=" and a.Codigo_SER='".$_GET["CodSER"]."' ";
								}
								$SQL="SELECT b.CUPS_PRC, b.Nombre_PRC, a.Codigo_SER FROM hcordenesdx a, gxprocedimientos b WHERE a.Codigo_SER=b.Codigo_SER AND a.Codigo_HCS='".$_GET["NumSol"]."' ".$Kond." ORDER BY 1";
								$result = mysqli_query($conexion, $SQL);
								while($row = mysqli_fetch_array($result)) {
									$HistResults++;
								?>
						<tr id="trhlpdxH<?php echo $HistResults.$NumWindow; ?>"> 
							<td id="t0hlpdxH<?php echo $HistResults.$NumWindow; ?>" colspan="5"><?php echo '<strong><kbd>'.$row[0].'</kbd> - '.$row[1].'</strong>'; ?></td>  
						</tr>
								<?php
								$KontItems=0;
									$SQL="SELECT b.Nombre_ITL, a.Referencia_ITL, c.Sigla_UNL, a.Requerido_ITL, d.Estado_EXA, e.Resultados_EXA , d.Codigo_EXA,a.Codigo_ITL, d.Fecha_EXA  FROM lbitemslab b, lbunidades c, lbitemsref a LEFT  JOIN lbexamenes d ON a.Codigo_SER= d.Codigo_SER LEFT OUTER JOIN  lbexamitems e ON d.Codigo_EXA=e.Codigo_EXA AND a.Codigo_ITL=e.Codigo_ITL WHERE c.Codigo_UNL=a.Codigo_UNL and a.Codigo_ITL=b.Codigo_ITL and a.Codigo_SER='".$row[2]."' AND d.Codigo_SLB='".$_GET["NumSol"]."' ORDER BY a.Orden_ITL";
									//echo $SQL;
									$reslab = mysqli_query($conexion, $SQL);
									while($rlab = mysqli_fetch_array($reslab)) {
										$dishabl=" ";
										$CodEXA="";
										if ($rlab[4]=="1") {
											$dishabl=" disabled='disabled' ";
										}
										$CodEXA=$rlab[6];
										$EstadoEXA=$rlab[4];
										$FechaEXA=$rlab[8];
										$KontItems++;
									?>
						<tr id="trhlpdxH<?php echo $HistResults.$rlab[4].$NumWindow; ?>" style="background-color: white;"> 
							<td id="t1hlpdxH<?php echo $HistResults.$rlab[4].$NumWindow; ?>" align="right"> <input type="hidden" name="hdn_examen<?php echo $KontItems.$NumWindow; ?>" value="<?php echo $rlab[6]; ?>" id="hdn_examen<?php echo $KontItems.$NumWindow; ?>">
							</td>
							<td id="t2hlpdxH<?php echo $HistResults.$rlab[4].$NumWindow; ?>" >
								<?php echo $rlab[0]; ?><input type="hidden" name="hdn_examitem<?php echo $KontItems.$NumWindow; ?>" value="<?php echo $rlab[7]; ?>" id="hdn_examitem<?php echo $KontItems.$NumWindow; ?>">
							</td>
							<td id="t3hlpdxH<?php echo $HistResults.$rlab[4].$NumWindow; ?>" >
								<input type="text"  class="input-sm " style="border-style: none; background-color: transparent; padding: 0px; height: 24px;font-weight: bold; text-align: center; font-size: 16px;" value="<?php echo $rlab[5]; ?>" <?php echo $dishabl; ?> id="txt_result<?php echo $KontItems.$NumWindow; ?>" name="txt_result<?php echo $KontItems.$NumWindow; ?>">
							</td>
							<td id="t5hlpdxH<?php echo $HistResults.$rlab[4].$NumWindow; ?>" >
								<?php echo $rlab[2]; ?>
							</td>
							<td id="t4hlpdxH<?php echo $HistResults.$rlab[4].$NumWindow; ?>" >
								<?php echo $rlab[1]; ?>
							</td>
							
						</tr>
									<?php
									}
									mysqli_free_result($reslab); 
								}
								mysqli_free_result($result); 
							}
						}
						if ($HistResults==0) {
						?>
						<tr id="NoReshlpdx<?php echo $NumWindow; ?>"> 
							<td id="thhlpdxNO<?php echo $NumWindow; ?>" colspan="4" align="center"><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> NO EXISTEN SOLICITUDES DE EXAMENES ANTERIORES EN EL SISTEMA</td> 
						</tr> 
						<?php
						}
						?>
						</tbody>
						</table>
						<input type="hidden" name="hdn_contaItems<?php echo $NumWindow; ?>" id="hdn_contaItems<?php echo $NumWindow; ?>" value="<?php echo $KontItems; ?>">
					</div>
				</div>             
		   </div>
	   <?php 
       	if ($Mode=="hc") {
       ?>
       <div class="row">
       	<div class="col-md-12">
       		<?php if ($EstadoEXA=="0") { ?>
       	 <button class="btn btn-success btn-sm pull-right" type="button" onclick="Guardar_lbordenes('<?php echo $ventana; ?>');">Guardar</button>
       	 	<?php } else { ?>
       	<div class="col-md-3">
		 <div class="input-group">
       	  <span class="input-group-addon" id="addordenfec">Fecha Resultados</span>
		  <input type="text" class="form-control" aria-describedby="addordenfec" name="txt_fecexa<?php echo $NumWindow; ?>" id="txt_fecexa<?php echo $NumWindow; ?>" value="<?php echo $FechaEXA; ?>" disabled>
		 </div>
		</div>
       	 <button class="btn btn-success btn-sm pull-right" type="button">Imprimir</button>
       	 	<?php } ?>
       	</div>
       </div>
       <?php
	    }
	   ?>
	</div>
</form>

<script>
<?php
if (isset($_GET["NumSol"])) {
	echo "
		document.getElementById('txt_ordenno".$NumWindow."').value='".$_GET["NumSol"]."';
		document.getElementById('cmb_origen".$NumWindow."').value='0';";
	$SQL="SELECT c.Fecha_HCF, d.Nombre_TER FROM hcordenesdx a, hcfolios c, czterceros d, gxmedicos e, czterceros m WHERE c.Codigo_TER=a.Codigo_TER AND c.Codigo_HCF=a.Codigo_HCF AND e.Codigo_TER=d.Codigo_TER AND e.Codigo_USR=c.Codigo_USR AND a.Codigo_HCS='".$_GET["NumSol"]."' ORDER BY 1 DESC ";
	$result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
		echo "
			document.getElementById('txt_ordena".$NumWindow."').value='".$row[1]."';
			document.getElementById('txt_ordenfec".$NumWindow."').value='".$row[0]."';";
	}
	mysqli_free_result($result);
	if ($Mode=="hc") {
		echo "
			document.getElementById('txt_ordenno".$NumWindow."').disabled = true;
			document.getElementById('cmb_origen".$NumWindow."').disabled = true;
			document.getElementById('txt_ordenfec".$NumWindow."').disabled = true;
			document.getElementById('txt_ordena".$NumWindow."').disabled = true;";
	}
}
?>

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