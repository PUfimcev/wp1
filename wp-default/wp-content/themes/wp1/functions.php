<?php
function wp1_setup(): void
{

    // Add support for post thumbnails
    add_theme_support('post-thumbnails');

    add_theme_support('title-tag');

    // Register navigation menus
    register_nav_menus(array(
        'header' => __('Header Menu', 'wp1'),
        'footer' => __('Footer Menu', 'wp1'),
    ));

    // Add support for HTML5 markup
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
}

add_action('after_setup_theme', 'wp1_setup');

function wp1_alter_title($title): string
{
    if(is_home() || is_front_page()) {
        $title .= 'You are on homepage';
    }

    return $title;
}

add_filter('pre_get_document_title', 'wp1_alter_title');