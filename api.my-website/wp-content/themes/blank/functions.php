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
}

new ThemeSetup();
