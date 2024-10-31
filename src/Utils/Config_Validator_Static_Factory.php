<?php


namespace Inspire_Labs\Posadzimy\Utils;


class Config_Validator_Static_Factory {

	/**
	 * Short description
	 *
	 * @return Config_Validator
	 */
	public static function create_service(): Config_Validator {
		return new Config_Validator();
	}
}
