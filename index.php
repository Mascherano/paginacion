<?php 

    include_once 'conexion.php'; 

    $sql = 'SELECT * FROM articulos';
    $sent = $pdo->prepare($sql);
    $sent->execute();

    $resultado = $sent->fetchAll();

    $art_pagina = 3;
    $total_articulos = $sent->rowCount();
    $total_paginas = ceil($total_articulos / $art_pagina);

?>
<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/css/bootstrap.min.css" integrity="sha384-9gVQ4dYFwwWSjIDZnLEWnxCjeSWFphJiwGPXr1jddIhOegiu1FwO5qRGvFXOdJZ4" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="container my-5">
        <h1 class="mb-5">Paginación</h1>
        <?php
            if(!$_GET){
                header('Location:index.php?pag=1');
            }

            if($_GET['pag'] > $total_paginas || $_GET['pag'] <= 0){
                header('Location:index.php?pag=1');
            }

            $inicio = ($_GET['pag']-1) * $art_pagina;
            
            $sql_articulos = "SELECT * FROM articulos LIMIT :iniciar,:narticulos";
            $sent_articulos = $pdo->prepare($sql_articulos);
            $sent_articulos->bindParam(':iniciar', $inicio,PDO::PARAM_INT);
            $sent_articulos->bindParam(':narticulos', $art_pagina,PDO::PARAM_INT);
            $sent_articulos->execute();

            $resultado_articulos = $sent_articulos->fetchAll();
        ?>
        <?php foreach($resultado_articulos as $articulo): ?>
            <div class="alert alert-primary" role="alert">
                <?php echo $articulo['titulo']; ?>
            </div>
        <?php endforeach ?>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li class="page-item <?php echo $_GET['pag'] <= 1 ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?pag=<?php echo $_GET['pag'] - 1 ?>">Anterior</a>
                </li>
                <?php for($i = 0; $i < $total_paginas; $i++):?>
                    <li class="page-item <?php echo $_GET['pag'] == $i+1 ? 'active' : '' ?>"><a class="page-link" href="index.php?pag=<?php echo $i + 1; ?>"><?php echo $i + 1; ?></a></li>
                <?php endfor ?>
                <li class="page-item <?php echo $_GET['pag'] >= $total_paginas ? 'disabled' : '' ?>">
                    <a class="page-link" href="index.php?pag=<?php echo $_GET['pag'] + 1 ?>">Siguiente</a>
                </li>
            </ul>
        </nav>
    </div>
  </body>
</html>