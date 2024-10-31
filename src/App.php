<?php


namespace Inspire_Labs\Posadzimy;

use Exception;
use Inspire_Labs\Posadzimy\Backend\Backend_Static_Factory;
use Inspire_Labs\Posadzimy\Backend\Order;
use Inspire_Labs\Posadzimy\Email\Custom_Email_Static_Factory;
use Inspire_Labs\Posadzimy\Email\New_Order_Mail_Static_Factory;
use Inspire_Labs\Posadzimy\Frontend\Frontend_Static_Factory;
use Inspire_Labs\Posadzimy\Utils\Settings_Helper;
use Inspire_Labs\Posadzimy\Utils\Settings_Static_Factory;
use Inspire_Labs\Posadzimy\Utils\Utils;
use Inspire_Labs\Posadzimy\Utils\Utils_Static_Factory;
use WC_Order;

/**
 * Class App
 *
 * @package Posadzimy
 */
class App {

	const TEXTDOMAIN = 'posadzimy';

	const META_VALUE_TRUE = '1';

	const META_VALUE_FALSE = '0';


	/**
	 * Short description
	 *
	 * @throws Exception
	 */
	public function execute() {
		if ( $this->is_backend() ) {
			$this->execute_backend();
		} else {
			$this->execute_frontend();
		}

		$this->execute_shared_features();
	}

	/**
	 * Short description
	 *
	 * @throws Exception
	 */
	private function execute_backend() {
		$backend = Backend_Static_Factory::create_service();
		$backend->init();
	}

	/**
	 * Short description
	 *
	 * @throws Exception
	 */
	private function execute_frontend() {
		$frontend = Frontend_Static_Factory::create_service();
		$frontend->init();
	}

	/**
	 *
	 * @throws Exception
	 */
	private function execute_shared_features() {
		New_Order_Mail_Static_Factory::create_service();

		add_action( 'woocommerce_order_status_processing',
			function ( $order_id ) {
				$custom_email = Custom_Email_Static_Factory::create_service();
				$custom_email->execute( new WC_Order( $order_id ) );
			},
			101 );


		add_action( 'woocommerce_order_status_completed',
			function ( $order_id ) {
				$custom_email = Custom_Email_Static_Factory::create_service();
				$custom_email->execute( new WC_Order( $order_id ) );
			},
			101 );
	}

	/**
	 * Short description
	 *
	 * @return Settings_Helper
	 */
	public static function get_settings(): Settings_Helper {
		return Settings_Static_Factory::create_service();
	}

	/**
	 * @return Utils
	 */
	public static function get_utils(): Utils {
		return Utils_Static_Factory::create_service();
	}

	/**
	 * @return string
	 */
	public static function get_settings_page(): string {
		return admin_url() . 'admin.php?page=wc-settings&tab=posadzimy';
	}

	/**
	 * @return string
	 */
	public static function get_support_page(): string {
		return admin_url() . 'admin.php?page=wc-settings&tab=posadzimy&section=help';
	}

	/**
	 * Short description
	 *
	 * @return bool
	 */
	private function is_backend(): bool {
		return is_admin();
	}
}
