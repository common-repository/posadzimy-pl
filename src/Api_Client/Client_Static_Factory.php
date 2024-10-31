<?php


namespace Inspire_Labs\Posadzimy\Api_Client;


use Inspire_Labs\Posadzimy\Backend\Alerts;
use Inspire_Labs\Posadzimy\Backend\Alerts_Static_Factory;

class Client_Static_Factory {

	/**
	 * Short description
	 *
	 * @return Client
	 */
	public static function create_service(): Client {
		return new Client(
			Auth_Static_Factory::create_service(),
			Alerts_Static_Factory::create_service()
		);
	}
}
