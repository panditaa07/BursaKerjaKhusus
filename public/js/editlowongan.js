document.addEventListener("DOMContentLoaded", () => {
    document.querySelectorAll(".input-wrapper .input-icon").forEach(icon => {
        icon.addEventListener("click", () => {
            const input = icon.closest(".input-wrapper").querySelector("input, select, textarea");
            if (input) {
                input.focus(); // auto fokus ke input
            }
        });
    });
});
