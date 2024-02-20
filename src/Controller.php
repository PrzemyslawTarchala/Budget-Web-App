<?php

declare(strict_types=1);

namespace App;

use PDO;

require_once("Database.php");
require_once("View.php");


class Controller
{
	private const DEFAULT_ACTION = 'login';

	private static array $configuration = [];

	private $request;
	private View $view;

	public static function initConfiguration(array $configuration): void
	{
		self::$configuration = $configuration;
	}

	public function __construct(array $request)
	{
		$db = new Database(self::$configuration['db']); 

		$this->request = $request;
		$this->view = new View();
	}

	public function run(): void 
	{
		$viewParams = [];
		
		switch ($this->action()) {
			case 'login':
				$page = 'login';

				$data = $this->getRequestPost();
				if(!empty($data)) {
					$data = [
						'email' => $data['email'],
						'password' => $data['password']
					];
					dump($data);
				}

				break;
			
			case 'register':
				$page = 'register';
				break;

			case 'recover-password':
				$page = 'recover-password';
				break;
			
			default:
				$page = 'login';
		}

		$this->view->render($page, $viewParams);
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