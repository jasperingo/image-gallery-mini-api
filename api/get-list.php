<?php

include_once '../autoload.php';

use imagegallery\utils\Httpx;
use imagegallery\controllers\ImageController;

Httpx::setGetHeaders();

$controller = new ImageController;

$response = $controller->getList();


Httpx::sendJSONResponse($response->code, $response->entity);


