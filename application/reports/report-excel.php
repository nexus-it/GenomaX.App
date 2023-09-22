<?php
header('Content-type:application/xls');
header('Content-Disposition: attachment; filename='.$_GET["rpt"].'.xls');
session_start();

include '../../functions/php/nexus/database.php';

$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);

mysqli_query ($conexion, "SET NAMES 'utf8'");
$SQL="SELECT sql_rpt, page_rpt, orientacion_rpt, Descripcion_RPT, IfNULL(Subtitle_RPT,' ') from ".$_SESSION['DB_NXS'].".itreports where codigo_rpt='".$_GET["rpt"]."'";
$result = mysqli_query($conexion, $SQL);
if ($row = mysqli_fetch_row($result)) {
	$SQL=$row[0];
	$FormatoPagina=$row[1];
	$Orientation=$row[2];
	$NombreReporte=$row[3];
	$Subtitulo=$row[4];
	$numero = count($_GET);
	$tags = array_keys($_GET);
	$valores = array_values($_GET);
	for($i=0;$i<$numero;$i++){
		if ($tags[$i]!="rpt") {
			if (substr($tags[$i],0,7)=="USUARIO") {
				$SQL=str_replace("@USUARIO",$_SESSION["it_CodigoUSR"],$SQL);
			} else {
                $SQL=str_replace("@".$tags[$i],$_GET[$tags[$i]],$SQL);
                $Subtitulo=str_replace("@".$tags[$i],$_GET[$tags[$i]],$Subtitulo);

			}
		}
	}
}
mysqli_free_result($result);
?>
<table border="1">
<tr>
<?php
$NumFields=0;
    if ($resultado = mysqli_query($conexion, $SQL)) {
        $info_campo = mysqli_fetch_fields($resultado);
        foreach ($info_campo as $valor) {
            $NumFields++;
?>
    <th><?php echo $valor->name; ?></th>
<?php
        }
    }
    mysqli_free_result($resultado);
?>
</tr>

<?php
    $result = mysqli_query($conexion, $SQL);
    while ($row = mysqli_fetch_row($result)) {
        $iField=0;
        echo '<tr>';
        while($iField<$NumFields){
?>
    <td><?php echo $row[$iField]; ?></td>
<?php
            $iField++;
        }
        echo '</tr>';
    }
    mysqli_free_result($result);
?>
 
</table>