  <div class="row">

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#tbanexo1<?php echo $NumWindow; ?>"aria-controls="tbfurtrans1<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">DATOS DEL PACIENTE</a></li>
            <li role="presentation"><a href="#tbanexo2<?php echo $NumWindow; ?>"aria-controls="tbfurtrans2<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">INFORMACION DE LA ATENCION</a></li>
            <li role="presentation"><a href="#tbanexo3<?php echo $NumWindow; ?>"aria-controls="tbfurtrans3<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">INFORMACION DE LA PERSONA QUE INFORMA</a></li>
        </ul>

        <form action="">
            <div id="divfurtrans<?php echo $NumWindow; ?>" class="col-md-12 tab-content">
                <div id="tbanexo1<?php echo $NumWindow; ?>" class="row tab-pane fade" role="tabpanel">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered">
                                <tbody>
                                   <tr>
                                    <td>
                                        <span>1er Apellido</span>
                                        <input
                                          type="text"
                                          name="txt_1apellido-paciente<?php echo $NumWindow; ?>"
                                          id="txt_1apellido-paciente<?php echo $NumWindow; ?>"
                                          class="form-control"
                                        />
                                      </td>
                                      <td>
                                        <span>2do. Apellido</span>
                                        <input
                                          type="text"
                                          name="txt_2apellido-paciente<?php echo $NumWindow; ?>"
                                          id="txt_2apellido-paciente<?php echo $NumWindow; ?>"
                                          class="form-control"
                                        />
                                      </td>
                                      <td>
                                        <span>Tipo Documento de Identificacion</span>
                                        <select name="txt_tdocumento-paciente<?php echo $NumWindow; ?>" id="txt_tdocumento-paciente<?php echo $NumWindow; ?>" class="form-control">
                                          <option hidden select>Seleccionar</option>
                                          <option value="">Registro Civil</option>
                                          <option value="">Pasaporte</option>
                                          <option value="">Tarjeta de identidad</option>
                                          <option value="">Adulto sin identificación</option>
                                          <option value="">Cédula de ciudadanía</option>
                                          <option value="">Menor sin identificación</option>
                                          <option value="">Cédula de extranjería</option>
                                        </select>
                                      </td>
                                      <td>
                                        <span>número documento de identificacion</span>
                                        <input
                                          type="text"
                                          name="txt_ndocumento-paciente<?php echo $NumWindow; ?>"
                                          id="txt_ndocumento-paciente<?php echo $NumWindow; ?>"
                                          class="form-control"
                                        />
                                      </td>
                                    </tr>
                                   <tr>
                                    <td>
                                        <span>1er Nombre</span>
                                        <input
                                          type="text"
                                          name="txt_1nombre-paciente<?php echo $NumWindow; ?>"
                                          id="txt_1nombre-paciente<?php echo $NumWindow; ?>"
                                          class="form-control"
                                        />
                                      </td>
                                      <td>
                                        <span>2do Nombre</span>
                                        <input
                                          type="text"
                                          name="txt_2nombre-paciente<?php echo $NumWindow; ?>"
                                          id="txt_nombre-paciente?php echo $NumWindow; ?>"
                                          class="form-control"
                                        />
                                      </td>
                                      <td>
                                        <span>Cobertura en salud</span>
                                        <select name="txt_cobertura-salud<?php echo $NumWindow; ?>" id="txt_cobertura-salud<?php echo $NumWindow; ?>" class="form-control">
                                          <option hidden select>Seleccionar</option>
                                          <option value="">egimen Contributivo </option>
                                          <option value="">Regimen Subsidiado - parcial</option>
                                          <option value="">Población Pobre no asegurada sin SISBEN</option>
                                          <option value="">Plan adicional de salud</option>
                                          <option value="">Regimen Subsidiado - tota</option>
                                          <option value="">Población pobre No asegurada con SISBEN</option>
                                          <option value="">Desplazado</option>
                                          <option value="">Otro</option>
                                        </select>
                                      </td>
                                      <td>
                                        <span>Fecha Radicación</span>
                                        <input
                                              type="date"
                                              name="txt_fecha-radicacion<?php echo $NumWindow; ?>"
                                              id="txt_fecha-radicacion<?php echo $NumWindow; ?>"
                                              value=""
                                              min=""
                                              max=""
                                              class="form-control"
                                            />
                                      </td>
                                    </tr>
                                    <tr class="col-12">
                                          <td>
                                            <span>Departamento</span>
                                              <select
                                                name="txt_departamento-paciente<?php echo $NumWindow; ?>"
                                                id="txt_departamento-paciente<?php echo $NumWindow; ?>"
                                                class="form-control"
                                              >
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Atlantico</option>
                                                <option value="">Cundinamarca</option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </td>
                                          <td>
                                            <span>Municipio:</span>
                                              <select
                                                name="txt_municipio-paciente<?php echo $NumWindow; ?>"
                                                id="txt_municipio-paciente<?php echo $NumWindow; ?>"
                                                class="form-control"
                                              >
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Atlantico</option>
                                                <option value="">Cundinamarca</option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </td>
                                        <td colspan="2">
                                            <span>Dirección de Residencia Habitual:</span>
                                            <div style="display: flex">
                                              <input
                                                type="text"
                                                name="txt_direccion-paciente<?php echo $NumWindow; ?>"
                                                id="txt_direccion-paciente<?php echo $NumWindow; ?>"
                                                class="form-control"
                                                placeholder="Direccion"
                                              />
                                              <input
                                                type="text"
                                                name="txt_telefono-paciente<?php echo $NumWindow; ?>"
                                                id="txt_telefono-paciente<?php echo $NumWindow; ?>"
                                                class="form-control"
                                                placeholder="Teléfono:"
                                              />
                                            </div>
                                          </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="tbanexo2<?php echo $NumWindow; ?>" class="row tab-pane fade" role="tabpanel">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered">
                                <tbody>
                                   <tr>
                                    <td colspan="2">
                                        <span>Origen de la atención</span>
                                          <select
                                            name="txt_origen-atencion<?php echo $NumWindow; ?>"
                                            id="txt_origen-atencion<?php echo $NumWindow; ?>"
                                            class="form-control"
                                          >
                                            <option hidden select>Seleccionar</option>
                                            <option value="">Enfermedad General</option>
                                            <option value="">Accidente de trabajo</option>
                                            <option value=""> Evento Catastrófico</option>
                                            <option value="">Enfermedad Profesional</option>
                                            <option value="">Accidente de tránsito </option>
                                        </select>
                                    </td>
                                    <td colspan="2">
                                        <span>Clasificación Triage</span>
                                          <select
                                            name="txt_clasificacion-triage<?php echo $NumWindow; ?>"
                                            id="txt_clasificacion-triage<?php echo $NumWindow; ?>"
                                            class="form-control"
                                          >
                                            <option hidden select>Seleccionar</option>
                                            <option value="">1. Rojo</option>
                                            <option value="">2. Amarillo</option>
                                            <option value="">3. Verde</option>
                                        </select>
                                    </td>
                                    </tr>
                                    <tr>
                                        <td colspan="12">
                                          <span
                                            >Ingreso a Urgencias</span
                                          >
                                        </td>
                                      </tr>
                                      <tr>
                                        <td>
                                            <div style="display: flex">
                                              <div style="margin-right: 10px">
                                                <span>Fecha</span>
                                                <input
                                                  type="date"
                                                  name="txt_fecha-ingreso-urgencias<?php echo $NumWindow; ?>"
                                                  id="txt_fecha-ingreso-urgencias<?php echo $NumWindow; ?>"
                                                  value=""
                                                  min=""
                                                  max=""
                                                  class="form-control"
                                                />
                                              </div>
                                              <div>
                                                <span>Hora</span>
                                                <input
                                                  type="time"
                                                  name="txt_hora-ingreso-urgencias<?php echo $NumWindow; ?>"
                                                  id="txt_hora-ingreso-urgencias<?php echo $NumWindow; ?>"
                                                  value=""
                                                  min=""
                                                  max=""
                                                  class="form-control"
                                                />
                                              </div>
                                            </div>
                                          </td>
                                          <td>
                                            <span>Paciente Viene Remitido </span>
                                            <select
                                              name="txt_paciente-remitido<?php echo $NumWindow; ?>"
                                              id="txt_paciente-remitido<?php echo $NumWindow; ?>"
                                              class="form-control"
                                            >
                                              <option hidden select>Seleccionar</option>
                                              <option value="">Si</option>
                                              <option value="">No</option>
                                            </select>
                                          </td>
                                          <td>
                                            <span>Nombre del prestador de servicios de salud que remite</span>
                                            <div style="display: flex">
                                              <input
                                                type="text"
                                                name="txt_nombre-remitente<?php echo $NumWindow; ?>"
                                                id="txt_nombre-remitente<?php echo $NumWindow; ?>"
                                                class="form-control"
                                                placeholder="Nombre"
                                              />
                                              <input
                                                type="text"
                                                name="txt_cod-remitente<?php echo $NumWindow; ?>"
                                                id="txt_cod-remitente<?php echo $NumWindow; ?>"
                                                class="form-control"
                                                placeholder="Codigo"
                                              />
                                            </div>
                                          </td>
                                      </tr>
                                      <tr>
                                          <td colspan="2">
                                            <span>Departamento</span>
                                              <select
                                                name="txt_departamento-urgencias<?php echo $NumWindow; ?>"
                                                id="txt_departamento-urgencias<?php echo $NumWindow; ?>"
                                                class="form-control"
                                              >
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Atlantico</option>
                                                <option value="">Cundinamarca</option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </td>
                                          <td colspan="2">
                                            <span>Municipio:</span>
                                              <select
                                                name="txt_municipio-urgencias<?php echo $NumWindow; ?>"
                                                id="txt_municipio-urgencias<?php echo $NumWindow; ?>"
                                                class="form-control"
                                              >
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Atlantico</option>
                                                <option value="">Cundinamarca</option>
                                                <option value=""></option>
                                                <option value=""></option>
                                            </select>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="12">
                                          <span>Motivo de consulta:</span>
                                          <textarea
                                            placeholder="Describe yourself here..."
                                            name="txt_motivo-consulta<?php echo $NumWindow; ?>"
                                            id="txt_motivo-consulta<?php echo $NumWindow; ?>"
                                            cols="30"
                                            rows="5"
                                            class="form-control"
                                          >
                                          </textarea>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="12">
                                          <span
                                            >Impresión Diagnóstica:</span
                                          >
                                        </td>
                                      </tr>
                                      <tr>
                                        <td colspan="2">
                                            <span>Diagnóstico principal</span>
                                            <input
                                              type="text"
                                              name="txt_diagnostico-principal<?php echo $NumWindow; ?>"
                                              id="txt_diagnostico-principal<?php echo $NumWindow; ?>"
                                              class="form-control"
                                              placeholder="Codigo CIE10 "
                                            />
                                          </td>
                                        <td colspan="2">
                                            <span>Diagnóstico relacionado 1
                                            </span>
                                            <input
                                              type="text"
                                              name="txt_diagnostico-r1<?php echo $NumWindow; ?>"
                                              id="txt_diagnostico-r1<?php echo $NumWindow; ?>"
                                              class="form-control"
                                              placeholder="Codigo CIE10 "
                                            />
                                          </td>
                                      </tr>
                                      <tr>
                                        <td colspan="2">
                                            <span>Diagnóstico relacionado 2</span>
                                            <input
                                              type="text"
                                              name="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                              id="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                              class="form-control"
                                              placeholder="Codigo CIE10 "
                                            />
                                          </td>
                                        <td colspan="2">
                                            <span>Diagnóstico relacionado 3</span>
                                            <input
                                              type="text"
                                              name="txt_diagnostico-r3<?php echo $NumWindow; ?>"
                                              id="txt_diagnostico-r3<?php echo $NumWindow; ?>"
                                              class="form-control"
                                              placeholder="Codigo CIE10 "
                                            />
                                          </td>
                                      </tr>
                                      <tr>
                                        <td colspan="12">
                                            <span>Descripción</span>
                                            <textarea
                                              placeholder="Describe yourself here..."
                                              name="txt_descripcion<?php echo $NumWindow; ?>"
                                              id="txt_descripcion<?php echo $NumWindow; ?>"
                                              cols="30"
                                              rows="5"
                                              class="form-control"
                                            >
                                            </textarea>
                                          </td>
                                      </tr>
                                      <tr>
                                        <td>
                                            <span>Destino del Paciente </span>
                                              <select
                                                name="txt_destino-paciente<?php echo $NumWindow; ?>"
                                                id="txt_destino-paciente<?php echo $NumWindow; ?>"
                                                class="form-control"
                                              >
                                                <option hidden select>Seleccionar</option>
                                                <option value="">Domicilio</option>
                                                <option value="">Internación</option>
                                                <option value="">Contrarremisión</option>
                                                <option value="">Observación</option>
                                                <option value="">Remisión</option>
                                                <option value=""> Otro</option>
                                            </select>
                                        </td>
                                      </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div id="tbanexo3<?php echo $NumWindow; ?>" class="row tab-pane fade" role="tabpanel">
                    <div class="col-sm-12">
                        <div class="table-responsive">
                            <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered">
                                <tbody>
                                   <tr>
                                    <td>
                                        <span>Nombre de quien informa</span>
                                        <input
                                          type="text"
                                          name="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                          id="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                          class="form-control"
                                        />
                                      </td>
                                    <td style="width: 50%;">
                                        <span>Teléfono</span>
                                        <div style="display: flex;" >
                                        <input
                                          type="text"
                                          name="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                          id="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                          class="form-control"
                                          placeholder="indicativo"
                                        />
                                        <input
                                          type="text"
                                          name="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                          id="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                          class="form-control"
                                          placeholder="número"
                                        />
                                        <input
                                          type="text"
                                          name="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                          id="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                          class="form-control"
                                          placeholder="extensión"
                                        />
                                        </div>
                                      </td>
                                    </tr>
                                   <tr>
                                    <td>
                                        <span>Cargo o actividad:</span>
                                        <input
                                          type="text"
                                          name="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                          id="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                          class="form-control"
                                        />
                                      </td>
                                    <td>
                                        <span>Teléfono celular: </span>
                                        <input
                                          type="text"
                                          name="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                          id="txt_diagnostico-r2<?php echo $NumWindow; ?>"
                                          class="form-control"
                                        />
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