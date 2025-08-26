jQuery(document).ready(function ($) {
    function updateHeaderHiddenInput() {
        // Tạo một đối tượng để chứa cấu trúc mới chỉ với 2 cột: Trái và Phải
        let newOrder = {
            left: [],
            right: []
        };

        // Lấy các item từ cột Trái
        $('#ht-header-left .ht-sortable-item').each(function () {
            newOrder.left.push($(this).data('item'));
        });

        // Lấy các item từ cột Phải
        $('#ht-header-right .ht-sortable-item').each(function () {
            newOrder.right.push($(this).data('item'));
        });

        // Cập nhật giá trị của input ẩn với chuỗi JSON mới
        // Lưu ý ID của control là 'ht_header_layout'
        $('#customize-control-ht_header_layout input[type="hidden"]')
            .val(JSON.stringify(newOrder))
            .trigger('change');
    }

    // Kích hoạt sortable cho cả 3 khu vực (Trái, Phải, và khu vực Còn lại) và kết nối chúng
    $("#ht-header-left, #ht-header-right, #ht-header-available").sortable({
        connectWith: ".ht-sortable", // Class chung cho các thành phần sortable của header
        placeholder: "ui-state-highlight", // Hiệu ứng placeholder được đồng bộ
        update: function (event, ui) {
            updateHeaderHiddenInput();
        }
    }).disableSelection();
});