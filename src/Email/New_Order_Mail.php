<?php


namespace Inspire_Labs\Posadzimy\Email;

use Inspire_Labs\Posadzimy\Backend\Settings;
use Inspire_Labs\Posadzimy\Utils\Order_Helper;
use Inspire_Labs\Posadzimy\Virtual_Product\Virtual_Product_Value_Object;
use WC_Order;
use Inspire_Labs\Posadzimy\App;

class New_Order_Mail {

	private const NO_VIRTUAL_PRODUCT_IN_CART = null;

	/**
	 * @var Order_Helper
	 */
	private $order_helper;


	/**
	 * New_Order_Mail constructor.
	 *
	 * @param Order_Helper $order
	 */
	public function __construct( Order_Helper $order ) {
		add_action( 'woocommerce_email_order_meta',
			[ $this, "print_virtual_product_info" ],
			10,
			3 );
		$this->order_helper = $order;
	}

	/**
	 * @param WC_Order $wc_order
	 * @param $sent_to_admin
	 * @param $plain_text
	 */
	public function print_virtual_product_info(
		WC_Order $wc_order,
		$sent_to_admin,
		$plain_text
	): void {


		if ( 'processing' === $wc_order->get_status()
		     || 'completed' === $wc_order->get_status() ) {

			$virtual_product = $this->order_helper
				->get_virtual_product_from_order( $wc_order );

			if ( self::NO_VIRTUAL_PRODUCT_IN_CART === $virtual_product ) {
				return;
			}


			$notice = App::get_settings()
			             ->get_option(
				             Settings::POST_ORDER_EMAIL_EXTRA_SECTION_CONTENT
			             );

			$notice = $this->add_virtual_product_url_to_notice(
				$notice,
				$virtual_product );

			echo "<div style='margin-bottom: 40px'>";
			echo wp_kses_post( $notice );
			echo "</div>";

			return;
		}

	}

	/**
	 * @param string $notice
	 * @param Virtual_Product_Value_Object $virtual_product
	 *
	 * @return string
	 */
	private function add_virtual_product_url_to_notice(
		string $notice
		,
		Virtual_Product_Value_Object $virtual_product
	): string {

		$url = sprintf( '<a href="%s"><b>%s</b></a>'
			,
            esc_url( $virtual_product->get_url() ),
			'link'
		);

		return str_replace( '{{link}}',
			$url
			,
			$notice
		);
	}
}
