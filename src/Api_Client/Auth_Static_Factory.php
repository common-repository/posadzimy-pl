<?php


namespace Inspire_Labs\Posadzimy\Api_Client;


class Auth_Static_Factory {
	/**
	 * Short description
	 *
	 * @return Auth
	 */
	public static function create_service(): Auth {
		return new Auth();
	}
}
