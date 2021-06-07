<?php

namespace App\Core;

class FormValidator
{

	public static function check($config, $data)
	{
		$errors = [];

		if (count($data) != self::getFieldsCount($config['inputs'])) { // Faille XSS 
			// $errors[] = "An error occured";
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


		// TODO: validate email 


		$pwd = isset($config["inputs"]['pwd']) ? $data['pwd'] : null;
		$pwdConfirm = isset($config["inputs"]['pwdConfirm']) ? $data['pwdConfirm'] : null;

		// TODO: validate password complexity
		# MIN LENGTH 8 - 255
		# AU MOINS 1 Maj, 1min, 1 chiffre, 1 specialChar

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


	private static function getFieldsCount($inputs)
	{
		$fields = array_filter($inputs, function ($v, $k) {
			return $v['type'] !== 'button' && $v['type'] !== 'link';
		}, ARRAY_FILTER_USE_BOTH);

		return count($fields);
	}
}
