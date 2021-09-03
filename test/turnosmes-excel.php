<?php
require_once("../functions/export-excel.php");
// Connect database.
include "functions/conectar.php";
// Get data records from table.
$SQL = "Select NomArea, isnull(CargoEmple, ''), E.CodEmple, ApeEmple + ' ' + NomEmple, SalarioEmple, '30', SMLV, AuxTransporte From TurnosAreas A, TurnosEmple E, TurnosConfig C Where A.CodArea=E.CodArea and EstadoEmple='1' and E.CodEmple <>'999' and CodEmpre='".$_GET["cmb_empre"]."' Order By ApeEmple + ' ' + NomEmple";
$result = mysqli_query(  $conexion, $SQL);
createExcel("Nomina Clinica El Prado ".$_GET["txt_anyoexcel"]."-".$_GET["cmb_mesexcel"].".xls");
xlsBOF();
$ElMes="";
switch ($_GET["cmb_mesexcel"]) {
  case "01": $ElMes== "ENERO";
  break; 
  case "02": $ElMes=="FEBRERO";
  break; 
  case "03": $ElMes=="MARZO";
  break; 
  case "04": $ElMes=="ABRIL";
  break; 
  case "05": $ElMes=="MAYO";
  break; 
  case "06": $ElMes=="JUNIO";
  break; 
  case "07": $ElMes=="JULIO";
  break; 
  case "08": $ElMes=="AGOSTO";
  break; 
  case "09": $ElMes=="SEPTIEMBRE";
  break; 
  case "10": $ElMes=="OCTUBRE";
  break; 
  case "11": $ElMes=="NOVIEMBRE";
  break; 
  case "12": $ElMes=="DICIEMBRE";
  break; 
  }

xlsWriteLabel(0,2,"COOPERATIVA INTEGRAR Y ASISTENCIA ".$ElMes." ".$_GET["txt_anyoexcel"]);
xlsWriteLabel(1,2,"TERCERO FMP CLINICA EL PRADO");
$xlsRow = 3;
xlsWriteLabel($xlsRow,8,"TIEMPO ADICIONAL");
$xlsRow++;
xlsWriteLabel($xlsRow,8,"RECARGO NOCT");
xlsWriteLabel($xlsRow,10,"HE DIURNA");
xlsWriteLabel($xlsRow,12,"HE NOCTURNA");
xlsWriteLabel($xlsRow,14,"DOMINGO Y FESTIVO");
xlsWriteLabel($xlsRow,16,"HE DYF DIURNO");
xlsWriteLabel($xlsRow,18,"HE DYF NOCTURNO");
xlsWriteLabel($xlsRow,20,"JORNADA ADICIONAL");
$xlsRow++;
xlsWriteLabel($xlsRow,0,"SERVICIO");
xlsWriteLabel($xlsRow,1,"CARGO");
xlsWriteLabel($xlsRow,2,"IDENTIFICACION");
xlsWriteLabel($xlsRow,3,"NOMBRE DEL ASOCIADO");
xlsWriteLabel($xlsRow,4,"COMPENSACION FIJA ACTUAL");
xlsWriteLabel($xlsRow,5,"DIAS");
xlsWriteLabel($xlsRow,6,"COMPENSACION BASE");
xlsWriteLabel($xlsRow,7,"TRANSP.");
xlsWriteLabel($xlsRow,8,"Cdad");
xlsWriteLabel($xlsRow,9,"Valor");
xlsWriteLabel($xlsRow,10,"Cdad");
xlsWriteLabel($xlsRow,11,"Valor");
xlsWriteLabel($xlsRow,12,"Cdad");
xlsWriteLabel($xlsRow,13,"Valor");
xlsWriteLabel($xlsRow,14,"Cdad");
xlsWriteLabel($xlsRow,15,"Valor");
xlsWriteLabel($xlsRow,16,"Cdad");
xlsWriteLabel($xlsRow,17,"Valor");
xlsWriteLabel($xlsRow,18,"Cdad");
xlsWriteLabel($xlsRow,19,"Valor");
xlsWriteLabel($xlsRow,20,"Cdad");
xlsWriteLabel($xlsRow,21,"Valor");
xlsWriteLabel($xlsRow,22,"TOTAL TIEMPO ADICIONAL");
xlsWriteLabel($xlsRow,23,"INCAPACIDADES");
xlsWriteLabel($xlsRow,24,"OTROS");
// Put data records from mysql by while loop.
$xlsRow++;
while($row=mysqli_fetch_array($result)){
	xlsWriteLabel($xlsRow,0,$row[0]);
	xlsWriteLabel($xlsRow,1,$row[1]);
	xlsWriteLabel($xlsRow,2,$row[2]);
	xlsWriteLabel($xlsRow,3,$row[3]);
	xlsWriteNumber($xlsRow,4,$row[4]);
	xlsWriteNumber($xlsRow,5,$row[5]);
	xlsWriteLabel($xlsRow,6,"=E".($xlsRow+1)."*F".($xlsRow+1)."/30");
	xlsWriteLabel($xlsRow,7,"=SI(E".($xlsRow+1)."<".number_format($row[6]*2, 2, ",", "").";(".number_format($row[7], 2, ",", "")."*F".($xlsRow+1).")/30;0)");
	//RECARGO NOCTURNO
	$SQL="SELECT SUM(HorasLiq), PorcRecargo, HorasEmple FROM TurnosLiq L, TurnosRecargos R, TurnosEmple E WHERE L.CodEmple='".$row[2]."' AND month(FechaTurno)='".$_GET["cmb_mesexcel"]."' and year(FechaTurno)='".$_GET["txt_anyoexcel"]."' and E.CodEmple=L.CodEmple and R.CodRecargo=L.CodRecargo and L.CodRecargo='02' Group By PorcRecargo, HorasEmple";
	$resultX=mysql_query($SQL);
	if($rowX=mysqli_fetch_array($resultX)){
		xlsWriteNumber($xlsRow,8,$rowX[0]);
		xlsWriteLabel($xlsRow,9,"=I".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[2])."*".number_format($rowX[1], 2, ",", ""));
	}
	else {
		xlsWriteNumber($xlsRow,8,"0");
		mysqli_free_result($resultX);
		$SQL="SELECT PorcRecargo, HorasEmple FROM TurnosRecargos R, TurnosEmple E WHERE E.CodEmple='".$row[2]."' and R.CodRecargo='02'";
		$resultX=mysql_query($SQL);
		if($rowX=mysqli_fetch_array($resultX)){
			xlsWriteLabel($xlsRow,9,"=I".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[1])."*".number_format($rowX[0], 2, ",", ""));
		}
	}
	mysqli_free_result($resultX);
	//HE DIURNA
	$SQL="SELECT SUM(HorasLiq), PorcRecargo, HorasEmple FROM TurnosLiq L, TurnosRecargos R, TurnosEmple E WHERE L.CodEmple='".$row[2]."' AND month(FechaTurno)='".$_GET["cmb_mesexcel"]."' and year(FechaTurno)='".$_GET["txt_anyoexcel"]."' and E.CodEmple=L.CodEmple and R.CodRecargo=L.CodRecargo and L.CodRecargo='03' Group By PorcRecargo, HorasEmple";
	$resultX=mysql_query($SQL);
	if($rowX=mysqli_fetch_array($resultX)){
		xlsWriteNumber($xlsRow,10,$rowX[0]);
		xlsWriteLabel($xlsRow,11,"=K".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[2])."*".number_format($rowX[1], 2, ",", ""));
	}
	else {
		xlsWriteNumber($xlsRow,10,"0");
		mysqli_free_result($resultX);
		$SQL="SELECT PorcRecargo, HorasEmple FROM TurnosRecargos R, TurnosEmple E WHERE E.CodEmple='".$row[2]."' and R.CodRecargo='03'";
		$resultX=mysql_query($SQL);
		if($rowX=mysqli_fetch_array($resultX)){
			xlsWriteLabel($xlsRow,11,"=K".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[1])."*".number_format($rowX[0], 2, ",", ""));
		}
	}
	mysqli_free_result($resultX);
	//HE NOCTURNA
	$SQL="SELECT SUM(HorasLiq), PorcRecargo, HorasEmple FROM TurnosLiq L, TurnosRecargos R, TurnosEmple E WHERE L.CodEmple='".$row[2]."' AND month(FechaTurno)='".$_GET["cmb_mesexcel"]."' and year(FechaTurno)='".$_GET["txt_anyoexcel"]."' and E.CodEmple=L.CodEmple and R.CodRecargo=L.CodRecargo and L.CodRecargo='04' Group By PorcRecargo, HorasEmple";
	$resultX=mysql_query($SQL);
	if($rowX=mysqli_fetch_array($resultX)){
		xlsWriteNumber($xlsRow,12,$rowX[0]);
		xlsWriteLabel($xlsRow,13,"=M".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[2])."*".number_format($rowX[1], 2, ",", ""));
	}
	else {
		xlsWriteNumber($xlsRow,12,"0");
		mysqli_free_result($resultX);
		$SQL="SELECT PorcRecargo, HorasEmple FROM TurnosRecargos R, TurnosEmple E WHERE E.CodEmple='".$row[2]."' and R.CodRecargo='04'";
		$resultX=mysql_query($SQL);
		if($rowX=mysqli_fetch_array($resultX)){
			xlsWriteLabel($xlsRow,13,"=M".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[1])."*".number_format($rowX[0], 2, ",", ""));
		}
	}
	mysqli_free_result($resultX);
	//DOMINGO Y FESTIVO
	$SQL="SELECT SUM(HorasLiq), PorcRecargo, HorasEmple FROM TurnosLiq L, TurnosRecargos R, TurnosEmple E WHERE L.CodEmple='".$row[2]."' AND month(FechaTurno)='".$_GET["cmb_mesexcel"]."' and year(FechaTurno)='".$_GET["txt_anyoexcel"]."' and E.CodEmple=L.CodEmple and R.CodRecargo=L.CodRecargo and L.CodRecargo='01' Group By PorcRecargo, HorasEmple";
	$resultX=mysql_query($SQL);
	if($rowX=mysqli_fetch_array($resultX)){
		xlsWriteNumber($xlsRow,14,$rowX[0]);
		xlsWriteLabel($xlsRow,15,"=O".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[2])."*".number_format($rowX[1], 2, ",", ""));
	}
	else {
		xlsWriteNumber($xlsRow,14,"0");
		mysqli_free_result($resultX);
		$SQL="SELECT PorcRecargo, HorasEmple FROM TurnosRecargos R, TurnosEmple E WHERE E.CodEmple='".$row[2]."' and R.CodRecargo='01'";
		$resultX=mysql_query($SQL);
		if($rowX=mysqli_fetch_array($resultX)){
			xlsWriteLabel($xlsRow,15,"=O".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[1])."*".number_format($rowX[0], 2, ",", ""));
		}
	}
	mysqli_free_result($resultX);
	//HE DYF DIURNO
	$SQL="SELECT SUM(HorasLiq), PorcRecargo, HorasEmple FROM TurnosLiq L, TurnosRecargos R, TurnosEmple E WHERE L.CodEmple='".$row[2]."' AND month(FechaTurno)='".$_GET["cmb_mesexcel"]."' and year(FechaTurno)='".$_GET["txt_anyoexcel"]."' and E.CodEmple=L.CodEmple and R.CodRecargo=L.CodRecargo and L.CodRecargo='05' Group By PorcRecargo, HorasEmple";
	$resultX=mysql_query($SQL);
	if($rowX=mysqli_fetch_array($resultX)){
		xlsWriteNumber($xlsRow,16,$rowX[0]);
		xlsWriteLabel($xlsRow,17,"=Q".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[2])."*".number_format($rowX[1], 2, ",", ""));
	}
	else {
		xlsWriteNumber($xlsRow,16,"0");
		mysqli_free_result($resultX);
		$SQL="SELECT PorcRecargo, HorasEmple FROM TurnosRecargos R, TurnosEmple E WHERE E.CodEmple='".$row[2]."' and R.CodRecargo='05'";
		$resultX=mysql_query($SQL);
		if($rowX=mysqli_fetch_array($resultX)){
			xlsWriteLabel($xlsRow,17,"=Q".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[1])."*".number_format($rowX[0], 2, ",", ""));
		}
	}
	mysqli_free_result($resultX);
	//HE DYF NOCTURNO
	$SQL="SELECT SUM(HorasLiq), PorcRecargo, HorasEmple FROM TurnosLiq L, TurnosRecargos R, TurnosEmple E WHERE L.CodEmple='".$row[2]."' AND month(FechaTurno)='".$_GET["cmb_mesexcel"]."' and year(FechaTurno)='".$_GET["txt_anyoexcel"]."' and E.CodEmple=L.CodEmple and R.CodRecargo=L.CodRecargo and L.CodRecargo='06' Group By PorcRecargo, HorasEmple";
	$resultX=mysql_query($SQL);
	if($rowX=mysqli_fetch_array($resultX)){
		xlsWriteNumber($xlsRow,18,$rowX[0]);
		xlsWriteLabel($xlsRow,19,"=S".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[2])."*".number_format($rowX[1], 2, ",", ""));
	}
	else {
		xlsWriteNumber($xlsRow,18,"0");
		mysqli_free_result($resultX);
		$SQL="SELECT PorcRecargo, HorasEmple FROM TurnosRecargos R, TurnosEmple E WHERE E.CodEmple='".$row[2]."' and R.CodRecargo='06'";
		$resultX=mysql_query($SQL);
		if($rowX=mysqli_fetch_array($resultX)){
			xlsWriteLabel($xlsRow,19,"=S".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[1])."*".number_format($rowX[0], 2, ",", ""));
		}
	}
	mysqli_free_result($resultX);
	//JORNADA ADICIONAL
	$SQL="SELECT HorasEmple FROM TurnosEmple WHERE CodEmple='".$row[2]."'";
	$resultX=mysql_query($SQL);
	if($rowX=mysqli_fetch_array($resultX)){
		xlsWriteNumber($xlsRow,20,"0");
		xlsWriteLabel($xlsRow,21,"=U".($xlsRow+1)."*E".($xlsRow+1)."/".number_format($rowX[0], 2, ",", ""));		
	}
	mysqli_free_result($resultX);
	xlsWriteLabel($xlsRow,22,"=J".($xlsRow+1)."+L".($xlsRow+1)."+N".($xlsRow+1)."+P".($xlsRow+1)."+R".($xlsRow+1)."+T".($xlsRow+1)."+V".($xlsRow+1));
	xlsWriteNumber($xlsRow,23,"0");
	xlsWriteNumber($xlsRow,24,"0");
	$xlsRow++;
}
//include "functions/desconectar.php";
xlsEOF();
exit();
?>