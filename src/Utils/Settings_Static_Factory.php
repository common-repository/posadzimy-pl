<?php


namespace Inspire_Labs\Posadzimy\Utils;


class Settings_Static_Factory {

	/**
	 * Short description
	 *
	 * @return Settings_Helper
	 */
	public static function create_service(): Settings_Helper {
		return new Settings_Helper();
	}
}
