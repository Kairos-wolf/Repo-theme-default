<?php

/**
 * Thêm một Panel tùy chỉnh và các Section bên trong nó.
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function ht_add_style_customizer_panel($wp_customize)
{

    // 1. Tạo một Panel chính có tên "Tùy Chọn Giao Diện"
    $wp_customize->add_panel('ht_style_panel', [
        'title'       => __('Style', 'ht'),
        'description' => __('Tùy chỉnh màu sắc, kiểu chữ và các cài đặt giao diện khác.', 'ht'),
        'priority'    => 120,
    ]);

    // 2. Thêm một Section cho Màu Sắc, và gán nó vào Panel đã tạo
    $wp_customize->add_section('ht_color_options', [
        'title'    => __('Colors', 'ht'),
        'panel'    => 'ht_style_panel', // Đây là dòng quan trọng để gắn section vào panel
    ]);

    // 3. Thêm Setting và Control cho các tùy chọn màu sắc
    $wp_customize->add_setting('ht_color_primary', [
        'default'           => '#007bff',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_color_primary', [
        'label'    => __('Primary Color', 'ht'),
        'section'  => 'ht_color_options',
    ]));

    $wp_customize->add_setting('ht_color_secondary', [
        'default'           => '#6c757d',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_color_secondary', [
        'label'    => __('Secondary Color', 'ht'),
        'section'  => 'ht_color_options',
    ]));

    $wp_customize->add_setting('ht_color_text', [
        'default'           => '#212529',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_color_text', [
        'label'    => __('Text color', 'ht'),
        'section'  => 'ht_color_options',
    ]));

    $wp_customize->add_setting('ht_color_background', [
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_color_background', [
        'label'    => __('Background color', 'ht'),
        'section'  => 'ht_color_options',
    ]));
}
add_action('customize_register', 'ht_add_style_customizer_panel');

/**
 * Tạo và in CSS động dựa trên các giá trị đã chọn trong Customizer.
 * Hàm này vẫn giữ nguyên, vì nó lấy dữ liệu theo tên setting, không phụ thuộc vào panel hay section.
 */
function ht_customizer_color_css()
{
    $primary_color = get_theme_mod('ht_color_primary');
    $secondary_color = get_theme_mod('ht_color_secondary');
    $text_color = get_theme_mod('ht_color_text');
    $background_color = get_theme_mod('ht_color_background');

    if ($primary_color || $secondary_color || $text_color || $background_color) {
        echo '<style type="text/css">';
        if ($primary_color) {
            echo 'a, .btn-primary { color: ' . esc_attr($primary_color) . '; }';
        }
        if ($secondary_color) {
            echo 'a:hover, .btn-secondary { color: ' . esc_attr($secondary_color) . '; }';
        }
        if ($text_color) {
            echo 'body, p { color: ' . esc_attr($text_color) . '; }';
        }
        if ($background_color) {
            echo 'body { background-color: ' . esc_attr($background_color) . '; }';
        }
        echo '</style>';
    }
}
add_action('wp_head', 'ht_customizer_color_css');
