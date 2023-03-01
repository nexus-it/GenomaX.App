<?php

session_start();

function InterfaceCNT($Proceso, $NumDoc, $Conn) {
    //error_log($Proceso);
    switch ($Proceso) {

        case 'Factura':
            $SQL="Select InterfazFC_XCT From itconfig_ct";
            $result = mysqli_query($Conn, $SQL);
	        if($row = mysqli_fetch_row($result)) {
                //error_log($row[0]);
                if ($row[0]!="") {
                    $CodigoCNT="0";
                    $SQL="Select Codigo_CNT From czmovcontcab Where Codigo_FNC='".$row[0]."' and Consec_FNC='".$NumDoc."'";
                    //error_log($SQL);
                    $result0 = mysqli_query($Conn, $SQL);
                    if($row0 = mysqli_fetch_row($result0)) {
                        $CodigoCNT=$row0['Codigo_CNT'];
                    }
                    mysqli_free_result($result0);
                    $Consec=LoadConsec("czmovcontcab", "Codigo_CNT", $CodigoCNT, $Conn, "Codigo_CNT");
                    $ConsecCNT=$Consec;
                    //error_log('Consec CT:'.$CodigoCNT.'-'.$ConsecCNT);
                    // Se carga el encabezado del Movimento
                    $SQL="Replace Into czmovcontcab(Codigo_CNT, Codigo_FNC, Codigo_TER, Fecha_CNT, Consec_FNC, Referencia_CNT, Observaciones_CNT, Total_CNT) Select '".$ConsecCNT."', '".$row[0]."', b.Codigo_TER, DATE(a.Fecha_FAC), a.Codigo_FAC, CONCAT('Factura de Venta ',a.Codigo_FAC,'. ',b.TipoContrato_EPS), concat('Contrato ', b.Contrato_EPS,'. ',a.Nota_FAC), (a.ValPaciente_FAC + a.ValEntidad_FAC) FROM gxfacturas a, gxeps b, gxadmision c WHERE a.Codigo_EPS=b.Codigo_EPS AND c.Codigo_ADM=a.Codigo_ADM AND a.Codigo_FAC='".$NumDoc."';";
                    EjecutarSQL($SQL, $Conn);
                    // Se eliminan registros anteriores  si existen 
                    $SQL="Delete from czmovcontdet Where Codigo_CNT='".$ConsecCNT."'";
                    EjecutarSQL($SQL, $Conn);
                    // Se crean los registros Contables
                    $SQL="Insert Into czmovcontdet(Codigo_CNT, Codigo_TER, Codigo_CTA, Descripcion_CNT, Codigo_CCT, Debito_CNT, Credito_CNT) Select '".$ConsecCNT."', b.Codigo_TER, c.CxC_TER, CONCAT('Factura de Venta ',a.Codigo_FAC), e.Codigo_CCT, a.ValTotal_FAC, 0 FROM gxfacturas a, gxeps b, czterceros c, gxadmision d, czsedes e WHERE a.Codigo_EPS=b.Codigo_EPS AND c.Codigo_TER=b.Codigo_TER AND d.Codigo_ADM=a.Codigo_ADM AND e.Codigo_SDE=d.Codigo_SDE AND a.Codigo_FAC='".$NumDoc."'";
                    EjecutarSQL($SQL, $Conn);
                    // Cuenta Cont por cada Concepto de Facturacion
                    $SQL="Insert Into czmovcontdet(Codigo_CNT, Codigo_TER, Codigo_CTA, Descripcion_CNT, Codigo_CCT, Debito_CNT, Credito_CNT) Select '".$ConsecCNT."', b.Codigo_TER, i.Codigo_CTA, j.Nombre_CTA, e.Codigo_CCT, 0, SUM(g.ValorServicio_ORD) FROM gxfacturas a, gxeps b, czterceros c, gxadmision d, czsedes e, gxordenescab f, gxordenesdet g, gxservicios h, gxconceptosfactura i, czcuentascont j WHERE a.Codigo_EPS=b.Codigo_EPS AND f.Estado_ORD='1' AND c.Codigo_TER=b.Codigo_TER AND d.Codigo_ADM=a.Codigo_ADM AND e.Codigo_SDE=d.Codigo_SDE AND f.Codigo_ADM=d.Codigo_ADM AND f.Codigo_ORD=g.Codigo_ORD AND g.Codigo_SER=h.Codigo_SER AND i.Codigo_CFC=h.Codigo_CFC AND j.Codigo_CTA=i.Codigo_CTA AND a.Codigo_FAC='".$NumDoc."' GROUP BY '".$ConsecCNT."', b.Codigo_TER, i.Codigo_CTA, j.Nombre_CTA, e.Codigo_CCT";
                    EjecutarSQL($SQL, $Conn);
                    // Cuenta Cont por Copagos y Cuotas Moderadoras
                    $SQL="Select a.Cuota_ADM, a.Copago_ADM FROM gxadmision a WHERE a.Codigo_ADM in (SELECT codigo_adm FROM gxfacturas WHERE codigo_fac='".$NumDoc."')";
                    $resultC = mysqli_query($Conn, $SQL);
                    if($rowC = mysqli_fetch_row($resultC)) {
                        $CuotaM=$rowC[0];
                        $Copago=$rowC[1];
                    }
                    mysqli_free_result($resultC);
                    if ($CuotaM=="1") {
                        $SQL="Insert Into czmovcontdet(Codigo_CNT, Codigo_TER, Codigo_CTA, Descripcion_CNT, Codigo_CCT, Debito_CNT, Credito_CNT) Select '".$ConsecCNT."', b.Codigo_TER, i.CtaCuotaMod_XCT, j.Nombre_CTA, e.Codigo_CCT, SUM(g.ValorPaciente_ORD), 0 FROM gxfacturas a, gxeps b, czterceros c, gxadmision d, czsedes e, gxordenescab f, gxordenesdet g, gxservicios h, itconfig_ct i, czcuentascont j WHERE a.Codigo_EPS=b.Codigo_EPS AND f.Estado_ORD='1' AND c.Codigo_TER=b.Codigo_TER AND d.Codigo_ADM=a.Codigo_ADM AND e.Codigo_SDE=d.Codigo_SDE AND f.Codigo_ADM=d.Codigo_ADM AND f.Codigo_ORD=g.Codigo_ORD AND g.Codigo_SER=h.Codigo_SER AND  j.Codigo_CTA=i.CtaCuotaMod_XCT AND a.Codigo_FAC='".$NumDoc."' GROUP BY '".$ConsecCNT."', b.Codigo_TER, i.CtaCuotaMod_XCT, j.Nombre_CTA, e.Codigo_CCT";
                        EjecutarSQL($SQL, $Conn);
                    }
                    if ($Copago=="1") {
                        $SQL="Insert Into czmovcontdet(Codigo_CNT, Codigo_TER, Codigo_CTA, Descripcion_CNT, Codigo_CCT, Debito_CNT, Credito_CNT) Select '".$ConsecCNT."', b.Codigo_TER, i.CtaCopagos_XCT, j.Nombre_CTA, e.Codigo_CCT, SUM(g.ValorPaciente_ORD), 0 FROM gxfacturas a, gxeps b, czterceros c, gxadmision d, czsedes e, gxordenescab f, gxordenesdet g, gxservicios h, itconfig_ct i, czcuentascont j WHERE a.Codigo_EPS=b.Codigo_EPS AND f.Estado_ORD='1' AND c.Codigo_TER=b.Codigo_TER AND d.Codigo_ADM=a.Codigo_ADM AND e.Codigo_SDE=d.Codigo_SDE AND f.Codigo_ADM=d.Codigo_ADM AND f.Codigo_ORD=g.Codigo_ORD AND g.Codigo_SER=h.Codigo_SER AND j.Codigo_CTA=i.CtaCopagos_XCT AND a.Codigo_FAC='".$NumDoc."' GROUP BY '".$ConsecCNT."', b.Codigo_TER, i.CtaCopagos_XCT, j.Nombre_CTA, e.Codigo_CCT";
                        EjecutarSQL($SQL, $Conn);
                    }
                    it_aud('1', 'Contabilidad', 'Interface Contable Factura '.$NumDoc);
                }
            }
            mysqli_free_result($result);
        break;
        case 'Caja':
            $SQL="Select InterfazFC_XCT From itconfig_ct";
            $result = mysqli_query($Conn, $SQL);
	        if($row = mysqli_fetch_row($result)) {
                //error_log($row[0]);
            }
            mysqli_free_result($result);
            it_aud('1', 'Contabilidad', 'Interface Contable Mov Caja '.$NumDoc);
        break;
        case 'FacTCompra':
            $SQL="Select InterfazCO_XCT From itconfig_ct";
            $result = mysqli_query($Conn, $SQL);
	        if($row = mysqli_fetch_row($result)) {
                //error_log($row[0]);
                if ($row[0]!="") {
                    $SQL="Select Codigo_CNT From czmovcontcab Where Codigo_FNC='".$row[0]."' and Consec_FNC='".$NumDoc."'";
                    //error_log($SQL);
                    $result0 = mysqli_query($Conn, $SQL);
                    if($row0 = mysqli_fetch_row($result0)) {
                        $CodigoCNT=$row0['Codigo_CNT'];
                    }
                    mysqli_free_result($result0);
                    $Consec=LoadConsec("czmovcontcab", "Codigo_CNT", $CodigoCNT, $Conn, "Codigo_CNT");
                    $ConsecCNT=$Consec;
                    //error_log('Consec CT:'.$CodigoCNT.'-'.$ConsecCNT);
                    // Se carga el encabezado del Movimento
                    $SQL="Replace Into czmovcontcab(Codigo_CNT, Codigo_FNC, Codigo_TER, Fecha_CNT, Consec_FNC, Referencia_CNT, Observaciones_CNT, Total_CNT) Select '".$ConsecCNT."', '".$row[0]."', a.Codigo_TER, a.Fecha_FAC, a.Codigo_FAC, CONCAT('Factura de Compra ', a.Consec_FAC), a.Observaciones_FAC, (a.Total_FAC +a.Retencion_FAC) FROM czfacturascompra a WHERE a.Codigo_FAC='".$NumDoc."';";
                    EjecutarSQL($SQL, $Conn);
                    // Se eliminan registros anteriores si existen 
                    $SQL="Delete from czmovcontdet Where Codigo_CNT='".$ConsecCNT."'";
                    EjecutarSQL($SQL, $Conn);
                    // Se crean los registros Contables
                    $SQL="Insert Into czmovcontdet(Codigo_CNT, Codigo_TER, Codigo_CTA, Descripcion_CNT, Codigo_CCT, Debito_CNT, Credito_CNT) Select '".$ConsecCNT."', a.Codigo_TER, b.CxP_TER, CONCAT('Factura de Compra ',a.Consec_FAC), a.Codigo_CCT, 0, a.Total_FAC FROM czfacturascompra a, czterceros b WHERE a.Codigo_TER=b.Codigo_TER and a.Codigo_FAC='".$NumDoc."'";
                    EjecutarSQL($SQL, $Conn);
                    // Cuenta Cont por cada Concepto de la factura
                    $SQL="Insert Into czmovcontdet(Codigo_CNT, Codigo_TER, Codigo_CTA, Descripcion_CNT, Codigo_CCT, Debito_CNT, Credito_CNT) Select '".$ConsecCNT."', b.Codigo_TER, a.Codigo_CTA, a.Nombre_CTA, b.Codigo_CCT, sum(a.Cantidad_FAC * a.Precio_FAC), 0 FROM czfacturascompradet a, czfacturascompra b WHERE a.Codigo_FAC=b.Codigo_FAC AND a.Codigo_FAC='".$NumDoc."' GROUP BY '".$ConsecCNT."', b.Codigo_TER, a.Codigo_CTA, a.Nombre_CTA, b.Codigo_CCT";
                    EjecutarSQL($SQL, $Conn);
                    // Cuenta Cont por cada impuesto agregado
                    $SQL="Insert Into czmovcontdet(Codigo_CNT, Codigo_TER, Codigo_CTA, Descripcion_CNT, Codigo_CCT, Debito_CNT, Credito_CNT) Select '".$ConsecCNT."', b.Codigo_TER, c.CodigoC_CTA, c.Nombre_IVA, b.Codigo_CCT, ((sum(a.Cantidad_FAC * a.Precio_FAC) * c.Porcentaje_IVA)/100), 0 FROM czfacturascompradet a, czfacturascompra b, czimpuestos c WHERE a.Codigo_FAC=b.Codigo_FAC AND c.Codigo_IVA=a.Codigo_IVA AND a.Codigo_FAC='".$NumDoc."' GROUP BY '".$ConsecCNT."', b.Codigo_TER, c.CodigoC_CTA, c.Nombre_IVA, b.Codigo_CCT";
                    EjecutarSQL($SQL, $Conn);
                    // Cuenta Cont por la retencion aplicada
                    $SQL="Insert Into czmovcontdet(Codigo_CNT, Codigo_TER, Codigo_CTA, Descripcion_CNT, Codigo_CCT, Debito_CNT, Credito_CNT) Select distinct '".$ConsecCNT."', b.Codigo_TER, c.Codigo_CTA, c.Nombre_RTE, b.Codigo_CCT, 0, b.Retencion_FAC FROM czfacturascompradet a, czfacturascompra b, czconceptosretencion c WHERE a.Codigo_FAC=b.Codigo_FAC AND b.Codigo_RTE=c.Codigo_RTE AND a.Codigo_FAC='".$NumDoc."'";
                    EjecutarSQL($SQL, $Conn);
                    
                }

            }
            mysqli_free_result($result);

            it_aud('1', 'Contabilidad', 'Interface Contable Factura Compra '.$NumDoc);
        break;
        case 'Egreso':
            $SQL="Select InterfazEG_XCT From itconfig_ct";
            $result = mysqli_query($Conn, $SQL);
	        if($row = mysqli_fetch_row($result)) {
                //error_log($row[0]);
                if ($row[0]!="") {
                    $SQL="Select Codigo_CNT From czmovcontcab Where Codigo_FNC='".$row[0]."' and Consec_FNC='".$NumDoc."'";
                    //error_log($SQL);
                    $result0 = mysqli_query($Conn, $SQL);
                    if($row0 = mysqli_fetch_row($result0)) {
                        $CodigoCNT=$row0['Codigo_CNT'];
                    }
                    mysqli_free_result($result0);
                    $Consec=LoadConsec("czmovcontcab", "Codigo_CNT", $CodigoCNT, $Conn, "Codigo_CNT");
                    $ConsecCNT=$Consec;
                    //error_log('Consec CT:'.$CodigoCNT.'-'.$ConsecCNT);
                    // Se carga el encabezado del Movimento
                    $SQL="Replace Into czmovcontcab(Codigo_CNT, Codigo_FNC, Codigo_TER, Fecha_CNT, Consec_FNC, Referencia_CNT, Observaciones_CNT, Total_CNT) Select '".$ConsecCNT."', '".$row[0]."', a.Codigo_TER, b.Fecha_CXP, a.Consec_FAC, CONCAT('Pago Factura ', a.Codigo_CXP), CONCAT('Saldo ', a.Saldo_CXP ), b.valor_CXP FROM czcxp a, czcxpdet b WHERE a.Codigo_CXP=b.Codigo_CXP AND a.Codigo_CXP='".$NumDoc."';";
                    EjecutarSQL($SQL, $Conn);
                    // Se eliminan registros anteriores si existen 
                    $SQL="Delete from czmovcontdet Where Codigo_CNT='".$ConsecCNT."'";
                    EjecutarSQL($SQL, $Conn);
                    // Se crean los registros Contables
                    $SQL="Insert Into czmovcontdet(Codigo_CNT, Codigo_TER, Codigo_CTA, Descripcion_CNT, Codigo_CCT, Debito_CNT, Credito_CNT) Select '".$ConsecCNT."', a.Codigo_TER, b.CxP_TER, CONCAT('Pago a Factura de Compra ',a.Consec_FAC), a.Codigo_CCT, c.Valor_CXP, 0 FROM czcxp a, czterceros b, czcxpdet c WHERE a.Codigo_CXP=c.Codigo_CXP and a.Codigo_TER=b.Codigo_TER and a.Codigo_FAC='".$NumDoc."'";
                    EjecutarSQL($SQL, $Conn);
                    // Cuenta Cont del banco donde se realiza el pago
                    $SQL="Insert Into czmovcontdet(Codigo_CNT, Codigo_TER, Codigo_CTA, Descripcion_CNT, Codigo_CCT, Debito_CNT, Credito_CNT) Select '".$ConsecCNT."', b.Codigo_TER, c.Codigo_CTA, CONCAT( c.Nombre_BCO, ' ', c.TipoCta_BCO, ' ', c.CuentaNo_BCO), d.Codigo_CCT, 0, a.Valor_CXP FROM czcxpdet a, czcxp b, czbancos c, czfacturascompra d WHERE a.Codigo_CXP=b.Codigo_CXP AND c.Codigo_BCO=a.Codigo_BCO AND d.Codigo_FAC=b.Consec_FAC AND a.Codigo_CXP='".$NumDoc."'";
                    EjecutarSQL($SQL, $Conn);
                    
                }
            }
            mysqli_free_result($result);
        break;

    }
}

?>