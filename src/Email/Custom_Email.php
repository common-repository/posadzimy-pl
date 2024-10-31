<?php


namespace Inspire_Labs\Posadzimy\Email;


use Exception;
use Inspire_Labs\Posadzimy\Api_Client\Client;
use Inspire_Labs\Posadzimy\Backend\Settings;
use Inspire_Labs\Posadzimy\Backend\Settings as Backend_Settings;
use Inspire_Labs\Posadzimy\Utils\Order_Helper;
use WC_Order;
use Inspire_Labs\Posadzimy\App;

class Custom_Email {

	private const NO_VIRTUAL_PRODUCT_IN_CART = null;

	/**
	 * @var Order_Helper
	 */
	private $order_helper;
	/**
	 * @var Client
	 */
	private $client;


	/**
	 * Custom_Email constructor.
	 *
	 * @param Order_Helper $order_helper
	 * @param Client $client
	 */
	public function __construct(
		Order_Helper $order_helper,
		Client $client
	) {
		$this->order_helper = $order_helper;
		$this->client       = $client;
	}

	/**
	 * @param WC_Order $wc_order
	 *
	 * @return bool
	 * @throws Exception
	 */
	public function execute( WC_Order $wc_order ): bool {
		if ( 'checkout_module_enabled' !== App::get_settings()->get_option(
			Settings::ENABLE_POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER )
		) {

			return false;
		}

		if ( 'processing' === $wc_order->get_status()
		     || 'completed' === $wc_order->get_status() ) {

			$virtual_product = $this->order_helper
				->get_virtual_product_from_order( $wc_order );

			if ( self::NO_VIRTUAL_PRODUCT_IN_CART === $virtual_product ) {
				return false;
			}

			if ( $this->is_custom_mail_sent( $wc_order ) ) {
				return false;
			}


			try {
				$response = $this->client->customer_mail_content(
					App::get_utils()
					   ->get_formatted_customer_name_from_order( $wc_order ),
					App::get_settings()->get_option(
						Settings::POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER_CONTENT
					),
					get_bloginfo( 'name' ),
					$virtual_product->get_url(),
					App::get_settings()->get_option(
						Settings::API_ID
					)
				);
			} catch ( Exception $e ) {
                \wc_get_logger()->debug( 'Exception: execute', array( 'source' => 'posadzimy-debug-log' ) );
                \wc_get_logger()->debug( print_r( $e->getMessage(), true), array( 'source' => 'posadzimy-debug-log' ) );
				return false;
			}

			$mail_sent = $this->send(
				App::get_utils()->get_customer_email_from_order( $wc_order ),
				App::get_settings()->get_option(
					Settings::POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER_SUBJECT
				),
				$this->filter_api_response( $response->get_data() )
			);

			update_post_meta(
				$wc_order->get_id(),
				self::get_custom_mail_sent_meta_key(),
				app::META_VALUE_TRUE
			);

            if( 'yes' === get_option('woocommerce_custom_orders_table_enabled') ) {
                $order = wc_get_order( $wc_order->get_id() );
                if ( $order && !is_wp_error($order) ) {
                    $order->update_meta_data( self::get_custom_mail_sent_meta_key(), app::META_VALUE_TRUE );
                    $order->save();
                }
            }


			return $mail_sent;

		}
	}

	/**
	 * @param $data
	 *
	 * @return mixed
	 */
	private function filter_api_response( $data ) {
		return $data['mailHTMLContent'];
	}

	/**
	 * @param $recipient
	 * @param $subject
	 * @param $content
	 *
	 * @return bool
	 */
	private function send( $recipient, $subject, $content ): bool {
		$mailer  = WC()->mailer();
		$headers = "Content-Type: text/html\r\n";

		return $mailer->send( $recipient, $subject, $content, $headers );
	}

	/**
	 * @return string
	 */
	public static function get_custom_mail_sent_meta_key(): string {
		return '_' . Backend_Settings::PREFIX
		       . 'custom_email_sent';
	}

	/**
	 * @param WC_Order $order
	 *
	 * @return bool
	 */
	public function is_custom_mail_sent( WC_Order $order ): bool {
		$from_meta = get_post_meta( $order->get_id(),
			self::get_custom_mail_sent_meta_key() );
		if ( is_array( $from_meta ) && isset( $from_meta[0] ) ) {
			return $from_meta[0] === app::META_VALUE_TRUE;
		}

		return false;
	}
}
