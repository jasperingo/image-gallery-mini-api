<?php

include_once '../autoload.php';

use imagegallery\utils\Httpx;
use imagegallery\controllers\ImageController;


Httpx::setPutHeaders();

$data = Httpx::fetchJSONRequest();


$controller = new ImageController;

$response = $controller->update($data);


Httpx::sendJSONResponse($response->code, $response->entity);







