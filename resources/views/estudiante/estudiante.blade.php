<x-app-layout>

    <style>
        .dataTables_wrapper {
            width: 100% !important;
            margin: 0 !important;
        }

        table.dataTable,
        table {
            width: 100% !important;
        }
    </style>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Mis Notas</h1>
    </div>

    <div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">

        <table id="tablaMisNotas" class="w-full text-sm text-gray-700">
            <thead class="bg-gray-50 border-b border-gray-200">
                <tr>
                    <th class="px-4 py-3 text-left font-semibold">Curso</th>
                    <th class="px-4 py-3 text-center font-semibold">Nota</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

    </div>

    @push('scripts')
    @include('estudiante.estudianteScripts')
    @endpush

</x-app-layout>