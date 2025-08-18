<?php

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Add the main theme panel to the admin menu.
 */
function mytheme_add_admin_menu()
{
    add_menu_page(
        'Welcome to 🦈 Baby Shark Theme',
        '🦈 Baby Shark',
        'manage_options',
        'mytheme-panel',
        'mytheme_panel_page_callback',
        'dashicons-admin-customizer',
        2
    );
}
add_action('admin_menu', 'mytheme_add_admin_menu');

/**
 * Add an "Advanced" options page as a submenu item.
 */
add_action('admin_menu', function () {
    add_submenu_page(
        'mytheme-panel',
        'Tùy chọn Nâng cao',
        'Nâng cao',
        'manage_options',
        'my_theme_options',
        'my_theme_options_page_html',
        99
    );
});

/**
 * Add a custom "Baby Shark" menu to the admin toolbar.
 */
function my_theme_add_toolbar_item($wp_admin_bar)
{
    $wp_admin_bar->add_node([
        'id'    => 'ali_tab',
        'title' => '🦈 Baby Shark',
        'href'  => admin_url('admin.php?page=mytheme-panel'),
    ]);

    $wp_admin_bar->add_node([
        'id'     => 'nangcao_subitem',
        'title'  => 'Nâng cao',
        'href'   => admin_url('admin.php?page=my_theme_options'),
        'parent' => 'ali_tab',
    ]);
}
add_action('admin_bar_menu', 'my_theme_add_toolbar_item', 50);
