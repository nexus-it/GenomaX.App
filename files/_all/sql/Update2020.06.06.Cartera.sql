UPDATE `itconfig` SET `Version_DCD`='[VIBRANIUM]20.06.27.001';
UPDATE `ititems` SET `Nombre_ITM`='Solicitud a Farmacia', `Enlace_ITM`='forms/inventariosolfarm.php' WHERE  `Codigo_ITM`=356 AND `Codigo_MNU`=97 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='1.Pills.png' WHERE  `Codigo_ITM`=356 AND `Codigo_MNU`=97 AND `Codigo_MOD`=2 AND `Codigo_APP`=2;
INSERT INTO `nxs_videologin` (`Codigo_LGN`, `Nombre_LGN`) VALUES ('6', 'bcklogin06.webm');
INSERT INTO `nxs_videologin` (`Codigo_LGN`, `Nombre_LGN`) VALUES ('7', 'bcklogin07.webm');
INSERT INTO `nxs_videologin` (`Codigo_LGN`, `Nombre_LGN`) VALUES ('8', 'bcklogin08.webm');
INSERT INTO `nxs_videologin` (`Codigo_LGN`, `Nombre_LGN`) VALUES ('9', 'bcklogin09.webm');
INSERT INTO `nxs_videologin` (`Codigo_LGN`, `Nombre_LGN`) VALUES ('10', 'bcklogin10.webm');
INSERT INTO `nxs_videologin` (`Codigo_LGN`, `Nombre_LGN`) VALUES ('11', 'bcklogin11.webm');
INSERT INTO `nxs_videologin` (`Codigo_LGN`, `Nombre_LGN`) VALUES ('12', 'bcklogin12.webm');
ALTER TABLE `gxeps`
	ADD COLUMN `FacXOrd_EPS` CHAR(1) NULL DEFAULT '0' AFTER `RemisionRIPS_EPS`;
UPDATE `itreports` SET `SQL_RPT`='Select a.Razonsocial_DCD, a.NIT_DCD, a.Direccion_DCD, a.Telefonos_DCD, a.EncabezadoFact_DCD, a.PiePaginaFact_DCD, \n b.ConsecIni_AFC, b.ConsecFin_AFC, b.Resolucion_AFC, b.Fecha_AFC, c.Codigo_FAC, c.Codigo_ADM, c.Fecha_FAC, c.ValPaciente_FAC, \n c.ValEntidad_FAC, c.ValCredito_FAC, c.Estado_FAC, CONCAT(e.ID_TER,\'-\',e.DigitoVerif_TER), e.Nombre_TER, e.Direccion_TER, e.Telefono_TER, \n LPAD(f.Codigo_ADM,10,\'0\'), CONCAT(h.Sigla_TID,\' \', g.ID_TER), g.Nombre_TER, i.Nombre_PLA, c.Codigo_EPS, c.Codigo_PLA, adddate(c.Fecha_FAC,d.VenceFactura_EPS), f.Autorizacion_ADM, a.Ciudad_DCD, g.Direccion_TER, g.Telefono_TER, Barrio_PAC, Nombre_MUN, x.Codigo_DGN, x.Descripcion_DGN, Prefijo_AFC, ValCredito_FAC, date(f.fecha_adm), f.FechaFin_ADM, d.contrato_eps, d.nombre_eps, d.Tipo_EPS, FacXOrd_EPS  \nFrom itconfig a, czautfacturacion b, gxfacturas c, gxeps d, czterceros e, gxadmision f, czterceros g, cztipoid h, gxplanes i, gxpacientes p, czmunicipios m, gxdiagnostico x \nWhere x.Codigo_DGN=f.Codigo_DGN and m.Codigo_MUN=p.Codigo_MUN and m.Codigo_DEP=p.Codigo_DEP and c.Codigo_AFC = b.Codigo_AFC and \np.Codigo_TER=g.Codigo_TER and d.Codigo_EPS= c.Codigo_EPS and e.Codigo_TER= d.Codigo_TER and f.Codigo_ADM =c.Codigo_ADM \n and g.Codigo_TER=f.Codigo_TER and h.Codigo_TID=g.Codigo_TID and i.Codigo_PLA= c.Codigo_PLA\n and c.Codigo_FAC>=Concat(\'@PREFIJO\',\' \',LPAD(\'@CODIGO_INICIAL\',10,\'0\')) and c.Codigo_FAC<=Concat(\'@PREFIJO\',\' \',LPAD(\'@CODIGO_FINAL\',10,\'0\'));' WHERE  `Codigo_RPT`='facturasaluddet' AND `Codigo_DCD`=0;
ALTER TABLE `hctipos`
	ADD COLUMN `Descripcion_HCT` VARCHAR(80) NOT NULL AFTER `Nombre_HCT`,
	ADD INDEX `Descripcion_HCT` (`Descripcion_HCT`);
UPDATE hctipos SET Descripcion_HCT=Nombre_HCT;