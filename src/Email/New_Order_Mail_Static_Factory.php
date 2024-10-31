<?php


namespace Inspire_Labs\Posadzimy\Email;


use Inspire_Labs\Posadzimy\Utils\Order_Helper_Static_Factory;

class New_Order_Mail_Static_Factory {

	/**
	 * @return New_Order_Mail
	 */
	public static function create_service(): New_Order_Mail {
		return new New_Order_Mail( Order_Helper_Static_Factory::create_service() );
	}
}
