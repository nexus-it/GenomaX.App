<?php

include '00trnsctns.php';

	$Consec=LoadConsec("czfacturascompra", "Codigo_FAC", $_POST['Codigo_FAC'], $conexion, "Codigo_FAC");
	
    $SQL="Replace into czfacturascompra(Codigo_FAC, Codigo_TER, Consec_FAC, Fecha_FAC, Vence_FAC, Codigo_CCT, Observaciones_FAC, Codigo_RTE, Subtotal_FAC, Descuento_FAC, Impuestos_FAC, Retencion_FAC, Total_FAC) Select '".$Consec."', Codigo_TER, '".$_POST["Consec_FAC"]."', '".$_POST["Fecha_FAC"]."', '".$_POST["Vence_FAC"]."', '".$_POST["Codigo_CCT"]."', '".$_POST["Observaciones_FAC"]."', '".$_POST["Codigo_RTE"]."', '".$_POST["Subtotal_FAC"]."', '0', '".$_POST["Impuestos_FAC"]."', '".$_POST["Retencion_FAC"]."', '".$_POST["Total_FAC"]."' From czterceros Where ID_TER='".$_POST['Codigo_TER']."'";
    EjecutarSQL($SQL, $conexion);
	$contador=0; 
	while($contador <= $_POST['hdn_controw']) { 
		$contador++;
		if (isset($_POST['Total_FAC'.$contador])) {
            if ($_POST['Total_FAC'.$contador]!="0") {
                $SQL="Insert into czfacturascompradet(Codigo_FAC, Codigo_CTA, Nombre_CTA, Precio_FAC, Codigo_IVA, Cantidad_FAC, Nota_FAC, Total_FAC) Values ('".$Consec."', '".$_POST["Codigo_CTA".$contador]."', '".$_POST["Nombre_CTA".$contador]."', '".$_POST["Precio_FAC".$contador]."', '".$_POST["Codigo_IVA".$contador]."', '".$_POST["Cantidad_FAC".$contador]."', '".$_POST["Nota_FAC".$contador]."', '".$_POST["Total_FAC".$contador]."')";
                EjecutarSQL($SQL, $conexion);
            }
		}
	}

	$ConsecCXP=LoadConsec("czcxp", "Codigo_CXP", 'X', $conexion, "Codigo_CXP");
	$SQL="Insert into czcxp(Codigo_CXP, Codigo_TER, Consec_FAC, Fecha_FAC, Vence_FAC, Referencia_CXP, Valor_FAC, Pagado_CXP, Saldo_CXP) Select '".$ConsecCXP."', Codigo_TER, '".$_POST["Consec_FAC"]."', '".$_POST["Fecha_FAC"]."', '".$_POST["Vence_FAC"]."', '".$_POST["Observaciones_FAC"]."', '".$_POST["Total_FAC"]."', '0', '".$_POST["Total_FAC"]."' From czterceros Where ID_TER='".$_POST['Codigo_TER']."'";
	EjecutarSQL($SQL, $conexion);

	it_aud('1', 'Factura Compra', 'Código No. '.$Consec);

    InterfaceCNT("FacTCompra", $Consec, $conexion);

include '99trnsctns.php';

?>