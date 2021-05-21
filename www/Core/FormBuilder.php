<?php

namespace App\Core;

class FormBuilder
{
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
						>" . htmlentities($configInput["value"] ?? "", 0, 'UTF-8') . "</textarea>";
			} elseif ($configInput['type'] == 'select') {
				$html .= "<select 
							name='" . $name . "' 
							id='" . ($configInput["id"] ?? $name) . "'>";

				foreach ($configInput['options'] as $option)
					$html .= "<option value='" . $option['id'] . "'>" . $option['label'] . "</option>";

				$html .= "</select>";
			} elseif ($configInput['type'] == 'session') {
				$html .= "<div id='session-inputs-container'>";
				foreach ($configInput['items'] as $item) {
					$html .= "<div class='flex session-inputs'>";
					foreach ($item as $name => $input) {
						$html .= "<label for='" . ($input["id"] ?? $name) . "' class='" . ($input["class"] ?? '') . "'>
								<span> " . ($input["label"] ?? "") . "</span>";

						if ($input["type"] == 'select') {
							$html .= "<select name='" . $name . "' 
										form='" . ($config["config"]["id"] ?? "") . "'
										id='" . ($input["id"] ?? $name) . "'>";

							foreach ($input['options'] as $option) {
								$html .= "<option value='" . $option['id']
									. "' " . ($input['value'] === $option['label'] ? 'selected' : '') . " >"
									. $option['label'] . "</option>";
							}

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
									" . ($input["type"] === 'time' ? "step='any'" : "") . "
						></label>";
						}
					}
					$html .= "</div>";
				}

				$html .= "</div>";
			} elseif ($configInput['type'] == 'button') {
				$html .= "<button 
							type='button' 
							id='" . ($configInput["id"] ?? $name) . "'
							class='" . $configInput['class'] . "'> " . $configInput['value'] . "
						</button>";
			} elseif ($configInput['type'] == 'checkbox') {
				$html .= "<input 
							name='" . $name . "'
							type='checkbox'
							id='" . ($configInput["id"] ?? $name) . "'
							form='" . ($configInput["form"] ?? $config['config']['id']) . "'
							" . (!empty($configInput["required"]) ? "required" : "") . "
							" . (!empty($configInput["checked"]) ? "checked" : "") . "
							>";
				$html .= "<span class='checkmark' ></span>";
			} else {
				$html .= "<input 
							name='" . $name . "'
							type='" . ($configInput["type"] ?? "text") . "'
							id='" . ($configInput["id"] ?? $name) . "'
							form='" . ($configInput["form"] ?? $config['config']['id']) . "'
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
			"<a class='button button--danger-soft' 
				href=" . $config["config"]["cancel_action"] . ">" . $config["config"]["cancel"] . " </a>"
			: "";

		$html .= "<div class='mt-xl flex flex-center'>
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
