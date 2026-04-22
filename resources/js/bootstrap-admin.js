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

const dataTables = new Map();

function csrfToken() {
    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
}

function showToast(text, backgroundColor = '#0f766e') {
    Toastify({
        text,
        duration: 3500,
        gravity: 'top',
        position: 'right',
        backgroundColor,
    }).showToast();
}

function initializeMasks(scope = document) {
    Inputmask().mask(scope.querySelectorAll('[data-mask]'));
}

function initializeDataTables() {
    document.querySelectorAll('[data-datatable]').forEach(element => {
        if (!$.fn.DataTable.isDataTable(element)) {
            const instance = $(element).DataTable({
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

            dataTables.set(element, instance);
        }
    });
}

function initializeSummernote() {
    document.querySelectorAll('[data-summernote]').forEach(element => {
        if (!$(element).next('.note-editor').length) {
            $(element).summernote({
                height: 220,
                lang: 'pt-BR',
                placeholder: 'Digite o conteudo aqui...',
            });
        }
    });
}

function resetAjaxForm(form) {
    form.reset();
    form.action = form.dataset.createAction || form.getAttribute('action');

    const methodField = form.querySelector('[data-method-field]');
    if (methodField) {
        methodField.value = 'POST';
    }

    form.dataset.formMode = 'create';

    const submitButton = form.querySelector('[data-submit-label]');
    if (submitButton) {
        submitButton.textContent = submitButton.dataset.createLabel || submitButton.textContent;
    }

    filterCustomerSelect(form);
}

function upsertTableRow(tableSelector, recordId, rowHtml) {
    const table = document.querySelector(tableSelector);

    if (!table) {
        return;
    }

    const dataTable = dataTables.get(table);
    const wrapper = document.createElement('tbody');
    wrapper.innerHTML = rowHtml.trim();
    const newRow = wrapper.firstElementChild;
    const existingRow = table.querySelector(`[data-row-id="${recordId}"]`);

    if (dataTable && existingRow) {
        dataTable.row(existingRow).remove().draw(false);
    } else if (existingRow) {
        existingRow.remove();
    }

    if (dataTable) {
        dataTable.row.add(newRow).draw(false);
    } else {
        table.querySelector('tbody')?.prepend(newRow);
    }
}

function removeTableRow(button, recordId) {
    const table = button.closest('table');

    if (!table) {
        return;
    }

    const row = table.querySelector(`[data-row-id="${recordId}"]`);
    const dataTable = dataTables.get(table);

    if (dataTable && row) {
        dataTable.row(row).remove().draw(false);
    } else if (row) {
        row.remove();
    }
}

function populateForm(form, record, url, method) {
    form.dataset.formMode = 'edit';
    form.action = url;

    const methodField = form.querySelector('[data-method-field]');
    if (methodField) {
        methodField.value = method;
    }

    Object.entries(record).forEach(([key, value]) => {
        const field = form.querySelector(`[name="${key}"]`);

        if (!field) {
            return;
        }

        field.value = value ?? '';
    });

    filterCustomerSelect(form);

    const submitButton = form.querySelector('[data-submit-label]');
    if (submitButton) {
        submitButton.textContent = submitButton.dataset.editLabel || 'Atualizar';
    }

    form.scrollIntoView({
        behavior: 'smooth',
        block: 'start',
    });
}

function filterCustomerSelect(form) {
    const tenantSelect = form.querySelector('[data-tenant-select]');
    const customerSelect = form.querySelector('[data-customer-select]');

    if (!tenantSelect || !customerSelect) {
        return;
    }

    const tenantId = tenantSelect.value;
    const currentValue = customerSelect.value;

    Array.from(customerSelect.options).forEach(option => {
        if (!option.value) {
            option.hidden = false;
            return;
        }

        option.hidden = tenantId !== '' && option.dataset.tenantId !== tenantId;
    });

    if (currentValue) {
        const selectedOption = customerSelect.querySelector(`option[value="${currentValue}"]`);

        if (selectedOption?.hidden) {
            customerSelect.value = '';
        }
    }
}

async function fetchViaCep(input) {
    const cep = input.value.replace(/\D/g, '');

    if (cep.length !== 8) {
        return;
    }

    try {
        const response = await fetch(`https://viacep.com.br/ws/${cep}/json/`);
        const data = await response.json();
        const form = input.closest('form');

        if (data.erro || !form) {
            return;
        }

        const fill = (name, value) => {
            const field = form.querySelector(`[name="${name}"]`);
            if (field && !field.value) {
                field.value = value || '';
            }
        };

        fill('address_line', data.logradouro);
        fill('district', data.bairro);
        fill('city', data.localidade);
        fill('state', data.uf);
    } catch {
        showToast('Nao foi possivel consultar o CEP agora.', '#b45309');
    }
}

function bindAjaxForms() {
    document.querySelectorAll('[data-ajax-form]').forEach(form => {
        if (!form.dataset.createAction) {
            form.dataset.createAction = form.getAttribute('action');
        }

        const submitButton = form.querySelector('[data-submit-label]');
        if (submitButton) {
            submitButton.dataset.createLabel = submitButton.textContent;
            submitButton.dataset.editLabel = 'Atualizar';
        }

        form.addEventListener('submit', async event => {
            event.preventDefault();

            const formData = new FormData(form);
            const submit = form.querySelector('[type="submit"]');

            if (submit) {
                submit.disabled = true;
            }

            try {
                const response = await axios.post(form.action, formData, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken(),
                        Accept: 'application/json',
                    },
                });

                if (response.data.row_html && response.data.record_id && form.dataset.tableSelector) {
                    upsertTableRow(form.dataset.tableSelector, response.data.record_id, response.data.row_html);
                }

                showToast(response.data.message);

                if (form.dataset.successReset === 'true') {
                    resetAjaxForm(form);
                }
            } catch (error) {
                const message = error.response?.data?.message ?? 'Falha ao salvar os dados.';
                const errors = error.response?.data?.errors;

                if (errors) {
                    const firstError = Object.values(errors).flat()[0];
                    showToast(firstError, '#b91c1c');
                } else {
                    showToast(message, '#b91c1c');
                }
            } finally {
                if (submit) {
                    submit.disabled = false;
                }
            }
        });
    });
}

function bindResetButtons() {
    document.querySelectorAll('[data-reset-form]').forEach(button => {
        button.addEventListener('click', () => {
            const form = button.closest('form');

            if (form) {
                resetAjaxForm(form);
            }
        });
    });
}

function bindEditButtons() {
    document.addEventListener('click', event => {
        const button = event.target.closest('[data-edit-record]');

        if (!button) {
            return;
        }

        const form = document.querySelector(button.dataset.formSelector);

        if (!form) {
            return;
        }

        populateForm(form, JSON.parse(button.dataset.record), button.dataset.url, button.dataset.method);
    });
}

function bindDeleteButtons() {
    document.addEventListener('click', async event => {
        const button = event.target.closest('[data-ajax-delete]');

        if (!button) {
            return;
        }

        const confirmation = await Swal.fire({
            title: 'Excluir registro?',
            text: `Deseja remover "${button.dataset.label}"?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Excluir',
            cancelButtonText: 'Cancelar',
        });

        if (!confirmation.isConfirmed) {
            return;
        }

        try {
            const response = await axios.post(button.dataset.url, {
                _method: 'DELETE',
            }, {
                headers: {
                    'X-CSRF-TOKEN': csrfToken(),
                    Accept: 'application/json',
                },
            });

            removeTableRow(button, response.data.record_id);
            showToast(response.data.message);
        } catch (error) {
            const message = error.response?.data?.message ?? 'Falha ao excluir o registro.';
            showToast(message, '#b91c1c');
        }
    });
}

function bindCronButtons() {
    document.querySelectorAll('[data-run-cron]').forEach(button => {
        button.addEventListener('click', async () => {
            const confirmation = await Swal.fire({
                title: 'Executar cron manualmente?',
                text: `Deseja rodar a tarefa "${button.dataset.task}" agora?`,
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
                const response = await axios.post(button.dataset.url, {}, {
                    headers: {
                        'X-CSRF-TOKEN': csrfToken(),
                        Accept: 'application/json',
                    },
                });

                showToast(response.data.message);
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
}

function bindTenantCustomerFilters() {
    document.querySelectorAll('form').forEach(form => {
        const tenantSelect = form.querySelector('[data-tenant-select]');

        if (!tenantSelect) {
            return;
        }

        filterCustomerSelect(form);

        tenantSelect.addEventListener('change', () => filterCustomerSelect(form));
    });
}

function bindViaCep() {
    document.querySelectorAll('[data-via-cep]').forEach(input => {
        input.addEventListener('blur', () => fetchViaCep(input));
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initializeMasks();
    initializeDataTables();
    initializeSummernote();
    bindAjaxForms();
    bindResetButtons();
    bindEditButtons();
    bindDeleteButtons();
    bindCronButtons();
    bindTenantCustomerFilters();
    bindViaCep();
});
