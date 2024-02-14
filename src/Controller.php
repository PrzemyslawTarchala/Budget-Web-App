<?php

declare(strict_types=1);

namespace App;

require_once("src/View.php");

class Controller
{
	private const DEFAULT_ACTION = 'login';

	private $request;
	private View $view;

	public function __construct(array $request)
	{
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