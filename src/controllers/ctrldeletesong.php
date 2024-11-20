<?php

function ctrldeletesong($request, $response, $container){
        $id_song = $request->get(INPUT_POST, 'id_song');

        $SongsModal = $container->Songs();
        $SongsModal->delete($id_song);
        
        $response->redirect("Location: index.php");
        return $response;
}