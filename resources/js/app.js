import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

window.toggleDark = () => {
    document.documentElement.classList.toggle('dark');
    localStorage.setItem('theme', document.documentElement.classList.contains('dark') ? 'dark' : 'light');
};

// On load, apply stored theme
if (localStorage.getItem('theme') === 'dark') {
    document.documentElement.classList.add('dark');
}

