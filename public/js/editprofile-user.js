document.addEventListener('DOMContentLoaded', function () {
    // Form elements
    const profileForm = document.getElementById('profile-form');
    const saveChangesBtn = document.getElementById('save-changes-btn');

    // Cropper elements
    const imageInput = document.getElementById('profile_photo_input');
    const cropModalElement = document.getElementById('cropImageModal');
    const cropModal = new bootstrap.Modal(cropModalElement);
    const imageToCrop = document.getElementById('image-to-crop');
    const cropAndSaveBtn = document.getElementById('crop-and-save');
    let cropper;

    if (!profileForm || !saveChangesBtn || !imageInput) {
        console.error('Required form elements are not found.');
        return;
    }

    // --- Form Change Detection Logic ---

    // The button is now always enabled.

    // --- Cropper Logic ---

    // Open modal when a file is selected
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

    // Initialize Cropper.js when the modal is shown
    cropModalElement.addEventListener('shown.bs.modal', function () {
        cropper = new Cropper(imageToCrop, {
            aspectRatio: 1,
            viewMode: 1,
            preview: '.cropper-preview',
        });
    });

    // Destroy Cropper.js instance when the modal is hidden
    cropModalElement.addEventListener('hidden.bs.modal', function () {
        if (cropper) {
            cropper.destroy();
        }
        cropper = null;
        // Do not reset imageInput.value, so the form knows a file is selected
    });

    // Handle the "Simpan Foto" button click in the modal
    cropAndSaveBtn.addEventListener('click', function () {
        if (!cropper) {
            return;
        }

        // --- This is the NEW workflow ---
        // It does NOT save to server. It stages the data for the main form.

        // 1. Get the cropped canvas and convert to base64 JPEG
        const croppedCanvas = cropper.getCroppedCanvas({ width: 512, height: 512 });
        const finalCanvas = document.createElement('canvas');
        finalCanvas.width = 512; finalCanvas.height = 512;
        const ctx = finalCanvas.getContext('2d');
        ctx.fillStyle = '#FFFFFF';
        ctx.fillRect(0, 0, 512, 512);
        ctx.drawImage(croppedCanvas, 0, 0);
        const base64Image = finalCanvas.toDataURL('image/jpeg', 0.9);

        // 2. Update the visible image preview on the page
        const currentPreviewEl = document.getElementById('profile-image-preview');
        if (currentPreviewEl.tagName === 'IMG') {
            currentPreviewEl.src = base64Image;
        } else {
            const newImg = document.createElement('img');
            newImg.src = base64Image;
            newImg.alt = 'Foto Profil';
            newImg.className = 'profile-photo-img';
            newImg.id = 'profile-image-preview';
            currentPreviewEl.parentNode.replaceChild(newImg, currentPreviewEl);
        }

        // 3. Find or create a hidden input to store the base64 data
        let hiddenInput = document.getElementById('profile_photo_base64');
        if (!hiddenInput) {
            hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'profile_photo_base64';
            hiddenInput.id = 'profile_photo_base64';
            profileForm.appendChild(hiddenInput);
        }
        hiddenInput.value = base64Image;

        // 4. Close the modal
        cropModal.hide();
    });
});
