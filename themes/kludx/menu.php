<?php
if (isset($_GET["Func"])) {
	include '../../functions/php/nexus/config.php';
	error_reporting(E_ERROR | E_PARSE);

	session_start();
	include '../../functions/php/nexus/database.php';
	include '../../functions/php/nexus/auditoria.php';
	$conexion=Conexion();
	nxsLoadModules($_SESSION["NEXUS_APP"], $_SESSION["it_CodigoPRF"]); 
}

function nxsLoadModules($Aplicacion, $Perfil) 
{
	$html="";
	$conexion=Conexion();
	if ($Perfil=='0') {
		$SQL="Select distinct a.Codigo_MOD, 'SISTEMA', Icono_MOD from nxs_gnx.itmodulos a, nxs_gnx.itmenu as b where Activo_MOD='1' and a.Codigo_APP='0' and b.Codigo_MOD=a.Codigo_MOD Union Select a.Codigo_MOD, Nombre_MOD, Icono_MOD from nxs_gnx.itmodulos a, nxs_gnx.itmenu as b where Activo_MOD='1' and a.Codigo_APP='".$Aplicacion."' and b.Codigo_MOD=a.Codigo_MOD Order by 1;";	
	} else {
		$SQL="Select distinct a.Codigo_MOD, Nombre_MOD, Icono_MOD from nxs_gnx.itmodulos a, nxs_gnx.itmenu as b, nxs_gnx.ititems as c, itpermisos as d where Activo_MOD='1' and a.Codigo_APP='".$Aplicacion."' and b.Codigo_MOD=a.Codigo_MOD and c.Codigo_MNU=b.Codigo_MNU and d.Codigo_ITM=c.Codigo_ITM and d.Codigo_PRF='".$Perfil."' Order by a.Codigo_MOD;";
	}
	$result1 = mysqli_query($conexion, $SQL);
	while($row1 = mysqli_fetch_row($result1)) 
		{
		$html=$html.'<div class="alert alert-secondary titmnu" role="alert" id="nxs_module'.$row1[0].'">'.strtoupper($row1[1]).'</div>
		';
		$htmlmenu=nxsLoadMenu($Aplicacion, $row1[0], $Perfil);
		$html=$html.$htmlmenu;
		}
	mysqli_free_result($result1);
	$html=$html.'<div class="alert alert-secondary titmnu" role="alert" id="nxs_moduleX">'.str_repeat('- ',24).'</div>
	<li class="manito"><a onClick="nxs_meet1(\'normal\')" title="Video Conferencias Seguras" data-toggle="modal" data-target="#GnmX_NXSMeet"> <i class="fas fa-video text-black-50"></i> <span><b>NE<em>X</em>US.<em>Meet</em></b></span> </a></li>
        <li class="manito"><a onClick="CargarChngPass()"><i class="fa fa-key text-warning"></i> <span>Cambio de Clave</span></a></li>
        <li class="manito"><a onClick="AboutGNX();"><i class="fa fa-play-circle text-success"></i> <span>Acerca de...</span></a></li>
        <li class="manito"><a onClick="sessionClose();" ><i class="fas fa-sign-out-alt text-danger"></i> <span>Cerrar Sesión</span></a></li>';
    echo $html;
}

function nxsLoadMenu($Aplicacion, $Modulo, $Perfil) 
{
	$html2='<div class="accordion" id="nxs_mod'.$Modulo.'">';
	$conexion=Conexion();
	if ($Perfil=='0') {
		if ($Modulo=='0'){
			$SQL="Select distinct Codigo_MNU, Nombre_MNU, FontLogo_MNU from nxs_gnx.itmenu where Activo_MNU='1' and Codigo_APP='0' and Codigo_MOD='0' order by Codigo_MNU";
		}else{
			$SQL="Select distinct Codigo_MNU, Nombre_MNU, FontLogo_MNU from nxs_gnx.itmenu where Activo_MNU='1' and Codigo_APP='".$Aplicacion."' and Codigo_MOD='".$Modulo."' order by Codigo_MNU;";	
		}
	} else {
		$SQL="Select distinct a.Codigo_MNU, Nombre_MNU, FontLogo_MNU from nxs_gnx.itmenu as a, nxs_gnx.ititems as b, itpermisos as c where Activo_MNU='1' and a.Codigo_APP='".$Aplicacion."' and a.Codigo_MOD='".$Modulo."' and b.Codigo_MNU=a.Codigo_MNU and c.Codigo_ITM=b.Codigo_ITM and c.Codigo_PRF='".$Perfil."' Order by a.Codigo_MNU;";	
	}
	$result2 = mysqli_query($conexion, $SQL);
	while($row2 = mysqli_fetch_row($result2)) 
		{
		$html2=$html2.'
		<div class="accordion-item">
			<h2 class="accordion-header" id="headmenu'.$row2[0].'">
				<button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse'.$row2[0].'" aria-expanded="true" aria-controls="collapse'.$row2[0].'">
					<i class="'.$row2[2].'" id="nxs_menu'.$row2[0].'"></i> <span>'.$row2[1].' <i class="fa fa-angle-left" id="nxs_chevron'.$row2[0].'"></i> </span> 
            	</button>
    		</h2>
			<div id="collapse'.$row2[0].'" class="accordion-collapse collapse" aria-labelledby="headmenu'.$row2[0].'" data-bs-parent="#nxs_mod'.$Modulo.'">
      			<div class="accordion-body">
        	';
        $htmlitems=nxsLoadItems($Aplicacion, $Modulo, $row2[0], '0', $Perfil);
        $html2=$html2.$htmlitems.'
				</div>
			</div>
        </div>
        ';
		}
	mysqli_free_result($result2);
	$html2=$html2.'</div>';
    return $html2;	
}

function nxsLoadItems($Aplicacion, $Modulo, $Menu, $Item, $Perfil)
{
	$html3='';
	$conexion=Conexion();
	if ($Perfil=='0') {
		if ($Modulo=='0'){
			$SQL="Select distinct Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from nxs_gnx.ititems as a, nxs_gnx.itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='0' and a.Codigo_MOD='0' and c.Codigo_MNU='".$Menu."' and Padre_ITM='".$Item."' order by Codigo_ITM;";
		}else{
			$SQL="Select distinct Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from nxs_gnx.ititems as a, nxs_gnx.itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='".$Aplicacion."' and a.Codigo_MOD='".$Modulo."' and c.Codigo_MNU='".$Menu."' and Padre_ITM='".$Item."' order by Codigo_ITM;";
		}
	} else {
		$SQL="Select distinct a.Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from nxs_gnx.ititems as a, itpermisos as b, nxs_gnx.itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='".$Aplicacion."' and a.Codigo_MOD='".$Modulo."' and c.Codigo_MNU='".$Menu."' and Padre_ITM='".$Item."' and b.Codigo_ITM=a.Codigo_ITM and b.Codigo_PRF='".$Perfil."' Order by a.Codigo_ITM;";	
	}
	//echo $SQL;
	$result3 = mysqli_query($conexion, $SQL);
	while($row3 = mysqli_fetch_row($result3)) 
		{
		$action='';
		$clase='';
		if ($row3[2]=='#') {
			$action='href="#"';
			$clase=' class="treeview"';
		} else {
			$action='onclick="CargarForm(\'application/'.$row3[2].'\', \''.$row3[1].'\', \''.$row3[4].'\'); AddFavsForm(\''.$row3[0].'\');"'; 
		}
		$html3=$html3.'
            <li id="item-'.$row3[0].'" '.$clase.'>
            	<a class="manito" '.$action.'><i class="fa fa-chevron-circle-right"></i> '.$row3[1];
        $subhtml=nxsLoadItems($Aplicacion, $Modulo, $Menu, $row3[0], $Perfil);
        if ($subhtml!='') {
        	$html3=$html3.'
        		<span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
                </a>
            ';
        } else {
        	$html3=$html3.'</a>';
        }
		$html3=$html3.$subhtml.'
			</li>';
		}

	mysqli_free_result($result3);
	if ($html3!='') {
		$html3='<div class="accordion" id="accordionExample">'.$html3.'
			</ul>';
	}
	return $html3;
}

function gxCargarItemsAdmin($Aplicacion, $Modulo, $Menu, $Item)
{
	$conexion=Conexion();
	if ($Modulo=='0'){
		$SQL="Select distinct Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from nxs_gnx.ititems as a, nxs_gnx.itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='0' and a.Codigo_MOD='0' and c.Nombre_MNU='".$Menu."' and Padre_ITM='".$Item."' order by Codigo_ITM;";
	}else{
		$SQL="Select distinct Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from nxs_gnx.ititems as a, nxs_gnx.itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='".$Aplicacion."' and a.Codigo_MOD='".$Modulo."' and c.Nombre_MNU='".$Menu."' and Padre_ITM='".$Item."' order by Codigo_ITM;";
	}
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) 
		{
		$Datos[]=$row;
		}
	mysqli_free_result($result);
    return $Datos;	
}

function gxCargarItems($Aplicacion, $Modulo, $Menu, $Item, $Perfil)
{
	$conexion=Conexion();
	$SQL="Select distinct a.Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from nxs_gnx.ititems as a, itpermisos as b, nxs_gnx.itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='".$Aplicacion."' and a.Codigo_MOD='".$Modulo."' and c.Nombre_MNU='".$Menu."' and Padre_ITM='".$Item."' and b.Codigo_ITM=a.Codigo_ITM and b.Codigo_PRF='".$Perfil."' Order by a.Codigo_ITM;";	
	//echo $SQL;
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) 
		{
		$Datos[]=$row;
		}
	mysqli_free_result($result);
    return $Datos;
}

function gxTotalModulos($Aplicacion) 
{
}

function gxTotalMenu($Modulo)
{
}

function gxTotalItems($Menu)
{
}


?>