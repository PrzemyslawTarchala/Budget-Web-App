<?php

declare(strict_types=1);

namespace App;
 
require_once("src/Exception/StorageException.php");
require_once("src/Exception/ConfigurationException.php");

use PDO;
use PDOException;
use Throwable;
use App\Exception\StorageException;
use App\Exception\ConfigurationException;

class Database
{
	private PDO $conn;

	public function __construct(array $config)
	{
		try {
			$this->validateConfig($config);
			$this->createConnection($config);
		} catch (PDOException $e){
			throw new StorageException('Connection error');
		}
	}

	public function registerUser(array $registrationData): void
	{
		try {
			// echo ("registerUser");
			// dump($registrationData);

			$username = $this->conn->quote($registrationData['username']);
			$password = $this->conn->quote($registrationData['confirmPassword']);
			$email = $this->conn->quote($registrationData['email']);

			$query = "
				INSERT INTO users(username, password, email) 
				VALUES($username, $password, $email)
			";

			dump($query);

			$this->conn->exec($query);

		} catch (Throwable $e) {
			throw new StorageException('Nie udało się utworzyć użtkownika.' );
			dump($e);
			exit;
		}
	}

	private function createConnection(array $config): void //Magia połączenia z serwerem
	{
		$dsn = "mysql:dbname={$config['database']};host={$config['host']}";;
		$this->conn = new PDO(
			$dsn,
			$config['user'],
			$config['password'],
			[
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION //error mode będą wywolywane jako exceptiony
			]
		);
	}

	private function validateConfig(array $config): void
	{
		if(
			empty($config['database']) 
			|| empty($config['host'])
			|| empty($config['user'])
			|| empty($config['password'])
		) {
			throw new ConfigurationException('Storage cofiguration error');
		}
	}

}
 