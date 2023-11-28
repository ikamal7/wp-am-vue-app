<?php

namespace Kamal\WpAmVueApp;

/**
 * Api Class.
 *
 * @since 0.0.1
 */
class Api {

    const API_URL = 'https://miusage.com/v1/challenge/2/static/';

    /**
     * Constructor
     *
     * @since 0.0.1
     *
     * @return void
     */
    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_endpoints' ) );
    }
    /**
     * Register_endpoints
     *
     * @return void
     */
    public function register_endpoints() {

        // Define a route for get data from external api.
        register_rest_route(
            'wp-am-vue-app/v1',
            '/data',
            array(
				'methods'  => 'GET',
				'callback' => array( $this, 'get_graph_data' ),
			)
        );

        // Define a route for saving settings.
        register_rest_route(
            'wp-am-vue-app/v1',
            '/settings',
            array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'save_settings_callback' ),
				'args'                => array(
					'row'      => array(
						'type'              => 'integer',
						'required'          => false,
						'minimum'           => 1,
						'maximum'           => 5,
						'sanitize_callback' => 'absint',
					),
					'readable' => array(
						'type'              => 'boolean',
						'required'          => false,
						'sanitize_callback' => 'rest_sanitize_boolean',
					),
					'emails'   => array(
						'type'              => 'array',
						'required'          => false,
						'sanitize_callback' => 'sanitize_text_field',
					),
				),
				'permission_callback' => array( $this, 'permissions' ),
			)
        );

        // Define a route for get Setting from options.
        register_rest_route(
            'wp-am-vue-app/v1',
            '/settings',
            array(
				'methods'  => 'GET',
				'callback' => array( $this, 'get_settings' ),
			)
        );
    }
    /**
     * Graph Data get API
     *
     * @since 0.0.1
     *
     * @return rest api response
     */
    public function get_graph_data() {

        // Check if the data is cached.
        $cached_data = get_option( 'am_api_cached_data' );
        if ( $cached_data ) {
            return rest_ensure_response( $cached_data );
        }

        // Fetch data from the external API.

        $response = wp_safe_remote_get( self::API_URL );

        if ( is_wp_error( $response ) ) {
            return rest_ensure_response( array( 'error' => 'Failed to fetch data from the API' ) );
        }

        $data = json_decode( wp_remote_retrieve_body( $response ), true );

        // Cache the data for one hour.
        update_option( 'am_api_cached_data', $data, HOUR_IN_SECONDS );

        return rest_ensure_response( $data );
    }

    /**
     * Save settings
     *
     * @since 0.0.1
     *
     * @param  mixed $request form field data for settings.
     * @return rest Response
     */
    public function save_settings_callback( $request ) {

        // Verify the nonce for security.
        $nonce = $request->get_header( 'X-WP-Nonce' );
        if ( ! wp_verify_nonce( $nonce, 'wp_rest' ) ) {
            return rest_ensure_response( array( 'error' => 'Nonce verification failed' ) );
        }

        // Extract the form data from the request.

		$data = json_decode( $request->get_body() );

		if ( update_option( 'am_vue_app_settings', $data ) ) {
            return rest_ensure_response( $data );
        }

        // Return the settings as a REST response.
        return rest_ensure_response( array( 'error' => 'Settings update failed' ) );
	}

    /**
     * Get settings from rest api callback
     *
     * @since 0.0.1
     *
     * @return rest Response
     */
    public function get_settings() {
        // Retrieve your settings from the options table.
        $settings = get_option( 'am_vue_app_settings', true );

        // Return the settings as a REST response.
        return rest_ensure_response( $settings );
    }

    /**
     * Check request permissions
     *
     * @return bool
     */
    public function permissions() {
        // Check permissions.
        if ( ! current_user_can( 'manage_options' ) ) {
            return new \WP_Error( 'rest_forbidden', __( 'You do not have permission to access this endpoint.', 'wp-am-vue-app' ), array( 'status' => 401 ) );
        }
        return true;
    }
}
