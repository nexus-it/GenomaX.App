<?php
function Modulos($data, $ElMenu)
{
$i=0;
    foreach($data as $row)
    {
        $i++;
		echo '<li><div class="gxDivMod" onclick="MostrarOpcines(\''.$ElMenu.'-'.$row[0].'\', \''.$row[0].'\', \''.$ElMenu.' / '.$row[1].'\')"  style="background-image:url(themes/'.$_SESSION["THEME_DEFAULT"].'/images/icons/32x32/'.$row[2].'.png);">'.(($row[1])).'</div></a></li>';
    }
}

function DetModulo($data, $menu)
{
	$i=0;
    foreach($data as $row)
    {
    echo '
	<div id="'.$menu.'-'.$row[0].'" class="GrupoItems">';
	$i++;
	if ($_SESSION["it_CodigoPRF"]=='0') {
		Items(gxCargarItemsAdmin(NEXUS_APP,$row[0], $menu,'0'),$row[0], $menu);
	}else{
		Items(gxCargarItems(NEXUS_APP,$row[0], $menu,'0', $_SESSION["it_CodigoPRF"]),$row[0], $menu);
	}
	echo '
	</div>';
	}
}

function Items($data, $modulo, $menu)
{
	$i=0;
	if (!empty($data))
	{
		foreach($data as $row)
		{
			$i++;
			if (rtrim($row[2])=="#"){
				echo '
				<div class="gxItem" type="button" data-toggle="collapse" data-target="#'.str_replace(' ','_',$modulo.$menu.$row[1]).'-items" aria-expanded="false" aria-controls="'.str_replace(' ','_',$row[1]).'-items">
	  			'.($row[1]).' <span class="glyphicon glyphicon-menu-right"></span>
				</div>
				<div class="collapse" id="'.str_replace(' ','_',$modulo.$menu.$row[1]).'-items">';
				if ($_SESSION["it_CodigoPRF"]=='0') {
					Items(gxCargarItemsAdmin(NEXUS_APP,$modulo, $menu, $row[0]),$modulo, $menu);
				}else{
					Items(gxCargarItems(NEXUS_APP,$modulo, $menu, $row[0], $_SESSION["it_CodigoPRF"]),$modulo, $menu);
				}
			}
			else {
			echo '
			<div id="item-'.$row[0].'" class="gxItem" onclick="CargarForm(\'application/'.rtrim($row[2]).'\', \''.$row[1].'\', \''.$row[4].'\'); AddFavsForm(\''.$row[0].'\');">'.($row[1]);
			}
			echo '
			</div>';
		}
	}
}

function Menu($data)
{
	$i=0;
    foreach($data as $row)
    {
        $i++;
		echo '
<div id="tabs-'.$i.'">';
if ($_SESSION["it_CodigoPRF"]=='0') {
	DetMenu(CargarMenuAdmin(NEXUS_APP,$row[0]),$row[0]);
}else{
	DetMenu(CargarMenu(NEXUS_APP,$row[0], $_SESSION["it_CodigoPRF"]),$row[0]);
}
	echo '
</div>';
    }
}

function it_jsmenu()
{
//menu administrador
if ($_SESSION["it_CodigoPRF"]=='0') {
	$dataX=CargarModulosAdmin(NEXUS_APP);
	foreach($dataX as $rowX)
	{
		$data2=CargarMenuAdmin(NEXUS_APP, $rowX[0]);
		foreach($data2 as $row2)
		{
		echo "
			$('#".str_replace(' ','_',$row2[1])."_".$rowX[0]."').menu({
				content: $('#".str_replace(' ','_',$row2[1])."_".$rowX[0]."').next().html(),
				crumbDefaultText: ' '
			});";
		}
	}
}else{
//menu segun perfil
	$dataX=CargarModulos(NEXUS_APP, $_SESSION["it_CodigoPRF"]);
	foreach($dataX as $rowX)
	{
		$data2=CargarMenu(NEXUS_APP, $rowX[0], $_SESSION["it_CodigoPRF"]);
		foreach($data2 as $row2)
		{
		echo "
			$('#".str_replace(' ','_',$row2[1])."_".$rowX[0]."').menu({
				content: $('#".str_replace(' ','_',$row2[1])."_".$rowX[0]."').next().html(),
				crumbDefaultText: ' '
			});";
		}
	}
}
}
?>
<!--
	<script type="text/javascript">	

		<?php
		/*it_jsmenu();*/
		?>
    	$('.zerowindow').draggable({handle: ".zerotitle"});
		$( ".zerowindow" ).resizable({ghost: true});
		$( "#msgbox1" ).dialog({
			autoOpen: false,
			modal: true,
			show: "fold",
			hide: "fold",
			buttons: {
				Ok: function() {
					$( this ).dialog( "close" );
				}
			}	
		});
		$( "#msgbox2" ).dialog({
			autoOpen: false,
			show: "blind",
			hide: "explode",
			modal: true,
			buttons: {
				"Si": function() {
					$( this ).dialog( "close" );
				},
				"No": function() {
					$( this ).dialog( "close" );
				}
			}
		});
		$(".zerowindow").click( function (){
			MostrarVentana(this.id);
   		});	
   				//BARRAS DESPLAZAMIENTO
		$('.scroll-pane').jScrollPane();	
		});
    </script>
-->