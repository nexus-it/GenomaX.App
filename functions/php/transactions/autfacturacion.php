<?php

include '00trnsctns.php';

$Consec=LoadConsec("czautfacturacion", "Codigo_AFC", $_POST['codigo'], $conexion, "Codigo_AFC");
$SQL="Insert into czautfacturacion(Codigo_DCD,Codigo_AFC,Prefijo_AFC,Descripcion_AFC,Tipo_AFC,ConsecIni_AFC,ConsecFin_AFC,ConsecNow_AFC,FechaIni_AFC,FechaFin_AFC,AvisoAntesDe_AFC,Resolucion_AFC,Fecha_AFC,ClaveTecnica_AFC,IdFormSiigo_AFC,Separador_AFC,Ceros_AFC,Estado_AFC) VALUES (0,'".$Consec."', '".$_POST['prefijo']."','".$_POST['descripcion']."','".$_POST['tipoaut']."','".$_POST['consecini']."','".$_POST['consecfin']."','".$_POST['actual']."','".$_POST['fechaini']."','".$_POST['fechaFin']."', '".$_POST['aviso']."', '".$_POST['resolucion']."', '".$_POST['fecha']."', '".$_POST['ctecnica']."', '0', '-','1');";
EjecutarSQL($SQL, $conexion);

it_aud('1', 'Autorzacion de Reolucion', 'Creación de autorizacion No.'.$Consec);

include '99trnsctns.php';

?>