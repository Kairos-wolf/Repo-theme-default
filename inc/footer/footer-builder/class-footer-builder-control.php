<?php
if (class_exists('WP_Customize_Control')) {
    class HT_Footer_Builder_Control extends WP_Customize_Control
    {
        public $type = 'ht_footer_builder';

        public function enqueue()
        {
            wp_enqueue_script('ht-footer-builder', get_template_directory_uri() . "/inc/footer/footer-builder/footer-builder.js", ['jquery', 'jquery-ui-sortable'], null, true);
            wp_enqueue_style('ht-footer-builder-style', get_template_directory_uri() . "/inc/footer/footer-builder/footer-builder.css");
        }

        public function render_content()
        {
            $value = json_decode($this->value(), true);
            if (!is_array($value)) {
                $value = ['logo', 'html1', 'menu']; // Default value
            }

            // Define all available items
            $all_items = ['logo', 'menu', 'html1', 'html2', 'html3', 'html4'];

            // Find items not yet used
            $inactive_items = array_diff($all_items, $value);

            echo '<div class="space-y-4">';
            echo '<label class="block text-sm font-semibold text-gray-700 mb-2">' . esc_html($this->label) . '</label>';
            echo '<p class="text-sm font-medium mb-1">Active Items</p>';
            echo '<ul id="ht-footer-sortable" class="ht-footer-sortable flex flex-row flex-wrap gap-3 p-2 border border-gray-300 rounded-md bg-white min-h-[50px]">';
            foreach ($value as $item) {
                echo $this->render_sortable_item($item);
            }
            echo '</ul>';
            echo '<p class="text-sm font-medium mt-4 mb-1">Available Items</p>';
            echo '<ul id="ht-footer-available" class="ht-footer-sortable flex flex-row flex-wrap gap-3 p-2 border border-dashed border-gray-300 rounded-md bg-gray-50 min-h-[50px]">';
            foreach ($inactive_items as $item) {
                echo $this->render_sortable_item($item);
            }
            echo '</ul>';
            echo '<input type="hidden" id="' . esc_attr($this->id) . '" name="' . esc_attr($this->id) . '" value="' . esc_attr(json_encode($value)) . '" ' . $this->get_link() . ' />';
            echo '</div>';
        }

        private function render_sortable_item($item)
        {
            $details = [
                'logo' => ['icon' => '🖼️', 'label' => 'Logo'],
                'menu' => ['icon' => '☰', 'label' => 'Menu'],
                'html1' => ['icon' => '🔧', 'label' => 'HTML 1'],
                'html2' => ['icon' => '🔧', 'label' => 'HTML 2'],
                'html3' => ['icon' => '🔧', 'label' => 'HTML 3'],
                'html4' => ['icon' => '🔧', 'label' => 'HTML 4'],
            ];

            $item_details = isset($details[$item]) ? $details[$item] : ['icon' => '❓', 'label' => 'Unknown'];
            $icon = $item_details['icon'];
            $label = $item_details['label'];

            return '<li class="ht-footer-sortable-item flex flex-col items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md min-w-[80px] text-center cursor-move hover:bg-gray-100 transition" data-item="' . esc_attr($item) . '">
                <span class="text-2xl mb-1">' . $icon . '</span>
                <span class="text-sm font-semibold text-gray-700">' . esc_html($label) . '</span>
            </li>';
        }
    }
}
