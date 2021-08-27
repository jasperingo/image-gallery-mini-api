<?php

include_once '../autoload.php';

use imagegallery\utils\Httpx;
use imagegallery\controllers\ImageController;


Httpx::setPostHeaders();

$data = Httpx::fetchJSONRequest();


$controller = new ImageController;

$response = $controller->add($data);


Httpx::sendJSONResponse($response->code, $response->entity);




