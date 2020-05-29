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
