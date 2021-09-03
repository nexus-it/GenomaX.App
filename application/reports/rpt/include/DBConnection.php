<?php
include "constants.php?nxsdb=".$_GET["nxsdb"];
// Parametros de conexion
class DBConnection {
    protected $host = DB_HOST;
    protected $dbname = DB_NAME;
    protected $user = DB_USER;
    protected $pass = DB_PASSWORD;
    protected $_db;

    function __construct() {

        try {

            $this->_db = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
        }
        catch (PDOException $e) {

            echo $e->getMessage();
        }
    }

    // Conexión de retorno
    function returnConnection() {
		return $this->_db;
	}

	// Cerramos la conexion
    public function closeConnection() {
        $this->_db = null;
    }
}

