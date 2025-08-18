document.addEventListener('DOMContentLoaded', function () {
    const forms = document.querySelectorAll('form.my-form');

    forms.forEach(form => {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const container = form.closest('.my-form-container');
            const messagesDiv = container.querySelector('.my-form-messages');
            const submitButton = form.querySelector('button[type="submit"]');
            const originalButtonText = submitButton.innerHTML;

            // Xóa các thông báo lỗi cũ
            messagesDiv.innerHTML = '';
            form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));

            // Hiển thị trạng thái đang gửi
            submitButton.innerHTML = 'Đang gửi...';
            submitButton.disabled = true;

            const formData = new FormData(form);

            fetch(my_form_ajax.ajax_url, { // my_form_ajax được truyền từ PHP
                method: 'POST',
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        messagesDiv.innerHTML = `<div class="alert alert-success">${data.data.message}</div>`;
                        form.reset();
                    } else {
                        messagesDiv.innerHTML = `<div class="alert alert-danger">${data.data.message}</div>`;
                        // Hiển thị lỗi cụ thể cho từng trường nếu có
                        if (data.data.errors) {
                            Object.keys(data.data.errors).forEach(fieldName => {
                                const field = form.querySelector(`[name="${fieldName}"]`);
                                if (field) {
                                    field.classList.add('is-invalid');
                                    // Bạn có thể chèn message lỗi ngay sau field nếu muốn
                                }
                            });
                        }
                    }
                })
                .catch(error => {
                    messagesDiv.innerHTML = '<div class="alert alert-danger">Lỗi kết nối. Vui lòng thử lại.</div>';
                    console.error('Submission Error:', error);
                })
                .finally(() => {
                    // Khôi phục nút bấm
                    submitButton.innerHTML = originalButtonText;
                    submitButton.disabled = false;
                });
        });
    });
});