<div id="modalRoles"  onclick="handleBackdropClick(event, 'modalRoles')">
    <div class="modal-card bg-white rounded-2xl shadow-xl w-full max-w-md p-8 relative mx-4" onclick="event.stopPropagation()">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-xl font-bold text-gray-800" id="modalRolTitle">
                Crear Rol
            </h3>
            <button onclick="cerrarModalRol()" class="btn-close">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
        <form id="formRol">
            <div class="space-y-4">
                <input type="hidden" name="rol_id" id="rol_id">
                <input type="hidden" name="_method" id="rolMethod" value="POST">

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre del Rol
                    </label>
                    <input type="text" name="name" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                        placeholder="Ej. Administrador">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Nombre visible
                    </label>
                    <input type="text" name="display_name" required
                        class="w-full px-4 py-2 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all"
                        placeholder="Ej. Administrador">
                </div>
            </div>
            <div class="flex gap-3 mt-8">
                <button type="button" onclick="cerrarModalRol()" 
                    class="flex-1 px-4 py-2 border border-gray-200 text-gray-600 rounded-xl hover:bg-gray-50 font-semibold transition-colors">
                    Cancelar
                </button>
                <button type="submit" 
                    class="flex-1 px-4 py-2 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 font-semibold transition-colors">
                    Guardar Rol
                </button>
            </div>
        </form>
    </div>
</div>