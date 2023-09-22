
    <div class="row">

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tbfurips2<?php echo $NumWindow; ?>"
                    aria-controls="tbfurips2<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">DATOS DEL TRANSPORTADOR</a></li>
            <li role="presentation"><a href="#tbfurips3<?php echo $NumWindow; ?>"
                    aria-controls="tbfurips3<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">RELACION DE LAS VICTIMAS TRASLADADAS</a></li>
            <li role="presentation"><a href="#tbfurips4<?php echo $NumWindow; ?>"
                    aria-controls="tbfurips4<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">LUGAR EN EL QUE SE RECOGE LA VICTIMA O VICTIMAS</a></li>
            <li role="presentation"><a href="#tbfurips5<?php echo $NumWindow; ?>"
                    aria-controls="tbfurips5<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">CERTIFICACION DE TRASLADO DE VICTIMAS</a></li>
        </ul>

        <div id="divtantcdt<?php echo $NumWindow; ?>" class="col-md-12 tab-content">
            <div id="tbfurips2<?php echo $NumWindow; ?>" class="row tab-pane fade in active" role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF"
                            class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Fecha de entrega</td>
                                    <td align="left" colspan="7">
                                        <input type="date" name="txt_fecha-entrega<?php echo $NumWindow; ?>"
                                            id="txt_fecha-entrega<?php echo $NumWindow; ?>" value="" min="" max="" />
                                    </td>
                                    <td align="left" style="vertical-align: middle;">No.Radicado</td>
                                    <td align="" colspan="7">
                                       <textarea name="txt_no-radicado<?php echo $NumWindow; ?>" id="txt_no-radicado<?php echo $NumWindow; ?>" cols="30" rows="10" style="min-width: 300px; max-width: 300px; min-height: 50px; max-height: 60px;"></textarea>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">No.Radicado Anterior (Respuesta a glosa, marcar x en RG) </td>
                                    <td align="" colspan="7">
                                       <textarea name="txt_radicado-anterior<?php echo $NumWindow; ?>" id="txt_radicado-anterior<?php echo $NumWindow; ?>" cols="30" rows="10" style="min-width: 300px; max-width: 300px; min-height: 30px; max-height: 40px;"></textarea>
                                    </td>
                                    <td align="right" style="vertical-align: middle;">
                                        <input class="form-check-input" type="checkbox"
                                            name="txt_RG<?php echo $NumWindow; ?>"
                                            id="txt_RG<?php echo $NumWindow; ?>">
                                    </td>
                                    <td align="left" style="vertical-align: middle;">RG</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tbanttox<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF"
                            class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                               <tr>
                                <td align="left" style="vertical-align: middle;">Nombre Empresa de Transporte Especial Reclamante</td>
                                <td  align="center" colspan="7">
                                    <input style="width: 600px;" type="text" name="txt_empresa<?php echo $NumWindow; ?>"
                                        id="txt_empresa<?php echo $NumWindow; ?>" />
                                </td>
                               </tr>
                               <tr>
                                <td align="left" style="vertical-align: middle;">Codigo de habilitacion Empresa de Transporte Especial</td>
                                <td  align="left" colspan="7">
                                    <input type="text" name="txt_empresa<?php echo $NumWindow; ?>"
                                        id="txt_empresa<?php echo $NumWindow; ?>" />
                                </td>
                               </tr>
                               <tr>
                                <td  align="center" colspan="7">
                                    <input style="width: 370px;" type="text" name="txt_1er-apellido<?php echo $NumWindow; ?>"
                                        id="txt_1er-apellido<?php echo $NumWindow; ?>" />
                                </td>
                                <td  align="" colspan="7" style="position: relative; right: 10rem;">
                                    <input style="width: 370px;" type="text" name="txt_2do-apellido<?php echo $NumWindow; ?>"
                                        id="txt_2do-apellido<?php echo $NumWindow; ?>" />
                                </td>
                               </tr>
                               <tr>
                                <td align="right" style="vertical-align: middle; position: relative; left: 10rem;">1er Apellido</td>
                                <td align="right" style="vertical-align: middle; position: relative; left: 28rem;">2do. Apellido</td>
                               </tr>
                               <tr>
                                <td  align="center" colspan="7">
                                    <input style="width: 370px;" type="text" name="txt_1er-nombre<?php echo $NumWindow; ?>"
                                        id="txt_1er-nombre<?php echo $NumWindow; ?>" />
                                </td>
                                <td  align="" colspan="7" style="position: relative; right: 10rem;">
                                    <input style="width: 370px;" type="text" name="txt_2do-nombre<?php echo $NumWindow; ?>"
                                        id="txt_2do-nombre<?php echo $NumWindow; ?>" />
                                </td>
                               </tr>
                               <tr>
                                <td align="right" style="vertical-align: middle; position: relative; left: 10rem;">1er Nombre</td>
                                <td align="right" style="vertical-align: middle; position: relative; left: 28rem;">2do. Nombre</td>
                               </tr>
                               <tr>
                               <td align="" style="vertical-align: middle;">Tipo de documento </td>
                                    <td align="left" style="vertical-align: middle; ">
                                        <select name="txt_tipo-documento<?php echo $NumWindow; ?>"
                                            id="txt_tipo-documento<?php echo $NumWindow; ?>" class="input-sm">
                                            <option value="0"></option>
                                            <option value="1">CC</option>
                                            <option value="1">CE</option>
                                            <option value="1">PA</option>
                                            <option value="1">TI</option>
                                            <option value="1">NI</option>
                                        </select>
                                    </td>
                                    <td align="left" style="vertical-align: middle;">Numero de documento</td>
                                    <td  align="left" colspan="7">
                                        <input type="text" name="txt_numero-documento<?php echo $NumWindow; ?>"
                                            id="txt_numero-documento<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Tipo de Servicio:</td>

                                    <td align="right" style="vertical-align: middle;">Ambulancia Básica</td>

                                    <td align="left" style="vertical-align: middle;">
                                        <input class="form-check-input" type="checkbox"
                                            name="txt_ambulancia-basica<?php echo $NumWindow; ?>"
                                            id="txt_ambulancia-basica<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Ambulancia Medica</td>

                                    <td align="left" style="vertical-align: middle;">
                                        <input class="form-check-input" type="checkbox"
                                            name="txt_ambulancia-medica<?php echo $NumWindow; ?>"
                                            id="txt_ambulancia-medica<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Si es Persona Natural-tipo Servicio </td>

                                    <td align="right" style="vertical-align: middle;">Particular</td>

                                    <td align="left" style="vertical-align: middle;">
                                        <input class="form-check-input" type="checkbox"
                                            name="txt_particular<?php echo $NumWindow; ?>"
                                            id="txt_particular<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Servicio Publico</td>

                                    <td align="left" style="vertical-align: middle;">
                                        <input class="form-check-input" type="checkbox"
                                            name="txt_servicio-publico<?php echo $NumWindow; ?>"
                                            id="txt_servicio-publico<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="right" style="vertical-align: middle;">Otro</td>
                                    <td align="left" style="vertical-align: middle;">
                                        <input class="form-check-input" type="checkbox"
                                            name="txt_otro<?php echo $NumWindow; ?>"
                                            id="txt_otro<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="center" style="vertical-align: middle;">Cual?</td>
                                    <td  align="left" colspan="7" style="position: relative; right: 10rem;">
                                        <input type="text" name="txt_cual<?php echo $NumWindow; ?>"
                                            id="txt_cual<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">En vehículo con placa No.
                                    </td>
                                    <td  align="left" colspan="7">
                                        <input type="text" name="txt_vehiculo-placa<?php echo $NumWindow; ?>"
                                            id="txt_vehiculo-placa<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle; width: 300px;">Dirección de la empresa o persona que realiza el transporte
                                    </td>
                                    <td align="left" colspan="7">
                                        <input style="width: 200px;" type="text" name="txt_direccion-empresa<?php echo $NumWindow; ?>"
                                            id="txt_direccion-empresa<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;"> Teléfono ó Celular
                                    </td>
                                    <td align="left" colspan="7">
                                        <input style="width: 200px;" type="text" name="txt_telefono<?php echo $NumWindow; ?>"
                                            id="txt_telefono<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;"> Departamento
                                    </td>
                                    <td align="left" colspan="7">
                                        <input style="width: 300px;" type="text" name="txt_departamento<?php echo $NumWindow; ?>"
                                            id="txt_departamento<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="left" style="vertical-align: middle;"> Cod.
                                    </td>
                                    <td style="position: relative; right: 8rem;" align="left" colspan="7">
                                        <input type="text" name="txt_cod<?php echo $NumWindow; ?>"
                                            id="txt_cod<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;"> Municipio 
                                    </td>
                                    <td align="left" colspan="7">
                                        <input style="width: 300px;" type="text" name="txt_municipio<?php echo $NumWindow; ?>"
                                            id="txt_municipio<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="left" style="vertical-align: middle;"> Cod.
                                    </td>
                                    <td style="position: relative; right: 8rem;" align="left" colspan="7">
                                        <input type="text" name="txt_cod-2<?php echo $NumWindow; ?>"
                                            id="txt_cod-2<?php echo $NumWindow; ?>" />
                                    </td>
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
                                    <td align="left" style="vertical-align: middle;">Tipo de documento permitido
                                        <select name="txt_tipo-documento<?php echo $NumWindow; ?>"
                                            id="txt_tipo-documento<?php echo $NumWindow; ?>" class="input-sm">
                                            <option value="0"></option>
                                            <option value="1">CC</option>
                                            <option value="1">CE</option>
                                            <option value="1">PA</option>
                                            <option value="1">TI</option>
                                            <option value="1">RC</option>
                                            <option value="1">AS</option>
                                            <option value="1">MB</option>
                                        </select>
                                   </td>
                                </tr>   
                                <tr> 
                                    <td align="left" style="vertical-align: middle;"> TipoDoc </td> 
                                    <td align="left" style="vertical-align: middle; position: relative; right: 5rem;">No. Documento
                                    </td> 
                                    <td align="left" style="vertical-align: middle; position: relative; right: 3.5rem;">Primer Nombre</td> 
                                    <td align="left" style="vertical-align: middle; position: relative; right: 2rem;">Segundo Nombre</td> 
                                    <td align="left" style="vertical-align: middle;">Primer Apellido</td> 
                                    <td align="left" style="vertical-align: middle;">Segundo Apellido
                                    </td> 
                                </tr>
                                <tr>
                                    <td >
                                        <input style="width: 130px;" type="text" name="txt_tipo-doc<?php echo $NumWindow; ?>"
                                            id="txt_tipo-doc<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td  style="position: relative; right: 5.5rem;">
                                        <input style="width: 170px;" type="text" name="txt_No-doc<?php echo $NumWindow; ?>"
                                            id="txt_No-doc<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 4rem;">
                                        <input style="width: 170px;" type="text" name="txt_primer-nombre<?php echo $NumWindow; ?>"
                                            id="txt_primer-nombre<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 2.5rem;">
                                        <input style="width: 170px;" type="text" name="txt_segundo-nombre<?php echo $NumWindow; ?>"
                                            id="txt_segundo-nombre<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 1rem;">
                                        <input style="width: 170px;" type="text" name="txt_primer-apellido<?php echo $NumWindow; ?>"
                                            id="txt_primer-apellido<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td >
                                        <input style="width: 170px;" type="text" name="txt_segundo-apellido<?php echo $NumWindow; ?>"
                                            id="txt_segundo-apellido<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>                                                                                                                        
                                <tr>
                                    <td >
                                        <input style="width: 130px;" type="text" name="txt_tipo-doc<?php echo $NumWindow; ?>"
                                            id="txt_tipo-doc<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td  style="position: relative; right: 5.5rem;">
                                        <input style="width: 170px;" type="text" name="txt_No-doc<?php echo $NumWindow; ?>"
                                            id="txt_No-doc<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 4rem;">
                                        <input style="width: 170px;" type="text" name="txt_primer-nombre<?php echo $NumWindow; ?>"
                                            id="txt_primer-nombre<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 2.5rem;">
                                        <input style="width: 170px;" type="text" name="txt_segundo-nombre<?php echo $NumWindow; ?>"
                                            id="txt_segundo-nombre<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 1rem;">
                                        <input style="width: 170px;" type="text" name="txt_primer-apellido<?php echo $NumWindow; ?>"
                                            id="txt_primer-apellido<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td >
                                        <input style="width: 170px;" type="text" name="txt_segundo-apellido<?php echo $NumWindow; ?>"
                                            id="txt_segundo-apellido<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>                                                                                                                        
                                <tr>
                                    <td >
                                        <input style="width: 130px;" type="text" name="txt_tipo-doc<?php echo $NumWindow; ?>"
                                            id="txt_tipo-doc<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td  style="position: relative; right: 5.5rem;">
                                        <input style="width: 170px;" type="text" name="txt_No-doc<?php echo $NumWindow; ?>"
                                            id="txt_No-doc<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 4rem;">
                                        <input style="width: 170px;" type="text" name="txt_primer-nombre<?php echo $NumWindow; ?>"
                                            id="txt_primer-nombre<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 2.5rem;">
                                        <input style="width: 170px;" type="text" name="txt_segundo-nombre<?php echo $NumWindow; ?>"
                                            id="txt_segundo-nombre<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 1rem;">
                                        <input style="width: 170px;" type="text" name="txt_primer-apellido<?php echo $NumWindow; ?>"
                                            id="txt_primer-apellido<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td >
                                        <input style="width: 170px;" type="text" name="txt_segundo-apellido<?php echo $NumWindow; ?>"
                                            id="txt_segundo-apellido<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>                                                                                                                        
                                <tr>
                                    <td >
                                        <input style="width: 130px;" type="text" name="txt_tipo-doc<?php echo $NumWindow; ?>"
                                            id="txt_tipo-doc<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td  style="position: relative; right: 5.5rem;">
                                        <input style="width: 170px;" type="text" name="txt_No-doc<?php echo $NumWindow; ?>"
                                            id="txt_No-doc<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 4rem;">
                                        <input style="width: 170px;" type="text" name="txt_primer-nombre<?php echo $NumWindow; ?>"
                                            id="txt_primer-nombre<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 2.5rem;">
                                        <input style="width: 170px;" type="text" name="txt_segundo-nombre<?php echo $NumWindow; ?>"
                                            id="txt_segundo-nombre<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 1rem;">
                                        <input style="width: 170px;" type="text" name="txt_primer-apellido<?php echo $NumWindow; ?>"
                                            id="txt_primer-apellido<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td >
                                        <input style="width: 170px;" type="text" name="txt_segundo-apellido<?php echo $NumWindow; ?>"
                                            id="txt_segundo-apellido<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>                                                                                                                        
                                <tr>
                                    <td >
                                        <input style="width: 130px;" type="text" name="txt_tipo-doc<?php echo $NumWindow; ?>"
                                            id="txt_tipo-doc<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td  style="position: relative; right: 5.5rem;">
                                        <input style="width: 170px;" type="text" name="txt_No-doc<?php echo $NumWindow; ?>"
                                            id="txt_No-doc<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 4rem;">
                                        <input style="width: 170px;" type="text" name="txt_primer-nombre<?php echo $NumWindow; ?>"
                                            id="txt_primer-nombre<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 2.5rem;">
                                        <input style="width: 170px;" type="text" name="txt_segundo-nombre<?php echo $NumWindow; ?>"
                                            id="txt_segundo-nombre<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td style="position: relative; right: 1rem;">
                                        <input style="width: 170px;" type="text" name="txt_primer-apellido<?php echo $NumWindow; ?>"
                                            id="txt_primer-apellido<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td >
                                        <input style="width: 170px;" type="text" name="txt_segundo-apellido<?php echo $NumWindow; ?>"
                                            id="txt_segundo-apellido<?php echo $NumWindow; ?>" />
                                    </td>
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
                                    <td align="left" style="vertical-align: middle;">Direccion 
                                    </td>
                                    <td align="left" colspan="7">
                                        <input style="width: 500px;" type="text" name="txt_direccion<?php echo $NumWindow; ?>"
                                            id="txt_direccion<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Departamento 
                                    </td>
                                    <td align="left" colspan="7">
                                        <input style="width: 500px;" type="text" name="txt_departamento-victima<?php echo $NumWindow; ?>"
                                            id="txt_departamento-victima<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="left" style="vertical-align: middle;">Cod.
                                    </td>
                                    <td align="left" colspan="7">
                                        <input type="text" name="txt_cod-victima<?php echo $NumWindow; ?>"
                                            id="txt_cod-victima<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="left" style="vertical-align: middle;">zona</td>
                                    <td>
                                        <select name="txt_zona<?php echo $NumWindow; ?>"
                                            id="txt_zona<?php echo $NumWindow; ?>" class="input-sm">
                                            <option value="0"></option>
                                            <option value="1">U</option>
                                            <option value="1">R</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Municipio 
                                    </td>
                                    <td align="left" colspan="7">
                                        <input style="width: 500px;" type="text" name="txt_municipio-victima<?php echo $NumWindow; ?>"
                                            id="txt_municipio-victima<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="left" style="vertical-align: middle;">Cod.
                                    </td>
                                    <td align="left" colspan="7">
                                        <input type="text" name="txt_cod-victima-2<?php echo $NumWindow; ?>"
                                            id="txt_cod-victima-2<?php echo $NumWindow; ?>" />
                                    </td>
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
                                    <td colspan="4">
                                        <p>
                                            La Institución Prestadora de Servicios de Salud certifica que la entidad de
                                             Transporte Especial o Persona Natural efectuó el traslado de la víctima a esta IPS
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                        <td align="left">Fecha de egreso
                                            <input type="date"
                                                name="txt_fecha-egreso<?php echo $NumWindow; ?>"
                                                id="txt_fecha-egreso<?php echo $NumWindow; ?>" value="" min="" max="" />
                                        </td>
                                        <td align="left" style="position: relative; right: 6rem;">a las
                                            <input  type="time"
                                                name="txt_hora-egreso<?php echo $NumWindow; ?>"
                                                id="<txt_hora-egreso></txt_hora-remision><?php echo $NumWindow; ?>" />
                                        </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Nombre IPS que atendió la víctima
                                    </td>
                                    <td align="left" colspan="7">
                                        <input style="width: 500px; position: relative; right: 10rem;" type="text" name="txt_ips-victima<?php echo $NumWindow; ?>"
                                            id="txt_ips-victima<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Nit 
                                    </td>
                                    <td align="left" >
                                        <input style="width: 200px; position: relative; right: 10rem;" type="text" name="txt_nit<?php echo $NumWindow; ?>"
                                            id="txt_nit<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="left" style="vertical-align: middle;">Código Habilitación:
 
                                    </td>
                                    <td align="left" >
                                        <input style="width: 200px;" type="text" name="txt_codigo-habilitacion<?php echo $NumWindow; ?>"
                                            id="txt_codigo-habilitacion<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Dirección
                                    </td>
                                    <td align="left" colspan="7">
                                        <input style="width: 500px; position: relative; right: 10rem;" type="text" name="txt_direccion-victima<?php echo $NumWindow; ?>"
                                            id="txt_direccion-victima<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Departamento 
                                    </td>
                                    <td align="left">
                                        <input style="position: relative; right: 4rem;" type="text" name="txt_departamento-victima<?php echo $NumWindow; ?>"
                                            id="txt_departamento-victima<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="left" style="vertical-align: middle; position: relative; right: 6rem;">Cod.
                                    </td>
                                    <td align="left">
                                        <input style="position: relative; right: 9rem;" type="text" name="txt_cod-victima-2<?php echo $NumWindow; ?>"
                                            id="txt_cod-victima-2<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="left" style="vertical-align: middle; position: relative; right: 7rem;">Telefono
                                    </td>
                                    <td align="left"> 
                                        <input  style="position: relative; right: 7rem;" type="text" name="txt_telefono-victima<?php echo $NumWindow; ?>"
                                            id="txt_telefono-victima<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="vertical-align: middle;">Municipio 
                                    </td>
                                    <td align="left">
                                        <input type="text" name="txt_departamento-victima-2<?php echo $NumWindow; ?>"
                                            id="txt_departamento-victima-2<?php echo $NumWindow; ?>" />
                                    </td>
                                    <td align="left" style="vertical-align: middle;">Cod.
                                    </td>
                                    <td align="left">
                                        <input style="position: relative; right: 3rem;" type="text" name="txt_cod-victima-2<?php echo $NumWindow; ?>"
                                            id="txt_cod-victima-2<?php echo $NumWindow; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="5">
                                        <p style="font-size: 14px;">
                                            Como representante legal o Gerente de la Institución Prestadora de Serviicos de Salud, declaró la gavedad de juramento que la información contenidad en este formulario es cierta y podrá se verificada por la Compañía de Seguros, por la Dirección Genereal
                                            de Financiamiento, por el Administrador Fiduciario del Fondo de Solidaridad y Garantía FOSYGA, por la Superintendencia Nacional de Salud o la Contraloria Generalde la República de no ser así, acepto todas las consecuencias legales que produzca esta
                                            situación.Adicionalmente, manifiesto que la reclamación no ha sido presentada con anterioridad ni se ha recibido pago alguno por las sumas reclamadas. 
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="position: relative; top: 1rem;">
                                        <p>
                                            ___________________________________________________
                                        </p>
                                    </td>
                                    <td >
                                        <p style="position: relative; left: 20rem; top: 1rem;">
                                            ___________________________________________________
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <td >
                                        <p style="font-size: 13px;" >
                                            NOMBRE DEL REPRESENTANTE LEGAL O PERSONA RESPONSIBLE PARA TRAMITE DE ADMISIONES DE LA IPS
                                        </p> 
                                    </td>
                                    <td >
                                        <p style="font-size: 13px; position: relative; left: 20rem;" >
                                            FIRMA DEL REPRESENTANTE LEGAL O PERSONA RESPONSABLE PARA TRAMITE DE ADMISIONES DE LA IPS

                                        </p> 
                                    </td>
                                </tr>
                                <tr>
                                    <td style="position: relative; top: 1rem;">
                                        <p>
                                            ___________________________________________________
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <tr>
                                        <td >
                                            <p style="font-size: 13px;" >
                                                TIPO Y NUMERO DE DOCUMENTO DEL REPRESENTANTE LEGAL O PERSONA RESPONSIBLE
                                                PARA TRAMITE DE ADMISIONES DE LA IPS
                                            </p> 
                                        </td>
                                </tr>
                                <tr>
                                    <td style="position: relative; top: 1rem;">
                                        <p>
                                            ___________________________________________________
                                        </p>
                                    </td>
                                </tr>
                                <tr>
                                    <tr>
                                        <td >
                                            <p style="font-size: 13px;" >
                                                FIRMA DEL REPRESENTANTE LEGAL DE LA EMPRESA TRANSPORTADORA
                                                O DE LA PERSONA NATURAL QUE REALIZO EL TRANSPORTE
                                            </p> 
                                        </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
