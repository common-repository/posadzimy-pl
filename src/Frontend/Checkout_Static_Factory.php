<?php


namespace Inspire_Labs\Posadzimy\Frontend;


use Exception;
use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Utils\Cart_Helper_Static_Factory;

class Checkout_Static_Factory {

	/**
	 * Short description
	 *
	 * @return Checkout
	 * @throws Exception
	 */
	public static function create_service(): Checkout {
		if ( is_admin() ) {
			throw new Exception( __( 'Wrong context', App::TEXTDOMAIN ) );
		}
		$cart_helper = Cart_Helper_Static_Factory::create_service();

		return new Checkout( $cart_helper );
	}
}
