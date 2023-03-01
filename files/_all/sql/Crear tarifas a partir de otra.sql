INSERT INTO gxmanualestarifarios(codigo_dcd, codigo_tar, fechaini_tar, fechafin_tar, codigo_ser, valor_tar)
SELECT codigo_dcd, '3', fechaini_tar, fechafin_tar, codigo_ser, valor_tar*1.16 FROM gxmanualestarifarios WHERE codigo_tar='1' AND codigo_ser IN (
SELECT codigo_ser FROM gxservicios WHERE codigo_cfc='02'
)
AND NOW() BETWEEN fechaini_tar AND fechafin_tar AND codigo_ser NOT IN (SELECT codigo_ser FROM gxmanualestarifarios WHERE codigo_tar='3'
)