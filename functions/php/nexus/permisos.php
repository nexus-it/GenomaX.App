<?php
function CargarModulosAdmin($Aplicacion) 
{
	$conexion=Conexion();
	$SQL="Select Codigo_MOD, '".$_SESSION["it_user"]."'  from ".$_SESSION['DB_NXS'].".itmodulos where Activo_MOD='1' and Codigo_APP='0' Union
	Select Codigo_MOD, Nombre_MOD from ".$_SESSION['DB_NXS'].".itmodulos where Activo_MOD='1' and Codigo_APP='".$Aplicacion."' order by Codigo_MOD;";	
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) 
		{
		$Datos[]=$row;
		}
	mysqli_free_result($result);
    return $Datos;
}

function CargarModulos($Aplicacion, $Perfil) 
{
	$conexion=Conexion();
	$SQL="Select distinct a.Codigo_MOD, Nombre_MOD from ".$_SESSION['DB_NXS'].".itmodulos a, ".$_SESSION['DB_NXS'].".itmenu as b, ".$_SESSION['DB_NXS'].".ititems as c, itpermisos as d where Activo_MOD='1' and a.Codigo_APP='".$Aplicacion."' and b.Codigo_MOD=a.Codigo_MOD and c.Codigo_MNU=b.Codigo_MNU and d.Codigo_ITM=c.Codigo_ITM and d.Codigo_PRF='".$Perfil."' Order by a.Codigo_MOD;";	
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) 
		{
		$Datos[]=$row;
		}
	mysqli_free_result($result);
    return $Datos;
}

function CargarMenuAdmin($Aplicacion, $Modulo)
{
	$conexion=Conexion();
	if ($Modulo=='0'){
		$SQL="Select Codigo_MNU, Nombre_MNU from ".$_SESSION['DB_NXS'].".itmenu where Activo_MNU='1' and Codigo_APP='0' and Codigo_MOD='0' order by Codigo_MNU";
	}else{
		$SQL="Select Codigo_MNU, Nombre_MNU from ".$_SESSION['DB_NXS'].".itmenu where Activo_MNU='1' and Codigo_APP='".$Aplicacion."' and Codigo_MOD='".$Modulo."' order by Codigo_MNU;";	
	}
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) 
		{
		$Datos[]=$row;
		}
	mysqli_free_result($result);
    return $Datos;	
}

function CargarMenu($Aplicacion, $Modulo, $Perfil)
{
	$conexion=Conexion();
	$SQL="Select distinct a.Codigo_MNU, Nombre_MNU from ".$_SESSION['DB_NXS'].".itmenu as a, ".$_SESSION['DB_NXS'].".ititems as b, itpermisos as c where Activo_MNU='1' and a.Codigo_APP='".$Aplicacion."' and a.Codigo_MOD='".$Modulo."' and b.Codigo_MNU=a.Codigo_MNU and c.Codigo_ITM=b.Codigo_ITM and c.Codigo_PRF='".$Perfil."' Order by a.Codigo_MNU;";	
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) 
		{
		$Datos[]=$row;
		}
	mysqli_free_result($result);
    return $Datos;	
}

function CargarItemsAdmin($Aplicacion, $Modulo, $Menu, $Item)
{
	$conexion=Conexion();
	if ($Modulo=='0'){
		$SQL="Select Codigo_ITM, Nombre_ITM, Enlace_ITM from ".$_SESSION['DB_NXS'].".ititems where Activo_ITM='1' and Codigo_APP='0' and Codigo_MOD='0' and Codigo_MNU='".$Menu."' and Padre_ITM='".$Item."' order by Codigo_ITM;";
	}else{
		$SQL="Select Codigo_ITM, Nombre_ITM, Enlace_ITM from ".$_SESSION['DB_NXS'].".ititems where Activo_ITM='1' and Codigo_APP='".$Aplicacion."' and Codigo_MOD='".$Modulo."' and Codigo_MNU='".$Menu."' and Padre_ITM='".$Item."' order by Codigo_ITM;";	
	}
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) 
		{
		$Datos[]=$row;
		}
	mysqli_free_result($result);
    return $Datos;	
}

function CargarItems($Aplicacion, $Modulo, $Menu, $Item, $Perfil)
{
	$conexion=Conexion();
	$SQL="Select distinct a.Codigo_ITM, Nombre_ITM, Enlace_ITM from ".$_SESSION['DB_NXS'].".ititems as a, itpermisos as b where Activo_ITM='1' and a.Codigo_APP='".$Aplicacion."' and a.Codigo_MOD='".$Modulo."' and Codigo_MNU='".$Menu."' and Padre_ITM='".$Item."' and b.Codigo_ITM=a.Codigo_ITM and b.Codigo_PRF='".$Perfil."' Order by a.Codigo_ITM;";	
//	echo $SQL;
	$result = mysqli_query($conexion, $SQL);
	while($row = mysqli_fetch_row($result)) 
		{
		$Datos[]=$row;
		}
	mysqli_free_result($result);
    return $Datos;	
}

function TotalModulos($Aplicacion) 
{
}

function TotalMenu($Modulo)
{
}

function TotalItems($Menu)
{
}


?>