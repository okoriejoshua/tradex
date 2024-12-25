<div>
    <div class="modal fade" id="updatedprofile" wire:ignore.self>
        <div class="modal-dialog  modal-dialog-centered">
            <div class="modal-content card-warning card-outline">
                <div class="modal-header">
                    <h4 class="modal-title"> Please Complete Account Verification </h4>
                </div>
                <div class="modal-body text-center ">
                    <i class="fas fa-info-circle mt-2 text-warning" style="font-size:80px"></i>
                    <div class="text-center">
                        Some information on you account are missing please, Complete them to Continue
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <span id="close-modal" data-dismiss="modal" class="radius-8 btn elevation-1 btn-danger">
                        Ok, Later
                    </span>
                    <a class="btn btn-primary" href="{{route('user.profile',['autoshow' => 'basic-kyc'])}}">Do Now</a>
                </div>
            </div>
        </div>
    </div>
</div>