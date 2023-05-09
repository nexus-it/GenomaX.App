<?php
session_start(); 
  // include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
  include '../../functions/php/nexus/database.php';
  include '../../functions/php/nexus/operaciones.php';
  $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
  mysqli_query ($conexion, "SET NAMES 'utf8'");	

class Invoice{
	
    private $host  = '127.0.0.1';
    private $user  = 'gnx';
    private $password   = "Clave12345*";
    private $database  = "php_factura_shaima";   
	

	private $invoiceUserTable = 'factura_usuarios';	
    private $invoiceOrderTable = 'factura_orden';
	private $ncOrderTable = 'nc_orden';
	private $ndOrderTable = 'nd_orden';
	private $productTable = 'factura_producto';
	private $customerTable = 'factura_clientes';
	private $invoiceOrderItemTable = 'factura_orden_producto';
	private $ncOrderItemTable = 'nc_orden_producto';
	private $ndOrderItemTable = 'nd_orden_producto';
	private $invoiceConfigTable = 'itconfig';
	
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            //$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
			$conn = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error($sqlQuery));
		}
		$data= array();
		while ($row = mysqli_fetch_assoc($result)) {
			$data[]=$row;            
		}
		return $data;
	}
	private function getNumRows($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			die('Error in query: '. mysqli_error($sqlQuery));
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}
	public function loginUsers($email, $password){
		$sqlQuery = "
			SELECT id, email, first_name, last_name, address, mobile 
			FROM ".$this->invoiceUserTable." 
			WHERE email='".$email."' AND password='".$password."'";
        return  $this->getData($sqlQuery);
	}	
	public function checkLoggedIn(){
		if(!$_SESSION['userid']) {
			header("Location:index.php");
		}
	}		
	public function saveInvoice($POST) {	
		$cadena = explode("--", $POST['companyName']);	
		$sqlInsert = "
			INSERT INTO ".$this->invoiceOrderTable."(order_prefix, order_resolution, user_id, order_receiver_nit, order_receiver_name, order_receiver_address, order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax, order_amount_paid, order_total_amount_due, note) 
			VALUES ('BQ', '18764026394833', '".$POST['userId']."', '".$cadena[0]."' ,'".$POST['companyName']."', '".$POST['address']."', '".$POST['subTotal']."', '".$POST['taxAmount']."', '".$POST['taxRate']."', '".$POST['totalAftertax']."', '".$POST['amountPaid']."', '".$POST['amountDue']."', '".$POST['notes']."')";		
			mysqli_query($this->dbConnect, $sqlInsert);
			echo $sqlInsert;
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		for ($i = 0; $i < count($POST['productCode']); $i++) {
			$sqlInsertItem = "
			INSERT INTO ".$this->invoiceOrderItemTable."(order_prefix, order_resolution ,order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_iva, order_item_desc, order_item_final_amount) 
			VALUES ('BQ', '18764026394833', '".$lastInsertId."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['iva'][$i]."', '".$POST['desc'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
			//echo $sqlInsertItem;
		}       	
	}
	
	
	public function saveNc($POST) {	
		$cadena = explode("--", $POST['companyName']);	
		$sqlInsert = "
			INSERT INTO ".$this->ncOrderTable."(order_prefix, order_resolution, user_id, order_receiver_nit, order_receiver_name, order_receiver_address, order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax, order_amount_paid, order_total_amount_due, note,payment_forms,payment_methods,	factura_acreditar) 
			VALUES ('NC', '".$POST['resolucion']."', '".$POST['userId']."', '".$cadena[0]."' ,'".$POST['companyName']."', '".$POST['address']."', '".$POST['subTotal']."', '".$POST['taxAmount']."', '".$POST['taxRate']."', '".$POST['totalAftertax']."', '".$POST['amountPaid']."', '".$POST['amountDue']."', '".$POST['notes']."', '".$POST['payment_forms']."', '".$POST['payment_methods']."', '".$POST['facturasId']."')";		
			mysqli_query($this->dbConnect, $sqlInsert);
			echo $sqlInsert;
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		for ($i = 0; $i < count($POST['productCode']); $i++) {
			$sqlInsertItem = "
			INSERT INTO ".$this->ncOrderItemTable."(order_prefix, order_resolution ,order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_iva, order_item_desc, order_item_final_amount) 
			VALUES ('NC', '".$POST['resolucion']."', '".$lastInsertId."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['iva'][$i]."', '".$POST['desc'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
			//echo $sqlInsertItem;
		}       	
	}
	
	public function saveNd($POST) {	
		$cadena = explode("--", $POST['companyName']);	
		$sqlInsert = "
			INSERT INTO ".$this->ndOrderTable."(order_prefix, order_resolution, user_id, order_receiver_nit, order_receiver_name, order_receiver_address, order_total_before_tax, order_total_tax, order_tax_per, order_total_after_tax, order_amount_paid, order_total_amount_due, note,payment_forms,payment_methods,	factura_debitar) 
			VALUES ('ND', '".$POST['resolucion']."', '".$POST['userId']."', '".$cadena[0]."' ,'".$POST['companyName']."', '".$POST['address']."', '".$POST['subTotal']."', '".$POST['taxAmount']."', '".$POST['taxRate']."', '".$POST['totalAftertax']."', '".$POST['amountPaid']."', '".$POST['amountDue']."', '".$POST['notes']."', '".$POST['payment_forms']."', '".$POST['payment_methods']."', '".$POST['facturasId']."')";		
			mysqli_query($this->dbConnect, $sqlInsert);
			//echo $sqlInsert;exit();
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		for ($i = 0; $i < count($POST['productCode']); $i++) {
			$sqlInsertItem = "
			INSERT INTO ".$this->ndOrderItemTable."(order_prefix, order_resolution ,order_id, item_code, item_name, order_item_quantity, order_item_price, order_item_iva, order_item_desc, order_item_final_amount) 
			VALUES ('ND', '".$POST['resolucion']."', '".$lastInsertId."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['iva'][$i]."', '".$POST['desc'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);
			//echo $sqlInsertItem;
		}       	
	}


	public function saveProduct($GET) {
		$referencia = $_GET['referencia'];
		$nombre = $_GET['nombre'];
		$sql = "insert into factura_producto (referencia,nombre) values (?,?) ";
		//echo $sql;
		if($stmt= mysqli_prepare($this->dbConnect, $sql)){
			mysqli_stmt_bind_param($stmt,"ss",$referencia,$nombre);
			if(mysqli_stmt_execute($stmt)){
				$stmt->close();
				$lastInsertId = mysqli_insert_id($this->dbConnect);
				return $lastInsertId;
			}else{
				return false;
			}
		}
	}

	public function saveCustomer($GET) {
		$identification_number = $_GET['identification_number'];
		$dv = $_GET['dv'];
		$name = $_GET['name'];
		$phone = $_GET['phone'];
		$address = $_GET['address'];
		$email = $_GET['email'];
		$sql = "insert into ".$this->customerTable." (identification_number,dv,name,phone,address,email) values (?,?,?,?,?,?) ";
		//echo $sql;
		if($stmt= mysqli_prepare($this->dbConnect, $sql)){
			mysqli_stmt_bind_param($stmt,"iissss",$identification_number,$dv,$name,$phone,$address,$email);
			if(mysqli_stmt_execute($stmt)){
				$stmt->close();
				return $identification_number;
			}else{
				return false;
			}
		}
	}
	
	public function updateInvoice($POST) {
		if($POST['invoiceId']) {
			$cad = explode("-",$POST['invoiceId']);
			$prefix = $cad[0];
			$number = $cad[1];
			$sqlInsert = "
				UPDATE ".$this->invoiceOrderTable." 
				SET order_receiver_name = '".$POST['companyName']."', order_receiver_address= '".$POST['address']."', order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['taxAmount']."', order_tax_per = '".$POST['taxRate']."', order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$POST['amountPaid']."', order_total_amount_due = '".$POST['amountDue']."', note = '".$POST['notes']."' 
				WHERE user_id = '".$POST['userId']."' AND order_id = '".$number."' AND order_prefix = '".$prefix."' ";		
			mysqli_query($this->dbConnect, $sqlInsert);	
			//echo $sqlInsert;
		}		
		$this->deleteInvoiceItems($POST['invoiceId']);
		for ($i = 0; $i < count($POST['productCode']); $i++) {			
			$sqlInsertItem = "
				INSERT INTO ".$this->invoiceOrderItemTable."(order_id, order_prefix , item_code, item_name, order_item_quantity, order_item_price, order_item_iva, order_item_desc, order_item_final_amount) 
				VALUES ('".$number."', '".$prefix."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['iva'][$i]."', '".$POST['desc'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);	
			echo $sqlInsertItem;		
		}       	
	}	


	public function updateNc($POST) {
		if($POST['invoiceId']) {
			$cad = explode("-",$POST['invoiceId']);
			$prefix = $cad[0];
			$number = $cad[1];
			$sqlInsert = "
				UPDATE ".$this->ncOrderTable." 
				SET order_receiver_name = '".$POST['companyName']."', order_receiver_address= '".$POST['address']."', order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['taxAmount']."', order_tax_per = '".$POST['taxRate']."', order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$POST['amountPaid']."', order_total_amount_due = '".$POST['amountDue']."', note = '".$POST['notes']."', factura_acreditar = '".$POST['facturasId']."'  
				WHERE user_id = '".$POST['userId']."' AND order_id = '".$number."' AND order_prefix = '".$prefix."' ";		
			mysqli_query($this->dbConnect, $sqlInsert);	
			//echo $sqlInsert;
		}		
		$this->deleteNcItems($POST['invoiceId']);
		for ($i = 0; $i < count($POST['productCode']); $i++) {			
			$sqlInsertItem = "
				INSERT INTO ".$this->ncOrderItemTable."(order_id, order_prefix , item_code, item_name, order_item_quantity, order_item_price, order_item_iva, order_item_desc, order_item_final_amount) 
				VALUES ('".$number."', '".$prefix."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['iva'][$i]."', '".$POST['desc'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);	
			echo $sqlInsertItem;		
		}       	
	}
	
	public function updateNd($POST) {
		if($POST['invoiceId']) {
			$cad = explode("-",$POST['invoiceId']);
			$prefix = $cad[0];
			$number = $cad[1];
			$sqlInsert = "
				UPDATE ".$this->ndOrderTable." 
				SET order_receiver_name = '".$POST['companyName']."', order_receiver_address= '".$POST['address']."', order_total_before_tax = '".$POST['subTotal']."', order_total_tax = '".$POST['taxAmount']."', order_tax_per = '".$POST['taxRate']."', order_total_after_tax = '".$POST['totalAftertax']."', order_amount_paid = '".$POST['amountPaid']."', order_total_amount_due = '".$POST['amountDue']."', note = '".$POST['notes']."', factura_debitar = '".$POST['facturasId']."'  
				WHERE user_id = '".$POST['userId']."' AND order_id = '".$number."' AND order_prefix = '".$prefix."' ";		
			mysqli_query($this->dbConnect, $sqlInsert);	
			//echo $sqlInsert;
		}		
		$this->deleteNdItems($POST['invoiceId']);
		for ($i = 0; $i < count($POST['productCode']); $i++) {			
			$sqlInsertItem = "
				INSERT INTO ".$this->ndOrderItemTable."(order_id, order_prefix , item_code, item_name, order_item_quantity, order_item_price, order_item_iva, order_item_desc, order_item_final_amount) 
				VALUES ('".$number."', '".$prefix."', '".$POST['productCode'][$i]."', '".$POST['productName'][$i]."', '".$POST['quantity'][$i]."', '".$POST['price'][$i]."', '".$POST['iva'][$i]."', '".$POST['desc'][$i]."', '".$POST['total'][$i]."')";			
			mysqli_query($this->dbConnect, $sqlInsertItem);	
			echo $sqlInsertItem;		
		}       	
	}


	public function updateProduct($POST){
		$id =$_POST["id"];
		$referencia = $_POST['referencia'];
		$nombre = $_POST['nombre'];
		$sql = "update factura_producto set referencia = '$referencia',nombre = '$nombre' where id = $id ";
		mysqli_query($this->dbConnect, $sql);
		return $id;
	}

	public function getInvoiceList(){
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE user_id = '".$_SESSION["NOMBRE_APP"]."' order by order_date desc";
		return  $this->getData($sqlQuery);
	}
	public function getNcList(){
		$sqlQuery = "
			SELECT * FROM ".$this->ncOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."' order by order_date desc";
		return  $this->getData($sqlQuery);
	}
	public function getNdList(){
		$sqlQuery = "
			SELECT * FROM ".$this->ndOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."' order by order_date desc";
		return  $this->getData($sqlQuery);
	}	
	public function getProductList(){
		$sqlQuery = "
			SELECT * FROM ".$this->productTable;
		return  $this->getData($sqlQuery);
	}
	public function getCustomerList(){
		$sqlQuery = "
			SELECT * FROM ".$this->customerTable;
		return  $this->getData($sqlQuery);
	}
	public function getInvoice($invoiceId){

		$string = $invoiceId;
		
		$number = preg_replace('/[^0-9]/', '', $string);
		$cadena = explode($number,$string);
		$prefix = $cadena[0];
		
		/*
		$cad = explode("-",$invoiceId);
		$prefix = $cad[0];
		$number = $cad[1];
		*/

		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."' AND order_prefix = '$prefix' AND order_id = '$number'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_assoc($result);
		return $row;
	}

	public function getNc($invoiceId){

		$string = $invoiceId;
		
		$number = preg_replace('/[^0-9]/', '', $string);
		$cadena = explode($number,$string);
		$prefix = $cadena[0];
		
		/*
		$cad = explode("-",$invoiceId);
		$prefix = $cad[0];
		$number = $cad[1];
		*/

		$sqlQuery = "
			SELECT * FROM ".$this->ncOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."' AND order_prefix = '$prefix' AND order_id = '$number'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_assoc($result);
		return $row;
	}
	
	public function getNd($invoiceId){

		$string = $invoiceId;
		
		$number = preg_replace('/[^0-9]/', '', $string);
		$cadena = explode($number,$string);
		$prefix = $cadena[0];
		
		/*
		$cad = explode("-",$invoiceId);
		$prefix = $cad[0];
		$number = $cad[1];
		*/

		$sqlQuery = "
			SELECT * FROM ".$this->ndOrderTable." 
			WHERE user_id = '".$_SESSION['userid']."' AND order_prefix = '$prefix' AND order_id = '$number'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_assoc($result);
		return $row;
	}
	
	public function getInvoiceItems($invoiceId){

		$string = $invoiceId;
		
		$number = preg_replace('/[^0-9]/', '', $string);
		$cadena = explode($number,$string);
		$prefix = $cadena[0];

		/*
		$cad = explode("-",$invoiceId);
		$prefix = $cad[0];
		$number = $cad[1];
		*/
		$sqlQuery = "
			SELECT * FROM ".$this->invoiceOrderItemTable." 
			WHERE order_prefix = '$prefix' AND order_id = '$number'";
		return  $this->getData($sqlQuery);	
	}

	public function getNcItems($invoiceId){

		$string = $invoiceId;
		
		$number = preg_replace('/[^0-9]/', '', $string);
		$cadena = explode($number,$string);
		$prefix = $cadena[0];

		/*
		$cad = explode("-",$invoiceId);
		$prefix = $cad[0];
		$number = $cad[1];
		*/
		$sqlQuery = "
			SELECT * FROM ".$this->ncOrderItemTable." 
			WHERE order_prefix = '$prefix' AND order_id = '$number'";
		return  $this->getData($sqlQuery);	
	}
	
	public function getNdItems($invoiceId){

		$string = $invoiceId;
		
		$number = preg_replace('/[^0-9]/', '', $string);
		$cadena = explode($number,$string);
		$prefix = $cadena[0];

		/*
		$cad = explode("-",$invoiceId);
		$prefix = $cad[0];
		$number = $cad[1];
		*/
		$sqlQuery = "
			SELECT * FROM ".$this->ndOrderItemTable." 
			WHERE order_prefix = '$prefix' AND order_id = '$number'";
		return  $this->getData($sqlQuery);	
	}

	public function deleteInvoiceItems($invoiceId){
		$cad = explode("-",$invoiceId);
		$prefix = $cad[0];
		$number = $cad[1];
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderItemTable." 
			WHERE order_id = '".$number."' and order_prefix = '".$prefix."'" ;
		mysqli_query($this->dbConnect, $sqlQuery);				
	}

	public function deleteNcItems($invoiceId){
		$cad = explode("-",$invoiceId);
		$prefix = $cad[0];
		$number = $cad[1];
		$sqlQuery = "
			DELETE FROM ".$this->ncOrderItemTable." 
			WHERE order_id = '".$number."' and order_prefix = '".$prefix."'" ;
		mysqli_query($this->dbConnect, $sqlQuery);				
	}
	
	public function deleteNdItems($invoiceId){
		$cad = explode("-",$invoiceId);
		$prefix = $cad[0];
		$number = $cad[1];
		$sqlQuery = "
			DELETE FROM ".$this->ndOrderItemTable." 
			WHERE order_id = '".$number."' and order_prefix = '".$prefix."'" ;
		mysqli_query($this->dbConnect, $sqlQuery);				
	}

	public function deleteInvoice($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->invoiceOrderTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$this->deleteInvoiceItems($invoiceId);	
		return 1;
	}


	public function deleteNc($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->ncOrderTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$this->deletencItems($invoiceId);	
		return 1;
	}
	
	public function deleteNd($invoiceId){
		$sqlQuery = "
			DELETE FROM ".$this->ndOrderTable." 
			WHERE order_id = '".$invoiceId."'";
		mysqli_query($this->dbConnect, $sqlQuery);	
		$this->deletendItems($invoiceId);	
		return 1;
	}	

	public function deleteProduct($productId){
		$sqlQuery = "
			DELETE FROM ".$this->productTable." 
			WHERE order_id = '".$productId."'";
		mysqli_query($this->dbConnect, $sqlQuery);		
		return 1;
	}

	function verficarEmpresaReg(){
		$sqlQuery="Select  NIT_DCD from  ".$this->invoiceConfigTable;
		mysqli_query($this->dbConnect, $sqlQuery);
		$result = mysqli_query($this->dbConnect, $sqlQuery);	
		$row = mysqli_fetch_assoc($result);
		return $row;
	  }


	function validarRegistroEmpRes($nit){
	$conexion = mysqli_connect("backend.estrateg.com", "makoto", "M@koto23*", "Billing", "3306");
		mysqli_query ($conexion, "SET NAMES 'utf8'");
	$cadena = explode("-",$nit);
	$sql = "SELECT * FROM `Billing`.`companies` t1, resolutions t2, type_documents t3 where t1.id = t2.company_id and t2.type_document_id = t3.id and identification_number = ".$cadena[0];
	$result = mysqli_query($conexion, $sql);
		echo "<table class='table'><thead><tr>";
		echo "<td>Resolucion No</td>";
		echo "<td>Tipo</td>";
		echo "<td>Prefijo</td>";
		echo "<td>Fecha Resol</td>";
		echo "<td>Llave Tecnica</td>";
		echo "<td>Desde</td>";
		echo "<td>Hasta</td>";
		echo "</tr></thead>";
	while($datosRes = mysqli_fetch_array($result)){
		echo "<tbody><tr>";
		echo "<td>".$datosRes['resolution']."</td>";
		echo "<td>".$datosRes['name']."</td>";
		echo "<td>".$datosRes['prefix']."</td>";
		echo "<td>".$datosRes['resolution_date']."</td>";
		echo "<td>".$datosRes['technical_key']."</td>";
		echo "<td>".$datosRes['from']."</td>";
		echo "<td>".$datosRes['to']."</td>";
		echo "</tr><tbody>";
	}
	echo "</table>";
	
	}  
}
?>