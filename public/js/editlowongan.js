function formatRupiah(value) {
    return 'Rp ' + value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

document.addEventListener("DOMContentLoaded", () => {
    // Format gaji inputs on load
    document.querySelectorAll('.gaji-input').forEach(input => {
        if (input.value) {
            input.value = formatRupiah(input.value);
        }
    });

    // Unformat gaji inputs on form submit
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', () => {
            document.querySelectorAll('.gaji-input').forEach(input => {
                if (input.value.startsWith('Rp ')) {
                    input.value = input.value.replace(/Rp\s*|\./g, '');
                }
            });
        });
    }

    document.querySelectorAll(".input-wrapper .input-icon").forEach(icon => {
        icon.addEventListener("click", () => {
            const input = icon.closest(".input-wrapper").querySelector("input, select, textarea");
            if (input) {
                input.focus(); // auto fokus ke input
            }
        });
    });
});

function previewLogo(event) {
    const reader = new FileReader();
    reader.onload = function(){
        document.getElementById('logoPreview').src = reader.result;
    };
    reader.readAsDataURL(event.target.files[0]);
}
