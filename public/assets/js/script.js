// Confirm Delete with Toast
function confirmDelete(
    message = "Apakah Anda yakin ingin menghapus data ini?"
) {
    return confirm(message);
}

// Image Preview Function
function previewImages(input, previewContainer) {
    const container = document.getElementById(previewContainer);
    if (!container) return;

    container.innerHTML = "";

    if (input.files) {
        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function (e) {
                const preview = document.createElement("div");
                preview.className = "image-preview";
                preview.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}">
                `;
                container.appendChild(preview);
            };

            reader.readAsDataURL(file);
        });
    }
}

// Auto-dismiss alerts
document.addEventListener("DOMContentLoaded", function () {
    // Set CSRF token for all AJAX requests
    const token = document.querySelector('meta[name="csrf-token"]');
    if (token) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": token.content,
            },
        });
    }
});
