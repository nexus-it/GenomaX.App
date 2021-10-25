<?php
	

session_start();
	include 'database.php';	
	include 'auditoria.php';
	if(isset($_POST["txt_loginuser"]))
	{
		//Incluimos el archivo que contiene los datos de la conexion del Nexus it MySQL.
		$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
		//Seleccionamos de la tabla Usuarios el usuario que concuerde con los datos suministrados.
		$SQL = "Select Codigo_USR from itusuarios where ID_USR = '".$_POST["txt_loginuser"]."'";
		$result = mysqli_query($conexion, $SQL);
		//Si el número de registros es diferente de cero existe el usuario.
		if(mysqli_num_rows($result) != 0)
			{
			//Ahora hacemos una consulta en la cual buscamos tanto al usuario como la clave. 
			$SQL = "Select Codigo_USR, Nombre_USR, ID_USR, a.Codigo_PRF, Nombre_PRF from itusuarios a, itperfiles b where a.Codigo_PRF=b.Codigo_PRF and ID_USR= '".$_POST["txt_loginuser"]."' and Clave_USR = SHA1('".$_POST["txt_loginpass"]."') and Activo_USR='1'";
			$result = mysqli_query($conexion, $SQL);
			$row = mysqli_fetch_array($result);
			//Si la consulta es diferente de cero la contraseña es válida
			if(mysqli_num_rows($result) != 0)
				{					
				$_SESSION["itTime_Out"]=time();
				$_SESSION["it_browsername"]=$_POST["hdn_browsername"];
				$_SESSION["it_browserversion"]=$_POST["hdn_browserversion"];
				$_SESSION["it_plataforma"]=$_POST["hdn_plataforma"];
				//Asignamos las varibles de session
				$_SESSION["it_NombreUSR"] = $row["Nombre_USR"];
				$_SESSION["it_user"] = $row["ID_USR"];
				$_SESSION["it_CodigoUSR"] = $row["Codigo_USR"];
				$_SESSION["it_CodigoPRF"] = $row["Codigo_PRF"];
				$_SESSION["it_NombrePRF"] = $row["Nombre_PRF"];
				$SQL="Update itusuarios set FechaAcceso_USR=now() Where ID_USR= '".$_POST["txt_loginuser"]."' ";
				$MyZone="SET time_zone = '".$_SESSION["DB_TIMEZONE"]."';";
				mysqli_query($conexion, $MyZone);
				it_aud('0', 'LogIn', 'Ingreso al Sistema');
				// Se verifica Si hay Token Para FE
				include 'getToken.php';	  
				if (isset($_GET["nxsdb"])) {
					header('Location: ../../../index.php?nxsdb='.$_SESSION["DB_SUFFIX"]);
				} else {
					header('Location: ../../../index.php');
				}
				}
			//Si la consulta no contiene registros el usuario es válido, pero la contraseña no.
			else
				{
					header('Location: ../../../login.php?action=2&nxsdb='.$_SESSION["DB_SUFFIX"]);
				}
			}
		//Si la consulta no contiene registros el usuario no existe.
		else
			{
				header('Location: ../../../login.php?action=1&nxsdb='.$_SESSION["DB_SUFFIX"]);
			}
		}
	else
		{
			header('Location: ../../../index.php?nxsdb='.$_SESSION["DB_SUFFIX"]);
		}
?>