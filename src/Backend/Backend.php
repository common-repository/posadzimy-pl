<?php


namespace Inspire_Labs\Posadzimy\Backend;

use Exception;
use Inspire_Labs\Posadzimy\Api_Client\Client_Static_Factory;
use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Utils\Config_Validator;
use Inspire_Labs\Posadzimy\Utils\Credit_Balance;

/**
 * Class Backend
 */
class Backend {

	/**
	 * @var Config_Validator
	 */
	private $config_validator;
	/**
	 * @var Alerts
	 */
	private $alerts;
	/**
	 * @var Credit_Balance
	 */
	private $credit_balance;

	/**
	 * Backend constructor.
	 *
	 * @param Config_Validator $config_validator
	 * @param Alerts $alerts
	 * @param Credit_Balance $credit_balance
	 */
	public function __construct(
		Config_Validator $config_validator,
		Alerts $alerts,
		Credit_Balance $credit_balance
	) {
		$this->config_validator = $config_validator;
		$this->alerts           = $alerts;
		$this->credit_balance   = $credit_balance;
	}


	/**
	 * Short description
	 */
	public function init() {
		$config_errors = $this->config_validator->get_errors();
		if ( empty( $config_errors ) ) {
			$this->init_backend_features();
		}
        $this->add_plugin_action_links();
		$this->enqueue_scripts();
		$this->init_settings();

		$this->alerts->add_error( $config_errors );

		$role_object = get_role( 'shop_manager' );
		$role_object->add_cap( 'manage_postman_logs' );
		$role_object->add_cap( 'postman/manage-options' );
		$role_object->add_cap( 'manage-options' );


	}

	private function enqueue_scripts() {
		add_action( 'admin_enqueue_scripts', function () {
			wp_enqueue_style(
				'posadzimy_admin_css',
				POSADZIMY_PLUGIN_URL . '/assets/css/admin.css',
				false,
				rand( 1, 9999 ) );
		} );

		add_action( 'admin_enqueue_scripts', function () {
			wp_enqueue_style(
				'posadzimy_lightbox_css',
				POSADZIMY_PLUGIN_URL . '/assets/js/lightbox/glightbox.min.css',
				false,
				rand( 1, 9999 ) );
		} );

		add_action( 'admin_enqueue_scripts', function () {
			wp_enqueue_script(
				'posadzimy_lightbox',
				POSADZIMY_PLUGIN_URL . '/assets/js/lightbox/glightbox.min.js',
				'jquery',
				rand( 1, 9999 ) );
		} );

		add_action( 'admin_enqueue_scripts', function () {
			wp_enqueue_script(
				'posadzimy_admin',
				POSADZIMY_PLUGIN_URL . '/assets/js/admin.js',
				'jquery',
				rand( 1, 9999 ) );
		} );
	}

	/**
	 * Short description
	 * @throws Exception
	 */
	private function init_backend_features() {

		$this->add_woocommerce_plugin_submenu();
		$this->redirect_to_settings_page_after_activate();

		add_action( 'woocommerce_order_status_processing',
			function ( $order_id ) {
				$order = Order_Static_Factory::create_service();
				$order->execute_business_logic( $order_id );
				//$this->credit_balance->update_status();
			},
			1 );


		add_action( 'woocommerce_order_status_completed',
			function ( $order_id ) {
				$order = Order_Static_Factory::create_service();
				$order->execute_business_logic( $order_id );
				//$this->credit_balance->update_status();
			},
			1 );
	}

    private function add_plugin_action_links() {
        add_filter( 'plugin_action_links_' . POSADZIMY_PLUGIN_BASENAME, function ( $links ) {
            $links[] = '<a href="' .
                App::get_settings_page() .
                '">' . __( 'Settings' ) . '</a>';
            $links[] = '<a target="_blank" href="https://posadzimy.pl/automatyzacje/woocommerce/">' . __( 'Technically support and help', App::TEXTDOMAIN ) . '</a>';

            return $links;
        } );
    }


	private function add_woocommerce_plugin_submenu() {
		add_action( 'admin_menu', function () {
			add_submenu_page(
				'woocommerce',
				__( 'Posadzimy', App::TEXTDOMAIN ),
				__( 'Posadzimy', App::TEXTDOMAIN ),
				'manage_woocommerce',
				'posadzimy-submenu',
				function () {
					wp_safe_redirect( App::get_settings_page(), 301 );
					exit;
				}
			);
		} );
	}


	private function redirect_to_settings_page_after_activate() {
		register_activation_hook( POSADZIMY_PLUGIN_BASENAME, function () {
			add_option( 'posadzimy_do_activation_redirect', true );
		} );

		add_action( 'admin_init', function () {
			if ( get_option( 'posadzimy_do_activation_redirect', false ) ) {
				delete_option( 'posadzimy_do_activation_redirect' );
				exit( wp_redirect( App::get_settings_page() ) );
			}
		} );
	}

	/**
	 * Short description
	 * @throws Exception
	 */
	private function init_settings() {
		add_filter( 'woocommerce_get_settings_pages', function ( $settings ) {
			$settings[] = Settings_Static_Factory::create_service();

			return $settings;
		}, 100 );

        $file = POSADZIMY_PLUGIN_BASENAME;
        add_action( 'deactivate_' . $file,  function() {
            wp_clear_scheduled_hook( 'posadzimy_balance_cron_update' );
        } );
	}
}
