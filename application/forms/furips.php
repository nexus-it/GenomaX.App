<?php
session_start();
    $NumWindow=$_GET["target"];
    // include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php'; 
    include '../../functions/php/nexus/database.php';   
    $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
    mysqli_query ($conexion, "SET NAMES 'utf8'");
    
?>
<form name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" method="post"  action="" onreset="resetea<?php echo $NumWindow; ?>()">

    <div class="form-group">
      <label for="txt_Ingreso<?php echo $NumWindow; ?>">Codigo</label>
      <div class="input-group"> 
         <input name="txt_Ingreso<?php echo $NumWindow; ?>" type="text" id="txt_Ingreso<?php echo $NumWindow; ?>" size="10" onkeypress="BuscarIng<?php echo $NumWindow; ?>(event);" />
         <span class="input-group-btn"> 
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="Ingreso" onclick="javascript:CargarSearch('Ingreso', 'txt_Ingreso<?php echo $NumWindow; ?>', 'Estado_ADM=*I*');"><span class="glyphicon glyphicon-search" aria-hidden="true"></span></button>
         </span>
       </div>
    </div>

    <div class="row">

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tbfurips2<?php echo $NumWindow; ?>"
                    aria-controls="tbfurips2<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">II. Condición de la Victima</a></li>
            <li role="presentation"><a href="#tbfurips3<?php echo $NumWindow; ?>"
                    aria-controls="tbfurips3<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">III. Datos del Sitio donde Ocurrió</a></li>
            <li role="presentation"><a href="#tbfurips4<?php echo $NumWindow; ?>"
                    aria-controls="tbfurips4<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">IV. Datos del Vehículo</a></li>
            <li role="presentation"><a href="#tbfurips5<?php echo $NumWindow; ?>"
                    aria-controls="tbfurips5<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">V. Datos del Propietario</a></li>
            <li role="presentation"><a href="#tbfurips6<?php echo $NumWindow; ?>" 
                    aria-controls="tbfurips6<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">VI. Datos del conductor involucrado</a></li>
            <li role="presentation"><a href="#tbfurips7<?php echo $NumWindow; ?>" 
                    aria-controls="tbfurips7<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">VII. Datos de Remision</a></li>
            <li role="presentation"><a href="#tbfurips8<?php echo $NumWindow; ?>" 
                    aria-controls="tbfurips8<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">VIII. Amparo de Transporte</a></li>
            <li role="presentation"><a href="#tbfurips9<?php echo $NumWindow; ?>" 
                    aria-controls="tbfurips9<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">IX. Certificado de la Atencion</a></li>
            <li role="presentation"><a href="#tbfurips10<?php echo $NumWindow; ?>" 
                    aria-controls="tbfurips9<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">X. Amaparos que reclama</a></li>       
        </ul>

        <div id="divtantcdt<?php echo $NumWindow; ?>" class="col-md-12 tab-content">
            <div id="tbfurips2<?php echo $NumWindow; ?>" class="row tab-pane fade in active" role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF"
                            class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td align="center" style="vertical-align: middle;">Condicion del Accidentado :</td>
                                    <td align="right" style="vertical-align: middle;">
                                        <?php nxs_chk('conductor', $NumWindow); ?>
                                    </td>
                                    <td align="" style="vertical-align: middle;">Conductor</td>

                                    <td align="right" style="vertical-align: middle;">
                                        <?php nxs_chk('peaton', $NumWindow); ?>
                                    </td>
                                    <td align="" style="vertical-align: middle;">Peatón</td>

                                    <td align="right" style="vertical-align: middle;">
                                        <?php nxs_chk('ocupante', $NumWindow); ?>
                                    </td>
                                    <td align="" style="vertical-align: middle;">Ocupante</td>

                                    <td align="right" style="vertical-align: middle;">
                                        <?php nxs_chk('ciclista', $NumWindow); ?>
                                    </td>
                                    <td align="" style="vertical-align: middle;">Ciclista</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tbfurips3<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF"
                            class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Naturaleza del evento :</td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">
                                        <h3>Naturales:</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="vertical-align: middle;">Accidente de transito</td>
                                    <td>
                                            <?php nxs_chk('acd_transito', $NumWindow); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="vertical-align: middle;">Sismo</td>
                                    <td>
                                        <?php nxs_chk('sismo', $NumWindow); ?>
                                    </td>
                                    <td class="" align="right" style="vertical-align: middle;">Maremoto</td>
                                    <td>
                                        <?php nxs_chk('maremoto', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Erupciones Volcánicas</td>
                                    <td>
                                        <?php nxs_chk('erupciones', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Huracán</td>
                                    <td>
                                        <?php nxs_chk('huracan', $NumWindow); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="vertical-align: middle;">Inundaciones</td>
                                    <td>
                                        <?php nxs_chk('inundaciones', $NumWindow); ?>
                                    </td>
                                    <td class="" align="right" style="vertical-align: middle;">Avalancha</td>
                                    <td>
                                        <?php nxs_chk('avalancha', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Desplazamiento de tierra</td>
                                    <td>
                                        <?php nxs_chk('des_tierra', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Incendio Natural</td>
                                    <td>
                                        <?php nxs_chk('in_natural', $NumWindow); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="vertical-align: middle;">Rayo</td>
                                    <td>
                                        <?php nxs_chk('rayo', $NumWindow); ?>
                                    </td>
                                    <td class="" align="right" style="vertical-align: middle;">Vendaval</td>
                                    <td>
                                        <?php nxs_chk('vendaval', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Tornado</td>
                                    <td>
                                        <?php nxs_chk('tornado', $NumWindow); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">
                                        <h3>Terroristas:</h3>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="vertical-align: middle;">Explosión</td>
                                    <td>
                                        <?php nxs_chk('explosion', $NumWindow); ?>
                                    </td>
                                    <td class="" align="right" style="vertical-align: middle;">Masacre</td>
                                    <td>
                                        <?php nxs_chk('masacre', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Mina Antipersonal</td>
                                    <td>
                                        <?php nxs_chk('mina', $NumWindow); ?>                                    </td>
                                    <td align="right" style="vertical-align: middle;">Combate</td>
                                    <td>
                                        <?php nxs_chk('combate', $NumWindow); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="vertical-align: middle;">Incendio</td>
                                    <td>
                                        <?php nxs_chk('incendio', $NumWindow); ?>
                                    </td>
                                    <td class="" align="right" style="vertical-align: middle;">Ataques a Municipios</td>
                                    <td>
                                        <?php nxs_chk('ataque', $NumWindow); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="vertical-align: middle;">otro</td>
                                    <td>
                                        <?php nxs_chk('otro', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Cual?</td>
                                    <td colspan="7">
                                        <input type="text" name="txt_cual<?php echo $NumWindow; ?>"
                                            id="txt_cual<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Dirección de la Ocurrencia</td>
                                    <td colspan="7">
                                        <input type="text" name="txt_dirocurrencia<?php echo $NumWindow; ?>"
                                            id="txt_dirocurrencia<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Fecha Evento/Accidente</td>
                                    <td colspan="7">
                                        <input type="date" name="txt_fechaeven<?php echo $NumWindow; ?>"
                                            id="txt_fechaeven<?php echo $NumWindow; ?>" value="" min="" max="" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Hora</td>
                                    <td colspan="7">
                                        <input style="margin-right: 8px;" type="time"
                                            name="txt_horaeven<?php echo $NumWindow; ?>"
                                            id="txt_horaeven<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Departamento</td>
                                    <td>
                                        <select name="txt_dptoeven<?php echo $NumWindow; ?>" id="txt_dptoeven<?php echo $NumWindow; ?>" onchange="BuscarDepto<?php echo $NumWindow; ?>('');">
                                                <?php 
                                                $SQL="Select Codigo_DEP, Nombre_DEP from czdepartamentos order by 2";
                                                $result = mysqli_query($conexion, $SQL);
                                                while($row = mysqli_fetch_array($result)) 
                                                    {
                                                 ?>
                                                  <option value="<?php echo $row[0]; ?>" ><?php echo ($row[1]); ?></option>
                                                <?php
                                                    }
                                                mysqli_free_result($result); 
                                                 ?>  
                                        </select>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Cod</td>
                                    <td colspan="7">
                                        <input style="width: 100px;" type="text" name="txt_cod<?php echo $NumWindow; ?>"
                                            id="txt_cod<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Municipio</td>
                                    <td>
                                        <select name="txt_muneven<?php echo $NumWindow; ?>" id="txt_muneven<?php echo $NumWindow; ?>" >  
                                        </select>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Cod</td>
                                    <td colspan="7">
                                        <input style="width: 100px;" type="text"
                                            name="txt_cod-2<?php echo $NumWindow; ?>"
                                            id="txt_cod-2<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">zona</td>
                                    <td>
                                        <select name="txt_zonaeven<?php echo $NumWindow; ?>"
                                            id="txt_zonaeven<?php echo $NumWindow; ?>" class="input-sm">
                                            <option value="0"></option>
                                            <option value="U">U</option>
                                            <option value="R">R</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Descripcion breve del evento
                                        catastrofico o accidente de transito</td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Enuncie las principales
                                        caracteristicas del evento / accidente: </td>
                                    <td colspan="7">
                                        <textarea
                                            style="height: 25px; max-height: 100px; width: 300px; max-width: 400px;"
                                            name="txt_deseven<?php echo $NumWindow; ?>"
                                            id="txt_deseven<?php echo $NumWindow; ?>"></textarea>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tbfurips4<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF"
                            class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td align="right" style="vertical-align: middle;">Asegurado</td>

                                    <td align="left" style="vertical-align: middle;">
                                        <?php nxs_chk('asegurado', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">No Asegurado</td>

                                    <td align="left" style="vertical-align: middle;">
                                            <?php nxs_chk('no-asegurado', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">vehículo fantasma</td>

                                    <td align="left" style="vertical-align: middle;">
                                             <?php nxs_chk('vehifantasma', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Póliza Falsa</td>

                                    <td align="left" style="vertical-align: middle;">
                                            <?php nxs_chk('polizafalsa', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Vehículo en fuga</td>

                                    <td align="left" style="vertical-align: middle;">
                                            <?php nxs_chk('vehienfuga', $NumWindow); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="vertical-align: middle;">Marca</td>
                                    <td colspan="7">
                                        <input type="text" name="txt_marca<?php echo $NumWindow; ?>"
                                            id="txt_marca<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Placa:</td>
                                    <td colspan="7">
                                        <input type="text" name="txt_placa<?php echo $NumWindow; ?>"
                                            id="txt_placa<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Tipo de Servicio:</td>

                                    <td align="right" style="vertical-align: middle;">Particular</td>

                                    <td align="left" style="vertical-align: middle;">
                                        <?php nxs_chk('particular', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Público</td>

                                    <td align="left" style="vertical-align: middle;">
                                        <?php nxs_chk('publico', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Oficial</td>

                                    <td align="left" style="vertical-align: middle;">
                                        <?php nxs_chk('oficial', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Vehiculo de emergencia</td>

                                    <td align="left" style="vertical-align: middle;">
                                            <?php nxs_chk('vehiemergencia', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Vehiculo de servicio diplomatico o
                                        consultar</td>

                                    <td align="left" style="vertical-align: middle;">
                                            <?php nxs_chk('diplomatico-consultar', $NumWindow); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="right" style="vertical-align: middle;">Vehiculo de tranporte masivo</td>

                                    <td align="left" style="vertical-align: middle;">
                                            <?php nxs_chk('transportemasivo', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Vehiculo Escolar</td>

                                    <td align="left" style="vertical-align: middle;">
                                        <?php nxs_chk('escolar', $NumWindow); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">Codigo de la aseguradora</td>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input type="text" name="txt_codigo-aseguradora<?php echo $NumWindow; ?>"
                                            id="txt_codigo-aseguradora<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;">No.de la poliza</td>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input type="text" name="txt_poliza<?php echo $NumWindow; ?>"
                                            id="txt_poliza<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                    <td align="left" style="vertical-align: middle;">Intervencion de autotidad</td>
                                    <td align="right" style="vertical-align: middle;">Si</td>
                                    <td align="left" style="vertical-align: middle;">

                                        
                                            <?php nxs_chk('si-intervencion', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">No</td>
                                    <td align="left" style="vertical-align: middle;">
                                        <?php nxs_chk('no-intervencion', $NumWindow); ?>
                                    </td>
                                </tr>
                                <tr align="left">
                                    <td style="vertical-align: middle;">Vigencia desde</td>
                                    <td colspan="7">
                                        <input style="position: relative; right: 10rem;" type="date"
                                            name="txt_vigenciadesde<?php echo $NumWindow; ?>"
                                            id="txt_vigenciadesde<?php echo $NumWindow; ?>" value="" min="" max="" />
                                    </td>
                                    <td align="left" style="vertical-align: middle; position: relative; right: 9rem;">
                                        Hasta</td>  
                                    <td colspan="7">
                                        <input style="position: relative; right: 10rem;" type="date"
                                            name="txt_vigenciahasta<?php echo $NumWindow; ?>"
                                            id="txt_vigenciahasta<?php echo $NumWindow; ?>" value="" min="" max="" />
                                    </td>
                                    <td align="left" style="vertical-align: middle;">Cobro Excedente póliza</td>
                                    <td align="right" style="vertical-align: middle;">Si</td>
                                    <td align="left" style="vertical-align: middle;">

                                       
                                            <?php nxs_chk('si-cobropoliza', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">No</td>
                                    <td align="left" style="vertical-align: middle;">
                                        <?php nxs_chk('no-cobropoliza', $NumWindow); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tbfurips5<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF"
                            class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input style="width: 300px; position: relative; right: 3rem;" type="text"
                                            name="txt_primerapellido<?php echo $NumWindow; ?>"
                                            id="txt_primerapellido<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_segundoapellido<?php echo $NumWindow; ?>"
                                            id="txt_segundoapellido<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;  position: relative; left: 10rem;">1er Apellido o
                                        razon social</td>
                                    <td align="right" style="vertical-align: middle; position: relative; left: 35rem;">
                                        2do.Apellido</td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input style="width: 300px; position: relative; right: 3rem;" type="text"
                                            name="txt_primernombre<?php echo $NumWindow; ?>"
                                            id="txt_primernombre<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_segundonombre<?php echo $NumWindow; ?>"
                                            id="txt_segundonombre<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;  position: relative; left: 10rem;">1er Nombre
                                    </td>
                                    <td align="right" style="vertical-align: middle; position: relative; left: 35rem;">
                                        2do.Nombre</td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Tipo de documento </td>
                                    <td align="left" style="vertical-align: middle; ">
                                        <select name="txt_tipo-documento<?php echo $NumWindow; ?>"
                                            id="txt_tipo-documento<?php echo $NumWindow; ?>" class="input-sm">
                                            <option value="0"></option>
                                            <option value="CC">CC</option>
                                            <option value="CE">CE</option>
                                            <option value="PA">PA</option>
                                            <option value="TI">TI</option>
                                            <option value="RC">RC</option>
                                            <option value="CD">CD</option>
                                        </select>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">No.documento </td>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input type="text" name="txt_numerodocumento<?php echo $NumWindow; ?>"
                                            id="txt_numerodocumento<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Direccion Residencia </td>
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_direccion-residencia<?php echo $NumWindow; ?>"
                                            id="txt_direccion-residencia<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Departamento</td>
                                    <td colspan="7">
                                            <select name="txt_departamentopro<?php echo $NumWindow; ?>" id="txt_departamentopro<?php echo $NumWindow; ?>" onchange="BuscarDeptoP<?php echo $NumWindow; ?>('');">
                                                <?php 
                                                $SQL="Select Codigo_DEP, Nombre_DEP from czdepartamentos order by 2";
                                                $result = mysqli_query($conexion, $SQL);
                                                while($row = mysqli_fetch_array($result)) 
                                                    {
                                                 ?>
                                                  <option value="<?php echo $row[0]; ?>" ><?php echo ($row[1]); ?></option>
                                                <?php
                                                    }
                                                mysqli_free_result($result); 
                                                 ?>  
                                        </select>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Cod</td>
                                    <td colspan="7">
                                        <input style="width: 100px;" type="text"
                                            name="txt_cod-pro<?php echo $NumWindow; ?>"
                                            id="txt_cod-pro<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Telefono</td>
                                    <td colspan="7">
                                        <input style="width: 100px;" type="text"
                                            name="txt_telefonopro<?php echo $NumWindow; ?>"
                                            id="txt_telefonopro<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Municipio Residencia</td>
                                    <td>
                                        <select name="txt_municipiopro<?php echo $NumWindow; ?>"
                                            id="txt_municipiopro<?php echo $NumWindow; ?>" class="input-sm">
                                        </select>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Cod</td>
                                    <td colspan="7">
                                        <input style="width: 100px;" type="text"
                                            name="txt_cod-pro2<?php echo $NumWindow; ?>"
                                            id="txt_cod-pro2<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <div id="tbfurips6<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF"
                            class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input style="width: 300px; position: relative; right: 3rem;" type="text"
                                            name="txt_primerapellido_ci<?php echo $NumWindow; ?>"
                                            id="txt_primerapellido_ci<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_segundoapellido_ci<?php echo $NumWindow; ?>"
                                            id="txt_segundoapellido_ci<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;  position: relative; left: 7em;">1er Apellido
                                    </td>
                                    <td align="right" style="vertical-align: middle; position: relative; left: 6rem;">
                                        2do.Apellido</td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input style="width: 300px; position: relative; right: 3rem;" type="text"
                                            name="txt_primernombre_ci<?php echo $NumWindow; ?>"
                                            id="txt_primernombre_ci<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_segundonombre_ci<?php echo $NumWindow; ?>"
                                            id="txt_segundonombre_ci<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;  position: relative; left: 7rem;">1er Nombre
                                    </td>
                                    <td align="right" style="vertical-align: middle; position: relative; left: 6rem;">
                                        2do.Nombre</td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Tipo de documento </td>
                                    <td align="left" style="vertical-align: middle; ">
                                        <select name="txt_tipodocumento_ci<?php echo $NumWindow; ?>"
                                            id="txt_tipodocumento_ci<?php echo $NumWindow; ?>" class="input-sm">
                                            <option value="0"></option>
                                            <option value="CC">CC</option>
                                            <option value="CE">CE</option>
                                            <option value="PA">PA</option>
                                            <option value="TI">TI</option>
                                            <option value="AS">AS</option>
                                            <option value="CD">CD</option>
                                        </select>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">No.documento </td>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input type="text" name="txt_numerodocumento_ci<?php echo $NumWindow; ?>"
                                            id="txt_numerodocumento_ci<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Direccion Residencia </td>
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_direccionresidencia_ci<?php echo $NumWindow; ?>"
                                            id="txt_direccionresidencia_ci<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <td align="left" style="vertical-align: middle;">Departamento</td>
                                <td colspan="7">
                                    <input type="text" name="txt_departamentopro_ci<?php echo $NumWindow; ?>"
                                        id="txt_departamentopro_ci<?php echo $NumWindow; ?>" />
                                </td>
                                <td align="right" style="vertical-align: middle;">Cod</td>
                                <td colspan="7">
                                    <input style="width: 100px;" type="text" name="txt_cod-pro<?php echo $NumWindow; ?>"
                                        id="txt_cod-pro<?php echo $NumWindow; ?>" />
                                </td>
                                <td align="right" style="vertical-align: middle;">Telefono</td>
                                <td colspan="7">
                                    <input style="width: 100px;" type="text"
                                        name="txt_telefono_ci<?php echo $NumWindow; ?>"
                                        id="txt_telefono_ci<?php echo $NumWindow; ?>" />
                                </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Municipio Residencia</td>
                                    <td>
                                        <select name="txt_municipioresidencia_ci<?php echo $NumWindow; ?>"
                                            id="txt_municipioresidencia_ci<?php echo $NumWindow; ?>" class="input-sm">
                                        </select>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Cod</td>
                                    <td colspan="7">
                                        <input style="width: 100px;" type="text"
                                            name="txt_cod-pro2<?php echo $NumWindow; ?>"
                                            id="txt_cod-pro2<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tbfurips7<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF"
                            class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Tipo Referencia:</td>
                                    <td align="right" style="vertical-align: middle;">Remision</td>
                                    <td>
                                        <?php nxs_chk('remision_dr', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Orden de servicio</td>
                                    <td>
                                        <?php nxs_chk('orden-servicio_dr', $NumWindow); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Fecha Remision</td>
                                    <td colspan="7">
                                        <input type="date" name="txt_fecha-remision<?php echo $NumWindow; ?>"
                                            id="txt_fecha-remision<?php echo $NumWindow; ?>" value="" min="" max="" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">a las</td>
                                    <td colspan="7">
                                        <input style="margin-right: 8px;" type="time"
                                            name="txt_hora-remision<?php echo $NumWindow; ?>"
                                            id="<txt_hora-remision></txt_hora-remision><?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Prestador que remite </td>
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_prestador<?php echo $NumWindow; ?>"
                                            id="txt_prestador<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Codigo de Incripcion: </td>
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_inscripcion-remite<?php echo $NumWindow; ?>"
                                            id="txt_inscripcion-remite<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Profesional que remite: </td>
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_proremite<?php echo $NumWindow; ?>"
                                            id="txt_proremite<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Cargo: </td>
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_cargo<?php echo $NumWindow; ?>"
                                            id="txt_cargo<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Fecha Aceptación</td>
                                    <td colspan="7">
                                        <input type="date" name="txt_fecha-aceptacion<?php echo $NumWindow; ?>"
                                            id="txt_fecha-aceptacion<?php echo $NumWindow; ?>" value="" min="" max="" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">a las</td>
                                    <td colspan="7">
                                        <input style="margin-right: 8px;" type="time"
                                            name="txt_hora-remision_acep<?php echo $NumWindow; ?>"
                                            id="txt_hora-remision_acep<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Prestador que recibe: </td>
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_prestador-recibe<?php echo $NumWindow; ?>"
                                            id="txt_prestador-recibe><?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Codigo de Incripcion: </td>
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_inscripcion-recibe<?php echo $NumWindow; ?>"
                                            id="txt_inscripcion-recibe<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Profesional que recibe: </td>
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_prorecibe<?php echo $NumWindow; ?>"
                                            id="txt_prorecibe<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Cargo: </td>
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_cargo-recibe<?php echo $NumWindow; ?>"
                                            id="txt_cargo-recibe<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tbfurips8<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF"
                            class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Diligenciar únicamente para
                                        transporte desde el sitio el sitio del evento hasta la primera IPS (Transporte
                                        primeario)</td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Datos de Vehiculo:</td>
                                    <td align="right" style="vertical-align: middle;">Placa No.</td>
                                    <td colspan="7">
                                        <input type="text" name="txt_placa-vehiculo<?php echo $NumWindow; ?>"
                                            id="txt_placa-vehiculo<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Transporto la victima desde </td>
                                    <td colspan="7">
                                        <input type="text" name="txt_transporte_desde<?php echo $NumWindow; ?>"
                                            id="txt_transporte_desde<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">hasta </td>
                                    <td colspan="7">
                                        <input type="text" name="txt_transporte_hasta<?php echo $NumWindow; ?>"
                                            id="txt_transporte_hasta<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Tipo de transporte</td>
                                    <td align="right" style="vertical-align: middle;">Ambulancia Básica</td>
                                    <td>
                                            <?php nxs_chk('ambulancia-basica', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Ambulancia Medicada</td>
                                    <td>
                                            <?php nxs_chk('ambulancia-medicada', $NumWindow); ?>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Lugar donde recoge la victima</td>
                                    <td align="right" style="vertical-align: middle;">zona</td>
                                    <td>
                                        <select style="padding-left:20px ;" name="txt_zona_recoge<?php echo $NumWindow; ?>"
                                            id="txt_zona_recoge<?php echo $NumWindow; ?>" class="input-sm">
                                            <option value="0"></option>
                                            <option value="1">U</option>
                                            <option value="1">R</option>
                                        </select>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tbfurips9<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF"
                            class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td align="left" style="vertical-align: middle; width: 100%;">Fecha de Ingreso</td>
                                    <td colspan="7">
                                        <input type="date" name="txt_fecha-ingreso<?php echo $NumWindow; ?>"
                                            id="txt_fecha-ingreso<?php echo $NumWindow; ?>" value="" min="" max="" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">a las</td>
                                    <td colspan="3">
                                        <input style="margin-right: 8px;" type="time"
                                            name="txt_hora-ingreso<?php echo $NumWindow; ?>"
                                            id="txt_hora-ingreso<?php echo $NumWindow; ?>" value="" min="" max="" />
                                    </td>
                                    <td align="left" style="vertical-align: middle; width: 100%;">Fecha de egreso</td>
                                    <td colspan="7">
                                        <input style="margin-right: 4rem;" type="date"
                                            name="txt_fecha-egreso<?php echo $NumWindow; ?>"
                                            id="txt_fecha-egreso<?php echo $NumWindow; ?>" value="" min="" max="" />
                                    </td>
                                    <td align="right" style="vertical-align: middle; width: 100%;">a las</td>
                                    <td colspan="3">
                                        <input style="margin-right: 8px;" type="time"
                                            name="txt_hora-egreso<?php echo $NumWindow; ?>"
                                            id="txt_hora-egreso<?php echo $NumWindow; ?>" value="" min="" max="" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Código diagnóstico principal de
                                        Ingreso </td>
                                    <td colspan="7">
                                        <input type="text" name="txt_otrocodigo-ingreso<?php echo $NumWindow; ?>"
                                            id="txt_otrocodigo-ingreso<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Código diagnóstico principal de
                                        egreso</td>
                                    <td colspan="7">
                                        <input type="text" name="txt_otrocodigo-egreso<?php echo $NumWindow; ?>"
                                            id="txt_otrocodigo-egreso<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">otro Código diagnóstico principal
                                        de
                                        Ingreso </td>
                                    <td colspan="7">
                                        <input type="text" name="txt_otrocodigo-ingreso_p<?php echo $NumWindow; ?>"
                                            id="txt_otrocodigo-ingreso<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">otro Código diagnóstico principal
                                        de
                                        egreso</td>
                                    <td colspan="7">
                                        <input type="text" name="txt_otrocodigo-egreso_p<?php echo $NumWindow; ?>"
                                            id="txt_otrocodigo-egreso<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">otro Código diagnóstico principal
                                        de
                                        Ingreso </td>
                                    <td colspan="7">
                                        <input type="text" name="txt_codigo-ingreso_s<?php echo $NumWindow; ?>"
                                            id="txt_codigo-ingreso<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">otro Código diagnóstico principal
                                        de
                                        egreso</td>
                                    <td colspan="7">
                                        <input type="text" name="txt_codigo-egreso_s<?php echo $NumWindow; ?>"
                                            id="txt_codigoegreso<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input style="width: 300px; position: relative; right: 3rem;" type="text"
                                            name="txt_primerapellido_ca<?php echo $NumWindow; ?>"
                                            id="txt_primerapellido_ca<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_segundoapellido_ca<?php echo $NumWindow; ?>"
                                            id="txt_segundoapellido_ca<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                </tr>
                                <tr>
                                    <td
                                        style="vertical-align: middle;  position: relative; left: 7.5rem; width: 100%; height: 100%;">
                                        1er Apellido del medico o profesional tratante</td>
                                    <td align="right" style="vertical-align: middle; position: relative; left: 29rem;">
                                        2do Apellido del medico o profesional tratante</td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input style="width: 300px; position: relative; right: 3rem;" type="text"
                                            name="txt_primernombre_ca<?php echo $NumWindow; ?>"
                                            id="txt_primernombre_ca<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input style="width: 300px;" type="text"
                                            name="txt_segundonombre_ca<?php echo $NumWindow; ?>"
                                            id="txt_segundonombre_ca<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="vertical-align: middle;  position: relative; left: 7.5rem;">1er Nombre
                                        del medico o profesional tratante
                                    </td>
                                    <td align="right" style="vertical-align: middle; position: relative; left: 29rem;">
                                        2do Nombre del medico o profesional tratante </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Tipo de documento </td>
                                    <td align="left" style="vertical-align: middle; ">
                                        <select name="txt_tipodocumento_ca<?php echo $NumWindow; ?>"
                                            id="txt_tipodocumento_ca<?php echo $NumWindow; ?>" class="input-sm">
                                            <option value="0"></option>
                                            <option value="CC">CC</option>
                                            <option value="CE">CE</option>
                                            <option value="PA">PA</option>
                                        </select>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Número de documento </td>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input type="text" name="txt_numerodocumento_ca<?php echo $NumWindow; ?>"
                                            id="txt_numerodocumento_ca<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Número de registro medico</td>
                                    <td align="left" style="vertical-align: middle;">
                                    <td colspan="7">
                                        <input type="text" name="txt_no-registromedico<?php echo $NumWindow; ?>"
                                            id="txt_no-registromedico<?php echo $NumWindow; ?>" />
                                    </td>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tbfurips10<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF"
                            class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Gastos medicos Quirurgicos</td>
                                </tr>    
                                <tr>
                                    <td align="left" style="vertical-align: middle;">-Valor total facturado:</td>
                                    <td colspan="7">
                                        <input type="text" name="txt_Valortotalfacturado_gmq<?php echo $NumWindow; ?>"
                                            id="txt_Valortotalfacturado_gmq<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>    
                                <tr>
                                    <td align="left" style="vertical-align: middle;">-Valor reclamado al fosyga</td>
                                    <td colspan="7">
                                        <input type="text" name="txt_Valorreclamadoalfosyga_gmq<?php echo $NumWindow; ?>"
                                            id="txt_Valorreclamadoalfosyga_gmq<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>    
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Gastos de transporte y movilización de la victima</td>
                                </tr>    
                                <tr>
                                    <td align="left" style="vertical-align: middle;">-Valor total facturado:</td>
                                    <td colspan="7">
                                        <input type="text" name="txt_Valortotalfacturado_gtmv<?php echo $NumWindow; ?>"
                                            id="txt_Valortotalfacturado_gtmv<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>    
                                <tr>
                                    <td align="left" style="vertical-align: middle;">-Valor reclamado al fosyga</td>
                                    <td colspan="7">
                                        <input type="text" name="txt_Valorreclamadoalfosyga_gtmv<?php echo $NumWindow; ?>"
                                            id="txt_Valorreclamadoalfosyga_gtmv<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>    
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

</form>

<script>

    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
    $("textarea").addClass("form-control");
    $("select").addClass("form-control");
    $("input[type=date]").addClass("form-control");
    $("input[type=number]").addClass("form-control");
    $("input[type=time]").addClass("form-control");


function BuscarDepto<?php echo $NumWindow; ?>(Mun) {
    Codigo=document.getElementById('txt_dptoeven<?php echo $NumWindow; ?>').value;
    CargarMun<?php echo $NumWindow; ?>('<?php echo $NumWindow; ?>', Codigo, Mun);
}



function CargarMun<?php echo $NumWindow; ?>(Ventana, Codigo, Muni)
{
    $.get(Funciones,{'Func':'CargarMun','value':Codigo},function(data){ 
        document.getElementById('txt_muneven'+Ventana).innerHTML=data;
        if (Muni!='') {
            document.getElementById('txt_muneven'+Ventana).value=Muni;
        }
    }); 
}

function BuscarDeptoP<?php echo $NumWindow; ?>(Mun) {
    Codigo=document.getElementById('txt_departamentopro<?php echo $NumWindow; ?>').value;
    CargarMunP<?php echo $NumWindow; ?>('<?php echo $NumWindow; ?>', Codigo, Mun);
}

function CargarMunP<?php echo $NumWindow; ?>(Ventana, Codigo, Muni)
{
    $.get(Funciones,{'Func':'CargarMun','value':Codigo},function(data){ 
        document.getElementById('txt_municipiopro'+Ventana).innerHTML=data;
        if (Muni!='') {
            document.getElementById('txt_municipiopro'+Ventana).value=Muni;
        }
    }); 
}

</script>
