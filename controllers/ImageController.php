<?php

namespace imagegallery\controllers;

use StdClass;
use imagegallery\utils\Response;
use imagegallery\utils\ResponseEntity;
use imagegallery\utils\FormFieldData;
use imagegallery\models\Image;
use imagegallery\db\ImageDB;


class ImageController {


	private function validateData(StdClass $data) : array {

		$errors = [];

		if (!isset($data->name) || empty($data->name)) {
			array_push($errors, new FormFieldData('name', '', __['error']['form_field_required']));
		} elseif (strlen($data->name) < 3) {
			array_push($errors, new FormFieldData('name', '', __['error']['form_field_invalid']));
		}

		if (!isset($data->url) || empty($data->url)) {
			array_push($errors, new FormFieldData('url', '', __['error']['form_field_required']));
		} elseif (!filter_var($data->url, FILTER_VALIDATE_URL)) {
			array_push($errors, new FormFieldData('url', '', __['error']['form_field_invalid']));
		}

		if (!isset($data->size) || empty($data->size)) {
			array_push($errors, new FormFieldData('size', '', __['error']['form_field_required']));
		} elseif ($data->size <= 0) {
			array_push($errors, new FormFieldData('size', '', __['error']['form_field_invalid']));
		}

		if (!isset($data->width) || empty($data->width)) {
			array_push($errors, new FormFieldData('width', '', __['error']['form_field_required']));
		} elseif ($data->width <= 0) {
			array_push($errors, new FormFieldData('width', '', __['error']['form_field_invalid']));
		}

		if (!isset($data->height) || empty($data->height)) {
			array_push($errors, new FormFieldData('height', '', __['error']['form_field_required']));
		} elseif ($data->height <= 0) {
			array_push($errors, new FormFieldData('height', '', __['error']['form_field_invalid']));
		}

		if (!isset($data->tags) || empty($data->tags)) {
			array_push($errors, new FormFieldData('tags', '', __['error']['form_field_required']));
		} elseif (!is_array($data->tags) || count($data->tags) < 1) {
			array_push($errors, new FormFieldData('tags', '', __['error']['form_field_invalid']));
		} else {

			foreach($data->tags as $t) {
				if (empty($t)) {
					array_push($errors, new FormFieldData('tags', '', __['error']['form_field_invalid']));
				}
			}

		}

		return $errors;
	}


	public function add(StdClass $data) : Response {

		$errors = $this->validateData($data);

		if (!empty($errors)) {
			return new Response(Response::RC_BAD_REQUEST, new ResponseEntity(
					ResponseEntity::STATUS_ERROR,
					__['error']['400'], 
					$errors
				)
			); 
		}

		$image = new Image(0, $data->name, $data->url, $data->size, $data->width, $data->height, $data->tags);
		
		if (!(new ImageDB)->insert($image)) {
			return new Response(Response::RC_INTERNAL_SERVER_ERROR, new ResponseEntity(
					ResponseEntity::STATUS_ERROR, 
					__['error']['500']
				)
			); 
		}
		
		return new Response(Response::RC_CREATED, new ResponseEntity(
				ResponseEntity::STATUS_SUCCESS, 
				__['success']['image_added'], 
				['id'=> $image->id]
			)
		);
	}


	public function update(StdClass $data) : Response {

		$db = new ImageDB;

		$errors = $this->validateData($data);

		if (!isset($data->id) || empty($data->id)) {
			array_push($errors, new FormFieldData('id', '', __['error']['form_field_required']));
		} elseif (!is_int($data->id)) {
			array_push($errors, new FormFieldData('id', $data->id, __['error']['form_field_invalid']));
		} else {

			$imgID = $db->findId($data->id);

			if ($imgID === -1) {
				return new Response(Response::RC_INTERNAL_SERVER_ERROR, new ResponseEntity(
						ResponseEntity::STATUS_ERROR, 
						__['error']['500']
					)
				); 
			} elseif ($imgID === 0) {
				array_push($errors, new FormFieldData('id', $data->id, __['error']['form_field_invalid']));
			}
		}
		
		if (!empty($errors)) {
			return new Response(Response::RC_BAD_REQUEST, new ResponseEntity(
					ResponseEntity::STATUS_ERROR,
					__['error']['400'], 
					$errors
				)
			); 
		}

		$image = new Image($data->id, $data->name, $data->url, $data->size, $data->width, $data->height, $data->tags);
		
		if (!$db->update($image)) {
			return new Response(Response::RC_INTERNAL_SERVER_ERROR, new ResponseEntity(
					ResponseEntity::STATUS_ERROR, 
					__['error']['500']
				)
			); 
		}

		return new Response(Response::RC_OK, new ResponseEntity(
				ResponseEntity::STATUS_SUCCESS, 
				__['success']['image_updated']
			)
		);
	}

	public function delete(StdClass $data) : Response {

		$db = new ImageDB;

		$errors = [];

		if (!isset($data->id) || empty($data->id)) {
			array_push($errors, new FormFieldData('id', '', __['error']['form_field_required']));
		} elseif (!is_int($data->id)) {
			array_push($errors, new FormFieldData('id', $data->id, __['error']['form_field_invalid']));
		} else {

			$imgID = $db->findId($data->id);

			if ($imgID === -1) {
				return new Response(Response::RC_INTERNAL_SERVER_ERROR, new ResponseEntity(
						ResponseEntity::STATUS_ERROR, 
						__['error']['500']
					)
				); 
			} elseif ($imgID === 0) {
				array_push($errors, new FormFieldData('id', $data->id, __['error']['form_field_invalid']));
			}
		}
		
		if (!empty($errors)) {
			return new Response(Response::RC_BAD_REQUEST, new ResponseEntity(
					ResponseEntity::STATUS_ERROR,
					__['error']['400'], 
					$errors
				)
			); 
		}

		$image = new Image($data->id);
		
		if (!$db->delete($image)) {
			return new Response(Response::RC_INTERNAL_SERVER_ERROR, new ResponseEntity(
					ResponseEntity::STATUS_ERROR, 
					__['error']['500']
				)
			); 
		}

		return new Response(Response::RC_NO_CONTENT);
	}


	public function get(int $id) : Response {

		$db = new ImageDB;

		$image = $db->find($id);
		
		if ($image === null) {
			return new Response(Response::RC_INTERNAL_SERVER_ERROR, new ResponseEntity(
					ResponseEntity::STATUS_ERROR, 
					__['error']['500']
				)
			);
		} elseif ($image->id === 0) {
			return new Response(Response::RC_NOT_FOUND, new ResponseEntity(
					ResponseEntity::STATUS_ERROR, 
					__['error']['404']
				)
			);
		}

		return new Response(Response::RC_OK, new ResponseEntity(
				ResponseEntity::STATUS_SUCCESS,
				null,
				$image
			)
		);
	}


	public function getList() : Response {

		$db = new ImageDB;

		$images = $db->findAll();
		
		if ($images === null) {
			return new Response(Response::RC_INTERNAL_SERVER_ERROR, new ResponseEntity(
					ResponseEntity::STATUS_ERROR, 
					__['error']['500']
				)
			);
		}

		return new Response(Response::RC_OK, new ResponseEntity(
				ResponseEntity::STATUS_SUCCESS,
				null,
				$images
			)
		);
	}


}




