// File: header-builder.js (Đã được đồng bộ và sửa lỗi)

jQuery(document).ready(function ($) {
    
    /**
     * Cập nhật giá trị vào input ẩn để lưu.
     */
    function updateHeaderHiddenInput() {
        let newOrder = {
            desktop: { left: [], right: [] },
            mobile:  { left: [], center: [], right: [] }
        };

        $('#ht-header-desktop-left .ht-sortable-item').each(function () { newOrder.desktop.left.push($(this).data('item')); });
        $('#ht-header-desktop-right .ht-sortable-item').each(function () { newOrder.desktop.right.push($(this).data('item')); });
        
        $('#ht-header-mobile-left .ht-sortable-item').each(function () { newOrder.mobile.left.push($(this).data('item')); });
        $('#ht-header-mobile-center .ht-sortable-item').each(function () { newOrder.mobile.center.push($(this).data('item')); });
        $('#ht-header-mobile-right .ht-sortable-item').each(function () { newOrder.mobile.right.push($(this).data('item')); });

        $('#customize-control-ht_header_layout input[type="hidden"]').val(JSON.stringify(newOrder)).trigger('change');
    }

    /**
     * SỬA LỖI: Hàm đồng bộ hóa hiển thị các khối trong khu vực "còn lại".
     * Nó sẽ ẩn các khối đã được dùng và hiện các khối chưa được dùng.
     */
    function syncAvailableItems() {
        let activeItems = [];
        // Lấy danh sách ID của tất cả các khối đang được sử dụng
        $('.ht-header-active-list .ht-sortable-item').each(function() {
            activeItems.push($(this).data('item'));
        });

        // Duyệt qua từng khối trong khu vực "còn lại"
        $('#ht-header-available .ht-sortable-item').each(function() {
            let item = $(this);
            // Nếu khối này đang được dùng ở trên, hãy ẩn nó đi
            if (activeItems.includes(item.data('item'))) {
                item.hide();
            } else { // Nếu không, hãy hiện nó ra
                item.show();
            }
        });
    }

    // --- LOGIC KÉO THẢ ĐÃ ĐƯỢỢC CẬP NHẬT ---
    
    const allAreas = ".ht-sortable";
    const availableList = "#ht-header-available";

    // Kích hoạt sortable cho TẤT CẢ các vùng
    $(allAreas).sortable({
        connectWith: allAreas,
        placeholder: "ui-state-highlight",
        // Bắt đầu kéo
        start: function(event, ui) {
            // Nếu kéo từ vùng "còn lại", đánh dấu nó là một bản sao
            if (ui.item.parent().is(availableList)) {
                ui.item.addClass('is-cloning');
            }
        },
        // Khi một vùng nhận được một item
        receive: function(event, ui) {
            // Nếu một vùng active nhận được item từ vùng "còn lại"
            if (ui.sender.is(availableList)) {
                // Biến item clone thành item thật
                ui.item.removeClass('is-cloning');
            }
        },
        // Kết thúc kéo thả
        stop: function(event, ui) {
            // Nếu item được kéo từ vùng "còn lại", hủy việc di chuyển item gốc
            // và để lại bản sao ở vị trí mới
            if (ui.item.hasClass('is-cloning')) {
                ui.item.removeClass('is-cloning');
                // Quan trọng: Hủy thao tác di chuyển item gốc khỏi danh sách "còn lại"
                $(this).sortable('cancel');
            }
            // Cập nhật input và đồng bộ hóa hiển thị
            updateHeaderHiddenInput();
            syncAvailableItems();
        }
    }).disableSelection();

    // Đồng bộ hóa lần đầu tiên khi tải trang
    syncAvailableItems();
});