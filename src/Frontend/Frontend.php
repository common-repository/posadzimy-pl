<?php


namespace Inspire_Labs\Posadzimy\Frontend;


use Exception;
use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Backend\Settings as Backend_Settings;
use Inspire_Labs\Posadzimy\Email\Custom_Email_Static_Factory;
use Inspire_Labs\Posadzimy\Utils\Credit_Balance;
use WC_Order;

class Frontend {
	/**
	 * @var Credit_Balance
	 */
	private $credit_balance;

	/**
	 * Frontend constructor.
	 *
	 * @param Credit_Balance $credit_balance
	 */
	public function __construct( Credit_Balance $credit_balance ) {
		$this->credit_balance = $credit_balance;
	}

	/**
	 * Short description
	 *
	 * @throws Exception
	 */
	public function init() {
		//if ( $this->credit_balance->verify_credits() ) {
		if ( floatval( get_option('posadzimy_balance') ) > 0 ) {
			$this->init_frontend_features();
		}
	}

	/**
	 * Short description
	 *
	 * @throws Exception
	 */
	private function init_frontend_features() {
		add_action(
			'wp',
			function () {
				if ( $this->is_cart_module_enabled() ) {
					$cart = Cart_Static_Factory::create_service();
					$cart->init();
				}

				if ( $this->is_single_product_module_enabled() ) {
					$sp = Product_Single_Static_Factory::create_service();
					$sp->init();
				}

				if ( $this->is_checkout_module_enabled() ) {
					$checkout = Checkout_Static_Factory::create_service();
					$checkout->init();
				}


				Order_Static_Factory::create_service();
			}
		);
	}

	/**
	 * Short description
	 *
	 * @return bool
	 */
	private function is_cart_module_enabled(): bool {
		return "1" === App::get_settings()->get_option(
				Backend_Settings::CART_MODULE_ENABLED
			);
	}

	/**
	 * Short description
	 *
	 * @return bool
	 */
	private function is_single_product_module_enabled(): bool {
		return "1" === App::get_settings()->get_option(
				Backend_Settings::SP_MODULE_ENABLED
			);
	}

	/**
	 * Short description
	 *
	 * @return bool
	 */
	private function is_checkout_module_enabled(): bool {
		return "1" === App::get_settings()->get_option(
				Backend_Settings::CHECKOUT_MODULE_ENABLED
			);
	}

}
