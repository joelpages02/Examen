<?php

function ctrlIndex($request, $response, $container){
    // Obtener el modelo de canciones   
    $songModel = $container->Songs();
    
    // Obtener todas las canciones
    $songs = $songModel->getAllSongs();
    
    // Pasar las canciones a la vista
    $response->set('songs', $songs);
    
    // Establecer la plantilla
    $response->setTemplate("index.php");
    
    return $response;
}