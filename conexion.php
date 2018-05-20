<?php

$link = 'mysql:host=127.0.0.1:3308;dbname=paginacion';
$user = 'root';
$pass = '';

try{

    $pdo = new PDO($link, $user, $pass);
    // foreach($pdo->query('Select * from `colores`') as $fila){
    //     print_r($fila);
    // }

}catch(PDOException $e){
    print "¡Error!: " . $e->getMessage() . "<br/>";
    die();
}