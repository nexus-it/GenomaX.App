	  			<div id="divdescqx<?php echo $NumWindow; ?>" class="col-md-12">
                    <div class="row">
                        <div class="col-md-2 col-sm-6">

                    <div class="form-group">
                        <label for="txt_numqx<?php echo $NumWindow; ?>">Evento Qx</label>
                        <input name="txt_numqx<?php echo $NumWindow; ?>" id="txt_numqx<?php echo $NumWindow; ?>" type="number" class="lead" value="1" />
                    </div>

                        </div>
                        <div class="col-md-2 col-sm-6">

                    <div class="form-group">
                        <label for="txt_fechaqx<?php echo $NumWindow; ?>">Fecha</label>
                        <input name="txt_fechaqx<?php echo $NumWindow; ?>" id="txt_fechaqx<?php echo $NumWindow; ?>" type="date" class="lead"  />
                    </div>

                        </div>
                        <div class="col-md-2 col-sm-6">

                    <div class="form-group">
                        <label for="txt_horainiqx<?php echo $NumWindow; ?>">Hora Incial</label>
                        <input name="txt_horainiqx<?php echo $NumWindow; ?>" id="txt_horainiqx<?php echo $NumWindow; ?>" type="time" class="lead"  />
                    </div>

                        </div>
                        <div class="col-md-2 col-sm-6">

                    <div class="form-group">
                        <label for="txt_horafinqx<?php echo $NumWindow; ?>">Hora Final</label>
                        <input name="txt_horafinqx<?php echo $NumWindow; ?>" id="txt_horafinqx<?php echo $NumWindow; ?>" type="time" class="lead"  />
                    </div>

                        </div>
                        <div class="col-md-2 col-sm-6">

                    <div class="form-group">
                        <label for="cmb_anestesiaqx<?php echo $NumWindow; ?>">Tipo Anestesia</label>
                        <select name="txt_anestesiaqx<?php echo $NumWindow; ?>" id="txt_anestesiaqx<?php echo $NumWindow; ?>"  >
                            <option value="Local">Local</option>
                            <option value="Sedación">Sedación</option>
                            <option value="Regional">Regional</option>
                            <option value="General">General</option>
                        </select>
                    </div>

                        </div>
                        <div class="col-md-2 col-sm-6">

                    <div class="form-group">
                        <label for="cmb_quirofano<?php echo $NumWindow; ?>">Quirófano</label>
                        <select name="cmb_quirofano<?php echo $NumWindow; ?> id="cmb_quirofano<?php echo $NumWindow; ?>>
                        <?php 
                        $SQL="Select Codigo_QRF, Nombre_QRF from gxquirofanos where Estado_QRF='1' order by Nombre_QRF";
                        $result = mysqli_query($conexion, $SQL);
                        while($row = mysqli_fetch_array($result)) 
                            {
                        ?>
                            <option value="<?php echo $row[0]; ?>"><?php echo $row[1]; ?></option>
                        <?php
                            }
                        mysqli_free_result($result); 
                        ?>
                        </select>
                    </div>

                        </div>
                    
                    </div>
                    <div class="row">
                        <div class="col-md-2 col-sm-3">

                    <div class="form-group" >
                        <label for="txt_qxproc<?php echo $NumWindow; ?>">Código</label>
                        <div class="input-group">	
                            <input style="font-size:15px;" name="txt_qxproc<?php echo $NumWindow; ?>" id="txt_qxproc<?php echo $NumWindow; ?>" type="text" required onchange="NombreQx<?php echo $NumWindow; ?>(this.value);" onblur="NombreQx<?php echo $NumWindow; ?>(this.value);" />
                            <span class="input-group-btn">	
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('ServiciosX1', 'txt_qxproc<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                        <input name="hdn_codigoproc<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigoproc<?php echo $NumWindow; ?>" value="" />
                    </div>

                        </div>
                        <div class="col-md-10 col-sm-9">

                    <div class="form-group">
                        <label for="txt_qxprocname<?php echo $NumWindow; ?>">Procedimiento</label>
                        <input name="txt_qxprocname<?php echo $NumWindow; ?>" id="txt_qxprocname<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
                    </div>

                        </div>
                    </div>
	  				<label class="label label-success"> Profesionales</label>
	  				<div class="row well well-sm">
                        <div class="col-md-2 col-sm-4">

                    <div class="form-group" >
                        <label for="txt_idmd1<?php echo $NumWindow; ?>">Cirujano 1</label>
                        <div class="input-group">	
                            <input style="font-size:15px;" name="txt_idmd1<?php echo $NumWindow; ?>" id="txt_idmd1<?php echo $NumWindow; ?>" type="text" required onchange="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_cirujano1<?php echo $NumWindow; ?>');" onblur="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_cirujano1<?php echo $NumWindow; ?>');"  />
                            <span class="input-group-btn">	
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('ProfesionalesSalud', 'txt_idmd1<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                        <input name="hdn_codigomd1<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigomd1<?php echo $NumWindow; ?>" value="" />
                    </div>

                        </div>
                        <div class="col-md-4 col-sm-8">

                    <div class="form-group">
                        <label for="txt_cirujano1<?php echo $NumWindow; ?>">Nombre</label>
                        <input name="txt_cirujano1<?php echo $NumWindow; ?>" id="txt_cirujano1<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
                    </div>

                        </div>
                        <div class="col-md-2 col-sm-4">

                    <div class="form-group" >
                        <label for="txt_idmd2<?php echo $NumWindow; ?>">Cirujano 2</label>
                        <div class="input-group">	
                            <input style="font-size:15px;" name="txt_idmd2<?php echo $NumWindow; ?>" id="txt_idmd2<?php echo $NumWindow; ?>" type="text" required onchange="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_cirujano2<?php echo $NumWindow; ?>');" onblur="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_cirujano2<?php echo $NumWindow; ?>');" />
                            <span class="input-group-btn">	
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('ProfesionalesSalud', 'txt_idmd2<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                        <input name="hdn_codigomd2<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigomd2<?php echo $NumWindow; ?>" value="" />
                    </div>

                        </div>
                        <div class="col-md-4 col-sm-8">

                    <div class="form-group">
                        <label for="txt_cirujano2<?php echo $NumWindow; ?>">Nombre</label>
                        <input name="txt_cirujano2<?php echo $NumWindow; ?>" id="txt_cirujano2<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
                    </div>

                        </div>
                        <div class="col-md-2 col-sm-4">

                    <div class="form-group" >
                        <label for="txt_idmd5<?php echo $NumWindow; ?>">Anestesiólogo</label>
                        <div class="input-group">	
                            <input style="font-size:15px;" name="txt_idmd5<?php echo $NumWindow; ?>" id="txt_idmd5<?php echo $NumWindow; ?>" type="text" required onchange="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_anestesiologo<?php echo $NumWindow; ?>');" onblur="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_anestesiologo<?php echo $NumWindow; ?>');"/>
                            <span class="input-group-btn">	
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('ProfesionalesSalud', 'txt_idmd5<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                        <input name="hdn_codigomd5<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigomd5<?php echo $NumWindow; ?>" value="" />
                    </div>

                        </div>
                        <div class="col-md-4 col-sm-8">

                    <div class="form-group">
                        <label for="txt_anestesiologo<?php echo $NumWindow; ?>">Nombre</label>
                        <input name="txt_anestesiologo<?php echo $NumWindow; ?>" id="txt_anestesiologo<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
                    </div>

                        </div>
                        <div class="col-md-2 col-sm-4">

                    <div class="form-group" >
                        <label for="txt_idmd3<?php echo $NumWindow; ?>">Ayudante 1</label>
                        <div class="input-group">	
                            <input style="font-size:15px;" name="txt_idmd3<?php echo $NumWindow; ?>" id="txt_idmd3<?php echo $NumWindow; ?>" type="text" required onchange="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_ayudante1<?php echo $NumWindow; ?>');" onblur="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_ayudante1<?php echo $NumWindow; ?>');" />
                            <span class="input-group-btn">	
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('ProfesionalesSalud', 'txt_idmd3<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                        <input name="hdn_codigomd3<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigomd3<?php echo $NumWindow; ?>" value="" />
                    </div>

                        </div>
                        <div class="col-md-4 col-sm-8">

                    <div class="form-group">
                        <label for="txt_ayudante1<?php echo $NumWindow; ?>">Nombre</label>
                        <input name="txt_ayudante1<?php echo $NumWindow; ?>" id="txt_ayudante1<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
                    </div>

                        </div>
                        <div class="col-md-2 col-sm-4">

                    <div class="form-group" >
                        <label for="txt_idmd4<?php echo $NumWindow; ?>">Ayudante 2</label>
                        <div class="input-group">	
                            <input style="font-size:15px;" name="txt_idmd4<?php echo $NumWindow; ?>" id="txt_idmd4<?php echo $NumWindow; ?>" type="text" required onchange="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_ayudante2<?php echo $NumWindow; ?>');" onblur="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_ayudante2<?php echo $NumWindow; ?>');" />
                            <span class="input-group-btn">	
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('ProfesionalesSalud', 'txt_idmd4<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                        <input name="hdn_codigomd4<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigomd4<?php echo $NumWindow; ?>" value="" />
                    </div>

                        </div>
                        <div class="col-md-4 col-sm-8">

                    <div class="form-group">
                        <label for="txt_ayudante2<?php echo $NumWindow; ?>">Nombre</label>
                        <input name="txt_ayudante2<?php echo $NumWindow; ?>" id="txt_ayudante2<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
                    </div>

                        </div>
                        <div class="col-md-2 col-sm-4">

                    <div class="form-group" >
                        <label for="txt_idmd6<?php echo $NumWindow; ?>">Ayudante 3</label>
                        <div class="input-group">	
                            <input style="font-size:15px;" name="txt_idmd6<?php echo $NumWindow; ?>" id="txt_idmd6<?php echo $NumWindow; ?>" type="text" required onchange="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_ayudante3<?php echo $NumWindow; ?>');" onblur="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_ayudante3<?php echo $NumWindow; ?>');" />
                            <span class="input-group-btn">	
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('ProfesionalesSalud', 'txt_idmd6<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                        <input name="hdn_codigomd6<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigomd6<?php echo $NumWindow; ?>" value="" />
                    </div>

                        </div>
                        <div class="col-md-4 col-sm-8">

                    <div class="form-group">
                        <label for="txt_ayudante3<?php echo $NumWindow; ?>">Nombre</label>
                        <input name="txt_ayudante3<?php echo $NumWindow; ?>" id="txt_ayudante3<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
                    </div>

                        </div>
                        <div class="col-md-2 col-sm-4">

                    <div class="form-group" >
                        <label for="txt_idmd7<?php echo $NumWindow; ?>">Instrumentador</label>
                        <div class="input-group">	
                            <input style="font-size:15px;" name="txt_idmd7<?php echo $NumWindow; ?>" id="txt_idmd7<?php echo $NumWindow; ?>" type="text" required onchange="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_instrumentador<?php echo $NumWindow; ?>');" onblur="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_instrumentador<?php echo $NumWindow; ?>');"/>
                            <span class="input-group-btn">	
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('ProfesionalesSalud', 'txt_idmd7<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                        <input name="hdn_codigomd7<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigomd7<?php echo $NumWindow; ?>" value="" />
                    </div>

                        </div>
                        <div class="col-md-4 col-sm-8">

                    <div class="form-group">
                        <label for="txt_instrumentador<?php echo $NumWindow; ?>">Nombre</label>
                        <input name="txt_instrumentador<?php echo $NumWindow; ?>" id="txt_instrumentador<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
                    </div>

                        </div>
                        <div class="col-md-2 col-sm-4">

                    <div class="form-group" >
                        <label for="txt_idmd8<?php echo $NumWindow; ?>">Otro</label>
                        <div class="input-group">	
                            <input style="font-size:15px;" name="txt_idmd8<?php echo $NumWindow; ?>" id="txt_idmd8<?php echo $NumWindow; ?>" type="text" required onchange="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_otromd<?php echo $NumWindow; ?>');" onblur="NombreProf<?php echo $NumWindow; ?>(this.value, 'txt_otromd<?php echo $NumWindow; ?>');" />
                            <span class="input-group-btn">	
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('ProfesionalesSalud', 'txt_idmd8<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                        <input name="hdn_codigomd8<?php echo $NumWindow; ?>" type="hidden" id="hdn_codigomd8<?php echo $NumWindow; ?>" value="" />
                    </div>

                        </div>
                        <div class="col-md-4 col-sm-8">

                    <div class="form-group">
                        <label for="txt_otromd<?php echo $NumWindow; ?>">Nombre</label>
                        <input name="txt_otromd<?php echo $NumWindow; ?>" id="txt_otromd<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
                    </div>

                        </div>
	  				</div>
                      <label class="label label-success"> Diagnósticos</label>
	  				<div class="row well well-sm">
                      <div class="col-md-1 col-sm-3">

                    <div class="form-group" >
                        <label for="txt_dxpre<?php echo $NumWindow; ?>">Dx</label>
                        <div class="input-group">	
                            <input style="font-size:15px;" name="txt_dxpre<?php echo $NumWindow; ?>" id="txt_dxpre<?php echo $NumWindow; ?>" type="text" required onchange="DxQx<?php echo $NumWindow; ?>(this.value, 'txt_predx<?php echo $NumWindow; ?>');" onblur="DxQx<?php echo $NumWindow; ?>(this.value, 'txt_predx<?php echo $NumWindow; ?>');" />
                            <span class="input-group-btn">	
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('Diagnostico', 'txt_dxpre<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                    </div>

                        </div>
                        <div class="col-md-5 col-sm-9">

                    <div class="form-group">
                        <label for="txt_predx<?php echo $NumWindow; ?>">Pre Operatorio</label>
                        <input name="txt_predx<?php echo $NumWindow; ?>" id="txt_predx<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
                    </div>

                        </div>
                        <div class="col-md-1 col-sm-3">

                    <div class="form-group" >
                        <label for="txt_dxpos<?php echo $NumWindow; ?>">Dx</label>
                        <div class="input-group">	
                            <input style="font-size:15px;" name="txt_dxpos<?php echo $NumWindow; ?>" id="txt_dxpos<?php echo $NumWindow; ?>" type="text" required onchange="DxQx<?php echo $NumWindow; ?>(this.value, 'txt_posdx<?php echo $NumWindow; ?>');" onblur="DxQx<?php echo $NumWindow; ?>(this.value, 'txt_posdx<?php echo $NumWindow; ?>');" />
                            <span class="input-group-btn">	
                                <button class="btn btn-success" type="button" data-toggle="modal" data-target="#GnmX_Search" data-whatever="ModelosHC" onclick="javascript:CargarSearch('Diagnostico', 'txt_dxpos<?php echo $NumWindow; ?>', 'NULL');"><i class="fas fa-search"></i></button>
                            </span>
                        </div>
                    </div>

                        </div>
                        <div class="col-md-5 col-sm-9">

                    <div class="form-group">
                        <label for="txt_posdx<?php echo $NumWindow; ?>">Pos Operatorio</label>
                        <input name="txt_posdx<?php echo $NumWindow; ?>" id="txt_posdx<?php echo $NumWindow; ?>" type="text" disabled="disabled" class="lead" />
                    </div>

                        </div>
                    </div>
                      <label class="label label-success"> Descripción</label>
	  				<div class="row well well-sm">
                      <div class="col-md-12">
                        <textarea name="txt_descripcionqx<?php echo $NumWindow; ?>" id="txt_descripcionqx<?php echo $NumWindow; ?>" rows="6"></textarea>
                      </div>
                    
                    </div>
                    <script>
                        FechaActual('txt_fechaqx<?php echo $NumWindow; ?>');
                        HoraActual('txt_horainiqx<?php echo $NumWindow; ?>');
                        HoraActual('txt_horafinqx<?php echo $NumWindow; ?>');

                        function NombreProf<?php echo $NumWindow; ?>(Codigo, destino) {
                            $.get(Funciones,{'Func':'NombreTercero','value':Codigo, 'tabla':'gxmedicos'},function(data){ 
                                if (data=="No se encuentra el tercero") {
                                    swal('DOCUMENTO NO SE ENCUENTRA', data,'error');
                                    document.getElementById(destino).value="";
                                } else {
                                    document.getElementById(destino).value=data;
                                }
                            }); 
                        }
                        function NombreQx<?php echo $NumWindow; ?>(Codigo) {
                            $.get(Funciones,{'Func':'NombreServicio','value':Codigo},function(data){ 																	  
                                document.getElementById('txt_qxprocname<?php echo $NumWindow; ?>').value=data;
                            }); 
                        }
                        function DxQx<?php echo $NumWindow; ?>(Codigo, Destino) {
                            $.get(Funciones,{'Func':'NombreDiagnostico','value':Codigo},function(data){ 																	  
                                document.getElementById(Destino).value=data;
                            }); 
                        }


                    </script>
	  			</div>
