import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '@fortawesome/fontawesome-free/js/all.min.js';
import $ from 'jquery';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.$ = $;

Alpine.start();
