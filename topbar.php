<nav class="ht-topbar-builder">
    <div class="topbar row align-items-center py-2">
        <?php
        // Lấy layout từ Customizer (sắp xếp bởi người dùng)
        $layout = get_theme_mod('ht_topbar_layout', json_encode(['menu', 'html1', 'social']));
        $items = json_decode($layout, true);

        // Lấy các tùy chọn cho ô tìm kiếm từ Customizer
        $search_ui = get_theme_mod('header_search_ui', 'default');
        $search_placeholder = get_theme_mod('search_placeholder', 'Tìm kiếm...');
        $search_button_html = get_theme_mod('search_button_html', 'Tìm');

        // Lấy các tùy chọn style
        $search_width = get_theme_mod('search_width', '200');
        $search_height = get_theme_mod('search_height', '40');
        $search_border_radius_left = get_theme_mod('search_border_radius_left', '0');
        $search_border_radius_right = get_theme_mod('search_border_radius_right', '0');
        
        $button_text_color = get_theme_mod('search_button_text_color', '#ffffff');
        $button_bg_color = get_theme_mod('search_button_background_color', '#0073aa');
        $button_font_size = get_theme_mod('search_button_font_size', '16px');
        $button_padding = get_theme_mod('search_button_padding', '10px 20px');
        $button_border_radius = get_theme_mod('search_button_border_radius', '0');

        // Tạo chuỗi style cho input
        $input_styles = "
            width: {$search_width}px; 
            height: {$search_height}px; 
            border-top-left-radius: {$search_border_radius_left}; 
            border-bottom-left-radius: {$search_border_radius_left};
            border-top-right-radius: {$search_border_radius_right};
            border-bottom-right-radius: {$search_border_radius_right};
        ";

        // Tạo chuỗi style cho button
        $button_styles = "
            height: {$search_height}px; 
            color: {$button_text_color}; 
            background-color: {$button_bg_color}; 
            font-size: {$button_font_size}; 
            padding: {$button_padding}; 
            border-radius: {$button_border_radius};
        ";

        if (is_array($items)) {
            foreach ($items as $index => $item_id) {

                // Mở thẻ div bao bọc chung cho mỗi item
                // Thêm class d-flex và align-items-center để căn giữa nội dung theo chiều dọc
                echo '<div class="topbar-item col ' . esc_attr($item_id) . ' text-sm d-flex align-items-center">';

                // Sử dụng switch để xử lý từng loại item
                switch ($item_id) {

                    case 'menu':
                        if (has_nav_menu('topbar_menu')) {
                            wp_nav_menu([
                                'theme_location' => 'topbar_menu',
                                'container'      => false,
                                'menu_class'     => 'ht-topbar-menu d-flex list-unstyled gap-4 my-auto',
                                'depth'          => 1,
                            ]);
                        } else {
                            echo '<ul class="ht-topbar-menu d-flex list-unstyled gap-4 mb-0"><li><a href="' . esc_url(admin_url('nav-menus.php')) . '" class="text-decoration-none"><span>Chưa thêm menu</span></a></li></ul>';
                        }
                        break;

                    case 'search':
                        echo "
                        <style>
                            .topbar-item.search input::placeholder,
                            .topbar-item.search input::-webkit-input-placeholder { /* Chrome, Opera, Safari */
                                font-family: inherit;
                            }
                            .topbar-item.search input::-moz-placeholder { /* Firefox 19+ */
                                font-family: inherit;
                                opacity: 1; /* Firefox mặc định có độ mờ */
                            }
                            .topbar-item.search input:-ms-input-placeholder { /* IE 10+ */
                                font-family: inherit;
                            }
                        </style>
                        ";

                        if ($search_ui == 'modern') {
                            echo '
                            <form role="search" method="get" action="' . esc_url(home_url('/')) . '" class="d-flex align-items-center w-100">
                                <input name="s" type="search" placeholder="' . esc_attr($search_placeholder) . '" 
                                       class="form-control rounded-start me-1" style="' . esc_attr($input_styles) . '" />
                                <button type="submit" class="search-button btn d-flex align-items-center" style="' . esc_attr($button_styles) . '">
                                    ' . wp_kses_post($search_button_html) . '
                                </button>
                            </form>';
                        } elseif ($search_ui == 'simple') {
                            echo '
                            <form role="search" method="get" action="' . esc_url(home_url('/')) . '" class="w-100">
                                <input name="s" type="search" placeholder="' . esc_attr($search_placeholder) . '" 
                                       class="form-control" style="' . esc_attr($input_styles) . '" />
                            </form>';
                        } else { // Mặc định
                            echo '
                            <form role="search" method="get" action="' . esc_url(home_url('/')) . '" class="search-form d-flex align-items-center w-100">
                                <input name="s" type="search" placeholder="' . esc_attr($search_placeholder) . '" 
                                       class="form-control me-1" style="' . esc_attr($input_styles) . '" />
                                <button type="submit" class="search-button btn d-flex align-items-center" style="' . esc_attr($button_styles) . '">
                                    ' . wp_kses_post($search_button_html) . '
                                </button>
                            </form>';
                        }
                        break;

                    case 'social':
                    // // Mảng map key với class icon của Font Awesome và tên hiển thị
                    // $social_networks = [
                    //     'facebook'    => ['icon' => 'fab fa-facebook', 'name' => 'Facebook'],
                    //     'threads'     => ['icon' => 'fab fa-threads', 'name' => 'Threads'],
                    //     'instagram'   => ['icon' => 'fab fa-instagram', 'name' => 'Instagram'],
                    //     'tiktok'      => ['icon' => 'fab fa-tiktok', 'name' => 'TikTok'],
                    //     'youtube'     => ['icon' => 'fab fa-youtube', 'name' => 'YouTube'],
                    //     'twitter'     => ['icon' => 'fab fa-twitter', 'name' => 'Twitter'],
                    //     'x-twitter'   => ['icon' => 'fab fa-x-twitter', 'name' => 'X'],
                    //     'telegram'    => ['icon' => 'fab fa-telegram', 'name' => 'Telegram'],
                    //     'discord'     => ['icon' => 'fab fa-discord', 'name' => 'Discord'],
                    //     'phone'       => ['icon' => 'fa-solid fa-phone', 'name' => 'Số điện thoại'],
                    //     'email'       => ['icon' => 'fas fa-envelope', 'name' => 'Email'],
                    // ];

                    // echo '<div class="ht-social-icons d-flex flex-wrap align-items-center gap-3">';

                    // foreach ($social_networks as $key => $details) {
                    //     $link = get_theme_mod("ht_social_{$key}_url");

                    //     if (!empty($link)) {
                    //         $href = '';
                    //         // Tạo nội dung cho tooltip
                    //         $tooltip_title = 'Theo dõi trên ' . $details['name'];
                    //         if ($key === 'phone') {
                    //             $href = 'tel:' . esc_attr($link);
                    //             $tooltip_title = 'Gọi ' . esc_attr($link); // Thay đổi nội dung tooltip cho phù hợp
                    //         } elseif ($key === 'email') {
                    //             $href = 'mailto:' . antispambot(esc_attr($link));
                    //             $tooltip_title = 'Gửi email tới ' . antispambot(esc_attr($link)); // Thay đổi nội dung tooltip
                    //         } else {
                    //             $href = esc_url($link);
                    //         }
                            
                    //         // Thêm các thuộc tính data-bs-* để tạo tooltip
                    //         echo '<a href="' . $href . '" 
                    //             aria-label="' . esc_attr($details['name']) . '" 
                    //             target="_blank" 
                    //             rel="noopener noreferrer" 
                    //             class="text-decoration-none"
                    //             data-bs-toggle="tooltip" 
                    //             data-bs-placement="bottom" 
                    //             title="' . esc_attr($tooltip_title) . '">';
                            
                    //         echo '<i class="' . esc_attr($details['icon']) . '"></i>';
                    //         echo '</a>';
                    //     }
                    // }
                    // echo '</div>';
                    ht_display_social_icons_component();
                        break;

                    case 'contact':
                        // Lấy nội dung từ Customizer, có giá trị mặc định
                        // echo '<div class="ht-contact-info">';
                        // echo wp_kses_post(get_theme_mod('ht_topbar_contact', 'Hotline: 0123-456-789'));
                        // echo '</div>';
                        ht_display_hotline_component();
                        break;
                        
                    case 'language_switcher':
                        // Placeholder cho chức năng chuyển ngôn ngữ
                        echo '<div class="ht-language-switcher">';
                        echo '<select class="form-select form-select-sm" aria-label="Language switcher"><option selected>Tiếng Việt</option><option>English</option></select>';
                        echo '</div>';
                        break;

                    case 'cart':
                        // Placeholder cho giỏ hàng, nên tích hợp với WooCommerce nếu có
                        //$cart_url = function_exists('wc_get_cart_url') ? wc_get_cart_url() : '#';
                        //$cart_count = function_exists('WC') ? WC()->cart->get_cart_contents_count() : 0;
                        echo '<a href="' . esc_url($cart_url) . '" class="ht-cart-button text-decoration-none">';
                        echo '<i class="fas fa-shopping-cart"></i> Giỏ hàng (' . esc_html($cart_count) . ')';
                        echo '</a>';
                        break;

                    case 'signup':
                        echo '<a href="' . site_url('/dang-ky')  . '" class="ht-signup-button text-decoration-none">Đăng ký</a>';
                        break;

                    case 'login': //đăng xuất nhanh
                        if (is_user_logged_in()) {
                            $current_user = wp_get_current_user();
                            echo '<div class="ht-user-menu">';
                            echo '<span>Xin chào, ' . esc_html($current_user->display_name) . '!</span>';
                            echo ' | <a href="' . esc_url(wp_logout_url(home_url())) . '" class="text-decoration-none">Đăng xuất</a>';
                            echo '</div>';
                        } else {
                            //echo '<a href="' . get_permalink(get_page_by_path('dang-nhap')) . '" class="ht-login-button text-decoration-none">Đăng nhập</a>';
                        }
                        break;

                    // Mặc định sẽ xử lý các khối html (html1, html2,...)
                    default:
                        // Kiểm tra nếu item_id bắt đầu bằng 'html'
                        if (strpos($item_id, 'html') === 0) {
                            $html_content = get_theme_mod("ht_topbar_{$item_id}");
                            if (!empty($html_content)) {
                                echo wp_kses_post($html_content);
                            }
                        }
                        break;
                }

                // Đóng thẻ div bao bọc
                echo '</div>';
            }
        }
        ?>
    </div>
</nav>