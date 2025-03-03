// Configuración global de SweetAlert2
const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
});

// Función para mostrar notificaciones
function showNotification(type, message) {
    Toast.fire({
        icon: type,
        title: message
    });
}

// Configuración global de Select2
$.fn.select2.defaults.set("theme", "bootstrap4");
$.fn.select2.defaults.set("language", "es");

// Inicialización de tooltips y popovers
$(function () {
    $('[data-toggle="tooltip"]').tooltip();
    $('[data-toggle="popover"]').popover();

    // Auto-hide para alertas
    $('.alert').not('.alert-important').delay(5000).fadeOut(350);

    // Confirmación de eliminación
    $('.btn-delete').on('click', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');

        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0F3061',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });

    // Inicialización de Select2 para todos los select con la clase .select2
    $('.select2').select2({
        width: '100%'
    });

    // Formato de fechas con Moment.js
    $('time').each(function() {
        let time = $(this);
        let datetime = time.attr('datetime');
        if (datetime) {
            time.text(moment(datetime).format('DD/MM/YYYY HH:mm'));
        }
    });
});

// Función para formatear números como moneda
function formatCurrency(number) {
    return new Intl.NumberFormat('es-AR', {
        style: 'currency',
        currency: 'ARS'
    }).format(number);
}

// Función para formatear fechas
function formatDate(date) {
    return moment(date).format('DD/MM/YYYY');
}

// Función para formatear hora
function formatTime(time) {
    return moment(time, 'HH:mm:ss').format('HH:mm');
}

// Función para validar formularios
function validateForm(formId) {
    const form = document.getElementById(formId);
    if (!form) return false;

    let isValid = true;
    const requiredFields = form.querySelectorAll('[required]');

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            field.classList.add('is-invalid');
            isValid = false;
        } else {
            field.classList.remove('is-invalid');
        }
    });

    return isValid;
}

// Función para manejar errores de AJAX
function handleAjaxError(xhr, textStatus, errorThrown) {
    console.error('Error AJAX:', errorThrown);

    let errorMessage = 'Ha ocurrido un error. Por favor, intente nuevamente.';

    if (xhr.responseJSON && xhr.responseJSON.message) {
        errorMessage = xhr.responseJSON.message;
    }

    showNotification('error', errorMessage);
}

// Configuración global para peticiones AJAX
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    error: handleAjaxError
});

// Función para actualizar el estado de una cirugía
function updateCirugiaStatus(cirugiaId, newStatus) {
    $.ajax({
        url: `/cirugias/${cirugiaId}/status`,
        type: 'PATCH',
        data: { status: newStatus },
        success: function(response) {
            showNotification('success', 'Estado actualizado correctamente');
            // Actualizar la UI según sea necesario
        }
    });
}

// Función para cargar médicos por institución
function loadMedicosByInstitucion(institucionId, selectElement) {
    if (!institucionId) return;

    $.get(`/api/instituciones/${institucionId}/medicos`, function(data) {
        let select = $(selectElement);
        select.empty();
        select.append('<option value="">Seleccione un médico</option>');

        data.forEach(function(medico) {
            select.append(`<option value="${medico.id}">${medico.nombre}</option>`);
        });
    });
}

// Event listener para cambios en campos de búsqueda
let searchTimeout;
$('.search-input').on('input', function() {
    clearTimeout(searchTimeout);
    const input = $(this);

    searchTimeout = setTimeout(function() {
        const searchTerm = input.val();
        if (searchTerm.length >= 3 || searchTerm.length === 0) {
            // Realizar búsqueda
            $.get(input.data('url'), { search: searchTerm }, function(data) {
                // Actualizar resultados
                $(input.data('target')).html(data);
            });
        }
    }, 300);
});
