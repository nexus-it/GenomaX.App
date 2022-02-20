<?php

session_start();

function InterfaceCNT($Proceso, $NumDoc, $Conn) {
    error_log($Proceso);
    switch ($Proceso) {

        case 'Factura':
            $SQL="Select InterfazFC_XCT From itconfig_ct";
            $result = mysqli_query($Conn, $SQL);
	        if($row = mysqli_fetch_row($result)) {
                error_log($row[0]);
                if ($row[0]!="") {
                    $CodigoCNT="0";
                    $SQL="Select Codigo_CNT From czmovcontcab Where Codigo_FNC='".$row[0]."' and Consec_FNC='".$NumDoc."'";
                    error_log($SQL);
                    $result0 = mysqli_query($Conn, $SQL);
                    if($row0 = mysqli_fetch_row($result0)) {
                        $CodigoCNT=$row0['Codigo_CNT'];
                    }
                    mysqli_free_result($result0);
                    $Consec=LoadConsec("czmovcontcab", "Codigo_CNT", $CodigoCNT, $Conn, "Codigo_CNT");
                    $ConsecCNT=$Consec;
                    error_log('Consec CT:'.$ConsecCNT);
                    // Se carga el encabezado del Movimento
                    $SQL="Replace Into czmovcontcab(Codigo_CNT, Codigo_FNC, Codigo_TER, Fecha_CNT, Consec_FNC, Referencia_CNT, Observaciones_CNT, Total_CNT) Select '".$ConsecCNT."', '".$row[0]."', b.Codigo_TER, DATE(a.Fecha_FAC), a.Codigo_FAC, CONCAT('Factura de Venta ',a.Codigo_FAC,'. ',b.TipoContrato_EPS), concat('Contrato ', b.Contrato_EPS,'. ',a.Nota_FAC), a.ValTotal_FAC FROM gxfacturas a, gxeps b, gxadmision c WHERE a.Codigo_EPS=b.Codigo_EPS AND c.Codigo_ADM=a.Codigo_ADM AND a.Codigo_FAC='".$NumDoc."';";
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
                    it_aud('1', 'Contabilidad', 'Interface Contable Factura '.$NumDoc);
                }
            }
            mysqli_free_result($result);
        break;
        case 'Caja':
            $SQL="Select InterfazFC_XCT From itconfig_ct";
            $result = mysqli_query($Conn, $SQL);
	        if($row = mysqli_fetch_row($result)) {

            }
            mysqli_free_result($result);
        break;

    }
}

?>