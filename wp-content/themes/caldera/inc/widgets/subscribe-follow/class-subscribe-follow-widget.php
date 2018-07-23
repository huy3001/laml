<?php

/**
 * Widget subscribe and follow.
 *
 * @package Caldera
 */
class Caldera_Subscribe_Follow_Widget extends Cherry_Abstract_Widget {

	/**
	 * MailChimp API server
	 *
	 * @var string
	 */
	private $api_server = 'https://%s.api.mailchimp.com/2.0/';

	/**
	 * Service errors set
	 *
	 * @var array
	 */
	public $errors = array();

	/**
	 * Constructor
	 */
	public function __construct() {

		$this->widget_cssclass = 'widget-subscribe';
		$this->widget_description = esc_html__( 'Display subscribe form and follow links.', 'caldera' );
		$this->widget_id = 'caldera_widget_subscribe_follow';
		$this->widget_name = esc_html__( 'Subscribe and Follow', 'caldera' );
		$this->settings = array(
			'enable_subscribe'        => array(
				'type'    => 'checkbox',
				'value'   => array(
					'enable_subscribe' => 'true',
				),
				'options' => array(
					'enable_subscribe' => esc_html__( 'Enable Subscribe Box', 'caldera' ),
				),
			),
			'subscribe_title'         => array(
				'type'  => 'text',
				'value' => esc_html__( 'Subscribe', 'caldera' ),
				'label' => esc_html__( 'Subscribe Title', 'caldera' ),
			),
			'subscribe_message'       => array(
				'type'  => 'textarea',
				'label' => esc_html__( 'Subscribe text message', 'caldera' ),
			),
			'subscribe_input'         => array(
				'type'  => 'text',
				'value' => esc_html__( 'Enter your e-mail', 'caldera' ),
				'label' => esc_html__( 'Subscribe input placeholder', 'caldera' ),
			),
			'subscribe_submit'        => array(
				'type'  => 'text',
				'value' => esc_html__( 'Subscribe', 'caldera' ),
				'label' => esc_html__( 'Subscribe submit label', 'caldera' ),
			),
			'subscribe_success'       => array(
				'type'  => 'text',
				'value' => esc_html__( 'You successfully subscribed', 'caldera' ),
				'label' => esc_html__( 'Subscribe success', 'caldera' ),
			),
			'enable_follow'           => array(
				'type'    => 'checkbox',
				'value'   => array(
					'enable_follow' => 'true',
				),
				'options' => array(
					'enable_follow' => esc_html__( 'Enable Follow Box', 'caldera' ),
				),
			),
			'follow_title'            => array(
				'type'  => 'text',
				'value' => esc_html__( 'Follow', 'caldera' ),
				'label' => esc_html__( 'Follow Title', 'caldera' ),
			),
			'follow_message'          => array(
				'type'  => 'textarea',
				'label' => esc_html__( 'Follow text message', 'caldera' ),
			),
			'enable_background'       => array(
				'type'    => 'checkbox',
				'value'   => array(
					'enable_background' => 'false',
				),
				'options' => array(
					'enable_background' => array(
						'label' => esc_html__( 'Enable Custom Background', 'caldera' ),
						'slave' => 'background_image'
					),
				),
			),
			'background_image'        => array(
				'type'               => 'media',
				'label'              => esc_html__( 'Background Image', 'caldera' ),
				'upload_button_text' => esc_html__( 'Choose Image', 'caldera' ),
				'multi_upload'       => false,
				'master'             => 'background_image',
			),
			'invert_text_colorscheme' => array(
				'type'    => 'checkbox',
				'value'   => array(
					'invert_text_colorscheme' => 'true',
				),
				'master'  => 'background_image',
				'options' => array(
					'invert_text_colorscheme' => esc_html__( 'Use "Invert scheme" for text color', 'caldera' ),
				),
			),
			'background_position'     => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Background Position', 'caldera' ),
				'value'   => 'center',
				'options' => array(
					'top-left'      => esc_html__( 'Top Left', 'caldera' ),
					'top-center'    => esc_html__( 'Top Center', 'caldera' ),
					'top-right'     => esc_html__( 'Top Right', 'caldera' ),
					'center-left'   => esc_html__( 'Middle Left', 'caldera' ),
					'center'        => esc_html__( 'Middle Center', 'caldera' ),
					'center-right'  => esc_html__( 'Middle Right', 'caldera' ),
					'bottom-left'   => esc_html__( 'Bottom Left', 'caldera' ),
					'bottom-center' => esc_html__( 'Bottom Center', 'caldera' ),
					'bottom-right'  => esc_html__( 'Bottom Right', 'caldera' ),
				),
				'master'  => 'background_image',
			),
			'background_repeat'       => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Background Position', 'caldera' ),
				'value'   => 'no-repeat',
				'options' => array(
					'repeat'    => esc_html__( 'Repeat', 'caldera' ),
					'repeat-x'  => esc_html__( 'Repeat X', 'caldera' ),
					'repeat-y'  => esc_html__( 'Repeat Y', 'caldera' ),
					'no-repeat' => esc_html__( 'No repeat', 'caldera' ),
				),
				'master'  => 'background_image',
			),
			'background_size'         => array(
				'type'    => 'select',
				'label'   => esc_html__( 'Background Size', 'caldera' ),
				'value'   => 'inherit',
				'options' => array(
					'cover'   => esc_html__( 'Cover', 'caldera' ),
					'contain' => esc_html__( 'Contain', 'caldera' ),
					'auto'    => esc_html__( 'Auto', 'caldera' ),
				),
				'master'  => 'background_image',
			),
			'background_color'        => array(
				'type'   => 'colorpicker',
				'label'  => esc_html__( 'Background Color', 'caldera' ),
				'master' => 'background_image',
			),
		);

		add_action( 'wp_ajax_caldera_subscribe', array( $this, 'process_subscribe' ) );
		add_action( 'wp_ajax_nopriv_caldera_subscribe', array( $this, 'process_subscribe' ) );

		$this->errors = array(
			'nonce'     => esc_html__( 'Security validation failed', 'caldera' ),
			'mail'      => esc_html__( 'Please, provide valid mail', 'caldera' ),
			'mailchimp' => esc_html__( 'Please, set up MailChimp API key and List ID', 'caldera' ),
			'internal'  => esc_html__( 'Internal error. Please, try again later', 'caldera' ),
		);

		parent::__construct();
	}

	/**
	 * widget function.
	 *
	 * @see WP_Widget
	 *
	 * @param array $args
	 * @param array $instance
	 */
	public function widget( $args, $instance ) {

		if ( $this->get_cached_widget( $args ) ) {
			return;
		}

		ob_start();

		$this->setup_widget_data( $args, $instance );
		$this->widget_start( $args, $instance );

		$subscribe_enabled = ( ! empty( $instance['enable_subscribe'] ) ) ? $instance['enable_subscribe'] : false;

		if ( is_array( $subscribe_enabled ) && 'true' === $subscribe_enabled['enable_subscribe'] ) {
			$subscribe_enabled = true;
		} else {
			$subscribe_enabled = false;
		}

		$follow_enabled = ( ! empty( $instance['enable_follow'] ) ) ? $instance['enable_follow'] : false;

		if ( is_array( $follow_enabled ) && 'true' === $follow_enabled['enable_follow'] ) {
			$follow_enabled = true;
		} else {
			$follow_enabled = false;
		}

		$subscribe_template = locate_template( 'inc/widgets/subscribe-follow/view/subcribe-view.php', false, false );

		$api_key = get_theme_mod( 'mailchimp_api_key' );
		$list_id = get_theme_mod( 'mailchimp_list_id' );

		// Load subscribe tamplate


		$follow_template = locate_template( 'inc/widgets/subscribe-follow/view/follow-view.php', false, false );

		// Load follow template
		if ( $follow_template && $follow_enabled ) {
			include $follow_template;
		}

		if ( $subscribe_enabled && $subscribe_template && $api_key && $list_id ) {
			include $subscribe_template;
		} elseif ( ! $api_key || ! $list_id ) {
			esc_html_e( 'Please set up MailChimp API key and List ID', 'caldera' );
		}


		$background_enabled = ( ! empty( $instance['enable_background'] ) ) ? $instance['enable_background'] : false;

		if ( is_array( $background_enabled ) && 'true' === $background_enabled['enable_background'] ) {

			$background_styles_template = locate_template( 'inc/widgets/subscribe-follow/view/background-styles-view.php', false, false );

			if ( $background_styles_template ) {
				include $background_styles_template;
			}
		}

		$this->widget_end( $args );
		$this->reset_widget_data();

		echo $this->cache_widget( $args, ob_get_clean() );
	}

	/**
	 * Get social navigation menu
	 *
	 * @return string
	 */
	public function get_social_nav() {
		return caldera_get_social_list( 'widget' );
	}

	/**
	 * Get subscribe button HTML.
	 *
	 * @param  string $class CSS class.
	 *
	 * @return string
	 */
	public function get_subscribe_submit( $class ) {

		$subscribe_submit = $this->use_wpml_translate( 'subscribe_submit' );
		$subscribe_submit = caldera_render_icons( $subscribe_submit );

		return '<a href="#" class="subscribe-block__submit ' . esc_attr( $class ) . '">' . wp_kses_post( $subscribe_submit ) . '</a>';
	}

	/**
	 * Get subscribe or follow block title.
	 *
	 * @param  string $block Block name to get title for.
	 *
	 * @return string
	 */
	public function get_block_title( $block = 'follow' ) {

		$setting = $block . '_title';
		$title = $this->use_wpml_translate( $setting );

		if ( ! empty( $title ) ) {
			return $this->args['before_title'] . $title . $this->args['after_title'];
		}
	}

	/**
	 * Get subscribe or follow block title.
	 *
	 * @param  string $block Block name to get title for.
	 *
	 * @return string
	 */
	public function get_block_message( $block = 'follow' ) {

		$setting = $block . '_message';
		$message = $this->use_wpml_translate( $setting );

		if ( ! empty( $message ) ) {
			return '<div class="' . $block . '-block__message">' . wp_kses( $message, wp_kses_allowed_html( 'post' ) ) . '</div>';
		}

	}

	/**
	 * Get subscribe form input
	 *
	 * @return string
	 */
	public function get_subscribe_input() {
		return '<input class="subscribe-block__input" type="email" name="subscribe-mail" value="" placeholder="' . esc_attr( $this->use_wpml_translate( 'subscribe_input' ) ) . '">';
	}

	/**
	 * Get subscribe form service messages
	 *
	 * @return string
	 */
	public function get_subscribe_messages() {
		$success = $this->use_wpml_translate( 'subscribe_success' );

		return '<div class="subscribe-block__messages">
					<div class="subscribe-block__success hidden">' . esc_html( $success ) . '</div>
					<div class="subscribe-block__error hidden"></div>
				</div>';
	}

	/**
	 * Process subscribtion form
	 *
	 * @return void
	 */
	public function process_subscribe() {

		if ( ! isset( $_POST['nonce'] ) || ! wp_verify_nonce( $_POST['nonce'], 'caldera_subscribe' ) ) {
			wp_send_json_error( array( 'message' => $this->errors['nonce'] ) );
		}

		$mail = ( ! empty( $_POST['mail'] ) ) ? esc_attr( $_POST['mail'] ) : false;

		if ( ! is_email( $mail ) ) {
			wp_send_json_error( array( 'message' => $this->errors['mail'] ) );
		}

		$args = array(
			'email'        => array(
				'email' => $mail,
			),
			'double_optin' => false,
		);

		$response = $this->api_call( 'lists/subscribe', $args );

		if ( false === $response ) {
			wp_send_json_error( array( 'message' => $this->errors['mailchimp'] ) );
		}

		$response = json_decode( $response, true );

		if ( empty( $response ) ) {
			wp_send_json_error( array( 'message' => $this->errors['internal'] ) );
		}

		if ( isset( $response['status'] ) && 'error' == $response['status'] ) {
			wp_send_json_error( array( 'message' => esc_html( $response['error'] ) ) );
		}

		wp_send_json_success();

	}

	/**
	 * Make remote request to mailchimp API
	 *
	 * @param  string $method API method to call.
	 * @param  array  $args   API call arguments.
	 *
	 * @return array|bool
	 */
	public function api_call( $method, $args = array() ) {

		if ( ! $method ) {
			return false;
		}

		$api_key = get_theme_mod( 'mailchimp_api_key' );
		$list_id = get_theme_mod( 'mailchimp_list_id' );

		if ( ! $api_key || ! $list_id ) {
			return false;
		}

		$key_data = explode( '-', $api_key );

		if ( empty( $key_data ) || ! isset( $key_data[1] ) ) {
			return false;
		}

		$this->api_server = sprintf( $this->api_server, $key_data[1] );

		$url = esc_url( trailingslashit( $this->api_server . $method ) );
		$defaults = array( 'apikey' => $api_key, 'id' => $list_id );
		$data = json_encode( array_merge( $defaults, $args ) );

		$request = wp_remote_post( $url, array( 'body' => $data ) );

		return wp_remote_retrieve_body( $request );

	}

}

add_action( 'widgets_init', 'caldera_register_subscribe_follow_widgets' );
function caldera_register_subscribe_follow_widgets() {
	register_widget( 'Caldera_Subscribe_Follow_Widget' );
}
