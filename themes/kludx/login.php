<div class="">
    <?php 
    if (isset($_GET["action"])) { 
        if ($_GET["action"]=="1") {
            $msg_login="Usuario no válido.";
        } else {
            $msg_login="Contraseña Incorrecta"; 
        }
        echo '<div class="messages line" align="center" style="height: 30px;">
        <h5>
        <strong>Error:</strong> '.$msg_login.' <span class="glyphicon glyphicon-warning-sign" aria-hidden="hiden"></span>
        </h5>
    </div>';
    } else {
        echo '';
    }
    
    // Todo esto solo es para que cambie el video de fondo vada vez que alguien se loguee...
    $conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"]);
    $SQL="Select Codigo_LGN, Nombre_LGN from nxs_videologin where Codigo_LGN in (select case when a.Codigo_LGN=max(b.Codigo_LGN) then '1' else (a.Codigo_LGN+1) end from nxs_videologin a, nxs_videologin b where a.Actual_LGN='1');";
    $resultX = mysqli_query($conexion, $SQL);
    $nxslgn="klud01.webm";
    if($rowX = mysqli_fetch_array($resultX)) {
        $SQL="Update nxs_videologin set Actual_LGN='0'";
        mysqli_query($conexion, $SQL);
        $nxslgn=$rowX[1];
        $SQL="Update nxs_videologin set Actual_LGN='1' where Codigo_LGN=".$rowX[0];
        mysqli_query($conexion, $SQL);
    }
?>
    <section class="login_box">
        <div class="login_control">
            <div class="kludtitle" align="center">
                <div class="line"><img src="http://cdn.genomax.co/media/image/logoklud_32mini.png" alt="<?php echo $_SESSION["NOMBRE_APP"]; ?>"> Kl'ud </div>
            
            </div>
            <form action="functions/php/nexus/validar.php?nxsdb=<?php echo $_GET["nxsdb"]; ?>" method="post" id="frm_login" >     
                <div class="control">
                    <div class="label">Usuario</div>
                    <input name="txt_loginuser" type="text" id="txt_loginuser"  placeholder="" class="form-control" />
                </div>
                
                <div class="control">
                     <div class="label">Contraseña</div>
                    <input name="txt_loginpass" type="password"  id="txt_loginpass" value="" placeholder=""  class="form-control" />
                </div>
                <div align="right">
                     <button class="btn btn-access" type="submit" onclick="encrypt();" id="btngo" name="btngo">Ingresar <span class="glyphicon glyphicon-play" aria-hidden="true"></span></button>
                </div>
            </form>
        </div>
    </section>
    <section class="video_title">
    <video id="klvideo" autoplay="autoplay" playsinline autoplay muted loop>
    <!-- <source src="themes/ghenx/videologin/bcklogin10.webm" type="video/webm"></source> -->
        <source src="http://cdn.genomax.co/media/video/<?php echo $nxslgn; ?>" type="video/webm"></source>
    </video>
    <div class="kludvideo">
        <div class="contenedor">
			<p>Brindamos</p>
			<ul>
                <li>respaldo</li>
                <li>cubrimiento</li>
				<li>tranquilidad</li>
				<li>seguridad</li>
			</ul>
		</div>
        
    <input name="hdn_browsername" type="hidden" id="hdn_browsername"  />
    <input name="hdn_browserversion" type="hidden" id="hdn_browserversion"  />
    <input name="hdn_plataforma" type="hidden" id="hdn_plataforma"  />
        
            
    </div>
    <script> document.getElementById('klvideo').play(); </script>
    </section>

    
</div>