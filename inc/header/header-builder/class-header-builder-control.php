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
            // Giải mã JSON, nếu không hợp lệ thì tạo cấu trúc 2 cột mặc định
            $value = json_decode($this->value(), true);
            if (!is_array($value) || !isset($value['left']) || !isset($value['right'])) {
                $value = ['left' => ['logo'], 'right' => ['menu', 'search']];
            }

            // Tất cả các item đang hoạt động
            $active_items = array_merge($value['left'], $value['right']);
            
            // Tất cả các item có thể có
            $all_items = ['logo', 'menu', 'search', 'signup', 'social', 'contact', 'custom_html', /*'language_switcher',*/ 'cart', 'login'];

            // Các item chưa được sử dụng
            $inactive_items = array_diff($all_items, $active_items);

            ?>
            <div class="space-y-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2"><?php echo esc_html($this->label); ?></label>

                <div class="ht-header-active-areas">
                    <div class="ht-header-area">
                        <p class="ht-header-area-title">Trái</p>
                        <ul id="ht-header-left" class="ht-sortable">
                            <?php foreach ($value['left'] as $item) { echo $this->render_sortable_item($item); } ?>
                        </ul>
                    </div>
                    <div class="ht-header-area">
                        <p class="ht-header-area-title">Phải</p>
                        <ul id="ht-header-right" class="ht-sortable">
                            <?php foreach ($value['right'] as $item) { echo $this->render_sortable_item($item); } ?>
                        </ul>
                    </div>
                </div>


                <p class="text-sm font-medium mt-4 mb-1">Thành phần còn lại</p>
                <ul id="ht-header-available" class="ht-sortable flex flex-row flex-wrap gap-3 p-2 border border-dashed border-gray-300 rounded-md bg-gray-50 min-h-[50px]">
                    <?php foreach ($inactive_items as $item) {
                        echo $this->render_sortable_item($item);
                    } ?>
                </ul>

                <input type="hidden" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr(json_encode($value)); ?>" <?php $this->link(); ?> />
            </div>
            <?php
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
                //'language_switcher' => '🌍',
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