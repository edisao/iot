<div class="modal inmodal" id="modal-confirm-delete" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <!-- modal-sm -->
        <div class="modal-content  animated fadeIn">
            <div class="modal-header">
                <h5 class="modal-title">{{ trans('msg.msgTituloEliminarRegistro') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>{{ trans('msg.msgConfirmarEliminarRegistro') }}<br/>
                    <strong><span id="modal-data-delete"></span></strong>
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ trans('labels.cancelar') }}</button>
                <a class="btn btn-danger btn-confirm-delete-ok">{{ trans('labels.eliminar') }}</a>
            </div>
        </div>
    </div>
</div>