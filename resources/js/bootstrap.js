import axios from 'axios';
import $ from 'jquery';
import 'bootstrap';
import 'admin-lte/dist/js/adminlte';
import 'datatables.net';
import 'datatables.net-bs5';
import 'summernote/dist/summernote-bs5';
import Inputmask from 'inputmask';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.$ = $;
window.jQuery = $;
window.Inputmask = Inputmask;

if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js').catch(() => {});
    });
}
