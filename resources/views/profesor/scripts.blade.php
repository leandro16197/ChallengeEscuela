<script>
    let tablaAlumnos = $('#tablaAlumnos').DataTable({
        ajax: {
            url: "{{ route('teacher.alumnos') }}",
            data: function(d) {
                d.curso_id = $('#filtroCurso').val();
            },
            dataSrc: "aaData"
        },
        columns: [{
                data: 'name',
                title: 'Alumno'
            },
            {
                data: 'nota',
                className: 'text-center',
                render: function(data) {
                    if (data === null || data === undefined) {
                        return '<span class="text-gray-400">-</span>';
                    }

                    let color = data >= 7 ? 'text-green-600' : 'text-red-500';

                    return `<span class="${color} font-bold">${data}</span>`;
                }
            },
            {
                data: null,
                className: 'text-center',
                orderable: false,
                render: function(row) {
                    return `
                    <button onclick="abrirModalNotas(${row.id}, ${row.curso_id}, ${row.nota ?? ''})"
                        class="px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg text-xs font-bold hover:bg-indigo-100">
                        Editar
                    </button>
                `;
                }
            }
        ],
        dom: '<"flex justify-between mb-2"f>rt<"flex justify-between mt-2"p>',
        language: {
            url: "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
        }
    });

    $('#filtroCurso').on('change', function() {
        tablaAlumnos.ajax.reload();
    });

    function abrirModalNotas(userId, cursoId, nota) {
        document.getElementById('nota_user_id').value = userId;
        document.getElementById('nota_curso_id').value = cursoId;
        document.getElementById('nota_value').value = nota ?? '';

        document.getElementById('modalAddNotas').style.display = 'flex';
    }

    function cerrarModalNotas() {
        document.getElementById('modalAddNotas').style.display = 'none';
    }

    document.getElementById('formNota').addEventListener('submit', function(e) {
        e.preventDefault();

        const userId = document.getElementById('nota_user_id').value;
        const cursoId = document.getElementById('nota_curso_id').value;
        const nota = document.getElementById('nota_value').value;

        fetch("{{ route('teacher.alumnos.nota') }}", {
                method: "POST",
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    user_id: userId,
                    curso_id: cursoId,
                    nota: nota
                })
            })
            .then(res => res.json())
            .then(() => {
                cerrarModalNotas();
                tablaAlumnos.ajax.reload(null, false);
            });
    });

    function handleBackdropClick(e, id) {
        const modal = document.getElementById(id);
        if (e.target === modal) {
            toggleModal(id);
        }
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
</script>
