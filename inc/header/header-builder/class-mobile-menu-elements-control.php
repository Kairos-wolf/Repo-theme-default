<?php
// File: /inc/header/header-builder/class-mobile-menu-elements-control.php

if (class_exists('WP_Customize_Control')) {
    class HT_Mobile_Menu_Elements_Control extends WP_Customize_Control {
        public $type = 'ht_mobile_menu_elements';

        /**
         * Định nghĩa tất cả các thành phần header có thể có ở đây.
         * Đây là "nguồn sự thật duy nhất" cho control này.
         */
        private function get_all_elements() {
            return [
                // DANH SÁCH ĐÃ ĐƯỢC CẬP NHẬT
                'menu'              => 'Main Menu',
                'search'            => 'Search Form',
                'social'            => 'Social',
                'contact'           => 'Contact',
                'cart'              => 'Cart',
                'login'             => 'Account / Login',
               
            ];
        }

        public function enqueue() {
            $uri = get_template_directory_uri();
            wp_enqueue_script('ht-mobile-menu-elements-js', $uri . '/inc/header/header-builder/mobile-menu-elements.js', ['jquery', 'jquery-ui-sortable'], false, true);
            wp_enqueue_style('ht-mobile-menu-elements-css', $uri . '/inc/header/header-builder/mobile-menu-elements.css');
            wp_enqueue_style('dashicons');
        }

        public function render_content() {
            $saved_elements = json_decode($this->value(), true);
            if (!is_array($saved_elements)) { $saved_elements = []; }

            // Lấy danh sách tất cả các thành phần từ hàm đã định nghĩa
            $all_elements = $this->get_all_elements();

            // Sắp xếp lại danh sách hiển thị: các item đã lưu giữ nguyên thứ tự,
            // các item mới sẽ được thêm vào cuối.
            $display_list = [];
            $saved_ids = [];

            foreach ($saved_elements as $element) {
                if (isset($all_elements[$element['id']])) {
                    $display_list[] = $element;
                    $saved_ids[] = $element['id'];
                }
            }
            foreach ($all_elements as $id => $label) {
                if (!in_array($id, $saved_ids)) {
                    $display_list[] = ['id' => $id, 'visible' => false]; // Mặc định ẩn các item mới
                }
            }
            ?>
            <div class="ht-mobile-elements-control">
                <label>
                    <span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
                </label>
                <ul class="ht-mobile-elements-list">
                    <?php foreach ($display_list as $element) : ?>
                        <?php
                        // Đảm bảo element có key 'id' và 'visible'
                        $id = isset($element['id']) ? $element['id'] : '';
                        $visible = isset($element['visible']) ? $element['visible'] : false;
                        $label = isset($all_elements[$id]) ? $all_elements[$id] : ucfirst($id);
                        ?>
                        <li class="ht-mobile-element-item" data-id="<?php echo esc_attr($id); ?>" data-visible="<?php echo $visible ? 'true' : 'false'; ?>">
                            <span class="dashicons dashicons-menu drag-handle"></span>
                            <span class="element-label"><?php echo esc_html($label); ?></span>
                            <button type="button" class="toggle-visibility">
                                <span class="dashicons <?php echo $visible ? 'dashicons-visibility' : 'dashicons-hidden'; ?>"></span>
                            </button>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <input type="hidden" class="ht-mobile-elements-input" <?php $this->link(); ?> value="<?php echo esc_attr($this->value()); ?>" />
            </div>
            <?php
        }
    }
}