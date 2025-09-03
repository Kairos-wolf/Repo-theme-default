// File: topbar-builder.js (Đã sửa lỗi)

jQuery(document).ready(function ($) {
    // Hàm update input không thay đổi
    function updateTopbarHiddenInput() {
        let newOrder = {
            desktop: { left: [], center: [], right: [] },
            mobile:  { left: [], center: [], right: [] }
        };
        $('#ht-topbar-desktop-left .ht-topbar-sortable-item').each(function () { newOrder.desktop.left.push($(this).data('item')); });
        $('#ht-topbar-desktop-center .ht-topbar-sortable-item').each(function () { newOrder.desktop.center.push($(this).data('item')); });
        $('#ht-topbar-desktop-right .ht-topbar-sortable-item').each(function () { newOrder.desktop.right.push($(this).data('item')); });
        $('#ht-topbar-mobile-left .ht-topbar-sortable-item').each(function () { newOrder.mobile.left.push($(this).data('item')); });
        $('#ht-topbar-mobile-center .ht-topbar-sortable-item').each(function () { newOrder.mobile.center.push($(this).data('item')); });
        $('#ht-topbar-mobile-right .ht-topbar-sortable-item').each(function () { newOrder.mobile.right.push($(this).data('item')); });
        $('#customize-control-ht_topbar_layout input[type="hidden"]').val(JSON.stringify(newOrder)).trigger('change');
    }

    // --- SỬA LỖI KÉO THẢ ---
    
    // Vùng chứa các khối hoạt động (Desktop và Mobile)
    const activeAreas = ".ht-topbar-desktop-areas .ht-topbar-sortable, .ht-topbar-mobile-areas .ht-topbar-sortable";
    // Vùng chứa các khối còn lại
    const availableArea = "#ht-topbar-available";

    // Kích hoạt sortable cho các vùng ACTIVE
    $(activeAreas).sortable({
        connectWith: ".ht-topbar-sortable", // Kết nối với tất cả các vùng khác
        placeholder: "ui-state-highlight",
        receive: function(event, ui) {
            // Nếu nhận item từ vùng "còn lại", không làm gì đặc biệt
            // jQuery UI sẽ tự động xử lý việc di chuyển
            ui.item.removeClass('is-cloned-item');
        },
        stop: function(event, ui) {
            updateTopbarHiddenInput();
        }
    }).disableSelection();

    // Kích hoạt sortable cho vùng AVAILABLE (chỉ kéo đi, không nhận lại)
    $(availableArea).sortable({
        connectWith: activeAreas, // Chỉ có thể kéo đến các vùng active
        placeholder: "ui-state-highlight",
        helper: 'clone', // Luôn tạo bản sao
        stop: function(event, ui) {
            // Cần cập nhật sau khi thả một bản sao
            updateTopbarHiddenInput();
        }
    }).disableSelection();

    // Giải thích về việc xóa khối:
    // Để xóa một khối khỏi layout, bạn chỉ cần kéo nó ra khỏi khu vực builder và thả vào một
    // vùng không hợp lệ (ví dụ: thả vào vùng "Thành phần còn lại"). jQuery UI sẽ tự động
    // xóa nó khỏi layout. Khối gốc vẫn luôn có sẵn trong "Thành phần còn lại" để bạn kéo lên lại.
});