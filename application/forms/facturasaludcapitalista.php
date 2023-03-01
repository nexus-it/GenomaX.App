<?php

if(isset($_POST["filtro"])){
	$filtro = $_POST["filtro"];
	//echo $filtro;
}
 


	session_start();
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	include '../../functions/php/nexus/operaciones.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	

	

?>


<!--
<script type="text/javascript">
$(document).ready(function() {	
    $('.pagination li a').on('click', function(){
        $('.items').html('<div class="loading"><img src="files/loading.gif" width="70px" height="70px"/><br/>Un momento por favor...</div>');

        var page = $(this).attr('data');
		//alert(page);		
        var dataString = 'page='+page;
		//alert(dataString);
        $.ajax({
            type: "GET",
            url: "application/forms/facturasaludlista.php",
            data: dataString,
            success: function(data) {
                $('.items').fadeIn(2000).html(data);
                $('.pagination li').removeClass('active');
                $('.pagination li a[data="'+page+'"]').parent().addClass('active');
				//alert(data);
				exit();
				return false;
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert("Algo salio mal");
			}
        });
        return false;
    });              
});    
</script>
-->
<?php if($_GET['page'] == ""){ ?>
<div class="col-md-12">

	<?php if(isset($_POST["filtro"])==""){ ?><label class="label label-default">Listado de facturas</label><?php }?>
	  <div class="row well well-sm">

	        <div class="container">  
			<?php
			if(isset($_POST["filtro"])==""){
	          $SQL="Select Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='2' and a.Codigo_MOD='2' and c.Codigo_MNU='50' and Padre_ITM='0' AND Codigo_ITM = 459 order by Codigo_ITM;";
            $result3 = mysqli_query($conexion, $SQL);
            $row3 = mysqli_fetch_row($result3);
            $action='onclick="CargarForm(\'application/'.$row3[2].'\', \''.$row3[1].'\', \''.$row3[4].'\'); AddFavsForm(\''.$row3[0].'\');"'; 
            $action=  '<a  title="Crear nueva cuenta evento " class="manito" '.$action.'><i class="fa fa-file"></i></a> ';//.$row3[1];

			

            $html .= '<div class="btn btn-success">'.$action.'</div>';
            
			echo $html;
			}
			?>
			</div>
			<br>
	<div class="col-md-12">

<div class="form-group">
<?php } ?>
<?php

$page = $_GET['page'];
//echo "paginas= ".$page."<br>";
$rowsPerPage = NUM_ITEMS_BY_PAGE;
$offset = ($page - 1) * $rowsPerPage;
sleep(1);


if($ini==''){
//$filtro = '';
$ini=0;
$fin=10;
}else{
	$ini=$_GET['ini'];
	$fin=$_GET['fin'];
}

if(isset($page)){
$ini = ($page - 1) * $rowsPerPage;
}//echo $ini;

if($filtro == ""){
?>
<form method="POST" action="">
	<input type="text" name="filtro" id="filtro">
	<button type="button" name="filtrar" id="filtrar">Filtrar</button>
</form>
<div id="resultadofiltro"></div>
<?php
}
echo '<table class="table table-striped">';
		
			$conteo = listarFacturasCapita($filtro,$ini,$fin);
		
echo '</table>';

if($filtro == ""){
$num_total_rows = $conteo;

$conteo = $conteo/10;
for($i=0;$i<=$conteo;$i++){
  // echo "<a href='#'>$i</a>"." - ";
   
}

/*
//echo "<br>".$num_total_rows;
$num_pages = ceil($num_total_rows / NUM_ITEMS_BY_PAGE);
//echo "<br>".$num_pages;
if ($num_pages > 1 and $page == "") {
	echo '<div class="row">';
	echo '<div class="col-lg-12">';
	echo '<nav aria-label="Paginacion de facturas">';
	echo '<ul class="pagination justify-content-end">';

	for ($i=1;$i<=$num_pages;$i++) {
		$class_active = '';
		if ($i == 1) {
			$class_active = 'active';
		}
		echo '<li class="page-item '.$class_active.'"><a class="page-link" href="#" data="'.$i.'">'.$i.'</a></li>';
	}

	echo '</ul>';
	echo '</nav>';
	echo '</div>';
	echo '</div>';
}
*/
}

?>

<script>

function filtrarFactura(filtro){
    $.ajax({
            type: 'POST',
            url: 'application/forms/facturasaludlista.php',
            data: {
                filtro: filtro

            },
            beforeSend: function()
             {
                
             },

              success: function (data) {
                
                $("#resultadofiltro").html(data)
				
              },
              error: function() { 
                console.log(data);
              }
            });

   }



$(document).ready(function() {
           $( "#filtrar" ).click(function() {
			  
			$('.items').html('<div class="loading"><img  src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/loading.gif" width="70px" height="70px"/><br/>Un momento por favor...</div>');
			 filtrarFactura($("#filtro<?php echo $NumWindow; ?>").val()
                            );
            });
			
      });






function editarFactura(filtro){
    $.ajax({
            type: 'GET',
            url: 'application/forms/facturaedit.php',
            data: {
                filtro: filtro

            },
            beforeSend: function()
             {
                
             },

              success: function (data) {
                
                $("#resultadofiltro").html(data)
				
              },
              error: function() { 
                console.log(data);
              }
            });

   }



$(document).ready(function() {
           $( "#editar" ).click(function() {
			  
			editarFactura($("#factura<?php echo $NumWindow; ?>").val()
                            );
            });
			
      });



$(document).ready(function() {	
    $( ".enviarfactcapitadian" ).click(function() {
      var factura = $(this).attr('data');
		  //alert(factura);
      $("#resultadoEnvioFacturaCapita").html("")
      putSendFacturaCapita(factura)
    });
});






function putSendFacturaCapita(factura){
    $.ajax({
            type: 'POST',
            url: '../../functions/php/GenomaXBackend/putSendFacturaCapita.php',
            data: {
              factura: factura

            },
            beforeSend: function()
             {
                
             },

              success: function (data) {
                
                //$("#resultadoEnvioFacturaCapita").html("Factura Enviada con exito")
                $("#resultadoEnvioFacturaCapita").html(data)

              },
              error: function() { 
                console.log(data);
              }
            });

   }


   function estadoFacturaDoc(cufe,factura){
      $.ajax({
            type: 'POST',
            url: '../../functions/php/GenomaXBackend/estadoFacturaDoc.php',
            data: {
              cufe: cufe,
              factura: factura

            },
            beforeSend: function()
             {
                
             },

              success: function (data) {
                
                //$("#resultadoEnvioFactura").html(data)
                
                obj = JSON.parse(data);
                $("#resultadoEnvioFacturaEstado").html(obj['ResponseDian']['Envelope']['Body']['GetStatusResponse']['GetStatusResult']['StatusMessage'])
                
                //$("#resultadoEnvioFactura").html("Factura Enviada con exito")

              },
              error: function() { 
                console.log(data);
              }
            });
   }   


   $(document).ready(function() {	
    $( ".estadoFacturaDoc" ).click(function() {
      var cufe = $(this).attr('data-f');
      var factura = $(this).attr('data-c');
      
		  //alert(ingreso);
      //$("#resultadoEnvioFactura").html("")
      estadoFacturaDoc(factura,cufe)
    });
});
</script>

