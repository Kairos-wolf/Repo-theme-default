<?php
if (class_exists('WP_Customize_Control')) {
    class HT_Headerbottom_Builder_Control extends WP_Customize_Control
    {
        public $type = 'ht_headerbottom_builder';

        public function enqueue()
        {
            wp_enqueue_script('ht-headerbottom-builder', get_template_directory_uri() . "/inc/header/header-builder/headerbottom-builder.js", ['jquery', 'jquery-ui-sortable'], null, true);
            wp_enqueue_style('ht-headerbottom-builder-style', get_template_directory_uri() . "/inc/header/header-builder/headerbottom-builder.css");
        }

        public function render_content()
        {
            $value = json_decode($this->value(), true);
            if (!is_array($value)) {
                $value = [];
            }

            // Danh sách tất cả các mục, bao gồm cả 'menu'
            $all_items = ['html1', 'html2', 'html3', 'html4', 'html5', 'html6', 'html7', 'html8', 'menu'];

            // Các mục chưa được chọn
            $inactive_items = array_diff($all_items, $value);

            echo '<div class="space-y-4">';
            echo '<label class="block text-sm font-semibold text-gray-700 mb-2">' . esc_html($this->label) . '</label>';
            echo '<p class="text-sm font-medium mb-1">Thành phần đã dùng</p>';
            echo '<ul id="ht-headerbottom-sortable" class="ht-headerbottom-sortable flex flex-row flex-wrap gap-3 p-2 border border-gray-300 rounded-md bg-white min-h-[50px]">';
            foreach ($value as $item) {
                echo $this->render_sortable_item($item);
            }
            echo '</ul>';
            echo '<p class="text-sm font-medium mt-4 mb-1">Thành phần còn lại</p>';
            echo '<ul id="ht-headerbottom-available" class="ht-headerbottom-sortable flex flex-row flex-wrap gap-3 p-2 border border-dashed border-gray-300 rounded-md bg-gray-50 min-h-[50px]">';
            foreach ($inactive_items as $item) {
                echo $this->render_sortable_item($item);
            }
            echo '</ul>';
            echo '<input type="hidden" id="' . esc_attr($this->id) . '" name="' . esc_attr($this->id) . '" value="' . esc_attr(json_encode(array_values($value))) . '" ' . $this->get_link() . ' />';
            echo '</div>';
        }

        private function render_sortable_item($item)
        {
            $icon = '🔧'; // icon mặc định
            $label = ucfirst($item);

            // Gán biểu tượng và nhãn riêng cho từng mục nếu cần
            switch ($item) {
                case 'menu':
                    $icon = '☰'; // Icon cho menu
                    $label = 'Menu';
                    break;
                    // Bạn có thể thêm các case khác ở đây cho các mục đặc biệt
            }

            return '<li class="ht-headerbottom-sortable-item flex flex-col items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md min-w-[80px] text-center cursor-move hover:bg-gray-100 transition" data-item="' . esc_attr($item) . '">
                <span class="text-2xl mb-1">' . $icon . '</span>
                <span class="text-sm font-semibold text-gray-700">' . esc_html($label) . '</span>
            </li>';
        }
    }
}
