﻿<?php
error_reporting(E_ERROR | E_PARSE);
session_start();
date_default_timezone_set('America/Bogota');
define('NUM_ITEMS_BY_PAGE', 10);

function listarFacturasCompra($filtro,$ini,$fin){
   $html="";	
  
  $SQL="SELECT a.Codigo_FAC, b.Nombre_TER, a.Consec_FAC, a.Fecha_FAC, a.Vence_FAC, a.Total_FAC, c.Saldo_CXP FROM czfacturascompra a, czterceros b, czcuentasxpagar c  ";
   //$SQL .=  " where T1.codigo_fac= 'BQ-14414'  "; 
  
  if($filtro <> ''){
   $SQL .=  $filtro; 
  }
  $SQL .= " and a.Codigo_TER=b.Codigo_TER AND a.Codigo_FAC=c.Codigo_FAC ORDER BY a.Fecha_FAC DESC LIMIT 200"; //  limit $ini,$fin
  //error_log($SQL);
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

      $SQL_m="Select Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='2' and a.Codigo_MOD='2' and c.Codigo_MNU='50' and Padre_ITM='489' AND Codigo_ITM = 431 order by Codigo_ITM;";
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
            $btnmail='onclick="estadoFacturaDoc(\''.$row[5].'\', \''.$row[0].'\'); "';
            $btnxml='href="https://backend.estrateg.com/API/storage/app/public/900993679/FE-'.$row[0].'.xml" download="FE-'.$row[0].'.xml"';
            $btnprint=' title="Vista previa factura '.$row[0].'" data-toggle="modal" data-target="#GnmX_WinModal" onclick="rptInvoice(\''.$Pref.'\',\''.$Consecutivo.'\')"';
            if($row[5] != '0'){
               $sendInvoice = ' disabled="disabled" title="Factura Enviada" ';
               $sendEdit = ' disabled="disabled" title="Factura Enviada" ';
               $sendMail = ' title="Enviar factura por correo" ';
               $sendXML = ' title="Descargar XML" ';
            }else{
               $sendInvoice = ' title="Enviar factura a la DIAN" ';
               $sendEdit = ' title="Editar factura" ';
               $sendMail = ' disabled="disabled" ';
               $sendXML = ' disabled="disabled" ';
            }
            $botonera='<div class="btn-group btn-group-sm " role="group" aria-label="..." id="btngrp'.($row[0]).'">
               <button type="button" class="btn btn-warning" '.$sendEdit.$btnedit.' id="btnedit'.($row[0]).'" > <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> </button>
               <button type="button" class="btn btn-success" '.$sendInvoice.$btnsend.' id="btnsend'.($row[0]).'"  > <span class="glyphicon glyphicon-send" aria-hidden="true"></span> </button>
               <button type="button" class="btn btn-info" '.$sendMail.$btnmail.' id="btnmail'.($row[0]).'"  > <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> </button>
               <a type="button" class="btn btn-primary" '.$btnxml.' role="button" '.$sendXML.' id="btnxml'.($row[0]).'" target="nxs_xml" download> <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> </a>
               <button type="button" class="btn btn-default" '.$btnprint.' title="Representación gráfica PDF"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </button>
            </div>
            <div class="progress" style="display: none; margin-top: 0px;" name="prgFE'.($row[0]).'" id="prgFE'.($row[0]).'"> <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%; height: 16px; margin-top: 0px;"> <span class="sr-only">Enviando Factura</span> </div></div>
            ';
            $html .= '<td align="center">'.$botonera.'</td>'; 

            $html .= '</tr>';
      }
      $html .= '</tbody>';

      echo $html;

	} else {
		echo '<span class="error">No se pudo acceder informacion de facturacion.</span>';
	}
	mysqli_free_result($result);
}

function listarDocumentoSoporte($filtro,$ini,$fin){
   $html="";	
  
  $SQL="SELECT factura, date, Razonsocial_DCD, Nombre_TER, sum(cantidad*valor)  FROM gxdocumentosoporte t1 
  INNER JOIN czterceros t2 ON t1.proveedor = t2.ID_TER 
  INNER JOIN itconfig t3 ON T1.cliente = SUBSTRING_INDEX(NIT_DCD, '-', 1) ";
   //$SQL .=  " where T1.codigo_fac= 'BQ-14414'  "; 
  /*
  if($filtro <> ''){
   $SQL .=  $filtro; 
  }*/
  $SQL .= " GROUP BY factura  ORDER BY date desc  limit $ini,$fin"; //  limit $ini,$fin
  //error_log($SQL);
  $conexion=conexion();
  $result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
      //echo $SQL;
      	$html = '
			<tr>
				<th>Documento Soporte</th>
				<th>Fecha</th>
				<th>Cliente</th>
				<th>Proveedor</th>
            <th>Valor</th>
				<th >Acciones</th>
			</tr>
			';
		$html .= '<tbody class="row items">';

      
      
      $result = mysqli_query($conexion, $SQL);//aqui lo vuelvo a ejecutar para que refrezcue el indice, se debe validar
      while($row = mysqli_fetch_array($result)){
            $html .= '<tr class="item">';
            $html .= '<td> '.($row[0]).'</td>';
            $html .= '<td> '.($row[1]).'</td>'; 
            $html .= '<td> '.($row[2]).'</td>';
            $html .= '<td> '.($row[3]).'</td>';
            $html .= '<td align="right"> $ '.number_format($row[4],0,',','.').'</td>';

            $string = str_replace(' ','',str_replace('-',' ',$row[0]));
            $Consecutivo = preg_replace('/[^0-9]/', '', $string);
            $cadena = explode($Consecutivo,$string);
            $Pref = $cadena[0];
             $btnedit='onclick="CargarForm(\'application/forms/editdocumentosoporte.php?documento='.$row[0].'\', \''.$row[0].'\', \''.$row[0].'\'); AddFavsForm(\''.$row[0].'\'); "'; 
            $btnsend='onclick="putSendFactura(\''.$row[0].'\'); "';
            $btnmail='onclick="estadoFacturaDoc(\''.$row[5].'\', \''.$row[0].'\'); "';
            $btnxml='onclick="descargaFactXml(\''.$row[0].'\'); "';
            $btnprint=' title="Vista previa Documento '.$row[0].'" data-toggle="modal" data-target="#GnmX_WinModal" onclick="rptDocSop(\''.$Consecutivo.'\')"';
            /*if($row[5] != '0'){
               $sendInvoice = ' disabled="disabled" title="Documento Enviado" ';
               $sendMail = ' ';
            }else{
               $sendInvoice = ' ';
               $sendMail = ' disabled="disabled" title="Mail Enviado" ';
            }*/
            $botonera='<div class="btn-group btn-group-sm " role="group" aria-label="..." id="btngrp'.($row[0]).'">
               <button type="button" class="btn btn-warning" '.$sendInvoice.$btnedit.' id="btnedit'.($row[0]).'" > <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> </button>';
               //<button type="button" class="btn btn-success" '.$sendInvoice.$btnsend.' id="btnsend'.($row[0]).'" > <span class="glyphicon glyphicon-send" aria-hidden="true"></span> </button>
               //<button type="button" class="btn btn-info" '.$sendMail.$btnmail.' id="btnmail'.($row[0]).'" > <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> </button>
               //<button type="button" class="btn btn-success" '.$btnxml.' id="btnmail'.($row[0]).'" > <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span> </button>
               $botonera.='<button type="button" class="btn btn-default" '.$btnprint.'> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </button>
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
		echo '<span class="error">No se pudo acceder informacion de Documentos soporte o no existe ninguno.</span>';
	}
	mysqli_free_result($result);
}

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
  //error_log($SQL);
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

      $SQL_m="Select Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='2' and a.Codigo_MOD='2' and c.Codigo_MNU='50' and Padre_ITM='489' AND Codigo_ITM = 431 order by Codigo_ITM;";
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
            $btnmail='onclick="estadoFacturaDoc(\''.$row[5].'\', \''.$row[0].'\'); "';
            //$btnxml='href="https://backend.estrateg.com/API/storage/app/public/900993679/FE-'.$row[0].'.xml" download="FE-'.$row[0].'.xml"';
	    $btnxml='onclick="descargarFacturaXml(\''.$row[5].'\', \''.$row[0].'\'); "';
            $btnprint=' title="Vista previa factura '.$row[0].'" data-toggle="modal" data-target="#GnmX_WinModal" onclick="rptInvoice(\''.$Pref.'\',\''.$Consecutivo.'\')"';
            if($row[5] != '0'){
               $sendInvoice = ' disabled="disabled" title="Factura Enviada" ';
               $sendEdit = ' disabled="disabled" title="Factura Enviada" ';
               $sendMail = ' title="Enviar factura por correo" ';
               $sendXML = ' title="Descargar XML" ';
            }else{
               $sendInvoice = ' title="Enviar factura a la DIAN" ';
               $sendEdit = ' title="Editar factura" ';
               $sendMail = ' disabled="disabled" ';
               $sendXML = ' disabled="disabled" ';
            }
            $botonera='<div class="btn-group btn-group-sm " role="group" aria-label="..." id="btngrp'.($row[0]).'">
               <button type="button" class="btn btn-warning" '.$sendEdit.$btnedit.' id="btnedit'.($row[0]).'" > <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> </button>
               <button type="button" class="btn btn-success" '.$sendInvoice.$btnsend.' id="btnsend'.($row[0]).'"  > <span class="glyphicon glyphicon-send" aria-hidden="true"></span> </button>
               <button type="button" class="btn btn-info" '.$sendMail.$btnmail.' id="btnmail'.($row[0]).'"  > <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> </button>
               <a type="button" class="btn btn-primary" '.$btnxml.' role="button" '.$sendXML.' id="btnxml'.($row[0]).'" target="nxs_xml" download> <span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span> </a>
               <button type="button" class="btn btn-default" '.$btnprint.' title="Representación gráfica PDF"> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </button>
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
   
  /*  if($ini == ''){
      $ini=0;
   }
   if($fin <> 20){
      $ini=$fin;
      $fin=20;
   } */

   $html="";	

  $SQL="SELECT * FROM gxfacturas t1   INNER JOIN gxadmision t2 ON t1.Codigo_ADM = t2.Codigo_ADM  INNER JOIN czterceros t3 ON t3.Codigo_TER = t2.Codigo_TER   INNER JOIN gxeps t4 ON t2.Codigo_EPS = t4.Codigo_EPS  INNER JOIN cznotascontablesenc t5 ON T1.Codigo_FAC = T5.NumeroDoc_NCT and t5.Naturaleza_NCT = 'C'";
   //$SQL .=  " where T1.codigo_fac= 'BQ-14414'  "; 
  
  if($filtro <> ''){
   $SQL .=  " where T5.Codigo_NCT = '$filtro' "; 
  }
  $SQL .= " and estado_fac = 1 ORDER BY fecha_fac desc limit $ini,$fin  ";

  //echo $SQL;
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

      $SQL_m="Select Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='2' and a.Codigo_MOD='2' and c.Codigo_MNU='50' and Padre_ITM='489' AND Codigo_ITM = 431 order by Codigo_ITM;";
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

            $cadnit = explode("-",verficarEmpresaReg());
            //$cadfac = explode("-",$row[1]);
            $cufe = ValidarCUfe($cadnit[0],'NC',$row['Codigo_NCT']);
            //print_r("cufe=".$cufe);exit();
            if($cufe  <> ''){

               $sql_update = "update cznotascontablesenc Set IdFE_FAC='".$cufe."' where Codigo_NCT='".$row['Codigo_NCT']."' and (IdFE_FAC IS NULL or IdFE_FAC = '1' or IdFE_FAC = '');";
               $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
               mysqli_query ($conexion, $sql_update);
               
               $sendInvoice = ' disabled="disabled" title="Nota Credito Enviada" ';
               $sendMail = ' ';
            }else{
               $sendInvoice = ' ';
               $sendMail = ' disabled="disabled" title="Mail Enviado" ';
            }

            /*
            $string = str_replace(' ','',str_replace('-',' ',$row['Codigo_NCT']));
            $Consecutivo = preg_replace('/[^0-9]/', '', $string);
            $cadena = explode($Consecutivo,$string);
            $Pref = $cadena[0];
            */
            $Consecutivo =$row['Codigo_NCT'];
            $Pref = 'NC';
            $btnedit='onclick="CargarForm(\'application/'.$row4[2].'?Ingreso='.$row[4].'\', \''.$row4[1].'\', \''.$row4[4].'\'); AddFavsForm(\''.$row4[0].'\'); "'; 
            $btnsend='onclick="putSendNC(\''.$row['Codigo_NCT'].'\'); "';
            $btnmail='onclick="estadoFacturaDoc(\''.$row[5].'\', \''.$row['Codigo_NCT'].'\'); "';
            $btnxml='onclick="descargaFactXml(\''.$row['Codigo_NCT'].'\'); "';
            $btnprint=' title="Vista previa NC '.$row['Codigo_NCT'].'" data-toggle="modal" data-target="#GnmX_WinModal" onclick="rptNC(\''.$Pref.'\',\''.$Consecutivo.'\')"';
            

            $botonera='<div class="btn-group btn-group-sm " role="group" aria-label="..." id="btngrp'.($row[0]).'">
            <button type="button" class="btn btn-warning" '.$sendInvoice.$btnedit.' id="btnedit'.($row[0]).'" > <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> </button>
            <button type="button" class="btn btn-success" '.$sendInvoice.$btnsend.' id="btnsend'.($row[0]).'" > <span class="glyphicon glyphicon-send" aria-hidden="true"></span> </button>
            <button type="button" class="btn btn-info" '.$sendMail.$btnmail.' id="btnmail'.($row[0]).'" > <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> </button>
            <button type="button" class="btn btn-success" '.$btnxml.' id="btnmail'.($row[0]).'" > <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span> </button>
            <button type="button" class="btn btn-default" '.$btnprint.'> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </button>
            </div>
            <div class="progress" style="display: none; margin-top: 0px;" name="prgFE'.($row[0]).'" id="prgFE'.($row[0]).'"> <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%; height: 16px; margin-top: 0px;"> <span class="sr-only">Enviando Factura</span> </div></div>
            ';
            $html .= '<td align="center">'.$botonera.'</td>'; 


            if($url == 'existe'){
               //$html .= '<td><i title="Nota Credito Enviada" class="fa fa-paper-plane"></i></td>';
            }else{
               //$html .= '<td> <a title="Enviar Nota Credito a la DIAN" href="#" class="enviarnotacreditodian" data="'.$row['Codigo_NCT'].'"><i class="fa fa-paper-plane"></i></a><div id="resultadoEnvioNC"></div> </td>';
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


function listarNotasDebito($filtro,$ini,$fin){
   
  /*  if($ini == ''){
      $ini=0;
   }
   if($fin <> 20){
      $ini=$fin;
      $fin=20;
   } */

   $html="";	

  $SQL="SELECT * FROM gxfacturas t1   INNER JOIN gxadmision t2 ON t1.Codigo_ADM = t2.Codigo_ADM  INNER JOIN czterceros t3 ON t3.Codigo_TER = t2.Codigo_TER   INNER JOIN gxeps t4 ON t2.Codigo_EPS = t4.Codigo_EPS  INNER JOIN cznotascontablesend t5 ON T1.Codigo_FAC = T5.NumeroDoc_NCT and t5.Naturaleza_NCT = 'D'";
   //$SQL .=  " where T1.codigo_fac= 'BQ-14414'  "; 
  
  if($filtro <> ''){
   $SQL .=  " where T5.Codigo_NCT = '$filtro' "; 
  }
  $SQL .= " and estado_fac = 1 ORDER BY fecha_fac desc limit $ini,$fin ";

 
  $conexion=conexion();
  $result = mysqli_query($conexion, $SQL);
	if($row = mysqli_fetch_array($result)) {
      //echo $SQL;
      	$html = '<tr>
            <th>Notas Debito</th>
            <th>Fecha ND</th>
				<th>Factura</th>
				<th>Fecha</th>
				<th>Paciente / Cliente</th>
				<th>Entidad</th>
				<th colspan="2">Estados</th>
			</tr>';
		$html .= '<tbody class="row items">';

      $SQL_m="Select Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='2' and a.Codigo_MOD='2' and c.Codigo_MNU='50' and Padre_ITM='489' AND Codigo_ITM = 431 order by Codigo_ITM;";
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

            $cadnit = explode("-",verficarEmpresaReg());
            //$cadfac = explode("-",$row[1]);
            $cufe = ValidarCUfe($cadnit[0],'ND',$row['Codigo_NCT']);

            If($cufe  <> ''){

               $sql_update = "update cznotascontablesend Set IdFE_FAC='".$cufe."' where Codigo_NCT='".$row['Codigo_NCT']."' and (IdFE_FAC IS NULL or IdFE_FAC = '1' or IdFE_FAC = '');";
               $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
               mysqli_query ($conexion, $sql_update);
               
               $sendInvoice = ' disabled="disabled" title="Nota Debito Enviada" ';
               $sendMail = ' ';
            }else{
               $sendInvoice = ' ';
               $sendMail = ' disabled="disabled" title="Mail Enviado" ';
            }




            $Consecutivo =$row['Codigo_NCT'];
            $Pref = 'ND';
            $btnedit='onclick="CargarForm(\'application/'.$row4[2].'?Ingreso='.$row[4].'\', \''.$row4[1].'\', \''.$row4[4].'\'); AddFavsForm(\''.$row4[0].'\'); "'; 
            $btnsend='onclick="putSendND(\''.$row['Codigo_NCT'].'\'); "';
            $btnmail='onclick="estadoFacturaDoc(\''.$row[5].'\', \''.$row['Codigo_NCT'].'\'); "';
            $btnxml='onclick="descargaFactXml(\''.$row['Codigo_NCT'].'\'); "';
            $btnprint=' title="Vista previa ND'.$row['Codigo_NCT'].'" data-toggle="modal" data-target="#GnmX_WinModal" onclick="rptND(\''.$Pref.'\',\''.$Consecutivo.'\')"';
            

            $botonera='<div class="btn-group btn-group-sm " role="group" aria-label="..." id="btngrp'.($row[0]).'">
            <button type="button" class="btn btn-warning" '.$sendInvoice.$btnedit.' id="btnedit'.($row[0]).'" > <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> </button>
            <button type="button" class="btn btn-success" '.$sendInvoice.$btnsend.' id="btnsend'.($row[0]).'" > <span class="glyphicon glyphicon-send" aria-hidden="true"></span> </button>
            <button type="button" class="btn btn-info" '.$sendMail.$btnmail.' id="btnmail'.($row[0]).'" > <span class="glyphicon glyphicon-envelope" aria-hidden="true"></span> </button>
            <button type="button" class="btn btn-success" '.$btnxml.' id="btnmail'.($row[0]).'" > <span class="glyphicon glyphicon-qrcode" aria-hidden="true"></span> </button>
            <button type="button" class="btn btn-default" '.$btnprint.'> <span class="glyphicon glyphicon-print" aria-hidden="true"></span> </button>
            </div>
            <div class="progress" style="display: none; margin-top: 0px;" name="prgFE'.($row[0]).'" id="prgFE'.($row[0]).'"> <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 99%; height: 16px; margin-top: 0px;"> <span class="sr-only">Enviando Factura</span> </div></div>
            ';
            $html .= '<td align="center">'.$botonera.'</td>'; 


            if($url == 'existe'){
               //$html .= '<td><i title="Nota Debito Enviada" class="fa fa-paper-plane"></i></td>';
            }else{
               //$html .= '<td> <a title="Enviar Nota Debito a la DIAN" href="#" class="enviarnotadebitodian" data="'.$row['Codigo_NCT'].'"><i class="fa fa-paper-plane"></i></a><div id="resultadoEnvioND"></div> </td>';
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

      $SQL_m="Select Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='2' and a.Codigo_MOD='2' and c.Codigo_MNU='50' and Padre_ITM='0' AND Codigo_ITM = 459 order by Codigo_ITM;";
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

      $SQL_m="Select Codigo_ITM, Nombre_ITM, Enlace_ITM, Nombre_MNU, Icono_ITM from ".$_SESSION['DB_NXS'].".ititems as a, ".$_SESSION['DB_NXS'].".itmenu as c where c.Codigo_MNU=a.Codigo_MNU and Activo_ITM='1' and a.Codigo_APP='2' and a.Codigo_MOD='2' and c.Codigo_MNU='50' and Padre_ITM='0' AND Codigo_ITM = 459 order by Codigo_ITM;";
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
   $conexion = mysqli_connect("backend.estrateg.com", "makoto", "M@koto23*", "Billing", "3306");
   mysqli_query ($conexion, "SET NAMES 'utf8'");
   $cadena = explode("-",$nit);
   $sql = ra)
                alert('https://backend.estrateg.com/API/storage/app/public/'.$nit.'/'.$factura.'ad'.$ad_xml.'.xml');
                
              }
            }
          },
          error: function() { 
            showProgress("0", factura)
            console.log(data);
          }
        });        
   } 
?>
