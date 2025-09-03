// File: /inc/header/header-builder/mobile-menu-elements.js

jQuery(document).ready(function($) {
    // Hàm cập nhật input ẩn khi có thay đổi
    function updateHiddenInput(list) {
        let data = [];
        list.find('.ht-mobile-element-item').each(function() {
            let item = $(this);
            data.push({
                id: item.data('id'),
                visible: item.data('visible') === true || item.data('visible') === 'true'
            });
        });
        // Cập nhật input và trigger 'change' để Customizer lưu lại và gửi tín hiệu cho preview
        list.siblings('.ht-mobile-elements-input').val(JSON.stringify(data)).trigger('change');
    }

    // Kích hoạt kéo thả
    $('.ht-mobile-elements-list').sortable({
        handle: '.drag-handle', // Chỉ cho phép kéo bằng icon menu
        update: function() {
            updateHiddenInput($(this));
        }
    });

    // Xử lý click vào icon con mắt
    $('.ht-mobile-elements-control').on('click', '.toggle-visibility', function() {
        let button = $(this);
        let item = button.closest('.ht-mobile-element-item');
        let icon = button.find('.dashicons');
        
        // Đảo ngược trạng thái data-visible
        let isVisible = !(item.data('visible') === true || item.data('visible') === 'true');
        item.data('visible', isVisible);
        
        // Thay đổi icon con mắt
        icon.toggleClass('dashicons-visibility dashicons-hidden');
        
        // Cập nhật input ẩn để lưu
        updateHiddenInput(item.closest('.ht-mobile-elements-list'));
    });
});