<?php
	
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>


<script type="text/javascript">
    <?php

    if (isset($_GET["Ingreso"])) {

    $SQL="Select date(fecha_adm) AS fechaingreso, time(fecha_adm), LPAD(Codigo_ADM,10,'0'), b.ID_TER, b.Nombre_TER,  Nombre_PLA, Nombre_CAM, Cuota_MOD, Porcentaje_COP, Maximo_COP, MaxAnual, Copago_ADM, Cuota_ADM, c.Codigo_EPS, d.Codigo_PLA, k.Codigo_AFC, a.Codigo_PTT, Reingreso_PTT, Nombre_PTT, i.FechaNac_PAC,round(DATEDIFF(CURDATE(),i.FechaNac_PAC)/365) as edad, i.Codigo_SEX, i.EstCivil_PAC , b.Direccion_TER, b.Telefono_TER, b.Correo_TER from gxpacientestipos z, czterceros b, gxeps c, gxplanes d, czterceros e, gxrangoactual h, gxpacientes i, czsedes k, gxadmision  a left join gxcamas f on a.Codigo_CAM=f.Codigo_CAM where  k.Codigo_SDE=a.Codigo_SDE and a.Codigo_TER=b.Codigo_TER and z.Codigo_PTT=a.Codigo_PTT and c.Codigo_TER=e.Codigo_TER and c.Codigo_EPS=a.Codigo_EPS and d.Codigo_PLA=a.Codigo_PLA and i.Codigo_TER=a.Codigo_TER and h.Codigo_ANY=DATE_FORMAT(curdate(), '%Y') and h.Codigo_RNG=i.Codigo_RNG and LPAD(Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0')  Limit 1"; //and Estado_ADM='I'
    $result = mysqli_query($conexion, $SQL);
    
    if($row = mysqli_fetch_array($result)) {
       
        
        echo "
                document.frm_form".$NumWindow.".txt_idhc".$NumWindow.".value='".$_GET["Ingreso"]."';
                document.frm_form".$NumWindow.".txt_paciente".$NumWindow.".value='".$row[4]."';
                
        ";
                $contrato = $row[13];
                $plan = $row['Nombre_PLA'];
                $fechanacimiento = $row['FechaNac_PAC']; 
                $edad = $row['edad'];
                $sexo = $row['Codigo_SEX'];
                $estcivil = $row['EstCivil_PAC'];
                $direccion = $row['Direccion_TER'];
                $telefono = $row['Telefono_TER'];
                $correo = $row['Correo_TER'];
                $fechaingreso = $row['fechaingreso'];
        }
    }

    ?>
        
</script>

<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal container" id="frm_form<?php echo $NumWindow; ?>">
        <!-- Buscador-->
        <div class="col-md-12" bis_skin_checked="1">
            <div class="row">
                <div class="col-md-2 col-sm-6" bis_skin_checked="1">
                    <div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>" bis_skin_checked="1">
                        <label for="txt_idhc<?php echo $NumWindow; ?>">Ingreso</label>
                        <div class="input-group" bis_skin_checked="1">	
                            <input style="font-size:15px;" name="txt_idhc<?php echo $NumWindow; ?>" id="txt_idhc<?php echo $NumWindow; ?>" type="text" required="" onkeypress="BuscarIng<?php echo $NumWindow; ?>(event);" onblur="BuscarIng<?php echo $NumWindow; ?>()" class="hcx_<?php echo $NumWindow; ?> input-sm form-control">
                            <span class="input-group-btn">	
                                <button class="btn btn-success hcx_<?php echo $NumWindow; ?>" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('Ingreso', 'txt_idhc<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-sm-8" bis_skin_checked="1">
                    <div class="form-group" bis_skin_checked="1">
                        <label for="txt_paciente<?php echo $NumWindow; ?>">Nombre</label>
                        <input style="font-size:15px; font-weight: bold; color:#0E5012; " name="txt_paciente<?php echo $NumWindow; ?>" id="txt_paciente<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead hcx_zWind_2 input-sm form-control">
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
                    <label>Contrato: </label> <span id="spn_contratozWind_2"><?php echo $contrato; ?></span>
                    <input name="hdn_contratozWind_2" type="hidden" id="hdn_contratozWind_2" value="" class="hcx_zWind_2">
                </div>
                <div class="col-md-5 col-sm-5" bis_skin_checked="1">
                    <label>Plan: </label> <span id="spn_planzWind_2"><?php echo $plan; ?></span>
                    <input name="hdn_planzWind_2" type="hidden" id="hdn_planzWind_2" value="" class="hcx_zWind_2">
                </div>
                <div class="col-md-2 col-sm-2" bis_skin_checked="1">
                    <label>Rango: </label> <span id="spn_rangozWind_2">--</span>
                </div>
                <div class="col-md-3 col-sm-3" bis_skin_checked="1">
                    <label>Fec Nacimiento: </label> <small><span id="spn_fechanaczWind_2"><?php echo $fechanacimiento; ?></span></small>
                </div>
                <div class="col-md-4 col-sm-4" bis_skin_checked="1">
                    <label>Edad: </label> <small><span id="spn_edadzWind_2"><?php echo $edad; ?> Años</span></small>
                </div>
                <div class="col-md-2 col-sm-2" bis_skin_checked="1">
                    <label>Sexo: </label> <small><span id="spn_sexozWind_2"><?php echo $sexo; ?></span></small>
                </div>
                <div class="col-md-3 col-sm-3" bis_skin_checked="1">
                    <label>Est. Civil: </label> <small><span id="spn_estcivilzWind_2"><?php echo $estcivil; ?></span></small>
                </div>
                <div class="col-md-4 col-sm-4" bis_skin_checked="1">
                    <label>Dirección: </label> <small><span id="spn_direccionzWind_2"><?php echo $direccion; ?></span></small>
                </div>
                <div class="col-md-2 col-sm-2" bis_skin_checked="1">
                    <label>Teléfono: </label> <small><span id="spn_telefonozWind_2"><?php echo $telefono; ?></span></small>
                </div>
                <div class="col-md-3 col-sm-3" bis_skin_checked="1">
                    <label>Correo: </label> <small><span id="spn_correoelzWind_2"><?php echo $correo; ?></span></small>
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
                    <label>Fecha Ingreso: </label> <span id="spn_fechaingzWind_2" class="badge"><?php echo $fechaingreso; ?></span>
                </div>
                <div class="col-md-4 col-sm-4" bis_skin_checked="1">
                    <label>Tipo Paciente: </label> <span id="spn_tipoptezWind_2">Sin datos</span>
                </div>
                
                
                
            </div>

        </div>
        <!--Detalle-->
        <div class="col-md-12" style="margin-bottom: 15px;" bis_skin_checked="1">
            <label for="txt_iddetalle">Detalle</label>
            <textarea placeholder="Detalle de Devolucion" name="txt_cajadetalle<?php echo $NumWindow; ?>" id="txt_cajadetalle<?php echo $NumWindow; ?>" class="hcx_zWind_2 form-control" style="width: 100%; height: 85px;"> </textarea>
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
                    <?php
                    $filasMed=0;
                    $SQL="Select a.Codigo_SER,b.Codigo_MED , b.Nombre_MED, concat(a.Dosis_HCM, ' ', c.Descripcion_VIA, ' - Frecuencia:', d.Descripcion_FRC, ', Duración: ', a.Duracion_HCM, '. ', a.Observaciones_HCM), a.Pendiente_HCM, e.Cantidad_ISF, e.Pendiente_ISF, e.Fecha_ISF From hcordenesmedica a, gxmedicamentos b, gxviasmed c, gxfrecuenciamed d, czinvsolfarmacia e Where a.Codigo_SER=b.Codigo_SER and c.Codigo_VIA=a.Via_HCM and a.Frecuencia_HCM=d.Codigo_FRC and a.Codigo_HCF=e.Codigo_HCF and e.Codigo_TER=a.Codigo_TER and  e.Codigo_SER=a.Codigo_SER AND LPAD(e.Codigo_ADM,10,'0')=LPAD('".$_GET["Ingreso"]."',10,'0')   and e.Pendiente_ISF <> 0;";
                    //echo $SQL;
                    ?>
                    <tbody id="tbdevoinv_1">
                        <?php 
                        $result = mysqli_query($conexion, $SQL);
    
                        while($row = mysqli_fetch_array($result)) {
                            $filasMed=$filasMed+1;

                        ?>
                        <tr>
                            <td><?php echo $row['Codigo_MED']; ?></td>
                            <td><?php echo $row['Fecha_ISF']; ?></td>
                            <td><?php echo $row['Fecha_ISF']; ?></td>
                            <td><?php echo $row['Nombre_MED']; ?></td>
                            <td><input id="cantdesp" type="number" value="<?php echo $row['Cantidad_ISF']-$row['Pendiente_ISF']; ?>" disabled="disabled"></td>
                            <td><input id="txt_cantdev<?php echo $filasMed.$NumWindow ?>" name="txt_cantdev<?php echo $filasMed.$NumWindow ?>" type="number" value="<?php echo $row['Pendiente_ISF']; ?>"></td>
                            <td><input id="cantAdm" type="number" value="<?php echo $row['Cantidad_ISF']-$row['Pendiente_ISF']; ?>" disabled="disabled"></td>
                        </tr>
                        <input name="hdn_codmed<?php echo $filasMed.$NumWindow; ?>" type="hidden" id="hdn_codmed<?php echo $filasMed.$NumWindow; ?>" value="<?php echo $row['Codigo_SER']; ?>" />
                        <?php
                        }
                        ?>
                    </tbody> 
                </table>

                <input name="hdn_solicitud<?php echo $NumWindow; ?>" type="hidden" id="hdn_solicitud<?php echo $NumWindow; ?>" value="<?php echo $_GET["Ingreso"]; ?>" />
                <input name="hdn_controwMed<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwMed<?php echo $NumWindow; ?>" value="<?php echo $filasMed; ?>" class="hcx_zWind_2">
               

                

            </div>
        </div>  
                <button type="button" class="btn btn-success btn-block btn-md" onclick="javascript:Guardar_inventariodelfarm('<?php echo $NumWindow; ?>', '<?php echo $_GET["genesis"]; ?>');" data-dismiss="modal" id="guardar<?php echo $NumWindow; ?>" name="guardar<?php echo $NumWindow; ?>" >Generar Devolucion</button>
    </form>
    <script src="functions/nexus/inventariosolfarm2.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>
<script >

$(":input:text:visible:first", "#frm_form<?php echo $NumWindow; ?>").focus();

let numdev = document.getElementById("cantdev");
    let text = 0;
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
 

     function BuscarIng<?php echo $NumWindow; ?>(e) {
      tecla = (document.all) ? e.keyCode : e.which;
      if (tecla==13){
        AbrirForm('application/forms/invdevol.php', '<?php echo $NumWindow; ?>', '&Ingreso='+document.getElementById('txt_idhc<?php echo $NumWindow; ?>').value);
      }
    }




</script>

<script src="functions/nexus/inventariodelfarm.js?v=<?php echo $_SESSION["VERSION_CONTROL"]; ?>.<?php echo $NumWindow; ?>"></script>