<?php


namespace Inspire_Labs\Posadzimy\Api_Client;


use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Backend\Settings as Backend_Settings;

class Auth {

	/**
	 * @return string
	 */
	public function getApiId(): string {
		return App::get_settings()->get_option(
			Backend_Settings::API_ID );
	}

	/**
	 * @return string
	 */
	public function getApiSecret(): string {
		return App::get_settings()->get_option(
			Backend_Settings::API_SECRET );
	}
}
