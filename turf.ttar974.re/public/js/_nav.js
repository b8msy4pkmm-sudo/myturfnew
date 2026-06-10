const dropdownMenu     = document.querySelectorAll('.dropdown');
const dropdownMenuItems = document.querySelectorAll('.dropdown-menu');

for (let i = 0; i < dropdownMenu.length; i++) {
    dropdownMenu[i].addEventListener('click', (e) => {
        e.stopPropagation();
        const isHidden = dropdownMenuItems[i].classList.contains('display-none');

        // Ferme tous les dropdowns
        for (let j = 0; j < dropdownMenuItems.length; j++) {
            dropdownMenuItems[j].classList.add('display-none');
        }

        // Ouvre celui cliqué s'il était fermé
        if (isHidden) {
            dropdownMenuItems[i].classList.remove('display-none');
        }
    });
}

// Ferme tous les dropdowns au clic en dehors
window.addEventListener('click', () => {
    for (let j = 0; j < dropdownMenuItems.length; j++) {
        dropdownMenuItems[j].classList.add('display-none');
    }
});
