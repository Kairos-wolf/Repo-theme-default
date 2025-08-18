<?php

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Output header scripts.
 */
function my_theme_output_header_scripts()
{
    $options = get_option('my_theme_settings');
    if (! empty($options['header_scripts'])) {
        echo "\n\n" . $options['header_scripts'] . "\n\n";
    }
}
add_action('wp_head', 'my_theme_output_header_scripts', 5);

/**
 * Output scripts at the top of the body.
 */
function my_theme_output_body_top_scripts()
{
    $options = get_option('my_theme_settings');
    if (! empty($options['body_top_scripts'])) {
        echo "\n\n" . $options['body_top_scripts'] . "\n\n";
    }
}
add_action('wp_body_open', 'my_theme_output_body_top_scripts');

/**
 * Output footer scripts.
 */
function my_theme_output_footer_scripts()
{
    $options = get_option('my_theme_settings');
    if (! empty($options['footer_scripts'])) {
        echo "\n\n" . $options['footer_scripts'] . "\n\n";
    }
}
add_action('wp_footer', 'my_theme_output_footer_scripts', 200);

/**
 * Output responsive CSS to the <head>.
 */
function my_theme_output_responsive_css()
{
    $options    = get_option('my_theme_settings');
    $css_all    = ! empty($options['css_all_screens']) ? trim($options['css_all_screens']) : '';
    $css_tablet = ! empty($options['css_tablet']) ? trim($options['css_tablet']) : '';
    $css_mobile = ! empty($options['css_mobile']) ? trim($options['css_mobile']) : '';

    $final_css = '';

    if ($css_all) {
        $final_css .= $css_all;
    }
    if ($css_tablet) {
        $final_css .= "\n@media (max-width: 991px) {\n" . $css_tablet . "\n}\n";
    }
    if ($css_mobile) {
        $final_css .= "\n@media (max-width: 767px) {\n" . $css_mobile . "\n}\n";
    }

    if (! empty(trim($final_css))) {
        echo "<style type=\"text/css\" id=\"mytheme-custom-css\">\n" . $final_css . "\n</style>\n";
    }
}
add_action('wp_head', 'my_theme_output_responsive_css', 100);
