<div id="modalCurso" class="fixed inset-0 bg-black/50 hidden flex items-center justify-center z-[9999]"
    onclick="handleBackdropClick(event, 'modalCurso')">
    <div class="modal-content">
        <div class="flex justify-between items-center mb-6">

            <h2 id="modalTitle" class="text-xl font-bold text-gray-800">Crear Nuevo Curso</h2>
            <button onclick="toggleModal('modalCurso')">×</button>
        </div>

        <form id="formCurso">
            @csrf

            <input type="hidden" name="curso_id" id="curso_id">
            <input type="hidden" name="_method" id="formMethod" value="POST">

            <div class="form-group">
                <label>Nombre del Curso</label>
                <input type="text" name="nombre" id="inputNombre" class="form-control"
                    placeholder="Ej: Programación Web" required>
            </div>

            <div class="form-group">
                <label>Asignar Profesor</label>
                <select name="profesor_id" id="selectProfesor" class="form-control">
                    <option value="">-- Seleccionar Profesor --</option>
                    @foreach ($profesores as $profe)
                        <option value="{{ $profe->id }}">{{ $profe->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <button type="button" onclick="toggleModal('modalCurso')" class="text-gray-500 font-semibold">
                    Cancelar
                </button>
                <button type="submit" id="btnGuardar"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-bold shadow-md transition">
                    Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>
