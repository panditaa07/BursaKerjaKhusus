document.addEventListener('DOMContentLoaded', function () {
    const imageInput = document.getElementById('profile_photo_input');
    const imagePreviewContainer = document.querySelector('.photo-wrapper');
    const cropModalElement = document.getElementById('cropImageModal');
    const cropModal = new bootstrap.Modal(cropModalElement);
    const imageToCrop = document.getElementById('image-to-crop');
    const cropAndSaveBtn = document.getElementById('crop-and-save');
    let cropper;

    if (!imageInput) return; // Stop if the element doesn't exist

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

    cropModalElement.addEventListener('shown.bs.modal', function () {
        cropper = new Cropper(imageToCrop, {
            aspectRatio: 1,
            viewMode: 1,
            background: false,
            preview: '.cropper-preview',
        });
    });

    cropModalElement.addEventListener('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
        }
        cropper = null;
        imageInput.value = '';
    });

    cropAndSaveBtn.addEventListener('click', function () {
        this.disabled = true;
        this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';

        if (!cropper) {
            this.disabled = false;
            this.innerHTML = 'Simpan Foto';
            return;
        }

        cropper.getCroppedCanvas({
            width: 512,
            height: 512,
        }).toBlob(function (blob) {
            const formData = new FormData();
            formData.append('photo', blob, 'profile.jpg');
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

            fetch('/profile/photo', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(result => {
                if (result.success) {
                    // Clear the container and add the new image
                    imagePreviewContainer.innerHTML = '';
                    const newImage = document.createElement('img');
                    newImage.src = result.path + '?t=' + new Date().getTime(); // Add timestamp to break cache
                    newImage.alt = 'Foto Profil';
                    newImage.className = 'profile-photo-img';
                    newImage.id = 'profile-image-preview';
                    imagePreviewContainer.appendChild(newImage);
                    
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
                cropAndSaveBtn.disabled = false;
                cropAndSaveBtn.innerHTML = 'Simpan Foto';
            });
        }, 'image/jpeg');
    });
});
