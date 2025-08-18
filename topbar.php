<nav class="ht-topbar-builder">
    <div class="topbar row">
        <?php
        // Lấy layout từ Customizer (sắp xếp bởi người dùng)
        $layout = get_theme_mod('ht_topbar_layout', json_encode(['']));
        $items = json_decode($layout, true);

        if (is_array($items)) {
            foreach ($items as $index => $item_id) {
                // Nếu là mục 'menu' thì hiển thị menu
                if ($item_id === 'menu') {
                    // Đảm bảo vị trí menu 'topbar_menu' đã được đăng ký
                    // if (has_nav_menu('topbar_menu')) {
                    //     echo '<div class="topbar-item col menu-item text-sm">';
                    //     wp_nav_menu([
                    //         'theme_location' => 'topbar_menu',
                    //         'container'      => false,
                    //         'menu_class'     => 'ht-topbar-menu flex flex-row gap-4', // Thêm class CSS cho menu
                    //         'depth'          => 1, // Chỉ hiển thị menu cấp 1
                    //     ]);
                    //     echo '</div>';
                    // }
                    if (has_nav_menu('topbar_menu')) {
                        // Nếu có, hiển thị menu
                        echo '<div class="topbar-item col menu-item text-sm">';
                        wp_nav_menu([
                            'theme_location' => 'topbar_menu',
                            'container'      => false,
                            'menu_class'     => 'ht-topbar-menu flex flex-row gap-4',
                            'depth'          => 1,
                        ]);
                        echo '</div>';
                    } else {
                        // Nếu chưa có menu, luôn hiển thị thông báo
                        echo '<div class="topbar-item col menu-item text-sm">';
                        echo '<ul class="ht-topbar-menu flex flex-row gap-4"><li>';

                        echo '<span>Chưa thêm menu</span>';
                        echo '</li></ul>';
                        echo '</div>';
                    }
                } else {
                    // Logic cũ cho các mục html
                    $html_content = get_theme_mod("ht_topbar_{$item_id}");

                    // Nếu không có nội dung thì bỏ qua
                    if (empty($html_content)) continue;

                    // Nếu là mục đầu tiên thì luôn hiển thị, từ mục 2 trở đi ẩn ở mobile
                    $classes = ($index === 0) ? '' : 'hidden sm:flex';

                    echo '<div class="topbar-item col ' . esc_attr($item_id) . ' text-sm ' . esc_attr($classes) . '">';
                    echo wp_kses_post($html_content);
                    echo '</div>';
                }
            }
        }
        ?>
    </div>
</nav>