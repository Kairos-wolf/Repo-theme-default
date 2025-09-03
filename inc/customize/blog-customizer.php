<?php
// File: /inc/customize/blog-customizer.php
/**
 * Đăng ký Panel và các Section, Control cho phần quản lý Blog trong Customizer.
 */
function ht_blog_customizer_register($wp_customize) {

    // =========================================================================
    // PANEL: BLOG
    // =========================================================================
    $wp_customize->add_panel('mytheme_blog_settings_panel', [
        'title'       => __('Blog', 'ht'),
        'priority'    => 30,
        'description' => __('Tùy chỉnh tất cả các thiết lập liên quan đến blog, bài viết.', 'ht'),
    ]);

    // =========================================================================
    // SECTION 1: BLOG GLOBAL
    // =========================================================================
    $wp_customize->add_section('mytheme_blog_global_section', [
        'title'    => __('Blog Global', 'ht'),
        'panel'    => 'mytheme_blog_settings_panel',
        'priority' => 10,
    ]);

    // Control: Show Date Box
    $wp_customize->add_setting('ht_blog_global_show_date_box', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_global_show_date_box_control', [
        'label'    => __('Show Date Box', 'ht'),
        'section'  => 'mytheme_blog_global_section',
        'settings' => 'ht_blog_global_show_date_box',
        'type'     => 'checkbox',
    ]);

    // Control: Blog Excerpt Suffix
    $wp_customize->add_setting('ht_blog_global_excerpt_suffix', [
        'default'           => '[...]',
        'sanitize_callback' => 'sanitize_text_field',
    ]);
    $wp_customize->add_control('ht_blog_global_excerpt_suffix_control', [
        'label'       => __('Blog Excerpt Suffix', 'ht'),
        'description' => __('Choose custom post excerpt suffix. Default [...]', 'ht'),
        'section'     => 'mytheme_blog_global_section',
        'settings'    => 'ht_blog_global_excerpt_suffix',
        'type'        => 'text',
    ]);

    // =========================================================================
    // SECTION 2: BLOG LAYOUT
    // =========================================================================
    $wp_customize->add_section('mytheme_blog_layout_section', [
        'title'    => __('Blog Layout', 'ht'),
        'panel'    => 'mytheme_blog_settings_panel',
        'priority' => 20,
    ]);

    // Control: Blog Homepage Header
    $wp_customize->add_setting('ht_blog_layout_header_html', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('ht_blog_layout_header_html_control', [
        'label'       => __('Blog Homepage Header', 'ht'),
        'description' => __('Enter HTML for blog header here...', 'ht'),
        'section'     => 'mytheme_blog_layout_section',
        'settings'    => 'ht_blog_layout_header_html',
        'type'        => 'textarea',
    ]);

    // Control: Transparent Header
    $wp_customize->add_setting('ht_blog_layout_transparent_header', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_layout_transparent_header_control', [
        'label'    => __('Transparent Header', 'ht'),
        'section'  => 'mytheme_blog_layout_section',
        'settings' => 'ht_blog_layout_transparent_header',
        'type'     => 'checkbox',
    ]);

    // Control: Blog Sidebar
    $wp_customize->add_setting('ht_blog_layout_sidebar', [
        'default'           => 'right-sidebar',
        'sanitize_callback' => 'sanitize_key',
    ]);
    $wp_customize->add_control('ht_blog_layout_sidebar_control', [
        'label'    => __('Blog Sidebar', 'ht'),
        'section'  => 'mytheme_blog_layout_section',
        'settings' => 'ht_blog_layout_sidebar',
        'type'     => 'radio',
        'choices'  => [
            'right-sidebar' => 'Right Sidebar',
            'left-sidebar'  => 'Left Sidebar',
            'no-sidebar'    => 'No Sidebar',
        ],
    ]);

    // Control: Enable Sidebar Divider
    $wp_customize->add_setting('ht_blog_layout_sidebar_divider', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_layout_sidebar_divider_control', [
        'label'    => __('Enable Sidebar Divider', 'ht'),
        'section'  => 'mytheme_blog_layout_section',
        'settings' => 'ht_blog_layout_sidebar_divider',
        'type'     => 'checkbox',
    ]);

    // Control: Sticky sidebar
    $wp_customize->add_setting('ht_blog_layout_sidebar_sticky', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_layout_sidebar_sticky_control', [
        'label'    => __('Sticky sidebar', 'ht'),
        'section'  => 'mytheme_blog_layout_section',
        'settings' => 'ht_blog_layout_sidebar_sticky',
        'type'     => 'checkbox',
    ]);

    // Control: Posts Layout
    $wp_customize->add_setting('ht_blog_layout_posts_layout', [
        'default'           => 'three-col',
        'sanitize_callback' => 'sanitize_key',
    ]);
    $wp_customize->add_control('ht_blog_layout_posts_layout_control', [
        'label'    => __('Posts Layout', 'ht'),
        'section'  => 'mytheme_blog_layout_section',
        'settings' => 'ht_blog_layout_posts_layout',
        'type'     => 'radio',
        'choices'  => [
            'normal'    => 'Normal',
            'inline'    => 'Inline',
            'two-col'   => 'Two Col',
            'three-col' => 'Three Col',
            'list'      => 'List',
        ],
    ]);

    // Control: Posts Layout Type
    $wp_customize->add_setting('ht_blog_layout_posts_layout_type', [
        'default'           => 'row',
        'sanitize_callback' => 'sanitize_key',
    ]);
    $wp_customize->add_control('ht_blog_layout_posts_layout_type_control', [
        'label'    => __('Posts Layout Type', 'ht'),
        'section'  => 'mytheme_blog_layout_section',
        'settings' => 'ht_blog_layout_posts_layout_type',
        'type'     => 'radio',
        'choices'  => ['row' => 'Row', 'masonry' => 'Masonry'],
    ]);

    // Control: Show Excerpts Only
    $wp_customize->add_setting('ht_blog_layout_show_excerpts_only', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_layout_show_excerpts_only_control', [
        'label'    => __('Show Excerpts Only', 'ht'),
        'section'  => 'mytheme_blog_layout_section',
        'settings' => 'ht_blog_layout_show_excerpts_only',
        'type'     => 'checkbox',
    ]);

    // Control: Posts Title Align
    $wp_customize->add_setting('ht_blog_layout_title_align', [
        'default'           => 'left',
        'sanitize_callback' => 'sanitize_key',
    ]);
    $wp_customize->add_control('ht_blog_layout_title_align_control', [
        'label'    => __('Posts Title Align', 'ht'),
        'section'  => 'mytheme_blog_layout_section',
        'settings' => 'ht_blog_layout_title_align',
        'type'     => 'radio',
        'choices'  => ['left' => 'Left', 'center' => 'Center', 'right' => 'Right'],
    ]);

    // =========================================================================
    // SECTION 3: BLOG ARCHIVE
    // =========================================================================
    $wp_customize->add_section('mytheme_blog_archive_section', [
        'title'       => __('Blog Archive', 'ht'),
        'description' => __('Set custom layouts for archive pages like Categories, Search etc.', 'ht'),
        'panel'       => 'mytheme_blog_settings_panel',
        'priority'    => 30,
    ]);

    // Control: Enable Blog Archive Title
    $wp_customize->add_setting('ht_blog_archive_show_title', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_archive_show_title_control', [
        'label'    => __('Enable Blog Archive Title', 'ht'),
        'section'  => 'mytheme_blog_archive_section',
        'settings' => 'ht_blog_archive_show_title',
        'type'     => 'checkbox',
    ]);

    // Control: Posts Layout (Archive)
    $wp_customize->add_setting('ht_blog_archive_posts_layout', [
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_key',
    ]);
    $wp_customize->add_control('ht_blog_archive_posts_layout_control', [
        'label'    => __('Posts Layout', 'ht'),
        'section'  => 'mytheme_blog_archive_section',
        'settings' => 'ht_blog_archive_posts_layout',
        'type'     => 'select',
        'choices'  => [
            'default'   => 'Default',
            'normal'    => 'Normal',
            'inline'    => 'Inline',
            'two-col'   => 'Two Col',
            'three-col' => 'Three Col',
            'list'      => 'List'
        ],
    ]);

    // =========================================================================
    // SECTION 4: BLOG SINGLE POST
    // =========================================================================
    $wp_customize->add_section('mytheme_blog_single_post_section', [
        'title'    => __('Blog Single Post', 'ht'),
        'panel'    => 'mytheme_blog_settings_panel',
        'priority' => 40,
    ]);

    // Control: Blog Post Single Layout
    $wp_customize->add_setting('ht_blog_single_layout', [
        'default'           => 'left-sidebar',
        'sanitize_callback' => 'sanitize_key',
    ]);
    $wp_customize->add_control('ht_blog_single_layout_control', [
        'label'    => __('Blog Post Single Layout', 'ht'),
        'section'  => 'mytheme_blog_single_post_section',
        'settings' => 'ht_blog_single_layout',
        'type'     => 'radio',
        'choices'  => [
            'right-sidebar' => 'Right Sidebar',
            'left-sidebar'  => 'Left Sidebar',
            'no-sidebar'    => 'No Sidebar'
        ],
    ]);

    // Control: Title Layout
    $wp_customize->add_setting('ht_blog_single_title_layout', [
        'default'           => 'normal',
        'sanitize_callback' => 'sanitize_key',
    ]);
    $wp_customize->add_control('ht_blog_single_title_layout_control', [
        'label'    => __('Title Layout', 'ht'),
        'section'  => 'mytheme_blog_single_post_section',
        'settings' => 'ht_blog_single_title_layout',
        'type'     => 'radio',
        'choices'  => ['normal' => 'Normal', 'top-full' => 'Top Full', 'inline' => 'Inline'],
    ]);

    // Control: Transparent Header (Single)
    $wp_customize->add_setting('ht_blog_single_transparent_header', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_single_transparent_header_control', [
        'label'    => __('Transparent Header', 'ht'),
        'section'  => 'mytheme_blog_single_post_section',
        'settings' => 'ht_blog_single_transparent_header',
        'type'     => 'checkbox',
    ]);

    // Control: Show Category
    $wp_customize->add_setting('ht_blog_single_show_category', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_single_show_category_control', [
        'label'    => __('Category', 'ht'),
        'section'  => 'mytheme_blog_single_post_section',
        'settings' => 'ht_blog_single_show_category',
        'type'     => 'checkbox',
    ]);

    // Control: Show Title
    $wp_customize->add_setting('ht_blog_single_show_title', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_single_show_title_control', [
        'label'    => __('Title', 'ht'),
        'section'  => 'mytheme_blog_single_post_section',
        'settings' => 'ht_blog_single_show_title',
        'type'     => 'checkbox',
    ]);

    // Control: Show Meta
    $wp_customize->add_setting('ht_blog_single_show_meta', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_single_show_meta_control', [
        'label'    => __('Meta', 'ht'),
        'section'  => 'mytheme_blog_single_post_section',
        'settings' => 'ht_blog_single_show_meta',
        'type'     => 'checkbox',
    ]);

    // Control: Show Featured image
    $wp_customize->add_setting('ht_blog_single_show_featured_image', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_single_show_featured_image_control', [
        'label'    => __('Featured image', 'ht'),
        'section'  => 'mytheme_blog_single_post_section',
        'settings' => 'ht_blog_single_show_featured_image',
        'type'     => 'checkbox',
    ]);

    // Control: Show Share icons
    $wp_customize->add_setting('ht_blog_single_show_share_icons', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_single_show_share_icons_control', [
        'label'    => __('Share icons', 'ht'),
        'section'  => 'mytheme_blog_single_post_section',
        'settings' => 'ht_blog_single_show_share_icons',
        'type'     => 'checkbox',
    ]);

    // Control: Show Meta (Footer)
    $wp_customize->add_setting('ht_blog_single_show_footer_meta', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_single_show_footer_meta_control', [
        'label'    => __('Meta (Footer)', 'ht'),
        'section'  => 'mytheme_blog_single_post_section',
        'settings' => 'ht_blog_single_show_footer_meta',
        'type'     => 'checkbox',
    ]);

    // Control: Show Blog author box
    $wp_customize->add_setting('ht_blog_single_show_author_box', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_single_show_author_box_control', [
        'label'    => __('Blog author box', 'ht'),
        'section'  => 'mytheme_blog_single_post_section',
        'settings' => 'ht_blog_single_show_author_box',
        'type'     => 'checkbox',
    ]);

    // Control: Show Next/Prev navigation
    $wp_customize->add_setting('ht_blog_single_show_nav', [
        'default'           => true,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_single_show_nav_control', [
        'label'    => __('Next/Prev navigation', 'ht'),
        'section'  => 'mytheme_blog_single_post_section',
        'settings' => 'ht_blog_single_show_nav',
        'type'     => 'checkbox',
    ]);

    // Control: HTML after blog posts
    $wp_customize->add_setting('ht_blog_single_html_after', [
        'default'           => '',
        'sanitize_callback' => 'wp_kses_post',
    ]);
    $wp_customize->add_control('ht_blog_single_html_after_control', [
        'label'       => __('HTML after blog posts', 'ht'),
        'description' => __('Enter HTML or shortcodes...', 'ht'),
        'section'     => 'mytheme_blog_single_post_section',
        'settings'    => 'ht_blog_single_html_after',
        'type'        => 'textarea',
    ]);

    // =========================================================================
    // SECTION 5: BLOG FEATURED POSTS
    // =========================================================================
    $wp_customize->add_section('mytheme_blog_featured_posts_section', [
        'title'    => __('Blog Featured Posts', 'ht'),
        'panel'    => 'mytheme_blog_settings_panel',
        'priority' => 50,
    ]);

    // Control: Featured Posts
    $wp_customize->add_setting('ht_blog_featured_layout', [
        'default'           => 'disabled',
        'sanitize_callback' => 'sanitize_key',
    ]);
    $wp_customize->add_control('ht_blog_featured_layout_control', [
        'label'       => __('Featured Posts', 'ht'),
        'description' => __('Show Featured posts in a slider...', 'ht'),
        'section'     => 'mytheme_blog_featured_posts_section',
        'settings'    => 'ht_blog_featured_layout',
        'type'        => 'radio',
        'choices'     => ['disabled' => 'Disabled (X)', 'layout1' => 'Layout 1', 'layout2' => 'Layout 2'],
    ]);

    // Control: Hide Featured Posts from Default Blog feed
    $wp_customize->add_setting('ht_blog_featured_hide_from_feed', [
        'default'           => false,
        'sanitize_callback' => 'wp_validate_boolean',
    ]);
    $wp_customize->add_control('ht_blog_featured_hide_from_feed_control', [
        'label'    => __('Hide Featured Posts from Default Blog feed.', 'ht'),
        'section'  => 'mytheme_blog_featured_posts_section',
        'settings' => 'ht_blog_featured_hide_from_feed',
        'type'     => 'checkbox',
    ]);

    // Control: Featured Posts Height
    $wp_customize->add_setting('ht_blog_featured_height', [
        'default'           => 500,
        'sanitize_callback' => 'absint',
    ]);
    $wp_customize->add_control('ht_blog_featured_height_control', [
        'label'       => __('Featured Posts Height', 'ht'),
        'section'     => 'mytheme_blog_featured_posts_section',
        'settings'    => 'ht_blog_featured_height',
        'type'        => 'range',
        'input_attrs' => ['min' => 300, 'max' => 800, 'step' => 10],
    ]);

    // Control: Image Size
    $wp_customize->add_setting('ht_blog_featured_image_size', [
        'default'           => 'medium',
        'sanitize_callback' => 'sanitize_key',
    ]);
    $wp_customize->add_control('ht_blog_featured_image_size_control', [
        'label'    => __('Image Size', 'ht'),
        'section'  => 'mytheme_blog_featured_posts_section',
        'settings' => 'ht_blog_featured_image_size',
        'type'     => 'radio',
        'choices'  => [
            'thumbnail' => 'Thumbnail',
            'medium'    => 'Medium',
            'large'     => 'Large',
            'original'  => 'Original'
        ],
    ]);
}