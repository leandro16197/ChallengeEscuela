<div id="modalEliminar" onclick="handleBackdropClick(event, 'modalEliminar')">
    <div class="modal-card" onclick="event.stopPropagation()">
        <div class="text-center">
            <div style="color: #ef4444; font-size: 2rem; margin-bottom: 1rem;">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            
            <h3 style="font-size: 1.25rem; color: #1e293b; margin-bottom: 0.5rem;">¿Eliminar usuario?</h3>
            <p style="color: #64748b; font-size: 0.9rem; margin-bottom: 1.5rem;">
                Esta acción no se puede deshacer. El usuario será borrado permanentemente.
            </p>
        </div>

        <form id="formEliminarUsuario" method="POST">
            @csrf
            @method('DELETE')
            <div class="buttons-container">
                <button type="button" class="btn-cancel" onclick="toggleModal('modalEliminar')">
                    Cancelar
                </button>
                <button type="submit" class="btn-delete">
                    Sí, Eliminar
                </button>
            </div>
        </form>
    </div>
</div>