<div id="modalEliminar" class="fixed inset-0 bg-black/50 hidden justify-center items-center z-50" onclick="handleBackdropClick(event, 'modalEliminar')">
        <div class="modal-content">
            <div class="text-center">
                <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                    <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">¿Eliminar curso?</h2>
                <p class="text-gray-500 mb-6">Esta acción no se puede deshacer. El curso se borrará permanentemente.</p>
                
                <form id="formEliminarCurso" method="POST">
                    @csrf
                    @method('DELETE') 
                    
                    <div class="flex justify-center gap-3">
                        <button type="button" onclick="toggleModal('modalEliminar')" class="text-gray-500">
                            Cancelar
                        </button>
                        <button type="submit" class="bg-red-600 text-white px-6 py-2 rounded-lg font-bold">
                            Sí, Eliminar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>