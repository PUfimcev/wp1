<?php

require_once __DIR__ . '/acf_functions.php';
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

## Удаляет "Рубрика: ", "Метка: " и т.д. из заголовка архива
add_filter( 'get_the_archive_title', function( $title ){
    return preg_replace('~^[^:]+: ~', '', $title );
});

add_filter( 'excerpt_length', function(){
    return 20;
} );

function add_styles(): void
{
    wp_enqueue_style('header_style', get_template_directory_uri() . '/assets/css/critical.css', array(), false, 'all');
}
add_action('wp_enqueue_scripts', 'add_styles');

function load_assets_in_footer(): void
{
    wp_enqueue_style('footer_style', get_template_directory_uri() . '/assets/css/style.css', array(), false, 'all');
}
add_action('load-assets-in-footer', 'load_assets_in_footer');


function add_one_day($date): string
{
    return date('d F Y',  strtotime($date . ' +1 day'));
}
add_filter('plus_one_day', 'add_one_day');

function wp1_current_day_shortcode(): string
{
    $current_day = date('d-m-Y');
    return apply_filters('plus_one_day', $current_day);
}
add_shortcode('current_day', 'wp1_current_day_shortcode');

// Enable shortcodes in post titles
add_filter('the_title', 'do_shortcode');


function add_body_classes($classes): array
{
    if (is_home() || is_front_page()) {
        $classes[] = 'hey-dude-it-is-blog';
    }

    return $classes;
}
add_filter('body_class', 'add_body_classes');
