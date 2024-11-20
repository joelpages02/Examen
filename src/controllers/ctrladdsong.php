<?php

function ctrladdsong($request, $response, $container){
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        $song_name = $request->get(INPUT_POST, "song_name");
        $artist = $request->get(INPUT_POST, "artist");
        $song_file = $request->get("FILES", "song");

        $unique_id = uniqid();
        $upload_dir = "uploads/";
        $file_name = $unique_id . "_" . basename($song_file['name']);
        $dir_file = $upload_dir . $file_name;

        move_uploaded_file($song_file['tmp_name'], $dir_file);

        $songModal = $container->Songs();

        $songModal->addSong($song_name, $artist, $dir_file);

        $response->redirect("Location: index.php");
    }
    return $response;
}
