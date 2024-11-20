<?php

function ctrlformsong($request, $response, $container){
    $response->setTemplate("formsongs.php");
    return $response;
}