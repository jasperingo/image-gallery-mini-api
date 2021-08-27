<?php

namespace imagegallery\utils;


class FormFieldData {

	public $name;

	public $value;

	public $error;

	
	public function __construct(string $name, $value, string $error) {
		$this->name = $name;
		$this->value = $value;
		$this->error = $error;
	}


}



