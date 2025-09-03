<?php
// =========================================================================
// BƯỚC 1: KIỂM TRA ĐIỀU KIỆN HIỂN THỊ TOPBAR
// =========================================================================

// Lấy cài đặt bật/tắt từ Customizer
$show_desktop = get_theme_mod('ht_topbar_show_desktop', true);
$show_mobile  = get_theme_mod('ht_topbar_show_mobile', true);

// Lấy cấu trúc layout
$layout_json = get_theme_mod('ht_topbar_layout', json_encode([]));
$layout = json_decode($layout_json, true);

$desktop_layout = $layout['desktop'] ?? [];
$mobile_layout  = $layout['mobile'] ?? [];

// Kiểm tra xem các layout có rỗng không (không có khối nào được thêm vào)
$is_desktop_empty = empty(array_filter(array_merge($desktop_layout['left'] ?? [], $desktop_layout['center'] ?? [], $desktop_layout['right'] ?? [])));
$is_mobile_empty  = empty(array_filter(array_merge($mobile_layout['left'] ?? [], $mobile_layout['center'] ?? [], $mobile_layout['right'] ?? [])));

// Quyết định xem có nên render các phần tương ứng không
$should_render_desktop = $show_desktop && !$is_desktop_empty;
$should_render_mobile  = $show_mobile && !$is_mobile_empty;

// Nếu cả hai giao diện đều không cần hiển thị, dừng thực thi toàn bộ file này
if (!$should_render_desktop && !$should_render_mobile) {
    return;
}

// =========================================================================
// BƯỚC 2: CHUẨN BỊ STYLE, CLASS VÀ HÀM RENDER
// =========================================================================

// Kiểm tra xem sticky có được bật cho topbar không
$is_sticky = get_theme_mod('ht_sticky_topbar_enabled', false);
$sticky_class = $is_sticky ? ' ht-sticky-item' : '';

// Lấy các giá trị tùy chỉnh style cho Top Bar từ Customizer
$bg_color   = get_theme_mod('topbar_background_color', '#f8f9fa');
$bg_image   = get_theme_mod('topbar_bg_image', '');
$color      = get_theme_mod('topbar_color', '#333333');
$margin     = get_theme_mod('topbar_margin', '0');
$padding    = get_theme_mod('topbar_padding', '10px 0');
$radius     = get_theme_mod('topbar_border_radius', '0');

// Tạo chuỗi style inline
$topbar_styles = "background-color: {$bg_color}; color: {$color}; margin: {$margin}; padding: {$padding}; border-radius: {$radius};";
if (!empty($bg_image)) {
    $topbar_styles .= " background-image: url('" . esc_url($bg_image) . "'); background-size: cover; background-position: center;";
}

// **THÊM MỚI**: Tạo các class CSS để kiểm soát hiển thị toàn bộ Top Bar
$visibility_classes = '';
if (!$should_render_desktop) {
    $visibility_classes .= ' d-md-none'; // Nếu desktop không hiển thị, thì ẩn nó trên màn hình lớn
}
if (!$should_render_mobile) {
    $visibility_classes .= ' d-none d-md-block'; // Nếu mobile không hiển thị, thì ẩn nó trên màn hình nhỏ
}

// Hàm trợ giúp để render một item, tránh lặp code
if (!function_exists('render_topbar_item')) {
    function render_topbar_item($item_id) {
        // Mở thẻ div bao bọc chung cho mỗi item
        echo '<div class="topbar-item ' . esc_attr($item_id) . ' d-flex align-items-center">';

        switch ($item_id) {
            case 'menu':
                if (has_nav_menu('topbar_menu')) {
                    wp_nav_menu(['theme_location' => 'topbar_menu', 'container' => false, 'menu_class' => 'ht-topbar-menu d-flex list-unstyled gap-4 my-auto', 'depth' => 1]);
                } else {
                    echo '<ul class="ht-topbar-menu d-flex list-unstyled gap-4 mb-0"><li><a href="' . esc_url(admin_url('nav-menus.php')) . '" class="text-decoration-none"><span>Chưa thêm menu</span></a></li></ul>';
                }
                break;
            case 'search':
                ht_display_search_component();
                break;
            case 'social':
                ht_display_social_icons_component();
                break;
            case 'contact':
                ht_display_hotline_component();
                break;
            case 'language_switcher':
                ht_display_language_switcher_component();
                break;
            case 'cart':
                ht_display_cart_component();
                break;
            case 'signup':
                echo '<a href="' . site_url('/dang-ky') . '" class="ht-signup-button text-decoration-none">Đăng ký</a>';
                break;
            case 'login':
                // if (is_user_logged_in()) {
                //     $current_user = wp_get_current_user();
                //     echo '<div class="ht-user-menu"><span>Xin chào, ' . esc_html($current_user->display_name) . '!</span> | <a href="' . esc_url(wp_logout_url(home_url())) . '" class="text-decoration-none">Đăng xuất</a></div>';
                // } else {
                //     // echo '<a href="' . get_permalink(get_page_by_path('dang-nhap')) . '" class="ht-login-button text-decoration-none">Đăng nhập</a>';
                // }
                ht_display_login_component();
                break;
            default:
                if (strpos($item_id, 'html') === 0) {
                    $html_content = get_theme_mod("ht_topbar_{$item_id}");
                    if (!empty($html_content)) {
                        echo wp_kses_post($html_content);
                    }
                }
                break;
        }
        echo '</div>'; // Đóng thẻ div.topbar-item
    }
}
?>

<nav class="ht-topbar-builder<?php echo esc_attr($sticky_class); ?><?php echo esc_attr($visibility_classes); ?>" style="<?php echo esc_attr($topbar_styles); ?>">
    <div class="container">
        <div class="topbar row align-items-center">
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

            // Vòng lặp để render cho cả desktop và mobile
            foreach ($devices as $device => $config) {
                if ($config['should_render']) {
                    // Render cột TRÁI
                    echo '<div class="topbar-section topbar-left-' . $device . ' ' . $config['col_class'] . ' ' . $config['visibility_class'] . ' justify-content-start align-items-center gap-3">';
                    if (!empty($config['layout']['left'])) {
                        foreach ($config['layout']['left'] as $item_id) { render_topbar_item($item_id); }
                    }
                    echo '</div>';

                    // Render cột GIỮA
                    echo '<div class="topbar-section topbar-center-' . $device . ' ' . $config['col_class'] . ' ' . $config['visibility_class'] . ' justify-content-center align-items-center gap-3">';
                    if (!empty($config['layout']['center'])) {
                        foreach ($config['layout']['center'] as $item_id) { render_topbar_item($item_id); }
                    }
                    echo '</div>';

                    // Render cột PHẢI
                    echo '<div class="topbar-section topbar-right-' . $device . ' ' . $config['col_class'] . ' ' . $config['visibility_class'] . ' justify-content-end align-items-center gap-3">';
                    if (!empty($config['layout']['right'])) {
                        foreach ($config['layout']['right'] as $item_id) { render_topbar_item($item_id); }
                    }
                    echo '</div>';
                }
            }
            ?>
        </div>
    </div>
</nav>