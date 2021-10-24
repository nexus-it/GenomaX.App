<?php 

    session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
    include '../../functions/php/nexus/api.php'; 
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");


    $datosEmp = validarRegistroEmp(verficarEmpresaReg());
    

?>
<script src="../../functions/nxs-js/jquery-1.7.1.min.js"></script>




<form  method="POST" name="frm_form<?php echo $NumWindow; ?>" id="frm_form<?php echo $NumWindow; ?>" class="form-horizontal container" >


<div class="col-md-12">

	<label class="label label-default">Datos de Empresa</label>
	<div class="row well well-sm">

            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_Nit<?php echo $NumWindow; ?>">Nit</label>
                    <div class="input-group">
                        <input name="txt_Nit<?php echo $NumWindow; ?>" type="text" id="txt_Nit<?php echo $NumWindow; ?>" value="<?php echo  $datosEmp["identification_number"]; ?>" />
                    </div>
                </div> 
            </div>
            <div class="col-md-3">  
                <label for="txt_DV<?php echo $NumWindow; ?>">DV</label>  
                <div class="form-group">   
                    <div class="input-group">
                        <input name="txt_DV<?php echo $NumWindow; ?>" type="text" id="txt_DV<?php echo $NumWindow; ?>" value="<?php echo  $datosEmp["dv"]; ?>" />
                    </div>
                </div>
            </div>
            <div class="col-md-3">  
                <label for="txt_tipoDI<?php echo $NumWindow; ?>">Tipo de Identificacion</label>  
                <div class="form-group">   
                        <select name="txt_tipoDI<?php echo $NumWindow; ?>" id="txt_tipoDI<?php echo $NumWindow; ?>">
                        <option></option>
                        <?php $tipoDI = llenarSelect("SELECT * FROM `Billing`.`type_document_identifications`","SELECT * FROM `Billing`.`type_document_identifications` where id = ".$datosEmp["type_document_identification_id"]); 
                        foreach($tipoDI as $tipoDIs){
                            echo $tipoDIs;
                        }
                        ?>
                        </select>
                    
                </div>
            </div>
            
            <div class="col-md-3">  
                <label for="txt_tipoOrg<?php echo $NumWindow; ?>">Tipo Organizacion</label>  
                <div class="form-group">   
                    
                        <select name="txt_tipoOrg<?php echo $NumWindow; ?>" id="txt_tipoOrg<?php echo $NumWindow; ?>">
                        <option></option>
                        <?php $tipoOrg = llenarSelect("SELECT * FROM `Billing`.`type_organizations`", "SELECT * FROM `Billing`.`type_organizations` where id =".$datosEmp["type_organization_id"]); 
                        foreach($tipoOrg as $tipoOrgs){
                            echo $tipoOrgs;
                        }
                        ?>
                        </select>
                    
                </div>
            </div>            
            
            <div class="col-md-2">  
                <label for="txt_tipoReg<?php echo $NumWindow; ?>">Tipo Regimen</label>  
                <div class="form-group">   
                    
                        <select name="txt_tipoReg<?php echo $NumWindow; ?>" id="txt_tipoReg<?php echo $NumWindow; ?>">
                        <option></option>
                        <?php $tipoReg = llenarSelect("SELECT * FROM `Billing`.`type_regimes`", "SELECT * FROM `Billing`.`type_regimes` where id =".$datosEmp["type_regime_id"]); 
                        foreach($tipoReg as $tipoRegs){
                            echo $tipoRegs;
                        }
                        ?>
                        </select>
                    
                </div>
            </div> 

            <div class="col-md-3">  
                <label for="txt_tipoRes<?php echo $NumWindow; ?>">Tipo Responsabilidad</label>  
                <div class="form-group">   
                    
                        <select name="txt_tipoRes<?php echo $NumWindow; ?>" id="txt_tipoRes<?php echo $NumWindow; ?>">
                        <option></option>
                        <?php $tipoRes = llenarSelect("SELECT * FROM `Billing`.`type_liabilities`","SELECT * FROM `Billing`.`type_liabilities` where id = ".$datosEmp["type_liability_id"]); 
                        foreach($tipoRes as $tipoRess){
                            echo $tipoRess;
                        }
                        ?>
                        </select>
                    
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_Razon<?php echo $NumWindow; ?>">Razon Social</label>
                    <div class="input-group">
                        <input name="txt_Razon<?php echo $NumWindow; ?>" type="text" id="txt_Razon<?php echo $NumWindow; ?>" value="<?php echo  $datosEmp["name"]; ?>" />
                    </div>
                </div> 
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_Rm<?php echo $NumWindow; ?>">Registro Mercantil</label>
                    <div class="input-group">
                        <input name="txt_Rm<?php echo $NumWindow; ?>" type="text" id="txt_Rm<?php echo $NumWindow; ?>" value="<?php echo  $datosEmp["merchant_registration"]; ?>" />
                    </div>
                </div> 
            </div>

            <div class="col-md-3">  
                <label for="txt_Municipio<?php echo $NumWindow; ?>">Municipio</label>  
                <div class="form-group">   
                    
                        <select name="txt_Municipio<?php echo $NumWindow; ?>" id="txt_Municipio<?php echo $NumWindow; ?>">
                        <option></option>
                        <?php $Municipio = llenarSelect("SELECT id,name FROM `Billing`.`municipalities`", "SELECT id,name FROM `Billing`.`municipalities` where id=".$datosEmp["municipality_id"]); 
                        foreach($Municipio as $Municipios){
                            echo $Municipios;
                        }
                        ?>
                        </select>
                    
                </div>
            </div>


            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_Dir<?php echo $NumWindow; ?>">Direccion</label>
                    <div class="input-group">
                        <input name="txt_Dir<?php echo $NumWindow; ?>" type="text" id="txt_Dir<?php echo $NumWindow; ?>" value="<?php echo  $datosEmp["address"]; ?>"  />
                    </div>
                </div> 
            </div>


            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_Tel<?php echo $NumWindow; ?>">Telefono</label>
                    <div class="input-group">
                        <input name="txt_Tel<?php echo $NumWindow; ?>" type="text" id="txt_Tel<?php echo $NumWindow; ?>" value="<?php echo  $datosEmp["phone"]; ?>" />
                    </div>
                </div> 
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_Email<?php echo $NumWindow; ?>">Correo</label>
                    <div class="input-group">
                        <input name="txt_Email<?php echo $NumWindow; ?>" type="text" id="txt_Email<?php echo $NumWindow; ?>" value="<?php echo  $datosEmp["email"]; ?>" />
                    </div>
                </div> 
            </div>

    </div>
</div>

	
<div class="col-md-2">
    <div class="form-group">
        <input type="button" name="enviar" value="Registrar / Actualizar Empresa" onclick="enviarDatosEmpresa()"  >
        
    </div>
    <div id="resultado"></div>
</div>

</form>


<p></p>

<div class="col-md-12">

	<label class="label label-default">Registrar Software</label>
	<div class="row well well-sm">

            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_Id<?php echo $NumWindow; ?>">Id</label>
                    <div class="input-group">
                        <input name="txt_Id<?php echo $NumWindow; ?>" type="text" id="txt_Id<?php echo $NumWindow; ?>" value="<?php echo  $datosEmp["identifier"]; ?>" />
                    </div>
                </div> 
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_Pin<?php echo $NumWindow; ?>">Pin</label>
                    <div class="input-group">
                        <input name="txt_Pin<?php echo $NumWindow; ?>" type="text" id="txt_Pin<?php echo $NumWindow; ?>" value="<?php echo  $datosEmp["pin"]; ?>" />
                    </div>
                </div> 
            </div>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
        <input type="button" name="enviar" value="Registrar / Actualizar Software" onclick="registrarSoftware()"  >
        
    </div>
    <div id="resultadoRegSoft"></div>
</div>



<p></p>


<div class="col-md-12">

	<label class="label label-default">Registrar Certificado</label>
	<div class="row well well-sm">

            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_Id<?php echo $NumWindow; ?>">Certificado</label>
                    <div class="input-group">
                        <textarea name="txt_Certificado<?php echo $NumWindow; ?>" id="txt_Certificado<?php echo $NumWindow; ?>" cols="30" rows="10" ><?php echo  $datosEmp["name"]; ?></textarea>
                    </div>
                </div> 
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_Password<?php echo $NumWindow; ?>">Password</label>
                    <div class="input-group">
                        <input name="txt_Password<?php echo $NumWindow; ?>" type="text" id="txt_Password<?php echo $NumWindow; ?>"  value="<?php echo  $datosEmp["password"]; ?>" />
                    </div>
                </div> 
            </div>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
        <input type="button" name="send" id="send" value="Registrar / Actualizar Certificado"  >
        
    </div>
    <div id="resultadoRegCert"></div>
</div>



<p></p>


<div class="col-md-12">

	<label class="label label-default">Registrar Resolucion</label>
	<div class="row well well-sm">

            <div class="col-md-3">  
                <label for="txt_TipoDoc<?php echo $NumWindow; ?>">Tipo de documento</label>  
                <div class="form-group">   
                    
                        <select name="txt_TipoDoc<?php echo $NumWindow; ?>" id="txt_TipoDoc<?php echo $NumWindow; ?>">
                        <option></option>
                        <?php $TipoDoc = llenarSelect("SELECT * FROM `Billing`.`type_documents` ",""); 
                        foreach($TipoDoc as $TipoDocs){
                            echo $TipoDocs;
                        }
                        ?>
                        </select>
                    
                </div>
            </div>                

            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_Prefijo<?php echo $NumWindow; ?>">Prefijo</label>
                    <div class="input-group">
                        <input name="txt_Prefijo<?php echo $NumWindow; ?>" type="text" id="txt_Prefijo<?php echo $NumWindow; ?>"  />
                    </div>
                </div> 
            </div>
            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_Resolucion<?php echo $NumWindow; ?>">Resolucion</label>
                    <div class="input-group">
                        <input name="txt_Resolucion<?php echo $NumWindow; ?>" type="text" id="txt_Resolucion<?php echo $NumWindow; ?>"  />
                    </div>
                </div> 
            </div>

            <div class="col-md-2">
                <div class="form-group">
                <label for="txt_FechaRes<?php echo $NumWindow; ?>">Fecha Resolucion</label>
                <input name="txt_FechaRes<?php echo $NumWindow; ?>" type="date" disable="disabled" id="txt_FechaRes<?php echo $NumWindow; ?>" >
                </div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_LlaveTecnica<?php echo $NumWindow; ?>">Llave tecnica</label>
                    <div class="input-group">
                        <input name="txt_LlaveTecnica<?php echo $NumWindow; ?>" type="text" id="txt_LlaveTecnica<?php echo $NumWindow; ?>"  />
                    </div>
                </div> 
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_NumDesde<?php echo $NumWindow; ?>">Numeracion desde</label>
                    <div class="input-group">
                        <input name="txt_NumDesde<?php echo $NumWindow; ?>" type="text" id="txt_NumDesde<?php echo $NumWindow; ?>"  />
                    </div>
                </div> 
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    <label for="txt_NumHasta<?php echo $NumWindow; ?>">Numeracion hasta</label>
                    <div class="input-group">
                        <input name="txt_NumHasta<?php echo $NumWindow; ?>" type="text" id="txt_NumHasta<?php echo $NumWindow; ?>"  />
                    </div>
                </div> 
            </div>

            <div class="col-md-2">
                <div class="form-group">
                <label for="txt_FechaNumdesde<?php echo $NumWindow; ?>">Fecha Numeracion desde</label>
                <input name="txt_FechaNumdesde<?php echo $NumWindow; ?>" type="date" disable="disabled" id="txt_FechaNumdesde<?php echo $NumWindow; ?>" >
                </div>
            </div>            
            
            <div class="col-md-2">
                <div class="form-group">
                <label for="txt_FechaNumhasta<?php echo $NumWindow; ?>">Fecha Numeracion hasta</label>
                <input name="txt_FechaNumhasta<?php echo $NumWindow; ?>" type="date" disable="disabled" id="txt_FechaNumhasta<?php echo $NumWindow; ?>" >
                </div>
            </div>   
    </div>
    
</div>




<div class="col-md-2">
    <div class="form-group">
        <input type="button" name="sendResolucion" id="sendResolucion" value="Registrar / Actualizar Resolucion de factura"  >
        
    </div>
    <div id="resultadoResolucion"></div>
</div>


<div class="col-md-12">
    <?php echo validarRegistroEmpRes(verficarEmpresaReg()); ?>
</div>

<script>
function enviarDatosEmpresa(){
    //alert("entro en la funcion");
    var nit= document.getElementById('txt_Nit<?php echo $NumWindow; ?>').value;
    var dv= document.getElementById('txt_DV<?php echo $NumWindow; ?>').value;
    var tipodi= document.getElementById('txt_tipoDI<?php echo $NumWindow; ?>').value;
    var tipoorg= document.getElementById('txt_tipoOrg<?php echo $NumWindow; ?>').value;
    var tiporeg= document.getElementById('txt_tipoReg<?php echo $NumWindow; ?>').value;
    var tipores= document.getElementById('txt_tipoRes<?php echo $NumWindow; ?>').value;
    var razon= document.getElementById('txt_Razon<?php echo $NumWindow; ?>').value;
    var rm= document.getElementById('txt_Rm<?php echo $NumWindow; ?>').value;
    var municipio= document.getElementById('txt_Municipio<?php echo $NumWindow; ?>').value;
    var dir= document.getElementById('txt_Dir<?php echo $NumWindow; ?>').value;
    var tel= document.getElementById('txt_Tel<?php echo $NumWindow; ?>').value;
    var email= document.getElementById('txt_Email<?php echo $NumWindow; ?>').value;
    
    var dataen = 'nit='+nit+'&dv='+dv+'&tipodi='+tipodi+'&tipoorg='+tipoorg+'&tiporeg='+tiporeg+'&tipores='+tipores+'&razon='+razon+'&rm='+rm+'&municipio='+municipio+'&dir='+dir+'&tel='+tel+'&email='+email;
    //alert(dataen);
    $.ajax({
        type:'POST',
        url:'application/forms/datosempresa_g.php',
        data: dataen,
        success:function(resp){
            $("#resultado").html(resp)
        }
    });
    return false;
}


function registrarSoftware(){
    //alert("entro en la funcion");
    var id= document.getElementById('txt_Id<?php echo $NumWindow; ?>').value;
    var pin= document.getElementById('txt_Pin<?php echo $NumWindow; ?>').value;
    
    
    var dataen = 'id='+id+'&pin='+pin;
    //alert(dataen);
    $.ajax({
        type:'POST',
        url:'application/forms/datosempresa_g.php',
        data: dataen,
        success:function(resp){
            $("#resultadoRegSoft").html(resp)
        }
    });
    return false;
}


function registrarCertificado(){
    //alert("entro en la funcion");
    var certificado= document.getElementById('txt_Certificado<?php echo $NumWindow; ?>').value;
    var password= document.getElementById('txt_Password<?php echo $NumWindow; ?>').value;
    
    
    var dataen = 'certificado='+certificado+'&password='+password;
    //alert(dataen);
    $.ajax({
        type:'POST',
        url:'application/forms/datosempresa_g.php',
        data: dataen,
        success:function(resp){
            $("#resultadoRegCert").html(resp)
        }
    });
    return false;
}


function putCertificate(certificado,password){
    $.ajax({
            type: 'POST',
            url: '../../functions/php/GenomaXBackend/putCertificate.php',
            data: {
              certificado: certificado,
              password:password

            },
            beforeSend: function()
             {
                
             },

              success: function (data) {
                
                $("#resultadoRegCert").html("Certificado Creado / Acualizado con exito")

              },
              error: function() { 
                console.log(data);
              }
            });

   }


$(document).ready(function() {
           $( "#send" ).click(function() {
              putCertificate($("#txt_Certificado<?php echo $NumWindow; ?>").val(),$("#txt_Password<?php echo $NumWindow; ?>").val());
            });
      });



function putResolution(TipoDoc,Prefijo,Resolucion,FechaRes,LlaveTecnica,NumDesde,NumHasta,FechaNumdesde,FechaNumhasta){
    $.ajax({
            type: 'POST',
            url: '../../functions/php/GenomaXBackend/putResolution.php',
            data: {
                TipoDoc: TipoDoc,
                Prefijo:Prefijo,
                Resolucion:Resolucion,
                FechaRes:FechaRes,
                LlaveTecnica:LlaveTecnica,
                NumDesde:NumDesde,
                NumHasta: NumHasta,
                FechaNumdesde: FechaNumdesde,
                FechaNumhasta:FechaNumhasta

            },
            beforeSend: function()
             {
                
             },

              success: function (data) {
                
                $("#resultadoResolucion").html("Resolucion Creada / Acualizado con exito")

              },
              error: function() { 
                console.log(data);
              }
            });

   }


$(document).ready(function() {
           $( "#sendResolucion" ).click(function() {
              putResolution($("#txt_TipoDoc<?php echo $NumWindow; ?>").val(),
                            $("#txt_Prefijo<?php echo $NumWindow; ?>").val(),
                            $("#txt_Resolucion<?php echo $NumWindow; ?>").val(),
                            $("#txt_FechaRes<?php echo $NumWindow; ?>").val(),
                            $("#txt_LlaveTecnica<?php echo $NumWindow; ?>").val(),
                            $("#txt_NumDesde<?php echo $NumWindow; ?>").val(),
                            $("#txt_NumHasta<?php echo $NumWindow; ?>").val(),
                            $("#txt_FechaNumdesde<?php echo $NumWindow; ?>").val(),
                            $("#txt_FechaNumhasta<?php echo $NumWindow; ?>").val()
                            );
            });
      });


</script>

<?php

/*
$url = 'https://backend.estrateg.com/nexusIt/public/api/ubl2.1/config/901508950/2';
$metodo = 'POST'; 
$datos = '{
    "type_document_identification_id": 3,
    "type_organization_id": 2,
    "type_regime_id": 2,
    "type_liability_id": 14,
    "business_name": "TECNOWEBS S.A.S.",
    "merchant_registration": "0000000-00",
    "municipality_id": 820,
    "address": "CALLE 27 NO 12 - 34 apo1",
    "phone": 3007715934,
    "email": "ing.leandro.castro@gmail.com"
  }';
$autorizacion = '5de658704d41e7f34cdb752ed5d3379301b9fabcc7604b894904b3953b1bfeec';

$result = llamarApi($url,$metodo,$datos,$autorizacion);

$data =  json_decode($result,true);
echo $data["success"];

*/
