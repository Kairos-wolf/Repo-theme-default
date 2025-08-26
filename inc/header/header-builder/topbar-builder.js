jQuery(document).ready(function ($) {
    function updateTopbarHiddenInput() {
        // Tạo một đối tượng để chứa cấu trúc mới
        let newOrder = {
            left: [],
            center: [],
            right: []
        };

        // Lấy các item từ cột Trái
        $('#ht-topbar-left .ht-topbar-sortable-item').each(function () {
            newOrder.left.push($(this).data('item'));
        });

        // Lấy các item từ cột Giữa
        $('#ht-topbar-center .ht-topbar-sortable-item').each(function () {
            newOrder.center.push($(this).data('item'));
        });

        // Lấy các item từ cột Phải
        $('#ht-topbar-right .ht-topbar-sortable-item').each(function () {
            newOrder.right.push($(this).data('item'));
        });

        // Cập nhật giá trị của input ẩn với chuỗi JSON mới
        $('#customize-control-ht_topbar_layout input[type="hidden"]')
            .val(JSON.stringify(newOrder))
            .trigger('change');
    }

    // Kích hoạt sortable cho cả 4 khu vực và kết nối chúng với nhau
    $("#ht-topbar-left, #ht-topbar-center, #ht-topbar-right, #ht-topbar-available").sortable({
        connectWith: ".ht-topbar-sortable",
        placeholder: "ui-state-highlight", // Thêm class để tạo hiệu ứng placeholder
        update: function (event, ui) {
            updateTopbarHiddenInput();
        }
    }).disableSelection();
});