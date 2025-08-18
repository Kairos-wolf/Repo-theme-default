<?php
// my_theme_smtp_settings.php (hoặc thêm vào functions.php của theme)

/**
 * Thêm menu con cho cài đặt SMTP trong mục "Settings"
 */
function my_theme_add_smtp_settings_page()
{
    add_options_page(
        'Cài đặt SMTP Form', // Tiêu đề trang
        'SMTP Form',       // Tên hiển thị trong menu
        'manage_options',  // Khả năng quản lý (chỉ admin)
        'my-form-smtp-settings', // Slug của trang
        'my_theme_render_smtp_settings_page' // Hàm render nội dung trang
    );
}
add_action('admin_menu', 'my_theme_add_smtp_settings_page');

/**
 * Render nội dung trang cài đặt SMTP
 */
function my_theme_render_smtp_settings_page()
{
    // Kiểm tra quyền người dùng
    if (!current_user_can('manage_options')) {
        return;
    }

    // Hiển thị thông báo nếu có
    if (isset($_GET['settings-updated'])) {
        add_settings_error('my_form_smtp_messages', 'my_form_smtp_message', 'Cài đặt đã được lưu.', 'updated');
    }
    settings_errors('my_form_smtp_messages');
?>
    <div class="wrap">
        <h1>Cài đặt SMTP cho My Forms</h1>
        <form action="options.php" method="post">
            <?php
            settings_fields('my_form_smtp_settings_group'); // Nhóm cài đặt đã đăng ký
            do_settings_sections('my-form-smtp-settings'); // Slug của trang
            submit_button('Lưu cài đặt');
            ?>
        </form>
    </div>
<?php
}

/**
 * Đăng ký cài đặt và các trường
 */
function my_theme_register_smtp_settings()
{
    // Đăng ký nhóm cài đặt
    register_setting(
        'my_form_smtp_settings_group', // Tên nhóm cài đặt
        'my_form_smtp_options',        // Tên option lưu trong database (sẽ là một mảng)
        'my_theme_smtp_options_validate' // Hàm validate dữ liệu
    );

    // Thêm section
    add_settings_section(
        'my_form_smtp_main_section', // ID của section
        'Cấu hình thông tin SMTP',    // Tiêu đề section
        'my_theme_smtp_main_section_callback', // Hàm callback nội dung section
        'my-form-smtp-settings'      // Slug của trang
    );

    // Thêm các trường cài đặt
    add_settings_field(
        'smtp_host',
        'Máy chủ SMTP (Host)',
        'my_theme_smtp_host_callback',
        'my-form-smtp-settings',
        'my_form_smtp_main_section'
    );
    add_settings_field(
        'smtp_username',
        'Tên đăng nhập SMTP (Username)',
        'my_theme_smtp_username_callback',
        'my-form-smtp-settings',
        'my_form_smtp_main_section'
    );
    add_settings_field(
        'smtp_password',
        'Mật khẩu SMTP (Password)',
        'my_theme_smtp_password_callback',
        'my-form-smtp-settings',
        'my_form_smtp_main_section'
    );
    add_settings_field(
        'smtp_port',
        'Cổng SMTP (Port)',
        'my_theme_smtp_port_callback',
        'my-form-smtp-settings',
        'my_form_smtp_main_section'
    );
    add_settings_field(
        'smtp_encryption',
        'Mã hóa (Encryption)',
        'my_theme_smtp_encryption_callback',
        'my-form-smtp-settings',
        'my_form_smtp_main_section'
    );
}
add_action('admin_init', 'my_theme_register_smtp_settings');

/**
 * Callback cho section
 */
function my_theme_smtp_main_section_callback()
{
    echo '<p>Vui lòng điền thông tin máy chủ SMTP của bạn để gửi email.</p>';
    echo '<p>Nếu bạn sử dụng Gmail, hãy bật xác minh 2 bước và tạo Mật khẩu ứng dụng (App Password) để sử dụng làm mật khẩu ở đây.</p>';
}

/**
 * Callbacks cho từng trường input
 */
function my_theme_smtp_host_callback()
{
    $options = get_option('my_form_smtp_options');
    $value = isset($options['host']) ? esc_attr($options['host']) : '';
    echo "<input type='text' name='my_form_smtp_options[host]' value='$value' class='regular-text' placeholder='smtp.example.com'>";
}

function my_theme_smtp_username_callback()
{
    $options = get_option('my_form_smtp_options');
    $value = isset($options['username']) ? esc_attr($options['username']) : '';
    echo "<input type='text' name='my_form_smtp_options[username]' value='$value' class='regular-text' placeholder='your_email@example.com'>";
}

function my_theme_smtp_password_callback()
{
    $options = get_option('my_form_smtp_options');
    $value = isset($options['password']) ? esc_attr($options['password']) : '';
    echo "<input type='password' name='my_form_smtp_options[password]' value='$value' class='regular-text' autocomplete='new-password'>";
    echo "<p class='description'>Để trống nếu bạn không muốn thay đổi mật khẩu đã lưu.</p>";
}

function my_theme_smtp_port_callback()
{
    $options = get_option('my_form_smtp_options');
    $value = isset($options['port']) ? esc_attr($options['port']) : '587';
    echo "<input type='number' name='my_form_smtp_options[port]' value='$value' class='small-text' placeholder='587'>";
}

function my_theme_smtp_encryption_callback()
{
    $options = get_option('my_form_smtp_options');
    $value = isset($options['encryption']) ? esc_attr($options['encryption']) : 'tls';
?>
    <select name="my_form_smtp_options[encryption]">
        <option value="" <?php selected($value, ''); ?>>Không (None)</option>
        <option value="ssl" <?php selected($value, 'ssl'); ?>>SSL</option>
        <option value="tls" <?php selected($value, 'tls'); ?>>TLS</option>
    </select>
    <p class="description">Chọn phương thức mã hóa: SSL (cổng 465) hoặc TLS (cổng 587).</p>
<?php
}

/**
 * Hàm validate dữ liệu trước khi lưu
 * @param array $input Dữ liệu đầu vào từ form
 * @return array Dữ liệu đã được làm sạch
 */
function my_theme_smtp_options_validate($input)
{
    $new_input = [];
    $options = get_option('my_form_smtp_options'); // Lấy các tùy chọn hiện tại để giữ mật khẩu nếu không thay đổi

    $new_input['host'] = sanitize_text_field($input['host']);
    $new_input['username'] = sanitize_email($input['username']);
    // Chỉ cập nhật mật khẩu nếu trường input không rỗng
    if (!empty($input['password'])) {
        $new_input['password'] = sanitize_text_field($input['password']);
    } else {
        $new_input['password'] = isset($options['password']) ? $options['password'] : '';
    }
    $new_input['port'] = intval($input['port']);
    $new_input['encryption'] = sanitize_text_field($input['encryption']);

    // Đặt mặc định nếu cần
    if (empty($new_input['port'])) {
        $new_input['port'] = 587;
    }
    if (empty($new_input['encryption']) && ($new_input['port'] == 465 || $new_input['port'] == 587)) {
        if ($new_input['port'] == 465) {
            $new_input['encryption'] = 'ssl';
        } elseif ($new_input['port'] == 587) {
            $new_input['encryption'] = 'tls';
        }
    }

    return $new_input;
}
