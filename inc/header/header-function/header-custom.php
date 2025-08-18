<?php
function mytheme_customize_register($wp_customize)
{
    // PANEL: HEADER MAIN SETTINGS
    $wp_customize->add_panel('header_main_panel', array(
        'title'    => __('Header Main Settings', 'mytheme'),
        'priority' => 30,
    ));
    // Section: Header Main
    $wp_customize->add_section('hm_header_main', array(
        'title'    => __('Header Main', 'mytheme'),
        'panel'    => 'header_main_panel',
        'description' => __('Đây là mục chỉnh sửa các thành phần chính của header.', 'mytheme'),
    ));

    // Background color header main
    $wp_customize->add_setting('header_main_background_color', array(
        'default'           => '#ffffff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'header_main_background_color_control',
        array(
            'label'    => __('Màu nền header chính', 'mytheme'),
            'section'  => 'hm_header_main',
            'settings' => 'header_main_background_color',
        )
    ));

    // color header main
    $wp_customize->add_setting('header_main_color', array(
        'default'           => '#ffffff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'header_main_color_control',
        array(
            'label'    => __('Màu chuws header chính', 'mytheme'),
            'section'  => 'hm_header_main',
            'settings' => 'header_main_color',
        )
    ));

    // Margin header main với các item khác
    $wp_customize->add_setting('header_main_margin', array(
        'default'           => '0',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('header_main_margin_control', array(
        'label'    => __('Margin header chính', 'mytheme'),
        'section'  => 'hm_header_main',
        'settings' => 'header_main_margin',
        'type'     => 'text',
        'description' => __('Nhập theo cú pháp CSS, ví dụ: 20px 0 (top-bottom, left-right)', 'mytheme'),
    ));

    // Padding nội dung header main
    $wp_customize->add_setting('header_main_padding', array(
        'default'           => '20px 0',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('header_main_padding_control', array(
        'label'    => __('Padding nội dung header chính', 'mytheme'),
        'section'  => 'hm_header_main',
        'settings' => 'header_main_padding',
        'type'     => 'text',
        'description' => __('Nhập theo cú pháp CSS, ví dụ: 20px 0 (top-bottom, left-right)', 'mytheme'),
    ));

    // Border radius header main
    $wp_customize->add_setting('header_main_border_radius', array(
        'default'           => '0',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('header_main_border_radius_control', array(
        'label'    => __('Bo tròn header chính', 'mytheme'),
        'section'  => 'hm_header_main',
        'settings' => 'header_main_border_radius',
        'type'     => 'text',
        'description' => __('Nhập theo cú pháp CSS, ví dụ: 10px)', 'mytheme'),
    ));

    // Section: Logo settings
    $wp_customize->add_section('hm_logo_settings', array(
        'title'    => __('Logo Settings', 'mytheme'),
        'panel'    => 'header_main_panel',
    ));

    // Setting: Chiều rộng logo
    $wp_customize->add_setting('logo_width', array(
        'default'           => 40,
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('logo_width_control', array(
        'label'    => __('Chiều rộng logo (px)', 'mytheme'),
        'section'  => 'hm_logo_settings',
        'settings' => 'logo_width',
        'type'     => 'number',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 500,
            'step' => 1,
        ),
    ));

    // Setting: Chiều cao logo
    $wp_customize->add_setting('logo_height', array(
        'default'           => 40,
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('logo_height_control', array(
        'label'    => __('Chiều cao logo (px)', 'mytheme'),
        'section'  => 'hm_logo_settings',
        'settings' => 'logo_height',
        'type'     => 'number',
        'input_attrs' => array(
            'min'  => 10,
            'max'  => 500,
            'step' => 1,
        ),
    ));

    // Setting: Padding với item trái logo
    $wp_customize->add_setting('logo_padding_left', array(
        'default'           => 0,
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('logo_padding_left_control', array(
        'label'    => __('Padding với item trái (px)', 'mytheme'),
        'section'  => 'hm_logo_settings',
        'settings' => 'logo_padding_left',
        'type'     => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
        ),
    ));

    // Setting: Padding với item phải logo
    $wp_customize->add_setting('logo_padding_right', array(
        'default'           => 0,
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('logo_padding_right_control', array(
        'label'    => __('Padding với item phải (px)', 'mytheme'),
        'section'  => 'hm_logo_settings',
        'settings' => 'logo_padding_right',
        'type'     => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
        ),
    ));

    // Section: Menu
    $wp_customize->add_section('hm_menu_settings', array(
        'title'    => __('Menu Settings', 'mytheme'),
        'panel'    => 'header_main_panel',
        'description' => __('Đây là mục chỉnh sửa khoảng cách giữa menu và các thành phần khác.', 'mytheme'),
    ));

    // Padding Left menu
    $wp_customize->add_setting('menu_padding_left', array(
        'default'           => '0',
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint', // đảm bảo là số nguyên dương
    ));

    $wp_customize->add_control('menu_padding_left_control', array(
        'label'    => __('Padding với item trái (px)', 'mytheme'),
        'section'  => 'hm_menu_settings',
        'settings' => 'menu_padding_left',
        'type'     => 'number',
        'input_attrs' => array(
            'min' => 0,
            'step' => 1,
        ),
    ));

    // Padding Right menu
    $wp_customize->add_setting('menu_padding_right', array(
        'default'           => '0',
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('menu_padding_right_control', array(
        'label'    => __('Padding với item phải (px)', 'mytheme'),
        'section'  => 'hm_menu_settings',
        'settings' => 'menu_padding_right',
        'type'     => 'number',
        'input_attrs' => array(
            'min' => 0,
            'step' => 1,
        ),
    ));

    // Color menu
    $wp_customize->add_setting('menu_text_color', array(
        'default'           => '#000000',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'menu_text_color_control',
        array(
            'label'    => __('Màu chữ menu', 'mytheme'),
            'section'  => 'hm_menu_settings',
            'settings' => 'menu_text_color',
        )
    ));

    // Color menu hover
    $wp_customize->add_setting('menu_hover_color', array(
        'default'           => '#ff0000',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'menu_hover_color_control',
        array(
            'label'    => __('Màu hover menu', 'mytheme'),
            'section'  => 'hm_menu_settings',
            'settings' => 'menu_hover_color',
        )
    ));

    // Font size menu
    $wp_customize->add_setting('menu_font_size', array(
        'default'           => 16,
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('menu_font_size_control', array(
        'label'    => __('Font size menu (px)', 'mytheme'),
        'section'  => 'hm_menu_settings',
        'settings' => 'menu_font_size',
        'type'     => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 90,
            'step' => 1,
        ),
    ));

    // Khoảng cách giữa các item menu
    $wp_customize->add_setting('menu_item_spacing', array(
        'default'           => 0,
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('menu_item_spacing_control', array(
        'label'    => __('Khoảng cách giữa các item (px)', 'mytheme'),
        'section'  => 'hm_menu_settings',
        'settings' => 'menu_item_spacing',
        'type'     => 'number',
        'input_attrs' => array(
            'min'  => 0,
            'max'  => 100,
            'step' => 1,
        ),
    ));


    // Section: Search
    $wp_customize->add_section('hm_search_settings', array(
        'title'    => __('Search Settings', 'mytheme'),
        'panel'    => 'header_main_panel',
        'description' => __('Đây là mục thêm khoảng cách giữa search và các thành phần khác.', 'mytheme'),
    ));

    // UI search
    $wp_customize->add_setting('header_search_ui', array(
        'default'   => 'default',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control('header_search_ui', array(
        'label'    => 'Chọn kiểu search',
        'section' => 'hm_search_settings',
        'type'    => 'radio',
        'choices' => array(
            'default' => 'Mặc định',
            'modern'  => 'Hiện đại',
            'simple'  => 'Tối giản',
        )
    ));

    // Padding Left
    $wp_customize->add_setting('search_padding_left', array(
        'default'           => '0',
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint', // đảm bảo là số nguyên dương
    ));

    $wp_customize->add_control('search_padding_left_control', array(
        'label'    => __('Padding với item trái (px)', 'mytheme'),
        'section'  => 'hm_search_settings',
        'settings' => 'search_padding_left',
        'type'     => 'number',
        'input_attrs' => array(
            'min' => 0,
            'step' => 1,
        ),
    ));

    // Padding Right
    $wp_customize->add_setting('search_padding_right', array(
        'default'           => '0',
        'transport'         => 'refresh',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('search_padding_right_control', array(
        'label'    => __('Padding với item phải (px)', 'mytheme'),
        'section'  => 'hm_search_settings',
        'settings' => 'search_padding_right',
        'type'     => 'number',
        'input_attrs' => array(
            'min' => 0,
            'step' => 1,
        ),
    ));

    // Chiều rộng search
    $wp_customize->add_setting('search_width', array(
        'default' => '200',
        'transport' => 'refresh',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('search_width', array(
        'label'    => __('Chiều rộng thanh tìm kiếm (px)', 'mytheme'),
        'section'  => 'hm_search_settings',
        'type'     => 'number',
        'input_attrs' => array(
            'min' => 100,
            'max' => 500,
            'step' => 10,
        ),
    ));

    // Chiều cao search
    $wp_customize->add_setting('search_height', array(
        'default' => '40',
        'transport' => 'refresh',
        'sanitize_callback' => 'absint',
    ));

    $wp_customize->add_control('search_height', array(
        'label'    => __('Chiều cao thanh tìm kiếm (px)', 'mytheme'),
        'section'  => 'hm_search_settings',
        'type'     => 'number',
        'input_attrs' => array(
            'min' => 20,
            'max' => 100,
            'step' => 5,
        ),
    ));

    // Placeholder ô tìm kiếm
    $wp_customize->add_setting('search_placeholder', array(
        'default'   => 'Tìm kiếm…',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('search_placeholder', array(
        'label'    => __('Placeholder thanh tìm kiếm', 'mytheme'),
        'section'  => 'hm_search_settings',
        'type'     => 'text',
    ));

    // Bo tròn bên trái ô tìm kiếm
    $wp_customize->add_setting('search_border_radius_left', array(
        'default'   => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('search_border_radius_left', array(
        'label'    => __('Bo góc trái thanh tìm kiếm', 'mytheme'),
        'section'  => 'hm_search_settings',
        'type'     => 'text',
        'description' => __('Đơn vị (px, em, rem,...), ví dụ: 5px', 'mytheme'),
    ));

    // Bo tròn bên phải ô tìm kiếm
    $wp_customize->add_setting('search_border_radius_right', array(
        'default'   => 0,
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('search_border_radius_right', array(
        'label'    => __('Bo góc phải thanh tìm kiếm', 'mytheme'),
        'section'  => 'hm_search_settings',
        'type'     => 'text',
        'description' => __('Đơn vị (px, em, rem,...), ví dụ: 5px', 'mytheme'),
    ));

    // Thay đổi nội dung nút tìm kiếm
    $wp_customize->add_setting('search_button_html', array(
        'default' => 'Tìm...',
        'transport' => 'refresh',
        'sanitize_callback' => 'wp_kses_post', // Cho phép HTML cơ bản
    ));

    $wp_customize->add_control('search_button_html', array(
        'label'    => __('Nội dung nút tìm kiếm', 'mytheme'),
        'section'  => 'hm_search_settings',
        'type'     => 'textarea',
        'description' => __('Bạn có thể sử dụng text hoặc html trong nội dung nút tìm kiếm, ví dụ: "Tìm <i class="fa-solid fa-magnifying-glass"></i>"', 'mytheme'),
    ));

    // Màu chữ nút tìm kiếm
    $wp_customize->add_setting('search_button_text_color', array(
        'default' => '#ffffff',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'search_button_text_color', array(
        'label' => __('Màu chữ nút tìm kiếm', 'mytheme'),
        'section' => 'hm_search_settings',
        'settings' => 'search_button_text_color',
    )));

    // Màu nền nút tìm kiếm
    $wp_customize->add_setting('search_button_background_color', array(
        'default' => '#0073aa',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'search_button_background_color',
        array(
            'label'    => __('Màu nền nút tìm kiếm', 'mytheme'),
            'section'  => 'hm_search_settings',
            'settings' => 'search_button_background_color',
        )
    ));

    // Font size nút tìm kiếm
    $wp_customize->add_setting('search_button_font_size', array(
        'default' => '16px',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('search_button_font_size', array(
        'label'    => __('Font size nút tìm kiếm', 'mytheme'),
        'section'  => 'hm_search_settings',
        'type'     => 'text',
        'description' => __('Đơn vị (px, rem, em,....), ví dụ: 16px', 'mytheme'),
    ));

    // Margin nút tìm kiếm (4 hướng)
    $wp_customize->add_setting('search_button_margin', array(
        'default' => '0',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('search_button_margin', array(
        'label'    => __('Margin nút tìm kiếm', 'mytheme'),
        'section'  => 'hm_search_settings',
        'type'    => 'text',
        'description' => __('Nhập theo cú pháp CSS theo thứ tự [top, right, bottom, left]. Đơn vị (px, rem, em,....), ví dụ: 10px 20px 10px 20px', 'mytheme'),
    ));

    // Padding nội dung bên trong nút tìm kiếm
    $wp_customize->add_setting('search_button_padding', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('search_button_padding', array(
        'label'    => __('Padding nút tìm kiếm', 'mytheme'),
        'section'  => 'hm_search_settings',
        'type'     => 'text',
        'description' => __('Nhập theo cú pháp CSS theo tứ tự [top-bottom] và [left-right]. Đơn vị (px, rem, em,....), ví dụ: 10px 20px', 'mytheme'),
    ));

    // Border radius nút tìm kiếm
    $wp_customize->add_setting('search_button_border_radius', array(
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('search_button_border_radius', array(
        'label' => __('Bo tròn nút tìm kiếm', 'mytheme'),
        'section' => 'hm_search_settings',
        'type' => 'text',
        'description' => __('Nhập theo cú pháp CSS theo tứ tự [top-left], [top-right], [bottom-right], [bottom-left]. Đơn vị (px, rem, em,....), ví dụ: 5px 10px 5px 10px', 'mytheme'),
    ));
}
add_action('customize_register', 'mytheme_customize_register');
