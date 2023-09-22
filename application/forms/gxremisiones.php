



    <div class="row">

        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active">
                <a href="#tbferencia2<?php echo $NumWindow; ?>"aria-controls="tbferencia2<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Datos Generales</a>
            </li>
            <li role="presentation">
                <a href="#tbferencia3<?php echo $NumWindow; ?>"aria-controls="tbferencia3<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Datos de la Solicitud</a>
            </li>
            <li role="presentation">
                <a href="#tbferencia4<?php echo $NumWindow; ?>"aria-controls="tbferencia4<?php echo $NumWindow; ?>" role="tab" data-toggle="tab">Seguimiento</a>
            </li>
        </ul>

        <div id="divReferencia<?php echo $NumWindow; ?>" class="col-md-12 tab-content">
            <div id="tbferencia2<?php echo $NumWindow; ?>" class="row tab-pane fade in active" role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td>Tipo:</td>
                                    <td>
                                        <select id="txt_TipoRef<?php echo $NumWindow; ?>" name="txt_TipoRef<?php echo $NumWindow; ?>" class="" >
                                            <option>Referencia</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                    </td> 
                                    <td>Consecutivo:</td>
                                    <td>
                                        <select id="txt_ConsRef<?php echo $NumWindow; ?>" name="txt_ConsRef<?php echo $NumWindow; ?>" class="" >
                                            <option>124256</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                    </td>       
                                </tr>
                                <tr>
                                    <td>Fecha:</td>
                                    <td>
                                        <input type="date" name="txt_fechaRef<?php echo $NumWindow; ?>"id="txt_fechaRef<?php echo $NumWindow; ?>" value="" min="" max="" />
                                    </td> 
                                    <td>Estado:</td>
                                    <td>
                                        <select  name="txt_fechaRef<?php echo $NumWindow; ?>" id="txt_fechaRef<?php echo $NumWindow; ?>"class="">
                                            <option>Registrado</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                    </td>  
                                    <td> Periodo:</td>
                                    <td>
                                        <select id="txt_UrgRef<?php echo $NumWindow; ?>" name="txt_UrgRef<?php echo $NumWindow; ?>" class="" >
                                            <option>Urgente</option>
                                            <option>2</option>
                                            <option>3</option>
                                        </select>
                                    </td>       
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        
            <div id="tbferencia3<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td>Medico:</td>
                                    <td>
                                       <input type="text" id="txt_MedRef<?php echo $NumWindow; ?>" name="txt_MedRef<?php echo $NumWindow; ?>" class="" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>Especilista:</td>
                                    <td>
                                        <input type="text" id="txt_EspRef1<?php echo $NumWindow; ?>" name="txt_EspRef1<?php echo $NumWindow; ?>" class="" >
                                        <input type="text" id="txt_EspRef2<?php echo $NumWindow; ?>" name="txt_EspRef2<?php echo $NumWindow; ?>" class="" >
                                    </td>
                                </tr>
                                <tr>
                                   <td>Servicio que Remite:</td>
                                   <td>
                                       <input type="text" id="txt_SerReRef<?php echo $NumWindow; ?>" name="txt_SerReRef<?php echo $NumWindow; ?>" class="" >
                                   </td>
                                   <td>Descripcion:</td>
                                   <td>
                                       <input type="text" id="txt_SerReDeRef<?php echo $NumWindow; ?>" name="txt_SerReDeRef<?php echo $NumWindow; ?>" class="" >
                                   </td>
                                </tr>
                                <tr>
                                    <td>Servicio al que Remite:</td>
                                    <td>
                                       <input type="text" id="txt_SerAlReRef<?php echo $NumWindow; ?>" name="txt_SerAlReRef<?php echo $NumWindow; ?>" class="" >
                                    </td>
                                    <td>Descripcion:</td>
                                    <td>
                                       <input type="text" id="txt_SerAlReDeRef<?php echo $NumWindow; ?>" name="txt_SerReAlDeRef<?php echo $NumWindow; ?>" class="" >
                                    </td>
                                </tr>
                                <tr>
                                   <td>Motivo de Remision:</td>
                                   <td>
                                       <input type="text" id="txt_MoReRef<?php echo $NumWindow; ?>" name="txt_MoReRef<?php echo $NumWindow; ?>" class="" >
                                       <input type="text" id="txt_MoReRef<?php echo $NumWindow; ?>" name="txt_MoReRef<?php echo $NumWindow; ?>" class="" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>Ampliacion de Motivo:</td>
                                    <td><input type="text" id="txt_AmpliMoRef<?php echo $NumWindow; ?>" name="txt_AmpliMoRef<?php echo $NumWindow; ?>" class="" ></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tbferencia4<?php echo $NumWindow; ?>" class="row tab-pane fade " role="tabpanel">
                <div class="col-sm-12">
                    <div class="table-responsive">
                        <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered">
                            <tbody>
                                <tr>
                                    <td>Fecha:</td>
                                    <td><input type="date" id="txt_SeFecRef<?php echo $NumWindow; ?>" name="txt_SeFecRef<?php echo $NumWindow; ?>" class="" ></td>
                                </tr>
                                <tr>
                                    <td>Funcionario quien Constesta:</td>
                                    <td><input type="text" id="txt_SeFunCoRef<?php echo $NumWindow; ?>" name="txt_SeFunCoRef<?php echo $NumWindow; ?>" class="" ></td>
                                </tr>
                                <tr>
                                    <td>Observaciones:</td>
                                    <td><input type="text" id="txt_SeObseRef<?php echo $NumWindow; ?>" name="txt_SeObseRef<?php echo $NumWindow; ?>" class="" ></td>
                                </tr>
                                <tr>
                                    <td>Paciente Aceptado:</td>
                                    <td><input type="text" id="txt_SePacAcRef<?php echo $NumWindow; ?>" name="txt_SePacAcRef<?php echo $NumWindow; ?>" class="" ></td>
                                </tr>
                                <tr>
                                    <td>Negacion Administrativa:</td>
                                    <td>
                                        <input type="checkbox" id="txt_SeNegAdmRef1<?php echo $NumWindow; ?>" name="txt_SeNegAdmRef1<?php echo $NumWindow; ?>" class="" >
                                        <input type="text" id="txt_SeNegAdmRef2<?php echo $NumWindow; ?>" name="txt_SeNegAdmRef2<?php echo $NumWindow; ?>" class="" >
                                        <input type="text" id="txt_SeNegAdmRef3<?php echo $NumWindow; ?>" name="txt_SeNegAdmRef3<?php echo $NumWindow; ?>" class="" >
                                    </td>
                                </tr>
                                <tr>
                                    <td>Negacion Medica:</td>
                                    <td>
                                        <input type="checkbox" id="txt_SeNegMedRef1<?php echo $NumWindow; ?>" name="txt_SeNegMedRef1<?php echo $NumWindow; ?>" class="" >
                                        <input type="text" id="txt_SeNegMedRef2<?php echo $NumWindow; ?>" name="txt_SeNegMedRef2<?php echo $NumWindow; ?>" class="" >
                                        <input type="text" id="txt_SeNegMedRef3<?php echo $NumWindow; ?>" name="txt_SeNegMedRef3<?php echo $NumWindow; ?>" class="" >
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

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
    
