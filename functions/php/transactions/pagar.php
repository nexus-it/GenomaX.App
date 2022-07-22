<?php

include '00trnsctns.php';

    $SQL="insert into czcxpdet(Codigo_CXP, Fecha_CXP, Valor_CXP, Codigo_BCO, Codigo_USR) values('".$_POST["Codigo_CXP"]."', '".$_POST["Fecha_CXP"]."', '".$_POST["Valor_CXP"]."', '".$_POST["Codigo_BCO"]."', '".$_SESSION["it_CodigoUSR"]."' )";
    EjecutarSQL($SQL, $conexion);
    $SQL="Update czcxp Set Pagado_CXP=Pagado_CXP+".$_POST["Valor_CXP"].", Saldo_CXP=Saldo_CXP-".$_POST["Valor_CXP"]." Where Codigo_CXP='".$_POST["Codigo_CXP"]."'";
    EjecutarSQL($SQL, $conexion);
    
	it_aud('1', 'CxP Pago Realizado', 'Código No. '.$_POST["Codigo_CXP"]);

    InterfaceCNT("Egreso", $_POST["Codigo_CXP"], $conexion);

include '99trnsctns.php';

?>