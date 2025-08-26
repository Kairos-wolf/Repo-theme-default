<?php
// Kiểm tra xem sticky có được bật cho topbar không
$is_sticky = get_theme_mod('ht_sticky_topbar_enabled', false);
$sticky_class = $is_sticky ? ' ht-sticky-item' : '';

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

<nav class="ht-topbar-builder<?php echo esc_attr($sticky_class); ?>">
    <div class="topbar row align-items-center py-2">
        <?php
        // Lấy layout từ Customizer, với cấu trúc mặc định mới
        $default_layout = json_encode(['left' => ['menu'], 'center' => ['html1'], 'right' => ['social']]);
        $layout_json = get_theme_mod('ht_topbar_layout', $default_layout);
        $layout = json_decode($layout_json, true);

        // Đảm bảo $layout luôn là một mảng hợp lệ
        if (!is_array($layout) || !isset($layout['left'])) {
             $layout = json_decode($default_layout, true);
        }

        $positions = ['left', 'center', 'right'];
        ?>

        <div class="topbar-section topbar-left col-md-4 d-flex justify-content-start align-items-center gap-3">
            <?php
            if (!empty($layout['left']) && is_array($layout['left'])) {
                foreach ($layout['left'] as $item_id) {
                    render_topbar_item($item_id);
                }
            }
            ?>
        </div>

        <div class="topbar-section topbar-center col-md-4 d-flex justify-content-center align-items-center gap-3">
             <?php
            if (!empty($layout['center']) && is_array($layout['center'])) {
                foreach ($layout['center'] as $item_id) {
                    render_topbar_item($item_id);
                }
            }
            ?>
        </div>

        <div class="topbar-section topbar-right col-md-4 d-flex justify-content-end align-items-center gap-3">
             <?php
            if (!empty($layout['right']) && is_array($layout['right'])) {
                foreach ($layout['right'] as $item_id) {
                    render_topbar_item($item_id);
                }
            }
            ?>
        </div>
    </div>
</nav>