UPDATE `itconfig` SET `Version_DCD`='18.03.10.001';
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `OptNo_ITM`, `OpSave_ITM`) VALUES ('456', '104', '8', '2', 'Anular Movimientos de Caja', 'money_delete.png', 'forms/cajasmovno.php', '1', '0');
UPDATE `ititems` SET `Icono_ITM`='money_in_envelope.png' WHERE  `Codigo_ITM`=450 AND `Codigo_MNU`=104 AND `Codigo_MOD`=8 AND `Codigo_APP`=2;
UPDATE `ititems` SET `Icono_ITM`='moneybox.png' WHERE  `Codigo_ITM`=446 AND `Codigo_MNU`=104 AND `Codigo_MOD`=8 AND `Codigo_APP`=2;
INSERT INTO `ititems` (`Codigo_ITM`, `Codigo_MNU`, `Codigo_MOD`, `Codigo_APP`, `Nombre_ITM`, `Icono_ITM`, `Enlace_ITM`, `OptNo_ITM`, `OpSave_ITM`) VALUES ('457', '104', '8', '2', 'Anular Cierre de Caja', 'coins_delete.png', 'forms/cajascierreno.php', '1', '0');
