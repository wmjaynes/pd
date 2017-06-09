<div class="modal fade" id="delete-modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteModalLabel">Delete Event</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>Delete the event: <span id="deletename"></span> ? This action can not be undone.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                {{ Form::open(['url' => 'XXXX', 'method' => 'delete', 'class' => 'destroy-form']) }}
                <button type="submit" class="btn btn-danger">Delete</button>
                {{ Form::close() }}
            </div>
        </div>
    </div>
</div>
<script>
    $('#delete-modal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget) // Button that triggered the modal
        var deleteid = button.data('deleteid') // Extract info from data-* attributes
        var deletename = button.data('deletename')
        var deletetitle = button.data('deleteModalLabel')
        var route = button.data('route')
        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
        var modal = $(this)
        modal.find("#deletename").html(deletename);
        modal.find("#deleteModalLabel").text(deletetitle)
        var dform = modal.find('.destroy-form')
        dform.attr('action', route);
    });
</script>
