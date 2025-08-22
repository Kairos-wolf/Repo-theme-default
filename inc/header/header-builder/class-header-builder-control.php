<?php
if (class_exists('WP_Customize_Control')) {
    class HT_Header_Builder_Control extends WP_Customize_Control
    {
        public $type = 'ht_header_builder';

        public function enqueue()
        {
            wp_enqueue_script('ht-header-builder', get_template_directory_uri() . '/inc/header/header-builder/header-builder.js', ['jquery', 'jquery-ui-sortable'], null, true);
            wp_enqueue_style('ht-header-builder-style', get_template_directory_uri() . '/inc/header/header-builder/header-builder.css');
        }

        public function render_content()
        {
            $value = json_decode($this->value(), true);
            if (!is_array($value)) {
                $value = [''];
            }
            
            // =================================================================
            // THAY ĐỔI #1: LẤY DANH SÁCH MENU ĐỘNG
            // =================================================================
            $registered_menus = get_registered_nav_menus();
            $dynamic_menu_items = [];
            foreach ($registered_menus as $location => $description) {
                // Tạo key động, ví dụ: 'menu_primary', 'menu_topbar'
                $dynamic_menu_items[] = 'menu_' . $location;
            }

            // Các item tĩnh khác
            $static_items = ['logo', 'search', 'signup', 'social', 'contact', 'custom_html', 'language_switcher', 'cart', 'login'];
            
            // Gộp item tĩnh và item menu động lại
            $all_items = array_merge($static_items, $dynamic_menu_items);
            
            $inactive_items = array_diff($all_items, $value);

            echo '<div class="space-y-4">';
            echo '<label class="block text-sm font-semibold text-gray-700 mb-2">' . esc_html($this->label) . '</label>';

            // Active items
            echo '<p class="text-sm font-medium mb-1">Active Items</p>';
            echo '<ul id="ht-header-sortable" class="ht-sortable flex flex-row space-x-3 p-2 border border-gray-300 rounded-md bg-white min-h-[50px]">';
            foreach ($value as $item) {
                if (empty($item)) continue; // Bỏ qua item rỗng
                echo $this->render_sortable_item($item);
            }
            echo '</ul>';

            // Available items
            echo '<p class="text-sm font-medium mt-4 mb-1">Available Items</p>';
            echo '<ul id="ht-header-available" class="ht-sortable flex flex-row space-x-3 p-2 border border-dashed border-gray-300 rounded-md bg-gray-50 min-h-[50px]">';
            foreach ($inactive_items as $item) {
                echo $this->render_sortable_item($item);
            }
            echo '</ul>';

            echo '<input type="hidden" id="' . esc_attr($this->id) . '" name="' . esc_attr($this->id) . '" value="' . esc_attr(json_encode(array_values($value))) . '" ' . $this->get_link() . ' />';
            echo '</div>';
        }

        private function render_sortable_item($item)
        {
            $icon = '📦';
            $display_name = ucfirst(str_replace('_', ' ', $item));

            // =================================================================
            // THAY ĐỔI #2: HIỂN THỊ TÊN VÀ ICON CHO TỪNG LOẠI ITEM
            // =================================================================
            
            // Kiểm tra xem có phải là menu không
            if (str_starts_with($item, 'menu_')) {
                $location = str_replace('menu_', '', $item);
                $registered_menus = get_registered_nav_menus();
                
                $icon = '📋';
                // Lấy tên menu đã đăng ký, ví dụ: 'Primary Menu'
                $display_name = $registered_menus[$location] ?? ucfirst($location);

            } else {
                // Xử lý các item tĩnh như cũ
                $icon = match ($item) {
                    'logo' => '🖼️',
                    'search' => '🔍',
                    'social' => '🌐',
                    'contact' => '☎️',
                    'custom_html' => '✍️',
                    'language_switcher' => '🌍',
                    'cart' => '🛒',
                    'signup' => '🔘',
                    'login' => '👤',
                    default => '📦'
                };

                $static_labels = [
                    'custom_html' => 'Custom HTML',
                    'language_switcher' => 'Language',
                ];
                $display_name = $static_labels[$item] ?? ucfirst($item);
            }

            return '<li class="ht-sortable-item flex flex-col items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md min-w-[80px] text-center cursor-move hover:bg-gray-100 transition" data-item="' . esc_attr($item) . '">
                <span class="text-2xl mb-1">' . $icon . '</span>
                <span class="text-sm font-medium text-gray-700">' . esc_html($display_name) . '</span>
            </li>';
        }
    }
}