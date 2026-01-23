<?php
require_once "GestionAutomovilesAuth.php";

//obtenemos la marca
$marcaActual = $_GET['marca'] ?? '';

?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="css/modelos.css" />
</head>
<body>
    
<h1>Modelos disponibles marca: <?php echo $marcaActual ?></h1>

<?php
//  lista desde la clase
$listadoCoches = $client->ObtenerModelosPorMarca($marcaActual);

foreach ($listadoCoches as $nombreModelo) {
    $nombreLimpio = trim($nombreModelo); 

    //rutas de imagenes
    $rutaExacta    = "images/" . $nombreLimpio . ".png";           
    $rutaMinuscula = "images/" . strtolower($nombreLimpio) . ".png"; 
    
    //si no hay fotos, ruta de repuesto con la imagen de la marca
    $logoMarca = "images/" . strtolower($marcaActual) . ".png";

    if (file_exists($rutaExacta)) {
        //si existe exacto
        $imagenAmostrar = $rutaExacta;
    } elseif (file_exists($rutaMinuscula)) {
        //si existe en minuscula
        $imagenAmostrar = $rutaMinuscula;
    } else {
        //si no existe
        $imagenAmostrar = $logoMarca;
    }
?>
    <figure>
        <img src="<?php echo $imagenAmostrar ?>" alt="<?php echo $nombreLimpio ?>" width="200px"/>
        <figcaption><?php echo $nombreLimpio ?></figcaption>
        
        </figure>

<?php 
} 
?>

</body>
</html>