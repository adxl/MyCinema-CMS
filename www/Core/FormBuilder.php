<?php

namespace App\Core;

class FormBuilder
{
	public function __construct()
	{
	}

	public static function render($config, $show = true)
	{
		$html = "<form 
				method='" . ($config["config"]["method"] ?? "GET") . "' 
				action='" . ($config["config"]["action"] ?? "") . "'
				class='" . ($config["config"]["class"] ?? "") . "'
				id='" . ($config["config"]["id"] ?? "") . "'
				>";

		foreach ($config["inputs"] as $name => $configInput) {
			$html .= "<div class='flex'>
						<label for='" . ($configInput["id"] ?? $name) . "'>" . ($configInput["label"] ?? "") . " </label>";

			if ($configInput['type'] == 'textarea') {
				$html .= "<textarea  
							id='" . ($configInput["id"] ?? $name) . "'
							name='" . $name . "'
							placeholder='" . ($configInput["placeholder"] ?? "") . "'
							value='" . ($configInput["value"] ?? "") . "'
							class='" . ($configInput["class"] ?? "") . "'
							rows='" . ($configInput["rows"] ?? "") . "'
							cols='" . ($configInput["cols"] ?? "") . "'
							" . (!empty($configInput["required"]) ? "required" : "") . "
							" . (!empty($configInput["checked"]) ? "checked" : "") . "
						></textarea>";
			} elseif ($configInput['type'] == 'select') {
				$html .= "<select 
							name='" . $name . "' 
							id='" . ($configInput["id"] ?? $name) . "'>";

				foreach ($configInput['options'] as $option)
					$html .= "<option value='" . $option['id'] . "'>" . $option['label'] . "</option>";

				$html .= "</select>";
			} elseif ($configInput['type'] == 'field') {
				$html .= "<div class='flex'>
							<input 
								type='text'
								id='" . $configInput["id"] . "'
								name='" . $name . "'
								placeholder='" . ($configInput["placeholder"] ?? "") . "'
								value='" . ($configInput["value"] ?? "") . "'
								class='" . ($configInput["class"] ?? "") . "'
								min='" . ($configInput["min"] ?? null) . "'
								max='" . ($configInput["max"] ?? null) . "'
								" . (!empty($configInput["required"]) ? "required" : "") . "
								" . (!empty($configInput["checked"]) ? "checked" : "") . "
						 	>" . "
							<button 
								type='button'
								id='" . $configInput["id"] . "-btn'
								name='" . $name . "'
								class='" . ($configInput["class"] ?? "") . "'>" . $configInput["button"] . "</button>
							<div id='" . $configInput["id"] . "-values' class='flex'></div>
						</div>";
			} elseif ($configInput['type'] == 'session') {
				$html .= "<div class='" . $configInput['class']  . " session-inputs' >";

				foreach ($configInput['items'] as $name => $input) {

					$html .= "<label for='" . ($input["id"] ?? $name) . "'>" . ($input["label"] ?? "") . " </label>";

					if ($input["type"] == 'select') {
						$html .= "<select name='" . $name . "' id='" . ($input["id"] ?? $name) . "'>";

						foreach ($input['options'] as $option)
							$html .= "<option value='" . $option['id'] . "'>" . $option['label'] . "</option>";

						$html .= "</select>";
					} elseif ($input["type"] == 'button') {
						$html .= "<button 
									type='button' 
									id='" . ($input['id'] ?? '') . "' 
									class='" . $input['class'] . "'> " . $input['value'] . "
								</button>";
					} else {
						$html .= "<input 
									type='" . $input["type"] . "'
									id='" . ($input["id"] ?? $name) . "'
									name='" . $name . "'
									placeholder='" . ($input["placeholder"] ?? "") . "'
									value='" . ($input["value"] ?? "") . "'
									class='" . ($input["class"] ?? "") . "'
									min='" . ($input["min"] ?? null) . "'
									max='" . ($input["max"] ?? null) . "'
									" . (!empty($input["required"]) ? "required" : "") . "
									" . (!empty($input["checked"]) ? "checked" : "") . "
						>";
					}
				}

				$html .= "</div>";
			} elseif ($configInput['type'] == 'button') {
				$html .= "<button 
							type='button' 
							id='" . $configInput['id'] . "'> " . $configInput['value'] . "
						</button>";
			} else {
				$html .= "<input 
							type='" . ($configInput["type"] ?? "text") . "'
							id='" . ($configInput["id"] ?? $name) . "'
							name='" . $name . "'
							placeholder='" . ($configInput["placeholder"] ?? "") . "'
							value='" . ($configInput["value"] ?? "") . "'
							class='" . ($configInput["class"] ?? "") . "'
							min='" . ($configInput["min"] ?? null) . "'
							max='" . ($configInput["max"] ?? null) . "'
							" . (!empty($configInput["required"]) ? "required" : "") . "
							" . (!empty($configInput["checked"]) ? "checked" : "") . "
							>";
			}
			$html .= "</div>";
		}

		$html .= "<div class='flex flex-center'>
					<input type='submit' value=\"" . ($config["config"]["submit"] ?? "Valider") . "\">
					<a href=" . ($config["config"]["cancel_action"] ?? "/") . "> " . ($config["config"]["cancel"] ?? "Cancel") . " </a>
				</div>";

		$html .= "</form>";


		if ($show) {
			echo $html;
		} else {
			return $html;
		}
	}
}
