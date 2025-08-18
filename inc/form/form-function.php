<?php

/**
 * My Custom Form - Contact Form 7 Style
 *
 * This file contains all the backend logic for creating and handling forms.
 */

// =============================================================================
// 1. ĐĂNG KÝ CUSTOM POST TYPE (Không đổi)
// =============================================================================
function register_custom_form_post_type_v2()
{
    register_post_type('my_form_builder', [
        'labels' => [
            'name' => 'Forms',
            'singular_name' => 'Form',
            'add_new_item' => 'Tạo form mới',
            'edit_item' => 'Sửa form',
            'all_items' => 'Tất cả Forms',
        ],
        'public' => false,
        'publicly_queryable' => false,
        'show_ui' => true,
        'show_in_menu' => true,
        'has_archive' => false,
        'supports' => ['title'],
        'menu_icon' => 'dashicons-email-alt',
    ]);
}
add_action('init', 'register_custom_form_post_type_v2');


// =============================================================================
// 2. THÊM CÁC META BOX (Không đổi)
// =============================================================================
function add_all_form_meta_boxes()
{
    add_meta_box('form_layout_metabox', 'Cấu trúc Form', 'form_layout_metabox_callback', 'my_form_builder', 'normal', 'high');
    add_meta_box('form_mail_settings_metabox', 'Cấu hình Mail', 'form_mail_settings_metabox_callback', 'my_form_builder', 'normal', 'high');
    add_meta_box('form_messages_metabox', 'Thông báo', 'form_messages_metabox_callback', 'my_form_builder', 'normal', 'high');
    add_meta_box('form_shortcode_metabox', 'Shortcode của Form', 'form_shortcode_metabox_callback', 'my_form_builder', 'side', 'low');
}
add_action('add_meta_boxes', 'add_all_form_meta_boxes');


// =============================================================================
// 3. CALLBACK CHO CẤU TRÚC FORM META BOX (Cập nhật hướng dẫn)
// =============================================================================
function form_layout_metabox_callback($post)
{
    wp_nonce_field('save_form_layout_data', 'form_layout_nonce');
    $form_layout = get_post_meta($post->ID, '_form_layout', true);
?>
    <div id="form-fields-toolbar" style="margin-bottom: 15px;">
        <button type="button" class="button button-secondary insert-form-tag" data-tag-type="text">Text Field</button>
        <button type="button" class="button button-secondary insert-form-tag" data-tag-type="email">Email Field</button>
        <button type="button" class="button button-secondary insert-form-tag" data-tag-type="tel">Tel Field</button>
        <button type="button" class="button button-secondary insert-form-tag" data-tag-type="number">Number Field</button>
        <button type="button" class="button button-secondary insert-form-tag" data-tag-type="date">Date Field</button>
        <button type="button" class="button button-secondary insert-form-tag" data-tag-type="textarea">Textarea</button>
        <button type="button" class="button button-secondary insert-form-tag" data-tag-type="checkbox">Checkbox</button>
        <button type="button" class="button button-secondary insert-form-tag" data-tag-type="select">Dropdown (Select)</button>
        <button type="button" class="button button-secondary insert-form-tag" data-tag-type="submit">Submit Button</button>
    </div>
    <textarea name="form_layout" id="form_layout" rows="15" class="large-text code" placeholder="<label>Tên của bạn</label>&#10;[text* your-name class=&quot;form-control&quot;]"><?php echo esc_textarea($form_layout); ?></textarea>
    <p class="description">
        <strong>Đây là trình soạn thảo HTML!</strong> Bạn có thể viết HTML tự do để tạo layout.
        <br>Sử dụng các nút ở trên để chèn shortcode trường form vào vị trí bạn muốn.
        <br>Ví dụ: <code>&lt;div class="form-group"&gt;&lt;label&gt;Tên của bạn&lt;/label&gt;[text* your-name id="name-field" class="form-control"]&lt;/div&gt;</code>.
        <br>Bạn có thể thêm các thuộc tính như <code>id</code>, <code>class</code>, <code>placeholder</code> trực tiếp vào shortcode.
    </p>

    <div id="my-form-tag-modal" style="display:none;">
        <div id="modal-content">
        </div>
    </div>
<?php
}

// =============================================================================
// 4. CALLBACK CHO CẤU HÌNH MAIL META BOX (Không đổi)
// =============================================================================
function form_mail_settings_metabox_callback($post)
{
    wp_nonce_field('save_form_mail_data', 'form_mail_nonce');
    $mail_to = get_post_meta($post->ID, '_mail_to', true);
    $mail_subject = get_post_meta($post->ID, '_mail_subject', true);
    $mail_body = get_post_meta($post->ID, '_mail_body', true);
?>
    <p>
        <label for="mail_to"><strong>Gửi tới (Email người nhận):</strong></label><br>
        <input type="email" name="mail_to" id="mail_to" value="<?php echo esc_attr($mail_to); ?>" class="large-text" placeholder="your_email@example.com">
    <p class="description">Địa chỉ email sẽ nhận được tin nhắn từ form này. Có thể nhập nhiều email cách nhau bởi dấu phẩy.</p>
    </p>
    <p>
        <label for="mail_subject"><strong>Tiêu đề Mail:</strong></label><br>
        <input type="text" name="mail_subject" id="mail_subject" value="<?php echo esc_attr($mail_subject); ?>" class="large-text" placeholder="Tin nhắn mới từ website của bạn">
    <p class="description">Sử dụng các trường form làm biến, ví dụ: <code>Tin nhắn từ [your-name]</code>.</p>
    </p>
    <p>
        <label for="mail_body"><strong>Nội dung Mail:</strong></label><br>
        <textarea name="mail_body" id="mail_body" rows="10" class="large-text code" placeholder="Từ: [your-name]&#13;Email: [your-email]&#13;Nội dung:&#13;[your-message]"><?php echo esc_textarea($mail_body); ?></textarea>
    <p class="description">Điền nội dung email. Sử dụng các biến tương ứng với tên trường form, ví dụ: <code>[your-name]</code>, <code>[your-email]</code>, <code>[your-message]</code>.</p>
    </p>
<?php
}

// =============================================================================
// 5. CALLBACK CHO THÔNG BÁO META BOX (Không đổi)
// =============================================================================
function form_messages_metabox_callback($post)
{
    wp_nonce_field('save_form_messages_data', 'form_messages_nonce');
    $msg_success = get_post_meta($post->ID, '_msg_success', true);
    $msg_error = get_post_meta($post->ID, '_msg_error', true);
    $msg_validation = get_post_meta($post->ID, '_msg_validation', true);
?>
    <p>
        <label for="msg_success"><strong>Thông báo thành công:</strong></label><br>
        <input type="text" name="msg_success" id="msg_success" value="<?php echo esc_attr($msg_success); ?>" class="large-text" placeholder="Cảm ơn bạn đã liên hệ! Chúng tôi sẽ phản hồi sớm nhất.">
    </p>
    <p>
        <label for="msg_error"><strong>Thông báo lỗi gửi:</strong></label><br>
        <input type="text" name="msg_error" id="msg_error" value="<?php echo esc_attr($msg_error); ?>" class="large-text" placeholder="Đã có lỗi xảy ra trong quá trình gửi. Vui lòng thử lại.">
    </p>
    <p>
        <label for="msg_validation"><strong>Thông báo lỗi xác thực:</strong></label><br>
        <input type="text" name="msg_validation" id="msg_validation" value="<?php echo esc_attr($msg_validation); ?>" class="large-text" placeholder="Vui lòng kiểm tra lại các trường được yêu cầu.">
    </p>
<?php
}


// =============================================================================
// 6. LƯU DỮ LIỆU META BOX KHI BÀI VIẾT ĐƯỢC LƯU (Cập nhật sanitization)
// =============================================================================
function save_form_meta_boxes($post_id)
{
    // Kiểm tra autosave
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Kiểm tra quyền
    if (!current_user_can('edit_post', $post_id)) return;

    // Lưu Cấu trúc Form - Cho phép lưu HTML
    if (isset($_POST['form_layout']) && check_admin_referer('save_form_layout_data', 'form_layout_nonce')) {
        update_post_meta($post_id, '_form_layout', wp_kses_post(wp_unslash($_POST['form_layout'])));
    }

    // Lưu Cấu hình Mail
    if (isset($_POST['mail_to']) && check_admin_referer('save_form_mail_data', 'form_mail_nonce')) {
        // Hỗ trợ nhiều email
        $emails = array_map('trim', explode(',', wp_unslash($_POST['mail_to'])));
        $sanitized_emails = array_map('sanitize_email', $emails);
        update_post_meta($post_id, '_mail_to', implode(', ', array_filter($sanitized_emails)));
    }
    if (isset($_POST['mail_subject']) && check_admin_referer('save_form_mail_data', 'form_mail_nonce')) {
        update_post_meta($post_id, '_mail_subject', sanitize_text_field(wp_unslash($_POST['mail_subject'])));
    }
    if (isset($_POST['mail_body']) && check_admin_referer('save_form_mail_data', 'form_mail_nonce')) {
        update_post_meta($post_id, '_mail_body', wp_kses_post(wp_unslash($_POST['mail_body'])));
    }

    // Lưu Thông báo
    if (isset($_POST['msg_success']) && check_admin_referer('save_form_messages_data', 'form_messages_nonce')) {
        update_post_meta($post_id, '_msg_success', sanitize_text_field(wp_unslash($_POST['msg_success'])));
    }
    if (isset($_POST['msg_error']) && check_admin_referer('save_form_messages_data', 'form_messages_nonce')) {
        update_post_meta($post_id, '_msg_error', sanitize_text_field(wp_unslash($_POST['msg_error'])));
    }
    if (isset($_POST['msg_validation']) && check_admin_referer('save_form_messages_data', 'form_messages_nonce')) {
        update_post_meta($post_id, '_msg_validation', sanitize_text_field(wp_unslash($_POST['msg_validation'])));
    }
}
add_action('save_post', 'save_form_meta_boxes');


// =============================================================================
// 7. SHORTCODE ĐỂ HIỂN THỊ FORM (CẬP NHẬT VỚI CLASS BOOTSTRAP)
// =============================================================================
function my_form_shortcode($atts)
{
    $atts = shortcode_atts(['id' => 0], $atts, 'my_form');
    $form_id = (int)$atts['id'];

    if (!$form_id || get_post_type($form_id) !== 'my_form_builder') {
        return '<p class="my-form-error">Form không tồn tại hoặc ID không hợp lệ.</p>';
    }

    $form_layout_raw = get_post_meta($form_id, '_form_layout', true);

    // Regex để tìm tất cả các shortcode của chúng ta
    $form_html = preg_replace_callback(
        '/\[(text|email|tel|number|date|textarea|checkbox|select|submit)(\*?)\s+([^\]]+)\]/',
        function ($matches) use ($form_id) { // Thêm `use ($form_id)` nếu cần trong tương lai
            $tag = $matches[0];
            $type = $matches[1];
            $required = !empty($matches[2]) ? ' required' : '';
            $attr_string = $matches[3];

            $parts = preg_split('/\s+/', $attr_string, 2);
            $name = $parts[0];
            $other_attrs_str = isset($parts[1]) ? $parts[1] : '';

            $attrs = shortcode_parse_atts($other_attrs_str);

            // ==========================================================
            // ✨ BẮT ĐẦU THAY ĐỔI: TỰ ĐỘNG THÊM CLASS 'form-control'
            // ==========================================================
            if (in_array($type, ['text', 'email', 'tel', 'number', 'date', 'textarea', 'select'])) {
                if (isset($attrs['class'])) {
                    // Nếu đã có class, và chưa có 'form-control', thì thêm vào
                    if (strpos($attrs['class'], 'form-control') === false) {
                        $attrs['class'] .= ' form-control';
                    }
                } else {
                    // Nếu chưa có class nào, thì tạo mới
                    $attrs['class'] = 'form-control';
                }
            }
            // ==========================================================
            // ✨ KẾT THÚC THAY ĐỔI
            // ==========================================================


            $html_attrs = '';
            foreach ($attrs as $key => $value) {
                if (is_numeric($key)) continue;
                $html_attrs .= sprintf(' %s="%s"', esc_attr($key), esc_attr($value));
            }

            switch ($type) {
                case 'text':
                case 'email':
                case 'tel':
                case 'number':
                case 'date':
                    return sprintf(
                        '<input type="%s" name="%s"%s%s>',
                        esc_attr($type),
                        esc_attr($name),
                        $required,
                        $html_attrs
                    );

                case 'textarea':
                    $value = isset($attrs['value']) ? esc_textarea($attrs['value']) : '';
                    // Xóa value khỏi thuộc tính để tránh in ra 2 lần
                    $temp_attrs = $attrs;
                    unset($temp_attrs['value']);
                    $html_attrs_no_value = '';
                    foreach ($temp_attrs as $key => $val) {
                        if (is_numeric($key)) continue;
                        $html_attrs_no_value .= sprintf(' %s="%s"', esc_attr($key), esc_attr($val));
                    }
                    return sprintf(
                        '<textarea name="%s"%s%s>%s</textarea>',
                        esc_attr($name),
                        $required,
                        $html_attrs_no_value,
                        $value
                    );

                case 'checkbox':
                    // Checkbox của Bootstrap có cấu trúc khác, nên việc thêm 'form-control' không phù hợp ở đây.
                    // Giữ nguyên để không phá vỡ layout.
                    $label = isset($attrs['label']) ? esc_html($attrs['label']) : 'Check me';
                    unset($attrs['label']);
                    return sprintf(
                        '<label><input type="checkbox" name="%s" value="1"%s%s> %s</label>',
                        esc_attr($name),
                        $required,
                        $html_attrs,
                        $label
                    );

                case 'select':
                    $options_html = '';
                    // Xóa options khỏi thuộc tính để không in ra trong thẻ select
                    $temp_attrs = $attrs;
                    unset($temp_attrs['options']);
                    $html_attrs_no_options = '';
                    foreach ($temp_attrs as $key => $val) {
                        if (is_numeric($key)) continue;
                        $html_attrs_no_options .= sprintf(' %s="%s"', esc_attr($key), esc_attr($val));
                    }
                    if (!empty($attrs['options'])) {
                        $options_array = explode('|', $attrs['options']);
                        foreach ($options_array as $option) {
                            $opt_parts = explode(':', $option, 2);
                            $value = trim($opt_parts[0]);
                            $label = isset($opt_parts[1]) ? trim($opt_parts[1]) : $value;
                            $options_html .= sprintf('<option value="%s">%s</option>', esc_attr($value), esc_html($label));
                        }
                    }
                    return sprintf(
                        '<select name="%s"%s%s>%s</select>',
                        esc_attr($name),
                        $required,
                        $html_attrs_no_options,
                        $options_html
                    );

                case 'submit':
                    $button_text = esc_html($name);
                    return sprintf(
                        '<button type="submit"%s>%s</button>',
                        $html_attrs,
                        $button_text
                    );

                default:
                    return '';
            }
        },
        $form_layout_raw
    );

    // Thêm các trường ẩn và div cho thông báo
    $output = '<div class="my-form-container">';
    $output .= '<div class="my-form-messages"></div>';
    $output .= '<form class="my-form" data-form-id="' . esc_attr($form_id) . '">';
    $output .= '<input type="hidden" name="action" value="my_form_ajax_submit">';
    $output .= '<input type="hidden" name="form_id" value="' . esc_attr($form_id) . '">';
    $output .= wp_nonce_field('my_form_action_' . $form_id, 'my_form_nonce_field', true, false);
    $output .= $form_html; // Đây là layout HTML tùy chỉnh của bạn
    $output .= '</form>';
    $output .= '</div>';

    return $output;
}
add_shortcode('my_form', 'my_form_shortcode');


// =============================================================================
// 8. Đăng ký script cho AJAX (Frontend) (Không đổi)
// =============================================================================
function my_form_enqueue_scripts()
{
    // Giả sử tệp JS nằm trong /inc/form/
    $js_path = get_template_directory_uri() . '/inc/form/form-frontend.js';
    if (file_exists(get_template_directory() . '/inc/form/form-frontend.js')) {
        wp_enqueue_script('my-form-frontend-script', $js_path, [], null, true);
        wp_localize_script('my-form-frontend-script', 'my_form_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
        ]);
    }
}
add_action('wp_enqueue_scripts', 'my_form_enqueue_scripts');


// =============================================================================
// 9. Đăng ký script và style cho Admin (Không đổi)
// =============================================================================
function my_form_admin_scripts($hook)
{
    if ('post.php' != $hook && 'post-new.php' != $hook) {
        return;
    }
    global $post;
    if (empty($post) || 'my_form_builder' != $post->post_type) {
        return;
    }

    wp_enqueue_script('jquery-ui-dialog');
    wp_enqueue_style('wp-jquery-ui-dialog');

    $editor_js_path = get_template_directory_uri() . '/inc/form/form-admin-editor.js';
    if (file_exists(get_template_directory() . '/inc/form/form-admin-editor.js')) {
        wp_enqueue_script('my-form-admin-editor', $editor_js_path, ['jquery', 'jquery-ui-dialog'], null, true);
    }

    $admin_css_path = get_template_directory_uri() . '/inc/form/form-admin.css';
    if (file_exists(get_template_directory() . '/inc/form/form-admin.css')) {
        wp_enqueue_style('my-form-admin-style', $admin_css_path, [], null);
    }
}
add_action('admin_enqueue_scripts', 'my_form_admin_scripts');


// =============================================================================
// 10. XỬ LÝ AJAX SUBMISSION (Không đổi)
// =============================================================================
// Hàm này vẫn hoạt động tốt vì nó dựa trên `name` của trường và nonce,
// vốn không bị ảnh hưởng bởi thay đổi layout.

function my_form_ajax_submit_handler()
{
    $form_id = isset($_POST['form_id']) ? (int)$_POST['form_id'] : 0;

    if (!$form_id) {
        wp_send_json_error(['message' => 'Thiếu ID form.']);
    }

    if (!check_ajax_referer('my_form_action_' . $form_id, 'my_form_nonce_field', false)) {
        wp_send_json_error(['message' => 'Lỗi bảo mật!']);
    }

    $form_layout = get_post_meta($form_id, '_form_layout', true);
    preg_match_all('/\[(?:text|email|tel|number|date|textarea|checkbox|select)\*\s+([a-zA-Z0-9_-]+)[^\]]*\]/', $form_layout, $matches_required);

    $errors = [];
    $required_fields_names = $matches_required[1] ?? [];

    foreach ($required_fields_names as $name) {
        if (strpos($form_layout, "[checkbox*" . $name) !== false) {
            if (empty($_POST[$name])) {
                $errors[$name] = 'Trường này là bắt buộc.';
            }
        } elseif (empty(trim($_POST[$name] ?? ''))) {
            $errors[$name] = 'Trường này là bắt buộc.';
        }
    }

    if (!empty($errors)) {
        $validation_msg = get_post_meta($form_id, '_msg_validation', true) ?: 'Vui lòng kiểm tra lại các trường được yêu cầu.';
        wp_send_json_error(['message' => $validation_msg, 'errors' => $errors]);
    }

    // Phần xử lý gửi mail còn lại giữ nguyên...
    require_once ABSPATH . WPINC . '/PHPMailer/PHPMailer.php';
    require_once ABSPATH . WPINC . '/PHPMailer/SMTP.php';
    require_once ABSPATH . WPINC . '/PHPMailer/Exception.php';

    $mail_to = get_post_meta($form_id, '_mail_to', true);
    $mail_subject_template = get_post_meta($form_id, '_mail_subject', true);
    $mail_body_template = get_post_meta($form_id, '_mail_body', true);

    // Lấy tất cả tên trường
    preg_match_all('/\[(?:text|email|tel|number|date|textarea|checkbox|select)\*?\s+([a-zA-Z0-9_-]+)/', $form_layout, $all_fields_matches);
    $all_field_names = array_unique($all_fields_matches[1] ?? []);

    $submitted_data = [];
    foreach ($all_field_names as $name) {
        if (strpos($form_layout, "[checkbox " . $name) !== false || strpos($form_layout, "[checkbox*" . $name) !== false) {
            $submitted_data[$name] = isset($_POST[$name]) && $_POST[$name] === '1' ? 'Đã chọn' : 'Chưa chọn';
        } else {
            $submitted_data[$name] = isset($_POST[$name]) ? sanitize_text_field(stripslashes($_POST[$name])) : '';
        }
    }

    $mail_subject = $mail_subject_template;
    $mail_body = $mail_body_template;
    foreach ($submitted_data as $key => $value) {
        $mail_subject = str_replace('[' . $key . ']', $value, $mail_subject);
        $mail_body = str_replace('[' . $key . ']', $value, $mail_body);
    }

    $smtp_options = get_option('my_form_smtp_options', []);
    $mail = new PHPMailer\PHPMailer\PHPMailer(true);

    try {
        if (!empty($smtp_options['host']) && !empty($smtp_options['username']) && !empty($smtp_options['password'])) {
            $mail->isSMTP();
            $mail->Host = $smtp_options['host'];
            $mail->SMTPAuth = true;
            $mail->Username = $smtp_options['username'];
            $mail->Password = $smtp_options['password'];
            $mail->SMTPSecure = $smtp_options['encryption'] ?? PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = (int)($smtp_options['port'] ?? 587);
        }

        $from_email = !empty($smtp_options['username']) ? $smtp_options['username'] : get_option('admin_email');
        $mail->setFrom($from_email, get_option('blogname'));

        $recipients = array_map('trim', explode(',', $mail_to));
        foreach ($recipients as $recipient) {
            if (is_email($recipient)) {
                $mail->addAddress($recipient);
            }
        }

        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';
        $mail->Subject = $mail_subject;
        $mail->Body    = nl2br($mail_body);
        $mail->AltBody = strip_tags($mail_body);

        $mail->send();

        $success_msg = get_post_meta($form_id, '_msg_success', true) ?: 'Cảm ơn bạn đã liên hệ!';
        wp_send_json_success(['message' => $success_msg]);
    } catch (PHPMailer\PHPMailer\Exception $e) {
        error_log("Mailer Error: {$mail->ErrorInfo}");
        $error_msg = get_post_meta($form_id, '_msg_error', true) ?: 'Có lỗi xảy ra khi gửi mail.';
        wp_send_json_error(['message' => "{$error_msg} (Debug: {$mail->ErrorInfo})"]);
    }
}
add_action('wp_ajax_my_form_ajax_submit', 'my_form_ajax_submit_handler');
add_action('wp_ajax_nopriv_my_form_ajax_submit', 'my_form_ajax_submit_handler');


// =============================================================================
// 11. CÁC HÀM PHỤ TRỢ (Shortcode metabox, cột admin) (Không đổi)
// =============================================================================
function form_shortcode_metabox_callback($post)
{
?>
    <p>Sử dụng shortcode này để hiển thị form trên bất kỳ trang, bài đăng hoặc widget nào:</p>
    <pre><code style="display: block; padding: 10px; background: #f0f0f0; border: 1px solid #ddd; border-radius: 4px;">[my_form id="<?php echo esc_attr($post->ID); ?>"]</code></pre>
    <p class="description">Sao chép và dán shortcode này vào nơi bạn muốn hiển thị form.</p>
<?php
}

function add_custom_columns_to_my_forms_list($columns)
{
    $new_columns = [];
    foreach ($columns as $key => $value) {
        $new_columns[$key] = $value;
        if ($key === 'title') {
            $new_columns['form_shortcode'] = 'Shortcode';
        }
    }
    $new_columns['author'] = 'Tác giả';
    return $new_columns;
}
add_filter('manage_my_form_builder_posts_columns', 'add_custom_columns_to_my_forms_list');


function display_custom_columns_for_my_forms_column($column, $post_id)
{
    switch ($column) {
        case 'form_shortcode':
            echo '<pre><code style="display: inline-block; padding: 5px; background: #f9f9f9; border: 1px solid #eee; border-radius: 3px; font-size: 12px;">[my_form id="' . esc_attr($post_id) . '"]</code></pre>';
            break;
        case 'author':
            $author_id = get_post_field('post_author', $post_id);
            echo esc_html(get_the_author_meta('display_name', $author_id));
            break;
    }
}
add_action('manage_my_form_builder_posts_custom_column', 'display_custom_columns_for_my_forms_column', 10, 2);

?>