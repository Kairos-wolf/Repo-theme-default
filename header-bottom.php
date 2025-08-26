<?php
// Kiểm tra xem sticky có được bật cho header bottom không
$is_sticky = get_theme_mod('ht_sticky_header_bottom_enabled', false);
$sticky_class = $is_sticky ? ' ht-sticky-item' : '';

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

<nav class="ht-headerbottom-builder<?php echo esc_attr($sticky_class); ?>">
    <div class="headerbottom row align-items-center py-2">
        <?php
        // Lấy layout từ Customizer, với cấu trúc 3 cột mặc định
        $default_layout = json_encode(['left' => [], 'center' => ['menu'], 'right' => []]);
        $layout_json = get_theme_mod('ht_headerbottom_layout', $default_layout);
        $layout = json_decode($layout_json, true);

        // Đảm bảo $layout luôn là một mảng hợp lệ
        if (!is_array($layout) || !isset($layout['left'])) {
             $layout = json_decode($default_layout, true);
        }
        ?>

        <div class="headerbottom-section headerbottom-left col-md-4 d-flex justify-content-start align-items-center gap-3">
            <?php
            if (!empty($layout['left']) && is_array($layout['left'])) {
                foreach ($layout['left'] as $item_id) {
                    render_headerbottom_item($item_id);
                }
            }
            ?>
        </div>

        <div class="headerbottom-section headerbottom-center col-md-4 d-flex justify-content-center align-items-center gap-3">
             <?php
            if (!empty($layout['center']) && is_array($layout['center'])) {
                foreach ($layout['center'] as $item_id) {
                    render_headerbottom_item($item_id);
                }
            }
            ?>
        </div>

        <div class="headerbottom-section headerbottom-right col-md-4 d-flex justify-content-end align-items-center gap-3">
             <?php
            if (!empty($layout['right']) && is_array($layout['right'])) {
                foreach ($layout['right'] as $item_id) {
                    render_headerbottom_item($item_id);
                }
            }
            ?>
        </div>
    </div>
</nav>
