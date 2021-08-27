<?php

namespace imagegallery\utils;


class ResponseEntity {

	const STATUS_SUCCESS = 'success';

	const STATUS_ERROR = 'error';


	public $status;

	public $message;

	public $data;

	public $pagination;

	public function __construct(string $status, ?string $message, $data = null, $pagination = null) {
		$this->status = $status;
		$this->message = $message;
		$this->data = $data;
		$this->pagination = $pagination;
	}


}


