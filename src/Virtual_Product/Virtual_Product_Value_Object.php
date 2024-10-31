<?php


namespace Inspire_Labs\Posadzimy\Virtual_Product;


class Virtual_Product_Value_Object {

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var float
	 */
	private $threshold_amount;

	/**
	 * Virtual_Product_Value_Object constructor.
	 *
	 * @param string $url
	 * @param float $threshold_amount
	 */
	public function __construct( string $url, float $threshold_amount ) {
		$this->url              = $url;
		$this->threshold_amount = $threshold_amount;
	}

	/**
	 * @return string
	 */
	public function get_url(): string {
		return $this->url;
	}

	/**
	 * @return float
	 */
	public function get_threshold_amount(): float {
		return $this->threshold_amount;
	}
}
