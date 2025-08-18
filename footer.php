<style>
    /* Footer styles from Customizer */
    .footer {
        color: <?php echo get_theme_mod('footer_text_color', '#000'); ?>;
        background-color: <?php echo get_theme_mod('footer_background_color', '#fff'); ?>;
        margin: <?php echo get_theme_mod('footer_main_margin', '0'); ?>;
        padding: <?php echo get_theme_mod('footer_main_padding', '2rem 1rem'); ?>;
    }

    .footer-items-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
    }

    .footer-item {
        flex: 1;
        min-width: 150px;
    }

    .footer-logo img {
        max-height: 50px;
        /* Adjust as needed */
        width: auto;
    }
</style>

<footer class="footer">
    <div class="footer-items-container">
        <?php
        // Get the layout from the Customizer
        $layout_json = get_theme_mod('ht_footer_layout', json_encode(['logo', 'html1', 'menu']));
        $items = json_decode($layout_json, true);

        if (is_array($items)) {
            foreach ($items as $item_id) {
                echo '<div class="footer-item ' . esc_attr($item_id) . '">';

                switch ($item_id) {
                    // Case for the Logo
                    case 'logo':
                        $logo_url = get_theme_mod('ht_footer_logo');
                        if ($logo_url) {
                            echo '<div class="footer-logo">';
                            echo '<img src="' . esc_url($logo_url) . '" alt="' . get_bloginfo('name') . ' Footer Logo">';
                            echo '</div>';
                        }
                        break;

                    // Case for the Menu
                    // case 'menu':
                    //     wp_nav_menu([
                    //         'theme_location' => 'footer_menu',
                    //         'fallback_cb'    => false, // Do not show anything if menu is not set
                    //         'container'      => 'nav',
                    //         'container_class' => 'footer-navigation',
                    //         'menu_class'     => 'footer-menu-list',
                    //     ]);
                    //     break;
                    case 'menu':
                        if (has_nav_menu('footer_menu')) {
                            wp_nav_menu([
                                'theme_location' => 'footer_menu',
                                'container'      => 'nav',
                                'container_class' => 'footer-navigation',
                                'menu_class'     => 'footer-menu-list',
                            ]);
                        } else {
                            echo '<p class="no-menu-message">Chưa thêm menu</p>';
                        }
                        break;


                    // Default case for HTML items (html1, html2, etc.)
                    default:
                        // Check if it's an HTML item
                        if (strpos($item_id, 'html') === 0) {
                            $html_content = get_theme_mod("ht_footer_{$item_id}");
                            if (!empty($html_content)) {
                                echo wp_kses_post($html_content);
                            }
                        }
                        break;
                }

                echo '</div>'; // Close .footer-item
            }
        }
        ?>
    </div>
</footer>

</div> <?php // Closes <div id="page"> from header 
        ?>
<?php wp_footer(); ?>
</body>

</html>