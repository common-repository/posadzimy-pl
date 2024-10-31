<?php


namespace Inspire_Labs\Posadzimy\Utils;


class Cart_Helper_Static_Factory {

	/**
	 * Short description
	 *
	 * @return Cart_Helper
	 */
	public static function create_service(): Cart_Helper {
		global $woocommerce;

		return new Cart_Helper( $woocommerce->cart );
	}
}
