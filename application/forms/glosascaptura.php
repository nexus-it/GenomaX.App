<?php
	
    session_start();
      $NumWindow=$_GET["target"];
      // include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
      include '../../functions/php/nexus/database.php';	
      $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
      mysqli_query ($conexion, "SET NAMES 'utf8'");	
      $contarow=0;
    ?>
    <form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal container" id="frm_form<?php echo $NumWindow; ?>" >
            <div class="detalleord table-responsive">
              <table width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle" id="tblDetalle<?php echo $NumWindow; ?>" >
                <tbody>
                  <tr>
                    <td>
                      <span class="text-success">Número de Glosa</span class="text-success">
                      <input type="text" name="Entidad<?php echo $NumWindow; ?>" id="Entidad<?php echo $NumWindow; ?>" />
                    </td>
                    <td>
                      <span class="text-success">Número Factura</span class="text-success">
                      <input type="text" name="Entidad<?php echo $NumWindow; ?>" id="Entidad<?php echo $NumWindow; ?>"
                      />
                    </td>
                    <td>
                      <span class="text-success">Entidad</span class="text-success">
                      <input type="text" name="Entidad<?php echo $NumWindow; ?>" id="Entidad<?php echo $NumWindow; ?>" disabled
                      />
                    </td>
                    <td>
                      <span class="text-success">Estado</span>
                      <input type="text" name="Estado<?php echo $NumWindow; ?>" id="Estado<?php echo $NumWindow; ?>" disabled
                      />
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <span class="text-success">Fecha de Factura </span>
                        <input type="text" name="Fecha_Factura<?php echo $NumWindow; ?>" id="Fecha_Facturas<?php echo $NumWindow; ?>" disabled 
                        />
                      </td>
                      <td>
                        <span class="text-success">Fecha de Glosa</span>
                        <input type="text" name="FechaGlosa<?php echo $NumWindow; ?>" id="FechaGlosas<?php echo $NumWindow; ?>" disabled
                        />
                      </td>
                    <td>
                      <span class="text-success">Plan de beneficio</span>
                      <input type="text" name="Plan_beneficio<?php echo $NumWindow; ?>" id="Plan_beneficio<?php echo $NumWindow; ?>" disabled
                      />
                    </td>
                    <td>
                      <span class="text-success">Contrato</span>
                      <input type="text" name="Contrato<?php echo $NumWindow; ?>" id="Contrato<?php echo $NumWindow; ?>" disabled
                      />
                    </td>
                  </tr>
                  <tr>
                    <td>
                        <span class="text-success">N.Rad</span>
                        <input type="text" name="nRadicacion<?php echo $NumWindow; ?>" id="nRadicacion<?php echo $NumWindow; ?>" disabled
                        />
                      </td>
                      <td>
                        <span class="text-success">Valor Factura</span>
                        <input type="text" name="Valor_factura<?php echo $NumWindow; ?>" id="Valor_factura<?php echo $NumWindow; ?>" disabled
                        />
                      </td>
                    <td>
                      <span class="text-success">Copago</span>
                      <input type="text" name="Copago<?php echo $NumWindow; ?>" id="Copago<?php echo $NumWindow; ?>" disabled
                      />
                    </td>
                    <td>
                      <span class="text-success">Referencia</span>
                      <input type="text" name="Referencia<?php echo $NumWindow; ?>" id="Referencia<?php echo $NumWindow; ?>" disabled
                      />
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
              <div class="col-sm-12">

                <label class="label label-default">Campos</label>
                  <div class="row well well-sm">	
              
              <div class="col-sm-12">
                <div id="zero_detallezWind_2" class=" table-responsive ">
                  <table width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tblDetallezWind_2">
                  <thead id="thDetallezWind_2">
                  <tr id="trhzWind_2"> 
                    <th>Concepto</th><th>Servicios</th><th>Cantidad</th><th>Valor Total</th><th>Centro de Costos</th><th>Valor Glosa</th><th>Observación</th>
                  </tr> 
                  </thead>
                  <tbody id="tbDetallezWind_2">
                  <tr id="tr1zWind_2">
                  <td>
                    <select name="Concepto<?php echo $NumWindow; ?>" id="Concepto<?php echo $NumWindow; ?>" value="text" style="border-width: 0px; background-color: white; font-size: smaller; border-bottom-width: 2px;border-bottom-style: dotted; width: 78px; padding: 5px;" class="form-control">
                      <option value="text">One</option>		
                      <option value="textarea">Two</option>		
                      <option value="check">Three</option>
                    </select>
                  </td>
                    <td>
                      <input type="text" name="Servicios<?php echo $NumWindow; ?>" id="Servicios<?php echo $NumWindow; ?>" value="" style="border-width: 0px; background-color: white; font-size: 11px; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px; text-transform: none;" class="form-control">
                    </td>
                    <td>
                      <input type="number" name="Cantidad<?php echo $NumWindow; ?>" id="Cantidad<?php echo $NumWindow; ?>" value="" style="border-width: 0px; background-color: white; font-size: 11px; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px; text-transform: none;" class="form-control">
                    </td>
                    <td>
                      <input type="number" name="Valor_total<?php echo $NumWindow; ?>" id="Valor_total<?php echo $NumWindow; ?>" value=" " style="border-width: 0px; background-color: white; font-size: 11px; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px; text-transform: none;" class="form-control">
                    </td>
                    <td>
                      <select name="Centro_costos<?php echo $NumWindow; ?>" id="Centro_costos<?php echo $NumWindow; ?>" value="text" style="border-width: 0px; background-color: white; font-size: smaller; border-bottom-width: 2px;border-bottom-style: dotted; width: 78px; padding: 5px;" class="form-control">
                        <option value="text">One</option>		
                        <option value="textarea">Two</option>		
                        <option value="check">Three</option>
                      </select>
                  </td>
                  <td>
                    <input type="number" name="Valor_glosa<?php echo $NumWindow; ?>" id="Valor_glosa<?php echo $NumWindow; ?>" value="12" style="border-width: 0px; background-color: white; font-size: 11px; border-bottom-width: 2px;border-bottom-style: dotted; padding: 5px; text-transform: none;" class="form-control">
                  </td>
                  <td>
                    <textarea name="Observacion<?php echo $NumWindow; ?>" id="Observacion<?php echo $NumWindow; ?>" placeholder="Leave a comment here" id="floatingTextarea"></textarea>
                  </td>
                  </tr>
                </tbody>
                  </table>
                </div>
                <input type="hidden" name="TotRowszWind_2" id="TotRowszWind_2" value="1">
              </div>
                
                </div>
              </div>
        </form>


  <script type="text/javascript">


$("input[type=text]").addClass("form-control");
$("input[type=password]").addClass("form-control");
$("textarea").addClass("form-control");
$("select").addClass("form-control");
$("input[type=date]").addClass("form-control");
$("input[type=number]").addClass("form-control");
$("input[type=time]").addClass("form-control");

    
 $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
 $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
 $("textarea").addClass("hc_<?php echo $NumWindow; ?>");
 $("select").addClass("hc_<?php echo $NumWindow; ?>");
 </script>
  