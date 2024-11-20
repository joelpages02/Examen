<?php

function ctrleditformsong($request, $response, $container){

    $id = $request->get(INPUT_GET, "id");

    $modelSong = $container->Songs();
    $songs = $modelSong->getSongById($id);

    $response->set("songs", $songs);
    $response->setTemplate("editformsong.php");
    return $response;
}