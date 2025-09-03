<?php
// File: class-topbar-builder-control.php

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
            // CẬP NHẬT: Giải mã cấu trúc dữ liệu mới cho cả desktop và mobile
            $value = json_decode($this->value(), true);
            if (!is_array($value) || !isset($value['desktop']) || !isset($value['mobile'])) {
                $value = [
                    'desktop' => ['left' => [], 'center' => [], 'right' => []],
                    'mobile'  => ['left' => [], 'center' => [], 'right' => []],
                ];
            }

            // CẬP NHẬT: Tập hợp các mục đang sử dụng từ cả hai giao diện
            $active_desktop = array_merge($value['desktop']['left'], $value['desktop']['center'], $value['desktop']['right']);
            $active_mobile  = array_merge($value['mobile']['left'], $value['mobile']['center'], $value['mobile']['right']);
            $active_items = array_unique(array_merge($active_desktop, $active_mobile));
            
            $all_items = ['html1', 'html2', 'html3', 'html4', 'html5', 'menu', 'search', 'signup', 'social', 'contact', 'language_switcher', 'cart', 'login'];
            $inactive_items = array_diff($all_items, $active_items);

            ?>
            <div class="space-y-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2"><?php echo esc_html($this->label); ?></label>

                <div class="ht-topbar-device-section">
                    <h4 class="ht-topbar-device-title">Desktop Layout</h4>
                    <div class="ht-topbar-active-areas ht-topbar-desktop-areas">
                        <div class="ht-topbar-area">
                            <p class="ht-topbar-area-title">Trái</p>
                            <ul id="ht-topbar-desktop-left" class="ht-topbar-sortable">
                                <?php foreach ($value['desktop']['left'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                        <div class="ht-topbar-area">
                            <p class="ht-topbar-area-title">Giữa</p>
                            <ul id="ht-topbar-desktop-center" class="ht-topbar-sortable">
                                <?php foreach ($value['desktop']['center'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                        <div class="ht-topbar-area">
                            <p class="ht-topbar-area-title">Phải</p>
                            <ul id="ht-topbar-desktop-right" class="ht-topbar-sortable">
                                <?php foreach ($value['desktop']['right'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="ht-topbar-device-section">
                    <h4 class="ht-topbar-device-title">Mobile / Tablet Layout</h4>
                    <div class="ht-topbar-active-areas ht-topbar-mobile-areas">
                        <div class="ht-topbar-area">
                            <p class="ht-topbar-area-title">Trái</p>
                            <ul id="ht-topbar-mobile-left" class="ht-topbar-sortable">
                                <?php foreach ($value['mobile']['left'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                        <div class="ht-topbar-area">
                            <p class="ht-topbar-area-title">Giữa</p>
                            <ul id="ht-topbar-mobile-center" class="ht-topbar-sortable">
                                <?php foreach ($value['mobile']['center'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                        <div class="ht-topbar-area">
                            <p class="ht-topbar-area-title">Phải</p>
                            <ul id="ht-topbar-mobile-right" class="ht-topbar-sortable">
                                <?php foreach ($value['mobile']['right'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="ht-topbar-device-section">
                    <h4 class="ht-topbar-device-title">Thành phần còn lại</h4>
                    <ul id="ht-topbar-available" class="ht-topbar-sortable ht-topbar-available-list">
                        <?php foreach ($inactive_items as $item) { echo $this->render_sortable_item($item); } ?>
                    </ul>
                </div>
                
                <input type="hidden" id="<?php echo esc_attr($this->id); ?>" name="<?php echo esc_attr($this->id); ?>" value="<?php echo esc_attr(json_encode($value)); ?>" <?php $this->link(); ?> />
            </div>
            <?php
        }

        private function render_sortable_item($item) {
            $label = ucfirst(str_replace('_', ' ', $item));
            $icon = match ($item) {
                'logo' => '🖼️', 'menu' => '📋', 'search' => '🔍', 'social' => '🌐', 'contact' => '☎️',
                'language_switcher' => '🌍', 'cart' => '🛒', 'signup' => '🔘', 'login' => '👤',
                default => '🔧'
            };
            return '<li class="ht-topbar-sortable-item" data-item="' . esc_attr($item) . '">
                <span class="ht-topbar-item-icon">' . $icon . '</span>
                <span class="ht-topbar-item-label">' . esc_html($label) . '</span>
            </li>';
        }
    }
}