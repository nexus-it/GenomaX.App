<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Optional theme -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@3.3.7/dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>Solicitud de Autorizacion de Servicios de salud</title>
</head>
<body>
    <div class="row">

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#tbSautorizacion1<?php echo $NumWindow; ?>"aria-controls="tbSautorizacion1<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Informacion del Prestador</a>
            </li>
            <li role="presentation">
                <a href="#tbSautorizacion2<?php echo $NumWindow; ?>"aria-controls="tbSautorizacion2<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Datos del Paciente</a>
            </li>
            <li role="presentation">
                <a href="#tbSautorizacion3<?php echo $NumWindow; ?>"aria-controls="tbSautorizacion3<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Informacion de la Atencion de Servicios Solicitados</a>
            </li>
            <li role="presentation">
                <a href="#tbSautorizacion4<?php echo $NumWindow; ?>"aria-controls="tbSautorizacion4<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Informacion de la Persona que Solicita</a>
            </li>
        </ul>
        <form>
            <div id="divSautorizacion<?php echo $NumWindow; ?>" class="col-md-12 tab-content">
                <div id="tbSautorizacion1<?php echo $NumWindow; ?>" class="row tab-pane fade in active " role="tabpanel">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered">
                                <tbody>
                                    <tr class="col-12">
                                        <td class="col-6" >
                                            <span>Numero de Solicitud:</span>
                                            <input type="text" class="form-control" id="txt_NSolicitud<?php echo $NumWindow; ?>" name="txt_NSolicitud<?php echo $NumWindow; ?>">
                                        </td>
                                        <td class="col-3">
                                            <span>Fecha:</span>
                                            <input type="date" class="form-control"  id="txt_FechaSolicitud<?php echo $NumWindow; ?>" name="txt_FechaSolicitud<?php echo $NumWindow; ?>">
                                        </td>
                                        <td class="col-3">
                                            <span> Hora:</span>
                                            <input type="time" class="form-control"  id="txt_HoraSolicitud<?php echo $NumWindow; ?>" name="txt_HoraSolicitud<?php echo $NumWindow; ?>">
                                        </td>
                                        <td class="col-2">
                                            <span>Telefono:</span>
                                            <div style="display:flex;">
                                                <input type="text" placeholder="Indicativo" class="form-control"  id="txt_TelefIndSolicitud<?php echo $NumWindow; ?>" name="txt_TelefIndSolicitud<?php echo $NumWindow; ?>">
                                                <input type="text" placeholder="Numero"  class="form-control"  id="txt_TelefNumSolicitud<?php echo $NumWindow; ?>" name="txt_TelefNumSolicitud<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6">
                                            <span>Nombre:</span>
                                            <input type="text" class="form-control" id="txt_NombreSolicitud<?php echo $NumWindow; ?>" name="txt_NombreSolicitud<?php echo $NumWindow; ?>">
                                        </td>
                                        <td class="col-3">
                                            <span>Tipo de Documento</span>
                                           <div style="display:flex;" >
                                                <select  class="form-control" style="width:30%" id="txt_TipoDocSolicitud<?php echo $NumWindow; ?>" name="txt_TipoDocSolicitud<?php echo $NumWindow; ?>">
                                                    <option hidden select>Tipo</option>
                                                    <option value="nit">Nit</option>
                                                    <option value="cc">CC</option>
                                                </select>
                                                <input type="text" class="form-control" style="width:70%" id="txt_DocSolicitud<?php echo $NumWindow; ?>" name="txt_DocSolicitud<?php echo $NumWindow; ?>">
                                           </div>
                                        </td>
                                        <td class="col-3">
                                            <span>Codigo:</span>
                                            <input type="text" class="form-control" id="txt_CodigSolicitud<?php echo $NumWindow; ?>" name="txt_CodigSolicitud<?php echo $NumWindow; ?>">
                                        </td>
                                        <td>
                                            <span>Direccion Prestador:</span>
                                            <input type="text" class="form-control" id="txt_DirPresSolicitud<?php echo $NumWindow; ?>" name="txt_DirPresSolicitud<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-3">
                                            <span>Departamento:</span>
                                            <select class="form-control" id="txt_DerpaSolicitud<?php echo $NumWindow; ?>" name="txt_DerpaPresSolicitud<?php echo $NumWindow; ?>">
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Atlantico</option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </td>
                                        <td>
                                            <span>Municipio:</span>
                                            <select  class="form-control" id="txt_MunicSolicitud<?php echo $NumWindow; ?>" name="txt_MunicSolicitud<?php echo $NumWindow; ?>">
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Barranquilla</option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </td>
                                        <td class="col-3">
                                               <span>Entidad a la que se le solicita(Pagador)</span>
                                               <input type="text" class="form-control" id="txt_EntiQueSolicitud<?php echo $NumWindow; ?>" name="txt_EntiQueSolicitud<?php echo $NumWindow; ?>">
                                        </td>
                                        <td>
                                            <span>Codigo:</span>
                                            <input type="text" class="form-control" id="txt_EntiQueCoSolicitud<?php echo $NumWindow; ?>" name="txt_EntiQueCoSolicitud<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="tbSautorizacion2<?php echo $NumWindow; ?>" class="row tab-pane fade  " role="tabpanel">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            <span>1er Apellido:</span>
                                            <input type="text" class="form-control" id="txt_PAlliSautorizacion2<?php echo $NumWindow; ?>" name="txt_PAlliSautorizacion2<?php echo $NumWindow; ?>">
                                        </td>
                                        <td>
                                            <span>2do Apellido:</span>
                                            <input type="text" class="form-control" id="txt_SAlliSautorizacion2<?php echo $NumWindow; ?>" name="txt_SAlliSautorizacion2<?php echo $NumWindow; ?>">
                                        </td>
                                        <td>
                                            <span>1er Nombre:</span>
                                            <input type="text" class="form-control" id="txt_PNomSautorizacion2<?php echo $NumWindow; ?>" name="txt_PNomSautorizacion2<?php echo $NumWindow; ?>">
                                        </td>
                                        <td>
                                            <span>2do Nombre:</span>
                                            <input type="text" class="form-control" id="txt_SNomSautorizacion2<?php echo $NumWindow; ?>" name="txt_SNomSautorizacion2<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span>Tipo de Documento de Identidad:</span>
                                            <select class="form-control" id="txt_TDISautorizacion2<?php echo $NumWindow; ?>" name="txt_TDISautorizacion2<?php echo $NumWindow; ?>">
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Registro Civil</option>
                                                <option value="">Tarjeta de Identidad</option>
                                                <option value="">Cedula de Ciudadania</option>
                                                <option value="">Cedula Extranjeria</option>
                                                <option value="">Passaporte</option>
                                                <option value="">Adulto sin Identificacion</option>
                                                <option value="">Menor sin Identificacion</option>
                                            </select> 
                                        </td>
                                        <td>
                                            <span>Número documento de identificación:</span>
                                            <input type="text" class="form-control" id="txt_NDISautorizacion2<?php echo $NumWindow; ?>" name="txt_NDISautorizacion2<?php echo $NumWindow; ?>">
                                        </td>
                                        <td>
                                            <span>Fecha de Nacimiento:</span>
                                            <input type="date" class="form-control" id="txt_FDNSautorizacion2<?php echo $NumWindow; ?>" name="txt_FDNSautorizacion2<?php echo $NumWindow; ?>">
                                        </td>
                                        <td>
                                            <span>Dirección de Residencia Habitual:</span>
                                            <input type="text" class="form-control" id="txt_DREHSautorizacion2<?php echo $NumWindow; ?>" name="txt_DREHSautorizacion2<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span>Telefono:</span>
                                            <input type="text" class="form-control" placeholder=""id="txt_TelefonoSautorizacion2<?php echo $NumWindow; ?>" name="txt_TelefonoSautorizacion2<?php echo $NumWindow; ?>">
                                        </td>
                                        <td>
                                            <span>Departamento:</span>
                                            <select  class="form-control" id="txt_DeparSautorizacion2<?php echo $NumWindow; ?>" name="txt_DeparSautorizacion2<?php echo $NumWindow; ?>">
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Atlantico</option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </td>
                                        <td>
                                            <span>Municipio:</span>
                                            <select  class="form-control" id="txt_MunicSautorizacion2<?php echo $NumWindow; ?>" name="txt_MunicSautorizacion2<?php echo $NumWindow; ?>">
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Barranquilla</option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span>Telefono Celular:</span>
                                            <input type="text" class="form-control" placeholder="" id="txt_TelefCeluSautorizacion2<?php echo $NumWindow; ?>" name="txt_TelefCeluSautorizacion2<?php echo $NumWindow; ?>">
                                        </td>
                                        <td>
                                            <span>Correo Electronico:</span>
                                            <input type="email" class="form-control" placeholder="Correo Electronico" id="txt_CorreoESautorizacion2<?php echo $NumWindow; ?>" name="txt_CorreoESautorizacion2<?php echo $NumWindow; ?>">
                                        </td>
                                        <td>
                                            <span>Cobertura en Salud:</span>
                                            <select   class="form-control" id="txt_CoberSSautorizacion2<?php echo $NumWindow; ?>" name="txt_CoberSSautorizacion2<?php echo $NumWindow; ?>">
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Regimen Contributivo</option>
                                                <option value="">Regimen Subsidiado-Parcial</option>
                                                <option value="">Regimen Subsidiado-Total</option>
                                                <option value="">Poblacion pobre Con Seguridad por Sisben</option>
                                                <option value="">Poblacion pobre Sin Seguridad por Sisbe</option>
                                                <option value="">Desplazados</option>
                                                <option value="">Plan Adicional en Salud</option>
                                                <option value="">Otros</option>
                                            </select>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="tbSautorizacion3<?php echo $NumWindow; ?>" class="row tab-pane fade  " role="tabpanel">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered">
                                <tbody>
                                    <tr>
                                        <td>
                                            Origen de la Atencion:
                                            <select class="form-control" id="txt_ODASautorizacion3<?php echo $NumWindow; ?>" name="txt_ODASautorizacion3<?php echo $NumWindow; ?>">
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Enfermedad General</option>
                                                <option value="">Enfermedad Profesional</option>
                                                <option value="">Accidente de Trabajo</option>
                                                <option value="">Accidente de Transito</option>
                                                <option value="">Evento Catastrofico</option>
                                            </select> 
                                        </td>
                                        <td>
                                            Tipos de Servicios Solicitados:
                                            <select class="form-control" id="txt_TSSSautorizacion3<?php echo $NumWindow; ?>" name="txt_TSSSautorizacion3<?php echo $NumWindow; ?>">
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Posterio a la atencion Inicial de Urgencias</option>
                                                <option value="">Servicios Electivos</option>
                                            </select>
                                        </td>
                                        <td>
                                            Prioridad de la Atencion:
                                            <select class="form-control"  id="txt_PASautorizacion3<?php echo $NumWindow; ?>" name="txt_PASautorizacion3<?php echo $NumWindow; ?>">
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Prioritaria</option>
                                                <option value="">No Prioritaria</option>
                                            </select> 
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Ubicacion del Paciente al Momento de la Solicitud de Autorizacion:
                                            <select  class="form-control"  id="txt_UPMSautorizacion3<?php echo $NumWindow; ?>" name="txt_UPMSautorizacion3<?php echo $NumWindow; ?>">
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Consulta Externa</option>
                                                <option value="">Urgencias</option>
                                                <option value="">Hospitalizacion</option>
                                            </select> 
                                        </td>
                                        <td>
                                            Servicio:
                                            <input type="text" class="form-control"  id="txt_SERVICSautorizacion3<?php echo $NumWindow; ?>" name="txt_SERVICSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                        <td>
                                            Cama:
                                            <input type="text" class="form-control" id="txt_CAMASautorizacion3<?php echo $NumWindow; ?>" name="txt_CAMASautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td colspan="12">
                                            Manejo Integral Segun Guia de:
                                            <input type="text" class="form-control"  id="txt_MISSautorizacion3<?php echo $NumWindow; ?>" name="txt_MISSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"  id="txt_1CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_1CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"  id="txt_1CSautorizacion3<?php echo $NumWindow; ?>" name="txt_1CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"  id="txt_1DSautorizacion3<?php echo $NumWindow; ?>" name="txt_1DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"  id="txt_2CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_2CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"  id="txt_2CSautorizacion3<?php echo $NumWindow; ?>" name="txt_2CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"  id="txt_2DSautorizacion3<?php echo $NumWindow; ?>" name="txt_2DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"  id="txt_3CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_3CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"  id="txt_3CSautorizacion3<?php echo $NumWindow; ?>" name="txt_3CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"  id="txt_3DSautorizacion3<?php echo $NumWindow; ?>" name="txt_3DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"  id="txt_4CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_4CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"  id="txt_4CSautorizacion3<?php echo $NumWindow; ?>" name="txt_4CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"  id="txt_4DSautorizacion3<?php echo $NumWindow; ?>" name="txt_4DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control" id="txt_5CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_5CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control" id="txt_5CSautorizacion3<?php echo $NumWindow; ?>" name="txt_5CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control" id="txt_5DSautorizacion3<?php echo $NumWindow; ?>" name="txt_5DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control" id="txt_6CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_6CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_6CSautorizacion3<?php echo $NumWindow; ?>" name="txt_6CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_6DSautorizacion3<?php echo $NumWindow; ?>" name="txt_6DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_7CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_7CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_7CSautorizacion3<?php echo $NumWindow; ?>" name="txt_7CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_7DSautorizacion3<?php echo $NumWindow; ?>" name="txt_7DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_8CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_8CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_6CSautorizacion3<?php echo $NumWindow; ?>" name="txt_8CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_8DSautorizacion3<?php echo $NumWindow; ?>" name="txt_8DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_9CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_9CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_9CSautorizacion3<?php echo $NumWindow; ?>" name="txt_9CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_9DSautorizacion3<?php echo $NumWindow; ?>" name="txt_9DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_10CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_10CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_10CSautorizacion3<?php echo $NumWindow; ?>" name="txt_10CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_10DSautorizacion3<?php echo $NumWindow; ?>" name="txt_10DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_11CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_11CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_11CSautorizacion3<?php echo $NumWindow; ?>" name="txt_11CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_11DSautorizacion3<?php echo $NumWindow; ?>" name="txt_11DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_12CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_12CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_12CSautorizacion3<?php echo $NumWindow; ?>" name="txt_12CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_12DSautorizacion3<?php echo $NumWindow; ?>" name="txt_12DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_13CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_14CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_13CSautorizacion3<?php echo $NumWindow; ?>" name="txt_13CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_13DSautorizacion3<?php echo $NumWindow; ?>" name="txt_13DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_14CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_14CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_14CSautorizacion3<?php echo $NumWindow; ?>" name="txt_14CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_14DSautorizacion3<?php echo $NumWindow; ?>" name="txt_14DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_15CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_15CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_15CSautorizacion3<?php echo $NumWindow; ?>" name="txt_15CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_15DSautorizacion3<?php echo $NumWindow; ?>" name="txt_15DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_16CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_16CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_16CSautorizacion3<?php echo $NumWindow; ?>" name="txt_16CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_16DSautorizacion3<?php echo $NumWindow; ?>" name="txt_16DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_17CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_17CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_17CSautorizacion3<?php echo $NumWindow; ?>" name="txt_17CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_17DSautorizacion3<?php echo $NumWindow; ?>" name="txt_17DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_18CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_18CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_18CSautorizacion3<?php echo $NumWindow; ?>" name="txt_18CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_18DSautorizacion3<?php echo $NumWindow; ?>" name="txt_18DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_19CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_19CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_19CSautorizacion3<?php echo $NumWindow; ?>" name="txt_19CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_19DSautorizacion3<?php echo $NumWindow; ?>" name="txt_19DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Codigo Cups
                                                <input type="text" class="form-control"id="txt_20CCSautorizacion3<?php echo $NumWindow; ?>" name="txt_20CCSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                Cantidad
                                                <input type="number" class="form-control"id="txt_20CSautorizacion3<?php echo $NumWindow; ?>" name="txt_20CSautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_20DSautorizacion3<?php echo $NumWindow; ?>" name="txt_20DSautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="12">
                                        <td colspan="12">
                                            Justificación Clínica:
                                            <textarea name="" id="" cols="30" rows="5" class="form-control" id="txt_JCSautorizacion3<?php echo $NumWindow; ?>" name="txt_JCSautorizacion3<?php echo $NumWindow; ?>"></textarea>
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Impresión Diagnóstica:
                                                <select  class="form-control" id="txt_ID1Sautorizacion3<?php echo $NumWindow; ?>" name="txt_ID1Sautorizacion3<?php echo $NumWindow; ?>">
                                                    <option hidden select>Seleccionar</option>
                                                    <option value="">Diagnostico Principal</option>
                                                    <option value="">Diagnóstico Relacionado 1</option>
                                                    <option value="">Diagnóstico Relacionado 2</option>
                                                </select>
                                            </div>
                                            <div>
                                                Codigo CIE10
                                                <input type="text" class="form-control"id="txt_CID1Sautorizacion3<?php echo $NumWindow; ?>" name="txt_CID1Sautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_DID1Sautorizacion3<?php echo $NumWindow; ?>" name="txt_DID1Sautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Impresión Diagnóstica:
                                                <select name="" id="" class="form-control"id="txt_ID2Sautorizacion3<?php echo $NumWindow; ?>" name="txt_ID2Sautorizacion3<?php echo $NumWindow; ?>">
                                                    <option hidden select>Seleccionar</option>
                                                    <option value="">Diagnostico Principal</option>
                                                    <option value="">Diagnóstico Relacionado 1</option>
                                                    <option value="">Diagnóstico Relacionado 2</option>
                                                </select>
                                            </div>
                                            <div>
                                                Codigo CIE10
                                                <input type="text" class="form-control"id="txt_CID2Sautorizacion3<?php echo $NumWindow; ?>" name="txt_CID2Sautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_DID2Sautorizacion3<?php echo $NumWindow; ?>" name="txt_DID2Sautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                    <tr class="col-12">
                                        <td class="col-6" style="display:flex ;">
                                            <div>
                                                Impresión Diagnóstica:
                                                <select name="" id="" class="form-control"id="txt_ID3Sautorizacion3<?php echo $NumWindow; ?>" name="txt_ID3Sautorizacion3<?php echo $NumWindow; ?>">
                                                    <option hidden select>Seleccionar</option>
                                                    <option value="">Diagnóstico principal</option>
                                                    <option value="">Diagnóstico Relacionado 1</option>
                                                    <option value="">Diagnóstico Relacionado 2</option>
                                                </select>
                                            </div>
                                            <div>
                                                Codigo CIE10
                                                <input type="text" class="form-control"id="txt_CID3Sautorizacion3<?php echo $NumWindow; ?>" name="txt_CID3Sautorizacion3<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td colspan="6">
                                            Descripcion
                                            <input type="text" class="form-control"id="txt_DID3Sautorizacion3<?php echo $NumWindow; ?>" name="txt_DID3Sautorizacion3<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div id="tbSautorizacion4<?php echo $NumWindow; ?>" class="row tab-pane fade  " role="tabpanel">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered">
                                <tbody>
                                    <tr class="col-12">
                                        <td class="col-6">
                                            <div>
                                                <span>Nombre de que solicita:</span>
                                                <input type="text" class="form-control"id="txt_NSSautorizacion4<?php echo $NumWindow; ?>" name="txt_NSSautorizacion4<?php echo $NumWindow; ?>">
                                            </div>
                                            <div>
                                                <span>Cargo o actividad:</span>
                                                <input type="text" class="form-control" id="txt_CASautorizacion4<?php echo $NumWindow; ?>" name="txt_CASautorizacion4<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td  colspan="4" >
                                            <span>Telefono:</span>
                                            <div >
                                                <input type="text" class="form-control" placeholder="Indicativo" id="txt_TISautorizacion4<?php echo $NumWindow; ?>" name="txt_TISautorizacion4<?php echo $NumWindow; ?>">
                                                <input type="text" class="form-control" placeholder="Numero"id="txt_TNSautorizacion4<?php echo $NumWindow; ?>" name="txt_TNSautorizacion4<?php echo $NumWindow; ?>">
                                                <input type="text" class="form-control" placeholder="Extension"id="txt_TESautorizacion4<?php echo $NumWindow; ?>" name="txt_TESautorizacion4<?php echo $NumWindow; ?>">
                                            </div>
                                        </td>
                                        <td class="col-2">
                                            <span>Teléfono celular:</span>
                                            <input type="text" class="form-control" placeholder="Numero"id="txt_CNUSautorizacion4<?php echo $NumWindow; ?>" name="txt_CNUSautorizacion4<?php echo $NumWindow; ?>">
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
    
            </div>
        </form>
    </div>

    <script>
        $("input[type=text]").addClass("form-control");
        $("input[type=password]").addClass("form-control");
        $("textarea").addClass("form-control");
        $("select").addClass("form-control");
        $("input[type=date]").addClass("form-control");
        $("input[type=number]").addClass("form-control");
        $("input[type=time]").addClass("form-control");
    </script>
    

</body>
</html>