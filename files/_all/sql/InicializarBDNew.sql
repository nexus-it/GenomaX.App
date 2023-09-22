-- Deshabilitar verificación de claves foráneas temporalmente
SET FOREIGN_KEY_CHECKS = 0;

DELETE FROM czempleados;
DELETE FROM czcajas;
DELETE FROM czinvsolfarmacia;
DELETE FROM gxordenesdet;
DELETE FROM gxordenescab;
DELETE FROM gxconsultorios;
DELETE FROM itusuariosareas;
DELETE FROM itusuariossedes;
DELETE FROM itusuarios WHERE  Codigo_USR NOT IN ('0','1','3','2');
DELETE FROM gxareas;
DELETE FROM czsedes;
DELETE FROM gxadmision;
DELETE FROM gxadmcovid19;
DELETE FROM gxagendadet;
DELETE FROM gxagendacab;
DELETE FROM gxpacientes WHERE codigo_ter NOT IN (0,1);
DELETE FROM gxcitasmedicas;
DELETE FROM gxcitasreprogramadas;
DELETE FROM gxcontratos WHERE  Codigo_EPS<>'0';
DELETE FROM gxeps WHERE  Codigo_EPS<>'0';
DELETE FROM gxestancias;
DELETE FROM gxpabelloncamas;
DELETE FROM gxmedicos;
DELETE FROM gxmedicosesp;
DELETE FROM gxpaquetes;
DELETE FROM gxprgmpctes;
DELETE FROM hcanalisis;
DELETE FROM hcant_alergico;
DELETE FROM hcant_familiar;
DELETE FROM hcant_ginecobst;
DELETE FROM hcant_personales;
DELETE FROM hcant_toxicologico;
DELETE FROM hcctrlparaobs;
DELETE FROM hcctrlprentl;
DELETE FROM hcdiagnosticos;
DELETE FROM hcembactual;
DELETE FROM hcfolios;
DELETE FROM hcfolios_old;
DELETE FROM hcframingham;
DELETE FROM hcidriesgoesp;
DELETE FROM hcincapacidades;
DELETE FROM hclabsrcv;
DELETE FROM hcnotas;
DELETE FROM hcordenesdx;
DELETE FROM hcordenesmedica;
DELETE FROM hcordenesqx;
DELETE FROM hcordenesservicios;
DELETE FROM hcriegocv;
DELETE FROM hcriegoobs;
DELETE FROM hcsignosvitales;
DELETE FROM hctratamiento;
DELETE FROM hcusuarioshc;
DELETE FROM itauditoria;

DELETE FROM czradicacionesdet;
DELETE FROM czradicacionescab;
DELETE FROM czcartera;
DELETE FROM czautfacturacion WHERE codigo_afc<>'X';
DELETE FROM czempleados;
DELETE FROM czpagosdet;
DELETE FROM cznotascontablesdet;
DELETE FROM cznotascontablesenc;
DELETE FROM cznotascontablesend;
DELETE FROM czareasterceros;
DELETE FROM czterceros WHERE codigo_ter NOT IN ('0','1', 'X');
DELETE FROM gxfacturas;
DELETE FROM gxmanualestarifarios WHERE Codigo_TAR NOT IN ('0','1','2');
DELETE FROM gxtarifaexcepciones;
DELETE FROM gxtarifas WHERE Codigo_TAR NOT IN ('0','1','2');
DELETE FROM itfavoritos;
DELETE FROM itxerror;

UPDATE `itconsecutivos` SET `Consecutivo_CNS`='0' WHERE  `Campo_CNS`='Codigo_ADM' AND `Tabla_CNS`='gxadmision' AND `Codigo_DCD`=0;
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='0' WHERE  `Campo_CNS`='Codigo_AGE' AND `Tabla_CNS`='gxagendacab' AND `Codigo_DCD`=0;
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='0' WHERE  `Campo_CNS`='Codigo_CIT' AND `Tabla_CNS`='gxcitasmedicas' AND `Codigo_DCD`=0;
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='0' WHERE  `Campo_CNS`='Codigo_CNS' AND `Tabla_CNS`='gxconsultorios' AND `Codigo_DCD`=0;
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='0' WHERE  `Campo_CNS`='Codigo_EPS' AND `Tabla_CNS`='gxeps' AND `Codigo_DCD`=0;
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='0' WHERE  `Campo_CNS`='Codigo_EXA' AND `Tabla_CNS`='lbexamenes' AND `Codigo_DCD`=0;
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='0' WHERE  `Campo_CNS`='Codigo_GRC' AND `Tabla_CNS`='gxgrupocamas' AND `Codigo_DCD`=0;
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='0' WHERE  `Campo_CNS`='Codigo_HCM' AND `Tabla_CNS`='hcordenesmedica' AND `Codigo_DCD`=0;
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='0' WHERE  `Campo_CNS`='Codigo_HCS' AND `Tabla_CNS`='hcordenesdx' AND `Codigo_DCD`=0;
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='0' WHERE  `Campo_CNS`='Codigo_ISF' AND `Tabla_CNS`='czinvsolfarmacia' AND `Codigo_DCD`=0;
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='0' WHERE  `Campo_CNS`='Codigo_ORD' AND `Tabla_CNS`='gxordenescab' AND `Codigo_DCD`=0;
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='1' WHERE  `Campo_CNS`='Codigo_TER' AND `Tabla_CNS`='czterceros' AND `Codigo_DCD`=0;
UPDATE `itconsecutivos` SET `Consecutivo_CNS`='3' WHERE  `Campo_CNS`='Codigo_USR' AND `Tabla_CNS`='itusuarios' AND `Codigo_DCD`=0;


DELETE FROM hc_;DELETE FROM hc_1001;DELETE FROM hc_autopsia01;DELETE FROM hc_autopsia02;DELETE FROM hc_ccoptoma01;DELETE FROM hc_colposc;DELETE FROM hc_coosautop1;DELETE FROM hc_coosautop2;DELETE FROM hc_coosautop3;DELETE FROM hc_coosautop4;DELETE FROM hc_coostoma01;DELETE FROM hc_covid10193;DELETE FROM hc_covid10194;DELETE FROM hc_covid10195;DELETE FROM hc_covid10196;DELETE FROM hc_covid10197;DELETE FROM hc_covid10198;DELETE FROM hc_covid10199;DELETE FROM hc_covid10200;DELETE FROM hc_covid10202;DELETE FROM hc_covid10203;DELETE FROM hc_covid10204;DELETE FROM hc_covid10205;DELETE FROM hc_covid10206;DELETE FROM hc_covid10207;DELETE FROM hc_covid10208;DELETE FROM hc_covid10209;DELETE FROM hc_covid10210;DELETE FROM hc_covid10211;DELETE FROM hc_covid10212;DELETE FROM hc_covid10213;DELETE FROM hc_covid10214;DELETE FROM hc_covid10215;DELETE FROM hc_covid10216;DELETE FROM hc_covid10217;DELETE FROM hc_covid10218;DELETE FROM hc_covid10219;DELETE FROM hc_covid10220;DELETE FROM hc_covid10223;DELETE FROM hc_covid10224;DELETE FROM hc_enfermeria;DELETE FROM hc_evol1;DELETE FROM hc_fact;DELETE FROM hc_formmedica;DELETE FROM hc_gncobst;DELETE FROM hc_gnxtoma001;DELETE FROM hc_gnxtoma002;DELETE FROM hc_gnxtoma003;DELETE FROM hc_gnxtoma004;DELETE FROM hc_gnxtoma005;DELETE FROM hc_hc01;DELETE FROM hc_hc02;DELETE FROM hc_hcesp01;DELETE FROM hc_hcesppd;DELETE FROM hc_hcev01;DELETE FROM hc_hcmi;DELETE FROM hc_hcpsc;DELETE FROM hc_hcpsq;DELETE FROM hc_hcpsq2;DELETE FROM hc_hprtsn;DELETE FROM hc_internista;DELETE FROM hc_jefe;DELETE FROM hc_lectres;DELETE FROM hc_medgral1;DELETE FROM hc_medgral2;DELETE FROM hc_nnutri;DELETE FROM hc_npsico;DELETE FROM hc_pediatr;DELETE FROM hc_pediatra2;DELETE FROM hc_pediatria;DELETE FROM hc_psicotel02;DELETE FROM hc_psicotel03;DELETE FROM hc_psicotel04;DELETE FROM hc_psicotel05;DELETE FROM hc_qx001;DELETE FROM hc_remision;DELETE FROM hc_sars01;DELETE FROM hc_sars02;DELETE FROM hc_teleespe;DELETE FROM hc_tfevol;DELETE FROM hc_tfis1;DELETE FROM hc_tfonev;DELETE FROM hc_tocu1;DELETE FROM hc_toevol;DELETE FROM hc_tresp1;DELETE FROM hc_trevol;DELETE FROM hc_trevtrq;DELETE FROM hc_triage;DELETE FROM hc_valher1;DELETE FROM hcanalisis;DELETE FROM hcant_alergico;DELETE FROM hcant_familiar;DELETE FROM hcant_ginecobst;DELETE FROM hcant_personales;DELETE FROM hcant_toxicologico;DELETE FROM hcantecedentes;DELETE FROM hccampos;DELETE FROM hccamposlistas;DELETE FROM hcclaseincapacidad;DELETE FROM hcclasiftriage;DELETE FROM hcconsentimiento;DELETE FROM hcconsentinformados;DELETE FROM hcctrlparaobs;DELETE FROM hcctrlprentl;DELETE FROM hcdiagnosticos;DELETE FROM hcembactual;DELETE FROM hcencabezados;DELETE FROM hcencabezadosdet;DELETE FROM hcfolios;DELETE FROM hcfolios_old;DELETE FROM hcframingham;DELETE FROM hcglasgow;DELETE FROM hcidriesgoesp;DELETE FROM hcincapacidades;DELETE FROM hclabsrcv;DELETE FROM hcmedpacientes;DELETE FROM hcmotivoincapacidad;DELETE FROM hcnotas;DELETE FROM hcodontograma;DELETE FROM hcodontogramacuadrante;DELETE FROM hcodontogramasimbolos;DELETE FROM hcordenescons;DELETE FROM hcordenesdx;DELETE FROM hcordenesins;DELETE FROM hcordenesmedica;DELETE FROM hcordenesqx;DELETE FROM hcordenesservicios;DELETE FROM hcplantconsinform;DELETE FROM hcpqservicios;DELETE FROM hcpypdata;DELETE FROM hcresultadoslab;DELETE FROM hcriegocv;DELETE FROM hcriegoobs;DELETE FROM hcsignosvitales;DELETE FROM hcsv1;DELETE FROM hcsv2;DELETE FROM hcsv3;DELETE FROM hctemplatedet;DELETE FROM hctemplateenc;DELETE FROM hctfg;DELETE FROM hctipoantecedentes;DELETE FROM hctipoatencion;DELETE FROM hctipocuraciones;DELETE FROM hctipoglasgow;DELETE FROM hctipoincapacidad;DELETE FROM hctipos;DELETE FROM hctiposliquidos;DELETE FROM hctratamiento;DELETE FROM hctriage;DELETE FROM hcubicanatom;DELETE FROM hcusuarioshc;
-- Habilitar verificación de claves foráneas nuevamente
SET FOREIGN_KEY_CHECKS = 1;

