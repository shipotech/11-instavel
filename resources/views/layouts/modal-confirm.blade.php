<!--Modal: modalConfirmDelete-->
<div class="modal fade" id="modalConfirmDelete{{$image->id}}" tabindex="-1" role="dialog" aria-labelledby="confirmDelete"
     aria-hidden="true">
    <div class="modal-dialog modal-sm modal-notify modal-danger modal-dialog-centered" role="document">
        <!--Content-->
        <div class="modal-content text-center">
            <!--Header-->
            <div class="modal-header d-flex justify-content-center">
                <p class="heading">Are you sure?</p>
            </div>

            <!--Body-->
            <div class="modal-body">

                <i class="fas fa-times fa-4x animated rotateIn"></i>

            </div>

            <!--Footer-->
            <div class="modal-footer flex-center">
                <a href="{{ route('image.delete', ['id' => $image->id]) }}" class="btn btn-outline-danger">Yes</a>
                <a type="button" class="btn  btn-danger waves-effect" data-dismiss="modal">No</a>
            </div>
        </div>
        <!--/.Content-->
    </div>
</div>
<!--Modal: modalConfirmDelete-->