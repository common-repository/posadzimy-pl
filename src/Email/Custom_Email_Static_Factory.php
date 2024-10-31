<?php


namespace Inspire_Labs\Posadzimy\Email;


use Inspire_Labs\Posadzimy\Api_Client\Client_Static_Factory;
use Inspire_Labs\Posadzimy\Utils\Order_Helper_Static_Factory;

class Custom_Email_Static_Factory {

	/**
	 * @return Custom_Email
	 */
	public static function create_service(): Custom_Email {
		return new Custom_Email(
			Order_Helper_Static_Factory::create_service(),
			Client_Static_Factory::create_service()
		);
	}
}
