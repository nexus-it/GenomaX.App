<?php

include '00trnsctns.php';

	if($_POST["CodigoCTA"] == "") {
		$MSG='ERROR: Codigo de cuenta en blanco';
	} else {
		$Nvl=strlen($_POST["CodigoCTA"]);
		if($Nvl>2) {
			if($Nvl==4) {
				$Nvl=3;
			} else {
				if($Nvl==6) {
					$Nvl=4;
				} else {
					$Nvl=5;
				}
			}
		}
		if($_POST["IDTER"] == "") {
			$SQL="Replace Into czcuentascont(Codigo_CTA, Nombre_CTA, Codigo_NVL, ManTer_CTA, CierreTer_CTA, Codigo_TER, ManRet_CTA, ManCC_CTA, Activo_CTA, Concilia_CTA, Disponibilidad_CTA, ManAjuste_CTA, Ajuste_CTA, Correccion_CTA) Values('".$_POST["CodigoCTA"]."', '".$_POST["NombreCTA"]."', '".$Nvl."', '".$_POST["ManTerCTA"]."', '".$_POST["CierreTerCTA"]."', '', '".$_POST["ManRetCTA"]."', '".$_POST["ManCCCTA"]."', '".$_POST["ActivoCTA"]."', '".$_POST["ConciliaCTA"]."', '".$_POST["DisponibilidadCTA"]."', '".$_POST["ManAjusteCTA"]."', '".$_POST["AjusteCTA"]."', '".$_POST["CorreccionCTA"]."');";
		} else {
			$SQL="Replace Into czcuentascont(Codigo_CTA, Nombre_CTA, Codigo_NVL, ManTer_CTA, CierreTer_CTA, Codigo_TER, ManRet_CTA, ManCC_CTA, Activo_CTA, Concilia_CTA, Disponibilidad_CTA, ManAjuste_CTA, Ajuste_CTA, Correccion_CTA) Select '".$_POST["CodigoCTA"]."', '".$_POST["NombreCTA"]."', '".$Nvl."', '".$_POST["ManTerCTA"]."', '".$_POST["CierreTerCTA"]."', Codigo_TER, '".$_POST["ManRetCTA"]."', '".$_POST["ManCCCTA"]."', '".$_POST["ActivoCTA"]."', '".$_POST["ConciliaCTA"]."', '".$_POST["DisponibilidadCTA"]."', '".$_POST["ManAjusteCTA"]."', '".$_POST["AjusteCTA"]."', '".$_POST["CorreccionCTA"]."' from czterceros Where ID_TER='".$_POST["IDTER"]."';";		
		}
		mysqli_free_result($result);
		EjecutarSQL($SQL, $conexion);
		$MSG='Datos registrados correctamente. Cuenta: '.$_POST["CodigoCTA"].' - Nombre: '.$_POST["NombreCTA"];
	
		it_aud('1', 'PUC', 'Cuenta: '.$_POST["CodigoCTA"].' - Nombre: '.$_POST["NombreCTA"].' - Estado: '.$_POST["estado"]);
	}

include '99trnsctns.php';

?>