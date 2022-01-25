<?php

include '00trnsctns.php';

$SQL="Select Estado_AGE from gxagendadet where Codigo_AGE='".$_POST['agenda']."' and Fecha_AGE='".$_POST['fechaage']."' and Hora_AGE='".$_POST['horaage']."' and Estado_AGE='0'";
// error_log($SQL);
$resultx = mysqli_query($conexion, $SQL);
if($rowx = mysqli_fetch_row($resultx)) {
    $Consec=LoadConsec("gxcitasmedicas", "Codigo_CIT", "X", $conexion, "Codigo_CIT");
    $SQL="Insert Into gxcitasmedicas (Codigo_CIT, Codigo_AGE, Codigo_TER, Fecha_AGE, Hora_AGE, FechaDeseada_CIT, FechaGraba_CIT, Codigo_USR, Estado_CIT, TipoConsulta_CIT, Nota_CIT, Codigo_TAH, Codigo_SER) Select '".$Consec."', '".$_POST['agenda']."', a.Codigo_TER, '".$_POST['fechaage']."', '".$_POST['horaage']."', '".$_POST['fecha']."', curdate(), '".$_SESSION["it_CodigoUSR"]."', 'P', '".$_POST['primeravez']."', '".$_POST['nota']."', '".$_POST['tipoatencion']."', '".$_POST['codigo']."' From czterceros a where a.ID_TER='".$_POST['idhc']."';";
    // error_log($SQL);
    EjecutarSQL($SQL, $conexion);
    $SQL="Update gxagendadet Set Estado_AGE='1' where Codigo_AGE='".$_POST['agenda']."' and Fecha_AGE='".$_POST['fechaage']."' and Hora_AGE='".$_POST['horaage']."' and Estado_AGE='0';";
    // error_log($SQL);
    EjecutarSQL($SQL, $conexion);
    if ($MSG=='Datos registrados correctamente. ') {
        $MSG='Se ha programado correctamente la cita '.$Consec;
        it_aud('1', 'Agenda Médica', 'Asignación Cita '.$Consec);
    }
} else {
    $MSG='El cupo ya fue asignado con anterioridad. Asigne un nuevo horario al paciente.';
}

include '99trnsctns.php';

?>