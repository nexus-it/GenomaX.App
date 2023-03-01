<?php

include '00trnsctns.php';
$Modulo=$_POST["Module"];
//error_log($Modulo);
switch ($Modulo) {

    case 'Facturacion':
        $SQL="Select Codigo_FAC From gxfacturas Where Estado_FAC='1' Order By Fecha_FAC";
        //error_log($SQL);
        $resultict = mysqli_query($conexion, $SQL);
        while ($rowict = mysqli_fetch_row($resultict)) {
            InterfaceCNT('Factura', $rowict[0], $conexion);
        }
        mysqli_free_result($resultict);
    break;

}

include '99trnsctns.php';

?>