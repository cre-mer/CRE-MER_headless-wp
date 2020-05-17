<?php


/**
 *
 */
class ThemeSetup
{
    public function __construct()
    {
        $this->themeSupport();
    }

    public function themeSupport()
    {
        // add theme supports
        add_theme_support('post-thumbnails');
    }
}

new ThemeSetup();
