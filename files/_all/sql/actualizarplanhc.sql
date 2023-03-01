SET @admision='48588';

UPDATE gxadmision SET codigo_eps='16', codigo_pla='1' WHERE codigo_adm =@admision;
update gxordenesdet SET codigo_eps='16', codigo_pla='1' WHERE codigo_ord IN (
 SELECT codigo_ord FROM gxordenescab WHERE codigo_adm=@admision);
update gxfacturas SET codigo_eps='16', codigo_pla='1' WHERE codigo_adm =@admision;
update gxpacientes SET codigo_eps='16', codigo_pla='1' WHERE codigo_ter IN (
 SELECT codigo_ter FROM gxadmision WHERE codigo_adm =@admision);
