<?php
function ht_customize_register_footer($wp_customize)
{
    // Register a new navigation menu location for the footer
    register_nav_menus([
        'footer_menu' => __('Footer Menu', 'ht'),
    ]);

    // Section Footer Builder
    $wp_customize->add_section('ht_footer_builder', [
        'title' => __('Footer Builder', 'ht'),
        'priority' => 30,
    ]);

    // Setting for the drag-and-drop layout
    $wp_customize->add_setting('ht_footer_layout', [
        'default' => json_encode(['logo', 'html1', 'menu']), // Default layout
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ]);

    // Control for the drag-and-drop builder
    $wp_customize->add_control(new HT_Footer_Builder_Control(
        $wp_customize,
        'ht_footer_layout',
        [
            'label' => __('Drag to reorder footer items', 'ht'),
            'section' => 'ht_footer_builder',
        ]
    ));

    // --- Logo ---
    $wp_customize->add_setting('ht_footer_logo', [
        'default' => '',
        'transport' => 'refresh',
        'sanitize_callback' => 'esc_url_raw',
    ]);

    $wp_customize->add_control(new WP_Customize_Image_Control(
        $wp_customize,
        'ht_footer_logo',
        [
            'label' => __('Footer Logo', 'ht'),
            'section' => 'ht_footer_builder',
        ]
    ));

    // --- Menu ---
    // Note: The menu is rendered via its location 'footer_menu'.
    // This text serves as a guide for the user.
    $wp_customize->add_setting('ht_footer_menu_info', []);
    $wp_customize->add_control('ht_footer_menu_info', [
        'label' => __('Footer Menu', 'ht'),
        'description' => sprintf(
            __('Assign a menu to the "Footer Menu" location in the <a href="%s" target="_blank">Menus</a> panel.', 'ht'),
            esc_url(admin_url('nav-menus.php'))
        ),
        'section' => 'ht_footer_builder',
        'type' => 'hidden', // Using 'hidden' and description to show info
    ]);


    // --- Multiple HTML Areas ---
    $number_of_html_items = 4; // Define how many HTML areas you want
    for ($i = 1; $i <= $number_of_html_items; $i++) {
        $item_id = 'html' . $i;

        // Setting for each HTML area
        $wp_customize->add_setting("ht_footer_{$item_id}", [
            'default' => '',
            'transport' => 'refresh',
            'sanitize_callback' => 'wp_kses_post',
        ]);

        // Control for each HTML area
        $wp_customize->add_control("ht_footer_{$item_id}", [
            'label' => __('Custom HTML ' . $i, 'ht'),
            'section' => 'ht_footer_builder',
            'type' => 'textarea',
        ]);
    }
}
add_action('customize_register', 'ht_customize_register_footer');
