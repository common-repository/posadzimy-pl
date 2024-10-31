<?php


namespace Inspire_Labs\Posadzimy\Backend;


use Inspire_Labs\Posadzimy\Api_Client\Client_Static_Factory;

class Order_Static_Factory {
	/**
	 * @return Order
	 */
	public static function create_service(): Order {
		return new Order( Client_Static_Factory::create_service() );
	}
}
