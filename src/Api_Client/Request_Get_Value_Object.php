<?php


namespace Inspire_Labs\Posadzimy\Api_Client;


use Exception;

class Request_Get_Value_Object implements Request_Value_Object_Interface {

	/**
	 * @var string
	 */
	private $url;

	/**
	 * Request_Value_Object constructor.
	 *
	 * @param string $url
	 */
	public function __construct( string $url ) {
		$this->url = $url;
	}

	/**
	 * @return string
	 */
	public function get_endpoint_url(): string {
		return $this->url;
	}
}
