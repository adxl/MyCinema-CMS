<?php

namespace App\Core;

class FormBuilder
{
	public static function render($config, $show = true)
	{
		$html = "<form 
				method='" . ($config["config"]["method"] ?? "GET") . "' 
				action='" . ($config["config"]["action"] ?? "") . "' 
				" . (!empty($config["config"]["enctype"]) ? "enctype='multipart/form-data'" : "") . "
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
				$html .= "<div id='session-inputs-container' class='w-100 w-75@m w-100@l'>";
				foreach ($configInput['items'] as $item) {
					$html .= "<div class='flex-column flex-row@l session-inputs'>";
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
							$html .= "<hr class='w-100 hidden@l faded'>";
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
									" . ($input["type"] === 'time' ? "step='60'" : "") . "
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
			} elseif ($configInput['type'] == 'link') {
				$html .= "<a 
							href='" . $configInput['href'] . "' 
							id='" . ($configInput["id"] ?? $name) . "'
							class='link " . $configInput['class'] . "'> " . $configInput['value'] . "
						</a>";
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
			} elseif ($configInput['type'] == 'media') {
				$html .= "<div class='flex-column flex-center'>";
				$html .= "<input 
							name='" . $name . "'
							type='file'
							accept='image/png, image/jpg, image/jpeg'
							id='" . ($configInput["id"] ?? $name) . "'
							>";
				$html .= "<img src='" . ($configInput["value"] ?? "") . "' style='max-width: 180px' />";
				$html .= "</div>";
			} else {
				$html .= "<input 
							name='" . $name . "'
							type='" . ($configInput["type"] ?? "text") . "'
							id='" . ($configInput["id"] ?? $name) . "'
							form='" . ($configInput["form"] ?? $config['config']['id']) . "'
							placeholder='" . ($configInput["placeholder"] ?? "") . "'
							value=\"" . htmlentities($configInput["value"] ?? "", 0, 'UTF-8') . "\"
							min='" . ($configInput["min"] ?? null) . "'
							max='" . ($configInput["max"] ?? null) . "'
							autocomplete='off'
							" . (!empty($configInput["required"]) ? "required" : "") . "
							" . (!empty($configInput["checked"]) ? "checked" : "") . "
							>";
				if (isset($configInput['hint'])) {
					$html .= "<div class='flex flex-middle'>
									<i class='visible@l fas fa-info-circle faded ml-m mr-m'></i>
									<p class='visible@l faded no-break'>" . $configInput['hint'] . "</p>
								</div>";
				}
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
