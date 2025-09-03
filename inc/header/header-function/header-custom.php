<?php
function mytheme_customize_register($wp_customize)
{
    // PANEL: HEADER
    $wp_customize->add_panel('header_main_panel', array(
        'title'    => __('Header', 'mytheme'),
        'priority' => 1,
    ));

    $site_identity_section = $wp_customize->get_section('title_tagline');

    if ( $site_identity_section ) {
        $site_identity_section->panel = 'header_main_panel';
        $site_identity_section->title = __( 'Logo & Site Identity', 'mytheme' );
        $site_identity_section->priority = 1;
    }

    // Section: Top Bar
    $wp_customize->add_section('ht_topbar_section', array(
        'title'       => __('Top Bar', 'mytheme'),
        'panel'       => 'header_main_panel', 
        'description' => __('Đây là mục chỉnh sửa các thành phần của Top Bar.', 'mytheme'),
        'priority'    => 2,
    ));

    // Bật/Tắt Topbar trên Desktop
    $wp_customize->add_setting('ht_topbar_show_desktop', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_topbar_show_desktop_control', [
        'label'    => __('Hiển thị Topbar trên Desktop', 'ht'),
        'section'  => 'ht_topbar_section', // Đảm bảo đúng tên section
        'settings' => 'ht_topbar_show_desktop',
        'type'     => 'checkbox',
    ]);

    // Bật/Tắt Topbar trên Mobile/Tablet
    $wp_customize->add_setting('ht_topbar_show_mobile', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_topbar_show_mobile_control', [
        'label'    => __('Hiển thị Topbar trên Mobile/Tablet', 'ht'),
        'section'  => 'ht_topbar_section',
        'settings' => 'ht_topbar_show_mobile',
        'type'     => 'checkbox',
    ]);

    // Background color Top Bar
    $wp_customize->add_setting('topbar_background_color', array(
        'default'           => '#f8f9fa', 
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'topbar_background_color_control',
        array(
            'label'    => __('Màu nền Top Bar', 'mytheme'),
            'section'  => 'ht_topbar_section',
            'settings' => 'topbar_background_color',
        )
    ));

    // Background image Top Bar
    $wp_customize->add_setting('topbar_bg_image', array(
        'default'           => '', 
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'topbar_bg_image_control',
        array(
            'label'       => __('Ảnh nền Top Bar', 'mytheme'),
            'description' => __('Tải lên một ảnh để làm nền cho Top Bar.', 'mytheme'),
            'section'     => 'ht_topbar_section',
            'settings'    => 'topbar_bg_image',
        )
    ));

    // Color Top Bar
    $wp_customize->add_setting('topbar_color', array(
        'default'           => '#333333', // Thay đổi màu mặc định nếu muốn
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));

    $wp_customize->add_control(new WP_Customize_Color_Control(
        $wp_customize,
        'topbar_color_control',
        array(
            'label'    => __('Màu chữ Top Bar', 'mytheme'),
            'section'  => 'ht_topbar_section',
            'settings' => 'topbar_color',
        )
    ));

    // Margin Top Bar
    $wp_customize->add_setting('topbar_margin', array(
        'default'           => '0',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('topbar_margin_control', array(
        'label'       => __('Margin Top Bar', 'mytheme'),
        'section'     => 'ht_topbar_section',
        'settings'    => 'topbar_margin',
        'type'        => 'text',
        'description' => __('Nhập theo cú pháp CSS, ví dụ: 0 0 10px 0', 'mytheme'),
    ));

    // Padding Top Bar
    $wp_customize->add_setting('topbar_padding', array(
        'default'           => '10px 0', // Thay đổi padding mặc định nếu muốn
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('topbar_padding_control', array(
        'label'       => __('Padding nội dung Top Bar', 'mytheme'),
        'section'     => 'ht_topbar_section',
        'settings'    => 'topbar_padding',
        'type'        => 'text',
        'description' => __('Nhập theo cú pháp CSS, ví dụ: 10px 0', 'mytheme'),
    ));

    // Border radius Top Bar
    $wp_customize->add_setting('topbar_border_radius', array(
        'default'           => '0',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('topbar_border_radius_control', array(
        'label'       => __('Bo tròn Top Bar', 'mytheme'),
        'section'     => 'ht_topbar_section',
        'settings'    => 'topbar_border_radius',
        'type'        => 'text',
        'description' => __('Nhập theo cú pháp CSS, ví dụ: 0 0 10px 10px)', 'mytheme'),
    ));
    
    // Section: Header Main
    $wp_customize->add_section('hm_header_main', array(
        'title'    => __('Header Main', 'mytheme'),
        'panel'    => 'header_main_panel',
        'description' => __('Đây là mục chỉnh sửa các thành phần chính của header.', 'mytheme'),
        'priority' => 3,
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

    $wp_customize->add_setting('header_main_bg_image', array(
        'default'           => '', 
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));

    // Thêm control để người dùng có thể tải ảnh lên
    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'header_main_bg_image_control',
        array(
            'label'      => __('Ảnh nền header chính', 'mytheme'),
            'description' => __('Tải lên một ảnh để làm nền cho header.', 'mytheme'),
            'section'    => 'hm_header_main',
            'settings'   => 'header_main_bg_image',
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
            'label'    => __('Màu chữ header chính', 'mytheme'),
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

    // Section: Header Bottom
    $wp_customize->add_section('ht_header_bottom_section', array(
        'title'       => __('Header Bottom', 'mytheme'),
        'panel'       => 'header_main_panel',
        'description' => __('Đây là mục chỉnh sửa các thành phần của Header Bottom.', 'mytheme'),
        'priority'    => 5, // Đặt priority để nó hiện sau Header Main
    ));

    // Bật/Tắt Header Bottom trên Desktop
    $wp_customize->add_setting('ht_header_bottom_show_desktop', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_header_bottom_show_desktop_control', [
        'label'    => __('Hiển thị Header Bottom trên Desktop', 'ht'),
        'section'  => 'ht_header_bottom_section', // Đảm bảo đúng tên section
        'settings' => 'ht_header_bottom_show_desktop',
        'type'     => 'checkbox',
    ]);

    // Bật/Tắt Header Bottom trên Mobile/Tablet
    $wp_customize->add_setting('ht_header_bottom_show_mobile', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_header_bottom_show_mobile_control', [
        'label'    => __('Hiển thị Header Bottom trên Mobile/Tablet', 'ht'),
        'section'  => 'ht_header_bottom_section',
        'settings' => 'ht_header_bottom_show_mobile',
        'type'     => 'checkbox',
    ]);

    // Background color Header Bottom
    $wp_customize->add_setting('header_bottom_background_color', array(
        'default'           => '#ffffff',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_bottom_background_color_control', array(
        'label'    => __('Màu nền Header Bottom', 'mytheme'),
        'section'  => 'ht_header_bottom_section',
        'settings' => 'header_bottom_background_color',
    )));

    // Background image Header Bottom
    $wp_customize->add_setting('header_bottom_bg_image', array(
        'default'           => '', 
        'transport'         => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ));
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'header_bottom_bg_image_control', array(
        'label'       => __('Ảnh nền Header Bottom', 'mytheme'),
        'description' => __('Tải lên một ảnh để làm nền cho Header Bottom.', 'mytheme'),
        'section'     => 'ht_header_bottom_section',
        'settings'    => 'header_bottom_bg_image',
    )));

    // Color Header Bottom
    $wp_customize->add_setting('header_bottom_color', array(
        'default'           => '#333333',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'header_bottom_color_control', array(
        'label'    => __('Màu chữ Header Bottom', 'mytheme'),
        'section'  => 'ht_header_bottom_section',
        'settings' => 'header_bottom_color',
    )));

    // Margin Header Bottom
    $wp_customize->add_setting('header_bottom_margin', array(
        'default'           => '0',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('header_bottom_margin_control', array(
        'label'       => __('Margin Header Bottom', 'mytheme'),
        'section'     => 'ht_header_bottom_section',
        'settings'    => 'header_bottom_margin',
        'type'        => 'text',
        'description' => __('Nhập theo cú pháp CSS, ví dụ: 0 0 10px 0', 'mytheme'),
    ));

    // Padding Header Bottom
    $wp_customize->add_setting('header_bottom_padding', array(
        'default'           => '10px 0',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('header_bottom_padding_control', array(
        'label'       => __('Padding nội dung Header Bottom', 'mytheme'),
        'section'     => 'ht_header_bottom_section',
        'settings'    => 'header_bottom_padding',
        'type'        => 'text',
        'description' => __('Nhập theo cú pháp CSS, ví dụ: 10px 0', 'mytheme'),
    ));

    // Border radius Header Bottom
    $wp_customize->add_setting('header_bottom_border_radius', array(
        'default'           => '0',
        'transport'         => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    $wp_customize->add_control('header_bottom_border_radius_control', array(
        'label'       => __('Bo tròn Header Bottom', 'mytheme'),
        'section'     => 'ht_header_bottom_section',
        'settings'    => 'header_bottom_border_radius',
        'type'        => 'text',
        'description' => __('Nhập theo cú pháp CSS, ví dụ: 0 0 10px 10px)', 'mytheme'),
    ));

    // Section: Logo settings
    $wp_customize->add_section('hm_logo_settings', array(
        'title'    => __('Logo Settings', 'mytheme'),
        'panel'    => 'header_main_panel',
        'priority' => '15'
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
        'priority' => '16'
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
        'priority' => '17'
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
        'default' => '<i class="fa-solid fa-magnifying-glass"></i>',
        'type'     => 'textarea',
        'description' => __('Bạn có thể sử dụng text hoặc html trong nội dung nút tìm kiếm. Có thể sử dụng font awesome', 'mytheme'),
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
        'default' => '-5px',
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
        'default' => '10px',
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
        'default' => '0px 5px 5px 0px',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ));

    $wp_customize->add_control('search_button_border_radius', array(
        'label' => __('Bo tròn nút tìm kiếm', 'mytheme'),
        'section' => 'hm_search_settings',
        'type' => 'text',
        'description' => __('Nhập theo cú pháp CSS theo tứ tự [top-left], [top-right], [bottom-right], [bottom-left]. Đơn vị (px, rem, em,....), ví dụ: 5px 10px 5px 10px', 'mytheme'),
    ));

    // Danh sách các mạng xã hội và thông tin liên hệ
    $networks = [
        'facebook'    => ['label' => 'Facebook', 'type' => 'url'],
        'threads'     => ['label' => 'Threads', 'type' => 'url'],
        'instagram'   => ['label' => 'Instagram', 'type' => 'url'],
        'tiktok'      => ['label' => 'TikTok', 'type' => 'url'],
        'youtube'     => ['label' => 'YouTube', 'type' => 'url'],
        'twitter'     => ['label' => 'Twitter (cũ)', 'type' => 'url'],
        'x-twitter'   => ['label' => 'X (Twitter mới)', 'type' => 'url'],
        'telegram'    => ['label' => 'Telegram', 'type' => 'url'],
        'discord'     => ['label' => 'Discord', 'type' => 'url'],
        'phone'       => ['label' => 'Số điện thoại', 'type' => 'text'],
        'email'       => ['label' => 'Địa chỉ Email', 'type' => 'email'],
    ];

    $wp_customize->add_section('ht_social_section', [
        'title'    => __('Mạng xã hội & Liên hệ', 'my-theme'),
        'panel' => 'header_main_panel',
        'description' => __('Nhập đường link đầy đủ (VD: https://facebook.com/...) hoặc thông tin liên hệ. Bỏ trống nếu không muốn hiển thị.', 'my-theme'),
        'priority' => '20'
    ]);

    foreach ($networks as $key => $details) {
        // Thêm Setting
        $wp_customize->add_setting("ht_social_{$key}_url", [
            'default'           => '',
            'sanitize_callback' => ($details['type'] === 'email') ? 'sanitize_email' : (($details['type'] === 'url') ? 'esc_url_raw' : 'sanitize_text_field'),
        ]);

        // Thêm Control
        $wp_customize->add_control("ht_social_{$key}_url", [
            'label'   => $details['label'],
            'section' => 'ht_social_section',
            'type'    => $details['type'],
        ]);
    }

    //contact
    $wp_customize->add_section('ht_hotline_section', [
    'title'       => __('Contact', 'ht'),
    'priority'    => 15,
    'panel'       => 'header_main_panel',
    ]);

    // --- TÙY CHỈNH ICON ---
    $wp_customize->add_setting('ht_hotline_icon_class', ['default' => 'fas fa-phone', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('ht_hotline_icon_class', ['label' => __('Icon Class (Font Awesome)', 'ht'), 'section' => 'ht_hotline_section', 'type' => 'text']);

    $wp_customize->add_setting('ht_hotline_icon_size', ['default' => 50, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('ht_hotline_icon_size', ['label' => __('Kích thước Icon (px)', 'ht'), 'section' => 'ht_hotline_section', 'type' => 'number']);

    $wp_customize->add_setting('ht_hotline_icon_font_size', ['default' => 20, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('ht_hotline_icon_font_size', ['label' => __('Kích thước Font Icon (px)', 'ht'), 'section' => 'ht_hotline_section', 'type' => 'number']);

    $wp_customize->add_setting('ht_hotline_icon_color', ['default' => 'orange', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_hotline_icon_color', ['label' => __('Màu Icon', 'ht'), 'section' => 'ht_hotline_section']));

    $wp_customize->add_setting('ht_hotline_icon_bg_color', ['default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_hotline_icon_bg_color', ['label' => __('Màu nền Icon', 'ht'), 'section' => 'ht_hotline_section']));

    $wp_customize->add_setting('ht_hotline_icon_border_color', ['default' => 'orange', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_hotline_icon_border_color', ['label' => __('Màu viền Icon', 'ht'), 'section' => 'ht_hotline_section']));

    // --- TÙY CHỈNH TEXT ---
    $wp_customize->add_setting('ht_hotline_text_top', ['default' => 'Hotline', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('ht_hotline_text_top', ['label' => __('Dòng chữ trên', 'ht'), 'section' => 'ht_hotline_section', 'type' => 'text']);

    $wp_customize->add_setting('ht_hotline_text_top_color', ['default' => '#000000', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_hotline_text_top_color', ['label' => __('Màu dòng chữ trên', 'ht'), 'section' => 'ht_hotline_section']));

    $wp_customize->add_setting('ht_hotline_number', ['default' => '123.456.789', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('ht_hotline_number', ['label' => __('Số điện thoại', 'ht'), 'section' => 'ht_hotline_section', 'type' => 'text']);

    $wp_customize->add_setting('ht_hotline_number_color', ['default' => 'red', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_hotline_number_color', ['label' => __('Màu số điện thoại', 'ht'), 'section' => 'ht_hotline_section']));


    // cart
    $wp_customize->add_section('ht_cart_section', [
    'title'       => __('Giỏ hàng (Cart)', 'ht'),
    'priority'    => 18,
    'panel'       => 'header_main_panel',
    ]);

    // --- TÙY CHỈNH ICON ---
    $wp_customize->add_setting('ht_cart_icon_type', ['default' => 'preset', 'sanitize_callback' => 'sanitize_key']);
    $wp_customize->add_control('ht_cart_icon_type', ['label' => __('Loại Icon', 'ht'),'section' => 'ht_cart_section','type' => 'radio','choices' => ['preset' => __('Chọn từ danh sách', 'ht'),'custom' => __('Tải ảnh lên', 'ht'),]]);

    $wp_customize->add_setting('ht_cart_preset_icon', ['default' => 'fas fa-shopping-cart','sanitize_callback' => 'sanitize_text_field',]);
    $wp_customize->add_control('ht_cart_preset_icon', ['label' => __('Chọn Icon có sẵn', 'ht'),'section' => 'ht_cart_section','type' => 'radio','choices' => ['fas fa-shopping-basket' => __('Giỏ Xách', 'ht'),'fas fa-shopping-cart' => __('Xe Đẩy', 'ht'),'fas fa-shopping-bag' => __('Túi Xách', 'ht'),],'active_callback' => function() use ($wp_customize) { return $wp_customize->get_setting('ht_cart_icon_type')->value() === 'preset'; },]);

    $wp_customize->add_setting('ht_cart_custom_icon');
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'ht_cart_custom_icon', ['label' => __('Tải lên Icon tùy chỉnh', 'ht'),'section' => 'ht_cart_section','active_callback' => function() use ($wp_customize) { return $wp_customize->get_setting('ht_cart_icon_type')->value() === 'custom'; },]));

    // MỚI: Tùy chọn kích thước font cho Icon (Theo yêu cầu)
    $wp_customize->add_setting('ht_cart_icon_font_size', ['default' => 18, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('ht_cart_icon_font_size', ['label' => __('Kích thước Font Icon (px)', 'ht'), 'section' => 'ht_cart_section', 'type' => 'number']);


    // --- TÙY CHỈNH HIỂN THỊ & TEXT ---
    $wp_customize->add_setting('ht_cart_display_title', ['default' => true, 'sanitize_callback' => 'wp_validate_boolean']);
    $wp_customize->add_control('ht_cart_display_title', ['label' => __('Hiển thị chữ "Giỏ hàng"', 'ht'), 'section' => 'ht_cart_section', 'type' => 'checkbox']);

    $wp_customize->add_setting('ht_cart_display_price', ['default' => false, 'sanitize_callback' => 'wp_validate_boolean']);
    $wp_customize->add_control('ht_cart_display_price', ['label' => __('Hiển thị tổng giá tiền', 'ht'), 'section' => 'ht_cart_section', 'type' => 'checkbox']);

    // MỚI: Tùy chọn kích thước font cho chữ (Theo yêu cầu)
    $wp_customize->add_setting('ht_cart_text_font_size', ['default' => 14, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('ht_cart_text_font_size', ['label' => __('Kích thước chữ (px)', 'ht'), 'section' => 'ht_cart_section', 'type' => 'number']);


    // --- TÙY CHỈNH STYLE NÚT BẤM ---
    $wp_customize->add_setting('ht_cart_padding', ['default' => '8px', 'sanitize_callback' => 'sanitize_text_field']);
    $wp_customize->add_control('ht_cart_padding', ['label' => __('Padding nút (Vd: 8px)', 'ht'), 'section' => 'ht_cart_section', 'type' => 'text']);

    // Style trạng thái bình thường
    $wp_customize->add_setting('ht_cart_bg_color', ['default' => '', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_cart_bg_color', ['label' => __('Màu nền', 'ht'), 'section' => 'ht_cart_section']));

    $wp_customize->add_setting('ht_cart_text_color', ['default' => '#000000', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_cart_text_color', ['label' => __('Màu chữ & Icon', 'ht'), 'section' => 'ht_cart_section']));

    $wp_customize->add_setting('ht_cart_border_color', ['default' => '#000000', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_cart_border_color', ['label' => __('Màu viền', 'ht'), 'section' => 'ht_cart_section']));

    // Style trạng thái HOVER
    $wp_customize->add_setting('ht_cart_bg_color_hover', ['default' => '#000000', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_cart_bg_color_hover', ['label' => __('Màu nền (Khi di chuột)', 'ht'), 'section' => 'ht_cart_section']));

    $wp_customize->add_setting('ht_cart_text_color_hover', ['default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_cart_text_color_hover', ['label' => __('Màu chữ & Icon (Khi di chuột)', 'ht'), 'section' => 'ht_cart_section']));

    $wp_customize->add_setting('ht_cart_border_color_hover', ['default' => '#ffffff', 'sanitize_callback' => 'sanitize_hex_color']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_cart_border_color_hover', ['label' => __('Màu viền (Khi di chuột)', 'ht'), 'section' => 'ht_cart_section']));

    // Tùy chỉnh viền
    $wp_customize->add_setting('ht_cart_border_width', ['default' => 1, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('ht_cart_border_width', ['label' => __('Độ dày viền (px)', 'ht'), 'section' => 'ht_cart_section', 'type' => 'number']);

    $wp_customize->add_setting('ht_cart_border_radius', ['default' => 8, 'sanitize_callback' => 'absint']);
    $wp_customize->add_control('ht_cart_border_radius', ['label' => __('Bo tròn viền (px)', 'ht'), 'section' => 'ht_cart_section', 'type' => 'number']);


    //login
    $wp_customize->add_section('ht_login_component_section', [
        'title'    => __('Thiết lập Login', 'ht'),
        'priority'   => 19,
        'panel'      => 'header_main_panel',
    ]);

    // --- Cài đặt cho ICON CHÍNH (USER) ---
    $wp_customize->add_setting('ht_login_show_icon', ['default' => true]);
    $wp_customize->add_control('ht_login_show_icon_control', [
        'label'    => __('Hiển thị Icon', 'ht'),
        'section'  => 'ht_login_component_section', 'settings' => 'ht_login_show_icon', 'type'     => 'checkbox',
    ]);

    // MỚI: Tùy chỉnh kích thước icon
    $wp_customize->add_setting('ht_login_icon_font_size', ['default' => 14]);
    $wp_customize->add_control('ht_login_icon_font_size_control', [
        'label'       => __('Kích thước Icon (px)', 'ht'),
        'section'     => 'ht_login_component_section', 'settings'    => 'ht_login_icon_font_size', 'type'        => 'number',
        'input_attrs' => ['min' => 10, 'max' => 30, 'step' => 1],
    ]);

    $wp_customize->add_setting('ht_login_icon_bg_color', ['default' => '#000000']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_login_icon_bg_color_control', [
        'label'    => __('Màu nền Icon', 'ht'),
        'section'  => 'ht_login_component_section', 'settings' => 'ht_login_icon_bg_color',
    ]));

    $wp_customize->add_setting('ht_login_icon_border_radius', ['default' => 50]);
    $wp_customize->add_control('ht_login_icon_border_radius_control', [
        'label'       => __('Bo góc Icon (px)', 'ht'),
        'section'     => 'ht_login_component_section', 'settings'    => 'ht_login_icon_border_radius', 'type'        => 'number',
        'input_attrs' => ['min' => 0, 'max' => 50, 'step' => 1],
    ]);

    // --- Cài đặt cho NHÃN (LABEL) & TEXT ---
    $wp_customize->add_setting('ht_login_show_label', ['default' => true]);
    $wp_customize->add_control('ht_login_show_label_control', [
        'label'    => __('Hiển thị Nhãn', 'ht'),
        'section'  => 'ht_login_component_section', 'settings' => 'ht_login_show_label', 'type'     => 'checkbox',
    ]);

    $wp_customize->add_setting('ht_login_label_text', ['default' => 'Đăng nhập']);
    $wp_customize->add_control('ht_login_label_text_control', [
        'label'    => __('Nội dung Nhãn (khi chưa đăng nhập)', 'ht'),
        'section'  => 'ht_login_component_section', 'settings' => 'ht_login_label_text', 'type'     => 'text',
    ]);

    // MỚI: Tùy chỉnh màu chữ
    $wp_customize->add_setting('ht_login_text_color', ['default' => '#333333']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_login_text_color_control', [
        'label'    => __('Màu chữ', 'ht'),
        'section'  => 'ht_login_component_section', 'settings' => 'ht_login_text_color',
    ]));

    // MỚI: Tùy chỉnh màu chữ khi hover
    $wp_customize->add_setting('ht_login_text_hover_color', ['default' => '#007bff']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_login_text_hover_color_control', [
        'label'    => __('Màu chữ khi Hover', 'ht'),
        'section'  => 'ht_login_component_section', 'settings' => 'ht_login_text_hover_color',
    ]));

    $wp_customize->add_setting('ht_login_show_username', ['default' => true]);
    $wp_customize->add_control('ht_login_show_username_control', [
        'label'       => __('Hiển thị Tên người dùng (khi đã đăng nhập)', 'ht'),
        'description' => __('Nếu bật, sẽ hiển thị "Chào, [Tên]". Nếu tắt, sẽ không hiển thị gì.', 'ht'),
        'section'     => 'ht_login_component_section', 'settings'    => 'ht_login_show_username', 'type'        => 'checkbox',
    ]);

    // --- Cài đặt cho ICON ĐĂNG XUẤT ---
    // MỚI: Tùy chỉnh màu icon đăng xuất
    $wp_customize->add_setting('ht_login_logout_icon_color', ['default' => '#6c757d']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_login_logout_icon_color_control', [
        'label'    => __('Màu Icon Đăng xuất', 'ht'),
        'section'  => 'ht_login_component_section', 'settings' => 'ht_login_logout_icon_color',
    ]));

    // MỚI: Tùy chỉnh màu icon đăng xuất khi hover
    $wp_customize->add_setting('ht_login_logout_icon_hover_color', ['default' => '#dc3545']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_login_logout_icon_hover_color_control', [
        'label'    => __('Màu Icon Đăng xuất khi Hover', 'ht'),
        'section'  => 'ht_login_component_section', 'settings' => 'ht_login_logout_icon_hover_color',
    ]));

    // --- MỚI: Cài đặt cho KIỂU DÁNG NÚT ĐĂNG NHẬP ---
    $wp_customize->add_setting('ht_login_button_bg_color', ['default' => 'rgba(0,0,0,0)']); // Mặc định trong suốt
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_login_button_bg_color_control', [
        'label'       => __('Màu nền Nút Đăng nhập', 'ht'),
        'description' => __('Áp dụng cho nhãn "Đăng nhập" khi chưa đăng nhập.', 'ht'),
        'section'     => 'ht_login_component_section', 'settings'    => 'ht_login_button_bg_color',
    ]));

    $wp_customize->add_setting('ht_login_button_bg_hover_color', ['default' => '#e9ecef']);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_login_button_bg_hover_color_control', [
        'label'    => __('Màu nền Nút Đăng nhập khi Hover', 'ht'),
        'section'  => 'ht_login_component_section', 'settings' => 'ht_login_button_bg_hover_color',
    ]));

    $wp_customize->add_setting('ht_login_button_padding', ['default' => '8px 12px']);
    $wp_customize->add_control('ht_login_button_padding_control', [
        'label'       => __('Padding Nút Đăng nhập', 'ht'),
        'description' => __('Ví dụ: 8px 12px', 'ht'),
        'section'     => 'ht_login_component_section', 'settings'    => 'ht_login_button_padding', 'type'        => 'text',
    ]);

    $wp_customize->add_setting('ht_login_button_border_radius', ['default' => 4]);
    $wp_customize->add_control('ht_login_button_border_radius_control', [
        'label'       => __('Bo góc Nút Đăng nhập (px)', 'ht'),
        'section'     => 'ht_login_component_section', 'settings'    => 'ht_login_button_border_radius', 'type'        => 'number',
        'input_attrs' => ['min' => 0, 'max' => 50, 'step' => 1],
    ]);

    //sticky down
    $wp_customize->add_section('ht_sticky_header_section', [
        'title'    => __('Sticky Header', 'ht'),
        'priority' => 10,
        'panel'       => 'header_main_panel',
    ]);

    // 2. Setting và Control cho Top Bar
    $wp_customize->add_setting('ht_sticky_topbar_enabled', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_sticky_topbar_control', [
        'label'    => __('Top Bar - Sticky on Scroll', 'ht'),
        'section'  => 'ht_sticky_header_section',
        'settings' => 'ht_sticky_topbar_enabled',
        'type'     => 'checkbox',
    ]);

    // 3. Setting và Control cho Header Main
    $wp_customize->add_setting('ht_sticky_header_main_enabled', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_sticky_header_main_control', [
        'label'    => __('Header Main - Sticky on Scroll', 'ht'),
        'section'  => 'ht_sticky_header_section',
        'settings' => 'ht_sticky_header_main_enabled',
        'type'     => 'checkbox',
    ]);

    // 4. Setting và Control cho Header Bottom
    $wp_customize->add_setting('ht_sticky_header_bottom_enabled', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_sticky_header_bottom_control', [
        'label'    => __('Header Bottom - Sticky on Scroll', 'ht'),
        'section'  => 'ht_sticky_header_section',
        'settings' => 'ht_sticky_header_bottom_enabled',
        'type'     => 'checkbox',
    ]);


    // Thêm Section mới vào Panel "Header"
    $wp_customize->add_section('ht_mobile_menu_section', [
        'title'    => __('Header Mobile Menu / Overlay', 'ht'),
        'priority' => 6,
        'panel'    => 'header_main_panel', // Đảm bảo bạn có panel này
    ]);

    // Vị trí
    $wp_customize->add_setting('ht_mobile_overlay_position', [
        'default'           => 'right', // Giữ nguyên mặc định là 'right'
        'sanitize_callback' => 'ht_sanitize_radio_choices', 
    ]);
    $wp_customize->add_control('ht_mobile_overlay_position_control', [
        'label'   => __('Vị trí Menu Overlay', 'ht'),
        'section' => 'ht_mobile_menu_section',
        'settings' => 'ht_mobile_overlay_position',
        'type'    => 'radio',
        'choices' => [
            'left'  => __('Bên trái', 'ht'),
            'right' => __('Bên phải', 'ht'),
        ],
    ]);

    // Màu nền
    $wp_customize->add_setting('ht_mobile_bg_color', [
        'default'           => '#ffffff',
        'sanitize_callback' => 'sanitize_hex_color',
    ]);
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'ht_mobile_bg_color_control', [
        'label'    => __('Màu nền Menu Overlay', 'ht'),
        'section'  => 'ht_mobile_menu_section',
        'settings' => 'ht_mobile_bg_color',
    ]));

    // Hành vi Click
    $wp_customize->add_setting('ht_mobile_submenu_click_behavior', [
        'default'           => 'toggle_submenu', // Giữ nguyên mặc định là 'toggle_submenu'
        'sanitize_callback' => 'ht_sanitize_radio_choices',
    ]);
    $wp_customize->add_control('ht_mobile_submenu_click_behavior_control', [
        'label'       => __('Hành vi khi click vào mục cha', 'ht'),
        'description' => __('Hành vi của mục menu có menu con.', 'ht'),
        'section'     => 'ht_mobile_menu_section',
        'settings'    => 'ht_mobile_submenu_click_behavior',
        'type'        => 'radio',
        'choices'     => [
            'open_link'      => __('Mở liên kết', 'ht'),
            'toggle_submenu' => __('Mở menu con', 'ht'),
        ],
    ]);

    // Hiệu ứng Submenu
    $wp_customize->add_setting('ht_mobile_submenu_effect', [
        'default'           => 'slide', // THAY ĐỔI: Mặc định là 'slide'
        'sanitize_callback' => 'ht_sanitize_radio_choices',
    ]);
    $wp_customize->add_control('ht_mobile_submenu_effect_control', [
        'label'   => __('Hiệu ứng Menu con', 'ht'),
        'section' => 'ht_mobile_menu_section',
        'settings' => 'ht_mobile_submenu_effect',
        'type'    => 'radio',
        'choices' => [
            'accordion' => __('Accordion (Sổ xuống)', 'ht'),
            'slide'     => __('Slide (Trượt ngang)', 'ht'),
        ],
    ]);

    // Danh sách các thành phần
    $wp_customize->add_setting('ht_mobile_menu_elements', [
        'default'   => json_encode([
            ['id' => 'search', 'visible' => true],
            ['id' => 'menu', 'visible' => true],
            ['id' => 'login', 'visible' => true],
            ['id' => 'social', 'visible' => false],
        ]),
        'transport' => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ]);

    // Tải và sử dụng Custom Control
    require_once(get_template_directory() . '/inc/header/header-builder/class-mobile-menu-elements-control.php');
    $wp_customize->add_control(new HT_Mobile_Menu_Elements_Control($wp_customize, 'ht_mobile_menu_elements_control', [
        'label'    => __('Thành phần Menu Mobile', 'ht'),
        'section'  => 'ht_mobile_menu_section',
        'settings' => 'ht_mobile_menu_elements',
    ]));

    if (!function_exists('ht_sanitize_radio_choices')) {
        function ht_sanitize_radio_choices($input, $setting) {
            $choices = $setting->manager->get_control($setting->id)->choices;
            if (array_key_exists($input, $choices)) {
                return $input;
            }
            return $setting->default;
        }
    }

    if (function_exists('ht_blog_customizer_register')) {
        ht_blog_customizer_register($wp_customize);
    }
}
add_action('customize_register', 'mytheme_customize_register');

