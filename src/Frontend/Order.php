<?php


namespace Inspire_Labs\Posadzimy\Frontend;

use Exception;
use Inspire_Labs\Posadzimy\Api_Client\Client;
use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Backend\Settings;
use Inspire_Labs\Posadzimy\Backend\Settings as Backend_Settings;
use Inspire_Labs\Posadzimy\Utils\Cart_Helper;
use Inspire_Labs\Posadzimy\Virtual_Product\Virtual_Product_Value_Object;
use WC_Customer;
use WC_Order;

class Order {

	/**
	 * @var Cart_Helper
	 */
	private $cart_helper;
	/**
	 * @var Client
	 */
	private $api_client;

	/**
	 * Order constructor.
	 *
	 * @param Cart_Helper $cart_helper
	 * @param Client $api_client
	 */
	public function __construct(
		Cart_Helper $cart_helper,
		Client $api_client
	) {
		$this->cart_helper = $cart_helper;
		add_action( 'woocommerce_checkout_update_order_meta',
			[ $this, 'process_virtual_product' ],
			100,
			1 );
		$this->api_client = $api_client;
	}

	/**
	 * @param int $order_id
	 */
	public function process_virtual_product( int $order_id ) {
		$wc_order = wc_get_order( $order_id );

		if ( $this->is_virtual_product_in_order( $wc_order ) ) {
			return;
		}

		// Gets order grand total. incl. taxes.
		$total = $wc_order->get_total();

        // if "Netto" amount in plugin settings
        if ( ! App::get_settings()->get_option(Backend_Settings::THRESHOLD_AMOUNT_VALUE_TYPE ) ) {
            $total = (float) $wc_order->get_total() - (float) $wc_order->get_total_tax();
        }

		if ( $this->cart_helper->is_threshold_amount_exceed( $total ) ) {
			update_post_meta(
				$order_id,
				self::get_meta_id(),
				App::META_VALUE_TRUE
			);

            if( 'yes' === get_option('woocommerce_custom_orders_table_enabled') ) {
                $order = wc_get_order( $order_id );
                if ( $order && !is_wp_error($order) ) {
                    $order->update_meta_data( self::get_meta_id(), App::META_VALUE_TRUE );
                    $order->save();
                }
            }

		} else {
			update_post_meta(
				$order_id,
				self::get_meta_id(),
				App::META_VALUE_FALSE
			);

            if( 'yes' === get_option('woocommerce_custom_orders_table_enabled') ) {
                $order = wc_get_order( $order_id );
                if ( $order && !is_wp_error($order) ) {
                    $order->update_meta_data( self::get_meta_id(), App::META_VALUE_FALSE );
                    $order->save();
                }
            }
		}
	}


	/**
	 * @return string
	 */
	public static function get_meta_id(): string {
		return '_' . Backend_Settings::PREFIX
		       . 'threshold_amount_exceed';
	}

	/**
	 * @return string
	 */
	public static function get_meta_virtual_product_id(): string {
		return '_' . Backend_Settings::PREFIX
		       . 'virtual_product';
	}

	/**
	 * @param WC_Order $order
	 *
	 * @return bool
	 */
	public function is_virtual_product_in_order( WC_Order $order ): bool {
		$from_meta = get_post_meta( $order->get_id(),
			Order::get_meta_virtual_product_id() );
		if ( is_array( $from_meta ) && isset( $from_meta[0] ) ) {
			return $from_meta[0] instanceof Virtual_Product_Value_Object;
		}

		return false;
	}
}
