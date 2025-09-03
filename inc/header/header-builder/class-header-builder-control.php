<?php
// File: class-header-builder-control.php (Đã sửa lỗi)

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
            // CẬP NHẬT: Cấu trúc dữ liệu mới và giá trị mặc định theo yêu cầu
            $value = json_decode($this->value(), true);
            if (!is_array($value) || !isset($value['desktop']) || !isset($value['mobile'])) {
                $value = [
                    // Mặc định desktop: logo bên trái, menu và search bên phải
                    'desktop' => ['left' => ['logo'], 'right' => ['menu', 'search']],
                    // Mặc định mobile: logo bên trái, không có gì ở giữa và phải
                    'mobile'  => ['left' => ['logo'], 'center' => [], 'right' => []],
                ];
            }

            // Cập nhật logic lấy item đang hoạt động từ cả 2 layout
            $active_desktop = array_merge($value['desktop']['left'], $value['desktop']['right']);
            $active_mobile  = array_merge($value['mobile']['left'], $value['mobile']['center'], $value['mobile']['right']);
            $active_items = array_unique(array_merge($active_desktop, $active_mobile));
            
            // Tất cả các item có thể có
            $all_items = ['logo', 'menu', 'search', 'signup', 'social', 'contact', 'custom_html', 'cart', 'login'];

            // CẬP NHẬT QUAN TRỌNG:
            // Loại bỏ các khối đang hoạt động khỏi danh sách, NGOẠI TRỪ 'logo'.
            // Điều này đảm bảo 'logo' luôn có sẵn để kéo.
            $active_items_without_logo = array_diff($active_items, ['logo']);
            $inactive_items = array_diff($all_items, $active_items_without_logo);
            ?>
            <div class="space-y-4">
                <label class="block text-sm font-semibold text-gray-700 mb-2"><?php echo esc_html($this->label); ?></label>

                <div class="ht-header-device-section">
                    <h4 class="ht-header-device-title">Desktop Layout</h4>
                    <div class="ht-header-active-areas ht-header-desktop-areas">
                        <div class="ht-header-area">
                            <p class="ht-header-area-title">Trái</p>
                            <ul id="ht-header-desktop-left" class="ht-sortable ht-header-active-list">
                                <?php foreach ($value['desktop']['left'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                        <div class="ht-header-area">
                            <p class="ht-header-area-title">Phải</p>
                            <ul id="ht-header-desktop-right" class="ht-sortable ht-header-active-list">
                                <?php foreach ($value['desktop']['right'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="ht-header-device-section">
                    <h4 class="ht-header-device-title">Mobile / Tablet Layout</h4>
                    <div class="ht-header-active-areas ht-header-mobile-areas">
                        <div class="ht-header-area">
                            <p class="ht-header-area-title">Trái</p>
                            <ul id="ht-header-mobile-left" class="ht-sortable ht-header-active-list">
                                <?php foreach ($value['mobile']['left'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                        <div class="ht-header-area">
                            <p class="ht-header-area-title">Giữa</p>
                            <ul id="ht-header-mobile-center" class="ht-sortable ht-header-active-list">
                                <?php foreach ($value['mobile']['center'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                        <div class="ht-header-area">
                            <p class="ht-header-area-title">Phải (Luôn có nút Menu)</p>
                            <ul id="ht-header-mobile-right" class="ht-sortable ht-header-active-list">
                                <?php foreach ($value['mobile']['right'] as $item) { echo $this->render_sortable_item($item); } ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="ht-header-device-section">
                    <h4 class="ht-header-device-title">Thành phần còn lại</h4>
                    <ul id="ht-header-available" class="ht-sortable ht-header-available-list">
                        <?php foreach ($inactive_items as $item) { echo $this->render_sortable_item($item); } ?>
                    </ul>
                </div>
                
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
                'cart' => '🛒',
                'signup' => '🔘',
                'login' => '👤',
                default => '📦'
            };
            return '<li class="ht-sortable-item" data-item="' . esc_attr($item) . '">
                <span class="ht-item-icon">' . $icon . '</span>
                <span class="ht-item-label">' . esc_html(ucfirst($item)) . '</span>
            </li>';
        }
    }
}