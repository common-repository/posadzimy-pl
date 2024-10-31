<?php


namespace Inspire_Labs\Posadzimy\Backend;

use Exception;
use Inspire_Labs\Empik_Woocommerce\Plugin;
use Inspire_Labs\Empik_Woocommerce\Wp_Admin\Settings_Ids;
use Inspire_Labs\Posadzimy\Api_Client\Client;
use Inspire_Labs\Posadzimy\Api_Client\Client_Static_Factory;
use Inspire_Labs\Posadzimy\App;
use Inspire_Labs\Posadzimy\Utils\Credit_Balance;
use WC_Admin_API_Keys;
use WC_Admin_Settings;
use WC_Admin_Webhooks;
use WC_Settings_Page;

/**
 * Class WC_Settings_Static_Factory
 */
class Settings extends WC_Settings_Page {

	const  PREFIX = 'posadzimy_';

	const ENABLE_POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER = self::PREFIX . 'user_nts_poce_enabled';

	const POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER_CONTENT = self::PREFIX . 'user_nts_poce_content';

	const POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER_SUBJECT = self::PREFIX . 'user_nts_poce_subject';

	const ENABLE_POST_ORDER_EMAIL_EXTRA_SECTION = self::PREFIX . 'user_nts_poees_enabled';

	const POST_ORDER_EMAIL_EXTRA_SECTION_CONTENT = self::PREFIX . 'user_nts_poees_content';

	const CHECKOUT_CUSTOM_CSS = self::PREFIX . 'checkout_custom_css';

	const CHECKOUT_THRESHOLD_AMOUNT_INFO_TEXT = self::PREFIX . 'checkout_threshold_amount_info_text';

	const CHECKOUT_MODULE_ENABLED = self::PREFIX . 'checkout_module_enabled';

	const CART_CUSTOM_CSS = self::PREFIX . 'cart_custom_css';

	const SP_CUSTOM_CSS = self::PREFIX . 'sp_custom_css';

	const CART_THRESHOLD_AMOUNT_INFO_TEXT = self::PREFIX . 'cart_how_much_to_spend_text';

	const SP_THRESHOLD_AMOUNT_INFO_TEXT = self::PREFIX . 'sp_how_much_to_spend_text';

	const CART_MODULE_ENABLED = self::PREFIX . 'cart_module_enabled';

	const SP_MODULE_ENABLED = self::PREFIX . 'sp_module_enabled';

	const API_SECRET = self::PREFIX . 'general_api_key_secret';

	const API_ID = self::PREFIX . 'general_api_id';

	const CERTIFICATE_TEXT = self::PREFIX . 'cert_text';

	const THRESHOLD_AMOUNT_VALUE = self::PREFIX . 'general_threshold_amount_value';

    const THRESHOLD_AMOUNT_VALUE_TYPE = self::PREFIX . 'general_threshold_amount_value_type';

	const CHECKOUT_VIRTUAL_PRODUCT_ADDED_NOTICE = self::PREFIX . 'checkout_vp_added_notice';

	const CART_VIRTUAL_PRODUCT_ADDED_NOTICE = self::PREFIX . 'cart_vp_added_notice';

	const SP_VIRTUAL_PRODUCT_ADDED_NOTICE = self::PREFIX . 'sp_vp_added_notice';

	static $prevent_duplicate = [];

	/**
	 * @var Credit_Balance
	 */
	private $credit_balance;

	/**
	 * Settings constructor.
	 *
	 * @param Credit_Balance $credit_balance
	 *
	 * @throws Exception
	 */
	public function __construct( Credit_Balance $credit_balance ) {
		$this->credit_balance = $credit_balance;
		$this->id             = 'posadzimy';

		$balance     = get_option( 'posadzimy_balance', null );
		$balance     = null === $balance ? '' : ' (' . __( 'Credits number: ', App::TEXTDOMAIN ) . $balance . ')';
		$this->label = __( 'Posadzimy integration', App::TEXTDOMAIN ) . $balance;

		add_action( 'woocommerce_admin_field_posadzimy',
			[ $this, 'email_notification_setting' ] );

		add_action( 'woocommerce_settings_save_' . $this->id,
			[ $this, 'save' ] );

		parent::__construct();
		$this->credit_balance = $credit_balance;
	}

	/**
	 * Get sections.
	 *
	 * @return array
	 */
	public function get_sections() {
		$sections = [
			''     => __( 'Settings', app::TEXTDOMAIN ),
			'help' => __( 'Help', app::TEXTDOMAIN ),
		];

		return apply_filters( 'woocommerce_get_sections_' . $this->id,
			$sections );
	}


	/**
	 * @param $sections
	 *
	 * @return array
	 */
	public function get_sections_posadzimy( $sections ): array {
		$sections['settings'] = __( 'Settings', app::TEXTDOMAIN );
		$sections['help']     = __( 'Help', app::TEXTDOMAIN );

		return $sections;
	}

	/**
	 * Short description
	 *
	 * @param array $settings_tabs
	 *
	 * @return array
	 */
	public function add_settings_tab( array $settings_tabs ): array {
		$settings_tabs['settings_tab_posadzimy'] = __( 'Posadzimy',
			'woocommerce-settings-tab-demo' );

		return $settings_tabs;
	}


	/**
	 * Short description
	 *
	 * @return void
	 */
	/*public function render_settings() {
		woocommerce_admin_fields( $this->get_settings_config() );
	}

	public function update_settings() {
		woocommerce_update_options( self::get_settings_config() );
	}*/

	/**
	 * Get settings array.
	 *
	 * @param string $current_section
	 *
	 * @return array
	 * @throws Exception
	 */
	public function get_settings( $current_section = '' ): array {

		if ( empty( $current_section )
		     || 'settings' === $current_section ) {
			return [
				self::PREFIX . 'general_section_start' => [
					'name' => __( 'General settings', APP::TEXTDOMAIN ),
					'type' => 'title',
					'id'   => self::PREFIX . 'general_section_start',
				],

				self::THRESHOLD_AMOUNT_VALUE => [
					'name' => __( 'Minimum order value', APP::TEXTDOMAIN ),
					'type' => 'number',
					'desc' => __( '', APP::TEXTDOMAIN ),
					'id'   => self::THRESHOLD_AMOUNT_VALUE,
				],

                self::THRESHOLD_AMOUNT_VALUE_TYPE => [
                    'name'    => __( 'Brutto or netto?',
                        APP::TEXTDOMAIN ),
                    'type'    => 'radio',
                    'options' => [
                        '1' => __( 'Brutto', APP::TEXTDOMAIN ),
                        '0' => __( 'Netto', APP::TEXTDOMAIN ),

                    ],
                    'default' => $this->get_default_tax_settings(),
                    'desc'    => __( '', APP::TEXTDOMAIN ),
                    'id'      => self::THRESHOLD_AMOUNT_VALUE_TYPE,
                ],

				self::API_SECRET => [
					'name' => __( 'API Key', APP::TEXTDOMAIN ),
					'type' => 'text',
					'desc' => __( 'The API Secret key can be found in the Posadzimy.pl customer panel, in the \'API module\' tab',
						APP::TEXTDOMAIN ),
					'id'   => self::API_SECRET,
				],

				self::API_ID => [
					'name' => __( 'Plant ID', APP::TEXTDOMAIN ),
					'type' => 'text',
					'desc' => __( "The Plant ID can be found in the Posadzimy.pl customer panel, in the 'API module' tab",
						APP::TEXTDOMAIN ),
					'id'   => self::API_ID,
				],

				self::PREFIX . 'general_section_end' => [
					'type' => 'sectionend',
					'id'   => self::PREFIX . 'general_section_end',
				],


				self::PREFIX . 'general_cert_section_start' => [
					'name' => __( 'Certificate generating settings', APP::TEXTDOMAIN ),
					'type' => 'title',
					'id'   => self::PREFIX . 'general_cert_section_start',
				],
				$this->create_lightbox_header(
					__( 'Click and show example', APP::TEXTDOMAIN ),
					'https://static.posadzimy.pl/integrations/woocommerce/certyfikat-woocommerce.jpg',
					'7'
				),

				self::CERTIFICATE_TEXT => [
					'name' => __( 'Certificate settings', APP::TEXTDOMAIN ),
					'type' => 'textarea',
					'desc' => __( 'Custom text visible on the certificate. You can use {{imie}} and {{numerZamowienia}} variables. For example, "{{imie}} - as a thank you for shopping in our store, we planted a tree for you!"', App::TEXTDOMAIN ),
                    'default' => __( '{{imie}} - as a thank you for shopping in our store, we planted a tree for you!', App::TEXTDOMAIN ),
					'id'   => self::CERTIFICATE_TEXT,
				],

				self::PREFIX . 'general_cert_section_end' => [
					'type' => 'sectionend',
					'id'   => self::PREFIX . 'general_cert_section_end',
				],

				self::PREFIX . 'sp_section_start' => [
					'name' => __( 'Single product settings', APP::TEXTDOMAIN ),
					'type' => 'title',
					'id'   => self::PREFIX . 'sp_section_start',
				],
				$this->create_lightbox_header(
					__( 'Click and show example', APP::TEXTDOMAIN ),
					'https://static.posadzimy.pl/integrations/woocommerce/powiadomienie-produkt.jpg',
					'1'
				),

				self::SP_MODULE_ENABLED             => [
					'name'    => __( 'Enable or disable single product module',
						APP::TEXTDOMAIN ),
					'type'    => 'radio',
					'options' => [
						'1' => __( 'Yes', APP::TEXTDOMAIN ),
						'0' => __( 'No', APP::TEXTDOMAIN ),

					],
					'desc'    => __( '', APP::TEXTDOMAIN ),
					'id'      => self::SP_MODULE_ENABLED,
				],
				self::SP_THRESHOLD_AMOUNT_INFO_TEXT => [
					'name'    => __( 'Threshold amount info', APP::TEXTDOMAIN ),
					'type'    => 'text',
					'desc'    => __( 'You can use the {{wysokosc_zamowienia}} variable to show the required amount, and the {{brakujaca_kwota}} variable to show what value is missing',
						APP::TEXTDOMAIN ),
					'default' => '',
					'id'      => self::SP_THRESHOLD_AMOUNT_INFO_TEXT,
					'class'   => 'posadzimy_input_long',
				],

				self::SP_VIRTUAL_PRODUCT_ADDED_NOTICE => [
					'name'    => __( 'Virtual product added notice',
						APP::TEXTDOMAIN ),
					'type'    => 'text',
					'default' => __( 'Congratulations! You got a virtual product!',
						APP::TEXTDOMAIN ),
					'desc'    => __( '', APP::TEXTDOMAIN ),
					'id'      => self::SP_VIRTUAL_PRODUCT_ADDED_NOTICE,
					'class'   => 'posadzimy_input_long',
				],

				self::SP_CUSTOM_CSS             => [
					'name'  => __( 'Custom CSS', APP::TEXTDOMAIN ),
					'type'  => 'textarea',
					'desc'  => __( 'Set custom CSS code', APP::TEXTDOMAIN ),
					'id'    => self::SP_CUSTOM_CSS,
					'class' => 'posadzimy_input_long',
				],
				self::PREFIX . 'sp_section_end' => [
					'type' => 'sectionend',
					'id'   => self::PREFIX . 'sp_section_end',
				],


				self::PREFIX . 'cart_section_start' => [
					'name' => __( 'Cart settings', APP::TEXTDOMAIN ),
					'type' => 'title',
					'id'   => self::PREFIX . 'cart_section_start',
				],
				$this->create_lightbox_header(
					__( 'Click and show example', APP::TEXTDOMAIN ),
					'https://static.posadzimy.pl/integrations/woocommerce/powiadomienie-koszyk.jpg',
					'2'
				),

				self::CART_MODULE_ENABLED             => [
					'name'    => __( 'Enable or disable cart module',
						APP::TEXTDOMAIN ),
					'type'    => 'radio',
					'options' => [
						'1' => __( 'Yes', APP::TEXTDOMAIN ),
						'0' => __( 'No', APP::TEXTDOMAIN ),

					],
					'desc'    => __( '', APP::TEXTDOMAIN ),
					'id'      => self::CART_MODULE_ENABLED,
				],
				self::CART_THRESHOLD_AMOUNT_INFO_TEXT => [
					'name'    => __( 'Threshold amount info', APP::TEXTDOMAIN ),
					'type'    => 'text',
					'desc'    => __( 'You can use the {{wysokosc_zamowienia}} variable to show the required amount, and the {{brakujaca_kwota}} variable to show what value is missing',
						APP::TEXTDOMAIN ),
					'default' => '',
					'class'   => 'posadzimy_input_long',
					'id'      => self::CART_THRESHOLD_AMOUNT_INFO_TEXT,
				],

				self::CART_VIRTUAL_PRODUCT_ADDED_NOTICE => [
					'name'    => __( 'Virtual product added notice',
						APP::TEXTDOMAIN ),
					'type'    => 'text',
					'default' => __( 'Congratulations! You got a virtual product!',
						APP::TEXTDOMAIN ),
					'desc'    => __( '', APP::TEXTDOMAIN ),
					'id'      => self::CART_VIRTUAL_PRODUCT_ADDED_NOTICE,
					'class'   => 'posadzimy_input_long',
				],

				self::CART_CUSTOM_CSS             => [
					'name'  => __( 'Custom CSS', APP::TEXTDOMAIN ),
					'type'  => 'textarea',
					'desc'  => __( '', APP::TEXTDOMAIN ),
					'id'    => self::CART_CUSTOM_CSS,
					'class' => 'posadzimy_input_long',
				],
				self::PREFIX . 'cart_section_end' => [
					'type' => 'sectionend',
					'id'   => self::PREFIX . 'cart_section_end',
				],


				self::PREFIX . 'checkout_section_start' => [
					'name' => __( 'Checkout settings', APP::TEXTDOMAIN ),
					'type' => 'title',
					'id'   => self::PREFIX . 'checkout_section_start',
				],
				$this->create_lightbox_header(
					__( 'Click and show example', APP::TEXTDOMAIN ),
					'https://static.posadzimy.pl/integrations/woocommerce/powiadomienie-checkout.jpg',
					'3'
				),

				self::CHECKOUT_MODULE_ENABLED             => [
					'name'    => __( 'Enable or disable checkout module',
						APP::TEXTDOMAIN ),
					'type'    => 'radio',
					'options' => [
						'1' => __( 'Yes', APP::TEXTDOMAIN ),
						'0' => __( 'No', APP::TEXTDOMAIN ),
					],
					'desc'    => __( '', APP::TEXTDOMAIN ),
					'id'      => self::CHECKOUT_MODULE_ENABLED,
				],
				self::CHECKOUT_THRESHOLD_AMOUNT_INFO_TEXT => [
					'name'    => __( 'Threshold amount info', APP::TEXTDOMAIN ),
					'type'    => 'text',
					'default' => '',
					'desc'    => __( 'You can use the {{wysokosc_zamowienia}} variable to show the required amount, and the {{brakujaca_kwota}} variable to show what value is missing',
						APP::TEXTDOMAIN ),
					'id'      => self::CHECKOUT_THRESHOLD_AMOUNT_INFO_TEXT,
					'class'   => 'posadzimy_input_long',
				],

				self::CHECKOUT_VIRTUAL_PRODUCT_ADDED_NOTICE => [
					'name'    => __( 'Virtual product added notice',
						APP::TEXTDOMAIN ),
					'type'    => 'text',
					'default' => __( 'Congratulations! You got a virtual product!',
						APP::TEXTDOMAIN ),
					'desc'    => __( '', APP::TEXTDOMAIN ),
					'id'      => self::CHECKOUT_VIRTUAL_PRODUCT_ADDED_NOTICE,
					'class'   => 'posadzimy_input_long',
				],

				self::CHECKOUT_CUSTOM_CSS => [
					'name'  => __( 'Custom CSS', APP::TEXTDOMAIN ),
					'type'  => 'textarea',
					'desc'  => __( '', APP::TEXTDOMAIN ),
					'id'    => self::CHECKOUT_CUSTOM_CSS,
					'class' => 'posadzimy_input_long',
				],

				self::PREFIX . 'checkout_section_end' => [
					'type' => 'sectionend',
					'id'   => self::PREFIX . 'checkout_section_end',
				],

				self::PREFIX . 'user_nts_section_start' => [
					'name' => __( 'User notification settings after purchasing and planting a tree',
						APP::TEXTDOMAIN ),
					'type' => 'title',
					'id'   => self::PREFIX . 'user_nts_section_start',
				],

				self::PREFIX . 'user_nts' => [
					'type' => 'sectionend',
					'id'   => self::PREFIX . 'user_nts',
				],

				self::PREFIX . 'user_nts_section_start_' => [
					'name' => __( 'Separate e-mail settings',
						APP::TEXTDOMAIN ),
					'type' => 'title',
					'id'   => self::PREFIX . 'user_nts_section_start_',
				],

				$this->create_lightbox_header(
					__( 'Click and show example', APP::TEXTDOMAIN ),
					'https://static.posadzimy.pl/integrations/woocommerce/mail-woocoomerce.jpg',
					'4'
				),


				self::ENABLE_POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER => [
					'name'    => __( 'Enable post order custom email to customer',
						APP::TEXTDOMAIN ),
					'type'    => 'radio',
					'options' => [
						'checkout_module_enabled'  => __( 'Yes', APP::TEXTDOMAIN ),
						'checkout_module_disabled' => __( 'No', APP::TEXTDOMAIN ),
					],
					'desc'    => __( '', APP::TEXTDOMAIN ),
					'id'      => self::ENABLE_POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER,
				],

				self::POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER_SUBJECT => [
					'name'    => __( 'The subject of the post-order email',
						APP::TEXTDOMAIN ),
					'type'    => 'text',
					'desc'    => '',
					'id'      => self::POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER_SUBJECT,
					'default' => __( 'As a thank you for the purchase in the XYZ store, we planted a tree!',
						APP::TEXTDOMAIN ),
					'class'   => 'posadzimy_input_long',
				],

				self::POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER_CONTENT => [
					'name'  => __( 'The content of the custom email',
						APP::TEXTDOMAIN ),
					'type'  => 'textarea',
					'id'    => self::POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER_CONTENT,
					'class' => 'posadzimy_input_long',
				],


				self::PREFIX . 'user_nts_' => [
					'type' => 'sectionend',
					'id'   => self::PREFIX . 'user_nts_',
				],


				self::PREFIX . 'user_nts_section_start__' => [
					'name' => __( 'Post order e-mail section settings',
						APP::TEXTDOMAIN ),
					'type' => 'title',
					'id'   => self::PREFIX . 'user_nts_section_start__',
				],

				$this->create_lightbox_header(
					__( 'Click and show example', APP::TEXTDOMAIN ),
					'https://static.posadzimy.pl/integrations/woocommerce/mail-woocoomerce-2.jpg',
					'5'
				),


				self::ENABLE_POST_ORDER_EMAIL_EXTRA_SECTION => [
					'name'    => __( 'Adding a section with information about planting a tree and certificate to the e-mail sent by WooCommerce after the payment is credited.',
						APP::TEXTDOMAIN ),
					'type'    => 'radio',
					'options' => [
						'checkout_module_enabled'  => __( 'Yes', APP::TEXTDOMAIN ),
						'checkout_module_disabled' => __( 'No', APP::TEXTDOMAIN ),

					],
					'desc'    => __( '', APP::TEXTDOMAIN ),
					'id'      => self::ENABLE_POST_ORDER_EMAIL_EXTRA_SECTION,
				],


				self::POST_ORDER_EMAIL_EXTRA_SECTION_CONTENT => [
					'name'  => __( 'Customer post order email extra section',
						APP::TEXTDOMAIN ),
					'type'  => 'textarea',
					'desc'  => __( 'Additional information visible on the email. You can use the {{link}} variable to show link to PDF certificate', APP::TEXTDOMAIN ),
					'id'    => self::POST_ORDER_EMAIL_EXTRA_SECTION_CONTENT,
					'class' => 'posadzimy_input_long',
				],


				self::PREFIX . 'user_nts__' => [
					'type' => 'sectionend',
					'id'   => self::PREFIX . 'user_nts__',
				],
			];
		}

		return [];


	}


	/**
	 * @param string $link_text
	 * @param string $image_url
	 * @param string $unique_id
	 *
	 * @return string[]
	 */
	private function create_lightbox_header(
		string $link_text,
		string $image_url,
		string $unique_id
	): array {
		add_action( 'woocommerce_admin_field_lightbox_header_' . $unique_id,
			function ( array $data ) use ( $unique_id, $link_text, $image_url ) {
				$type = $data['type'];
				if ( isset( self::$prevent_duplicate[ $type ] ) && self::$prevent_duplicate[ $type ] ) {
					return;
				}
				?>
                <tr valign="top">
                    <th scope="row" class="titledesc titledesc_setter">
                        <a class="glightbox glightbox_setter" id="<?php echo 'lightbox_header_' . $unique_id ?>"
                           href="<?php esc_attr_e( $image_url ) ?> "><?php esc_attr_e( $link_text ) ?>
                        </a>
                    </th>
                    <td class="forminp forminp-text">
                        <img class="posadzimy-mini-img d-img-none"
                             src="<?php esc_attr_e( $image_url ) ?>">
                    </td>
                </tr>
				<?php
				self::$prevent_duplicate[ $type ] = true;
			},
			10 );

		return

			[
				'name'  => 'lightbox_header_' . $unique_id,
				'title' => '',
				'type'  => 'lightbox_header_' . $unique_id,
				'id'    => 'lightbox_header_' . $unique_id,
			];

	}


	/**
	 * Notices.
	 */
	private function notices() {
		if ( isset( $_GET['section'] ) && 'webhooks' === $_GET['section'] ) { // WPCS: input var okay, CSRF ok.
			WC_Admin_Webhooks::notices();
		}
		if ( isset( $_GET['section'] ) && 'keys' === $_GET['section'] ) { // WPCS: input var okay, CSRF ok.
			WC_Admin_API_Keys::notices();
		}
	}

	/**
	 * Form method.
	 *
	 * @param string $method Method name.
	 *
	 * @return string
	 * @deprecated 3.4.4
	 *
	 */
	public function form_method( $method ) {
		return 'post';
	}

	/**
	 * Output the settings.
	 */
	public function output() {
		global $current_section;

		if ( 'help' === $current_section ) {
			//require_once POSADZIMY_PLUGIN_PATH . '/templates/backend/help.php';
            $api_client = Client_Static_Factory::create_service();
            $response = $api_client->get_help_content();
            echo '<style>p.submit > .woocommerce-save-button {display: none;}</style>';
            echo wp_kses_post( $response );

		} elseif ( 'keys' === $current_section ) {
			WC_Admin_API_Keys::page_output();
		} else {
			$settings = $this->get_settings( $current_section );
			WC_Admin_Settings::output_fields( $settings );
		}
	}

	public function save() {
		global $current_section;
		$settings = $this->get_settings( $current_section );
		if( $this->check_separate_email_settings() && $this->check_extra_email_settings() ) {
			WC_Admin_Settings::save_fields($settings);

			if ($current_section) {
				do_action('woocommerce_update_options_' . $this->id . '_' . $current_section);
			}

			$balance = $this->credit_balance->get_balance_amount();

            \wc_get_logger()->debug( 'POSADZIMY SAVE SETTINGS: ', array( 'source' => 'posadzimy-cron-log' ) );
            $old_value = get_option('posadzimy_balance');
            \wc_get_logger()->debug( print_r( 'OLD value: ' . $old_value, true), array( 'source' => 'posadzimy-cron-log' ) );
            \wc_get_logger()->debug( print_r( 'NEW value: ' . $balance, true), array( 'source' => 'posadzimy-cron-log' ) );


            if( ! empty($balance) && is_numeric($balance) ) {
				$res = update_option('posadzimy_balance', $balance );
                if( $res ) {
                    \wc_get_logger()->debug( print_r( 'Balance updated during saving of settings', true), array( 'source' => 'posadzimy-cron-log' ) );
                }
				$balance = ' (Balance: ' . $balance . ')';
				$this->label = __('Posadzimy', App::TEXTDOMAIN) . $balance;				
			}			
		}
	}

	public function check_separate_email_settings(): bool {
		if (array_key_exists(self::ENABLE_POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER, $_POST)) {
			if ($_POST[self::ENABLE_POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER] === 'checkout_module_enabled') {
				return $this->validate_separate_email_settings();
			}
		}
		return true;
	}

	public function check_extra_email_settings(): bool {
		if (array_key_exists(self::ENABLE_POST_ORDER_EMAIL_EXTRA_SECTION, $_POST)) {
			if ($_POST[self::ENABLE_POST_ORDER_EMAIL_EXTRA_SECTION] === 'checkout_module_enabled') {
				return $this->validate_extra_email_settings();
			}
		}
		return true;
	}

	public function validate_separate_email_settings(): bool {
		if(empty($_POST[self::POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER_SUBJECT])
			|| empty($_POST[self::POST_ORDER_CUSTOM_EMAIL_TO_CUSTOMER_CONTENT]) )
		{
			WC_Admin_Settings::add_error(
				esc_html__( 'When "Separate e-mail settings" option is enabled fields "Subject" and "Content" cannot be empty',
					APP::TEXTDOMAIN )
			);
			return false;
		}
		return true;
	}

	public function validate_extra_email_settings(): bool {
		if(empty($_POST[self::POST_ORDER_EMAIL_EXTRA_SECTION_CONTENT]) ) {
			WC_Admin_Settings::add_error(
				esc_html__( 'When "Post order e-mail section" option is enabled 
				field of extra section cannot be empty.',
					APP::TEXTDOMAIN )
			);
			return false;
		}
		return true;
	}

	private function get_default_tax_settings() {

        if( 'yes' === get_option( 'woocommerce_calc_taxes' ) ) {
            return '1';
        }

        return '0';
    }
}
