<?php


namespace Inspire_Labs\Posadzimy\Frontend;


use Inspire_Labs\Posadzimy\Api_Client\Client_Static_Factory;
use Inspire_Labs\Posadzimy\Utils\Cart_Helper_Static_Factory;

class Order_Static_Factory {

	/**
	 * @return Order
	 */
	public static function create_service(): Order {
		return new Order(
			Cart_Helper_Static_Factory::create_service(),
			Client_Static_Factory::create_service()
		);
	}
}
