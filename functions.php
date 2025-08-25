<?php
// Theme setup and custom header functions
require_once get_template_directory() . '/inc/header/header-function/setup.php';
require_once get_template_directory() . '/inc/header/header-function/header-custom.php';
require_once get_template_directory() . '/inc/footer/footer-function/footer-custom.php';

// Header builder
require_once get_template_directory() . '/inc/header/header-builder/customizer.php';
require_once get_template_directory() . '/inc/header/header-builder/class-header-builder-control.php';
require_once get_template_directory() . '/inc/header/header-builder/class-topbar-builder-control.php';
require_once get_template_directory() . '/inc/header/header-builder/class-headerbottom-builder-control.php';

// Footer builder
require_once get_template_directory() . '/inc/footer/footer-builder/customizer.php';
require_once get_template_directory() . '/inc/footer/footer-builder/class-footer-builder-control.php';

// Contact Form - Admin
require_once get_template_directory() . '/inc/form/form-function.php';
require_once get_template_directory() . '/inc/form/my-theme-smtp-settings.php';


// Advanced
if (! defined('ABSPATH')) {
    exit;
}

define('THEME_DIR_PATH', get_template_directory());

$theme_includes = [
    '/inc/advance/admin-menu.php',
    '/inc/advance/admin-page-main.php',
    '/inc/advance/admin-page-advanced.php',
    '/inc/advance/frontend-output.php',
];

foreach ($theme_includes as $file) {
    require_once THEME_DIR_PATH . $file;
}

// Customize 
require_once get_template_directory() . '/inc/customize/style/color.php';
require_once get_template_directory() . '/inc/customize/style/typography.php';
require_once get_template_directory() . '/inc/customize/style/custom-css.php';
require_once get_template_directory() . '/inc/customize/layout/layout.php';

// ===================================================
add_action('after_setup_theme', 'remove_admin_bar_for_non_admins');
function remove_admin_bar_for_non_admins()
{
    // Kiểm tra nếu người dùng hiện tại không có quyền quản trị ('manage_options' là quyền chỉ admin mới có)
    if (!current_user_can('manage_options')) {
        // Ẩn thanh admin bar
        show_admin_bar(false);
    }
}

function them_class_cho_link_menu_topbar($atts, $item, $args) {
    // Chỉ áp dụng cho menu có theme_location là 'topbar_menu'
    if (isset($args->theme_location) && $args->theme_location == 'topbar_menu') {
        // Thêm class 'text-decoration-none' vào các thẻ <a>
        $atts['class'] = 'text-decoration-none';
    }
    return $atts;
}
add_filter('nav_menu_link_attributes', 'them_class_cho_link_menu_topbar', 10, 3);

if (!function_exists('ht_display_social_icons_component')) {
    /**
     * Hiển thị component social icons dựa trên cài đặt trong Customizer.
     */
    function ht_display_social_icons_component()
    {
        // Mảng map key với class icon của Font Awesome và tên hiển thị (đã bỏ Zalo)
        $social_networks = [
            'facebook'    => ['icon' => 'fab fa-facebook', 'name' => 'Facebook'],
            'threads'     => ['icon' => 'fab fa-threads', 'name' => 'Threads'],
            'instagram'   => ['icon' => 'fab fa-instagram', 'name' => 'Instagram'],
            'tiktok'      => ['icon' => 'fab fa-tiktok', 'name' => 'TikTok'],
            'youtube'     => ['icon' => 'fab fa-youtube', 'name' => 'YouTube'],
            'twitter'     => ['icon' => 'fab fa-twitter', 'name' => 'Twitter'],
            'x-twitter'   => ['icon' => 'fab fa-x-twitter', 'name' => 'X'],
            'telegram'    => ['icon' => 'fab fa-telegram', 'name' => 'Telegram'],
            'discord'     => ['icon' => 'fab fa-discord', 'name' => 'Discord'],
            'phone'       => ['icon' => 'fa-solid fa-phone', 'name' => 'Số điện thoại'],
            'email'       => ['icon' => 'fas fa-envelope', 'name' => 'Email'],
        ];

        echo '<div class="ht-social-icons d-flex flex-wrap align-items-center gap-3">';

        foreach ($social_networks as $key => $details) {
            $link = get_theme_mod("ht_social_{$key}_url");

            if (!empty($link)) {
                $href = '';
                $tooltip_title = 'Theo dõi trên ' . $details['name'];

                if ($key === 'phone') {
                    $href = 'tel:' . esc_attr($link);
                    $tooltip_title = 'Gọi ' . esc_attr($link);
                } elseif ($key === 'email') {
                    $href = 'mailto:' . antispambot(esc_attr($link));
                    $tooltip_title = 'Gửi email tới ' . antispambot(esc_attr($link));
                } else {
                    $href = esc_url($link);
                }

                echo '<a href="' . $href . '" 
                       aria-label="' . esc_attr($details['name']) . '" 
                       target="_blank" 
                       rel="noopener noreferrer" 
                       class="text-decoration-none"
                       data-bs-toggle="tooltip" 
                       data-bs-placement="bottom" 
                       title="' . esc_attr($tooltip_title) . '">';
                
                // Bây giờ chỉ cần hiển thị icon Font Awesome
                echo '<i class="' . esc_attr($details['icon']) . '"></i>';

                echo '</a>';
            }
        }
        echo '</div>';
    }
}
/**
 * Thêm CSS tùy chỉnh cho các icon mạng xã hội vào thẻ <head> của trang.
 */
function ht_add_css()
{
    // Sử dụng cú pháp HEREDOC để viết CSS dễ dàng hơn
    $css = <<<CSS
    <style>
        /* --- TÙY CHỈNH MÀU SẮC CHO ICON MẠNG XÃ HỘI --- */

        /* Thiết lập style chung cho các icon */
        .ht-social-icons a i {
            transition: opacity 0.3s ease; /* Thêm hiệu ứng mượt mà khi di chuột */
            font-size: 1.1rem; /* Chỉnh kích thước icon nếu cần */
        }

        /* Hiệu ứng khi di chuột */
        .ht-social-icons a:hover i {
            opacity: 0.8;
        }

        /* Màu sắc riêng cho từng icon */
        .ht-social-icons .fa-facebook { color: #1877F2; }
        .ht-social-icons .fa-instagram { color: #E4405F; }
        .ht-social-icons .fa-threads { color: #000000; }
        .ht-social-icons .fa-tiktok { color: #000000; }
        .ht-social-icons .fa-youtube { color: #FF0000; }
        .ht-social-icons .fa-twitter { color: #1DA1F2; }
        .ht-social-icons .fa-x-twitter { color: #000000; }
        .ht-social-icons .fa-telegram { color: #26A5E4; }
        .ht-social-icons .fa-discord { color: #5865F2; }
        .ht-social-icons .fa-phone { color: #25D366; }
        .ht-social-icons .fa-envelope { color: #BB001B; }
        
        .hotline-wrapper {
            display: flex;
            align-items: center;
            text-decoration: none;
        }
        .circle-icon-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            flex-shrink: 0; /* Giúp icon không bị co lại */
        }
        .hotline-text {
            display: flex;
            flex-direction: column;
            line-height: 1.2;
        }
        .hotline-text strong {
            text-transform: uppercase;
            font-weight: bold;
        }
        .hotline-sub {
            font-weight: bold;
            margin-top: 2px;
        }
        
    </style>
    CSS;

    echo $css;
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
    <?php
}
add_action('wp_head', 'ht_add_css');

if (!function_exists('ht_display_hotline_component')) {
    function ht_display_hotline_component() {
        // Lấy tất cả giá trị từ Customizer
        $icon_class = get_theme_mod('ht_hotline_icon_class', 'fa-solid fa-phone');
        $icon_size = get_theme_mod('ht_hotline_icon_size', 50);
        $icon_font_size = get_theme_mod('ht_hotline_icon_font_size', 20);
        $icon_color = get_theme_mod('ht_hotline_icon_color', 'orange');
        $icon_bg_color = get_theme_mod('ht_hotline_icon_bg_color', '#ffffff');
        $icon_border_color = get_theme_mod('ht_hotline_icon_border_color', 'orange');
        $text_top = get_theme_mod('ht_hotline_text_top', 'Hotline');
        $text_top_color = get_theme_mod('ht_hotline_text_top_color', '#000000');
        $number = get_theme_mod('ht_hotline_number', '123.456.789');
        $number_color = get_theme_mod('ht_hotline_number_color', 'red');

        // Chuẩn bị style inline
        $icon_styles = "
            background-color: " . esc_attr($icon_bg_color) . ";
            color: " . esc_attr($icon_color) . ";
            border: 2px solid " . esc_attr($icon_border_color) . ";
            width: " . esc_attr($icon_size) . "px;
            height: " . esc_attr($icon_size) . "px;
            font-size: " . esc_attr($icon_font_size) . "px;
            margin-right: 8px;
        ";
        
        $tel_number = preg_replace('/[^0-9+]/', '', $number);

        // Render HTML
        if (!empty($number)) {
            echo '<a href="tel:' . esc_attr($tel_number) . '" class="hotline-wrapper">';
            echo '<span class="circle-icon-custom" style="' . $icon_styles . '">';
            echo '<i class="' . esc_attr($icon_class) . '"></i>';
            echo '</span>';
            echo '<div class="hotline-text">';
            echo '<strong style="color:' . esc_attr($text_top_color) . ';">' . esc_html($text_top) . '</strong>';
            echo '<div class="hotline-sub" style="color:' . esc_attr($number_color) . ';">' . esc_html($number) . '</div>';
            echo '</div>';
            echo '</a>';
        }
    }
}