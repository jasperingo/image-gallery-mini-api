<?php

namespace imagegallery\db;

use PDO;


class DB {
	

	private static $connection = null;


	protected static function getConnection() : PDO {
		if (self::$connection == null) {
			self::$connection = static::createConnection();
		}

		return self::$connection;
	}

	private static function createConnection () : PDO {
		
		$options = array(
			\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
			\PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
			\PDO::ATTR_EMULATE_PREPARES => false,
		);
		
		return new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD, $options);
	}
	
	
	public function selectRow (string $query, array $arr) : array {
	
		$stmt = $this->conn->prepare($query);
		
		$stmt->execute($arr);
		
		$results = $stmt->fetch();
	
		if (!empty($results)) {
			return $results;
		} else {
			return array();
		}
		
	}
	
	public function selectRows (string $query, array $arr) : array {
	
		$stmt = $this->conn->prepare($query);
	
		$stmt->execute($arr);
	
		$results = $stmt->fetchAll();
	
		if (!empty($results)) {
			return $results;
		} else {
			return array();
		}
	
	}
	
	public function selectColumns (string $query, array $arr) : array {
	
		$stmt = $this->conn->prepare($query);
	
		$stmt->execute($arr);
	
		$results = $stmt->fetchAll(PDO::FETCH_COLUMN);
		
		if (!empty($results)) {
			return $results;
		} else {
			return array();
		}
	}
	
	public function selectColumn (string $query, array $arr) {
	
		$stmt = $this->conn->prepare($query);
		
		$stmt->execute($arr);
		
		$result = $stmt->fetchColumn();
		
		if ($result !== false) {
			return $result;
		} else {
			return null;
		}
	}
	
	
	public function selectInt (string $query, array $arr) : int {
	
		$stmt = $this->conn->prepare($query);
		
		$stmt->execute($arr);
		
		$result = $stmt->fetchColumn();
		
		if ($result !== false) {
			return $result;
		} else {
			return 0;
		}
	}
	
	
	public function selectFloat (string $query, array $arr) : float {
	
		$stmt = $this->conn->prepare($query);
		
		$stmt->execute($arr);
		
		$result = $stmt->fetchColumn();
		
		if ($result !== false && $result !== null) {
			return $result;
		} else {
			return 0.00;
		}
	}
	
	
	public function selectString (string $query, array $arr) : string {
	
		$stmt = $this->conn->prepare($query);
		
		$stmt->execute($arr);
		
		$result = $stmt->fetchColumn();
		
		if ($result !== false && $result !== null) {
			return $result;
		} else {
			return "";
		}
	}
	
	public function selectBool (string $query, array $arr) : bool {
	
		$stmt = $this->conn->prepare($query);
		
		$stmt->execute($arr);
		
		$result = $stmt->fetchColumn();
		
		if ($result !== false) {
			return true;
		} else {
			return false;
		}
	}


	public function useTransaction ($func, $args=array()) {
		
		try {
			
			$this->beginTransaction();
			
			$result = $func($args);
			
			if ($result === false) {
				$this->rollback();
				return false;
			}
			
			$this->commit();
			
			return true;
			
		} catch (\PDOException $e) {
			
			if ($this->inTransaction()) {
				$this->rollback();
			}
			
			return false;
		}
	}
	
	
	
	
	
}



