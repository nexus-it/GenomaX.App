<?php
$Where= " ";
if ($_GET['cond']!='NULL') {
	$Where=" and ".str_replace("*","'",$_GET['cond']);
	$Where=str_replace("!"," ",$Where);
	$Where=str_replace("__"," ",$Where);
}
switch ($_GET['req']) {
case 'Paciente':
	$SQL="id_ter as Documento, nombre1_pac as 'Primer Nombre', nombre2_pac as 'Segundo Nombre', apellido1_pac as 'Primer Apellido', apellido2_pac as 'Segundo Apellido' from czterceros a, gxpacientes b where a.codigo_ter=b.codigo_ter".$Where;
	$SQLx="id_ter, nombre1_pac, nombre2_pac, apellido1_pac, apellido2_pac from czterceros a, gxpacientes b where a.codigo_ter=b.codigo_ter".$Where;
break;

case 'PagosCartera':
	$SQL="a.Codigo_PGS as 'Consecutivo', b.Nombre_TER as 'Tercero', a.Fecha_PGS as 'Periodo', a.Total_PGS as 'Valor Pagado' FROM czpagosenc a, czterceros b WHERE a.Estado_PGS <>'0' AND a.Codigo_TER=b.Codigo_TER".$Where;
	$SQLx="a.Codigo_PGS, b.Nombre_TER, a.Fecha_PGS, a.Total_PGS FROM czpagosenc a, czterceros b WHERE a.Estado_PGS <>'0' AND a.Codigo_TER=b.Codigo_TER".$Where;
break;

case 'Tercero':
	$SQL="ID_TER as ID, nombre_ter as 'Nombre Tercero' from czterceros where 1=1".$Where;
	$SQLx="ID_TER, nombre_ter from czterceros where 1=1".$Where;
break;

case 'PUC':
	$SQL="Codigo_CTA as 'Cuenta', Nombre_CTA as 'Nombre Cuenta' from czcuentascont where 1=1".$Where;
	$SQLx="Codigo_CTA, Nombre_CTA from czcuentascont where 1=1".$Where;
break;

case 'Departamentos':
	$SQL="Codigo_DEP as Codigo, nombre_DEP as 'Departamento' from czdepartamentos where 1=1".$Where;
	$SQLx="Codigo_DEP, nombre_DEP from czdepartamentos where 1=1".$Where;
break;

case 'Municipios':
	$SQL="Codigo_MUN as Codigo, Nombre_MUN as 'Municipio' from czmunicipios where 1=1".$Where;
	$SQLx="Codigo_MUN, Nombre_MUN from czmunicipios where 1=1".$Where;
break;

case 'Diagnostico':
	$SQL="Codigo_DGN as 'Codigo CIE10', Descripcion_DGN as 'Diagnostico' from gxdiagnostico where 1=1".$Where;
	$SQLx="Codigo_DGN, Descripcion_DGN from gxdiagnostico where 1=1".$Where;
break;

case 'Camas':
	$SQL="Nombre_CAM as Cama, Descripcion_CAM as 'Descripcion', Descripcion_GRC as Grupo, Nombre_ARE as Area, Ocupada_CAM as Estado from gxcamas a, gxgrupocamas b, gxareas c where a.Codigo_GRC=b.Codigo_GRC and a.Codigo_ARE=c.Codigo_ARE and Estado_CAM='1'".$Where;
	$SQLx="Nombre_CAM, Descripcion_CAM, Descripcion_GRC, Nombre_ARE, Case Ocupada_CAM When '1' Then 'Ocupada' Else 'Libre' End from gxcamas a, gxgrupocamas b, gxareas c where a.Codigo_GRC=b.Codigo_GRC and a.Codigo_ARE=c.Codigo_ARE and Estado_CAM='1'".$Where;
break;

case 'Ingreso':
	$SQL="LPAD(Codigo_ADM,10,'0') as Ingreso, Nombre_TER as 'Paciente', ID_TER as 'Documento', DATE_FORMAT(Fecha_ADM, '%d/%m/%Y %H:%i:%s') as 'Fecha Ingreso', Estado_ADM as Estado from gxadmision b, czterceros a where a.codigo_ter=b.codigo_ter".$Where;
	$SQLx="LPAD(Codigo_ADM,10,'0'), Nombre_TER, ID_TER, DATE_FORMAT(Fecha_ADM, '%d/%m/%Y %H:%i:%s'), Case Estado_ADM When 'I' then 'Activo' When 'A' Then 'Anulado' When 'F' Then 'Facturado' End from gxadmision b, czterceros a where a.codigo_ter=b.codigo_ter".$Where;
break;

case 'IngFacPeriodo':
	$SQL="LPAD(b.Codigo_ADM,10,'0') as Ingreso, Nombre_TER as 'Paciente', ID_TER as 'Documento', DATE_FORMAT(Fecha_ADM, '%d/%m/%Y %H:%i:%s') as 'Fecha Ingreso', Codigo_FAC as 'No. Factura', DATE_FORMAT(Fecha_FAC, '%d/%m/%Y') as 'Facturado' from itconfig_fc z,gxfacturas d, gxadmision b, czterceros a where d.Codigo_ADM=b.Codigo_ADM and d.Estado_FAC='1' and z.PeriodoActual_XFC=concat(month(d.Fecha_FAC),'.',year(d.Fecha_FAC)) and a.codigo_ter=b.codigo_ter".$Where;
	$SQLx="LPAD(b.Codigo_ADM,10,'0'), Nombre_TER, ID_TER, DATE_FORMAT(Fecha_ADM, '%d/%m/%Y %H:%i:%s'), Codigo_FAC, DATE_FORMAT(Fecha_FAC, '%d/%m/%Y')  from itconfig_fc z,gxfacturas d, gxadmision b, czterceros a where d.Codigo_ADM=b.Codigo_ADM and d.Estado_FAC='1' and z.PeriodoActual_XFC=concat(month(d.Fecha_FAC),'.',year(d.Fecha_FAC)) and a.codigo_ter=b.codigo_ter".$Where;
break;

case 'Contrato':
	$SQL="Codigo_EPS as Codigo, Nombre_EPS as 'Nombre Contrato', Contrato_EPS as 'Contrato', Nombre_TER as 'Entidad', concat(ID_TER,'-',digitoverif_TER) as NIT, TipoContrato_EPS as 'Tipo', estado_EPS as Estado from gxeps a, czterceros b where a.Codigo_TER=b.Codigo_TER".$Where;
	$SQLx="Codigo_EPS, Nombre_EPS,Contrato_EPS, Nombre_TER, concat(ID_TER,'-',digitoverif_TER),TipoContrato_EPS, Case estado_EPS When '1' Then 'Activo' When '0' Then 'Inactivo' End from gxeps a, czterceros b where a.Codigo_TER=b.Codigo_TER".$Where;
break;

case 'Planes':
	$SQL="Codigo_PLA as Codigo, Nombre_PLA as 'Nombre Plan', Estado_PLA as Estado from gxplanes where 1=1".$Where;
	$SQLx="Codigo_PLA, Nombre_PLA, Estado_PLA from gxplanes where 1=1".$Where;
break;

case 'Tarifa':
	$SQL="Codigo_TAR as Codigo, Nombre_TAR as 'Nombre Tarifa', Tipo_TAR as Tipo from gxtarifas where 1=1".$Where;
	$SQLx="Codigo_TAR, Nombre_TAR, Tipo_TAR from gxtarifas where 1=1".$Where;
break;

case 'Egreso':
	$SQL="LPAD(Codigo_EGR,10,'0') as Egreso, Nombre_TER as 'Paciente', ID_TER as 'Documento', LPAD(b.Codigo_ADM,10,'0') as Ingreso, DATE_FORMAT(Fecha_ADM, '%d/%m/%Y %H:%i:%s') as 'Fecha Ingreso', DATE_FORMAT(Fecha_EGR, '%d/%m/%Y %H:%i:%s') as 'Fecha Egreso', Estado_EGR as Estado from gxadmision b, czterceros a, gxegresos c where b.codigo_adm=c.codigo_adm and a.codigo_ter=b.codigo_ter".$Where;
	$SQLx="LPAD(Codigo_EGR,10,'0'), Nombre_TER, ID_TER, LPAD(b.Codigo_ADM,10,'0'), DATE_FORMAT(Fecha_ADM, '%d/%m/%Y %H:%i:%s'), DATE_FORMAT(Fecha_EGR, '%d/%m/%Y %H:%i:%s'), Estado_EGR from gxadmision b, czterceros a, gxegresos c where b.codigo_adm=c.codigo_adm and a.codigo_ter=b.codigo_ter".$Where;
break;

case 'Servicios1':
	$SQL="a.Codigo_SER as 'Codigo', Nombre_SER as 'Nombre Servicio', CUPS_PRC as 'CUPS' from gxservicios a, gxprocedimientos b, gxmanualestarifarios c where a.codigo_ser=b.codigo_ser and c.codigo_ser=b.codigo_ser and '".date('Y-m-d')."' >= FechaIni_Tar and '".date('Y-m-d')."' <= FechaFin_TAR".$Where;
	$SQLx="a.Codigo_SER, Nombre_SER, CUPS_PRC from gxservicios a, gxprocedimientos b, gxmanualestarifarios c where a.codigo_ser=b.codigo_ser and c.codigo_ser=b.codigo_ser and '".date('Y-m-d')."' and '".date('Y-m-d')."' >= FechaIni_Tar and '".date('Y-m-d')."' <= FechaFin_TAR".$Where;
break;

case 'Servicios2':
	$SQL="a.Codigo_SER as 'Codigo', Nombre_SER as 'Nombre Producto', Codigo_MED as 'Cod. Producto' from gxservicios a, gxmedicamentos b, gxmanualestarifarios c where a.codigo_ser=b.codigo_ser and c.codigo_ser=b.codigo_ser and '".date('Y-m-d')."' >= FechaIni_Tar and '".date('Y-m-d')."' <= FechaFin_TAR".$Where;
	$SQLx="a.Codigo_SER, Nombre_SER, Codigo_MED from gxservicios a, gxmedicamentos b, gxmanualestarifarios c where a.codigo_ser=b.codigo_ser and c.codigo_ser=b.codigo_ser and '".date('Y-m-d')."' >= FechaIni_Tar and '".date('Y-m-d')."' <= FechaFin_TAR".$Where;
break;

case 'ServiciosX1':
	$SQL="a.Codigo_SER as 'Codigo', Nombre_SER as 'Nombre Servicio', CUPS_PRC as 'CUPS' from gxservicios a, gxprocedimientos b where a.codigo_ser=b.codigo_ser".$Where;
	$SQLx="a.Codigo_SER, Nombre_SER, CUPS_PRC from gxservicios a, gxprocedimientos b where trim(a.codigo_ser)=trim(b.codigo_ser)".$Where;
break;

case 'ServiciosX2':
	$SQL="a.Codigo_SER as 'Codigo', Nombre_SER as 'Nombre Producto', Codigo_MED as 'Cod. Producto' from gxservicios a, gxmedicamentos b where a.codigo_ser=b.codigo_ser".$Where;
	$SQLx="a.Codigo_SER, Nombre_SER, Codigo_MED from gxservicios a, gxmedicamentos b where a.codigo_ser=b.codigo_ser".$Where;
break;

case 'Dispositivos':
	$SQL="a.Codigo_SER as 'Codigo', Nombre_SER as 'Dispositivo', Codigo_MED as 'Cod. Dispositivo' from gxservicios a, gxmedicamentos b, gxmanualestarifarios c where a.codigo_ser=b.codigo_ser and c.codigo_ser=b.codigo_ser and b.Dispositivo_MED='1' and '".date('Y-m-d')."' >= FechaIni_Tar and '".date('Y-m-d')."' <= FechaFin_TAR".$Where;
	$SQLx="a.Codigo_SER, Nombre_SER, Codigo_MED from gxservicios a, gxmedicamentos b, gxmanualestarifarios c where a.codigo_ser=b.codigo_ser and c.codigo_ser=b.codigo_ser and b.Dispositivo_MED='1' and '".date('Y-m-d')."' >= FechaIni_Tar and '".date('Y-m-d')."' <= FechaFin_TAR".$Where;
break;

case 'ordenesdeservicio':
	$SQL="LPAD(Codigo_ORD,10,'0') as 'Orden', Nombre_TER as 'Paciente', LPAD(a.Codigo_ADM,10,'0') as 'Admision', ID_TER as 'Identificacion' From gxadmision a, czterceros b, gxordenescab c Where a.Codigo_ADM=c.Codigo_ADM and a.Codigo_TER=b.Codigo_TER and Estado_ADM='I' and Estado_ORD='1' ".$Where;
	$SQLx="LPAD(Codigo_ORD,10,'0'), Nombre_TER, LPAD(a.Codigo_ADM,10,'0'), ID_TER From gxadmision a, czterceros b, gxordenescab c Where a.Codigo_ADM=c.Codigo_ADM and a.Codigo_TER=b.Codigo_TER and Estado_ADM='I' and Estado_ORD='1' ".$Where;
break;

case 'radicaciones':
	$SQL="LPAD(Codigo_RAD,10,'0') as 'Radicacion', Nombre_TER as 'Contrato', d.Nombre_PLA as 'Plan', a.Fecha_RAD as 'Fecha' From czradicacionescab a, czterceros b, gxeps c, gxplanes d Where a.Codigo_EPS=c.Codigo_EPS and c.Codigo_TER=b.Codigo_TER and d.Codigo_PLA=a.Codigo_PLA ".$Where;
	$SQLx="LPAD(Codigo_RAD,10,'0'), Nombre_TER, d.Nombre_PLA, a.Fecha_RAD From czradicacionescab a, czterceros b, gxeps c, gxplanes d Where a.Codigo_EPS=c.Codigo_EPS and c.Codigo_TER=b.Codigo_TER and d.Codigo_PLA=a.Codigo_PLA ".$Where;
break;

case 'Usuarios':
	$SQL="Codigo_USR as 'Código', ID_USR as 'Usuario', Nombre_USR as 'Nombre', Nombre_PRF as 'Perfil', Activo_USR as 'Estado' From itusuarios a, itperfiles b Where a.Codigo_PRF=b.Codigo_PRF and Codigo_USR<>'0' ".$Where;
	$SQLx="Codigo_USR, ID_USR, Nombre_USR, Nombre_PRF, Case Activo_USR When '1' Then 'Activo' Else 'Inactivo' End From itusuarios a, itperfiles b Where a.Codigo_PRF=b.Codigo_PRF and Codigo_USR<>'0' ".$Where;
break;

case 'UsuariosNoMed':
	$SQL="ID_USR as 'Usuario', Nombre_USR as 'Nombre', Nombre_PRF as 'Perfil', Activo_USR as 'Estado' From itusuarios a, itperfiles b Where a.Codigo_USR Not in (Select Codigo_USR From gxmedicos Where Estado_MED='1') and a.Codigo_PRF=b.Codigo_PRF and Codigo_USR<>'0' ".$Where;
	$SQLx="ID_USR, Nombre_USR, Nombre_PRF, Case Activo_USR When '1' Then 'Activo' Else 'Inactivo' End From itusuarios a, itperfiles b Where a.Codigo_USR Not in (Select Codigo_USR From gxmedicos Where Estado_MED='1') and a.Codigo_PRF=b.Codigo_PRF and Codigo_USR<>'0' ".$Where;
break;

case 'Perfiles':
	$SQL="Codigo_PRF as 'Código',  Nombre_PRF as 'Perfil', Activo_PRF as 'Estado' From itperfiles Where Codigo_PRF<>'0' ".$Where;
	$SQLx="Codigo_PRF, Nombre_PRF, Case Activo_PRF When '1' Then 'Activo' Else 'Inactivo' End From itperfiles  Where Codigo_PRF<>'0' ".$Where;
break;

case 'Perfiles2':
	$SQL="Codigo_PRF as 'Código',  Nombre_PRF as 'Perfil', Activo_PRF as 'Estado' From itperfiles Where Codigo_PRF in (Select distinct Codigo_PRF From itpermisos) ".$Where;
	$SQLx="Codigo_PRF, Nombre_PRF, Case Activo_PRF When '1' Then 'Activo' Else 'Inactivo' End From itperfiles  Where Codigo_PRF in (Select distinct Codigo_PRF From itpermisos) ".$Where;
break;

case 'Empleado':
	$SQL="id_ter as Documento, nombre1_emp as 'Primer Nombre', nombre2_emp as 'Segundo Nombre', apellido1_emp as 'Primer Apellido', apellido2_emp as 'Segundo Apellido', estado_emp as 'Estado' from czterceros a, czempleados b where a.codigo_ter=b.codigo_ter".$Where;
	$SQLx="id_ter, nombre1_emp, nombre2_emp, apellido1_emp, apellido2_emp, case estado_emp when '1' then 'ACTIVO' else 'INACTIVO' end from czterceros a, czempleados b where a.codigo_ter=b.codigo_ter".$Where;
break;

case 'Cargos':
	$SQL="Codigo_CRG as Codigo, nombre_CRG as 'Cargo', Estado_CRG as 'Estado' from czcargos where 1=1".$Where;
	$SQLx="Codigo_CRG, nombre_CRG, Case Estado_CRG When '1' Then 'Activo' Else 'Inactivo' End from czcargos where 1=1".$Where;
break;

case 'Turnos':
	$SQL="Codigo_TRN as Codigo, Nombre_TRN as 'Nombre Turno', Inicia_TRN as 'Hora Inicio', Termina_TRN as 'Hora Fin', TotalHoras_TRN as 'Total Horas', Descanso_TRN as 'Descanso' from cztipoturnos where Estado_TRN='1'".$Where;
	$SQLx="Codigo_TRN, Nombre_TRN, Inicia_TRN, Termina_TRN, TotalHoras_TRN, Descanso_TRN from cztipoturnos where Estado_TRN='1'".$Where;
break;

case 'Empleados':
	$SQL="id_ter as Documento, nombre1_emp as 'Primer Nombre', nombre2_emp as 'Segundo Nombre', apellido1_emp as 'Primer Apellido', apellido2_emp as 'Segundo Apellido' from czterceros a, czempleados b, czareasterceros c where a.codigo_ter=c.codigo_ter and a.codigo_ter=b.codigo_ter and Estado_EMP='1'".$Where;
	$SQLx="id_ter, nombre1_emp, nombre2_emp, apellido1_emp, apellido2_emp from czterceros a, czempleados b, czareasterceros c where a.codigo_ter=c.codigo_ter and a.codigo_ter=b.codigo_ter and Estado_EMP='1'".$Where;
break;

case 'MyTurnos':
	$SQL="Codigo_TUR as Codigo, Nombre_TUR as 'Nombre Turno', FechaIni_TUR as 'Fecha Inicio', FechaFin_TUR as 'Fecha Fin' from czmyturnosenc where 1=1".$Where;
	$SQLx="Codigo_TUR, Nombre_TUR, FechaIni_TUR, FechaFin_TUR from czmyturnosenc where 1=1".$Where;
break;

case 'ODS':
	$SQL="Codigo_ODS as Codigo, Titulo_ODS as 'Servicio Solicitado', Fecha_ODS as 'Fecha Solicitud', Estado_ODS as 'Estado' from myodssol where Codigo_USR='".$_SESSION["it_CodigoUSR"]."'".$Where;
	$SQLx="Codigo_ODS, Titulo_ODS, Fecha_ODS, Case Estado_ODS When '1' Then 'Cerrada' Else 'Abierta' End from myodssol where Codigo_USR='".$_SESSION["it_CodigoUSR"]."'".$Where;
break;

case 'ODS2':
	$SQL="Codigo_ODS as Codigo, Titulo_ODS as 'Servicio Solicitado', Fecha_ODS as 'Fecha Solicitud', Clasificacion_ODS as 'Tipo', FechaProg_ODS as 'Programacion' from myodssol where 1=1".$Where;
	$SQLx="Codigo_ODS, Titulo_ODS, Fecha_ODS, Case Clasificacion_ODS When 'S' Then 'SW' Else 'HW' End, FechaProg_ODS from myodssol where 1=1".$Where;
break;

case 'Bodega':
	$SQL="Codigo_BDG as Codigo, Nombre_BDG as 'Almacén', Codigo_SDE as 'Sede', Estado_BDG as 'Estado' from czbodegas where 1=1".$Where;
	$SQLx="Codigo_BDG, Nombre_BDG, Codigo_SDE, Case Estado_BDG When '1' Then 'Activa' Else 'Inactiva' End from czbodegas where 1=1".$Where;
break;

case 'InventarioEntra':
	$SQL="Codigo_ENT as Codigo, Nombre_TER as 'Proveedor', NumeroDoc_ENT as 'Documento', Fecha_ENT as 'Fecha', Estado_ENT as 'Estado' from czinventradascab a, czterceros b where a.Proveedor_ENT=b.Codigo_TER".$Where;
	$SQLx="Codigo_ENT, Nombre_TER, NumeroDoc_ENT, Fecha_ENT, Case Estado_ENT When '1' Then 'Activa' Else 'Inactiva' End from czinventradascab a, czterceros b where a.Proveedor_ENT=b.Codigo_TER".$Where;
break;

case 'Proveedor':
	$SQL="id_ter as Documento, nombre_ter as 'Nombre', razonsocial_ter as 'Razon Social' from czterceros a, czproveedores b where a.codigo_ter=b.codigo_ter ".$Where;
	$SQLx="id_ter, nombre_ter, razonsocial_ter from czterceros a, czproveedores b where a.codigo_ter=b.codigo_ter ".$Where;
break;

case 'ModelosHC':
	$SQL="Codigo_HCT as CodigoHC, nombre_HCT as 'Modelo HC', Activo_HCT as 'Estado' from hctipos where Codigo_HCT Not In (Select distinct Codigo_HCT from hcfolios) and Activo_HCT<>'X' ".$Where;
	$SQLx="Codigo_HCT, Nombre_HCT, Case Activo_HCT When '1' Then 'Activa' Else 'Inactiva' End from hctipos where Codigo_HCT Not In (Select distinct Codigo_HCT from hcfolios) and Activo_HCT<>'X' ".$Where;
break;

case 'PacientesHC':
	$SQL="ID_TER as 'Historia', Nombre_TER as 'Paciente',Codigo_ADM as Ingreso,  DATE_FORMAT(Fecha_ADM, '%d/%m/%Y %H:%i:%s') as 'Fecha Ingreso' from gxadmision b, czterceros a where Estado_ADM='I' and a.codigo_ter=b.codigo_ter".$Where;
	$SQLx="ID_TER, Nombre_TER,Codigo_ADM, DATE_FORMAT(Fecha_ADM, '%d/%m/%Y %H:%i:%s') from gxadmision b, czterceros a where Estado_ADM='I' and a.codigo_ter=b.codigo_ter".$Where;
break;

case 'KlCotizacion':
	$SQL="LPAD(Codigo_CTZ,6,'0') as 'Cotizacion', Nombre_TER as 'Cliente', ID_TER as 'Pasaporte', DATE(Fecha_CTZ) as 'Fecha', nombre_pla as 'Plan' From klcotizaciones a, czterceros b, klplanes c Where a.codigo_pla=c.codigo_pla and a.Codigo_TER=b.Codigo_TER  ".$Where;
	$SQLx="LPAD(Codigo_CTZ,6,'0'), Nombre_TER, ID_TER, DATE(Fecha_CTZ), nombre_pla From klcotizaciones a, czterceros b, klplanes c Where a.codigo_pla=c.codigo_pla and a.Codigo_TER=b.Codigo_TER ".$Where;
break;

case 'KlPlanes':
	$SQL="Nombre_pla as 'Plan', Descripcion_pla as 'Descripcion', Descripcion_EST as 'Estado' From klplanes a, klestadosventas b Where a.Estado_PLA=b.Codigo_EST  ".$Where;
	$SQLx="Nombre_pla , Descripcion_pla , Descripcion_EST  From klplanes a , klestadosventas b Where a.Estado_PLA=b.Codigo_EST ".$Where;
break;

case 'Klagencias':
	$SQL="ID_TER as 'No ID', Nombre_AGE as 'Nombre Agencia', Estado_AGE as 'Estado' From klagencias a, czterceros b Where a.Codigo_TER=b.Codigo_TER ".$Where;
	$SQLx="ID_TER , Nombre_AGE , Estado_AGE  From klagencias a, czterceros b Where a.Codigo_TER=b.Codigo_TER ".$Where;
break;

case 'Klmodindividual':
	$SQL="Nombre_pla as 'Plan', Descripcion_pla as 'Descripcion', Descripcion_EST as 'Estado' From klplanes a Where 1=1  ".$Where;
	$SQLx="Nombre_pla , Descripcion_pla , Descripcion_EST  From klplanes a Where 1=1 ".$Where;
break;

case 'Klmodpareja':
	$SQL="Nombre_pla as 'Plan', Descripcion_pla as 'Descripcion', Descripcion_EST as 'Estado' From klplanes a Where 1=1  ".$Where;
	$SQLx="Nombre_pla , Descripcion_pla , Descripcion_EST  From klplanes a Where 1=1 ".$Where;
break;

case 'Klmodfamilia':
	$SQL="Nombre_pla as 'Plan', Descripcion_pla as 'Descripcion', Descripcion_EST as 'Estado' From klplanes a Where 1=1  ".$Where;
	$SQLx="Nombre_pla , Descripcion_pla , Descripcion_EST  From klplanes a Where 1=1 ".$Where;
break;

case 'Usuarios2':
	$SQL=" ID_USR as 'Usuario', Nombre_USR as 'Nombre', Nombre_PRF as 'Perfil', Activo_USR as 'Estado' From itusuarios a, itperfiles b Where a.Codigo_PRF=b.Codigo_PRF and Codigo_USR not in ('0', '1') ".$Where;
	$SQLx=" ID_USR, Nombre_USR, Nombre_PRF, Case Activo_USR When '1' Then 'Activo' Else 'Inactivo' End From itusuarios a, itperfiles b Where a.Codigo_PRF=b.Codigo_PRF and Codigo_USR not in ('0', '1') ".$Where;
break;

case 'KlPoliza':
	$SQL="LPAD(Codigo_EMI,6,'0') as 'Poliza', Nombre_TER as 'Cliente', ID_TER as 'Pasaporte', DATE(Fecha_EMI) as 'Fecha', nombre_pla as 'Plan', prefijo_emi as 'PREFIJO' From klcotizaciones a, czterceros b, klplanes c, klemisiones d Where d.Codigo_CTZ=a.Codigo_CTZ and a.codigo_pla=c.codigo_pla and a.Codigo_TER=b.Codigo_TER  ".$Where;
	$SQLx="LPAD(Codigo_EMI,6,'0'), Nombre_TER, ID_TER, DATE(Fecha_EMI), nombre_pla, prefijo_emi From klcotizaciones a, czterceros b, klplanes c, klemisiones d Where d.Codigo_CTZ=a.Codigo_CTZ and a.codigo_pla=c.codigo_pla and a.Codigo_TER=b.Codigo_TER ".$Where;
break;

case 'PrefFacturas':
	$SQL="distinct a.Prefijo_AFC AS 'PREFIJO', a.Descripcion_AFC AS 'DESCRIPCION', a.Tipo_AFC AS 'TIPO', a.Estado_AFC AS 'ESTADO' FROM czautfacturacion a WHERE a.Codigo_AFC IN ( SELECT distinct b.Codigo_AFC FROM gxfacturas b) ".$Where;
	$SQLx="distinct a.Prefijo_AFC, a.Descripcion_AFC, Case a.Tipo_AFC When '1' Then 'Manual' When '2' Then 'por Computador' When '3' Then 'Electrónica' When '4' Then 'Contingencia' End, Case a.Estado_AFC When '1' then 'Activo' Else 'Inactivo' End FROM czautfacturacion a WHERE a.Codigo_AFC IN ( SELECT distinct b.Codigo_AFC FROM gxfacturas b) ".$Where;
break;

case 'FacturasPre':
	$SQL="a.Codigo_FAC as 'No. Factura', c.ID_TER as 'Doc Pcte.', c.Nombre_TER as 'Paciente', a.Codigo_ADM as 'Admision', b.Nombre_EPS as 'Entidad', a.Fecha_FAC as 'Fecha', a.ValTotal_FAC as 'Valor' From gxfacturas a, gxeps b, czterceros c, gxadmision d Where a.Codigo_EPS=b.Codigo_EPS and c.Codigo_TER=d.Codigo_TER and d.Codigo_ADM=a.Codigo_ADM and d.Estado_ADM='F' ".$Where;
	$SQLx="a.Codigo_FAC, c.ID_TER, c.Nombre_TER, a.Codigo_ADM, b.Nombre_EPS, a.Fecha_FAC, a.ValTotal_FAC From gxfacturas a, gxeps b, czterceros c, gxadmision d Where a.Codigo_EPS=b.Codigo_EPS and c.Codigo_TER=d.Codigo_TER and d.Codigo_ADM=a.Codigo_ADM and d.Estado_ADM='F' ".$Where;
break;

case 'ProfesionalesSalud':
	$SQL="ID_TER as 'Identificacion', a.Apellido1_MED as 'Primer Apellido', a.Apellido2_MED as 'Segundo Apellido', a.Nombre1_MED as 'Primer Nombre', a.Nombre2_MED as 'Segundo Nombre' From gxmedicos a, czterceros b Where a.Codigo_TER=b.Codigo_TER and Estado_MED='1' ".$Where;
	$SQLx="ID_TER, a.Apellido1_MED, a.Apellido2_MED, a.Nombre1_MED, a.Nombre2_MED From gxmedicos a, czterceros b Where a.Codigo_TER=b.Codigo_TER and Estado_MED='1' ".$Where;
break;

case 'Caja':
	$SQL="Codigo_CJA as 'Codigo', Nombre_CJA as 'Nombre Caja' From czcajas Where 1=1 ".$Where;
	$SQLx="Codigo_CJA , Nombre_CJA From czcajas Where 1=1 ".$Where;
break;

case 'FacturaCartera':
	$SQL="f.Codigo_FAC as 'No. Factura', c.Nombre_TER as 'Paciente', a.Codigo_ADM as 'Admision', b.Nombre_EPS as 'Entidad', a.Fecha_FAC as 'Fecha', a.ValTotal_FAC as 'Valor' From gxfacturas a, gxeps b, czterceros c, gxadmision d, czcartera f Where a.codigo_fac=f.Codigo_FAC and a.Codigo_EPS=b.Codigo_EPS and c.Codigo_TER=d.Codigo_TER and d.Codigo_ADM=a.Codigo_ADM and d.Estado_ADM='F' ".$Where;
	$SQLx="f.Codigo_FAC, c.Nombre_TER, a.Codigo_ADM, b.Nombre_EPS, a.Fecha_FAC, a.ValTotal_FAC From gxfacturas a, gxeps b, czterceros c, gxadmision d, czcartera f Where a.codigo_fac=f.Codigo_FAC and a.Codigo_EPS=b.Codigo_EPS and c.Codigo_TER=d.Codigo_TER and d.Codigo_ADM=a.Codigo_ADM and d.Estado_ADM='F' ".$Where;
break;


}
	
?>