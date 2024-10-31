<?php


namespace Inspire_Labs\Posadzimy\Frontend;


use Exception;
use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Utils\Cart_Helper_Static_Factory;

class Cart_Static_Factory {

	/**
	 * Short description
	 *
	 * @return Cart
	 * @throws Exception
	 */
	public static function create_service(): Cart {
		if ( is_admin() ) {
			throw new Exception( __( 'Wrong context', App::TEXTDOMAIN ) );
		}
		$cart_helper = Cart_Helper_Static_Factory::create_service();

		return new Cart( $cart_helper );
	}
}
