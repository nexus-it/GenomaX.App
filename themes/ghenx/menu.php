<?php

function nxsLoadModules($Aplicacion, $Perfil) 
{
	$html="";
	$conexion=Conexion();
	if ($Perfil=='0') {
		$SQL="Select distinct a.Codigo_MOD, 'SISTEMA', Icono_MOD from ".$_SESSION['DB_NXS'].".itmodulos a, ".$_SESSION['DB_NXS'].".itmenu as b where Activo_MOD='1' and a.Codigo_APP='0' and b.Codigo_MOD=a.Codigo_MOD Union Select a.Codigo_MOD, Nombre_MOD, Icono_MOD from ".$_SESSION['DB_NXS'].".itmodulos a, ".$_SESSION['DB_NXS'].".itmenu as b where Activo_MOD='1' and a.Codigo_APP='".$Aplicacion."' and b.Codigo_MOD=a.Codigo_MOD Order by 1;";	
	} else {
		$SQL="Select distinct a.Codigo_MOD, Nombre_MOD, Icono_MOD from ".$_SESSION['DB_NXS'].".itmodulos a, ".$_SESSION['DB_NXS'].".itmenu as b, ".$_SESSION['DB_NXS'].".ititems as c, itpermisos as d where Activo_MOD='1' and a.Codigo_APP='".$Aplicacion."' and b.Codigo_MOD=a.Codigo_MOD and c.Codigo_MNU=b.Codigo_MNU and d.Codigo_ITM=c.Codigo_ITM and d.Codigo_PRF='".$Perfil."' Order by a.Codigo_MOD;";
	}
	//error_log("Modulos: ".$SQL);
	$result1 = mysqli_query($conexion, $SQL);
	while($row1 = mysqli_fetch_row($result1)) 
		{
		$html=$html.'<li class="header" id="nxs_module'.$row1[0].'">'.strtoupper($row1[1]).'</li>
		';
		$htmlmenu=nxsLoadMenu($Aplicacion, $row1[0], $Perfil);
		$html=$html.$htmlmenu;
		}
	mysqli_free_result($result1);
    echo $html;
}

function nxsLoadMenu($Aplicacion, $Modulo, $Perfil) 
{
	$html2="";
	$conexion=Conexion();
	if ($Perfil=='0') {
		if ($Modulo=='0'){
			$SQL="Select distinct Codigo_MNU, Nombre_MNU, FontLogo_MNU from ".$_SESSION['DB_NXS'].".itmenu where Activo_MNU='1' and Codigo_APP='0' and Codigo_MOD='0' order by Codigo_MNU";
		}else{
			$SQL="Select distinct Codigo_MNU, Nombre_MNU, FontLogo_MNU from ".$_SESSION['DB_NXS'].".itmenu where Activo_MNU='1' and Codigo_APP='".$Aplicacion."' and Codigo_MOD='".$Modulo."' order by Codigo_MNU;";	
		}
	} else {
		$SQL="Select distinct a.Codigo_MNU, Nombre_MNU, FontLogo_MNU from ".$_SESSION['DB_NXS'].".itmenu as a, ".$_SESSION['DB_NXS'].".ititems as b, itpermisos as c where Activo_MNU='1' and a.Codigo_APP='".$Aplicacion."' and a.Codigo_MOD='".$Modulo."' and b.Codigo_MNU=a.Codigo_MNU and c.Codigo_ITM=b.Codigo_ITM and c.Codigo_PRF='".$Perfil."' Order by a.Codigo_MNU;";	
	}
	//error_log("Menu: ".$SQL);
	$result2 = mysqli_query($conexion, $SQL);
	while($row2 = mysqli_fetch_row($result2)) 
		{
		$html2=$html2.'<li class="treeview">
          <a href="#">
            <i class="'.$row2[2].'" id="nxs_menu'.$row2[0].'"></i> <span>'.$row2[1].'</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
        	';
        $htmlitems=nxsLoadItems($Aplicacion, $Modulo, $row2[0], '0', $Perfil);
        $html2=$html2.$htmlitems.'
        </li>
        ';
		}
	mysqli_free_result($result2);
    return $html2;	
}

function nxsLoadItems($Aplicacion, $Modulo, $Menu, $Item, $Perfil)
{
	$html3='';
	$conexion=Conexion();
	if ($Perfil=='0') {
		if ($Modulo=='0'){
			$SQL="Select distinct Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU AND c.Codigo_APP=a.Codigo_APP and Activo_ITM='1' and a.Codigo_APP='0' and a.Codigo_MOD='0' and c.Codigo_MNU='".$Menu."' and Padre_ITM='".$Item."' order by Codigo_ITM;";
		}else{
			$SQL="Select distinct Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU AND c.Codigo_APP=a.Codigo_APP and Activo_ITM='1' and a.Codigo_APP='".$Aplicacion."' and a.Codigo_MOD='".$Modulo."' and c.Codigo_MNU='".$Menu."' and Padre_ITM='".$Item."' order by Codigo_ITM;";
		}
	} else {
		$SQL="Select distinct a.Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, itpermisos as b, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU AND c.Codigo_APP=a.Codigo_APP and Activo_ITM='1' and a.Codigo_APP='".$Aplicacion."' and a.Codigo_MOD='".$Modulo."' and c.Codigo_MNU='".$Menu."' and Padre_ITM='".$Item."' and b.Codigo_ITM=a.Codigo_ITM and b.Codigo_PRF='".$Perfil."' Order by a.Codigo_ITM;";	
	}
	//error_log("Items: ".$SQL);
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
		$html3='<ul class="treeview-menu">'.$html3.'
			</ul>';
	}
	return $html3;
}

function gxCargarItemsAdmin($Aplicacion, $Modulo, $Menu, $Item)
{
	$conexion=Conexion();
	if ($Modulo=='0'){
		$SQL="Select distinct Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='0' and a.Codigo_MOD='0' and c.Nombre_MNU='".$Menu."' and Padre_ITM='".$Item."' order by Codigo_ITM;";
	}else{
		$SQL="Select distinct Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='".$Aplicacion."' and a.Codigo_MOD='".$Modulo."' and c.Nombre_MNU='".$Menu."' and Padre_ITM='".$Item."' order by Codigo_ITM;";
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
	$SQL="Select distinct a.Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, itpermisos as b, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='".$Aplicacion."' and a.Codigo_MOD='".$Modulo."' and c.Nombre_MNU='".$Menu."' and Padre_ITM='".$Item."' and b.Codigo_ITM=a.Codigo_ITM and b.Codigo_PRF='".$Perfil."' Order by a.Codigo_ITM;";	
	//error_log( $SQL);
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