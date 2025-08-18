<?php

/**
 * Thêm tùy chọn Custom CSS vào Customizer.
 *
 * Hàm này sẽ tạo một section mới tên là "Custom CSS" bên trong panel "Style"
 * mà chúng ta đã tạo ở các bước trước.
 *
 * @param WP_Customize_Manager $wp_customize The Customizer object.
 */
function ht_add_custom_css_options($wp_customize)
{
    // Thêm Section "Custom CSS" vào Panel "Style" đã có
    // Nếu bạn chưa có panel 'ht_style_panel', bạn cần tạo nó trước.
    // Nếu bạn đang dùng code từ các câu trả lời trước của tôi thì panel này đã tồn tại.
    $wp_customize->add_section('ht_custom_css_section', [
        'title'    => __('Custom CSS', 'ht'),
        'panel'    => 'ht_style_panel', // Gán vào panel 'Style'
        'priority' => 150,
    ]);

    // 1. Thêm ô nhập CSS cho Desktop (áp dụng cho mọi màn hình)
    $wp_customize->add_setting('ht_custom_css_desktop', [
        'default'           => '',
        'sanitize_callback' => 'wp_strip_all_tags', // Hàm làm sạch để loại bỏ các thẻ HTML nguy hiểm
    ]);
    $wp_customize->add_control('ht_custom_css_desktop_control', [
        'label'       => __('Custom CSS', 'ht'),
        'description' => __('CSS tại đây sẽ áp dụng cho mọi kích thước màn hình.', 'ht'),
        'section'     => 'ht_custom_css_section',
        'settings'    => 'ht_custom_css_desktop',
        'type'        => 'textarea', // Loại control là một ô nhập liệu lớn
    ]);

    // 2. Thêm ô nhập CSS cho Tablet
    $wp_customize->add_setting('ht_custom_css_tablet', [
        'default'           => '',
        'sanitize_callback' => 'wp_strip_all_tags',
    ]);
    $wp_customize->add_control('ht_custom_css_tablet_control', [
        'label'       => __('Custom Tablet CSS', 'ht'),
        'description' => __('CSS tại đây chỉ áp dụng cho màn hình máy tính bảng (chiều rộng <= 1024px).', 'ht'),
        'section'     => 'ht_custom_css_section',
        'settings'    => 'ht_custom_css_tablet',
        'type'        => 'textarea',
    ]);

    // 3. Thêm ô nhập CSS cho Mobile
    $wp_customize->add_setting('ht_custom_css_mobile', [
        'default'           => '',
        'sanitize_callback' => 'wp_strip_all_tags',
    ]);
    $wp_customize->add_control('ht_custom_css_mobile_control', [
        'label'       => __('Custom Mobile CSS', 'ht'),
        'description' => __('CSS tại đây chỉ áp dụng cho màn hình điện thoại (chiều rộng <= 767px).', 'ht'),
        'section'     => 'ht_custom_css_section',
        'settings'    => 'ht_custom_css_mobile',
        'type'        => 'textarea',
    ]);
}
add_action('customize_register', 'ht_add_custom_css_options');


/**
 * In các đoạn CSS tùy chỉnh ra thẻ <head> của trang web.
 *
 * Hàm này sẽ lấy dữ liệu từ Customizer và đặt chúng vào trong các media query
 * tương ứng để áp dụng đúng trên từng loại thiết bị.
 */
function ht_output_custom_css()
{
    // Lấy giá trị CSS đã lưu
    $desktop_css = get_theme_mod('ht_custom_css_desktop', '');
    $tablet_css  = get_theme_mod('ht_custom_css_tablet', '');
    $mobile_css  = get_theme_mod('ht_custom_css_mobile', '');

    // Chỉ thực hiện nếu có ít nhất một ô CSS được điền
    if (empty($desktop_css) && empty($tablet_css) && empty($mobile_css)) {
        return;
    }

    // Bắt đầu in thẻ style
    echo '<style type="text/css" id="ht-theme-custom-css">';

    // In CSS cho Desktop
    if (!empty($desktop_css)) {
        echo "/* Custom Desktop CSS */\n";
        echo $desktop_css;
        echo "\n";
    }

    // In CSS cho Tablet (sử dụng media query)
    if (!empty($tablet_css)) {
        echo "/* Custom Tablet CSS */\n";
        echo "@media (max-width: 1024px) {\n";
        echo $tablet_css;
        echo "\n}\n";
    }

    // In CSS cho Mobile (sử dụng media query)
    if (!empty($mobile_css)) {
        echo "/* Custom Mobile CSS */\n";
        echo "@media (max-width: 767px) {\n";
        echo $mobile_css;
        echo "\n}\n";
    }

    echo '</style>';
}
add_action('wp_head', 'ht_output_custom_css', 999);
