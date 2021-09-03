<?php

include '00trnsctns.php';

	$target_charset = "utf8";
$target_collate = "utf8_general_ci";
$SQL="show index from ".$_POST['tabla']."";
$result = mysqli_query($conexion, $SQL);
$indicies = array();
while (($row = mysqli_fetch_array($result)) != null) {
		if ($row[2] != "PRIMARY") {
				$indicies[] = array("name" => $row[2], "unique" => !($row[1] == "1"), "col" => $row[4]);
				$SQL="ALTER TABLE ".$_POST['tabla']." DROP INDEX {$row[2]}";
				EjecutarSQL($SQL, $conexion);
		}
}
$SQL="DESCRIBE ".$_POST['tabla']."";
$result = mysqli_query($conexion, $SQL);
while (($row = mysqli_fetch_array($result)) != null) {
		$name = $row[0];
		$type = $row[1];
		$set = false;
		if (preg_match("/^varchar\((\d+)\)$/i", $type, $mat)) {
				$size = $mat[1];
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} VARBINARY({$size})";
				EjecutarSQL($SQL, $conexion);
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} VARCHAR({$size}) CHARACTER SET {$target_charset}";
				EjecutarSQL($SQL, $conexion);
				$set = true;
		}
		else if (!strcasecmp($type, "CHAR")) {
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} BINARY(1)";
				EjecutarSQL($SQL, $conexion);
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} VARCHAR(1) CHARACTER SET {$target_charset}";
				EjecutarSQL($SQL, $conexion);
				$set = true;
		}
		else if (!strcasecmp($type, "TINYTEXT")) {
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} TINYBLOB";
				EjecutarSQL($SQL, $conexion);
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} TINYTEXT CHARACTER SET {$target_charset}";
				EjecutarSQL($SQL, $conexion);
				$set = true;
		}
		else if (!strcasecmp($type, "MEDIUMTEXT")) {
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} MEDIUMBLOB";
				EjecutarSQL($SQL, $conexion);
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} MEDIUMTEXT CHARACTER SET {$target_charset}";
				EjecutarSQL($SQL, $conexion);
				$set = true;
		}
		else if (!strcasecmp($type, "LONGTEXT")) {
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} LONGBLOB";
				EjecutarSQL($SQL, $conexion);
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} LONGTEXT CHARACTER SET {$target_charset}";
				EjecutarSQL($SQL, $conexion);
				$set = true;
		}
		else if (!strcasecmp($type, "TEXT")) {
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} BLOB";
				EjecutarSQL($SQL, $conexion);
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} TEXT CHARACTER SET {$target_charset}";
				EjecutarSQL($SQL, $conexion);
				$set = true;
		}

		if ($set) {
				$SQL="ALTER TABLE ".$_POST['tabla']." MODIFY {$name} COLLATE {$target_collate}";
				EjecutarSQL($SQL, $conexion);
		}
}

// re-build indicies..
foreach ($indicies as $index) {
		if ($index["unique"]) {
				mysqli_query("CREATE UNIQUE INDEX {$index["name"]} ON ".$_POST['tabla']." ({$index["col"]})");
				EjecutarSQL($SQL, $conexion);
		}
		else {
				mysqli_query("CREATE INDEX {$index["name"]} ON ".$_POST['tabla']." ({$index["col"]})");
				EjecutarSQL($SQL, $conexion);
		}
}

// set default collate
$SQL="ALTER TABLE ".$_POST['tabla']." DEFAULT CHARACTER SET {$target_charset} COLLATE {$target_collate}";
EjecutarSQL($SQL, $conexion);

	it_aud('1', 'MyTurnos', 'Codigo No. '.$Consec);

include '99trnsctns.php';

?>