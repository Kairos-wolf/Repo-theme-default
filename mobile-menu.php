<?php
// Lấy các cài đặt từ Customizer
$position = get_theme_mod('ht_mobile_overlay_position', 'right');
$bg_color = get_theme_mod('ht_mobile_bg_color', '#ffffff');
$elements_json = get_theme_mod('ht_mobile_menu_elements', '[]');
$elements = json_decode($elements_json, true);
?>

<div id="ht-mobile-overlay" class="ht-mobile-overlay position-<?php echo esc_attr($position); ?>" style="background-color: <?php echo esc_attr($bg_color); ?>">
    <button id="ht-close-mobile-menu" class="ht-close-mobile-menu">&times;</button>
    <div class="ht-mobile-menu-inner">
        <?php
        if (is_array($elements) && !empty($elements)) {
            foreach ($elements as $element) {
                if ($element['visible']) { // Chỉ hiển thị các thành phần được bật
                    echo '<div class="ht-mobile-menu-item item-' . esc_attr($element['id']) . '">';
                    // Dùng switch để gọi hàm hiển thị tương ứng
                    switch ($element['id']) {
                        case 'search': ht_display_search_component(); break;
                        case 'login': ht_display_login_component(); break;
                        case 'cart': ht_display_cart_component(); break;
                        case 'social': ht_display_social_icons_component(); break;
                        case 'contact': ht_display_hotline_component(); break;
                        case 'menu':
                            if (has_nav_menu('primary')) { // Dùng menu chính
                                wp_nav_menu([
                                    'theme_location' => 'primary',
                                    'container' => false,
                                    'menu_class' => 'ht-mobile-main-menu'
                                ]);
                            }
                            break;
                        // Thêm các case khác nếu cần
                    }
                    echo '</div>';
                }
            }
        }
        ?>
    </div>
</div>