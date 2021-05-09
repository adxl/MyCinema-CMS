<?php

namespace App\Core;

class FormValidator
{

	public static function check($config, $data)
	{
		$errors = [];

		if (count($data) != self::getFieldsCount($config['inputs'])) { // Faille XSS 
			// $errors[] = "An error occured";
			exit("An error occured"); // TODO: non testé
		}

		foreach ($config["inputs"] as $name => $input) {

			// validate required
			if (isset($input['required']) && empty($data[$name])) {
				$errors[] = $input['label'] . ' is required';
			}

			// validate length (min et max)
			if (isset($input["minLength"]) && isset($input["maxLength"])) {

				$minLengthValid = (strlen($data[$name]) >= $input["minLength"]);
				$maxLengthValid = (strlen($data[$name]) <= $input["maxLength"]);

				if (!$minLengthValid || !$maxLengthValid) {
					$errors[] = $input['label'] . " length should be between " . $input["minLength"] . " and " . $input["maxLength"] . " characters.";
				}
			}
		}


		// validate password confirmation
		$pwd = isset($config["inputs"]['pwd']) ? $data['pwd'] : null;
		$pwdConfirm = isset($config["inputs"]['pwd-confirm']) ? $data['pwd-confirm'] : null;

		if (($pwd && $pwdConfirm) && ($pwd !== $pwdConfirm)) {
			$errors[] = "Passwords don't match";
		}

		return $errors;
	}


	private static function getFieldsCount($inputs)
	{
		$fields = array_filter($inputs, function ($v, $k) {
			return $v['type'] !== 'button';
		}, ARRAY_FILTER_USE_BOTH);

		return count($fields);
	}
}
