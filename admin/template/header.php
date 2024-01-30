<?php 
session_start();
    if(isset($_SESSION["usuario"])){
        header("Location:../index.php");
    }else{
        if($_SESSION["usuario"]=="ok"){
            $nombreUsuario= $_SESSION["nombreUsuario"];
        }
    }
?>

<header>
    <?php $url="http://".$_SERVER['HTTP_HOST']."/sitioweb"; 
    ?>
    <!-- place navbar here -->
   <nav class="navbar navbar-expand navbar-light bg-light">
       <ul class="nav navbar-nav">
           <li class="nav-item">
               <a class="nav-link active" href="#" aria-current="page">Administrador<span class="visually-hidden">(current)</span></a>
           </li>
           <li class="nav-item">
               <a class="nav-link" href="<?php echo $url;?>/admin//">Inicio</a>
           </li>
           <li class="nav-item">
               <a class="nav-link" href="<?php echo $url;?>/admin/seccion/productos.php">Libros</a>
           </li>
           <li class="nav-item">
               <a class="nav-link" href="<?php echo $url;?>/admin/seccion/cerrarSesion.php";?>Cerrar sesion</a>
           </li>
           <li class="nav-item">
               <a class="nav-link" href="<?php echo $url;?>">Ver sitio web</a>
           </li>
           
       </ul>
   </nav>
  </header>