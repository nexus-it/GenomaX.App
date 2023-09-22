$(function() 
{
	// configuramos el control para realizar la busqueda de los productos
	$(".nxsautocomplete").autocomplete({
		source: "http://192.168.0.78/myescala/test/buscar.php", 				/* este es el formulario que realiza la busqueda */
		minLength: 2,									/* le decimos que espere hasta que haya 2 caracteres escritos */
		select: productoSeleccionado,	/* esta es la rutina que extrae la informacion del registro seleccionado */
		focus: productoMarcado
	});
});