<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-thin.css">

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-solid.css">

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-regular.css">

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-duotone-light.css">

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-thin.css">

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-solid.css">

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-regular.css">

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/sharp-light.css">

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/duotone-thin.css">

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/duotone-regular.css">

    <link
        rel="stylesheet"
        href="https://site-assets.fontawesome.com/releases/v6.7.2/css/duotone-light.css">

    <?php
    wp_enqueue_style('bootstrap-css', get_template_directory_uri() . '/assets/css/bootstrap.min.css');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.bundle.js');
    ?>
    <?php wp_head(); ?>

    <style>
        /* 
        * CSS cho các chế độ Layout
        */

        body.layout-full-width .container-fluid,
        body.layout-full-width .topbar,
        body.layout-full-width .headerbottom,
        body.layout-full-width main,
        body.layout-full-width .footer-items-container {
            max-width: <?php echo absint(get_theme_mod('ht_boxed_width', 1200)); ?>px;
            margin: auto;
        }

        body.layout-full-width {
            background-color: <?php echo esc_attr(get_theme_mod('ht_background_color_layout', '#f1f1f1')); ?>;
        }
        @media only screen and (min-width: 992px) {

            /* Nền cho chế độ Boxed */
            body.layout-boxed {
                background-color: <?php echo esc_attr(get_theme_mod('ht_background_color_layout', '#f1f1f1')); ?>;
            }

            body.layout-boxed #page {
                max-width: <?php echo absint(get_theme_mod('ht_boxed_width', 1400)); ?>px;
                /* Lấy giá trị động từ Customizer */
                margin: auto;
                background-color: <?php echo esc_attr(get_theme_mod('ht_background_color_layout', '#f1f1f1')); ?>;
            }

            /* Nền cho chế độ Framed */
            body.layout-framed {
                background-color: <?php echo esc_attr(get_theme_mod('ht_background_color_layout', '#f1f1f1')); ?>;
                max-width: <?php echo absint(get_theme_mod('ht_boxed_width', 1400)); ?>px;
                margin: 30px auto;
                box-sizing: border-box;
            }

            body.layout-framed #page {
                background-color: <?php echo esc_attr(get_theme_mod('ht_background_color_layout', '#f1f1f1')); ?>;
            }

        }

        /* >= 640px */
        @media (min-width: 640px) {

            /* Header Main */
            .header-main {
                padding: <?php echo get_theme_mod('header_main_padding', '0'); ?>;
                margin: <?php echo get_theme_mod('header_main_margin', '0'); ?>;
                border-radius: <?php echo get_theme_mod('header_main_border_radius', '0'); ?>;
            }

            /* Logo (Header Main Settings) */
            .padding-logo {
                padding-right: <?php echo get_theme_mod('logo_padding_right', 0); ?>px;
                padding-left: <?php echo get_theme_mod('logo_padding_left', 0); ?>px;
            }

            .custom-logo a img {
                height: <?php echo get_theme_mod('logo_height', 40); ?>px;
                width: <?php echo get_theme_mod('logo_width', 40); ?>px;
                object-fit: contain;
            }

            /* Menu (Header Main Settings) */
            .menu-padding {
                padding-left: <?php echo get_theme_mod('menu_padding_left', 0); ?>px;
                padding-right: <?php echo get_theme_mod('menu_padding_right', 0); ?>px;
            }

            /* Search (Header Main Settings) */
            .search input[type="search"] {
                height: <?php echo get_theme_mod('search_height', 40); ?>px;
                width: <?php echo get_theme_mod('search_width', 200); ?>px;

            }

            .search-button {
                margin: <?php echo esc_attr(get_theme_mod('search_button_margin', '0')); ?>;
                padding: <?php echo esc_attr(get_theme_mod('search_button_padding', '0')); ?>;
            }

        }

        /* Header Main */
        .header-main {
            background-color: <?php echo get_theme_mod('header_main_background_color', '#fff'); ?>;
            color: <?php echo get_theme_mod('header_main_color', '#fff'); ?>;
            background-image: url('<?php echo esc_url(get_theme_mod("header_main_bg_image")); ?>');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        /* Menu (Header Main Settings) */
        .menu a {
            color: <?php echo get_theme_mod('menu_text_color', '#000'); ?>;
            font-size: <?php echo get_theme_mod('menu_font_size', 16); ?>px;
            margin-right: <?php echo get_theme_mod('menu_item_spacing', 0); ?>px;
        }

        .main-menu a:hover {
            color: <?php echo get_theme_mod('menu_hover_color', '#ff0000'); ?>;
        }

        /* Search (Header Main Settings) */
        .search-padding {
            padding-left: <?php echo get_theme_mod('search_padding_left', 0); ?>px;
            padding-right: <?php echo get_theme_mod('search_padding_right', 0); ?>px;
        }

        .search input[type="search"] {
            border-top-left-radius: <?php echo get_theme_mod('search_border_radius_left', 0); ?>;
            border-bottom-left-radius: <?php echo get_theme_mod('search_border_radius_left', 0); ?>;
            border-top-right-radius: <?php echo get_theme_mod('search_border_radius_right', 0); ?>;
            border-bottom-right-radius: <?php echo get_theme_mod('search_border_radius_right', 0); ?>;
        }

        .search-button {
            color: <?php echo esc_attr(get_theme_mod('search_button_text_color', '#fff')); ?>;
            border-radius: <?php echo esc_attr(get_theme_mod('search_button_border_radius', '0')); ?>;
            background-color: <?php echo esc_attr(get_theme_mod('search_button_background_color', '#007bff')); ?>;
            font-size: <?php echo esc_attr(get_theme_mod('search_button_font_size', '16px')); ?>;
        }

        @media (max-width: 640px) {
            .header-main {
                padding: 6px;
            }

            .custom-logo {
                height: 30px;
                width: 30px;
            }
        }
    </style>
</head>

<body <?php body_class(); ?>>
    <div id="page" style="background-color: white;"> <?php // <-- THÊM DÒNG NÀY 
                                                        ?>
        <header class="sticky top-0">
            <!-- Top bar -->
            <?php get_template_part('topbar'); ?>
            <!-- Header main -->
            <nav class="navbar navbar-expand-lg header-main">
                <div class="container-fluid">
                    <!-- Logo -->
                    <div class="navbar-brand d-flex align-items-center">
                        <?php
                        $layout = get_theme_mod('ht_header_layout', '[]');
                        $items = json_decode($layout, true);
                        $firstItem = array_shift($items); // phần tử đầu tiên
                        

                        if ($firstItem === 'logo') {
                            echo '<div class="header-item logo custom-logo me-2">';
                            if (has_custom_logo()) {
                                the_custom_logo();
                            } else {
                                bloginfo('name');
                            }
                            echo '</div>';
                        } else {
                            echo '<div class="header-item me-2">' . esc_html($firstItem) . '</div>';
                        }
                        ?>
                    </div>

                    <!-- Toggle button -->
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <!-- Collapsible menu -->
                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav d-flex align-items-lg-center ">
                            <?php
                            foreach ($items as $item) {
                                echo '<li class="nav-item">';
                                echo render_header_item($item); // Chèn item động từ theme mod
                                echo '</li>';
                            }
                            ?>
                        </ul>
                    </div>
                </div>
            </nav>

            <!-- Header bottom -->
            <?php get_template_part('header-bottom'); ?>
        </header>
        <?php
        // Hàm hiển thị từng phần tử
        function render_header_item($item, $isMobile = false)
        {
            $output = '';
            $search_ui = get_theme_mod('header_search_ui', 'default'); // Lấy kiểu từ customizer
            $search_placeholder = get_theme_mod('search_placeholder', 'Tìm kiếm…');

            // Định nghĩa trạng thái xem một lần để dùng chung
            $current_user = wp_get_current_user();
            $is_customer_view = ($current_user->ID != 0 && in_array('customer', (array) $current_user->roles));

            switch ($item) {
                // case 'menu':
                //     $output .= '<div class="header-item menu menu-padding menu-color">';

                //     $output .= wp_nav_menu([
                //         'theme_location' => 'primary',
                //         'container'      => false,
                //         'echo'           => false,
                //         'menu_class'     => 'navbar-nav me-auto mb-2 mb-lg-0 main-menu', // Bootstrap class
                //         'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                //         'walker'         => new class extends Walker_Nav_Menu {
                //             function start_lvl(&$output, $depth = 0, $args = null)
                //             {
                //                 $output .= '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                //             }

                //             function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
                //             {
                //                 $has_children = in_array('menu-item-has-children', $item->classes);
                //                 $is_dropdown = $depth === 0 && $has_children;

                //                 // Li classes
                //                 $classes = 'nav-item';
                //                 if ($is_dropdown) {
                //                     $classes .= ' dropdown';
                //                 }

                //                 // A classes
                //                 $link_classes = 'nav-link';
                //                 if ($is_dropdown) {
                //                     $link_classes .= ' dropdown-toggle';
                //                 }

                //                 // ID cho aria-labelledby
                //                 $dropdown_id = $is_dropdown ? 'navbarDropdown' . $item->ID : '';

                //                 $output .= '<li class="' . esc_attr($classes) . '">';

                //                 $output .= '<a href="' . esc_url($item->url) . '" class="' . esc_attr($link_classes) . '"';

                //                 if ($is_dropdown) {
                //                     $output .= ' id="' . esc_attr($dropdown_id) . '" role="button" data-bs-toggle="dropdown" aria-expanded="false"';
                //                 }

                //                 $output .= '>';
                //                 $output .= esc_html($item->title);
                //                 $output .= '</a>';
                //             }

                //             function end_el(&$output, $item, $depth = 0, $args = null)
                //             {
                //                 $output .= '</li>';
                //             }

                //             function end_lvl(&$output, $depth = 0, $args = null)
                //             {
                //                 $output .= '</ul>';
                //             }
                //         }
                //     ]);

                //     $output .= '</div>';
                //     break;
                case 'menu':
                    $output .= '<div class="header-item menu menu-padding menu-color">';

                    // KIỂM TRA NẾU CHƯA CÓ MENU
                    if (has_nav_menu('primary')) {
                        $output .= wp_nav_menu([
                            'theme_location' => 'primary',
                            'container'      => false,
                            'echo'           => false,
                            'menu_class'     => 'navbar-nav me-auto mb-2 mb-lg-0 main-menu', // Bootstrap class
                            'items_wrap'     => '<ul class="%2$s">%3$s</ul>',
                            'walker'         => new class extends Walker_Nav_Menu
                            {
                                function start_lvl(&$output, $depth = 0, $args = null)
                                {
                                    $output .= '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                                }

                                function start_el(&$output, $item, $depth = 0, $args = null, $id = 0)
                                {
                                    $has_children = in_array('menu-item-has-children', $item->classes);
                                    $is_dropdown = $depth === 0 && $has_children;

                                    // Li classes
                                    $classes = 'nav-item';
                                    if ($is_dropdown) {
                                        $classes .= ' dropdown';
                                    }

                                    // A classes
                                    $link_classes = 'nav-link';
                                    if ($is_dropdown) {
                                        $link_classes .= ' dropdown-toggle';
                                    }

                                    // ID cho aria-labelledby
                                    $dropdown_id = $is_dropdown ? 'navbarDropdown' . $item->ID : '';

                                    $output .= '<li class="' . esc_attr($classes) . '">';

                                    $output .= '<a href="' . esc_url($item->url) . '" class="' . esc_attr($link_classes) . '"';

                                    if ($is_dropdown) {
                                        $output .= ' id="' . esc_attr($dropdown_id) . '" role="button" data-bs-toggle="dropdown" aria-expanded="false"';
                                    }

                                    $output .= '>';
                                    $output .= esc_html($item->title);
                                    $output .= '</a>';
                                }

                                function end_el(&$output, $item, $depth = 0, $args = null)
                                {
                                    $output .= '</li>';
                                }

                                function end_lvl(&$output, $depth = 0, $args = null)
                                {
                                    $output .= '</ul>';
                                }
                            }
                        ]);
                    } else {
                        // HIỂN THỊ THÔNG BÁO NẾU KHÔNG CÓ MENU
                        $output .= '<ul class="navbar-nav me-auto mb-2 mb-lg-0 main-menu"><li class="nav-item">';
                        if (current_user_can('edit_theme_options')) {
                            // Nếu người dùng có quyền chỉnh sửa, hiển thị link đến trang quản lý menu
                            $output .= '<a class="nav-link" href="' . esc_url(admin_url('nav-menus.php')) . '">Chưa thêm menu</a>';
                        } else {
                            // Nếu là khách, chỉ hiển thị text
                            $output .= '<span class="nav-link">Chưa thêm menu</span>';
                        }
                        $output .= '</li></ul>';
                    }

                    $output .= '</div>';
                    break;

                case 'search':
                    $output .= '<div class="header-item search search-padding">';

                    if ($search_ui == 'modern') { // Hiện đại
                        $output .= '
                <form role="search" method="get" action="' . home_url('/') . '" class="d-flex align-items-center">
                    <input name="s" type="search" placeholder="' . esc_attr($search_placeholder) . '" 
                            class="form-control rounded-start me-1" />
                    <button type="submit" 
                            class="search-button d-flex align-items-center">
                        ' . wp_kses_post(get_theme_mod('search_button_html', 'Tìm <i class="fas fa-search ms-1"></i>')) . '
                    </button>
                </form>';
                    } elseif ($search_ui == 'simple') { // Tối giản
                        $output .= '
                <form role="search" method="get" action="' . home_url('/') . '">
                    <input name="s" type="search" placeholder="' . esc_attr($search_placeholder) . '" 
                            class="form-control" />
                </form>';
                    } else { // Mặc định
                        $output .= '
                <form role="search" method="get" action="' . home_url('/') . '" class="search-form d-flex align-items-center">
                    <input name="s" type="search" placeholder="' . esc_attr($search_placeholder) . '" 
                            class="form-control me-1" />
                    <button type="submit" 
                            class="search-button  d-flex align-items-center">
                        ' . wp_kses_post(get_theme_mod('search_button_html', 'Tìm <i class="fas fa-search ms-1"></i>')) . '
                    </button>
                </form>';
                    }

                    $output .= '</div>';
                    break;
                case 'social':
                    $output .= '<div class="header-item social flex space-x-2">';
                    $output .= '<a href="#"><img src="' . get_template_directory_uri() . '/assets/img/facebook.svg" alt="Facebook" class="h-5 w-5"></a>';
                    $output .= '<a href="#"><img src="' . get_template_directory_uri() . '/assets/img/twitter.svg" alt="Twitter" class="h-5 w-5"></a>';
                    $output .= '</div>';
                    break;
                case 'contact':
                    $output .= '<div class="header-item contact text-sm">';
                    $output .= '<span class="font-medium">Hotline:</span> 0989-xxx-xxx';
                    $output .= '</div>';
                    break;
                case 'custom_html':
                    $output .= '<div class="header-item custom-html">';
                    $output .= do_shortcode(get_theme_mod('ht_header_custom_html', ''));
                    $output .= '</div>';
                    break;
                case 'language_switcher':
                    $output .= '<div class="header-item lang">';
                    $output .= '<select class="text-sm border-gray-300 rounded p-1">
                            <option>🇻🇳 VN</option>
                            <option>🇬🇧 EN</option>
                        </select>';
                    $output .= '</div>';
                    break;
                case 'cart':
                    $cart_count = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
                    $output .= '<div class="header-item cart position-relative">'; // Use Bootstrap's position-relative
                    $output .= '<a href="' . site_url('/index.php/cart') . '" class="btn btn-outline-light position-relative">'; // Bootstrap button styling
                    $output .= '<i class="fa-solid fa-cart-shopping me-1"></i> Cart'; // Font Awesome icon with some text
                    if ($cart_count > 0) {
                        $output .= '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">'; // Bootstrap badge for count
                        $output .= $cart_count;
                        $output .= '<span class="visually-hidden">items in cart</span>'; // For accessibility
                        $output .= '</span>';
                    }
                    $output .= '</a>';
                    $output .= '</div>';
                    break;
                case 'signup':
                    if (!$is_customer_view) {
                        $output .= '<div class="header-item signup">';
                        $output .= '<a href="' . site_url('/index.php/dang-ky') . '" class="">Đăng ký</a>';
                        $output .= '</div>';
                    }
                    break;
                case 'login':
                    $output .= '<div class="header-item login">';

                    // Kiểm tra nếu là khách hàng đã đăng nhập
                    if (is_user_logged_in() && in_array('customer', (array)$current_user->roles)) {

                        // Lấy URL các trang một cách linh hoạt, tránh hard-code
                        $account_url = get_permalink(get_page_by_path('tai-khoan')); // <-- Thay slug nếu cần
                        $order_history_url = get_permalink(get_page_by_path('theo-doi-don-hang')); // <-- Thay slug nếu cần
                        $logout_url = wp_logout_url(home_url());

                        $output .= '<div class="nav-item dropdown">';
                        $output .= '<a class="nav-link dropdown-toggle" href="#" id="userAccountDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">';
                        $output .= 'Xin chào, ' . esc_html($current_user->display_name);
                        $output .= '</a>';
                        $output .= '<ul class="dropdown-menu" aria-labelledby="userAccountDropdown">';

                        // Chỉ hiển thị link nếu trang tồn tại
                        if ($account_url) {
                            $output .= '<li><a class="dropdown-item" href="' . esc_url($account_url) . '">Tài khoản của tôi</a></li>';
                        }
                        if ($order_history_url) {
                            $output .= '<li><a class="dropdown-item" href="' . esc_url($order_history_url) . '">Đơn hàng của tôi</a></li>';
                        }

                        $output .= '<li><hr class="dropdown-divider"></li>';
                        $output .= '<li><a class="dropdown-item" href="' . esc_url($logout_url) . '">Đăng xuất</a></li>';
                        $output .= '</ul>';
                        $output .= '</div>';
                    } else {
                        // View dành cho khách hoặc người dùng không phải 'customer' (Admin,...)
                        $login_url = get_permalink(get_page_by_path('dang-nhap')); // <-- Thay slug nếu cần
                        if ($login_url) {
                            $output .= '<a href="' . esc_url($login_url) . '" class="text-sm text-blue-600 hover:underline">Đăng nhập</a>';
                        }
                    }

                    $output .= '</div>';
                    break;

                default:
                    $output .= '<div class="header-item">' . esc_html($item) . '</div>';
            }
            return $output;
        }
        ?>


        <!-- Script hover submenu trên điện thoại -->
        <script>
            document.querySelectorAll('.menu .group > a').forEach(link => {
                link.addEventListener('click', function(e) {
                    const submenu = this.nextElementSibling;
                    if (submenu && submenu.tagName === 'UL') {
                        e.preventDefault();
                        submenu.classList.toggle('hidden');
                    }
                });
            });
        </script>