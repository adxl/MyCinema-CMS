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
				//TODO: $html .= "<select..."
			} elseif ($configInput['type'] == 'field') {
				$html .= "<div>
							<input 
								type='text'
								id='" . ($configInput["id"] ?? $name) . "'
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
								id='" . ($configInput["id"] ?? $name) . "-btn'
								name='" . $name . "'
								class='" . ($configInput["class"] ?? "") . "'
								>" . $configInput["button"] . "
							</button>
						</div>";
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
