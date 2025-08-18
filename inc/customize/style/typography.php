<?php

// Gọi API Google Fonts một lần và lưu vào transient để cache trong 24h
function ht_get_google_fonts_list()
{
    // Cảnh báo: API key này chỉ để minh họa, bạn nên thay bằng key của riêng bạn.
    $api_key = 'AIzaSyDitX4EXR2bnZ5txUD4i8L0FaCVz0AIgS4';
    $transient_key = 'ht_google_fonts_list';

    $fonts = get_transient($transient_key);
    if ($fonts === false) {
        $response = wp_remote_get("https://www.googleapis.com/webfonts/v1/webfonts?key={$api_key}");
        if (!is_wp_error($response) && wp_remote_retrieve_response_code($response) === 200) {
            $body = wp_remote_retrieve_body($response); // Đã sửa lỗi ở đây
            $data = json_decode($body, true);
            $fonts = [];

            if (isset($data['items'])) {
                foreach ($data['items'] as $font) {
                    $fonts[] = $font['family']; // Chỉ cần mảng các tên font
                }
                set_transient($transient_key, $fonts, 24 * HOUR_IN_SECONDS);
            }
        } else {
            $fonts = [];
        }
    }
    return $fonts;
}

// Thêm section chọn font vào panel Style
function ht_add_typography_customizer($wp_customize)
{
    $fonts = ht_get_google_fonts_list();

    // Tạo HTML cho thẻ <datalist> để tái sử dụng
    $datalist_html = '<datalist id="ht-google-fonts-list">';
    if (!empty($fonts)) {
        foreach ($fonts as $font) {
            $datalist_html .= '<option value="' . esc_attr($font) . '">';
        }
    }
    $datalist_html .= '</datalist>';

    $wp_customize->add_section('ht_typography_options', [
        'title'    => __('Typography', 'ht'),
        'panel'    => 'ht_style_panel',
        'priority' => 30,
    ]);

    // Font Body
    $wp_customize->add_setting('ht_font_body', [
        'default'           => 'Roboto',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ht_font_body', [
        'type'        => 'text',
        'label'       => __('Body Font', 'ht'),
        'section'     => 'ht_typography_options',
        'input_attrs' => [
            'list'        => 'ht-google-fonts-list',
            'placeholder' => 'Gõ để tìm font...',
        ],
        'description' => $datalist_html,
    ]);

    // Body Font Size
    $wp_customize->add_setting('ht_font_size_body', [
        'default'           => '16px',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ht_font_size_body', [
        'type'        => 'text',
        'label'       => __('Body Font Size', 'ht'),
        'section'     => 'ht_typography_options',
        'description' => __('E.g., 16px, 1.1em, 1rem', 'ht'),
    ]);

    // Body Line Height
    $wp_customize->add_setting('ht_line_height_body', [
        'default'           => '1.5',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ht_line_height_body', [
        'type'        => 'text',
        'label'       => __('Body Line Height', 'ht'),
        'section'     => 'ht_typography_options',
        'description' => __('E.g., 1.5, 24px', 'ht'),
    ]);

    // Body Letter Spacing
    $wp_customize->add_setting('ht_letter_spacing_body', [
        'default'           => '0px',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ht_letter_spacing_body', [
        'type'        => 'text',
        'label'       => __('Body Letter Spacing', 'ht'),
        'section'     => 'ht_typography_options',
        'description' => __('E.g., 0px, 0.05em', 'ht'),
    ]);


    // Font Heading
    $wp_customize->add_setting('ht_font_heading', [
        'default'           => 'Roboto',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ht_font_heading', [
        'type'        => 'text',
        'label'       => __('Heading Font (H1 - H6)', 'ht'),
        'section'     => 'ht_typography_options',
        'input_attrs' => [
            'list'        => 'ht-google-fonts-list',
            'placeholder' => 'Gõ để tìm font...',
        ],
        'description' => $datalist_html,
    ]);

    // Heading Font Weight
    $wp_customize->add_setting('ht_font_weight_heading', [
        'default'           => '700',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ht_font_weight_heading', [
        'type'        => 'select',
        'label'       => __('Heading Font Weight', 'ht'),
        'section'     => 'ht_typography_options',
        'choices'     => [
            '100' => 'Thin (100)',
            '200' => 'Extra Light (200)',
            '300' => 'Light (300)',
            '400' => 'Normal (400)',
            '500' => 'Medium (500)',
            '600' => 'Semi Bold (600)',
            '700' => 'Bold (700)',
            '800' => 'Extra Bold (800)',
            '900' => 'Black (900)',
        ],
    ]);

    // Heading Line Height
    $wp_customize->add_setting('ht_line_height_heading', [
        'default'           => '1.2',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ht_line_height_heading', [
        'type'        => 'text',
        'label'       => __('Heading Line Height', 'ht'),
        'section'     => 'ht_typography_options',
        'description' => __('E.g., 1.2, 30px', 'ht'),
    ]);

    // Heading Letter Spacing
    $wp_customize->add_setting('ht_letter_spacing_heading', [
        'default'           => '0px',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ht_letter_spacing_heading', [
        'type'        => 'text',
        'label'       => __('Heading Letter Spacing', 'ht'),
        'section'     => 'ht_typography_options',
        'description' => __('E.g., 0px, 0.02em', 'ht'),
    ]);
}
add_action('customize_register', 'ht_add_typography_customizer');


// In font từ Google Fonts và áp dụng vào body + heading
function ht_enqueue_selected_google_fonts()
{
    $body_font = get_theme_mod('ht_font_body', 'Roboto');
    $heading_font = get_theme_mod('ht_font_heading', 'Roboto');

    $body_font_size = get_theme_mod('ht_font_size_body', '16px');
    $body_line_height = get_theme_mod('ht_line_height_body', '1.5');
    $body_letter_spacing = get_theme_mod('ht_letter_spacing_body', '0px');

    $heading_font_weight = get_theme_mod('ht_font_weight_heading', '700');
    $heading_line_height = get_theme_mod('ht_line_height_heading', '1.2');
    $heading_letter_spacing = get_theme_mod('ht_letter_spacing_heading', '0px');


    $fonts = array_unique(array_filter([$body_font, $heading_font]));

    if (!empty($fonts)) {
        $font_families = implode('|', array_map('urlencode', $fonts));
        echo "<link href='https://fonts.googleapis.com/css?family={$font_families}&display=swap' rel='stylesheet'>\n";
    }

    $body_font_css = $body_font ? "font-family: '" . esc_attr($body_font) . "', sans-serif;" : '';
    $body_font_size_css = $body_font_size ? "font-size: " . esc_attr($body_font_size) . ";" : '';
    $body_line_height_css = $body_line_height ? "line-height: " . esc_attr($body_line_height) . ";" : '';
    $body_letter_spacing_css = $body_letter_spacing ? "letter-spacing: " . esc_attr($body_letter_spacing) . ";" : '';


    $heading_font_css = $heading_font ? "font-family: '" . esc_attr($heading_font) . "', sans-serif;" : '';
    $heading_font_weight_css = $heading_font_weight ? "font-weight: " . esc_attr($heading_font_weight) . ";" : '';
    $heading_line_height_css = $heading_line_height ? "line-height: " . esc_attr($heading_line_height) . ";" : '';
    $heading_letter_spacing_css = $heading_letter_spacing ? "letter-spacing: " . esc_attr($heading_letter_spacing) . ";" : '';


    echo "<style>
        body {
            {$body_font_css}
            {$body_font_size_css}
            {$body_line_height_css}
            {$body_letter_spacing_css}
        }
        h1, h2, h3, h4, h5, h6 {
            {$heading_font_css}
            {$heading_font_weight_css}
            {$heading_line_height_css}
            {$heading_letter_spacing_css}
        }
    </style>";
}
add_action('wp_head', 'ht_enqueue_selected_google_fonts');
