<?php


namespace Inspire_Labs\Posadzimy\Backend;


class Alerts_Static_Factory {

	/**
	 * Short description
	 *
	 * @return Alerts
	 */
	public static function create_service(): Alerts {
		return new Alerts();
	}
}
