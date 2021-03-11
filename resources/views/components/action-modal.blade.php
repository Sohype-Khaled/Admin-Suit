<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true" id="admin-suit-action-modal">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="admin-suit-action-modal_title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
            </div>
           
            <x-admin.form action="{{ route('admin-suit.call-action') }}" method="post">
                <input type="hidden" name="action_model" id="admin-suit-action-modal_model">
                <input type="hidden" name="action" id="admin-suit-action-modal_action">
                <input type="hidden" name="action_items" id="admin-suit-action-modal_items">
                <input type="hidden" name="all_selected" id="admin-suit-action-modal_all_selected">
                <input type="hidden" name="action_value" id="admin-suit-action-modal_value">
                <div class="modal-body">
                    <p id="admin-suit-action-modal_message"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </x-admin.form>
        </div>
    </div>
</div>