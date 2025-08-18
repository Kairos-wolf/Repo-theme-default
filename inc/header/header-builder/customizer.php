<?php
function ht_customize_register($wp_customize)
{
    // Section Header
    $wp_customize->add_section('ht_header_builder', [
        'title' => __('Header Main Builder', 'ht'),
        'priority' => 30,
    ]);

    $wp_customize->add_setting('ht_header_layout', [
        'default' => json_encode(['logo', 'menu', 'search']),
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control(new HT_Header_Builder_Control(
        $wp_customize,
        'ht_header_layout',
        [
            'label' => __('Drag to reorder header items', 'ht'),
            'section' => 'ht_header_builder',
            'settings' => 'ht_header_layout',
        ]
    ));
    //
    $wp_customize->add_setting('ht_header_custom_html', [
        'default' => '<strong>Chào bạn!</strong>',
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control('ht_header_custom_html', [
        'label' => __('Custom HTML', 'ht'),
        'section' => 'ht_header_builder',
        'type' => 'textarea',
    ]);

    // Section Top Bar
    $wp_customize->add_section('ht_topbar_builder', [
        'title' => __('Top Bar Builder', 'ht'),
        'priority' => 29,
    ]);

    // Layout: Danh sách thứ tự các item (html1 → html8)
    $wp_customize->add_setting('ht_topbar_layout', [
        'default' => json_encode(['html1', 'html2']),
        'transport' => 'refresh',
    ]);

    $wp_customize->add_control(new HT_Topbar_Builder_Control(
        $wp_customize,
        'ht_topbar_layout',
        [
            'label' => __('Có thể thêm code html, icon, text,...', 'ht'),
            'section' => 'ht_topbar_builder',
            'settings' => 'ht_topbar_layout',
        ]
    ));

    // Tạo 8 custom HTML tương ứng với html1 → html8
    // Xử lý riêng mục đầu tiên
    $wp_customize->add_setting('ht_topbar_html1', [
        'default' =>
        "<div class='row'><div class='col'>Nội dung 1</div><div class='col'>Nội dung 2</div></div>",
        'transport' => 'refresh',
    ]);
    $wp_customize->add_control('ht_topbar_html1', [
        'label' => __("Chỉnh sửa HTML cho HTML1", 'ht'),
        'section' => 'ht_topbar_builder',
        'type' => 'textarea',
    ]);

    // Vòng lặp cho 7 mục còn lại (từ 2 đến 8)
    for ($i = 2; $i <= 8; $i++) {
        $setting_id = "ht_topbar_html{$i}";
        $wp_customize->add_setting($setting_id, [
            'default' => "<strong>HTML {$i} nội dung</strong>",
            'transport' => 'refresh',
        ]);

        $wp_customize->add_control($setting_id, [
            'label' => __("Chỉnh sửa HTML cho HTML{$i}", 'ht'),
            'section' => 'ht_topbar_builder',
            'type' => 'textarea',
        ]);
    }

    // Section Header Bottom
    $wp_customize->add_section('ht_headerbottom_builder', [
        'title' => __('Header Bottom Builder', 'ht'),
        'priority' => 30, // Đặt priority khác để không trùng với Top Bar
    ]);

    // Layout: Danh sách thứ tự các item cho Header Bottom
    $wp_customize->add_setting('ht_headerbottom_layout', [
        'default' => json_encode(['html1', 'html2']),
        'transport' => 'refresh',
        'sanitize_callback' => 'wp_kses_post',
    ]);

    // Thêm control kéo thả cho Header Bottom
    // Giả định bạn đã tạo file class-headerbottom-builder-control.php ở bước 2
    if (class_exists('HT_Headerbottom_Builder_Control')) {
        $wp_customize->add_control(new HT_Headerbottom_Builder_Control(
            $wp_customize,
            'ht_headerbottom_layout',
            [
                'label' => __('Kéo thả để sắp xếp các thành phần.', 'ht'),
                'section' => 'ht_headerbottom_builder',
                'settings' => 'ht_headerbottom_layout',
            ]
        ));
    }


    // Tạo 8 ô nhập liệu HTML tương ứng với html1 → html8 cho Header Bottom
    for ($i = 1; $i <= 8; $i++) {
        $setting_id = "ht_headerbottom_html{$i}";
        $wp_customize->add_setting($setting_id, [
            'default' => "<div class='row'><div class='col'>Nội dung</div></div>",
            'transport' => 'refresh',
            'sanitize_callback' => 'wp_kses_post',
        ]);

        $wp_customize->add_control($setting_id, [
            'label' => __("Chỉnh sửa HTML cho mục {$i}", 'ht'),
            'section' => 'ht_headerbottom_builder',
            'type' => 'textarea',
        ]);
    }
}
add_action('customize_register', 'ht_customize_register');
