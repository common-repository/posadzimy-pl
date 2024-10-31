<?php


namespace Inspire_Labs\Posadzimy\Utils;


use Exception;
use Inspire_Labs\Posadzimy\Api_Client\Client;
use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Backend\Settings;

class Credit_Balance {

	private const BALANCE_VERIFY_STATUS = 'balance_verify_status';

	/**
	 * @var Client
	 */
	private $client;


	/**
	 * Credit_Balance_Static_Factory constructor.
	 *
	 * @param Client $client
	 */
	public function __construct( Client $client ) {
		$this->client = $client;

        add_action( 'posadzimy_balance_cron_update', array( $this, 'posadzimy_balance_cron_update_callback' ), 10 );
        $args = array();
        if ( ! wp_next_scheduled( 'posadzimy_balance_cron_update', $args ) ) {
            $delay = 0;
            wp_schedule_event( time() + $delay, 'daily', 'posadzimy_balance_cron_update' );
        }
	}

	/**
	 * @return bool
	 * @throws Exception
	 */
	 /*
	public function verify_credits(): bool {
		$balance = $this->get_balance_amount();
		$result  = $balance > 0;
		if ( $result ) {
			$this->save_verify_result( App::META_VALUE_TRUE );
		} else {
			$this->save_verify_result( App::META_VALUE_FALSE );
		}

		return $result;
	}
	*/

	/**
	 * @throws Exception
	 */
	 /*
	public function update_status() {
		$this->verify_credits();
	}
	*/

	/**
	 * @return int
	 * @throws Exception
	 */
	public function get_balance_amount(): int {
        try {
            return $this->client->get_credit_balance(App::get_settings()->get_option(
                Settings::API_ID
            ));
        } catch ( Exception $e ) {
            \wc_get_logger()->debug( 'Exception: get_balance_amount', array( 'source' => 'posadzimy-debug-log' ) );
            \wc_get_logger()->debug( print_r( $e->getMessage(), true), array( 'source' => 'posadzimy-debug-log' ) );
            return false;
        }
    }

	/**
	 * @param string $result
	 */
	//private function save_verify_result( string $result ) {
		//update_option( Settings::PREFIX . '_' . self::BALANCE_VERIFY_STATUS, $result );
	//}

	/**
	 * @return bool
	 */
	//public function get_last_verify_result(): bool {
		//$result = get_option( Settings::PREFIX . '_' . self::BALANCE_VERIFY_STATUS );

		//return App::META_VALUE_TRUE === $result;
	//}

    /**
     * Scheduled credit Balance update
     */
    public function posadzimy_balance_cron_update_callback() {

        $balance = $this->get_balance_amount();

        \wc_get_logger()->debug( 'CRON POSADZIMY get_balance_amount: ', array( 'source' => 'posadzimy-cron-log' ) );
        $old_value = get_option('posadzimy_balance');
        \wc_get_logger()->debug( print_r( 'OLD value: ' . $old_value, true), array( 'source' => 'posadzimy-cron-log' ) );
        \wc_get_logger()->debug( print_r( 'NEW value: ' . $balance, true), array( 'source' => 'posadzimy-cron-log' ) );


        $updated_balance = '0.00';
        if( ! empty( $balance ) && is_numeric( $balance ) ) {
            $updated_balance = $balance;
        }

        $res = update_option('posadzimy_balance', $updated_balance );
        if( $res ) {
            \wc_get_logger()->debug( print_r( 'Balance updated', true), array( 'source' => 'posadzimy-cron-log' ) );
        }

    }


}
