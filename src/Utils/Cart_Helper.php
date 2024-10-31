<?php


namespace Inspire_Labs\Posadzimy\Utils;


use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Backend\Settings as Backend_Settings;
use WC_Cart;

class Cart_Helper {
	/**
	 * @var WC_Cart
	 */
	private $cart;

	/**
	 * @var float
	 */
	private $threshold_amount_value;

	/**
	 * Cart_Helper constructor.
	 *
	 * @param WC_Cart $cart
	 */
	public function __construct( WC_Cart $cart ) {
		$this->cart                   = $cart;
		$this->threshold_amount_value = (float) App::get_settings()
		                                           ->get_option( Backend_Settings::THRESHOLD_AMOUNT_VALUE );
	}

	/**
	 * Short description
	 *
	 * @return float
	 */
	public function get_threshold_amount_required(): float {

        if( 'yes' === get_option( 'woocommerce_calc_taxes' ) ) {
            // if "Brutto" amount in plugin settings
            if (App::get_settings()->get_option(Backend_Settings::THRESHOLD_AMOUNT_VALUE_TYPE)) {
                $total = (float)$this->cart->get_cart_contents_total() + (float)$this->cart->get_total_tax();
                return round(  $this->threshold_amount_value - $total, 2 );
            }
        }

        $total = (float) $this->cart->get_cart_contents_total();
        return round(  $this->threshold_amount_value - $total, 2 );
	}

	/**
	 * Short description
	 *
	 * @param null $total
	 *
	 * @return bool
	 */
	public function is_threshold_amount_exceed( $total = null ): bool {
		if ( ! $total ) {

            if( 'yes' === get_option( 'woocommerce_calc_taxes' ) ) {
                // if "Brutto" amount in plugin settings
                if (App::get_settings()->get_option(Backend_Settings::THRESHOLD_AMOUNT_VALUE_TYPE)) {
                    $total = (float)$this->cart->get_cart_contents_total() + (float)$this->cart->get_total_tax();
                    return $total >= $this->threshold_amount_value;
                }
            }

            $total = (float)$this->cart->get_cart_contents_total();
            return $total >= $this->threshold_amount_value;
		}

        return $total >= $this->threshold_amount_value;
	}

	/**
	 * @return float
	 */
	public function get_threshold_amount_value(): float {
        return $this->threshold_amount_value;
	}

}
