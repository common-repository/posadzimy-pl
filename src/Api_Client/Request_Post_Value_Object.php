<?php


namespace Inspire_Labs\Posadzimy\Api_Client;


use Exception;

class Request_Post_Value_Object implements Request_Value_Object_Interface {

	/**
	 * @var string
	 */
	private $url;

	/**
	 * @var string
	 */
	private $payload;

	/**
	 * Request_Value_Object constructor.
	 *
	 * @param string $url
	 * @param string $payload
	 */
	public function __construct( string $url, string $payload ) {
		$this->url     = $url;
		$this->payload = $payload;
	}

	/**
	 * @return string
	 */
	public function get_endpoint_url(): string {
		return $this->url;
	}

	/**
	 * @return string
	 */
	public function get_payload(): string {
		return $this->payload;
	}
}
