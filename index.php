<?php

declare(strict_types=1);

namespace App;

use App\Exception\AppException;
use Throwable;

require_once("src/Utils/debug.php");
require_once("src/Controller.php");
require_once("src/Exception/StorageException.php");

$configuration = require_once("config/config.php"); 

$request = [
	'get' => $_GET,
	'post' => $_POST
];

try{
	Controller::initConfiguration($configuration);
	(new Controller($request))->run();
} catch (ConfigurationException $e) {
	echo "Wystąpił nieoczekiwany błąd aplikacji. ConfigurationException</br>";
	echo "Wymagany kontakt";
	echo $e->getMessage();

} catch (StorageException $e) {
	echo "Wystąpił nieoczekiwany błąd aplikacji. StorageException</br>";
	echo $e->getMessage();

} catch (AppException $e) {
	echo "Wystąpił nieoczekiwany błąd aplikacji. AppException</br>";
	echo $e->getMessage();

}	catch (Throwable $e) {
	echo "Wystąpił nieoczekiwany błąd aplikacji. Throwable</br>";
	echo $e->getMessage();
}


// $controller = new Controller($request);
// $controller->run();

