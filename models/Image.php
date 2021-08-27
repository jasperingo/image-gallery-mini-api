<?php


namespace imagegallery\models;



class Image extends Model {

	public $name;

	public $url;

	public $size;

	public $width;

	public $height;

	public $tags;
	
	public function __construct(int $id=0, string $name=null, string $url=null, int $size=0, int $width=0, int $height=0, array $tags=[], string $created_at=null) {
		$this->id = $id;
		$this->name = $name;
		$this->size = $size;
		$this->url = $url;
		$this->width = $width;
		$this->height = $height;
		$this->tags = $tags;
		$this->createdAt = $created_at;		
	}

}





