<?php


namespace Inspire_Labs\Posadzimy\Api_Client;


class Response_Value_Object {

	private const STATUS_OK = 200;

	/**
	 * @var int
	 */
	private $status;

	/**
	 * @var array|null
	 */
	private $data;

	/**
	 * @var
	 */
	private $message;

	/**
	 * @var Request_Value_Object_Interface
	 */
	private $request;

	/**
	 * @var array
	 */
	private $raw_response;

	/**
	 * Response_Value_Object constructor.
	 *
	 * @param int $status
	 * @param array|null $data
	 * @param $message
	 * @param Request_Value_Object_Interface $raw_request
	 * @param array|null $raw_response
	 */
	public function __construct(
		int $status,
		?array $data,
		$message,
		Request_Value_Object_Interface $raw_request,
		?array $raw_response

	) {
		$this->status       = $status;
		$this->data         = $data;
		$this->message      = $message;
		$this->request      = $raw_request;
		$this->raw_response = $raw_response;

	}

	/**
	 * @return int
	 */
	public function get_status(): int {
		return $this->status;
	}

	/**
	 * @return array|null
	 */
	public function get_data(): ?array {
		return $this->data;
	}

	/**
	 * @return mixed
	 */
	public function get_message() {
		return $this->message;
	}

	public function is_success(): bool {
		return 200 === $this->status;
	}

	/**
	 * @return Request_Value_Object_Interface
	 */
	public function get_request(): Request_Value_Object_Interface {
		return $this->request;
	}

	/**
	 * @return array
	 */
	public function get_raw_response(): ?array {
		return $this->raw_response;
	}
}
