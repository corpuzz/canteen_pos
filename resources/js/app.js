import './bootstrap';
import Alpine from 'alpinejs';
import persist from '@alpinejs/persist'

// Only initialize Alpine if it hasn't been initialized already
if (!window.Alpine) {
    window.Alpine = Alpine;
    Alpine.plugin(persist);
    
    // Defer Alpine start to prevent multiple initializations
    document.addEventListener('DOMContentLoaded', () => {
        Alpine.start();
    });
}
