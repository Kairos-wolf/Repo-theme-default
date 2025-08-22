<?php
function mytheme_customize_footer_register($wp_customize) {
// PANEL: FOOTER SETTINGS
    $wp_customize->add_panel('footer_main_panel', array(
        'title'    => __('Footer', 'mytheme'),
        'priority' => 30,
    ));
// Section: Footer
    $wp_customize->add_section('hm_footer_main', array(
        'title'    => __('Footer Main', 'mytheme'),
        'panel'    => 'footer_main_panel',
        'description' => __('Đây là mục chỉnh sửa các thành phần chính của footer.', 'mytheme'),
        'priority' => 1,
    ));

    // Background color footer
    $wp_customize->add_setting('footer_background_color', array(
        'default'           => '#ffffff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'footer_background_color_control',
        array(
            'label'    => __('Màu nền footer', 'mytheme'),
            'section'  => 'hm_footer_main',
            'settings' => 'footer_background_color',
        )
    ));

    // Color footer
    $wp_customize->add_setting('footer_text_color', array(
        'default'           => '#000000',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'footer_text_color_control',
        array(
            'label'    => __('Màu chữ footer', 'mytheme'),
            'section'  => 'hm_footer_main',
            'settings' => 'footer_text_color',
        )
    ));

    // Margin
    $wp_customize->add_setting('footer_main_margin', array(
        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('footer_main_margin_control', array(
        'label'    => __('Margin', 'mytheme'),
        'section'  => 'hm_footer_main',
        'settings' => 'footer_main_margin',
        'type'     => 'text',
        'description' => __('Nhập theo cú pháp CSS, ví dụ: 20px 0 (top-bottom, left-right)', 'mytheme'),
    ));

    // Padding
    $wp_customize->add_setting('footer_main_padding', array(
        'default'           => '',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('footer_main_padding_control', array(
        'label'    => __('Padding nội dung footer', 'mytheme'),
        'section'  => 'hm_footer_main',
        'settings' => 'footer_main_padding',
        'type'     => 'text',
        'description' => __('Nhập theo cú pháp CSS, ví dụ: 20px 0 (top-bottom, left-right)', 'mytheme'),
    ));

}
add_action('customize_register', 'mytheme_customize_footer_register');