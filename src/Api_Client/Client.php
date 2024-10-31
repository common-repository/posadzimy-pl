<?php


namespace Inspire_Labs\Posadzimy\Api_Client;


use \Exception;
use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Backend\Alerts;
use Inspire_Labs\Posadzimy\Backend\Settings;
use Inspire_Labs\Posadzimy\Utils\Config_Validator;
use mysql_xdevapi\Result;
use stdClass;
use WP_Error;

class Client {

	private const ENDPOINT_CHECK_CREDIT_BALANCE = 'https://api.posadzimy.pl/api/integration/check_credit_balance';

	private const ENDPOINT_MAKE_ORDER = 'https://api.posadzimy.pl/api/integration/make_order';

	private const ENDPOINT_CUSTOMER_MAIL_CONTENT = 'https://api.posadzimy.pl/api/integration/customer_mail_content';

    private const ENDPOINT_HELP_CONTENT = 'https://xbwk-kaew-lop4.f2.xano.io/api:cKWVK4i7/wordpress-desc-old';


    /**
	 * @var Alerts
	 */
	private $alerts;
	/**
	 * @var Auth
	 */

	private $auth;

	/**
	 * @var Auth
	 */


	/**
	 * Client constructor.
	 *
	 * @param Auth $auth
	 * @param Alerts $alerts
	 */
	public function __construct( Auth $auth, Alerts $alerts ) {
		$this->auth   = $auth;
		$this->alerts = $alerts;
	}


	/**
	 * @param string $tree_group_id
	 *
	 * @return int
	 * @throws Exception
	 */
	public function get_credit_balance( string $tree_group_id ): int {
        $config_validator = new Config_Validator();
        $config_errors = $config_validator->get_errors();
        if ( empty( $config_errors ) ) {
            $payload = wp_json_encode([
                'treeGroupID' => $tree_group_id,
                'source'      => 'woocommerce-plugin-old'
            ]);

            $request = $this->prepare_post_request(
                self::ENDPOINT_CHECK_CREDIT_BALANCE,
                $payload
            );
            $response = $this->execute_request($request);

            if ( is_object( $response ) ) {
                if ($response->get_status() !== 200) {
                    $this->alerts->add_error(
                        __('Posadzimy.pl: Failed to get balance. Check the API credentials', app::TEXTDOMAIN)
                    );

                    return 0;
                }
                return $response->get_data()['creditsBalance'];

            } else {
                $this->alerts->add_error(
                    __('Posadzimy.pl: Failed to get balance. API error', app::TEXTDOMAIN)
                );
                return 0;
            }
        }
        return 0;
	}

	/**
	 * @param string $customer_name
	 * @param string $cert_text
	 * @param string $tree_group_id
	 * @param int $order_id
	 *
	 * @return Response_Value_Object
	 * @throws Exception
	 */
	public function make_order(
		string $customer_name,
		string $cert_text,
		string $tree_group_id,
		int $order_id
	): Response_Value_Object {
		
		$cert_text = str_replace(
            [
                '{{imie}}',
                '{{numerZamowienia}}',
            ],
            [
                $customer_name,
                $order_id,
            ]
            ,
            $cert_text
        );
		
		$payload = wp_json_encode( [
			'customerName'    => $customer_name,
			'certificateText' => $cert_text,
			'treeGroupID'     => $tree_group_id,
            'source'          => 'woocommerce-plugin-old'
		] );

		$request = $this->prepare_post_request(
			self::ENDPOINT_MAKE_ORDER,
			$payload
		);

		$response = $this->execute_request( $request );

		if ( $response->get_status() !== 201 ) {
            \wc_get_logger()->debug( 'Exception: make_order', array( 'source' => 'posadzimy-debug-log' ) );
            \wc_get_logger()->debug( print_r( $response->get_message(), true), array( 'source' => 'posadzimy-debug-log' ) );
			throw new Exception( $response->get_message() );
		}

		return $response;
	}

	/**
	 * @param string $customer_name
	 * @param string $custom_text
	 * @param string $shop_name
	 * @param string $virtual_product_url
	 * @param string $plant_name
	 * @param string $tree_group_id
	 *
	 * @return Response_Value_Object
	 * @throws Exception
	 */
	public function customer_mail_content(
		string $customer_name,
		string $custom_text,
		string $shop_name,
		string $virtual_product_url,
		string $plant_name


	): Response_Value_Object {

		$payload = wp_json_encode( [
			'customerName'      => $customer_name,
			'customText'        => $custom_text,
			'shopName'          => $shop_name,
			'linkToCertificate' => $virtual_product_url,
			'plantName'         => $plant_name,
            'source'            => 'woocommerce-plugin-old'
		] );

		$request = $this->prepare_post_request
		(
			self::ENDPOINT_CUSTOMER_MAIL_CONTENT,
			$payload
		);

		$response = $this->execute_request( $request );

		if ( ! $this->is_success( $response->get_status() ) ) {
            \wc_get_logger()->debug( 'Exception: customer_mail_content', array( 'source' => 'posadzimy-debug-log' ) );
            \wc_get_logger()->debug( print_r( $response->get_message(), true), array( 'source' => 'posadzimy-debug-log' ) );
			throw new Exception( $response->get_message() );
		}

		return $response;
	}


	/**
	 * @param array|WP_Error $response
	 *
	 * @return array|null
	 * @throws Exception
	 */
	private function extract_data_from_response( $response ): ?stdClass {
		if ( $response instanceof WP_Error ) {
            \wc_get_logger()->debug( 'Exception: extract_data_from_response', array( 'source' => 'posadzimy-debug-log' ) );
            \wc_get_logger()->debug( print_r( $response->get_error_message(), true), array( 'source' => 'posadzimy-debug-log' ) );
			throw new Exception( $response->get_error_message() );
		}

		if ( ! isset( $response['body'] ) ) {
            \wc_get_logger()->debug( 'Exception: extract_data_from_response - Missing body in response', array( 'source' => 'posadzimy-debug-log' ) );
            \wc_get_logger()->debug( print_r( $response, true), array( 'source' => 'posadzimy-debug-log' ) );
			throw new Exception( 'api Missing body in response' );
		}

		if ( ! is_array( $response ) ) {
            \wc_get_logger()->debug( 'Exception: extract_data_from_response - not array', array( 'source' => 'posadzimy-debug-log' ) );
            \wc_get_logger()->debug( print_r( $response, true), array( 'source' => 'posadzimy-debug-log' ) );
			throw new Exception( 'api error' );
		}

		$responseObj = json_decode( $response['body'] );

		if ( ! is_array( $responseObj ) ) {
            \wc_get_logger()->debug( 'Exception: extract_data_from_response - not array responseObj', array( 'source' => 'posadzimy-debug-log' ) );
            \wc_get_logger()->debug( print_r( $response['body'], true), array( 'source' => 'posadzimy-debug-log' ) );
			throw new Exception( 'api error' );
		}

		if ( $responseObj->status !== 200 ) {
            \wc_get_logger()->debug( 'Exception: extract_data_from_response - status not 200', array( 'source' => 'posadzimy-debug-log' ) );
            \wc_get_logger()->debug( print_r( $responseObj->status, true), array( 'source' => 'posadzimy-debug-log' ) );
			throw new Exception( 'api error: '
			                     . $responseObj->status . ' Message: '
			                     . $responseObj->message
			);
		}

		return $responseObj;
	}

	/**
	 * @param string $endpoint
	 * @param string|null $payload
	 *
	 * @return Request_Get_Value_Object
	 */
	private function prepare_get_request(
		string $endpoint
	): Request_Get_Value_Object {

		return new Request_Get_Value_Object( $endpoint );
	}

	/**
	 * @param string $endpoint
	 * @param string $json_payload
	 *
	 * @return Request_Post_Value_Object
	 */
	private function prepare_post_request(
		string $endpoint,
		string $json_payload
	): Request_Post_Value_Object {
		return new Request_Post_Value_Object(
			$endpoint,
			$json_payload
		);
	}

	/**
	 * @param Request_Value_Object_Interface $request
	 *
	 * @return Response_Value_Object
	 * @throws Exception
	 */
	private function execute_request( Request_Value_Object_Interface $request
	): Response_Value_Object {
		$api_secret = $this->auth->getApiSecret();
		if ( $request instanceof Request_Get_Value_Object ) {
			$result = wp_remote_get(
				$request->get_endpoint_url(),
				[
					'headers' => [
						'X-AUTH-TOKEN' => $api_secret,
					],
				]
			);
		}

		if ( $request instanceof Request_Post_Value_Object ) {
			$result = wp_remote_post(
				$request->get_endpoint_url(),
				[
					'headers' => [
						'X-AUTH-TOKEN' => $api_secret,
						'data_format'  => 'body',
						'method'       => 'POST',
					],
					'body'    => $request->get_payload(),
                    'timeout' => 30
				]
			);
		}

		$raw_response_parsed = json_decode( wp_remote_retrieve_body( $result ) );

		if ( empty( $raw_response_parsed ) ) {
            $this->alerts->add_error(
                __( 'Posadzimy.pl: Api request error', App::TEXTDOMAIN )
            );
            throw new Exception( 'api request error' );
        }

		return $this->prepare_response( $raw_response_parsed, $request, $result );
	}

	/**
	 * @param $raw_response_parsed
	 * @param Request_Value_Object_Interface $request
	 * @param $raw_response
	 *
	 * @return Response_Value_Object
	 */
	private function prepare_response(
		$raw_response_parsed
		,
		Request_Value_Object_Interface $request,
		$raw_response
	): Response_Value_Object {

		return new Response_Value_Object(
			$raw_response_parsed->status,
			isset( $raw_response_parsed->data )
				? (array) $raw_response_parsed->data
				: null,
			isset( $raw_response_parsed->message )
				? $raw_response_parsed->message
				: null,
			$request,
			$raw_response
		);
	}

	/**
	 * @param mixed $status
	 *
	 * @return bool
	 */
	private function is_success( $status ): bool {
		return 201 === $status || 200 === $status;
	}


    /**
     *
     * @return string
     * @throws Exception
     */
    public function get_help_content(): string {

        try {

            $response = wp_remote_get(self::ENDPOINT_HELP_CONTENT );

            if ( ! is_wp_error( $response ) ) {
                return json_decode( wp_remote_retrieve_body( $response ) );
            }

            return null;

        } catch ( Exception $e ) {
            \wc_get_logger()->debug( 'Exception: get_help_content', array( 'source' => 'posadzimy-debug-log' ) );
            \wc_get_logger()->debug( print_r( $e->getMessage(), true), array( 'source' => 'posadzimy-debug-log' ) );

            return $e->getMessage();
        }

    }
}
