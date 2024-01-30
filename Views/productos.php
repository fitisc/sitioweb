<?php
include_once '.header.php' ?>
<?php
include_once '../admin/config/bd.php';

$sentenciaSQL = $conexion -> prepare("SELECT * FROM libros"); //pongo la intrucc sql para seleccionar todos los libros
// ejecuto la instrucción anterior
$sentenciaSQL->execute();
//para almacenar la informacion y luego llamarla... tengo que igualar la sentencia sql qu se ejecuto anteriormente a traves de una var nueva que tiene un fetch (junta los registros para mostrar los datod dfe la tabla)  con pdo fetchassoc que 
//esta var nueva va a tener todos los registros para mostrar los dat
$listaLibros = $sentenciaSQL ->fetchAll(PDO::FETCH_ASSOC);


?>
<?php foreach($listaLibros as $libro){ ?>
    <div class="col-md-3">
    
    <div class="card">
        <img class="card-img-top" src="<?php echo $libro["imagen"]; ?>" alt="">

        <div class="card-body">
        <h4 class="card-title"><?php echo $libro["nombre"]; ?></h4>
        <p class="card-text">Text</p>
        <a name="" id="" class="btn btn-primary"  href="#" role="button">Ver</a>
        </div>
    </div>
</div>




<? } ?>



<?php 
include("footer.php");?>