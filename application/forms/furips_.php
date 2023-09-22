<div class="row">
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active">
      <a
        href="#tbfurips1<?php echo $NumWindow; ?>"
        aria-controls="tbfurips1<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
        >PERSONAS JURIDICAS - FURIPS</a
      >
    </li>
    <li role="presentation">
      <a
        href="#tbfurips2<?php echo $NumWindow; ?>"
        aria-controls="tbfurips2<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
      >
        DATOS DE LA INSTITUCIÓN PRESTADORA DE SERVICIOS DE SALUD</a
      >
    </li>
    <li role="presentation">
      <a
        href="#tbfurips3<?php echo $NumWindow; ?>"
        aria-controls="tbfurips3<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
        >Datos del Vehículo</a
      >
    </li>
    <li role="presentation">
      <a
        href="#tbfurips4<?php echo $NumWindow; ?>"
        aria-controls="tbfurips4<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
        >Datos del Propietario</a
      >
    </li>
    <li role="presentation">
      <a
        href="#tbfurips5<?php echo $NumWindow; ?>"
        aria-controls="tbfurips5<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
        >Datos del conductor Involucrado</a
      >
    </li>
    <li role="presentation">
      <a
        href="#tbfurips6<?php echo $NumWindow; ?>"
        aria-controls="tbfurips6<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
        >Datos de Remision</a
      >
    </li>
    <li role="presentation">
      <a
        href="#tbfurips7<?php echo $NumWindow; ?>"
        aria-controls="tbfurips7<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
        >Amparo de Transporte</a
      >
    </li>
    <li role="presentation">
      <a
        href="#tbfurips8<?php echo $NumWindow; ?>"
        aria-controls="tbfurips8<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
        >Certificado de la Atencion</a
      >
    </li>
    <li role="presentation">
      <a
        href="#tbfurips9<?php echo $NumWindow; ?>"
        aria-controls="tbfurips9<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
        >Amparos que Reclaman</a
      >
    </li>
    <li role="presentation">
      <a
        href="#tbfurips10<?php echo $NumWindow; ?>"
        aria-controls="tbfurips9<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
        >...</a
      >
    </li>
    <li role="presentation">
      <a
        href="#tbfurips11<?php echo $NumWindow; ?>"
        aria-controls="tbfurips9<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
        >...</a
      >
    </li>
    <li role="presentation">
      <a
        href="#tbfurips12<?php echo $NumWindow; ?>"
        aria-controls="tbfurips9<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
        >...</a
      >
    </li>
    <li role="presentation">
      <a
        href="#tbfurips13<?php echo $NumWindow; ?>"
        aria-controls="tbfurips9<?php echo $NumWindow; ?>"
        role="tab"
        data-toggle="tab"
        >...</a
      >
    </li>
  </ul>

  <form action="">
    <div id="divfurips<?php echo $NumWindow; ?>" class="col-md-12 tab-content">
      <div
        id="tbfurips1<?php echo $NumWindow; ?>"
        class="row tab-pane fade row in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <td>
                  <div>
                    <div>
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
                    </div>
                  </div>
                </td>
                <td>
                  <div style="display: flex">
                    <div style="margin-right: 10px">
                      <span>No. Radicado </span>
                      <textarea
                        style="min-width: 320px"
                        name="txt_no-radicado<?php echo $NumWindow; ?>"
                        id="txt_no-radicado<?php echo $NumWindow; ?>"
                        cols="4"
                        rows="2"
                        class="form-control"
                      >
                      </textarea>
                    </div>
                    <div>
                      <span>RG</span>
                      <input
                        class="form-control"
                        type="checkbox"
                        name="txt_RG<?php echo $NumWindow; ?>"
                        id="txt_RG<?php echo $NumWindow; ?>"
                        value=""
                      />
                    </div>
                  </div>
                </td>
                <td>
                  <span
                    >No. Radicado Anterior (Respuesta a glosa, marcar x en
                    RG)</span
                  >
                  <textarea
                    style="min-width: 320px"
                    name="txt_radicado-anterior<?php echo $NumWindow; ?>"
                    id="txt_radicado-anterior<?php echo $NumWindow; ?>"
                    cols="4"
                    rows="2"
                    class="form-control"
                  >
                  </textarea>
                </td>
                <td>
                  <span>Nro Factura / Cuenta de cobro</span>
                  <textarea
                    style="min-width: 320px"
                    name="txt_factura-cuentacobro<?php echo $NumWindow; ?>"
                    id="txt_factura-cuentacobro<?php echo $NumWindow; ?>"
                    cols="4"
                    rows="2"
                    class="form-control"
                  >
                  </textarea>
                </td>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div
        id="tbfurips2<?php echo $NumWindow; ?>"
        class="row tab-pane fade row in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <tr>
                  <td>
                    <span>Razón Social</span>
                    <input
                      type="text"
                      name="txt_razon-social<?php echo $NumWindow; ?>"
                      id="txt_razon-social<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Código Habilitación: </span>
                    <input
                      type="text"
                      name="txt_co-habilitacion<?php echo $NumWindow; ?>"
                      id="txt_co-habilitacion<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Departamento</span>
                    <div style="display: flex">
                      <select
                        name="txt_departamento-salud<?php echo $NumWindow; ?>"
                        id="txt_departamento-salud<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod-salud<?php echo $NumWindow; ?>"
                        id="txt_cod-salud<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                      <input
                        type="text"
                        name="txt_telefono-salud<?php echo $NumWindow; ?>"
                        id="txt_telefono-salud<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Telefono"
                      />
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>Nit</span>
                    <input
                      type="text"
                      name="txt_nit-salud<?php echo $NumWindow; ?>"
                      id="txt_nit-salud<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Dirección:</span>
                    <input
                      type="text"
                      name="txt_direccion-salud<?php echo $NumWindow; ?>"
                      id="txt_direccion-salud<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Municipio</span>
                    <div style="display: flex">
                      <select
                        name="txt_municipio-salud<?php echo $NumWindow; ?>"
                        id="txt_municipio-salud<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod-salud2<?php echo $NumWindow; ?>"
                        id="txt_cod-salud2<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div
        id="tbfurips3<?php echo $NumWindow; ?>"
        class="row tab-pane fade row in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <tr>
                  <td>
                    <span>1er Apellido</span>
                    <input
                      type="text"
                      name="txt_1apellido-victima<?php echo $NumWindow; ?>"
                      id="txt_1apellido-victima<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>2do. Apellido</span>
                    <input
                      type="text"
                      name="txt_2apellido-victima<?php echo $NumWindow; ?>"
                      id="txt_2apellido-victima<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Tipo de Documento </span>
                    <select name="txt_tdocumento-victima<?php echo $NumWindow; ?>" id="txt_tdocumento-victima<?php echo $NumWindow; ?>" class="form-control">
                      <option hidden select>Seleccionar</option>
                      <option value="">CC</option>
                      <option value="">CE</option>
                      <option value="">PA</option>
                      <option value="">TI</option>
                      <option value="">RC</option>
                      <option value="">AS</option>
                      <option value="">MS</option>
                    </select>
                  </td>
                  <td>
                    <span>No. Documento</span>
                    <input
                      type="text"
                      name="txt_no-documento-victima<?php echo $NumWindow; ?>"
                      id="txt_no-documento-victima<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>1er Nombre</span>
                    <input
                      type="text"
                      name="txt_1nombre-victima<?php echo $NumWindow; ?>"
                      id="txt_1nombre-victima<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>2do. Nombre</span>
                    <input
                      type="text"
                      name="txt_2nombre-victima<?php echo $NumWindow; ?>"
                      id="txt_2nombre-victima<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Fecha de Nacimiento</span>
                    <input
                      type="date"
                      name="txt_fecha-victima<?php echo $NumWindow; ?>"
                      id="txt_fecha-victima<?php echo $NumWindow; ?>"
                      value=""
                      min=""
                      max=""
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Sexo </span>
                    <select
                      name="txt_sexo-victima<?php echo $NumWindow; ?>"
                      id="txt_sexo-victima<?php echo $NumWindow; ?>"
                      class="form-control"
                    >
                      <option hidden select>Seleccionar</option>
                      <option value="1">F</option>
                      <option value="1">M</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>Dirección Residencia</span>
                    <input
                      type="text"
                      name="txt_direccion-residencia<?php echo $NumWindow; ?>"
                      id="txt_direccion-residencia<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td style="width: 360px">
                    <span>Departamento</span>
                    <div style="display: flex">
                      <select
                        name="txt_departamento-victima<?php echo $NumWindow; ?>"
                        id="txt_departamento-victima<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod-victima<?php echo $NumWindow; ?>"
                        id="txt_cod-victima<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                      <input
                        type="text"
                        name="txt_telefono-victima<?php echo $NumWindow; ?>"
                        id="txt_telefono-victima<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Telefono"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Municipio </span>
                    <div style="display: flex">
                      <select
                        name="txt_municipio-victima<?php echo $NumWindow; ?>"
                        id="txt_municipio-victima<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod2-victima<?php echo $NumWindow; ?>"
                        id="txt_cod2-victima<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Condición del Accidentado:</span>
                    <select
                      name="txt_condicion-accidentado<?php echo $NumWindow; ?>"
                      id="txt_condicion-accidentado<?php echo $NumWindow; ?>"
                      class="form-control"
                    >
                      <option hidden select>Seleccionar</option>
                      <option value="">Conductor</option>
                      <option value="">Peatón</option>
                      <option value="">Ocupante</option>
                      <option value="">Ciclista</option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div
        id="tbfurips4<?php echo $NumWindow; ?>"
        class="row tab-pane fade in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <tr class="col-12">
                  <td colspan="12">Naturaleza del evento :</td>
                </tr>
                <tr>
                  <td>
                    <span>Naturales:</span>
                    <select name="txt_naturales<?php echo $NumWindow; ?>" id="txt_naturales<?php echo $NumWindow; ?>" class="form-control">
                      <option hidden select>Seleccionar</option>
                      <option value="">Accidente de transito</option>
                      <option value="">Sismo</option>
                      <option value="">Maremoto</option>
                      <option value="">Erucciones Volcanicas</option>
                      <option value="">Huracan</option>
                      <option value="">Inudaciones</option>
                      <option value="">Avalancha</option>
                      <option value="">Desplazamiento de Tierra</option>
                      <option value="">Incedio Natural</option>
                    </select>
                  </td>
                  <td>
                    <span>Terroristas:</span>
                    <select name="txt_terroristas<?php echo $NumWindow; ?>" id="txt_terroristas<?php echo $NumWindow; ?>" class="form-control">
                      <option hidden select>Seleccionar</option>
                      <option value="">Explosión</option>
                      <option value="">Masacre/option></option>
                      <option value="">Mina Antipersonal</option>
                      <option value="">Combate</option>
                      <option value="">Incendio</option>
                      <option value="">Ataques a Municipios</option>
                    </select>
                  </td>
                  <td>
                    <span>Dirección de la Ocurrencia</span>
                    <input
                      type="text"
                      name="txt_direccion-ocurrencia<?php echo $NumWindow; ?>"
                      id="txt_direccion-ocurrencia<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <div style="display: flex">
                      <div style="margin-right: 10px">
                        <span>Fecha Evento/Accidente</span>
                        <input
                          type="date"
                          name="txt_fecha-accidente<?php echo $NumWindow; ?>"
                          id="txt_fecha-accidente<?php echo $NumWindow; ?>"
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
                          name="txt_hora-accidente<?php echo $NumWindow; ?>"
                          id="txt_hora-accidente<?php echo $NumWindow; ?>"
                          value=""
                          min=""
                          max=""
                          class="form-control"
                        />
                      </div>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td>
                    <span>Departamento</span>
                    <div style="display: flex">
                      <select
                        name="txt_departamento-evento<?php echo $NumWindow; ?>"
                        id="txt_departamento-evento<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod-evento<?php echo $NumWindow; ?>"
                        id="txt_cod-evento<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Municipio</span>
                    <div style="display: flex">
                      <select
                        name="txt_municipio-evento<?php echo $NumWindow; ?>"
                        id="txt_municipio-evento<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod2-evento<?php echo $NumWindow; ?>"
                        id="txt_cod2-evento<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Zona</span>
                    <select
                      name="txt_zona-evento<?php echo $NumWindow; ?>"
                      id="txt_zona-evento<?php echo $NumWindow; ?>"
                      class="form-control"
                    >
                      <option hidden select>Seleccionar</option>
                      <option value="1">U</option>
                      <option value="1">R</option>
                    </select>
                  </td>
                </tr>

                <tr>
                  <td colspan="12">
                    <span
                      >Descripcion breve del evento catastrofico o accidente de
                      transito</span
                    >
                  </td>
                </tr>
                <tr>
                  <td colspan="12">
                    <span
                      >Enuncie las principales caracteristicas del evento /
                      accidente:</span
                    >
                    <textarea
                      placeholder="Describe yourself here..."
                      name="txt_comentario-evento<?php echo $NumWindow; ?>"
                      id="txt_comentario-evento<?php echo $NumWindow; ?>"
                      cols="30"
                      rows="5"
                      class="form-control"
                    >
                    </textarea>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div
        id="tbfurips5<?php echo $NumWindow; ?>"
        class="row tab-pane fade in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <tr>
                  <td>
                    <span>Estado de Aseguramiento:</span>
                      <select
                        name="txt_estado-aseguramiento<?php echo $NumWindow; ?>"
                        id="txt_estado-aseguramiento<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Asegurado</option>
                        <option value="">No Asegurado</option>
                        <option value="">Vehículo fantasma</option>
                        <option value="">Póliza Falsa</option>
                        <option value="">Vehículo en fuga</option>
                      </select>
                  </td>
                  <td>
                    <span>Marca </span>
                    <input
                      type="text"
                      name="txt_marca-aseguramiento<?php echo $NumWindow; ?>"
                      id="txt_marca-aseguramiento<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Placa:</span>
                    <input
                      type="text"
                      name="txt_placa-aseguramiento<?php echo $NumWindow; ?>"
                      id="txt_placa-aseguramiento<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>Tipo de Servicio:</span>
                      <select
                        name="txt_tipo-servicio<?php echo $NumWindow; ?>"
                        id="txt_tipo-servicio<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Particular</option>
                        <option value="">Público</option>
                        <option value="">Oficial</option>
                        <option value="">Vehículo de emergencia</option>
                        <option value="">
                          Vehículo de servicio diplomático o consular
                        </option>
                        <option value="">Vehículo de transporte masivo</option>
                        <option value="">Vehículo escolar</option>
                      </select>
                  </td>
                  <td>
                    <span>Nombre de la Aseguradora </span>
                    <input
                      type="text"
                      name="txt_nombre-aseguradora<?php echo $NumWindow; ?>"
                      id="txt_nombre-aseguradora<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Intervención de autoridad </span>
                    <select
                      name="txt_intervencion<?php echo $NumWindow; ?>"
                      id="txt_intervencion<?php echo $NumWindow; ?>"
                      class="form-control"
                    >
                      <option hidden select>Seleccionar</option>
                      <option value="1">Si</option>
                      <option value="1">No</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>No. de la Póliza </span>
                    <input
                      type="text"
                      name="txt_no-poliza<?php echo $NumWindow; ?>"
                      id="txt_no-poliza<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <div style="display: flex">
                      <div style="margin-right: 10px">
                        <span>Vigencia Desde </span>
                        <input
                          type="date"
                          name="txt_fecha-vigencia<?php echo $NumWindow; ?>"
                          id="txt_fecha-vigencia<?php echo $NumWindow; ?>"
                          value=""
                          min=""
                          max=""
                          class="form-control"
                        />
                      </div>
                      <div>
                        <span>Hasta</span>
                        <input
                          type="time"
                          name="txt_hasta<?php echo $NumWindow; ?>"
                          id="txt_hasta<?php echo $NumWindow; ?>"
                          value=""
                          min=""
                          max=""
                          class="form-control"
                        />
                      </div>
                    </div>
                  </td>
                  <td>
                    <span>Cobro Excedente Póliza</span>
                    <select
                      name="txt_cobro-poliza<?php echo $NumWindow; ?>"
                      id="txt_cobro-poliza<?php echo $NumWindow; ?>"
                      class="form-control"
                    >
                      <option hidden select>Seleccionar</option>
                      <option value="1">Si</option>
                      <option value="1">No</option>
                    </select>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div
        id="tbfurips6<?php echo $NumWindow; ?>"
        class="row tab-pane fade in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <tr>
                  <td>
                    <span>1er Apellido</span>
                    <input
                      type="text"
                      name="txt_1apellido-propietario<?php echo $NumWindow; ?>"
                      id="txt_1apellido-propietario<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>2do. Apellido</span>
                    <input
                      type="text"
                      name="txt_2apellido-propietario<?php echo $NumWindow; ?>"
                      id="txt_2apellido-propietario<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Tipo de Documento </span>
                    <div style="display: flex">
                      <select name="txt_tdocumento-propietario<?php echo $NumWindow; ?>" id="txt_tdocumento-propietario<?php echo $NumWindow; ?>" class="form-control">
                        <option hidden select>Seleccionar</option>
                        <option value="">CC</option>
                        <option value="">CE</option>
                        <option value="">PA</option>
                        <option value="">NIT</option>
                        <option value="">TI</option>
                        <option value="">RC</option>
                      </select>
                      <input
                        type="text"
                        name="txt_ndocumento-propietario<?php echo $NumWindow; ?>"
                        id="txt_ndocumento-propietario<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="No. Documento"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Departamento</span>
                    <div style="display: flex">
                      <select
                        name="txt_departamento-propietario<?php echo $NumWindow; ?>"
                        id="txt_departamento-propietario<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod-propietario<?php echo $NumWindow; ?>"
                        id="txt_cod-propietario<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                      <input
                        type="text"
                        name="txt_telefono-propietario<?php echo $NumWindow; ?>"
                        id="txt_telefono-propietario<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Teléfono"
                      />
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>1er Nombre</span>
                    <input
                      type="text"
                      name="txt_1nombre-propietario<?php echo $NumWindow; ?>"
                      id="txt_1nombre-propietario<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>2do. Nombre</span>
                    <input
                      type="text"
                      name="txt_2nombre-propietario<?php echo $NumWindow; ?>"
                      id="txt_2nombre-propietario<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Dirección Residencia</span>
                    <input
                      type="text"
                      name="txt_direccion-propietario<?php echo $NumWindow; ?>"
                      id="txt_direccion-propietario<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Municipio Residencia</span>
                    <div style="display: flex">
                      <select
                        name="txt_municipio-propietario<?php echo $NumWindow; ?>"
                        id="txt_municipio-propietario<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod2-propietario<?php echo $NumWindow; ?>"
                        id="txt_cod2-propietario<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div
        id="tbfurips7<?php echo $NumWindow; ?>"
        class="row tab-pane fade in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <tr>
                  <td>
                    <span>1er Apellido</span>
                    <input
                      type="text"
                      name="txt_1apellido-conductor<?php echo $NumWindow; ?>"
                      id="txt_1apellido-conductor<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>2do. Apellido</span>
                    <input
                      type="text"
                      name="txt_2apellido-conductor<?php echo $NumWindow; ?>"
                      id="txt_2apellido-conductor<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Tipo de Documento </span>
                    <div style="display: flex">
                      <select name="txt_tdocumento-conductor<?php echo $NumWindow; ?>" id="txt_tdocumento-conductor<?php echo $NumWindow; ?>" class="form-control">
                        <option hidden select>Seleccionar</option>
                        <option value="">CC</option>
                        <option value="">CE</option>
                        <option value="">PA</option>
                        <option value="">NIT</option>
                        <option value="">TI</option>
                        <option value="">RC</option>
                      </select>
                      <input
                        type="text"
                        name="txt_ndocumento-conductor<?php echo $NumWindow; ?>"
                        id="txt_ndocumento-conductor<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="No. Documento"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Departamento</span>
                    <div style="display: flex">
                      <select
                        name="txt_departamento-documento<?php echo $NumWindow; ?>"
                        id="txt_departamento-documento<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod-conductor<?php echo $NumWindow; ?>"
                        id="txt_cod-conductor<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                      <input
                        type="text"
                        name="txt_telefono-conductor<?php echo $NumWindow; ?>"
                        id="txt_telefono-conductor<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Teléfono"
                      />
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>1er Nombre</span>
                    <input
                      type="text"
                      name="txt_1nombre-conductor<?php echo $NumWindow; ?>"
                      id="txt_1nombre-conductor<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>2do. Nombre</span>
                    <input
                      type="text"
                      name="txt_2nombre-conductor<?php echo $NumWindow; ?>"
                      id="txt_2nombre-conductor<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Dirección Residencia</span>
                    <input
                      type="text"
                      name="txt_direccion-conductor<?php echo $NumWindow; ?>"
                      id="txt_direccion-conductor<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Municipio Residencia</span>
                    <div style="display: flex">
                      <select
                        name="txt_municipio-conductor<?php echo $NumWindow; ?>"
                        id="txt_municipio-conductor<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod2-conductor<?php echo $NumWindow; ?>"
                        id="txt_cod2-conductor<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div
        id="tbfurips8<?php echo $NumWindow; ?>"
        class="row tab-pane fade in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <tr>
                  <td>
                    <span>Fecha de Remisión</span>
                    <input
                      type="date"
                      name="txt_fecha-remision<?php echo $NumWindow; ?>"
                      id="txt_fecha-remision<?php echo $NumWindow; ?>"
                      value=""
                      min=""
                      max=""
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Persona Remitida de </span>
                    <input
                      type="text"
                      name="txt_persona-remitida<?php echo $NumWindow; ?>"
                      id="txt_persona-remitida<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Persona que remite</span>
                    <div style="display: flex">
                      <input
                        type="text"
                        name="txt_cod-remision<?php echo $NumWindow; ?>"
                        id="txt_cod-remision<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                      <input
                        type="text"
                        name="txt_cargo-remision<?php echo $NumWindow; ?>"
                        id="txt_cargo-remision<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Cargo"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Dirección IPS que remite</span>
                    <input
                      type="text"
                      name="txt_direccionips-remision<?php echo $NumWindow; ?>"
                      id="txt_direccionips-remision<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>Fecha de Aceptación </span>
                    <input
                      type="date"
                      name="txt_fecha-aceptacion<?php echo $NumWindow; ?>"
                      id="txt_fecha-aceptacion<?php echo $NumWindow; ?>"
                      value=""
                      min=""
                      max=""
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Persona Remitida a:</span>
                    <input
                      type="text"
                      name="txt_persona-remitida<?php echo $NumWindow; ?>"
                      id="txt_persona-remitida<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Persona que recibe</span>
                    <div style="display: flex">
                      <input
                        type="text"
                        name="txt_cod2-remision<?php echo $NumWindow; ?>"
                        id="txt_cod2-remision<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                      <input
                        type="text"
                        name="txt_cargo2-remision<?php echo $NumWindow; ?>"
                        id="txt_cargo2-remision<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Cargo"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Dirección IPS que recibe </span>
                    <input
                      type="text"
                      name="txt_direccionips2-remision<?php echo $NumWindow; ?>"
                      id="txt_direccionips2-remision<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>Departamento IPS que remite</span>
                    <div style="display: flex">
                      <select
                        name="txt_departamentoips-remision<?php echo $NumWindow; ?>"
                        id="txt_departamentoips-remision<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod3-remision<?php echo $NumWindow; ?>"
                        id="txt_cod3-remision<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                      <input
                        type="text"
                        name="txt_telefono2-remision<?php echo $NumWindow; ?>"
                        id="txt_telefono2-remision<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Teléfono"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Municipio IPS que remite</span>
                    <div style="display: flex">
                      <select
                        name="txt_municipioips2-remision<?php echo $NumWindow; ?>"
                        id="txt_municipioips2-remision<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod-municipio<?php echo $NumWindow; ?>"
                        id="txt_cod-municipio<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Departamento IPS que recibe</span>
                    <div style="display: flex">
                      <select
                        name="txt_departamento-recibe<?php echo $NumWindow; ?>"
                        id="txt_departamento-recibe<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod-recibe<?php echo $NumWindow; ?>"
                        id="txt_cod-recibe<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                      <input
                        type="text"
                        name="txt_telefono-recibe<?php echo $NumWindow; ?>"
                        id="txt_telefono-recibe<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Teléfono"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Municipio IPS que recibe</span>
                    <div style="display: flex">
                      <select
                        name="txt_municipio-recibe<?php echo $NumWindow; ?>"
                        id="txt_municipio-recibe<?php echo $NumWindow; ?>"
                        class="form-control"
                      >
                        <option hidden select>Seleccionar</option>
                        <option value="">Atlantico</option>
                        <option value="">Cundinamarca</option>
                        <option value=""></option>
                        <option value=""></option>
                      </select>
                      <input
                        type="text"
                        name="txt_cod-recibe<?php echo $NumWindow; ?>"
                        id="txt_cod-recibe<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Codigo"
                      />
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div
        id="tbfurips9<?php echo $NumWindow; ?>"
        class="row tab-pane fade in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <tr>
                  <td colspan="12">
                    <span
                      >Diligenciar únicamente para el transporte desde el sitio
                      del evento hasta la primera IPS (Transporte
                      Primario)</span
                    >
                  </td>
                </tr>
                <tr class="col-12">
                  <td style="vertical-align: middle">
                    <span>Datos de Vehículo</span>
                  </td>
                  <td>
                    <span>Placa No.</span>
                    <input
                      type="text"
                      name="txt_nplaca-vehiculo<?php echo $NumWindow; ?>"
                      id="txt_nplaca-vehiculo<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>1er Apellido</span>
                    <input
                      type="text"
                      name="txt_1apellido-movilizacion<?php echo $NumWindow; ?>"
                      id="txt_1apellido-movilizacion<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>2do. Apellido</span>
                    <input
                      type="text"
                      name="txt_2apellido-movilizacion<?php echo $NumWindow; ?>"
                      id="txt_2apellido-movilizacion<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Tipo de Documento </span>
                    <div style="display: flex">
                      <select name="txt_tdocumento-movilizacion<?php echo $NumWindow; ?>" id="txt_tdocumento-movilizacion<?php echo $NumWindow; ?>" class="form-control">
                        <option hidden select>Seleccionar</option>
                        <option value="">CC</option>
                        <option value="">CE</option>
                        <option value="">PA</option>
                        <option value="">NIT</option>
                        <option value="">TI</option>
                        <option value="">RC</option>
                      </select>
                      <input
                        type="text"
                        name="txt_ndocumento-movilizacion<?php echo $NumWindow; ?>"
                        id="txt_ndocumento-movilizacion<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="No. Documento"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Tipo de Transporte</span>
                    <select
                      name="txt_zona-movilizacion<?php echo $NumWindow; ?>"
                      id="txt_zona-movilizacion<?php echo $NumWindow; ?>"
                      class="form-control"
                    >
                      <option hidden select>Seleccionar</option>
                      <option value="1">Ambulancia Básica</option>
                      <option value="1">Ambulancia Medicada</option>
                    </select>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>1er Nombre</span>
                    <input
                      type="text"
                      name="txt_1nombre-movilizacion<?php echo $NumWindow; ?>"
                      id="txt_1nombre-movilizacion<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>2do. Nombre</span>
                    <input
                      type="text"
                      name="txt_2nombre-movilizacion<?php echo $NumWindow; ?>"
                      id="txt_2nombre-movilizacion<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Transporto la víctima</span>
                    <div style="display: flex">
                      <input
                        type="text"
                        name="txt_desde-movilizacion<?php echo $NumWindow; ?>"
                        id="txt_desde-movilizacion<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Desde"
                      />
                      <input
                        type="text"
                        name="txt_hasta-movilizacion<?php echo $NumWindow; ?>"
                        id="txt_hasta-movilizacion<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="Hasta"
                      />
                    </div>
                  </td>
                  <td>
                    <span>Lugar donde recoge la Victima</span>
                    <select
                      name="txt_zona-movilizacon<?php echo $NumWindow; ?>"
                      id="txt_zona-movilizacon<?php echo $NumWindow; ?>"
                      class="form-control"
                    >
                      <option hidden select>Seleccionar</option>
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
      <div
        id="tbfurips10<?php echo $NumWindow; ?>"
        class="row tab-pane fade in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <tr>
                  <td>
                    <div style="display: flex">
                      <div style="margin-right: 10px">
                        <span>Fecha de ingreso </span>
                        <input
                          type="date"
                          name="txt_fecha-ingreso<?php echo $NumWindow; ?>"
                          id="txt_fecha-ingreso<?php echo $NumWindow; ?>"
                          value=""
                          min=""
                          max=""
                          class="form-control"
                        />
                      </div>
                      <div>
                        <span>a las</span>
                        <input
                          type="time"
                          name="txt_hora-ingreso<?php echo $NumWindow; ?>"
                          id="txt_hora-ingreso<?php echo $NumWindow; ?>"
                          value=""
                          min=""
                          max=""
                          class="form-control"
                        />
                      </div>
                    </div>
                  </td>
                  <td>
                    <span>Código Diagnóstico principal de Ingreso </span>
                    <input
                      type="text"
                      name="txt_diagnostico-ingreso<?php echo $NumWindow; ?>"
                      id="txt_diagnostico-ingreso<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Código Diagnóstico principal de Egreso </span>
                    <input
                      type="text"
                      name="txt_diagnostico-egreso<?php echo $NumWindow; ?>"
                      id="txt_diagnostico-egreso<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Otro Código Diagnóstico de ingreso</span>
                    <input
                      type="text"
                      name="txt_otro-ingreso<?php echo $NumWindow; ?>"
                      id="txt_otro-ingreso<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                </tr>
                <tr>
                  <td>
                    <div style="display: flex">
                      <div style="margin-right: 10px">
                        <span>Fecha de ingreso </span>
                        <input
                          type="date"
                          name="txt_fecha2-ingreso<?php echo $NumWindow; ?>"
                          id="txt_fecha2-ingreso<?php echo $NumWindow; ?>"
                          value=""
                          min=""
                          max=""
                          class="form-control"
                        />
                      </div>
                      <div>
                        <span>a las</span>
                        <input
                          type="time"
                          name="txt_hora2-ingreso<?php echo $NumWindow; ?>"
                          id="txt_hora2-ingreso<?php echo $NumWindow; ?>"
                          value=""
                          min=""
                          max=""
                          class="form-control"
                        />
                      </div>
                    </div>
                  </td>
                  <td>
                    <span>Otro Código Diagnóstico de ingreso</span>
                    <input
                      type="text"
                      name="txt_otro-ingreso2<?php echo $NumWindow; ?>"
                      id="txt_otro-ingreso2<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Otro código Diagnóstico principal de Egreso</span>
                    <input
                      type="text"
                      name="txt_otro-egreso<?php echo $NumWindow; ?>"
                      id="txt_otro-egreso<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Otro código Diagnóstico principal de Egreso</span>
                    <input
                      type="text"
                      name="txt_otro-egreso2<?php echo $NumWindow; ?>"
                      id="txt_otro-egreso2<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div
        id="tbfurips11<?php echo $NumWindow; ?>"
        class="row tab-pane fade in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <tr>
                  <td>
                    <span>1er Apellido del Médico o Profesional tratante</span>
                    <input
                      type="text"
                      name="txt_1apellido-medico<?php echo $NumWindow; ?>"
                      id="txt_1apellido-medico<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>2do. Apellido del Médico o Profesional tratante</span>
                    <input
                      type="text"
                      name="txt_2apellido-medico<?php echo $NumWindow; ?>"
                      id="txt_2apellido-medico<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Tipo de Documento </span>
                    <div style="display: flex">
                      <select name="txt_tdocumento-medico<?php echo $NumWindow; ?>" id="txt_tdocumento-medico<?php echo $NumWindow; ?>" class="form-control">
                        <option hidden select>Seleccionar</option>
                        <option value="">CC</option>
                        <option value="">CE</option>
                        <option value="">PA</option>
                        <option value="">NIT</option>
                        <option value="">TI</option>
                        <option value="">RC</option>
                      </select>
                      <input
                        type="text"
                        name="txt_ndocumento-medico<?php echo $NumWindow; ?>"
                        id="txt_ndocumento-medico<?php echo $NumWindow; ?>"
                        class="form-control"
                        placeholder="No. Documento"
                      />
                    </div>
                  </td>
                </tr>
                <tr>
                  <td>
                    <span>1er Nombre del Médico o Profesional tratante</span>
                    <input
                      type="text"
                      name="txt_1nombre-medico<?php echo $NumWindow; ?>"
                      id="txt_1nombre-medico<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>2do Nombre del Médico o Profesional tratante</span>
                    <input
                      type="text"
                      name="txt_2nombre-medico<?php echo $NumWindow; ?>"
                      id="txt_2nombre-medico<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>Número de Registro Médico</span>
                    <input
                      type="text"
                      name="txt_nregistro-medico<?php echo $NumWindow; ?>"
                      id="txt_nregistro-medico<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div
        id="tbfurips12<?php echo $NumWindow; ?>"
        class="row tab-pane fade in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <tr>
                  <td colspan="12">
                    <span
                      >Marque la casilla correspomdiente al beneficio
                      reclamado</span
                    >
                  </td>
                </tr>
                <tr>
                  <td style="vertical-align: middle">
                    <div style="display: flex">
                      <span style="width: 100%">GASTOS MEDICO QUIRURGICOS</span>
                      <input
                        style="height: 20px"
                        class="form-control"
                        type="checkbox"
                        name="txt_gmedicos<?php echo $NumWindow; ?>"
                        id="txt_gmedicos<?php echo $NumWindow; ?>"
                        value=""
                      />
                    </div>
                  </td>
                  <td>
                    <span>VALOR TOTAL FACTURADO</span>
                    <input
                      type="text"
                      name="txt_tfacturado<?php echo $NumWindow; ?>"
                      id="txt_tfacturado<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <span>VALOR RECLAMADO AL FOSYGA</span>
                    <input
                      type="text"
                      name="txt_vreclamado<?php echo $NumWindow; ?>"
                      id="txt_vreclamado<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                </tr>
                <tr>
                  <td style="vertical-align: middle">
                    <div style="display: flex">
                      <span style="width: 100%">GASTOS DE TRANSPORTE Y MOVILIZACION DE LA VICTIMA</span>
                      <input
                        style="height: 20px"
                        class="form-control"
                        type="checkbox"
                        name="txt_gtransporte<?php echo $NumWindow; ?>"
                        id="txt_gtransporte<?php echo $NumWindow; ?>"
                        value=""
                      />
                    </div>
                  </td>
                  <td>
                    <input
                      type="text"
                      name="txt_vfacturado2<?php echo $NumWindow; ?>"
                      id="txt_vfacturado2<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                  <td>
                    <input
                      type="text"
                      name="txt_vreclamado2<?php echo $NumWindow; ?>"
                      id="txt_vreclamado2<?php echo $NumWindow; ?>"
                      class="form-control"
                    />
                  </td>
                </tr>
                <tr>
                  <td colspan="12">
                    <span
                      >El total facturado y reclamado descrito en este numeral
                      se debe detallar y hacer descripcion de las actividades,
                      procedimientos, medicamentos, insumos, suministros y
                      materiales, dentro del anexo técnico numero 2.</span
                    >
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div
        id="tbfurips13<?php echo $NumWindow; ?>"
        class="row tab-pane fade in active"
        role="tabpanel"
      >
        <div class="col-sm-12">
          <div class="table-responsive">
            <table
              width="99%"
              align="center"
              cellpadding="1"
              cellspacing="2"
              bgcolor="#EFEFEF"
              class="table table-striped table-condensed tblDetalle table-bordered"
            >
              <tbody>
                <tr>
                  <td colspan="12">
                    <span
                      >Como representante legal o Gerente de la Institución
                      Prestadora de Servicios de Salud, declaró bajo la gravedad
                      de juramento que toda la información contenida en
                    </span>
                  </td>
                </tr>
                <tr>
                  <td>_______________________________________________</td>
                  <td>_______________________________________________</td>
                </tr>
                <tr>
                  <td>
                    <span>NOMBRE</span>
                  </td>
                  <td>
                    <span
                      >FIRMA DEL REPRESENTANTE LEGAL, GERENTE O SU DELEGADO
                    </span>
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
