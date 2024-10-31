<?php


namespace Inspire_Labs\Posadzimy\Utils;


class Utils_Static_Factory {

	public static function create_service(): Utils {
		return new Utils();
	}
}
