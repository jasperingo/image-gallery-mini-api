<?php

include_once '../autoload.php';

use imagegallery\utils\Httpx;
use imagegallery\controllers\ImageController;


Httpx::setDeleteHeaders();

$data = Httpx::fetchJSONRequest();


$controller = new ImageController;

$response = $controller->delete($data);


Httpx::sendJSONResponse($response->code, $response->entity);





