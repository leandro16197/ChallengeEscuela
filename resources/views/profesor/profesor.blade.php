<x-app-layout>

<style>
    .dataTables_wrapper {
        width: 100% !important;
        margin: 0 !important;
    }

    table.dataTable {
        width: 100% !important;
    }

    table {
        width: 100% !important;
    }
</style>

<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Mis Alumnos</h1>
</div>

<div class="mb-4 bg-white p-4 rounded-xl shadow-sm border border-gray-100">
    <label class="text-sm font-semibold text-gray-700">Filtrar por curso</label>

    <select id="filtroCurso"
        class="mt-2 w-full border-gray-200 rounded-lg text-sm">
        <option value="">Todos los cursos</option>

        @foreach($cursos as $curso)
            <option value="{{ $curso->id }}">{{ $curso->name }}</option>
        @endforeach
    </select>
</div>

<div class="bg-white shadow-sm rounded-2xl border border-gray-100 p-6">

    <table id="tablaAlumnos" class="w-full text-sm text-gray-700">
        <thead class="bg-gray-50 border-b border-gray-200">
            <tr>
                <th class="px-4 py-3 text-left font-semibold">Alumno</th>
                <th class="px-4 py-3 text-center font-semibold">Nota</th>
                <th class="px-4 py-3 text-center font-semibold">Acciones</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>

</div>
@include('profesor.nota-alumno')
@push('scripts')
@include('profesor.scripts')
@endpush

</x-app-layout>