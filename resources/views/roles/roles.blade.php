<x-app-layout>
    <style>
        .grid-container {
            display: flex;
            flex-direction: column;
  
            gap: 1.5rem;
            width: 100%;
        }

        @media (min-width: 1024px) {
            .grid-container {
                flex-direction: row;

                align-items: flex-start;
            }

            .divTablaUsuarios {
                flex: 0 0 60%;

                min-width: 0;

            }

            .divTablaRoles {
                flex: 0 0 38%;

                min-width: 0;

            }
        }


        .dataTables_wrapper {
            width: 100% !important;
            margin: 0 !important;
        }

        table.dataTable {
            width: 100% !important;
        }


        .dataTables_wrapper {
            width: 100% !important;
        }

        table {
            width: 100% !important;
        }

        .dataTables_scrollBody {
            border-radius: 0 0 1rem 1rem;
        }
    </style>

    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Seguridad y Accesos</h1>
    </div>

    <div class="flex flex-col lg:flex-row gap-6 items-start w-full">

        <div class="divTablaUsuarios flex-1 bg-white shadow-sm rounded-2xl border border-gray-100 p-6 min-w-0">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Usuarios</h2>
                <button onclick="abrirModalCrearUsuario()"
                    class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-lg text-xs font-bold hover:bg-indigo-100 transition-colors">
                    + Nuevo
                </button>
            </div>

            <div class="overflow-x-auto">
                <table id="tablaUsuariosRoles" class="w-full text-sm text-gray-700">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Usuario</th>
                            <th class="px-4 py-3 text-center font-semibold">Rol Actual</th>
                            <th class="px-4 py-3 text-center font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100"></tbody>
                </table>
            </div>
        </div>

        <div class="divTablaRoles lg:w-1/3 bg-white shadow-sm rounded-2xl border border-gray-100 p-6 min-w-0">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-bold text-gray-800">Roles</h2>
                <button onclick="abrirModalCrearRol()"
                    class="bg-indigo-50 text-indigo-600 px-3 py-1 rounded-lg text-xs font-bold hover:bg-indigo-100 transition-colors">
                    + Nuevo
                </button>
            </div>
            <div class="overflow-x-auto">
                <table id="tablaRolesSimple" class="w-full text-sm text-gray-700">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">Rol</th>
                            <th class="px-4 py-3 text-center font-semibold">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100"></tbody>
                </table>
            </div>
        </div>
    </div>
    @include('roles.nuevo-usuario')
    @include('roles.eliminar-usuario')
    @include('roles.roles-add')
    @include('roles.eliminar-rol')


    @push('scripts')
        @include('roles.scripts')
    @endpush
</x-app-layout>
