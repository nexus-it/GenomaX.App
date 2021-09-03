<?php
    $NumWindow = $_GET["ventana"];
    $elanyo = $_GET["anyo"];
    $elmes = $_GET["mes"];
    $CodArea = $_GET["area"];
    $Contrato = $_GET["contrato"];
    $resultx = '<div id="datempresa'.$NumWindow.'" class="tblDetalle1">
  <label for="txt_ordhours'.$NumWindow.'">Horas Ordinarias: </label><input name="txt_ordhours'.$NumWindow.'" type="text" disabled="disabled" id="txt_ordhours'.$NumWindow.'" value="';
    $NumDia=0;
	  $totalh=0;
	  //SE CALCULAN LOS DIAS HABILES DEL MES * 8
    while (UltimoDia($elanyo, $elmes)> $NumDia) {
	  $NumDia++;
		$SQL="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$elanyo."-".$elmes."-".$NumDia."'";
		$result = mysqli_query($conexion, $SQL);
		if(!($row=mysqli_fetch_array($result))) {
			if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))!=0) 
			{
				$totalh++;
			}
		}
		mysqli_free_result($result); 
	  }
	  $resultx = $resultx.($totalh*8).'" size="3" maxlength="3" readonly="readonly" />
  </div>
  <br>  
  <table width="100%" align="center" cellpadding="0" cellspacing="0" class="tblDetalle" >
  <tr>
    <th rowspan="2" align="center" valign="middle"> EMPLEADO </th>';
  $Weekday="";
	$Colorday="";
	$NumDia=0;
	while (UltimoDia($elanyo, $elmes)> $NumDia) {
	$NumDia++;
	$Colorday="2";
	$SQL="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$elanyo."-".$elmes."-".$NumDia."'";
	$result = mysqli_query($conexion, $SQL);
	if($row=mysqli_fetch_array($result)) {
	 $Colorday='class="festivo"';
	}
	else
	{
		$Colorday="";
	}
	mysqli_free_result($result); 
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==1) $Weekday= "Lu";
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==2) $Weekday= "Ma";
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==3) $Weekday= "Mi";
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==4) $Weekday= "Ju";
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==5) $Weekday= "Vi";
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==6) $Weekday= "Sa";
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==0) 
	{
		$Weekday= "Do";
		$Colorday='class="festivo"';
	}
	$resultx = $resultx.'<th  '.$Colorday.'>'.$Weekday.'</th>';
	}
	$resultx = $resultx.'
  </tr>
  <tr>';
  $Weekday="";
	$Colorday="";
	$NumDia=0;
	while (UltimoDia($elanyo, $elmes)> $NumDia) {
	$NumDia++;
	$SQL="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$elanyo."-".$elmes."-".$NumDia."'";
	$result = mysqli_query($conexion, $SQL);
	if($row=mysqli_fetch_array($result)) {
		$Colorday='class="festivo2"';
	} else {
		$Colorday="";
	}
	mysqli_free_result($result); 
	if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==0) 
	{
		$Colorday='class="festivo2"';
	}
	$resultx = $resultx. '<td align="center" valign="middle" bgcolor="#DFDFDF" '.$Colorday.'>'.$NumDia.'</td>';
	}
	$resultx = $resultx.'
  </tr>';
  $SQL="SELECT distinct Nombre_TER, A.Codigo_TER FROM czempleados A, czterceros B, czareasterceros C WHERE A.Codigo_TER=B.Codigo_TER AND A.Codigo_TER=C.Codigo_TER AND C.Codigo_ARE='".$CodArea."' AND Codigo_TCL='".$Contrato."' AND Estado_EMP='1';";
  $result = mysqli_query($conexion, $SQL);
  while($row=mysqli_fetch_array($result)) {
$resultx = $resultx.'
  <tr>
    <td align="left">'.ucwords(strtolower($row[0])).'</td>
  ';
	$NumDia=0;
	while (UltimoDia($elanyo, $elmes)> $NumDia) {
	$NumDia++;
$resultx = $resultx.'
    <td align="center" valign="middle">
  ';
	$SQL="Select DiaFest_FST From czfestivos Where DiaFest_FST='".$elanyo."-".$elmes."-".$NumDia."'";
	$result2 = mysqli_query($conexion, $SQL);
	if($row2=mysqli_fetch_array($result2)) {
		$Colorday='class="festivo2"';
	}
	else
	{
		$Colorday="";
		if (date("w", mktime(0, 0, 0, $elmes, $NumDia, $elanyo))==0) 
		{
			$Colorday='class="festivo2"';
		}
	}
	mysqli_free_result($result2);
	$SQL="Select rtrim(Codigo_TRN), Fecha_TUR, month(Fecha_TUR), day(Fecha_TUR), year(Fecha_TUR) From czturnosdet Where Codigo_TER='".$row[1]."' and month(Fecha_TUR)='".$elmes."' and year(Fecha_TUR)='".$elanyo."' and day(Fecha_TUR)='".$NumDia."'";
	$result1 = mysqli_query($conexion, $SQL);
	if($row1=mysqli_fetch_array($result1)) {
      $resultx = $resultx. '<input name="txt_dia'.$row1[3].'_'.rtrim($row[1]).$NumWindow.'" type="text" id="txt_dia'.$row1[3].'_'.rtrim($row[1]).$NumWindow.'" '.$Colorday.' value="'.$row1[0].'" size="1" maxlength="2" onkeydown="if(event.keyCode==115){CargarSearch(\'Turnos\', \'txt_dia'.$row1[3].'_'.rtrim($row[1]).$NumWindow.'\', \'NULL\')};" title="<F4> Para buscar tipos de turnos activos" />';
	} else {
      $resultx = $resultx. '<input name="txt_dia'.$row1[3].'_'.rtrim($row[1]).$NumWindow.'" type="text" id="txt_dia'.$row1[3].'_'.rtrim($row[1]).$NumWindow.'" '.$Colorday.' value="00" size="1" maxlength="2" onkeydown="if(event.keyCode==115){CargarSearch(\'Turnos\', \'txt_dia'.$row1[3].'_'.rtrim($row[1]).$NumWindow.'\', \'NULL\')};" title="<F4> Para buscar tipos de turnos activos" />';
	}
	mysqli_free_result($result1);
$resultx = $resultx.'
      </td>';
	}
$result. = $resultx.'
  </tr>';
	}
	mysqli_free_result($result);
$result. = $resultx.'</table>
<hr align="center" width="95%" size="1"  class="anulado" />
<table align="left" cellpadding="0" cellspacing="0" class="tblDetalle" >
    <tr>
      <th align="left" scope="col">Observaciones</th>
    </tr>
    <tr>
      <td align="left" valign="top">
        <textarea name="txt_observaciones" cols="60" rows="5" wrap="physical" id="txt_observaciones"></textarea>
      </td>
    </tr>
</table>

<table border="1" align="right" cellpadding="0" cellspacing="0"class="tblDetalle" >
    <tr>
      <th colspan="4" align="center" valign="middle">Consolidado</th>
    </tr>
    <tr>
      <td align="center" valign="middle" bgcolor="#DFDFDF">Asociado</td>
      <td align="center" valign="middle" bgcolor="#DFDFDF">Horas/Mes</td>
      <td align="center" valign="middle" bgcolor="#DFDFDF">Base H. E.</td>
      <td align="center" valign="middle" bgcolor="#DFDFDF">Total H.E.</td>
    </tr>';
$SQL="SELECT distinct Nombre_TER, A.Codigo_TER FROM czempleados A, czterceros B, czareasterceros C WHERE A.Codigo_TER=B.Codigo_TER AND A.Codigo_TER=C.Codigo_TER AND C.Codigo_ARE='".$CodArea."' AND Codigo_TCL='".$Contrato."' AND Estado_EMP='1';";
//$SQL="SELECT distinct Nombre_TER, E.Codigo_TER FROM czterceros E, czturnosdet T, czareasterceros A WHERE T.Codigo_TER=A.Codigo_TER and T.Codigo_TER=E.Codigo_TER and A.Codigo_ARE='".$CodArea."' and month(Fecha_TUR)='".$elmes."' and year(Fecha_TUR)='".$elanyo."' AND Codigo_TCL='".$Contrato."' and Estado_EMP='1'";
$result = mysqli_query($conexion, $SQL);
  while($row=mysqli_fetch_array($result)) {
  $result. = $resultx.'    <tr>
    <td align="left">'.ucwords(strtolower($row[0])).'</td>
    <td align="right">';
    $HorasDesc=0;
    $SQL="SELECT sum(Descanso_TRN) From cztipoturnos H, czturnosdet T, czterceros E Where H.Codigo_TRN=T.Codigo_TRN and E.Codigo_TER=T.Codigo_TER and E.Codigo_TER='".$row[1]."' and month(Fecha_TUR)='".$elmes."' and year(Fecha_TUR)='".$elanyo."'";
    $result2 = mysqli_query($conexion, $SQL);
    if($row2=mysqli_fetch_array($result2)) {
    $HorasDesc = $row2[0];
    }
    mysqli_free_result($result2);
    $SQL="SELECT sum(TotalHoras_TRN) From cztipoturnos H, czturnosdet T, czterceros E Where H.Codigo_TRN=T.Codigo_TRN and E.Codigo_TER=T.Codigo_TER and E.Codigo_TER='".$row[1]."' and month(Fecha_TUR)='".$elmes."' and year(Fecha_TUR)='".$elanyo."'";
    $result2 = mysqli_query($conexion, $SQL);
    if($row2=mysqli_fetch_array($result2)) {
      $resultx = $resultx.($row2[0] - $HorasDesc);
    }
    mysqli_free_result($result2);
    $result. = $resultx.'</td>
    <td align="right">';
    $HorasTotales=0;
    $HorasFest=0;
    $HorasDesc=0;
    $SQL="SELECT sum(TotalHoras_TRN) From cztipoturnos H, czturnosdet T, czterceros E Where H.Codigo_TRN=T.Codigo_TRN and E.Codigo_TER=T.Codigo_TER and E.Codigo_TER='".$row[1]."' and month(Fecha_TUR)='".$elmes."' and year(Fecha_TUR)='".$elanyo."'";
    $result2 = mysqli_query($conexion, $SQL);
    if($row2=mysqli_fetch_array($result2)) {
      $HorasTotales = $row2[0];
    }
    mysqli_free_result($result2);
    //CALCULO DE HORAS DE LOS FESTIVOS
    $SQL="Select T1.Codigo_TRN, T1.Fecha_TUR, H1.Inicia_TRN, H1.Termina_TRN, CASE DAY(T1.Fecha_TUR) WHEN '01' THEN '00:00' ELSE H2.Inicia_TRN END, CASE DAY(T1.Fecha_TUR) WHEN '01' THEN '00:00' ELSE H2.Termina_TRN END 
    From czturnosdet T1, cztipoturnos H1, czturnosdet T2, cztipoturnos H2
    Where  T1.Fecha_TUR in (Select DiaFest_FST from czfestivos where month(DiaFest_FST)='".$elmes."' and year(DiaFest_FST)='".$elanyo."') and T1.Codigo_TER='".$row[1]."' and T1.Codigo_TRN=H1.Codigo_TRN 
    AND T2.Codigo_TER=T1.Codigo_TER AND T2.Fecha_TUR=(DateAdd(d, -1 ,T1.Fecha_TUR)) and T2.Codigo_TRN=H2.Codigo_TRN";
    $result2 = mysqli_query($conexion, $SQL);
    while($row2=mysqli_fetch_array($result2)) {
      if ($row2[4] > $row2[5]) {
        $HorasFest = $HorasFest + $row2[5];
      }
      if ($row2[2] > $row2[3]) {
        $HorasFest = $HorasFest + (24 - $row2[2]);
      }
      else
      {
        $HorasFest = $HorasFest + ($row2[3] - $row2[2]);
      }
    }
    mysqli_free_result($result2);
    //CALCULO DE LOS DESCANSOS
    $SQL="SELECT sum(Descanso_TRN) From cztipoturnos H, czturnosdet T, czterceros E Where H.Codigo_TRN=T.Codigo_TRN and E.Codigo_TER=T.Codigo_TER and E.Codigo_TER='".$row[1]."' and month(Fecha_TUR)='".$elmes."' and year(Fecha_TUR)='".$elanyo."'
    and Fecha_TUR not in (Select DiaFest_FST from czfestivos where month(DiaFest_FST)='".$elanyo."' and year(DiaFest_FST)='".$elanyo."')";
    $result2 = mysqli_query($conexion, $SQL);
    if($row2=mysqli_fetch_array($result2)) {
      $HorasDesc = $row2[0];
    }
    mysqli_free_result($result2);
    //TOTALIZAR
    $HorasTotales = $HorasTotales - ($HorasFest + $HorasDesc);
    $resultx = $resultx.$HorasTotales;
    $result. = $resultx.'</td>
      <td align="right">';
    if (($HorasTotales)-($totalh*8)>0) {
      $resultx = $resultx.(($HorasTotales)-($totalh*8));
    }
    else {
      $resultx = $resultx.'--'"';
    }
    $result. = $resultx.'</td>
    </tr>';
}
$result. = $resultx.'</table>';