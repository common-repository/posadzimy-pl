<?php


namespace Inspire_Labs\Posadzimy\Utils;


use Exception;
use WC_Customer;
use WC_Order;

class Utils {

	/**
	 * @param WC_Customer $customer
	 *
	 * @return string
	 */
	public function get_formatted_customer_name( WC_Customer $customer
	): string {

		return $customer->get_first_name();
	}

	/**
	 * @param WC_Order $order
	 *
	 * @return string
	 * @throws Exception
	 */
	public function get_formatted_customer_name_from_order( WC_Order $order
	): string {
		$customer = new WC_Customer( $order->get_customer_id() );

		return 0 === $customer->get_id()
			? $order->get_billing_first_name()
			: $customer->get_first_name();
	}

	/**
	 * @param WC_Customer $customer
	 *
	 * @return string
	 */
	public function get_formatted_customer_full_name( WC_Customer $customer
	): string {
		$return = get_user_meta( $customer->get_id(),
			'shipping_first_name',
			true );
		$return .= ' ';
		$return .= get_user_meta( $customer->get_id(),
			'shipping_last_name',
			true );

		return $return;
	}

	/**
	 * @param WC_Order $order
	 *
	 * @return string
	 * @throws Exception
	 */
	public function get_customer_email_from_order( WC_Order $order ): string {
        /*
		$customer = new WC_Customer( $order->get_customer_id() );

         return false === $customer instanceof WC_Customer
			? $order->get_billing_email()
			: $customer->get_email();*/

		return $order->get_billing_email();
	}
}
