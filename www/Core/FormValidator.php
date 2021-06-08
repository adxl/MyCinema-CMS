<?php

namespace App\Core;

use App\Core\Database;

class FormValidator
{

	public static function check($config, $data)
	{
		$errors = [];

		if (count($data) != self::getFieldsCount($config['inputs'])) { // Faille XSS 
			Helpers::redirect("/500");
			die();
		}

		foreach ($config["inputs"] as $name => $input) {

			// validate required
			if (isset($input['required']) && empty($data[$name])) {
				$errors[] = "'" . $input['label'] . "' est obligatiore";
			}

			// validate length (min et max)
			if (isset($input["minLength"]) && isset($input["maxLength"])) {

				$minLengthValid = (strlen($data[$name]) >= $input["minLength"]);
				$maxLengthValid = (strlen($data[$name]) <= $input["maxLength"]);

				if (!$minLengthValid || !$maxLengthValid) {
					$errors[] = "'" . $input['label'] . "' doit faire entre " . $input["minLength"] . " et " . $input["maxLength"] . " caractères.";
				}
			}
		}

		// validate email pattern 
		if (isset($config["inputs"]['email'])) {
			$filterEmail = filter_var($data['email'], FILTER_VALIDATE_EMAIL);
			if (!$filterEmail) {
				$errors[] = "Email non-valide";
			}
		}

		$pwd = isset($config["inputs"]['pwd']) ? $data['pwd'] : null;
		$pwdConfirm = isset($config["inputs"]['pwdConfirm']) ? $data['pwdConfirm'] : null;

		// validate password strength
		if (!is_null($pwd)) {
			if (strlen($pwd) < 8) {
				$errors[] = "Le mot de passe doit faire au moins 8 caractères!";
			}

			if (!preg_match("#[0-9]+#", $pwd)) {
				$errors[] = "Le mot de passe doit contenir au moins 1 chiffre";
			}

			if (!preg_match("#[a-z]+#", $pwd)) {
				$errors[] = "Le mot de passe doit contenir au moins 1 minuscule";
			}

			if (!preg_match("#[A-Z]+#", $pwd)) {
				$errors[] = "Le mot de passe doit contenir au moins 1 majuscule";
			}

			if (!preg_match("#[\:\.\@\&\#\$\?\!\_\-\/\*\=\+]+#", $pwd)) {
				$errors[] = "Le mot de passe doit contenir au moins 1 caractère special ($, @, !, ?, ...)";
			}

			// validate password confirmation
			if (($pwd && $pwdConfirm) && ($pwd !== $pwdConfirm)) {
				$errors[] = "Les mots de passe ne correspondent pas";
			}
		}

		return $errors;
	}

	public static function checkDatabaseSettings($config, $data)
	{
		$errors = [];

		// validate required
		foreach ($config["inputs"] as $name => $input) {
			if (empty($data[$name])) {
				$errors[] = "'" . $input['label'] . "' est obligatiore";
			}
		}

		if (empty($errors)) {

			// validate database connection
			$host = $data["db-host"];
			$driver = $data["db-driver"];
			$port = $data["db-port"];
			$name = $data["db-name"];
			$user = $data["db-user"];
			$password = $data["db-password"];

			try {
				$pdo = new \PDO($driver . ":host=" . $host . ";dbname=" . $name . ";port=" . $port, $user, $password);
			} catch (\PDOException $e) {
				$errors[] = "Echec de connexion à la base de données";
				return $errors;
			}
		}

		return $errors;
	}

	public static function checkMailingSettings($config, $data)
	{
		$errors = [];

		// validate required
		foreach ($config["inputs"] as $name => $input) {
			if (empty($data[$name])) {
				$errors[] = "'" . $input['label'] . "' est obligatiore";
			}
		}

		return $errors;
	}

	private static function getFieldsCount($inputs) // anti-XSS
	{
		$fields = array_filter($inputs, function ($v, $k) {
			return $v['type'] !== 'button' && $v['type'] !== 'link';
		}, ARRAY_FILTER_USE_BOTH);

		return count($fields);
	}
}
