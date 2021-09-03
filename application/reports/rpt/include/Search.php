<?php
session_start();
include '../../../../functions/php/nexus/database.php';   
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
    mysqli_query ($conexion, "SET NAMES 'utf8'");

/* require_once(dirname(__FILE__)."/DBConnection.php?nxsdb=".$_GET["nxsdb"]); */
class Search
{
    protected $db;
    public function __construct() {
        $this->db = new DBConnection();
        $this->db = $this->db->returnConnection();
    }

    // get Blog Info function
    public function getBlogInfo() {
        $query = $this->db->prepare("SELECT name, last_name, email, contact_no, address, salary FROM personal");
        $query->execute();

        $result = $query->fetchAll();
        return $result;
    }
}