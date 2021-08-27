<?php

namespace imagegallery\utils;


class Httpx {
	
	
	public static function fetchJSONRequest() : \StdClass {

		try {

			$data = json_decode(file_get_contents("php://input"), null, 512, JSON_THROW_ON_ERROR);

			return $data;

		} catch (\JsonException $e) {
			self::sendJSON400Response();
		}
	}

	public static function sendJSON400Response() : void {
		self::sendJSONResponse(Response::RC_BAD_REQUEST, new ResponseEntity(ResponseEntity::STATUS_ERROR, __['error']['400']));
	}
	
	public static function sendJSONResponse(int $code, ?ResponseEntity $response) : void {
		
		http_response_code($code);

		if ($response !== null) {

			foreach ($response as $key => $value) {
				if ($value === null) {
					unset($response->{$key});
				}
			}

			echo json_encode($response);
		}

		exit;
	}
	
	
	public static function setPostHeaders() : void {
		header('Access-Control-Max-Age: 3600');
		header('Access-Control-Allow-Methods: POST');
		self::setHeaders();
	}

	public static function setPutHeaders() : void {
		header('Access-Control-Max-Age: 3600');
		header('Access-Control-Allow-Methods: PUT');
		self::setHeaders();
	}

	public static function setDeleteHeaders() : void {
		header('Access-Control-Max-Age: 3600');
		header('Access-Control-Allow-Methods: DELETE');
		self::setHeaders();
	}

	public static function setGetHeaders() : void {
		header('Access-Control-Allow-Methods: GET');
		self::setHeaders();
	}

	public static function setHeaders() : void {
		header('Access-Control-Allow-Origin: *');
		header('Content-Type: application/json; charset=UTF-8');
		header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');
	}
	
	
}





