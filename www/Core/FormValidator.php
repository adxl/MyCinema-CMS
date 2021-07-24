<?php

namespace App\Core;

use App\Core\Database;

class FormValidator
{

	public static function check($config, $data)
	{
		$errors = [];

		$fields_count = self::getFieldsCount($config['inputs']);
		if (isset($config['config']['enctype']) &&  ($config['config']['enctype'] == 'multipart/form-data')) {
			$fields_count--;
		}

		if (count($data) != $fields_count) { // Faille XSS 
			echo "<pre>";
			echo 'XSS ERROR :' . PHP_EOL;
			var_dump(array_keys($data));
			var_dump($data);
			echo '---:' . PHP_EOL;
			var_dump(array_keys($config['inputs']));
			echo '---:' . PHP_EOL;
			var_dump($fields_count);
			echo "</pre>";
			die();
			Helpers::redirect("/500");
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

	public static function checkEventForm($config, $data)
	{
		$errors = [];

		if (count($data) != 9) {
			return ["Les données de l'évènement sont invalides"];
		}

		if (
			!isset($data['date'])
			|| !isset($data['startTime'])
			|| !isset($data['endTime'])
			|| !isset($data['room'])
		) {
			return ["Les données de la séance ne sont pas correctes"];
		}

		if (
			(count($data['startTime']) != count($data['date']))
			|| (count($data['endTime']) != count($data['date']))
			|| (count($data['room']) != count($data['date']))
		) {
			return ["Les données de la séance ne sont pas correctes"];
		}

		for ($i = 0; $i < count($data['date']); $i++) {
			if ($data['startTime'][$i] >= $data['endTime'][$i])
				return ["Les horaires de la séance ne sont pas correctes"];
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

		// validate database connection			
		if (empty($errors) && !Database::testConnection($data)) {
			return ["Echec de connexion à la base de données"];
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

		// validate email pattern 
		$filterEmail = filter_var($data['EMAIL_SMTP_ADMIN'], FILTER_VALIDATE_EMAIL);
		if (!$filterEmail) {
			$errors[] = "Le format de l'email n'est pas valide";
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

	public static function checkWizard($config, $data)
	{
		$errors = [];

		// validate required
		foreach ($config["inputs"] as $name => $input) {
			if (empty($data[$name])) {
				$errors[] = "'" . $input['label'] . "' est obligatiore";
			}
		}

		// validate emails patterns
		if (!empty($data['EMAIL_SMTP_ADMIN']) && !filter_var($data['EMAIL_SMTP_ADMIN'], FILTER_VALIDATE_EMAIL)) {
			$errors[] = "Le format de l'email SMTP n'est pas valide";
		}
		if (!empty($data['WEBSITE_ADMIN']) && !filter_var($data['WEBSITE_ADMIN'], FILTER_VALIDATE_EMAIL)) {
			$errors[] = "Le format de l'email admin n'est pas valide";
		}

		// validate admin password
		if (strlen($data["WEBSITE_PASSWORD"]) < 8)
			$errors[] = "Le mot de passe doit faire au moins 8 caractères!";
		if (!preg_match("#[0-9]+#", $data["WEBSITE_PASSWORD"]))
			$errors[] = "Le mot de passe doit contenir au moins 1 chiffre";
		if (!preg_match("#[a-z]+#", $data["WEBSITE_PASSWORD"]))
			$errors[] = "Le mot de passe doit contenir au moins 1 minuscule";
		if (!preg_match("#[A-Z]+#", $data["WEBSITE_PASSWORD"]))
			$errors[] = "Le mot de passe doit contenir au moins 1 majuscule";
		if (!preg_match("#[\:\.\@\&\#\$\?\!\_\-\/\*\=\+]+#", $data["WEBSITE_PASSWORD"]))
			$errors[] = "Le mot de passe doit contenir au moins 1 caractère special ($, @, !, ?, ...)";

		// validate database connection			
		$databaseData = [
			'DB_HOST' => $data['DB_HOST'],
			'DB_DRIVER' => "mysql",
			'DB_PORT' => 3306,
			'DB_NAME' => $data['DB_NAME'],
			'DB_PREFIXE' => "faman_",
			'DB_USER' => $data['DB_USER'],
			'DB_PASSWORD' => $data['DB_PASSWORD']
		];

		if (!Database::testConnection($databaseData)) {
			$errors[] = "Echec de connexion à la base de données";
		}

		return $errors;
	}
}
