<?php
	session_start();
	$NumWindow=$_GET["target"];
	include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	


    $cadena = explode("-",verficarEmpresaReg());
	$cliente = $cadena[0];
	$proveedor = $_POST['txt_paciente'];
    $nombre = $_POST['nombre'];
	$date = $_POST['txt_fechaadm'];
    $descripcion = $_POST['descripcion'];
    $cantidad = $_POST['cantidad'];
	$valorunitario = $_POST['valorunitario'];
	$cadret = explode("-",$_POST['retencion']);
	$retencion = $cadret[0];
	$por_ret = $cadret[1];

	$usuario = $_SESSION["it_CodigoUSR"];
	//$date = date('Y-m-d');

	if($descripcion <> ''){
        $query = "INSERT INTO gxdocumentosoporte (producto, cantidad, valor, date, Codigo_USR, cliente, proveedor, retencion, por_ret) VALUES ('$descripcion', '$cantidad', '$valorunitario', '$date', '$usuario' , '$cliente', '$proveedor', '$retencion', '$por_ret')";
		$data['mensaje'] = '200';
	}else{
		$query = "select MAX(factura) as consecutivo from gxdocumentosoporte ";
		$result = mysqli_query($conexion, $query);
		$row = mysqli_fetch_array($result);
		$consecutivo = $row['consecutivo']+1;
		$query = "UPDATE gxdocumentosoporte SET factura = $consecutivo where Codigo_USR = '$usuario' and  cliente = '$cliente' and  proveedor =  '$proveedor' and factura IS NULL ";
		$data['mensaje'] = $consecutivo;
		$query = "select Consecutivo_CNS as consecutivo from itconsecutivos where Tabla_CNS='czcxp' and Campo_CNS='Codigo_CXP' ";
		$result = mysqli_query($conexion, $query);
		$row = mysqli_fetch_array($result);
		$consec = $row['consecutivo']+1;
		$SQL="Insert into czcxp(Codigo_CXP, Codigo_TER, Consec_FAC, Fecha_FAC, Vence_FAC, Referencia_CXP, Valor_FAC, Pagado_CXP, Saldo_CXP) Select '".$consec."', Codigo_TER, '".$consecutivo."', '".$date."', '".$date."', 'Documento Soporte '.$descripcion, '".$valorunitario*$cantidad."', '0', '".$valorunitario*$cantidad."' From czterceros Where ID_TER='".$proveedor."'";
		mysqli_query($conexion, $SQL);
	}
    $result = mysqli_query($conexion, $query);
    
	if($result){

		$html = '<div id="zero_detalle<?php echo $NumWindow; ?>" class="detalleord table-responsive" >';
		$html .= '<table width="99%" border="0" align="center" cellpadding="1" cellspacing="2" bgcolor="#EFEFEF" class="table table-striped table-condensed tblDetalle">
					<thead>
						<tr>
							<th>
							PRODUCTO
							</th>
							<th>
							CANTIDAD
							</th>
							<th>
							VALOR UNITARIO
							</th>
							<th>
							TOTAL
							</th>
						</tr>
					</thead>';

		$query = "select * from gxdocumentosoporte where factura IS NULL";
		$result = mysqli_query($conexion, $query);
					

		$html .= '<tbody>';

		while($row = mysqli_fetch_array($result)){
		$html .= 	'<tr>';
		$html .= 		'<td>';
		$html .= 		 $row['producto'];
		$html .= 		'</td>';
		
		$html .= 		'<td>';
		$html .= 		 $row['cantidad'];
		$html .= 		'</td>';
		
		$html .= 		'<td>';
		$html .= 		 $row['valor'];
		$html .= 		'</td>';
		
		$html .= 		'<td>';
		$html .= 		 number_format($row['cantidad']*$row['valor'],2);
		$html .= 		'</td>';

		$html .= 	'</tr>';
		}
		$html .= '</tbody>';

		$html .= '</table>';
		$html .= '</div>';

		$data['tabla'] = $html;
		//$data['mensaje'] = '200';
		echo json_encode($data);
		//echo '200';
	}else{
		$data['tabla'] = $query;
		$data['mensaje'] = '500';
		echo json_encode($data);
		//echo '500';
	}

?>
