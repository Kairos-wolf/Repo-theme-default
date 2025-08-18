<?php

// Cài đặt logo và menu cho theme
function ht_theme_setup()
{
    add_theme_support('custom-logo');
    register_nav_menus([
        'primary' => __('Primary Menu', 'ht'),
        'topbar_menu' => esc_html__('Topbar Menu', 'ht'),
        'headerbottom_menu' => esc_html__('Header Bottom Menu', 'ht'),
    ]);
}
add_action('after_setup_theme', 'ht_theme_setup');

// Tải file css chính của theme (style.css) vào giao diện
function ht_theme_scripts()
{
    // Gọi Bootstrap CSS
    // wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css');

    // Gọi style.css của theme
    wp_enqueue_style('ht-style', get_stylesheet_uri());

    // Gọi Bootstrap JS
    // wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', [], null, true);
}

// Thêm class tailwind cho menu có submenu  
add_filter('nav_menu_css_classes', function ($classes, $item) {
    if (in_array('menu-item-has-children', $item->classes)) {
        $classes[] = 'group relative';
    }
    return $classes;
}, 10, 2);

add_filter('nav_menu_submenu_css_classes', function ($classes, $item) {
    $classes[] = 'absolute left-0 top-full hidden group-hover:block p-2 bg-gray-100 shadow-md min-w-[200px] transition ease-in-out duration-500';
    return $classes;
}, 10, 2);

// Thêm title tag cho site
function theme_setup()
{
    // Kích hoạt tính năng Title Tag
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'theme_setup');

/**
 * Thay đổi dấu phân cách trong tiêu đề.
 */
function custom_document_title_separator($sep)
{
    return '-'; // Trả về dấu gạch ngang
}
add_filter('document_title_separator', 'custom_document_title_separator');

/**
 * Sắp xếp lại các thành phần của tiêu đề trang.
 * Định dạng: Tên trang web - Tiêu đề trang con.
 */
function custom_document_title_parts($title)
{
    // Chỉ áp dụng cho các trang không phải là trang chủ
    if (! is_front_page()) {
        // Lấy tên trang web và tiêu đề trang hiện tại
        $site_name = $title['site'];
        $page_title = $title['title'];

        // Tạo lại mảng tiêu đề theo thứ tự mong muốn
        $title = [
            'title' => $site_name, // Phần đầu tiên giờ là tên trang web
            'site'  => $page_title,  // Phần thứ hai là tiêu đề trang con
        ];
    }

    // Đối với trang chủ, giữ nguyên cấu trúc mặc định (vd: Tên trang - Dòng giới thiệu)
    return $title;
}
add_filter('document_title_parts', 'custom_document_title_parts', 10, 1);
