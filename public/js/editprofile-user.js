document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('profile_photo_input');
    const cropModalElement = document.getElementById('cropImageModal');
    const cropModal = new bootstrap.Modal(cropModalElement);
    const imageToCrop = document.getElementById('image-to-crop');
    const cropAndSaveBtn = document.getElementById('crop-and-save');
    const updateUrl = document.querySelector('meta[name="update-photo-url"]').getAttribute('content');
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let cropper;

    if (!imageInput || !cropModalElement || !updateUrl) {
        console.error('Required elements for cropping are not found.');
        return;
    }

    // 1. Open modal and prepare image when a file is selected
    imageInput.addEventListener('change', function (e) {
        const files = e.target.files;
        if (files && files.length > 0) {
            const reader = new FileReader();
            reader.onload = function (event) {
                imageToCrop.src = event.target.result;
                cropModal.show();
            };
            reader.readAsDataURL(files[0]);
        }
    });

    // 2. Initialize Cropper.js when the modal is shown
    cropModalElement.addEventListener('shown.bs.modal', function () {
        cropper = new Cropper(imageToCrop, {
            aspectRatio: 1,
            viewMode: 1,
            background: false,
            preview: '.cropper-preview', // Ensure you have a preview element with this class
        });
    });

    // 3. Destroy Cropper.js instance when the modal is hidden
    cropModalElement.addEventListener('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
        }
        cropper = null;
        imageInput.value = ''; // Reset file input
    });

    // 4. Handle the crop and save button click
    cropAndSaveBtn.addEventListener('click', function () {
        if (!cropper) {
            return;
        }

        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';

        // Get the cropped image as a base64 string
        const base64Image = cropper.getCroppedCanvas({
            width: 512,
            height: 512,
            imageSmoothingQuality: 'high',
        }).toDataURL('image/png');

        // 5. Send the base64 image to the server
        fetch(updateUrl, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ photo: base64Image })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(result => {
            if (result.success) {
                // Get the most current reference to the preview element on the main page
                const currentPreviewEl = document.getElementById('profile-image-preview');
                
                // Add a cache-busting query parameter
                const newImagePath = result.path + '?t=' + new Date().getTime();
                
                // Update the profile image on the page without reloading
                if (currentPreviewEl.tagName === 'IMG') {
                    currentPreviewEl.src = newImagePath;
                } else {
                    // If the preview was a div with initials, replace it with an img tag
                    const newImg = document.createElement('img');
                    newImg.src = newImagePath;
                    newImg.alt = 'Foto Profil';
                    newImg.className = 'profile-photo-img';
                    newImg.id = 'profile-image-preview';
                    currentPreviewEl.parentNode.replaceChild(newImg, currentPreviewEl);
                }
                
                cropModal.hide();
            } else {
                alert('Gagal mengunggah foto: ' + (result.message || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat mengunggah foto.');
        })
        .finally(() => {
            this.disabled = false;
            this.innerHTML = 'Simpan Foto';
        });
    });
});