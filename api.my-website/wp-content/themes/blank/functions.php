<?php

/**
 * Setup theme
 */
class ThemeSetup
{
    public function __construct()
    {
        $this->restApi();
        $this->themeSupport();
        $this->yoastMeta();
    }

    /**
     * Handle REST API
     * @return void
     */
    public function restApi()
    {
        // Allow anonymous comments
        add_filter('rest_allow_anonymous_comments', '__return_true');

        // Restrict api Access
        add_filter( 'rest_authentication_errors', 'filter_incoming_connections' );

        function filter_incoming_connections( $errors ) {
            $client_id = filter_var($_GET['client_id'], FILTER_SANITIZE_STRING);
            $client_secret = filter_var($_GET['client_secret'], FILTER_SANITIZE_STRING);

            if( $client_id !== WP_API_CLIENT_ID && $client_secret !== WP_API_CLIENT_SECRET)
                return new WP_Error( 'forbidden_access', 'Access denied', array( 'status' => 403 ) );

            return $errors;

        }
    }

    /**
    * Add theme supports
    * @return void
    */
    public function themeSupport()
    {
        // Enable post thumbnails
        add_theme_support('post-thumbnails');
    }

    /**
     * Handle YOAST in REST API
     * @return void
     */
    public function yoastMeta()
    {
        register_meta('post', '_yoast_wpseo_metadesc', ['show_in_rest' => true]);
        register_meta('post', '_yoast_wpseo_title', ['show_in_rest' => true]);
    }
}

new ThemeSetup();
