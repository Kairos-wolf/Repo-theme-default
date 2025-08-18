// form-admin-editor.js
jQuery(document).ready(function ($) {
    const $formLayoutTextarea = $('#form_layout');
    const $formTagModal = $('#my-form-tag-modal');
    const $modalContent = $('#modal-content');

    let currentTagType = '';

    $formTagModal.dialog({
        autoOpen: false,
        modal: true,
        width: 450,
        height: 'auto',
        minHeight: 250,
        closeOnEscape: true,
        title: 'Cấu hình Trường Form',
        dialogClass: 'wp-dialog',
        buttons: [
            {
                text: "Chèn Thẻ",
                class: "button button-primary",
                click: function () {
                    const tag = generateTagShortcode(currentTagType);
                    if (tag) {
                        insertAtCaret($formLayoutTextarea[0], tag);
                        $(this).dialog("close");
                    }
                }
            },
            {
                text: "Hủy",
                class: "button button-secondary",
                click: function () {
                    $(this).dialog("close");
                }
            }
        ]
    });

    $('.insert-form-tag').on('click', function () {
        currentTagType = $(this).data('tag-type');
        loadModalContent(currentTagType);
        $formTagModal.dialog('open');
    });

    // Cập nhật: Thêm trường ID và Class
    function loadModalContent(type) {
        let html = '';
        let commonFields = `
            <div class="field-setting">
                <label for="tag-name">Tên trường (Bắt buộc):</label>
                <input type="text" id="tag-name" value="" placeholder="your-name">
                <p class="description">Chỉ dùng chữ thường, số, gạch ngang, gạch dưới.</p>
            </div>
             <div class="field-setting">
                <label for="tag-id">ID (Tùy chọn):</label>
                <input type="text" id="tag-id" value="" placeholder="my-custom-id">
            </div>
             <div class="field-setting">
                <label for="tag-class">Class (Tùy chọn):</label>
                <input type="text" id="tag-class" value="" placeholder="form-control custom-class">
            </div>
            <div class="field-setting">
                <label><input type="checkbox" id="tag-required"> Trường bắt buộc?</label>
            </div>
        `;

        switch (type) {
            case 'text':
            case 'email':
            case 'tel':
            case 'number':
            case 'date':
                html = commonFields + `
                    <div class="field-setting">
                        <label for="tag-placeholder">Placeholder (Gợi ý):</label>
                        <input type="text" id="tag-placeholder" value="" placeholder="Nhập giá trị của bạn">
                    </div>
                `;
                break;
            case 'textarea':
                html = commonFields + `
                    <div class="field-setting">
                        <label for="tag-placeholder">Placeholder (Gợi ý):</label>
                        <input type="text" id="tag-placeholder" value="" placeholder="Nội dung tin nhắn">
                    </div>
                    <div class="field-setting">
                        <label for="tag-rows">Số dòng (Rows):</label>
                        <input type="number" id="tag-rows" value="5" min="1" class="small-text">
                    </div>
                `;
                break;
            case 'checkbox':
                html = `
                    <div class="field-setting">
                        <label for="tag-name">Tên trường (Bắt buộc):</label>
                        <input type="text" id="tag-name" value="" placeholder="agree-terms">
                         <p class="description">Chỉ dùng chữ thường, số, gạch ngang, gạch dưới.</p>
                    </div>
                    <div class="field-setting">
                        <label for="tag-id">ID (Tùy chọn):</label>
                        <input type="text" id="tag-id" value="" placeholder="my-custom-id">
                    </div>
                    <div class="field-setting">
                        <label for="tag-class">Class (Tùy chọn):</label>
                        <input type="text" id="tag-class" value="" placeholder="custom-class">
                    </div>
                    <div class="field-setting">
                        <label for="tag-label">Văn bản hiển thị (Label Text):</label>
                        <input type="text" id="tag-label" value="" placeholder="Tôi đồng ý với các điều khoản">
                    </div>
                    <div class="field-setting">
                        <label><input type="checkbox" id="tag-required"> Trường bắt buộc?</label>
                    </div>
                `;
                break;
            case 'select':
                html = commonFields + `
                    <div class="field-setting">
                        <label for="tag-options">Các tùy chọn (Options):</label>
                        <textarea id="tag-options" rows="5" placeholder="value1:Label 1|value2:Label 2"></textarea>
                        <p class="description">Mỗi tùy chọn trên một dòng hoặc cách nhau bởi dấu gạch đứng (|). Định dạng: <code>giá_trị:Văn bản hiển thị</code>.</p>
                    </div>
                `;
                break;
            case 'submit':
                html = `
                    <div class="field-setting">
                        <label for="tag-button-text">Văn bản nút (Button Text):</label>
                        <input type="text" id="tag-button-text" value="Gửi đi" placeholder="Gửi đi">
                    </div>
                     <div class="field-setting">
                        <label for="tag-id">ID (Tùy chọn):</label>
                        <input type="text" id="tag-id" value="" placeholder="my-submit-button">
                    </div>
                     <div class="field-setting">
                        <label for="tag-class">Class (Tùy chọn):</label>
                        <input type="text" id="tag-class" value="btn btn-primary" placeholder="btn btn-primary">
                    </div>
                `;
                break;
        }
        $modalContent.html(html);
    }

    // Cập nhật: Thêm id và class vào shortcode
    function generateTagShortcode(type) {
        let tag = `[${type}`;
        let name = '';
        let required = '';

        if (type !== 'submit') {
            name = $('#tag-name').val().trim();
            required = $('#tag-required').is(':checked') ? '*' : '';

            if (name === '') {
                alert('Tên trường không được để trống.');
                $('#tag-name').focus();
                return '';
            }
            if (!/^[a-z0-9_-]+$/.test(name)) {
                alert('Tên trường chỉ chấp nhận chữ thường, số, dấu gạch ngang và gạch dưới.');
                $('#tag-name').focus();
                return '';
            }
            tag += `${required} ${name}`;
        } else {
            const buttonText = $('#tag-button-text').val().trim() || 'Gửi đi';
            tag += ` "${buttonText}"`;
        }

        // Thêm các thuộc tính chung
        const id = $('#tag-id').val().trim();
        const className = $('#tag-class').val().trim();
        if (id) tag += ` id="${id}"`;
        if (className) tag += ` class="${className}"`;

        switch (type) {
            case 'text':
            case 'email':
            case 'tel':
            case 'number':
            case 'date':
            case 'textarea':
                const placeholder = $('#tag-placeholder').val().trim();
                if (placeholder) tag += ` placeholder="${placeholder}"`;
                if (type === 'textarea') {
                    const rows = $('#tag-rows').val().trim();
                    if (rows && rows !== '5') tag += ` rows="${rows}"`;
                }
                break;
            case 'checkbox':
                const labelText = $('#tag-label').val().trim();
                if (labelText) tag += ` label="${labelText}"`;
                break;
            case 'select':
                const optionsText = $('#tag-options').val().trim();
                if (optionsText) {
                    let formattedOptions = optionsText.replace(/\r?\n|\r/g, '|');
                    tag += ` options="${formattedOptions}"`;
                }
                break;
        }
        tag += ']';
        return tag;
    }

    function insertAtCaret(el, text) {
        const val = el.value;
        const start = el.selectionStart;
        const end = el.selectionEnd;
        el.value = val.substring(0, start) + text + val.substring(end);
        el.selectionStart = el.selectionEnd = start + text.length;
        el.focus();
    }
});