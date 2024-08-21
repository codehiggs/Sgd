<?php

if (!function_exists("generate_sgd_permissions")) {

		/**
		 * Permite registrar los permisos asociados al modulo, tecnicamente su
		 * ejecucion regenera los permisos asignables definidos por el modulo DISA
		 */
		function generate_sgd_permissions():void
		{
				$permissions = array(
						"sgd-access",
				);
				generate_permissions($permissions, "sgd");
		}

}

if (!function_exists("get_sgd_sidebar")) {
		function get_sgd_sidebar($active_url = false):string
		{
				$bootstrap = service("bootstrap");
				$lpk = safe_strtolower(pk());
				$options = array(
						"home" => array("text" => lang("App.Home"), "href" => "/sgd/", "svg" => "home.svg"),
						"settings" => array("text" => lang("App.Settings"), "href" => "/sgd/settings/home/" . lpk(), "icon" => ICON_TOOLS, "permission" => "sgd-access"),
				);
				$o = get_application_custom_sidebar($options, $active_url);
				$return = $bootstrap->get_NavPills($o, $active_url);
				return ($return);
		}
	}

?>
