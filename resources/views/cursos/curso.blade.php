<x-app-layout>
    <style>
        #tablaCursosPrincipal th, 
        #tablaCursosPrincipal td {
            width: auto !important;
            min-width: 0 !important;
        }

        .dataTables_scrollHeadInner, 
        .dataTables_scrollHeadInner table,
        .dataTables_scrollBody table {
            width: 100% !important;
            margin: 0 !important;
        }
        #tablaCursosPrincipal th:nth-child(1) { width: 50% !important; }
        #tablaCursosPrincipal th:nth-child(2) { width: 25% !important; }
        #tablaCursosPrincipal th:nth-child(3) { width: 25% !important; }
    </style>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Gestión de Cursos</h1>
        <button onclick="abrirModalCrear()" class="bg-indigo-600 hover:bg-indigo-700 text-white px-5 py-2 rounded-lg ...">
            + Nuevo Curso
        </button>
    </div>

    <div class="bg-white shadow-sm rounded-2xl overflow-hidden border border-gray-100 p-4">
        <table id="tablaCursosPrincipal" class="w-full text-sm text-gray-700">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                   <th class="px-4 py-3 text-left font-semibold w-2/4">Nombre del Curso</th>
                    <th class="px-4 py-3 text-center font-semibold w-1/4">Profesor Asignado</th>
                    <th class="px-4 py-3 text-center font-semibold w-1/4">Acciones</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100"></tbody>
        </table>
    </div>
    @include('cursos.curso-add-alumnos-materia')
    @include('cursos.curso-add')
    @include('cursos.curso-delete')
    @push('scripts')
    @include('cursos.scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            const inputBuscar = document.getElementById('buscarAlumno');
            if (inputBuscar) {
                inputBuscar.addEventListener('input', function () {
                    const filtro = this.value.toLowerCase();
                    const alumnos = document.querySelectorAll('#listaAlumnos label');

                    alumnos.forEach(label => {
                        const nombre = label.innerText.toLowerCase();
                        label.style.display = nombre.includes(filtro) ? 'flex' : 'none';
                    });
                });
            }

            document.addEventListener('change', function(e) {
                if (e.target && e.target.name === 'alumnos[]') {
                    const total = document.querySelectorAll('input[name="alumnos[]"]:checked').length;
                    const contador = document.getElementById('contadorSeleccionados');
                    if (contador) {
                        contador.innerText = total + ' alumnos seleccionados';
                    }
                }
            });
        });        
    </script>
    @endpush
</x-app-layout>