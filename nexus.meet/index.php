<?php
if (isset($_GET["channel"])) {
	header("Location: https://meet.jit.si/".$_GET["channel"]);
} else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NEXUS.Meet Video Conferencias Seguras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous"> 
    <link href="https://fonts.googleapis.com/css2?family=Alex+Brush&display=swap" rel="stylesheet">
</head>

<style>
    .jumbotron {
        padding: 12rem 2rem;
        
    }
    .container {
        width: 100%;
        padding-right: 15px;
        padding-left: 15px;
        margin-right: auto;
        margin-left: auto;
        margin-bottom: 20px;
    }
    #meet {
    	font-family: 'Alex Brush', cursive;
    }
</style>

    <body class=" jumbotron text-center ">
  
        <section >
            <div class="container">
                <h2 class="" style="color:#1BAA55";><b>NEXUS<spam id="meet">.Meet</spam></b></h2>
                <h5 class="" style="color:#1BAA55";><b> Video Conferencias Seguras</b></h5>
            </div>
        
             <form action="" method="_GET">
                <div class="container ">
                           <div class="form-group ">
                                    <label for="Ind_sesion" name='Ind_sesion'>Por favor indique el Nombre de la Sesión del Videochat</label>
                                    <div class="input-group justify-content-md-center ">
                                        <span class="input-group col-md-5 ">
                                        <input type="text" class="form-control" name="channel" id="channel">
                                        <button value="Nsesion" class="btn btn-success"><svg class="bi bi-reply-all-fill" width="1em" height="1em" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M8.079 11.9l4.568-3.281a.719.719 0 000-1.238L8.079 4.1A.716.716 0 007 4.719V6c-1.5 0-6 0-7 8 2.5-4.5 7-4 7-4v1.281c0 .56.606.898 1.079.62z"/>
                                            <path fill-rule="evenodd" d="M10.868 4.293a.5.5 0 01.7-.106l3.993 2.94a1.147 1.147 0 010 1.946l-3.994 2.94a.5.5 0 01-.593-.805l4.012-2.954a.493.493 0 01.042-.028.147.147 0 000-.252.496.496 0 01-.042-.028l-4.012-2.954a.5.5 0 01-.106-.699z" clip-rule="evenodd"/>
                                          </svg></button>
                                        </span>
                                    </div>
                           </div>
                </div>
             </form>  
        </section>
    
        <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    </body>
</html>
<?php
}

?>