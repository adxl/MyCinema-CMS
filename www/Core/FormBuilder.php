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
            $html .= "<label for='" . ($configInput["id"] ?? $name) . "'>" . ($configInput["label"] ?? "") . " </label>";

            $html .= "<input 
						type='" . ($configInput["type"] ?? "text") . "'
						id='" . ($configInput["id"] ?? $name) . "'
						name='" . $name . "'
						placeholder='" . ($configInput["placeholder"] ?? "") . "'
						value='" . ($configInput["value"] ?? "") . "'
						class='" . ($configInput["class"] ?? "") . "'
						min='" . ($configInput["min"] ?? null) . "'
						max='" . ($configInput["max"] ?? null) . "'
						" . (!empty($configInput["required"]) ? "required='required'" : "") . "
						" . (!empty($configInput["checked"]) ? "checked='checked'" : "") . "
						 ><br>";
        }

        $html .= "<input type='submit' value=\"" . ($config["config"]["submit"] ?? "Valider") . "\">";
        $html .= "<a href=" . ($config["config"]["cancel_action"] ?? "/") . "> " . ($config["config"]["cancel"] ?? "Cancel") . " </a>";
        $html .= "</form>";


        if ($show) {
            echo $html;
        } else {
            return $html;
        }
    }
}
