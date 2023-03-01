<?php
session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>

<div class="col-md-12panel panel-default" id="pctehis<?php echo $NumWindow; ?>">
    <div id="zero_detalle<?php echo $NumWindow; ?>" class="detallecx table-responsive panel-body" >
        <table  width="99%" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle table-bordered" id="tbDetCitas<?php echo $NumWindow; ?>" >
        <tbody id="tbDetallemar<?php echo $NumWindow; ?>">
        <?php 
         $SQL="Select Codigo_TER, Nombre_TER from czterceros Where ID_TER='".$_GET["IdPte"]."'";
         $result = mysqli_query($conexion, $SQL);
		 if($row = mysqli_fetch_array($result)) {
            $CodTerH=$row[0];
        ?>
        <tr><td align="center" colspan="9"><h3><b><?php echo $row[1]; ?></b> 
          Id.: <?php echo $_GET["IdPte"]; ?></h3></td></tr>
        <tr><td align="center" colspan="9"><h3><em>Histórico de citas</em></h3></td></tr>
        <?php 
         }
         mysqli_free_result($result);
        ?>
        <tr id="trh<?php echo $NumWindow; ?>"> 
            <th >Fecha</th> 
            <th >Hora</th> 
            <th >Area</th> 
            <th >Especialidad</th> 
            <th >Profesional</th> 
            <th >Fecha Deseada</th> 
            <th >Fecha Registro</th> 
            <th >Estado</th> 
            <th >Observaciones</th> 
        </tr> 
        <?php 
         $kontHis=0;
         $SQL="SELECT sql_rpt from itreports where codigo_rpt='citasxpcte'";
        $result = mysqli_query($conexion, $SQL);
        if ($row = mysqli_fetch_row($result)) {
            $SQL=$row[0];
            $SQL=str_replace("@PACIENTE",$_GET["IdPte"],$SQL);
        }
        mysqli_free_result($result);

         // $SQL="SELECT distinct a.Fecha_AGE, a.Hora_AGE, c.Nombre_ARE, d.Nombre_ESP, e.Nombre_TER, a.FechaDeseada_CIT,          a.FechaGraba_CIT, case a.Estado_CIT when 'P' then 'Programada' when 'X' then 'Cancelada' ELSE 'Reprogramada' end, CONCAT(a.Nota_CIT,' ', a.NotaCancela_CIT)          FROM gxcitasmedicas a, gxagendacab b, gxareas c, gxespecialidades d, czterceros e          WHERE a.Codigo_AGE=b.Codigo_AGE AND c.Codigo_ARE=b.Codigo_ARE AND d.Codigo_ESP=b.Codigo_ESP          AND e.Codigo_TER=b.Codigo_TER AND a.Codigo_TER='".$CodTerH."' Order By 1,2";
         // error_log($SQL);
         $result = mysqli_query($conexion, $SQL);
         while($row = mysqli_fetch_array($result)) {
            $kontHis++;
            $klase='';
            if ($row["ESTADO"]=="REPROGRAMADA") {
                $klase='class="info"';
            } else {
                if ($row["ESTADO"]=="CANCELADA") {
                    $klase='class="danger"';
                } else {
                    if ($row["ESTADO"]=="ATENDIDO") {
                        $klase='class="active"';
                    } else {
                        if ($row["ESTADO"]=="NO ASISTE") {
                            $klase='class="warning"';
                        }
                    }
                }
            }
        ?>
        <tr <?php echo $klase; ?>>
         <td><?php echo $row["FECHA CITA"]; ?></td>
         <td><?php echo $row["TURNO"]; ?></td>
         <td><?php echo $row["AREA"]; ?></td>
         <td><?php echo $row["ESPECIALIDAD"]; ?></td>
         <td><?php echo $row["NOMBRE DEL MEDICO"]; ?></td>
         <td><?php echo $row["FECHA DESEADA"]; ?></td>
         <td><?php echo $row["FECHA ASIGNACION"]; ?></td>
         <td><?php echo $row["ESTADO"]; ?></td>
         <td><?php echo $row["OBSERVACIONES"]; ?></td>   
        </tr>
        <?php 
         }
         mysqli_free_result($result);
        ?>
        <input name="hdn_controwcitas<?php echo $NumWindow; ?>" type="hidden" id="hdn_controwcitas<?php echo $NumWindow; ?>" value="<?php echo $kontHis; ?>">
        </tbody>
        </table>
    </div>
    
</div>
		

<script >


    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");
	$("input[type=time]").addClass("form-control");
	$("input[type=date]").addClass("form-control");


    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
