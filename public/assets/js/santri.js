document.addEventListener('DOMContentLoaded', function () {
    const uploadForm = document.getElementById('uploadForm');
    const progressBar = document.getElementById('progressBar');
    const uploadStatus = document.getElementById('uploadStatus');
    const uploadProgress = document.getElementById('uploadProgress');
    const uploadMessages = document.getElementById('uploadMessages');
    const dataTable = $('#myTable').DataTable(); // Initialize DataTable instance

    if (uploadForm) {
        uploadForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(uploadForm);
            const xhr = new XMLHttpRequest();

            xhr.open('POST', uploadForm.action, true);

            const csrfTokenMeta = document.querySelector('meta[name="csrf-token"]');
            if (csrfTokenMeta) {
                xhr.setRequestHeader('X-CSRF-TOKEN', csrfTokenMeta.getAttribute('content'));
            } else {
                console.error('Meta tag csrf-token not found!');
                return;
            }

            xhr.upload.addEventListener('progress', function (e) {
                if (e.lengthComputable) {
                    const percentComplete = (e.loaded / e.total) * 100;
                    progressBar.style.width = percentComplete + '%';
                    progressBar.innerText = percentComplete.toFixed(2) + '%';
                }
            });

            xhr.addEventListener('load', function () {
                let response;
                try {
                    response = JSON.parse(xhr.responseText);
                } catch (e) {
                    console.error('Error parsing JSON response:', e);
                    uploadStatus.classList.add('alert', 'alert-danger');
                    uploadStatus.innerHTML = '<strong>Error:</strong> Unexpected response from server.';
                    return;
                }

                uploadProgress.style.display = 'none';
                uploadStatus.innerHTML = '';

                if (response.status === 'success') {
                    // Clear previous messages
                    uploadMessages.innerHTML = '';

                    // Show success message
                    uploadMessages.classList.add('alert', 'alert-success');
                    uploadMessages.innerHTML = `<strong>${response.message}</strong>`;

                    // Refresh DataTable after upload
                    refreshDataTable();
                } else {
                    uploadMessages.classList.add('alert', 'alert-danger');
                    uploadMessages.innerHTML = `<strong>${response.message}</strong>`;
                }
            });

            uploadProgress.style.display = 'block';
            xhr.send(formData);
        });
    } else {
        console.error('Upload form element not found!');
    }

    // Function to refresh DataTable after upload
    function refreshDataTable() {
        // Destroy current DataTable instance
        dataTable.destroy();

        // Reload table data
        $('#myTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true
        });
    }
});
