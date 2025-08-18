<?php

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Callback function to render the HTML for the "Advanced" options page.
 */
function my_theme_options_page_html()
{
    if (! current_user_can('manage_options')) {
        return;
    }
?>
    <div class="wrap">
        <h1><?php echo esc_html(get_admin_page_title()); ?></h1>

        <h2 class="nav-tab-wrapper">
            <a href="#tab-scripts" class="nav-tab nav-tab-active">Scripts</a>
            <a href="#tab-css" class="nav-tab">Custom CSS</a>
        </h2>

        <form action="options.php" method="post">
            <?php settings_fields('my_theme_options_group'); ?>

            <div id="tab-scripts" class="tab-content active">
                <h3>Global Scripts</h3>
                <?php do_settings_sections('my_theme_options_scripts'); ?>
            </div>

            <div id="tab-css" class="tab-content">
                <h3>Responsive CSS</h3>
                <?php do_settings_sections('my_theme_options_css'); ?>
            </div>

            <?php submit_button('Lưu tất cả thay đổi'); ?>
        </form>
    </div>

    <style>
        .tab-content {
            display: none;
            margin-top: 20px;
        }

        .tab-content.active {
            display: block;
        }

        .form-table th {
            width: 200px;
        }
    </style>

    <script>
        jQuery(document).ready(function($) {
            // Tab switching logic
            var tabs = $('.nav-tab-wrapper .nav-tab');
            var contents = $('.tab-content');
            var activeTab = window.location.hash;

            if (activeTab) {
                tabs.removeClass('nav-tab-active');
                contents.removeClass('active');
                $('a[href="' + activeTab + '"]').addClass('nav-tab-active');
                $(activeTab).addClass('active');
            }

            tabs.on('click', function(e) {
                e.preventDefault();
                tabs.removeClass('nav-tab-active');
                $(this).addClass('nav-tab-active');
                contents.removeClass('active');
                var newHash = $(this).attr('href');
                $(newHash).addClass('active');
                window.location.hash = newHash;
            });
        });
    </script>
<?php
}

/**
 * Register settings, sections, and fields for the "Advanced" options page.
 */
function my_theme_settings_init()
{
    register_setting('my_theme_options_group', 'my_theme_settings');

    // Scripts Tab
    add_settings_section('my_theme_scripts_section', null, null, 'my_theme_options_scripts');
    add_settings_field('header_scripts', 'Header Scripts', 'my_theme_field_callback', 'my_theme_options_scripts', 'my_theme_scripts_section', ['id' => 'header_scripts', 'desc' => 'Inserts into the <code>&lt;head&gt;</code> tag.']);
    add_settings_field('body_top_scripts', 'Body Scripts - Top', 'my_theme_field_callback', 'my_theme_options_scripts', 'my_theme_scripts_section', ['id' => 'body_top_scripts', 'desc' => 'Inserts just after the opening <code>&lt;body&gt;</code> tag.']);
    add_settings_field('footer_scripts', 'Footer Scripts', 'my_theme_field_callback', 'my_theme_options_scripts', 'my_theme_scripts_section', ['id' => 'footer_scripts', 'desc' => 'Inserts before the closing <code>&lt;/body&gt;</code> tag.']);

    // CSS Tab
    add_settings_section('my_theme_css_section', null, null, 'my_theme_options_css');
    add_settings_field('css_all_screens', 'All screens', 'my_theme_field_callback', 'my_theme_options_css', 'my_theme_css_section', ['id' => 'css_all_screens', 'desc' => 'Applies to all screen sizes.']);
    add_settings_field('css_tablet', 'Tablets and down', 'my_theme_field_callback', 'my_theme_options_css', 'my_theme_css_section', ['id' => 'css_tablet', 'desc' => 'Applies to screens 991px and smaller.']);
    add_settings_field('css_mobile', 'Mobile only', 'my_theme_field_callback', 'my_theme_options_css', 'my_theme_css_section', ['id' => 'css_mobile', 'desc' => 'Applies to screens 767px and smaller.']);
}
add_action('admin_init', 'my_theme_settings_init');

/**
 * General callback function to render textarea fields.
 */
function my_theme_field_callback($args)
{
    $options = get_option('my_theme_settings');
    $id      = $args['id'];
    $value   = isset($options[$id]) ? $options[$id] : '';
    echo '<textarea name="my_theme_settings[' . esc_attr($id) . ']" rows="10" class="large-text code">' . esc_textarea($value) . '</textarea>';
    if (! empty($args['desc'])) {
        echo '<p class="description">' . wp_kses_post($args['desc']) . '</p>';
    }
}
