<script>
    var resourceTable;
    const resourceTableId = 'tablaCursosPrincipal';

    function initDataTable() {
        if (typeof $ === 'undefined' || !$.fn.DataTable) return;

        resourceTable = $('#' + resourceTableId).DataTable({
            "autoWidth": false,
            "bAutoWidth": false,
            "scrollX": true,
            "fixedHeader": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "{{ route('admin.cursos.data') }}",
            "language": {
                url: "/datatables/es-ES.json",
                "search": "_INPUT_",
                "searchPlaceholder": "Buscar curso..."
            },
            "dom": '<"flex justify-between items-center mb-4"l f>rt<"flex justify-between items-center mt-4"i p>',
            "order": [
                [0, 'asc']
            ],
            "aoColumnDefs": [{
                    "mData": "name",
                    "aTargets": [0],
                    "mRender": function(value, type, full) {
                        return '<span class="text-gray-700 font-medium">' + (full.name || value) +
                            '</span>';
                    }
                },
                {
                    "mData": "profesor",
                    "aTargets": [1],
                    "sClass": "text-center px-4 py-3",
                    "mRender": function(value, type, full) {
                        const profNombre = (full.profesor && full.profesor.name) ? full.profesor.name :
                            'Sin asignar';
                        const badgeClass = (full.profesor) ? 'bg-indigo-100 text-indigo-700' :
                            'bg-gray-100 text-gray-500';
                        return '<span class="inline-block px-3 py-1 ' + badgeClass +
                            ' rounded-full text-xs font-bold uppercase">' + profNombre + '</span>';
                    }
                },
                {
                    "mData": null,
                    "aTargets": [2],
                    "sortable": false,
                    "sClass": "text-center px-4 py-3",
                    "mRender": function(value, type, full) {
                        const nombreEscapado = String(full.name || '').replace(/'/g, "\\'");
                        const profId = full.teacher_id || 'null';
                        const alumnosIds = full.alumnos ?
                            encodeURIComponent(JSON.stringify(full.alumnos.map(a => a.id))) :
                            encodeURIComponent('[]');

                        return `
                            <div class="flex justify-center items-center gap-2">
                                <button onclick="abrirModalEditar(${full.id}, '${nombreEscapado}', ${profId})"
                                    class="btn-action-pill action-edit">
                                    <i class="fas fa-edit mr-1"></i> Editar
                                </button>

                                <button onclick="abrirModalAlumnos(${full.id}, '${nombreEscapado}', '${alumnosIds}')"
                                    class="btn-action-pill action-students">
                                    <i class="fas fa-users mr-1"></i> Alumnos
                                </button>

                                <button onclick="confirmarEliminacion('/admin/cursos/${full.id}')"
                                    class="btn-action-pill action-delete">
                                    <i class="fas fa-trash mr-1"></i> Eliminar
                                </button>
                            </div>`;
                    }
                }
            ],
            "fnCreatedRow": function(row, data) {
                $(row).attr('id', 'curso-' + data.id);
                $(row).addClass('hover:bg-gray-50 transition-colors');
            },
            "initComplete": function(settings, json) {
                this.api().columns.adjust();
            }
        });
    }

    function initEventListeners() {

        const inputBuscar = document.getElementById('buscarAlumno');
        if (inputBuscar) {
            inputBuscar.addEventListener('input', function() {
                const filtro = this.value.toLowerCase();
                const alumnos = document.querySelectorAll('#listaAlumnos label');
                alumnos.forEach(label => {
                    const nombre = label.innerText.toLowerCase();
                    label.style.display = nombre.includes(filtro) ? 'flex' : 'none';
                });
            });
        }


        const formCurso = document.getElementById('formCurso');
        if (formCurso) {
            formCurso.addEventListener('submit', async function(e) {
                e.preventDefault();
                const btn = document.getElementById('btnGuardar');
                const cursoId = document.getElementById('curso_id').value;
                const isEdit = cursoId !== '';

                btn.disabled = true;
                btn.innerText = 'Procesando...';

                const url = isEdit ? `/admin/cursos/${cursoId}` : "{{ route('admin.cursos.store') }}";
                const formData = new FormData(this);

                try {
                    const response = await fetch(url, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    });
                    const data = await response.json();
                    if (data.success) {
                        toggleModal('modalCurso');
                        resourceTable.ajax.reload(null, false);
                        appCustom.smallBox('ok', data.msg || 'Curso guardado correctamente', null, 3000);
                    } else {
                        appCustom.smallBox('nok', data.msg || 'Error al validar datos', null,
                            'NO_TIME_OUT');
                    }
                } catch (error) {
                    appCustom.smallBox('nok', 'Error de conexión con el servidor', null, 'NO_TIME_OUT');
                } finally {
                    btn.disabled = false;
                    btn.innerText = 'Guardar Cambios';
                }
            });
        }


        const formEliminar = document.getElementById('formEliminarCurso');
        if (formEliminar) {
            formEliminar.addEventListener('submit', async function(e) {
                e.preventDefault();
                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    });
                    const data = await response.json();
                    if (data.success) {
                        toggleModal('modalEliminar');
                        resourceTable.ajax.reload(null, false);
                        appCustom.smallBox('ok', 'Curso eliminado con éxito', null, 3000);
                    } else {
                        appCustom.smallBox('nok', data.msg || 'No se pudo eliminar', null, 'NO_TIME_OUT');
                    }
                } catch (e) {
                    appCustom.smallBox('nok', 'Error al procesar la eliminación', null, 'NO_TIME_OUT');
                }
            });
        }

        const formAsignarAlumnos = document.getElementById('formAsignarAlumnos');
        if (formAsignarAlumnos) {
            formAsignarAlumnos.addEventListener('submit', async function(e) {
                e.preventDefault();
                const btn = this.querySelector('button[type="submit"]');
                const cursoId = document.getElementById('curso_id_alumnos').value;

                if (btn) {
                    btn.disabled = true;
                    btn.innerText = 'Guardando...';
                }

                try {
                    const response = await fetch(`/admin/cursos/${cursoId}/alumnos`, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                        }
                    });
                    const data = await response.json();
                    if (data.success) {
                        toggleModal('modalAlumnos');
                        resourceTable.ajax.reload(null, false);
                        appCustom.smallBox('ok', 'Inscripciones actualizadas correctamente', null, 3000);
                    } else {
                        appCustom.smallBox('nok', data.msg || 'Error al asignar', null, 'NO_TIME_OUT');
                    }
                } catch (error) {
                    appCustom.smallBox('nok', 'Error en la petición de alumnos', null, 'NO_TIME_OUT');
                } finally {
                    if (btn) {
                        btn.disabled = false;
                        btn.innerText = 'Guardar Inscripciones';
                    }
                }
            });
        }
    }


    document.addEventListener('DOMContentLoaded', function() {
        initEventListeners();
        const checkJS = setInterval(() => {
            if (typeof $ !== 'undefined' && $.fn.DataTable) {
                clearInterval(checkJS);
                initDataTable();
            }
        }, 100);
    });

    function abrirModalCrear() {
        const form = document.getElementById('formCurso');
        if (form) form.reset();
        document.getElementById('curso_id').value = '';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('modalTitle').innerText = 'Crear Nuevo Curso';
        toggleModal('modalCurso');
    }

    function abrirModalEditar(id, nombre, profesorId) {
        document.getElementById('curso_id').value = id;
        document.getElementById('inputNombre').value = nombre || '';
        document.getElementById('formMethod').value = 'PUT';
        document.getElementById('modalTitle').innerText = 'Editar Curso';
        const selectProfesor = document.getElementById('selectProfesor');
        if (selectProfesor) selectProfesor.value = profesorId || "";
        toggleModal('modalCurso');
    }

    function abrirModalAlumnos(cursoId, nombreCurso, alumnosIds) {

        console.log('CLICK alumnos', cursoId, nombreCurso, alumnosIds);

        try {
            alumnosIds = JSON.parse(decodeURIComponent(alumnosIds));
        } catch {
            alumnosIds = [];
        }

        const inputId = document.getElementById('curso_id_alumnos');
        const title = document.getElementById('modalAlumnosTitle');

        if (inputId) inputId.value = cursoId;
        if (title) title.innerText = 'Alumnos en: ' + nombreCurso;

        const checkboxes = document.querySelectorAll('#formAsignarAlumnos input[type="checkbox"]');

        checkboxes.forEach(cb => {
            cb.checked = alumnosIds.includes(parseInt(cb.value));
        });

        const total = document.querySelectorAll('#formAsignarAlumnos input[name="alumnos[]"]:checked').length;
        const contador = document.getElementById('contadorSeleccionados');

        if (contador) {
            contador.innerText = total + ' alumnos seleccionados';
        }

        toggleModal('modalAlumnos');
    }
    function confirmarEliminacion(url) {
        const form = document.getElementById('formEliminarCurso');
        if (form) {
            form.action = url;
            toggleModal('modalEliminar');
        }
    }
    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (!modal) {
            console.error("ERROR: No existe el elemento con ID:", id);
            return;
        }

        if (modal.classList.contains('hidden')) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            modal.style.display = 'flex';
        } else {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modal.style.display = 'none'; 
        }
    }
    function toggleModalAlumnos() { toggleModal('modalAlumnos'); }
    function toggleModalEliminar() { toggleModal('modalEliminar'); }
    function toggleModalCurso() { toggleModal('modalCurso'); }
    function handleBackdropClick(e, id) {
        const modal = document.getElementById(id);

        if (e.target === modal) {
            toggleModal(id);
        }
    }
</script>
