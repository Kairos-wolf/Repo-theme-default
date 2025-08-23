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
