jQuery(document).ready(function ($) {
    function updateHeaderBottomHiddenInput() {
        // Tạo một đối tượng để chứa cấu trúc mới với 3 cột
        let newOrder = {
            left: [],
            center: [],
            right: []
        };

        // Lấy các item từ cột Trái
        $('#ht-headerbottom-left .ht-headerbottom-sortable-item').each(function () {
            newOrder.left.push($(this).data('item'));
        });

        // Lấy các item từ cột Giữa
        $('#ht-headerbottom-center .ht-headerbottom-sortable-item').each(function () {
            newOrder.center.push($(this).data('item'));
        });

        // Lấy các item từ cột Phải
        $('#ht-headerbottom-right .ht-headerbottom-sortable-item').each(function () {
            newOrder.right.push($(this).data('item'));
        });

        // Cập nhật giá trị của input ẩn với chuỗi JSON mới
        $('#customize-control-ht_headerbottom_layout input[type="hidden"]')
            .val(JSON.stringify(newOrder))
            .trigger('change');
    }

    // Kích hoạt sortable cho cả 4 khu vực và kết nối chúng với nhau
    $("#ht-headerbottom-left, #ht-headerbottom-center, #ht-headerbottom-right, #ht-headerbottom-available").sortable({
        connectWith: ".ht-headerbottom-sortable",
        placeholder: "ui-state-highlight", // Đồng bộ hiệu ứng placeholder
        update: function (event, ui) {
            updateHeaderBottomHiddenInput();
        }
    }).disableSelection();

});