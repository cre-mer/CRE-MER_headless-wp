<?php


/**
 *
 */
class ThemeSetup
{
    public function __construct()
    {
        $this->themeSupport();
        $this->restApi();
        $this->yoastMeta();
    }

    public function themeSupport()
    {
        // add theme supports
        add_theme_support('post-thumbnails');
    }

    public function restApi()
    {
        add_filter('rest_allow_anonymous_comments', '__return_true');
    }

    // Show YOAST in Rest
    public function yoastMeta()
    {
        register_meta('post', '_yoast_wpseo_metadesc', ['show_in_rest' => true]);
        register_meta('post', '_yoast_wpseo_title', ['show_in_rest' => true]);
    }
}

new ThemeSetup();
