<script>
    $(document).ready(function() {
        const AUTH_USER_ID = {{ auth()->id() }};

        $('#tablaUsuariosRoles').DataTable({
            ajax: {
                url: "{{ route('admin.usuarios.index') }}",
                dataSrc: "aaData"
            },
            columns: [{
                    data: 'name'
                },
                {
                    data: 'role_relation',
                    render: function(data) {
                        let nombre = data ? data.display_name : 'Sin Rol';
                        let color = data ? 'indigo' : 'gray';
                        return `<span class="px-2 py-1 rounded-full bg-${color}-50 text-${color}-600 text-[10px] font-bold uppercase border border-${color}-100">${nombre}</span>`;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data) {
                        const dataString = JSON.stringify(data).replace(/"/g, '&quot;');
                        const botonEliminar = (data.id !== AUTH_USER_ID) ?
                            `<button onclick="eliminarUsuario(${data.id})" 
                                class="btn-chip btn-chip-red" title="Eliminar">
                                Eliminar
                            </button>`
                        :
                            `<span class="text-gray-400 text-xs italic"></span>`;

                        return `
                            <div class="flex justify-center gap-2">
                                <button onclick="editarUsuario(${dataString})" 
                                    class="btn-chip btn-chip-blue" title="Editar">
                                    Editar
                                </button>
                                ${botonEliminar}
                            </div>
                        `;
                    }
                }
            ],
            language: {
                url: "/datatables/es-ES.json",
            },
            dom: '<"flex justify-between mb-2"f>rt<"flex justify-between mt-2"p>',
        });

        $('#tablaRolesSimple').DataTable({
            ajax: {
                url: "{{ route('admin.roles.data') }}",
                dataSrc: 'aaData'
            },
            columns: [{
                    data: 'display_name',
                    render: function(data, type, row) {
                        return `
                            <div>
                                <div class="font-bold text-gray-800">${data}</div>
                                <div class="text-[10px] text-gray-400 font-mono">${row.name}</div>
                            </div>
                        `;
                    }
                },
                {
                    data: null,
                    orderable: false,
                    className: 'text-center',
                    render: function(data) {
                        return `
                            <div class="flex justify-center gap-2">
                                <button onclick="editarRol(${data.id})"
                                    class="btn-chip btn-chip-blue">
                                    Editar
                                </button>
                                <button onclick="eliminarRol(${data.id})"
                                    class="btn-chip btn-chip-red">
                                    Eliminar
                                </button>
                            </div>
                        `;
                    }
                }
            ],
            language: {
                url: "/datatables/es-ES.json",
            },
            dom: 'rt<"mt-2"p>',
        });
    });


    function abrirModalCrearUsuario() {
        const modal = document.getElementById('modalUsuario');

        modal.style.setProperty('display', 'flex', 'important');

        cargarRolesEnSelect();
        document.body.style.overflow = 'hidden';
    }

    function toggleModal(id) {
        const modal = document.getElementById(id);
        if (!modal) return;

        if (modal.style.display === 'none' || modal.style.display === '') {
            modal.style.setProperty('display', 'flex', 'important');
            document.body.style.overflow = 'hidden';
        } else {
            modal.style.setProperty('display', 'none', 'important');
            document.body.style.overflow = 'auto';
        }
    }

    function cerrarModalUsuario() {
        const modal = document.getElementById('modalUsuario');

        modal.style.setProperty('display', 'none', 'important');

        document.body.style.overflow = 'auto';
        document.getElementById('formUsuario').reset();
    }

    async function cargarRolesEnSelect() {
        const select = document.getElementById('selectRoles');
        if (!select) return;

        select.innerHTML = '<option value="">Cargando roles...</option>';

        try {
            const respuesta = await fetch('/admin/roles/data');
            const resultado = await respuesta.json();
            const roles = resultado.aaData;

            select.innerHTML = '<option value="">Seleccionar rol...</option>';
            roles.forEach(rol => {
                const option = document.createElement('option');
                option.value = rol.id;
                option.textContent = rol.display_name || rol.name;
                select.appendChild(option);
            });
        } catch (error) {
            console.error("Error cargando roles:", error);
            select.innerHTML = '<option value="">Error al cargar roles</option>';
        }
    }
    function eliminarRol(id) {
        const form = document.getElementById('formEliminarRol');
        form.action = `/admin/roles/${id}`;

        toggleModal('modalEliminarRol');
    }

    $(document).on('submit', '#formEliminarRol', function(e) {
        e.preventDefault();

        const form = $(this);
        const url = form.attr('action');
        const btn = form.find('button[type="submit"]');
        const originalText = btn.text();

        btn.prop('disabled', true).text('Eliminando...');

        $.ajax({
            url: url,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                toggleModal('modalEliminarRol');

                $('#tablaRolesSimple').DataTable().ajax.reload(null, false);

                appCustom.smallBox('ok', 'Rol eliminado correctamente', null, 3000);
            },
            error: function() {
                toggleModal('modalEliminarRol');
                appCustom.smallBox('error', 'No se pudo eliminar el rol', null, 3000);
            },
            complete: function() {
                btn.prop('disabled', false).text(originalText);
            }
        });
    });

    function abrirModalCrearRol() {
        const form = document.getElementById('formRol');
        form.reset();
        document.getElementById('rol_id').value = '';
        document.getElementById('rolMethod').value = 'POST';
        document.getElementById('modalRolTitle').innerText = 'Nuevo Rol';
        toggleModal('modalRoles');
    }

    function editarRol(id) {
        fetch(`/admin/roles/${id}/edit`)
            .then(res => res.json())
            .then(rol => {
                document.getElementById('rol_id').value = rol.id;
                document.querySelector('input[name="name"]').value = rol.name;
                document.querySelector('input[name="display_name"]').value = rol.display_name || '';
                document.getElementById('rolMethod').value = 'PUT';
                document.getElementById('modalRolTitle').innerText = 'Editar Rol';
                toggleModal('modalRoles');
            })
            .catch(() => {
                appCustom.smallBox('nok', 'Error al obtener el rol', null, 'NO_TIME_OUT');
            });
    }
    function cerrarModalRol() {
        const modal = document.getElementById('modalRoles');
        modal.style.setProperty('display', 'none', 'important');
        document.body.style.overflow = 'auto';
        const form = document.getElementById('formRol');
        if (form) form.reset();
        document.getElementById('rol_id').value = '';
        document.getElementById('rolMethod').value = 'POST';
        const title = document.getElementById('modalRolTitle');
        if (title) title.innerText = 'Crear Rol';
    }

    document.getElementById('formRol').addEventListener('submit', async function(e) {
        e.preventDefault();
        const btn = this.querySelector('button[type="submit"]');
        const rolId = document.getElementById('rol_id').value;
        const method = document.getElementById('rolMethod').value;
        const url = (method === 'PUT') ?
            `/admin/roles/${rolId}` :
            `/admin/roles`;
        const formData = new FormData(this);
        if (method === 'PUT') {
            formData.append('_method', 'PUT');
        }
        if (btn) {
            btn.disabled = true;
            btn.innerText = 'Guardando...';
        }
        try {
            const response = await fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            });
            const data = await response.json();
            if (data.success) {
                toggleModal('modalRoles');
                if ($.fn.DataTable.isDataTable('#tablaRoles')) {
                    $('#tablaRoles').DataTable().ajax.reload(null, false);
                }
                appCustom.smallBox('ok', data.msg || 'Guardado correctamente', null, 3000);
            } else {
                appCustom.smallBox('nok', data.msg || 'Error al guardar', null, 'NO_TIME_OUT');
            }
        } catch (error) {
            appCustom.smallBox('nok', 'Error de conexión', null, 'NO_TIME_OUT');
        } finally {
            if (btn) {
                btn.disabled = false;
                btn.innerText = 'Guardar Rol';
            }
        }
    });

    function abrirModalAsignar(userId, userName, currentRoleId) {
        $('#userIdAsignar').val(userId);
        $('#userNameDisplay').text(userName);
        $('#selectRoleAsignar').val(currentRoleId);
        toggleModal('modalAsignarRol');
    }

    $('#formUsuario').on('submit', function(e) {
        e.preventDefault();
        const userId = $('#usuario_id').val();
        const url = userId ?
            `/admin/usuarios/${userId}` :
            "{{ route('admin.usuarios.store') }}";

        const btnGuardar = $(this).find('button[type="submit"]');
        const originalText = btnGuardar.text();

        btnGuardar.prop('disabled', true).text('Guardando...');

        $.ajax({
            url: url,
            method: 'POST',
            data: $(this).serialize(),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                cerrarModalUsuario();
                $('#tablaUsuariosRoles').DataTable().ajax.reload(null, false);

                const msg = userId ? 'Usuario actualizado correctamente' :
                    'Usuario creado correctamente';
                appCustom.smallBox('ok', msg, null, 3000);
            },
            error: function(xhr) {
                let errores = xhr.responseJSON?.errors;
                if (errores) {
                    let mensaje = "";
                    Object.values(errores).forEach(err => mensaje += `${err}<br>`);
                    appCustom.smallBox('error', mensaje, null, 4000);
                } else {
                    cerrarModalUsuario();
                    appCustom.smallBox('error', 'Ocurrió un error al procesar la solicitud.', null,
                        3000);
                }
            },
            complete: function() {
                btnGuardar.prop('disabled', false).text(originalText);
            }
        });
    });


    function eliminarUsuario(id) {
        const form = document.getElementById('formEliminarUsuario');
        form.action = `/admin/usuarios/${id}`;
        toggleModal('modalEliminar');
    }

    $(document).on('submit', '#formEliminarUsuario', function(e) {
        e.preventDefault();

        const form = $(this);
        const url = form.attr('action');
        const btn = form.find('button[type="submit"]');
        const originalText = btn.text();

        btn.prop('disabled', true).text('Eliminando...');

        $.ajax({
            url: url,
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                toggleModal('modalEliminar');
                $('#tablaUsuariosRoles').DataTable().ajax.reload(null, false);
                appCustom.smallBox('ok', 'Usuario eliminado correctamente', null, 3000);
            },
            error: function(xhr) {
                toggleModal('modalEliminar');
                appCustom.smallBox('error', 'No se pudo eliminar el usuario', null, 3000);
            },
            complete: function() {
                btn.prop('disabled', false).text(originalText);
            }
        });
    });

    function editarUsuario(data) {
        const modal = document.getElementById('modalUsuario');
        $('#modalUsuarioTitle').text('Editar Usuario');
        $('#usuario_id').val(data.id);
        $('#usuarioMethod').val('PUT');
        $('input[name="name"]').val(data.name);
        $('input[name="email"]').val(data.email);
        $('input[name="password"]').val('');
        $('input[name="password"]').removeAttr('required');
        cargarRolesEnSelect().then(() => {
            $('#selectRoles').val(data.role);
        });

        modal.style.setProperty('display', 'flex', 'important');
        document.body.style.overflow = 'hidden';
    }

    function handleBackdropClick(e, id) {
        const modal = document.getElementById(id);

        if (e.target === modal) {
            toggleModal(id);
        }
    }
</script>
