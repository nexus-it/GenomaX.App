select *
from gxordenesdet where codigo_ord in (
 select codigo_ord from gxordenescab where codigo_adm in (
   select codigo_adm from gxfacturas where codigo_fac in (
	'BAQ 0000001030', 'BAQ 0000001905', 'BAQ 0000002172', 'BAQ 0000002822', 'BAQ 0000002939', 'BAQ 0000003223', 'BAQ 0000003279', 'BAQ 0000003325', 'BAQ 0000003689', 'BAQ 0000003714', 'BAQ 0000004236'
	)))