<?php


namespace Inspire_Labs\Posadzimy\Frontend;


use Exception;
use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Utils\Credit_Balance_Static_Factory;

class Frontend_Static_Factory {

	/**
	 * Short description
	 *
	 * @return Frontend
	 * @throws Exception
	 */
	public static function create_service(): Frontend {
		return new Frontend( Credit_Balance_Static_Factory::create_service() );
	}
}
