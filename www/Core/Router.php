<?php

namespace App\Core;

use App\Core\Security;

class Router
{
	private $slug;
	private $action;
	private $controller;
	private $scope;
	private $routePath = "routes.yml";
	private $listOfRoutes = [];
	private $listOfSlugs = [];


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
		$slug =  explode("?", $this->slug)[0];

		if (substr($slug, -1) == '/') {
			$slug = rtrim($slug, '/');
		}

		$this->slug = $slug ?: '/';
	}

	private function checkAuthentication()
	{
		$isAuthenticated = Security::isAuthenticated();
		if (!$isAuthenticated)
			Helpers::redirect('/bo/login');
	}

	private function checkPermission()
	{
		$hasPermission = Security::hasPermission($this->scope);
		if (!$hasPermission)
			if ($this->slug === '/bo')
				Helpers::redirect('/bo/login');
			else {
				$this->exception404();
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
		Helpers::redirect('/404');
	}
}
