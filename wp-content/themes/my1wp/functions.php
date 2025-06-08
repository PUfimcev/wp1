<?php

function my1wp_after_setup_theme(): void
{
    add_theme_support( 'title-tag' );

    // Add support for post thumbnails
    add_theme_support('post-thumbnails');
    // Set the default thumbnail size
    set_post_thumbnail_size(150, 150, true);
    // Add support for HTML5 markup

    // Register a navigation menu
    register_nav_menus(array(
        'header' => __('Header Menu', 'my1wp'),
        'footer'    => __('Footer Menu', 'my1wp'),
    ));

}

add_action('after_setup_theme', 'my1wp_after_setup_theme');