<?php

function ctrlsongslist($request, $response, $container){
    $songModel = $container->Songs();

    $songs = $songModel->getAllSongs();

    $response->set('songs', $songs);
    $response->setTemplate("index.php");

    return $response;
}