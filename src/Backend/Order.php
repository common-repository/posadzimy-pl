<?php


namespace Inspire_Labs\Posadzimy\Backend;


use Exception;
use Inspire_Labs\Posadzimy\Api_Client\Client;
use Inspire_Labs\Posadzimy\Api_Client\Client_Static_Factory;
use Inspire_Labs\Posadzimy\Utils\Credit_Balance;
use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Backend\Settings as Backend_Settings;
use Inspire_Labs\Posadzimy\Virtual_Product\Virtual_Product_Value_Object;
use WC_Customer;
use WC_Order;

class Order {
	/**
	 * @var Client
	 */
	private $api_client;

	/**
	 * Order constructor.
	 *
	 * @param Client $api_client
	 */
	public function __construct( Client $api_client ) {
		$this->api_client = $api_client;
	}

	/**
	 * @param int $order_id
	 *
	 * @throws Exception
	 */
	public function execute_business_logic( int $order_id ) {
		$wc_order = wc_get_order( $order_id );

		if ( ! $this->should_make_virtual_product_order( $wc_order ) ) {
			return;
		}

		if ( $this->is_virtual_product_in_order( $wc_order ) ) {
			return;
		}

		$virtual_product = $this->make_virtual_product_order( $order_id );

		if ( $virtual_product instanceof Virtual_Product_Value_Object ) {
			update_post_meta(
				$order_id,
				self::get_meta_virtual_product_id(),
				$virtual_product
			);
            if( 'yes' === get_option('woocommerce_custom_orders_table_enabled') ) {
                $order = wc_get_order( $order_id );
                if ( $order && !is_wp_error($order) ) {
                    $order->update_meta_data( self::get_meta_virtual_product_id(), $virtual_product );
                    $order->save();
                }
            }
		}
	}

	/**
	 * @param int $order_id
	 *
	 * @return Virtual_Product_Value_Object|null
	 * @throws Exception
	 */
	private function make_virtual_product_order( int $order_id
	): ?Virtual_Product_Value_Object {
		try {
			$order = wc_get_order( $order_id );

			$response = $this->api_client->make_order(
				App::get_utils()->get_formatted_customer_name_from_order(
					$order
				),
				App::get_settings()->get_option(
					Settings::CERTIFICATE_TEXT ),
				App::get_settings()->get_option(
					Settings::API_ID
				),
				$order_id
			);
			
			$credit_balance = new Credit_Balance( Client_Static_Factory::create_service() );
            $balance = $credit_balance->get_balance_amount();
            $updated_balance = '0.00';
            if( ! empty( $balance ) && is_numeric( $balance ) ) {
                $updated_balance = $balance;
            }
            update_option('posadzimy_balance', $updated_balance );

			return new Virtual_Product_Value_Object(
				$response->get_data()['certificateUrl'],
				0.0
			);
		} catch ( Exception $e ) {
            \wc_get_logger()->debug( 'Exception: make_virtual_product_order', array( 'source' => 'posadzimy-debug-log' ) );
            \wc_get_logger()->debug( print_r( $e->getMessage(), true), array( 'source' => 'posadzimy-debug-log' ) );
			return null;
		}
	}


	/**
	 * @param WC_Order $order
	 *
	 * @return bool
	 */
	public function should_make_virtual_product_order( WC_Order $order ): bool {
		$from_meta = get_post_meta( $order->get_id(),
			self::get_threshold_amount_exceed_meta_id() );
		if ( is_array( $from_meta ) && isset( $from_meta[0] ) ) {
			return $from_meta[0] === App::META_VALUE_TRUE;
		}

		return false;
	}

	/**
	 * @return string
	 */
	public static function get_threshold_amount_exceed_meta_id(): string {
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
