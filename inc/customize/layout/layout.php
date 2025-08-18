<?php

/**
 * Thêm tùy chọn Layout vào Customizer.
 */
function ht_add_layout_customizer_options($wp_customize)
{
    // Tạo Section "Layout"
    $wp_customize->add_section('ht_layout_options', [
        'title'       => __('Layout', 'ht'),
        'description' => __('Tùy chỉnh layout cho trang web.', 'ht'),
        'priority'    => 125,
    ]);

    // Thêm Setting và Control cho Chế độ Layout
    $wp_customize->add_setting('ht_site_layout_mode', [
        'default'           => 'full-width',
        'sanitize_callback' => 'ht_sanitize_layout_mode_choices',
    ]);

    $wp_customize->add_control('ht_site_layout_mode', [
        'label'    => __('Layout Mode', 'ht'),
        'section'  => 'ht_layout_options',
        'type'     => 'radio',
        'choices'  => [
            'full-width' => __('Full Width', 'ht'),
            'boxed'      => __('Boxed', 'ht'),
            'framed'     => __('Framed', 'ht'),
        ],
    ]);

    // Thêm Setting cho chiều rộng của layout Boxed
    $wp_customize->add_setting('ht_boxed_width', [
        'default'           => 1400, // Giá trị mặc định là 1400px
        'sanitize_callback' => 'absint', // Dùng hàm absint của WordPress để đảm bảo là số nguyên dương
    ]);

    // Thêm Control để người dùng nhập chiều rộng
    $wp_customize->add_control('ht_boxed_width', [
        'label'           => __('Boxed Layout Width (px)', 'ht'),
        'description'     => __('Nhập chiều rộng tối đa cho layout boxed.', 'ht'),
        'section'         => 'ht_layout_options',
        'type'            => 'number', // Kiểu nhập liệu là số
        'input_attrs'     => [
            'min' => 600, // Chiều rộng tối thiểu
            'step' => 10,  // Bước nhảy
        ],
    ]);

    // =================================================================
    // BẮT ĐẦU PHẦN THÊM MỚI - Ô CHỌN MÀU
    // =================================================================

    // 1. Thêm Setting cho màu nền
    $wp_customize->add_setting('ht_background_color_layout', [
        'default'           => '#f1f1f1', // Giá trị màu mặc định
        'sanitize_callback' => 'sanitize_hex_color', // Hàm làm sạch màu của WordPress
    ]);

    // 2. Thêm Control để người dùng chọn màu
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_background_color_layout', [
        'label'      => __('Background Color', 'ht'),
        'description' => __('Chọn một màu nền cho trang web khi ở chế độ Boxed hoặc Framed.', 'ht'),
        'section'    => 'ht_layout_options',
    ]));

    // =================================================================
    // KẾT THÚC PHẦN THÊM MỚI
    // =================================================================
}
add_action('customize_register', 'ht_add_layout_customizer_options');


/**
 * Hàm kiểm tra và làm sạch dữ liệu cho lựa chọn layout.
 */
function ht_sanitize_layout_mode_choices($input)
{
    $valid = ['full-width', 'boxed', 'framed'];
    if (in_array($input, $valid, true)) {
        return $input;
    }
    return 'full-width'; // Giá trị mặc định nếu lựa chọn không hợp lệ
}


/**
 * Thêm class CSS vào thẻ <body> dựa trên lựa chọn layout.
 */
function ht_layout_body_class($classes)
{
    $layout_mode = get_theme_mod('ht_site_layout_mode', 'full-width');
    $classes[] = 'layout-' . esc_attr($layout_mode);

    return $classes;
}
add_filter('body_class', 'ht_layout_body_class');


/**
 * Thêm CSS tùy chỉnh vào thẻ <head> để áp dụng các thay đổi về layout.
 * Hàm này sẽ áp dụng chiều rộng cho layout Boxed và màu nền.
 */
function ht_dynamic_layout_css()
{
    $layout_mode    = get_theme_mod('ht_site_layout_mode', 'full-width');
    $output_css     = '';

    // Chỉ áp dụng CSS nếu không phải là Full-width
    if ('full-width' !== $layout_mode) {
        $background_color = get_theme_mod('ht_background_color_layout', '#f1f1f1');
        $output_css .= "
            body.layout-{$layout_mode} {
                background-color: " . esc_attr($background_color) . ";
            }
        ";
    }

    // Áp dụng chiều rộng tối đa cho layout Boxed
    if ('boxed' === $layout_mode) {
        $boxed_width = get_theme_mod('ht_boxed_width', 1400);
        // Giả sử bạn có một container chính với class là `.site-container` hoặc `#page`
        // Hãy thay đổi selector cho phù hợp với theme của bạn
        $output_css .= "
            .layout-boxed .site-container {
                max-width: " . absint($boxed_width) . "px;
                margin-left: auto;
                margin-right: auto;
                position: relative;
            }
        ";
    }

    // In CSS vào <head> nếu có
    if (!empty($output_css)) {
        echo '<style type="text/css">' . $output_css . '</style>';
    }
}
add_action('wp_head', 'ht_dynamic_layout_css');
