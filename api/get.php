<?php

include_once '../autoload.php';

use imagegallery\utils\Httpx;
use imagegallery\controllers\ImageController;


Httpx::setGetHeaders();

if (!isset($_GET['id'])) {
	Httpx::sendJSON400Response();
}

$controller = new ImageController;

$response = $controller->get($_GET['id']);


Httpx::sendJSONResponse($response->code, $response->entity);

