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
     * Allow anonymous comments
     * @return void
     */
    public function restApi()
    {
        add_filter('rest_allow_anonymous_comments', '__return_true');
    }

    /**
    * Add theme supports
    * @return void
    */
    public function themeSupport()
    {
        add_theme_support('post-thumbnails');
    }

    /**
     * Show YOAST in Rest
     * @return void
     */
    public function yoastMeta()
    {
        register_meta('post', '_yoast_wpseo_metadesc', ['show_in_rest' => true]);
        register_meta('post', '_yoast_wpseo_title', ['show_in_rest' => true]);
    }
}

new ThemeSetup();
