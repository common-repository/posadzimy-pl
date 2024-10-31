<?php
defined( 'ABSPATH' ) || exit;

/**
 * Plugin Name: Posadzimy.pl
 * Plugin URI: https://wordpress.org/plugins/posadzimy-pl
 * Description: Wtyczka umożliwiająca integrację z serwisem Posadzimy.pl oraz automatczyne sadzenie drzew w imieniu klientów sklepu, po spełnieniu minimalnej wartości zamówienia.
 * Version: 1.0.7
 * Author: iLabs.dev
 * Author URI: https://ilabs.dev/
 * Text Domain: posadzimy
 * Requires at least: 5.4
 * Requires PHP: 7.2
 *
 * @package WooCommerce
 */

add_action( 'plugins_loaded', function () {
	load_plugin_textdomain( 'posadzimy', false, basename( dirname( __FILE__ ) ) . '/languages/' );
} );

define( 'POSADZIMY_PLUGIN_URL',
	plugin_dir_url( __FILE__ )
);

define( 'POSADZIMY_PLUGIN_BASENAME',
	plugin_basename( __FILE__ )
);

define( 'POSADZIMY_PLUGIN_PATH',
	plugin_dir_path( __FILE__ )
);

require_once __DIR__ . '../../woocommerce/includes/admin/settings/class-wc-settings-page.php';
require_once __DIR__ . '/vendor/autoload.php';

$posadzimy_app = new \Inspire_Labs\Posadzimy\App();
$posadzimy_app->execute();
