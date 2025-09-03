<?php
// =========================================================================
// BƯỚC 1: KIỂM TRA ĐIỀU KIỆN HIỂN THỊ HEADER BOTTOM
// =========================================================================

// Lấy cài đặt bật/tắt từ Customizer
$show_desktop = get_theme_mod('ht_header_bottom_show_desktop', true);
$show_mobile  = get_theme_mod('ht_header_bottom_show_mobile', true);

// Lấy cấu trúc layout
$layout_json = get_theme_mod('ht_headerbottom_layout', json_encode([]));
$layout = json_decode($layout_json, true);

$desktop_layout = $layout['desktop'] ?? [];
$mobile_layout  = $layout['mobile'] ?? [];

// Kiểm tra xem các layout có rỗng không
$is_desktop_empty = empty(array_filter(array_merge($desktop_layout['left'] ?? [], $desktop_layout['center'] ?? [], $desktop_layout['right'] ?? [])));
$is_mobile_empty  = empty(array_filter(array_merge($mobile_layout['left'] ?? [], $mobile_layout['center'] ?? [], $mobile_layout['right'] ?? [])));

// Quyết định xem có nên render các phần tương ứng không
$should_render_desktop = $show_desktop && !$is_desktop_empty;
$should_render_mobile  = $show_mobile && !$is_mobile_empty;

// Nếu cả hai giao diện đều không cần hiển thị, dừng thực thi file này
if (!$should_render_desktop && !$should_render_mobile) {
    return;
}

// =========================================================================
// BƯỚC 2: CHUẨN BỊ STYLE, CLASS VÀ HÀM RENDER
// =========================================================================

// Kiểm tra xem sticky có được bật cho header bottom không
$is_sticky = get_theme_mod('ht_sticky_header_bottom_enabled', false);
$sticky_class = $is_sticky ? ' ht-sticky-item' : '';

// Lấy các giá trị tùy chỉnh style cho Header Bottom từ Customizer
$bg_color   = get_theme_mod('header_bottom_background_color', '#ffffff');
$bg_image   = get_theme_mod('header_bottom_bg_image', '');
$color      = get_theme_mod('header_bottom_color', '#333333');
$margin     = get_theme_mod('header_bottom_margin', '0');
$padding    = get_theme_mod('header_bottom_padding', '10px 0');
$radius     = get_theme_mod('header_bottom_border_radius', '0');

// Tạo chuỗi style inline
$header_bottom_styles = "background-color: {$bg_color}; color: {$color}; margin: {$margin}; padding: {$padding}; border-radius: {$radius};";
if (!empty($bg_image)) {
    $header_bottom_styles .= " background-image: url('" . esc_url($bg_image) . "'); background-size: cover; background-position: center;";
}

// Tạo các class CSS để kiểm soát hiển thị toàn bộ Header Bottom
$visibility_classes = '';
if (!$should_render_desktop) {
    $visibility_classes .= ' d-md-none'; // Nếu desktop không hiển thị, thì ẩn nó trên màn hình lớn
}
if (!$should_render_mobile) {
    $visibility_classes .= ' d-none d-md-block'; // Nếu mobile không hiển thị, thì ẩn nó trên màn hình nhỏ
}

// Hàm trợ giúp để render một item, tránh lặp code và dễ quản lý
if (!function_exists('render_headerbottom_item')) {
    function render_headerbottom_item($item_id) {
        // Mở thẻ div bao bọc chung cho mỗi item
        echo '<div class="headerbottom-item ' . esc_attr($item_id) . ' d-flex align-items-center">';

        switch ($item_id) {
            case 'menu':
                // if (has_nav_menu('headerbottom_menu')) {
                //     echo '<div class="headerbottom-item col menu-item text-sm">';
                //     wp_nav_menu([
                //         'theme_location' => 'headerbottom_menu',
                //         'container'      => false,
                //         'menu_class'     => 'ht-headerbottom-menu d-inline-flex flex-row text-decoration-none list-unstyled gap-4', // Thêm class CSS cho menu
                //         'depth'          => 1, // Chỉ hiển thị menu cấp 1
                //     ]);
                //     echo '</div>';
                // }
                if (has_nav_menu('headerbottom_menu')) {
                    wp_nav_menu([
                        'theme_location' => 'headerbottom_menu',
                        'container'      => false,
                        'menu_class'     => 'ht-headerbottom-menu d-inline-flex flex-row list-unstyled gap-4 my-auto',
                        'depth'          => 1,
                    ]);
                } else {
                    echo '<ul class="ht-headerbottom-menu d-inline-flex flex-row list-unstyled gap-4 my-auto"><li><span>Chưa thêm menu</span></li></ul>';
                }
                break;
            
            // Bạn có thể thêm các case khác ở đây cho cart, login nếu cần logic phức tạp
            // Ví dụ: case 'cart': ht_display_cart_component(); break;

            case 'cart':
                if (function_exists('ht_display_cart_component')) {
                    ht_display_cart_component();
                }
                break;

            case 'login':
                if (function_exists('ht_display_login_component')) {
                    ht_display_login_component();
                }
                break;

            default:
                // Mặc định xử lý các khối html (html1, html2,...)
                if (strpos($item_id, 'html') === 0) {
                    $html_content = get_theme_mod("ht_headerbottom_{$item_id}");
                    if (!empty($html_content)) {
                        echo wp_kses_post($html_content);
                    }
                }
                break;
        }

        echo '</div>'; // Đóng thẻ div.headerbottom-item
    }
}
?>
<style>
    /* .headerbottom {
        display: flex;
    } */
    .ht-headerbottom-menu li a {
        text-decoration: none;
    }
</style>

<nav class="ht-headerbottom-builder<?php echo esc_attr($sticky_class); ?><?php echo esc_attr($visibility_classes); ?>" style="<?php echo esc_attr($header_bottom_styles); ?>">
    <div class="container">
        <div class="headerbottom row align-items-center">
            <?php
            // Mảng chứa thông tin layout cho cả hai giao diện
            $devices = [
                'desktop' => [
                    'should_render' => $should_render_desktop,
                    'visibility_class' => 'd-none d-md-flex',
                    'col_class' => 'col-md-4',
                    'layout' => $desktop_layout,
                ],
                'mobile' => [
                    'should_render' => $should_render_mobile,
                    'visibility_class' => 'd-md-none',
                    'col_class' => 'col',
                    'layout' => $mobile_layout,
                ]
            ];

            // Vòng lặp để render cho cả desktop và mobile, giữ code gọn gàng
            foreach ($devices as $device => $config) {
                if ($config['should_render']) {
                    // Render cột TRÁI
                    echo '<div class="headerbottom-section headerbottom-left-' . $device . ' ' . $config['col_class'] . ' ' . $config['visibility_class'] . ' justify-content-start align-items-center gap-3">';
                    if (!empty($config['layout']['left'])) {
                        foreach ($config['layout']['left'] as $item_id) { render_headerbottom_item($item_id); }
                    }
                    echo '</div>';

                    // Render cột GIỮA
                    echo '<div class="headerbottom-section headerbottom-center-' . $device . ' ' . $config['col_class'] . ' ' . $config['visibility_class'] . ' justify-content-center align-items-center gap-3">';
                    if (!empty($config['layout']['center'])) {
                        foreach ($config['layout']['center'] as $item_id) { render_headerbottom_item($item_id); }
                    }
                    echo '</div>';

                    // Render cột PHẢI
                    echo '<div class="headerbottom-section headerbottom-right-' . $device . ' ' . $config['col_class'] . ' ' . $config['visibility_class'] . ' justify-content-end align-items-center gap-3">';
                    if (!empty($config['layout']['right'])) {
                        foreach ($config['layout']['right'] as $item_id) { render_headerbottom_item($item_id); }
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</nav>
