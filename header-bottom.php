<nav class="ht-headerbottom-builder">
    <div class="headerbottom row align-items-center">
        <?php
        $layout = get_theme_mod('ht_headerbottom_layout', json_encode(['']));
        $items = json_decode($layout, true);

        if (is_array($items)) {
            foreach ($items as $index => $item_id) {
                // Nếu là mục 'menu' thì hiển thị menu
                if ($item_id === 'menu') {
                    // Đảm bảo vị trí menu 'headerbottom_menu' đã được đăng ký
                    // if (has_nav_menu('headerbottom_menu')) {
                    //     echo '<div class="headerbottom-item col menu-item text-sm">';
                    //     wp_nav_menu([
                    //         'theme_location' => 'headerbottom_menu',
                    //         'container'      => false,
                    //         'menu_class'     => 'ht-headerbottom-menu d-inline-flex flex-row text-decoration-none list-unstyled gap-4', // Thêm class CSS cho menu
                    //         'depth'          => 1, // Chỉ hiển thị menu cấp 1
                    //     ]);
                    //     echo '</div>';
                    // }
                    if (has_nav_menu('headerbottom_menu')) {
                        // Nếu có menu, hiển thị menu
                        echo '<div class="headerbottom-item col menu-item text-sm d-flex align-items-center">';
                        wp_nav_menu([
                            'theme_location' => 'headerbottom_menu',
                            'container'      => false,
                            'menu_class'     => 'ht-headerbottom-menu d-inline-flex flex-row text-decoration-none list-unstyled gap-4 my-auto', // Thêm class CSS cho menu
                            'depth'          => 1, // Chỉ hiển thị menu cấp 1
                        ]);
                        echo '</div>';
                    } else {
                        // Nếu chưa có menu, luôn hiển thị thông báo
                        echo '<div class="headerbottom-item col menu-item text-sm">';
                        echo '<ul class="ht-headerbottom-menu d-inline-flex flex-row text-decoration-none list-unstyled gap-4 my-auto"><li>';

                        echo '<span>Chưa thêm menu</span>';

                        echo '</li></ul>';
                        echo '</div>';
                    }
                } else {
                    // Logic cũ cho các mục html
                    $html_content = get_theme_mod("ht_headerbottom_{$item_id}");

                    // Nếu không có nội dung thì bỏ qua
                    if (empty($html_content)) continue;

                    // Nếu là mục đầu tiên thì luôn hiển thị, từ mục 2 trở đi ẩn ở mobile
                    $classes = ($index === 0) ? '' : 'hidden sm:flex';

                    echo '<div class="headerbottom-item col ' . esc_attr($item_id) . ' text-sm ' . esc_attr($classes) . '">';
                    echo wp_kses_post($html_content);
                    echo '</div>';
                }
            }
        }
        ?>
    </div>
</nav>

<style>
    /* .headerbottom {
        display: flex;
    } */
    .ht-headerbottom-menu li a {
        text-decoration: none;
    }
</style>