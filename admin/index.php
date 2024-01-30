<?php 
session_start();
if($_POST){
  if(($_POST["usuario"]=="admin")&&($_POST ["contraseña"]=="admin")){
    $_SESSION["usuario"]="ok";
    $_SESSION["contraseña"]="ok";
    $_SESSION["nombreUsuario"]="Fátima";
    header('Location:inicio.php');
  }else{
  $mensaje="Error: El usuario ingresado es incorrecto";
}

}
?>


<!doctype html>
<html lang="en">

<head>
  <title>Administrador</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>

<body>
 
<div class="container">
    <div class="row">
      <div class="col-md-4" ></div>
        <div class="col-md-4">
          <br><br><br>
            <div class="card">
                <div class="card-header">
                    Login
                </div>
                <div class="card-body">
                  <?php if(isset($mensaje)){ ?>
                    <div class="alert alert-danger" role="alert" >
                    <?php echo $mensaje; ?>
                    </div>
                  <?php } ?>


                  <form method="post" >
                    <div class = "form-group">
                      <label>Usuario</label>
                      <input type="text" name="usuario" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingrese su usuario">
                      
                    </div>
                    <div class="form-group">
                      <label>Contraseña</label>
                      <input type="password" name="contraseña" class="form-control" id="exampleInputPassword1" placeholder="Contraseña">
                      <small id="emailHelp" class="form-text text-muted">We'll never share your password with anyone else.</small>
                    </div>
                    <div class="form-check">
                      <input type="checkbox" class="form-check-input" id="exampleCheck1">
                      <label class="form-check-label" for="exampleCheck1">Check me out</label>
                    </div>
                    <button type="submit" class="btn btn-primary">Ingresar</button>
                  </form>
                
                



             
                    
                </div>
            </div>
        </div>
       
        
    </div>
</div>






  <!-- Bootstrap JavaScript Libraries -->
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
    integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
  </script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
    integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
  </script>
</body>

</html>