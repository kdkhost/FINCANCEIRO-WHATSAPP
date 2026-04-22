import axios from 'axios';
import $ from 'jquery';
import 'bootstrap';
import 'admin-lte/dist/js/adminlte';
import 'datatables.net';
import 'datatables.net-bs5';
import 'summernote/dist/summernote-bs5';
import 'summernote/dist/lang/summernote-pt-BR.min.js';
import Inputmask from 'inputmask';
import Toastify from 'toastify-js';
import Swal from 'sweetalert2';

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.$ = $;
window.jQuery = $;
window.Inputmask = Inputmask;
window.Toastify = Toastify;
window.Swal = Swal;

document.addEventListener('DOMContentLoaded', () => {
    Inputmask().mask(document.querySelectorAll('[data-mask]'));

    document.querySelectorAll('[data-datatable]').forEach(element => {
        if (!$.fn.DataTable.isDataTable(element)) {
            $(element).DataTable({
                pageLength: 10,
                language: {
                    decimal: ',',
                    thousands: '.',
                    emptyTable: 'Nenhum registro encontrado',
                    info: 'Mostrando de _START_ ate _END_ de _TOTAL_ registros',
                    infoEmpty: 'Mostrando 0 ate 0 de 0 registros',
                    infoFiltered: '(filtrado de _MAX_ registros no total)',
                    lengthMenu: 'Mostrar _MENU_ registros',
                    loadingRecords: 'Carregando...',
                    processing: 'Processando...',
                    search: 'Buscar:',
                    zeroRecords: 'Nenhum resultado encontrado',
                    paginate: {
                        first: 'Primeiro',
                        last: 'Ultimo',
                        next: 'Proximo',
                        previous: 'Anterior',
                    },
                },
            });
        }
    });

    document.querySelectorAll('[data-summernote]').forEach(element => {
        $(element).summernote({
            height: 220,
            lang: 'pt-BR',
            placeholder: 'Digite o conteudo aqui...',
        });
    });

    document.querySelectorAll('[data-run-cron]').forEach(button => {
        button.addEventListener('click', async () => {
            const taskName = button.dataset.task;
            const url = button.dataset.url;
            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

            const confirmation = await Swal.fire({
                title: 'Executar cron manualmente?',
                text: `Deseja rodar a tarefa "${taskName}" agora?`,
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Executar',
                cancelButtonText: 'Cancelar',
            });

            if (!confirmation.isConfirmed) {
                return;
            }

            button.disabled = true;
            button.textContent = 'Executando...';

            try {
                const response = await axios.post(url, {}, {
                    headers: {
                        'X-CSRF-TOKEN': token,
                        Accept: 'application/json',
                    },
                });

                Toastify({
                    text: response.data.message,
                    duration: 4000,
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: '#0f766e',
                }).showToast();

                setTimeout(() => window.location.reload(), 900);
            } catch (error) {
                const message = error.response?.data?.message ?? 'Falha ao executar o cron.';

                Swal.fire({
                    title: 'Erro ao executar',
                    text: message,
                    icon: 'error',
                });
            } finally {
                button.disabled = false;
                button.textContent = 'Executar agora';
            }
        });
    });
});
