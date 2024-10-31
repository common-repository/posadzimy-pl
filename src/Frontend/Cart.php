<?php


namespace Inspire_Labs\Posadzimy\Frontend;


use \Inspire_Labs\Posadzimy\Backend\Settings as Backend_Settings;
use Inspire_Labs\Posadzimy\Utils\Cart_Helper;
use Inspire_Labs\Posadzimy\App;

class Cart {

	/**
	 * @var Cart_Helper
	 */
	private $cart_helper;

	public function __construct( Cart_Helper $cart_helper ) {
		$this->cart_helper = $cart_helper;
	}

	/**
	 * Init.
	 */
	public function init() {
		if ( ! is_cart() ) {
			return;
		}

		if ( false === $this->cart_helper->is_threshold_amount_exceed() ) {
			$threshold_amount_value = $this->cart_helper->get_threshold_amount_value();
			$threshold_amount_required = $this->cart_helper->get_threshold_amount_required();
			$message = App::get_settings()->get_option(
				Backend_Settings::CART_THRESHOLD_AMOUNT_INFO_TEXT
			);
			$message = str_replace(
				[
					'{{wysokosc_zamowienia}}',
					'{{brakujaca_kwota}}',
				],
				[
					$threshold_amount_value,
					$threshold_amount_required,
				]
				,
				$message
			);
			wc_add_notice( $message, 'notice' );
		} else {
			$message = App::get_settings()->get_option(
				Backend_Settings::CART_VIRTUAL_PRODUCT_ADDED_NOTICE );

			wc_add_notice( $message, 'notice' );
		}
		$this->include_inline_css();
	}

	/**
	 * Short description
	 *
	 * @return void
	 */
	private function include_inline_css() {
		add_action(
			'wp_head',
			function () {
				$css = App::get_settings()->get_option(
					Backend_Settings::CART_CUSTOM_CSS
				);
				if ( ! empty( $css ) ) {
					echo wp_kses( "<style>$css</style>", [ 'style' => [] ] );
				}
			},
			100
		);
	}
}
