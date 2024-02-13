<?php

declare(strict_types=1);

namespace App;

require_once("src/Utils/debug.php");
require_once("src/View.php");

const DEAFULT_ACTION = 'login';


$action = $_GET['action'] ?? DEAFULT_ACTION;

$view = new View();

$viewParams = [];
$viewParams['userId'] = 1;

$view->render($action, $viewParams);