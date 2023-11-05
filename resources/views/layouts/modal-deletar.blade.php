<div id="confirm_modal" class="modal fade" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">{{__("Confirm")}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>{{__("Você deseja realmente excluir?")}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{__("Cancel")}}</button>
        <button type="button" class="btn btn-danger" onclick="confirmButton()">{{__("Yes")}}</button>
      </div>
    </div>
  </div>
</div>