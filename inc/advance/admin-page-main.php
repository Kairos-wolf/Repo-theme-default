<?php

// Exit if accessed directly.
if (! defined('ABSPATH')) {
    exit;
}

/**
 * Callback function to render the HTML for the main theme panel.
 */
function mytheme_panel_page_callback()
{
?>
    <div class="wrap">
        <h1>Welcome to MyTheme</h1>
        <p>Thanks for using MyTheme - A clean and customizable theme for WordPress.</p>

        <h2 class="nav-tab-wrapper">
            <a href="?page=mytheme-panel&tab=registration" class="nav-tab <?php echo mytheme_active_tab('registration'); ?>">Theme Registration</a>
            <a href="?page=mytheme-panel&tab=help" class="nav-tab <?php echo mytheme_active_tab('help'); ?>">Help & Guides</a>
            <a href="?page=mytheme-panel&tab=status" class="nav-tab <?php echo mytheme_active_tab('status'); ?>">Status</a>
        </h2>

        <div style="background: #fff; padding: 20px; border: 1px solid #ccd0d4;">
            <?php
            $tab = $_GET['tab'] ?? 'registration';
            switch ($tab) {
                case 'help':
                    echo '<h3>Help & Guides</h3><p>Here is some documentation...</p>';
                    break;
                case 'status':
                    echo '<h3>System Status</h3><p>All systems are go!</p>';
                    break;
                default:
                    echo '<h3>Theme Registration</h3><p>Your theme is registered. Thank you!</p>';
            }
            ?>
        </div>
    </div>
<?php
}

/**
 * Helper function to set the active tab class.
 */
function mytheme_active_tab($tab_name)
{
    $current_tab = $_GET['tab'] ?? 'registration';
    return $current_tab === $tab_name ? 'nav-tab-active' : '';
}
