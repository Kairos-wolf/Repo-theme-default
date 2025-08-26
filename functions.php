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

function ht_display_search_component() {
    // Lấy các tùy chọn cho ô tìm kiếm từ Customizer
    $search_ui = get_theme_mod('header_search_ui', 'default');
    $search_placeholder = get_theme_mod('search_placeholder', 'Tìm kiếm...');
    $search_button_html = get_theme_mod('search_button_html', 'Tìm');
    $search_width = get_theme_mod('search_width', '200');
    $search_height = get_theme_mod('search_height', '40');
    $search_border_radius_left = get_theme_mod('search_border_radius_left', '0');
    $search_border_radius_right = get_theme_mod('search_border_radius_right', '0');
    $button_text_color = get_theme_mod('search_button_text_color', '#ffffff');
    $button_bg_color = get_theme_mod('search_button_background_color', '#0073aa');
    $button_font_size = get_theme_mod('search_button_font_size', '16px');
    $button_padding = get_theme_mod('search_button_padding', '10px 20px');
    $button_border_radius = get_theme_mod('search_button_border_radius', '0');

    // Tạo chuỗi style cho input và button
    $input_styles = "width: {$search_width}px; height: {$search_height}px; border-top-left-radius: {$search_border_radius_left}px; border-bottom-left-radius: {$search_border_radius_left}px; border-top-right-radius: {$search_border_radius_right}px; border-bottom-right-radius: {$search_border_radius_right}px;";
    $button_styles = "height: {$search_height}px; color: {$button_text_color}; background-color: {$button_bg_color}; font-size: {$button_font_size}; padding: {$button_padding}; border-radius: {$button_border_radius}px;";

    // Bắt đầu tạo HTML
    $output = '<div class="ht-search-component">';

    if ($search_ui == 'modern') {
        $output .= '<form role="search" method="get" action="' . esc_url(home_url('/')) . '" class="d-flex align-items-center w-100">';
        $output .= '<input name="s" type="search" placeholder="' . esc_attr($search_placeholder) . '" class="form-control rounded-start me-1" style="' . esc_attr($input_styles) . '" />';
        $output .= '<button type="submit" class="search-button btn d-flex align-items-center" style="' . esc_attr($button_styles) . '">' . wp_kses_post($search_button_html) . '</button>';
        $output .= '</form>';
    } elseif ($search_ui == 'simple') {
        $output .= '<form role="search" method="get" action="' . esc_url(home_url('/')) . '" class="w-100">';
        $output .= '<input name="s" type="search" placeholder="' . esc_attr($search_placeholder) . '" class="form-control" style="' . esc_attr($input_styles) . '" />';
        $output .= '</form>';
    } else { // Mặc định
        $output .= '<form role="search" method="get" action="' . esc_url(home_url('/')) . '" class="search-form d-flex align-items-center w-100">';
        $output .= '<input name="s" type="search" placeholder="' . esc_attr($search_placeholder) . '" class="form-control me-1" style="' . esc_attr($input_styles) . '" />';
        $output .= '<button type="submit" class="search-button btn d-flex align-items-center" style="' . esc_attr($button_styles) . '">' . wp_kses_post($search_button_html) . '</button>';
        $output .= '</form>';
    }
    
    $output .= '</div>';

    echo $output;
}

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
        
        .ht-language-switcher .dropdown-toggle {
            background-color: transparent !important;
            border: none !important;
            color: inherit !important; /* Lấy màu chữ từ topbar */
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem; /* Kích thước chữ sm */
            box-shadow: none !important; /* Bỏ đổ bóng khi focus */
        }

        /* Style cho lá cờ */
        .ht-language-switcher .dropdown-toggle img,
        .ht-language-switcher .dropdown-item img {
            width: 20px;
            height: auto;
            border-radius: 2px;
        }

        /* Căn chỉnh dropdown menu sang phải nếu cần */
        .ht-language-switcher .dropdown-menu {
            min-width: auto;
            border-radius: 0.25rem;
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

if (!function_exists('ht_display_language_switcher_component')) {
    /**
     * Hiển thị component chuyển đổi ngôn ngữ dưới dạng Bootstrap Dropdown.
     * Tự động tích hợp với Polylang nếu plugin này được kích hoạt.
     */
    function ht_display_language_switcher_component()
    {
        echo '<div class="ht-language-switcher">';

        if (function_exists('pll_the_languages') && function_exists('pll_current_language')) {
            // Lấy ngôn ngữ hiện tại
            $current_lang_slug = pll_current_language('slug');
            $current_lang_name = pll_current_language('name');
            // Lấy URL của cờ hiện tại
            $current_lang_flag_url = pll_the_languages(['raw' => 1, 'echo' => 0, 'display_names_as' => 'slug'])[$current_lang_slug]['flag'];


            // Lấy danh sách các ngôn ngữ khác
            $other_languages = pll_the_languages(['raw' => 1]);

            // Bắt đầu cấu trúc dropdown
            echo '<div class="dropdown">';

            // Nút bấm để mở dropdown
            echo '<button class="btn btn-sm dropdown-toggle d-flex align-items-center" type="button" id="languageDropdownMenu" data-bs-toggle="dropdown" aria-expanded="false">';
            // SỬA LỖI: Bọc URL của cờ trong thẻ <img>
            echo '<img src="' . esc_url($current_lang_flag_url) . '" alt="' . esc_attr($current_lang_name) . '" width="20" height="auto" />' . '<span class="ms-2">' . esc_html(strtoupper($current_lang_slug)) . '</span>';
            echo '</button>';

            // Danh sách các ngôn ngữ trong dropdown
            echo '<ul class="dropdown-menu dropdown-menu-end" aria-labelledby="languageDropdownMenu">';
            
            foreach ($other_languages as $lang) {
                // Chỉ hiển thị các ngôn ngữ khác với ngôn ngữ hiện tại
                if (!$lang['current_lang']) {
                    echo '<li>';
                    echo '<a class="dropdown-item d-flex align-items-center" href="' . esc_url($lang['url']) . '">';
                    // SỬA LỖI: Bọc URL của cờ trong thẻ <img>
                    echo '<img src="' . esc_url($lang['flag']) . '" alt="' . esc_attr($lang['name']) . '" width="20" height="auto" />' . '<span class="ms-2">' . esc_html($lang['name']) . '</span>';
                    echo '</a>';
                    echo '</li>';
                }
            }
            
            echo '</ul>';
            echo '</div>'; // end .dropdown

        } else {
            // Fallback nếu không có Polylang
            echo '<select class="form-select form-select-sm" disabled><option selected>Ngôn ngữ</option></select>';
            if (current_user_can('manage_options')) {
                echo '<p class="text-danger small mt-1" style="font-size: 12px;">Gợi ý: Cài đặt Polylang để kích hoạt.</p>';
            }
        }

        echo '</div>';
    }
}

function ht_cart_dynamic_css() {
    // Lấy các giá trị hover từ Customizer
    $bg_color_hover = get_theme_mod('ht_cart_bg_color_hover', '#7cb342');
    $text_color_hover = get_theme_mod('ht_cart_text_color_hover', '#ffffff');
    $border_color_hover = get_theme_mod('ht_cart_border_color_hover', '#ffffff');
    ?>
    <style>
        .ht-cart-component:hover {
            background-color: <?php echo esc_attr($bg_color_hover); ?> !important;
            color: <?php echo esc_attr($text_color_hover); ?> !important;
            border-color: <?php echo esc_attr($border_color_hover); ?> !important;
        }
    </style>
    <?php
}
add_action('wp_head', 'ht_cart_dynamic_css');

if (!function_exists('ht_display_cart_component')) {
    function ht_display_cart_component()
    {
        // Kiểm tra và lấy dữ liệu giỏ hàng (giữ nguyên logic)
        if (!function_exists('WC')) {
            $cart_url = home_url('/cart');
            $cart_count = isset($_SESSION['cart_items']) && is_array($_SESSION['cart_items']) ? count($_SESSION['cart_items']) : 0;
            $cart_total = isset($_SESSION['cart_total']) ? number_format($_SESSION['cart_total']) . ' đ' : '0 đ';
        } else {
            $cart_url = wc_get_cart_url();
            $cart_count = WC()->cart->get_cart_contents_count();
            $cart_total = WC()->cart->get_cart_total();
        }

        // Lấy các tùy chọn từ Customizer
        $icon_type           = get_theme_mod('ht_cart_icon_type', 'preset');
        $preset_icon         = get_theme_mod('ht_cart_preset_icon', 'fas fa-shopping-cart');
        $custom_icon_id      = get_theme_mod('ht_cart_custom_icon');
        $icon_font_size      = get_theme_mod('ht_cart_icon_font_size', 18);
        $display_title       = get_theme_mod('ht_cart_display_title', true);
        $display_price       = get_theme_mod('ht_cart_display_price', false);
        $text_font_size      = get_theme_mod('ht_cart_text_font_size', 14);
        $padding             = get_theme_mod('ht_cart_padding', '8px');
        $bg_color            = get_theme_mod('ht_cart_bg_color', '#ffffff');
        $text_color          = get_theme_mod('ht_cart_text_color', '#000000');
        $border_color        = get_theme_mod('ht_cart_border_color', '#000000');
        $bg_color_hover      = get_theme_mod('ht_cart_bg_color_hover', '#000000');
        $text_color_hover    = get_theme_mod('ht_cart_text_color_hover', '#ffffff');
        $border_color_hover  = get_theme_mod('ht_cart_border_color_hover', '#ffffff');
        $border_width        = get_theme_mod('ht_cart_border_width', 1);
        $border_radius       = get_theme_mod('ht_cart_border_radius', 8);


        // Chuẩn bị các thuộc tính style
        $button_styles = "
            padding: " . esc_attr($padding) . ";
            background-color: " . esc_attr($bg_color) . ";
            color: " . esc_attr($text_color) . ";
            border: " . absint($border_width) . "px solid " . esc_attr($border_color) . ";
            border-radius: " . absint($border_radius) . "px;
            transition: all 0.3s ease;
        ";

        $icon_margin_style = '';
        if ($display_title || $display_price) {
            $icon_margin_style = 'margin-right: 8px;';
        }

        $text_styles = "
            font-size: " . absint($text_font_size) . "px;
        ";

        // Thêm CSS động cho hiệu ứng hover
        echo '
        <style>
            .ht-cart-component {
                display: inline-flex;
                align-items: center;
                text-decoration: none;
                position: relative;
                ' . $button_styles . '
            }
            .ht-cart-component:hover {
                background-color: ' . esc_attr($bg_color_hover) . ';
                color: ' . esc_attr($text_color_hover) . ';
                border-color: ' . esc_attr($border_color_hover) . ';
            }
        </style>
        ';

        // Render HTML
        echo '<a href="' . esc_url($cart_url) . '" class="ht-cart-component">';

        // Hiển thị Icon
        $icon_html = '';
        $icon_style = 'font-size: ' . absint($icon_font_size) . 'px; ' . $icon_margin_style;
        if ($icon_type === 'custom' && $custom_icon_id) {
            $icon_html = wp_get_attachment_image($custom_icon_id, 'thumbnail', false, ['style' => 'width: ' . absint($icon_font_size) . 'px; height: auto; ' . $icon_margin_style]);
        } else {
            $icon_html = '<i class="' . esc_attr($preset_icon) . '" style="' . $icon_style . '"></i>';
        }
        echo $icon_html;

        // Hiển thị chữ & giá
        $text_output = '';
        if ($display_title && $display_price) {
            $text_output = esc_html__('Giỏ hàng', 'ht') . ' / ' . wp_kses_post($cart_total);
        } elseif ($display_title) {
            $text_output = esc_html__('Giỏ hàng', 'ht');
        } elseif ($display_price) {
            $text_output = wp_kses_post($cart_total);
        }

        if (!empty($text_output)) {
            echo '<span class="cart-text" style="' . $text_styles . '">' . $text_output . '</span>';
        }

        // Hiển thị số lượng (badge)
        if ($cart_count > 0) {
            echo '<span class="cart-count position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="z-index: 2;">' . esc_html($cart_count) . '</span>';
        }

        echo '</a>';
    }
}

function ht_display_login_component() {
    // Lấy tất cả các cài đặt từ Customizer
    $show_icon      = get_theme_mod('ht_login_show_icon', true);
    $icon_bg        = get_theme_mod('ht_login_icon_bg_color', '#000000');
    $icon_radius_px = get_theme_mod('ht_login_icon_border_radius', 20);
    $icon_fsize     = get_theme_mod('ht_login_icon_font_size', 14);
    $show_label     = get_theme_mod('ht_login_show_label', true);
    $label_text     = get_theme_mod('ht_login_label_text', 'Đăng nhập');
    $text_color     = get_theme_mod('ht_login_text_color', '#333333');
    $show_username  = get_theme_mod('ht_login_show_username', true);
    $logout_color   = get_theme_mod('ht_login_logout_icon_color', '#6c757d');

    $btn_bg         = get_theme_mod('ht_login_button_bg_color', 'rgba(0,0,0,0)');
    $btn_padding    = get_theme_mod('ht_login_button_padding', '8px 12px');
    $btn_radius_px  = get_theme_mod('ht_login_button_border_radius', 4);

    // Chuẩn bị các biến dùng chung
    $output = '';
    $icon_html = '';
    $icon_style = "background-color: {$icon_bg}; border-radius: {$icon_radius_px}px; font-size: {$icon_fsize}px;";
    $text_style = "color: {$text_color};";
    $button_wrapper_style = "background-color: {$btn_bg}; border-radius: {$btn_radius_px}px; padding: {$btn_padding};";

    if ($show_icon) {
        $icon_html = '<span class="ht-login-icon" style="' . esc_attr($icon_style) . '"><i class="fas fa-user"></i></span>';
    }
    
    // Bắt đầu component
    $output .= '<div class="header-item login">';

    // KIỂM TRA TRẠNG THÁI ĐĂNG NHẬP
    if (is_user_logged_in()) {
        // --- XỬ LÝ CHUNG CHO TẤT CẢ USER ĐÃ ĐĂNG NHẬP ---
        $current_user = wp_get_current_user();
        $profile_url = home_url('/quan-li-ho-so');

        $output .= '<div class="ht-login-component logged-in d-flex align-items-center">';
        
        if ($show_username) {
            $output .= '<a href="' . esc_url($profile_url) . '" class="ht-user-menu-name text-decoration-none">';
            $output .= $icon_html;
            $output .= '<span class="ht-user-greeting" style="' . esc_attr($text_style) . '">Chào, ' . esc_html($current_user->display_name) . '!</span>';
            $output .= '</a>';
        }
        
        $output .= '<a href="' . esc_url(wp_logout_url(home_url())) . '" class="ht-logout-link text-decoration-none" style="color:' . esc_attr($logout_color) . ';"><i class="fa-solid fa-right-from-bracket"></i></a>';
        $output .= '</div>';

    } else {
        // --- XỬ LÝ KHI CHƯA ĐĂNG NHẬP ---
        $login_url = get_permalink(get_page_by_path('tai-khoan'));

        // **SỬA LỖI Ở ĐÂY**: Nếu không tìm thấy trang có slug 'tai-khoan',
        // thì dùng link đăng nhập WordPress mặc định làm phương án dự phòng.
        if ( ! $login_url ) {
            $login_url = wp_login_url();
        }

        if ($login_url) {
            $output .= '<a href="' . esc_url($login_url) . '" class="ht-login-component ht-login-button-wrapper logged-out d-flex align-items-center gap-2 text-decoration-none" style="' . esc_attr($button_wrapper_style) . '">';
            $output .= $icon_html;
            if ($show_label) {
                $output .= '<span class="ht-login-label" style="' . esc_attr($text_style) . '">' . esc_html($label_text) . '</span>';
            }
            $output .= '</a>';
        }
    }

    $output .= '</div>'; // Đóng .header-item.login

    echo $output;
}
function ht_login_component_dynamic_styles() {
    // Lấy giá trị màu hover từ Customizer
    $text_hover_color = get_theme_mod('ht_login_text_hover_color', '#007bff');
    $logout_hover_color = get_theme_mod('ht_login_logout_icon_hover_color', '#dc3545');
    // THÊM MỚI: Lấy giá trị màu hover của button
    $btn_bg_hover = get_theme_mod('ht_login_button_bg_hover_color', '#e9ecef');

    // Bắt đầu chuỗi CSS
    $css = '<style type="text/css">';
    
    // Quy tắc cho text hover (Code gốc của bạn)
    $css .= '
        /* --- CSS cho Thành phần Login --- */
        .ht-login-component a {
            color: inherit; /* Kế thừa màu chữ từ thẻ cha */
        }

        /* Style chung cho icon */
        .ht-login-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            color: #fff;
            transition: all 0.3s ease;
        }

        /* Style cho trạng thái đã đăng nhập */
        .ht-login-component.logged-in {
            font-size: 14px;
        }

        .ht-user-menu-name {
            display: inline-flex;
            align-items: center;
            gap: 8px; /* Khoảng cách giữa icon và chữ */
        }

        .ht-user-menu-name:hover .ht-login-icon {
            opacity: 0.8;
        }

        .ht-logout-link {
            margin-left: 8px;
            padding-left: 8px;
            border-left: 1px solid #ccc;
            font-weight: bold;
        }

        /* Style cho trạng thái chưa đăng nhập */
        .ht-login-component.logged-out:hover .ht-login-icon {
            opacity: 0.8;
        }
        .ht-login-component.logged-out:hover .ht-login-label {
            text-decoration: none !important;
        }
        .ht-login-component.logged-out:hover .ht-login-label {
            text-decoration: underline;
        }

        /* THÊM MỚI: CSS tĩnh cho button wrapper để hiệu ứng transition hoạt động */
        .ht-login-button-wrapper {
            transition: background-color 0.3s ease;
        }

        .ht-login-component.logged-out:hover .ht-login-label,
        .ht-login-component.logged-in .ht-user-menu-name:hover .ht-user-greeting {
            color: ' . esc_attr($text_hover_color) . ' !important;
        }
    ';

    // Quy tắc cho icon đăng xuất hover (Code gốc của bạn)
    $css .= '
        .ht-login-component.logged-in .ht-logout-link:hover {
            color: ' . esc_attr($logout_hover_color) . ' !important;
        }
    ';

    // THÊM MỚI: Quy tắc cho background hover của nút đăng nhập
    $css .= '
        .ht-login-button-wrapper:hover {
            background-color: ' . esc_attr($btn_bg_hover) . ' !important;
        }
    ';

    $css .= '</style>';

    // In CSS ra
    echo $css;
}
add_action('wp_head', 'ht_login_component_dynamic_styles');

function ht_sticky_header_scripts() {
    ?>
    <style>
        /* CSS cho Sticky Header */
        .ht-sticky-wrapper {
            position: relative;
            z-index: 1020;
        }

        .ht-sticky-wrapper.is-sticky {
            position: fixed;
            /* Thuộc tính 'top' sẽ được JS xử lý động */
            left: 0;
            right: 0;
            width: 100%;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            
            transform: translateY(-100%);
            animation: jumpDown 0.5s forwards ease-out;
        }

        .sticky-placeholder {
            display: none;
        }

        .sticky-placeholder.active {
            display: block;
        }

        @keyframes jumpDown {
            from {
                transform: translateY(-100%);
            }
            to {
                transform: translateY(0);
            }
        }
    </style>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const stickyItems = document.querySelectorAll('.ht-sticky-item');
        if (stickyItems.length === 0) return;

        // --- BẮT ĐẦU PHẦN CẬP NHẬT ---

        // MỚI: Tự động phát hiện chiều cao của Admin Bar
        let adminBarHeight = 0;
        const adminBar = document.getElementById('wpadminbar');
        if (adminBar) {
            adminBarHeight = adminBar.offsetHeight;
        }
        
        // --- KẾT THÚC PHẦN CẬP NHẬT ---

        const wrapper = document.createElement('div');
        wrapper.classList.add('ht-sticky-wrapper');
        
        const firstStickyItem = stickyItems[0];
        firstStickyItem.parentNode.insertBefore(wrapper, firstStickyItem);
        stickyItems.forEach(item => wrapper.appendChild(item));

        const placeholder = document.createElement('div');
        placeholder.classList.add('sticky-placeholder');
        wrapper.parentNode.insertBefore(placeholder, wrapper);
        
        let initialOffsetTop = wrapper.offsetTop;
        let totalHeight = wrapper.offsetHeight;

        function handleScroll() {
            // Tính toán điểm bắt đầu dính, trừ đi chiều cao của admin bar
            const stickyStartPoint = initialOffsetTop - adminBarHeight;

            if (window.scrollY > stickyStartPoint) {
                if (!wrapper.classList.contains('is-sticky')) {
                    placeholder.style.height = totalHeight + 'px';
                    placeholder.classList.add('active');
                    
                    // MỚI: Đặt vị trí top của header bằng chiều cao của admin bar
                    wrapper.style.top = adminBarHeight + 'px'; 
                    
                    wrapper.classList.add('is-sticky');
                }
            } else {
                if (wrapper.classList.contains('is-sticky')) {
                    wrapper.classList.remove('is-sticky');
                    placeholder.classList.remove('active');
                    placeholder.style.height = '0px';

                    // MỚI: Trả lại vị trí top về mặc định
                    wrapper.style.top = '0px'; 
                }
            }
        }

        window.addEventListener('scroll', handleScroll);
        handleScroll(); 
    });
    </script>
    <?php
}
add_action('wp_footer', 'ht_sticky_header_scripts');