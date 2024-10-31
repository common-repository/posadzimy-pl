<?php


namespace Inspire_Labs\Posadzimy\Utils;


use Inspire_Labs\Posadzimy\Frontend\Order;
use Inspire_Labs\Posadzimy\Virtual_Product\Virtual_Product_Value_Object;
use WC_Order;

class Order_Helper {

	/**
	 * @param WC_Order $order
	 *
	 * @return Virtual_Product_Value_Object|null
	 */
	public function get_virtual_product_from_order( WC_Order $order
	): ?Virtual_Product_Value_Object {
		$from_meta = get_post_meta( $order->get_id(),
			Order::get_meta_virtual_product_id() );
		if ( is_array( $from_meta ) && isset( $from_meta[0] ) ) {
			return $from_meta[0] instanceof Virtual_Product_Value_Object
				? $from_meta[0]
				: null;
		}

		return null;
	}
}
