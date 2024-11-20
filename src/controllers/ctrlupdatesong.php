<?php

function ctrlupdatesong($request, $response, $container) {
    $id = $request->get(INPUT_POST, 'song_id');

    // Recoge los datos enviados desde el formulario para la actualización
    $song_name = $request->get(INPUT_POST, 'song_name');
    $artist = $request->get(INPUT_POST, 'artist');

    // Modelo de canciones
    $songModel = $container->Songs();

    // Verifica si la canción existe
    $currentsong = $songModel->getSongById($id);
    if (!$currentsong) {
        // Si no se encuentra la canción, redirige a una página de error
        $response->redirect("Location: error.php?msg=cancion_no_encontrada");
        return $response;
    }

    // Usa los valores existentes si no se envían valores nuevos
    $song_name = $song_name ?: $currentsong['song_name'];
    $artist = $artist ?: $currentsong['artist'];

    // Manejo del archivo enviado
    if (!empty($_FILES['song']['tmp_name'])) {
        $uploadDir = 'uploads/';
        $song_path = $uploadDir . basename($_FILES['song']['name']);
        if (!move_uploaded_file($_FILES['song']['tmp_name'], $song_path)) {
            // Redirigir si hay un error al subir el archivo
            $response->redirect("Location: index.php?msg=error_subiendo_archivo");
        }
    } else {
        // Si no hay un archivo nuevo, usa el path existente
        $song_path = $currentsong['song_path'];
    }

    // Intenta actualizar la canción
    $updateSuccess = $songModel->updateSong($id, $song_name, $artist, $song_path);

    if ($updateSuccess) {
        // Redirigir a la página de éxito si se actualiza correctamente
        $response->redirect("Location: index.php?msg=cancion_actualizada");
    } else {
        // Redirigir a una página de error si falla la actualización
        $response->redirect("Location: index.php?msg=error_actualizando_cancion");
    }

    return $response;
}
