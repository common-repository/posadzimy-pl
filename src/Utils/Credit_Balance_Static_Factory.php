<?php


namespace Inspire_Labs\Posadzimy\Utils;


use Inspire_Labs\Posadzimy\Api_Client\Client;
use Inspire_Labs\Posadzimy\Api_Client\Client_Static_Factory;

class Credit_Balance_Static_Factory {

	/**
	 * @return Credit_Balance
	 */
	public static function create_service(): Credit_Balance {
		return new Credit_Balance( Client_Static_Factory::create_service() );
	}
}
