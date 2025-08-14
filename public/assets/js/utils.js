
function assets(path) {
    const isSecure = window.location.protocol === 'https:';
    const scheme = isSecure ? 'https' : 'http';
    const host = window.location.host;

    path = path.replace(/^\/+/, ''); // إزالة أي / من بداية المسار

    return `${scheme}://${host}/assets/${path}`;
}


function confirmDelete(csrf, url,targetUrl='') {
    const formData = new FormData();
    formData.append('csrf', csrf);
    formData.append('_method', 'DELETE');

    Swal.fire({
        title: 'هل أنت متأكد؟',
        text: 'لن تتمكن من التراجع عن هذا الإجراء!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'نعم، احذف!',
        cancelButtonText: 'إلغاء'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        Swal.fire('تم الحذف!', data.message, 'success').then(() => {
                            if (targetUrl) location.href=targetUrl;
                            else location.reload();
                        });
                    } else {
                        Swal.fire('خطأ!', data.message, 'error');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('خطأ!', "Error deleting image. Please try again.", 'error');

                });
        }
    });
}
