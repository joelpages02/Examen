<?php

function ctrlcreditsview($request, $response, $container){
    $response->setTemplate("credits.php");
    return $response;
}