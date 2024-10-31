<?php


namespace Inspire_Labs\Posadzimy\Utils;


class Order_Helper_Static_Factory {

	/**
	 * @return Order_Helper
	 */
	public static function create_service(): Order_Helper {
		return new Order_Helper();
	}
}
