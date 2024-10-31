<?php // phpcs:disable WordPress.Files.FileName.InvalidClassFileName


namespace Inspire_Labs\Posadzimy\Backend;

use Exception;
use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Utils\Config_Validator_Static_Factory;
use Inspire_Labs\Posadzimy\Utils\Credit_Balance_Static_Factory;

/**
 * Class Settings_Static_Factory
 */
class Backend_Static_Factory {

	/**
	 * Short description
	 *
	 * @return Backend
	 * @throws Exception
	 */
	public static function create_service(): Backend {
		if ( ! is_admin() ) {
			throw new Exception( __( 'Wrong context', App::TEXTDOMAIN ) );
		}

		$config_validator = Config_Validator_Static_Factory::create_service();
		$alerts           = Alerts_Static_Factory::create_service();
		$balance          = Credit_Balance_Static_Factory::create_service();

		return new Backend( $config_validator, $alerts, $balance );
	}
}
