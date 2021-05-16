<?php

namespace App\Core;

use App\Controllers\Security;

class Router
{
	private $slug;
	private $action;
	private $controller;
	private $scope;
	private $routePath = "routes.yml";
	private $listOfRoutes = [];
	private $listOfSlugs = [];

	/*
        - On passe le slug en attribut
        - Execution de la methode loadYaml
        - Vérifie si le slug existe dans nos routes -> SINON appel la methode exception4040
        - call setController et setAction
    */
	public function __construct($slug)
	{
		$this->slug = $slug;
		$this->cleanSlug();
		$this->loadYaml();

		if (empty($this->listOfRoutes[$this->slug])) {
			$this->exception404();
		}

		$this->setController($this->listOfRoutes[$this->slug]["controller"]);
		$this->setAction($this->listOfRoutes[$this->slug]["action"]);
		$this->setScope($this->listOfRoutes[$this->slug]["scope"]);

		if (!empty($this->scope)) {
			$this->checkAuthentication();
			$this->checkPermission();
		}
	}

	public function cleanSlug()
	{
		$this->slug = explode("?", $this->slug)[0];
	}

	private function checkAuthentication()
	{
		session_start();

		$session = $_SESSION['authSession'] ?? null;

		if (!$session) {
			Helpers::redirect('/login');
		}

		$isAuthenticated = Security::isAuthenticated($session);

		if (!$isAuthenticated) {
			Helpers::redirect('/login');
		}
	}

	private function checkPermission()
	{
		session_start();

		$scope = $this->scope;
		$sessionId = $_SESSION['authSession'] ?? null;

		if (!$sessionId) {
			$this->exception403();
		}

		$hasPermission = Security::hasPermission($sessionId, $scope);

		if (!$hasPermission) {
			$this->exception403();
		}
	}

	public function loadYaml()
	{
		$this->listOfRoutes = yaml_parse_file($this->routePath);
		foreach ($this->listOfRoutes as $slug => $route) {
			if (empty($route["controller"]) || empty($route["action"])) {
				die("Error - Parse Error : failed to parse YAML file [Router.php]");
			}

			$this->listOfSlugs[$route["controller"]][$route["action"]] = $slug;
		}
	}

	public function getSlug($controller = "Main", $action = "default")
	{
		return $this->listOfSlugs[$controller][$action];
	}

	public function setController($controller)
	{
		$this->controller = ucfirst($controller);
	}

	public function setAction($action)
	{
		$this->action = $action . "Action";
	}

	public function setScope($scope)
	{
		$this->scope = $scope;
	}

	public function getController()
	{
		return $this->controller;
	}

	public function getAction()
	{
		return $this->action;
	}

	public function getScope()
	{
		return $this->scope;
	}

	public function exception404()
	{
		die("Error - Not Found Error : route not found [Router.php]");  // TODO: add views
	}

	public function exception403()
	{
		die("Error - Forbidden Error : you don't have access [Router.php]"); // TODO: add views
	}
}
