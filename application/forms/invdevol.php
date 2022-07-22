<?php
	
session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form0<?php echo $NumWindow; ?>" class="form-horizontal container" id="frm_form0<?php echo $NumWindow; ?>">
        <!-- Buscador-->
        <div class="col-md-12" bis_skin_checked="1">
            <div class="row">
                <div class="col-md-2 col-sm-6" bis_skin_checked="1">
                    <div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>" bis_skin_checked="1">
                        <label for="txt_idhc<?php echo $NumWindow; ?>">Ingreso</label>
                        <div class="input-group" bis_skin_checked="1">	
                            <input style="font-size:15px;" name="txt_idhc<?php echo $NumWindow; ?>" id="txt_idhc<?php echo $NumWindow; ?>" type="text" required="" onkeypress="BuscarHCPte<?php echo $NumWindow; ?>(event);" onblur="HCPteOnBlur<?php echo $NumWindow; ?>()" class="hcx_<?php echo $NumWindow; ?> input-sm form-control">
                            <span class="input-group-btn">	
                                <button class="btn btn-success hcx_<?php echo $NumWindow; ?>" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('Ingreso', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-8" bis_skin_checked="1">
                    <div class="form-group" bis_skin_checked="1">
                        <label for="txt_pacientezWind_2">Nombre</label>
                        <input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_pacientezWind_2" id="txt_pacientezWind_2" type="text" disabled="disabled" class="lead hcx_zWind_2 input-sm form-control">
                    </div>
                </div>
            </div>

        </div>
        <!--Informacion del Paciente-->
        <div class="col-md-12 alert alert-warning "  bis_skin_checked="1">
            <div class="row">
                <div class="col-md-12 col-sm-12 label label-danger hidden" id="div_alertas" bis_skin_checked="1">
                    ...
                </div>
                <input name="hdn_autorizacionzWind_2" type="hidden" id="hdn_autorizacionzWind_2" value="" class="hcx_zWind_2">
                <div class="col-md-5 col-sm-5" bis_skin_checked="1">
                    <label>Contrato: </label> <span id="spn_contratozWind_2">Sin datos</span>
                    <input name="hdn_contratozWind_2" type="hidden" id="hdn_contratozWind_2" value="" class="hcx_zWind_2">
                </div>
                <div class="col-md-5 col-sm-5" bis_skin_checked="1">
                    <label>Plan: </label> <span id="spn_planzWind_2">Sin datos</span>
                    <input name="hdn_planzWind_2" type="hidden" id="hdn_planzWind_2" value="" class="hcx_zWind_2">
                </div>
                <div class="col-md-2 col-sm-2" bis_skin_checked="1">
                    <label>Rango: </label> <span id="spn_rangozWind_2">--</span>
                </div>
                <div class="col-md-3 col-sm-3" bis_skin_checked="1">
                    <label>Fec Nacimiento: </label> <small><span id="spn_fechanaczWind_2">00/00/0000</span></small>
                </div>
                <div class="col-md-4 col-sm-4" bis_skin_checked="1">
                    <label>Edad: </label> <small><span id="spn_edadzWind_2">00 Años</span></small>
                </div>
                <div class="col-md-2 col-sm-2" bis_skin_checked="1">
                    <label>Sexo: </label> <small><span id="spn_sexozWind_2">-</span></small>
                </div>
                <div class="col-md-3 col-sm-3" bis_skin_checked="1">
                    <label>Est. Civil: </label> <small><span id="spn_estcivilzWind_2">Sin datos</span></small>
                </div>
                <div class="col-md-4 col-sm-4" bis_skin_checked="1">
                    <label>Dirección: </label> <small><span id="spn_direccionzWind_2">Sin datos</span></small>
                </div>
                <div class="col-md-2 col-sm-2" bis_skin_checked="1">
                    <label>Teléfono: </label> <small><span id="spn_telefonozWind_2">Sin datos</span></small>
                </div>
                <div class="col-md-3 col-sm-3" bis_skin_checked="1">
                    <label>Correo: </label> <small><span id="spn_correoelzWind_2">Sin datos</span></small>
                </div>
                <div class="col-md-3 col-sm-3" bis_skin_checked="1">
                    <label>Ocupación: </label> <small><span id="spn_ocupacionzWind_2">Sin datos</span></small>
                </div>
                <div class="col-md-5 col-sm-5" bis_skin_checked="1">
                    <label>Acompañante: </label> <small><span id="spn_acompzWind_2">Sin datos</span></small>
                </div>
                <div class="col-md-3 col-sm-3" bis_skin_checked="1">
                    <label>Teléfono: </label> <small><span id="spn_telacompzWind_2">Sin datos</span></small>
                </div>
                <div class="col-md-4 col-sm-4" bis_skin_checked="1">
                    <label>Parentesco: </label> <small><span id="spn_parentescozWind_2">Sin datos</span></small>
                </div>
                <div class="col-md-4 col-sm-4" bis_skin_checked="1">
                    <label>Ingreso Por: </label> <small><span id="spn_ingporzWind_2">Sin datos</span></small>
                </div>
                <div class="col-md-4 col-sm-4" bis_skin_checked="1">
                    <label>Observaciones: </label> <small><span id="spn_obszWind_2">Sin datos</span></small>
                </div>
                <div class="col-md-4 col-sm-4" bis_skin_checked="1">
                    <label>Fecha Ingreso: </label> <span id="spn_fechaingzWind_2" class="badge">00/00/0000</span>
                </div>
                <div class="col-md-4 col-sm-4" bis_skin_checked="1">
                    <label>Tipo Paciente: </label> <span id="spn_tipoptezWind_2">Sin datos</span>
                </div>
                
                
                
            </div>

        </div>
        <!--Detalle-->
        <div class="col-md-12" style="margin-bottom: 15px;" bis_skin_checked="1">
            <label for="txt_iddetalle">Detalle</label>
            <textarea placeholder="Detalle de Devolucion" name="txt_cajadetalle" id="txt_cajadetalle" class="hcx_zWind_2 form-control" style="width: 100%; height: 85px;"> </textarea>
        </div>
        <!--Tabla de Suministros-->
        <div class="col-md-12" bis_skin_checked="1">
            <div id="zero_tbdevoluciones" class="de table-responsive alturahc" bis_skin_checked="1">
                <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetalleMedzWind_2">
                    <thead>
                        <tr>
                            <th>Suministro</th>
                            <th>F.Suministro</th>
                            <th>Almacen</th>
                            <th>Producto</th>
                            <th>C.Despachada</th>
                            <th>C.Devolucion</th>
                            <th>C.Administrada</th>
                        </tr>
                    </thead>
                    <tbody id="tbdevoinv_1">
                        <tr>
                            <td>BQ20220620</td>
                            <td>22/06/2022</td>
                            <td>General</td>
                            <td>Amoxicilina/ácido clavulánico</td>
                            <td><input id="cantdesp" type="number" value="10" disabled="disabled"></td>
                            <td><input id="cantdev" type="number" onmouseup="restar(fila);"></td>
                            <td><input id="cantAdm" type="number" disabled="disabled"></td>
                        </tr>
                    </tbody> 
                </table>
                <input name="hdn_controwMedzWind_2" type="hidden" id="hdn_controwMedzWind_2" value="0" class="hcx_zWind_2">
            </div>
        </div>  

    </form>
<script >

$(":input:text:visible:first", "#frm_form0<?php echo $NumWindow; ?>").focus();

let numdev = document.getElementById("cantdev");
    let text = 0;
    function restar(fila) {
        
    }
    numdev.addEventListener("mouseup", (event)=>{
        console.log("jhola");
        let CDV =  parseInt(event.path[0].value);
        let CDP = document.getElementById("cantdesp").value;
        if(CDV === ""){
            text = 0;
        }else if(CDV <= CDP){
            text = CDP - CDV
        }else{
            text = 0;
        };
        document.getElementById("cantAdm").value = text;
    });

    $("input[type=text]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=date]").addClass("form-control");
	$("input[type=number]").addClass("form-control");
	$("input[type=time]").addClass("form-control");
    

</script>