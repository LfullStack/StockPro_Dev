    function toggleDropdown() {
        const dropdown = document.getElementById('dropdownCarrito');
        dropdown.classList.toggle('hidden');
    }

    // Cierra el dropdown si haces clic fuera de él
    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('dropdownCarrito');
        if (!e.target.closest('#dropdownCarrito') && !e.target.closest('button[onclick="toggleDropdown()"]')) {
            dropdown.classList.add('hidden');
        }
    });

