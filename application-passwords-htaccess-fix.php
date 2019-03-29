<?php
/**
 * Plugin Name: Application Passwords .htaccess Fix
 * Plugin URI: https://github.com/csalzano
 * Description: This plugin persists a customization to .htaccess that the Application Passwords plugin requires on some server configurations.
 * Version: 1.0.2
 * Author: Corey Salzano
 * Author URI: https://profiles.wordpress.org/salzano
 * Text Domain: application-passwords-htaccess
 * Domain Path: /languages
 * License: GPLv2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.html
 */

defined( 'ABSPATH' ) OR exit;

class Application_Passwords_Htaccess_Fix{

	function add_hooks() {
		add_filter( 'mod_rewrite_rules', array( $this, 'maybe_add_http_authorization' ), 9999 );
	}

	/**
	 * If something something something Application Passwords, modify the
	 * section WordPress creates in .htaccess to implement this workaround.
	 *
	 * @param string $rules The content that gets written to .htaccess that powers WordPress.
	 */
	function maybe_add_http_authorization( $rules ) {


		//is the Application Passwords plugin running?
		if( ! class_exists( 'Application_Passwords' ) ) {
			//no, abort
			return;
		}

		/**
		 * Detect that a web request with an authorization header doesn't deliver
		 * a value in $_SERVER["PHP_AUTH_USER"]
		 */

		$args = array(
			'method'  => 'POST',
			'headers' => array(
				'Authorization'  => 'Basic ' . base64_encode( 'username:password' ),
			),
		);

		//this is a REST API endpoint created by Application Passwords
		$url = esc_url_raw( rest_url() ) . '2fa/v1/test-basic-authorization-header';
		$response = wp_remote_post( $url, $args );
		if( isset( $response['body'] ) && isset( $response['body']->PHP_AUTH_USER ) ) {

			/**
			 * There is no problem, this server is passing Basic Authentication
			 * headers just fine.
			 */
			return $rules;
		}

		/**
		 * Insert this line into the $rules that end up in .htaccess just after
		 * RewriteEngine On
		 */
		$line = "RewriteRule .* - [E=REMOTE_USER:%{HTTP:Authorization}]\n";

		$after = "RewriteEngine On\n"; //wp-includes/class-wp-rewrite.php line 1466

		$position = strpos( $rules, $after ) + strlen( $after );
		if( false === $position ) {

			//Perhaps something else is filtering the output of mod_rewrite_rules()
			return $rules;
		}

		//Insert $line right after $after
		return substr( $rules, 0, $position )
			. $line
			. substr( $rules, $position );
	}
}
$breakfast_fix_60394 = new Application_Passwords_Htaccess_Fix();
$breakfast_fix_60394->add_hooks();

register_activation_hook( __FILE__, 'flush_rewrite_rules' );
