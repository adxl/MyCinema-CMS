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
			$html .= "<div class='row'>
						<label for='" . ($configInput["id"] ?? $name) . "' class='" . ($configInput["class"] ?? '') . "'>
							<span> " . ($configInput["label"] ?? "") . "</span>";

			if ($configInput['type'] == 'textarea') {
				$html .= "<textarea  
							id='" . ($configInput["id"] ?? $name) . "'
							name='" . $name . "'
							placeholder='" . ($configInput["placeholder"] ?? "") . "'
							rows='" . ($configInput["rows"] ?? "") . "'
							cols='" . ($configInput["cols"] ?? "") . "'
							" . (!empty($configInput["required"]) ? "required" : "") . "
							" . (!empty($configInput["checked"]) ? "checked" : "") . "
						>" . utf8_encode($configInput["value"] ?? "") . "</textarea>";
			} elseif ($configInput['type'] == 'select') {
				$html .= "<select 
							name='" . $name . "' 
							id='" . ($configInput["id"] ?? $name) . "'>";

				foreach ($configInput['options'] as $option)
					$html .= "<option value='" . $option['id'] . "'>" . $option['label'] . "</option>";

				$html .= "</select>";
			} elseif ($configInput['type'] == 'session') {
				$html .= "<div class='row session-inputs' >";

				foreach ($configInput['items'] as $name => $input) {

					$html .= "<label for='" . ($input["id"] ?? $name) . "' class='" . ($input["class"] ?? '') . "'>
								<span> " . ($input["label"] ?? "") . "</span>";

					if ($input["type"] == 'select') {
						$html .= "<select name='" . $name . "' 
										form='" . ($config["config"]["id"] ?? "") . "'
										id='" . ($input["id"] ?? $name) . "'>";

						foreach ($input['options'] as $option)
							$html .= "<option value='" . $option['id'] . "'>" . $option['label'] . "</option>";

						$html .= "</select></label>";
					} elseif ($input["type"] == 'button') {
						$html .= "</label><button 
									type='button' 
									form='" . ($config["config"]["id"] ?? "") . "'
									id='" . ($input['id'] ?? '') . "' 
									class='" . $input['class'] . " button remove-session-btn'> " . $input['value'] . "
								</button>";
					} else {
						$html .= "<input 
									type='" . $input["type"] . "'
									id='" . ($input["id"] ?? $name) . "'
									name='" . $name . "'
									placeholder='" . ($input["placeholder"] ?? "") . "'
									value='" . ($input["value"] ?? "") . "'
									form='" . ($config["config"]["id"] ?? "") . "'
									" . (!empty($input["required"]) ? "required" : "") . "
									" . (!empty($input["checked"]) ? "checked" : "") . "
						></label>";
					}
				}

				$html .= "</div>";
			} elseif ($configInput['type'] == 'button') {
				$html .= "<button 
							type='button' 
							id='" . ($configInput["id"] ?? $name) . "'
							class='" . $configInput['class'] . "'> " . $configInput['value'] . "
						</button>";
			} else {
				$html .= "<input 
							type='" . ($configInput["type"] ?? "text") . "'
							id='" . ($configInput["id"] ?? $name) . "'
							name='" . $name . "'
							placeholder='" . ($configInput["placeholder"] ?? "") . "'
							value='" . ($configInput["value"] ?? "") . "'
							min='" . ($configInput["min"] ?? null) . "'
							max='" . ($configInput["max"] ?? null) . "'
							autocomplete='off'
							" . (!empty($configInput["required"]) ? "required" : "") . "
							" . (!empty($configInput["checked"]) ? "checked" : "") . "
							>";
			}
			$html .= "</label></div>";
		}

		$postButton = "<input type='submit' class='button button--success " . ($config["config"]["submitClass"] ?? "") . "' 
								value=\"" . ($config["config"]["submit"] ?? "Valider") . "\">";
		$cancelButton = isset($config["config"]["cancel"]) ?
			"<a class='button button--danger' 
				href=" . $config["config"]["cancel_action"] . ">" . $config["config"]["cancel"] . " </a>"
			: "";

		$html .= "<div class='flex flex-center'>
				" . $postButton . $cancelButton . " 
				</div>";

		$html .= "</form>";


		if ($show) {
			echo $html;
		} else {
			return $html;
		}
	}
}
