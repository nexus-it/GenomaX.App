<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
date_default_timezone_set('America/Bogota');
define('NUM_ITEMS_BY_PAGE', 10);



function listarFacturas($filtro,$ini,$fin){
   $html="";	
  
  $SQL="SELECT t1.Codigo_FAC, Fecha_FAC, Nombre_TER, Nombre_EPS, t1.Codigo_ADM, IdFE_FAC, ObtenNumeros(t1.Codigo_FAC), t1.valtotal_fac  FROM gxfacturas t1 
  INNER JOIN gxadmision t2 ON t1.Codigo_ADM = t2.Codigo_ADM
  INNER JOIN czterceros t3 ON t3.Codigo_TER = t2.Codigo_TER 
  INNER JOIN gxeps t4 ON t2.Codigo_EPS = t4.Codigo_EPS";
   //$SQL .=  " where T1.codigo_fac= 'BQ-14414'  "; 
  
  if($filtro <> ''){
   $SQL .=  $filtro; 
  }
  $SQL .= " and estado_fac = 1 ORDER BY fecha_fac desc,7 desc  limit $ini,$fin"; //  limit $ini,$fin
  error_log($SQL);
  $conexion=conexion();
  $result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
      //echo $SQL;
      	$html = '
			<tr>
				<th>Factura</th>
				<th>Fecha</th>
				<th>Paciente / Cliente</th>
				<th>Entidad</th>
            <th>Valor</th>
				<th >Acciones</th>
			</tr>
			';
		$html .= '<tbody class="row items">';

      $SQL_m="Select Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from nxs_gnx.ititems as a, nxs_gnx.itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='2' and a.Codigo_MOD='2' and c.Codigo_MNU='50' and Padre_ITM='489' AND Codigo_ITM = 431 order by Codigo_ITM;";
      $result4 = mysqli_query($conexion, $SQL_m);
      $row4 = mysqli_fetch_row($result4);
      
      $result = mysqli_query($conexion, $SQL);//aqui lo vuelvo a ejecutar para que refrezcue el indice, se debe validar
      while($row = mysqli_fetch_array($result)){
            $html .= '<tr class="item">';
            $html .= '<td> '.($row[0]).'</td>';
            $html .= '<td> '.($row[1]).'</td>'; 
            $html .= '<td> '.($row[2]).'</td>';
            $html .= '<td> '.($row[3]).'</td>';
            $html .= '<td align="right"> $ '.number_format($row[7],0,',','.').'</td>';

            $string = str_replace(' ','',str_replace('-',' ',$row[0]));
            $Consecutivo = preg_replace('/[^0-9]/', '', $string);
            $cadena = explode($Consecutivo,$string);
            $Pref = $cadena[0];
            $btnedit='onclick="CargarForm(\'application/'.$row4[2].'?Ingreso='.$row[4].'\', \''.$row4[1].'\', \''.$row4[4].'\'); AddFavsForm(\''.$row4[0].'\'); "'; 
            $btnsend='onclick="putSendFactura(\''.$row[0].'\'); "';
            $btnprint=' title="Vista previa factura '.$row[0].'" data-toggle="modal" data-target="#GnmX_WinModal" onclick="rptInvoice(\''.$Pref.'\',\''.$Consecutivo.'\')"';
            if($row[5] != '0'){
               $sendInvoice = ' disabled="disabled" title="Factura Enviada" ';
            }else{
               $sendInvoice = ' ';
            }
            $botonera='<div class="btn-group btn-group-sm " role="group" aria-label="..." id="btngrp'.($row[0]).'">
               <button type="button" class="btn btn-warning" '.$sendInvoice.$btnedit.' id="btnedit'.($row[0]).'" > <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> </button>
               <button type="button" class="btn btn-success" '.$sendInvoice.$btnsend.' id="btnsend'.($row[0]).'" > <span class="glyphicon glyphicon-send" aria-hidden="true"></span> </button>
               <button type="button" class="btn btn-default" '.$btnprint.'> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </button>
            </div>
            <div class="progress" style="display: none; margin-top: 0px;" name="prgFE'.($row[0]).'" id="prgFE'.($row[0]).'"> <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%; height: 16px; margin-top: 0px;"> <span class="sr-only">Enviando Factura</span> </div></div>
            ';
            $html .= '<td align="center">'.$botonera.'</td>'; 
            /* $action1='onclick="CargarForm(\'application/'.$row4[2].'?numeroIng='.$row[4].'\', \''.$row4[1].'\', \''.$row4[4].'\'); AddFavsForm(\''.$row4[0].'\'); "'; 
            $action1=  '<a title="Editar Factura" class="manito" '.$action1.'><i class="fa fa-broom"></i></a> ';
      
            $html .= '<td>'.$action1.'</td>'; 

            if($row[5] != '0'){
               $html .= '<td><i title="Factura Enviada" class="fa fa-paper-plane"></i><a href="#" class="estadoFacturaDoc" data-f="'.$row[0].'" data-c="'.$cufe.'" "><i title="Validar Estado Factura Enviada" class="fa fa-thermometer-quarter"></i></a><div id="resultadoEnvioFacturaEstado"></div></td>';
            }else{
               $html .= '<td> <a title="Enviar Factura a la DIAN" href="#" class="enviarfactdian" data="'.$row[0].'"><i class="fa fa-paper-plane"></i></a></a><div id="resultadoEnvioFactura"></div><div id="resultadoEnvioFacturaEstado"></div></td>';
            }
            */
            $html .= '</tr>';
      }
      $html .= '</tbody>';

      echo $html;

	} else {
		echo '<span class="error">No se pudo acceder informacion de facturacion.</span>';
	}
	mysqli_free_result($result);
}

function contarFacts($filtro, $pag, $ShowReg) {
   $TotalFact=0;
   $btnatras="";
   $btnadelante="";
   $SQLx="SELECT count(*) FROM gxfacturas t1 ";
   $SQLx="SELECT count(*) FROM gxfacturas t1 
  INNER JOIN gxadmision t2 ON t1.Codigo_ADM = t2.Codigo_ADM
  INNER JOIN czterceros t3 ON t3.Codigo_TER = t2.Codigo_TER 
  INNER JOIN gxeps t4 ON t2.Codigo_EPS = t4.Codigo_EPS";
   //$SQL .=  " where T1.codigo_fac= 'BQ-14414'  "; 
  
  if($filtro <> ''){
   $SQLx .=  $filtro; 
  }
  $SQLx .= " and estado_fac = 1 "; //  limit $ini,$fin

  $conexion=conexion();
   $resultx = mysqli_query($conexion, $SQLx);
      if($rowx = mysqli_fetch_array($resultx)) {
         $TotalFact=$rowx[0];
      }
   mysqli_free_result($resultx);
   $TotPaginas=$TotalFact/$ShowReg;
   $rndTotPag=round($TotPaginas);
   if($rndTotPag<>$TotPaginas) {
      $TotPaginas=round($TotPaginas+1);
   }
   if($pag=="1") {
      $btnatras=' disabled="disabled"';
   }
   if($pag==$TotPaginas) {
      $btnadelante=' disabled="disabled"';
   }
   $html='<div class="row">
   <div class="col-lg-2">
     <div class="input-group">
       <span class="input-group-btn">
         <button class="btn btn-success pagefact" type="button" title="Atrás" '.$btnatras.' data="'.($pag - 1).'"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> </button>
       </span>
       <input type="text" class="form-control" placeholder="Página"  disabled="disabled" value="'.$pag.' / '.$TotPaginas.'" style="text-align:center;">
       <span class="input-group-btn">
         <button class="btn btn-success pagefact" type="button" title="Adelante" '.$btnadelante.' data="'.($pag + 1).'"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> </button>
       </span>
     </div>
   </div>
 </div>';
 echo $html;
}

function listarNotasCredito($filtro,$ini,$fin){
   
   if($ini == ''){
      $ini=0;
   }
   if($fin <> 20){
      $ini=$fin;
      $fin=20;
   }

   $html="";	

  $SQL="SELECT * FROM gxfacturas t1   INNER JOIN gxadmision t2 ON t1.Codigo_ADM = t2.Codigo_ADM  INNER JOIN czterceros t3 ON t3.Codigo_TER = t2.Codigo_TER   INNER JOIN gxeps t4 ON t2.Codigo_EPS = t4.Codigo_EPS  INNER JOIN cznotascontablesenc t5 ON T1.Codigo_FAC = T5.NumeroDoc_NCT";
   //$SQL .=  " where T1.codigo_fac= 'BQ-14414'  "; 
  
  if($filtro <> ''){
   $SQL .=  " where T5.Codigo_NCT = '$filtro' "; 
  }
  $SQL .= " and estado_fac = 1 ORDER BY fecha_fac desc limit 0,20  ";

  
  $conexion=conexion();
  $result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
      //echo $SQL;
      	$html = '<tr>
            <th>Notas Credito</th>
            <th>Fecha NC</th>
				<th>Factura</th>
				<th>Fecha</th>
				<th>Paciente / Cliente</th>
				<th>Entidad</th>
				<th colspan="2">Estados</th>
			</tr>';
		$html .= '<tbody class="row items">';

      $SQL_m="Select Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from nxs_gnx.ititems as a, nxs_gnx.itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='2' and a.Codigo_MOD='2' and c.Codigo_MNU='50' and Padre_ITM='489' AND Codigo_ITM = 431 order by Codigo_ITM;";
      $result4 = mysqli_query($conexion, $SQL_m);
      $row4 = mysqli_fetch_row($result4);
      $result = mysqli_query($conexion, $SQL);//aqui lo vuelvo a ejecutar para que refrezcue el indice, se debe validar
      while($row = mysqli_fetch_array($result)){
            $html .= '<tr class="item">';
            $html .= '<td> '.($row['Codigo_NCT']).'</td>';
            $html .= '<td> '.($row['Fecha_NCT']).'</td>';
            $html .= '<td> '.($row[1]).'</td>';
            $html .= '<td> '.($row['Fecha_FAC']).'</td>'; 
            $html .= '<td> '.($row['Nombre_TER']).'</td>';
            $html .= '<td> '.($row['Nombre_EPS']).'</td>';

            //$action1='onclick="CargarForm(\'application/'.$row4[2].'?numeroIng='.$row[3].'\', \''.$row4[1].'\', \''.$row4[4].'\'); AddFavsForm(\''.$row4[0].'\'); "'; 
            //$action1=  '<a class="manito" '.$action1.'><i class="fa fa-chevron-circle-right"></i> '.$row4[1].'</a> ';
      
            //$html .= '<td>'.$action1.'</td>';
            
            /* $cadnit = explode("-",verficarEmpresaReg());
            $url = url_exists("https://backend.estrateg.com/nexusIt/storage/app/public/".$cadnit[0]."/NCS-9".$row['Codigo_NCT'].".pdf")? 'existe' : 'no existe';
             */
            if($url == 'existe'){
               $html .= '<td><i title="Nota Credito Enviada" class="fa fa-paper-plane"></i></td>';
            }else{
               $html .= '<td> <a title="Enviar Nota Credito a la DIAN" href="#" class="enviarnotacreditodian" data="'.$row['Codigo_NCT'].'"><i class="fa fa-paper-plane"></i></a><div id="resultadoEnvioNC"></div> </td>';
            }

            $html .= '</tr>';
      }
      $html .= '</tbody>';

      echo $html;

      /* $SQL1="SELECT count(*) as conteo FROM gxfacturas t1 
      INNER JOIN gxadmision t2 ON t1.Codigo_ADM = t2.Codigo_ADM
      INNER JOIN czterceros t3 ON t3.Codigo_TER = t2.Codigo_TER 
      INNER JOIN gxeps t4 ON t2.Codigo_EPS = t4.Codigo_EPS";
      $conexion=conexion();
      $result1 = mysqli_query($conexion, $SQL1);
      if($row1 = mysqli_fetch_row($result1)) {
          $conteo =  $row1[0];
      }
      mysqli_free_result($result);
      return $conteo; */
   

	} else {
		echo '<span class="error">No se pudo acceder a la versión del sistema.</span>';
	}
	mysqli_free_result($result);	
}



function listarFacturasCapita($filtro,$ini,$fin){
   
   if($ini == ''){
      $ini=0;
   }
   if($fin <> 10){
      $ini=$fin;
      $fin=10;
   }

   $html="";	



  $SQL="SELECT * FROM gxfacturas t1 
  INNER JOIN gxeps t2 ON t1.Codigo_EPS = t2.Codigo_EPS 
  INNER JOIN gxfacturascapita t3 ON T1.Codigo_FAC = t3.Codigo_FAC ";
   //$SQL .=  " where T1.codigo_fac= 'BQ-14414'  "; 
  
  if($filtro <> ''){
   $SQL .=  " where T1.codigo_fac = '$filtro' "; 
  }
  $SQL .= " and estado_fac = 1 ORDER BY fecha_fac desc limit $ini,$fin  ";

  
  $conexion=conexion();
  $result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
      //echo $SQL;
      if($ini <>''){
			$html = '<thead>
			<tr>
				<td>Factura</td>
				<td>Fecha</td>
				<td>Entidad</td>
				<td>Estados</td>
			</tr>
			</thead>';
		}      
		$html .= '<tbody class="row items">';

      $SQL_m="Select Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from nxs_gnx.ititems as a, nxs_gnx.itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='2' and a.Codigo_MOD='2' and c.Codigo_MNU='50' and Padre_ITM='0' AND Codigo_ITM = 459 order by Codigo_ITM;";
      $result4 = mysqli_query($conexion, $SQL_m);
      $row4 = mysqli_fetch_row($result4);
      
      

      $result = mysqli_query($conexion, $SQL);//aqui lo vuelvo a ejecutar para que refrezcue el indice, se debe validar
      while($row = mysqli_fetch_array($result)){
            $html .= '<tr class="item">';
            $html .= '<td> '.($row[1]).'</td>';
            $html .= '<td> '.($row['Fecha_FAC']).'</td>'; 
            $html .= '<td> '.($row['Nombre_EPS']).'</td>';

            //$action1='onclick="CargarForm(\'application/'.$row4[2].'?numeroIng='.$row[3].'\', \''.$row4[1].'\', \''.$row4[4].'\'); AddFavsForm(\''.$row4[0].'\'); "'; 
            //$action1=  '<a class="manito" '.$action1.'><i class="fa fa-chevron-circle-right"></i> '.$row4[1].'</a> ';
            //$html .= '<td>'.$action1.'</td>';
            $cadnit = explode("-",verficarEmpresaReg());
            $cadfac = explode("-",$row[1]);
            $url = url_exists("https://backend.estrateg.com/nexusIt/storage/app/public/".$cadnit[0]."/FES-".$cadfac[0].$cadfac[1].".pdf")? 'existe' : 'no existe';
            $cufe = ValidarCUfe($cadnit[0],$cadfac[0],$cadfac[1]);

            if($url == 'existe' and $cufe <> ''){
               $html .= '<td><i title="Factura capita Enviada" class="fa fa-paper-plane"></i><a href="#" class="estadoFacturaDoc" data-f="'.$row[1].'" data-c="'.$cufe.'" "><i title="Validar Estado Factura Enviada" class="fa fa-thermometer-quarter"></i></a><div id="resultadoEnvioFacturaEstado"></div></td>';
            }else{
               $html .= '<td> <a  title="Enviar factura capita a la DIAN " href="#" class="enviarfactcapitadian" data="'.$row[1].'"><i class="fa fa-paper-plane"></i></a><div id="resultadoEnvioFacturaCapita"></div> </td>';
            }

            $html .= '</tr>';
      }
      $html .= '</tbody>';

      echo $html;

      $SQL1="SELECT count(*) as conteo FROM gxfacturas t1 
      INNER JOIN gxeps t2 ON t1.Codigo_EPS = t2.Codigo_EPS 
      INNER JOIN gxfacturascapita t3 ON T1.Codigo_FAC = t3.Codigo_FAC ";
      $conexion=conexion();
      $result1 = mysqli_query($conexion, $SQL1);
      if($row1 = mysqli_fetch_row($result1)) {
          $conteo =  $row1[0];
      }
      mysqli_free_result($result);
      return $conteo;
   

	} else {
		echo '<span class="error">No se pudo acceder a la versión del sistema.</span>';
	}
	mysqli_free_result($result);	
}





function listarNotasCreditoCapita($filtro,$ini,$fin){
   
   if($ini == ''){
      $ini=0;
   }
   if($fin <> 10){
      $ini=$fin;
      $fin=10;
   }

   $html="";	



  $SQL="SELECT * FROM gxfacturas t1 
  INNER JOIN gxeps t2 ON t1.Codigo_EPS = t2.Codigo_EPS 
  INNER JOIN gxfacturascapita t3 ON T1.Codigo_FAC = t3.Codigo_FAC 
  INNER JOIN cznotascontablesenc t4 ON T1.Codigo_FAC = T4.NumeroDoc_NCT";
   //$SQL .=  " where T1.codigo_fac= 'BQ-14414'  "; 
  
  if($filtro <> ''){
   $SQL .=  " where T4.Codigo_NCT = '$filtro' "; 
  }
  $SQL .= " and estado_fac = 1 ORDER BY fecha_fac desc limit $ini,$fin  ";

  
  $conexion=conexion();
  $result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
      //echo $SQL;
      if($ini <>''){
			$html = '<thead>
			<tr>
            <td>Nota Credito</td>
            <td>Fecha NC</td>
				<td>Factura</td>
				<td>Fecha</td>
            <td>Paciente / Cliente</td>
				<td>Entidad</td>
				<td>Estados</td>
			</tr>
			</thead>';
		}      
		$html .= '<tbody class="row items">';

      $SQL_m="Select Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from nxs_gnx.ititems as a, nxs_gnx.itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='2' and a.Codigo_MOD='2' and c.Codigo_MNU='50' and Padre_ITM='0' AND Codigo_ITM = 459 order by Codigo_ITM;";
      $result4 = mysqli_query($conexion, $SQL_m);
      $row4 = mysqli_fetch_row($result4);
      
      

      $result = mysqli_query($conexion, $SQL);//aqui lo vuelvo a ejecutar para que refrezcue el indice, se debe validar
      while($row = mysqli_fetch_array($result)){
            $html .= '<tr class="item">';
            $html .= '<td> '.($row['Codigo_NCT']).'</td>';
            $html .= '<td> '.($row['Fecha_NCT']).'</td>';
            $html .= '<td> '.($row[1]).'</td>';
            $html .= '<td> '.($row['Fecha_FAC']).'</td>'; 
            $html .= '<td> '.($row['Nombre_EPS']).'</td>';
            $html .= '<td> '.($row['Nombre_EPS']).'</td>';

            //$action1='onclick="CargarForm(\'application/'.$row4[2].'?numeroIng='.$row[3].'\', \''.$row4[1].'\', \''.$row4[4].'\'); AddFavsForm(\''.$row4[0].'\'); "'; 
            //$action1=  '<a class="manito" '.$action1.'><i class="fa fa-chevron-circle-right"></i> '.$row4[1].'</a> ';
            //$html .= '<td>'.$action1.'</td>';

            $cadnit = explode("-",verficarEmpresaReg());
            $url = url_exists("https://backend.estrateg.com/nexusIt/storage/app/public/".$cadnit[0]."/NCS-9".$row['Codigo_NCT'].".pdf")? 'existe' : 'no existe';
            
            if($url == 'existe'){
               $html .= '<td><i title="Nota Credito capita Enviada" class="fa fa-paper-plane"></i></td>';
            }else{
               $html .= '<td> <a title="Enviar Nota Credito a la DIAN" href="#" class="enviarnotacreditocapitadian" data="'.$row[1].'"><i class="fa fa-paper-plane"></i></a><div id="resultadoEnvioNCCapita"></div> </td>';
            }
            $html .= '</tr>';
      }
      $html .= '</tbody>';

      echo $html;

      $SQL1="SELECT count(*) as conteo FROM gxfacturas t1 
      INNER JOIN gxeps t2 ON t1.Codigo_EPS = t2.Codigo_EPS 
      INNER JOIN gxfacturascapita t3 ON T1.Codigo_FAC = t3.Codigo_FAC ";
      $conexion=conexion();
      $result1 = mysqli_query($conexion, $SQL1);
      if($row1 = mysqli_fetch_row($result1)) {
          $conteo =  $row1[0];
      }
      mysqli_free_result($result);
      return $conteo;
   

	} else {
		echo '<span class="error">No se pudo acceder a la versión del sistema.</span>';
	}
	mysqli_free_result($result);	
}





function url_exists($url) {
    $h = get_headers($url);
    $status = array();
    preg_match('/HTTP\/.* ([0-9]+) .*/', $h[0] , $status);
    return ($status[1] == 200);
}


function ValidarCUfe($nit,$prefix,$number){
   $conexion = mysqli_connect("backend.estrateg.com", "makoto", "M@koto23*", "Billing");
   mysqli_query ($conexion, "SET NAMES 'utf8'");
   $cadena = explode("-",$nit);
   $sql = "SELECT * FROM `Billing`.`documents` where identification_number =".$cadena[0]." AND CUFE IS NOT NULL and prefix = '".$prefix."' and number = ".$number ;
   $result = mysqli_query($conexion, $sql);
   $datosEmp = mysqli_fetch_array($result);
   
   //return $sql;
   return $datosEmp['cufe'];
 }

?>
