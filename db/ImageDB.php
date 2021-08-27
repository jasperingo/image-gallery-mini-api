<?php

namespace imagegallery\db;

use PDOException;
use imagegallery\models\Image;


class ImageDB extends DB {

	public function insert (Image $image) : bool {

		$sql = 'INSERT INTO image (name, size, url, height, width, tags) VALUES (?, ?, ?, ?, ?, ?)';
		
		try {

			$stmt = self::getConnection()->prepare($sql);

			$rows = $stmt->execute([
				$image->name,
				$image->size,
				$image->url,
				$image->height,
				$image->width,
				join(',', $image->tags)
			]);

			if ($rows < 1) {
				throw new PDOException('Image Not Inserted');
			}

			$image->id = self::getConnection()->lastInsertId();

			return true;

		} catch (PDOException $e) {
			error_log('DATABASE: '.$e->getMessage());
			return false;
		}
	}

	public function update (Image $image) : bool {

		$sql = 'UPDATE image SET name = ?, size = ?, url = ?, height = ?, width = ?, tags = ? WHERE id = ?';
		
		try {

			$stmt = self::getConnection()->prepare($sql);

			$rows = $stmt->execute([
				$image->name,
				$image->size,
				$image->url,
				$image->height,
				$image->width,
				join(',', $image->tags),
				$image->id
			]);

			if ($rows < 1) {
				throw new PDOException('Image Not Updated');
			}

			return true;

		} catch (PDOException $e) {
			error_log('DATABASE: '.$e->getMessage());
			return false;
		}
	}

	public function delete (Image $image) : bool {

		$sql = 'DELETE FROM image WHERE id = ?';
		
		try {

			$stmt = self::getConnection()->prepare($sql);

			$rows = $stmt->execute([$image->id]);

			if ($rows < 1) {
				throw new PDOException('Image Not Deleted');
			}

			return true;

		} catch (PDOException $e) {
			error_log('DATABASE: '.$e->getMessage());
			return false;
		}
	}

	public function findId(int $id) : int {

		$sql = 'SELECT id FROM image WHERE id = ?';
		
		try {

			$stmt = self::getConnection()->prepare($sql);

			$rows = $stmt->execute([$id]);

			$result = $stmt->fetchColumn();

			if ($result !== false) {
				return $result;
			}

			return 0;

		} catch (PDOException $e) {
			error_log('DATABASE: '.$e->getMessage());
			return -1;
		}
	}

	public function find(int $id) : ?Image {

		$sql = 'SELECT * FROM image WHERE id = ?';
		
		try {

			$stmt = self::getConnection()->prepare($sql);

			$rows = $stmt->execute([$id]);

			$result = $stmt->fetch();

			if ($result !== false) {
				return new Image(
					$result->id, 
					$result->name, 
					$result->url, 
					$result->size, 
					$result->width, 
					$result->height, 
					explode(",", $result->tags),
					$result->created_at
				);
			}

			return new Image;

		} catch (PDOException $e) {
			error_log('DATABASE: '.$e->getMessage());
			return null;
		}
	}

	public function findAll() : ?array {

		$sql = 'SELECT * FROM image';
		
		try {

			$stmt = self::getConnection()->prepare($sql);

			$rows = $stmt->execute();

			$results = $stmt->fetchAll();

			$list = [];
			
			foreach ($results as $result) {
				array_push($list, new Image(
					$result->id, 
					$result->name, 
					$result->url, 
					$result->size, 
					$result->width, 
					$result->height, 
					explode(",", $result->tags),
					$result->created_at
				));
			}

			return $list;

		} catch (PDOException $e) {
			error_log('DATABASE: '.$e->getMessage());
			return null;
		}

	}


}








