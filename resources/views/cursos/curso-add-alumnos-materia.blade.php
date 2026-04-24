<div id="modalAlumnos"
     class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-[9999]"
     onclick="handleBackdropClick(event, 'modalAlumnos')">

    <div class="relative bg-white w-full max-w-lg rounded-2xl shadow-xl p-6 z-10">

        <div class="flex justify-between items-center mb-5">
            <h2 id="modalAlumnosTitle" class="text-xl font-bold text-gray-800">
                Asignar Alumnos
            </h2>
            <button type="button" onclick="toggleModal('modalAlumnos')"
                class="text-gray-400 hover:text-gray-600 text-2xl">
                &times;
            </button>
        </div>

        <form id="formAsignarAlumnos">

            @csrf
            <input type="hidden" name="curso_id" id="curso_id_alumnos">
            <div class="mb-4">
                <input type="text" id="buscarAlumno" placeholder="Buscar alumno..."
                    class="w-full border-gray-300 rounded-lg shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div class="mb-4">
                <p class="text-sm text-gray-600 mb-2">
                    Selecciona los alumnos que participarán en este curso:
                </p>

                <div id="listaAlumnos"
                    class="max-h-72 overflow-y-auto border border-gray-200 rounded-lg p-3 bg-gray-50 space-y-1">

                    @foreach ($todosLosAlumnos as $alumno)
                        <label class="flex items-center p-2 rounded-lg cursor-pointer hover:bg-white">

                            <input type="checkbox" name="alumnos[]" value="{{ $alumno->id }}"
                                class="mr-3 rounded border-gray-300 text-indigo-600">

                            <span class="text-gray-700">
                                {{ $alumno->name }}
                            </span>
                        </label>
                    @endforeach

                </div>

                <p id="contadorSeleccionados" class="text-xs text-gray-500 mt-2">
                    0 alumnos seleccionados
                </p>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="toggleModal('modalAlumnos')"
                    class="text-gray-500 font-semibold hover:text-gray-700">
                    Cancelar
                </button>

                <button type="submit" 
                    style="background-color: #16a34a !important; color: #ffffff !important;"
                    class="inline-flex items-center justify-center px-8 py-3 rounded-full font-black text-white uppercase tracking-widest text-xs shadow-lg shadow-green-200 hover:shadow-green-300 transform transition-all duration-300 hover:-translate-y-0.5 active:scale-95 border-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7" />
                    </svg>
                    Guardar Inscripciones
                </button>
            </div>

        </form>
    </div>
</div>
