<?php
	

session_start();
	$NumWindow=$_GET["target"];
	// include '../../themes/'.$_SESSION["THEME_DEFAULT"].'/template.php';	
	include '../../functions/php/nexus/database.php';	
	$conexion = mysqli_connect($_SESSION["DB_HOST"], $_SESSION["DB_USER"], $_SESSION["DB_PASSWORD"], $_SESSION["DB_NAME"], $_SESSION["DB_PORT"]);
	mysqli_query ($conexion, "SET NAMES 'utf8'");	
	$contarow=0;
?>
<form action="" method="post" name="frm_form<?php echo $NumWindow; ?>" class="form-horizontal col-md-12" id="frm_form<?php echo $NumWindow; ?>"  enctype="multipart/form-data" onreset="KlResetea<?php echo $NumWindow; ?>();">
	<label class="label label-info"> <span class="glyphicon glyphicon-transfer" aria-hidden="true"></span> CÁLCULO</label>
	  		<div class="row well well-sm">
	  		<div class="col-md-12">
	  		<div class="row">

		<div class="col-md-2">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="cmb_plan<?php echo $NumWindow; ?>">Plan</label>
		  <select name="cmb_plan<?php echo $NumWindow; ?>" id="cmb_plan<?php echo $NumWindow; ?>" onchange="selecplan<?php echo $NumWindow; ?>();">
		    <option value="0" >-- Seleccione --</option>
		  <?php
		  $SQL="Select Codigo_PLA, Nombre_PLA From klplanes Order By Codigo_PLA";
			$result = mysqli_query($conexion, $SQL);
			while ($row = mysqli_fetch_array($result)) {
			?>
		    <option value="<?php echo $row[0]; ?>" ><?php echo $row[1]; ?></option>
		  	<?php
			 }
			mysqli_free_result($result);
			?>
		  </select>
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_fnac<?php echo $NumWindow; ?>">F. Nacimiento</label>
		<input  name="txt_fnac<?php echo $NumWindow; ?>" id="txt_fnac<?php echo $NumWindow; ?>" type="text" required  class="datepicker0<?php echo $NumWindow; ?>"/>
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc<?php echo $NumWindow; ?>">
		<label for="txt_edad<?php echo $NumWindow; ?>">Edad</label>
			<input name="txt_edad<?php echo $NumWindow; ?>" id="txt_edad<?php echo $NumWindow; ?>" type="text" disabled />
	</div>

		</div>
		<div class="col-md-2">
	
	<div class="form-group" id="grp_txt_hora<?php echo $NumWindow; ?>">
		<label for="cmb_modalidad<?php echo $NumWindow; ?>">Modalidad</label>
		  <select name="cmb_modalidad<?php echo $NumWindow; ?>" id="cmb_modalidad<?php echo $NumWindow; ?>">
		  <?php 
		  	if (isset($_GET["Plan"])) {
		  		$SQL="Select Sum(Individual_PLA), Sum(Pareja_PLA), Sum(Hijos_PLA) from klplanesprecios where Codigo_PLA='".$_GET["Plan"]."'";
		  		$resultm = mysqli_query($conexion, $SQL);
				while ($rowm = mysqli_fetch_array($resultm)) {
					if($rowm[0]!="0"){
				?>
			    <option value="Individual_PLA" >Individual</option>
			  	<?php
			  		}
			  		if($rowm[1]!="0"){
				?>
			    <option value="Pareja_PLA" >Pareja</option>
			  	<?php
			  		}
			  		if($rowm[2]!="0"){
				?>
			    <option value="Hijos_PLA" >Familia</option>
			  	<?php
			  		}
				}
				mysqli_free_result($resultm);
		  	} else {
		  ?>
		    <option value="X" >-- Seleccione Plan --</option>
		  <?php
		    }
		  ?>
		  </select>
	</div>

		</div>
		<div class="col-md-2">
	
	<div class="form-group">
		<label for="cmb_destino<?php echo $NumWindow; ?>">Destino</label>
		  <select name="cmb_modalidad<?php echo $NumWindow; ?>" id="cmb_modalidad<?php echo $NumWindow; ?>">
		  <?php 
		  	if (isset($_GET["Plan"])) {
		  		$SQL="Select a.Codigo_dst, Nombre_dst from klplanesdestinos a, kldestinos b where a.Codigo_DST=b.Codigo_dst and Codigo_PLA='".$_GET["Plan"]."' and Estado_dst='1' Order by 2";
		  		$resultd = mysqli_query($conexion, $SQL);
				while ($rowd = mysqli_fetch_array($resultd)) {
					echo '<option value="'.$rowd[0].'" >'.$rowd[1].'</option>
					';
				}
				mysqli_free_result($resultd);
		    } else {
		  ?>
		    <option value="X" >-- Seleccione Plan --</option>
		  <?php
		    }
		  ?>
		  </select>
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc1<?php echo $NumWindow; ?>">
		<label for="txt_fini<?php echo $NumWindow; ?>">Fecha Inicial</label>
		<input  name="txt_fini<?php echo $NumWindow; ?>" id="txt_fini<?php echo $NumWindow; ?>" type="text" required class="datepicker1<?php echo $NumWindow; ?>"/>
	</div>

		</div>
		<div class="col-md-1">

	<div class="form-group" id="grp_txt_idhc2<?php echo $NumWindow; ?>">
		<label for="txt_ffin<?php echo $NumWindow; ?>">Fecha Final</label>
		<input  name="txt_ffin<?php echo $NumWindow; ?>" id="txt_ffin<?php echo $NumWindow; ?>" type="text" required class="datepicker2<?php echo $NumWindow; ?>" onchange="CalcularDias<?php echo $NumWindow; ?>();"/>
	</div>

		</div>
		<div class="col-md-1">
			<div class="form-group" id="grp_txt_idhc0<?php echo $NumWindow; ?>">
				<label for="txt_dias<?php echo $NumWindow; ?>">Días</label>
				<input style="font-size:15px;" name="txt_dias<?php echo $NumWindow; ?>" id="txt_dias<?php echo $NumWindow; ?>" type="text" disabled="disabled"/>
			</div>
		</div>
		<div class="col-md-1">
			<div class="form-group" id="grp_txt_idhcx<?php echo $NumWindow; ?>">
				<label for="btn_calc<?php echo $NumWindow; ?>">Calcular</label>
				<button type="button" class="btn btn-primary btn-block" onclick="Calcular<?php echo $NumWindow; ?>()"> <span class="glyphicon glyphicon-play" aria-hidden="true"></span> </button>
			</div>
		</div>

		</div>
		<div class="row well well-sm" id="calc<?php echo $NumWindow; ?>" name="calc<?php echo $NumWindow; ?>">

		<div class="col-md-1">
			<div class="form-group" id="grp_txt_idhcx<?php echo $NumWindow; ?>">
				<label for="txt_trm<?php echo $NumWindow; ?>">T.R.M.</label>
				<?php
		  	$SQL="Select Valor_TRM From cztrm Where Moneda_TRM='US' Order By Fecha_TRM desc Limit 1";
			$resultx = mysqli_query($conexion, $SQL);
			while ($rowx = mysqli_fetch_array($resultx)) {
				$trm_val=$rowx[0];
			}
			mysqli_free_result($resultx);
			?>
				<input style="font-size:15px;" name="txt_trm<?php echo $NumWindow; ?>" id="txt_trm<?php echo $NumWindow; ?>" type="text" value="<?php echo $trm_val; ?>" onchange="CalcTRM<?php echo $NumWindow; ?>();"/>
			</div>
		</div>
		<div class="col-md-5">
			<div class="form-group" id="grp_txt_idhcx<?php echo $NumWindow; ?>">
				<label for="txt_dolares<?php echo $NumWindow; ?>">Dolares</label>
				<input style="font-size:15px; text-align:right;font-weight: bold;" name="txt_dolares<?php echo $NumWindow; ?>" id="txt_dolares<?php echo $NumWindow; ?>" type="text" disabled="disabled" value="0.00"/>
			</div>
		</div>
		<div class="col-md-6">
			<div class="form-group" id="grp_txt_idhcx<?php echo $NumWindow; ?>">
				<label for="txt_pesos<?php echo $NumWindow; ?>">Pesos</label>
				<div class="input-group">
					<input style="font-size:15px; text-align:right;font-weight: bold;" name="txt_pesos<?php echo $NumWindow; ?>" id="txt_pesos<?php echo $NumWindow; ?>" type="text" disabled="disabled" value="0.00"/>
					<span class="input-group-btn">
			          <button class="btn btn-primary" type="button"><span class="glyphicon glyphicon-send" aria-hidden="true"></span> Cotizar </button>
			        </span>
		        </div>
			</div>
		</div>

		</div> 
		</div>
 		</div>


</form>

<script >

document.getElementById('calc<?php echo $NumWindow; ?>').style.visibility = 'hidden';

<?php 
if(isset($_GET["Plan"])) {
	echo '
	document.getElementById("cmb_plan'.$NumWindow.'").value="'.$_GET["Plan"].'";
	document.getElementById("txt_fnac'.$NumWindow.'").value="'.$_GET["FecNac"].'";
	document.getElementById("txt_fini'.$NumWindow.'").value="'.$_GET["FecIni"].'";
	document.getElementById("txt_ffin'.$NumWindow.'").value="'.$_GET["FecFin"].'";
	if (document.getElementById("txt_ffin'.$NumWindow.'").value!="") {
		CalcularDias'.$NumWindow.'();
	}
	';
} else {
	echo '
	FechaActual("txt_fini'.$NumWindow.'");
	';
}
?>
function CalcularDias<?php echo $NumWindow; ?>() {
	FecINI=document.getElementById('txt_fini<?php echo $NumWindow; ?>').value;
	FecFIN=document.getElementById('txt_ffin<?php echo $NumWindow; ?>').value;
	if(FecINI=="") {
		MsgBoxErr("Error", "Fecha inicial no puede estar en blanco");
		return false;
	}
	if(FecFIN=="") {
		MsgBoxErr("Error", "Fecha final no puede estar en blanco");
		return false;
	}
	var values1=FecINI.split("/");
	FecINIx=values1[2].concat('-',values1[1],'-',values1[0]);
	var values2=FecFIN.split("/");
	FecFINx=values2[2].concat('-',values2[1],'-',values2[0]);
	if (FecINIx>=FecFINx) {
		MsgBoxErr("Error", "Fechas de viaje no concuerdan");
		return false;
	}
	var fechaInicio = new Date(FecINIx).getTime();
	var fechaFin    = new Date(FecFINx).getTime();
	var diff = fechaFin - fechaInicio;
	diasx=(diff/(1000*60*60*24) );
	if (diasx<=0) {
		MsgBoxErr("Error", "Fecha de inicio no puede ser mayor a fecha final");
		return false;
	} else {
		document.getElementById('txt_dias<?php echo $NumWindow; ?>').value=diasx;
		return true;
	}

}

function Calcular<?php echo $NumWindow; ?>() {
	document.getElementById('calc<?php echo $NumWindow; ?>').style.visibility = 'hidden';
	//PRIMERO LA SELECCION DEL PLAN
	if(document.getElementById('cmb_plan<?php echo $NumWindow; ?>').value=="0") {
		MsgBoxErr("Atención", "No ha selecciondo el plan");
		return false;
	}
	//CALCULAMOS EDAD
	document.getElementById('txt_edad<?php echo $NumWindow; ?>').value="";
	if(document.getElementById("txt_fnac<?php echo $NumWindow; ?>").value=="") {
		MsgBoxErr("Error de cáculo", "No ha introducido una fecha de nacimiento válida");
	}
	var fecha=document.getElementById("txt_fnac<?php echo $NumWindow; ?>").value;
 	if(validate_fecha<?php echo $NumWindow; ?>(fecha)==true)
    {
 	    // Si la fecha es correcta, calculamos la edad
        var values=fecha.split("/");
        var dia = values[0];
        var mes = values[1];
        var ano = values[2];
        // cogemos los valores actuales
        var fecha_hoy = new Date();
        var ahora_ano = fecha_hoy.getYear();
        var ahora_mes = fecha_hoy.getMonth();
        var ahora_dia = fecha_hoy.getDate();
        // realizamos el calculo
        var edad = (ahora_ano + 1900) - ano;
        if ( ahora_mes < (mes - 1)) {
            edad--;
        }
        if (((mes - 1) == ahora_mes) && (ahora_dia < dia)) {
            edad--;
        }
        if (edad > 1900) {
            edad -= 1900;
        }
 		document.getElementById('txt_edad<?php echo $NumWindow; ?>').value=edad;
    } else {
    	MsgBoxErr("Error de cáculo", "La fecha de nacimiento introducida no es válida");
    	return false;
    }
    if (CalcularDias<?php echo $NumWindow; ?>()==false) {
    	MsgBoxErr("Error de fechas", "Por favor verifique las fechas seleccionadas");
    	return false;
    }

	document.getElementById('calc<?php echo $NumWindow; ?>').style.visibility = 'visible';
}

function isValidDate<?php echo $NumWindow; ?>(day,month,year)
{
    var dteDate;
 	month=month-1;
    dteDate=new Date(year,month,day);
 	return ((day==dteDate.getDate()) && (month==dteDate.getMonth()) && (year==dteDate.getFullYear()));
}

function validate_fecha<?php echo $NumWindow; ?>(fecha)
{
	values0=fecha.split("/");
	fecha0=values0[2].concat('-', values0[1], '-',values0[0]);
	var patron=new RegExp("^(19|20)+([0-9]{2})([-])([0-9]{1,2})([-])([0-9]{1,2})$");

    if(fecha0.search(patron)==0)
    {
    	var values=fecha0.split("-");
        if(isValidDate<?php echo $NumWindow; ?>(values[2],values[1],values[0]))
        {
            return true;
        }
    }
    return false;
}

function CalcTRM<?php echo $NumWindow; ?>() {
	dolares=document.getElementById('txt_dolares<?php echo $NumWindow; ?>').value;
	trm=document.getElementById('txt_trm<?php echo $NumWindow; ?>').value;
	pesos=dolares*trm;
   	document.getElementById('txt_pesos<?php echo $NumWindow; ?>').value=pesos;
}

function selecplan<?php echo $NumWindow; ?>() {
	if(document.getElementById('cmb_plan<?php echo $NumWindow; ?>').value!="0") {
		AbrirForm('application/forms/cotizaciones.php', '<?php echo $NumWindow; ?>', '&Plan='+document.getElementById('cmb_plan<?php echo $NumWindow; ?>').value+'&FecNac='+document.getElementById('txt_fnac<?php echo $NumWindow; ?>').value+'&FecIni='+document.getElementById('txt_fini<?php echo $NumWindow; ?>').value+'&FecFin='+document.getElementById('txt_ffin<?php echo $NumWindow; ?>').value);
	}
}

function KlResetea<?php echo $NumWindow; ?>() {
	AbrirForm('application/forms/cotizaciones.php', '<?php echo $NumWindow; ?>', '');	
}
	
	$('.datepicker0<?php echo $NumWindow; ?>').datetimepicker({ locale: 'es', format: 'DD/MM/YYYY' });
	$('.datepicker1<?php echo $NumWindow; ?>').datetimepicker({ locale: 'es', format: 'DD/MM/YYYY' });
    $('.datepicker2<?php echo $NumWindow; ?>').datetimepicker({
    	locale: 'es',
    	format: 'DD/MM/YYYY',
        useCurrent: false //Important! See issue #1075
    });
    $(".datepicker0<?php echo $NumWindow; ?>").on("dp.change", function (e) {
        EdadOnBlur<?php echo $NumWindow; ?>();
    });
    $(".datepicker1<?php echo $NumWindow; ?>").on("dp.change", function (e) {
        $('.datepicker2<?php echo $NumWindow; ?>').data("DateTimePicker").minDate(e.date);
    });
    $(".datepicker2<?php echo $NumWindow; ?>").on("dp.change", function (e) {
        $('.datepicker1<?php echo $NumWindow; ?>').data("DateTimePicker").maxDate(e.date);
    });


    $("input[type=text]").addClass("form-control");
    $("input[type=password]").addClass("form-control");
	$("textarea").addClass("form-control");
	$("select").addClass("form-control");

    $("input[type=text]").addClass("hc_<?php echo $NumWindow; ?>");
    $("input[type=password]").addClass("hc_<?php echo $NumWindow; ?>");
	$("textarea").addClass("hc_<?php echo $NumWindow; ?>");
	$("select").addClass("hc_<?php echo $NumWindow; ?>");
</script>
