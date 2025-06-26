import './bootstrap';
import 'bootstrap/dist/js/bootstrap.bundle.min.js';
import '@fortawesome/fontawesome-free/js/all.min.js';
import $ from 'jquery';
import Chart from 'chart.js/auto';

import Alpine from 'alpinejs';

window.Alpine = Alpine;
window.$ = $;
window.Chart = Chart;

Alpine.start();
