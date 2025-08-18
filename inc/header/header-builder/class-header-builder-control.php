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
                // $value = ['logo', 'menu', 'search'];
            }

            $all_items = ['logo', 'menu', 'search', 'signup', 'social', 'contact', 'custom_html', 'language_switcher', 'cart', 'login'];
            $inactive_items = array_diff($all_items, $value);

            echo '<div class="space-y-4">';
            echo '<label class="block text-sm font-semibold text-gray-700 mb-2">' . esc_html($this->label) . '</label>';

            // Active items
            echo '<p class="text-sm font-medium mb-1">Active Items</p>';
            echo '<ul id="ht-header-sortable" class="ht-sortable flex flex-row space-x-3 p-2 border border-gray-300 rounded-md bg-white min-h-[50px]">';
            foreach ($value as $item) {
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

            echo '<input type="hidden" id="' . esc_attr($this->id) . '" name="' . esc_attr($this->id) . '" value="' . esc_attr(json_encode($value)) . '" ' . $this->get_link() . ' />';
            echo '</div>';
        }

        private function render_sortable_item($item)
        {
            $icon = match ($item) {
                'logo' => '🖼️',
                'menu' => '📋',
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
            return '<li class="ht-sortable-item flex flex-col items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md min-w-[80px] text-center cursor-move hover:bg-gray-100 transition" data-item="' . esc_attr($item) . '">
                <span class="text-2xl mb-1">' . $icon . '</span>
                <span class="text-sm font-medium text-gray-700">' . esc_html(ucfirst($item)) . '</span>
            </li>';
        }
    }
}
