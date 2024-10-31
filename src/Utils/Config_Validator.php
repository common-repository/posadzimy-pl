<?php


namespace Inspire_Labs\Posadzimy\Utils;


use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Backend\Settings as Backend_Settings;

class Config_Validator {

	/**
	 * Short description
	 *
	 * @return array
	 */
	public function get_errors(): array {
		$errors = false;

		if ( ! $this->check_api_id() ) {
			$errors = true;
		}

		if ( ! $this->check_api_secret() ) {
			$errors = true;
		}

		return $errors
			? [
				__( 'Posadzimy.pl - Nieprawidłowa konfiguracja interfejsu API. Podaj prawidłowy KLUCZ API i Plant ID.',
					APP::TEXTDOMAIN ),
			]
			: [];
	}

	/**
	 * Short description
	 *
	 * @return bool
	 */
	private function check_api_id(): bool {
		$id = App::get_settings()->get_option(
			Backend_Settings::API_ID
		);

		return ! empty( $id );
	}

	/**
	 * Short description
	 *
	 * @return bool
	 */
	private function check_api_secret(): bool {
		$secret = App::get_settings()->get_option(
			Backend_Settings::API_SECRET
		);

		return ! empty( $secret );
	}

	private function check_api_conection() {
	}
}
