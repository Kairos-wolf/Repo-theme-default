<?php
// File: class-headerbottom-builder-control.php (Đã cập nhật)

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
            // Giải mã cấu trúc dữ liệu mới cho cả desktop và mobile
            $value = json_decode($this->value(), true);
            if (!is_array($value) || !isset($value['desktop']) || !isset($value['mobile'])) {
                $value = [
                    'desktop' => ['left' => [], 'center' => ['menu'], 'right' => []],
                    'mobile'  => ['left' => [], 'center' => [], 'right' => []],
                ];
            }

            $active_desktop = array_merge($value['desktop']['left'], $value['desktop']['center'], $value['desktop']['right']);
            $active_mobile  = array_merge($value['mobile']['left'], $value['mobile']['center'], $value['mobile']['right']);
            $active_items = array_unique(array_merge($active_desktop, $active_mobile));
            
            $all_items = ['html1', 'html2', 'html3', 'html4', 'html5', 'menu', 'cart', 'login'];
            $inactive_items = array_diff($all_items, $active_items);

            ?>
            <div class="space-y-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2"><?php echo esc_html($this->label); ?></label>

                <div class="ht-headerbottom-device-section">
                    <h4 class="ht-headerbottom-device-title">Desktop Layout</h4>
                    <div class="ht-headerbottom-active-areas ht-headerbottom-desktop-areas">
                        <div class="ht-headerbottom-area">
                            <p class="ht-headerbottom-area-title">Trái</p>
                            <ul id="ht-headerbottom-desktop-left" class="ht-headerbottom-sortable">
                                <?php foreach ($value['desktop']['left'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                        <div class="ht-headerbottom-area">
                            <p class="ht-headerbottom-area-title">Giữa</p>
                            <ul id="ht-headerbottom-desktop-center" class="ht-headerbottom-sortable">
                                <?php foreach ($value['desktop']['center'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                        <div class="ht-headerbottom-area">
                            <p class="ht-headerbottom-area-title">Phải</p>
                            <ul id="ht-headerbottom-desktop-right" class="ht-headerbottom-sortable">
                                <?php foreach ($value['desktop']['right'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="ht-headerbottom-device-section">
                    <h4 class="ht-headerbottom-device-title">Mobile / Tablet Layout</h4>
                    <div class="ht-headerbottom-active-areas ht-headerbottom-mobile-areas">
                        <div class="ht-headerbottom-area">
                            <p class="ht-headerbottom-area-title">Trái</p>
                            <ul id="ht-headerbottom-mobile-left" class="ht-headerbottom-sortable">
                                <?php foreach ($value['mobile']['left'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                        <div class="ht-headerbottom-area">
                            <p class="ht-headerbottom-area-title">Giữa</p>
                            <ul id="ht-headerbottom-mobile-center" class="ht-headerbottom-sortable">
                                <?php foreach ($value['mobile']['center'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                        <div class="ht-headerbottom-area">
                            <p class="ht-headerbottom-area-title">Phải</p>
                            <ul id="ht-headerbottom-mobile-right" class="ht-headerbottom-sortable">
                                <?php foreach ($value['mobile']['right'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="ht-headerbottom-device-section">
                    <h4 class="ht-headerbottom-device-title">Thành phần còn lại</h4>
                    <ul id="ht-headerbottom-available" class="ht-headerbottom-sortable ht-headerbottom-available-list">
                        <?php foreach ($inactive_items as $item) { echo $this->render_sortable_item($item); } ?>
                    </ul>
                </div>
                
                <input type="hidden" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr(json_encode($value)); ?>" <?php $this->link(); ?> />
            </div>
            <?php
        }

        private function render_sortable_item($item) {
            $label = ucfirst($item);
            $icon = match($item) {
                'menu' => '📋',
                'cart' => '🛒',
                'login' => '👤',
                default => '🔧'
            };
            return '<li class="ht-headerbottom-sortable-item" data-item="' . esc_attr($item) . '">
                <span class="ht-headerbottom-item-icon">' . $icon . '</span>
                <span class="ht-headerbottom-item-label">' . esc_html($label) . '</span>
            </li>';
        }
    }
}