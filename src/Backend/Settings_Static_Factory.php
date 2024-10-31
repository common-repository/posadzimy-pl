<?php


namespace Inspire_Labs\Posadzimy\Backend;

use Exception;
use Inspire_Labs\Posadzimy\Api_Client\Client_Static_Factory;
use Inspire_Labs\Posadzimy\Utils\Credit_Balance_Static_Factory;

/**
 * Class Backend_Static_Factory
 */
class Settings_Static_Factory {

	/**
	 * Short description
	 *
	 * @return Settings
	 * @throws Exception
	 */
	public static function create_service(): Settings {
		return new Settings(
			Credit_Balance_Static_Factory::create_service()
		);
	}
}
