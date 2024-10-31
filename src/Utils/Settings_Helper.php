<?php


namespace Inspire_Labs\Posadzimy\Utils;


class Settings_Helper {

	/**
	 * @var array
	 */
	private $options;

	/**
	 * Short description
	 *
	 * @param string $key
	 *
	 * @return false|mixed|void
	 */
	public function get_option( $key ) {
		return get_option( $key );
	}

	private function get_options() {

	}
}
