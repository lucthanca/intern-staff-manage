<!-- Bảng thông báo lỗi -->
@error('errorMsg')
<div class="col-md-4">
    <div class="modal fade show animated tada" id="modal-notification" tabindex="-1" role="dialog" aria-labelledby="modal-notification" style="display: block; padding-right: 17px;">
        <div class="modal-dialog modal-danger modal-dialog-centered modal-" role="document">
            <div class="modal-content bg-gradient-danger">

                <div class="modal-header">
                    <h6 class="modal-title" id="modal-title-notification">Cảnh báo !</h6>
                    <button type="button" class="close _close-modal" aria-label="Đóng">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="modal-body">

                    <div class="py-3 text-center">
                        <i class="ni ni-bell-55 ni-3x"></i>
                        <h4 class="heading mt-4">{{ $message }}</h4>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-link text-white ml-auto _close-modal">Ò</button>
                </div>

            </div>
        </div>
    </div>
</div>
@enderror