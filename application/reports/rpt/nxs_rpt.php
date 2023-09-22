<?php
session_start();
include '../../../functions/php/nexus/database.php';   
$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
    mysqli_query ($conexion, "SET NAMES 'utf8'");
$TheRpt="";
if (isset($_GET["nxsrpt"]))
{
    $TheRpt=$_GET["nxsrpt"];
    $SQL="Select Descripcion_RPT, Subtitle_RPT, SQL_RPT from ".$_SESSION['DB_NXS'].".itreports where trim(codigo_rpt)=trim('".$_GET["nxsrpt"]."');";
$resulttb = mysqli_query($conexion, $SQL);
if($rowtb = mysqli_fetch_array($resulttb)) {
    $rpt_titulo=$rowtb[0];
    $rpt_sql=$rowtb[2];
    $rpt_subtitulo=$rowtb[1];
}
mysqli_free_result($resulttb);
$rpt_cols=substr($rpt_sql, 0, stripos($rpt_sql, "where"))." WHERE 1=0 LIMIT 1";
$SQL2="Select Campo_RPT From ".$_SESSION['DB_NXS'].".itreportsparam Where Codigo_RPT='".$_GET["nxsrpt"]."'";
$result2 = mysqli_query($conexion, $SQL2);
while($row2 = mysqli_fetch_row($result2)) {
    $rpt_subtitulo=str_replace("@".$row2[0],$_GET[$row2[0]],$rpt_subtitulo);
    $rpt_cols=str_replace("@".$row2[0],$_GET[$row2[0]],$rpt_cols);
}
mysqli_free_result($result2);    
//error_log($rpt_cols);
include('templates/header.php');
?>

 <section >
    <div class="container">
        <div class="row padall">
            <div class="col-lg-12" style="padding-bottom:10px; padding-top:10px;">
                <h4><?php echo $rpt_titulo; ?></h4>
                <h5><?php echo $rpt_subtitulo; ?></h5>              
            </div>
        </div>
            <div class="row padall border-bottom">
                <div class="col-lg-12">
                <div class="table-responsive-sm">
                    <table id="render-data" class="table tblDetalle display nowrap" style="width:100%">
                        <thead>
                            <tr>
                               <?php
                               
                                $resulttb1 = mysqli_query($conexion, $rpt_cols);
                                $colstb = mysqli_fetch_fields($resulttb1);
                                foreach($colstb as $namecol) {
                                    echo '<th>'.$namecol->name.'</th>';
                                }
                                mysqli_free_result(resulttb1);
                                ?>
                            </tr>
                        </thead>
                        <tbody>
                            
                        </tbody>
                        <tfoot>
                            <tr>
                                <?php
                                $resulttb1 = mysqli_query($conexion, $rpt_cols);
                                $colstb = mysqli_fetch_fields($resulttb1);
                                foreach($colstb as $namecol) {
                                    echo '<th>'.$namecol->name.'</th>';
                                }
                                mysqli_free_result(resulttb1);
                                ?>
                            </tr>
                        </tfoot>
                    </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
}
include('templates/footer.php');
?>