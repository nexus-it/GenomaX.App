<?php
// Todo esto solo es para que cambie el video de fondo vada vez que alguien se loguee...
    $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
    $SQL="Select Codigo_LGN, Nombre_LGN from nxs_videologin where Codigo_LGN in (select case when a.Codigo_LGN=max(b.Codigo_LGN) then '1' else (a.Codigo_LGN+1) end from nxs_videologin a, nxs_videologin b where a.Actual_LGN='1');";
    $resultX = mysqli_query($conexion, $SQL);
    $nxslgn="bcklogin01.webm";
    if($rowX = mysqli_fetch_array($resultX)) {
        $SQL="Update nxs_videologin set Actual_LGN='0'";
        mysqli_query($conexion, $SQL);
        $nxslgn=$rowX[1];
        $SQL="Update nxs_videologin set Actual_LGN='1' where Codigo_LGN=".$rowX[0];
        mysqli_query($conexion, $SQL);
    }
?>
<video id="mivideo" autoplay="autoplay" playsinline autoplay muted loop>
  <!-- <source src="themes/<?php echo $_SESSION["THEME_DEFAULT"]; ?>/videologin/<?php echo $nxslgn; ?>" type="video/webm"></source> -->
  <source src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/video/<?php echo $nxslgn; ?>" type="video/webm"></source>
</video>
<script> document.getElementById('mivideo').play(); </script>
<div class="container">
    <div class="row login_box">
        <div class="overlay"></div>
        <div class="col-md-12 col-xs-12" align="center">
            <div class="line"><h3><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/title_genomax.png"  alt="GenomaX" title="GenomaX"/> </h3> </div>
            <div class="outter"><img src="<?php echo $_SESSION["NEXUS_CDN"]; ?>/image/login_genomax.png" class="image-circle"/></div>   
            <h1>Inicio de Sesión</h1>
            <span id="razonsocial"></span>
        </div>
        <div class="col-md-12 col-xs-12 <?php if (isset($_GET["action"])) { echo 'messagesx'; } ?> line" align="center" >
            <h5>
        <?php 
        if (isset($_GET["action"])) { 
            if ($_GET["action"]=="1") {
                $msg_login="Usuario no válido.";
            } else {
                $msg_login="Contraseña Incorrecta"; 
            }
            echo '<strong>Error:</strong> '.$msg_login.' <span class="glyphicon glyphicon-warning-sign" aria-hidden="hiden"></span> ';
        } else {
            echo '';
        }
        ?>
            </h5>
        </div>
        <div class="col-md-12 col-xs-12 login_control">
            <form action="functions/php/nexus/validar.php?nxsdb=<?php echo $_GET["nxsdb"]; ?>" method="post" id="frm_login" >     
                <div class="control">
                    <div class="label">Usuario</div>
                    <input name="txt_loginuser" type="text" id="txt_loginuser"  placeholder="" class="form-control" />
                </div>
                
                <div class="control">
                     <div class="label">Contraseña</div>
                    <input name="txt_loginpass" type="password"  id="txt_loginpass" value="" placeholder=""  class="form-control" />
                </div>
                <div align="center">
                     <button class="btn btn-access" type="submit" onclick="encrypt();">Ingresar <span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
                </div>
            </form>
        </div>
    <input name="hdn_browsername" type="hidden" id="hdn_browsername"  />
    <input name="hdn_browserversion" type="hidden" id="hdn_browserversion"  />
    <input name="hdn_plataforma" type="hidden" id="hdn_plataforma"  />
            
    </div>
</div>