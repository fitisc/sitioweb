<?php 
include_once '../template/header.php' ?>
<?php 

//con el post llamo a la info que entra en cada input del form
$txtID=(isset($_POST['txtID']))?$_POST['txtID']:"";//debe ser el mismo valor que name
$txtNombre=(isset($_POST['txtNombre']))?$_POST['txtNombre']:"";
$txtImagen=(isset($_FILES['txtImagen']['name']))?$_FILES['txtImagen']['name']:"";
$accion=(isset($_POST['accion'])) ? $_POST['accion']: "";

include_once '../config/bd.php';
//si yo quiero mostrar la informacion: esto se agrega a la tabla de datos con un echo $libros...etc..
$sentenciaSQL = $conexion -> prepare("SELECT * FROM libros"); //pongo la intrucc sql para seleccionar todos los libros
// ejecuto la instrucción anterior
$sentenciaSQL->execute();
//para almacenar la informacion y luego llamarla... tengo que igualar la sentencia sql qu se ejecuto anteriormente a traves de una var nueva que tiene un fetch (junta los registros para mostrar los datod dfe la tabla)  con pdo fetchassoc que 
//esta var nueva va a tener todos los registros para mostrar los dat
$listaLibros = $sentenciaSQL ->fetchAll(PDO::FETCH_ASSOC);

switch($accion){//crear base de datos y tablas e inserta aqui
    case "Agregar":
       
        //INSERT INTO `libros` (`idlibro`, `nombre`, `imagen`) VALUES (NULL, 'libro php', 'imagen.jpg');
        $sentenciaSQL= $conexion->prepare("INSERT INTO `libros` ( `nombre`, `imagen`) VALUES (:nombre, :imagen);");
        $sentenciaSQL->bindParam(':nombre',$txtNombre);
        //nuevo nombre del archivo y si envian archivo , le pongo el nuevo nombre mas el tiempo y nuevo nombre de archivo para que no se confunda con el anterior. imagen.jpg es generica... aca va cualquier nombre...
        $fecha= new DateTime();
        $nombreArchivo= ($txtImagen!="")? $fecha ->getTimestamp()."_".$_FILES["txtImage"]["name"]:"imagen.jpg";
        //vamos a utilizar una imagen temporal que va a ser igual a files con el archivo de img y le vamos a poner la imag temp que la vamos a compiar en u¿la bd...
        $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

        if($tmpImagen=""){
            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);

        }

        $sentenciaSQL->bindParam(':imagen',$txtImagen);
        $sentenciaSQL->execute();
        header("Location:productos.php");
        break;

    case "Modificar":
        $sentenciaSQL=$conexion->prepare("UPDATE libros SET nombre= :nombre WHERE idlibro=:id");
        $sentenciaSQL->bindParam( ':nombre', $txtNombre);
        $sentenciaSQL->bindParam( ':id', $txtID);
        $sentenciaSQL->execute();

        //ESTO ES PARA MODIFICAR LA IMAGEN DESDE LA PAGINA , SE MODIFICA EN LA BD
        if($txtImagen!=""){
            $fecha= new DateTime();
            $nombreArchivo= ($txtImagen!="")? $fecha ->getTimestamp()."_".$_FILES["txtImage"]["name"]:"imagen.jpg";

            $tmpImagen=$_FILES["txtImagen"]["tmp_name"];

            move_uploaded_file($tmpImagen,"../../img/".$nombreArchivo);


            $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE idlibro=:id");
            $sentenciaSQL->bindParam( ':id', $txtID);
            $sentenciaSQL->execute();
            $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY); //CARGAR LOS DATOS UNO A UNO Y RELLENARLOS
    
            if(isset($libro["imagen"]) &&($libro["imagen"]!="imagen.jpg")){
                if(file_exists("../../img/".$libro["imagen"])){
                    unlink("../../img/".$libro["imagen"]);
                }
            }

            $sentenciaSQL=$conexion->prepare("UPDATE libros SET imagen= :imagen WHERE idlibro=:id");
            $sentenciaSQL->bindParam( ':imagen', $nombreArchivo);
            $sentenciaSQL->bindParam( ':id', $txtID);
            $sentenciaSQL->execute();
        }
        header("Location:productos.php");
        break;

    case "Cancelar":
        //echo "Cancelar"; redireccionamos la pagina al recargar
        header("Location:productos.php");
        break;
    case "Seleccionar":
        $sentenciaSQL = $conexion->prepare("SELECT * FROM libros WHERE idlibro=:id");
        $sentenciaSQL->bindParam( ':id', $txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY); //CARGAR LOS DATOS UNO A UNO Y RELLENARLOS

        $txtNombre=$libro['nombre'];
        $txtImagen=$libro['imagen'];

        //echo "Seleccionar";
        break;
    case "Borrar":
        $sentenciaSQL = $conexion->prepare("SELECT imagen FROM libros WHERE idlibro=:id");
        $sentenciaSQL->bindParam( ':id', $txtID);
        $sentenciaSQL->execute();
        $libro=$sentenciaSQL->fetch(PDO::FETCH_LAZY); //CARGAR LOS DATOS UNO A UNO Y RELLENARLOS

        if(isset($libro["imagen"]) &&($libro["imagen"]!="imagen.jpg")){
            if(file_exists("../../img/".$libro["imagen"])){
                unlink("../../img/".$libro["imagen"]);
            }
        }


        $sentenciaSQL=$conexion->prepare("DELETE FROM libros WHERE idlibro=:id");
        $sentenciaSQL->bindParam(':id', $txtID);
        $sentenciaSQL->execute();
        //echo "Borrar";
        header("Location:productos.php");
        break;
    }

?>




<!DOCTYPE html>
<html lang="en">
<head>
  <title>Title</title>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Bootstrap CSS v5.2.1 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-iYQeCzEYFbKjA/T2uDLTpkwGzCiq6soy8tYaI1GyVh/UjpbCx/TYkiZhlZB6+fzT" crossorigin="anonymous">

</head>
<body>

PRODUCTOS
<div class="col-md-5">
    <div class="card">
        <div class="card-header">
            Listado de Libros
        </div>

        <div class="card-body">
        <form method="post" enctype="multipart/form-data" >
            <div class = "form-group">
                <label for="txtID">Id</label>
                <input type="text" required readonly class="form-control" value="<?php echo $txtID; ?>" name="txtID" id="txtID" placeholder="Id">
            </div>

            <div class="form-group">
                <label for="txtNombre">Nombre</label>
                <input type="text" required class="form-control"  value="<?php echo $txtNombre; ?>" name="txtNombre" id="txtNombre" placeholder="Nombre">
            </div>

            <div class="form-group">
                <label for="txtNombre">Imagen</label>
                <?php echo $txtImagen; ?>
                <?php if($txtImagen!=""){ ?>
                    <img class="img-thumbnail rounded" src="../../img/<?php echo $txtImagen; ?>" width="50" alt="">

                <?php } ?>

                <input type="file" required class="form-control" name="txtImagen" id="txtImagen" placeholder="imagen">
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="exampleCheck1">
                <label class="form-check-label" for="exampleCheck1">Check me out</label>
            </div>

            <div class="btn-group" role="group" aria-label="">
                <button type="submit" name="accion" <?php echo ($accion=="Seleccionar")?"disable":""; ?> value="Agregar" class="btn btn-success">Agregar</button>
                <button type="submit" name="accion"  <?php echo ($accion=="Seleccionar")?"disable":""; ?> value="Modificar" class="btn btn-warning">Modificar</button>
                <button type="submit" name="accion"  <?php echo ($accion=="Seleccionar")?"disable":""; ?> value="Cancelar" class="btn btn-info">Cancelar</button>
            </div>
        </form>
    
        </div>

        <div class="card-footer text-muted">
            Footer
        </div>
    </div>
   
   
    
</div>

<div class="col-md-7">
    tabla de libros
    <div class="table-responsive-md">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th scope="col">Id</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($listaLibros as $libro) { ?>
                <tr class="">
                    <td scope="row"><?php echo $libro['idlibro']; ?></td>
                    <td><?php echo $libro['nombre']; ?></td>
                    <td><img src="../../img/<?php echo $libro['imagen']; ?>" width="50" alt="">
                        </td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="txtID" id="txtID" value="<?php echo $libro['idlibro']; ?>" />

                            <input type="submit" name="accion" value="Seleccionar" class="btn btn-primary" />

                            <input type="submit" name="accion" value="Borrar" class="btn btn-danger"/>
                        </form>
                    </td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
    
    
</div>




<?php 
include_once '../template/footer.php' ?>

</body>
</html>


