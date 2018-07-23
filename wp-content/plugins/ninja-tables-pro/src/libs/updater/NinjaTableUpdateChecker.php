<?php

class NinjaTableUpdateChecker {

	private $vars;

	function __construct( $vars ) {
		$this->vars = $vars;
		add_action( 'plugins_loaded', array( $this, 'init' ) );
		add_action( 'admin_init', array( $this, 'register_option' ) );

		add_action( 'wp_ajax_' . $this->get_var( 'option_group' ) . '_activate_license',
			array( $this, 'activate_license' ) );
		add_action( 'wp_ajax_' . $this->get_var( 'option_group' ) . '_deactivate_license',
			array( $this, 'deactivate_license' ) );

		add_action( 'admin_init', array( $this, 'check_license' ) );
		add_action( 'admin_init', array( $this, 'sl_updater' ), 0 );
	}

	public function isLocal() {
		$ip_address = '';
		if ( array_key_exists( 'SERVER_ADDR', $_SERVER ) ) {
			$ip_address = $_SERVER['SERVER_ADDR'];
		} else if ( array_key_exists( 'LOCAL_ADDR', $_SERVER ) ) {
			$ip_address = $_SERVER['LOCAL_ADDR'];
		}
		
		return in_array( $ip_address, array( "127.0.0.1", "::1" ) );
	}

	function get_var( $var ) {
		if ( isset( $this->vars[ $var ] ) ) {
			return $this->vars[ $var ];
		}

		return false;
	}
	
	/**
	 * Show an error message that license needs to be activated
	 */
	function init() {
		
		if($this->isLocal()) {
			return;
		}
		
		if ( 'valid' != get_option( $this->get_var( 'license_status' ) ) ) {
			add_action( 'admin_notices', function () {
				echo '<div class="error error_notice'.$this->get_var('option_group').'"><p>' .
				     sprintf( __( 'The %s license needs to be activated. %sActivate Now%s', 'ninja-tables-pro' ),
					     $this->get_var( 'plugin_title' ), '<a href="' . $this->get_var( 'activate_url' ) . '">',
					     '</a>' ) .
				     '</p></div>';
			} );
		}
	}

	function sl_updater() {
		// retrieve our license key from the DB
		$license_key    = trim( get_option( $this->get_var( 'license_key' ) ) );
		$license_status = get_option( $this->get_var( 'license_status' ) );

		// setup the updater
		new NinjaTableUpdater( $this->get_var( 'store_url' ), $this->get_var( 'plugin_file' ), array(
			'version'   => $this->get_var( 'version' ),
			'license'   => $license_key,
			'item_name' => $this->get_var( 'item_name' ),
			'item_id'   => $this->get_var( 'item_id' ),
			'author'    => $this->get_var( 'author' )
		),
			array(
				'license_status' => $license_status,
				'admin_page_url' => $this->get_var( 'activate_url' ),
				'purchase_url'   => $this->get_var( 'purchase_url' ),
				'plugin_title'   => $this->get_var( 'plugin_title' )
			)
		);
	}

	function register_option() {
		// creates our settings in the options table
		register_setting( $this->get_var( 'option_group' ), $this->get_var( 'license_key' ),
			array( $this, 'sanitize_license' ) );
	}

	function sanitize_license( $new ) {
		$old = get_option( $this->get_var( 'license_key' ) );
		if ( $old && $old != $new ) {
			delete_option( $this->get_var( 'license_status' ) ); // new license has been entered, so must reactivate
		}

		return $new;
	}

	function activate_license() {

		$license = trim( $_POST[ $this->get_var( 'license_key' ) ] );

		// save the license key to the database
		update_option( $this->get_var( 'license_key' ), $license );

		// data to send in our API request
		$api_params = array(
			'edd_action' => 'activate_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->get_var( 'item_name' ) ), // the name of our product in EDD
			'item_id'    => $this->get_var( 'item_id' ),
			'url'        => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( $this->get_var( 'store_url' ),
			array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array(
				'message'  => 'There was an error activating the license, please verify your license is correct and try again or contact support.',
				'response' => $response
			), 423 );
			die();
		}

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "valid" or "invalid"
		update_option( $this->get_var( 'license_status' ), $license_data->license );

		if ( 'valid' != $license_data->license ) {
			wp_send_json_error( array(
				'message'  => 'There was an error activating the license, please verify your license is correct and try again or contact support.',
				'response' => $license_data
			), 423 );
			die();
		}

		wp_send_json_success( array(
			'message'  => 'Congratulation! ' . $this->get_var( 'plugin_title' ) . ' is successfully activated',
			'response' => $license_data
		), 200 );
	}

	function deactivate_license() {
		// retrieve the license from the database
		$license = trim( get_option( $this->get_var( 'license_key' ) ) );

		// data to send in our API request
		$api_params = array(
			'edd_action' => 'deactivate_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->get_var( 'item_name' ) ), // the name of our product in EDD
			'item_id'    => $this->get_var( 'item_id' ),
			'url'        => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post( $this->get_var( 'store_url' ),
			array( 'timeout' => 15, 'sslverify' => false, 'body' => $api_params ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) ) {
			wp_send_json_error( array(
				'message' => 'There was an error deactivating the license, please try again or contact support.'
			), 423 );
			die();
		}

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );

		// $license_data->license will be either "deactivated" or "failed"
		if ( 'deactivated' != $license_data->license ) {

			wp_send_json_error( array(
				'message' => 'There was an error deactivating the license, please try again or contact support.'
			), 423 );
			die();
		}
		
		delete_option( $this->get_var( 'license_status' ) );
		wp_send_json_success( array(
			'message' => 'License deactivated'
		), 200 );
		die();
	}

	function check_license() {
		if ( get_transient( $this->get_var( 'license_status' ) . '_checking' ) ) {
			return;
		}

		$license = trim( get_option( $this->get_var( 'license_key' ) ) );

		$api_params = array(
			'edd_action' => 'check_license',
			'license'    => $license,
			'item_name'  => urlencode( $this->get_var( 'item_name' ) ),
			'url'        => home_url()
		);

		// Call the custom API.
		$response = wp_remote_post(
			$this->get_var( 'store_url' ),
			array(
				'timeout'   => 15,
				'sslverify' => false,
				'body'      => $api_params
			)
		);

		if ( is_wp_error( $response ) ) {
			return false;
		}

		$license_data = json_decode(
			wp_remote_retrieve_body( $response )
		);

		if ( $license_data->license != 'valid' ) {
			delete_option( $this->get_var( 'license_status' ) );
		}

		// Set to check again in 12 hours
		set_transient(
			$this->get_var( 'license_status' ) . '_checking',
			$license_data,
			( 60 * 60 * 12 )
		);
	}
}
