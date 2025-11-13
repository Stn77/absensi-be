import '../sass/app.scss';
import './bootstrap';

// Import Bootstrap JavaScript
import * as bootstrap from 'bootstrap';

// Contoh: Inisialisasi semua tooltips
document.addEventListener('DOMContentLoaded', function () {
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
});
