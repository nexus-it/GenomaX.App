// JavaScript Document
var Funciones="functions/php/nexus/functions.php";
var Updates="functions/php/nexus/updates.php";
var Uploads="functions/php/nexus/uploads.php";
var Transac="functions/php/nexus/transactions.php";
var Transact="functions/php/transactions/";


function EditProduct(NumSol, Ventana) {
  CargarWind('Editar Producto ['+NumSol+'] ', 'forms/servicios.php?Mode=modal&Servicio='+NumSol, '1.Pills.png', 'inventariosolfarm.php',Ventana );
}

function NewProduct(Ventana) {
  CargarWind('Nuevo Producto ', 'forms/servicios.php?Mode=modal', '1.Pills.png', 'inventariosolfarm.php',Ventana );
}

