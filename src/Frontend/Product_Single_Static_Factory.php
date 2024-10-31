<?php


namespace Inspire_Labs\Posadzimy\Frontend;


use Inspire_Labs\Posadzimy\Utils\Cart_Helper;
use Inspire_Labs\Posadzimy\Utils\Cart_Helper_Static_Factory;

class Product_Single_Static_Factory {
	public static function create_service(): Product_Single {
		return new Product_Single(
			Cart_Helper_Static_Factory::create_service()
		);
	}
}
