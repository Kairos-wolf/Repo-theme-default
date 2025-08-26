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
            // Giải mã JSON, nếu không hợp lệ thì tạo cấu trúc 3 cột mặc định
            $value = json_decode($this->value(), true);
            if (!is_array($value) || !isset($value['left']) || !isset($value['center']) || !isset($value['right'])) {
                $value = ['left' => [], 'center' => ['menu'], 'right' => []];
            }

            // Tập hợp tất cả các mục đang được sử dụng
            $active_items = array_merge($value['left'], $value['center'], $value['right']);

            // Danh sách tất cả các mục có sẵn
            $all_items = ['html1', 'html2', 'html3', 'html4', 'html5', 'menu', 'cart', 'login'];

            // Các mục chưa được chọn
            $inactive_items = array_diff($all_items, $active_items);

            ?>
            <div class="space-y-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2"><?php echo esc_html($this->label); ?></label>

                <div class="ht-headerbottom-active-areas">
                    <div class="ht-headerbottom-area">
                        <p class="ht-headerbottom-area-title">Trái</p>
                        <ul id="ht-headerbottom-left" class="ht-headerbottom-sortable">
                            <?php foreach ($value['left'] as $item) { echo $this->render_sortable_item($item); } ?>
                        </ul>
                    </div>
                    <div class="ht-headerbottom-area">
                        <p class="ht-headerbottom-area-title">Giữa</p>
                        <ul id="ht-headerbottom-center" class="ht-headerbottom-sortable">
                             <?php foreach ($value['center'] as $item) { echo $this->render_sortable_item($item); } ?>
                        </ul>
                    </div>
                    <div class="ht-headerbottom-area">
                        <p class="ht-headerbottom-area-title">Phải</p>
                        <ul id="ht-headerbottom-right" class="ht-headerbottom-sortable">
                             <?php foreach ($value['right'] as $item) { echo $this->render_sortable_item($item); } ?>
                        </ul>
                    </div>
                </div>

                <p class="text-sm font-medium mt-4 mb-1">Thành phần còn lại</p>
                <ul id="ht-headerbottom-available" class="ht-headerbottom-sortable flex flex-row flex-wrap gap-3 p-2 border border-dashed border-gray-300 rounded-md bg-gray-50 min-h-[50px]">
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
            $label = ucfirst($item);
            $icon = match($item) {
                'menu' => '📋',
                'cart' => '🛒',
                'login' => '👤',
                default => '🔧' // icon mặc định cho html1, html2...
            };

            return '<li class="ht-headerbottom-sortable-item flex flex-col items-center justify-center px-4 py-2 bg-white border border-gray-300 rounded-md min-w-[80px] text-center cursor-move hover:bg-gray-100 transition" data-item="' . esc_attr($item) . '">
                <span class="text-2xl mb-1">' . $icon . '</span>
                <span class="text-sm font-semibold text-gray-700">' . esc_html($label) . '</span>
            </li>';
        }
    }
}