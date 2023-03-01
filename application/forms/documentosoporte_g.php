<?php
	session_start();
	//$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
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

	$factura = $_POST['factura'];

	$usuario = $_SESSION["it_CodigoUSR"];
	//$date = date('Y-m-d');



	if($descripcion <> ''){
        $query = "INSERT INTO gxdocumentosoporte (producto, cantidad, valor, date, Codigo_USR, cliente, proveedor, retencion, por_ret) VALUES ('$descripcion', '$cantidad', '$valorunitario', '$date', '$usuario' , '$cliente', '$proveedor', '$retencion', '$por_ret')";
		$data['mensaje'] = '200';

		

	}else{
		if($factura == ''){

			$queryDS = "select Prefijo_AFC from czautfacturacion where descripcion_afc like 'DS%' ";
			$resultDS = mysqli_query($conexion, $queryDS);
			$rowDS = mysqli_fetch_array($resultDS);
			$prefijoDS = $rowDS['Prefijo_AFC'];

			$query = "select MAX(factura) as consecutivo from gxdocumentosoporte ";
			$result = mysqli_query($conexion, $query);
			$row = mysqli_fetch_array($result);
			$consecutivo = $row['consecutivo']+1;
			$query = "UPDATE gxdocumentosoporte SET factura = $consecutivo, Codigo_FAC = '".$prefijoDS.$consecutivo."' where Codigo_USR = '$usuario' and  cliente = '$cliente' and  proveedor =  '$proveedor' and factura IS NULL ";
			//echo $query;
			$data['mensaje'] = $consecutivo;
		}else{
			$query = "select * from gxdocumentosoporte where factura = ".$factura;
			$result = mysqli_query($conexion, $query_fact);
			
			
		
		}
	}
    $result = mysqli_query($conexion, $query);
    
	if($result){

		if($factura <> ''){

			$queryDS = "select * from czautfacturacion where descripcion_afc like 'DS%' ";
			$resultDS = mysqli_query($conexion, $queryDS);
			$rowDS = mysqli_fetch_array($resultDS);
			$prefijoDS = $rowDS['Prefijo_AFC'];



			$query_fact = "UPDATE gxdocumentosoporte SET factura = $factura, Codigo_FAC = '".$prefijoDS.$consecutivo."'  where Codigo_USR = '$usuario' and  cliente = '$cliente' and  proveedor =  '$proveedor' and factura IS NULL";
			$result_fact = mysqli_query($conexion, $query_fact);
		
		}
		

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
							<th>
							ACCION
							</th>
						</tr>
					</thead>';

		if($factura == ''){			
			$query = "select * from gxdocumentosoporte where factura IS NULL";
		}else{
			$query = "select * from gxdocumentosoporte where factura = ".$factura;
		}
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

		$html .= '<td>';
		$html .= '<button type="button" name="btnEliminar" id="btnEliminar" onClick="javascript:Eliminar('.$row['id'].','.$factura.')">Eliminar</button>';
		$html .= '</td>';

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
		$data['mensaje'] = '500'.$query;
		echo json_encode($data);
		//echo '500';
	}

	
    

?>
