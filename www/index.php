<?php

namespace App;

use App\Core\Router;
use App\Core\ConstantManager;
use App\Core\InstallWizard;

session_start();

require "Autoload.php";
Autoload::register();

if (!InstallWizard::check()) {
	InstallWizard::start();
	return;
}

new ConstantManager();

$slug = mb_strtolower($_SERVER["REQUEST_URI"]);

$route = new Router($slug);

$c = $route->getController();
$a = $route->getAction();

if (file_exists("./Controllers/" . $c . ".php")) {

	include "./Controllers/" . $c . ".php";

	$c = "App\\Controllers\\" . $c;
	if (class_exists($c)) {

		$cObject = new $c();
		if (method_exists($cObject, $a)) {
			$cObject->$a();
		} else {
			die("Error - Method Not Found : " . $a . "  does not exist [index.php]");
		}
	} else {
		die("Error - Class Not Found : " . $c . "  does not exist [index.php]");
	}
} else {
	die("Error - File Not Found : controller file does not exist [index.php]");
}
