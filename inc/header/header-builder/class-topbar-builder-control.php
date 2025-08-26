<?php
if (class_exists('WP_Customize_Control')) {
    class HT_Topbar_Builder_Control extends WP_Customize_Control
    {
        public $type = 'ht_topbar_builder';

        public function enqueue()
        {
            wp_enqueue_script('ht-topbar-builder', get_template_directory_uri() . "/inc/header/header-builder/topbar-builder.js", ['jquery', 'jquery-ui-sortable'], null, true);
            wp_enqueue_style('ht-topbar-builder-style', get_template_directory_uri() . "/inc/header/header-builder/topbar-builder.css");
        }

        public function render_content()
        {
            // Giải mã giá trị JSON, nếu không hợp lệ thì tạo cấu trúc mặc định
            $value = json_decode($this->value(), true);
            if (!is_array($value) || !isset($value['left']) || !isset($value['center']) || !isset($value['right'])) {
                $value = ['left' => [], 'center' => [], 'right' => []];
            }

            // Tập hợp tất cả các mục đang được sử dụng
            $active_items = array_merge($value['left'], $value['center'], $value['right']);
            
            // Danh sách tất cả các mục có sẵn
            $all_items = ['html1', 'html2', 'html3', 'html4', 'html5', 'menu', 'search', 'signup', 'social', 'contact', 'language_switcher', 'cart', 'login'];

            // Các mục chưa được chọn
            $inactive_items = array_diff($all_items, $active_items);

            ?>
            <div class="space-y-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2"><?php echo esc_html($this->label); ?></label>

                <div class="ht-topbar-active-areas" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px;">
                    <div class="ht-topbar-area">
                        <p class="text-sm font-medium mb-1">Trái</p>
                        <ul id="ht-topbar-left" class="ht-topbar-sortable flex flex-col gap-2 p-2 border border-gray-300 rounded-md bg-white min-h-[80px]">
                            <?php foreach ($value['left'] as $item) { echo $this->render_sortable_item($item); } ?>
                        </ul>
                    </div>
                    <div class="ht-topbar-area">
                        <p class="text-sm font-medium mb-1">Giữa</p>
                        <ul id="ht-topbar-center" class="ht-topbar-sortable flex flex-col gap-2 p-2 border border-gray-300 rounded-md bg-white min-h-[80px]">
                            <?php foreach ($value['center'] as $item) { echo $this->render_sortable_item($item); } ?>
                        </ul>
                    </div>
                    <div class="ht-topbar-area">
                        <p class="text-sm font-medium mb-1">Phải</p>
                        <ul id="ht-topbar-right" class="ht-topbar-sortable flex flex-col gap-2 p-2 border border-gray-300 rounded-md bg-white min-h-[80px]">
                            <?php foreach ($value['right'] as $item) { echo $this->render_sortable_item($item); } ?>
                        </ul>
                    </div>
                </div>

                <p class="text-sm font-medium mt-4 mb-1">Thành phần còn lại</p>
                <ul id="ht-topbar-available" class="ht-topbar-sortable flex flex-row flex-wrap gap-3 p-2 border border-dashed border-gray-300 rounded-md bg-gray-50 min-h-[50px]">
                    <?php foreach ($inactive_items as $item) { echo $this->render_sortable_item($item); } ?>
                </ul>

                <input type="hidden" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr(json_encode($value)); ?>" <?php $this->link(); ?> />
            </div>
            <?php
        }

        private function render_sortable_item($item)
        {
            $label = ucfirst($item);
            $icon = match ($item) {
                'logo' => '🖼️', 'menu' => '📋', 'search' => '🔍', 'social' => '🌐', 'contact' => '☎️',
                'language_switcher' => '🌍', 'cart' => '🛒', 'signup' => '🔘', 'login' => '👤',
                default => '🔧'
            };
            return '<li class="ht-topbar-sortable-item flex flex-col items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md min-w-[80px] text-center cursor-move hover:bg-gray-100 transition" data-item="' . esc_attr($item) . '">
                <span class="text-2xl mb-1">' . $icon . '</span>
                <span class="text-sm font-semibold text-gray-700">' . esc_html($label) . '</span>
            </li>';
        }
    }
}