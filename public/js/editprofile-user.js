// ============================================
// SMOOTH FADE-IN ANIMATION
// ============================================
document.addEventListener("DOMContentLoaded", () => {
    document.body.style.opacity = 0;
    document.body.style.transition = "opacity 0.3s ease";
    requestAnimationFrame(() => {
        document.body.style.opacity = 1;
    });
});

// ============================================
// CONFIRM DELETE BUTTON
// ============================================
document.querySelectorAll('.btn-delete').forEach(btn => {
    btn.addEventListener('click', e => {
        const name = btn.dataset.name || 'data ini';
        if (!confirm(`Apakah kamu yakin ingin menghapus ${name}?`)) {
            e.preventDefault();
        }
    });
});

// ============================================
// PREVIEW IMAGE UPLOAD (Foto Profil / Logo)
// ============================================
document.querySelectorAll('input[type="file"]').forEach(input => {
    input.addEventListener('change', function () {
        const preview = document.querySelector(`#preview-${this.name}`);
        const file = this.files[0];
        if (file && preview) {
            const reader = new FileReader();
            reader.onload = e => {
                preview.src = e.target.result;
                preview.style.display = "block";
            };
            reader.readAsDataURL(file);
        }
    });
});

// ============================================
// BUTTON LOADING STATE
// ============================================
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', function () {
        const submitBtn = this.querySelector('[type="submit"]');
        if (submitBtn) {
            submitBtn.disabled = true;
            submitBtn.innerHTML = `
                <span class="spinner" style="margin-right:6px;"></span>
                Sedang diproses...
            `;
        }
    });
});

// ============================================
// TABLE ROW HOVER ANIMATION
// ============================================
document.querySelectorAll('table tbody tr').forEach(row => {
    row.addEventListener('mouseenter', () => {
        row.style.backgroundColor = '#f8f9fa';
        row.style.transition = 'background-color 0.2s';
    });
    row.addEventListener('mouseleave', () => {
        row.style.backgroundColor = '';
    });
});

// ============================================
// FLASH MESSAGE AUTO HIDE
// ============================================
const flashMessage = document.querySelector('.alert');
if (flashMessage) {
    setTimeout(() => {
        flashMessage.style.opacity = '0';
        flashMessage.style.transition = 'opacity 0.3s ease';
        setTimeout(() => flashMessage.remove(), 300);
    }, 3000);
}

// ============================================
// FILTER FUNCTIONALITY (DROPDOWN FILTER)
// ============================================
const filterSelect = document.querySelector('select[name*="role"], select[name*="filter"]');
if (filterSelect) {
    filterSelect.addEventListener('change', function() {
        const filterValue = this.value.toLowerCase();
        const rows = document.querySelectorAll('tbody tr');
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (filterValue === '' || filterValue === 'all' || filterValue === 'semua') {
                row.style.display = '';
                row.style.animation = 'fadeIn 0.3s ease';
            } else if (text.includes(filterValue)) {
                row.style.display = '';
                row.style.animation = 'fadeIn 0.3s ease';
            } else {
                row.style.display = 'none';
            }
        });
    });
}

// ============================================
// SIMPLE FADE-IN CSS ANIMATION
// ============================================
const style = document.createElement('style');
style.innerHTML = `
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(4px); }
    to { opacity: 1; transform: translateY(0); }
}
.spinner {
    display: inline-block;
    width: 14px;
    height: 14px;
    border: 2px solid #fff;
    border-top: 2px solid transparent;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
}
@keyframes spin {
    0% { transform: rotate(0); }
    100% { transform: rotate(360deg); }
}
`;
document.head.appendChild(style);