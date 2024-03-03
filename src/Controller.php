<?php

declare(strict_types=1);

namespace App;

// use PDO;
// use Throwable;
// use App\Exception\AppException;
use App\Exception\ConfigurationException;

require_once("src/Exception/ConfigurationException.php");
require_once("Database.php");
require_once("View.php");


class Controller
{
	private const DEFAULT_ACTION = 'login';

	private static array $configuration = [];

	private Database $database;
	private View $view;
	private $request;

	public static function initConfiguration(array $configuration): void
	{
		self::$configuration = $configuration;
	}

	public function __construct(array $request)
	{
		if(empty(self::$configuration['db'])){
			throw new ConfigurationException("Configuration error");
		}

		$this->database = new Database(self::$configuration['db']); 
		$this->request = $request;
		$this->view = new View();
	}

	public function run(): void 
	{
		switch ($this->action()) {
			case 'login':
				$page = 'login';

				$loginData = $this->getRequestPost();
				if(!empty($loginData)) {
					$loginData = [
						'username' => $loginData['username'],
						'password' => $loginData['password']
					];
				$this->database->loginUser($loginData);
				}
				break;
			
			case 'register':
				$page = 'register';
				
				$registrationData = $this->getRequestPost();
				if(!empty($registrationData)) {
					$registrationData = [
						'email' => $registrationData['email'],
						'username' => $registrationData['username'],
						'password' => $registrationData['password'],
						'confirmPassword' => $registrationData['confirmPassword']
					];
					if ($registrationData['password'] === $registrationData['confirmPassword']){
						$this->database->registerUser($registrationData);	
						header('Location: /'); 
					} else {
						echo "Różne hasła";
					}
				}
				break;

			case 'recover-password':
				$page = 'recover-password';
				break;
			
			default:
				$page = 'login';
		}

		$this->view->render($page);
	}

	private function action(): string 
	{
		$data = $this->getRequestGet();
		return $data['action'] ?? self::DEFAULT_ACTION;
	}

	private function getRequestGet(): array
	{
		return $this->request['get'] ?? [];
	}

	private function getRequestPost(): array
	{
		return $this->request['post'] ?? [];
	}


}