<?php

/* $SQL="COMMIT;";
mysqli_query($conexion, $SQL);
*/
mysqli_commit($conexion);
mysqli_autocommit($conexion,TRUE);
mysqli_close($conexion);
if (session_status() != PHP_SESSION_ACTIVE) {
	$MSG="Su sessión ha expirado!";
}
echo $MSG;

?>